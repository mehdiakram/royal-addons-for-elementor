<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use RoyalAddons\Elementor\Royal_Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalTestimonialCarousel extends Widget_Base {

    public function get_name() {
        return  'royaltestimonialcarousel';
    }

    public function get_title() {
        return esc_html__( 'Testimonial Carousel', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-testimonial-carousel rtbranding'; }

	public function get_keywords() {
		return ['slide', 'team', 'testimonial', 'carousel', 'animated', 'image', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return [ 'royaltech' ];
    }


	public function get_style_depends() {
		$styles = ['royalowlcarousel', 'royalowlcarouseltheme' ,'royalcarousel'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalowlcarousel', 'royalcarousel'];
		return $scripts;
	}


    public function register_controls() {
		$this->rt_content_query_options();
		Royal_Helpers::royal_carousel_options( $this );

        $this->rt_style_item_options();
        $this->rt_style_content_options();
        $this->rt_style_infobox_options();
        $this->rt_style_name_options();
        $this->rt_style_title_options();
        $this->rt_style_star_options();
        $this->rt_style_quote_options();
        $this->rt_style_image_options();
        
        $this->rt_style_navigation_options();
    }

    private function rt_content_query_options() {
        // Content Settings
        $this->start_controls_section(
            'content_settings',
            [
                'label' => __( 'Content', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );    

        $this->add_control(
            'layout',
            [
                'label' => __( 'Layout', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'layout1' 	=> 'Layout 1',
                    'layout2'   => 'Layout 2',
                    'layout3' 	=> 'Layout 3',
                    'layout4' 	=> 'Layout 4',					
                    'layout5' 	=> 'Layout 5',
                    'layout6'   => 'Layout 6 Slider',
                    'layout7'   => 'Layout 7 Team',
                    'layout8'   => 'Layout 8',
                    'layout9'   => 'Layout 9',
                    'layout10'  => 'Layout 10 Simple',
                    'layout11'  => 'Layout 11',
                    'layout12'  => 'Layout 12 Slider',
                ],
                'default' => 'layout1',
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'image',
            [
                'label' => __( 'Image', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => __( 'Content', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Royal Technologies provided the most prompt quote of three requested for website design, communicated well during the project, and provided a well-designed website with an easy to use content management system.',
                'label_block' => true
            ]
        );              
        $repeater->add_control(
            'name',
            [
                'label' => __( 'Name', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'S M Mehdi Akram', 'royal-addons-for-elementor' ),
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'CEO', 'royal-addons-for-elementor' ),
                'label_block' => true
            ]
        );

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'starratings',
			[
				'label' => esc_html__( 'Star Ratings', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
                
				'size_units' => [ '%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
			]
		);

        $this->add_control(
            'slides',
            [
                'label' => __( 'Slides', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'content'=> 'Royal Technologies provided the most prompt quote of three requested for website design, communicated well during the project, and provided a well-designed website with an easy to use content management system.',
                        'name'   => 'S M Mehdi Akram',
                        'title' => __('CEO, Royal Group', 'royal-addons-for-elementor'),
                    ],
                    [
                        'content'=> 'As usual very helpful, nothing to much trouble and the end result as I envisaged. Good price point, you pay for what you get and Fluid are full value for money.',
                        'name'   => 'Kh Hasanuzzaman',
                        'title' => __('Owner, Dania Machineries', 'royal-addons-for-elementor'),
                    ],       
                    [
                        'content'=> 'Very grateful to Royal Technologies for all the hard work they put into our website, finished product was fantastic. Jessie is such a pleasure to work with, would recommend them!',
                        'name'   => 'Md. Masud Rana',
                        'title' => __('CTO, One Solutions', 'royal-addons-for-elementor'),
                    ],                                 
                ],
                'title_field' => '{{{ name }}}',
            ]
        );       

        $this->add_control(
            'showarrow',
            [
                'label' => __( 'Arrow', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [
					'layout' => ['layout1', 'layout2' , 'layout3', 'layout4', 'layout5'],
				],	                
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'showarrow',
                'default' => 'showarrow',
            ]
        );

		$this->add_control(
			'arrowposition',
			[
				'label' => esc_html__( 'Arrow Position', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
                    'showarrow' => ['showarrow'],
                    'layout' => ['layout1', 'layout2' , 'layout3', 'layout4', 'layout5'],
				],				
				'size_units' => ['%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .layout1 .showarrow::after' => 'left: calc({{SIZE}}{{UNIT}} - 25px);',
					'{{WRAPPER}} .royaltestimonialcarousel .layout2 .showarrow::after' => 'left: calc({{SIZE}}{{UNIT}} - 25px);',
					'{{WRAPPER}} .royaltestimonialcarousel .layout3 .showarrow::after' => 'top: calc({{SIZE}}{{UNIT}} - 25px);',
					'{{WRAPPER}} .royaltestimonialcarousel .layout4 .showarrow::after' => 'left: calc({{SIZE}}{{UNIT}} - 25px);',

				],
			]
		);		


        $this->add_control(
            'quotebefore',
            [
                'label' => __( 'Quote Before', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'layout' => ['layout1', 'layout2', 'layout3', 'layout4', 'layout5'],
				],	
                'default' => '“',
                'label_block' => true
            ]
        );               

        $this->add_control(
            'quoteafter',
            [
                'label' => __( 'Quote After', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'layout!' => ['layout6', 'layout7', 'layout9', 'layout10'],
				],	
                'default' => '„',
                'label_block' => true
            ]
        );   
      


		$this->add_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'separator'=> 'before',		
				'condition' => [
					'layout' => ['layout1', 'layout2', 'layout3', 'layout4', 'layout5', 'layout8', 'layout9', 'layout11'],
				],	                		
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .item' => 'align-items: {{VALUE}};',
				],
			]
		);
       
        $this->add_control(
            'showratings',
            [
                'label' => __( 'Show Ratings', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [
					'layout' => ['layout3', 'layout4', 'layout5', 'layout8', 'layout9', 'layout11'],
				],	                
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'show',
                'default' => 'show',
            ]
        );

    $this->end_controls_section();
    }




	private function rt_style_item_options() {
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => __( 'Item', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


        $this->add_control(
            'item_background',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Background', 'royal-addons-for-elementor' ),
              'default'	=> '#ffffff',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .owl-item' => 'background-color: {{VALUE}};',
              ],
            ]
          );

        $this->add_control(
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .owl-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],                    
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .owl-item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);  


        $this->start_controls_tabs(
            'style_item_border_tabs'
        );
        
        $this->start_controls_tab(
            'style_item_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .royaltestimonialcarousel .owl-item',
			]
		);        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_item_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_border_hover',
				'selector' => '{{WRAPPER}} .royaltestimonialcarousel .owl-item:hover',
			]
		);        
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    
    
    }
    


	private function rt_style_content_options() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'content_height',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .content' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'content_typo',
              'label' => __( 'Typography', 'royal-addons-for-elementor' ),
			  'global' => [
				'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
			  ],
              'selector' => '{{WRAPPER}} .royaltestimonialcarousel .content',
            ]
          );

		$this->add_control(
			'content_alignment',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],                    
				],
				'separator'=> 'before',               		
				'default' => 'center',
				'condition' => [
					'layout' => ['layout1', 'layout2', 'layout4', 'layout5', 'layout8', 'layout9', 'layout10', 'layout11'],
				],	                 
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .content' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'content_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Color', 'royal-addons-for-elementor' ),
              'default'	=> '#000',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .content' => 'color: {{VALUE}};',
              ],
            ]
          );

          $this->add_control(
            'content_background',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Background', 'royal-addons-for-elementor' ),
              'default'	=> '#86787844',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .content' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .layout1 .showarrow::after' => 'border-top-color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .layout2 .showarrow::after' => 'border-top-color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .layout3 .showarrow::after' => 'border-right-color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .layout4 .showarrow::after' => 'border-bottom-color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .layout5 .content:before' => 'border-top-color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .layout5 .content:after' => 'border-top-color: {{VALUE}};',
              ],
            ]
          );

          $this->add_control(
			'content_margin',
			[
				'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royaltestimonialcarousel .content',
			]
		);        
        $this->end_controls_section();
    }

	private function rt_style_infobox_options() {
		$this->start_controls_section(
			'section_style_infobox',
			[
				'label' => __( 'Info Box', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => ['layout6', 'layout7'],
				],	                
			]
		);

		$this->add_control(
			'infobox_alignment',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],                    
				],
				'separator'=> 'before',               		
				'default' => 'center',
				'condition' => [
					'layout' => ['layout6', 'layout7'],
				],	                 
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .infobox' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'infobox_width',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
					'size' => 400,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .infobox' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'infobox_position_top',
			[
				'label' => esc_html__( 'Position Top', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .infobox' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->add_responsive_control(
			'infobox_position_left',
			[
				'label' => esc_html__( 'Position Left', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
					'unit' => '%',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .infobox' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'infobox_background',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Background', 'royal-addons-for-elementor' ),
              'default'	=> '#00000050',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .infobox' => 'background: {{VALUE}};',
              ],
            ]
          );

          $this->add_responsive_control(
			'infobox_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .infobox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		); 

          $this->end_controls_section();
    }


	private function rt_style_name_options() {
		$this->start_controls_section(
			'section_style_name',
			[
				'label' => __( 'Name', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'name_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Color', 'royal-addons-for-elementor' ),
              'default'	=> '#000',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .name' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .name a' => 'color: {{VALUE}};',
              ],
            ]
          );

          $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'name_typo',
              'label' => __( 'Typography', 'royal-addons-for-elementor' ),
			  'global' => [
				'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
			  ],
              'selector' => '{{WRAPPER}} .royaltestimonialcarousel .name',
            ]
          );

          $this->add_control(
			'name_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'namealignment',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				'separator'=> 'before',		
				'condition' => [
					'layout' => ['layout10'],
				],	                		
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .name' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
    }


	private function rt_style_title_options() {
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'title_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Color', 'royal-addons-for-elementor' ),
              'default'	=> '#000',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .title' => 'color: {{VALUE}};', 
                '{{WRAPPER}} .royaltestimonialcarousel .title a' => 'color: {{VALUE}};', 
              ],
            ]
          );

          $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'title_typo',
              'label' => __( 'Typography', 'royal-addons-for-elementor' ),
			  'global' => [
				'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
			  ],
              'selector' => '{{WRAPPER}} .royaltestimonialcarousel .title, {{WRAPPER}} .royaltestimonialcarousel .title a',
            ]
          );   

          $this->add_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);  


		$this->add_control(
			'titlealignment',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				'separator'=> 'before',		
				'condition' => [
					'layout' => ['layout10'],
				],	                		
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .title' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
    }


    

	private function rt_style_star_options() {
		$this->start_controls_section(
			'section_style_star',
			[
				'label' => __( 'Star', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => ['layout3', 'layout4', 'layout5', 'layout8', 'layout9', 'layout11'],
				],	                
			]
		);

        $this->add_control(
            'royalstarratings_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Non Star Color', 'royal-addons-for-elementor' ),
              'default'	=> '#cccccc',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .royalstarratings' => 'color: {{VALUE}};',
              ],
            ]
          );

          $this->add_control(
            'fillratings_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Star Color', 'royal-addons-for-elementor' ),
              'default'	=> '#e7711b',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .royalstarratings .fillratings' => 'color: {{VALUE}};',
              ],
            ]
          );

          $this->add_control(
			'royalstarratings_fontsize',
			[
				'label' => esc_html__( 'Star Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
                        'step' => .1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .royalstarratings' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }




	private function rt_style_quote_options() {
		$this->start_controls_section(
			'section_style_quote',
			[
				'label' => __( 'Quote', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => ['layout1', 'layout2', 'layout3', 'layout4', 'layout5', 'layout8', 'layout11'],
				],				
			]
		);

        $this->add_control(
            'quote_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Color', 'royal-addons-for-elementor' ),
              'default'	=> '#000',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .quoteafter' => 'color: {{VALUE}};',
              ],
            ]
        );

        $this->add_control(
            'quote_bg_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Background', 'royal-addons-for-elementor' ),
              'default'	=> '#97187D',
              'condition' => [
                'layout' => ['layout8'],
            ],	               
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .quoteafter' => 'background: {{VALUE}};',
              ],
            ]
        );

        $this->add_control(
			'quote_fontsize',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 50,
                        'step' => .1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .quotebefore' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royaltestimonialcarousel .quoteafter' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'quotebefore_position',
			[
				'label' => esc_html__( 'Quote Before Position', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .quotebefore' => 'top: {{TOP}}{{UNIT}};  left:{{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'quoteafter_position',
			[
				'label' => esc_html__( 'Quote After Position', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .quoteafter' => 'right:{{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }

	private function rt_style_image_options() {
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Image Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 700,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__( 'Image Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .image img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],                    
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .image img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);  

        $this->add_control(
			'image_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		); 

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royaltestimonialcarousel .image img',
			]
		);

        $this->add_control(
			'image_box_padding',
			[
				'label' => esc_html__( 'Image Box Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);  
        
        $this->add_control(
			'image_box_margin',
			[
				'label' => esc_html__( 'Image Box Margin', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);  


		$this->add_control(
			'imagealignment',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'separator'=> 'before',		
				'condition' => [
					'layout' => ['layout10'],
				],	                		
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .item .image' => 'justify-content: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
    }

	private function rt_style_navigation_options() {
		$this->start_controls_section(
			'section_navigation',
			[
				'label' => __( 'Navigation', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nav_options',
			[
				'label' => esc_html__( 'Nav Options', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'nav_dev_size',
			[
				'label'     => __( 'Nav Dev height & width', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_size',
			[
				'label'     => __( 'Nav Size', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Color', 'royal-addons-for-elementor' ),
				'default'	=> '#869791',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Color Hover', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button:hover i' => 'color: {{VALUE}};',
				],
			]
		);	
		
		$this->add_control(
			'nav_radius',
			[
				'label'     => __( 'Nav Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_control(
			'nav_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Background', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff00',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'background-color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_control(
			'nav_background_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Background Hover', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);	
		

		$this->add_control(
			'nav_whole_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Whole Background', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff00',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button' => 'background-color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_control(
			'nav_whole_background_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Whole Background Hover', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff00',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);	
	


		$this->add_control(
			'dot_options',
			[
				'label' => esc_html__( 'Dot Options', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);		
		$this->add_control(
			'dot_size',
			[
				'label'     => __( 'Dot Size', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .royalcarouseldotinsidecenter.owl-carousel .owl-dots .owl-dot' => 'width: calc({{SIZE}}{{UNIT}} + 10px); height: calc({{SIZE}}{{UNIT}} + 10px);',
				],
			]
		);

		$this->add_control(
			'dot_radius',
			[
				'label'     => __( 'Dot Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot span' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'dot_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Dot Color', 'royal-addons-for-elementor' ),
				'default'	=> '#869791',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_color_active',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Active Dot Color', 'royal-addons-for-elementor' ),
				'default'	=> '#dddddd',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}


    protected function render() {
		$settings 		= $this->get_settings_for_display();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $loop           = $settings['loop'];
        $autoplay       = $settings['autoplay'];
        $margin         = $settings['margin'];
        $timeout        = $settings['timeout'];
        $navposition    = $settings['navposition'];
        $dotposition    = $settings['dotposition'];
		
        $previous_icon_html = '';
        $next_icon_html = '';
        if ( isset( $settings['previousicon']['value'] ) && ! empty( $settings['previousicon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['previousicon'], [ 'aria-hidden' => 'true' ] );
            $previous_icon_html = ob_get_clean();
        }

        if ( isset( $settings['nexticon']['value'] ) && ! empty( $settings['nexticon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['nexticon'], [ 'aria-hidden' => 'true' ] );
            $next_icon_html = ob_get_clean();
        }
        $navtext = json_encode( [ $previous_icon_html, $next_icon_html ] );


        $desktopitems   = $settings['desktopitems'];
        if ( 'yes' === $settings['desktopdots'] ) {
			$desktopdots = 'true';
		} else{
            $desktopdots = 'false';
        } 
        if ( 'yes' === $settings['desktopnav'] ) {
			$desktopnav = 'true';
		} else{
            $desktopnav = 'false';
        }           


        $tabitems       = $settings['tabitems'];
        if ( 'yes' === $settings['tabdots'] ) {
			$tabdots = 'true';
		} else{
            $tabdots = 'false';
        }
        if ( 'yes' === $settings['tabnav'] ) {
			$tabnav = 'true';
		} else{
            $tabnav = 'false';
        }                     


        $mobileitems    = $settings['mobileitems'];
        if ( 'yes' === $settings['mobiledots'] ) {
			$mobiledots = 'true';
		} else{
            $mobiledots = 'false';
        } 
        if ( 'yes' === $settings['mobilenav'] ) {
			$mobilenav = 'true';
		} else{
            $mobilenav = 'false';
        } 

        $this->add_render_attribute(
            'royal_carousel_options',
            [
                'id'                	=> $carouselid,
                'data-loop'         	=> $loop,
                'data-autoplay'     	=> $autoplay,
                'data-margin'       	=> $margin,
                'data-autoplayTimeout'	=> $timeout,
                'data-navtext'   		=> $navtext,	

                'data-desktopitems' 	=> $desktopitems,
                'data-desktopdots'  	=> $desktopdots,
                'data-desktopnav'   	=> $desktopnav,

                'data-tabitems'     	=> $tabitems,
				'data-tabdots'  		=> $tabdots,
                'data-tabnav'   		=> $tabnav,

                'data-mobileitems'  	=> $mobileitems,
                'data-mobiledots'  		=> $mobiledots,
                'data-mobilenav'   		=> $mobilenav,	
			
            ]
        );
 
    echo '<div class="royalmastercarousel">';
    echo '<div class="royalcarousel royaltestimonialcarousel owl-carousel owl-theme '.$navposition.' '.$dotposition.'" '.$this->get_render_attribute_string( 'royal_carousel_options' ).'>';
        foreach( $settings[ 'slides' ] as $slide ):
           // $image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src($slide['image']['id'], 'thumbnail', $slide);
           
           if($slide['image']['id']){
            $img_atts = wp_get_attachment_image_src($slide['image']['id'], 'medium');
            $image_url = $img_atts[0];

            $img_atts_full = wp_get_attachment_image_src($slide['image']['id'], 'full');
            $imagefull = $img_atts_full[0]; 

           } else {
            $image_url = $slide['image']['url'];
            $imagefull = $slide['image']['url'];
           }

            
            if('layout1'== $settings['layout']){
            echo '<div class="item layout1">';
                echo '<div class="content '.$settings['showarrow'].'">';
                if ( $settings['quotebefore'] ) { echo '<span class="quotebefore">'.$settings['quotebefore'].'</span>';}
                echo $slide['content'];
                if ( $settings['quoteafter'] ) { echo '<span class="quoteafter">'.$settings['quoteafter'].'</span>';}
                echo '</div>';
                echo '<div class="imagebox">';
                    echo '<div class="imageboxinner">';
                        echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                        echo '<div class="name">'.$slide['name'].',&nbsp;</div>';
                        echo '<div class="title">'.$slide['title'].'</div>';
                    echo '</div>';
                echo '</div>';
             echo '</div>'; 
                
                
            } elseif('layout2'== $settings['layout']){
            echo '<div class="item layout2">';
                echo '<div class="content '.$settings['showarrow'].'">';
                if ( $settings['quotebefore'] ) { echo '<span class="quotebefore">'.$settings['quotebefore'].'</span>';}
                echo $slide['content'];
                if ( $settings['quoteafter'] ) { echo '<span class="quoteafter">'.$settings['quoteafter'].'</span>';}
                echo '</div>';
                echo '<div class="imagebox">';
                    echo '<div class="imageboxinner">';
                        echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                        echo '<div class="nametitle">';
                        echo '<div class="name">'.$slide['name'].'</div>';
                        echo '<div class="title">'.$slide['title'].'</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
             echo '</div>';


            } elseif('layout3'== $settings['layout']){
            echo '<div class="item layout3">';
                echo '<div class="imageleft">';
                    echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                echo '</div>';
                echo '<div class="content '.$settings['showarrow'].'">';
                if ( $settings['quotebefore'] ) { echo '<span class="quotebefore">'.$settings['quotebefore'].'</span>';}
                echo $slide['content'];
                if ( $settings['quoteafter'] ) { echo '<span class="quoteafter">'.$settings['quoteafter'].'</span>';}
                echo '</div>';
                echo '<div class="name">'.$slide['name'].'</div>';
                if ($settings['showratings']=="show"){
                    echo '<div class="royalstarratings"><div class="fillratings" style="width: '. $slide['starratings']['size'] .'%"><span>★★★★★</span></div><div class="emptyratings"><span>★★★★★</span></div></div>';
                }
                echo '<div class="title">'.$slide['title'].'</div>';                    
            echo '</div>';
            

        } elseif('layout4'== $settings['layout']){
            echo '<div class="item layout4">';
            echo '<div class="imagebox">';
                echo '<div class="imageboxinner">';
                    echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                echo '</div>';
            echo '</div>';

            echo '<div class="content '.$settings['showarrow'].'">';
            if ( $settings['quotebefore'] ) { echo '<span class="quotebefore">'.$settings['quotebefore'].'</span>';}
            echo $slide['content'];
            if ( $settings['quoteafter'] ) { echo '<span class="quoteafter">'.$settings['quoteafter'].'</span>';}
            echo '</div>';
                echo '<div class="name">'.$slide['name'].'</div>';
                if ($settings['showratings']=="show"){
                    echo '<div class="royalstarratings"><div class="fillratings" style="width: '. $slide['starratings']['size'] .'%"><span>★★★★★</span></div><div class="emptyratings"><span>★★★★★</span></div></div>';
                }                    
                echo '<div class="title">'.$slide['title'].'</div>';
         echo '</div>';


        } elseif('layout5'== $settings['layout']){
            echo '<div class="item layout5">';
            echo '<div class="content">';
            if ( $settings['quotebefore'] ) { echo '<span class="quotebefore">'.$settings['quotebefore'].'</span>';}
            echo $slide['content'];
            if ( $settings['quoteafter'] ) { echo '<span class="quoteafter">'.$settings['quoteafter'].'</span>';}
            echo '</div>';
                    echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                    echo '<div class="name">'.$slide['name'].'</div>';
                    if ($settings['showratings']=="show"){
                        echo '<div class="royalstarratings"><div class="fillratings" style="width: '. $slide['starratings']['size'] .'%"><span>★★★★★</span></div><div class="emptyratings"><span>★★★★★</span></div></div>';
                    }                     
                    echo '<div class="title">'.$slide['title'].'</div>';
         echo '</div>';



        } elseif('layout6'== $settings['layout']){
            echo '<div class="item layout6">';
            echo '<div class="content">';
                echo '<div class="fullimage"><img src="' . esc_attr($imagefull) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                echo '<div class="infobox">';
                    echo '<div class="name">'.$slide['name'].'</div>';
                    echo '<div class="title">'.$slide['title'].'</div>';
                    echo '<div class="fullcontent">'.$slide['content'].'</div>';
                echo '</div>';
            echo '</div>';
            echo '</div>';

            
        } elseif('layout7'== $settings['layout']){
            echo '<div class="item layout7">';
            echo '<div class="content">';
                echo '<div class="fullimage"><img src="' . esc_attr($imagefull) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                echo '<div class="infobox">';
                    echo '<div class="name">'.$slide['name'].'</div>';
                    echo '<div class="title">'.$slide['title'].'</div>';
                    echo '<div class="fullcontent">'.$slide['content'].'</div>';
                echo '</div>';
            echo '</div>';
            echo '</div>';
       
	   
        } elseif('layout8'== $settings['layout']){
            echo '<div class="item layout8">';
                echo '<div class="quoteafter">';
                if ( $settings['quoteafter'] ) { echo '<span>'.$settings['quoteafter'].'</span>';}
                echo '</div>';
                echo '<div class="imagebox">';
                    echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                    echo '<div class="name">'.$slide['name'].'</div>';
                    echo '<div class="title">'.$slide['title'].'</div>';
                    if ($settings['showratings']=="show"){
                    echo '<div class="royalstarratings"><div class="fillratings" style="width: '. $slide['starratings']['size'] .'%"><span>★★★★★</span></div><div class="emptyratings"><span>★★★★★</span></div></div>';
                    }
                echo '</div>'; 
                echo '<div class="content">'.$slide['content'].'</div>';
             echo '</div>';


        } elseif('layout9'== $settings['layout']){
                echo '<div class="item layout9">';
                    echo '<div class="content">'.$slide['content'].'</div>';
                    echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                    if ($settings['showratings']=="show"){
                    echo '<div class="royalstarratings"><div class="fillratings" style="width: '. $slide['starratings']['size'] .'%"><span>★★★★★</span></div><div class="emptyratings"><span>★★★★★</span></div></div>';
                    }
                   ?>
                   <div class="name"><a href="<?php echo $slide['link']['url']; ?>" target="<?php echo ($slide['link']['is_external']) ? "_blank" : '' ?>" rel="<?php echo ($slide['link']['nofollow']) ? "nofollow" : '' ?>"><?php echo $slide['name']; ?></a></div>
                   <?php
                 echo '</div>';


        } elseif('layout10'== $settings['layout']){
                echo '<div class="item layout10">';
                    echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                    ?>
                    <div class="name"><a href="<?php echo $slide['link']['url']; ?>" target="<?php echo ($slide['link']['is_external']) ? "_blank" : '' ?>" rel="<?php echo ($slide['link']['nofollow']) ? "nofollow" : '' ?>"><?php echo $slide['name']; ?></a></div>
                    <?php
                    echo '<div class="title">'.$slide['title'].'</div>';
                    if ($settings['showratings']=="show"){
                        echo '<div class="royalstarratings"><div class="fillratings" style="width: '. $slide['starratings']['size'] .'%"><span>★★★★★</span></div><div class="emptyratings"><span>★★★★★</span></div></div>';
                        }                    
                    echo '<div class="content">'.$slide['content'].'</div>';
                    echo '</div>';


		} elseif('layout11'== $settings['layout']){
			echo '<div class="item layout11">';
				echo '<div class="imagebox">';
					echo '<div class="imageboxinner">';
						echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
						echo '<div class="nametitle">';
							echo '<div class="name">'.$slide['name'].'</div>';
							echo '<div class="title">'.$slide['title'].'</div>';
							if ($settings['showratings']=="show"){
							echo '<div class="royalstarratings"><div class="fillratings" style="width: '. $slide['starratings']['size'] .'%"><span>★★★★★</span></div><div class="emptyratings"><span>★★★★★</span></div></div>';
							}
						echo '</div>';
					echo '</div>';
					echo '<div class="quoteafter">';
					if ( $settings['quoteafter'] ) { echo '<span>'.$settings['quoteafter'].'</span>';}
					echo '</div>';

				echo '</div>'; 
				echo '<div class="content">'.$slide['content'].'</div>';
				echo '</div>';


        } elseif('layout12'== $settings['layout']){
            echo '<div class="item layout12">';
			echo '<div class="fullimage image"><img src="' . esc_attr($imagefull) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
            echo '<div class="content">';
                echo '<div class="infobox">';
					 echo '<div>';
					echo '<div class="name">'.$slide['name'].'</div>';
					echo '<div class="fullcontent">'.$slide['content'].'</div>';
					echo '</div>';
                    echo '<div class="title"><a href="' . esc_url( $slide['link']['url'] ) . '" target="' . ( !empty($slide['link']['is_external']) ? '_blank' : '' ) . '" rel="' . ( !empty($slide['link']['nofollow']) ? 'nofollow' : '' ) . '">' . esc_html( $slide['title'] ) . '</a></div>';					
                echo '</div>';
            echo '</div>';
            echo '</div>';










        } else {
            echo '<div class="item layout1">';
                echo '<div class="content '.$settings['showarrow'].'">';
                if ( $settings['quotebefore'] ) { echo '<span class="quotebefore">'.$settings['quotebefore'].'</span>';}
                echo $slide['content'];
                if ( $settings['quoteafter'] ) { echo '<span class="quoteafter">'.$settings['quoteafter'].'</span>';}
                echo '</div>';
                echo '<div class="imagebox">';
                    echo '<div class="imageboxinner">';
                        echo '<div class="image"><img src="' . esc_attr($image_url) . '" alt="' . esc_attr($slide['title'] ) . '" /></div>';
                        echo '<div class="name">'.$slide['name'].',&nbsp;</div>';
                        echo '<div class="title">'.$slide['title'].'</div>';
                    echo '</div>';
                echo '</div>';
             echo '</div>';
            }


        endforeach;          
    echo '</div>';
    echo '</div>';
    }













}
