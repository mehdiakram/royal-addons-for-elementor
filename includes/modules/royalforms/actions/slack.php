<?php
namespace RoyalAddons\Modules\Forms\Actions;

use RoyalAddons\Modules\Forms\Classes\Action_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Slack extends Action_Base {

	public function get_name() {
		return 'slack';
	}

	public function get_label() {
		return esc_html__( 'Slack', 'royal-addons-for-elementor' );
	}

	public function run( $record, $ajax_handler ) {
		$settings = $record->get_form_settings();
		$fields = $record->get_formatted_data();

		$webhook_url = isset( $settings['slack_webhook_url'] ) ? $settings['slack_webhook_url'] : '';

		if ( empty( $webhook_url ) ) {
			return;
		}

		// Build message
		$form_name = $settings['form_name'] ?? 'Form';
		$page_url = $record->get_meta( 'page_url' );
		
		$message_text = "*New {$form_name} Submission*\n";
		
		// Get field labels from settings
		$form_fields = isset( $settings['form_fields'] ) ? $settings['form_fields'] : [];
		$field_labels = [];
		foreach ( $form_fields as $field ) {
			if ( isset( $field['custom_id'] ) && isset( $field['field_label'] ) ) {
				$field_labels[ $field['custom_id'] ] = $field['field_label'];
			}
		}
		
		// Build field list
		$field_blocks = [];
		foreach ( $fields as $key => $value ) {
			if ( empty( $value ) ) continue;
			
			$label = isset( $field_labels[ $key ] ) ? $field_labels[ $key ] : $key;
			$field_blocks[] = [
				'type' => 'mrkdwn',
				'text' => "*{$label}:*\n{$value}",
			];
		}

		// Slack Block Kit payload
		$payload = [
			'blocks' => [
				[
					'type' => 'header',
					'text' => [
						'type' => 'plain_text',
						'text' => "📋 New {$form_name} Submission",
						'emoji' => true,
					],
				],
				[
					'type' => 'section',
					'fields' => array_slice( $field_blocks, 0, 10 ), // Slack limit
				],
			],
		];

		// Add more fields if needed
		if ( count( $field_blocks ) > 10 ) {
			$payload['blocks'][] = [
				'type' => 'section',
				'fields' => array_slice( $field_blocks, 10, 10 ),
			];
		}

		// Add page URL
		if ( $page_url ) {
			$payload['blocks'][] = [
				'type' => 'context',
				'elements' => [
					[
						'type' => 'mrkdwn',
						'text' => "Submitted from: <{$page_url}|View Page>",
					],
				],
			];
		}

		// Add timestamp
		$payload['blocks'][] = [
			'type' => 'context',
			'elements' => [
				[
					'type' => 'plain_text',
					'text' => 'Submitted: ' . current_time( 'F j, Y g:i a' ),
				],
			],
		];

		// Send to Slack
		$response = wp_remote_post( $webhook_url, [
			'body'        => wp_json_encode( $payload ),
			'headers'     => [
				'Content-Type' => 'application/json',
			],
			'timeout'     => 30,
		] );

		if ( is_wp_error( $response ) ) {
			error_log( 'Royal Form Slack Error: ' . $response->get_error_message() );
		}
	}
}
