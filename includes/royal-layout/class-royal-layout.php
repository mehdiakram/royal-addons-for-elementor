<?php
/**
 * Royal Layout — Core CPT, Hooks, Frontend Injection
 * @package RoyalAddons\RoyalLayout
 */
namespace RoyalAddons\RoyalLayout;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Core {
    private static $instance = null;
    private $renderer;

    public static function instance() {
        if ( null === self::$instance ) { self::$instance = new self(); }
        return self::$instance;
    }

    public function __construct() {
        $this->renderer = Renderer::instance();
        add_action( 'init', [ $this, 'register_cpt' ] );
        add_action( 'wp', [ $this, 'init_frontend' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'maybe_enqueue_css' ] );
    }

    public function register_cpt() {
        register_post_type( 'royal_layout', [
            'labels' => [
                'name'          => __( 'Layouts', 'royal-addons-for-elementor' ),
                'singular_name' => __( 'Layout', 'royal-addons-for-elementor' ),
                'menu_name'     => __( 'Layouts', 'royal-addons-for-elementor' ),
                'add_new'       => __( 'Add New', 'royal-addons-for-elementor' ),
                'add_new_item'  => __( 'Add New Layout', 'royal-addons-for-elementor' ),
                'edit_item'     => __( 'Edit Layout', 'royal-addons-for-elementor' ),
                'all_items'     => __( 'All Layouts', 'royal-addons-for-elementor' ),
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
    }

    public function init_frontend() {
        if ( is_admin() ) { return; }

        $woo = function_exists( 'WC' );

        // Single Product
        if ( $woo && is_singular( 'product' ) && $this->renderer->has_layout( 'single_product' ) ) {
            add_filter( 'template_include', function() {
                return ROYAL_LAYOUT_DIR . 'templates/canvas-product.php';
            }, 999 );
        }

        // Shop Archive
        if ( $woo && ( is_shop() || is_product_category() || is_product_tag() || ( function_exists('is_product_taxonomy') && is_product_taxonomy() ) ) && $this->renderer->has_layout( 'shop_archive' ) ) {
            add_filter( 'template_include', function() {
                return ROYAL_LAYOUT_DIR . 'templates/canvas-archive.php';
            }, 999 );
        }

        // Cart
        if ( $woo && is_cart() ) {
            $wc_cart  = WC()->cart;
            $is_empty = $wc_cart && $wc_cart->is_empty();
            $type     = $is_empty ? 'empty_cart' : 'cart';
            if ( $this->renderer->has_layout( $type ) ) {
                add_filter( 'the_content', function( $content ) use ( $type ) {
                    if ( ! is_cart() ) return $content;
                    $html = $this->renderer->get_layout_html( $type );
                    return $html ?: $content;
                } );
            }
        }

        // Checkout
        if ( $woo && is_checkout() && ! is_order_received_page() && $this->renderer->has_layout( 'checkout_form' ) ) {
            add_filter( 'the_content', function( $content ) {
                if ( ! is_checkout() || is_order_received_page() ) return $content;
                $html = $this->renderer->get_layout_html( 'checkout_form' );
                return $html ?: $content;
            } );
        }

        // Thank You
        if ( $woo && is_order_received_page() && $this->renderer->has_layout( 'thank_you_page' ) ) {
            add_filter( 'the_content', function( $content ) {
                $html = $this->renderer->get_layout_html( 'thank_you_page' );
                return $html ?: $content;
            } );
        }

        // My Account
        if ( $woo && is_account_page() ) {
            $is_auth      = ! is_user_logged_in();
            $is_lost_pass = isset( $_GET['action'] ) && 'lostpassword' === $_GET['action'];
            $account_type = $is_lost_pass ? 'my_account_lost_password' : ( $is_auth ? 'my_account_auth' : 'my_account_page' );
            if ( $this->renderer->has_layout( $account_type ) ) {
                add_filter( 'the_content', function( $content ) use ( $account_type ) {
                    $html = $this->renderer->get_layout_html( $account_type );
                    return $html ?: $content;
                } );
            }
        }

        // Single Post
        if ( is_singular( 'post' ) && $this->renderer->has_layout( 'single_post' ) ) {
            add_filter( 'template_include', function() {
                return ROYAL_LAYOUT_DIR . 'templates/canvas-post.php';
            }, 999 );
        }

        // Blog Archive
        if ( ( is_home() || is_category() || is_tag() || is_author() || is_date() ) && $this->renderer->has_layout( 'blog_archive' ) ) {
            add_filter( 'template_include', function() {
                return ROYAL_LAYOUT_DIR . 'templates/canvas-blog.php';
            }, 999 );
        }
    }

    public function maybe_enqueue_css() {
        if ( is_admin() ) return;
        if ( class_exists( '\Elementor\Plugin' ) ) {
            \Elementor\Plugin::instance()->frontend->enqueue_styles();
        }
    }
}
