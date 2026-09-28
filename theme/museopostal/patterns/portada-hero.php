<?php
/**
 * Title: Portada: presentación
 * Slug: museopostal/portada-hero
 * Categories: museopostal-portada
 * Description: El nombre del museo como único H1, la misión en una frase y dos accesos. Sin carrusel ni imágenes generadas.
 *
 * @package museopostal
 */

?>
<!-- wp:group {"tagName":"section","className":"mp-portada-hero","templateLock":"contentOnly","layout":{"type":"constrained"}} -->
<section class="wp-block-group mp-portada-hero">
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php esc_html_e( 'Museo Postal y Filatélico de la Región de Murcia', 'museopostal' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Un museo virtual que conserva, explica y comparte sellos, cartas y marcas postales, con la Región de Murcia como punto de partida.', 'museopostal' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/salas/' ) ); ?>"><?php esc_html_e( 'Entrar en las salas', 'museopostal' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/coleccion/' ) ); ?>"><?php esc_html_e( 'Explorar la colección', 'museopostal' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
