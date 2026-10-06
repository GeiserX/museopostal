<?php
/**
 * Plugin Name:       Museo Postal: colección
 * Plugin URI:        https://github.com/GeiserX/museopostal
 * Description:       El modelo del Museo Postal y Filatélico de la Región de Murcia: piezas con ficha filatélica, salas, épocas, lugares, tipos y temas, bloques de la ficha y la portada, buscador por Edifil y redirecciones del sitio antiguo. Funciona con cualquier tema; el tema «Museo Postal» lo presenta.
 * Version:           0.1.0
 * Requires at least: 7.1
 * Requires PHP:      8.1
 * Author:            Museo Postal y Filatélico de la Región de Murcia
 * Author URI:        https://museopostal.org
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       museopostal-coleccion
 * Update URI:        https://github.com/GeiserX/museopostal
 *
 * @package museopostal-coleccion
 */

defined( 'ABSPATH' ) || exit;

const MUSEOPOSTAL_COLECCION_VERSION = '0.1.0';
const MUSEOPOSTAL_COLECCION_ARCHIVO = __FILE__;

require_once __DIR__ . '/includes/modelo.php';
require_once __DIR__ . '/includes/ficha-tecnica.php';
require_once __DIR__ . '/includes/bloques.php';
require_once __DIR__ . '/includes/consultas.php';
require_once __DIR__ . '/includes/redirecciones.php';
require_once __DIR__ . '/includes/actualizaciones.php';

/**
 * Comentarios cerrados en todo el sitio (§7.4), también en el contenido
 * antiguo que se importó con los comentarios abiertos.
 */
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

/**
 * Al activar: registra el modelo, crea los términos iniciales y
 * regenera las URL para que /coleccion/, /pieza/ y /sala/ funcionen.
 */
function museopostal_coleccion_activar(): void {
	museopostal_coleccion_registrar_modelo();
	museopostal_coleccion_crear_terminos();
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'museopostal_coleccion_activar' );

/**
 * Al desactivar solo se regeneran las URL. No se borra nada: las piezas,
 * los términos y los metadatos se quedan en la base de datos.
 */
function museopostal_coleccion_desactivar(): void {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'museopostal_coleccion_desactivar' );
