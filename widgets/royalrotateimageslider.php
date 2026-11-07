<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
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


class RoyalRotateImageSlider extends Widget_Base {

    public function get_name() {
        return  'royalrotateimageslider';
    }

    public function get_title() {
        return esc_html__( 'Rotate Image Slider', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-testimonial-carousel rtbranding'; }

	public function get_keywords() {
		return ['slide', 'image', 'rotate', 'animated', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return [ 'royaltech' ];
    }


	public function get_style_depends() {
		$styles = ['royalrotateimageslider', 'jquery-ui'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalrotateimageslider', 'jquery-ui'];
		return $scripts;
	}


    public function register_controls() {
		$this->rt_content_query_options();
		Royal_Helpers::royal_carousel_options( $this );

        $this->rt_style_content_options();
        $this->rt_style_name_options();
        $this->rt_style_title_options();
        $this->rt_style_quote_options();
        $this->rt_style_image_options();
        
        Royal_Helpers::royal_style_nav_options( $this );
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
                'title_field' => '{{{ title }}}',
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
                ],
                'default' => 'layout1',
            ]
        );


        $this->add_control(
            'showarrow',
            [
                'label' => __( 'Arrow', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
				'condition' => [
					'layout!' => ['layout6'],
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
					'layout!' => ['layout6'],
                    'showarrow' => ['showarrow'],
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
					'layout!' => ['layout6'],
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
					'layout!' => ['layout6'],
				],	
                'default' => '„',
                'label_block' => true
            ]
        );   
      
		$this->add_control(
			'imageboxalignment',
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .imagebox' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .royaltestimonialcarousel .layout6 .infobox' => 'text-align: {{VALUE}};',
				],
			]
		);
       

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
              'selector' => '{{WRAPPER}} .royaltestimonialcarousel .title',
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

        $this->end_controls_section();
    }


	private function rt_style_quote_options() {
		$this->start_controls_section(
			'section_style_quote',
			[
				'label' => __( 'Quote', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'quote_color',
            [
              'type'      => Controls_Manager::COLOR,
              'label'     => __( 'Color', 'royal-addons-for-elementor' ),
              'default'	=> '#000',
              'selectors' => [
                '{{WRAPPER}} .royaltestimonialcarousel .quotebefore' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royaltestimonialcarousel .quoteafter' => 'color: {{VALUE}};',
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
					'unit' => 'em',
					'size' => 5,
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
        $this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltestimonialcarousel .image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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

        $this->end_controls_section();
    }



    protected function render() {
		$settings 		= $this->get_settings_for_display();
        $id         	= $this->get_id();


    ?>
        <div class="rotatebox">
            <div class="images"></div>
            <div class="slider"></div>
        </div>
        <script>
        jQuery.noConflict();
        (function( $ ) {
        $(document).ready(function(){
        rotate([
            "http://localhost/wordpress/wp-content/uploads/2022/03/1.jpg",
            "http://localhost/wordpress/wp-content/uploads/2022/03/2.jpg",
        ]);
        });
        })(jQuery);
        </script>
    <?php
    }
    
}