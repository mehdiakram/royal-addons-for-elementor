<?php
namespace RoyalAddons\Modules\Forms\Actions;

use RoyalAddons\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Discord extends Action_Base {

	public function get_name() {
		return 'discord';
	}

	public function get_label() {
		return esc_html__( 'Discord', 'royal-addons-for-elementor' );
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get_form_settings();
		$fields = $record->get_formatted_data();

		$webhook_url = isset( $settings['discord_webhook_url'] ) ? $settings['discord_webhook_url'] : '';

		if ( empty( $webhook_url ) ) {
			return;
		}

		// Build message
		$form_name = $settings['form_name'] ?? 'Form';
		$page_url = $record->get_meta( 'page_url' );
		
		// Get field labels from settings
		$form_fields = isset( $settings['form_fields'] ) ? $settings['form_fields'] : [];
		$field_labels = [];
		foreach ( $form_fields as $field ) {
			if ( isset( $field['custom_id'] ) && isset( $field['field_label'] ) ) {
				$field_labels[ $field['custom_id'] ] = $field['field_label'];
			}
		}
		
		// Build embed fields
		$embed_fields = [];
		foreach ( $fields as $key => $value ) {
			if ( empty( $value ) ) continue;
			
			$label = isset( $field_labels[ $key ] ) ? $field_labels[ $key ] : $key;
			$embed_fields[] = [
				'name'   => $label,
				'value'  => mb_substr( $value, 0, 1024 ), // Discord limit
				'inline' => strlen( $value ) < 50,
			];
		}

		// Discord embed payload
		$payload = [
			'embeds' => [
				[
					'title'       => "📋 New {$form_name} Submission",
					'color'       => 5814783, // Blue color
					'fields'      => array_slice( $embed_fields, 0, 25 ), // Discord limit
					'footer'      => [
						'text' => 'Submitted: ' . current_time( 'F j, Y g:i a' ),
					],
					'timestamp'   => current_time( 'c' ),
				],
			],
		];

		// Add page URL to description if available
		if ( $page_url ) {
			$payload['embeds'][0]['description'] = "Submitted from: [{$page_url}]({$page_url})";
		}

		// Send to Discord
		$response = wp_remote_post( $webhook_url, [
			'body'        => wp_json_encode( $payload ),
			'headers'     => [
				'Content-Type' => 'application/json',
			],
			'timeout'     => 30,
		] );

		if ( is_wp_error( $response ) ) {
			error_log( 'Royal Form Discord Error: ' . $response->get_error_message() );
		}
	}
}
