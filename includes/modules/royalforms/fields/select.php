<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Select extends Field_Base {

	public function get_type() {
		return 'select';
	}

	public function get_name() {
		return esc_html__( 'Select', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'field_options' => [
				'label' => esc_html__( 'Options', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => [ 'field_type' => $this->get_type() ],
				'description' => esc_html__( 'Enter each option on a new line. Use | to separate value and label (e.g., value|Label)', 'royal-addons-for-elementor' ),
				'default' => "option1|Option 1\noption2|Option 2\noption3|Option 3",
			],
			'allow_multiple' => [
				'label' => esc_html__( 'Multiple Selection', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [ 'field_type' => $this->get_type() ],
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$attrs = $this->get_field_attributes( $item, $form );
		
		if ( ! empty( $item['allow_multiple'] ) ) {
			$attrs['multiple'] = 'multiple';
			$attrs['name'] .= '[]';
		}

		echo '<select' . $this->render_attributes( $attrs ) . '>';
		
		if ( empty( $item['allow_multiple'] ) ) {
			echo '<option value="">' . esc_html__( 'Select...', 'royal-addons-for-elementor' ) . '</option>';
		}

		$options = $this->parse_options( $item['field_options'] ?? '' );
		$selected_value = $item['field_value'] ?? '';

		foreach ( $options as $option ) {
			$selected = ( $selected_value === $option['value'] ) ? ' selected' : '';
			echo '<option value="' . esc_attr( $option['value'] ) . '"' . $selected . '>' . esc_html( $option['label'] ) . '</option>';
		}

		echo '</select>';

		$this->render_field_wrapper_end();
	}

	private function parse_options( $options_string ) {
		$options = [];
		$lines = explode( "\n", $options_string );

		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( empty( $line ) ) {
				continue;
			}

			if ( strpos( $line, '|' ) !== false ) {
				list( $value, $label ) = explode( '|', $line, 2 );
				$options[] = [
					'value' => trim( $value ),
					'label' => trim( $label ),
				];
			} else {
				$options[] = [
					'value' => $line,
					'label' => $line,
				];
			}
		}

		return $options;
	}

	public function process_value( $value, $field ) {
		if ( is_array( $value ) ) {
			return array_map( 'sanitize_text_field', $value );
		}
		return sanitize_text_field( $value );
	}
}
