<?php
/**
 * Mapa 301 del sitio antiguo al nuevo (BRIEF §4.4 y crítica n.º 34).
 *
 * Solo actúa cuando WordPress iba a responder 404: mientras una página
 * antigua siga existiendo, se sirve ella. Al convertirla o borrarla, su URL
 * vieja empieza a redirigir sola. Una URL inventada sigue dando 404.
 * El mapa legible está en docs/mapa-301.md; este array manda.
 *
 * @package museopostal-coleccion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Mapa viejo => nuevo. Claves: ruta con barra final, «?p=N», «?page_id=N»,
 * o un prefijo terminado en «*». Destinos: rutas relativas a la portada.
 *
 * @return array<string, string>
 */
function museopostal_coleccion_mapa_301(): array {
	$publicaciones = '/el-museo/publicaciones/';
	$mapa          = array(
		// Portada, blog y tienda.
		'/proximamente-pagina-principal/'   => '/',
		'/contenedor-de-blog/'              => '/articulos/',
		'/category/sin-categoria/'          => '/articulos/',
		'/elementor-548/'                   => $publicaciones,
		'/carrito/'                         => $publicaciones,
		'/tienda/'                          => $publicaciones,
		'/producto/*'                       => $publicaciones,
		'/categoria-producto/*'             => $publicaciones,
		'/etiqueta-producto/*'              => $publicaciones,
		// Textos legales.
		'/elementor-573/'                   => '/politica-de-privacidad/',
		'/politica-privacidad/'             => '/politica-de-privacidad/',
		'/elementor-662/'                   => '/aviso-legal/',
		'/politica-de-cookies-ue/'          => '/politica-de-cookies/',
		// Salas y piezas.
		'/museos-del-mundo/'                => '/investigacion/museos-postales-del-mundo/',
		'/elementor-854/'                   => '/sala/el-correo-en-la-pintura/',
		'/elementor-821/'                   => '/pieza/san-jeronimo-leyendo-una-carta/',
		'/elementor-821-copy/'              => '/pieza/la-carta-de-amor/',
		'/cuadro_1-copy/'                   => '/pieza/las-ultimas-diligencias-del-correo-en-newcastle/',
		'/cuadro_1-copy-2/'                 => '/pieza/el-cartero-del-pueblo/',
		'/jean-baptiste-simeon-chardin/'    => '/pieza/una-mujer-sellando-una-carta/',
		'/museo_murcia/'                    => '/sala/region-de-murcia/',
		// Artículos, Aula, videoteca y formularios.
		'/eclipse-solar-agosto-2026-filatelia-correos-espana/' => '/articulos/los-eclipses-solares-en-la-filatelia/',
		'/video-conferencias-historia-postal-y-filatelia/' => '/investigacion/videoteca/',
		'/pagina_wasap/'                    => '/coleccion/comparte-tu-pieza/',
		'/la-tarjeta-del-soldado/'          => '/aula/la-tarjeta-del-soldado/',
		'/formulario_informacion/'          => '/contacto/',
		'/padre_museo/'                     => '/',
		'/investigacion-copy/'              => '/',
		'/el-wi-fi-del-siglo-xix/'          => '/articulos/el-wi-fi-del-siglo-xix/',
		'/el-correo-en-los-ultimos-2000-anos/' => '/articulos/el-wi-fi-del-siglo-xix/',
		'/el-correo-submarino-2/'           => '/articulos/el-correo-submarino/',
		'/el-correo-submarino/'             => '/articulos/el-correo-submarino/',
		'/author/felipe/'                   => '/el-museo/',
	);

	// Enlaces cortos ?p=N y ?page_id=N de las páginas y entradas antiguas (03 Anexo A).
	$por_id = array(
		235 => '/',
		598 => '/sala/region-de-murcia/',
		854 => '/sala/el-correo-en-la-pintura/',
		821 => '/pieza/san-jeronimo-leyendo-una-carta/',
		827 => '/pieza/la-carta-de-amor/',
		836 => '/pieza/las-ultimas-diligencias-del-correo-en-newcastle/',
		857 => '/pieza/el-cartero-del-pueblo/',
		753 => '/pieza/una-mujer-sellando-una-carta/',
		925 => '/articulos/los-eclipses-solares-en-la-filatelia/',
		717 => '/articulos/el-correo-submarino/',
		472 => '/articulos/el-wi-fi-del-siglo-xix/',
		118 => '/aula/la-tarjeta-del-soldado/',
		97  => '/investigacion/videoteca/',
		126 => '/investigacion/museos-postales-del-mundo/',
		691 => '/investigacion/',
		748 => '/',
		59  => '/coleccion/comparte-tu-pieza/',
		531 => '/articulos/',
		548 => $publicaciones,
		382 => $publicaciones,
		394 => $publicaciones,
		697 => '/contacto/',
		324 => '/contacto/',
		596 => '/',
		573 => '/politica-de-privacidad/',
		662 => '/aviso-legal/',
		658 => '/politica-de-cookies/',
	);
	foreach ( $por_id as $id => $destino ) {
		$mapa[ '?p=' . $id ]       = $destino;
		$mapa[ '?page_id=' . $id ] = $destino;
	}

	/**
	 * Filtra el mapa de redirecciones 301.
	 *
	 * @param array<string, string> $mapa Mapa viejo => nuevo.
	 */
	return (array) apply_filters( 'museopostal_coleccion_redirecciones', $mapa );
}

/**
 * Busca el destino de una petición en el mapa.
 *
 * @param string                $ruta     Ruta pedida, relativa a la portada.
 * @param array<string, string> $consulta Parámetros GET.
 * @param array<string, string> $mapa     Mapa viejo => nuevo.
 */
function museopostal_coleccion_destino_301( string $ruta, array $consulta, array $mapa ): ?string {
	$ruta = strtolower( '/' . trim( rawurldecode( $ruta ), '/' ) . '/' );
	$ruta = '//' === $ruta ? '/' : $ruta;

	foreach ( array( 'p', 'page_id' ) as $parametro ) {
		if ( isset( $consulta[ $parametro ] ) && isset( $mapa[ '?' . $parametro . '=' . absint( $consulta[ $parametro ] ) ] ) ) {
			return $mapa[ '?' . $parametro . '=' . absint( $consulta[ $parametro ] ) ];
		}
	}
	if ( '/' !== $ruta && isset( $mapa[ $ruta ] ) ) {
		return $mapa[ $ruta ];
	}
	foreach ( $mapa as $viejo => $nuevo ) {
		if ( str_ends_with( $viejo, '*' ) && str_starts_with( $ruta, rtrim( $viejo, '*' ) ) && $ruta !== rtrim( $viejo, '*' ) . '/' ) {
			return $nuevo;
		}
	}
	return null;
}

/**
 * Aplica el mapa justo antes del 404.
 */
function museopostal_coleccion_redirigir_301(): void {
	if ( ! is_404() ) {
		return;
	}
	$pedida = (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ) ), PHP_URL_PATH );
	$base   = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( '' !== $base && '/' !== $base && str_starts_with( $pedida, $base ) ) {
		$pedida = substr( $pedida, strlen( rtrim( $base, '/' ) ) );
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- solo lectura de la URL.
	$destino = museopostal_coleccion_destino_301( $pedida, wp_unslash( $_GET ), museopostal_coleccion_mapa_301() );
	if ( null !== $destino ) {
		wp_safe_redirect( home_url( $destino ), 301, 'museopostal-coleccion' );
		exit;
	}
}
add_action( 'template_redirect', 'museopostal_coleccion_redirigir_301', 5 );
