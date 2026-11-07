<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalItemLists extends Widget_Base {

    public function get_name() {
        return 'royalitemlists';
    }


    public function get_title() {
        return esc_html__('Item Lists', 'royal-addons-for-elementor');
    }


    public function get_icon() { return 'eicon-bullet-list rtbranding'; }

	public function get_keywords() {
		return [ 'item', 'list', 'item list', 'icon', 'bullet', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
	
    public function get_categories() {
        return ['royaltech'];
    }


	public function get_style_depends()	{
		return [ 'royalitemlists' ];
	}


	public function get_script_depends(){
		return [ ];
	}


	protected function register_controls() {
		$this->rt_content_layout_options();
		$this->rt_style_options();
	}


    private function rt_content_layout_options() {

        $this->start_controls_section(
            'section_general', array(
                'label'         => __('General', 'royal-addons-for-elementor'),
            )
        );

        $this->add_control(
            'item_lists_style', [
                'label'         => __('List Style', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'materialbullet'            => __('Material Bullets', 'royal-addons-for-elementor'),
                    'shapebullet'               => __('Shape Bullets', 'royal-addons-for-elementor'),
                    'timelinebullet'            => __('Timeline Bullets', 'royal-addons-for-elementor'),
                    'alternatetimelinebullet' 	=> __('Alternate Timeline Bullets', 'royal-addons-for-elementor'),
                    'gradientorderedbullet'     => __('Gradient Ordered Bullets', 'royal-addons-for-elementor'),
                ],
                'default'       				=> 'materialbullet',
            ]
        );

        $this->end_controls_section();
		
		
        $this->start_controls_section(
            'section_material_list_items', array(
                'label'         => __('Items', 'royal-addons-for-elementor'),
                'condition'     => [
                    'item_lists_style'  => 'materialbullet',
                ],
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'material_list_items_title',
            [
                'label'         => __('Title', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Title', 'royal-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'material_list_items_content',
            [
                'label'         => __('Content', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __('Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eiusmod tempor incididunt ut abore et dolore magna', 'royal-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'material_list_items_display_icon',
            [
                'label'         => __('Icon', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'none'  => [
                        'title' => __('None', 'royal-addons-for-elementor'),
                        'icon'  => 'fa fa-ban',
                    ],
                    'icon'  => [
                        'title' => __('Icon', 'royal-addons-for-elementor'),
                        'icon'  => 'fa fa-info-circle',
                    ],
                    'image'  => [
                        'title' => __('Image', 'royal-addons-for-elementor'),
                        'icon'  => 'fas fa-image',
                    ],
                ],
                'default'       => 'icon',
            ]
        );

        $repeater->add_control(
			'material_list_items_image',
			[
				'type'          => Controls_Manager::MEDIA,
				'default'       => [
					'url' 		=> \Elementor\Utils::get_placeholder_image_src(),
				],
                'condition'     => [
                    'material_list_items_display_icon'   => 'image',
                ],
			]
		);

        $repeater->add_control(
            'material_list_items_icon',
            [
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fas fa-leaf',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'material_list_items_display_icon'   => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'material_icon_color', [
                'label'         => __('Icon Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ffffff',
                'condition'     => [
                    'material_list_items_display_icon'   => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'material_icon_bg_color', [
                'label'         => __('Icon Background Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ff8181',
                'condition'     => [
                    'material_list_items_display_icon'   => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'material_title_color', [
                'label'         => __('Title Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ffffff',
            ]
        );

        $repeater->add_control(
            'material_content_color', [
                'label'         => __('Content Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ffffff',
            ]
        );

        $repeater->add_control(
            'material_content_bg_color', [
                'label'         => __('Content Background Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ec6161',
            ]
        );

        $this->add_control(
			'material_item_lists',
			[
				'label'         => __( 'List Items', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'render_type'   => 'template',
                'default'       => [
                    [
                        'material_list_items_title'     => 'List One', 
                        'material_content_bg_color'     => '#ec6161'
                    ],
                    [
                        'material_list_items_title'     => 'List Two',
                        'material_content_bg_color'     => '#2DCEC6',
                        'material_icon_bg_color'        => '#32DDD4',
                        'material_list_items_icon'      => [
                            'value'     => 'fas fa-laugh',
                            'library'   => 'fa-solid',
                        ],
                    ],
                    [
                        'material_list_items_title'     => 'List Three',
                        'material_content_bg_color'     => '#C56EE3',
                        'material_icon_bg_color'        => '#DB87F7',
                        'material_list_items_icon'      => [
                            'value'     => 'fas fa-paw',
                            'library'   => 'fa-solid',
                        ],
                    ],
                    [
                        'material_list_items_title'     => 'List Four',
                        'material_content_bg_color'     => '#868BFF',
                        'material_icon_bg_color'        => '#A8ADFF',
                        'material_list_items_icon'      => [
                            'value'     => 'fas fa-magnet',
                            'library'   => 'fa-solid',
                        ],
                    ],
                ],
                'title_field'   => '{{{ material_list_items_title }}}'
			]
        );

        $this->end_controls_section();		
		
		
        // Shape Bullet Style Items
        $this->start_controls_section(
            'section_shape_list_items', array(
                'label'         => __('Items', 'royal-addons-for-elementor'),
                'condition'     => [
                    'item_lists_style'      => 'shapebullet',
                ],
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'shape_list_items_title',
            [
                'label'         => __('Title', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Title', 'royal-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'shape_list_items_content',
            [
                'label'         => __('Content', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __('Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eiusmod tempor incididunt ut abore et dolore magna', 'royal-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'shape_list_items_display_icon',
            [
                'label'         => __('Icon', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'none'  => [
                        'title' => __('None', 'royal-addons-for-elementor'),
                        'icon'  => 'fa fa-ban',
                    ],
                    'icon'  => [
                        'title' => __('Icon', 'royal-addons-for-elementor'),
                        'icon'  => 'fa fa-info-circle',
                    ],
                ],
                'default'       => 'icon',
            ]
        );

        $repeater->add_control(
            'shape_list_items_icon',
            [
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fas fa-leaf',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'shape_list_items_display_icon'   => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'shape_list_item_icon_style', [
                'label'         => __('Icon Box Style', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'diamond-icon-style'        => __('Diamond', 'royal-addons-for-elementor'),
                    'circle-icon-style'         => __('Circle', 'royal-addons-for-elementor'),
                    'square-icon-style'         => __('Square', 'royal-addons-for-elementor'),
                ],
                'default'       => 'diamond-icon-style',
            ]
        );

        $this->add_control(
			'shape_item_lists',
			[
				'label'         => __( 'List Items', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'render_type'   => 'template',
                'default'       => [
                    [
                        'shape_list_items_title'      => 'List One',
                    ],
                    [
                        'shape_list_items_title'      => 'List Two',
                        'shape_list_item_icon_style'  => 'circle-icon-style',
                        'shape_list_items_icon'       => [
                            'value'     => 'fas fa-laugh',
                            'library'   => 'fa-solid',
                        ],
                    ],
                    [
                        'shape_list_items_title'      => 'List Three',
                        'shape_list_item_icon_style'  => 'square-icon-style',
                        'shape_list_items_icon'       => [
                            'value'     => 'fas fa-paw',
                            'library'   => 'fa-solid',
                        ],
                    ],
                ],
                'title_field'   => '{{{ shape_list_items_title }}}'
			]
        );

        $this->end_controls_section();

        // Timeline Bullet & Alternate Timeline Bullet Style Items
        $this->start_controls_section(
            'section_timeline_list_items', array(
                'label'         => __('Items', 'royal-addons-for-elementor'),
                'condition'     => [
                    'item_lists_style'      => [ 'timelinebulletstyle', 'alternatetimelinebullet' ],
                ],
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'timeline_list_items_title',
            [
                'label'         => __('Title', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Title', 'royal-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'timeline_list_items_content',
            [
                'label'         => __('Content', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __('Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eiusmod tempor incididunt ut abore et dolore magna', 'royal-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'timeline_list_items_display_icon',
            [
                'label'         => __('Icon', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'none'  => [
                        'title' => __('None', 'royal-addons-for-elementor'),
                        'icon'  => 'fa fa-ban',
                    ],
                    'icon'  => [
                        'title' => __('Icon', 'royal-addons-for-elementor'),
                        'icon'  => 'fa fa-info-circle',
                    ],
                    'image'  => [
                        'title' => __('Image', 'royal-addons-for-elementor'),
                        'icon'  => 'fas fa-image',
                    ],
                ],
                'default'       => 'icon',
            ]
        );

        $repeater->add_control(
			'timeline_list_items_image',
			[
				'type'          => Controls_Manager::MEDIA,
				'default'       => [
					'url' 		=> \Elementor\Utils::get_placeholder_image_src(),
				],
                'condition'     => [
                    'timeline_list_items_display_icon'   => 'image',
                ],
			]
		);

        $repeater->add_control(
            'timeline_list_items_icon',
            [
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fas fa-leaf',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'timeline_list_items_display_icon'   => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'timeline_icon_color', [
                'label'         => __('Icon Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ffffff',
                'condition'     => [
                    'timeline_list_items_display_icon'   => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'timeline_icon_bg_color', [
                'label'         => __('Icon Background Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ff8181',
                'condition'     => [
                    'timeline_list_items_display_icon'   => 'icon',
                ],
            ]
        );

        $this->add_control(
			'timeline_item_lists',
			[
				'label'         => __( 'List Items', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'render_type'   => 'template',
                'default'       => [
                    [
                        'timeline_list_items_title'      => 'List One',
                    ],
                    [
                        'timeline_list_items_title'      => 'List Two',
                        'timeline_icon_bg_color'         => '#32DDD4',
                        'timeline_list_items_icon'       => [
                            'value'     => 'fas fa-laugh',
                            'library'   => 'fa-solid',
                        ],
                    ],
                    [
                        'timeline_list_items_title'      => 'List Three',
                        'timeline_icon_bg_color'         => '#DB87F7',
                        'timeline_list_items_icon'       => [
                            'value'     => 'fas fa-paw',
                            'library'   => 'fa-solid',
                        ],
                    ],
                    [
                        'timeline_list_items_title'      => 'List Four',
                        'timeline_icon_bg_color'         => '#A8ADFF',
                        'timeline_list_items_icon'       => [
                            'value'     => 'fas fa-magnet',
                            'library'   => 'fa-solid',
                        ],
                    ],
                ],
                'title_field'   => '{{{ timeline_list_items_title }}}'
			]
        );

        $this->end_controls_section();

        // Gradient Ordered Bullet Style Items
        $this->start_controls_section(
            'section_gradient_ordered_list_items', array(
                'label'         => __('Items', 'royal-addons-for-elementor'),
                'condition'     => [
                    'item_lists_style'  => 'gradientorderedbullet',
                ],
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'gradient_ordered_list_items_title',
            [
                'label'         => __('Title', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Title', 'royal-addons-for-elementor'),
            ]
        );

        $repeater->add_control(
            'gradient_ordered_list_items_content',
            [
                'label'         => __('Content', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => __('Lorem ipsum dolor sit amet, consectetur adipisi cing elit, sed do eiusmod tempor incididunt ut abore et dolore magna', 'royal-addons-for-elementor'),
            ]
        );

        $this->add_control(
			'gradient_ordered_item_lists',
			[
				'label'         => __( 'List Items', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'render_type'   => 'template',
                'default'       => [
                    [
                        'gradient_ordered_list_items_title'     => 'List One', 
                    ],
                    [
                        'gradient_ordered_list_items_title'     => 'List Two',
                    ],
                    [
                        'gradient_ordered_list_items_title'     => 'List Three',
                    ],
                    [
                        'gradient_ordered_list_items_title'     => 'List Four',
                    ],
                ],
                'title_field'   => '{{{ gradient_ordered_list_items_title }}}'
			]
        );

        $this->end_controls_section();
        // End Item Lists Items Section

        // Start Box Style Control       
        $this->start_controls_section(
            'list_items_box_style', [
                'label'         => __('Box', 'royal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'list_items_box_column_direction', [
                'label'         => __('Direction', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'ltr' => __('LTR', 'royal-addons-for-elementor'),
                    'rtl' => __('RTL', 'royal-addons-for-elementor'),
                ],
                'condition'     => [
                    'item_lists_style!' => ['alternatetimelinebullet', 'gradientorderedbullet'],
                ],
                'default'       => 'ltr',
            ]
        );

        $this->add_control(
            'list_items_number_box_background_color', [
                'label'         => __('Background Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#F0F0F0',
                'selectors'     => [
                    '{{WRAPPER}} .royalil-gradient-ordered-bullet-style .royalil-content-box'    => 'background: {{VALUE}};',
                ],
                'condition'     => [
                    'item_lists_style' => 'gradientorderedbullet',
                ],
            ]
        );

        $this->add_control(
            'list_items_box_margin', [
                'label'         => __('Box Margin', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-gradient-ordered-bullet-style .royalil-content-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'item_lists_style' => 'gradientorderedbullet',
                ],
            ]
        );

        $this->add_control(
            'list_items_box_padding', [
                'label'         => __('Content Padding', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-content-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_box_spacing', [
                'label'         => __('Space Between Box', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => [ 'size'  => 20 ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-container-row,
                     {{WRAPPER}} .royalil-shape-bullet-style .royalil-content-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalil-timeline-bullet-style .royalil-container-holder,
                     {{WRAPPER}} .royalil-alternate-timeline-bullet-style .royalil-container-holder' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'item_lists_style!' => 'gradientorderedbullet',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_box_border_radius', [
                'label'         => __('Border Radius', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'condition'     => [
                    'item_lists_style' => 'materialbullet',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-container-row' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Box Style Control

        // Start Timeline Style Control
        $this->start_controls_section(
            'list_items_timeline_style', [
                'label'         => __('Timeline', 'royal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'item_lists_style' => [ 'timelinebullet', 'alternatetimelinebullet' ],
                ],
            ]
        );

        $this->add_control(
            'list_items_timeline_color', [
                'label'         => __('Timeline Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#d6d6d6',
                'selectors'     => [
                    '{{WRAPPER}} .royalil-timeline-vertical,
                     {{WRAPPER}} .royalil-timeline-horizontal'    => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_timeline_width', [
                'label'         => __('Timeline Width', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 10,
                    ],
                ],
                'default'       => [ 'size'  => 2 ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-timeline-vertical'   => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalil-timeline-horizontal' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalil-timeline-right'      => 'margin-right: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .royalil-timeline-left'       => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_timeline_horizontal_width', [
                'label'         => __('Timeline Horizontal Width', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => [ 'size'  => 50 ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-timeline-horizontal' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_timeline_horizontal_spacing', [
                'label'         => __('Timeline Horizontal Spacing', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => [ 'size'  => 40 ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-timeline-horizontal' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Timeline Style Control       

        // Start Number Style Control
        $this->start_controls_section(
            'list_items_number_style', [
                'label'         => __('Number', 'royal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'item_lists_style' => 'gradientorderedbullet',
                ],
            ]
        );

        $this->add_control(
            'list_items_number_color', [
                'label'         => __('Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#000000',
                'selectors'     => [
                    '{{WRAPPER}} .royalil-gradient-ordered-bullet-style li.royalil-content-container::before' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
		  \Elementor\Group_Control_Typography::get_type(),
			[
                'name'          => 'typography_list_item_number',
                'selector'      => '{{WRAPPER}} .royalil-gradient-ordered-bullet-style li.royalil-content-container::before',
            ]
        );

        $this->add_responsive_control(
            'list_items_number_box_size', [
                'label'         => __('Background Size', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'default'       => [ 'size'  => 60 ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-gradient-ordered-bullet-style li.royalil-content-container::before'    => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_items_number_box_alignment', [
                'label'         => __('Vertical Alignment', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'top'          => __('Top', 'royal-addons-for-elementor'),
                    'middle'       => __('Middle', 'royal-addons-for-elementor'),
                    'bottom'       => __('Botttom', 'royal-addons-for-elementor'),
                ],
                'default'       => 'top',
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'          => 'list_items_number_background_color',
				'types'         => array( 'classic', 'gradient' ),
				'selector'      => '{{WRAPPER}} .royalil-gradient-ordered-bullet-style li.royalil-content-container::before',
			]
		);

        $this->add_control(
            'list_items_number_radius', [
                'label'         => __('Radius', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-gradient-ordered-bullet-style li.royalil-content-container::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Number Style Control

        // Start Icon Style Control 
        $this->start_controls_section(
            'list_items_icon_style', [
                'label'         => __('Icon', 'royal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'item_lists_style!' => 'gradientorderedbullet',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_icon_size', [
                'label'         => __('Icon Size', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => [ 'size'  => 25 ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_items_icon_color', [
                'label'         => __('Icon Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#00DAE6',
                'condition'     => [
                    'item_lists_style' => 'shapebullet',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-icon'    => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_icon_box_material_width', [
                'label'         => __('Icon Box Width', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'default'       => [ 'size'  => 100 ],
                'condition'     => [
                    'item_lists_style'  => 'materialbullet',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-icon'    => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_icon_box_width', [
                'label'         => __('Icon Box Size', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'default'       => [ 'size'  => 80 ],
                'condition'     => [
                    'item_lists_style!' => 'materialbullet',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_items_icon_bg_color', [
                'label'         => __('Icon Background Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ffffff',
                'condition'     => [
                    'item_lists_style' => 'shapebullet',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-icon-box svg path'    => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_icon_border_width', [
                'label'         => __('Icon Border Width', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 10,
                    ],
                ],
                'default'       => [ 'size'  => 2 ],
                'condition'     => [
                    'item_lists_style' => 'shapebullet',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-icon-box svg path' => 'stroke-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_items_icon_border_color', [
                'label'         => __('Icon Border Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#00DAE6',
                'condition'     => [
                    'item_lists_style' => 'shapebullet',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-icon-box svg path'    => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_icon_line_width', [
                'label'         => __('Line Width', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 10,
                    ],
                ],
                'default'       => [ 'size'  => 2 ],
                'condition'     => [
                    'item_lists_style' => 'shape-bullet-style',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-shape-bullet-style .royalil-line' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'list_items_icon_line_color', [
                'label'         => __('Line Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#000000',
                'condition'     => [
                    'item_lists_style' => 'shape-bullet-style',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-shape-bullet-style .royalil-line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_icon_box_radius', [
                'label'         => __('Icon Box Radius', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'default'       => [ 'size'  => 100 ],
                'condition'     => [
                    'item_lists_style' => [ 'timeline-bullet-style', 'alternate-timeline-bullet-style' ],  
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-timeline-bullet-style .royalil-icon-box,
                     {{WRAPPER}} .royalil-alternate-timeline-bullet-style .royalil-icon-box' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Icon Style Control

        // Start Image Style Control 
        $this->start_controls_section(
            'list_items_image_style', [
                'label'         => __('Image', 'royal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'item_lists_style' => ['material-bullet-style', 'timeline-bullet-style', 'alternate-timeline-bullet-style']
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_image_box_material_width', [
                'label'         => __('Image Width', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-image'    => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_items_image_box_material_radius', [
                'label'         => __('Radius', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 200,
                    ],
                ],
                'default'       => [ 'size'  => 100 ],
                'condition'     => [
                    'item_lists_style'  => ['timeline-bullet-style', 'alternate-timeline-bullet-style'],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-image'    => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Image Style Control

        // Start Title Style Control       
        $this->start_controls_section(
            'list_items_title_style', [
                'label'         => __('Title', 'royal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'list_items_title_color', [
                'label'         => __('Title Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#000000',
                'condition'     => [
                    'item_lists_style!' => 'material-bullet-style',
                ],
                'selectors'     => [
                    '{{WRAPPER}} h2.royalil-title' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
		  \Elementor\Group_Control_Typography::get_type(),
			[
                'name'          => 'typography_list_item_title',
                'selector'      => '{{WRAPPER}} .royalil-title',
            ]
        );

        $this->add_responsive_control(
            'list_item_title_spacing', [
                'label'         => __('Title Spacing', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'    => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => [ 'size'  => 0 ],
                'selectors'     => [
                    '{{WRAPPER}} .royalil-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Title Style Control

        // Start Content Style Control       
        $this->start_controls_section(
            'list_items_content_style', [
                'label'         => __('Content', 'royal-addons-for-elementor'),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'list_items_content_color', [
                'label'         => __('Content Color', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#999999',
                'condition'     => [
                    'item_lists_style!'     => 'material-bullet-style',
                ],
                'selectors'     => [
                    '{{WRAPPER}} p.royalil-content'   => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
		  \Elementor\Group_Control_Typography::get_type(),
			[
                'name'          => 'typography_list_item_content',
                'selector'      => '{{WRAPPER}} .royalil-content',
            ]
        );

        $this->end_controls_section();
        // End Content Style Control		
		
		
	
	}
	
	
	private function rt_style_options() {
		
		
	}


    protected function render() {
        $settings 	= $this->get_settings();
		$list 		= $settings['item_lists_style'];

		if($list == "materialbullet"){?>
		<div class="royalil-material-bullet-style" style="direction:<?php echo wp_kses_post( $settings['list_items_box_column_direction'] ) ?>;">
			<div class="royalil-container-holder">
			<?php foreach ($settings['material_item_lists'] as $items => $item) {
				$icon = $item['material_list_items_icon']['value'];
				$title = $item['material_list_items_title'];
				$title_color = $item['material_title_color'];
				$content = $item['material_list_items_content'];
				$content_color = $item['material_content_color'];
				$content_bg_color = $item['material_content_bg_color'];
				$icon_color = $item['material_icon_color'];
				$icon_bg_color = $item['material_icon_bg_color']; ?>
				<div class="royalil-container-row"><?php
					if($item['material_list_items_display_icon'] === 'icon') { ?>
						<i class="royalil-icon <?php echo $icon ?>" style="color:<?php echo $icon_color; ?>; background-color:<?php echo $icon_bg_color; ?>"></i>
					<?php } 
					else if($item['material_list_items_display_icon'] === 'image') { ?>
						<img src="<?php echo $item['material_list_items_image']['url']; ?>" class="royalil-image" />
					<?php } ?>
					<div class="royalil-content-box" style="background-color:<?php echo $content_bg_color ?>;">
						<h2 class="royalil-title"><?php echo $title; ?></h2>
						<p class="royalil-content"><?php echo $content; ?></p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>		
		
		<?php } elseif ($list == "shapebullet"){ ?>
		<div class="royalil-shape-bullet-style" style="direction:<?php echo wp_kses_post( $settings['list_items_box_column_direction'] ) ?>;"><?php
		foreach ($settings['shape_item_lists'] as $items => $item) {
			$icon = $item['shape_list_items_icon']['value'];
			$title = $item['shape_list_items_title'];
			$content = $item['shape_list_items_content'];
			$icon_box = $item['shape_list_item_icon_style'] ?>
			<div class="royalil-container-holder">
				<div class="royalil-container-icon-line">
					<div class="royalil-icon-box"><?php 
						if($icon_box == 'diamond-icon-style') { ?>
							<svg  viewBox="0 0 94 94" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.41423 46.528L46.53 1.41421L91.6418 46.528L46.528 91.6418L1.41423 46.528Z" stroke="black" stroke-width="1"/>
							</svg><?php
						}
						else if($icon_box == 'circle-icon-style') { ?>
							<svg  viewBox="0 0 67 67" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M56.0851 56.0846C43.6274 68.5424 23.429 68.5428 10.9714 56.0851C-1.4865 43.6273 -1.48583 23.4285 10.9723 10.9709C23.4303 -1.48657 43.6287 -1.4866 56.0861 10.9713C68.5433 23.4291 68.5427 43.6271 56.0851 56.0846Z" stroke="black" stroke-width="1"/>
							</svg><?php
						}
						else { ?>
							<svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0.5 0.5H49.5V49.5H0.5V0.5Z" stroke="black"/>
							</svg><?php
						}
						if($item['shape_list_items_display_icon'] === 'icon') { ?>
							<i class="royalil-icon <?php echo $icon ?>"></i>
						<?php } ?>
					</div>
					<div class="royalil-line"></div>
				</div>
				<div class="royalil-content-box">
					<h2 class="royalil-title"><?php echo $title; ?></h2>
					<p class="royalil-content"><?php echo $content; ?></p>
				</div>
			</div>
			<?php } ?>
		</div>	
		<?php } elseif ($list == "timelinebullet"){ ?>
		<div class="royalil-timeline-bullet-style" style="direction:<?php echo wp_kses_post( $settings['list_items_box_column_direction'] ) ?>;"><?php
			foreach ($settings['timeline_item_lists'] as $items => $item) {
				$icon = $item['timeline_list_items_icon']['value'];
				$title = $item['timeline_list_items_title'];
				$content = $item['timeline_list_items_content'];
				$icon_color = $item['timeline_icon_color'];
				$icon_bg_color = $item['timeline_icon_bg_color']; ?>
				<div class="royalil-container-holder">
					<div class="royalil-timeline-vertical"></div>
					<div class="royalil-timeline-horizontal"></div><?php
					if($item['timeline_list_items_display_icon'] === 'icon') { ?>
					<div class="royalil-icon-box" style="background-color:<?php echo $icon_bg_color; ?>">
						<i class="royalil-icon <?php echo $icon ?>" style="color:<?php echo $icon_color; ?>;"></i>
					</div><?php
					}  else if($item['timeline_list_items_display_icon'] === 'image') { ?>
						<img src="<?php echo $item['timeline_list_items_image']['url']; ?>" class="royalil-image" /><?php
					} ?>
					<div class="royalil-content-box">
						<h2 class="royalil-title"><?php echo $title; ?></h2>
						<p class="royalil-content"><?php echo $content; ?></p>
					</div>
				</div><?php
			} ?>
		</div>
		<?php } elseif ($list == "alternatetimelinebullet"){ ?>
		<div class="royalil-alternate-timeline-bullet-style">
			<?php $count = 0; 
			foreach ($settings['timeline_item_lists'] as $items => $item) {
				$icon = $item['timeline_list_items_icon']['value'];
				$title = $item['timeline_list_items_title'];
				$content = $item['timeline_list_items_content'];
				$icon_color = $item['timeline_icon_color'];
				$icon_bg_color = $item['timeline_icon_bg_color'];
				$ile_timeline_content = "royalil-timeline-right";
				if($count % 2 == 0) { 
					$ile_timeline_content = "royalil-timeline-left";  
				} ?>
				<div class="royalil-container-holder <?php echo $ile_timeline_content; ?>">
					<div class="royalil-timeline-vertical"></div>
					<div class="royalil-timeline-horizontal"></div>
					<?php if($item['timeline_list_items_display_icon'] === 'icon') { ?>
					<div class="royalil-icon-box" style="background-color:<?php echo $icon_bg_color; ?>">
						<i class="royalil-icon <?php echo $icon ?>" style="color:<?php echo $icon_color; ?>;"></i>
					</div>
					<?php } else if($item['timeline_list_items_display_icon'] === 'image') { ?>
						<img src="<?php echo $item['timeline_list_items_image']['url']; ?>" class="royalil-image" /><?php
					} ?>
					<div class="royalil-content-box">
						<h2 class="royalil-title"><?php echo $title; ?></h2>
						<p class="royalil-content"><?php echo $content; ?></p>
					</div>
				</div>
				<?php $count = $count +1; } ?>
		</div>	
		<?php } elseif ($list == "gradientorderedbullet"){ ?>
		<div class="royalil-gradient-ordered-bullet-style">
			<ol class="royalil-container-holder">
			<?php $alignment = $settings['list_items_number_box_alignment'];
			foreach ($settings['gradient_ordered_item_lists'] as $items => $item) {
				$title = $item['gradient_ordered_list_items_title'];
				$content = $item['gradient_ordered_list_items_content']; ?>
				<li class="royalil-content-container royalil-number-alignment-<?php echo $alignment; ?>">
					<div class="royalil-content-box">
						<h2 class="royalil-title"><?php echo $title; ?></h2>
						<p class="royalil-content"><?php echo $content; ?></p>
					</div>
				</li><?php
			} ?>
			</ol>
		</div>
		<?php }else{}

        
    }

}