<?php
namespace RoyalAddons\Modules\Forms\Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base class for all form field types
 */
abstract class Field_Base {

	/**
	 * Get field type identifier
	 */
	abstract public function get_type();

	/**
	 * Get field type label for display
	 */
	abstract public function get_name();

	/**
	 * Render the field HTML
	 */
	abstract public function render( $item, $item_index, $form );

	/**
	 * Get field-specific controls for the repeater
	 */
	public function get_field_controls() {
		return [];
	}

	/**
	 * Validate the field value
	 */
	public function validate( $field, $record, $ajax_handler ) {
		// Default validation - required check
		if ( ! empty( $field['required'] ) && empty( $field['value'] ) ) {
			$ajax_handler->add_error_message( 
				sprintf( 
					esc_html__( '%s is required.', 'royal-addons-for-elementor' ), 
					$field['field_label'] 
				) 
			);
			return false;
		}
		return true;
	}

	/**
	 * Process the field value before saving/sending
	 */
	public function process_value( $value, $field ) {
		return sanitize_text_field( $value );
	}

	/**
	 * Get common field attributes
	 */
	protected function get_field_attributes( $item, $form ) {
		$settings = $form->get_settings_for_display();
		$show_placeholder = isset( $settings['show_placeholder'] ) ? $settings['show_placeholder'] : 'yes';
		
		$attrs = [
			'class' => 'royal-form-field royal-form-field-' . $this->get_type(),
			'name' => 'form_fields[' . $item['custom_id'] . ']',
			'id' => 'form-field-' . $item['custom_id'],
		];

		if ( ! empty( $item['placeholder'] ) && 'yes' === $show_placeholder ) {
			$attrs['placeholder'] = $item['placeholder'];
		}

		if ( ! empty( $item['required'] ) ) {
			$attrs['required'] = 'required';
			$attrs['aria-required'] = 'true';
		}

		return $attrs;
	}

	/**
	 * Render attributes as HTML string
	 */
	protected function render_attributes( $attrs ) {
		$html = '';
		foreach ( $attrs as $key => $value ) {
			if ( is_bool( $value ) ) {
				if ( $value ) {
					$html .= ' ' . esc_attr( $key );
				}
			} else {
				$html .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
			}
		}
		return $html;
	}

	/**
	 * Render field wrapper start
	 */
	protected function render_field_wrapper_start( $item ) {

		$class = 'royal-form-field-wrapper royal-form-field-type-' . $this->get_type();
		
		if ( ! empty( $item['css_classes'] ) ) {
			$class .= ' ' . $item['css_classes'];
		}

		// Responsive Layout Layout
		$layout_desktop = ! empty( $item['layout_mode'] ) ? $item['layout_mode'] : 'inline-flex';
		$layout_tablet = ! empty( $item['layout_mode_tablet'] ) ? $item['layout_mode_tablet'] : $layout_desktop;
		$layout_mobile = ! empty( $item['layout_mode_mobile'] ) ? $item['layout_mode_mobile'] : $layout_tablet;

		$item_class = 'royal-form-item';
		$item_class .= ' royal-layout-' . $layout_desktop;
		$item_class .= ' royal-layout-tablet-' . $layout_tablet;
		$item_class .= ' royal-layout-mobile-' . $layout_mobile;

		// Build conditional logic data
		$conditions_data = '';
		if ( ! empty( $item['enable_conditions'] ) && $item['enable_conditions'] === 'yes' ) {
			$conditions = [
				'enabled' => true,
				'field_id' => $item['custom_id'] ?? '',
				'action' => $item['condition_action'] ?? 'show',
				'condition_field' => $item['condition_field'] ?? '',
				'condition_operator' => $item['condition_operator'] ?? 'equals',
				'condition_value' => $item['condition_value'] ?? '',
			];
			$conditions_data = ' data-conditions="' . esc_attr( wp_json_encode( $conditions ) ) . '"';
			
			// Initially hide if action is 'show' (will be controlled by JS)
			if ( $item['condition_action'] === 'show' ) {
				$item_class .= ' royal-form-conditional-hidden';
			}
		}

		$width_desktop = isset( $item['input_size'] ) ? $item['input_size'] : '100';
		$width_tablet = isset( $item['input_size_tablet'] ) ? $item['input_size_tablet'] : '';
		$width_mobile = isset( $item['input_size_mobile'] ) ? $item['input_size_mobile'] : '';

		$style_attr = '--royal-field-w: ' . esc_attr( $width_desktop ) . '%;';
		if ( ! empty( $width_tablet ) ) {
			$style_attr .= ' --royal-field-w-tablet: ' . esc_attr( $width_tablet ) . '%;';
		}
		if ( ! empty( $width_mobile ) ) {
			$style_attr .= ' --royal-field-w-mobile: ' . esc_attr( $width_mobile ) . '%;';
		}

		echo '<div class="' . esc_attr( $item_class ) . '"' . $conditions_data . ' style="' . $style_attr . '">';
		echo '<div class="' . esc_attr( $class ) . '">';
	}

	/**
	 * Render field wrapper end
	 */
	protected function render_field_wrapper_end() {
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Render field label
	 * 
	 * @param array $item Field item data
	 * @param object|null $form Form widget instance for accessing settings
	 */
	protected function render_label( $item, $form = null ) {
		$show_labels = 'yes';
		$mark_required = 'yes';
		
		if ( $form ) {
			$settings = $form->get_settings_for_display();
			$show_labels = isset( $settings['show_labels'] ) ? $settings['show_labels'] : 'yes';
			$mark_required = isset( $settings['mark_required'] ) ? $settings['mark_required'] : 'yes';
		}
		
		if ( 'yes' !== $show_labels || empty( $item['field_label'] ) ) {
			return;
		}

		$required_mark = '';
		if ( ! empty( $item['required'] ) && 'yes' === $mark_required ) {
			$required_mark = '<span class="royal-form-required">*</span>';
		}

		echo '<label for="form-field-' . esc_attr( $item['custom_id'] ) . '" class="royal-form-label">';
		echo esc_html( $item['field_label'] ) . $required_mark;
		echo '</label>';
	}
}
