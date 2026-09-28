#!/usr/bin/env node
/**
 * Capturas de la portada, una sala y una ficha a 1440 y 500 px, para el tema
 * base y para cada variación de theme/museopostal/styles/*.json.
 * Guarda docs/capturas/<variacion>/<pagina>-<ancho>.png.
 *
 * Además de fotografiar, comprueba que cada página responde 200, la pinta el
 * tema museopostal (su cabecera .mp-cabecera), tiene un solo H1 y todas sus
 * imágenes cargan.
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
		// Cada imagen del sitio tiene que llegar entera: mismo tamaño que su fichero en playground/muestra/.
		pagina.on('response', async (r) => {
			const url = r.url();
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
			const carpeta = join(raiz, 'docs/capturas', variacion);
			mkdirSync(carpeta, { recursive: true });
			await pagina.screenshot({ path: join(carpeta, `${nombre}-${ancho}.png`), fullPage: true, animations: 'disabled' });
			const imagenes = await pagina.evaluate(() => [...document.images].map((img) => `${img.currentSrc.split('/').pop()}:${img.naturalWidth}`));
			console.log(`${variacion}/${nombre}-${ancho}.png  HTTP ${estado}, ${h1} H1, imágenes ${imagenes.join(' ')}`);
		}
		await contexto.close();
	}
}
await navegador.close();

if (fallos.length) {
	for (const f of fallos) console.log(`::error::${f}`);
	process.exit(1);
}
