<?php
const SOF_VERSION = '1.0.0';
define("SOF_PATH", dirname(__FILE__));
define("SOF_URL", get_stylesheet_directory_uri());
define("SOF_ASSETS", SOF_URL . '/assets' );

/**
 * Admin Enqueue Scripts
 *
 * @param string $page_name Page.
 * @return void
 */

if(!function_exists('sof_admin_enqueue_scripts')) {
    /**
     * Admin Enqueue Scripts
     *
     * @param string $page_name Page.
     * @return void
     */

    function sof_admin_enqueue_scripts( $page_name ) {
        $page = '';
        if ( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) ) { //phpcs:ignore WordPress.Security.NonceVerification
            $page = sanitize_text_field( wp_unslash( $_GET['page'] ) ); //phpcs:ignore WordPress.Security.NonceVerification
        }


        wp_enqueue_style( 'sof-admin-metaboxes', SOF_ASSETS . '/css/admin/metaboxes.css', false, SOF_VERSION, 'all' );

        if ( ! wp_style_is( 'wp-color-picker' ) ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
        }

        if ( 'sof_ilm' !== $page && 'nav-menus.php' !== $page_name ) {
            wp_enqueue_script( 'sof-repeater', SOF_ASSETS . '/js/repeater.js', array( 'jquery' ), SOF_VERSION, true );

            wp_enqueue_style( 'sof-select2', SOF_ASSETS . '/css/select2.css', false, SOF_VERSION, 'all' );
            wp_enqueue_script( 'sof-select2', SOF_ASSETS . '/js/select2.js', array( 'jquery' ), SOF_VERSION, true );

            wp_enqueue_style( 'sof-jquery-ui', SOF_ASSETS . '/css/jquery-ui.css', false, SOF_VERSION, 'all' );
            wp_enqueue_script( 'sof-jquery-ui', SOF_ASSETS . '/js/jquery-ui.js', array( 'jquery' ), SOF_VERSION, true );

            wp_enqueue_script( 'sof-mask', SOF_ASSETS . '/js/jquery.mask.min.js', array( 'jquery' ), SOF_VERSION, true );

            wp_enqueue_script( 'sof-admin-metaboxes', SOF_ASSETS . '/js/admin/metaboxes.js', array( 'jquery', 'sof-jquery-ui' ), SOF_VERSION, true );

        }
    }
}
add_action( 'admin_enqueue_scripts', 'sof_admin_enqueue_scripts' );

/**
 * Path
 *
 * @param $path
 * @return void
 */
function sof_autoload_functions($path) {
    $items = glob( $path . DIRECTORY_SEPARATOR . '*' );
    foreach ( $items as $item ) {
        if ( is_file( $item ) ) {
            $basename = basename( $item );
            if ( 'php' === pathinfo( $item )['extension'] ) {
                include_once $item;
            }
        }
    }

    foreach ( $items as $item ) {
        if ( is_dir( $item ) ) {
            sof_autoload_functions( $item );
        }
    }
}


sof_autoload_functions(SOF_PATH . '/metaboxes');;
