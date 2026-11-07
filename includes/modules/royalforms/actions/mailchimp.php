<?php
namespace RoyalAddons\Modules\Forms\Actions;

use RoyalAddons\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mailchimp extends Action_Base {

	public function get_name() {
		return 'mailchimp';
	}

	public function get_label() {
		return esc_html__( 'Mailchimp', 'royal-addons-for-elementor' );
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get_form_settings();
		$fields = $record->get_formatted_data();

		$api_key = get_option( 'royal_mailchimp_api_key', '' );
		$list_id = isset( $settings['mailchimp_list'] ) ? $settings['mailchimp_list'] : '';

		if ( empty( $api_key ) || empty( $list_id ) ) {
			return;
		}

		// Get email field
		$email_field = isset( $settings['mailchimp_email_field'] ) ? $settings['mailchimp_email_field'] : 'email';
		$email = isset( $fields[ $email_field ] ) ? $fields[ $email_field ] : '';

		if ( empty( $email ) || ! is_email( $email ) ) {
			return;
		}

		// Get name fields
		$first_name_field = isset( $settings['mailchimp_first_name_field'] ) ? $settings['mailchimp_first_name_field'] : '';
		$last_name_field = isset( $settings['mailchimp_last_name_field'] ) ? $settings['mailchimp_last_name_field'] : '';

		$merge_fields = [];
		if ( ! empty( $first_name_field ) && isset( $fields[ $first_name_field ] ) ) {
			$merge_fields['FNAME'] = $fields[ $first_name_field ];
		}
		if ( ! empty( $last_name_field ) && isset( $fields[ $last_name_field ] ) ) {
			$merge_fields['LNAME'] = $fields[ $last_name_field ];
		}

		// Get DC from API key
		$dc = 'us1';
		if ( strpos( $api_key, '-' ) !== false ) {
			list( , $dc ) = explode( '-', $api_key );
		}

		$api_url = "https://{$dc}.api.mailchimp.com/3.0/lists/{$list_id}/members";

		$body = [
			'email_address' => $email,
			'status'        => isset( $settings['mailchimp_double_optin'] ) && $settings['mailchimp_double_optin'] ? 'pending' : 'subscribed',
		];

		if ( ! empty( $merge_fields ) ) {
			$body['merge_fields'] = $merge_fields;
		}

		// Add tags if specified
		if ( ! empty( $settings['mailchimp_tags'] ) ) {
			$body['tags'] = array_map( 'trim', explode( ',', $settings['mailchimp_tags'] ) );
		}

		$response = wp_remote_post( $api_url, [
			'body'    => wp_json_encode( $body ),
			'headers' => [
				'Content-Type'  => 'application/json',
				'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key ),
			],
			'timeout' => 30,
		] );

		if ( is_wp_error( $response ) ) {
			error_log( 'Royal Form Mailchimp Error: ' . $response->get_error_message() );
		} else {
			$response_code = wp_remote_retrieve_response_code( $response );
			if ( $response_code >= 400 ) {
				$body = json_decode( wp_remote_retrieve_body( $response ), true );
				error_log( 'Royal Form Mailchimp Error: ' . ( $body['detail'] ?? 'Unknown error' ) );
			}
		}
	}
}
