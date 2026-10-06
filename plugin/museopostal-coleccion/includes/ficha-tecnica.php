<?php
/**
 * Caja «Ficha técnica» del editor de piezas: PHP y HTML, sin JavaScript.
 *
 * Todos los grupos se muestran plegados con <details> (crítica n.º 20):
 * cambiar el tipo de pieza en el editor de bloques no recarga la caja, así
 * que ocultar grupos según el tipo no funcionaría sin JavaScript.
 *
 * @package museopostal-coleccion
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra la caja en la barra lateral del editor de piezas.
 */
function museopostal_coleccion_caja_ficha(): void {
	add_meta_box(
		'museopostal-ficha-tecnica',
		__( 'Ficha técnica', 'museopostal-coleccion' ),
		'museopostal_coleccion_pintar_caja',
		'pieza',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes_pieza', 'museopostal_coleccion_caja_ficha' );

/**
 * Otras piezas que ya usan este número de inventario.
 *
 * @param string $inventario Número de inventario.
 * @param int    $excluir    ID de la pieza actual.
 * @return int[]
 */
function museopostal_coleccion_inventario_repetido( string $inventario, int $excluir ): array {
	if ( '' === $inventario ) {
		return array();
	}
	return get_posts(
		array(
			'post_type'      => 'pieza',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
			'posts_per_page' => 5,
			'fields'         => 'ids',
			'post__not_in'   => array( $excluir ),
			'no_found_rows'  => true,
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_query_meta_query -- consulta puntual del editor.
			'meta_query'     => array(
				array(
					'key'   => 'mp_inventario',
					'value' => $inventario,
				),
			),
		)
	);
}

/**
 * Pinta la caja: avisos, y un <details> por grupo con sus campos.
 *
 * @param WP_Post $post Pieza que se edita.
 */
function museopostal_coleccion_pintar_caja( WP_Post $post ): void {
	$campos = museopostal_coleccion_campos();
	wp_nonce_field( 'museopostal_ficha', 'museopostal_ficha_nonce' );

	$faltan = array();
	foreach ( $campos as $clave => $campo ) {
		if ( ! empty( $campo['obligatorio'] ) && '' === (string) get_post_meta( $post->ID, $clave, true ) ) {
			$faltan[] = $campo['etiqueta'];
		}
	}
	$repetidas = museopostal_coleccion_inventario_repetido( (string) get_post_meta( $post->ID, 'mp_inventario', true ), $post->ID );

	echo '<style>.mp-ficha-caja summary{cursor:pointer;font-weight:600;padding:.4rem 0}.mp-ficha-caja label{display:block;font-weight:600;margin-top:.6rem}.mp-ficha-caja input[type=text],.mp-ficha-caja input[type=url],.mp-ficha-caja input[type=number],.mp-ficha-caja select,.mp-ficha-caja textarea{width:100%}.mp-ficha-caja .mp-ayuda{color:#50575e;font-size:12px;margin:.2rem 0 0}.mp-ficha-caja .mp-aviso{border-left:4px solid #b32d2e;padding:.4rem .6rem;background:#fcf0f1}</style>';
	echo '<div class="mp-ficha-caja">';

	if ( $faltan ) {
		/* translators: %s: lista de campos. */
		printf( '<p class="mp-aviso">%s</p>', esc_html( sprintf( __( 'Faltan campos obligatorios: %s.', 'museopostal-coleccion' ), implode( ', ', $faltan ) ) ) );
	}
	if ( $repetidas ) {
		echo '<p class="mp-aviso">' . esc_html__( 'Este número de inventario ya lo usa:', 'museopostal-coleccion' ) . ' ';
		$enlaces = array_map(
			static fn( int $id ): string => sprintf( '<a href="%s">%s</a>', esc_url( (string) get_edit_post_link( $id ) ), esc_html( get_the_title( $id ) ) ),
			$repetidas
		);
		echo implode( ', ', $enlaces ) . '</p>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado arriba.
	}

	foreach ( museopostal_coleccion_grupos() as $grupo => $titulo ) {
		printf( '<details><summary>%s</summary>', esc_html( $titulo ) );
		foreach ( $campos as $clave => $campo ) {
			if ( $campo['grupo'] === $grupo ) {
				museopostal_coleccion_pintar_campo( $clave, $campo, get_post_meta( $post->ID, $clave, true ) );
			}
		}
		echo '</details>';
	}
	echo '</div>';
}

/**
 * Pinta un campo con su etiqueta y su ayuda.
 *
 * @param string               $clave Clave del metadato.
 * @param array<string, mixed> $campo Definición del campo.
 * @param mixed                $valor Valor guardado.
 */
function museopostal_coleccion_pintar_campo( string $clave, array $campo, mixed $valor ): void {
	$id       = 'mp-campo-' . $clave;
	$etiqueta = $campo['etiqueta'] . ( empty( $campo['obligatorio'] ) ? '' : ' ' . __( '(obligatorio)', 'museopostal-coleccion' ) );
	$valor    = (string) $valor;

	if ( 'enum-multiple' === $campo['tipo'] ) {
		$marcados = explode( ',', $valor );
		printf( '<fieldset><legend><strong>%s</strong></legend>', esc_html( $etiqueta ) );
		foreach ( $campo['opciones'] as $opcion => $texto ) {
			printf(
				'<label style="font-weight:400"><input type="checkbox" name="%1$s[]" value="%2$s"%3$s> %4$s</label>',
				esc_attr( $clave ),
				esc_attr( $opcion ),
				checked( in_array( $opcion, $marcados, true ), true, false ),
				esc_html( $texto )
			);
		}
		echo '</fieldset>';
	} else {
		printf( '<label for="%s">%s</label>', esc_attr( $id ), esc_html( $etiqueta ) );
		switch ( $campo['tipo'] ) {
			case 'enum':
				printf( '<select id="%1$s" name="%2$s"><option value="">—</option>', esc_attr( $id ), esc_attr( $clave ) );
				$actual = '' === $valor ? ( $campo['defecto'] ?? '' ) : $valor;
				foreach ( $campo['opciones'] as $opcion => $texto ) {
					printf( '<option value="%s"%s>%s</option>', esc_attr( $opcion ), selected( $actual, $opcion, false ), esc_html( $texto ) );
				}
				echo '</select>';
				break;
			case 'multilinea':
			case 'json':
				printf( '<textarea id="%1$s" name="%2$s" rows="3">%3$s</textarea>', esc_attr( $id ), esc_attr( $clave ), esc_textarea( $valor ) );
				break;
			case 'entero':
				printf( '<input type="number" min="0" step="1" id="%1$s" name="%2$s" value="%3$s">', esc_attr( $id ), esc_attr( $clave ), esc_attr( '0' === $valor ? '' : $valor ) );
				break;
			case 'url':
				printf( '<input type="url" id="%1$s" name="%2$s" value="%3$s">', esc_attr( $id ), esc_attr( $clave ), esc_attr( $valor ) );
				break;
			default:
				printf( '<input type="text" id="%1$s" name="%2$s" value="%3$s">', esc_attr( $id ), esc_attr( $clave ), esc_attr( $valor ) );
		}
	}
	if ( ! empty( $campo['ayuda'] ) ) {
		printf( '<p class="mp-ayuda">%s</p>', esc_html( $campo['ayuda'] ) );
	}
}

/**
 * Guarda la caja. Un campo vacío borra su metadato.
 *
 * @param int $post_id ID de la pieza.
 */
function museopostal_coleccion_guardar_caja( int $post_id ): void {
	if ( ! isset( $_POST['museopostal_ficha_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['museopostal_ficha_nonce'] ) ), 'museopostal_ficha' )
		|| wp_is_post_autosave( $post_id )
		|| wp_is_post_revision( $post_id )
		|| ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( museopostal_coleccion_campos() as $clave => $campo ) {
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- se limpia en museopostal_coleccion_limpiar().
		$bruto = isset( $_POST[ $clave ] ) ? wp_unslash( $_POST[ $clave ] ) : '';
		$valor = museopostal_coleccion_limpiar( $bruto, $campo );
		if ( '' === $valor || 0 === $valor ) {
			delete_post_meta( $post_id, $clave );
		} else {
			update_post_meta( $post_id, $clave, $valor );
		}
	}
}
add_action( 'save_post_pieza', 'museopostal_coleccion_guardar_caja' );
