<?php
/**
 * Royal Elementor Theme Compatibility
 * 
 * Note: Royal Elementor theme uses `elementor_theme_do_location()` function
 * which is now defined globally in our plugin. So this file serves as a
 * fallback/additional compatibility layer if needed.
 * 
 * The global `elementor_theme_do_location()` function handles header/footer
 * rendering for Royal Elementor theme automatically.
 */
namespace RoyalAddons\RoyalHF\Themes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Royal Elementor uses elementor_theme_do_location() which is now handled
// by our global-functions.php file. No additional code needed here.
// This file exists for organizational purposes and potential future enhancements.
