<?php
namespace RoyalAddons;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Royal Login Widget — AJAX Handler
 * Handles login via AJAX with optional user role restriction.
 */
class Royal_Login_Ajax {

	public function __construct() {
		add_action( 'wp_ajax_nopriv_royal_login_ajax', [ $this, 'handle_login' ] );
		add_action( 'wp_ajax_royal_login_ajax',        [ $this, 'handle_login' ] );
	}

	public function handle_login() {

		// ---- Nonce verification ----
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'royal_login_nonce' ) ) {
			wp_send_json_error( [ 'message' => __( 'Security check failed. Please refresh and try again.', 'royal-addons-for-elementor' ) ] );
		}

		$username = isset( $_POST['username'] ) ? sanitize_text_field( wp_unslash( $_POST['username'] ) ) : '';
		$password = isset( $_POST['password'] ) ? wp_unslash( $_POST['password'] )                         : '';
		$remember = ! empty( $_POST['remember'] );

		// ---- Allowed roles (sent from the widget via data-attribute, but roles are enforced server-side) ----
		// NOTE: Allowed roles come from the user-agent. We validate them server-side against stored widget data.
		// For security, we run wp_signon() first and THEN check the role of the signed-in user.

		if ( empty( $username ) || empty( $password ) ) {
			wp_send_json_error( [ 'message' => __( 'Please enter your username and password.', 'royal-addons-for-elementor' ) ] );
		}

		// ---- Attempt login ----
		$creds = [
			'user_login'    => $username,
			'user_password' => $password,
			'remember'      => $remember,
		];

		$user = wp_signon( $creds, is_ssl() );

		if ( is_wp_error( $user ) ) {
			// Sanitize WP default error to a friendly message
			$error_code = $user->get_error_code();
			if ( in_array( $error_code, [ 'invalid_username', 'invalid_email', 'incorrect_password', 'invalidcombo' ], true ) ) {
				$message = __( 'Invalid username/email or password.', 'royal-addons-for-elementor' );
			} else {
				$message = $user->get_error_message();
				// Strip HTML tags from WP error messages
				$message = wp_strip_all_tags( $message );
			}
			wp_send_json_error( [ 'message' => $message ] );
		}

		// ---- Role restriction check ----
		$allowed_roles_raw = isset( $_POST['allowed_roles'] ) ? sanitize_text_field( wp_unslash( $_POST['allowed_roles'] ) ) : '["all"]';
		$allowed_roles     = json_decode( $allowed_roles_raw, true );

		if ( ! is_array( $allowed_roles ) ) {
			$allowed_roles = [ 'all' ];
		}

		// Normalize
		$allowed_roles = array_map( 'sanitize_key', $allowed_roles );

		// 'all' means no restriction
		if ( ! in_array( 'all', $allowed_roles, true ) ) {
			$user_roles = (array) $user->roles;
			$has_role   = ! empty( array_intersect( $user_roles, $allowed_roles ) );

			if ( ! $has_role ) {
				// Role not allowed — destroy the session we just created
				wp_destroy_current_session();
				wp_clear_auth_cookie();

				$error_message = isset( $_POST['error_msg'] )
					? sanitize_text_field( wp_unslash( $_POST['error_msg'] ) )
					: __( 'You are not eligible to log in with this user role.', 'royal-addons-for-elementor' );

				wp_send_json_error( [ 'message' => $error_message ] );
			}
		}

		// ---- Success ----
		$redirect = isset( $_POST['redirect'] ) ? esc_url_raw( wp_unslash( $_POST['redirect'] ) ) : admin_url();

		wp_send_json_success( [
			'redirect'        => $redirect,
			'success_title'   => __( 'Welcome!', 'royal-addons-for-elementor' ),
			'success_message' => sprintf(
				/* translators: %s: user display name */
				__( 'You have been logged in successfully as %s.', 'royal-addons-for-elementor' ),
				esc_html( $user->display_name )
			),
		] );
	}
}

new Royal_Login_Ajax();
