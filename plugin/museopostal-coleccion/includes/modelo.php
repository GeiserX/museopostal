<?php
/**
 * El modelo del museo (BRIEF §5): el tipo de contenido «pieza», las cinco
 * taxonomías con sus términos iniciales y los metadatos mp_*.
 *
 * @package museopostal-coleccion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Campos de la ficha técnica, en el orden en que se muestran.
 *
 * Una sola definición alimenta el registro de metadatos, la caja
 * «Ficha técnica» del editor y el bloque museopostal/datos-pieza.
 * Tipos: texto, multilinea, url, entero, enum, enum-multiple, json, ids.
 *
 * @return array<string, array<string, mixed>>
 */
function museopostal_coleccion_campos(): array {
	static $campos = null;
	if ( null !== $campos ) {
		return $campos;
	}

	$procedencias = array(
		'coleccion-museo'      => __( 'Colección del museo', 'museopostal-coleccion' ),
		'donacion'             => __( 'Donación', 'museopostal-coleccion' ),
		'prestamo'             => __( 'Préstamo', 'museopostal-coleccion' ),
		'aportacion-visitante' => __( 'Aportación de un visitante', 'museopostal-coleccion' ),
		'imagen-terceros'      => __( 'Imagen de terceros', 'museopostal-coleccion' ),
	);
	$derechos     = array(
		'cc-by-sa-4.0'    => __( 'CC BY-SA 4.0', 'museopostal-coleccion' ),
		'cc-by-nc-4.0'    => __( 'CC BY-NC 4.0', 'museopostal-coleccion' ),
		'dominio-publico' => __( 'Dominio público', 'museopostal-coleccion' ),
		'reservados'      => __( 'Todos los derechos reservados', 'museopostal-coleccion' ),
	);
	$estados      = array(
		'nuevo-sin-fijasellos' => __( 'Nuevo sin fijasellos', 'museopostal-coleccion' ),
		'nuevo-con-fijasellos' => __( 'Nuevo con fijasellos', 'museopostal-coleccion' ),
		'nuevo-sin-goma'       => __( 'Nuevo sin goma', 'museopostal-coleccion' ),
		'usado'                => __( 'Usado', 'museopostal-coleccion' ),
		'pieza-completa'       => __( 'Pieza completa', 'museopostal-coleccion' ),
		'frontal'              => __( 'Frontal', 'museopostal-coleccion' ),
		'fragmento'            => __( 'Fragmento', 'museopostal-coleccion' ),
		'no-aplica'            => __( 'No aplica', 'museopostal-coleccion' ),
	);
	$rutas        = array(
		'terrestre'             => __( 'Terrestre', 'museopostal-coleccion' ),
		'ferrocarril-ambulante' => __( 'Ferrocarril (ambulante)', 'museopostal-coleccion' ),
		'maritimo'              => __( 'Marítimo', 'museopostal-coleccion' ),
		'submarino'             => __( 'Submarino', 'museopostal-coleccion' ),
		'aereo'                 => __( 'Aéreo', 'museopostal-coleccion' ),
		'militar'               => __( 'Militar', 'museopostal-coleccion' ),
	);

	$c = static fn( string $grupo, string $etiqueta, string $tipo = 'texto', array $extra = array() ): array => array_merge(
		array(
			'grupo'    => $grupo,
			'etiqueta' => $etiqueta,
			'tipo'     => $tipo,
		),
		$extra
	);

	$campos = array(
		// A. Identificación.
		'mp_inventario'      => $c( 'A', __( 'Inventario', 'museopostal-coleccion' ), 'texto', array( 'obligatorio' => true, 'ayuda' => __( 'MPF-AAAA-NNN: año de alta y secuencia. Único.', 'museopostal-coleccion' ) ) ),
		'mp_fecha'           => $c( 'A', __( 'Fecha', 'museopostal-coleccion' ), 'texto', array( 'obligatorio' => true, 'ayuda' => __( 'AAAA-MM-DD, AAAA-MM o AAAA. Emisión, circulación o creación.', 'museopostal-coleccion' ) ) ),
		'mp_procedencia'     => $c( 'A', __( 'Procedencia', 'museopostal-coleccion' ), 'enum', array( 'obligatorio' => true, 'opciones' => $procedencias ) ),
		'mp_credito'         => $c( 'A', __( 'Crédito', 'museopostal-coleccion' ) ),
		'mp_derechos'        => $c( 'A', __( 'Licencia de la imagen', 'museopostal-coleccion' ), 'enum', array( 'obligatorio' => true, 'opciones' => $derechos, 'defecto' => 'reservados', 'ayuda' => __( 'Cubre la fotografía o el escaneo. El diseño del sello conserva sus propios derechos.', 'museopostal-coleccion' ) ) ),
		'mp_estado'          => $c( 'A', __( 'Estado de conservación', 'museopostal-coleccion' ), 'enum', array( 'opciones' => $estados ) ),
		'mp_estado_obs'      => $c( 'A', __( 'Observaciones del estado', 'museopostal-coleccion' ) ),
		// B. Emisión.
		'mp_pais'            => $c( 'B', __( 'País y administración', 'museopostal-coleccion' ) ),
		'mp_serie'           => $c( 'B', __( 'Serie', 'museopostal-coleccion' ) ),
		'mp_catalogo'        => $c( 'B', __( 'Catálogo', 'museopostal-coleccion' ), 'texto', array( 'ayuda' => __( 'Con prefijo y separados por «·»; Edifil primero: «Edifil 4870 · Yvert 4590».', 'museopostal-coleccion' ) ) ),
		'mp_valor_facial'    => $c( 'B', __( 'Valor facial', 'museopostal-coleccion' ) ),
		'mp_color'           => $c( 'B', __( 'Color', 'museopostal-coleccion' ) ),
		'mp_formato'         => $c( 'B', __( 'Formato', 'museopostal-coleccion' ) ),
		'mp_dimensiones'     => $c( 'B', __( 'Dimensiones', 'museopostal-coleccion' ) ),
		'mp_dentado'         => $c( 'B', __( 'Dentado', 'museopostal-coleccion' ) ),
		'mp_tecnica'         => $c( 'B', __( 'Técnica', 'museopostal-coleccion' ) ),
		'mp_papel'           => $c( 'B', __( 'Papel', 'museopostal-coleccion' ) ),
		'mp_filigrana'       => $c( 'B', __( 'Filigrana', 'museopostal-coleccion' ) ),
		'mp_diseno'          => $c( 'B', __( 'Diseño', 'museopostal-coleccion' ) ),
		'mp_grabado'         => $c( 'B', __( 'Grabado', 'museopostal-coleccion' ) ),
		'mp_imprenta'        => $c( 'B', __( 'Imprenta', 'museopostal-coleccion' ) ),
		'mp_pliego'          => $c( 'B', __( 'Pliego', 'museopostal-coleccion' ) ),
		'mp_tirada'          => $c( 'B', __( 'Tirada', 'museopostal-coleccion' ) ),
		'mp_variedades'      => $c( 'B', __( 'Variedades', 'museopostal-coleccion' ) ),
		// C. Circulación.
		'mp_origen'          => $c( 'C', __( 'Origen', 'museopostal-coleccion' ) ),
		'mp_destino'         => $c( 'C', __( 'Destino', 'museopostal-coleccion' ) ),
		'mp_ruta'            => $c( 'C', __( 'Ruta', 'museopostal-coleccion' ), 'enum-multiple', array( 'opciones' => $rutas ) ),
		'mp_franqueo'        => $c( 'C', __( 'Franqueo', 'museopostal-coleccion' ) ),
		'mp_tarifa'          => $c( 'C', __( 'Tarifa', 'museopostal-coleccion' ) ),
		'mp_marcas'          => $c( 'C', __( 'Matasellos y marcas', 'museopostal-coleccion' ), 'multilinea', array( 'ayuda' => __( 'Una marca por línea: tipo, texto, color y posición.', 'museopostal-coleccion' ) ) ),
		'mp_censura'         => $c( 'C', __( 'Censura', 'museopostal-coleccion' ) ),
		'mp_transcripcion'   => $c( 'C', __( 'Transcripción', 'museopostal-coleccion' ), 'multilinea', array( 'ayuda' => __( 'Solo si el texto es histórico y público: nunca datos de particulares vivos.', 'museopostal-coleccion' ) ) ),
		// D. Obra externa.
		'mp_autor'           => $c( 'D', __( 'Autor', 'museopostal-coleccion' ) ),
		'mp_titulo_original' => $c( 'D', __( 'Título original', 'museopostal-coleccion' ) ),
		'mp_estilo'          => $c( 'D', __( 'Estilo', 'museopostal-coleccion' ) ),
		'mp_institucion'     => $c( 'D', __( 'Institución', 'museopostal-coleccion' ) ),
		'mp_institucion_url' => $c( 'D', __( 'Ficha en la institución', 'museopostal-coleccion' ), 'url' ),
		// E. Imágenes.
		'mp_reverso_id'      => $c( 'E', __( 'Reverso (ID del adjunto)', 'museopostal-coleccion' ), 'entero' ),
		'mp_anotaciones'     => $c( 'E', __( 'Anotaciones', 'museopostal-coleccion' ), 'json', array( 'ayuda' => __( 'Puntos sobre el anverso para el Aula: [{"n":1,"x":12.5,"y":40,"texto":"Fechador"}], en % del ancho y del alto.', 'museopostal-coleccion' ) ) ),
		// F. Interpretación y relaciones.
		'mp_relacion_murcia' => $c( 'F', __( 'Relación con la Región', 'museopostal-coleccion' ) ),
		'mp_bibliografia'    => $c( 'F', __( 'Bibliografía', 'museopostal-coleccion' ), 'multilinea' ),
		'mp_orden_sala'      => $c( 'F', __( 'Orden en la sala', 'museopostal-coleccion' ), 'entero' ),
		'mp_relacionadas'    => $c( 'F', __( 'Piezas relacionadas (ID separados por comas)', 'museopostal-coleccion' ), 'ids' ),
		'mp_articulo_id'     => $c( 'F', __( 'Artículo que la estudia (ID)', 'museopostal-coleccion' ), 'entero' ),
	);

	return $campos;
}

