<?php
/**
 * SofIlm Function - Meta Values
 *
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! function_exists( 'sof_get_default_attributes' ) ) :
	/**
	 * SofIlm - Get Default Attributes
	 *
	 * @return array
	 */
	function sof_get_default_attributes() {

		return array(
			'id'          => '',
			'type'        => '',
			'name'        => '',
			'title'       => '',
			'subtitle'    => '',
			'desc'        => '',
			'default'     => '',
			'required'    => '',
			'placeholder' => '',
			'class'       => '',
			'options'     => '',
			'attributes'  => '',
			'hide_title'  => false,
		);
	}
endif;

if ( ! function_exists( 'sof_get_background_repeat_options' ) ) :
	/**
	 * SofIlm - Get Background Repeat Options
	 *
	 * @return array
	 */
	function sof_get_background_repeat_options() {
		return array(
			''          => __( 'Default', 'sof' ),
			'no-repeat' => __( 'No Repeat', 'sof' ),
			'repeat'    => __( 'Repeat All', 'sof' ),
			'repeat-x'  => __( 'Repeat Horizontally', 'sof' ),
			'repeat-y'  => __( 'Repeat Vertically', 'sof' ),
			'inherit'   => __( 'Inherit', 'sof' ),
		);
	}
endif;

if ( ! function_exists( 'sof_get_background_size_options' ) ) :
	/**
	 * SofIlm - Get Background Size Options
	 *
	 * @return array
	 */
	function sof_get_background_size_options() {
		return array(
			''        => __( 'Default', 'sof' ),
			'inherit' => __( 'Inherit', 'sof' ),
			'cover'   => __( 'Cover', 'sof' ),
			'contain' => __( 'Contain', 'sof' ),
		);
	}
endif;

if ( ! function_exists( 'sof_get_background_attachments' ) ) :
	/**
	 * SofIlm - Get Background Attachment Options
	 *
	 * @return array
	 */
	function sof_get_background_attachments() {

		return array(
			''        => __( 'Default', 'sof' ),
			'fixed'   => __( 'Fixed', 'sof' ),
			'scroll'  => __( 'Scroll', 'sof' ),
			'inherit' => __( 'Inherit', 'sof' ),
		);
	}
endif;

if ( ! function_exists( 'sof_get_background_position_options' ) ) :
	/**
	 * SofIlm - Get Background Position Options
	 *
	 * @return array
	 */
	function sof_get_background_position_options() {

		return array(
			''              => __( 'Default', 'sof' ),
			'left top'      => __( 'Left Top', 'sof' ),
			'left center'   => __( 'Left Center', 'sof' ),
			'left bottom'   => __( 'Left Bottom', 'sof' ),
			'center top'    => __( 'Center Top', 'sof' ),
			'center center' => __( 'Center Center', 'sof' ),
			'center bottom' => __( 'Center Bottom', 'sof' ),
			'right top'     => __( 'Right Top', 'sof' ),
			'right center'  => __( 'Right Center', 'sof' ),
			'right bottom'  => __( 'Right Bottom', 'sof' ),
		);
	}
endif;

if ( ! function_exists( 'sof_get_background_origin_options' ) ) :
	/**
	 * SofIlm - Get Background Origin Options
	 *
	 * @return array
	 */
	function sof_get_background_origin_options() {
		return array(
			'inherit'     => esc_html__( 'Inherit', 'sof' ),
			'border-box'  => esc_html__( 'Border Box', 'sof' ),
			'content-box' => esc_html__( 'Content Box', 'sof' ),
			'padding-box' => esc_html__( 'Padding Box', 'sof' ),
		);
	}
endif;

if ( ! function_exists( 'sof_get_background_clip_options' ) ) :
	/**
	 * SofIlm - Get Background Clip Options
	 *
	 * @return array
	 */
	function sof_get_background_clip_options() {
		return array(
			'inherit'     => esc_html__( 'Inherit', 'sof' ),
			'border-box'  => esc_html__( 'Border Box', 'sof' ),
			'content-box' => esc_html__( 'Content Box', 'sof' ),
			'padding-box' => esc_html__( 'Padding Box', 'sof' ),
		);
	}
endif;

if ( ! function_exists( 'sof_get_class_pricing_types' ) ) :
	/**
	 * SofIlm - Get Class Pricing Types
	 *
	 * @return array
	 */
	function sof_get_class_pricing_types() {
		return array(
			'weekly'  => esc_html__( 'Weekly', 'sof' ),
			'monthly' => esc_html__( 'Monthly', 'sof' ),
			'yearly'  => esc_html__( 'Yearly', 'sof' ),
		);
	}
endif;

if ( ! function_exists( 'sof_get_weekdays' ) ) :
	/**
	 * SofIlm - Get Weekdays
	 *
	 * @return array
	 */
	function sof_get_weekdays() {
		return array(
			'monday'    => esc_html__( 'Monday', 'sof' ),
			'tuesday'   => esc_html__( 'Tuesday', 'sof' ),
			'wednesday' => esc_html__( 'Wednesday', 'sof' ),
			'thursday'  => esc_html__( 'Thursday', 'sof' ),
			'friday'    => esc_html__( 'Friday', 'sof' ),
			'saturday'  => esc_html__( 'Saturday', 'sof' ),
			'sunday'    => esc_html__( 'Sunday', 'sof' ),
		);
	}
endif;
