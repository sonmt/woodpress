<?php
/**
 * Redux Framework functions
 *
 * @package techmarket
 */

/**
 * Setup functions for theme options
 */

/**
 * Enqueues font awesome for Redux Theme Options
 *
 * @return void
 */
function redux_queue_font_awesome() {
	$font_awesome_url = get_template_directory_uri() . '/assets/vendors/fontawesome/css/all.min.css';
    wp_register_style( 'fontawesome', $font_awesome_url, array(), time(), 'all' );
    wp_enqueue_style( 'fontawesome' );
}

/**
 * Disables Demo mode of Redux Framework
 *
 * @return void
 */
function redux_remove_demo_mode() { // Be sure to rename this function to something more unique
    remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
}

/**
 * Gets product attribute taxonomies
 *
 * @return array
 */
function redux_get_product_attr_taxonomies() {
	$product_attr_taxonomies = array();

	if( function_exists( 'techmarket_get_product_attr_taxonomies' ) ) {
		$product_attr_taxonomies = techmarket_get_product_attr_taxonomies();
	}

	return $product_attr_taxonomies;
}

require_once get_template_directory() . '/inc/redux-framework/functions/general-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/shop-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/header-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/footer-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/social-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/blog-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/style-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/typography-functions.php';
