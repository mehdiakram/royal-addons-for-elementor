<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class RoyalTooltip {

    static $should_script_enqueue = false;

    public static function init() {
		// Register controls on legacy Elements, Widgets, and Containers
		add_action( 'elementor/element/after_section_end', [ __CLASS__, 'royal_wrapper_tooltip_atomic' ], 10, 2 );

        // Enqueue scripts
        add_action('wp_enqueue_scripts', [__CLASS__, 'royaltooltipjs_enqueue_scripts']);
        add_action('elementor/preview/enqueue_scripts', [__CLASS__, 'royaltooltipjs_enqueue_scripts']);

		// Elementor 4 Atomic API Hooks
		add_filter( 'elementor/atomic-widgets/props-schema', [ __CLASS__, 'add_atomic_props_schema' ], 10, 1 );
		add_filter( 'elementor/atomic-widgets/controls', [ __CLASS__, 'add_atomic_controls' ], 10, 2 );
		
        // Universal Render Hooks (covers Legacy Container, Atomic Div Block, Legacy Widget, Atomic Widget)
		add_action( 'elementor/element/after_add_attributes', [ __CLASS__, 'render_universal' ] );
		add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'render_universal' ] );
    }

    public static function royaltooltipjs_enqueue_scripts() {
		wp_enqueue_script(
			'royal-tooltip-js',
			ROYAL_ADDONS_DIR_URL . 'assets/js/extension-royaltooltip.js',
			['jquery', 'elementor-frontend'],
			ROYAL_ADDONS_VERSION . '-' . time(),
			true
		);
    }




    /* Atomic Elements - registered tracker */
    private static $registered_elements = [];

    public static function royal_wrapper_tooltip_atomic( $element, $section_id = '' ) {
		$trigger_ids = [
			'section_advanced', 'section_custom_css_pro', 'section_custom_css', 'section_effects'
		];
		if ( ! in_array( $section_id, $trigger_ids, true ) ) {
			return;
		}

		self::royal_wrapper_tooltip( $element );
	}

    public static function royal_wrapper_tooltip( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;

        $element->start_controls_section(
            'royalcontrolsection_tooltip',
            [
                'label' => __('Tooltip [Royal]', 'royal-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'royal_tooltip_enable',
            [
                'label'       => __('Enable Tooltip?', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SWITCHER,
                'label_on' => __('On', 'royal-addons-for-elementor'),
                'label_off' => __('Off', 'royal-addons-for-elementor'),
                'return_value' => 'enable',
                'prefix_class' => 'royal-tooltip-',
                'default' => '',
                'frontend_available' => true,
            ]
        );

        $element->start_controls_tabs('royal_tooltip_tabs');

        $element->start_controls_tab('royal_tooltip_settings', [
            'label' => __('Settings', 'royal-addons-for-elementor'),
            'condition' => [
                'royal_tooltip_enable!' => '',
            ],
        ]);

        $element->add_control(
            'royal_tooltip_content',
            [
                'label' => __('Content', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::TEXTAREA,
                'rows' => 5,
                'default' => __('I am a tooltip', 'royal-addons-for-elementor'),
                'dynamic' => ['active' => true],
                'frontend_available' => true,
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_tooltip_position',
            [
                'label' => __('Position', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => __('Top', 'royal-addons-for-elementor'),
                    'bottom' => __('Bottom', 'royal-addons-for-elementor'),
                    'left' => __('Left', 'royal-addons-for-elementor'),
                    'right' => __('Right', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'prefix_class' => 'royal-tooltip%s-',
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_control(
            'royal_tooltip_animation',
            [
                'label' => __('Animation', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('None', 'royal-addons-for-elementor'),
                    'royal_fadeIn' => __('fadeIn', 'royal-addons-for-elementor'),
                    'royal_zoomIn' => __('zoomIn', 'royal-addons-for-elementor'),
                    'royal_rollIn' => __('rollIn', 'royal-addons-for-elementor'),
                    'royal_bounce' => __('bounce', 'royal-addons-for-elementor'),
                    'royal_slideInDown' => __('slideInDown', 'royal-addons-for-elementor'),
                    'royal_slideInLeft' => __('slideInLeft', 'royal-addons-for-elementor'),
                    'royal_slideInRight' => __('slideInRight', 'royal-addons-for-elementor'),
                    'royal_slideInUp' => __('slideInUp', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_control(
            'royal_tooltip_duration',
            [
                'label' => __('Animation Duration (ms)', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 5000,
                'step' => 50,
                'default' => 1000,
                'frontend_available' => true,
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_control(
            'royal_tooltip_arrow',
            [
                'label' => __('Arrow', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'royal-addons-for-elementor'),
                'label_off' => __('Hide', 'royal-addons-for-elementor'),
                'return_value' => 'true',
                'default' => 'true',
                'frontend_available' => true,
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );


        $element->add_control(
            'royal_tooltip_arrow_notice',
            [
                'raw' => '<strong>' . esc_html__('Please note!', 'royal-addons-for-elementor') . '</strong> ' . esc_html__('By toggling Arrow to "HIDE" you get access to more background control.', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'render_type' => 'ui',
                'condition' => [
                    'royal_tooltip_enable!' => '',
                    'royal_tooltip_arrow' => 'true',
                ],
            ]
        );

        $element->add_control(
            'royal_tooltip_trigger',
            [
                'label' => __('Trigger', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'hover',
                'options' => [
                    'click' => __('Click', 'royal-addons-for-elementor'),
                    'hover' => __('Hover', 'royal-addons-for-elementor'),
                ],
                'frontend_available' => true,
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_tooltip_distance',
            [
                'label' => __('Distance', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '0',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.royal-tooltip-enable .royal-tooltip-content' => '--royal-tooltip-arrow-distance: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_tooltip_align',
            [
                'label' => __('Text Alignment', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'royal-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'royal-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'royal-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .royal-tooltip-content' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->end_controls_tab();

        $element->start_controls_tab('royal_tooltip_styles', [
            'label' => __('Styles', 'royal-addons-for-elementor'),
            'condition' => [
                'royal_tooltip_enable!' => '',
            ],
        ]);

        $element->add_responsive_control(
            'royal_tooltip_width',
            [
                'label' => __('Width', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '120',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-tooltip-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_tooltip_arrow_size',
            [
                'label' => __('Tooltip Arrow Size (px)', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '5',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-tooltip-content::after' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                    'royal_tooltip_arrow' => 'true',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'royal_tooltip_typography',
                'separator' => 'after',
                'fields_options' => [
                    'typography' => [
                        'default' => 'yes'
                    ],
                    'font_family' => [
                        'default' => 'Nunito',
                    ],
                    'font_weight' => [
                        'default' => '500', // 100, 200, 300, 400, 500, 600, 700, 800, 900, normal, bold
                    ],
                    'font_size' => [
                        'default' => [
                            'unit' => 'px', // px, em, rem, vh
                            'size' => '14', // any number
                        ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .royal-tooltip-content',
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'royal_tooltip_title_section_bg_color',
                'label'    => __('Background', 'royal-addons-for-elementor'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .royal-tooltip-content',
                'condition' => [
                    'royal_tooltip_enable!' => '',
                    'royal_tooltip_arrow!' => 'true',
                ],
            ]
        );

        $element->add_control(
            'royal_tooltip_background_color',
            [
                'label' => __('Background Color', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .royal-tooltip-content' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .royal-tooltip-content::after' => '--royal-tooltip-arrow-color: {{VALUE}}',
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                    'royal_tooltip_arrow' => 'true',
                ],
            ]
        );

        $element->add_control(
            'royal_tooltip_color',
            [
                'label' => __('Text Color', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .royal-tooltip-content' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'royal_tooltip_border',
                'label' => __('Border', 'royal-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .royal-tooltip-content',
                'condition' => [
                    'royal_tooltip_enable!' => '',
                    'royal_tooltip_arrow!' => 'true',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_tooltip_border_radius',
            [
                'label' => __('Border Radius', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .royal-tooltip-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_responsive_control(
            'royal_tooltip_padding',
            [
                'label' => __('Padding', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .royal-tooltip-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'royal_tooltip_box_shadow',
                'selector' => '{{WRAPPER}} .royal-tooltip-content',
                'separator' => '',
                'condition' => [
                    'royal_tooltip_enable!' => '',
                ],
            ]
        );

        $element->end_controls_tab();

        $element->end_controls_tabs();

        $element->end_controls_section();
    }

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
		$schema['royal_tooltip_enable'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(false);
		$schema['royal_tooltip_content'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('I am a tooltip')->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_position'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('top')->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_animation'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('')->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_duration'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Number_Prop_Type::make()->default(1000)->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_arrow'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\Boolean_Prop_Type::make()->default(true)->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_trigger'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('hover')->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_align'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('center')->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		
		$schema['royal_tooltip_distance'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 0, 'unit' => 'px'])->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_width'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 120, 'unit' => 'px'])->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_arrow_size'] = \Elementor\Modules\AtomicWidgets\PropTypes\Size_Prop_Type::make()->default(['size' => 5, 'unit' => 'px'])->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_background_color'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('#000000')->set_dependencies( self::get_dependency('royal_tooltip_enable') );
		$schema['royal_tooltip_color'] = \Elementor\Modules\AtomicWidgets\PropTypes\Primitives\String_Prop_Type::make()->default('#ffffff')->set_dependencies( self::get_dependency('royal_tooltip_enable') );

		return $schema;
	}

	public static function add_atomic_controls( $controls, $element ) {
		$items = [
			\Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control::bind_to( 'royal_tooltip_enable' )
                ->set_label( __( 'Enable Tooltip?', 'royal-addons-for-elementor' ) ),
			\Elementor\Modules\AtomicWidgets\Controls\Types\Textarea_Control::bind_to( 'royal_tooltip_content' )
                ->set_label( __( 'Content', 'royal-addons-for-elementor' ) ),
			\Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( 'royal_tooltip_position' )
                ->set_label( __( 'Position', 'royal-addons-for-elementor' ) )
                ->set_options([
                    ['value' => 'top', 'label' => 'Top'],
                    ['value' => 'bottom', 'label' => 'Bottom'],
                    ['value' => 'left', 'label' => 'Left'],
                    ['value' => 'right', 'label' => 'Right'],
                ]),
			\Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( 'royal_tooltip_animation' )
                ->set_label( __( 'Animation', 'royal-addons-for-elementor' ) )
                ->set_options([
                    ['value' => '', 'label' => 'None'],
                    ['value' => 'royal_fadeIn', 'label' => 'fadeIn'],
                    ['value' => 'royal_zoomIn', 'label' => 'zoomIn'],
                    ['value' => 'royal_rollIn', 'label' => 'rollIn'],
                    ['value' => 'royal_bounce', 'label' => 'bounce'],
                    ['value' => 'royal_slideInDown', 'label' => 'slideInDown'],
                    ['value' => 'royal_slideInLeft', 'label' => 'slideInLeft'],
                    ['value' => 'royal_slideInRight', 'label' => 'slideInRight'],
                    ['value' => 'royal_slideInUp', 'label' => 'slideInUp'],
                ]),
			\Elementor\Modules\AtomicWidgets\Controls\Types\Number_Control::bind_to( 'royal_tooltip_duration' )
                ->set_label( __( 'Animation Duration (ms)', 'royal-addons-for-elementor' ) ),
			\Elementor\Modules\AtomicWidgets\Controls\Types\Switch_Control::bind_to( 'royal_tooltip_arrow' )
                ->set_label( __( 'Arrow', 'royal-addons-for-elementor' ) ),
			\Elementor\Modules\AtomicWidgets\Controls\Types\Select_Control::bind_to( 'royal_tooltip_trigger' )
                ->set_label( __( 'Trigger', 'royal-addons-for-elementor' ) )
                ->set_options([
                    ['value' => 'click', 'label' => 'Click'],
                    ['value' => 'hover', 'label' => 'Hover'],
                ]),
            \Elementor\Modules\AtomicWidgets\Controls\Types\Size_Control::bind_to( 'royal_tooltip_distance' )
                ->set_label( __( 'Distance', 'royal-addons-for-elementor' ) ),
            \Elementor\Modules\AtomicWidgets\Controls\Types\Size_Control::bind_to( 'royal_tooltip_width' )
                ->set_label( __( 'Width', 'royal-addons-for-elementor' ) ),
            \Elementor\Modules\AtomicWidgets\Controls\Types\Size_Control::bind_to( 'royal_tooltip_arrow_size' )
                ->set_label( __( 'Arrow Size', 'royal-addons-for-elementor' ) ),
		];

		$controls[] = \Elementor\Modules\AtomicWidgets\Controls\Section::make()
			->set_id( 'royalcontrolsection_tooltip_atomic' )
			->set_label( __( 'Tooltip [Royal]', 'royal-addons-for-elementor' ) )
			->set_items( $items );

		return $controls;
	}

	/**
	 * Inject data-royal-tooltip for ALL Structural elements (Legacy Container, Atomic Div Block, Sections, Columns).
	 * We use a custom attribute to avoid mutating or breaking Elementor's native data-settings JSON.
	 * Atomic Widgets build their own DOM in JS and ignore wrapper attributes, they use x-data.
	 */
	public static function render_universal( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$el_name = $element->get_name();
		// Skip for Atomic Widgets since they use x-data and don't output _wrapper
		if ( strpos($el_name, 'atomic-') === 0 ) return;

		$settings = [];
		if ( method_exists($element, 'get_atomic_settings') ) {
			try {
				$settings = $element->get_atomic_settings();
			} catch ( \Throwable $e ) {}
		}

		if ( empty($settings) ) {
			$settings = method_exists($element, 'get_settings_for_display') ? $element->get_settings_for_display() : [];
			if ( empty($settings) ) {
			    $settings = method_exists($element, 'get_settings') ? $element->get_settings() : [];
			}
		}

		foreach ( $settings as $key => $val ) {
			if ( is_array($val) && isset($val['$$type']) && array_key_exists('value', $val) ) {
				$settings[$key] = $val['value'];
			}
		}

		$isEnabled = $settings['royal_tooltip_enable'] ?? false;
		if ( $isEnabled === 'enable' || $isEnabled === 'yes' || $isEnabled === true ) {
			$element->add_render_attribute( '_wrapper', 'class', 'royal-tooltip-enable' );
			
			if ( !empty($settings['royal_tooltip_position']) ) {
				$element->add_render_attribute( '_wrapper', 'class', 'royal-tooltip-' . esc_attr($settings['royal_tooltip_position']) );
			}
			
			// Inject settings payload universally using our own attribute
			$payload = [
				'royal_tooltip_enable'    => true,
				'royal_tooltip_content'   => $settings['royal_tooltip_content'] ?? 'I am a tooltip',
				'royal_tooltip_position'  => $settings['royal_tooltip_position'] ?? 'top',
				'royal_tooltip_animation' => $settings['royal_tooltip_animation'] ?? '',
				'royal_tooltip_duration'  => $settings['royal_tooltip_duration'] ?? 1000,
				'royal_tooltip_arrow'     => $settings['royal_tooltip_arrow'] ?? true,
				'royal_tooltip_trigger'   => $settings['royal_tooltip_trigger'] ?? 'hover',
			];
			$element->add_render_attribute( '_wrapper', 'data-royal-tooltip', wp_json_encode($payload) );

            // Inline CSS for distance
            if ( isset($settings['royal_tooltip_distance']) && is_array($settings['royal_tooltip_distance']) && isset($settings['royal_tooltip_distance']['size']) ) {
                $css = '--royal-tooltip-arrow-distance: ' . $settings['royal_tooltip_distance']['size'] . ($settings['royal_tooltip_distance']['unit'] ?? 'px') . ';';
                $element->add_render_attribute( '_wrapper', 'style', $css );
            }
		}
	}
}

RoyalTooltip::init();
