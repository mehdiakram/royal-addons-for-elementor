<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class RoyalImageCompare2 extends Widget_Base {

	public function get_name() {
		return 'royalimagecompare2';
	}

	public function get_title() {
		return esc_html__( 'Image Compare2', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-image-before-after rtbranding'; }

	public function get_categories() {
		return [ 'royaltech'];
	}


    public function get_keywords() {
        return [ 'compare', 'image', 'before', 'after', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_style_depends() {
		$styles = [ 'royalimagecomparison' ];
		return $styles;
	}


    public function get_script_depends() {
        return [
            'jquery-event-move',
            'twentytwenty',
            'imagesloaded',
            'royalimagecomparison'
        ];
    }


	protected function register_controls() {

		$this->start_controls_section(
			'royal_image_comparison_section_start',
			[
				'label' => esc_html__( 'Images', 'royal-addons-for-elementor' )
			]
		);



        $this->start_controls_tabs( 'royal_image_comparison_tab_images' );
        $this->start_controls_tab(
            'royal_image_comparison_tab_before_image',
            [
                'label' => esc_html__( 'Before', 'royal-addons-for-elementor' ),
            ]
		);


		$this->add_control(
			'royal_image_comparison_before_image',
			array(
				'label'      => esc_html__('Before image','royal-addons-for-elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false
			)
		);

        $this->add_control(
            'royal_image_comparison_before_label',
            [
                'label' => esc_html__( 'Label', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Before', 'royal-addons-for-elementor' ),
                'placeholder' => esc_html__( 'Before Label', 'royal-addons-for-elementor' ),
				'description' => esc_html__( 'Show/Hide Labels on Overlay Settings', 'royal-addons-for-elementor' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
		);
        $this->end_controls_tab();


        $this->start_controls_tab(
            'royal_image_comparison_tab_after_image',
            [
                'label' => esc_html__( 'After', 'royal-addons-for-elementor' ),
            ]
		);

		$this->add_control(
			'royal_image_comparison_after_image',
			array(
				'label'      => esc_html__('After Image','royal-addons-for-elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false
			)
		);

        $this->add_control(
            'royal_image_comparison_after_label',
            [
                'label' 		=> esc_html__( 'Label', 'royal-addons-for-elementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'default' 		=> esc_html__( 'After', 'royal-addons-for-elementor' ),
                'placeholder' 	=> esc_html__( 'After Label', 'royal-addons-for-elementor' ),
                'description' 	=> esc_html__( 'Show/Hide Labels on Overlay Settings', 'royal-addons-for-elementor' ),
                'dynamic' 		=> [
                    	'active' => true,
                ]
            ]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'full',
				'separator' => 'before',
				'exclude'    => array( 'custom' ),
            ]
		);

		$this->end_controls_section();




		$this->start_controls_section(
			'royal_image_comparison_section',
			array(
				'label' => esc_html__( 'Settings', 'royal-addons-for-elementor' )
			)
		);

        $this->add_control(
			'royal_image_comparison_visible_ratio',
            [
                'label'   		=> esc_html__( 'Visible Ratio (%)', 'royal-addons-for-elementor' ),
				'type'          => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'style_transfer' => true
            ]
		);

		$this->add_control(
            'royal_image_comparison_orientation',
            [
                'label' 		=> esc_html__( 'Orientation', 'royal-addons-for-elementor' ),
                'type' 			=> Controls_Manager::CHOOSE,
                'label_block' 	=> false,
                'options' 		=> [
                    'horizontal' 	=> [
							'title' 	=> esc_html__( 'Horizontal', 'royal-addons-for-elementor' ),
							'icon' 		=> 'eicon-h-align-center',
                    ],
                    'vertical' 		=> [
                        'title' 		=> esc_html__( 'Vertical', 'royal-addons-for-elementor' ),
                        'icon' 			=> 'eicon-v-align-middle',
                    ],
                ],
                'default' 		 => 'horizontal',
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'royal_image_comparison_overlay',
            [
				'label' 		    => esc_html__( 'Overlay', 'royal-addons-for-elementor' ),
				'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'         => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value'      => 'yes',
                'description' 	    => esc_html__( 'Show/Hide overlay with before and after label', 'royal-addons-for-elementor' ),
                'style_transfer'    => true,
            ]
		);


		$this->end_controls_section();



        /**
		 * General Style Section
		 */
		 $this->start_controls_section(
			'royal_image_comparison_general_style',
			array(
				'label'      => esc_html__( 'Layout Style', 'royal-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'royal_image_comparison_container_border',
				'label'       => esc_html__( 'Border', 'royal-addons-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} .royal-image-comparison',
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-image-comparison' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_container_margin',
			array(
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-image-comparison' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();





        /**
         * Style Tab: Overlay
         */
		 $this->start_controls_section(
            'royal_image_comparison_section_overlay_style',
            [
                'label'             => esc_html__( 'Overlay', 'royal-addons-for-elementor' ),
                'tab'               => Controls_Manager::TAB_STYLE,
				'condition'         => [
					'royal_image_comparison_overlay'  => 'yes',
				],
            ]
        );

        $this->start_controls_tabs( 'royal_image_comparison_tabs_overlay_style' );

        $this->start_controls_tab(
            'royal_image_comparison_tab_overlay_normal',
            [
                'label'             => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'royal_image_comparison_overlay_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .twentytwenty-overlay',
				'condition'         => [
					'royal_image_comparison_overlay'  => 'yes',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'royal_image_comparison_tab_overlay_hover',
            [
                'label'             => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'royal_image_comparison_overlay_background_hover',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .twentytwenty-overlay:hover',
				'condition'         => [
					'royal_image_comparison_overlay'  => 'yes',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();





        /**
         * Style Tab: Handle
         */
		 $this->start_controls_section(
            'royal_image_comparison_section_handle_style',
            [
                'label'             => esc_html__( 'Handle', 'royal-addons-for-elementor' ),
                'tab'               => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'royal_image_comparison_heading_bar',
            [
                'label' => esc_html__( 'Handle Bar', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'royal_image_comparison_handle_color',
            [
                'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-handle:after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .twentytwenty-handle' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}}',
                    '{{WRAPPER}} .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}}',
                    '{{WRAPPER}} .twentytwenty-handle:before' =>
                        '-webkit-box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);'
                        . '-moz-box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);'
                        . 'box-shadow: 0 3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);',
                    '{{WRAPPER}} .twentytwenty-handle:after' =>
                        '-webkit-box-shadow: 0 -3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);'
                        . '-moz-box-shadow: 0 -3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);'
                        . 'box-shadow: 0 -3px 0 {{VALUE}}, 0px 0px 12px rgba(51, 51, 51, 0.5);',
                ],
            ]
		);

        $this->add_responsive_control(
            'royal_image_comparison_handle_bar_size',
            [
                'label' => esc_html__( 'Size', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after' => 'width: {{SIZE}}{{UNIT}}; margin-left: calc(-0px - {{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after' => 'height: {{SIZE}}{{UNIT}}; margin-top: calc(-0px - {{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );




        $this->add_control(
            'royal_image_comparison_heading_bar_indicator',
            [
                'label' => esc_html__( 'Handle Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'royal_image_comparison_arrow_box_width',
            [
                'label' => esc_html__( 'Box Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-handle' => 'width: {{SIZE}}{{UNIT}}; margin-left: calc(-1 * ({{SIZE}}{{UNIT}} / 2));',
                    '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before' => 'margin-left: calc(({{SIZE}}{{UNIT}} / 2) - 1px);',
                    '{{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after' => 'margin-right: calc(({{SIZE}}{{UNIT}} / 2) - 1px);',
                ],
            ]
        );
        $this->add_responsive_control(
            'royal_image_comparison_arrow_box_height',
            [
                'label' => esc_html__( 'Box Height', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .twentytwenty-handle' => 'height: {{SIZE}}{{UNIT}}; margin-top: calc(-1 * ({{SIZE}}{{UNIT}} / 2));',
                    '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before' => 'margin-bottom: calc(({{SIZE}}{{UNIT}} / 2) + 2px);',
                    '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after' => 'margin-top: calc(({{SIZE}}{{UNIT}} / 2) + 2px);',
                ],
            ]
        );



        $this->start_controls_tabs( 'royal_image_comparison_tabs_handle_style' );

        $this->start_controls_tab(
            'royal_image_comparison_tab_handle_normal',
            [
                'label'             => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'royal_image_comparison_handle_icon_color',
            [
                'label'             => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#4b00e7',
                'selectors'         => [
                    '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}}',
                    '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}}',
                    '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle .twentytwenty-down-arrow' => 'border-top-color: {{VALUE}}',
                    '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle .twentytwenty-up-arrow' => 'border-bottom-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'royal_image_comparison_handle_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'              => 'royal_image_comparison_handle_border',
				'label'             => esc_html__( 'Border', 'royal-addons-for-elementor' ),
				'placeholder'       => '1px',
				'default'           => '1px',
				'selector'          => '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle',
				'separator'         => 'before',
			]
		);

		$this->add_control(
			'royal_image_comparison_handle_border_radius',
			[
				'label'             => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => [ 'px', '%' ],
				'selectors'         => [
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-handle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'royal_image_comparison_handle_box_shadow',
				'selector'              => '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'royal_image_comparison_tab_handle_hover',
            [
                'label'             => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'royal_image_comparison_handle_icon_color_hover',
            [
                'label'             => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle:hover .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}}',
                    '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle:hover .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'royal_image_comparison_handle_background_hover',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle:hover',
			]
		);

        $this->add_control(
            'royal_image_comparison_handle_border_color_hover',
            [
                'label'             => esc_html__( 'Border Color', 'royal-addons-for-elementor' ),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .royal-image-comparison .twentytwenty-handle:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();



		/**
		 * Label Style Section
		 */
		 $this->start_controls_section(
			'royal_image_comparison_label_style',
			array(
				'label'      => esc_html__( 'Label', 'royal-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => ['royal_image_comparison_overlay' => 'yes'],
			)
		);

		$this->start_controls_tabs( 'royal_image_comparison_tabs_label_styles' );

		$this->start_controls_tab(
			'royal_image_comparison_tab_label_before',
			array(
				'label' => esc_html__( 'Before', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_before_label_color',
			array(
				'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-before-label:before' => 'color: {{VALUE}}',
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'royal_image_comparison_before_label_typography_group',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
				'selector' => '{{WRAPPER}} .royal-image-comparison .twentytwenty-before-label:before',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'royal_image_comparison_before_label_background_group',
				'selector' => '{{WRAPPER}} .royal-image-comparison .twentytwenty-before-label:before',
			)
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'royal_image_comparison_before_label_border',
				'label'       => esc_html__( 'Border', 'royal-addons-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} .twentytwenty-before-label:before',
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_before_label_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);


		$this->add_responsive_control(
			'royal_image_comparison_before_label_margin',
			array(
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-before-label:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_before_label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-before-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'royal_image_comparison_tab_label_after',
			array(
				'label' => esc_html__( 'After', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_after_label_color',
			array(
				'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'royal_image_comparison_after_label_typography_group',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				  ],
				'selector' => '{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'royal_image_comparison_after_label_background_group',
				'selector' => '{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before',
			)
		);



		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'royal_image_comparison_after_label_border',
				'label'       => esc_html__( 'Border', 'royal-addons-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before',
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_after_label_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);


		$this->add_responsive_control(
			'royal_image_comparison_after_label_margin',
			array(
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'royal_image_comparison_after_label_padding',
			array(
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-image-comparison .twentytwenty-after-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();




	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$id       = 'royal-image-comparison-' . $this->get_id();

		$this->add_render_attribute(
			[
				'royal_image_comparison' => [
					'id'    => esc_attr( $id ),
					'class' => implode(' ', [
						'twentytwenty-container',
						'royal-image-comparison',
						'royal-image-comparison-' . esc_attr( $this->get_id()),
					]),
					'data-image-comparison-settings' => [
						wp_json_encode(array_filter([
							"container_id"          =>  esc_attr( $this->get_id()),
							'visible_ratio'         => ( $settings['royal_image_comparison_visible_ratio']['size'] != '' ? $settings['royal_image_comparison_visible_ratio']['size']/100 : '0.5' ),
							'orientation'           => ( $settings['royal_image_comparison_orientation'] != '' ? $settings['royal_image_comparison_orientation'] : 'horizontal' ),
							'before_label'          => ( $settings['royal_image_comparison_before_label'] != '' ? esc_attr( $settings['royal_image_comparison_before_label'] ) : '' ),
							'after_label'           => ( $settings['royal_image_comparison_after_label'] != '' ? esc_attr( $settings['royal_image_comparison_after_label'] ) : '' ),
							'no_overlay'            => ( $settings['royal_image_comparison_overlay'] == 'yes' ? false : true )
						]))
					]
				]
			]
		); ?>

        <div <?php echo $this->get_render_attribute_string( 'royal_image_comparison' ); ?>>
            <?php if ( $settings['royal_image_comparison_before_image']['url'] || $settings['royal_image_comparison_before_image']['id'] ) :
                $this->add_render_attribute( 'royal_before_image', 'src', $settings['royal_image_comparison_before_image']['url'] );
                $this->add_render_attribute( 'royal_before_image', 'alt', Control_Media::get_image_alt( $settings['royal_image_comparison_before_image'] ) );
                $this->add_render_attribute( 'royal_before_image', 'title', Control_Media::get_image_title( $settings['royal_image_comparison_before_image'] ) );
				echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'royal_image_comparison_before_image' );
            endif;

            if ( $settings['royal_image_comparison_after_image']['url'] || $settings['royal_image_comparison_after_image']['id'] ) :
                $this->add_render_attribute( 'royal_after_image', 'src', $settings['royal_image_comparison_after_image']['url'] );
                $this->add_render_attribute( 'royal_after_image', 'alt', Control_Media::get_image_alt( $settings['royal_image_comparison_after_image'] ) );
                $this->add_render_attribute( 'royal_after_image', 'title', Control_Media::get_image_title( $settings['royal_image_comparison_after_image'] ) );
                echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'royal_image_comparison_after_image' );
            endif; ?>
        </div>

        <?php

	}

   
}