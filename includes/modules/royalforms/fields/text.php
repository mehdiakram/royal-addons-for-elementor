<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Text extends Field_Base {

	public function get_type() {
		return 'text';
	}

	public function get_name() {
		return esc_html__( 'Text', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'min_length' => [
				'label' => esc_html__( 'Min Length', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'min' => 0,
			],
			'max_length' => [
				'label' => esc_html__( 'Max Length', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'min' => 0,
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['type'] = 'text';

		if ( ! empty( $item['min_length'] ) ) {
			$attrs['minlength'] = $item['min_length'];
		}
		if ( ! empty( $item['max_length'] ) ) {
			$attrs['maxlength'] = $item['max_length'];
		}
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

		if ( ! empty( $field['min_length'] ) && strlen( $value ) < $field['min_length'] ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s must be at least %d characters.', 'royal-addons-for-elementor' ),
					$field['field_label'],
					$field['min_length']
				)
			);
			return false;
		}

		if ( ! empty( $field['max_length'] ) && strlen( $value ) > $field['max_length'] ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s must be no more than %d characters.', 'royal-addons-for-elementor' ),
					$field['field_label'],
					$field['max_length']
				)
			);
			return false;
		}

		return true;
	}
}
