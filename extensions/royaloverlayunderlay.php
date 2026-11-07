<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter; 
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class RoyalOverlayUnderlay {

	static $should_script_enqueue = false;


	public static function init() {
		// Universal hook that fires for ALL element types including Atomic Containers, Div Blocks, etc.
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'add_section_atomic' ], 10, 2 );

		add_action( 'elementor/element/after_add_attributes',  [ __CLASS__, 'add_attributes' ] );
		// Document Settings :: 
		add_action( 'elementor/element/wp-post/document_settings/before_section_end', [ __CLASS__, 'poopart_remove_horizontal_scroller' ] ); 
		add_action( 'elementor/element/wp-page/document_settings/before_section_end', [ __CLASS__, 'poopart_remove_horizontal_scroller' ] ); 

        /* should enqueue? */
        add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
        /* add script */
        add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

	}

    /* enqueue script JS */
    public static function enqueue_scripts() {
		wp_enqueue_script('royaloverlayunderlay', ROYAL_ADDONS_DIR_URL.'assets/js/extension-overlayunderlay.js', [], '' );
    }

    /* should enqueue? */
    public static function should_script_enqueue( $element ) {

        if( self::$should_script_enqueue ) return;

        if( 'yes' == $element->get_settings_for_display( '_royal_overlay_use' ) ) {

            self::$should_script_enqueue = true;
            self::enqueue_scripts();

            remove_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
        }
    }

	public static function add_attributes( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

        if ( in_array( $element->get_name(), [ 'section', 'column', 'container' ] ) ) return;
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) return;

		$settings = $element->get_settings_for_display();

        if ( isset( $settings[ '_royal_overlay_use' ] ) && 'yes' === $settings[ '_royal_overlay_use' ] ) {

            $element->add_render_attribute( '_wrapper', [
                'class' => 'royal-has-background-overlay'
            ] );

        }

    }


	/* Atomic Elements - registered tracker */
	private static $registered_elements = [];

	public static function add_section_atomic( $element, $section_id = '' ) {
		// Bail out if the object is not a real Element_Base (e.g. Kit document passed by the hook)
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		// Only register once, on the 'section_advanced' hook
		if ( $section_id !== 'section_advanced' ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;
		self::add_section( $element );
	}

    public static function add_section( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;
		$el_name = $element->get_name();
		$is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
		
		$target_tab = $is_atomic ? Controls_Manager::TAB_ADVANCED : Controls_Manager::TAB_ADVANCED;

        $selector_before = '{{WRAPPER}}.royal-has-background-overlay > .elementor-widget-container:before';
        $selector_after = '{{WRAPPER}}.royal-has-background-overlay > .elementor-widget-container:after';
        if ( $is_atomic ) {
            $selector_before = '{{WRAPPER}}.royal-has-background-overlay:before';
            $selector_after = '{{WRAPPER}}.royal-has-background-overlay:after';
        }

		$element->start_controls_section(
            'royalcontrolsection_overlayunderlay',
            [
                'label' => 'Overlay Underlay [Royal]',
				'tab' => $target_tab, 
            ]
		);

		// --------------------------------------------------------------------------------------------- CONTROL: Use Butter Button
		$element->add_control(
			'_royal_overlay_use',
			[
                'label' => __( 'Enable Overlay Underlay?', 'royal-addons-for-elementor' ), 
				'separator' => 'after', 
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		// --------------------------------------------------------------------------------------------- START 2 TABS Overlay & Underlay
		$element->start_controls_tabs( '_royal_tech_tabs' );

		// --------------------------------------------------------------------------------------------- START TAB Overlay
        $element->start_controls_tab(
            '_royal_tech_tab_overlay',
            [
                'label' => __( 'Overlay', 'royal-addons-for-elementor' ),
				'condition' => [
                    '_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
				'name' => '_royal_tech_overlay_background', 
                'selector' => $selector_before,
				'condition' => [
                    '_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND OPACITY
        $element->add_control(
            '_royal_tech_overlay_bg_opacity',
            [
                'label' => __( 'Opacity', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.7,
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
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL FILTERS
		$element->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_royal_tech_overlay_bg_filters',
				'selector' => $selector_before, 
				'condition' => [
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BLEND MODE
        $element->add_control(
            '_royal_tech_overlay_bg_blend_mode',
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
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
        );
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER W H Y X Rot
		$element->add_control(
            '_royal_tech_overlay_popover_whyxrot',
            [
                'label' => __( 'Position and Size', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH
        $element->add_responsive_control(
            '_royal_tech_overlay_w',
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
					'size' => 100,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
							'_royal_tech_overlay_w_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_overlay_w_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_royal_tech_overlay_w_alt' => '', 
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH - Alternative
        $element->add_responsive_control(
            '_royal_tech_overlay_w_alt',
            [
				'label' => __( 'Calc Width', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'width: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT
        $element->add_responsive_control(
            '_royal_tech_overlay_h',
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
					'size' => 100,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
							'_royal_tech_overlay_h_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_overlay_h_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_royal_tech_overlay_h_alt' => '', 
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT - Alternative
        $element->add_responsive_control(
            '_royal_tech_overlay_h_alt',
            [
				'label' => __( 'Calc Height', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 45% + 85px or 100% - 3em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'height: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP
		$element->add_responsive_control(
			'_royal_tech_overlay_y',
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
							'_royal_tech_overlay_y_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_overlay_y_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_royal_tech_overlay_y_alt' => '', 
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP - Alternative
        $element->add_responsive_control(
            '_royal_tech_overlay_y_alt',
            [
				'label' => __( 'Calc Offset Top', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'top: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT
		$element->add_responsive_control(
			'_royal_tech_overlay_x',
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
							'_royal_tech_overlay_x_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_overlay_x_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_before => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'_royal_tech_overlay_x_alt' => '', 
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT - Alternative
        $element->add_responsive_control(
            '_royal_tech_overlay_x_alt',
            [
				'label' => __( 'Calc Offset Left', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 45% + 85px or 100% - 3em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_before => 'left: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER ROTATION
		# NOTE : this is the hack. Elementor does not do well with 'deg' when speaking of responsiveness!
		$element->add_responsive_control(
			'_royal_tech_overlay_rot',
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
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER
		$element->add_control(
            '_royal_tech_overlay_popover_border',
            [
                'label' => __( 'Border', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true, 
				'condition' => [
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER ALL
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_royal_tech_overlay_borders', 
				'label' => __( 'Border', 'royal-addons-for-elementor' ), 
				'selector' => $selector_before, 
				'condition' => [
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER RADIUS
		$element->add_responsive_control(
			'_royal_tech_overlay_border_rad',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'custom' ],
				'selectors' => [
					$selector_before => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_border' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover BORdER end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ
		$element->add_control(
            '_royal_tech_overlay_popover_masq',
            [
                'label' => __( 'Overlay Mask', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
				],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ IMAGE
		$element->add_responsive_control(
			'_royal_tech_overlay_mask_img',
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
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ POSITION
		$element->add_responsive_control(
			'_royal_tech_overlay_mask_position',
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
					'_royal_tech_overlay_mask_img[url]!' => '',
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE
		$element->add_responsive_control(
			'_royal_tech_overlay_mask_size',
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
					'_royal_tech_overlay_mask_img[url]!' => '',
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE Custom
		$element->add_responsive_control(
			'_royal_tech_overlay_mask_size_width', 
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
					'_royal_tech_overlay_mask_size' => [ 'initial' ],
					'_royal_tech_overlay_mask_img[url]!' => '',
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'selectors' => [
							$selector_before => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_royal_tech_overlay_mask_size' => [ 'initial' ], 
							'_royal_tech_overlay_popover_masq' => 'yes', 
							'_royal_overlay_use' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'selectors' => [
							$selector_before => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_royal_tech_overlay_mask_size' => [ 'initial' ], 
							'_royal_tech_overlay_popover_masq' => 'yes', 
							'_royal_overlay_use' => 'yes', 
						],
					],
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ REPEAT
		$element->add_responsive_control(
			'_royal_tech_overlay_mask_repeat',
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
					'_royal_tech_overlay_mask_img[url]!' => '',
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_overlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);

		$element->end_popover(); // popover MASQ end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER CLIP PATH since 1.6.4
        $element->add_control(
			'_royal_tech_overlay_clip_path',
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
					'_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		// --------------------------------------------------------------------------------------------- CONTROL Z-INDeX
		$element->add_control(
			'_royal_tech_overlay_z_index',
			[
				'label' => __( 'Z-Index', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -9999,
				'default' => -1, 
				'selectors' => [
					$selector_before => 'z-index: {{VALUE}};',
				],
				'label_block' => false, 
				'condition' => [
                    '_royal_tech_overlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->end_controls_tab(); // Overlay tab end

		// --------------------------------------------------------------------------------------------- START TAB Underlay ------------------------------- >>>>>

		$element->start_controls_tab(
            '_royal_tech_tab_underlay',
            [
                'label' => __( 'Underlay', 'royal-addons-for-elementor' ),
				'condition' => [
                    '_royal_overlay_use' => 'yes', 
                ],
            ]
		);

		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
				'name' => '_royal_tech_underlay_background', 
                'selector' => $selector_after, 
				'condition' => [
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BACKGROUND OPACITY
        $element->add_control(
            '_royal_tech_underlay_bg_opacity',
            [
                'label' => __( 'Opacity', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.7,
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
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL FILTERS
		$element->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => '_royal_tech_underlay_bg_filters',
				'selector' => $selector_after, 
				'condition' => [
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL BLEND MODE
        $element->add_control(
            '_royal_tech_underlay_bg_blend_mode',
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
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
            ]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER W H Y X Rot
		$element->add_control(
			'_royal_tech_underlay_popover_whyxrot',
			[
				'label' => __( 'Position and Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true, 
				'condition' => [
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH
		$element->add_responsive_control(
			'_royal_tech_underlay_w',
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
					'size' => 100,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
							'_royal_tech_underlay_w_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_underlay_w_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    '_royal_tech_underlay_w_alt' => '', 
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER WIDTH - Alternative
        $element->add_responsive_control(
            '_royal_tech_underlay_w_alt',
            [
				'label' => __( 'Calc Width', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'width: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT
		$element->add_responsive_control(
			'_royal_tech_underlay_h',
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
					'size' => 100,
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'condition' => [
							'_royal_tech_underlay_h_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_underlay_h_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    '_royal_tech_underlay_h_alt' => '', 
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER HEIGHT - Alternative
        $element->add_responsive_control(
            '_royal_tech_underlay_h_alt',
            [
				'label' => __( 'Calc Height', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 45% + 85px or 100% - 3em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'height: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP
		$element->add_responsive_control(
			'_royal_tech_underlay_y',
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
							'_royal_tech_underlay_y_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_underlay_y_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    '_royal_tech_underlay_y_alt' => '', 
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET TOP - Alternative
        $element->add_responsive_control(
            '_royal_tech_underlay_y_alt',
            [
				'label' => __( 'Calc Offset Top', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'top: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT
		$element->add_responsive_control(
			'_royal_tech_underlay_x',
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
							'_royal_tech_underlay_x_alt' => '', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'condition' => [
							'_royal_tech_underlay_x_alt' => '', 
						],
					],
				],
				'selectors' => [
					$selector_after => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
                    '_royal_tech_underlay_x_alt' => '', 
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER OFFSET LEFT - Alternative
        $element->add_responsive_control(
            '_royal_tech_underlay_x_alt',
            [
				'label' => __( 'Calc Offset Left', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter CSS calc value only! Like: 100% - 50px or 100% + 2em', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					$selector_after => 'left: calc({{VALUE}});',
				],
				'condition' => [
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER ROTATION
		# NOTE : this is the hack. Elementor does not do well with 'deg' when speaking of responsiveness!
		$element->add_responsive_control(
			'_royal_tech_underlay_rot',
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
					'_royal_tech_underlay_popover_whyxrot' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER
		$element->add_control(
			'_royal_tech_underlay_popover_border',
			[
				'label' => __( 'Border', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'frontend_available' => true, 
				'condition' => [
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER ALL
		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_royal_tech_underlay_borders', 
				'label' => __( 'Border', 'royal-addons-for-elementor' ), 
				'selector' => $selector_after, 
				'condition' => [
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER BORDER RADIUS
		$element->add_responsive_control(
			'_royal_tech_underlay_border_rad',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'custom' ],
				'selectors' => [
					$selector_after => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_underlay_popover_border' => 'yes', 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->end_popover(); // popover BORdER end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ - UNDERLAY ------------------->>
		$element->add_control(
            '_royal_tech_underlay_popover_masq',
            [
                'label' => __( 'Underlay Mask', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'return_value' => 'yes',
				'frontend_available' => true,
				'condition' => [
					'_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
				],
            ]
		);
		
		$element->start_popover();

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ IMAGE
		$element->add_responsive_control(
			'_royal_tech_underlay_mask_img',
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
					'_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_tech_underlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ POSITION
		$element->add_responsive_control(
			'_royal_tech_underlay_mask_position',
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
					'_royal_tech_underlay_mask_img[url]!' => '',
					'_royal_tech_underlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE
		$element->add_responsive_control(
			'_royal_tech_underlay_mask_size',
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
					'_royal_tech_underlay_mask_img[url]!' => '',
					'_royal_tech_underlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ SIZE Custom
		$element->add_responsive_control(
			'_royal_tech_underlay_mask_size_width', 
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
					'_royal_tech_underlay_mask_size' => [ 'initial' ],
					'_royal_tech_underlay_mask_img[url]!' => '', 
					'_royal_tech_underlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'selectors' => [
							$selector_after => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_royal_tech_underlay_mask_size' => [ 'initial' ], 
							'_royal_tech_underlay_popover_masq' => 'yes', 
							'_royal_overlay_use' => 'yes', 
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'selectors' => [
							$selector_after => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_royal_tech_underlay_mask_size' => [ 'initial' ], 
							'_royal_tech_underlay_popover_masq' => 'yes', 
							'_royal_overlay_use' => 'yes', 
						],
					],
				],
			]
		);
		// --------------------------------------------------------------------------------------------- CONTROL POPOVER MASQ REPEAT
		$element->add_responsive_control(
			'_royal_tech_underlay_mask_repeat',
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
					'_royal_tech_underlay_mask_img[url]!' => '', 
					'_royal_tech_underlay_popover_masq' => 'yes', 
					'_royal_overlay_use' => 'yes', 
				],
			]
		);

		$element->end_popover(); // popover MASQ end

		// --------------------------------------------------------------------------------------------- CONTROL POPOVER CLIP PATH since 1.6.4
        $element->add_control(
			'_royal_tech_underlay_clip_path',
			[				
                'label' => __( 'Clip path', 'royal-addons-for-elementor' ), 
                'description' => sprintf(
                    __( 'Enter the full clip-path property! See the copy-paste examples at %sClippy%s', 'royal-addons-for-elementor' ),
                    '<a href="https://bennettfeely.com/clippy/" target="_blank">',
                    '</a>'
				),
				'default' => '', 
				'type' => Controls_Manager::TEXTAREA, 
				'rows' => 3, 
				'selectors' => [
					$selector_after => '{{VALUE}}',
				],
				'condition' => [
					'_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		// --------------------------------------------------------------------------------------------- CONTROL Z-INDeX
		$element->add_control(
			'_royal_tech_underlay_z_index',
			[
				'label' => __( 'Z-Index', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -9999,
				'default' => -1, 
				'selectors' => [
					$selector_after => 'z-index: {{VALUE}};',
				],
				'label_block' => false, 
				'condition' => [
                    '_royal_tech_underlay_background_background' => [ 'classic', 'gradient' ], 
					'_royal_overlay_use' => 'yes', 
                ],
			]
		);

		$element->end_controls_tab(); // Underlay tab end

		$element->end_controls_tabs(); // Underlay and Overlay tabs end

		$element->end_controls_section(); // END SECTION / PANEL

	}


    public static function poopart_remove_horizontal_scroller( \Elementor\Core\DocumentTypes\PageBase $page ) {

		// ------------------------------------------------------------------------- CONTROL: get rid of horizontal scroller
		$page->add_control(
			'_royal_tech_no_horizontal_scroller',
			[
				'label' => __( 'Get rid of the Horizontal scroller?', 'royal-addons-for-elementor' ),
				'description' => __( 'POOOPART may cause Horizontal Scroller to show up. This is how you can remove it.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'hidden',
				'default' => 'auto',
				'selectors' => [
					'html, body' => 'overflow-x: {{VALUE}};',
				],
				'label_block' => false,
				'separator' => 'before', 
				'condition' => [
                    '_royal_overlay_use' => 'yes', 
                ],
			]
		);	

		// ------------------------------------------------------------------------- CONTROL: design your baseline grid
		$page->add_control(
			'_royal_tech_use_baseline_grid',
			[
				'label' => __( 'Baseline Grid', 'royal-addons-for-elementor' ),
				'description' => __( 'Baseline grid helps you maintain accuracy and consistency', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
				'label_block' => false,
				'separator' => 'before', 
			]
		);
        $page->add_control(
            '_royal_tech_baseline_grid_style',
            [
                'label' => __( 'Grid style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both', 
                'options' => [
                    'both' => __( 'Squares', 'royal-addons-for-elementor' ),
                    'vertical' => __( 'Vertical lines', 'royal-addons-for-elementor' ),
                    'horizontal' => __( 'Horizontal lines', 'royal-addons-for-elementor' ),
				],
				'condition' => [
                    '_royal_tech_use_baseline_grid' => 'yes', 
                ],
            ]
        );
		$page->add_control(
			'_royal_tech_baseline_grid_color',
			[
				'label' => __( 'Grid color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F9F9F9', 
				'condition' => [
                    '_royal_tech_use_baseline_grid' => 'yes', 
                ],
			]
		);
		$page->add_control(
			'_royal_tech_baseline_grid_size',
			[
				'label' => __( 'Grid size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER, 
				'range' => [
					'px' => [
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'html.elementor-html::before' => 'background-image: repeating-linear-gradient(to right, {{_royal_tech_baseline_grid_color.VALUE}}, {{_royal_tech_baseline_grid_color.VALUE}} 1px, transparent 1px, transparent), repeating-linear-gradient(to bottom, {{_royal_tech_baseline_grid_color.VALUE}}, {{_royal_tech_baseline_grid_color.VALUE}} 1px, transparent 1px, transparent);background-size: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};', 
				],
				'condition' => [
					'_royal_tech_use_baseline_grid' => 'yes', 
					'_royal_tech_baseline_grid_style' => [ 'both' ], 
                ],
			]
		);
		$page->add_control(
			'_royal_tech_baseline_grid_size_vert',
			[
				'label' => __( 'Vertical Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER, 
				'range' => [
					'px' => [
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'html.elementor-html::before' => 'background-image: repeating-linear-gradient(90deg, {{_royal_tech_baseline_grid_color.VALUE}}, {{_royal_tech_baseline_grid_color.VALUE}} 1px, transparent 1px, transparent);background-size: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};', 
				],
				'condition' => [
					'_royal_tech_use_baseline_grid' => 'yes', 
					'_royal_tech_baseline_grid_style' => [ 'vertical' ], 
                ],
			]
		);
		$page->add_control(
			'_royal_tech_baseline_grid_size_horiz',
			[
				'label' => __( 'Horizontal Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER, 
				'range' => [
					'px' => [
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'html.elementor-html::before' => 'background-image: repeating-linear-gradient(0deg, {{_royal_tech_baseline_grid_color.VALUE}}, {{_royal_tech_baseline_grid_color.VALUE}} 1px, transparent 1px, transparent);background-size: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};', 
				],
				'condition' => [
					'_royal_tech_use_baseline_grid' => 'yes', 
					'_royal_tech_baseline_grid_style' => [ 'horizontal' ], 
                ],
			]
		);

	}

}

RoyalOverlayUnderlay::init();