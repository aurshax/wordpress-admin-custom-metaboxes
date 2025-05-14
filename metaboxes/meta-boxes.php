<?php
/**
 * SofIlm Function - Meta Boxes
 *
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! function_exists( 'sof_add_meta_box' ) ) :
	/**
	 * SofIlm - Add Meta Box
	 *
	 * @param array $meta_box Meta Box.
	 * @return void
	 */
	function sof_add_meta_box( $meta_box ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return;
		}

		$screen     = get_current_screen();
		$post_types = $meta_box['post_types'];

		if ( empty( $post_types ) ) {
			return;
		}

		if ( ! isset( $meta_box['id'] ) ) {
			if ( isset( $meta_box['title'] ) ) {
				$meta_box['id'] = strtolower( sanitize_html_class( $meta_box['title'] ) );
			} else {
				$meta_box['id'] = 'sof_meta_box';
			}
		}

		$position = sof_get_array_value( 'position', $meta_box, 'normal' );
		$priority = sof_get_array_value( 'priority', $meta_box, 'low' );

		if ( function_exists( 'add_meta_box' ) && $screen && 'post' === $screen->base && in_array( $screen->id, $post_types, true ) ) {
			add_meta_box( $meta_box['id'], $meta_box['title'], $meta_box['callback'], $post_types, $position, $priority );
		}
	}
endif;

/**
 * RealgymCore Render Meta Boxes
 *
 * @param array $meta_fields Meta Fields.
 * @return void
 */
function sof_render_meta_box( $meta_fields ) {
	if ( empty( $meta_fields ) ) {
		return;
	}

	$sections = $meta_fields['sections'];

	if ( count( $sections ) <= 1 ) {
		foreach ( $sections as $section ) {
			$fields = $section['fields'];

			foreach ( $fields as $field ) {
				sof_render_meta_field( $field );
			}
		}
	} else {
		$meta_id = 'sof-meta';
		if ( isset( $meta_fields['id'] ) ) {
			$meta_id = $meta_fields['id'];
		}

		echo '<div class="sof-meta ' . esc_html( $meta_id ) . '">';
		sof_render_meta_tabs( $sections, $meta_id );

		echo '<div class="sof-meta-content">';
		foreach ( $sections as $index => $section ) {
			$fields = $section['fields'];
			echo '<div class="sof-meta-content-item ' . ( 0 === $index ? 'active' : '' ) . '" data-tab-content="' . esc_attr( $section['id'] ) . '" data-tab-group="' . esc_attr( $meta_id ) . '">';
			echo '<h3 class="sof-meta-section-title">' . esc_html( $section['title'] ) . '</h3>';
			foreach ( $fields as $field ) {
				sof_render_meta_field( $field );
			}
			echo '</div>';
		}
		echo '</div>';
		echo '</div>';
	}
}

/**
 * SofIlm - Render Meta Box Tabs
 *
 * @param array  $sections Sections.
 * @param string $group Group.
 * @return void
 */
function sof_render_meta_tabs( $sections, $group ) {
	?>
	<ul class="sof-meta-tab">
		<?php
		foreach ( $sections as $index => $section ) :
			?>
				<li class="sof-meta-tab-item">
					<button class="sof-meta-tab-link <?php echo 0 === $index ? 'active' : ''; ?>" data-tab-id="<?php echo esc_attr( $section['id'] ); ?>" data-tab-group="<?php echo esc_attr( $group ); ?>"><?php echo esc_html( $section['title'] ); ?></button>
				</li>
			<?php
			endforeach;
		?>
	</ul>
	<?php
}

/**
 * SofIlm - Render Meta Field
 *
 * @param array $meta_field Meta Field.
 * @return void
 */
