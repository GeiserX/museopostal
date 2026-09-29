<?php
/**
 * Title: Vídeo de la videoteca
 * Slug: museopostal/videoteca-item
 * Categories: museopostal-investigacion
 * Post Types: page
 * Description: Un vídeo con título, ponente, entidad, fecha, duración, resumen y crédito. El vídeo solo se carga de youtube-nocookie.com cuando el visitante pulsa.
 *
 * @package museopostal
 */

?>
<!-- wp:group {"tagName":"article","className":"mp-videoteca-item","templateLock":"contentOnly","layout":{"type":"constrained"}} -->
<article class="wp-block-group mp-videoteca-item">
<!-- wp:heading {"level":3,"placeholder":"<?php echo esc_attr__( 'Título del vídeo', 'museopostal' ); ?>"} -->
<h3 class="wp-block-heading"></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"mp-videoteca-item__datos","placeholder":"<?php echo esc_attr__( 'Ponente · Entidad · Fecha · Duración', 'museopostal' ); ?>"} -->
<p class="mp-videoteca-item__datos"></p>
<!-- /wp:paragraph -->

<!-- wp:museopostal/video /-->

<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Resumen en dos o tres frases.', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"mp-videoteca-item__piezas","placeholder":"<?php echo esc_attr__( 'Piezas relacionadas (enlaces a sus fichas).', 'museopostal' ); ?>"} -->
<p class="mp-videoteca-item__piezas"></p>
<!-- /wp:paragraph -->
</article>
<!-- /wp:group -->
