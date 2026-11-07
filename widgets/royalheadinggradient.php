<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use RoyalAddons\Controls\Group_Control_Text_Gradient;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalHeadingGradient extends Widget_Base {
	
	public function get_name() {
		return 'royalheadinggradient';
	}
	
	public function get_title() {
		return __( 'Gradient Heading', 'royal-addons-for-elementor' );
	}
	
	public function get_icon() { return 'eicon-heading rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
    }
    
    public function get_keywords() {
		return ['gradient', 'heading', 'title', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

	public function get_style_depends() {
		return [ 'royalheadinggradient' ];
    }
	
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Gradient Heading', 'royal-addons-for-elementor' ),
			]
		);

            $this->add_control(
                'gh_heading',
                [
                    'label' => __( 'Title', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => 'Royal Technologies',
                ]
            );

            $this->add_control(
                'gh_title_animation',
                [
                    'label' => __( 'Animation', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'animationhue',                   
                    'options' => [
                        'noanimation'           => 'No Animation',
                        'animationhue'          => 'Hue',
                        'animationtextshine'    => 'Text Shine',

                    ],
                    'separator' => 'before',
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'animation-name: {{VALUE}};',
                    ],                    
                ]
            );

            $this->add_control(
                'gh_speed',
                [
                    'label' => esc_html__( 'Speed', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => [
                        'gh_title_animation!' => [ 'noanimation' ],
                    ],                    
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                    'default' => 10,
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'animation-duration: {{VALUE}}s;',
                    ],                       
                ]
            );

            $this->add_control(
                'gh_title_timing_function',
                [
                    'label' => __( 'Timing Function', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'condition' => [
                        'gh_title_animation!' => [ 'noanimation' ],
                    ],                      
                    'default' => 'linear',                   
                    'options' => [
                        'linear'                => 'Linear',
                        'ease'                  => 'Case',
                        'ease-out'              => 'Case Out',
                        'ease-in'               => 'Case In',
                        'ease-in-out'           => 'Case In Out',
                        'initial'               => 'Initial',
                        'inherit'               => 'Inherit',                        
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'animation-timing-function: {{VALUE}};',
                    ],                    
                ]
            );

            $this->add_control(
                'gh_title_direction',
                [
                    'label' => __( 'Direction', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'condition' => [
                        'gh_title_animation!' => [ 'noanimation' ],
                    ],                      
                    'default' => 'normal',                   
                    'options' => [
                        'normal'                => 'Normal',
                        'reverse'               => 'Reverse',
                        'alternate'             => 'Alternate',
                        'alternate-reverse'     => 'Alternate Reverse',
                        'initial'               => 'Initial',
                        'inherit'               => 'Inherit',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'animation-direction: {{VALUE}};',
                    ],                    
                ]
            );

            $this->add_control(
                'gh_title_iteration_count',
                [
                    'label' => __( 'Iteration Count', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'condition' => [
                        'gh_title_animation!' => [ 'noanimation' ],
                    ],                      
                    'default' => 'infinite',                   
                    'options' => [
                        '1'                     => '1',
                        '2'                     => '2',
                        '3'                     => '3',
                        '4'                     => '4',
                        '5'                     => '5',
                        '6'                     => '6',
                        '7'                     => '7',
                        '8'                     => '8',
                        '9'                     => '9',
                        '10'                    => '10',
                        'infinite'              => 'Infinite',                       
                        'initial'               => 'Initial',
                        'inherit'               => 'Inherit',                        
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'animation-iteration-count: {{VALUE}};',
                    ],                    
                ]
            );


            $this->add_control(
                'gh_link',
                [
                    'label' => __( 'Link', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::URL,
                    'placeholder' => 'https://your-link.com',
                    'separator' => 'before',
                    'show_external' => true,
                    'default' => [
                        'url' => '',
                        'is_external' => true,
                        'nofollow' => true,
                    ],
                ]
            );

            $this->add_control(
                'gh_title_tag',
                [
                    'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'options'   => Royal_Helpers::royal_title_tags(),
                    'default' => 'h3',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'gh_heading_align',
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
                    'default' => 'center',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_gh_style',
            [
                'label' => __( 'Gradient Heading', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_group_control(
                Group_Control_Text_Gradient::get_type(),
                [
                    'name' => 'gh_heading_gradient',
                    'selector' => '{{WRAPPER}} .royal-gradient-heading',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'gh_heading_typography',
                    'label' => __( 'Typography', 'royal-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .royal-gradient-heading',
                ]
            );
            
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => 'gh_heading_shadow',
                    'label' => __( 'Text Shadow', 'royal-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .royal-gradient-heading',
                ]
            );

            
            $this->add_control(
                'gh_blend_mode',
                [
                    'label' => __( 'Blend Mode', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'solid',
                    'options' => [
                        'normal'  => __( 'Normal', 'royal-addons-for-elementor' ),
                        'screen' => __( 'Screen', 'royal-addons-for-elementor' ),
                        'overlay' => __( 'Overlay', 'royal-addons-for-elementor' ),
                        'darken' => __( 'Darken', 'royal-addons-for-elementor' ),
                        'color-dodge' => __( 'Color Dodge', 'royal-addons-for-elementor' ),
                        'color-burn' => __( 'Color Burn', 'royal-addons-for-elementor' ),
                        'hard-light' => __( 'Hard Light', 'royal-addons-for-elementor' ),
                        'soft-light' => __( 'Soft Light', 'royal-addons-for-elementor' ),
                        'difference' => __( 'Difference', 'royal-addons-for-elementor' ),
                        'exclusion' => __( 'Exlusion', 'royal-addons-for-elementor' ),
                        'hue' => __( 'Hue', 'royal-addons-for-elementor' ),
                        'saturation' => __( 'Saturation', 'royal-addons-for-elementor' ),
                        'color' => __( 'Color', 'royal-addons-for-elementor' ),
                        'luminosity' => __( 'Luminosity', 'royal-addons-for-elementor' ),
                    ],
                    'default' => 'normal',
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'mix-blend-mode: {{VALUE}}'
                    ],
                ]
            );


            $this->add_control(
                'background_size',
                [
                    'label' => esc_html__( 'Background Size', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'background-size: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'background_position',
                [
                    'label' => esc_html__( 'Background Position', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -1000,
                            'max' => 1000,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-gradient-heading' => 'background-position: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
	}
	
	protected function render() {
        $settings = $this->get_settings_for_display();
        
            if ( $settings['gh_link']['url'] == "" ) {
                echo '<' . $settings['gh_title_tag'] . ' class="royal-gradient-heading">' . $settings['gh_heading'] . '</' . $settings['gh_title_tag'] . '>';
            } else {
                $target = $settings['gh_link']['is_external'] ? ' target="_blank"' : '';
                $nofollow = $settings['gh_link']['nofollow'] ? ' rel="nofollow"' : '';

                echo '<' . $settings['gh_title_tag'] . ' class="royal-gradient-heading">';
                echo '<a href="' . $settings['gh_link']['url'] . '" ' . $target . ' ' . $nofollow .'>';
                echo wp_kses_post( $settings['gh_heading'] );
                echo '</a></' . $settings['gh_title_tag'] . '>';
            }
        ?>
        <?php
	}
	
}
