<?php
/**
 * Muestra de Playground, segundo paso (no se instala con el tema ni con el plugin).
 *
 * El blueprint copia las imágenes de playground/muestra/ a
 * wp-content/uploads/muestra/ e importa muestra.xml. Este script, que se
 * ejecuta después con WordPress cargado:
 *
 * 1. crea un adjunto por imagen, con su texto alternativo;
 * 2. pone el anverso como imagen destacada y el reverso en mp_reverso_id;
 * 3. cambia {{muestra}} en el contenido por la URL real de las imágenes;
 * 4. fija la portada y la página de artículos, y regenera las URL.
 *
 * Así la muestra no pide nada a museopostal.org (crítica n.º 27).
 * Si algo falta, lanza una excepción y el blueprint se para en rojo.
 *
 * @package museopostal
 */

defined( 'ABSPATH' ) || exit;

$museopostal_subidas = wp_upload_dir();
$museopostal_dir     = $museopostal_subidas['basedir'] . '/muestra';
$museopostal_url     = $museopostal_subidas['baseurl'] . '/muestra';

// slug => tipo, anverso, alt del anverso, reverso, alt del reverso.
$museopostal_imagenes = array(
	'carta-de-aguilas-a-murcia-1866'        => array( 'pieza', '1866_81-85_ANV.jpg', 'Carta de Águilas a Murcia de 1866 con un sello de 4 cuartos azul y otro de 20 céntimos de escudo lila, matasellados con el fechador de Águilas' ),
	'spd-submarino-peral-2014'              => array( 'pieza', '2014_4870_SPD.jpg', 'Sobre de primer día con el sello de 0,54 € del 125 aniversario del submarino Peral, el retrato de Isaac Peral y el matasellos de Madrid del 18 de febrero de 2014' ),
	'hoja-bloque-eclipse-solar-2026'        => array( 'pieza', '2026_eclipse_HB.jpg', 'Hoja bloque de Correos «Eclipse solar total, España 12 agosto 2026» con un sello de 4 € que muestra el eclipse y el mapa de la península' ),
	'san-jeronimo-leyendo-una-carta'        => array( 'pieza', 'de-la-tour_san-jeronimo.jpg', 'Cuadro de Georges de la Tour: San Jerónimo lee una carta iluminada, con el resto de la escena en penumbra' ),
	'la-carta-de-amor'                      => array( 'pieza', 'van-der-kooi_carta-de-amor.webp', 'Cuadro de Van der Kooi: un joven mensajero entrega una carta lacrada a una mujer vestida a la moda Imperio' ),
	'tarjeta-del-soldado-1918'              => array( 'pieza', '1918_tarjeta-campana_ANV.jpg', 'Anverso de una tarjeta en franquicia del Regio Esercito Italiano con banderas aliadas, el fechador de Posta Militare y la marca azul «Verificato per censura»', '1918_tarjeta-campana_REV.jpg', 'Reverso de la tarjeta, escrito a mano desde la zona de guerra el 28 de mayo de 1918' ),
	'marcas-censura-postal-nacional-heller' => array( 'pieza', 'heller_censura_ANV.jpg', 'Portada del libro de Ernst L. Heller «Marcas utilizadas por la Censura postal Nacional de 1936 a 1945», con un sobre censurado del Banco Hispano Americano', 'heller_censura_REV.jpg', 'Contraportada del libro de Ernst L. Heller sobre la censura postal nacional' ),
	'hoja-bloque-300-anos-correos-2016'     => array( 'pieza', '2016_300-anos-correos_HB.jpg', 'Hoja bloque de 2016 «300 años de Correos en España, primera centuria 1716 a 1816», con un sello de 3 € sobre un mapa de rutas postales' ),
	'el-wi-fi-del-siglo-xix'                => array( 'post', 'cursuspublicus.jpg', 'Carreta romana del cursus publicus' ),
	'el-correo-submarino'                   => array( 'post', '1938_775_sellos.jpg', 'Los seis sellos de la serie Correo Submarino de 1938, de distinto color y valor' ),
);

