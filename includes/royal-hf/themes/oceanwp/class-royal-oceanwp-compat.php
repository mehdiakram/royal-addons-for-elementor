<?php
namespace RoyalAddons\RoyalHF\Themes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Royal_OceanWP_Compat {

    private static $instance = null;

    public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    public function __construct() {
        add_action( 'template_redirect', [ $this, 'oceanwp_setup_header_footer' ] );
    }

    public function oceanwp_setup_header_footer() {
        // Header override
        if ( \RoyalAddons\RoyalHF\royal_get_header_id() ) {
            remove_action( 'ocean_header', 'oceanwp_header_template' );
            add_action( 'ocean_header', '\RoyalAddons\RoyalHF\royal_render_header' );
        }

        // Footer override - only if we have a custom footer template
        if ( \RoyalAddons\RoyalHF\royal_get_footer_id() ) {
            remove_action( 'ocean_footer', 'oceanwp_footer_template' );
            add_action( 'ocean_footer', '\RoyalAddons\RoyalHF\royal_render_footer' );
        }
        // If only before-footer is set (no custom footer), add it before theme's footer
        elseif ( \RoyalAddons\RoyalHF\royal_get_before_footer_id() ) {
            add_action( 'ocean_footer', '\RoyalAddons\RoyalHF\royal_render_before_footer', 5 );
        }
    }
}

Royal_OceanWP_Compat::instance();
