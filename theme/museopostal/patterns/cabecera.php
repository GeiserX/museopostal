<?php
/**
 * Title: Cabecera
 * Slug: museopostal/cabecera
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: no
 * Description: Logo (o nombre), lema, menú de cinco entradas y buscador visible también en móvil (§4.1, §6.4).
 *
 * Es un patrón PHP y no HTML fijo para que los enlaces salgan de home_url():
 * así funcionan igual en museopostal.org, en el clon de pruebas y en Playground.
 *
 * @package museopostal
 */

$museopostal_enlace = static function ( string $texto, string $ruta, bool $arriba = false ): string {
	$atributos = array(
		'label' => $texto,
		'url'   => home_url( $ruta ),
		'kind'  => 'custom',
	);
	if ( $arriba ) {
		$atributos['isTopLevelLink'] = true;
	}
	return '<!-- wp:navigation-link ' . serialize_block_attributes( $atributos ) . ' /-->';
};

$museopostal_submenu = static function ( string $texto, string $ruta, array $hijos ) use ( $museopostal_enlace ): string {
	$atributos = array(
		'label' => $texto,
		'url'   => home_url( $ruta ),
		'kind'  => 'custom',
	);
	$html = '<!-- wp:navigation-submenu ' . serialize_block_attributes( $atributos ) . ' -->';
	foreach ( $hijos as $hijo ) {
		$html .= $museopostal_enlace( $hijo[0], $hijo[1] );
	}
	return $html . '<!-- /wp:navigation-submenu -->';
};

// El logo horizontal que elige la variación activa (settings.custom.logo), en
// línea para que siga sus colores. Si no hay, el nombre del sitio en texto.
$museopostal_logo = sanitize_key( (string) wp_get_global_settings( array( 'custom', 'logo' ) ) );
$museopostal_svg  = '';
if ( '' !== $museopostal_logo && is_readable( get_theme_file_path( 'assets/logo/' . $museopostal_logo . '-horizontal.svg' ) ) ) {
	$museopostal_svg = (string) file_get_contents( get_theme_file_path( 'assets/logo/' . $museopostal_logo . '-horizontal.svg' ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- fichero del propio tema.
}
?>
<!-- wp:group {"className":"mp-cabecera","layout":{"type":"constrained"}} -->
<div class="wp-block-group mp-cabecera">
<!-- wp:group {"align":"wide","className":"mp-cabecera__fila","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide mp-cabecera__fila">
<!-- wp:group {"className":"mp-marca","layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group mp-marca">
<?php if ( '' !== $museopostal_svg ) : ?>
<!-- wp:html -->
<a class="mp-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo $museopostal_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG del propio tema. ?></a>
<!-- /wp:html -->
<?php else : ?>
<!-- wp:site-title {"level":0} /-->
<?php endif; ?>
<!-- wp:site-tagline /-->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"mp-cabecera__acciones","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group mp-cabecera__acciones">
<!-- wp:navigation {"overlayMenu":"mobile","ariaLabel":"<?php echo esc_attr__( 'Menú principal', 'museopostal' ); ?>","layout":{"type":"flex","flexWrap":"wrap"}} -->
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped -- markup de bloques generado arriba con serialize_block_attributes().
echo $museopostal_submenu(
	__( 'Salas', 'museopostal' ),
	'/salas/',
	array(
		array( __( 'Todas las salas', 'museopostal' ), '/salas/' ),
		array( __( 'Antes del sello', 'museopostal' ), '/sala/antes-del-sello/' ),
		array( __( 'La Región de Murcia', 'museopostal' ), '/sala/region-de-murcia/' ),
		array( __( 'Correo en guerra', 'museopostal' ), '/sala/correo-en-guerra/' ),
		array( __( 'El correo en la pintura', 'museopostal' ), '/sala/el-correo-en-la-pintura/' ),
		array( __( 'Sellos que cuentan el mundo', 'museopostal' ), '/sala/sellos-que-cuentan-el-mundo/' ),
	)
);
echo $museopostal_submenu(
	__( 'Colección', 'museopostal' ),
	'/coleccion/',
	array(
		array( __( 'Explorar la colección', 'museopostal' ), '/coleccion/' ),
		array( __( 'Por época', 'museopostal' ), '/coleccion/#por-epoca' ),
		array( __( 'Por lugar', 'museopostal' ), '/coleccion/#por-lugar' ),
		array( __( 'Por tipo de pieza', 'museopostal' ), '/coleccion/#por-tipo' ),
		array( __( 'Identifica tu pieza', 'museopostal' ), '/coleccion/identifica-tu-pieza/' ),
		array( __( 'Comparte tu pieza', 'museopostal' ), '/coleccion/comparte-tu-pieza/' ),
		array( __( 'Glosario', 'museopostal' ), '/coleccion/glosario/' ),
	)
);
echo $museopostal_enlace( __( 'Aula', 'museopostal' ), '/aula/', true );
echo $museopostal_submenu(
	__( 'Investigación', 'museopostal' ),
	'/investigacion/',
	array(
		array( __( 'Artículos', 'museopostal' ), '/articulos/' ),
		array( __( 'Videoteca', 'museopostal' ), '/investigacion/videoteca/' ),
		array( __( 'Biblioteca', 'museopostal' ), '/investigacion/biblioteca/' ),
		array( __( 'Museos postales del mundo', 'museopostal' ), '/investigacion/museos-postales-del-mundo/' ),
	)
);
echo $museopostal_submenu(
	__( 'El museo', 'museopostal' ),
	'/el-museo/',
	array(
		array( __( 'Quiénes somos', 'museopostal' ), '/el-museo/' ),
		array( __( 'Publicaciones', 'museopostal' ), '/el-museo/publicaciones/' ),
		array( __( 'Contacto', 'museopostal' ), '/contacto/' ),
		array( __( 'Accesibilidad', 'museopostal' ), '/el-museo/accesibilidad/' ),
		array( __( 'Créditos y licencias', 'museopostal' ), '/el-museo/creditos-y-licencias/' ),
		array( __( 'Cómo citar', 'museopostal' ), '/el-museo/como-citar/' ),
	)
);
// phpcs:enable
?>
<!-- /wp:navigation -->

<!-- wp:search {"label":"<?php echo esc_attr__( 'Buscar en el museo', 'museopostal' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Buscar: Edifil, lugar, tema…', 'museopostal' ); ?>","buttonText":"<?php echo esc_attr__( 'Buscar', 'museopostal' ); ?>","className":"mp-buscador"} /-->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
