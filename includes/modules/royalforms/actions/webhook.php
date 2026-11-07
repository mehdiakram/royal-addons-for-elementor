<?php
namespace RoyalAddons\Modules\Forms\Actions;

use RoyalAddons\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Webhook extends Action_Base {

	public function get_name() {
		return 'webhook';
	}

	public function get_label() {
		return esc_html__( 'Webhook', 'royal-addons-for-elementor' );
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get_form_settings();
		$fields = $record->get_formatted_data();

		$webhook_url = isset( $settings['webhook_url'] ) ? $settings['webhook_url'] : '';

		if ( empty( $webhook_url ) ) {
			return;
		}

		// Build payload
		$payload = [
			'form_id'   => $settings['form_id'] ?? '',
			'form_name' => $settings['form_name'] ?? '',
			'fields'    => $fields,
			'meta'      => [
				'page_url'    => isset( $_POST['page_url'] ) ? esc_url_raw( $_POST['page_url'] ) : '',
				'post_id'     => isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0,
				'user_id'     => get_current_user_id(),
				'submit_time' => current_time( 'c' ),
				'site_url'    => site_url(),
				'site_name'   => get_bloginfo( 'name' ),
			],
		];

		// Allow filtering the payload
		$payload = apply_filters( 'royal_form_webhook_payload', $payload, $record, $settings );

		// Send webhook
		$response = wp_remote_post( $webhook_url, [
			'body'        => wp_json_encode( $payload ),
			'headers'     => [
				'Content-Type' => 'application/json',
			],
			'timeout'     => 30,
			'data_format' => 'body',
		] );

		if ( is_wp_error( $response ) ) {
			// Log error but don't show to user
			error_log( 'Royal Form Webhook Error: ' . $response->get_error_message() );
		}
	}
}
