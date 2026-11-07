<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hidden extends Field_Base {

	public function get_type() {
		return 'hidden';
	}

	public function get_name() {
		return esc_html__( 'Hidden', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'field_value' => [
				'label' => esc_html__( 'Default Value', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [ 'field_type' => $this->get_type() ],
				'dynamic' => [
					'active' => true,
				],
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$value = $item['field_value'] ?? '';

		// Support dynamic tags
		$dynamic_value = $this->get_dynamic_value( $value );

		echo '<input type="hidden" ';
		echo 'name="form_fields[' . esc_attr( $item['custom_id'] ) . ']" ';
		echo 'value="' . esc_attr( $dynamic_value ) . '">';
	}

	private function get_dynamic_value( $value ) {
		// Handle dynamic placeholders
		$placeholders = [
			'[post_id]' => get_the_ID(),
			'[post_title]' => get_the_title(),
			'[post_url]' => get_permalink(),
			'[user_id]' => get_current_user_id(),
			'[user_email]' => is_user_logged_in() ? wp_get_current_user()->user_email : '',
			'[user_name]' => is_user_logged_in() ? wp_get_current_user()->display_name : '',
			'[date]' => current_time( 'Y-m-d' ),
			'[time]' => current_time( 'H:i:s' ),
			'[referrer]' => wp_get_referer() ?: '',
		];

		return str_replace( array_keys( $placeholders ), array_values( $placeholders ), $value );
	}
}
