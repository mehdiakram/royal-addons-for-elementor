<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalServices extends Widget_Base {

    public function get_name() {
        return  'royalservices';
    }

    public function get_title() {
        return esc_html__( 'Services', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-post-list rtbranding'; }

    public function get_keywords() {
        return [ 'services', 'action', 'facility', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

    public function get_categories() {
        return [ 'royaltech' ];
    }


	public function get_style_depends() {
		$styles = [
            'royalservices',
            'elementor-icons-fa-solid',
            'elementor-icons-fa-regular',
            'elementor-icons-fa-brands',
        ];
		return $styles;
	}


    protected function register_controls() {
		$this->service_content_tab();
		$this->service_style_tab();
	}    


    private function service_content_tab() {
        $this->start_controls_section(
            'service_section',
            [
                'label' => __( 'Service', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'service_style',
			[
				'label' => __( 'Service Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Style 2', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Style 3', 'royal-addons-for-elementor' ),
					'4' => esc_html__( 'Style 4', 'royal-addons-for-elementor' ),	
					'5' => esc_html__( 'Style 5', 'royal-addons-for-elementor' ),	
					'6' => esc_html__( 'Style 6', 'royal-addons-for-elementor' ),
					'7' => esc_html__( 'Style 7 — Hover Card', 'royal-addons-for-elementor' ),
					'8' => esc_html__( 'Style 8 — 3D Tilt Card', 'royal-addons-for-elementor' ),
					'9' => esc_html__( 'Style 9 — Icon Left Card', 'royal-addons-for-elementor' ),
					'10' => esc_html__( 'Style 10 — Objective Card', 'royal-addons-for-elementor' ),
					'11' => esc_html__( 'Style 11 — Pillar Animated Card (Unnayan)', 'royal-addons-for-elementor' ),
					'12' => esc_html__( 'Style 12 — Glowing Neon Border Card', 'royal-addons-for-elementor' ),
					'13' => esc_html__( 'Style 13 — Minimalist Watermark Card', 'royal-addons-for-elementor' ),
					'14' => esc_html__( 'Style 14 — Isometric Corner Ribbon Card', 'royal-addons-for-elementor' ),
					'15' => esc_html__( 'Style 15 — Two-Tone Split Header Card', 'royal-addons-for-elementor' ),
					'16' => esc_html__( 'Style 16 — Cyberpunk Tech Bracket Card', 'royal-addons-for-elementor' ),
					'17' => esc_html__( 'Style 17 — Aurora Mesh Floating Card', 'royal-addons-for-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'mobile_adapt',
			[
				'label' => esc_html__( 'Mobile Adapt', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
                'condition' => [
                    'service_style' => ['2', '3'],
				],				
			]
		);
		
        $this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
                'condition' => [
                    'service_style' => ['2', '3' ],
				],
				'selectors' => [
					'{{WRAPPER}} .royalelementservices .servicecontent' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'imageoricon',
			[
				'label' => __( 'Image or Icon', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'   => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
					'image'  => esc_html__( 'Image', 'royal-addons-for-elementor' ),
					'letter' => esc_html__( 'Letter / Number', 'royal-addons-for-elementor' ),
				],
			]
		);

        
		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'imageoricon' => 'image',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
                'condition' => [
                    'imageoricon' => 'icon',
                ],          
			]
		);


        
		$this->add_control(
			'letter_char',
			[
				'label'       => __( 'Letter or Number', 'royal-addons-for-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '1',
				'placeholder' => '1 or A',
				'description' => __( 'Enter 1 or 2 characters to display as an icon/avatar.', 'royal-addons-for-elementor' ),
				'condition'   => [
					'imageoricon' => 'letter',
				],
			]
		);
$this->add_control(
            'number',
            [
                'label' => __( 'Number', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '1',
                'condition' => [
                    'service_style' => ['1', '2', '3', '10', '11', '13', '14', '16'],
                ],
                'label_block' => false,
            ]
        );

        $this->add_control(
            'badge_text',
            [
                'label' => __( 'Badge / Tag', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Featured', 'royal-addons-for-elementor' ),
                'placeholder' => __( 'e.g. Featured, New, Popular', 'royal-addons-for-elementor' ),
                'condition' => [
                    'service_style' => ['12', '14', '15', '16', '17'],
                ],
            ]
        );

        // ── Style 8 Size Controls ──────────────────────────────
        $this->add_control(
            's8_size_heading',
            [
                'label'     => __( 'Card Size', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'service_style' => '8' ],
            ]
        );

        $this->add_responsive_control(
            's8_card_width',
            [
                'label'      => __( 'Width', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 50,  'max' => 800, 'step' => 5 ],
                    '%'  => [ 'min' => 10,  'max' => 100, 'step' => 1 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 300 ],
                'selectors'  => [
                    '{{WRAPPER}} .servicestyle8' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'service_style' => '8' ],
            ]
        );

        $this->add_responsive_control(
            's8_card_height',
            [
                'label'      => __( 'Height', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 50, 'max' => 700, 'step' => 5 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 300 ],
                'selectors'  => [
                    '{{WRAPPER}} .servicestyle8'        => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .servicestyle8 .s8-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'service_style' => '8' ],
            ]
        );

        $this->end_controls_section();



        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Default title', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control(
            'titlelink',
            [
                'label' => __( 'Title Link', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'title!' => '',
                ],
            ]
        ); 

        // Style 10 Checklist Items
        $repeater_s10 = new Repeater();
        $repeater_s10->add_control(
            'item_text',
            [
                'label'       => esc_html__( 'Text', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Checklist item description.', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );
        $repeater_s10->add_control(
            'item_icon',
            [
                'label'   => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-check-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );
                $this->add_control(
            'enable_checklist',
            [
                'label'        => esc_html__( 'Checklist / Features', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'service_style' => ['10', '11', '12', '13', '14', '15', '16', '17'],
                ],
            ]
        );
$this->add_control(
            's10_checklist',
            [
                'label'       => esc_html__( 'Checklist / Features', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_s10->get_controls(),
                'default'     => [
                    [
                        'item_text' => esc_html__( 'Safe drinking water systems', 'royal-addons-for-elementor' ),
                    ],
                    [
                        'item_text' => esc_html__( 'Hygiene awareness sessions', 'royal-addons-for-elementor' ),
                    ],
                    [
                        'item_text' => esc_html__( 'Sanitation infrastructure', 'royal-addons-for-elementor' ),
                    ],
                    [
                        'item_text' => esc_html__( 'School WASH programs', 'royal-addons-for-elementor' ),
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
                'condition'   => [
                    'service_style'    => ['10', '11', '12', '13', '14', '15', '16', '17'],
                    'enable_checklist' => 'yes',
                ],
            ]
        ); 

        $this->add_control(
            'description',
            [
                'label' => __( 'Description', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'condition' => [
                    'service_style' => ['1', '2', '3', '4', '6', '7', '9', '11', '12', '13', '14', '15', '16', '17'],
				],	
                'default' => __( 'Ensuring access to clean water and safe sanitation facilities for all.', 'royal-addons-for-elementor' ),
                'placeholder' => __( 'Type your description here', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'readmore',
            [
                'label' => __( 'Readmore', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'service_style' => ['1', '2', '3', '4', '6', '7', '9', '11', '12', '13', '14', '15', '16', '17'],
				],	
                'default' => __( 'Read More', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'readmorelink',
            [
                'label' => __( 'Readmore Link', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'service_style' => ['1', '2', '3', '4', '6', '7', '9', '11', '12', '13', '14', '15', '16', '17'],
                    'readmore!' => '',
                ],
            ]
        );  
        $this->end_controls_section();
    }


    private function service_style_tab() {

        $this->start_controls_section(
            'services_style_section',
            [
                'label' => __( 'Services Style', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'services_padding',
            [
                'label' => __( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'description' => 'Default: 0px',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'services_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalelementservices',
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'box_style_section',
            [
                'label' => __( 'Box Style', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'iconbox_background',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '
                {{WRAPPER}} .royalelementservices .serviceimg,
                {{WRAPPER}} .royalelementservices .servicestyle4 .imageoricon,
                {{WRAPPER}} .royalelementservices .servicestyle5,
                {{WRAPPER}} .royalelementservices .servicestyle6',
			]
		);

        $this->add_control(
			'box_border_radius',
			[
				'label'     => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%'],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalelementservices .serviceimg' => 'border-radius: {{SIZE}}{{UNIT}}', 
					'{{WRAPPER}} .royalelementservices .servicestyle4 .imageoricon' => 'border-radius: {{SIZE}}{{UNIT}}', 
					'{{WRAPPER}} .royalelementservices .servicestyle5' => 'border-radius: {{SIZE}}{{UNIT}}', 
				],
			]
		);

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'condition' => [
                    'imageoricon' => ['icon'],
                ],

                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .imageoricon i, {{WRAPPER}} .servicestyle8 .s8-icon-wrap i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royalelementservices .imageoricon svg, {{WRAPPER}} .servicestyle8 .s8-icon-wrap svg, {{WRAPPER}} .servicestyle10 .s10-ico svg, {{WRAPPER}} .servicestyle11 .s11-ico svg, {{WRAPPER}} .servicestyle12 .s12-ico svg, {{WRAPPER}} .servicestyle13 .s13-ico svg, {{WRAPPER}} .servicestyle14 .s14-ico svg, {{WRAPPER}} .servicestyle15 .s15-ico svg, {{WRAPPER}} .servicestyle16 .s16-ico svg, {{WRAPPER}} .servicestyle17 .s17-ico svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 15,
                    ],
                    'rem' => [
                        'min' => 0.5,
                        'max' => 15,
                    ],
                ],
                'condition' => [
                    'imageoricon' => ['icon'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .imageoricon i, {{WRAPPER}} .servicestyle8 .s8-icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalelementservices .imageoricon svg, {{WRAPPER}} .servicestyle8 .s8-icon-wrap svg, {{WRAPPER}} .servicestyle10 .s10-ico svg, {{WRAPPER}} .servicestyle11 .s11-ico svg, {{WRAPPER}} .servicestyle12 .s12-ico svg, {{WRAPPER}} .servicestyle13 .s13-ico svg, {{WRAPPER}} .servicestyle14 .s14-ico svg, {{WRAPPER}} .servicestyle15 .s15-ico svg, {{WRAPPER}} .servicestyle16 .s16-ico svg, {{WRAPPER}} .servicestyle17 .s17-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );        
        $this->end_controls_section();



        $this->start_controls_section(
            'number_style_section',
            [
                'label' => __( 'Number Style', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style' => ['1', '2', '3', '10'],
                    'number!' => '',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'number_background',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .royalelementservices .servicenumber',
			]
		);

        $this->add_control(
            'number_color',
            [
                'label' => __( 'Number Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .servicenumber' => 'color: {{VALUE}}',
                ],
                'default' => '#000000',
            ]
        );

        $this->add_control(
			'number_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .royalelementservices .servicenumber' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


        $this->end_controls_section();


        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __( 'Content Style', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style' => ['1', '2', '3', '4', '6', '7', '9'],
                ],
            ]
        );


        $this->start_controls_tabs('content_style_tabs');
        $this->start_controls_tab(
            'content_style_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background_normal',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '
                    {{WRAPPER}} .royalelementservices .servicecontent,
                    {{WRAPPER}} .royalelementservices .servicestyle4,
                    {{WRAPPER}} .royalelementservices .servicestyle4 .servicetitle',
			]
		);

        $this->end_controls_tab();


        $this->start_controls_tab(
            'content_style_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background_hover',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '
                    {{WRAPPER}} .royalelementservices:hover .servicecontent .serviceshape,
                    {{WRAPPER}} .royalelementservices:hover .servicestyle4,
                    {{WRAPPER}} .royalelementservices:hover .servicestyle4 .servicetitle',
			]
		);

        $this->end_controls_tab();        
        $this->end_controls_tabs();
        $this->end_controls_section();


        $this->start_controls_section(
            'title_style_section',
            [
                'label' => __( 'Title Style', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'service_title_typography',
                'label' => __( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalelementservices .servicetitle',
            ]
        );

        $this->add_control(
            'title_ball_color',
            [
                'label' => __( 'Title Ball Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'service_style' => ['5'],
                ],
                'default'   => '#D7B474',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle5 .servicetitle::after' => 'background: {{VALUE}}',
                ],
            ]
        );


        $this->add_responsive_control(
            'titlebox_padding',
            [
                'label' => __( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [
                    'service_style' => ['5'],
                ],
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 30,
                    'right' => 30,
                    'bottom' => 30,
                    'left' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .servicestyle5 .servicestitlebox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'description' => 'Default: 30px',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'servicestitlebox_shadow',
				'label'     => esc_html__( 'Box Shadow', 'royal-addons-for-elementor' ),
				'selector'  => '{{WRAPPER}} .royalelementservices .servicestyle5 .servicestitlebox',
				'condition' => [
					'service_style' => ['5'],
				],
			]
		);


        $this->add_control(
            'title_box_background',
            [
                'label' => __( 'Background', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'service_style' => ['5'],
                ],
                'default'   => '#131313',
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .servicestyle5 .servicestitlebox' => 'background: {{VALUE}}',
                ],
            ]
        );

        




       
        $this->start_controls_tabs(
            'title_section_style_tabs'
        );
        
        $this->start_controls_tab(
            'title_style_tab_normal',
            [
                'label' => __( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );


        $this->add_control(
            'title_color_normal',
            [
                'label' => __( 'Title Color Normal', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .servicetitle' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .royalelementservices .servicetitle a' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .royalelementservices .servicestyle4 .servicetitle:before' => 'background: linear-gradient(to right, {{VALUE}}, transparent);',
                    '{{WRAPPER}} .royalelementservices .servicestyle4 .servicetitle:after' => 'background: linear-gradient(to right, transparent, {{VALUE}});',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_hover_style',
            [
                'label' => __( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'content_title_hover_color',
            [
                'label' => __( 'Title Color Hover', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices:hover .servicetitle' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .royalelementservices:hover .servicetitle a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();



        $this->start_controls_section(
            'servicedescription_style_section',
            [
                'label' => __( 'Description Style', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style' => ['1', '2', '3', '4', '6', '7', '9', '11', '12', '13', '14', '15', '16', '17'],
                ],
            ]
        );

        $this->add_responsive_control(
            'servicedescription_top_spacing',
            [
                'label' => __( 'Description Top Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'description' => 'Default: 10px',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .servicedescription' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'servicedescription_typography',
                'label' => __( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalelementservices .servicedescription',
            ]
        );

        $this->start_controls_tabs(
            'servicedescription_section_style_tabs'
        );
        
        $this->start_controls_tab(
            'servicedescription_style_tab_normal',
            [
                'label' => __( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'servicedescription_color_normal',
            [
                'label' => __( 'Description Color Normal', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .servicedescription' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'servicedescription_hover_style',
            [
                'label' => __( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'servicedescription_hover_color',
            [
                'label' => __( 'Description Color Hover', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices:hover .servicedescription' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();




        $this->start_controls_section(
            'readmore_button_style_section',
            [
                'label' => __( 'Button Style', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style' => ['1', '2', '3', '4', '6', '7', '9', '11', '12', '13', '14', '15', '16', '17'],
                ],
            ]
        );

        $this->add_responsive_control(
            'readmore_button_top_spacing',
            [
                'label' => __( 'Button Top Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'description' => 'Default: 10px',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .linkbtn' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'readmore_button_typography',
                'label' => __( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalelementservices .linkbtn',
            ]
        );

        $this->start_controls_tabs(
            'readmore_button_section_style_tabs'
        );
        
        $this->start_controls_tab(
            'readmore_button_style_tab_normal',
            [
                'label' => __( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'readmore_button_color_normal',
            [
                'label' => __( 'Button Color Normal', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .linkbtn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .servicestyle6 .top'           => 'background: {{VALUE}}',
                    '{{WRAPPER}} .servicestyle7 .s7-overlay'    => 'background: {{VALUE}}',
                ],
                'default' => '#0E5AF2',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'readmore_button_hover_style',
            [
                'label' => __( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'readmore_button_hover_color',
            [
                'label' => __( 'Button Color Hover', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .linkbtn:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .royalelementservices:hover .servicestyle1 .linkbtn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .royalelementservices:hover .servicestyle2 .linkbtn' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .royalelementservices:hover .servicestyle3 .linkbtn' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'readmore_button_underline_hover_color',
            [
                'label' => __( 'Button Underline Color Hover', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalelementservices .linkbtn:before' => 'background-color: {{VALUE}}',
                ],
                'default' => '#0E5AF2',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // ── Style 10 Card Settings ──────────────────────────────
        $this->start_controls_section(
            's10_card_style_section',
            [
                'label' => __( 'Objective Card Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style' => '10',
                ],
            ]
        );

        $this->add_control(
            's10_theme_color',
            [
                'label' => __( 'Accent Theme Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0d6efd',
                'description' => __( 'Controls accent bar, icon bg, dashed ring, number and checklist icons.', 'royal-addons-for-elementor' ),
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10' => '--c: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            's10_bg_color',
            [
                'label' => __( 'Card Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            's10_border_radius',
            [
                'label' => __( 'Card Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 24,
                    'right' => 24,
                    'bottom' => 24,
                    'left' => 24,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            's10_card_padding',
            [
                'label' => __( 'Card Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 28,
                    'right' => 26,
                    'bottom' => 26,
                    'left' => 26,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 's10_card_shadow',
                'label' => __( 'Card Shadow', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .servicestyle10',
            ]
        );

        $this->add_control(
            's10_enable_spin',
            [
                'label' => __( 'Enable Rotating Ring', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => __( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            's10_enable_shine',
            [
                'label' => __( 'Enable Hover Shine', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => __( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // ── Checklist / Features Style ────────────────────────────
        $this->start_controls_section(
            's10_checklist_style_section',
            [
                'label' => __( 'Checklist / Features Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style'    => ['10', '11', '12', '13', '14', '15', '16', '17'],
                    'enable_checklist' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            's10_list_gap',
            [
                'label' => __( 'List Gap', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 4, 'max' => 40 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 10 ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10 .s10-list, {{WRAPPER}} .servicestyle11 .s11-list, {{WRAPPER}} .servicestyle12 .s12-list, {{WRAPPER}} .servicestyle13 .s13-list, {{WRAPPER}} .servicestyle14 .s14-list, {{WRAPPER}} .servicestyle15 .s15-list, {{WRAPPER}} .servicestyle16 .s16-list, {{WRAPPER}} .servicestyle17 .s17-list' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            's10_list_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#5a6a75',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10 .s10-list li, {{WRAPPER}} .servicestyle11 .s11-list li, {{WRAPPER}} .servicestyle12 .s12-list li, {{WRAPPER}} .servicestyle13 .s13-list li, {{WRAPPER}} .servicestyle14 .s14-list li, {{WRAPPER}} .servicestyle15 .s15-list li, {{WRAPPER}} .servicestyle16 .s16-list li, {{WRAPPER}} .servicestyle17 .s17-list li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 's10_list_typography',
                'label' => __( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .servicestyle10 .s10-list li, {{WRAPPER}} .servicestyle11 .s11-list li, {{WRAPPER}} .servicestyle12 .s12-list li, {{WRAPPER}} .servicestyle13 .s13-list li, {{WRAPPER}} .servicestyle14 .s14-list li, {{WRAPPER}} .servicestyle15 .s15-list li, {{WRAPPER}} .servicestyle16 .s16-list li, {{WRAPPER}} .servicestyle17 .s17-list li',
            ]
        );

        $this->add_control(
            's10_list_icon_color',
            [
                'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10 .s10-list-ico i, {{WRAPPER}} .servicestyle11 .s11-list-ico i, {{WRAPPER}} .servicestyle12 .s12-list-ico i, {{WRAPPER}} .servicestyle13 .s13-list-ico i, {{WRAPPER}} .servicestyle14 .s14-list-ico i, {{WRAPPER}} .servicestyle15 .s15-list-ico i, {{WRAPPER}} .servicestyle16 .s16-list-ico i, {{WRAPPER}} .servicestyle17 .s17-list-ico i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .servicestyle10 .s10-list-ico svg, {{WRAPPER}} .servicestyle11 .s11-list-ico svg, {{WRAPPER}} .servicestyle12 .s12-list-ico svg, {{WRAPPER}} .servicestyle13 .s13-list-ico svg, {{WRAPPER}} .servicestyle14 .s14-list-ico svg, {{WRAPPER}} .servicestyle15 .s15-list-ico svg, {{WRAPPER}} .servicestyle16 .s16-list-ico svg, {{WRAPPER}} .servicestyle17 .s17-list-ico svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            's10_list_icon_size',
            [
                'label' => __( 'Icon Size', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 32 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle10 .s10-list-ico i, {{WRAPPER}} .servicestyle11 .s11-list-ico i, {{WRAPPER}} .servicestyle12 .s12-list-ico i, {{WRAPPER}} .servicestyle13 .s13-list-ico i, {{WRAPPER}} .servicestyle14 .s14-list-ico i, {{WRAPPER}} .servicestyle15 .s15-list-ico i, {{WRAPPER}} .servicestyle16 .s16-list-ico i, {{WRAPPER}} .servicestyle17 .s17-list-ico i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .servicestyle10 .s10-list-ico svg, {{WRAPPER}} .servicestyle11 .s11-list-ico svg, {{WRAPPER}} .servicestyle12 .s12-list-ico svg, {{WRAPPER}} .servicestyle13 .s13-list-ico svg, {{WRAPPER}} .servicestyle14 .s14-list-ico svg, {{WRAPPER}} .servicestyle15 .s15-list-ico svg, {{WRAPPER}} .servicestyle16 .s16-list-ico svg, {{WRAPPER}} .servicestyle17 .s17-list-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ── Style 11 Pillar Card Style ────────────────────────────
        $this->start_controls_section(
            's11_card_style_section',
            [
                'label' => __( 'Pillar Card Style (Style 11)', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style' => '11',
                ],
            ]
        );

        $this->add_control(
            's11_theme_color',
            [
                'label' => __( 'Primary Accent Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0b4d26',
                'description' => __( 'Controls top bar start, icon hover background, title color, and hover border.', 'royal-addons-for-elementor' ),
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11' => '--s11-accent: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            's11_sec_color',
            [
                'label' => __( 'Secondary Accent Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#c9a24a',
                'description' => __( 'Controls top bar gradient end and checklist icons.', 'royal-addons-for-elementor' ),
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11' => '--s11-sec: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            's11_bg_color',
            [
                'label' => __( 'Card Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            's11_border_color',
            [
                'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(11, 77, 38, 0.14)',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            's11_border_radius',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            's11_card_padding',
            [
                'label' => __( 'Card Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 26,
                    'right' => 24,
                    'bottom' => 26,
                    'left' => 24,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 's11_card_shadow',
                'label' => __( 'Hover Shadow', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .servicestyle11:hover',
            ]
        );

        $this->add_control(
            's11_icon_bg',
            [
                'label' => __( 'Icon Box Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(11, 77, 38, 0.08)',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11 .s11-ico' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            's11_icon_color',
            [
                'label' => __( 'Icon Normal Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0b4d26',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle11 .s11-ico' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .servicestyle11 .s11-ico i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .servicestyle11 .s11-ico svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ── Modern Services Style (Styles 12–17) ───────────────────
        $this->start_controls_section(
            'modern_cards_style_section',
            [
                'label' => __( 'Modern Card Style (Styles 12–17)', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'service_style' => ['12', '13', '14', '15', '16', '17'],
                ],
            ]
        );

        $this->add_control(
            'modern_theme_color',
            [
                'label' => __( 'Primary Accent Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#2563eb',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle12, {{WRAPPER}} .servicestyle13, {{WRAPPER}} .servicestyle14, {{WRAPPER}} .servicestyle15, {{WRAPPER}} .servicestyle16, {{WRAPPER}} .servicestyle17' => '--m-color: {{VALUE}}; --m-accent: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'modern_sec_color',
            [
                'label' => __( 'Secondary Accent Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#06b6d4',
                'selectors' => [
                    '{{WRAPPER}} .servicestyle12, {{WRAPPER}} .servicestyle13, {{WRAPPER}} .servicestyle14, {{WRAPPER}} .servicestyle15, {{WRAPPER}} .servicestyle16, {{WRAPPER}} .servicestyle17' => '--m-sec: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'modern_card_bg',
            [
                'label' => __( 'Card Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .servicestyle12 .s12-inner, {{WRAPPER}} .servicestyle13, {{WRAPPER}} .servicestyle14, {{WRAPPER}} .servicestyle15, {{WRAPPER}} .servicestyle16, {{WRAPPER}} .servicestyle17' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'modern_border_radius',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle12, {{WRAPPER}} .servicestyle12 .s12-inner, {{WRAPPER}} .servicestyle13, {{WRAPPER}} .servicestyle14, {{WRAPPER}} .servicestyle15, {{WRAPPER}} .servicestyle16, {{WRAPPER}} .servicestyle17' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'modern_card_padding',
            [
                'label' => __( 'Card Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .servicestyle12 .s12-inner, {{WRAPPER}} .servicestyle13, {{WRAPPER}} .servicestyle14, {{WRAPPER}} .servicestyle15 .s15-body, {{WRAPPER}} .servicestyle16, {{WRAPPER}} .servicestyle17' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'modern_box_shadow',
                'label' => __( 'Hover Shadow', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .servicestyle12:hover, {{WRAPPER}} .servicestyle13:hover, {{WRAPPER}} .servicestyle14:hover, {{WRAPPER}} .servicestyle15:hover, {{WRAPPER}} .servicestyle16:hover, {{WRAPPER}} .servicestyle17:hover',
            ]
        );

        $this->end_controls_section();


    }


    protected function render() {
        $settings           = $this->get_settings_for_display();
        $service_style      = $settings[ 'service_style' ];
		$mobileadapt        = '';
		if ( 'yes' === $settings['mobile_adapt'] ) {
			$mobileadapt = 'mobileadapt';
		}                
				
				
        if($service_style == "1"){?>
        <div class="royalelementservices">
            <div class="servicestyle1">
                <div class="serviceimg">
                    <?php $this->number(); ?>
                    <?php $this->imageoricon(); ?>
                </div>
                <div class="servicecontent">
                    <div class="serviceshape"></div>
                        <?php $this->title(); ?>
                        <?php $this->description(); ?>
                        <?php $this->readmore(); ?>
                </div>
            </div>
        </div>      


        <?php } elseif($service_style == "2"){?>
        <div class="royalelementservices">
            <div class="servicestyle2 <?php echo $mobileadapt ?>">
                <div class="serviceimg">
                    <?php $this->number(); ?>
                    <?php $this->imageoricon(); ?>
                </div>
                <div class="servicecontent">
                    <div class="serviceshape"></div>
                        <?php $this->title(); ?>
                        <?php $this->description(); ?>
                        <?php $this->readmore(); ?>
                </div>
            </div>
        </div>


        <?php } elseif($service_style == "3"){?>
        <div class="royalelementservices">
            <div class="servicestyle3 <?php echo $mobileadapt ?>">
                <div class="serviceimg">
                    <?php $this->number(); ?>
                    <?php $this->imageoricon(); ?>
                </div>                 
				<div class="servicecontent">
                    <div class="serviceshape"></div>
                        <?php $this->title(); ?>
                        <?php $this->description(); ?>
                        <?php $this->readmore(); ?>
                </div>               
            </div>
        </div>


        <?php } elseif($service_style == "4"){?>
        <div class="royalelementservices services-section">
            <div class="servicestyle4">
                <?php $this->imageoricon(); ?>
                <?php $this->title(); ?>
                <?php $this->description(); ?>
            </div>
        </div>


        <?php } elseif($service_style == "5"){?>
        <div class="royalelementservices services-section">
            <div class="servicestyle5">
                <?php $this->title(); ?>
                <?php $this->imageoricon(); ?>
            </div>
        </div>

        <?php } elseif($service_style == "6"){?>
        <div class="royalelementservices services-section">
            <div class="servicestyle6">
                <div class="back">
                    <?php $this->title(); ?>
                    <?php $this->description(); ?>
                    <?php $this->readmore(); ?>
                </div>
                <div class="top">
                    <?php $this->imageoricon(); ?>
                    <?php $this->title(); ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "7"){?>
        <div class="royalelementservices services-section">
            <div class="servicestyle7">
                <div class="s7-front">
                    <?php $this->imageoricon(); ?>
                    <?php $this->title(); ?>
                </div>
                <div class="s7-overlay">
                    <?php $this->imageoricon(); ?>
                    <?php $this->title(); ?>
                    <?php $this->description(); ?>
                    <?php $this->readmore(); ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "8"){
            $s8_img     = ! empty( $settings['image']['url'] ) ? esc_url( $settings['image']['url'] ) : '';
            $s8_has_img = ( ! empty( $s8_img ) && strpos( $s8_img, 'placeholder.png' ) === false );
            $s8_title   = $settings['title'];
            $s8_link    = ! empty( $settings['titlelink']['url'] )
                            ? esc_url( $settings['titlelink']['url'] )
                            : ( ! empty( $settings['readmorelink']['url'] )
                                ? esc_url( $settings['readmorelink']['url'] )
                                : '#' );
            $s8_target  = ( ! empty( $settings['titlelink']['is_external'] ) && $settings['titlelink']['is_external'] )
                            ? ' target="_blank"'
                            : ( ( ! empty( $settings['readmorelink']['is_external'] ) && $settings['readmorelink']['is_external'] )
                                ? ' target="_blank"'
                                : '' );
            $s8_nofollow = ( ! empty( $settings['titlelink']['nofollow'] ) && $settings['titlelink']['nofollow'] )
                            ? ' rel="nofollow"'
                            : '';
        ?>
        <div class="royalelementservices">
            <div class="servicestyle8">
                <a class="s8-card" href="<?php echo $s8_link; ?>"<?php echo $s8_target; ?><?php echo $s8_nofollow; ?> style="<?php if ( $s8_has_img ) : ?>background-image: url('<?php echo $s8_img; ?>');<?php endif; ?>">
                    <div class="s8-overlay"></div>
                    <div class="s8-inner">
                        <?php if ( $this->has_card_media( $settings ) ) : ?>
                            <div class="s8-icon-wrap">
                                <?php $this->render_card_icon( $settings ); ?>
                            </div>
                        <?php endif; ?>
                        <span class="s8-title"><?php echo esc_html( $s8_title ); ?></span>
                        <?php if ( ! empty( $settings['description'] ) ) : ?>
                            <p class="s8-desc"><?php echo wp_kses_post( $settings['description'] ); ?></p>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['readmore'] ) ) : ?>
                            <span class="s8-readmore"><?php echo esc_html( $settings['readmore'] ); ?> &rarr;</span>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        </div>

        <?php } elseif($service_style == "9"){
            $s9_readmore      = $settings['readmore'];
            $s9_readmorelink  = ! empty( $settings['readmorelink']['url'] ) ? esc_url( $settings['readmorelink']['url'] ) : '#';
            $s9_rm_target     = ( ! empty( $settings['readmorelink']['is_external'] ) && $settings['readmorelink']['is_external'] ) ? ' target="_blank"' : '';
            $s9_rm_nofollow   = ( ! empty( $settings['readmorelink']['nofollow'] ) && $settings['readmorelink']['nofollow'] ) ? ' rel="nofollow"' : '';
        ?>
        <div class="royalelementservices">
            <div class="servicestyle9">
                <div class="s9-icon-wrap">
                    <?php $this->imageoricon(); ?>
                </div>
                <div class="s9-content">
                    <?php $this->title(); ?>
                    <?php $this->description(); ?>
                    <?php if ( ! empty( $s9_readmore ) ) : ?>
                        <a href="<?php echo $s9_readmorelink; ?>"<?php echo $s9_rm_target; ?><?php echo $s9_rm_nofollow; ?> class="s9-readmore">
                            <?php echo esc_html( $s9_readmore ); ?> &rarr;
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "10"){
            $s10_number       = ! empty( $settings['number'] ) ? $settings['number'] : '';
            $s10_checklist    = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $s10_enable_shine = ( ! isset( $settings['s10_enable_shine'] ) || 'yes' === $settings['s10_enable_shine'] );
            $s10_enable_spin  = ( ! isset( $settings['s10_enable_spin'] ) || 'yes' === $settings['s10_enable_spin'] );
            $s10_spin_class   = $s10_enable_spin ? 'has-spin' : 'no-spin';
            $show_checklist   = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle10 <?php echo esc_attr( $s10_spin_class ); ?>">
                <?php if ( $s10_enable_shine ) : ?>
                    <span class="s10-shine"></span>
                <?php endif; ?>

                <?php if ( ! empty( $s10_number ) ) : ?>
                    <span class="s10-num servicenumber"><?php echo esc_html( $s10_number ); ?></span>
                <?php endif; ?>

                <?php if ( $this->has_card_media( $settings ) ) : ?>
                    <div class="s10-ico">
                        <?php $this->render_card_icon( $settings ); ?>
                    </div>
                <?php endif; ?>

                <div class="s10-content">
                    <?php $this->title(); ?>

                    <?php if ( $show_checklist && ! empty( $s10_checklist ) ) : ?>
                        <ul class="s10-list">
                            <?php foreach ( $s10_checklist as $item ) : ?>
                                <li>
                                    <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                        <span class="s10-list-ico">
                                            <?php $this->render_list_icon( $item ); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="s10-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "11"){
            $s11_number     = ! empty( $settings['number'] ) ? $settings['number'] : '';
            $s11_checklist  = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $show_checklist = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle11">
                <span class="s11-top-bar"></span>
                <?php if ( ! empty( $s11_number ) ) : ?>
                    <span class="s11-num"><?php echo esc_html( $s11_number ); ?></span>
                <?php endif; ?>
                <?php if ( $this->has_card_media( $settings ) ) : ?>
                    <div class="s11-ico">
                        <?php $this->render_card_icon( $settings ); ?>
                    </div>
                <?php endif; ?>
                <div class="s11-content">
                    <?php $this->title(); ?>
                    <?php $this->description(); ?>
                    <?php if ( $show_checklist && ! empty( $s11_checklist ) ) : ?>
                        <ul class="s11-list">
                            <?php foreach ( $s11_checklist as $idx => $item ) : ?>
                                <li style="--j: <?php echo esc_attr( $idx ); ?>;">
                                    <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                        <span class="s11-list-ico">
                                            <?php $this->render_list_icon( $item ); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="s11-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php $this->readmore(); ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "12"){
            $s12_badge      = ! empty( $settings['badge_text'] ) ? $settings['badge_text'] : '';
            $s12_checklist  = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $show_checklist = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle12">
                <div class="s12-inner">
                    <div class="s12-top-row">
                        <?php if ( $this->has_card_media( $settings ) ) : ?>
                            <div class="s12-ico">
                                <span class="s12-ico-pulse"></span>
                                <?php $this->render_card_icon( $settings ); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( ! empty( $s12_badge ) ) : ?>
                            <span class="s12-badge"><?php echo esc_html( $s12_badge ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="s12-content">
                        <?php $this->title(); ?>
                        <?php $this->description(); ?>
                        <?php if ( $show_checklist && ! empty( $s12_checklist ) ) : ?>
                            <ul class="s12-list">
                                <?php foreach ( $s12_checklist as $item ) : ?>
                                    <li>
                                        <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                            <span class="s12-list-ico"><?php $this->render_list_icon( $item ); ?></span>
                                        <?php endif; ?>
                                        <span class="s12-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php $this->readmore(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "13"){
            $s13_number     = ! empty( $settings['number'] ) ? sprintf( '%02d', intval( $settings['number'] ) ?: 1 ) : '01';
            $s13_checklist  = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $show_checklist = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle13">
                <span class="s13-watermark"><?php echo esc_html( $s13_number ); ?></span>
                <?php if ( $this->has_card_media( $settings ) ) : ?>
                    <div class="s13-ico">
                        <?php $this->render_card_icon( $settings ); ?>
                    </div>
                <?php endif; ?>
                <div class="s13-content">
                    <?php $this->title(); ?>
                    <span class="s13-line"></span>
                    <?php $this->description(); ?>
                    <?php if ( $show_checklist && ! empty( $s13_checklist ) ) : ?>
                        <ul class="s13-list">
                            <?php foreach ( $s13_checklist as $item ) : ?>
                                <li>
                                    <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                        <span class="s13-list-ico"><?php $this->render_list_icon( $item ); ?></span>
                                    <?php endif; ?>
                                    <span class="s13-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php $this->readmore(); ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "14"){
            $s14_badge      = ! empty( $settings['badge_text'] ) ? $settings['badge_text'] : ( ! empty( $settings['number'] ) ? '#' . $settings['number'] : '' );
            $s14_checklist  = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $show_checklist = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle14">
                <?php if ( ! empty( $s14_badge ) ) : ?>
                    <div class="s14-ribbon"><span><?php echo esc_html( $s14_badge ); ?></span></div>
                <?php endif; ?>
                <div class="s14-body">
                    <?php if ( $this->has_card_media( $settings ) ) : ?>
                        <div class="s14-ico">
                            <?php $this->render_card_icon( $settings ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="s14-content">
                        <?php $this->title(); ?>
                        <?php $this->description(); ?>
                        <?php if ( $show_checklist && ! empty( $s14_checklist ) ) : ?>
                            <ul class="s14-list">
                                <?php foreach ( $s14_checklist as $item ) : ?>
                                    <li>
                                        <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                            <span class="s14-list-ico"><?php $this->render_list_icon( $item ); ?></span>
                                        <?php endif; ?>
                                        <span class="s14-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php $this->readmore(); ?>
                    </div>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "15"){
            $s15_badge      = ! empty( $settings['badge_text'] ) ? $settings['badge_text'] : '';
            $s15_checklist  = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $show_checklist = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle15">
                <div class="s15-header">
                    <?php if ( ! empty( $s15_badge ) ) : ?>
                        <span class="s15-badge"><?php echo esc_html( $s15_badge ); ?></span>
                    <?php endif; ?>
                    <?php if ( $this->has_card_media( $settings ) ) : ?>
                        <div class="s15-ico">
                            <?php $this->render_card_icon( $settings ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="s15-body">
                    <?php $this->title(); ?>
                    <?php $this->description(); ?>
                    <?php if ( $show_checklist && ! empty( $s15_checklist ) ) : ?>
                        <ul class="s15-list">
                            <?php foreach ( $s15_checklist as $item ) : ?>
                                <li>
                                    <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                        <span class="s15-list-ico"><?php $this->render_list_icon( $item ); ?></span>
                                    <?php endif; ?>
                                    <span class="s15-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php $this->readmore(); ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "16"){
            $s16_tag        = ! empty( $settings['badge_text'] ) ? $settings['badge_text'] : 'SYS // READY';
            $s16_num        = ! empty( $settings['number'] ) ? $settings['number'] : '';
            $s16_checklist  = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $show_checklist = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle16">
                <span class="s16-bracket s16-tl"></span>
                <span class="s16-bracket s16-tr"></span>
                <span class="s16-bracket s16-bl"></span>
                <span class="s16-bracket s16-br"></span>
                <div class="s16-topbar">
                    <span class="s16-dot"></span>
                    <span class="s16-tag"><?php echo esc_html( $s16_tag ); ?></span>
                    <?php if ( ! empty( $s16_num ) ) : ?>
                        <span class="s16-id">[#<?php echo esc_html( $s16_num ); ?>]</span>
                    <?php endif; ?>
                </div>
                <?php if ( $this->has_card_media( $settings ) ) : ?>
                    <div class="s16-ico">
                        <?php $this->render_card_icon( $settings ); ?>
                    </div>
                <?php endif; ?>
                <div class="s16-content">
                    <?php $this->title(); ?>
                    <?php $this->description(); ?>
                    <?php if ( $show_checklist && ! empty( $s16_checklist ) ) : ?>
                        <ul class="s16-list">
                            <?php foreach ( $s16_checklist as $item ) : ?>
                                <li>
                                    <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                        <span class="s16-list-ico"><?php $this->render_list_icon( $item ); ?></span>
                                    <?php endif; ?>
                                    <span class="s16-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    <?php $this->readmore(); ?>
                </div>
            </div>
        </div>

        <?php } elseif($service_style == "17"){
            $s17_badge      = ! empty( $settings['badge_text'] ) ? $settings['badge_text'] : '';
            $s17_checklist  = ! empty( $settings['s10_checklist'] ) ? $settings['s10_checklist'] : [];
            $show_checklist = ( ! isset( $settings['enable_checklist'] ) || 'yes' === $settings['enable_checklist'] );
        ?>
        <div class="royalelementservices">
            <div class="servicestyle17">
                <div class="s17-aurora"></div>
                <div class="s17-card-inner">
                    <div class="s17-top-bar">
                        <?php if ( $this->has_card_media( $settings ) ) : ?>
                            <div class="s17-ico">
                                <?php $this->render_card_icon( $settings ); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( ! empty( $s17_badge ) ) : ?>
                            <span class="s17-badge"><?php echo esc_html( $s17_badge ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="s17-content">
                        <?php $this->title(); ?>
                        <?php $this->description(); ?>
                        <?php if ( $show_checklist && ! empty( $s17_checklist ) ) : ?>
                            <ul class="s17-list">
                                <?php foreach ( $s17_checklist as $item ) : ?>
                                    <li>
                                        <?php if ( ! empty( $item['item_icon']['value'] ) ) : ?>
                                            <span class="s17-list-ico"><?php $this->render_list_icon( $item ); ?></span>
                                        <?php endif; ?>
                                        <span class="s17-list-text"><?php echo wp_kses_post( $item['item_text'] ); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="s17-action">
                            <?php $this->readmore(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php } // end of style checks
    }

    protected function has_card_media( $settings ) {
        $type = ! empty( $settings['imageoricon'] ) ? $settings['imageoricon'] : 'icon';
        if ( 'image' === $type ) {
            return ! empty( $settings['image']['url'] ) && strpos( $settings['image']['url'], 'placeholder.png' ) === false;
        } elseif ( 'letter' === $type ) {
            return isset( $settings['letter_char'] ) && '' !== trim( (string) $settings['letter_char'] );
        } else {
            return ! empty( $settings['icon']['value'] );
        }
    }

    protected function render_card_icon( $settings ) {
        $type = ! empty( $settings['imageoricon'] ) ? $settings['imageoricon'] : 'icon';

        if ( 'image' === $type ) {
            if ( ! empty( $settings['image']['url'] ) && strpos( $settings['image']['url'], 'placeholder.png' ) === false ) {
                echo '<img src="' . esc_url( $settings['image']['url'] ) . '" alt="' . esc_attr( $settings['title'] ) . '">';
            }
            return;
        }

        if ( 'letter' === $type ) {
            $char = ( isset( $settings['letter_char'] ) && '' !== trim( (string) $settings['letter_char'] ) ) ? trim( (string) $settings['letter_char'] ) : '1';
            echo '<span class="royal-letter-icon">' . esc_html( $char ) . '</span>';
            return;
        }

        if ( ! empty( $settings['icon']['value'] ) ) {
            $icon = $settings['icon'];
            if ( empty( $icon['library'] ) || 'solid' === $icon['library'] ) {
                $icon['library'] = 'fa-solid';
            }
            $svg = class_exists( 'RoyalAddons\Elementor\Royal_Helpers' ) ? \RoyalAddons\Elementor\Royal_Helpers::get_svg_by_icon( $icon ) : '';
            if ( ! empty( $svg ) ) {
                echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
            }
        }
    }

    protected function render_list_icon( $item ) {
        if ( ! empty( $item['item_icon']['value'] ) ) {
            $icon = $item['item_icon'];
            if ( empty( $icon['library'] ) || 'solid' === $icon['library'] ) {
                $icon['library'] = 'fa-solid';
            }
            $svg = class_exists( 'RoyalAddons\Elementor\Royal_Helpers' ) ? \RoyalAddons\Elementor\Royal_Helpers::get_svg_by_icon( $icon ) : '';
            if ( ! empty( $svg ) ) {
                echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
            }
        }
    }

    protected function number() {
		$settings = $this->get_settings();
		$number = $settings['number'];

        if (empty($number)) {
            return;
        }

		?>
		<span class="servicenumber"><?php echo esc_html( $number ); ?></span>
		<?php
	}

    protected function imageoricon() {
		$settings    = $this->get_settings();
        $imageoricon = ! empty( $settings['imageoricon'] ) ? $settings['imageoricon'] : 'icon';
		if($imageoricon == "image"){
            $img = ! empty( $settings['image']['url'] ) ? esc_url( $settings['image']['url'] ) : '';
            if ( ! empty( $img ) ) {
                echo '<div class="imageoricon"><img src="' . $img . '" alt=""></div>';
            }
        } elseif ( $imageoricon == "letter" ) {
            $char = ( isset( $settings['letter_char'] ) && '' !== trim( (string) $settings['letter_char'] ) ) ? trim( (string) $settings['letter_char'] ) : '1';
            echo '<div class="imageoricon"><span class="royal-letter-icon">' . esc_html( $char ) . '</span></div>';
        } else {
            if ( ! empty( $settings['icon']['value'] ) ) {
                $icon = $settings['icon'];
                if ( empty( $icon['library'] ) || 'solid' === $icon['library'] ) {
                    $icon['library'] = 'fa-solid';
                }
                echo '<div class="imageoricon">';
                $svg = class_exists( 'RoyalAddons\Elementor\Royal_Helpers' ) ? \RoyalAddons\Elementor\Royal_Helpers::get_svg_by_icon( $icon ) : '';
                if ( ! empty( $svg ) ) {
                    echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                } else {
                    Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
                }
                echo '</div>';
            }
        } 
	}

    protected function title() {
		$settings = $this->get_settings();
		$title = $settings['title'];
        $titlelink = $settings[ 'titlelink' ][ 'url' ];

        if (empty($title)) {
            return;
        }
        $titletarget        = $settings[ 'titlelink' ][ 'is_external' ] ? ' target="_blank"' : '';
        $titlenofollow      = $settings[ 'titlelink' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
		
        if (empty($titlelink)) {
        ?>
        <div class="servicestitlebox"><h3 class="servicetitle"><?php echo esc_html( $title ); ?></h3></div>
        <?php } else{ ?>
            <div class="servicestitlebox"><h3 class="servicetitle"><a href="<?php echo esc_url( $titlelink ); ?>" <?php echo $titletarget; ?> <?php echo $titlenofollow; ?>><?php echo esc_html( $title ); ?></a></h3></div>
        <?php }
        ?>
		
		<?php
	}


    protected function description() {
		$settings = $this->get_settings();
		$description = $settings['description'];

        if (empty($description)) {
            return;
        }

		?>
		<p class="servicedescription"><?php echo wp_kses_post( $description ); ?></p>
		<?php
	}
 

    protected function readmore() {
		$settings = $this->get_settings();
		$readmore = $settings['readmore'];
        $readmorelink = $settings[ 'readmorelink' ][ 'url' ];

        if (empty($readmore)) {
            return;
        }
        $readmoretarget        = $settings[ 'readmorelink' ][ 'is_external' ] ? ' target="_blank"' : '';
        $readmorenofollow      = $settings[ 'readmorelink' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
		
        if (empty($readmorelink)) {
        ?>
        <p class="linkbtn"><?php echo $readmore; ?></p>
        <?php } else{ ?>
            <a href="<?php echo $readmorelink; ?>" <?php echo $readmoretarget; ?> <?php echo $readmorenofollow; ?> class="linkbtn"><?php echo $readmore; ?></a>
        <?php }
        ?>
		
		<?php
	}







}
