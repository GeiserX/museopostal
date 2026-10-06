<?php
/**
 * Consultas: buscador por Edifil e inventario, orden de salas y épocas,
 * y las piezas relacionadas de la ficha.
 *
 * @package museopostal-coleccion
 */

defined( 'ABSPATH' ) || exit;

/**
 * El buscador del núcleo solo mira título, extracto y contenido. Este filtro
 * añade las piezas cuyo catálogo (Edifil, Yvert…) o inventario contienen
 * la búsqueda entera, de modo que «4870» o «Edifil 81» encuentran la pieza
 * (crítica n.º 21).
 *
 * @param string   $busqueda Cláusula SQL de búsqueda que genera el núcleo.
 * @param WP_Query $consulta Consulta.
 */
function museopostal_coleccion_buscar_en_catalogo( string $busqueda, WP_Query $consulta ): string {
	$texto = trim( (string) $consulta->get( 's' ) );
	if ( '' === $busqueda || '' === $texto || ! $consulta->is_search() ) {
		return $busqueda;
	}
	$recortada = ltrim( $busqueda );
	if ( ! str_starts_with( $recortada, 'AND ' ) ) {
		return $busqueda;
	}
	global $wpdb;
	$por_catalogo = $wpdb->prepare(
		"{$wpdb->posts}.ID IN ( SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key IN ( 'mp_catalogo', 'mp_inventario' ) AND meta_value LIKE %s ) AND {$wpdb->posts}.post_password = ''",
		'%' . $wpdb->esc_like( $texto ) . '%'
	);
	return ' AND ( ( ' . $por_catalogo . ' ) OR ( ' . substr( $recortada, 4 ) . ' ) ) ';
}
add_filter( 'posts_search', 'museopostal_coleccion_buscar_en_catalogo', 10, 2 );

/**
 * Orden de los archivos de piezas: las salas por su recorrido (mp_orden_sala)
 * y las épocas por fecha, de la más antigua a la más reciente.
 *
 * @param WP_Query $consulta Consulta principal.
 */
function museopostal_coleccion_ordenar_archivos( WP_Query $consulta ): void {
	if ( is_admin() || ! $consulta->is_main_query() ) {
		return;
	}
	if ( $consulta->is_post_type_archive( 'pieza' ) || $consulta->is_tax( array( 'sala', 'epoca', 'lugar', 'tipo', 'tema' ) ) ) {
		$consulta->set( 'posts_per_page', 24 );
	}
	$clave = null;
	if ( $consulta->is_tax( 'sala' ) ) {
		$clave = array( 'mp_orden_sala', 'NUMERIC' );
	} elseif ( $consulta->is_tax( 'epoca' ) ) {
		$clave = array( 'mp_fecha', 'CHAR' );
	}
	if ( null === $clave ) {
		return;
	}
	// Las piezas sin ese dato no desaparecen del listado: van al principio.
	// phpcs:ignore WordPress.DB.SlowDBQuery.slow_query_meta_query -- archivo pequeño.
	$consulta->set(
		'meta_query',
		array(
			'relation' => 'OR',
			'orden'    => array(
				'key'     => $clave[0],
				'type'    => $clave[1],
				'compare' => 'EXISTS',
			),
			array(
				'key'     => $clave[0],
				'compare' => 'NOT EXISTS',
			),
		)
	);
	$consulta->set(
		'orderby',
		array(
			'orden' => 'ASC',
			'title' => 'ASC',
		)
	);
}
add_action( 'pre_get_posts', 'museopostal_coleccion_ordenar_archivos' );

/**
 * «En la misma sala» y «De la misma época» en la ficha: un bloque Query con
 * "mpRelacion": "sala" (o "epoca") en su consulta se limita a las piezas que
 * comparten ese término con la pieza que se está viendo.
 *
 * @param array<string, mixed> $vars   Argumentos de WP_Query.
 * @param WP_Block             $bloque Bloque post-template.
 */
function museopostal_coleccion_piezas_relacionadas( array $vars, WP_Block $bloque ): array {
	$relacion = $bloque->context['query']['mpRelacion'] ?? '';
	if ( ! in_array( $relacion, array( 'sala', 'epoca', 'lugar', 'tipo', 'tema' ), true ) ) {
		return $vars;
	}
	$actual   = (int) get_queried_object_id();
	$terminos = $actual ? wp_get_post_terms( $actual, $relacion, array( 'fields' => 'ids' ) ) : array();
	if ( is_wp_error( $terminos ) || ! $terminos ) {
		// Sin término que compartir no hay relacionadas: consulta vacía a propósito.
		$vars['post__in'] = array( 0 );
		return $vars;
	}
	$vars['post_type']              = 'pieza';
	$vars['post__not_in']           = array_merge( (array) ( $vars['post__not_in'] ?? array() ), array( $actual ) );
	$vars['ignore_sticky_posts']    = true;
	$vars['update_post_term_cache'] = true;
	// phpcs:ignore WordPress.DB.SlowDBQuery.slow_query_tax_query -- una sola taxonomía.
	$vars['tax_query'] = array(
		array(
			'taxonomy' => $relacion,
			'field'    => 'term_id',
			'terms'    => $terminos,
		),
	);
	return $vars;
}
add_filter( 'query_loop_block_query_vars', 'museopostal_coleccion_piezas_relacionadas', 10, 2 );
