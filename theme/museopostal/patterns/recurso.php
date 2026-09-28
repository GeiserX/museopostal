<?php
/**
 * Title: Recurso de la biblioteca
 * Slug: museopostal/recurso
 * Categories: museopostal-investigacion
 * Post Types: page
 * Description: Un PDF propio, libro, catálogo, revista o enlace, con autor, año, editorial, ISBN y licencia.
 *
 * @package museopostal
 */

?>
<!-- wp:group {"tagName":"article","className":"is-style-tarjeta mp-recurso","templateLock":"contentOnly","layout":{"type":"default"}} -->
<article class="wp-block-group is-style-tarjeta mp-recurso">
<!-- wp:heading {"level":3,"placeholder":"<?php echo esc_attr__( 'Título del recurso', 'museopostal' ); ?>"} -->
<h3 class="wp-block-heading"></h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'Tipo:', 'museopostal' ); ?></strong> <?php esc_html_e( 'PDF propio, libro, catálogo, revista o enlace', 'museopostal' ); ?></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'Autor:', 'museopostal' ); ?></strong> </li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'Año y editorial:', 'museopostal' ); ?></strong> </li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'ISBN:', 'museopostal' ); ?></strong> </li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'Licencia:', 'museopostal' ); ?></strong> </li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->

<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Enlace al archivo o a la fuente.', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->
</article>
<!-- /wp:group -->
