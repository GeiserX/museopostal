<?php
/**
 * Bloques dinámicos del museo, registrados solo en PHP (§8.2).
 *
 * Con 'autoRegister' el editor los muestra sin JavaScript compilado y los
 * pinta con ServerSideRender. En el sitio, todo sale como HTML del servidor.
 *
 * @package museopostal-coleccion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra los seis bloques.
 */
function museopostal_coleccion_registrar_bloques(): void {
	$comunes = array(
		'api_version' => 3,
		'category'    => 'widgets',
		'supports'    => array(
			'autoRegister' => true,
			'html'         => false,
		),
	);

	register_block_type(
		'museopostal/datos-pieza',
		array_merge(
			$comunes,
			array(
				'title'           => __( 'Datos de la pieza', 'museopostal-coleccion' ),
				'description'     => __( 'Imágenes, datos clave, todos los datos, cita o puntos anotados de una pieza.', 'museopostal-coleccion' ),
				'icon'            => 'id-alt',
				'attributes'      => array(
					'vista'   => array(
						'type'    => 'string',
						'enum'    => array( 'clave', 'ficha', 'imagenes', 'cita', 'anotaciones' ),
						'default' => 'ficha',
					),
					'piezaId' => array(
						'type'    => 'integer',
						'default' => 0,
						'role'    => 'content',
					),
				),
				'uses_context'    => array( 'postId', 'postType' ),
				'render_callback' => 'museopostal_coleccion_render_datos_pieza',
			)
		)
	);

	register_block_type(
		'museopostal/video',
		array_merge(
			$comunes,
			array(
				'title'           => __( 'Vídeo sin rastreo', 'museopostal-coleccion' ),
				'description'     => __( 'Vídeo de YouTube que solo se carga (desde youtube-nocookie.com) cuando el visitante pulsa.', 'museopostal-coleccion' ),
				'icon'            => 'video-alt3',
				'attributes'      => array(
					'url'    => array(
						'type'    => 'string',
						'default' => '',
						'role'    => 'content',
					),
					'titulo' => array(
						'type'    => 'string',
						'default' => '',
						'role'    => 'content',
					),
					'poster' => array(
						'type'    => 'integer',
						'default' => 0,
						'role'    => 'content',
					),
				),
				'render_callback' => 'museopostal_coleccion_render_video',
			)
		)
	);

	register_block_type(
		'museopostal/cifras',
		array_merge(
			$comunes,
			array(
				'title'           => __( 'Cifras de la colección', 'museopostal-coleccion' ),
				'description'     => __( 'Piezas y salas publicadas.', 'museopostal-coleccion' ),
				'icon'            => 'chart-bar',
				'render_callback' => 'museopostal_coleccion_render_cifras',
			)
		)
	);

	register_block_type(
		'museopostal/efemeride',
		array_merge(
			$comunes,
			array(
				'title'           => __( 'Efeméride del día', 'museopostal-coleccion' ),
				'description'     => __( 'La pieza cuyo día y mes coinciden con hoy o, si no hay, la próxima.', 'museopostal-coleccion' ),
				'icon'            => 'calendar-alt',
				'render_callback' => 'museopostal_coleccion_render_efemeride',
			)
		)
	);

	register_block_type(
		'museopostal/sala-cabecera',
		array_merge(
			$comunes,
			array(
				'title'           => __( 'Cabecera de la sala', 'museopostal-coleccion' ),
				'description'     => __( 'La imagen de cabecera de la sala que se está viendo (metadato mp_sala_cabecera_id del término).', 'museopostal-coleccion' ),
				'icon'            => 'format-image',
				'render_callback' => 'museopostal_coleccion_render_sala_cabecera',
			)
		)
	);

	register_block_type(
		'museopostal/pieza-al-azar',
		array_merge(
			$comunes,
			array(
				'title'           => __( 'Una pieza al azar', 'museopostal-coleccion' ),
				'description'     => __( 'Enlace que lleva a una pieza distinta cada vez, sin JavaScript.', 'museopostal-coleccion' ),
				'icon'            => 'randomize',
				'attributes'      => array(
					'texto' => array(
						'type'    => 'string',
						'default' => '',
						'role'    => 'content',
					),
				),
				'render_callback' => 'museopostal_coleccion_render_pieza_al_azar',
			)
		)
	);
}
add_action( 'init', 'museopostal_coleccion_registrar_bloques' );

