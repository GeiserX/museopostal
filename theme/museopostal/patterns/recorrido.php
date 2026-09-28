<?php
/**
 * Title: Recorrido
 * Slug: museopostal/recorrido
 * Categories: museopostal-salas
 * Post Types: page
 * Description: Relato ordenado de 6 a 12 piezas. Duplica un paso por cada pieza: imagen enlazada a su ficha y de 80 a 150 palabras.
 *
 * @package museopostal
 */

?>
<!-- wp:paragraph {"fontSize":"large","placeholder":"<?php echo esc_attr__( 'Introducción del recorrido: de qué trata y por qué merece la pena, en dos o tres frases.', 'museopostal' ); ?>"} -->
<p class="has-large-font-size"></p>
<!-- /wp:paragraph -->

<!-- wp:group {"tagName":"section","className":"mp-recorrido-paso","layout":{"type":"constrained"}} -->
<section class="wp-block-group mp-recorrido-paso">
<!-- wp:heading {"placeholder":"<?php echo esc_attr__( 'Paso 1: nombre de la pieza', 'museopostal' ); ?>"} -->
<h2 class="wp-block-heading"></h2>
<!-- /wp:heading -->

<!-- wp:image {"sizeSlug":"large","linkDestination":"custom","className":"is-style-montura"} -->
<figure class="wp-block-image size-large is-style-montura"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Qué se ve y por qué importa en este recorrido: de 80 a 150 palabras.', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"mp-recorrido-paso__datos","placeholder":"<?php echo esc_attr__( 'Fecha y lugar (opcional).', 'museopostal' ); ?>"} -->
<p class="mp-recorrido-paso__datos"></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->

<!-- wp:separator {"className":"is-style-perforado"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-perforado"/>
<!-- /wp:separator -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Créditos', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Comisario, fuentes y procedencia de las imágenes.', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->
