<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function royal_addons_tweak_disable_elementor_dashboard_widget() {
    remove_meta_box( 'e-dashboard-overview', 'dashboard', 'normal');
}

function royal_addons_tweak_elementor_frontend_config( $config ) {
    $tweak_settings = royal_addons_get_tweak_settings();

    if ( isset( $tweak_settings['disable_elementor_default_colors'] ) && $tweak_settings['disable_elementor_default_colors'] === 'yes' ) {
        $config['elements']['section']['_keys_'][] = 'stretch_section';
        $config['default_custom_colors'] = [];
    }

    if ( isset( $tweak_settings['disable_elementor_default_fonts'] ) && $tweak_settings['disable_elementor_default_fonts'] === 'yes' ) {
        $config['default_schemes']['typography'] = [];
    }

    if ( isset( $tweak_settings['disable_elementor_font_awesome_4'] ) && $tweak_settings['disable_elementor_font_awesome_4'] === 'yes' ) {
        remove_action( 'wp_enqueue_scripts', [ \Elementor\Plugin::instance()->frontend, 'enqueue_font_awesome' ], 9 );
        remove_action( 'wp_enqueue_scripts', [ \Elementor\Plugin::instance()->frontend, 'enqueue_font_awesome_5' ], 9 );
        add_filter( 'elementor/frontend/print_config', function( $config ) {
            $config['has_font_awesome'] = false;
            $config['has_font_awesome_5'] = false;
            return $config;
        });
    }

    return $config;
}
add_filter( 'elementor/frontend/print_config', 'royal_addons_tweak_elementor_frontend_config' );

function royal_addons_tweak_disable_elementor_lightbox( $enabled ) {
    $tweak_settings = royal_addons_get_tweak_settings();
    if ( isset( $tweak_settings['disable_elementor_lightbox'] ) && $tweak_settings['disable_elementor_lightbox'] === 'yes' ) {
        return false;
    }
    return $enabled;
}
add_filter( 'elementor/frontend/lightbox_enabled', 'royal_addons_tweak_disable_elementor_lightbox' );

// CSS for Head
function royal_addons_css_hide_pro() {
    $tweak_settings = royal_addons_get_tweak_settings();
    if ( ! isset( $tweak_settings['disable_elementor_go_pro_notices'] ) || $tweak_settings['disable_elementor_go_pro_notices'] !== 'yes' ) {
        return;
    }
    
    $custom_css = '
        /* High specificity selectors for Elementor Pro "Upgrade/Go Pro" elements */
        #e-admin-top-bar-root .e-admin-top-bar__secondary-area .e-admin-top-bar__bar-button.accent,
        #e-admin-top-bar-root .e-admin-top-bar__secondary-area .e-admin-top-bar__bar-button--go-pro,
        #adminmenu li#toplevel_page_elementor .wp-submenu a[href*="elementor-one-upgrade"],
        #adminmenu li#toplevel_page_elementor .wp-submenu a[href*="go_pro"],
        #adminmenu li#toplevel_page_elementor .wp-submenu a[href*="upgrade"],
        #adminmenu li#toplevel_page_elementor .wp-submenu a[href*="pricing"],
        #adminmenu li#toplevel_page_elementor .wp-submenu a[style*="background"],
        #adminmenu li#toplevel_page_elementor .wp-submenu a .dashicons-star-filled,
        #adminmenu li#toplevel_page_elementor .wp-submenu a .elementor-submenu-icon-upgrade,
        #adminmenu a[href*="elementor-one-upgrade"], 
        .elementor-plugins-gopro,
        .elementor-admin-notice.elementor-go-pro-notice,
        .notice.elementor-message,
        .go_pro,
        .elementor-upgrade-now,
        .elementor-button-go-pro {
            display: none !important;
        }
    ';
    echo '<style id="royal-hide-pro-css">' . $custom_css . '</style>';
}
add_action( 'admin_head', 'royal_addons_css_hide_pro', 2000 );

// JS for Footer
function royal_addons_js_hide_pro() {
    $tweak_settings = royal_addons_get_tweak_settings();
    if ( ! isset( $tweak_settings['disable_elementor_go_pro_notices'] ) || $tweak_settings['disable_elementor_go_pro_notices'] !== 'yes' ) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Function to hide elements
        var hideProElements = function() {
            // 1. Hide Admin Menu Items containing specific URLs or Text
            $('#adminmenu li#toplevel_page_elementor .wp-submenu a').each(function() {
                var href = $(this).attr('href');
                var text = $(this).text().toLowerCase();
                var style = $(this).attr('style');
                
                if ( href && ( href.indexOf('elementor-one-upgrade') !== -1 || href.indexOf('go_pro') !== -1 || href.indexOf('pricing') !== -1 ) ) {
                    $(this).closest('li').hide();
                }
                if ( text && ( text.indexOf('upgrade') !== -1 || text.indexOf('go pro') !== -1 ) ) {
                    $(this).closest('li').hide();
                }
                if ( style && style.indexOf('background') !== -1 ) {
                    $(this).closest('li').hide();
                }
            });

            // 2. Hide Top Bar Button
            $('#e-admin-top-bar-root .e-admin-top-bar__bar-button--go-pro').hide();
            
            // 3. Hide elements with specific classes
            $('.go_pro').hide();
            $('.elementor-upgrade-now').hide();
            $('.elementor-button-go-pro').hide();
        };

        // Run immediately
        hideProElements();
        
        // Run on window load (in case of late rendering)
        $(window).on('load', hideProElements);
        
        // Run periodically for a few seconds to catch dynamic insertions
        setInterval(hideProElements, 500);
    });
    </script>
    <?php
}
add_action( 'admin_footer', 'royal_addons_js_hide_pro', 2000 );

