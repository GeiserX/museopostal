<?php
/**
 * Title: Actividad del Aula
 * Slug: museopostal/actividad-aula
 * Categories: museopostal-aula
 * Post Types: page
 * Description: Ficha guiada para clase: nivel, materias, duración, objetivos, la pieza con sus puntos numerados, desarrollo, preguntas y solucionario.
 *
 * @package museopostal
 */

?>
<!-- wp:group {"className":"is-style-tarjeta mp-actividad-datos","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tarjeta mp-actividad-datos">
<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'Nivel:', 'museopostal' ); ?></strong> <?php esc_html_e( 'Primaria, ESO, Bachillerato o adultos', 'museopostal' ); ?></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'Materias:', 'museopostal' ); ?></strong> <?php esc_html_e( 'Historia, Lengua, Geografía…', 'museopostal' ); ?></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong><?php esc_html_e( 'Duración:', 'museopostal' ); ?></strong> <?php esc_html_e( '50 minutos', 'museopostal' ); ?></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:group -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Objetivos', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item {"placeholder":"<?php echo esc_attr__( 'Qué aprenderá el alumnado.', 'museopostal' ); ?>"} -->
<li></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'La pieza', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Elige la pieza en los ajustes del bloque de debajo: se muestra con sus puntos numerados (campo «Anotaciones» de su ficha técnica).', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:museopostal/datos-pieza {"vista":"anotaciones"} /-->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Desarrollo', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Pasos de la actividad en clase.', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Preguntas', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list">
<!-- wp:list-item {"placeholder":"<?php echo esc_attr__( 'Una pregunta sobre la pieza.', 'museopostal' ); ?>"} -->
<li></li>
<!-- /wp:list-item -->
</ol>
<!-- /wp:list -->

<!-- wp:details {"summary":"<?php echo esc_attr__( 'Solucionario (para el docente)', 'museopostal' ); ?>"} -->
<details class="wp-block-details"><summary><?php esc_html_e( 'Solucionario (para el docente)', 'museopostal' ); ?></summary>
<!-- wp:paragraph {"placeholder":"<?php echo esc_attr__( 'Respuestas a las preguntas.', 'museopostal' ); ?>"} -->
<p></p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->

<!-- wp:paragraph {"className":"mp-aviso-menores","fontSize":"small"} -->
<p class="mp-aviso-menores has-small-font-size"><?php esc_html_e( 'Esta actividad no recoge datos del alumnado, no tiene formularios y no carga servicios de terceros.', 'museopostal' ); ?></p>
<!-- /wp:paragraph -->
