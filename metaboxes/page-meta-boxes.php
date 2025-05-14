<?php
/**
 * Sof - Page Meta settings
 *
 * @author  Balcomsoft
 * @package TenpoCore
 * @version 1.0.0
 * @since   1.0.0
 */

/**
 * TenpoCore Page Meta Options
 *
 * @return array[]
 */
function sof_get_page_meta_options()
{
    return array(
        'id' => 'sof_page_meta_box',
        'title' => esc_html__('Settings', 'sof'),
        'callback' => 'sof_page_meta_box',
        'post_types' => array('page'),
        'position' => 'normal',
        'priority' => 'high',
        'sections' => array(
            array(
                'id' => 'sof-page-general-section',
                'title' => esc_html__('General', 'sof'),
                'icon' => 'el el-cog',
                'fields' => array(
                    array(
                        'id'      => 'sof_primary',
                        'type'    => 'switch',
                        'title'   => esc_html__( 'Is Primary', 'sof' ),
                        'default' => false,
                    ),
                    array(
                        'id' => 'sof_monthly_price',
                        'title' => esc_html__('Monthly Price', 'sof'),
                        'type' => 'text',
                        'default' => 0
                    ),
                    array(
                        'id' => 'sof_monthly_price_subtitle',
                        'title' => esc_html__('Monthly Price Subtitle', 'sof'),
                        'type' => 'text',
                        'default' => ''
                    ),
                    array(
                        'id' => 'sof_yearly_price',
                        'title' => esc_html__('Yearly Price', 'sof'),
                        'type' => 'text',
                        'default' => 0
                    ),
                    array(
                        'id' => 'sof_yearly_price_subtitle',
                        'title' => esc_html__('Yearly Price Subtitle', 'sof'),
                        'type' => 'text',
                        'default' => ''
                    ),
                    array(
                        'id' => 'sof_features',
                        'type' => 'repeater',
                        'title' => esc_html__('Features', 'sof'),
                        'fields' => array(
                            array(
                                'id' => 'sof_feature_label',
                                'title' => esc_html__('Label', 'sof'),
                                'type' => 'text',
                            ),
                            array(
                                'id'      => 'sof_feature_active',
                                'type'    => 'switch',
                                'title'   => esc_html__( 'Active', 'sof' ),
                                'default' => 1,
                            ),
                        )
                    ),

                ),
            ),
        ),
    );
}

/**
 * Zero Gym Add Page Meta Options
 *
 * @return void
 */
function sof_add_page_meta_options()
{
    if (!function_exists('get_current_screen')) {
        return;
    }

    $meta_box = sof_get_page_meta_options();
    sof_add_meta_box($meta_box);

}

add_action('add_meta_boxes', 'sof_add_page_meta_options');

/**
 * TenpoCore Render Page Meta Box
 *
 * @return void
 */
function sof_page_meta_box()
{
    $meta_fields = sof_get_page_meta_options();
    sof_render_meta_box($meta_fields);
}

/**
 * TenpoCore Save Page Meta Options
 *
 * @param integer $post_id Post ID.
 * @return void
 */
function sof_save_page_meta_values($post_id)
{
    if (!function_exists('get_current_screen')) {
        return;
    }
    $screen = get_current_screen();

    $meta_options = sof_get_page_meta_options();
    $post_types = $meta_options['post_types'];

    if ($screen && 'post' === $screen->base && in_array($screen->id, $post_types, true)) {
        sof_save_meta_value($post_id, $meta_options['sections']);
    }
}

add_action('save_post', 'sof_save_page_meta_values');
