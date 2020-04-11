<?php
/**
 * Techmarket Options. Theme Options available for Techmarket
 */
if ( ! class_exists( 'ReduxFramework' ) ) {
	return;
}

if ( ! class_exists( 'Techmarket_Options' ) ) :

	class Techmarket_Options{

		public function __construct( ) {
			add_action( 'after_setup_theme', array( $this, 'load_config' ) );
		}

		public function load_config() {

			$options     = array( 'general', 'header', 'shop', 'blog', 'footer', 'social', 'style', 'typography' );
			$options_dir = get_template_directory() . '/inc/redux-framework/options';

			foreach( $options as $option ) {
				$options_file = $options_dir . '/' . $option . '-options.php';
				
				if ( file_exists( $options_file ) ) {
					require_once $options_file;
				}
			}

			$sections 	= apply_filters( 'techmarket_options_sections_args', array( $general_options, $header_options, $shop_options, $blog_options, $footer_options, $social_options, $style_options, $typography_options ) );
			$theme 		= wp_get_theme();
			$args 		= array(
				'opt_name'          => 'techmarket_options',
				'display_name'      => $theme->get( 'Name' ),
				'display_version'   => $theme->get( 'Version' ),
				'allow_sub_menu'    => true,
				'menu_title'        => esc_html__( 'Techmarket', 'techmarket' ),
				'page_priority'     => 3,
				'page_slug'         => 'theme_options',
				'intro_text'        => '',
				'dev_mode'          => false,
				'customizer'        => true,
				'footer_credit'     => '&nbsp;',
			);
			
			$ReduxFramework = new ReduxFramework( $sections, $args );
		}
	}

	new Techmarket_Options();

endif;

if( ! array_key_exists( 'techmarket_options' , $GLOBALS ) ) {
	$GLOBALS['techmarket_options'] = get_option( 'techmarket_options', array() );
}