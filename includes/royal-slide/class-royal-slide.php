<?php
/**
 * Royal Slide — Core CPT & Taxonomy
 * @package RoyalAddons\RoyalSlide
 */
namespace RoyalAddons\RoyalSlide;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Core {
    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) { self::$instance = new self(); }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'init', [ $this, 'register_cpt_and_tax' ] );
    }

    public function register_cpt_and_tax() {
        // Taxonomy
        register_taxonomy( 'royal-slider', [ 'royal-slide' ], [
            'labels' => [
                'name'          => __( 'Royal Sliders', 'royal-addons-for-elementor' ),
                'singular_name' => __( 'Royal Slider', 'royal-addons-for-elementor' ),
                'menu_name'     => __( 'Royal Sliders', 'royal-addons-for-elementor' ),
                'all_items'     => __( 'All Sliders', 'royal-addons-for-elementor' ),
                'edit_item'     => __( 'Edit Slider', 'royal-addons-for-elementor' ),
                'update_item'   => __( 'Update Slider', 'royal-addons-for-elementor' ),
                'add_new_item'  => __( 'Add New Slider', 'royal-addons-for-elementor' ),
                'new_item_name' => __( 'New Slider Name', 'royal-addons-for-elementor' ),
            ],
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_nav_menus' => false,
        ] );

        // CPT
        register_post_type( 'royal-slide', [
            'labels' => [
                'name'          => __( 'Royal Slides', 'royal-addons-for-elementor' ),
                'singular_name' => __( 'Royal Slide', 'royal-addons-for-elementor' ),
                'menu_name'     => __( 'Royal Slides', 'royal-addons-for-elementor' ),
                'add_new'       => __( 'Add New Slide', 'royal-addons-for-elementor' ),
                'add_new_item'  => __( 'Add New Slide', 'royal-addons-for-elementor' ),
                'edit_item'     => __( 'Edit Slide', 'royal-addons-for-elementor' ),
                'all_items'     => __( 'All Slides', 'royal-addons-for-elementor' ),
            ],
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => 'royaladdonsforelementor',
            'show_in_nav_menus'   => false,
            'exclude_from_search' => true,
            'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => [ 'title', 'elementor' ],
            'rewrite'             => false,
        ] );

        // Force Elementor support for royal-slide CPT
        $cpt_support = get_option( 'elementor_cpt_support' );
        if ( ! $cpt_support ) {
            $cpt_support = [ 'page', 'post' ];
        }
        if ( ! in_array( 'royal-slide', $cpt_support ) ) {
            $cpt_support[] = 'royal-slide';
            update_option( 'elementor_cpt_support', $cpt_support );
        }
    }
}
