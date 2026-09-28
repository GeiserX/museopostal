#!/usr/bin/env node
/**
 * Blueprint de la vista previa de una PR en WordPress Playground.
 *
 * Parte de playground/blueprint.json (el mismo que usa el CLI en las
 * capturas) y le añade dos cosas que solo necesita el navegador:
 *
 * - instala el tema y el plugin desde GitHub, en el commit exacto de la PR;
 * - cambia cada recurso «bundled» (muestra.xml, imágenes, muestra.php) por
 *   su URL en raw.githubusercontent.com de ese mismo commit.
 *
 * Uso: node playground/vista-previa.mjs <propietario/repo> <sha>
 */
import { readFileSync } from 'node:fs';

const [repo, sha] = process.argv.slice(2);
if (!/^[\w.-]+\/[\w.-]+$/.test(repo ?? '') || !/^[0-9a-f]{40}$/.test(sha ?? '')) {
	console.error('Uso: node playground/vista-previa.mjs <propietario/repo> <sha de 40 caracteres>');
	process.exit(2);
}

const base = JSON.parse(readFileSync(new URL('./blueprint.json', import.meta.url), 'utf8'));
const raw = `https://raw.githubusercontent.com/${repo}/${sha}/playground`;

const reescribir = (valor) => {
	if (Array.isArray(valor)) return valor.map(reescribir);
	if (valor && typeof valor === 'object') {
		if (valor.resource === 'bundled') return { resource: 'url', url: raw + valor.path };
		return Object.fromEntries(Object.entries(valor).map(([k, v]) => [k, reescribir(v)]));
	}
	return valor;
};

const desdeGit = (path) => ({ resource: 'git:directory', url: `https://github.com/${repo}`, ref: sha, refType: 'commit', path });

const blueprint = reescribir(base);
blueprint.steps = [
	{ step: 'installTheme', themeData: desdeGit('theme/museopostal'), options: { activate: false, targetFolderName: 'museopostal' } },
	{ step: 'installPlugin', pluginData: desdeGit('plugin/museopostal-coleccion'), options: { activate: false, targetFolderName: 'museopostal-coleccion' } },
	...blueprint.steps,
];

process.stdout.write(JSON.stringify(blueprint));
