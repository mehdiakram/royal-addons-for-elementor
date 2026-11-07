<?php
/**
 * Royal Layout — Elementor Content Renderer
 * @package RoyalAddons\RoyalLayout
 */
namespace RoyalAddons\RoyalLayout;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Renderer {
    private static $instance = null;
    private $conditions;

    public static function instance() {
        if ( null === self::$instance ) { self::$instance = new self(); }
        return self::$instance;
    }

    public function __construct() {
        $this->conditions = Conditions::instance();
    }

    public function render( $post_id ) {
        if ( ! class_exists( '\Elementor\Plugin' ) ) { return ''; }
        $this->enqueue_css( $post_id );
        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post_id, true );
    }

    public function get_layout_html( $type ) {
        $layout_id = $this->conditions->get_layout_id( $type );
        if ( ! $layout_id ) { return false; }
        return $this->render( $layout_id );
    }

    public function enqueue_css( $post_id ) {
        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
            $css = new \Elementor\Core\Files\CSS\Post( $post_id );
            $css->enqueue();
        }
    }

    public function has_layout( $type ) {
        return $this->conditions->has_layout( $type );
    }

    public function get_layout_id( $type ) {
        return $this->conditions->get_layout_id( $type );
    }
}
