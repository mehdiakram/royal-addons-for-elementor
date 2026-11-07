<?php
// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/admin/plugin-scripts.php


add_action('admin_enqueue_scripts', 'royal_mega_menu_admin_enqueue_scripts');
function royal_mega_menu_admin_enqueue_scripts ($hook) {
    // Only enqueue on the nav-menus page (menu editor)
    if ( 'nav-menus.php' === $hook || 'nav-menus' === get_current_screen()->id ) { 

        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');

        wp_enqueue_style( 'royal-megamenu-admin-style', ROYAL_MEGA_MENU_URL . 'admin/assets/admin/css/royal-mega-menu-admin.css', [], ROYAL_ADDONS_VERSION );
        wp_enqueue_script( 'royal-megamenu-admin', ROYAL_MEGA_MENU_URL . 'admin/assets/admin/js/royal-mega-menu-admin.js', array('jquery'), ROYAL_ADDONS_VERSION, TRUE );

        // Localize the script with ajaxurl and nonce
        wp_localize_script(
                'royal-megamenu-admin',
                'royal_mega_menu_ajax',
                    [
                        'ajaxurl'          => admin_url( 'admin-ajax.php' ),
                        'adminURL'         => admin_url(),
                        'nonce'            => wp_create_nonce('royal_mega_menu_nonce'),
                        'version'          => ROYAL_ADDONS_VERSION,
                    ]
            );
    }
}