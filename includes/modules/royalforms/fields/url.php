<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Url extends Field_Base {

	public function get_type() {
		return 'url';
	}

	public function get_name() {
		return esc_html__( 'URL', 'royal-addons-for-elementor' );
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['type'] = 'url';

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

		if ( ! empty( $value ) && ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s is not a valid URL.', 'royal-addons-for-elementor' ),
					$field['field_label']
				)
			);
			return false;
		}

		return true;
	}

	public function process_value( $value, $field ) {
		return esc_url_raw( $value );
	}
}
