#!/usr/bin/env node
/**
 * Capturas de la portada, una sala y una ficha a 1440 y 500 px, para el tema
 * base y para cada variación de theme/museopostal/styles/*.json.
 * Guarda <carpeta>/<variacion>/<pagina>-<ancho>.png (por defecto capturas/).
 *
 * Además de fotografiar, comprueba que cada página responde 200, la pinta el
 * tema museopostal (su cabecera .mp-cabecera), tiene un solo H1, todas sus
 * imágenes cargan, no desborda en horizontal, lleva el logo y el favicon de
 * su variación y, si la variación trae fuentes, que se cargan y se precargan.
 * Uso (con Playground ya escuchando): node .github/scripts/capturas.mjs [url] [carpeta]
 */
import { chromium } from 'playwright';
import { existsSync, mkdirSync, readdirSync, readFileSync } from 'node:fs';
import { join, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const raiz = resolve(fileURLToPath(new URL('../..', import.meta.url)));
const base = (process.argv[2] || 'http://127.0.0.1:9400').replace(/\/$/, '');
const salida = resolve(process.argv[3] || join(raiz, 'capturas'));
const paginas = {
	portada: '/',
	sala: '/sala/region-de-murcia/',
	ficha: '/pieza/carta-de-aguilas-a-murcia-1866/',
};
const anchos = [1440, 500];

const carpetaEstilos = join(raiz, 'theme/museopostal/styles');
const temaBase = JSON.parse(readFileSync(join(raiz, 'theme/museopostal/theme.json'), 'utf8'));
const tieneFuentes = (json) => (json.settings?.typography?.fontFamilies ?? []).some((f) => Array.isArray(f.fontFace) && f.fontFace.length);
// slug => { logo, fuentes }: lo que cada variación debe enseñar.
const variaciones = { base: { logo: temaBase.settings?.custom?.logo ?? '', fuentes: tieneFuentes(temaBase) } };
if (existsSync(carpetaEstilos)) {
	for (const f of readdirSync(carpetaEstilos).filter((x) => x.endsWith('.json')).sort()) {
		const json = JSON.parse(readFileSync(join(carpetaEstilos, f), 'utf8'));
		if (json.blockTypes) continue; // estilo de sección, no una variación completa
		variaciones[f.replace(/\.json$/, '')] = { logo: json.settings?.custom?.logo ?? variaciones.base.logo, fuentes: tieneFuentes(json) || variaciones.base.fuentes };
	}
}

const navegador = await chromium.launch();
const fallos = [];
for (const [variacion, esperado] of Object.entries(variaciones)) {
	for (const ancho of anchos) {
		const contexto = await navegador.newContext({ viewport: { width: ancho, height: 900 }, deviceScaleFactor: 1, locale: 'es-ES', reducedMotion: 'reduce' });
		await contexto.addCookies([{ name: 'mp_variacion', value: variacion, url: base }]);
		const pagina = await contexto.newPage();
		// Cada imagen del sitio tiene que llegar entera: mismo tamaño que su fichero en playground/muestra/.
		pagina.on('response', async (r) => {
			const url = r.url();
			if (/\.woff2(\?|$)/.test(url) && !r.ok()) fallos.push(`${variacion} ${ancho}px: fuente ${url.split('/').pop()} respondió HTTP ${r.status()}`);
			if (!/\/wp-content\/uploads\/muestra\/[^/?]+$/.test(url)) return;
			const nombre = decodeURIComponent(url.split('/').pop());
			const local = join(raiz, 'playground/muestra', nombre);
			const cuerpo = await r.body().catch(() => null);
			const esperado = existsSync(local) ? readFileSync(local).length : -1;
			if (!r.ok() || !cuerpo || cuerpo.length !== esperado) {
				fallos.push(`${variacion} ${ancho}px: ${nombre} llegó con HTTP ${r.status()} y ${cuerpo?.length ?? 0} bytes (el fichero tiene ${esperado})`);
			}
		});
		for (const [nombre, ruta] of Object.entries(paginas)) {
			const respuesta = await pagina.goto(base + ruta, { waitUntil: 'networkidle' });
			const estado = respuesta?.status();
			const h1 = await pagina.locator('h1').count();
			const cabecera = await pagina.locator('.mp-cabecera').count();
			if (estado !== 200) fallos.push(`${variacion} ${nombre} ${ancho}px: HTTP ${estado}`);
			if (cabecera !== 1) fallos.push(`${variacion} ${nombre} ${ancho}px: no la pinta el tema museopostal`);
			if (h1 !== 1) fallos.push(`${variacion} ${nombre} ${ancho}px: ${h1} H1 (se espera 1)`);
			// Las imágenes con loading="lazy" por debajo del pliegue no se cargan en una
			// captura de página entera: se fuerzan y se espera a que terminen.
			await pagina.evaluate(async () => {
				const imagenes = [...document.images];
				imagenes.forEach((img) => { img.loading = 'eager'; });
				await Promise.all(imagenes.map((img) => (img.complete ? null : new Promise((listo) => { img.onload = img.onerror = listo; }))));
				// Cargada no es pintada: con decoding="async" el runner puede capturar antes de decodificar.
				await Promise.all(imagenes.map((img) => img.decode().catch(() => null)));
			});
			const rotas = await pagina.evaluate(() => [...document.images].filter((img) => !img.naturalWidth).map((img) => img.currentSrc || img.src));
			if (rotas.length) fallos.push(`${variacion} ${nombre} ${ancho}px: imágenes sin cargar: ${rotas.join(', ')}`);
			const estado2 = await pagina.evaluate(async () => {
				await document.fonts.ready;
				return {
					desborde: document.documentElement.scrollWidth - document.documentElement.clientWidth,
					logo: document.querySelectorAll('.mp-cabecera .mp-logo svg').length,
					favicon: [...document.querySelectorAll('link[rel="icon"]')].map((l) => l.getAttribute('href')),
					precargas: [...document.querySelectorAll('link[rel="preload"][as="font"]')].map((l) => l.getAttribute('href')),
					fuentes: [...new Set([...document.fonts].filter((f) => f.status === 'loaded' && f.family !== 'dashicons').map((f) => f.family))],
					h1Fuente: getComputedStyle(document.querySelector('h1')).fontFamily,
				};
			});
			if (estado2.desborde > 0) fallos.push(`${variacion} ${nombre} ${ancho}px: desborda ${estado2.desborde}px en horizontal`);
			if (esperado.logo) {
				if (estado2.logo !== 1) fallos.push(`${variacion} ${nombre} ${ancho}px: ${estado2.logo} logos en la cabecera (se espera 1: ${esperado.logo})`);
				if (!estado2.favicon.some((h) => h?.endsWith(`${esperado.logo}-favicon.svg`))) fallos.push(`${variacion} ${nombre} ${ancho}px: falta el favicon ${esperado.logo}-favicon.svg (hay: ${estado2.favicon.join(', ') || 'ninguno'})`);
			}
			if (esperado.fuentes) {
				if (estado2.precargas.length !== 2) fallos.push(`${variacion} ${nombre} ${ancho}px: ${estado2.precargas.length} fuentes precargadas (se esperan 2)`);
				if (estado2.fuentes.length < 2) fallos.push(`${variacion} ${nombre} ${ancho}px: solo cargan estas fuentes propias: ${estado2.fuentes.join(', ') || 'ninguna'}`);
			} else if (estado2.precargas.length || estado2.fuentes.length) {
				fallos.push(`${variacion} ${nombre} ${ancho}px: sin fuentes propias no debería precargar ni cargar ninguna (${estado2.precargas.length} precargas, ${estado2.fuentes.join(', ')})`);
			}
			const carpeta = join(salida, variacion);
			mkdirSync(carpeta, { recursive: true });
			await pagina.screenshot({ path: join(carpeta, `${nombre}-${ancho}.png`), fullPage: true, animations: 'disabled' });
			const imagenes = await pagina.evaluate(() => [...document.images].map((img) => `${img.currentSrc.split('/').pop()}:${img.naturalWidth}`));
			console.log(`${variacion}/${nombre}-${ancho}.png  HTTP ${estado}, ${h1} H1, logo ${estado2.logo}, favicon ${estado2.favicon.join(',') || '-'}, precargas ${estado2.precargas.length}, fuentes [${estado2.fuentes.join(', ')}], h1 en ${estado2.h1Fuente}, imágenes ${imagenes.join(' ')}`);
		}
		await contexto.close();
	}
}
await navegador.close();

if (fallos.length) {
	for (const f of fallos) console.log(`::error::${f}`);
	process.exit(1);
}
