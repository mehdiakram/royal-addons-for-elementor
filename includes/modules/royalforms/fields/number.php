<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Number extends Field_Base {

	public function get_type() {
		return 'number';
	}

	public function get_name() {
		return esc_html__( 'Number', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'min_value' => [
				'label' => esc_html__( 'Min Value', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
			],
			'max_value' => [
				'label' => esc_html__( 'Max Value', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
			],
			'number_step' => [
				'label' => esc_html__( 'Step', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => 1,
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		$attrs['type'] = 'number';

		if ( isset( $item['min_value'] ) && '' !== $item['min_value'] ) {
			$attrs['min'] = $item['min_value'];
		}
		if ( isset( $item['max_value'] ) && '' !== $item['max_value'] ) {
			$attrs['max'] = $item['max_value'];
		}
		if ( ! empty( $item['number_step'] ) ) {
			$attrs['step'] = $item['number_step'];
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

		if ( '' === $value ) {
			return true;
		}

		if ( ! is_numeric( $value ) ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s must be a number.', 'royal-addons-for-elementor' ),
					$field['field_label']
				)
			);
			return false;
		}

		if ( isset( $field['min_value'] ) && '' !== $field['min_value'] && floatval( $value ) < floatval( $field['min_value'] ) ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s must be at least %s.', 'royal-addons-for-elementor' ),
					$field['field_label'],
					$field['min_value']
				)
			);
			return false;
		}

		if ( isset( $field['max_value'] ) && '' !== $field['max_value'] && floatval( $value ) > floatval( $field['max_value'] ) ) {
			$ajax_handler->add_error_message(
				sprintf(
					esc_html__( '%s must be no more than %s.', 'royal-addons-for-elementor' ),
					$field['field_label'],
					$field['max_value']
				)
			);
			return false;
		}

		return true;
	}

	public function process_value( $value, $field ) {
		return is_numeric( $value ) ? floatval( $value ) : '';
	}
}
