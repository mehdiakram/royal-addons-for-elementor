<?php
use Elementor\Controls_Manager; 
use Elementor\Element_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter; 
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalPseudo {
	
	public static function init() {
		// Universal hook that fires for ALL element types including Atomic Containers, Div Blocks, etc.
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'add_section_atomic' ], 10, 2 );

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );

		add_action( 'elementor/element/after_add_attributes', [ __CLASS__, 'add_render_attributes' ], 10, 1 );
	}

	public static function add_render_attributes( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		$settings = $is_atomic && method_exists($element, 'get_atomic_settings') ? $element->get_atomic_settings() : $element->get_settings();

		if ( 'yes' === ( $settings['royal_pseudo'] ?? '' ) ) {
			$element->add_render_attribute( '_wrapper', 'class', 'royal-pseudo-active' );
		}
	}

	public static function add_atomic_props_schema( $schema ) {
		$schema['royal_pseudo'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('no');
		return $schema;
	}

	public static function add_atomic_controls( $controls, $element ) {
		$controls[] = \Elementor\Modules\AtomicWidgets\Controls\Section::make()
			->set_id( 'royalcontrolsection_pseudo_atomic' )
			->set_label( __( 'Pseudo Elements [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( [
				\Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control::bind_to( 'royal_pseudo' )
					->set_label( __( 'Enable Pseudo Elements', 'royal-addons-for-elementor' ) )
			] );

		return $controls;
	}

	/* Atomic Elements - registered tracker for add_section */
	private static $registered_sections = [];

	public static function add_section_atomic( $element, $section_id = '' ) {
		// Only register once, on the 'section_advanced' hook
		if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro' ] ) ) return;

		self::royalpseudo_hook( $element );
	}

    public static function royalpseudo_hook( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_sections[ $element_id ] ) ) {
			return;
		}
		self::$registered_sections[ $element_id ] = true;
		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		
		$target_tab = $is_atomic ? Controls_Manager::TAB_ADVANCED : Controls_Manager::TAB_ADVANCED;

		$selector_before = '{{WRAPPER}}.royal-pseudo-yes > .e-con-inner::before, {{WRAPPER}}.royal-pseudo-yes::before'; 
		$selector_after  = '{{WRAPPER}}.royal-pseudo-yes > .e-con-inner::after, {{WRAPPER}}.royal-pseudo-yes::after'; 

		if ( $el_name === 'section' ) {
			$selector_before = '{{WRAPPER}}.royal-pseudo-yes > .elementor-container::before'; 
			$selector_after  = '{{WRAPPER}}.royal-pseudo-yes > .elementor-container::after'; 
		} elseif ( $el_name === 'column' ) {
			$selector_before = '{{WRAPPER}}.royal-pseudo-yes > .elementor-column-wrap::before, {{WRAPPER}}.royal-pseudo-yes > .elementor-widget-wrap::before'; 
			$selector_after  = '{{WRAPPER}}.royal-pseudo-yes > .elementor-column-wrap::after, {{WRAPPER}}.royal-pseudo-yes > .elementor-widget-wrap::after'; 
		} elseif ( $is_atomic ) {
			$selector_before = '{{WRAPPER}}.royal-pseudo-yes::before'; 
			$selector_after  = '{{WRAPPER}}.royal-pseudo-yes::after'; 
		} elseif ( $el_name !== 'container' ) {
			$selector_before = '{{WRAPPER}}.royal-pseudo-yes > .elementor-widget-container::before'; 
			$selector_after  = '{{WRAPPER}}.royal-pseudo-yes > .elementor-widget-container::after'; 
		} 

        //  create panel
        $element->start_controls_section(
            'royalcontrolsection_pseudo',
            [
                'label' => 'Pseudo [Royal]',
				'tab' => $target_tab, 
            ]
		);
        
		$element->add_control(
			'royal_pseudo',
			[
                'label' => __( 'Enable Pseudo?', 'royal-addons-for-elementor' ), 
				'description' => __( 'This is how you can create and manage :before and :after pseudo elements for this column', 'royal-addons-for-elementor' ), 
				'separator' => 'before', 
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
				'frontend_available' => true,
				'prefix_class'  => 'royal-pseudo-',
				'selectors' => [
                    $selector_before => 'content: ""; position: absolute; pointer-events: none;',
                    $selector_after => 'content: ""; position: absolute; pointer-events: none;',
				],
			]
		);

        // --------------------------------------------------------------------------------------------- START 2 TABS Before & After
		$element->start_controls_tabs( '_ob_pseudo_tabs' );

		// --------------------------------------------------------------------------------------------- START TAB Before
        $element->start_controls_tab(
            '_ob_pseudo_tab_before',
            [
                'label' => __( 'Before', 'royal-addons-for-elementor' ),
				 'condition' => [
                    'royal_pseudo' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
				'name' => '_ob_pseudo_before_background', 
                'selector' => $selector_before, 
                'condition' => [
                    'royal_pseudo' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND OPACITY
        $element->add_control(
            '_ob_pseudo_before_bg_opacity',
            [
                'label' => __( 'Opacity', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    $selector_before => 'opacity: {{SIZE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL FILTERS
		$element->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_ob_pseudo_before_bg_filters',
				'selector' => $selector_before, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BLEND MODE
        $element->add_control(
            '_ob_pseudo_before_bg_blend_mode',
            [
                'label' => __( 'Blend Mode', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'Normal', 'royal-addons-for-elementor' ),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    $selector_before => 'mix-blend-mode: {{VALUE}}',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
        );

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER W H Y X Rot
		$element->add_control(
            '_ob_pseudo_before_popover_whyxrot',
            [
                'label' => __( 'Position and Size', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH
        $element->add_responsive_control(
            '_ob_pseudo_before_w',
            [
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_w_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_w_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_w_alt' => '', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_before_w_alt',
            [
				'label' => __( 'Calc Width', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'width: calc({{VALUE}});',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT
        $element->add_responsive_control(
            '_ob_pseudo_before_h',
            [
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_h_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_h_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_h_alt' => '', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_before_h_alt',
            [
				'label' => __( 'Calc Height', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 45% + 85px or 100% - 3em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'height: calc({{VALUE}});',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP
		$element->add_responsive_control(
			'_ob_pseudo_before_y',
			[
				'label' => __( 'Offset Top', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_y_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_y_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_y_alt' => '', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_before_y_alt',
            [
				'label' => __( 'Calc Offset Top', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'top: calc({{VALUE}});',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT
		$element->add_responsive_control(
			'_ob_pseudo_before_x',
			[
				'label' => __( 'Offset Left', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_x_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_x_alt' => '', 
							'_ob_pseudo_before_popover_whyxrot' => 'yes', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_x_alt' => '', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_before_x_alt',
            [
				'label' => __( 'Calc Offset Left', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 45% + 85px or 100% - 3em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'left: calc({{VALUE}});',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER ROTATION
		# NOTE : this is the hack. Elementor does not do well with 'deg' when speaking of responsiveness!
		$element->add_responsive_control(
			'_ob_pseudo_before_rot',
			[
				'label' => __( 'Rotate', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					$selector_before => 'transform: rotate({{SIZE}}deg);',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_whyxrot' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER
		$element->add_control(
            '_ob_pseudo_before_popover_border',
            [
                'label' => __( 'Border', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER ALL
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_ob_pseudo_before_borders', 
				'label' => __( 'Border', 'royal-addons-for-elementor' ), 
				'selector' => $selector_before, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER RADIUS
		$element->add_responsive_control(
			'_ob_pseudo_before_border_rad',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'custom' ],
				'selectors' => [
					$selector_before => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_border' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover BORdER end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ
		$element->add_control(
            '_ob_pseudo_before_popover_masq',
            [
                'label' => __( 'Before Mask', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
				],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ IMAGE
		$element->add_responsive_control(
			'_ob_pseudo_before_mask_img',
			[
				'label' => __( 'Choose Image Mask', 'royal-addons-for-elementor' ),
				'description' => __( 'NOTE: Image Mask should be black-and-transparent SVG file! Anything that’s 100% black in the image mask with be completely visible, anything that’s transparent will be completely hidden.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'selectors' => [
					$selector_before => '-webkit-mask-image: url("{{URL}}"); mask-image: url("{{URL}}"); -webkit-mask-mode: alpha; mask-mode: alpha;',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_masq' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ POSITION
		$element->add_responsive_control(
			'_ob_pseudo_before_mask_position',
			[
				'label' => __( 'Mask position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'center center' => __( 'Center Center', 'royal-addons-for-elementor' ),
					'center left' => __( 'Center Left', 'royal-addons-for-elementor' ),
					'center right' => __( 'Center Right', 'royal-addons-for-elementor' ),
					'top center' => __( 'Top Center', 'royal-addons-for-elementor' ),
					'top left' => __( 'Top Left', 'royal-addons-for-elementor' ),
					'top right' => __( 'Top Right', 'royal-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'royal-addons-for-elementor' ),
					'bottom left' => __( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom right' => __( 'Bottom Right', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector_before => '-webkit-mask-position: {{VALUE}}; mask-position: {{VALUE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_mask_img[url]!' => '',
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_masq' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE
		$element->add_responsive_control(
			'_ob_pseudo_before_mask_size',
			[
				'label' => __( 'Mask size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'contain', 
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'auto' => __( 'Auto', 'royal-addons-for-elementor' ),
					'cover' => __( 'Cover', 'royal-addons-for-elementor' ),
					'contain' => __( 'Contain', 'royal-addons-for-elementor' ),
					'initial' => __( 'Custom', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector_before => '-webkit-mask-size: {{VALUE}}; mask-size: {{VALUE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_mask_img[url]!' => '',
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_masq' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE Custom
		$element->add_responsive_control(
			'_ob_pseudo_before_mask_size_width', 
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					$selector_before => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_mask_size' => [ 'initial' ],
					'_ob_pseudo_before_mask_img[url]!' => '',
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_masq' => 'yes', 
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'selectors' => [
							$selector_before => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_mask_size' => [ 'initial' ],
							'_ob_pseudo_before_popover_masq' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'selectors' => [
							$selector_before => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_before_mask_size' => [ 'initial' ], 
							'_ob_pseudo_before_popover_masq' => 'yes', 
						],
					],
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ REPEAT
		$element->add_responsive_control(
			'_ob_pseudo_before_mask_repeat',
			[
				'label' => __( 'Mask repeat', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'no-repeat' => __( 'No-repeat', 'royal-addons-for-elementor' ),
					'repeat' => __( 'Repeat', 'royal-addons-for-elementor' ),
					'repeat-x' => __( 'Repeat-x', 'royal-addons-for-elementor' ),
					'repeat-y' => __( 'Repeat-y', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector_before => '-webkit-mask-repeat: {{VALUE}}; mask-repeat: {{VALUE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_mask_img[url]!' => '',
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_before_popover_masq' => 'yes', 
				],
			]
		);

		$element->end_popover(); // popover MASQ end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER CLIP PATH since 1.6.4
        $element->add_control(
			'_ob_pseudo_before_clip_path',
			[				
                'label' => __( 'Clip path', 'royal-addons-for-elementor' ), 
                'description' => sprintf(
                    __( 'Enter the full clip-path property! See the copy-paste examples at %sClippy%s', 'royal-addons-for-elementor' ),
                    '<a href="https://mehdiakram.github.io/clippy/" target="_blank">',
                    '</a>'
				),
				'default' => '', 
				'type' => Controls_Manager::TEXTAREA, 
				'rows' => 3, 
				'selectors' => [
					$selector_before => '{{VALUE}}',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);

		// --------------------------------------------------------------------------------------------- CONTROL Z-INDeX
		$element->add_control(
			'_ob_pseudo_before_z_index',
			[
				'label' => __( 'Z-Index', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -9999,
				'default' => 0, 
				'selectors' => [
					$selector_before => 'z-index: {{VALUE}};',
				],
				'label_block' => false, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_before_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);

		$element->end_controls_tab(); // Before tab end

		// --------------------------------------------------------------------------------------------- START TAB After ------------------------------- >>>>>

		$element->start_controls_tab(
            '_ob_pseudo_tab_after',
            [
                'label' => __( 'After', 'royal-addons-for-elementor' ),
				'condition' => [
                    'royal_pseudo' => 'yes', 
                ],
            ]
		);

		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
				'name' => '_ob_pseudo_after_background', 
                'selector' => $selector_after, 
                'condition' => [
                    'royal_pseudo' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND OPACITY
        $element->add_control(
            '_ob_pseudo_after_bg_opacity',
            [
                'label' => __( 'Opacity', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    $selector_after => 'opacity: {{SIZE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL FILTERS
		$element->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_ob_pseudo_after_bg_filters',
				'selector' => $selector_after, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BLEND MODE
        $element->add_control(
            '_ob_pseudo_after_bg_blend_mode',
            [
                'label' => __( 'Blend Mode', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'Normal', 'royal-addons-for-elementor' ),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    $selector_after => 'mix-blend-mode: {{VALUE}}',
				], 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER W H Y X Rot
		$element->add_control(
			'_ob_pseudo_after_popover_whyxrot',
			[
				'label' => __( 'Position and Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);

		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH
		$element->add_responsive_control(
			'_ob_pseudo_after_w',
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_w_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_w_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_w_alt' => '', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_after_w_alt',
            [
				'label' => __( 'Calc Width', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'width: calc({{VALUE}});',
				],
                'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT
		$element->add_responsive_control(
			'_ob_pseudo_after_h',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_h_alt' => '', 
							'_ob_pseudo_after_popover_whyxrot' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_h_alt' => '', 
							'_ob_pseudo_after_popover_whyxrot' => 'yes', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_h_alt' => '', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_after_h_alt',
            [
				'label' => __( 'Calc Height', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 45% + 85px or 100% - 3em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'height: calc({{VALUE}});',
				],
                'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP
		$element->add_responsive_control(
			'_ob_pseudo_after_y',
			[
				'label' => __( 'Offset Top', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_y_alt' => '', 
							'_ob_pseudo_after_popover_whyxrot' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_y_alt' => '', 
							'_ob_pseudo_after_popover_whyxrot' => 'yes', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_y_alt' => '', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_after_y_alt',
            [
				'label' => __( 'Calc Offset Top', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'top: calc({{VALUE}});',
				],
                'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT
		$element->add_responsive_control(
			'_ob_pseudo_after_x',
			[
				'label' => __( 'Offset Left', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'%' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_x_alt' => '', 
							'_ob_pseudo_after_popover_whyxrot' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_x_alt' => '', 
							'_ob_pseudo_after_popover_whyxrot' => 'yes', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_x_alt' => '', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT - Alternative
        $element->add_responsive_control(
            '_ob_pseudo_after_x_alt',
            [
				'label' => __( 'Calc Offset Left', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'left: calc({{VALUE}});',
				],
                'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER ROTATION
		# NOTE : this is the hack. Elementor does not do well with 'deg' when speaking of responsiveness!
		$element->add_responsive_control(
			'_ob_pseudo_after_rot',
			[
				'label' => __( 'Rotate', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 360,
						'step' => 5,
					],
				],
				'default' => [
					'size' => 0,
				],
				'selectors' => [
					$selector_after => 'transform: rotate({{SIZE}}deg);',
				],
                'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_popover_whyxrot' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER
		$element->add_control(
			'_ob_pseudo_after_popover_border',
			[
				'label' => __( 'Border', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);

		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER ALL
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_ob_pseudo_after_borders', 
				'label' => __( 'Border', 'royal-addons-for-elementor' ), 
				'selector' => $selector_after, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER RADIUS
		$element->add_responsive_control(
			'_ob_pseudo_after_border_rad',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'custom' ],
				'selectors' => [
					$selector_after => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_after_popover_border' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover BORdER end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ - After ------------------->>
		$element->add_control(
            '_ob_pseudo_after_popover_masq',
            [
                'label' => __( 'After Mask', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
				],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ IMAGE
		$element->add_responsive_control(
			'_ob_pseudo_after_mask_img',
			[
				'label' => __( 'Choose Image Mask', 'royal-addons-for-elementor' ),
				'description' => __( 'NOTE: Image Mask should be black-and-transparent SVG file! Anything that’s 100% black in the image mask with be completely visible, anything that’s transparent will be completely hidden.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'selectors' => [
					$selector_after => '-webkit-mask-image: url("{{URL}}"); mask-image: url("{{URL}}"); -webkit-mask-mode: alpha; mask-mode: alpha;',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
					'_ob_pseudo_after_popover_masq' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ POSITION
		$element->add_responsive_control(
			'_ob_pseudo_after_mask_position',
			[
				'label' => __( 'Mask position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'center center' => __( 'Center Center', 'royal-addons-for-elementor' ),
					'center left' => __( 'Center Left', 'royal-addons-for-elementor' ),
					'center right' => __( 'Center Right', 'royal-addons-for-elementor' ),
					'top center' => __( 'Top Center', 'royal-addons-for-elementor' ),
					'top left' => __( 'Top Left', 'royal-addons-for-elementor' ),
					'top right' => __( 'Top Right', 'royal-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'royal-addons-for-elementor' ),
					'bottom left' => __( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom right' => __( 'Bottom Right', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector_after => '-webkit-mask-position: {{VALUE}}; mask-position: {{VALUE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_mask_img[url]!' => '',
					'_ob_pseudo_after_popover_masq' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE
		$element->add_responsive_control(
			'_ob_pseudo_after_mask_size',
			[
				'label' => __( 'Mask size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'contain', 
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'auto' => __( 'Auto', 'royal-addons-for-elementor' ),
					'cover' => __( 'Cover', 'royal-addons-for-elementor' ),
					'contain' => __( 'Contain', 'royal-addons-for-elementor' ),
					'initial' => __( 'Custom', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector_after => '-webkit-mask-size: {{VALUE}}; mask-size: {{VALUE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_mask_img[url]!' => '',
					'_ob_pseudo_after_popover_masq' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE Custom
		$element->add_responsive_control(
			'_ob_pseudo_after_mask_size_width', 
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					$selector_after => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_mask_size' => [ 'initial' ],
					'_ob_pseudo_after_mask_img[url]!' => '',
					'_ob_pseudo_after_popover_masq' => 'yes', 
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'selectors' => [
							$selector_after => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_mask_size' => [ 'initial' ],
							'_ob_pseudo_after_popover_masq' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'selectors' => [
							$selector_after => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
                            'royal_pseudo' => 'yes', 
							'_ob_pseudo_after_mask_size' => [ 'initial' ], 
							'_ob_pseudo_after_popover_masq' => 'yes', 
						],
					],
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ REPEAT
		$element->add_responsive_control(
			'_ob_pseudo_after_mask_repeat',
			[
				'label' => __( 'Mask repeat', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'no-repeat' => __( 'No-repeat', 'royal-addons-for-elementor' ),
					'repeat' => __( 'Repeat', 'royal-addons-for-elementor' ),
					'repeat-x' => __( 'Repeat-x', 'royal-addons-for-elementor' ),
					'repeat-y' => __( 'Repeat-y', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector_after => '-webkit-mask-repeat: {{VALUE}}; mask-repeat: {{VALUE}};',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_mask_img[url]!' => '',
					'_ob_pseudo_after_popover_masq' => 'yes', 
				],
			]
		);

		$element->end_popover(); // popover MASQ end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER CLIP PATH since 1.6.4
        $element->add_control(
			'_ob_pseudo_after_clip_path',
			[				
                'label' => __( 'Clip path', 'royal-addons-for-elementor' ), 
                'description' => sprintf(
                    __( 'Enter the full clip-path property! See the copy-paste examples at %sClippy%s', 'royal-addons-for-elementor' ),
                    '<a href="https://mehdiakram.github.io/clippy/" target="_blank">',
                    '</a>'
				),
				'default' => '', 
				'type' => Controls_Manager::TEXTAREA, 
				'rows' => 3, 
				'selectors' => [
					$selector_after => '{{VALUE}}',
				],
				'condition' => [
                    'royal_pseudo' => 'yes', 
					'_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);

		// --------------------------------------------------------------------------------------------- CONTROL Z-INDeX
		$element->add_control(
			'_ob_pseudo_after_z_index',
			[
				'label' => __( 'Z-Index', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -9999,
				'default' => 0, 
				'selectors' => [
					$selector_after => 'z-index: {{VALUE}};',
				],
				'label_block' => false, 
				'condition' => [
                    'royal_pseudo' => 'yes', 
                    '_ob_pseudo_after_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);

		$element->end_controls_tab(); // After tab end

		$element->end_controls_tabs(); // After and Before tabs end


		$element->end_controls_section(); // END SECTION / PANEL


    }




}
RoyalPseudo::init();