function sof_render_meta_field( $meta_field ) {
	if ( isset( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post_id = (int) sanitize_text_field( wp_unslash( $_GET['post'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post    = get_post( $post_id );
	} else {
		$post = $GLOBALS['post'];
	}

	extract( // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		shortcode_atts(
			array(
				'id'       => '',
				'type'     => '',
				'default'  => '',
				'required' => '',
			),
			$meta_field
		)
	);

	$meta_value = get_post_meta( $post->ID, $id, true );

	if ( '' === $meta_value ) {
		$meta_value = $default;
	}

	sof_render_field( $meta_field, $meta_value );
}

/**
 * Render Meta Fields
 *
 * @param array $meta_field Meta Field.
 * @param mixed $meta_value Meta Value.
 * @return void
 */
function sof_render_field( $meta_field, $meta_value ) {
	if ( empty( $meta_field['name'] ) ) {
		$meta_field['name'] = SOF_META_SETTINGS_OPT . '[' . $meta_field['id'] . ']';
	}

	switch ( $meta_field['type'] ) {
		case 'text':
			sof_text_meta_field( $meta_field, $meta_value );
			break;
		case 'textarea':
			sof_textarea_meta_field( $meta_field, $meta_value );
			break;
		case 'number':
			sof_number_meta_field( $meta_field, $meta_value );
			break;
		case 'select':
			sof_select_meta_field( $meta_field, $meta_value );
			break;
		case 'color':
			sof_color_meta_field( $meta_field, $meta_value );
			break;
		case 'switch':
			sof_switch_meta_field( $meta_field, $meta_value );
			break;
		case 'editor':
			sof_editor_meta_field( $meta_field, $meta_value );
			break;
		case 'background':
			sof_background_meta_field( $meta_field, $meta_value );
			break;
		case 'media':
			sof_media_meta_field( $meta_field, $meta_value );
			break;
		case 'date':
			sof_date_meta_field( $meta_field, $meta_value );
			break;
		case 'time':
			sof_time_meta_field( $meta_field, $meta_value );
			break;
		case 'time_range':
			sof_time_range_meta_field( $meta_field, $meta_value );
			break;
		case 'repeater':
			sof_repeater_field( $meta_field, $meta_value );
			break;
		case 'button':
			sof_button_field( $meta_field, $meta_value );
			break;
		default:
			break;
	}
}

/**
 * SofIlm - Save Meta Value
 *
 * @param int   $post_id Post ID.
 * @param array $meta_field_sections Meta Field Sections.
 * @return void
 */
function sof_save_meta_value( $post_id, $meta_field_sections ) {
	if ( empty( $meta_field_sections ) ) {
		return;
	}

	$meta_fields = array();
	foreach ( $meta_field_sections as $section ) {
		$meta_fields = array_merge( $meta_fields, $section['fields'] );
	}

	$post_data = array();
	if ( isset( $_POST[ SOF_META_SETTINGS_OPT ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$post_data =  $_POST[ SOF_META_SETTINGS_OPT ]; // @codingStandardsIgnoreLine
	}

	foreach ( $meta_fields as $meta_field ) {
		if ( empty( $meta_field['id'] ) ) {
			continue;
		}

		if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) { // phpcs:ignore WordPress.Security.NonceVerification
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		$meta_key   = $meta_field['id'];
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		if ( ! isset( $post_data[ $meta_key ] ) ) {
			delete_post_meta( $post_id, $meta_key );
			continue;
		}

		$updated_meta_value = $post_data[ $meta_key ];

		if ( ! is_array( $updated_meta_value ) ) {
			$updated_meta_value = preg_replace( '/<script([^>]*)>/s', '', $updated_meta_value );
			$updated_meta_value = preg_replace( '/<style([^>]*)>/s', '', $updated_meta_value );
			$updated_meta_value = str_replace( '</script>', '', $updated_meta_value );
			$updated_meta_value = str_replace( '</style>', '', $updated_meta_value );

			if ( 'editor' === $meta_field['type'] ) {
				$updated_meta_value = wpautop( $updated_meta_value );
			}
		}

		if ( 'repeater' === $meta_field['type'] && isset( $updated_meta_value[ SOF_REPEATER_DATA ] ) ) {
			$updated_meta_value = $updated_meta_value[ SOF_REPEATER_DATA ];
		}

		if ( ! is_null( $updated_meta_value ) ) {
			update_post_meta( $post_id, $meta_key, $updated_meta_value );
		} elseif ( is_null( $updated_meta_value ) && $meta_value ) {
			delete_post_meta( $post_id, $meta_key );
		}
	}
}
