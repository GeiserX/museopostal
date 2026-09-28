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
 * Con un tercer argumento, el slug de una variación (theme/museopostal/styles/
 * <slug>.json), añade un paso que la deja aplicada como si Felipe la hubiera
 * elegido en Estilos: guarda sus settings y styles en el post wp_global_styles
 * del usuario, que es donde WordPress guarda esa elección.
 *
 * Uso: node playground/vista-previa.mjs <propietario/repo> <sha> [variación|base]
 */
import { existsSync, readFileSync } from 'node:fs';

const [repo, sha, variacion = 'base'] = process.argv.slice(2);
if (!/^[\w.-]+\/[\w.-]+$/.test(repo ?? '') || !/^[0-9a-f]{40}$/.test(sha ?? '') || !/^[a-z0-9-]+$/.test(variacion)) {
	console.error('Uso: node playground/vista-previa.mjs <propietario/repo> <sha de 40 caracteres> [variación|base]');
	process.exit(2);
}
if (variacion !== 'base' && !existsSync(new URL(`../theme/museopostal/styles/${variacion}.json`, import.meta.url))) {
	console.error(`No existe theme/museopostal/styles/${variacion}.json`);
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

if (variacion !== 'base') {
	blueprint.meta.title += ` (${variacion})`;
	// Directo en la tabla: sin kses (el CSS de la variación lleva «>») ni revisiones.
	blueprint.steps.push({
		step: 'runPHP',
		code: [
			'<?php',
			'require "/wordpress/wp-load.php";',
			`$fichero = get_theme_file_path( "styles/${variacion}.json" );`,
			'$datos = json_decode( (string) file_get_contents( $fichero ), true );',
			`if ( ! is_array( $datos ) ) { throw new RuntimeException( "Variación ilegible: ${variacion}" ); }`,
			'$usuario = array( "version" => 3, "isGlobalStylesUserThemeJSON" => true, "settings" => $datos["settings"] ?? array(), "styles" => $datos["styles"] ?? array() );',
			'$id = (int) WP_Theme_JSON_Resolver::get_user_global_styles_post_id();',
			// Sin usuario conectado, wp_insert_post no asigna el término wp_theme y WordPress no encontraría el post.
			'wp_set_object_terms( $id, get_stylesheet(), "wp_theme" );',
			'global $wpdb;',
			'$wpdb->update( $wpdb->posts, array( "post_content" => wp_json_encode( $usuario ) ), array( "ID" => $id ) );',
			'clean_post_cache( $id );',
			'wp_cache_flush();',
			'WP_Theme_JSON_Resolver::clean_cached_data();',
			'$esperado = ""; foreach ( (array) ( $datos["settings"]["color"]["palette"] ?? array() ) as $c ) { if ( "base" === ( $c["slug"] ?? "" ) ) { $esperado = strtolower( (string) $c["color"] ); } }',
			'$real = ""; foreach ( (array) wp_get_global_settings( array( "color", "palette", "custom" ) ) as $c ) { if ( "base" === ( $c["slug"] ?? "" ) ) { $real = strtolower( (string) $c["color"] ); } }',
			`if ( "" === $esperado || $real !== $esperado ) { throw new RuntimeException( "La variación ${variacion} no quedó aplicada: fondo $real, se esperaba $esperado" ); }`,
		].join('\n'),
	});
}

process.stdout.write(JSON.stringify(blueprint));
