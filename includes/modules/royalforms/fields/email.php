<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Email extends Field_Base {

	public function get_type() {
		return 'email';
	}

	public function get_name() {
		return esc_html__( 'Email', 'royal-addons-for-elementor' );
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['type'] = 'email';

		if ( ! empty( $item['field_value'] ) ) {
			$attrs['value'] = $item['field_value'];
		}

		echo '<input' . $this->render_attributes( $attrs ) . '>';

		$this->render_field_wrapper_end();
	}

	public function validate( $field, $record, $ajax_handler ) {
		if ( ! parent::validate( $field, $record, $ajax_handler ) ) {
			return false;
		}

		$value = $field['value'];

		if ( ! empty( $value ) && ! is_email( $value ) ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s is not a valid email address.', 'royal-addons-for-elementor' ),
					$field['field_label']
				)
			);
			return false;
		}

		return true;
	}

	public function process_value( $value, $field ) {
		return sanitize_email( $value );
	}
}
