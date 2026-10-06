<?php
/**
 * Title: Rejilla de piezas
 * Slug: museopostal/rejilla-piezas
 * Categories: museopostal-coleccion
 * Inserter: no
 * Description: Las piezas del archivo actual (colección, sala, época, lugar, tipo o tema) como tarjetas: imagen real sobre montura, título y una línea de contexto.
 *
 * @package museopostal
 */

?>
<!-- wp:query {"queryId":1,"query":{"inherit":true,"perPage":24},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide">
<!-- wp:post-template {"layout":{"type":"grid","minimumColumnWidth":"14rem"}} -->
<!-- wp:group {"className":"mp-tarjeta-pieza","layout":{"type":"default"}} -->
<div class="wp-block-group mp-tarjeta-pieza">
<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","scale":"contain","sizeSlug":"medium_large","className":"is-style-montura"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->

<!-- wp:post-excerpt {"excerptLength":22} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->
<!-- wp:query-pagination-numbers /-->
<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p><?php esc_html_e( 'Todavía no hay piezas aquí. Prueba con otra sala o con el buscador.', 'museopostal' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
