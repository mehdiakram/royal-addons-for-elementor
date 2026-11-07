<?php

namespace RoyalAddons\RoyalHF;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Loader {

	private static $instance = null;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
        $this->load_files();
    }

    public function load_files() {
        // Load global functions (not namespaced) for elementor_theme_do_location
        // This function has a fallback check if the namespaced functions aren't loaded yet
        require_once \ROYAL_HF_CORE_DIR . 'global-functions.php';
        
        // Load main class which includes all other files
        require_once \ROYAL_HF_CORE_DIR . 'class-royal-hf.php';
        Core::instance();
    }
}

Loader::instance();