/* ------------------------------------------------------------------ */
/* Utilidades                                                          */
/* ------------------------------------------------------------------ */

/**
 * «1866-06-18» → «18 de junio de 1866»; «1866-06» → «junio de 1866»; «1866» → «1866».
 *
 * @param string $fecha Fecha en AAAA-MM-DD, AAAA-MM o AAAA.
 */
function museopostal_coleccion_fecha_legible( string $fecha ): string {
	$meses = array( '', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' );
	if ( ! preg_match( '/^(\d{4})(?:-(\d{2}))?(?:-(\d{2}))?$/', trim( $fecha ), $m ) ) {
		return $fecha;
	}
	$mes = isset( $m[2] ) ? (int) $m[2] : 0;
	$dia = isset( $m[3] ) ? (int) $m[3] : 0;
	if ( $mes < 1 || $mes > 12 ) {
		return $m[1];
	}
	if ( $dia < 1 ) {
		/* translators: 1: mes, 2: año. */
		return sprintf( __( '%1$s de %2$s', 'museopostal-coleccion' ), $meses[ $mes ], $m[1] );
	}
	/* translators: 1: día, 2: mes, 3: año. */
	return sprintf( __( '%1$d de %2$s de %3$s', 'museopostal-coleccion' ), $dia, $meses[ $mes ], $m[1] );
}

/**
 * La pieza que pinta un bloque: la elegida en el bloque, la del contexto o la actual.
 *
 * @param array<string, mixed> $atributos Atributos del bloque.
 * @param WP_Block|null        $bloque    Bloque.
 */
function museopostal_coleccion_pieza_del_bloque( array $atributos, ?WP_Block $bloque ): ?WP_Post {
	$id = (int) ( $atributos['piezaId'] ?? 0 );
	if ( ! $id && $bloque && ! empty( $bloque->context['postId'] ) ) {
		$id = (int) $bloque->context['postId'];
	}
	if ( ! $id ) {
		$id = (int) get_the_ID();
	}
	$post = $id ? get_post( $id ) : null;
	return ( $post instanceof WP_Post && 'pieza' === $post->post_type ) ? $post : null;
}

/**
 * Grupo de la ficha que corresponde al tipo de pieza: B, C, D o ''.
 *
 * @param int $id ID de la pieza.
 */
function museopostal_coleccion_grupo_de_pieza( int $id ): string {
	$grupos = array(
		'B' => array( 'sello', 'serie', 'hoja-bloque', 'pliego-minipliego', 'spd', 'tarjeta-maxima', 'entero-postal' ),
		'C' => array( 'carta-sobre', 'tarjeta-postal', 'tarjeta-de-campana', 'matasellos-marca', 'documento' ),
		'D' => array( 'pintura', 'objeto', 'publicacion' ),
	);
	$tipos = wp_get_post_terms( $id, 'tipo', array( 'fields' => 'slugs' ) );
	if ( is_wp_error( $tipos ) ) {
		return '';
	}
	foreach ( $grupos as $grupo => $slugs ) {
		if ( array_intersect( $slugs, $tipos ) ) {
			return $grupo;
		}
	}
	return '';
}

/**
 * Valor de un campo listo para imprimir como HTML (ya escapado). '' si está vacío.
 *
 * @param string $clave Clave del metadato.
 * @param int    $id    ID de la pieza.
 */
function museopostal_coleccion_valor_html( string $clave, int $id ): string {
	$campos = museopostal_coleccion_campos();
	$campo  = $campos[ $clave ] ?? array( 'tipo' => 'texto' );
	$valor  = get_post_meta( $id, $clave, true );
	if ( '' === $valor || null === $valor || 0 === $valor || '0' === $valor ) {
		return '';
	}
	$valor = (string) $valor;

	switch ( $clave ) {
		case 'mp_fecha':
			return esc_html( museopostal_coleccion_fecha_legible( $valor ) );
		case 'mp_relacionadas':
		case 'mp_articulo_id':
			$enlaces = array();
			foreach ( array_filter( array_map( 'absint', explode( ',', $valor ) ) ) as $otro ) {
				if ( 'publish' === get_post_status( $otro ) ) {
					$enlaces[] = sprintf( '<a href="%s">%s</a>', esc_url( (string) get_permalink( $otro ) ), esc_html( get_the_title( $otro ) ) );
				}
			}
			return implode( ', ', $enlaces );
	}

	switch ( $campo['tipo'] ) {
		case 'enum':
			return esc_html( $campo['opciones'][ $valor ] ?? $valor );
		case 'enum-multiple':
			$textos = array_map( static fn( string $v ): string => $campo['opciones'][ $v ] ?? $v, explode( ',', $valor ) );
			return esc_html( implode( ', ', $textos ) );
		case 'url':
			return sprintf( '<a href="%1$s">%2$s</a>', esc_url( $valor ), esc_html( wp_parse_url( $valor, PHP_URL_HOST ) ?: $valor ) );
		case 'multilinea':
			$lineas = array_filter( array_map( 'trim', explode( "\n", $valor ) ) );
			if ( count( $lineas ) < 2 ) {
				return esc_html( implode( '', $lineas ) );
			}
			return '<ul><li>' . implode( '</li><li>', array_map( 'esc_html', $lineas ) ) . '</li></ul>';
		default:
			return esc_html( $valor );
	}
}

/**
 * Lista <dl> con las claves dadas que tengan valor.
 *
 * @param string[] $claves Claves de metadatos.
 * @param int      $id     ID de la pieza.
 */
function museopostal_coleccion_dl( array $claves, int $id, string $clase = '' ): string {
	$campos = museopostal_coleccion_campos();
	$filas  = '';
	foreach ( $claves as $clave ) {
		$html = museopostal_coleccion_valor_html( $clave, $id );
		if ( '' !== $html ) {
			$filas .= sprintf( '<dt>%s</dt><dd>%s</dd>', esc_html( $campos[ $clave ]['etiqueta'] ), $html );
		}
	}
	return '' === $filas ? '' : sprintf( '<dl class="%s">%s</dl>', esc_attr( trim( 'mp-datos ' . $clase ) ), $filas );
}

/**
 * <img> de un adjunto con alt garantizado.
 *
 * @param int                  $adjunto  ID del adjunto.
 * @param string               $respaldo Alt si el adjunto no tiene.
 * @param array<string, mixed> $extra    Atributos extra.
 */
function museopostal_coleccion_img( int $adjunto, string $respaldo, array $extra = array() ): string {
	$alt = trim( (string) get_post_meta( $adjunto, '_wp_attachment_image_alt', true ) );
	return wp_get_attachment_image( $adjunto, 'large', false, array_merge( array( 'alt' => '' === $alt ? $respaldo : $alt ), $extra ) );
}

/* ------------------------------------------------------------------ */
/* museopostal/datos-pieza                                             */
/* ------------------------------------------------------------------ */

/**
 * Pinta la vista pedida de la ficha de una pieza.
 *
 * @param array<string, mixed> $atributos Atributos.
 * @param string               $contenido Contenido interior (vacío).
 * @param WP_Block|null        $bloque    Bloque.
 */
function museopostal_coleccion_render_datos_pieza( array $atributos, string $contenido = '', ?WP_Block $bloque = null ): string {
	$pieza = museopostal_coleccion_pieza_del_bloque( $atributos, $bloque );
	if ( ! $pieza ) {
		return '';
	}
	$id    = $pieza->ID;
	$vista = (string) ( $atributos['vista'] ?? 'ficha' );

	switch ( $vista ) {
		case 'clave':
			$html = museopostal_coleccion_datos_clave( $id );
			break;
		case 'imagenes':
			$html = museopostal_coleccion_imagenes( $pieza );
			break;
		case 'cita':
			$html = museopostal_coleccion_cita( $pieza );
			break;
		case 'anotaciones':
			$html = museopostal_coleccion_anotaciones( $pieza );
			break;
		default:
			$html = museopostal_coleccion_todos_los_datos( $id );
	}
	if ( '' === $html ) {
		return '';
	}
	$envoltorio = get_block_wrapper_attributes( array( 'class' => 'mp-vista-' . sanitize_html_class( $vista ) ) );
	return sprintf( '<div %1$s>%2$s</div>', $envoltorio, $html );
}

/**
 * Los cuatro datos clave según el tipo de pieza (patrón 9 de 02).
 *
 * @param int $id ID de la pieza.
 */
function museopostal_coleccion_datos_clave( int $id ): string {
	$por_grupo = array(
		'B' => array( 'mp_inventario', 'mp_fecha', 'mp_catalogo', 'mp_valor_facial' ),
		'C' => array( 'mp_inventario', 'mp_fecha', 'mp_origen', 'mp_destino' ),
		'D' => array( 'mp_inventario', 'mp_fecha', 'mp_autor', 'mp_institucion' ),
	);
	$preferidas = $por_grupo[ museopostal_coleccion_grupo_de_pieza( $id ) ] ?? array( 'mp_inventario', 'mp_fecha' );
	$reserva    = array( 'mp_pais', 'mp_formato', 'mp_procedencia', 'mp_estado' );
	$claves     = array();
	foreach ( array_merge( $preferidas, $reserva ) as $clave ) {
		if ( count( $claves ) < 4 && ! in_array( $clave, $claves, true ) && '' !== museopostal_coleccion_valor_html( $clave, $id ) ) {
			$claves[] = $clave;
		}
	}
	return museopostal_coleccion_dl( $claves, $id, 'mp-datos--clave' );
}

/**
 * «Todos los datos», plegados en un <details> y agrupados. Solo los campos rellenos.
 *
 * @param int $id ID de la pieza.
 */
function museopostal_coleccion_todos_los_datos( int $id ): string {
	$ocultos = array( 'mp_reverso_id', 'mp_anotaciones', 'mp_orden_sala' );
	$grupos  = museopostal_coleccion_grupos();
	$cuerpo  = '';
	foreach ( $grupos as $grupo => $titulo ) {
		$claves = array();
		foreach ( museopostal_coleccion_campos() as $clave => $campo ) {
			if ( $campo['grupo'] === $grupo && ! in_array( $clave, $ocultos, true ) ) {
				$claves[] = $clave;
			}
		}
		$dl = museopostal_coleccion_dl( $claves, $id );
		if ( '' !== $dl ) {
			// El título del grupo sin la letra ni el paréntesis: «Emisión», «Circulación»…
			$limpio  = preg_replace( '/^[A-F]\.\s*|\s*\(.*\)$/u', '', $titulo );
			$cuerpo .= sprintf( '<h3>%s</h3>%s', esc_html( (string) $limpio ), $dl );
		}
	}
	if ( '' === $cuerpo ) {
		return '';
	}
	return sprintf(
		'<details class="mp-datos"><summary>%s</summary>%s</details>',
		esc_html__( 'Todos los datos', 'museopostal-coleccion' ),
		$cuerpo
	);
}

/**
 * Anverso y reverso sobre su montura, con enlace al original y la licencia.
 *
 * @param WP_Post $pieza Pieza.
 */
function museopostal_coleccion_imagenes( WP_Post $pieza ): string {
	$titulo  = get_the_title( $pieza );
	$anverso = (int) get_post_thumbnail_id( $pieza );
	$reverso = (int) get_post_meta( $pieza->ID, 'mp_reverso_id', true );
	$caras   = array();
	if ( $anverso ) {
		/* translators: %s: título de la pieza. */
		$caras['anverso'] = array( $anverso, __( 'Anverso', 'museopostal-coleccion' ), sprintf( __( 'Anverso de %s', 'museopostal-coleccion' ), $titulo ) );
	}
	if ( $reverso && wp_attachment_is_image( $reverso ) ) {
		/* translators: %s: título de la pieza. */
		$caras['reverso'] = array( $reverso, __( 'Reverso', 'museopostal-coleccion' ), sprintf( __( 'Reverso de %s', 'museopostal-coleccion' ), $titulo ) );
	}
	if ( ! $caras ) {
		return '';
	}

	$html = '';
	if ( count( $caras ) > 1 ) {
		$html .= '<ul class="mp-imagenes__nav">';
		foreach ( $caras as $cara => $datos ) {
			$html .= sprintf( '<li><a href="#mp-%1$s">%2$s</a></li>', esc_attr( $cara ), esc_html( $datos[1] ) );
		}
		$html .= '</ul>';
	}

	$html .= '<div class="mp-imagenes__lista">';
	$primera = true;
	foreach ( $caras as $cara => list( $adjunto, $nombre, $alt ) ) {
		$extra = $primera ? array(
			'fetchpriority' => 'high',
			'loading'       => false,
		) : array();
		$html .= sprintf(
			'<figure class="mp-montura" id="mp-%1$s">%2$s<figcaption>%3$s · <a href="%4$s">%5$s</a></figcaption></figure>',
			esc_attr( $cara ),
			museopostal_coleccion_img( $adjunto, $alt, $extra ),
			esc_html( $nombre ),
			esc_url( (string) wp_get_attachment_url( $adjunto ) ),
			esc_html__( 'ver a tamaño completo', 'museopostal-coleccion' )
		);
		$primera = false;
	}
	$html .= '</div>';

	$derechos = (string) get_post_meta( $pieza->ID, 'mp_derechos', true );
	$campos   = museopostal_coleccion_campos();
	$licencia = $campos['mp_derechos']['opciones'][ $derechos ] ?? '';
	$credito  = (string) get_post_meta( $pieza->ID, 'mp_credito', true );
	$partes   = array();
	if ( '' !== $credito ) {
		/* translators: %s: crédito de la imagen. */
		$partes[] = esc_html( sprintf( __( 'Imagen: %s.', 'museopostal-coleccion' ), $credito ) );
	}
	if ( '' !== $licencia ) {
		$partes[] = esc_html( $licencia . '.' );
	}
	if ( $anverso && in_array( $derechos, array( 'cc-by-sa-4.0', 'cc-by-nc-4.0', 'dominio-publico' ), true ) ) {
		$partes[] = sprintf( '<a href="%s" download>%s</a>', esc_url( (string) wp_get_attachment_url( $anverso ) ), esc_html__( 'Descargar la imagen', 'museopostal-coleccion' ) );
	}
	if ( $partes ) {
		$html .= '<p class="mp-licencia">' . implode( ' ', $partes ) . '</p>';
	}
	return '<div class="mp-imagenes">' . $html . '</div>';
}

/**
 * «Cómo citar esta pieza» (patrón 12 de 02).
 *
 * @param WP_Post $pieza Pieza.
 */
function museopostal_coleccion_cita( WP_Post $pieza ): string {
	$inventario = (string) get_post_meta( $pieza->ID, 'mp_inventario', true );
	$url        = (string) get_permalink( $pieza );
	$texto      = sprintf(
		'«%1$s». %2$s%3$s. <a href="%4$s">%5$s</a>, %6$s %7$s.',
		esc_html( get_the_title( $pieza ) ),
		esc_html__( 'Museo Postal y Filatélico de la Región de Murcia', 'museopostal-coleccion' ),
		'' === $inventario ? '' : esc_html( ', n.º ' . $inventario ),
		esc_url( $url ),
		esc_html( $url ),
		esc_html__( 'consultado el', 'museopostal-coleccion' ),
		esc_html( museopostal_coleccion_fecha_legible( current_datetime()->format( 'Y-m-d' ) ) )
	);
	return sprintf( '<p class="mp-cita"><strong>%s</strong> %s</p>', esc_html__( 'Cómo citar esta pieza:', 'museopostal-coleccion' ), $texto );
}

/**
 * Anverso con puntos numerados y su leyenda, para las fichas del Aula.
 *
 * @param WP_Post $pieza Pieza.
 */
function museopostal_coleccion_anotaciones( WP_Post $pieza ): string {
	$anverso = (int) get_post_thumbnail_id( $pieza );
	if ( ! $anverso ) {
		return '';
	}
	$puntos = json_decode( (string) get_post_meta( $pieza->ID, 'mp_anotaciones', true ), true );
	$puntos = is_array( $puntos ) ? $puntos : array();

	$marcas  = '';
	$leyenda = '';
	foreach ( $puntos as $punto ) {
		if ( ! isset( $punto['n'], $punto['x'], $punto['y'], $punto['texto'] ) ) {
			continue;
		}
		$x        = min( 100, max( 0, (float) $punto['x'] ) );
		$y        = min( 100, max( 0, (float) $punto['y'] ) );
		$marcas  .= sprintf( '<span class="mp-anotada__punto" style="left:%1$s%%;top:%2$s%%" aria-hidden="true">%3$d</span>', esc_attr( (string) $x ), esc_attr( (string) $y ), (int) $punto['n'] );
		$leyenda .= sprintf( '<li value="%1$d">%2$s</li>', (int) $punto['n'], esc_html( (string) $punto['texto'] ) );
	}
	/* translators: %s: título de la pieza. */
	$alt  = sprintf( __( 'Anverso de %s', 'museopostal-coleccion' ), get_the_title( $pieza ) );
	$html = sprintf(
		'<figure class="mp-anotada mp-montura"><div class="mp-anotada__lienzo">%1$s%2$s</div><figcaption><a href="%3$s">%4$s</a></figcaption></figure>',
		museopostal_coleccion_img( $anverso, $alt ),
		$marcas,
		esc_url( (string) get_permalink( $pieza ) ),
		esc_html( get_the_title( $pieza ) )
	);
	if ( '' !== $leyenda ) {
		$html .= '<ol class="mp-anotada__leyenda">' . $leyenda . '</ol>';
	}
	return $html;
}

/* ------------------------------------------------------------------ */
/* museopostal/video                                                   */
/* ------------------------------------------------------------------ */

/**
 * Identificador de un vídeo de YouTube a partir de su URL.
 *
 * @param string $url URL del vídeo.
 */
function museopostal_coleccion_id_youtube( string $url ): string {
	if ( preg_match( '~(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~', $url, $m ) ) {
		return $m[1];
	}
	return '';
}

/**
 * Fachada de clic: sin JavaScript es un enlace al reproductor de
 * youtube-nocookie.com; con JavaScript, el clic lo incrusta en la página.
 * Nada se pide a YouTube (ni la miniatura) hasta que el visitante pulsa.
 *
 * @param array<string, mixed> $atributos Atributos.
 */
function museopostal_coleccion_render_video( array $atributos ): string {
	$url    = (string) ( $atributos['url'] ?? '' );
	$titulo = trim( (string) ( $atributos['titulo'] ?? '' ) );
	$id     = museopostal_coleccion_id_youtube( $url );
	if ( '' === $id ) {
		return '' === $url ? '' : sprintf( '<p %1$s><a href="%2$s">%3$s</a></p>', get_block_wrapper_attributes(), esc_url( $url ), esc_html( '' === $titulo ? $url : $titulo ) );
	}

	wp_enqueue_script(
		'museopostal-video',
		plugins_url( 'assets/video.js', MUSEOPOSTAL_COLECCION_ARCHIVO ),
		array(),
		MUSEOPOSTAL_COLECCION_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	$poster = (int) ( $atributos['poster'] ?? 0 );
	$imagen = $poster ? wp_get_attachment_image( $poster, 'large', false, array( 'alt' => '' ) ) : '';
	$nombre = '' === $titulo ? __( 'Ver el vídeo', 'museopostal-coleccion' ) : sprintf( /* translators: %s: título. */ __( 'Ver el vídeo «%s»', 'museopostal-coleccion' ), $titulo );

	return sprintf(
		'<figure %1$s><a class="mp-video__fachada" href="%2$s" data-mp-video="%3$s" data-mp-titulo="%4$s">%5$s<span>▶ %6$s</span></a><figcaption>%7$s</figcaption></figure>',
		get_block_wrapper_attributes( array( 'class' => 'mp-video' ) ),
		esc_url( 'https://www.youtube-nocookie.com/embed/' . $id . '?autoplay=1' ),
		esc_attr( $id ),
		esc_attr( '' === $titulo ? __( 'Vídeo', 'museopostal-coleccion' ) : $titulo ),
		$imagen,
		esc_html( $nombre ),
		esc_html__( 'Al pulsar, el vídeo se carga desde YouTube (youtube-nocookie.com). Antes no se envía nada a terceros.', 'museopostal-coleccion' )
	);
}

/* ------------------------------------------------------------------ */
/* museopostal/cifras                                                  */
/* ------------------------------------------------------------------ */

/**
 * «142 piezas · 5 salas»: piezas publicadas y salas con alguna pieza.
 */
function museopostal_coleccion_render_cifras(): string {
	$piezas = (int) ( wp_count_posts( 'pieza' )->publish ?? 0 );
	$salas  = get_terms(
		array(
			'taxonomy'   => 'sala',
			'hide_empty' => true,
			'fields'     => 'ids',
		)
	);
	$salas  = is_array( $salas ) ? count( $salas ) : 0;
	return sprintf(
		'<p %1$s><strong>%2$s</strong> %3$s · <strong>%4$s</strong> %5$s</p>',
		get_block_wrapper_attributes( array( 'class' => 'mp-cifras' ) ),
		esc_html( number_format_i18n( $piezas ) ),
		esc_html( _n( 'pieza', 'piezas', $piezas, 'museopostal-coleccion' ) ),
		esc_html( number_format_i18n( $salas ) ),
		esc_html( _n( 'sala', 'salas', $salas, 'museopostal-coleccion' ) )
	);
}

/* ------------------------------------------------------------------ */
/* museopostal/efemeride                                               */
/* ------------------------------------------------------------------ */

/**
 * La pieza del día: misma fecha (día y mes) que hoy o, si no hay, la próxima.
 *
 * @return array{0: int, 1: bool}|null ID de la pieza y si es de hoy.
 */
function museopostal_coleccion_pieza_efemeride(): ?array {
	$ids = get_posts(
		array(
			'post_type'      => 'pieza',
			'post_status'    => 'publish',
			'posts_per_page' => 1000,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'orderby'        => 'ID',
			'order'          => 'ASC',
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_query_meta_key -- solo piezas con fecha.
			'meta_key'       => 'mp_fecha',
		)
	);
	if ( ! $ids ) {
		return null;
	}
	update_meta_cache( 'post', $ids );

	$hoy    = current_datetime()->setTime( 0, 0 );
	$mejor  = null;
	$margen = PHP_INT_MAX;
	foreach ( $ids as $id ) {
		if ( ! preg_match( '/^\d{4}-(\d{2})-(\d{2})$/', (string) get_post_meta( $id, 'mp_fecha', true ), $m ) || ! checkdate( (int) $m[1], (int) $m[2], 2000 ) ) {
			continue;
		}
		$anio        = (int) $hoy->format( 'Y' );
		$aniversario = museopostal_coleccion_aniversario( $anio, (int) $m[1], (int) $m[2] );
		if ( $aniversario < $hoy ) {
			$aniversario = museopostal_coleccion_aniversario( $anio + 1, (int) $m[1], (int) $m[2] );
		}
		$dias = (int) $hoy->diff( $aniversario )->days;
		if ( $dias < $margen ) {
			$margen = $dias;
			$mejor  = $id;
		}
	}
	return null === $mejor ? null : array( $mejor, 0 === $margen );
}

/**
 * Fecha del aniversario en un año dado; el 29 de febrero cae el 28 en años no bisiestos.
 *
 * @param int $anio Año.
 * @param int $mes Mes.
 * @param int $dia Día.
 */
function museopostal_coleccion_aniversario( int $anio, int $mes, int $dia ): DateTimeImmutable {
	if ( 2 === $mes && 29 === $dia && ! checkdate( 2, 29, $anio ) ) {
		$dia = 28;
	}
	return current_datetime()->setDate( $anio, $mes, $dia )->setTime( 0, 0 );
}

/**
 * Pinta la efeméride.
 */
function museopostal_coleccion_render_efemeride(): string {
	$efemeride = museopostal_coleccion_pieza_efemeride();
	if ( ! $efemeride ) {
		return '';
	}
	list( $id, $es_hoy ) = $efemeride;
	$titulo              = get_the_title( $id );
	$enlace              = (string) get_permalink( $id );
	$anverso             = (int) get_post_thumbnail_id( $id );
	$imagen              = $anverso ? sprintf( '<figure class="mp-montura"><a href="%1$s">%2$s</a></figure>', esc_url( $enlace ), museopostal_coleccion_img( $anverso, $titulo ) ) : '';

	return sprintf(
		'<div %1$s><h2>%2$s</h2><p class="mp-efemeride__fecha">%3$s</p>%4$s<h3><a href="%5$s">%6$s</a></h3>%7$s</div>',
		get_block_wrapper_attributes( array( 'class' => 'mp-efemeride' ) ),
		esc_html( $es_hoy ? __( 'Tal día como hoy', 'museopostal-coleccion' ) : __( 'Próxima efeméride', 'museopostal-coleccion' ) ),
		esc_html( museopostal_coleccion_fecha_legible( (string) get_post_meta( $id, 'mp_fecha', true ) ) ),
		$imagen,
		esc_url( $enlace ),
		esc_html( $titulo ),
		has_excerpt( $id ) ? '<p>' . esc_html( get_the_excerpt( $id ) ) . '</p>' : ''
	);
}

/* ------------------------------------------------------------------ */
/* museopostal/sala-cabecera                                           */
/* ------------------------------------------------------------------ */

/**
 * Imagen de cabecera de la sala que se está viendo: un detalle macro de una
 * pieza real (02 patrón 19), a sangre. Sin sala o sin imagen no pinta nada.
 */
function museopostal_coleccion_render_sala_cabecera(): string {
	$termino = get_queried_object();
	if ( ! $termino instanceof WP_Term || 'sala' !== $termino->taxonomy ) {
		return '';
	}
	$adjunto = (int) get_term_meta( $termino->term_id, 'mp_sala_cabecera_id', true );
	if ( ! $adjunto || ! wp_attachment_is_image( $adjunto ) ) {
		return '';
	}
	$imagen = wp_get_attachment_image(
		$adjunto,
		'full',
		false,
		array(
			'loading'       => false,
			'fetchpriority' => 'high',
		)
	);
	if ( '' === $imagen ) {
		return '';
	}
	return sprintf(
		'<figure %1$s>%2$s</figure>',
		get_block_wrapper_attributes( array( 'class' => 'mp-sala-cabecera alignfull' ) ),
		$imagen
	);
}

/* ------------------------------------------------------------------ */
/* museopostal/pieza-al-azar                                           */
/* ------------------------------------------------------------------ */

/**
 * Enlace a /?pieza-al-azar, que redirige (302) a una pieza cualquiera.
 *
 * @param array<string, mixed> $atributos Atributos.
 */
function museopostal_coleccion_render_pieza_al_azar( array $atributos ): string {
	$texto = trim( (string) ( $atributos['texto'] ?? '' ) );
	return sprintf(
		'<p %1$s><a href="%2$s" rel="nofollow">%3$s</a></p>',
		get_block_wrapper_attributes( array( 'class' => 'mp-pieza-al-azar' ) ),
		esc_url( add_query_arg( 'pieza-al-azar', '', home_url( '/' ) ) ),
		esc_html( '' === $texto ? __( 'Una pieza al azar', 'museopostal-coleccion' ) : $texto )
	);
}

/**
 * Atiende /?pieza-al-azar: 302 a una pieza publicada, sin caché (crítica n.º 24).
 */
function museopostal_coleccion_redirigir_al_azar(): void {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- enlace público sin efectos.
	if ( ! isset( $_GET['pieza-al-azar'] ) ) {
		return;
	}
	$ids     = get_posts(
		array(
			'post_type'      => 'pieza',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'orderby'        => 'rand',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	$destino = $ids ? (string) get_permalink( $ids[0] ) : (string) get_post_type_archive_link( 'pieza' );
	nocache_headers();
	header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
	wp_safe_redirect( $destino, 302, 'museopostal-coleccion' );
	exit;
}
add_action( 'template_redirect', 'museopostal_coleccion_redirigir_al_azar', 1 );
