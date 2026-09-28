#!/usr/bin/env node
/**
 * Valida el tema y la muestra antes de que lleguen a WordPress:
 *
 * 1. theme.json y cada styles/*.json contra el esquema de theme.json de WordPress 7.1;
 * 2. el contraste de cada paleta (la base y cada variación) según WCAG: ≥ 4,5:1;
 * 3. playground/blueprint.json y el blueprint de la vista previa contra el esquema
 *    de Playground, y que cada recurso «bundled» exista en playground/.
 *
 * Uso: node .github/scripts/validar-json.mjs [--tema <carpeta>] [--playground <carpeta>]
 * Sale con 1 si algo falla. Necesita ajv (npm install --no-save ajv@8).
 */
import Ajv from 'ajv';
import { existsSync, readdirSync, readFileSync } from 'node:fs';
import { join, resolve } from 'node:path';
import { execFileSync } from 'node:child_process';

const raiz = resolve(new URL('../..', import.meta.url).pathname);
const opcion = (nombre, defecto) => {
	const i = process.argv.indexOf(nombre);
	return i > -1 ? resolve(process.argv[i + 1]) : defecto;
};
const tema = opcion('--tema', join(raiz, 'theme/museopostal'));
const playground = opcion('--playground', join(raiz, 'playground'));

const ESQUEMA_TEMA = 'https://schemas.wp.org/wp/7.1/theme.json';
const ESQUEMA_BLUEPRINT = 'https://playground.wordpress.net/blueprint-schema.json';
const SLUGS = ['base', 'contrast', 'primary', 'secondary', 'accent', 'mount', 'surface'];
// Texto sobre fondo que el tema usa de verdad (style.css y theme.json).
const PARES = [
	['contrast', 'base'], ['contrast', 'surface'], ['contrast', 'mount'],
	['primary', 'base'], ['primary', 'surface'],
	['secondary', 'base'], ['secondary', 'surface'],
	['accent', 'base'], ['accent', 'surface'],
	['base', 'primary'], ['base', 'accent'], ['base', 'contrast'],
];

let fallos = 0;
const mal = (mensaje) => { fallos++; console.log(`::error::${mensaje}`); };
const bien = (mensaje) => console.log(`OK ${mensaje}`);
const leer = (fichero) => JSON.parse(readFileSync(fichero, 'utf8'));

async function esquema(url) {
	const r = await fetch(url, { redirect: 'follow' });
	if (!r.ok) throw new Error(`No se pudo descargar ${url}: HTTP ${r.status}`);
	const json = await r.json();
	delete json.$schema; // Ajv no conoce el meta-esquema genérico de Playground.
	return json;
}

const ajv = new Ajv({ allErrors: true, strict: false, allowUnionTypes: true });
const validarTema = ajv.compile(await esquema(ESQUEMA_TEMA));
const validarBlueprint = ajv.compile(await esquema(ESQUEMA_BLUEPRINT));

const errores = (validar) => validar.errors.slice(0, 8).map((e) => `${e.instancePath || '/'} ${e.message}${e.params?.additionalProperty ? ` (${e.params.additionalProperty})` : ''}`).join('; ');

// 1. Esquema del tema y de sus variaciones.
const temaJson = join(tema, 'theme.json');
const variaciones = existsSync(join(tema, 'styles'))
	? readdirSync(join(tema, 'styles')).filter((f) => f.endsWith('.json')).map((f) => join(tema, 'styles', f))
	: [];
for (const fichero of [temaJson, ...variaciones]) {
	const datos = leer(fichero);
	if (datos.version !== 3) mal(`${fichero}: la versión de theme.json es ${datos.version}, se espera 3`);
	if (validarTema(datos)) bien(`${fichero} cumple el esquema de WordPress 7.1`);
	else mal(`${fichero} no cumple el esquema de WordPress 7.1: ${errores(validarTema)}`);
}

// 2. Contraste WCAG de cada paleta.
const luminancia = (hex) => {
	const [r, g, b] = [0, 2, 4].map((i) => parseInt(hex.replace('#', '').slice(i, i + 2), 16) / 255)
		.map((v) => (v <= 0.03928 ? v / 12.92 : ((v + 0.055) / 1.055) ** 2.4));
	return 0.2126 * r + 0.7152 * g + 0.0722 * b;
};
const contraste = (a, b) => {
	const [x, y] = [luminancia(a), luminancia(b)].sort((m, n) => n - m);
	return (x + 0.05) / (y + 0.05);
};
if (Math.abs(contraste('#000000', '#FFFFFF') - 21) > 0.01) mal('La fórmula de contraste no da 21:1 para negro sobre blanco');

const paletaBase = Object.fromEntries((leer(temaJson).settings?.color?.palette ?? []).map((c) => [c.slug, c.color]));
const paletas = [['theme.json', paletaBase]];
for (const fichero of variaciones) {
	const datos = leer(fichero);
	if (datos.blockTypes) continue; // estilo de sección, no una variación completa
	const propia = Object.fromEntries((datos.settings?.color?.palette ?? []).map((c) => [c.slug, c.color]));
	paletas.push([fichero.split('/').pop(), { ...paletaBase, ...propia }]);
}
for (const [nombre, paleta] of paletas) {
	for (const slug of SLUGS) {
		if (!/^#[0-9a-f]{6}$/i.test(paleta[slug] ?? '')) mal(`${nombre}: falta el color «${slug}» o no es #RRGGBB`);
	}
	const bajos = PARES.filter(([t, f]) => paleta[t] && paleta[f] && contraste(paleta[t], paleta[f]) < 4.5)
		.map(([t, f]) => `${t} sobre ${f} ${contraste(paleta[t], paleta[f]).toFixed(2)}:1`);
	if (bajos.length) mal(`${nombre}: contraste por debajo de 4,5:1: ${bajos.join(', ')}`);
	else bien(`${nombre}: ${PARES.length} pares de texto y fondo a 4,5:1 o más`);
}

// 3. Blueprints.
const blueprint = join(playground, 'blueprint.json');
const base = leer(blueprint);
if (validarBlueprint(base)) bien(`${blueprint} cumple el esquema de Playground`);
else mal(`${blueprint} no cumple el esquema de Playground: ${errores(validarBlueprint)}`);

const empaquetados = [];
JSON.stringify(base, (clave, valor) => {
	if (valor && valor.resource === 'bundled') empaquetados.push(valor.path);
	return valor;
});
const faltan = empaquetados.filter((p) => !existsSync(join(playground, p)));
if (!empaquetados.length) mal(`${blueprint} no usa ningún recurso empaquetado`);
else if (faltan.length) mal(`${blueprint} pide ficheros que no están en playground/: ${faltan.join(', ')}`);
else bien(`${empaquetados.length} recursos empaquetados presentes en playground/`);

const previa = JSON.parse(execFileSync(process.execPath, [join(playground, 'vista-previa.mjs'), 'GeiserX/museopostal', '0'.repeat(40)], { encoding: 'utf8' }));
if (validarBlueprint(previa)) bien('el blueprint de la vista previa cumple el esquema de Playground');
else mal(`el blueprint de la vista previa no cumple el esquema: ${errores(validarBlueprint)}`);
if (JSON.stringify(previa).includes('"bundled"')) mal('el blueprint de la vista previa aún tiene recursos «bundled»');

if (fallos) {
	console.log(`${fallos} comprobaciones fallidas`);
	process.exit(1);
}
console.log('Todo en orden.');
