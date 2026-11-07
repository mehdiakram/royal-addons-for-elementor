<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Radio extends Field_Base {

	public function get_type() {
		return 'radio';
	}

	public function get_name() {
		return esc_html__( 'Radio', 'royal-addons-for-elementor' );
	}

	public function get_field_controls() {
		return [
			'field_options' => [
				'label' => esc_html__( 'Options', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => [ 'field_type' => $this->get_type() ],
				'description' => esc_html__( 'Enter each option on a new line. Use | to separate value and label', 'royal-addons-for-elementor' ),
				'default' => "option1|Option 1\noption2|Option 2\noption3|Option 3",
			],
			'inline_list' => [
				'label' => esc_html__( 'Inline', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [ 'field_type' => $this->get_type() ],
				'default' => '',
			],
		];
	}

	public function render( $item, $item_index, $form ) {
		$this->render_field_wrapper_start( $item );
		$this->render_label( $item, $form );

		$options = $this->parse_options( $item['field_options'] ?? '' );
		$inline_class = ! empty( $item['inline_list'] ) ? ' royal-field-inline' : '';
		$selected_value = $item['field_value'] ?? '';

		echo '<div class="royal-field-options' . esc_attr( $inline_class ) . '">';

		foreach ( $options as $index => $option ) {
			$option_id = 'form-field-' . $item['custom_id'] . '-' . $index;
			$checked = ( $selected_value === $option['value'] ) ? ' checked' : '';
			$required = ! empty( $item['required'] ) ? ' required' : '';

			echo '<label class="royal-field-option" for="' . esc_attr( $option_id ) . '">';
			echo '<input type="radio" name="form_fields[' . esc_attr( $item['custom_id'] ) . ']" ';
			echo 'id="' . esc_attr( $option_id ) . '" ';
			echo 'value="' . esc_attr( $option['value'] ) . '"' . $checked . $required . '>';
			echo '<span class="royal-field-option-label">' . esc_html( $option['label'] ) . '</span>';
			echo '</label>';
		}

		echo '</div>';

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
}
