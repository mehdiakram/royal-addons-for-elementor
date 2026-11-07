<?php

use Elementor\Controls_Manager;
use Elementor\Modules\AtomicWidgets\Controls\Section as AtomicSection;
use Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control as AtomicSwitch;
use Elementor\Modules\AtomicWidgets\Controls\Types\Size_Control as AtomicSize;
use Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control as AtomicSelect;
use Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control as AtomicNumber;

class RoyalGSAPScrollTrigger {

	public static function init() {
		// Standard Elementor controls (Container, Section)
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'add_gsap_scrolltrigger_controls_atomic' ], 10, 2 );

		// Use after_add_attributes hook — fires AFTER all add_render_attributes() calls,
		// so our data-attributes won't be overwritten by Div Block's add_render_attributes().
		add_action( 'elementor/element/after_add_attributes', [ __CLASS__, 'inject_data_attributes' ], 10, 1 );

		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
		add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );
    }

	/* ─────────────────────────────────────────────
	 *  Atomic API — Props Schema
	 * ───────────────────────────────────────────── */

	private static function get_dependency( $path, $value = true ) {
		$manager = \Elementor\Modules\AtomicWidgets\PropDependencies\Manager::make();
		$manager->where( [
			'operator' => 'eq',
			'path' => [ $path ],
			'value' => $value,
		] );
		return $manager->get();
	}

	public static function add_atomic_props_schema( $schema ) {
		$schema['gsap_scrolltrigger_enable'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(false);
		$schema['gsap_opacity_start'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_scale_start'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 1, 'unit' => 'px'])->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_x_position'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_y_position'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_rotation'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_scrolltrigger_start'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->enum(['top-bottom','top-center','top-top','center-bottom','center-center','bottom-bottom'])->default('top-bottom')->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_scrolltrigger_end'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->enum(['top-top','center-center','bottom-top','bottom-center'])->default('top-top')->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_animation_effect'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->enum(['fade','zoom','slide'])->default('fade')->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_duration'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type::make()->default(1000)->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );
		$schema['gsap_scrolltrigger_scrub'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(true)->set_dependencies( self::get_dependency('gsap_scrolltrigger_enable') );

		return $schema;
	}

	/* ─────────────────────────────────────────────
	 *  Atomic API — Controls UI
	 * ───────────────────────────────────────────── */

	public static function add_atomic_controls( $controls, $element ) {
		$items = [
			AtomicSwitch::bind_to( 'gsap_scrolltrigger_enable' )->set_label( __( 'Enable GSAP ScrollTrigger?', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'gsap_opacity_start' )->set_label( __( 'Start Opacity (0‑1)', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'gsap_scale_start' )->set_label( __( 'Start Scale', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'gsap_x_position' )->set_label( __( 'X Position', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'gsap_y_position' )->set_label( __( 'Y Position', 'royal-addons-for-elementor' ) ),
			AtomicSize::bind_to( 'gsap_rotation' )->set_label( __( 'Rotation', 'royal-addons-for-elementor' ) ),
			AtomicSelect::bind_to( 'gsap_scrolltrigger_start' )->set_label( __( 'Trigger Start', 'royal-addons-for-elementor' ) )->set_options([
				['value' => 'top-bottom', 'label' => __('Top Bottom', 'royal-addons-for-elementor')],
				['value' => 'top-center', 'label' => __('Top Center', 'royal-addons-for-elementor')],
				['value' => 'top-top', 'label' => __('Top Top', 'royal-addons-for-elementor')],
				['value' => 'center-bottom', 'label' => __('Center Bottom', 'royal-addons-for-elementor')],
				['value' => 'center-center', 'label' => __('Center Center', 'royal-addons-for-elementor')],
				['value' => 'bottom-bottom', 'label' => __('Bottom Bottom', 'royal-addons-for-elementor')],
			]),
			AtomicSelect::bind_to( 'gsap_scrolltrigger_end' )->set_label( __( 'Trigger End', 'royal-addons-for-elementor' ) )->set_options([
				['value' => 'top-top', 'label' => __('Top Top', 'royal-addons-for-elementor')],
				['value' => 'center-center', 'label' => __('Center Center', 'royal-addons-for-elementor')],
				['value' => 'bottom-top', 'label' => __('Bottom Top', 'royal-addons-for-elementor')],
				['value' => 'bottom-center', 'label' => __('Bottom Center', 'royal-addons-for-elementor')],
			]),
			AtomicSelect::bind_to( 'gsap_animation_effect' )->set_label( __( 'Animation Type', 'royal-addons-for-elementor' ) )->set_options([
				['value' => 'fade', 'label' => __('Fade', 'royal-addons-for-elementor')],
				['value' => 'zoom', 'label' => __('Zoom', 'royal-addons-for-elementor')],
				['value' => 'slide', 'label' => __('Slide', 'royal-addons-for-elementor')],
			]),
			AtomicNumber::bind_to( 'gsap_duration' )->set_label( __( 'Animation Duration (ms)', 'royal-addons-for-elementor' ) )->set_min(100)->set_max(5000)->set_step(50),
			AtomicSwitch::bind_to( 'gsap_scrolltrigger_scrub' )->set_label( __( 'Enable Scrub', 'royal-addons-for-elementor' ) ),
		];

		$controls[] = AtomicSection::make()
			->set_id( 'royalcontrolsection_gsap_scrolltrigger_atomic' )
			->set_label( __( 'GSAP ScrollTrigger [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( $items );

		return $controls;
	}

	/* ─────────────────────────────────────────────
	 *  Helpers
	 * ───────────────────────────────────────────── */

	/**
	 * Extract a numeric "size" value from a setting that could be:
	 *  - a plain number
	 *  - an array ['size' => x, 'unit' => '...']
	 *  - a $$type wrapper
	 */
	private static function get_size_val( $settings, $key, $default = 0 ) {
		$val = $settings[$key] ?? $default;
		if ( is_array($val) && isset($val['size']) ) {
			return $val['size'];
		}
		if ( is_numeric($val) ) {
			return $val;
		}
		return $default;
	}

	/* ─────────────────────────────────────────────
	 *  Data-attribute injection (fires AFTER all add_render_attributes)
	 * ───────────────────────────────────────────── */

	public static function inject_data_attributes( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);

		if ( $is_atomic ) {
			self::inject_atomic( $element );
		} else {
			self::inject_standard( $element );
		}
	}

	/**
	 * Atomic Div Block / Flexbox: read settings via get_atomic_settings()
	 */
	private static function inject_atomic( $element ) {
		$settings = [];

		// Method 1: get_atomic_settings() — properly resolves $$type values
		if ( method_exists($element, 'get_atomic_settings') ) {
			try {
				$settings = $element->get_atomic_settings();
			} catch ( \Throwable $e ) {
				$settings = [];
			}
		}

		// Method 2: fallback to raw get_settings() with manual $$type extraction
		if ( empty($settings) || !isset($settings['gsap_scrolltrigger_enable']) ) {
			$raw = method_exists($element, 'get_settings') ? $element->get_settings() : [];
			foreach ( $raw as $key => $val ) {
				if ( strpos($key, 'gsap_') === 0 && !isset($settings[$key]) ) {
					// Extract value from $$type wrapper if present
					if ( is_array($val) && isset($val['$$type']) && array_key_exists('value', $val) ) {
						$settings[$key] = $val['value'];
					} else {
						$settings[$key] = $val;
					}
				}
			}
		}

		$isEnabled = $settings['gsap_scrolltrigger_enable'] ?? false;
		if ( $isEnabled !== true && $isEnabled !== 'yes' && $isEnabled !== 'enable' ) {
			return;
		}

		$opacity_val = self::get_size_val($settings, 'gsap_opacity_start', 0);
		$scale_val = self::get_size_val($settings, 'gsap_scale_start', 1);
		$x_val = self::get_size_val($settings, 'gsap_x_position', 0);
		$y_val = self::get_size_val($settings, 'gsap_y_position', 0);
		$rot_val = self::get_size_val($settings, 'gsap_rotation', 0);

		$trigger_start = $settings['gsap_scrolltrigger_start'] ?? 'top-bottom';
		$trigger_end = $settings['gsap_scrolltrigger_end'] ?? 'top-top';
		$anim_effect = $settings['gsap_animation_effect'] ?? 'fade';
		$duration = $settings['gsap_duration'] ?? 1000;
		$scrub_raw = $settings['gsap_scrolltrigger_scrub'] ?? true;
		$scrub = ( $scrub_raw === true || $scrub_raw === 'yes' || $scrub_raw === 'enable' ) ? 'yes' : 'no';

		$element->add_render_attribute( '_wrapper', [
			'data-gsap-scrolltrigger-enable' => 'enable',
			'data-gsap-opacity-start' => $opacity_val,
			'data-gsap-scale-start' => $scale_val,
			'data-gsap-x-position' => $x_val,
			'data-gsap-y-position' => $y_val,
			'data-gsap-rotation' => $rot_val,
			'data-gsap-scrolltrigger-start' => $trigger_start,
			'data-gsap-scrolltrigger-end' => $trigger_end,
			'data-gsap-animation-effect' => $anim_effect,
			'data-gsap-duration' => $duration,
			'data-gsap-scrub' => $scrub,
		]);
	}

	/**
	 * Standard Container / Section: read settings via get_settings_for_display()
	 */
	private static function inject_standard( $element ) {
		$el_name = $element->get_name();
		if ( ! in_array($el_name, ['section', 'container', 'e-container', 'e-flexbox']) ) {
			return;
		}

		$settings = $element->get_settings_for_display();
		$isEnabled = $settings['gsap_scrolltrigger_enable'] ?? '';
		if ( 'enable' !== $isEnabled && 'yes' !== $isEnabled && true !== $isEnabled ) {
			return;
		}

		$opacity = isset($settings['gsap_opacity_start']['size']) ? $settings['gsap_opacity_start']['size'] : 1;
		$scale = isset($settings['gsap_scale_start']['size']) ? $settings['gsap_scale_start']['size'] : 1;
		$x_pos = isset($settings['gsap_x_position']['size']) ? $settings['gsap_x_position']['size'] : 0;
		$y_pos = isset($settings['gsap_y_position']['size']) ? $settings['gsap_y_position']['size'] : 0;
		$rotation = isset($settings['gsap_rotation']['size']) ? $settings['gsap_rotation']['size'] : 0;
		$scrub = $settings['gsap_scrolltrigger_scrub'] ?? 'yes';

		$element->add_render_attribute( '_wrapper', [
			'data-gsap-scrolltrigger-enable' => 'enable',
			'data-gsap-opacity-start' => $opacity,
			'data-gsap-scale-start' => $scale,
			'data-gsap-x-position' => $x_pos,
			'data-gsap-y-position' => $y_pos,
			'data-gsap-rotation' => $rotation,
			'data-gsap-scrolltrigger-start' => $settings['gsap_scrolltrigger_start'] ?? 'top-bottom',
			'data-gsap-scrolltrigger-end' => $settings['gsap_scrolltrigger_end'] ?? 'top-top',
			'data-gsap-animation-effect' => $settings['gsap_animation_effect'] ?? 'fade',
			'data-gsap-duration' => $settings['gsap_duration'] ?? 1000,
			'data-gsap-scrub' => ( 'enable' === $scrub || 'yes' === $scrub || true === $scrub ) ? 'yes' : 'no',
		]);
	}

	/* ─────────────────────────────────────────────
	 *  Enqueue GSAP, ScrollTrigger, and custom JS
	 * ───────────────────────────────────────────── */

    public static function enqueue_scripts() {
        wp_enqueue_script('gsap', ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/gsap.min.js', [], '3.12.2', true);
        wp_enqueue_script('scrolltrigger', ROYAL_ADDONS_DIR_URL . 'assets/vendor/gsap/scrolltrigger.min.js', ['gsap'], '3.12.2', true);
        wp_enqueue_script('royal-gsap-scrolltrigger', ROYAL_ADDONS_DIR_URL . 'assets/js/extension-royalgsapscrolltrigger.js', ['gsap', 'scrolltrigger'], ROYAL_ADDONS_VERSION, true);
    }

	/* ─────────────────────────────────────────────
	 *  Standard Elementor Controls (Container/Section)
	 * ───────────────────────────────────────────── */

	private static $registered_elements = [];

	public static function add_gsap_scrolltrigger_controls_atomic( $element, $section_id = '' ) {
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro' ] ) ) return;
		self::add_gsap_scrolltrigger_controls( $element );
	}

	public static function add_gsap_scrolltrigger_controls($element) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);

        if ( in_array( $el_name, [ 'section', 'container', 'e-container', 'e-flexbox' ] ) || $is_atomic ) {
            $element->start_controls_section(
                'royalcontrolsection_gsap_scrolltrigger',
                [
                    'label' => __('GSAP ScrollTrigger [Royal]', 'royal-addons-for-elementor'),
                    'tab' => Controls_Manager::TAB_ADVANCED,
                ]
            );

            $element->add_control(
                'gsap_scrolltrigger_enable',
                [
                    'label' => __('Enable GSAP ScrollTrigger?', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('Yes', 'royal-addons-for-elementor'),
                    'label_off' => __('No', 'royal-addons-for-elementor'),
                    'return_value' => 'enable',
                    'default' => '',
                ]
            );

            // Opacity Control
            $element->add_control(
                'gsap_opacity_start',
                [
                    'label' => __('Start Opacity', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1,
                            'step' => 0.001,
                        ],
                    ],
                    'default' => [
                        'size' => 0,
                        'unit' => 'px',
                    ],
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // Scale Control
            $element->add_control(
                'gsap_scale_start',
                [
                    'label' => __('Start Scale', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 2,
                            'step' => 0.1,
                        ],
                    ],
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // X Position Control
            $element->add_control(
                'gsap_x_position',
                [
                    'label' => __('X Position', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
                        ],
                    ],
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // Y Position Control
            $element->add_control(
                'gsap_y_position',
                [
                    'label' => __('Y Position', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -500,
                            'max' => 500,
                        ],
                    ],
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // Rotation Control
            $element->add_control(
                'gsap_rotation',
                [
                    'label' => __('Rotation', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => -360,
                            'max' => 360,
                        ],
                    ],
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // Trigger Start
            $element->add_control(
                'gsap_scrolltrigger_start',
                [
                    'label' => __('Trigger Start', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'top-bottom' => __('Top Bottom', 'royal-addons-for-elementor'),
                        'top-center' => __('Top Center', 'royal-addons-for-elementor'),
                        'top-top' => __('Top Top', 'royal-addons-for-elementor'),
                        'center-bottom' => __('Center Bottom', 'royal-addons-for-elementor'),
                        'center-center' => __('Center Center', 'royal-addons-for-elementor'),
                        'bottom-bottom' => __('Bottom Bottom', 'royal-addons-for-elementor'),
                    ],
                    'default' => 'top-bottom',
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // Trigger End
            $element->add_control(
                'gsap_scrolltrigger_end',
                [
                    'label' => __('Trigger End', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'top-top' => __('Top Top', 'royal-addons-for-elementor'),
                        'center-center' => __('Center Center', 'royal-addons-for-elementor'),
                        'bottom-top' => __('Bottom Top', 'royal-addons-for-elementor'),
                        'bottom-center' => __('Bottom Center', 'royal-addons-for-elementor'),
                    ],
                    'default' => 'top-top',
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // Animation Type
            $element->add_control(
                'gsap_animation_effect',
                [
                    'label' => __('Animation Type', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'fade' => __('Fade', 'royal-addons-for-elementor'),
                        'zoom' => __('Zoom', 'royal-addons-for-elementor'),
                        'slide' => __('Slide', 'royal-addons-for-elementor'),
                    ],
                    'default' => 'fade',
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            $element->add_control(
                'gsap_duration',
                [
                    'label' => __('Animation Duration (ms)', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 100,
                    'max' => 5000,
                    'step' => 50,
                    'default' => 1000,
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            // Scrub Control
            $element->add_control(
                'gsap_scrolltrigger_scrub',
                [
                    'label' => __('Enable Scrub', 'royal-addons-for-elementor'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('Yes', 'royal-addons-for-elementor'),
                    'label_off' => __('No', 'royal-addons-for-elementor'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'gsap_scrolltrigger_enable' => 'enable',
                    ],
                ]
            );

            $element->end_controls_section();
        }
    }
}

RoyalGSAPScrollTrigger::init();
