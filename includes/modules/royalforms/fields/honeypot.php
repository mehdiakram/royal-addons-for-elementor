<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Honeypot extends Field_Base {

	public function get_type() {
		return 'honeypot';
	}

	public function get_name() {
		return esc_html__( 'Honeypot', 'royal-addons-for-elementor' );
	}

	public function render( $item, $item_index, $form ) {
		// Honeypot field is hidden from users but visible to bots
		echo '<div class="royal-form-honeypot" style="position: absolute; left: -9999px; opacity: 0; height: 0; width: 0; overflow: hidden;" aria-hidden="true">';
		echo '<label for="form-field-' . esc_attr( $item['custom_id'] ) . '">' . esc_html__( 'Leave this field empty', 'royal-addons-for-elementor' ) . '</label>';
		echo '<input type="text" name="form_fields[' . esc_attr( $item['custom_id'] ) . ']" id="form-field-' . esc_attr( $item['custom_id'] ) . '" tabindex="-1" autocomplete="off">';
		echo '</div>';
	}

	public function validate( $field, $record, $ajax_handler ) {
		// If honeypot field has a value, it's likely a bot
		if ( ! empty( $field['value'] ) ) {
			$ajax_handler->add_error_message(
				esc_html__( 'Bot detected.', 'royal-addons-for-elementor' )
			);
			return false;
		}
		return true;
	}

	public function process_value( $value, $field ) {
		return ''; // Honeypot doesn't submit a value
	}
}
