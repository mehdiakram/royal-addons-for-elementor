<?php
namespace RoyalAddons\RoyalHF\Themes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Royal_GeneratePress_Compat {

    private static $instance = null;

    public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    public function __construct() {
        add_action( 'template_redirect', [ $this, 'gp_setup_header_footer' ] );
    }

    public function gp_setup_header_footer() {
        // Header override
        if ( \RoyalAddons\RoyalHF\royal_get_header_id() ) {
            remove_action( 'generate_header', 'generate_construct_header' );
            add_action( 'generate_header', '\RoyalAddons\RoyalHF\royal_render_header' );
        }

        // Footer override - only if we have a custom footer template
        if ( \RoyalAddons\RoyalHF\royal_get_footer_id() ) {
            remove_action( 'generate_footer', 'generate_construct_footer' );
            add_action( 'generate_footer', '\RoyalAddons\RoyalHF\royal_render_footer' );
        }
        // If only before-footer is set (no custom footer), add it before theme's footer
        elseif ( \RoyalAddons\RoyalHF\royal_get_before_footer_id() ) {
            add_action( 'generate_footer', '\RoyalAddons\RoyalHF\royal_render_before_footer', 5 );
        }
    }
}

Royal_GeneratePress_Compat::instance();
