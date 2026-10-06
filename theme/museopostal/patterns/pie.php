<?php
/**
 * Title: Pie
 * Slug: museopostal/pie
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 * Description: Lema, una pieza al azar, enlaces legales, contacto, accesibilidad y copyright (§4.1). Sin redes incrustadas.
 *
 * @package museopostal
 */

?>
<!-- wp:group {"tagName":"div","className":"mp-pie","layout":{"type":"constrained"}} -->
<div class="wp-block-group mp-pie">
<!-- wp:separator {"className":"is-style-perforado","align":"wide"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-perforado"/>
<!-- /wp:separator -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:site-title {"level":0} /-->
<!-- wp:site-tagline /-->
<!-- wp:museopostal/pieza-al-azar /-->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:list {"className":"mp-pie__enlaces"} -->
<ul class="wp-block-list mp-pie__enlaces">
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Contacto', 'museopostal' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/el-museo/accesibilidad/' ) ); ?>"><?php esc_html_e( 'Declaración de accesibilidad', 'museopostal' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/el-museo/creditos-y-licencias/' ) ); ?>"><?php esc_html_e( 'Créditos y licencias', 'museopostal' ); ?></a></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:list {"className":"mp-pie__enlaces"} -->
<ul class="wp-block-list mp-pie__enlaces">
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/aviso-legal/' ) ); ?>"><?php esc_html_e( 'Aviso legal', 'museopostal' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/politica-de-privacidad/' ) ); ?>"><?php esc_html_e( 'Política de privacidad', 'museopostal' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/politica-de-cookies/' ) ); ?>"><?php esc_html_e( 'Política de cookies', 'museopostal' ); ?></a></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:paragraph {"className":"mp-pie__copyright"} -->
<p class="mp-pie__copyright">© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'Museo Postal y Filatélico de la Región de Murcia', 'museopostal' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