/**
 * Crea el adjunto de una imagen ya copiada a uploads/muestra/.
 *
 * @throws RuntimeException Si falta el fichero o WordPress no crea el adjunto.
 */
$museopostal_adjunto = static function ( string $fichero, string $alt, int $padre ) use ( $museopostal_dir, $museopostal_url ): int {
	$ruta = $museopostal_dir . '/' . $fichero;
	if ( ! file_exists( $ruta ) ) {
		throw new RuntimeException( 'Falta la imagen de muestra ' . $ruta );
	}
	$tipo = wp_check_filetype( $fichero );
	$id   = wp_insert_attachment(
		array(
			'post_mime_type' => (string) $tipo['type'],
			'post_title'     => pathinfo( $fichero, PATHINFO_FILENAME ),
			'post_status'    => 'inherit',
			'guid'           => $museopostal_url . '/' . $fichero,
		),
		$ruta,
		$padre,
		true
	);
	if ( is_wp_error( $id ) || ! $id ) {
		throw new RuntimeException( 'No se pudo crear el adjunto ' . $fichero );
	}
	$tamano = wp_getimagesize( $ruta );
	wp_update_attachment_metadata(
		$id,
		array(
			'width'  => (int) ( $tamano[0] ?? 0 ),
			'height' => (int) ( $tamano[1] ?? 0 ),
			'file'   => 'muestra/' . $fichero,
			'sizes'  => array(),
		)
	);
	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	return (int) $id;
};

foreach ( $museopostal_imagenes as $museopostal_slug => $museopostal_datos ) {
	$museopostal_post = get_page_by_path( $museopostal_slug, OBJECT, $museopostal_datos[0] );
	if ( ! $museopostal_post ) {
		throw new RuntimeException( 'No se importó ' . $museopostal_datos[0] . ' ' . $museopostal_slug );
	}
	set_post_thumbnail( $museopostal_post, $museopostal_adjunto( $museopostal_datos[1], $museopostal_datos[2], $museopostal_post->ID ) );
	if ( isset( $museopostal_datos[3] ) ) {
		update_post_meta( $museopostal_post->ID, 'mp_reverso_id', $museopostal_adjunto( $museopostal_datos[3], $museopostal_datos[4], $museopostal_post->ID ) );
	}
}

// {{muestra}} en el contenido → URL real. Directo en la tabla: sin kses ni revisiones.
global $wpdb;
$wpdb->query(
	$wpdb->prepare(
		"UPDATE {$wpdb->posts} SET post_content = REPLACE( post_content, %s, %s ) WHERE post_content LIKE %s",
		'{{muestra}}',
		$museopostal_url,
		'%' . $wpdb->esc_like( '{{muestra}}' ) . '%'
	)
);
wp_cache_flush();

// Portada estática y página de artículos (§4.2: /articulos/).
$museopostal_inicio    = get_page_by_path( 'inicio' );
$museopostal_articulos = get_page_by_path( 'articulos' );
if ( ! $museopostal_inicio || ! $museopostal_articulos ) {
	throw new RuntimeException( 'Faltan las páginas Inicio o Artículos de la muestra.' );
}
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $museopostal_inicio->ID );
update_option( 'page_for_posts', $museopostal_articulos->ID );
flush_rewrite_rules();

// Comprobación final: cada pieza con su anverso.
$museopostal_sin_imagen = get_posts(
	array(
		'post_type'      => 'pieza',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_query_meta_query
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'NOT EXISTS',
			),
		),
	)
);
if ( $museopostal_sin_imagen || 8 !== (int) wp_count_posts( 'pieza' )->publish ) {
	throw new RuntimeException(
		sprintf(
			'La muestra no quedó completa: %d piezas publicadas (se esperan 8); sin anverso: %s',
			(int) wp_count_posts( 'pieza' )->publish,
			$museopostal_sin_imagen ? implode( ',', $museopostal_sin_imagen ) : 'ninguna'
		)
	);
}
