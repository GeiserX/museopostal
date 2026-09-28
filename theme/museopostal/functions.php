<?php
/**
 * Museo Postal: funciones del tema.
 *
 * Solo lo que theme.json no puede hacer: la hoja de estilos, las
 * categorías de patrones, los estilos de bloque y el formato WebP.
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
