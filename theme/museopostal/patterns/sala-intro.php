<?php
/**
 * Title: Sala: presentación
 * Slug: museopostal/sala-intro
 * Categories: museopostal-salas
 * Inserter: no
 * Description: Cabecera de una sala: migas, nombre de la sala como H1 y el texto de sala, que es la descripción del término.
 *
 * @package museopostal
 */

?>
<!-- wp:group {"tagName":"section","className":"mp-sala-intro","layout":{"type":"constrained"}} -->
<section class="wp-block-group mp-sala-intro">
<!-- wp:breadcrumbs /-->

<!-- wp:paragraph {"className":"mp-sala-intro__etiqueta"} -->
<p class="mp-sala-intro__etiqueta"><?php esc_html_e( 'Sala del museo', 'museopostal' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:query-title {"type":"archive","showPrefix":false} /-->

<!-- wp:term-description /-->
</section>
<!-- /wp:group -->
