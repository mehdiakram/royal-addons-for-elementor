<?php
/**
 * Global Functions for Royal HF
 * 
 * This file is intentionally NOT namespaced so that the functions
 * are defined in the global namespace and can be called by themes
 * without any namespace prefix.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define elementor_theme_do_location function if Elementor Pro is not active.
 * This allows themes that check for this function (like Hello Elementor, Royal Elementor)
 * to use our custom header/footer templates.
 */
// Defer the check to ensure other plugins (like Pro Elements) have loaded.
add_action( 'plugins_loaded', function() {
    if ( ! function_exists( 'elementor_theme_do_location' ) && ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
        /**
         * Render the content for a theme location.
         * 
         * This function is called by themes like Hello Elementor and Royal Elementor
         * to check if a custom header/footer should be rendered.
         * 
         * @param string $location The location ('header' or 'footer').
         * @return bool Whether the location was rendered. True means the theme should NOT show its default.
         */
        function elementor_theme_do_location( $location ) {
            // Make sure our functions are loaded
            if ( ! function_exists( '\RoyalAddons\RoyalHF\royal_do_elementor_location' ) ) {
                return false;
            }
            return \RoyalAddons\RoyalHF\royal_do_elementor_location( $location );
        }
    }
}, 20 );
