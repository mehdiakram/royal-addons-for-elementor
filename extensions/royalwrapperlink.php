<?php

use Elementor\Controls_Manager;
use Elementor\Element_Base;

defined('ABSPATH') || die();

class RoyalWrapperLink {

	static $should_script_enqueue = false;

	public static function init() {
		// Legacy elements (widgets, sections, columns, containers)
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'register_legacy_controls' ], 10, 2 );

		// Frontend: inject data attribute before render
		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'before_render' ], 1 );

		// Script enqueue
		add_action( 'elementor/frontend/before_render',        [ __CLASS__, 'maybe_enqueue' ] );
		add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'maybe_enqueue' ] );
		add_action( 'elementor/preview/enqueue_scripts',       [ __CLASS__, 'enqueue_scripts' ] );
	}

	/* ------------------------------------------------------------------ */
	/* Script Enqueue                                                        */
	/* ------------------------------------------------------------------ */

	public static function enqueue_scripts() {
		$js_file = ROYAL_ADDONS_DIR_PATH . 'assets/js/extension-royalwrapperlink.js';
		if ( file_exists( $js_file ) ) {
			wp_add_inline_script( 'elementor-frontend', file_get_contents( $js_file ) );
		}
	}

	public static function maybe_enqueue( $element ) {
		if ( self::$should_script_enqueue ) {
			return;
		}

		$switch = self::get_prop( self::get_raw_settings( $element ), 'wrapper_link_switch' );

		if ( self::is_on( $switch ) ) {
			self::$should_script_enqueue = true;
			self::enqueue_scripts();
			remove_action( 'elementor/frontend/before_render',        [ __CLASS__, 'maybe_enqueue' ] );
			remove_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'maybe_enqueue' ] );
		}
	}

	/* ------------------------------------------------------------------ */
	/* Legacy API — Widgets / Sections / Columns / Containers               */
	/* ------------------------------------------------------------------ */

	private static $registered_elements = [];

	public static function register_legacy_controls( $element, $section_id = '' ) {
		$trigger_ids = [
			'section_advanced', 'section_custom_css_pro',
			'_section_style', 'section_layout', '_section_layout', '_section_responsive',
		];
		if ( ! in_array( $section_id, $trigger_ids, true ) ) {
			return;
		}

		if ( ! ( $element instanceof Element_Base ) ) {
			return;
		}

		// Skip Atomic elements — Wrapper Link is disabled for Atomic widgets
		if ( self::is_atomic( $element ) ) {
			return;
		}

		$el_name = $element->get_name();
		if ( isset( self::$registered_elements[ $el_name ] ) ) {
			return;
		}
		self::$registered_elements[ $el_name ] = true;

		$tab = in_array( $el_name, [ 'section', 'column', 'container', 'e-con' ], true )
			? Controls_Manager::TAB_LAYOUT
			: Controls_Manager::TAB_CONTENT;

		$element->start_controls_section(
			'royalcontrolsection_wrapperlink',
			[
				'label' => __( 'Wrapper Link [Royal]', 'royal-addons-for-elementor' ),
				'tab'   => $tab,
			]
		);

		$element->add_control(
			'wrapper_link_switch',
			[
				'label'        => esc_html__( 'Active', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$element->add_control(
			'royal_element_link',
			[
				'label'       => __( 'Your Link', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'wrapper_link_switch' => 'yes' ],
			]
		);

		$element->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Frontend Render — inject data-royal-element-link                      */
	/* ------------------------------------------------------------------ */

	public static function before_render( $element ) {
		if ( ! ( $element instanceof Element_Base ) ) {
			return;
		}

		// Wrapper link is disabled for Atomic elements
		if ( self::is_atomic( $element ) ) {
			return;
		}

		$raw      = self::get_raw_settings( $element );
		$switch   = self::get_prop( $raw, 'wrapper_link_switch' );

		if ( ! self::is_on( $switch ) ) {
			return;
		}

		// Legacy: URL stored as Elementor URL control array
		$link_settings = self::get_prop( $raw, 'royal_element_link', [] );

		if ( empty( $link_settings['url'] ) ) {
			return;
		}
		$link_data = $link_settings;

		$element->add_render_attribute(
			'_wrapper',
			[
				'data-royal-element-link' => wp_json_encode( $link_data ),
				'style'                   => 'cursor: pointer',
			]
		);
	}

	/* ------------------------------------------------------------------ */
	/* Helpers                                                               */
	/* ------------------------------------------------------------------ */

	/**
	 * Detect if an element is an Atomic element (Div Block, Flexbox, Atomic Widget).
	 * Uses the trait method `get_atomic_settings` as the reliable indicator.
	 */
	private static function is_atomic( $element ): bool {
		return method_exists( $element, 'get_atomic_settings' );
	}

	/**
	 * Get the raw (un-resolved) settings from any element type.
	 */
	private static function get_raw_settings( $element ): array {
		$settings = [];
		try {
			$settings = (array) $element->get_settings_for_display();
		} catch ( \Throwable $e ) {
			// fallback to empty array
		}

		return $settings;
	}

	/**
	 * Extract a prop value from a settings array.
	 * Handles both plain values AND Elementor's {$$type, value} wrapper format.
	 */
	private static function get_prop( array $settings, string $key, $default = '' ) {
		if ( ! array_key_exists( $key, $settings ) ) {
			return $default;
		}

		$val = $settings[ $key ];

		if ( is_array( $val ) ) {
			if ( isset( $val['$$type'] ) && array_key_exists( 'value', $val ) ) {
				return $val['value'];
			}
			if ( array_key_exists( 'value', $val ) ) {
				return $val['value'];
			}
			if ( array_key_exists( 'default', $val ) ) {
				return $val['default'];
			}
		}

		return $val;
	}

	/**
	 * Check if a switch/toggle prop is active.
	 */
	private static function is_on( $value ): bool {
		return in_array( $value, [ 'yes', true, 'true', '1', 1 ], true );
	}
}

RoyalWrapperLink::init();
