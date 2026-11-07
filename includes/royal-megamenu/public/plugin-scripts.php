<?php
// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/public/plugin-scripts.php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

add_action('wp_enqueue_scripts', 'royal_mega_menu_wp_enqueue_scripts');
function royal_mega_menu_wp_enqueue_scripts (){
    wp_enqueue_style( 'royal-megamenu-style', ROYAL_MEGA_MENU_URL . 'public/assets/public/css/royal-mega-menu.css', [], ROYAL_ADDONS_VERSION );

    // Enqueue the mgaccordion plugin script
    wp_enqueue_script( 'mgaccordion', ROYAL_MEGA_MENU_URL . 'public/assets/public/js/mgaccordion.js', ['jquery'], ROYAL_ADDONS_VERSION, true );

    // Enqueue royal-mega-menu-public.js AFTER mgaccordion, as it depends on it
    wp_enqueue_script( 'royal-megamenu-public', ROYAL_MEGA_MENU_URL . 'public/assets/public/js/royal-mega-menu-public.js', ['jquery', 'mgaccordion'], ROYAL_ADDONS_VERSION, true );
}
