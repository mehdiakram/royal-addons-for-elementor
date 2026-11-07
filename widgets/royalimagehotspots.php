<?php
namespace RoyalAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalImageHotspots extends Widget_Base {
		
	public function get_name() {
		return 'royalimagehotspots';
	}

	public function get_title() {
		return esc_html__( 'Image Hotspots', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-image-hotspot rtbranding'; }

	public function get_categories() {
		return [ 'royaltech'];
	}

	public function get_keywords() {
		return [ 'image', 'hotspot', 'hot', 'spot', 'hotspots', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
	
	public function get_style_depends() {
		$styles = [ 'royalimagehotspots' ];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalimagehotspots'];
		return $scripts;
	}	


	public function add_control_tooltip_trigger() {
		$this->add_control(
			'tooltip_trigger',
			[
				'label' => esc_html__( 'Show Tooltips', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => [
					'none' 	=> esc_html__( 'None', 'royal-addons-for-elementor' ),
					'click' => esc_html__( 'on Click', 'royal-addons-for-elementor' ),
					'hover' => esc_html__( 'on Hover', 'royal-addons-for-elementor' ),
				],
				'prefix_class' => 'royalhotspot-trigger-',
				'separator' => 'after',
			]
		);
	}

	public function add_control_tooltip_position() {
		$this->add_control(
			'tooltip_position',
			[
				'label' => esc_html__( 'Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top' 		=> esc_html__( 'Top', 'royal-addons-for-elementor' ),
					'bottom' 	=> esc_html__( 'Bottom', 'royal-addons-for-elementor' ),
					'left' 		=> esc_html__( 'Left', 'royal-addons-for-elementor' ),
					'right' 	=> esc_html__( 'Right', 'royal-addons-for-elementor' ),
				],
				'prefix_class' => 'royalhotspot-tooltip-position-',
			]
		);
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); // End Controls Section

		// Section: Hotspots ---------
		$this->start_controls_section(
			'section_hotspots',
			[
				'label' => esc_html__( 'Hotspots', 'royal-addons-for-elementor' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_hotspot_item' );

		$repeater->start_controls_tab(
			'tab_hotspot_item_content',
			[
				'label' => esc_html__( 'Content', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'hotspot_icon',
			[
				'label' => esc_html__( 'Select Icon', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'hotspot_text',
			[
				'label' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_custom_color',
			[
				'label' => esc_html__( 'Custom Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_custom_text_color',
			[
				'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royalhotspot-content' => 'color: {{VALUE}}',
				],
				'condition' => [
					'hotspot_custom_color' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'hotspot_custom_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#605BE5',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royalhotspot-content' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}}.royalhotspot-anim-glow:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}}.royalhotspot-anim-glow2:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'hotspot_custom_color' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'hotspot_tooltip',
			[
				'label' => esc_html__( 'Tooltip', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_tooltip_text',
			[
				'label' => __('', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Tooltip Content',
				'condition' => [
					'hotspot_tooltip' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'hotspot_link',
			[
				'label' => esc_html__( 'Link', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://www.your-link.com', 'royal-addons-for-elementor' ),
				'separator' => 'before',
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_hotspot_item_position',
			[
				'label' => esc_html__( 'Position', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'hotspot_hr_position',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Horizontal Position (%)', 'royal-addons-for-elementor' ),
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.royalhotspot-item' => 'left: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'hotspot_vr_position',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Vertical Position (%)', 'royal-addons-for-elementor' ),
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.royalhotspot-item' => 'top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'hotspot_items',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'hotspot_text' => '',
						'hotspot_hr_position' => [
							'unit' => '%',
							'size' => 30,
						],
						'hotspot_vr_position' => [
							'unit' => '%',
							'size' => 40,
						],
					],
					[
						'hotspot_text' => '',
						'hotspot_hr_position' => [
							'unit' => '%',
							'size' => 60,
						],
						'hotspot_vr_position' => [
							'unit' => '%',
							'size' => 20,
						],
					],
					
				],
				'title_field' => '{{{ hotspot_text }}}',
			]
		);

		$this->add_control(
			'hotspot_animation',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Animation', 'royal-addons-for-elementor' ),
				'default' => 'glow',
				'options' => [
					'none' => esc_html__( 'None', 'royal-addons-for-elementor' ),
					'glow' => esc_html__( 'Glow', 'royal-addons-for-elementor' ),
					'glow2' => esc_html__( 'Glow 2X', 'royal-addons-for-elementor' ),
					'pulse' => esc_html__( 'Pulse', 'royal-addons-for-elementor' ),
					'shake' => esc_html__( 'Shake', 'royal-addons-for-elementor' ),
					'swing' => esc_html__( 'Swing', 'royal-addons-for-elementor' ),
					'tada' => esc_html__( 'Tada', 'royal-addons-for-elementor' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'hotspot_origin',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Origin', 'royal-addons-for-elementor' ),
				'description' => esc_html__('Defines where the point is located relative to hotspot item', 'royal-addons-for-elementor'),
				'default' => 'top-left',
				'options' => [
					'top-left' => esc_html__( 'Top Left', 'royal-addons-for-elementor' ),
					'top-right' => esc_html__( 'Top Right', 'royal-addons-for-elementor' ),
					'top-center' => esc_html__( 'Top Center', 'royal-addons-for-elementor' ),
					'center' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
					'center-left' => esc_html__( 'Center Left', 'royal-addons-for-elementor' ),
					'center-right' => esc_html__( 'Center Right', 'royal-addons-for-elementor' ),
					'bottom-left' => esc_html__( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'royal-addons-for-elementor' ),
					'bottom-center' => esc_html__( 'Bottom Center', 'royal-addons-for-elementor' )
				],
				'selectors_dictionary' => [
					'top-left' => '',
					'top-right' => 'transform: translate(-100%, 0);',
					'top-center' => 'transform: translate(-50%, 0);',
					'center' => 'transform: translate(-50%, -50%);',
					'center-left' => 'transform: translate(0, -50%);',
					'center-right' => 'transform: translate(-100%, -50%);',
					'bottom-left' => 'transform: translate(0, -100%);',
					'bottom-right' => 'transform: translate(-100%, -100%);',
					'bottom-center' => 'transform: translate(-50%, -100%);'
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-item' => '{{VALUE}}',
				],
				'separator' => 'before'
				// 'render_type' => 'template',
			]
		);

		$this->end_controls_section(); // End Controls Section

		// Section: Tooltips ---------
		$this->start_controls_section(
			'section_tooltips',
			[
				'label' => esc_html__( 'Tooltips', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control_tooltip_trigger();

		$this->add_control_tooltip_position();

		$this->add_responsive_control(
            'tooltip_align',
            [
                'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip' => 'text-align: {{VALUE}}',
				],
            ]
        );

		$this->add_responsive_control(
			'tooltip_width',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 115,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tooltip_triangle',
			[
				'label' => esc_html__( 'Triangle', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,				
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tooltip_triangle_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Size', 'royal-addons-for-elementor' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip:before' => 'border-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royalhotspot-tooltip-position-top .royalhotspot-tooltip' => 'margin-top: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.royalhotspot-tooltip-position-bottom .royalhotspot-tooltip' => 'margin-bottom: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.royalhotspot-tooltip-position-left .royalhotspot-tooltip' => 'margin-left: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.royalhotspot-tooltip-position-right .royalhotspot-tooltip' => 'margin-right: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.royalhotspot-tooltip-position-top .royalhotspot-tooltip:before' => 'bottom: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.royalhotspot-tooltip-position-bottom .royalhotspot-tooltip:before' => 'top: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.royalhotspot-tooltip-position-right .royalhotspot-tooltip:before' => 'left: calc(-{{SIZE}}{{UNIT}} + 1px);',
					'{{WRAPPER}}.royalhotspot-tooltip-position-left .royalhotspot-tooltip:before' => 'right: calc(-{{SIZE}}{{UNIT}} + 1px);',
				],
				'condition' => [
					'tooltip_triangle' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_distance',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__( 'Distance', 'royal-addons-for-elementor' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}}.royalhotspot-tooltip-position-top .royalhotspot-tooltip' => 'top: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royalhotspot-tooltip-position-bottom .royalhotspot-tooltip' => 'bottom: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royalhotspot-tooltip-position-left .royalhotspot-tooltip' => 'left: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royalhotspot-tooltip-position-right .royalhotspot-tooltip' => 'right: -{{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tooltip_animation',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Animation', 'royal-addons-for-elementor' ),
				'default' => 'fade',
				'options' => [
					'shift-toward' => esc_html__( 'Shift Toward', 'royal-addons-for-elementor' ),
					'fade' => esc_html__( 'Fade', 'royal-addons-for-elementor' ),
					'scale' => esc_html__( 'Scale', 'royal-addons-for-elementor' ),
				],
				'prefix_class' => 'royaltooltip-effect-',
				'render_type' => 'template',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tooltip_anim_duration',
			[
				'label' => esc_html__( 'Animation Duration', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.2,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip' => '-webkit-transition-duration: {{VALUE}}s; transition-duration: {{VALUE}}s;',
				],		
			]
		);

		$this->end_controls_section(); // End Controls Section

		// Section: Hotspots ---------
		$this->start_controls_section(
			'section_style_hotspots',
			[
				'label' => esc_html__( 'Hotspots', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hotspot_color',
			[
				'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'hotspot_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#605BE5',
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalhotspot-anim-glow:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalhotspot-anim-glow2:before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'hotspot_border_color',
			[
				'label' => esc_html__( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'hotspot_box_shadow',
				'selector' => '{{WRAPPER}} .royalhotspot-content',
			]
		);

		$this->add_control(
			'hotspot_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hotspot_typography',
				'selector' => '{{WRAPPER}} .royalhotspot-text',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_section',
			[
				'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label' => esc_html__( 'Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'right',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'royalhotspot-icon-position-',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalhotspot-content svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_size',
			[
				'label' => esc_html__( 'Box Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_distance',
			[
				'label' => esc_html__( 'Distance', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}}.royalhotspot-icon-position-left .royalhotspot-text ~ i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royalhotspot-icon-position-right .royalhotspot-text ~ i' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royalhotspot-icon-position-left .royalhotspot-text ~ svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.royalhotspot-icon-position-right .royalhotspot-text ~ svg' => 'margin-left: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'hotspot_border_type',
			[
				'label' => esc_html__( 'Border Type', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'royal-addons-for-elementor' ),
					'solid' => esc_html__( 'Solid', 'royal-addons-for-elementor' ),
					'double' => esc_html__( 'Double', 'royal-addons-for-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'royal-addons-for-elementor' ),
					'dashed' => esc_html__( 'Dashed', 'royal-addons-for-elementor' ),
					'groove' => esc_html__( 'Groove', 'royal-addons-for-elementor' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'hotspot_border_width',
			[
				'label' => esc_html__( 'Border Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'hotspot_border_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'hotspot_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royalhotspot-anim-glow:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royalhotspot-anim-glow2:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); // End Controls Section

		// Section: Tooltips ---------
		$this->start_controls_section(
			'section_style_tooltips',
			[
				'label' => esc_html__( 'Tooltips', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tooltip_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip' => 'background-color: {{VALUE}}',
					'{{WRAPPER}}.royalhotspot-tooltip-position-top .royalhotspot-tooltip:before' => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}}.royalhotspot-tooltip-position-bottom .royalhotspot-tooltip:before' => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}}.royalhotspot-tooltip-position-left .royalhotspot-tooltip:before' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}}.royalhotspot-tooltip-position-right .royalhotspot-tooltip:before' => 'border-right-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tooltip_box_shadow',
				'selector' => '{{WRAPPER}} .royalhotspot-tooltip',
			]
		);

		$this->add_control(
			'tooltip_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tooltip_typography',
				'label' => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalhotspot-tooltip',
			]
		);

		$this->add_responsive_control(
			'tooltip_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tooltip_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .royalhotspot-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); // End Controls Section

	}

	protected function render() {
		// Get Settings
		$settings = $this->get_settings();

		$item_count = 0;
		$image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['image']['id'], 'image_size', $settings );

		if ( ! $image_src ) {
			$image_src = $settings['image']['url'];
		}

		$hotsposts_options = [	
			'tooltipTrigger' => $settings['tooltip_trigger'],
		];

		$this->add_render_attribute( 'hotspots_attribute', 'class', 'royalimage-hotspots' );
		$this->add_render_attribute( 'hotspots_attribute', 'data-options', wp_json_encode( $hotsposts_options ) );

		?>

		<div <?php echo $this->get_render_attribute_string( 'hotspots_attribute'); ?>>
			
			<?php if ( $image_src ) : ?>
				<div class="royalhotspot-image">
					<img src="<?php echo esc_url( $image_src ); ?>" >
				</div>
			<?php endif; ?>

			<div class="royalhotspot-item-container">
				

				<?php foreach ( $settings['hotspot_items'] as $key => $item ) : ?>
					
					<?php

					$hotspot_tag = 'div';

					$this->add_render_attribute( 'hotspot_item_attribute'. $item_count, 'class', 'royalhotspot-item elementor-repeater-item-'. esc_attr($item['_id'] ));

					if ( 'none' !== $settings['hotspot_animation'] ) {
						$this->add_render_attribute( 'hotspot_item_attribute'. $item_count, 'class', 'royalhotspot-anim-'. $settings['hotspot_animation'] );
					}

					$this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'class', 'royalhotspot-content' );

					if ( '' !== $item['hotspot_link']['url'] ) {

						$hotspot_tag = 'a';

						$this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'href', esc_url( $item['hotspot_link']['url'] ) );

						if ( $item['hotspot_link']['is_external'] ) {
							$this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'target', '_blank' );
						}

						if ( $item['hotspot_link']['nofollow'] ) {
							$this->add_render_attribute( 'hotspot_content_attribute'. $item_count, 'nofollow', '' );
						}

					}

					?>

					<div <?php echo $this->get_render_attribute_string( 'hotspot_item_attribute'. $item_count ); ?>>

						<<?php echo esc_attr( $hotspot_tag ); ?> <?php echo $this->get_render_attribute_string( 'hotspot_content_attribute'. $item_count ); ?>>
							
							<?php if ( '' !== $item['hotspot_text'] ) : ?>
								<span class="royalhotspot-text"><?php echo esc_html( $item['hotspot_text'] ); ?></span>
							<?php endif; ?>
							<?php if ( '' !== $item['hotspot_icon']['value'] && 'svg' !== $item['hotspot_icon']['library'] ) : ?>
								<?php \Elementor\Icons_Manager::render_icon( $item['hotspot_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							<?php elseif ( '' !== $item['hotspot_icon']['value'] && 'svg' == $item['hotspot_icon']['library'] ) : ?>
								<img src="<?php echo esc_url( $item['hotspot_icon']['value']['url'] ) ?>">
							<?php endif; ?>

						</<?php echo esc_attr( $hotspot_tag ); ?>>
						
						<?php if ( 'yes' === $item['hotspot_tooltip'] && '' !== $item['hotspot_tooltip_text'] ) : ?>
							<div class="royalhotspot-tooltip"><?php echo wp_kses_post($item['hotspot_tooltip_text']); ?></div>						
						<?php endif; ?>	

					</div>

					<?php

					$item_count++;

				endforeach;

				?>

			</div>
			
		</div>

		<?php

	}
}