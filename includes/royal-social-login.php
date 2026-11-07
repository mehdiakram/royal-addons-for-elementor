<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class RoyalAddons_Social_Login_Handler {
    
    public const VERIFY_API = 'https://auth.royaltechbd.com/api/social-login/verify';
    
    public function __construct() {
        add_action( 'init', [ $this, 'handle_auth_code' ] );
    }

    public function handle_auth_code() {
        // Check which parameter the proxy returned
        $auth_code = '';
        $param_used = '';
        
        if ( isset( $_GET['auth_code'] ) && ! empty( $_GET['auth_code'] ) ) {
            $auth_code = sanitize_text_field( $_GET['auth_code'] );
            $param_used = 'auth_code';
        } elseif ( isset( $_GET['rdr_auth_code'] ) && ! empty( $_GET['rdr_auth_code'] ) ) {
            $auth_code = sanitize_text_field( $_GET['rdr_auth_code'] );
            $param_used = 'rdr_auth_code';
        } elseif ( isset( $_GET['royal_auth_code'] ) && ! empty( $_GET['royal_auth_code'] ) ) {
            $auth_code = sanitize_text_field( $_GET['royal_auth_code'] );
            $param_used = 'royal_auth_code';
        }

        if ( empty( $auth_code ) ) {
            return;
        }

        // Verify code with RoyalAuth
        $response = wp_remote_post( self::VERIFY_API, [
            'body' => [
                'auth_code' => $auth_code,
                'software' => 'royaladdonsforelementor'
            ],
            'timeout' => 15
        ]);

        if ( is_wp_error( $response ) ) {
            $this->redirect_with_error( __( 'Could not connect to authentication server.', 'royal-addons-for-elementor' ), $param_used );
        }

        $status = wp_remote_retrieve_response_code( $response );
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( $status !== 200 || empty( $data['success'] ) ) {
            $this->redirect_with_error( $data['error'] ?? __( 'Authentication failed.', 'royal-addons-for-elementor' ), $param_used );
        }

        // Successfully retrieved user info!
        $email = sanitize_email( $data['email'] ?? '' );
        $name = sanitize_text_field( $data['name'] ?? '' );
        
        if ( empty( $email ) ) {
            $this->redirect_with_error( __( 'Email address is required for login.', 'royal-addons-for-elementor' ), $param_used );
        }

        // Check if user exists
        $user = get_user_by( 'email', $email );

        if ( ! $user ) {
            // Register new user
            $password = wp_generate_password( 16, true );
            $user_id = wp_create_user( $email, $password, $email );
            
            if ( is_wp_error( $user_id ) ) {
                $this->redirect_with_error( $user_id->get_error_message(), $param_used );
            }

            $user = get_user_by( 'id', $user_id );
            
            // Set name
            $name_parts = explode( ' ', $name, 2 );
            wp_update_user([
                'ID' => $user_id,
                'first_name' => $name_parts[0] ?? '',
                'last_name' => $name_parts[1] ?? '',
                'display_name' => $name
            ]);
        }

        // Log the user in
        wp_set_current_user( $user->ID );
        wp_set_auth_cookie( $user->ID, true );
        do_action( 'wp_login', $user->user_login, $user );

        // Redirect back to same page without the auth_code parameter
        $redirect_to = remove_query_arg( $param_used );
        wp_safe_redirect( $redirect_to );
        exit;
    }

    private function redirect_with_error( $message, $param_used ) {
        $url = remove_query_arg( $param_used );
        // Append error to show in frontend widget
        $url = add_query_arg( 'royal_login_error', urlencode( $message ), $url );
        wp_safe_redirect( $url );
        exit;
    }
}

new RoyalAddons_Social_Login_Handler();
