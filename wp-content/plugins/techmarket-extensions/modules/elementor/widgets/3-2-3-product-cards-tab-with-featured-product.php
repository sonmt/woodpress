<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Elementor 3-2-3 Product Cards Tab with Featured Product Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Techmarket_Elementor_3_2_3_Product_Cards_Tab_With_Featured_Product extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve 3-2-3 Product Cards Tab with Featured Product widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'techmarket_3_2_3_product_cards_tab_with_featured_product';
    }

    /**
     * Get widget title.
     *
     * Retrieve 3-2-3 Product Cards Tab with Featured Product widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( '3-2-3 Product Cards Tab with Featured Product', 'techmarket-extensions' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve 3-2-3 Product Cards Tab with Featured Product widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'fa fa-shopping-bag';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the 3-2-3 Product Cards Tab with Featured Product widget belongs to.
     *
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'techmarket-elements' ];
    }

    /**
     * Register 3-2-3 Product Cards Tab with Featured Product widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'techmarket-extensions' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'section_title',
            [
                'label' => esc_html__( 'Section Title', 'techmarket-extensions' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => esc_html__( 'Enter your section title here.', 'techmarket-extensions' ),
            ]
        );

        $this->add_control(
            'default_active_tab',
            [
                'label' => esc_html__( 'Default Active Tab', 'techmarket-extensions' ),
                'type' => Controls_Manager::TEXT,
                'default' => '1',
                'placeholder' => esc_html__( 'Enter default active tab id.', 'techmarket-extensions' ),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'  => esc_html__( 'Products Tabs Element', 'techmarket-extensions' ),
                'type'   => Controls_Manager::REPEATER,
                'fields' => [

                    [
                        'name'  => 'title',
                        'label' => esc_html__( 'Title', 'techmarket-extensions' ),
                        'type'  => Controls_Manager::TEXT,
                        'description'   => esc_html__('Enter tab title.', 'techmarket-extensions'),
                    ],
                    [
                        'name'  => 'shortcode_tag',
                        'label' => esc_html__( 'Shortcode', 'techmarket-extensions' ),
                        'type'  => Controls_Manager::SELECT,
                        'options'   => [
                            'featured_products'     => esc_html__( 'Featured Products','techmarket-extensions'),
                            'sale_products'         => esc_html__( 'On Sale Products','techmarket-extensions'),
                            'top_rated_products'    => esc_html__( 'Top Rated Products','techmarket-extensions'),
                            'recent_products'       => esc_html__( 'Recent Products','techmarket-extensions'),
                            'best_selling_products' => esc_html__( 'Best Selling Products','techmarket-extensions'),
                            'product_category'      => esc_html__( 'Product Category','techmarket-extensions'),
                            'products'              => esc_html__( 'Products','techmarket-extensions')
                        ],
                        'default' => 'recent_products',
                    ],
                    [
                        'name'  => 'orderby',
                        'label' => esc_html__( 'Order by', 'techmarket-extensions' ),
                        'type'  => Controls_Manager::TEXT,
                        'description'   => esc_html__('Enter orderby.', 'techmarket-extensions'),
                        'default' => 'date',
                    ],
                    [
                        'name'  => 'order',
                        'label' => esc_html__( 'Order', 'techmarket-extensions' ),
                        'type'  => Controls_Manager::TEXT,
                        'description' =>esc_html__('Enter order', 'techmarket-extensions' ),
                        'default' => 'DESC',
                    ],
                    [
                        'name'  => 'product_id',
                        'label' => esc_html__( 'Product IDs', 'techmarket-extensions' ),
                        'type'  => Controls_Manager::TEXT,
                        'description' =>esc_html__('Enter id spearate by comma(,) Note: Only works with Products Shortcode.', 'techmarket-extensions' ),
                        'condition' => [
                            'shortcode_tag' => 'products',
                        ],
                    ],
                    [
                        'name'  => 'category',
                        'label' => esc_html__( 'Category', 'techmarket-extensions' ),
                        'type'  => Controls_Manager::TEXT,
                        'description'   => esc_html__('Enter slug spearate by comma(,) Note: Only works with Product Category Shortcode.', 'techmarket-extensions'),
                        'condition' => [
                            'shortcode_tag' => 'product_category',
                        ],
                    ],
                ],
                'default' => [],
            ]
        );

        $this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'techmarket-extensions' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'techmarket-extensions' ),
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render 3-2-3 Product Cards Tab with Featured Product widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings();

        extract( $settings );

        if( is_object( $tabs ) || is_array( $tabs ) ) {
            $tabs = json_decode( json_encode( $tabs ), true );
        } else {
            $tabs = json_decode( urldecode( $tabs ), true );
        }

        $tabs_args = array();
        
        if( is_array( $tabs ) ) {
            foreach ( $tabs as $key => $tab ) {

                extract(shortcode_atts(array(
                    'title'             => '',
                    'shortcode_tag'     => 'recent_products',
                    'orderby'           => 'date',
                    'order'             => 'desc',
                    'product_id'        => '',
                    'category'          => '',
                ), $tab));
                
                $shortcode_atts = function_exists( 'techmarket_get_atts_for_shortcode' ) ? techmarket_get_atts_for_shortcode( array( 'shortcode' => $shortcode_tag, 'product_category_slug' => $category, 'products_choice' => 'ids', 'products_ids_skus' => $product_id ) ) : array();

                $tabs_args[] = array(
                    'title'             => $title,
                    'shortcode_tag'     => $shortcode_tag,
                    'shortcode_atts'    => wp_parse_args( $shortcode_atts, array( 'order' => $order, 'orderby' => $orderby ) ),
                );
            }
        }

        $args = array(
            'section_title'     => $section_title,
            'default_active_tab'=> empty( $default_active_tab ) ? 3 : $default_active_tab,
            'tabs'              => $tabs_args,
            'section_class'     => $el_class,
        );

        if( function_exists( 'techmarket_3_2_3_product_cards_tab_with_featured_product' ) ) {
            techmarket_3_2_3_product_cards_tab_with_featured_product( $args );
        }
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Techmarket_Elementor_3_2_3_product_cards_tab_with_featured_product );