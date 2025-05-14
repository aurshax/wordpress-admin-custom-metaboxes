<?php
/**
 * TenpoCore Function - Meta Fields
 *
 * @author  Balcomsoft
 * @package TenpoCore
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! function_exists( 'sof_render_meta_field_title' ) ) :
	/**
	 * TenpoCore Render Meta Field Title
	 *
	 * @param string $title Meta Field Title.
	 * @return void
	 */
	function sof_render_meta_field_title( $title ) {
		?>
		<div class="sof-metabox__label">
			<div class="sof-metabox__title"><?php echo esc_html( $title ); ?></div>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'sof_render_meta_field_description' ) ) :
	/**
	 * TenpoCore Render Meta Field Description
	 *
	 * @param string $id Meta Field ID.
	 * @param string $desc Description.
	 * @return void
	 */
	function sof_render_meta_field_description( $id, $desc ) {
		if ( $desc ) :
			?>
			<div class="sof-metabox__desc">
				<label for="<?php echo esc_attr( $id ); ?>">
					<?php
					echo wp_kses(
						$desc,
						array(
							'em'     => array(),
							'i'      => array(),
							'strong' => array(),
							'a'      => array(
								'class' => array(),
								'href'  => array(),
							),
						)
					);
					?>
				</label>
			</div>
			<?php
		endif;
	}
endif;