/**
 * Nombres de los grupos de la ficha.
 *
 * @return array<string, string>
 */
function museopostal_coleccion_grupos(): array {
	return array(
		'A' => __( 'A. Identificación', 'museopostal-coleccion' ),
		'B' => __( 'B. Emisión (sellos, series, hojas bloque, SPD, enteros)', 'museopostal-coleccion' ),
		'C' => __( 'C. Circulación (cartas, tarjetas, marcas, documentos)', 'museopostal-coleccion' ),
		'D' => __( 'D. Obra externa (pinturas, objetos, publicaciones)', 'museopostal-coleccion' ),
		'E' => __( 'E. Imágenes', 'museopostal-coleccion' ),
		'F' => __( 'F. Interpretación y relaciones', 'museopostal-coleccion' ),
	);
}

/**
 * Limpia un valor según el tipo de su campo. Se usa al guardar la caja
 * y como sanitize_callback de la API REST.
 *
 * @param mixed                $valor Valor recibido.
 * @param array<string, mixed> $campo Definición del campo.
 */
function museopostal_coleccion_limpiar( mixed $valor, array $campo ): string|int {
	switch ( $campo['tipo'] ) {
		case 'entero':
			return absint( $valor );
		case 'multilinea':
			return sanitize_textarea_field( (string) $valor );
		case 'url':
			return esc_url_raw( trim( (string) $valor ) );
		case 'enum':
			$valor = sanitize_key( (string) $valor );
			return isset( $campo['opciones'][ $valor ] ) ? $valor : '';
		case 'enum-multiple':
			$lista = is_array( $valor ) ? $valor : explode( ',', (string) $valor );
			$lista = array_map( 'sanitize_key', $lista );
			$lista = array_values( array_intersect( array_keys( $campo['opciones'] ), $lista ) );
			return implode( ',', $lista );
		case 'json':
			$texto = trim( (string) $valor );
			if ( '' === $texto ) {
				return '';
			}
			$datos = json_decode( $texto, true );
			return is_array( $datos ) ? (string) wp_json_encode( $datos, JSON_UNESCAPED_UNICODE ) : '';
		case 'ids':
			$ids = array_filter( array_map( 'absint', explode( ',', (string) $valor ) ) );
			return implode( ',', array_unique( $ids ) );
		default:
			return sanitize_text_field( (string) $valor );
	}
}

