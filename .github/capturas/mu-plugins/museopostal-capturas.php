<?php
/**
 * Solo para el job de capturas (se monta en Playground; nunca se publica).
 *
 * - Aplica la variación de estilo que pide la cookie mp_variacion
 *   (theme/museopostal/styles/<slug>.json) como si Felipe la hubiera elegido
 *   en el Editor del sitio, pero sin escribir en la base de datos.
 * - Oculta la barra de administración para que no salga en las capturas.
 *
 * @package museopostal
 */

add_filter( 'show_admin_bar', '__return_false' );

add_filter(
	'wp_theme_json_data_user',
	static function ( $datos ) {
		$slug = isset( $_COOKIE['mp_variacion'] ) ? sanitize_key( wp_unslash( $_COOKIE['mp_variacion'] ) ) : '';
		if ( '' === $slug || 'base' === $slug ) {
			return $datos;
		}
		$fichero = get_theme_file_path( 'styles/' . $slug . '.json' );
		if ( ! is_readable( $fichero ) ) {
			wp_die( esc_html( 'Variación desconocida: ' . $slug ), '', array( 'response' => 500 ) );
		}
		$variacion = json_decode( (string) file_get_contents( $fichero ), true );
		if ( ! is_array( $variacion ) ) {
			wp_die( esc_html( 'Variación ilegible: ' . $slug ), '', array( 'response' => 500 ) );
		}
		return $datos->update_with( $variacion );
	}
);