if ( ! function_exists( 'sof_select_meta_field' ) ) :
	/**
	 * TenpoCore Select Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_select_meta_field( $meta_field, $meta_value ) {
		$additional_attributes = array(
			'data'  => '',
			'args'  => '',
			'multi' => false,
		);
		$meta_field            = wp_parse_args( $meta_field, array_merge( sof_get_default_attributes(), $additional_attributes ) );

		$default_option = $meta_field['default'];
		if ( ! empty( $meta_field['data'] ) && empty( $meta_field['options'] ) ) {
			if ( empty( $meta_field['args'] ) ) {
				$meta_field['args'] = array();
			}

			$default_option        = true;
			$meta_field['options'] = sof_get_autocomplete_posts( $meta_field['args'] );
		}

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-select-box">
					<select
							name="<?php echo esc_attr( $meta_field['name'] ) . esc_attr( true === $meta_field['multi'] ? '[]' : '' ); ?>"
							data-name="<?php echo esc_attr( $meta_field['id'] ); ?>"
							id="<?php echo esc_attr( $meta_field['id'] ); ?>"
							data-type="select"
						<?php echo esc_html( true === $meta_field['multi'] ? 'multiple="true"' : '' ); ?>
					>
						<?php if ( $default_option ) : ?>
							<option value=""><?php echo esc_html__( 'Select', 'sof' ); ?></option>
						<?php endif; ?>
						<?php
						if ( is_array( $meta_field['options'] ) ) :
							foreach ( $meta_field['options'] as $key => $option ) :
								$selected = '';
								if ( true === $meta_field['multi'] ) {
									if ( is_array( $meta_value ) ) {
										$selected = in_array( strval( $key ), $meta_value, true ) ? ' selected="selected"' : '';
									}
								} else {
									$selected = selected( $meta_value, $key, false );
								}
								?>
								<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
									<?php echo esc_html( $option ); ?>
								</option>
								<?php
							endforeach;
						endif
						?>
					</select>
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_color_meta_field' ) ) :
	/**
	 * TenpoCore Color Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_color_meta_field( $meta_field, $meta_value ) {
		$meta_field = wp_parse_args( $meta_field, sof_get_default_attributes() );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-color-box">
					<input type="text" id="<?php echo esc_attr( $meta_field['id'] ); ?>" name="<?php echo esc_attr( $meta_field['name'] ); ?>" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" size="50%" class="sof-color-field"/>
					<label class="sof-transparency-check" for="<?php echo esc_attr( $meta_field['id'] ); ?>-transparency">
						<input type="checkbox" value="1" id="<?php echo esc_attr( $meta_field['id'] ); ?>-transparency" class="sof-checkbox sof-color-transparency"<?php echo 'transparent' === $meta_value ? ' checked="checked"' : ''; ?>>
						<?php esc_html_e( 'Transparent', 'sof' ); ?>
					</label>
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_editor_meta_field' ) ) :
	/**
	 * TenpoCore Editor Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_editor_meta_field( $meta_field, $meta_value ) {
		$meta_field = wp_parse_args( $meta_field, sof_get_default_attributes() );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-editor-box">
					<?php
					wp_editor(
						$meta_value,
						$meta_field['id'],
						array(
							'media_buttons' => false,
							'textarea_name' => $meta_field['name'],
							'textarea_rows' => 10,
						)
					);
					?>
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_switch_meta_field' ) ) :
	/**
	 * TenpoCore Switch Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_switch_meta_field( $meta_field, $meta_value ) {
		$additional_attributes = array(
			'on'  => '',
			'off' => '',
		);

		$meta_field = wp_parse_args( $meta_field, array_merge( sof_get_default_attributes(), $additional_attributes ) );

		$cb_enabled  = '';
		$cb_disabled = '';

		if ( 1 === (int) $meta_value ) {
			$cb_enabled = 'selected';
		} else {
			$cb_disabled = 'selected';
		}

		$on  = ! empty( $on ) ? $on : esc_html__( 'On', 'sof' );
		$off = ! empty( $off ) ? $off : esc_html__( 'Off', 'sof' );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-switch-box">
					<label class="cb-enable <?php echo esc_attr( $cb_enabled ); ?>" data-id="<?php echo esc_attr( $meta_field['id'] ); ?>"><span><?php echo esc_html( $on ); ?></span></label>
					<label class="cb-disable <?php echo esc_attr( $cb_disabled ); ?>" data-id="<?php echo esc_attr( $meta_field['id'] ); ?>"><span><?php echo esc_html( $off ); ?></span></label>
					<input type="hidden" class="checkbox checkbox-input <?php echo esc_attr( $meta_field['class'] ); ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>" name="<?php echo esc_attr( $meta_field['name'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>" data-type="switch">
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_background_meta_field' ) ) :
	/**
	 * TenpoCore Background Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_background_meta_field( $meta_field, $meta_value ) {
		$additional_attributes = array(
			'background-color'      => true,
			'background-repeat'     => true,
			'background-attachment' => true,
			'background-position'   => true,
			'background-image'      => true,
			'background-gradient'   => false,
			'background-clip'       => false,
			'background-origin'     => false,
			'background-size'       => true,
			'preview'               => true,
			'transparent'           => true,
		);

		$meta_field = wp_parse_args( $meta_field, array_merge( sof_get_default_attributes(), $additional_attributes ) );

		$defaults = array(
			'background-color'      => '',
			'background-repeat'     => '',
			'background-attachment' => '',
			'background-position'   => '',
			'background-image'      => '',
			'background-clip'       => '',
			'background-origin'     => '',
			'background-size'       => '',
			'media'                 => array(),
		);

		$meta_value = wp_parse_args( $meta_value, $defaults );

		$defaults = array(
			'id'        => '',
			'width'     => '',
			'height'    => '',
			'thumbnail' => '',
		);

		$meta_value['media'] = wp_parse_args( $meta_value['media'], $defaults );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-background-box">
					<?php
					if ( true === $meta_field['background-color'] ) {
						?>
						<div class="sof-color-box">
							<input type="text" id="<?php echo esc_attr( $meta_field['name'] ); ?>-background-color" name="<?php echo esc_attr( $meta_field['name'] ) . '[background-color]'; ?>" value="<?php echo esc_attr( $meta_value['background-color'] ); ?>" size="50%" class="sof-color-field"/>
							<label class="sof-transparency-check" for="<?php echo esc_attr( $meta_field['id'] ); ?>-transparency">
								<input type="checkbox" value="1" id="<?php echo esc_attr( $meta_field['id'] ); ?>-transparency" class="sof-checkbox sof-color-transparency"<?php echo 'transparent' === $meta_value['background-color'] ? ' checked="checked"' : ''; ?>>
								<?php esc_html_e( 'Transparent', 'sof' ); ?>
							</label>
						</div>
						<?php
					}
					?>

					<?php if ( true === $meta_field['background-image'] ) : ?>
						<div class="background-select-wrapper">
							<?php if ( true === $meta_field['background-repeat'] ) : ?>
								<div class="background-item">
									<div class="sof-select-box">
										<select name="<?php echo esc_attr( $meta_field['name'] ) . '[background-repeat]'; ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>-background-repeat" data-css-name="background-repeat">
											<?php foreach ( sof_get_background_repeat_options() as $key => $option ) : ?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo $meta_value['background-repeat'] === $key ? ' selected="selected"' : ''; ?>>
													<?php echo esc_html( $option ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
							<?php if ( true === $meta_field['background-size'] ) : ?>
								<div class="background-item">
									<div class="sof-select-box">
										<select name="<?php echo esc_attr( $meta_field['name'] ) . '[background-size]'; ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>-background-size" data-css-name="background-size">
											<?php foreach ( sof_get_background_size_options() as $key => $option ) : ?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo $meta_value['background-size'] === $key ? ' selected="selected"' : ''; ?>>
													<?php echo esc_html( $option ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
							<?php if ( true === $meta_field['background-attachment'] ) : ?>
								<div class="background-item">
									<div class="sof-select-box">
										<select name="<?php echo esc_attr( $meta_field['name'] ) . '[background-attachment]'; ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>-background-attachment" data-css-name="background-attachment">
											<?php foreach ( sof_get_background_attachments() as $key => $option ) : ?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo $meta_value['background-attachment'] === $key ? ' selected="selected"' : ''; ?>>
													<?php echo esc_html( $option ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
							<?php if ( true === $meta_field['background-position'] ) : ?>
								<div class="background-item">
									<div class="sof-select-box">
										<select name="<?php echo esc_attr( $meta_field['name'] ) . '[background-position]'; ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>-background-position" data-css-name="background-position">
											<?php foreach ( sof_get_background_position_options() as $key => $option ) : ?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo $meta_value['background-position'] === $key ? ' selected="selected"' : ''; ?>>
													<?php echo esc_html( $option ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
							<?php if ( true === $meta_field['background-origin'] ) : ?>
								<div class="background-item">
									<div class="sof-select-box">
										<select name="<?php echo esc_attr( $meta_field['name'] ) . '[background-origin]'; ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>-background-origin" data-css-name="background-origin">
											<?php foreach ( sof_get_background_origin_options() as $key => $option ) : ?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo $meta_value['background-origin'] === $key ? ' selected="selected"' : ''; ?>>
													<?php echo esc_html( $option ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
							<?php if ( true === $meta_field['background-clip'] ) : ?>
								<div class="background-item">
									<div class="sof-select-box">
										<select name="<?php echo esc_attr( $meta_field['name'] ) . '[background-clip]'; ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>-background-clip" data-css-name="background-clip">
											<?php foreach ( sof_get_background_clip_options() as $key => $option ) : ?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo $meta_value['background-clip'] === $key ? ' selected="selected"' : ''; ?>>
													<?php echo esc_html( $option ); ?>
												</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>
						</div>

						<div class="background-image-wrapper">
							<input type="text" class="sof-admin-input sof-admin-background-image-input" id="<?php echo esc_attr( $meta_field['name'] ); ?>[background-image]" name="<?php echo esc_attr( $meta_field['name'] ) . '[background-image]'; ?>" value="<?php echo esc_attr( $meta_value['background-image'] ); ?>" placeholder="<?php echo esc_html__( 'No Media Selected', 'sof' ); ?>">
							<input type="hidden" class="background-media-id" name="<?php echo esc_attr( $meta_field['name'] ) . '[media][id]'; ?>" value="<?php echo esc_attr( $meta_value['media']['id'] ); ?>">
							<div class="background-image-wrapper__actions">
								<button id="page-title-bg-media" class="button sof-image-upload-button" data-type="background">
									<?php echo esc_html__( 'Upload', 'sof' ); ?>
								</button>
								<?php
								$hide_remove = '';
								if ( empty( $meta_value['background-image'] ) ) {
									$hide_remove = 'hide';
								}
								?>
								<button id="reset-page-title-bg-media" class="button sof-button-reset sof-image-remove-button <?php echo esc_attr( $hide_remove ); ?>" data-type="background">
									<?php echo esc_html__( 'Remove', 'sof' ); ?>
								</button>
							</div>
						</div>

						<?php
						if ( $meta_field['preview'] ) :
							$css          = sof_generate_background_media_inline_css( $meta_value );
							$is_bg_exists = strpos( $css, 'background-image' );

							if ( empty( $css ) || ! $is_bg_exists ) {
								$css = 'display:none;';
							}
							?>
							<div class="sof-background-preview" style="<?php echo esc_attr( $css ); ?>"></div>
						<?php endif; ?>
					<?php endif; ?>

					<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
				</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_media_meta_field' ) ) :
	/**
	 * TenpoCore Media Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_media_meta_field( $meta_field, $meta_value ) {
		$additional_attributes = array(
			'url' => '',
		);

		$meta_field = wp_parse_args( $meta_field, array_merge( sof_get_default_attributes(), $additional_attributes ) );

		$defaults = array(
			'id'        => '',
			'width'     => '',
			'height'    => '',
			'thumbnail' => '',
		);

		$meta_value = wp_parse_args( $meta_value, $defaults );

		$required = sof_get_required_attr( $meta_field['required'] );

		$image = '';
		if ( ! empty( $meta_value['id'] ) ) {
			$image = wp_get_attachment_image_url( $meta_value['id'] );
		}

		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-media-box">
						<div class="media-image-wrapper">
							<?php if ( $meta_field['url'] ) : ?>
								<input type="text" readonly class="sof-admin-input sof-admin-media-input" id="<?php echo esc_attr( $meta_field['name'] ); ?>[thumbnail]" name="<?php echo esc_attr( $meta_field['name'] ) . '[thumbnail]'; ?>" value="<?php echo esc_attr( $meta_value['thumbnail'] ); ?>" placeholder="<?php echo esc_html__( 'No Media Selected', 'sof' ); ?>">
							<?php endif; ?>
							<input type="hidden" class="background-media-id" name="<?php echo esc_attr( $meta_field['name'] ) . '[id]'; ?>" value="<?php echo esc_attr( $meta_value['id'] ); ?>">

							<?php
							$hide_preview = '';
							if ( empty( $image ) ) {
								$hide_preview = 'hide';
							}
							?>
							<div class="sof-media-preview <?php echo esc_attr( $hide_preview ); ?>">
								<a href="<?php echo esc_url( $meta_value['thumbnail'] ); ?>" target="_blank">
									<img class="sof-preview-image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html__( 'Media Preview', 'sof' ); ?>" />
								</a>
							</div>

							<div class="media-image-wrapper__actions">
								<button id="page-title-bg-media" class="button sof-image-upload-button" data-type="media">
									<?php echo esc_html__( 'Upload', 'sof' ); ?>
								</button>
								<?php
								$hide_remove = '';
								if ( empty( $meta_value['id'] ) ) {
									$hide_remove = 'hide';
								}
								?>
								<button id="reset-page-title-bg-media" class="button sof-button-reset sof-image-remove-button <?php echo esc_attr( $hide_remove ); ?>" data-type="media">
									<?php echo esc_html__( 'Remove', 'sof' ); ?>
								</button>
							</div>
						</div>

					<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
				</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_text_meta_field' ) ) :
	/**
	 * TenpoCore Text Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_text_meta_field( $meta_field, $meta_value ) {
		$meta_field = wp_parse_args( $meta_field, sof_get_default_attributes() );

		$default = array(
			'type' => 'text',
		);

		$meta_field['attributes'] = wp_parse_args( $meta_field['attributes'], $default );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-text-box">
					<input class="regular-text" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>" type="<?php echo esc_attr( $meta_field['attributes']['type'] ); ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>" name="<?php echo esc_attr( $meta_field['name'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>">
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_textarea_meta_field' ) ) :
	/**
	 * TenpoCore Text Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_textarea_meta_field( $meta_field, $meta_value ) {
		$additional_attributes = array(
			'rows' => 6,
		);

		$meta_field = wp_parse_args( $meta_field, array_merge( sof_get_default_attributes(), $additional_attributes ) );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-text-box">
					<textarea class="large-text" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>" name="<?php echo esc_attr( $meta_field['name'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" placeholder="<?php echo esc_attr( $meta_field['placeholder'] ); ?>" rows="<?php echo esc_attr( $meta_field['rows'] ); ?>"
					><?php echo esc_html( $meta_value ); ?></textarea>
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_number_meta_field' ) ) :
	/**
	 * TenpoCore Number Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_number_meta_field( $meta_field, $meta_value ) {
		$additional_attributes = array(
			'min'  => '',
			'max'  => '',
			'step' => 1,
		);
		$meta_field            = wp_parse_args( $meta_field, array_merge( sof_get_default_attributes(), $additional_attributes ) );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-text-box">
					<input class="regular-text" type="number" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>" name="<?php echo esc_attr( $meta_field['name'] ); ?>" min="<?php echo esc_attr( $meta_field['min'] ); ?>" max="<?php echo esc_attr( $meta_field['max'] ); ?>" step="<?php echo esc_attr( $meta_field['step'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>">
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_date_meta_field' ) ) :
	/**
	 * TenpoCore Date Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_date_meta_field( $meta_field, $meta_value ) {
		$meta_field = wp_parse_args( $meta_field, sof_get_default_attributes() );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-date-box">
					<input class="regular-text sof-date-input" type="text" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>" name="<?php echo esc_attr( $meta_field['name'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>">
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_time_meta_field' ) ) :
	/**
	 * TenpoCore Time Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_time_meta_field( $meta_field, $meta_value ) {
		$meta_field = wp_parse_args( $meta_field, sof_get_default_attributes() );

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-time-box">
					<input class="regular-text sof-time-input" type="text" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>" id="<?php echo esc_attr( $meta_field['id'] ); ?>" name="<?php echo esc_attr( $meta_field['name'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>">
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_time_range_meta_field' ) ) :
	/**
	 * TenpoCore Time Range Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_time_range_meta_field( $meta_field, $meta_value ) {
		$meta_field = wp_parse_args( $meta_field, sof_get_default_attributes() );

		$start_time = '';
		$end_time   = '';
		if ( is_array( $meta_value ) ) {
			$start_time = $meta_value['start_time'] ?? '';
			$end_time   = $meta_value['end_time'] ?? '';
		}

		$required = sof_get_required_attr( $meta_field['required'] );
		?>
		<fieldset class="sof-field-container" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-time-box">
					<input class="regular-text sof-time-input" type="text" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>[start_time]" id="<?php echo esc_attr( $meta_field['id'] ); ?>_start_time" name="<?php echo esc_attr( $meta_field['name'] ); ?>[start_time]" value="<?php echo esc_attr( $start_time ); ?>">
					<input class="regular-text sof-time-input" type="text" data-name="<?php echo esc_attr( $meta_field['id'] ); ?>[end_time]" id="<?php echo esc_attr( $meta_field['id'] ); ?>_end_time" name="<?php echo esc_attr( $meta_field['name'] ); ?>[end_time]" value="<?php echo esc_attr( $end_time ); ?>">
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_repeater_field' ) ) :
	/**
	 * TenpoCore Repeater Meta Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_repeater_field( $meta_field, $meta_value ) {
		$additional_attributes = array(
			'fields'     => array(),
			'item_name'  => '',
			'full_width' => false,
		);
		$meta_field            = wp_parse_args( $meta_field, array_merge( sof_get_default_attributes(), $additional_attributes ) );

		if ( ! is_array( $meta_value ) ) {
			$meta_value = array();
		}

		$required = sof_get_required_attr( $meta_field['required'] );

		?>
		<fieldset id="<?php echo 'sof-field-repeater-' . $meta_field['id'] ?>" class="sof-field-container <?php echo esc_attr( $meta_field['full_width'] ? 'sof-full-width' : '' ); ?>" <?php echo esc_attr( $required ); ?>>
			<?php
			if ( ! $meta_field['hide_title'] ) {
				sof_render_meta_field_title( $meta_field['title'] );
			}
			?>
			<div class="sof-field-container__inner">
				<div class="sof-box-option sof-repeater-box">
					<div class="sof-repeater-inner">
						<?php
						if ( is_array( $meta_value ) && count( $meta_value ) > 0 ) :
							foreach ( $meta_value as $meta_field_value ) {
								?>
								<div class="sof-repeater-items" data-group="<?php echo esc_attr( $meta_field['name'] ) . '[' . esc_attr( SOF_REPEATER_DATA ) . ']'; ?>">
									<?php
									foreach ( $meta_field['fields'] as $field ) {
										$field['name'] = $meta_field['name'];

										$value = '';
										if ( isset( $meta_field_value[ $field['id'] ] ) ) {
											$value = $meta_field_value[ $field['id'] ];
										}

										sof_render_field( $field, $value );
									}
									?>
									<div class="sof-remove-item-wrapper">
										<button class="sof-remove-btn"><i class="el el-remove-sign"></i></button>
									</div>
								</div>
								<?php } ?>
						<?php else : ?>
							<div class="sof-repeater-items" data-empty="true" data-group="<?php echo esc_attr( $meta_field['name'] ) . '[' . esc_attr( SOF_REPEATER_DATA ) . ']'; ?>">
								<?php
								foreach ( $meta_field['fields'] as $field ) {
									$field['name'] = $meta_field['name'];
									$default       = isset( $field['default'] ) ? $field['default'] : '';

									sof_render_field( $field, $default );
								}
								?>
								<div class="sof-remove-item-wrapper"><button class="sof-remove-btn"><i class="el el-remove-sign"></i></button></div>
							</div><?php endif; ?>
					</div>
					<div class="repeater-heading">
						<button class="button button-primary button-large repeater-add-btn"><?php echo esc_html__( 'Add Row', 'sof' ); ?></button>
					</div>
				</div>
				<?php sof_render_meta_field_description( $meta_field['id'], $meta_field['desc'] ); ?>
			</div>
		</fieldset>
		<?php
	}
endif;

if ( ! function_exists( 'sof_button_field' ) ) {
	/**
	 * Tenpo Core Button Field
	 *
	 * @param array $meta_field Meta Field.
	 * @param mixed $meta_value Meta Value.
	 * @return void
	 */
	function sof_button_field( $meta_field, $meta_value ) {
		$meta_field = wp_parse_args( $meta_field, sof_get_default_attributes() );

		?>
			<fieldset class="sof-field-container">
				<?php
				if ( ! $meta_field['hide_title'] ) {
					sof_render_meta_field_title( $meta_field['title'] );
				}
				?>
				<div class="sof-field-container__inner">
					<button class="btn btn-primary sof-admin-btn btn-sof-condition"><?php echo esc_html__( 'Set Condition', 'sof' ); ?></button>
				</div>
			</fieldset>
			<?php
	}
}
