<?php

    /* Admin Assets */
    add_action( 'admin_enqueue_scripts', 'royaladons_enqueue_admin_assets' );
    function royaladons_enqueue_admin_assets( $hook ) {
        wp_enqueue_style('royaldashboardadmin', ROYAL_ADDONS_DIR_URL.'assets/css/admin-dashboard.css', [], rand(), 'all' );

        // Enqueue SweetAlert2
        wp_enqueue_style( 'royal-sweetalert2', ROYAL_ADDONS_DIR_URL . 'assets/vendor/sweetalert2/sweetalert2.min.css', [], ROYAL_ADDONS_VERSION, 'all' );
        wp_enqueue_script( 'royal-sweetalert2', ROYAL_ADDONS_DIR_URL . 'assets/vendor/sweetalert2/sweetalert2.all.min.js', [], ROYAL_ADDONS_VERSION, true );

        wp_enqueue_script('royaldashboardadmin', ROYAL_ADDONS_DIR_URL.'assets/js/admin-dashboard.js', ['jquery', 'royal-sweetalert2'], rand(), true );
        
        wp_localize_script( 'royaldashboardadmin', 'RoyalAdminConfig', array(
            'license_nonce' => wp_create_nonce('royaladdons_license_nonce'),
            'tweak_nonce'   => wp_create_nonce('royal-tweak-nonce'),
            'i18n'          => array(
                // Deactivate confirm dialog
                'deactivate_title'          => __( 'Deactivate License?', 'royal-addons-for-elementor' ),
                'deactivate_text'           => __( 'Are you sure you want to deactivate your license? All Pro features will be disabled.', 'royal-addons-for-elementor' ),
                'deactivate_confirm_btn'    => __( 'Yes, Deactivate', 'royal-addons-for-elementor' ),
                'deactivate_cancel_btn'     => __( 'Cancel', 'royal-addons-for-elementor' ),
                // Deactivating loading popup
                'deactivating_title'        => __( 'Deactivating...', 'royal-addons-for-elementor' ),
                'deactivating_text'         => __( 'Please wait while your license is being deactivated.', 'royal-addons-for-elementor' ),
                // Success popup
                'deactivated_title'         => __( 'Deactivated!', 'royal-addons-for-elementor' ),
                // Error popups
                'error_title'               => __( 'Error', 'royal-addons-for-elementor' ),
                'deactivate_failed'         => __( 'Deactivation failed.', 'royal-addons-for-elementor' ),
                'connection_error_title'    => __( 'Connection Error', 'royal-addons-for-elementor' ),
                'connection_error_text'     => __( 'Could not connect. Please try again.', 'royal-addons-for-elementor' ),
            ),
        ));
    }


    add_action( 'admin_menu', 'royaladons_admin_menu_page', 9 );

    function royaladons_admin_menu_page() {
        global $menu, $royaladons_admin_menu_page;

        // Menu settings for Royal Addons
        $page_title = esc_html__( 'Royal Addons', 'royal-addons-for-elementor' );
        $menu_title = esc_html__( 'Royal Addons', 'royal-addons-for-elementor' );
        $capability = 'manage_options';
        $menu_slug  = 'royaladdonsforelementor';
        $function   = 'royaladdons_admin_menu_page_display';
        $icon_url   = ROYAL_ADDONS_ASSETS . 'images/royaladdonsforelementor.png';
        $position   = 20; 

        // Add the top-level menu page for Royal Addons
        add_menu_page(
            $page_title,
            $menu_title,
            $capability,
            $menu_slug,
            $function,
            $icon_url,
            $position
        );

        // Add Social Submenu
        add_submenu_page(
            $menu_slug,
            esc_html__( 'Social Integrations', 'royal-addons-for-elementor' ),
            esc_html__( 'Social', 'royal-addons-for-elementor' ),
            $capability,
            'royaladdons-social',
            'royaladdons_social_menu_page_display'
        );
    }

    /* Social Admin Menu Page Output */
    function royaladdons_social_menu_page_display() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Unauthorized user', 'royal-addons-for-elementor' ) );
        }

        require_once( __DIR__ . '/social-template.php' );
    }

    /* Admin Menu Page Output */
    function royaladdons_admin_menu_page_display() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Unauthorized user', 'royal-addons-for-elementor' ) );
        }

        require_once( __DIR__ . '/admin-template.php' );
    }

    add_action( 'admin_menu', 'reorder_royaladdonsforelementor_submenus_for_plugin', 999 );
    function reorder_royaladdonsforelementor_submenus_for_plugin() {
        global $submenu;

        if ( empty( $submenu['royaladdonsforelementor'] ) || ! is_array( $submenu['royaladdonsforelementor'] ) ) {
            return;
        }

        $ordered  = [];
        $leftover = [];

        foreach ( $submenu['royaladdonsforelementor'] as $item ) {
            $slug = isset($item[2]) ? $item[2] : '';
            switch ( $slug ) {
                case 'royaladdonsforelementor':
                    $ordered[10] = $item;
                    break;
                case 'edit.php?post_type=royal-hf':
                    $ordered[20] = $item;
                    break;
                case 'edit.php?post_type=royal_layout':
                    $ordered[22] = $item;
                    break;
                case 'edit.php?post_type=royal-slide':
                    $ordered[23] = $item;
                    break;
                case 'edit-tags.php?taxonomy=royal-slider&post_type=royal-slide':
                    $ordered[24] = $item;
                    break;
                case 'edit.php?post_type=royal_snippet':
                    $ordered[25] = $item;
                    break;
                case 'edit.php?post_type=royal_custom_font':
                    $ordered[30] = $item;
                    break;
                default:
                    $leftover[] = $item;
                    break;
            }
        }

        ksort( $ordered );
        
        $final_submenu = [];
        foreach ( $ordered as $item ) {
            $final_submenu[] = $item;
        }
        foreach ( $leftover as $item ) {
            $final_submenu[] = $item;
        }

        $submenu['royaladdonsforelementor'] = $final_submenu;
    }

