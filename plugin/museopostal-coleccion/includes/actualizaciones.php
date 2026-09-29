<?php
/**
 * Actualizaciones desde las Releases de GitHub.
 *
 * PENDIENTE (crítica n.º 26): aquí se cargará plugin-update-checker v5
 * (MIT) apuntando a las Releases públicas de GeiserX/museopostal. No se
 * incluye todavía a propósito:
 *
 * - Sin autenticar, la API de GitHub admite 60 peticiones por hora por IP,
 *   compartidas con los demás clientes del servidor de Webempresa. La
 *   comprobación puede fallar en silencio.
 * - La alternativa que admite PUC es un JSON de metadatos publicado como
 *   asset de cada Release, que no gasta cuota de la API. Hay que probar
 *   cuál funciona desde el clon pruebas.museopostal.org antes de elegir.
 * - Antes de la primera Release con PUC tiene que existir la protección de
 *   los tags v* (crítica n.º 3): quien publique un tag publica en producción.
 *
 * Mientras tanto, la cabecera «Update URI» del plugin y del tema impide que
 * WordPress.org ofrezca como actualización un plugin ajeno con el mismo slug.
 *
 * @package museopostal-coleccion
 */

defined( 'ABSPATH' ) || exit;
