<?php

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalStickyHeader {
	
	static $should_script_enqueue = false;

	public static function init() {
		// Universal hook that fires for ALL legacy element types including Container
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'royal_sticky_header_register_controls' ], 20, 2 );

		// Elementor 4 Atomic API Hooks.
		// Elementor fires 'elementor/init' at WordPress 'init' priority 0,
		// while our extension loads at priority 11 — so elementor/init has
		// already fired by the time we get here. We therefore register the
		// filters directly (they will still be in time for get_props_schema /
		// get_atomic_controls calls made during editor config generation).
		add_filter( 'elementor/atomic-widgets/props-schema', [ 'RoyalStickyHeader', 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls',    [ 'RoyalStickyHeader', 'add_atomic_controls' ],    10, 2 );

		// Enqueue scripts on frontend
		add_action('elementor/frontend/section/before_render', [__CLASS__, 'check_and_enqueue']);
		add_action('elementor/frontend/container/before_render', [__CLASS__, 'check_and_enqueue']);
		add_action('elementor/frontend/before_render', [__CLASS__, 'check_and_enqueue']);
		
		// Enqueue in editor
		add_action('elementor/editor/before_enqueue_scripts', [__CLASS__, 'royal_sticky_header_enqueue']);
		
		// Always enqueue on frontend for Elementor pages
		add_action('wp_enqueue_scripts', [__CLASS__, 'frontend_scripts'], 100);
	}
	
	
    public static function royal_sticky_header_enqueue() {
		wp_enqueue_script('royalstickyheader', ROYAL_ADDONS_DIR_URL.'assets/js/extension-royalstickyheader.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
		wp_enqueue_style('royalstickyheader', ROYAL_ADDONS_DIR_URL.'assets/css/extension-royalstickyheader.css', [], ROYAL_ADDONS_VERSION);
    }

	/**
	 * Enqueue scripts on frontend for all Elementor pages
	 */
	public static function frontend_scripts() {
		// Check if Elementor is active
		if ( ! class_exists('\Elementor\Plugin') ) {
			return;
		}
		
		// Always enqueue on Elementor pages - let JS handle the detection
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			self::royal_sticky_header_enqueue();
			return;
		}
		
		// Check current post
		global $post;
		if ( $post ) {
			$document = \Elementor\Plugin::$instance->documents->get( $post->ID );
			if ( $document && $document->is_built_with_elementor() ) {
				self::royal_sticky_header_enqueue();
				self::$should_script_enqueue = true;
				return;
			}
		}
		
		// Check for Theme Builder templates (header, footer, etc.)
		if ( class_exists('\ElementorPro\Modules\ThemeBuilder\Module') ) {
			try {
				$theme_builder = \ElementorPro\Modules\ThemeBuilder\Module::instance();
				if ( $theme_builder ) {
					$locations_manager = $theme_builder->get_locations_manager();
					if ( $locations_manager ) {
						$locations = $locations_manager->get_locations();
						if ( !empty($locations) ) {
							self::royal_sticky_header_enqueue();
							self::$should_script_enqueue = true;
							return;
						}
					}
				}
			} catch (Exception $e) {
				// Silently fail
			}
		}
		
		// Fallback: check if any Elementor footer/header is active
		if ( did_action('elementor/loaded') ) {
			self::royal_sticky_header_enqueue();
		}
	}

    public static function check_and_enqueue($element) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;
        if (self::$should_script_enqueue) {
            return;
        }

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		
		$settings = [];
		try {
			$settings = $element->get_settings_for_display();
		} catch (\Throwable $e) {}

		// Fallback for atomic if needed, but display settings should have it
		if ( $is_atomic && empty($settings['transparent']) && method_exists($element, 'get_atomic_settings') ) {
			try {
				$atomic_settings = $element->get_atomic_settings();
				if (isset($atomic_settings['transparent'])) {
					// Atomic properties might be wrapped in {value, type}
					$settings['transparent'] = is_array($atomic_settings['transparent']) ? ($atomic_settings['transparent']['value'] ?? 'no') : $atomic_settings['transparent'];
				}
			} catch (\Throwable $e) {}
		}

		$is_enabled = ( 'yes' === ( $settings['transparent'] ?? 'no' ) ) || true === ( $settings['transparent'] ?? false ) || 'true' === ( $settings['transparent'] ?? 'false' );

        if ( $is_enabled ) {
            self::$should_script_enqueue = true;
            self::royal_sticky_header_enqueue();

			if ( $is_atomic ) {
				$element->add_render_attribute( '_wrapper', 'class', 'royalstickyheader-header' );
				$element->add_render_attribute( '_wrapper', 'class', 'royalstickyheader-header-yes' );
				// Provide data-settings to JS so fallback defaults can run
				$element->add_render_attribute( '_wrapper', 'data-settings', wp_json_encode($settings) );
			}
        }
    }
	
	/* Atomic Elements - registered tracker */
	private static $registered_elements = [];

	public static function add_atomic_props_schema( $schema ) {
		if ( ! isset( $schema['transparent'] ) ) {
			$schema['transparent'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default( false );
		}
		return $schema;
	}

	public static function add_atomic_controls( $controls, $element ) {
		$el_name = method_exists( $element, 'get_name' ) ? $element->get_name() : get_class( $element );

		try {
			$schema = $element::get_props_schema();
			if ( ! array_key_exists( 'transparent', $schema ) ) {
				return $controls;
			}
		} catch ( \Throwable $e ) {
			return $controls;
		}

		$switch = \Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control::bind_to( 'transparent' )
			->set_label( __( 'Enable Sticky Header', 'royal-addons-for-elementor' ) )
			->set_meta( [ 'topDivider' => true ] );

		// Always append a dedicated section for Sticky Header
		$new_section = \Elementor\Modules\AtomicWidgets\Controls\Section::make()
			->set_id( 'royalcontrolsection_sticky_header_atomic' )
			->set_label( __( 'Sticky Header [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( [ $switch ] );
			
		$controls[] = $new_section;

		return $controls;
	}



	public static function royal_sticky_header_register_controls( $element, $section_id = '' ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);

		if ( ! $is_atomic && ! in_array( $section_id, [ 'section_custom_css', 'section_custom_css_pro', 'section_custom_attributes' ] ) ) {
			return;
		}

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;
		
		$target_tab = $is_atomic ? Controls_Manager::TAB_ADVANCED : Controls_Manager::TAB_ADVANCED;

		$element->start_controls_section(
			'royalcontrolsection_sticky_header',
			[
				'label' => __( 'Sticky Header [Royal]', 'royal-addons-for-elementor' ),
				'tab' => $target_tab,
			]
		);

		$element->add_control(
			'transparent',
			[
				'label' => __( 'Enable', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'bew-header' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'prefix_class'  => 'royalstickyheader-header-'
			]
		);
		
		$element->add_control(
			'upgrade_notice',
			[
				'type' => Controls_Manager::NOTICE,
				'notice_type' => 'info',
				'dismissible' => true,
				'heading' => esc_html__( 'New FREE Pro Features', 'royal-addons-for-elementor' ),
				'content' => esc_html__( 'Disable Fully Transparent Background, Background Type, Custom Menu Toggle Button, Bottom Shadow, Blur Background settings' , 'royal-addons-for-elementor' ) ,
				'condition' => [
					'transparent!' => '',
				],
			]
		);

		$element->add_control(
			'transparent_on',
			[
				'label' => __( 'Enable On', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'label_block' => 'true',
				'default' => [ 'desktop', 'tablet', 'mobile' ],
				'options' => [
					'desktop' => __( 'Desktop', 'royal-addons-for-elementor' ),
					'tablet' => __( 'Tablet', 'royal-addons-for-elementor' ),
					'mobile' => __( 'Mobile', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'transparent!' => ''
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'settings_notice',
			[
				'raw' => __( 'Remember: The settings below will not be applied until the page is scrolled the distance set above', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition' => [
					'transparent!' => '',
					],
			]
		);


		$element->start_controls_tabs(
			'tabs_before_after_scrolling'
			
		);
		
		$element->start_controls_tab(
			'tab_before_scrolling',
			[
				'label' => esc_html__( 'Before Scroll', 'royal-addons-for-elementor' ),
				'condition' => [
					'transparent!' => '',
				],
			]
		);
		

		$element->add_control(
			'transparent_header_show',
			[
				'label' => __('Sticky Header', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __('On', 'royal-addons-for-elementor'),
				'label_off' => __('Off', 'bew-header'),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'prefix_class'  => 'royalstickyheader-header-transparent-',
				'condition' => [
					'transparent!' => '',
				],
				'description' => __('Sets the header position to "absolute" so negative margins are not needed', 'royal-addons-for-elementor'),
			]
		);


		$element->add_control(
			'initial_blur_bg',
			[
				'label' => __('Blur Background Before Scrolling', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __('On', 'royal-addons-for-elementor'),
				'label_off' => __('Off', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
				],
				'description' => __('Add a modern blur effect to a semi-transparent header background color Before scrolling', 'royal-addons-for-elementor'),
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header-transparent-yes' => 'backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%);',
					'{{WRAPPER}}.royalstickyheader-header-transparent-yes' => 'backdrop-filter: blur({{blur_bg_blur_amount.SIZE}}{{blur_bg_blur_amount.UNIT}}) saturate({{blur_bg_saturate_amount.SIZE}}) !important; -webkit-backdrop-filter: blur({{blur_bg_blur_amount.SIZE}}{{blur_bg_blur_amount.UNIT}}) saturate({{blur_bg_saturate_amount.SIZE}}) !important;',
				],
			]
		);
		
		$element->add_control(
			'initial_blur_bg_note',
			[
				'raw' => __('Tip: Low saturation works best with no background color<br><br>DEFAULTS: Blur 20px, Saturation 1.80', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition' => [
					'transparent!' => '',
					'initial_blur_bg' => 'yes',
				],
			]
		);

		$element->add_control(
			'initial_blur_bg_blur_amount',
			[
				'label' => __('Blur Amount (Px)', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => ['px'],
				'condition' => [
					'transparent!' => '',
					'initial_blur_bg' => 'yes',
				],
				'description' => __('', 'royal-addons-for-elementor'),
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'initial_blur_bg_saturate_amount',
			[
				'label' => __('Saturation Amount', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1.8,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'condition' => [
					'transparent!' => '',
					'initial_blur_bg' => 'yes',
				],
				'description' => __('', 'royal-addons-for-elementor'),
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'initial_background_color',
			[
				'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff00',
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header-transparent-yes' => 'background-color: {{VALUE}} !important; position:absolute !important;',
				],
				'condition' => [
					'transparent!' => '',
					'transparent_header_show' => 'yes',
					'initial_blur_bg!' => 'yes',
				],
			]
		);

		$element->add_control(
			'transparent_note',
			[
				'raw' => __('This will make the header overlap the main page so extra spacing at the top of sections may be needed<br><br>
				Does NOT work on/override elementor sticky settings', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-control-notice elementor-control-notice-type-info',
				'condition' => [
					'transparent!' => '',
					'transparent_header_show' => 'yes',
				],
			]
		);


		$element->end_controls_tab();
		

		$element->start_controls_tab(
			'tab_afer_scrolling',
			[
				'label' => esc_html__( 'After Scroll', 'royal-addons-for-elementor' ),
				'condition' => [
					'transparent!' => '',
				],
			]
		);
		
		$element->add_control(
			'sticky_on_reach_top',
			[
				'label' => __('Sticky When Reaches Top', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('On', 'royal-addons-for-elementor'),
				'label_off' => __('Off', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
				],
				'description' => __('Header will become sticky when it reaches the top of the viewport (ignores Scroll Distance)', 'royal-addons-for-elementor'),
			]
		);

		$element->add_responsive_control(
			'scroll_distance',
			[
				'label' => __( 'Scroll Distance (px)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 60,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ 'px'],
				'description' => __( 'Choose the scroll distance to enable Sticky Header Effects (set to 0 for immediate sticky)', 'royal-addons-for-elementor' ),
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
					'sticky_on_reach_top!' => 'yes',
				],
			]
		);


		$element->add_control(
			'popover-toggle',
			[
				'label' => esc_html__( 'After Sticky', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => esc_html__( 'Default', 'royal-addons-for-elementor' ),
				'label_on' => esc_html__( 'Custom', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'condition' => [
					'transparent!' => '',
				],
			]
		);

		$element->start_popover();
		$element->add_control(
			'royalstickyheader_sticky_header',
			array(
				'label'     => __( 'After Sticky', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			)
		);
		$element->add_responsive_control(
			'royalstickyheader_offset_top',
			[
				'label' => esc_html__( 'Offset', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'frontend_available' => true,
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition' => [
					'transparent!' => '',
				],
			]
		);
		$element->add_responsive_control(
			'royalstickyheader_width',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'frontend_available' => true,
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'condition' => [
					'transparent!' => '',
				],
			]
		);
		$element->add_responsive_control(
			'royalstickyheader_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => '',
					'bottom' => 0,
					'left' => '',
					'unit' => 'px',
					'isLinked' => true,
				],
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
				],
			]
		);
		$element->add_control(
			'after_sticky_header_notice',
			[
				'raw' => __( 'Adjust properties once Status will be changed to Sticky.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition' => [
					'transparent!' => '',
				],
			]
		);
		$element->end_popover();
		
		
		$element->add_control(
			'blur_bg',
			[
				'label' => __('Blur Background After Scrolling', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __('On', 'royal-addons-for-elementor'),
				'label_off' => __('Off', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
				],
				'description' => __('Add a modern blur effect to a semi-transparent header background color after scrolling', 'royal-addons-for-elementor'),
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header' => 'backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%);',
					'{{WRAPPER}}.royalstickyheader-header' => 'backdrop-filter: blur({{blur_bg_blur_amount.SIZE}}{{blur_bg_blur_amount.UNIT}}) saturate({{blur_bg_saturate_amount.SIZE}}) !important; -webkit-backdrop-filter: blur({{blur_bg_blur_amount.SIZE}}{{blur_bg_blur_amount.UNIT}}) saturate({{blur_bg_saturate_amount.SIZE}}) !important;',
				],
			]
		);
		
		$element->add_control(
			'blur_bg_note',
			[
				'raw' => __('Tip: Low saturation works best with no background color<br><br>DEFAULTS: Blur 20px, Saturation 1.80', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition' => [
					'transparent!' => '',
					'blur_bg' => 'yes',
				],
			]
		);

		$element->add_control(
			'blur_bg_blur_amount',
			[
				'label' => __('Blur Amount (Px)', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'size_units' => ['px'],
				'condition' => [
					'transparent!' => '',
					'blur_bg' => 'yes',
				],
				'description' => __('', 'royal-addons-for-elementor'),
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'blur_bg_saturate_amount',
			[
				'label' => __('Saturation Amount', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1.8,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'condition' => [
					'transparent!' => '',
					'blur_bg' => 'yes',
				],
				'description' => __('', 'royal-addons-for-elementor'),
				'frontend_available' => true,
			]
		);



		$element->add_control(
			'background_show',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'bew-header' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
					'blur_bg!' => 'yes',
				],
				'description' => __( 'Choose what color to change the background to after scrolling', 'royal-addons-for-elementor' ),
			]
		);
		
		$element->add_control(
			'background_type',
			[
				'label' => __('Background Type', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'background_show' => 'yes',
					'transparent!' => '',
				],
				'label_block' => false,
				'render_type' => 'ui',
				'options' => [
					'classic' => [
						'title' => __('Classic', 'royal-addons-for-elementor'),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => __('Gradient', 'royal-addons-for-elementor'),
						'icon' => 'eicon-barcode',
					],
				],
				'default' => 'classic'
			]
		);

		$element->add_control(
			'background',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
				    'background_show' => 'yes',
					'transparent!' => '',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);
		
		$element->add_control(
			'gradient_transition_notice',
			[
				'raw' => __( 'Please note that gradients will not be transitioned', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition' => [
					'background_type' => ['gradient'],
					'transparent!' => '',
				],
			 ]
			);
		
		$element->add_control(
			'color_stop',
			[
				'label' => __('Location', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition' => [
					'background_show' => 'yes',
					'transparent!' => '',
					'background_type' => ['gradient'],
				],
				'of_type' => 'gradient',
			]
		);

		$element->add_control(
			'color_b',
			[
				'label' => __('Second Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#f2295b',
				'render_type' => 'ui',
				'condition' => [
					'background_show' => 'yes',
					'transparent!' => '',
					'background_type' => ['gradient'],
				],
				'of_type' => 'gradient',
			]
		);

		$element->add_control(
			'color_b_stop',
			[
				'label' => __('Location', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition' => [
					'background_show' => 'yes',
					'transparent!' => '',
					'background_type' => ['gradient'],
				],
				'of_type' => 'gradient',
			]
		);

		$element->add_control(
			'gradient_type',
			[
				'label' => __('Type', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'linear' => __('Linear', 'royal-addons-for-elementor'),
					'radial' => __('Radial', 'royal-addons-for-elementor'),
				],
				'default' => 'linear',
				'render_type' => 'ui',
				'condition' => [
					'background_show' => 'yes',
					'transparent!' => '',
					'background_type' => ['gradient'],
				],
				'of_type' => 'gradient',
			]
		);

		$element->add_control(
			'gradient_angle',
			[
				'label' => __('Angle', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['deg'],
				'default' => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{background.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
				],
				'condition' => [
					'background_show' => 'yes',
					'transparent!' => '',
					'background_type' => ['gradient'],
					'gradient_type' => 'linear',
				],
				'of_type' => 'gradient',
			]
		);

		$element->add_control(
			'gradient_position',
			[
				'label' => __('Position', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'center center' => __('Center Center', 'royal-addons-for-elementor'),
					'center left' => __('Center Left', 'royal-addons-for-elementor'),
					'center right' => __('Center Right', 'royal-addons-for-elementor'),
					'top center' => __('Top Center', 'royal-addons-for-elementor'),
					'top left' => __('Top Left', 'royal-addons-for-elementor'),
					'top right' => __('Top Right', 'royal-addons-for-elementor'),
					'bottom center' => __('Bottom Center', 'royal-addons-for-elementor'),
					'bottom left' => __('Bottom Left', 'royal-addons-for-elementor'),
					'bottom right' => __('Bottom Right', 'royal-addons-for-elementor'),
				],
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{background.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
				],
				'condition' => [
					'background_show' => 'yes',
					'transparent!' => '',
					'background_type' => ['gradient'],
					'gradient_type' => 'radial',
				],
				'of_type' => 'gradient',
			]
		);


		$element->add_control(
			'menu_color_show',
			[
				'label' => __( 'Menu Color Enable', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'bew-header' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
				],
				'description' => __( 'Choose what color to change the menu to after scrolling', 'royal-addons-for-elementor' ),
			]
		);
	
	
		$element->add_control(
			'menu_color',
			[
				'label' => esc_html__( 'Menu Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'transparent!' => '',
					'menu_color_show' => 'yes',
				],
				'selectors' => [
					'.royalstickyheader-header .royalhorizontalmenu .menu-item a' => 'color: {{VALUE}}!important',
				],
			]
		);	

		$element->add_control(
			'shrink_header',
			[
				'label' => __( 'Shrink Header', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Choose header height after scrolling', 'royal-addons-for-elementor' ),
				'condition' => [
					'transparent!' => '',
				],
			]
		);

		$element->add_responsive_control(
			'custom_height_header',
			[
				'label' => __( 'Header Height (px)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 70,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'size_units' => [ 'px'],
				'description' => __( 'Remember: The header cannot shrink smaller than the elements inside of it', 'royal-addons-for-elementor' ),
				'condition' => [
				   'shrink_header' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
			]
		);

$element->add_control(
			'shrink_header_logo',
			[
				'label' => __('Shrink Logo', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __('On', 'royal-addons-for-elementor'),
				'label_off' => __('Off', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __('Resize logo after scrolling', 'royal-addons-for-elementor'),
				'condition' => [
					'transparent!' => '',
				],
			]
		);

		$element->add_responsive_control(
			'custom_height_header_logo',
			[
				'label' => __( 'Logo Height (%)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%'],
				'condition' => [
				    'shrink_header_logo' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
				'description' => __('<b>Depricated:</b> Responsive sizes only load on page refresh, not window resize. Please migrate to using the settings below', 'royal-addons-for-elementor'),
			]
		);

		$element->add_control(
			'hide_header',
			[
				'label' => __( 'Hide header on scroll down', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Hides the header if scrolling down, and shows header if scrolling up', 'royal-addons-for-elementor' ),
				'prefix_class'  => 'royalstickyheader-header-hide-on-scroll-',
				'condition' => [
					'transparent!' => '',
				],
			]
		);

		$element->add_control(
			'hide_header_notice',
			[
				'raw' => __('WARNING: This might break section/container entrance animations', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => [
					'hide_header' => 'yes',
					'transparent!' => '',
				],
			]
		);

		$element->add_responsive_control(
			'scroll_distance_hide_header',
			[
				'label' => __( 'Scroll Distance (px)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 500,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ 'px'],
				'description' => __( 'Choose the scroll distance to start hiding the header', 'royal-addons-for-elementor' ),
				'frontend_available' => true,
				'condition' => [
					'hide_header' => 'yes',
					'transparent!' => '',
				],
			]
		);

		
		$element->add_control(
			'bottom_border',
			[
				'label' => __( 'Bottom Border', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
				],
				'description' => __( 'Choose bottom border size and color', 'royal-addons-for-elementor' ),
			]
		);


		$element->add_control(
			'custom_bottom_border_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
				    'bottom_border' => 'yes',
					'transparent!' => '',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_responsive_control(
			'custom_bottom_border_width',
			[
				'label' => __( 'Bottom Border Thickness (px)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px'],
				'description' => __( 'Note: A border size(even 0px) must be set on the header for the transition to work both ways', 'royal-addons-for-elementor' ),
				'condition' => [
				    'bottom_border' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
			]
		);
		
		$element->add_control(
			'bottom_shadow',
			[
				'label' => __('Bottom Shadow', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __('On', 'royal-addons-for-elementor'),
				'label_off' => __('Off', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'transparent!' => '',
				],
				'description' => __('Choose bottom shadow options after scrolling', 'royal-addons-for-elementor'),
				'selectors' => [
					'body:not(.elementor-editor-active) .royalstickyheader-header-yes' => 'box-shadow: 0 0 0 0 rgb(0 0 0 / 0%); clip-path: inset(0 0 -100vh 0);',
					'body:not(.elementor-editor-active) .royalstickyheader-header-yes.royalstickyheader-header' => 'box-shadow: 0 {{bottom_shadow_vertical.SIZE}}{{bottom_shadow_vertical.UNIT}} {{bottom_shadow_blur.SIZE}}{{bottom_shadow_blur.UNIT}} {{bottom_shadow_spread.SIZE}}{{bottom_shadow_spread.UNIT}} {{bottom_shadow_color.VALUE}}; clip-path: inset(0 0 -100vh 0);',
				],
			]
		);

		$element->add_control(
			'bottom_shadow_color',
			[
				'label' => __('Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0, 0, 0, 0.15)',
				'condition' => [
					'bottom_shadow' => 'yes',
					'transparent!' => '',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'bottom_shadow_vertical',
			[
				'label' => __('Vertical', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => ['px'],
				'condition' => [
					'bottom_shadow' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'bottom_shadow_blur',
			[
				'label' => __('Blur', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => ['px'],
				'condition' => [
					'bottom_shadow' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'bottom_shadow_spread',
			[
				'label' => __('Spread', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => ['px'],
				'condition' => [
					'bottom_shadow' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
			]
		);


		$element->end_controls_tab();		
		$element->end_controls_tabs();


		

		$element->add_control(
		'mobile_menu_toggle_animation',
		[
			'label' => __('Custom Menu Toggle Button', 'royal-addons-for-elementor'),
			'type' => Controls_Manager::SWITCHER,
			'separator' => 'before',
			'label_on' => __('On', 'royal-addons-for-elementor'),
			'label_off' => __('Off', 'royal-addons-for-elementor'),
			'return_value' => 'yes',
			'default' => '',
			'frontend_available' => true,
			'condition' => [
				'transparent!' => '',
			],
			'description' => __('Customize and add animation to the Elementor menu icon<br>*Only supports Elementor nav menu', 'royal-addons-for-elementor'),
			'selectors' => [
				'.royalstickyheader-header-yes .elementor-menu-toggle:before,
					.royalstickyheader-header-yes .elementor-menu-toggle:after,
					.royalstickyheader-header-yes .elementor-menu-toggle i:after' => 'content: "";
					position: absolute;
					background: currentColor;
					top: 50%;
					left: 50%;',

				'.royalstickyheader-header-yes .elementor-menu-toggle' => 'position: relative;
					transition: color 0.4s ease-in-out, background-color 0.4s ease-in-out;',

				'.royalstickyheader-header-yes .elementor-menu-toggle.elementor-active:before' => 'transform: translate(-50%,-50%) rotate(-45deg);',

				'.royalstickyheader-header-yes .elementor-menu-toggle.elementor-active:after' => 'transform: translate(-50%,-50%) rotate(45deg);',

				'.royalstickyheader-header-yes .elementor-menu-toggle i:after' => 'transform: translate(-50%,-50%);',

				'.royalstickyheader-header-yes .elementor-menu-toggle i:before,
					.royalstickyheader-header-yes .elementor-menu-toggle.elementor-active i:after' => 'opacity: 0;',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_note',
			[
				'raw' => __('This option ONLY works on the WordPress menu widget hamburger icon.<br><br>Tip: Set the nav menu toggle button size first. All of these settings are scaled off of that size', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-control-notice elementor-control-notice-type-info',
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_type',
			[
				'label' => __('Toggle Button Type', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'lines',
				'options' => [
					'lines' => [
						'title' => __('Lines', 'royal-addons-for-elementor'),
						'icon' => 'eicon-menu-bar',

					],
					'dots' => [
						'title' => __('Dots/Squares', 'royal-addons-for-elementor'),
						'icon' => 'eicon-ellipsis-v',
					],
				],
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
			]
		);

		$element->add_control(
			'lines_note',
			[
				'raw' => __('<b>Lines</b><br>Separately adjustable line weight and width', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
			]
		);

		$element->add_control(
			'dots_note',
			[
				'raw' => __('<b>Dots/Squares</b><br>Line weight and width are equal with an adjustable width for the active(close button) lines', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_only_two',
			[
				'label' => __('Only 2', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('On', 'royal-addons-for-elementor'),
				'label_off' => __('Off', 'royal-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
				'description' => __('If 3 is too many, try only 2', 'royal-addons-for-elementor'),
				'selectors' => [
					'.royalstickyheader-header-yes .elementor-menu-toggle i:after' => 'display: none;',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_weight',
			[
				'label' => __('Weight', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['em', 'rem', '%', 'px'],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
					'rem' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.01,
					],
					'%' => [
						'min' => 0,
						'max' => 33,
						'step' => 0.1,
					],
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0.12,
					'unit' => 'em',
				],
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
				'selectors' => [
					'.royalstickyheader-header-yes .elementor-menu-toggle:before,
						.royalstickyheader-header-yes .elementor-menu-toggle:after,
						.royalstickyheader-header-yes .elementor-menu-toggle i:after' => '
						height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_width',
			[
				'label' => __('Width', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['em', 'rem', '%', 'px'],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.01,
					],
					'rem' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 1,
					'unit' => 'em',
				],
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'mobile_menu_toggle_type' => ['lines'],
					'transparent!' => '',
				],
				'frontend_available' => true,
				'selectors' => [
					'.royalstickyheader-header-yes .elementor-menu-toggle:before,
						.royalstickyheader-header-yes .elementor-menu-toggle:after,
						.royalstickyheader-header-yes .elementor-menu-toggle i:after' => '
						width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_active_width',
			[
				'label' => __('Active Width(Close Button)', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['em', 'rem', '%', 'px'],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.01,
					],
					'rem' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 1,
					'unit' => 'em',
				],
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'mobile_menu_toggle_type' => ['dots'],
					'transparent!' => '',
				],
				'frontend_available' => true,
				'selectors' => [
					'.royalstickyheader-header-yes .elementor-menu-toggle:before,
						.royalstickyheader-header-yes .elementor-menu-toggle:after,
						.royalstickyheader-header-yes .elementor-menu-toggle i:after' => '
						height: {{mobile_menu_toggle_weight.SIZE}}{{mobile_menu_toggle_weight.UNIT}};
						width: {{mobile_menu_toggle_weight.SIZE}}{{mobile_menu_toggle_weight.UNIT}};
						transition: transform 0.3s cubic-bezier(0.28, 0.55, 0.385, 1.65) 0.3s, width 0.3s cubic-bezier(0.28, 0.55, 0.385, 1.65) !important;',

					'.royalstickyheader-header-yes .elementor-menu-toggle.elementor-active:before,
						.royalstickyheader-header-yes .elementor-menu-toggle.elementor-active:after,
						.royalstickyheader-header-yes .elementor-menu-toggle.elementor-active i:after' => 'width: {{SIZE}}{{UNIT}} !important;
						transition: transform 0.3s cubic-bezier(0.28, 0.55, 0.385, 1.65), width 0.3s cubic-bezier(0.28, 0.55, 0.385, 1.65) 0.3s !important;',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_gap',
			[
				'label' => __('Gap', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['em', 'rem', '%', 'px'],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
					'rem' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.01,
					],
					'%' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0.12,
					'unit' => 'em',
				],
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
				'selectors' => [
					'.royalstickyheader-header-yes .elementor-menu-toggle:before,
						.royalstickyheader-header-yes .elementor-menu-toggle:after,
						.royalstickyheader-header-yes .elementor-menu-toggle i:after' => '
						transform: translate(-50%,calc(-50% + {{SIZE}}{{UNIT}} * 2));',
					'.royalstickyheader-header-yes .elementor-menu-toggle:after' => 'transform: translate(-50%,calc(-50% - {{SIZE}}{{UNIT}} * 2));',
				],
			]
		);

		$element->add_control(
			'mobile_menu_toggle_radius',
			[
				'label' => __('Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['em', 'rem', '%', 'px'],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
					'rem' => [
						'min' => 0,
						'max' => 2,
						'step' => 0.01,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0.12,
					'unit' => 'em',
				],
				'condition' => [
					'mobile_menu_toggle_animation' => 'yes',
					'transparent!' => '',
				],
				'frontend_available' => true,
				'selectors' => [
					'.royalstickyheader-header-yes .elementor-menu-toggle:before,
						.royalstickyheader-header-yes .elementor-menu-toggle:after,
						.royalstickyheader-header-yes .elementor-menu-toggle i:after' => '
						border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		

		// ---------------------------------- LOGO COLOR TOGGLE

		$element->add_control(
			'change_logo_color',
			[
				'label' => __( 'Change Logo Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Change the logo image color before or after the user reaches the scroll distance set above', 'royal-addons-for-elementor' ),
				'condition' => [
					'transparent!' => '',
				],
			]
		);

		// ---------------------------------- LOGO COLOR NOTICE

		$element->add_control(
		'logo_color_notice',
			[
				'raw' => __( 'Please select <b>only 1 option</b> for each tab', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition' => [
					'change_logo_color' => 'yes',
					'transparent!' => '',
				],
			]
		);

		// ---------------------------------- LOGO COLOR TABS

		$element->start_controls_tabs(
				'logo_color_tabs'
			);

		// ---------------------------------- LOGO BEFORE TAB

		$element->start_controls_tab(
				'before_tab',
				[
				'label' => __( 'Before scrolling', 'royal-addons-for-elementor' ),
				'condition' => [
						'change_logo_color' => 'yes',
						'transparent!' => '',
					],
				]
			);

		// ---------------------------------- LOGO WHITE BEFORE

		$element->add_control(
			'logo_color_white_before',
			[
				'label' => __( 'White Logo', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Change the logo to white', 'royal-addons-for-elementor' ),
				'prefix_class'  => 'royalstickyheader-header-change-logo-color-',
				'condition' => [
					'change_logo_color' => 'yes',
					'transparent!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .elementor-widget-theme-site-logo:not(.elementor-widget-n-menu .elementor-widget-theme-site-logo), 
					{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .elementor-widget-image:not(.elementor-widget-n-menu .elementor-widget-image), 
					{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .logo' => '-webkit-filter: brightness(0) invert(1); filter: brightness(0) invert(1);',
					'{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .elementor-widget-n-menu .elementor-widget-image, 
					{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .not-logo' => '-webkit-filter: none; filter: none;'
				],
			]
		);

		// ---------------------------------- LOGO BLACK BEFORE

		$element->add_control(
			'logo_color_black_before',
			[
				'label' => __( 'Black Logo', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Change the logo to black', 'royal-addons-for-elementor' ),
				'prefix_class'  => 'royalstickyheader-header-change-logo-color-',
				'condition' => [
					'change_logo_color' => 'yes',
					'transparent!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .elementor-widget-theme-site-logo,
					{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .elementor-widget-image,
					{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .logo' => '-webkit-filter: brightness(0) invert(0); filter: brightness(0) invert(0);',
					'{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .elementor-widget-n-menu .elementor-widget-image, 
					{{WRAPPER}}.royalstickyheader-header-yes:not(.royalstickyheader-header) .not-logo' => '-webkit-filter: none; filter: none;'
				],
			]
		);

		$element->end_controls_tab();

		// ---------------------------------- LOGO AFTER TAB

		$element->start_controls_tab(
			'after_tab',
			[
		'label' => __( 'After Scrolling', 'royal-addons-for-elementor' ),
			'condition' => [
					'change_logo_color' => 'yes',
					'transparent!' => '',
				],
			]
		);

		// ---------------------------------- LOGO WHITE AFTER

		$element->add_control(
			'logo_color_white_after',
			[
				'label' => __( 'White Logo', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Change the logo to white', 'royal-addons-for-elementor' ),
				'prefix_class'  => 'royalstickyheader-header-change-logo-color-',
				'condition' => [
					'change_logo_color' => 'yes',
					'transparent!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header .elementor-widget-theme-site-logo,
					{{WRAPPER}}.royalstickyheader-header .elementor-widget-image,
					{{WRAPPER}}.royalstickyheader-header .logo' => '-webkit-filter: brightness(0) invert(1); filter: brightness(0) invert(1);',
					'{{WRAPPER}}.royalstickyheader-header .elementor-widget-n-menu .elementor-widget-image, 
					{{WRAPPER}}.royalstickyheader-header .not-logo' => '-webkit-filter: none; filter: none;'
				],
			]
		);

		// ---------------------------------- LOGO BLACK AFTER

		$element->add_control(
			'logo_color_black_after',
			[
				'label' => __( 'Black Logo', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Change the logo to black', 'royal-addons-for-elementor' ),
				'prefix_class'  => 'royalstickyheader-header-change-logo-color-',
				'condition' => [
					'change_logo_color' => 'yes',
					'transparent!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header .elementor-widget-theme-site-logo,
					{{WRAPPER}}.royalstickyheader-header .elementor-widget-image,
					{{WRAPPER}}.royalstickyheader-header .logo' => '-webkit-filter: brightness(0) invert(0); filter: brightness(0) invert(0);',
					'{{WRAPPER}}.royalstickyheader-header .elementor-widget-n-menu .elementor-widget-image, 
					{{WRAPPER}}.royalstickyheader-header .not-logo' => '-webkit-filter: none; filter: none;'
				],
			]
		);

		// ---------------------------------- LOGO FULL COLOR AFTER

		$element->add_control(
			'logo_color_full_after',
			[
				'label' => __( 'Full Color Logo', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
				'description' => __( 'Removes all filters to allow a full color logo image', 'royal-addons-for-elementor' ),
				'prefix_class'  => 'royalstickyheader-header-change-logo-color-',
				'condition' => [
					'change_logo_color' => 'yes',
					'transparent!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.royalstickyheader-header .elementor-widget-theme-site-logo,
					{{WRAPPER}}.royalstickyheader-header .elementor-widget-image,
					{{WRAPPER}}.royalstickyheader-header .logo' => '-webkit-filter: brightness(1) invert(0); filter: brightness(1) invert(0);',
					'{{WRAPPER}}.royalstickyheader-header .elementor-widget-n-menu .elementor-widget-image, 
					{{WRAPPER}}.royalstickyheader-header .not-logo' => '-webkit-filter: none; filter: none;'
				],
			]
		);

		$element->end_controls_tab();
		$element->end_controls_tabs();
		

		

		$element->end_controls_section();
	}


	
	

}
RoyalStickyHeader::init();