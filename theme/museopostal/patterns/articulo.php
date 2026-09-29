<?php
/**
 * Title: Artículo
 * Slug: museopostal/articulo
 * Categories: museopostal-investigacion
 * Post Types: post
 * Block Types: core/post-content
 * Description: Estructura de un artículo: entradilla, apartados, piezas citadas y fuentes.
 *
 * @package museopostal
 */

?>
<!-- wp:paragraph {"fontSize":"large","placeholder":"<?php echo esc_attr__( 'Entradilla: una o dos frases que resumen el artículo.', 'museopostal' ); ?>"} -->
<p class="has-large-font-size"></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"placeholder":"<?php echo esc_attr__( 'Primer apartado', 'museopostal' ); ?>"} -->
<h2 class="wp-block-heading"></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Texto del apartado. Enlaza cada pieza que cites a su ficha.', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-perforado"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-perforado"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Fuentes', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item {"placeholder":"<?php echo esc_attr__( 'Autor, título, año y enlace.', 'museopostal' ); ?>"} -->
<li></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