function royal_addons_tweak_hide_elementor_pro_notices_editor_css() {
    $tweak_settings = royal_addons_get_tweak_settings();
    if ( isset( $tweak_settings['disable_elementor_go_pro_notices'] ) && $tweak_settings['disable_elementor_go_pro_notices'] === 'yes' ) {
         $custom_css = '
            .elementor-editor-section-elements .elementor-element-wrapper.elementor-element--promotion,
            .elementor-element-wrapper__description__pro,
            .elementor-editor-ui .elementor-header-buttons .elementor-button-go-pro,
            .elementor-editor-ui .elementor-header-buttons .elementor-button-go-pro-v2,
            .elementor-editor-ui-v2 .elementor-global-actions__wrapper > .elementor-button.elementor-button--go-pro,
            #elementor-header-app #elementor-upgrade-now,
            #elementor-header-app .elementor-header-upgrade-now,
            #elementor-panel-footer-tools .elementor-panel-footer-tool-go-pro {
                display: none !important;
            }
                #e-admin-top-bar-root .e-admin-top-bar__secondary-area .e-admin-top-bar__bar-button.accent,
            #e-admin-top-bar-root .e-admin-top-bar__secondary-area a[href*="elementor-apps"],
            #e-admin-top-bar-root .e-admin-top-bar__secondary-area button .eicon-speakerphone,
            #e-admin-top-bar-root .e-admin-top-bar__secondary-area a[href*="elementor-connect"],
            #e-admin-top-bar-root .e-admin-top-bar__secondary-area a[data-info*="Finder"],
            #elementor-panel #elementor-panel-elements-wrapper .elementor-element--promotion,
            .elementor-panel-footer #elementor-panel__footer__go-pro,
            #elementor-header-app #elementor-go-pro-nav,
            #elementor-panel-footer-tools .elementor-panel-footer-tool-go-pro,
            .elementor-add-section-area-button .elementor-add-section-area-button-title-pro,
            .elementor-editor-section-elements .elementor-element-wrapper.elementor-element--promotion,
            .elementor-element-wrapper__description__pro,
            .elementor-editor-ui .elementor-header-buttons .elementor-button-go-pro,
            .elementor-editor-ui .elementor-header-buttons .elementor-button-go-pro-v2,
            .elementor-editor-ui-v2 .elementor-global-actions__wrapper > .elementor-button.elementor-button--go-pro,
            .elementor-editor-ui-v2 .elementor-global-actions__wrapper > .elementor-button.elementor-button--connect-account,
            .elementor-editor-ui-v2 .elementor-global-actions__wrapper > .elementor-button.elementor-button--whats-new,
            #elementor-header-app #elementor-upgrade-now,
            #elementor-header-app .elementor-header-upgrade-now,
            #elementor-panel-footer-tools .elementor-panel-footer-tool-whats-new,
            .elementor-admin-notice.elementor-go-pro-notice,
            .elementor-notice.elementor-go-pro-notice,
            .notice.elementor-message,
            .e-notice--extended.e-notice--info,
            a[href*="admin.php?page=elementor-one-upgrade"],
            #adminmenu a[href="admin.php?page=elementor-one-upgrade"],
            #adminmenu li#toplevel_page_elementor .wp-submenu a[href*="elementor-one-upgrade"],
            #adminmenu li#toplevel_page_elementor .wp-submenu a[href*="go_pro"],
            #adminmenu li#toplevel_page_elementor .wp-submenu a .elementor-submenu-icon-upgrade,
            #adminmenu li#toplevel_page_elementor .wp-submenu a[style*="background-color"],
            #adminmenu li#toplevel_page_elementor .wp-submenu a[href*="upgrade"],
            #e-admin-top-bar-root .e-admin-top-bar__secondary-area .e-admin-top-bar__bar-button--go-pro,
            .elementor-upgrade-now,
            .elementor-button-go-pro {
                display: none !important;
            }
            /* Specific fix for the Upgrade button in the popup/flyout menu */
            #adminmenu .elementor-upgrade-submenu-link,
            #adminmenu a.elementor-upgrade-link,
            #adminmenu li#toplevel_page_elementor .wp-submenu li a[href*="upgrade"],
            #adminmenu a[href="admin.php?page=elementor-one-upgrade"],
            .elementor-plugins-gopro {
                display: none !important;
            }
            /* Hide by text content (last resort, depends on language) */
             #adminmenu li#toplevel_page_elementor .wp-submenu li a:contains("Upgrade") { 
                display: none !important;
            }
            #e-admin-top-bar-root .e-admin-top-bar__secondary-area a[data-info*="Finder"] .e-admin-top-bar__bar-button-title {
                display: none !important;
            }
        ';
        wp_add_inline_style( 'elementor-editor', $custom_css );
    }
}
add_action( 'elementor/editor/before_enqueue_scripts', 'royal_addons_tweak_hide_elementor_pro_notices_editor_css', 999 );

