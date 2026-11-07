<?php
/**
 * Theme Support
 */
namespace RoyalAddons\RoyalHF;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Theme_Support {

    private static $instance = null;

    public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    public function __construct() {
        $this->load_theme_compat();
    }

    public function load_theme_compat() {
        $theme = wp_get_theme();
        $theme_slug = strtolower( $theme->get_template() );
        $compat_file = \ROYAL_HF_CORE_DIR . 'themes/' . $theme_slug . '/class-royal-' . $theme_slug . '-compat.php';

        if ( file_exists( $compat_file ) ) {
            require_once $compat_file;
        }
    }
}

Theme_Support::instance();
