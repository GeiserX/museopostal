#!/usr/bin/env node
/**
 * Capturas de la portada, una sala y una ficha a 1440 y 500 px, para el tema
 * base y para cada variación de theme/museopostal/styles/*.json.
 * Guarda docs/capturas/<variacion>/<pagina>-<ancho>.png.
 *
 * Además de fotografiar, comprueba: cada página responde 200 y tiene un solo H1.
 * Uso (con Playground ya escuchando): node .github/scripts/capturas.mjs [url]
 */
import { chromium } from 'playwright';
import { existsSync, mkdirSync, readdirSync, readFileSync } from 'node:fs';
import { join, resolve } from 'node:path';

const raiz = resolve(new URL('../..', import.meta.url).pathname);
const base = (process.argv[2] || 'http://127.0.0.1:9400').replace(/\/$/, '');
const paginas = {
	portada: '/',
	sala: '/sala/region-de-murcia/',
	ficha: '/pieza/carta-de-aguilas-a-murcia-1866/',
};
const anchos = [1440, 500];

const carpetaEstilos = join(raiz, 'theme/museopostal/styles');
const variaciones = ['base'];
if (existsSync(carpetaEstilos)) {
	for (const f of readdirSync(carpetaEstilos).filter((x) => x.endsWith('.json')).sort()) {
		if (!JSON.parse(readFileSync(join(carpetaEstilos, f), 'utf8')).blockTypes) variaciones.push(f.replace(/\.json$/, ''));
	}
}

const navegador = await chromium.launch();
const fallos = [];
for (const variacion of variaciones) {
	for (const ancho of anchos) {
		const contexto = await navegador.newContext({ viewport: { width: ancho, height: 900 }, deviceScaleFactor: 1, locale: 'es-ES', reducedMotion: 'reduce' });
		await contexto.addCookies([{ name: 'mp_variacion', value: variacion, url: base }]);
		const pagina = await contexto.newPage();
		for (const [nombre, ruta] of Object.entries(paginas)) {
			const respuesta = await pagina.goto(base + ruta, { waitUntil: 'networkidle' });
			const estado = respuesta?.status();
			const h1 = await pagina.locator('h1').count();
			if (estado !== 200) fallos.push(`${variacion} ${nombre} ${ancho}px: HTTP ${estado}`);
			if (h1 !== 1) fallos.push(`${variacion} ${nombre} ${ancho}px: ${h1} H1 (se espera 1)`);
			const carpeta = join(raiz, 'docs/capturas', variacion);
			mkdirSync(carpeta, { recursive: true });
			await pagina.screenshot({ path: join(carpeta, `${nombre}-${ancho}.png`), fullPage: true, animations: 'disabled' });
			console.log(`${variacion}/${nombre}-${ancho}.png  HTTP ${estado}, ${h1} H1`);
		}
		await contexto.close();
	}
}
await navegador.close();

if (fallos.length) {
	for (const f of fallos) console.log(`::error::${f}`);
	process.exit(1);
}