function royal_addons_tweak_remove_upgrade_menu() {
    $tweak_settings = royal_addons_get_tweak_settings();
    if ( isset( $tweak_settings['disable_elementor_go_pro_notices'] ) && $tweak_settings['disable_elementor_go_pro_notices'] === 'yes' ) {
        remove_submenu_page( 'elementor', 'elementor-one-upgrade' );
        remove_submenu_page( 'elementor', 'go_pro' ); 
        remove_submenu_page( 'elementor', 'elementor-license' );
        
        global $submenu;
        if ( isset( $submenu['elementor'] ) ) {
            foreach ( $submenu['elementor'] as $key => $menu_item ) {
                // Check if the menu title or slug contains upgrade-related keywords
                $title = isset($menu_item[0]) ? strtolower(strip_tags($menu_item[0])) : '';
                $slug = isset($menu_item[2]) ? strtolower($menu_item[2]) : '';
                
                if ( 
                    strpos( $title, 'upgrade' ) !== false || 
                    strpos( $title, 'go pro' ) !== false || 
                    strpos( $title, 'pricing' ) !== false ||
                    strpos( $title, 'license' ) !== false ||
                    strpos( $slug, 'upgrade' ) !== false ||
                    strpos( $slug, 'go_pro' ) !== false ||
                    strpos( $slug, 'pricing' ) !== false ||
                    strpos( $slug, 'elementor-license' ) !== false ||
                    strpos( $menu_item[0], 'elementor-plugins-gopro' ) !== false ||
                    strpos( $menu_item[0], 'elementor-submenu-icon-upgrade' ) !== false ||
                    strpos( $menu_item[0], 'background' ) !== false ||
                    strpos( $menu_item[0], 'color' ) !== false
                ) {
                    unset( $submenu['elementor'][ $key ] );
                }
            }
        }
    }
}
add_action( 'admin_menu', 'royal_addons_tweak_remove_upgrade_menu', 999 );

function royal_addons_get_tweak_settings() {
    return get_option( 'royal_addons_tweak_settings', array() );
}

add_action( 'admin_init', 'royal_addons_apply_tweak_settings' );
function royal_addons_apply_tweak_settings() {
    $tweak_settings = royal_addons_get_tweak_settings();

    if ( isset( $tweak_settings['disable_elementor_dashboard_widget'] ) && $tweak_settings['disable_elementor_dashboard_widget'] === 'yes' ) {
        add_action( 'wp_dashboard_setup', 'royal_addons_tweak_disable_elementor_dashboard_widget', 40 );
    }
}

add_action( 'wp_ajax_royal_save_tweak_settings', 'royal_save_tweak_settings_callback' );
function royal_save_tweak_settings_callback() {
    	check_ajax_referer( 'royal-tweak-nonce', '_ajax_nonce' );

	// Debug logging
	// error_log('Royal Tweak Save Triggered. POST: ' . print_r($_POST, true));

	if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( __( 'You do not have permission to perform this action.', 'royal-addons-for-elementor' ) );
    }

    $tweak_settings = royal_addons_get_tweak_settings(); // Load existing settings

    $all_tweak_keys = array(
        'disable_elementor_dashboard_widget',
        'disable_elementor_default_colors',
        'disable_elementor_default_fonts',
        'disable_elementor_font_awesome_4',
        'disable_elementor_lightbox',
        'disable_elementor_go_pro_notices',
    );

    $old_settings = $tweak_settings; // Store old settings for comparison

    foreach ( $all_tweak_keys as $key ) {
        if ( isset( $_POST[ $key ] ) && $_POST[ $key ] === 'yes' ) {
            $tweak_settings[ $key ] = 'yes';
        } else {
            unset( $tweak_settings[ $key ] );
        }
    }

    // Check if there are actual changes before calling update_option()
    if ( $tweak_settings === $old_settings ) {
        wp_send_json_success( __( 'Settings are already up to date!', 'royal-addons-for-elementor' ) );
    } else {
        $update_result = update_option( 'royal_addons_tweak_settings', $tweak_settings );
        // update_option returns false if value is the same, which is fine.
        wp_send_json_success( __( 'Tweak settings saved successfully!', 'royal-addons-for-elementor' ) );
    }
}