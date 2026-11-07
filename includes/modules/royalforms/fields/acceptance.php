<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Acceptance extends Field_Base {

	public function get_type() {
		return 'acceptance';
	}

	public function get_name() {
		return esc_html__( 'Acceptance', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'acceptance_text' => [
				'label' => esc_html__( 'Acceptance Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => esc_html__( 'I agree to the terms and conditions', 'royal-addons-for-elementor' ),
			],
			'checked_by_default' => [
				'label' => esc_html__( 'Checked by Default', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [ 'field_type' => $this->get_type() ],
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );

		$option_id = 'form-field-' . $item['custom_id'];
		$checked = ! empty( $item['checked_by_default'] ) ? ' checked' : '';
		$required = ! empty( $item['required'] ) ? ' required' : '';
		$text = $item['acceptance_text'] ?? esc_html__( 'I agree to the terms and conditions', 'royal-addons-for-elementor' );

		echo '<label class="royal-field-option royal-acceptance" for="' . esc_attr( $option_id ) . '">';
		echo '<input type="checkbox" name="form_fields[' . esc_attr( $item['custom_id'] ) . ']" ';
		echo 'id="' . esc_attr( $option_id ) . '" ';
		echo 'value="on"' . $checked . $required . '>';
		echo '<span class="royal-field-option-label">' . wp_kses_post( $text ) . '</span>';
		echo '</label>';

		$this->render_field_wrapper_end();
	}

	public function validate( $field, $record, $ajax_handler ) {
		if ( ! empty( $field['required'] ) && empty( $field['value'] ) ) {
			$ajax_handler->add_error_message(
				esc_html__( 'You must accept the terms to continue.', 'royal-addons-for-elementor' )
			);
			return false;
		}
		return true;
	}

	public function process_value( $value, $field ) {
		return ! empty( $value ) ? 'Yes' : 'No';
	}
}