/**
 * Registra el tipo de contenido, las taxonomías y los metadatos.
 */
function museopostal_coleccion_registrar_modelo(): void {
	register_post_type(
		'pieza',
		array(
			'labels'        => array(
				'name'               => __( 'Piezas', 'museopostal-coleccion' ),
				'singular_name'      => __( 'Pieza', 'museopostal-coleccion' ),
				'add_new_item'       => __( 'Añadir pieza', 'museopostal-coleccion' ),
				'edit_item'          => __( 'Editar pieza', 'museopostal-coleccion' ),
				'all_items'          => __( 'Todas las piezas', 'museopostal-coleccion' ),
				'search_items'       => __( 'Buscar piezas', 'museopostal-coleccion' ),
				'not_found'          => __( 'No hay piezas.', 'museopostal-coleccion' ),
				'featured_image'     => __( 'Anverso', 'museopostal-coleccion' ),
				'set_featured_image' => __( 'Elegir el anverso', 'museopostal-coleccion' ),
			),
			'public'        => true,
			'show_in_rest'  => true,
			'has_archive'   => 'coleccion',
			'rewrite'       => array(
				'slug'       => 'pieza',
				'with_front' => false,
			),
			'menu_icon'     => 'dashicons-email-alt',
			'menu_position' => 5,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
			'template'      => array( array( 'core/pattern', array( 'slug' => 'museopostal/ficha-pieza' ) ) ),
		)
	);

	$taxonomias = array(
		'sala'  => array( __( 'Salas', 'museopostal-coleccion' ), __( 'Sala', 'museopostal-coleccion' ), true, array( 'pieza' ) ),
		'tipo'  => array( __( 'Tipos de pieza', 'museopostal-coleccion' ), __( 'Tipo de pieza', 'museopostal-coleccion' ), false, array( 'pieza' ) ),
		'epoca' => array( __( 'Épocas', 'museopostal-coleccion' ), __( 'Época', 'museopostal-coleccion' ), false, array( 'pieza', 'post' ) ),
		'lugar' => array( __( 'Lugares', 'museopostal-coleccion' ), __( 'Lugar', 'museopostal-coleccion' ), true, array( 'pieza', 'post' ) ),
		'tema'  => array( __( 'Temas', 'museopostal-coleccion' ), __( 'Tema', 'museopostal-coleccion' ), false, array( 'pieza', 'post' ) ),
	);
	foreach ( $taxonomias as $slug => list( $plural, $singular, $jerarquica, $tipos ) ) {
		register_taxonomy(
			$slug,
			$tipos,
			array(
				'labels'            => array(
					'name'          => $plural,
					'singular_name' => $singular,
				),
				'public'            => true,
				'hierarchical'      => $jerarquica,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => array(
					'slug'       => $slug,
					'with_front' => false,
				),
			)
		);
	}

	foreach ( museopostal_coleccion_campos() as $clave => $campo ) {
		$entero = 'entero' === $campo['tipo'];
		register_post_meta(
			'pieza',
			$clave,
			array(
				'type'              => $entero ? 'integer' : 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'default'           => $campo['defecto'] ?? ( $entero ? 0 : '' ),
				'sanitize_callback' => static fn( $valor ) => museopostal_coleccion_limpiar( $valor, $campo ),
				'auth_callback'     => static fn( $permitido, $clave_meta, $id ) => current_user_can( 'edit_post', $id ),
			)
		);
	}

	// Campos del artículo (§5.3).
	$campos_articulo = array(
		'mp_piezas'   => array( 'tipo' => 'ids' ),
		'mp_fuentes'  => array( 'tipo' => 'multilinea' ),
		'mp_revisado' => array( 'tipo' => 'texto' ),
	);
	foreach ( $campos_articulo as $clave => $campo ) {
		register_post_meta(
			'post',
			$clave,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => static fn( $valor ) => museopostal_coleccion_limpiar( $valor, $campo ),
				'auth_callback'     => static fn( $permitido, $clave_meta, $id ) => current_user_can( 'edit_post', $id ),
			)
		);
	}

	// Metadatos de término (§5.2).
	$campos_termino = array(
		array( 'sala', 'mp_sala_cabecera_id', 'integer' ),
		array( 'sala', 'mp_sala_orden', 'integer' ),
		array( 'sala', 'mp_sala_comisario', 'string' ),
		array( 'epoca', 'mp_epoca_inicio', 'integer' ),
	);
	foreach ( $campos_termino as list( $taxonomia, $clave, $tipo ) ) {
		register_term_meta(
			$taxonomia,
			$clave,
			array(
				'type'              => $tipo,
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'integer' === $tipo ? 'intval' : 'sanitize_text_field',
				'auth_callback'     => static fn() => current_user_can( 'manage_categories' ),
			)
		);
	}
}
add_action( 'init', 'museopostal_coleccion_registrar_modelo' );

