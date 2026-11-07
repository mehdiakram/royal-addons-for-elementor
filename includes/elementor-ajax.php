<?php
// elementor-ajax.php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start Settings page AJAX handler
add_action('wp_ajax_royal_save_widgets', 'royal_save_widgets_callback');
add_action('wp_ajax_nopriv_royal_save_widgets', 'royal_save_widgets_callback');

function royal_save_widgets_callback() {
    if ( ! current_user_can('manage_options') ) {
        wp_send_json_error('Permission denied');
    }

    if ( empty($_POST['widgets']) || !is_array($_POST['widgets']) ) {
        wp_send_json_error('Invalid data');
    }

    $widgets_array = $_POST['widgets'];

    $widget_lists = require ROYAL_ADDONS_DIR_PATH . 'admin/royalwidgetslist.php';

    if ( ! is_array($widget_lists) ) {
        wp_send_json_error('Widgets list is invalid');
    }

    foreach (['free', 'pro'] as $type) {
        if (!empty($widget_lists[$type])) {
            foreach ($widget_lists[$type] as $key => $value) {
                $widget_key = strtolower($key);
                if (isset($widgets_array[$widget_key])) {
                    update_option($widget_key, $widgets_array[$widget_key] == 1 ? 1 : 0);
                }
            }
        }
    }

    wp_send_json_success('Widgets settings saved successfully!');
}

add_action('wp_ajax_royal_save_extensions', 'royal_save_extensions_callback');
add_action('wp_ajax_nopriv_royal_save_extensions', 'royal_save_extensions_callback');

function royal_save_extensions_callback() {
    if ( ! current_user_can('manage_options') ) {
        wp_send_json_error('Permission denied');
    }

    if ( empty($_POST['extensions']) || !is_array($_POST['extensions']) ) {
        wp_send_json_error('Invalid data');
    }

    $extensions_array = $_POST['extensions'];

    $extention_list = require ROYAL_ADDONS_DIR_PATH . 'admin/royalextentionslist.php';

    if ( ! is_array($extention_list) ) {
        wp_send_json_error('Extensions list is invalid');
    }

    foreach (['free', 'pro'] as $type) {
        if (!empty($extention_list[$type])) {
            foreach ($extention_list[$type] as $key => $value) {
                $ext_key = strtolower($key);
                if (isset($extensions_array[$ext_key])) {
                    update_option($ext_key, $extensions_array[$ext_key] == 1 ? 1 : 0);
                }
            }
        }
    }

    wp_send_json_success('Extensions settings saved successfully!');
}

// AJAX handler for saving license
add_action('wp_ajax_royal_save_license', 'royal_save_license_callback');
add_action('wp_ajax_nopriv_royal_save_license', 'royal_save_license_callback');

function royal_save_license_callback() {
    if ( ! current_user_can('manage_options') ) {
        wp_send_json_error('Permission denied');
    }

    if ( empty($_POST['license_key']) ) {
        wp_send_json_error('License key missing');
    }

    $license_key = sanitize_text_field($_POST['license_key']);
    update_option('royaladdons_license_key', $license_key);

    // Force an online check by clearing the lock
    delete_transient('ra_license_check_lock');

    if ( function_exists('royaladdons_is_license_valid') && royaladdons_is_license_valid() ) {
        wp_send_json_success('License is valid!');
    } else {
        wp_send_json_error('License is invalid!');
    }
}

// AJAX handler for deactivating license
add_action('wp_ajax_royal_deactivate_license', 'royal_deactivate_license_callback');

function royal_deactivate_license_callback() {
    if ( ! current_user_can('manage_options') ) {
        wp_send_json_error( array( 'message' => __( 'Permission denied.', 'royal-addons-for-elementor' ) ) );
    }

    // Verify nonce
    $nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
    if ( ! wp_verify_nonce( $nonce, 'royaladdons_license_nonce' ) ) {
        wp_send_json_error( array( 'message' => __( 'Security check failed.', 'royal-addons-for-elementor' ) ) );
    }

    // Clear all license-related data
    delete_option( 'royaladdons_license_key' );
    delete_option( 'royaladdons_license_expiry_enc' );
    delete_option( 'royaladdons_license_cache' );
    delete_transient( 'ra_license_check_lock' );

    wp_send_json_success( array( 'message' => __( 'License deactivated successfully.', 'royal-addons-for-elementor' ) ) );
}

add_action( 'wp_ajax_royal_load_more_facebook_posts', 'royal_load_more_facebook_posts_callback' );
add_action( 'wp_ajax_nopriv_royal_load_more_facebook_posts', 'royal_load_more_facebook_posts_callback' );

function royal_load_more_facebook_posts_callback() {
    $page_id = sanitize_text_field( $_POST['page_id'] ?? '' );
    $access_token = sanitize_text_field( $_POST['access_token'] ?? '' );
    $posts_per_page = intval( $_POST['posts_per_page'] ?? 5 );
    $after = sanitize_text_field( $_POST['after'] ?? '' );

    if ( empty( $page_id ) || empty( $access_token ) ) {
        wp_send_json_error();
    }

    $url = "https://graph.facebook.com/v15.0/{$page_id}/posts?access_token={$access_token}&limit={$posts_per_page}&fields=message,created_time,full_picture,permalink_url";

    if ( $after ) {
        $url .= "&after={$after}";
    }

    $response = wp_remote_get( $url );

    if ( is_wp_error( $response ) ) {
        wp_send_json_error();
    }

    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body );

    if ( empty( $data->data ) ) {
        wp_send_json_success([
            'posts_html' => '',
            'has_next' => false,
            'next_after' => ''
        ]);
    }

    ob_start();

    foreach ( $data->data as $post ) {
        $message = isset($post->message) ? esc_html($post->message) : '';
        $created_time = isset($post->created_time) ? esc_html( date( 'F j, Y', strtotime( $post->created_time ) ) ) : '';
        $full_picture = isset($post->full_picture) ? esc_url( $post->full_picture ) : '';
        $permalink_url = isset($post->permalink_url) ? esc_url( $post->permalink_url ) : '#';

        echo '<div class="facebook-post" style="border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:5px;">';

        if ( $full_picture ) {
            echo '<div class="facebook-post-image" style="margin-bottom:10px;"><a href="'. $permalink_url .'" target="_blank" rel="nofollow noopener"> <img src="'. $full_picture .'" alt="'. $message .'" style="width:100%; height:auto; border-radius:5px;"></a></div>';
        }

        echo '<div class="facebook-post-content">';
        echo '<p>'. $message .'</p>';
        echo '<small style="color:#666;">'. $created_time .'</small><br>';
        echo '<a href="'. $permalink_url .'" target="_blank" rel="nofollow noopener">'. __( 'View on Facebook', 'royal-addons-for-elementor' ) .'</a>';
        echo '</div>';

        echo '</div>';
    }

    $posts_html = ob_get_clean();

    $next_after = $data->paging->cursors->after ?? '';
    $has_next = !empty( $next_after );

    wp_send_json_success([
        'posts_html' => $posts_html,
        'has_next' => $has_next,
        'next_after' => $next_after,
    ]);
}