<?php
/**
 * Title: Portada: las cinco salas
 * Slug: museopostal/portada-puertas
 * Categories: museopostal-portada, museopostal-salas
 * Description: Cinco puertas, una por sala, con la Región de Murcia como sala central. Cada tarjeta lleva nombre y una línea de contexto.
 *
 * @package museopostal
 */

$museopostal_salas = array(
	array( 'region-de-murcia', __( 'La Región de Murcia', 'museopostal' ), __( 'Correo, sellos y marcas de la Región: Cartagena naval, Águilas, Lorca y Murcia.', 'museopostal' ), true ),
	array( 'antes-del-sello', __( 'Antes del sello', 'museopostal' ), __( 'Del cursus publicus al primer sello de España, en 1850.', 'museopostal' ), false ),
	array( 'correo-en-guerra', __( 'Correo en guerra', 'museopostal' ), __( 'Correo de campaña, censura y correo submarino, de 1918 a 1945.', 'museopostal' ), false ),
	array( 'el-correo-en-la-pintura', __( 'El correo en la pintura', 'museopostal' ), __( 'La carta, el lacre y el cartero vistos por los pintores.', 'museopostal' ), false ),
	array( 'sellos-que-cuentan-el-mundo', __( 'Sellos que cuentan el mundo', 'museopostal' ), __( 'Un tema contado con sellos de cualquier país.', 'museopostal' ), false ),
);
?>
<!-- wp:group {"tagName":"section","className":"mp-puertas","templateLock":"contentOnly","align":"wide","layout":{"type":"default"}} -->
<section class="wp-block-group alignwide mp-puertas">
<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Las salas', 'museopostal' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"mp-puertas__rejilla","layout":{"type":"grid","minimumColumnWidth":"13rem"}} -->
<div class="wp-block-group mp-puertas__rejilla">
<?php foreach ( $museopostal_salas as $museopostal_sala ) : ?>
<!-- wp:group {"className":"is-style-tarjeta<?php echo $museopostal_sala[3] ? ' mp-puertas__central' : ''; ?>","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-tarjeta<?php echo $museopostal_sala[3] ? ' mp-puertas__central' : ''; ?>">
	<?php if ( $museopostal_sala[3] ) : ?>
<!-- wp:paragraph {"className":"mp-puertas__etiqueta"} -->
<p class="mp-puertas__etiqueta"><?php esc_html_e( 'Sala central', 'museopostal' ); ?></p>
<!-- /wp:paragraph -->
	<?php endif; ?>
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><a href="<?php echo esc_url( home_url( '/sala/' . $museopostal_sala[0] . '/' ) ); ?>"><?php echo esc_html( $museopostal_sala[1] ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $museopostal_sala[2] ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