/**
 * Términos iniciales de cada taxonomía (§5.2). Nombre visible => slug.
 * Los hijos van en un array con la clave del padre.
 *
 * @return array<string, array<string, mixed>>
 */
function museopostal_coleccion_terminos_iniciales(): array {
	return array(
		'sala'  => array(
			'antes-del-sello'             => array( 'Antes del sello', array( 'mp_sala_orden' => 1 ) ),
			'region-de-murcia'            => array( 'La Región de Murcia', array( 'mp_sala_orden' => 2 ) ),
			'correo-en-guerra'            => array( 'Correo en guerra', array( 'mp_sala_orden' => 3 ) ),
			'el-correo-en-la-pintura'     => array( 'El correo en la pintura', array( 'mp_sala_orden' => 4 ) ),
			'sellos-que-cuentan-el-mundo' => array( 'Sellos que cuentan el mundo', array( 'mp_sala_orden' => 5 ) ),
			'juegos-y-juguetes-postales'  => array( 'Juegos y juguetes postales', array( 'mp_sala_orden' => 6 ) ),
		),
		'tipo'  => array(
			'sello'              => array( 'Sello' ),
			'serie'              => array( 'Serie' ),
			'hoja-bloque'        => array( 'Hoja bloque' ),
			'pliego-minipliego'  => array( 'Pliego o minipliego' ),
			'spd'                => array( 'Sobre de primer día (SPD)' ),
			'tarjeta-maxima'     => array( 'Tarjeta máxima' ),
			'entero-postal'      => array( 'Entero postal' ),
			'carta-sobre'        => array( 'Carta o sobre' ),
			'tarjeta-postal'     => array( 'Tarjeta postal' ),
			'tarjeta-de-campana' => array( 'Tarjeta de campaña' ),
			'matasellos-marca'   => array( 'Matasellos o marca' ),
			'documento'          => array( 'Documento' ),
			'pintura'            => array( 'Pintura' ),
			'objeto'             => array( 'Objeto' ),
			'publicacion'        => array( 'Publicación' ),
		),
		'epoca' => array(
			'antiguedad-y-edad-media'     => array( 'Antigüedad y Edad Media', array( 'mp_epoca_inicio' => -27 ) ),
			'correo-de-postas'            => array( 'Correo de postas', array( 'mp_epoca_inicio' => 1505 ) ),
			'correo-de-la-corona'         => array( 'Correo de la Corona', array( 'mp_epoca_inicio' => 1717 ) ),
			'isabel-ii'                   => array( 'Isabel II', array( 'mp_epoca_inicio' => 1850 ) ),
			'sexenio-y-primera-republica' => array( 'Sexenio y Primera República', array( 'mp_epoca_inicio' => 1868 ) ),
			'restauracion'                => array( 'Restauración', array( 'mp_epoca_inicio' => 1875 ) ),
			'segunda-republica'           => array( 'Segunda República', array( 'mp_epoca_inicio' => 1931 ) ),
			'guerra-civil'                => array( 'Guerra Civil', array( 'mp_epoca_inicio' => 1936 ) ),
			'posguerra-y-franquismo'      => array( 'Posguerra y franquismo', array( 'mp_epoca_inicio' => 1939 ) ),
			'democracia'                  => array( 'Democracia', array( 'mp_epoca_inicio' => 1975 ) ),
			'euro'                        => array( 'Euro', array( 'mp_epoca_inicio' => 2002 ) ),
		),
		'lugar' => array(
			'region-de-murcia' => array(
				'Región de Murcia',
				array(),
				array(
					'cartagena'        => 'Cartagena',
					'murcia'           => 'Murcia',
					'lorca'            => 'Lorca',
					'aguilas'          => 'Águilas',
					'la-union'         => 'La Unión',
					'jumilla'          => 'Jumilla',
					'molina-de-segura' => 'Molina de Segura',
					'torre-pacheco'    => 'Torre Pacheco',
					'cabo-de-palos'    => 'Cabo de Palos',
				),
			),
			'espana'           => array( 'España' ),
			'mundo'            => array( 'Mundo' ),
		),
		'tema'  => array(
			'submarinos-y-marina'   => array( 'Submarinos y marina' ),
			'guerra-y-censura'      => array( 'Guerra y censura' ),
			'astronomia-y-eclipses' => array( 'Astronomía y eclipses' ),
			'pintura-y-arte'        => array( 'Pintura y arte' ),
			'musica'                => array( 'Música' ),
			'juegos-y-juguetes'     => array( 'Juegos y juguetes' ),
			'ferrocarril'           => array( 'Ferrocarril' ),
			'mineria'               => array( 'Minería' ),
			'fiestas-y-tradiciones' => array( 'Fiestas y tradiciones' ),
			'personajes'            => array( 'Personajes' ),
			'deporte'               => array( 'Deporte' ),
		),
	);
}

