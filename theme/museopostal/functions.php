<?php
/**
 * Museo Postal: funciones del tema.
 *
 * Solo lo que theme.json no puede hacer: la hoja de estilos, las
 * categorías de patrones, los estilos de bloque, el formato WebP, la
 * precarga de las fuentes y el favicon de la variación activa.
 * El modelo del museo (piezas, salas, metadatos) vive en el plugin
 * museopostal-coleccion para sobrevivir a un cambio de tema.
 *
 * @package museopostal
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hoja de estilos del tema en el sitio y en el editor.
 */
function museopostal_setup(): void {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'museopostal_setup' );

/**
 * Un solo fichero CSS propio (T4: como mucho 3 CSS en portada).
 */
function museopostal_estilos(): void {
	wp_enqueue_style(
		'museopostal',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'museopostal_estilos' );

/**
 * Categorías de patrones: así Felipe encuentra cada patrón por su uso.
 */
function museopostal_categorias_de_patrones(): void {
	$categorias = array(
		'museopostal-portada'       => __( 'Museo: portada', 'museopostal' ),
		'museopostal-salas'         => __( 'Museo: salas y recorridos', 'museopostal' ),
		'museopostal-coleccion'     => __( 'Museo: colección', 'museopostal' ),
		'museopostal-aula'          => __( 'Museo: Aula', 'museopostal' ),
		'museopostal-investigacion' => __( 'Museo: investigación', 'museopostal' ),
	);
	foreach ( $categorias as $slug => $nombre ) {
		register_block_pattern_category( $slug, array( 'label' => $nombre ) );
	}
}
add_action( 'init', 'museopostal_categorias_de_patrones' );

/**
 * Estilos de bloque. Cada uno tiene su CSS en style.css.
 */
function museopostal_estilos_de_bloque(): void {
	$montura = array(
		'name'  => 'montura',
		'label' => __( 'Pieza sobre montura', 'museopostal' ),
	);
	register_block_style( 'core/image', $montura );
	register_block_style( 'core/post-featured-image', $montura );

	register_block_style(
		'core/separator',
		array(
			'name'  => 'perforado',
			'label' => __( 'Filete dentado', 'museopostal' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'tarjeta',
			'label' => __( 'Tarjeta', 'museopostal' ),
		)
	);
	register_block_style(
		'core/paragraph',
		array(
			'name'  => 'cifras',
			'label' => __( 'Cifras tabulares', 'museopostal' ),
		)
	);
}
add_action( 'init', 'museopostal_estilos_de_bloque' );

/**
 * Los tamaños intermedios de JPEG y PNG se generan en WebP (§7.1).
 *
 * @param array<string, string> $formatos Formato de origen => formato de salida.
 * @return array<string, string>
 */
function museopostal_formato_webp( array $formatos ): array {
	$formatos['image/jpeg'] = 'image/webp';
	$formatos['image/png']  = 'image/webp';
	return $formatos;
}
add_filter( 'image_editor_output_format', 'museopostal_formato_webp' );

/**
 * Precarga los dos primeros woff2 de la variación activa (BRIEF §7.1): la
 * redonda de titulares y la de cuerpo o interfaz. Con las fuentes del sistema
 * (tema base) no imprime nada.
 */
function museopostal_precarga_fuentes(): void {
	$familias = wp_get_global_settings( array( 'typography', 'fontFamilies' ) );
	$lista    = array();
	foreach ( array( 'custom', 'theme' ) as $origen ) {
		if ( ! empty( $familias[ $origen ] ) && is_array( $familias[ $origen ] ) ) {
			$lista = $familias[ $origen ];
			break;
		}
	}
	$urls = array();
	foreach ( $lista as $familia ) {
		foreach ( (array) ( $familia['fontFace'] ?? array() ) as $cara ) {
			if ( 'italic' === ( $cara['fontStyle'] ?? 'normal' ) ) {
				continue;
			}
			$src = (array) ( $cara['src'] ?? array() );
			$src = (string) reset( $src );
			if ( str_starts_with( $src, 'file:./' ) ) {
				$src = get_theme_file_uri( substr( $src, 7 ) );
			}
			if ( str_ends_with( $src, '.woff2' ) && ! in_array( $src, $urls, true ) ) {
				$urls[] = $src;
			}
		}
	}
	foreach ( array_slice( $urls, 0, 2 ) as $url ) {
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( $url ) );
	}
}
add_action( 'wp_head', 'museopostal_precarga_fuentes', 2 );

/**
 * Favicon SVG de la propuesta de logo que elige la variación (settings.custom.logo),
 * mientras no haya un icono del sitio subido en Ajustes › Identidad del sitio.
 */
function museopostal_favicon(): void {
	if ( has_site_icon() ) {
		return;
	}
	$logo = sanitize_key( (string) wp_get_global_settings( array( 'custom', 'logo' ) ) );
	if ( '' === $logo || ! is_readable( get_theme_file_path( 'assets/logo/' . $logo . '-favicon.svg' ) ) ) {
		return;
	}
	printf( '<link rel="icon" href="%s" type="image/svg+xml">' . "\n", esc_url( get_theme_file_uri( 'assets/logo/' . $logo . '-favicon.svg' ) ) );
}
add_action( 'wp_head', 'museopostal_favicon', 2 );
