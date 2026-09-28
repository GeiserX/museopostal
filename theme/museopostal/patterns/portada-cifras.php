<?php
/**
 * Title: Portada: cifras y pieza al azar
 * Slug: museopostal/portada-cifras
 * Categories: museopostal-portada
 * Description: Cuántas piezas y salas hay publicadas, y un enlace a una pieza al azar que funciona sin JavaScript.
 *
 * @package museopostal
 */

?>
<!-- wp:group {"tagName":"section","className":"is-style-tarjeta mp-portada-cifras","templateLock":"contentOnly","layout":{"type":"default"}} -->
<section class="wp-block-group is-style-tarjeta mp-portada-cifras">
<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'La colección', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:museopostal/cifras /-->

<!-- wp:museopostal/pieza-al-azar /-->
</section>
<!-- /wp:group -->