/**
 * Crea los términos que falten. Nunca renombra ni borra los que ya existen,
 * así que es seguro volver a ejecutarla tras cada actualización.
 */
function museopostal_coleccion_crear_terminos(): void {
	foreach ( museopostal_coleccion_terminos_iniciales() as $taxonomia => $terminos ) {
		foreach ( $terminos as $slug => $datos ) {
			$id = museopostal_coleccion_asegurar_termino( $taxonomia, $slug, $datos[0], 0, $datos[1] ?? array() );
			foreach ( $datos[2] ?? array() as $slug_hijo => $nombre_hijo ) {
				museopostal_coleccion_asegurar_termino( $taxonomia, $slug_hijo, $nombre_hijo, $id );
			}
		}
	}
	update_option( 'museopostal_coleccion_terminos', MUSEOPOSTAL_COLECCION_VERSION );
}

/**
 * Crea un término si no existe y le pone sus metadatos iniciales.
 *
 * @param string              $taxonomia Taxonomía.
 * @param string              $slug      Slug.
 * @param string              $nombre    Nombre visible.
 * @param int                 $padre     ID del término padre.
 * @param array<string, int>  $meta      Metadatos del término.
 * @return int ID del término (0 si falló).
 */
function museopostal_coleccion_asegurar_termino( string $taxonomia, string $slug, string $nombre, int $padre = 0, array $meta = array() ): int {
	$existente = get_term_by( 'slug', $slug, $taxonomia );
	if ( $existente instanceof WP_Term ) {
		return $existente->term_id;
	}
	$nuevo = wp_insert_term(
		$nombre,
		$taxonomia,
		array(
			'slug'   => $slug,
			'parent' => $padre,
		)
	);
	if ( is_wp_error( $nuevo ) ) {
		return 0;
	}
	foreach ( $meta as $clave => $valor ) {
		update_term_meta( $nuevo['term_id'], $clave, $valor );
	}
	return (int) $nuevo['term_id'];
}

/**
 * Tras una actualización del plugin, crea los términos nuevos que traiga.
 */
function museopostal_coleccion_actualizar_terminos(): void {
	if ( get_option( 'museopostal_coleccion_terminos' ) !== MUSEOPOSTAL_COLECCION_VERSION ) {
		museopostal_coleccion_crear_terminos();
	}
}
add_action( 'admin_init', 'museopostal_coleccion_actualizar_terminos' );

/**
 * Sugerencia de título normalizado en el editor (§5.1).
 *
 * @param string  $texto Texto por defecto.
 * @param WP_Post $post  Entrada que se edita.
 */
function museopostal_coleccion_titulo_sugerido( string $texto, WP_Post $post ): string {
	if ( 'pieza' !== $post->post_type ) {
		return $texto;
	}
	return __( 'Ej.: Carta de Águilas a Murcia, 18 de junio de 1866', 'museopostal-coleccion' );
}
add_filter( 'enter_title_here', 'museopostal_coleccion_titulo_sugerido', 10, 2 );
