<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalContactForm7 extends Widget_Base {

    public function get_name() {
        return 'royalcontactform7';
    }


    public function get_title() {
        return __( 'Contact Form 7', 'royal-addons-for-elementor' );
    }


    public function get_icon() { return 'eicon-mail rtbranding'; }


	public function get_keywords() {
		return [ 'royal', 'contact', 'form', '7', 'cf7', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
  
  
    public function get_categories() {
        return array( 'royaltech_3rdparty' );
    }


	public function get_style_depends() {
		$styles = ['royalcontactform7'];
		return $styles;
	}
    
	
    protected function register_controls() {
		if ( post_type_exists( 'wpcf7_contact_form' ) ) {
		$this->rt_cf7_general_section();
		$this->rt_cf7_style_section_general();
		$this->rt_cf7_style_section_input();
		$this->rt_cf7_style_section_textarea();
		$this->rt_cf7_style_section_label();
		$this->rt_cf7_style_section_button();
		$this->rt_cf7_style_section_after_submit();
		} else {
			$this->wpcf7_not_found();
		}		
	}


	private function wpcf7_not_found() {

		$this->start_controls_section(
			'section_not_found',
			[
				'label' => esc_html__( 'Live Visitor Counter not found', 'royal-addons-for-elementor' ),
			]
		);	 
		
		$this->add_control(
			'plugin_not_activated',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => sprintf(
					'<strong>%s</strong> %s <a href="plugin-install.php?s=Contact-Form-7&tab=search&type=term" target="_blank">%s</a> %s',
					__( 'Contact Form 7', 'royal-addons-for-elementor' ),
					__( 'is not installed/activated on your site. Please install and activate.', 'royal-addons-for-elementor' ),
					__( 'Contact Form 7', 'royal-addons-for-elementor' ),
					__( ' first.', 'royal-addons-for-elementor' )
				),
			]
		);
		$this->add_control(
			'wp_repository_plugin_link',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => '<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank"><strong>Contact Form 7</strong></a> in wordpress plugin repository.',
			]
		);		
		$this->end_controls_section();
	}

	private function rt_cf7_general_section() {
        $this->start_controls_section(
            'rt_cf7_section_selection',
            [
                'label' => __( 'Contact Form 7', 'royal-addons-for-elementor' ),
            ]
        );


        $this->add_control(
            'royalcf7',
            [
                'type' => Controls_Manager::SELECT,
                'label' => __( 'Select a Form', 'royal-addons-for-elementor' ),
                'default' => '',
                'options'     => \RoyalAddons\Elementor\RoyalClass::royalwpcf7(),
            ]
        );


		$this->add_control(
			'rt_cf7_form_action_add',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( '<a href="%s" target="_blank" style="color:#d30c5c; float: right;">Add or edit form</a>', 'royal-addons-for-elementor' ), admin_url( 'admin.php?page=wpcf7' ) ),
				'content_classes' => '',
			]
		);



        $this->add_control(
            'extraclass',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __( 'Extra Class', 'royal-addons-for-elementor' ),
                'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'royal-addons-for-elementor' ),
            ]
        );


        $this->end_controls_section();
		
		
		
		$this->start_controls_section(
			'rt_cf7_section_redirect',
			[
				'label' => esc_html__( 'After Submit Redirect Setting', 'royal-addons-for-elementor' ),   //section name for controler view
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
	
		$this->add_control(
			'rt_cf7_redirect_external',
			[
				'label' => __( 'On Success External URL Redirect', 'royal-addons-for-elementor' ),
				'description' => esc_html__('Insert the external URL where you want users to redirect to when the contact form is submitted and is successful. Leave Blank to Disable','royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'https://royaltechbd.com', 'royal-addons-for-elementor' ),
				'label_block' => 1,
			]
		);

		$this->add_control(
			'rt_cf7_redirect_page',
			[
				'label' => esc_html__( 'On Success Internal Redirect', 'royal-addons-for-elementor' ),
                'description' => esc_html__('Select a page within the site which you want users to redirect to when the contact form is submitted and is successful. Leave Blank to Disable','royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT2,
				'multiple' => false,
				'label_block' => 1,
				'options'     => \RoyalAddons\Elementor\RoyalClass::royalallpage(),
				'condition' =>
				[
					'rt_cf7_redirect_external' => '',
				],	
			]
		);

	
		$this->end_controls_section();		
		
		
		
		
		
    }


	private function rt_cf7_style_section_general() {

		$this->start_controls_section(
			'rt_cf7_section_style_general',
			[
				'label' => __( 'General Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
	
	
		$this->add_responsive_control(
			'rt_cf7_align',
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
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
				'separator' =>'before',
			]
		);	
	
		$this->end_controls_section();
	}

	
	private function rt_cf7_style_section_input() {
		
		// Input Field style tab start
		$this->start_controls_section(
			'rt_cf7_input_style',
			[
				'label'     => __( 'Input', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);		
		
		
		$this->start_controls_tabs('input_style_tabs'); //start input area Normal/focus tabs

		// Input Normal tab start
		$this->start_controls_tab(
			'rt_cf7_input_style_normal_tab',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

			$this->add_responsive_control(
			'rt_cf7_input_box_height',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => 'px',
					'size' => 43,
				],			
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]'   => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]'  => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]'    => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]'    => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]'   => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'         => 'height: {{SIZE}}{{UNIT}};',
				],
			]
			);

			$this->add_responsive_control(
			'rt_cf7_input_box_width',
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],					
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]'   => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]'  => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]'    => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]'    => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]'   => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'         => 'width: {{SIZE}}{{UNIT}};',
				],
			]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'rt_cf7_input_box_bg_grd',
				'types' => [ 'classic', 'gradient'],
				'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
				'selector' => 
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"],
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"],
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"],
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"],
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"],
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"],
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
				
			]
			);

			$this->add_control(
			'rt_cf7_input_box_text_color',
			[
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'         => 'color: {{VALUE}};',
				],
			]
			);

			$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'rt_cf7_input_box_border',
				'label' => __( 'Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
			]
			);

			$this->add_responsive_control(
			'rt_cf7_input_box_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
				'separator' =>'after',
			]
			);

		$this->end_controls_tab(); // input Normal tab end

		// Input Focus tab start
		$this->start_controls_tab(
			'input_style_focus_tab',
			[
				'label' => __( 'Focus', 'royal-addons-for-elementor' ),
			]
		);

			$this->add_responsive_control(
			'rt_cf7_input_box_height_f',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => 'px',
					'size' => 43,
				],	
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus'   => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus'  => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus'    => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus'    => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus'   => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus'         => 'height: {{SIZE}}{{UNIT}};',
				],
			]
			);

			$this->add_responsive_control(
			'rt_cf7_input_box_width_f',
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus'   => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus'  => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus'    => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus'    => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus'   => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus'         => 'width: {{SIZE}}{{UNIT}};',
				],
			]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'rt_cf7_input_box_bg_grd_f',
				'types' => [ 'classic', 'gradient'],
				'label' => esc_html__( 'Background', 'plugin-name' ),
				'selector' => 
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus,
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus,
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus,
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus,
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus,
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus,
					{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus',
				
			]
			);

			$this->add_control(
			'rt_cf7_input_box_text_color_f',
			[
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus'         => 'color: {{VALUE}};',
				],
			]
			);

			$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'rt_cf7_input_box_border_f',
				'label' => __( 'Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus',
			]
			);

			$this->add_responsive_control(
			'rt_cf7_input_box_border_radius_f',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
			);

			$this->add_control(
			'rt_cf7_input_transition',
			[
				'label'     => __( 'Transition Control', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'placeholder' => 'width .35s ease-in-out',
				'description' => __( 'input your desired transition effect for focus. Remember one single line can set all types of transition values. <a target="_blank" href="https://css-tricks.com/almanac/properties/t/transition/">Example</a>', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' =>'transition:{{VALUE}};-webkit-transition:{{VALUE}};-o-transition:{{VALUE}}',

			 
				],
				'separator' =>'after',

			]
			);

		$this->end_controls_tab(); // input Focus tab end
		$this->end_controls_tabs(); // end text area Normal/focus tabs	

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			    'name' => 'rt_cf7_input_box_typography',
			    
			    'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
			]
			);


			$this->add_control(
			'rt_cf7_input_box_placeholder_color',
			[
			    'label'     => __( 'Placeholder Color', 'royal-addons-for-elementor' ),
			    'type'      => Controls_Manager::COLOR,
			    'selectors' => [
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]::-moz-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]::-moz-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]::-moz-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]::-moz-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]::-moz-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]::-moz-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:-ms-input-placeholder'  => 'color: {{VALUE}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'      => 'color: {{VALUE}};',
			    ],
			]
			);


			$this->add_responsive_control(
			'rt_cf7_input_box_padding',
			[
			    'label' => __( 'Padding', 'royal-addons-for-elementor' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', '%', 'em' ],
			    'selectors' => [
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
			    'separator' =>'before',
			]
			);

			$this->add_responsive_control(
			'rt_cf7_input_box_margin',
			[
			    'label' => __( 'Margin', 'royal-addons-for-elementor' ),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => [ 'px', '%', 'em' ],
			    'selectors' => [
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			        '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
			    'separator' =>'before',
			]
			);

		
		$this->end_controls_section();		
	}
	
	
	private function rt_cf7_style_section_textarea() {
		//Textarea style tab start
		$this->start_controls_section(
		    'rt_cf7_textarea_style',
		    [
		        'label'     => __( 'Textarea', 'royal-addons-for-elementor' ),
		        'tab'       => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->start_controls_tabs('textarea_style_tabs'); //start text area Normal/focus tabs

			// Input Normal tab start
			$this->start_controls_tab(
				'text_normal_tab',
				[
					'label' => __( 'Normal', 'royal-addons-for-elementor' ),
				]
			);	 

				$this->add_responsive_control(
				'rt_cf7_textarea_box_height',
				[
					'label' => __( 'Height', 'royal-addons-for-elementor' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => [ '%', 'px', 'vh' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
							'px' => [
								'min' => 0,
								'max' => 2000,
							],
							'vh' => [
								'min' => 0,
								'max' => 100,
							],					
						],
						'default' => [
							'unit' => 'px',
							'size' => 150,
						],
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'   => 'height: {{SIZE}}{{UNIT}};',
					],
				]
				);
				$this->add_responsive_control(
				'rt_cf7_textarea_box_width',
				[
					'label' => __( 'Width', 'royal-addons-for-elementor' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => [ '%', 'px', 'vw' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
							'px' => [
								'min' => 0,
								'max' => 2000,
							],
							'vw' => [
								'min' => 0,
								'max' => 100,
							],					
						],
						'default' => [
							'unit' => '%',
							'size' => 100,
						],
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'   => 'width: {{SIZE}}{{UNIT}};',
					],
				]

				);

				$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'rt_cf7_textarea_box_bg_grd',
					'types' => [ 'classic', 'gradient'],
					'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
					'selector' => 
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',	        
				]

				);

				$this->add_control(
				'rt_cf7_textarea_box_text_color',
				[
					'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'   => 'color: {{VALUE}};',
					],
				]
				);

				$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'rt_cf7_textarea_box_border',
					'label' => __( 'Border', 'royal-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',
				]
				);

				$this->add_responsive_control(
				'rt_cf7_textarea_box_border_radius',
				[
					'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
					'separator' =>'after',
				]
				);


			$this->end_controls_tab(); // Textarea Normal tab end	


			// Input Focus tab start
			$this->start_controls_tab(
				'text_focus_tab',
				[
					'label' => __( 'Focus', 'royal-addons-for-elementor' ),
				]
			);	 
				$this->add_responsive_control(
				'rt_cf7_textarea_box_height_f',
				[
					'label' => __( 'Height', 'royal-addons-for-elementor' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => [ '%', 'px', 'vh' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
							'px' => [
								'min' => 0,
								'max' => 2000,
							],
							'vh' => [
								'min' => 0,
								'max' => 100,
							],					
						],
						'default' => [
							'unit' => 'px',
							'size' => 150,
						],

					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus'   => 'height: {{SIZE}}{{UNIT}};',
					],
				]
				);
				$this->add_responsive_control(
				'rt_cf7_textarea_box_width_f',
				[
					'label' => __( 'Width', 'royal-addons-for-elementor' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => [ '%', 'px', 'vw' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
							'px' => [
								'min' => 0,
								'max' => 2000,
							],
							'vw' => [
								'min' => 0,
								'max' => 100,
							],					
						],
						'default' => [
							'unit' => '%',
							'size' => 100,
						],

					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus'   => 'width: {{SIZE}}{{UNIT}};',
					],
				]

				);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'rt_cf7_textarea_box_bg_grd_f',
					'types' => [ 'classic', 'gradient'],
					'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
					'selector' => 
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus',	        
				]
				
				);

				$this->add_control(
				'rt_cf7_textarea_box_text_color_f',
				[
					'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus'   => 'color: {{VALUE}};',
					],
				]
				);

				$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'rt_cf7_textarea_box_border_f',
					'label' => __( 'Border', 'royal-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus',
				]
				);

				$this->add_responsive_control(
				'rt_cf7_textarea_box_border_radius_f',
				[
					'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
					'separator' =>'after',
				]
				);

				$this->add_control(
				'rt_cf7_textarea_transition',
				[
					'label'     => __( 'Transition Control', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::TEXT,
					'placeholder' => 'width .35s ease-in-out',
					'description' => __( 'input your desired transition effect for focus. Remember one single line can set all types of transition values. <a target="_blank" href="https://css-tricks.com/almanac/properties/t/transition/">Example</a>', 'royal-addons-for-elementor' ),
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' =>'transition:{{VALUE}};-webkit-transition:{{VALUE}}',

				 
					],
					'separator' =>'after',

				]
				);				

			$this->end_controls_tab(); // Textarea Focus tab end				
		
		$this->end_controls_tabs(); //end text area Normal/focus tabs				


		$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'rt_cf7_textarea_box_typography',
			'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',
		]
		);



		$this->add_control(
		'rt_cf7_textarea_box_placeholder_color',
		[
			'label'     => __( 'Placeholder Color', 'royal-addons-for-elementor' ),
			'type'      => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::-webkit-input-placeholder'  => 'color: {{VALUE}};',
				'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::-moz-placeholder'  => 'color: {{VALUE}};',
				'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:-ms-input-placeholder'  => 'color: {{VALUE}};',
			],
		]
		);


		$this->add_responsive_control(
		'rt_cf7_textarea_box_padding',
		[
			'label' => __( 'Padding', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'separator' =>'before',
		]
		);

		$this->add_responsive_control(
		'rt_cf7_textarea_box_margin',
		[
			'label' => __( 'Margin', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'separator' =>'before',
		]
		);

		$this->end_controls_section(); // Textarea style tab end


	}		
	
	
	private function rt_cf7_style_section_label() {
		// Label style tab start
		$this->start_controls_section(
			'rt_cf7_cf7_label_style',
			[
				'label'     => __( 'Label', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'rt_cf7_label_background',
				[
					'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}  form.wpcf7-form label'   => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'rt_cf7_label_text_color',
				[
					'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}  form.wpcf7-form label'   => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'rt_cf7_label_typography',
					'selector' => '{{WRAPPER}}  form.wpcf7-form label',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'rt_cf7_label_border',
					'label' => __( 'Border', 'royal-addons-for-elementor' ),
					'selector' => '{{WRAPPER}}  form.wpcf7-form label',
				]
			);

			$this->add_responsive_control(
				'rt_cf7_label_border_radius',
				[
					'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}}  form.wpcf7-form label' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
					'separator' =>'before',
				]
			);

			$this->add_responsive_control(
				'rt_cf7_label_padding',
				[
					'label' => __( 'Padding', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}}  form.wpcf7-form label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' =>'before',
				]
			);

			$this->add_responsive_control(
				'rt_cf7_label_margin',
				[
					'label' => __( 'Margin', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}}  form.wpcf7-form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' =>'before',
				]
			);

		$this->end_controls_section(); // 
		// Label style tab end


	}	
		
		
	private function rt_cf7_style_section_button() {
	        // Input submit button style tab start
	        $this->start_controls_section(
	            'rt_cf7_inputsubmit_style',
	            [
	                'label'     => __( 'Button', 'royal-addons-for-elementor' ),
	                'tab'       => Controls_Manager::TAB_STYLE,
	            ]
	        );

			$this->add_responsive_control(
				'rt_cf7_button_text_align',
				[
					'label' => __( 'Text Alignment', 'royal-addons-for-elementor' ),
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
						'justify' => [
							'title' => __( 'Justified', 'royal-addons-for-elementor' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form input[type=submit]' => 'text-align: {{VALUE}};',
					],
					'separator' =>'before',
				]
			);


			$this->add_responsive_control(
				'rt_cf7_button_align',
				[
					'label' => __( 'Button Float', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'royal-addons-for-elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						
						'right' => [
							'title' => __( 'Right', 'royal-addons-for-elementor' ),
							'icon' => 'eicon-text-align-right',
						],	                     
					],
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form input[type=submit]' => 'float: {{VALUE}};',
					],
					'separator' =>'after',
				]
			);
			
			$this->start_controls_tabs('submit_style_tabs');

			// Button Normal tab start
			$this->start_controls_tab(
				'submit_style_normal_tab',
				[
					'label' => __( 'Normal', 'royal-addons-for-elementor' ),
				]
			);

				$this->add_responsive_control(
					'input_submit_height',
					[
					'label' => __( 'Height', 'royal-addons-for-elementor' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'vh' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
							'px' => [
								'min' => 0,
								'max' => 900,
							],
							'vh' => [
								'min' => 0,
								'max' => 100,
							],					
						],
						'default' => [
							'unit' => 'px',
							'size' => 50,
						],	
							
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]' => 'height: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_responsive_control(
					 'input_submit_width',
					[
					'label' => __( 'Width', 'royal-addons-for-elementor' ),
						'type'  => Controls_Manager::SLIDER,
						'size_units' => [ 'px', '%', 'vw' ],
						'range' => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
							'px' => [
								'min' => 0,
								'max' => 1000,
							],
							'vw' => [
								'min' => 0,
								'max' => 100,
							],					
						],
						'default' => [
							'unit' => 'px',
							'size' => 130,
						],	
							
								'selectors' => [
									'{{WRAPPER}} .wpcf7-form input[type=submit]' => 'width: {{SIZE}}{{UNIT}};',
								],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'input_submit_typography',
						'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
					]
				);

				$this->add_control(
					'input_submit_text_color',
					[
						'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]'  => 'color: {{VALUE}};',
						],
					]
				);

	   

				$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'input_submit_bg_grd',
					'types' => [ 'classic', 'gradient'],
					'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
					'selector' => 
						'{{WRAPPER}} .wpcf7-form input[type=submit]',	        
				]
				);

				$this->add_responsive_control(
					'input_submit_padding',
					[
						'label' => __( 'Padding', 'royal-addons-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'separator' =>'before',
					]
				);

				$this->add_responsive_control(
					'input_submit_margin',
					[
						'label' => __( 'Margin', 'royal-addons-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'separator' =>'before',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'input_submit_border',
						'label' => __( 'Border', 'royal-addons-for-elementor' ),
						'selector' => '{{WRAPPER}} .wpcf7-form input[type=submit]',
					]
				);

				$this->add_responsive_control(
					'input_submit_border_radius',
					[
						'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						],
						'separator' =>'before',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'rt_cf7_input_submit_box_shadow',
						'label' => __( 'Box Shadow', 'royal-addons-for-elementor' ),
						'selector' => '{{WRAPPER}} .wpcf7-form input[type=submit]',
					]
				);

			$this->end_controls_tab(); // Button Normal tab end

			// Button Hover tab start
			$this->start_controls_tab(
				'submit_style_hover_tab',
				[
					'label' => __( 'Hover', 'royal-addons-for-elementor' ),
				]
			);

				$this->add_responsive_control(
					'input_submit_height_h',
					[
			'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vh' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 900,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],	
					
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]:hover' => 'height: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_responsive_control(
					 'input_submit_width_h',
					[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => 'px',
					'size' => 130,
				],	
					
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form input[type=submit]:hover' => 'width: {{SIZE}}{{UNIT}};',
				],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'input_submit_typography_h',
						'selector' => '{{WRAPPER}} .wpcf7-form input[type=submit]:hover',
					]
				);

				$this->add_control(
					'input_submit_text_color_h',
					[
						'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]:hover'  => 'color: {{VALUE}};',
						],
					]
				);

	   

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
				[
					'name' => 'input_submit_bg_grd_h',
					'types' => [ 'classic', 'gradient'],
					'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
					'selector' => 
						'{{WRAPPER}} .wpcf7-form input[type=submit]:hover',	        
				]
				);

				$this->add_responsive_control(
					'input_submit_padding_h',
					[
						'label' => __( 'Padding', 'royal-addons-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'separator' =>'before',
					]
				);

				$this->add_responsive_control(
					'input_submit_margin_h',
					[
						'label' => __( 'Margin', 'royal-addons-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'separator' =>'before',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'input_submit_border_h',
						'label' => __( 'Border', 'royal-addons-for-elementor' ),
						'selector' => '{{WRAPPER}} .wpcf7-form input[type=submit]:hover',
					]
				);

				$this->add_responsive_control(
					'input_submit_border_radius_h',
					[
						'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						],
						'separator' =>'before',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'rt_cf7_input_submit_box_shadow_h',
						'label' => __( 'Box Shadow', 'royal-addons-for-elementor' ),
						'selector' => '{{WRAPPER}} .wpcf7-form input[type=submit]:hover',
					]
				);

				$this->add_control(
					'rt_cf7_button_h_animation',
					[
						'label'     => __( 'Hover Animation', 'royal-addons-for-elementor' ),
						'type'      => Controls_Manager::TEXT,
						'placeholder' => 'all .25s linear 0s',
						'default' => 'all .25s linear 0s',
						'description' => __( 'input your desired transition effect for focus. Remember one single line can set all types of transition values. <a target="_blank" href="https://css-tricks.com/almanac/properties/t/transition/">Example</a>', 'royal-addons-for-elementor' ),
						'selectors' => [
							'{{WRAPPER}} .wpcf7-form input[type=submit]' =>'transition:{{VALUE}};-webkit-transition:{{VALUE}};-o-transition:{{VALUE}}',
						],
						'separator' =>'after',

					]
				);

			$this->end_controls_tab(); // Button Hover tab end

			$this->end_controls_tabs(); //ens submit style tabs
		$this->end_controls_section(); 
		// end out style tab
	}	
		
		
	private function rt_cf7_style_section_after_submit() {

		// After submit styles
		$this->start_controls_section(
			'rt_cf7_section_after_submit',
			[
				'label' => __('After Submit message', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs('rt_cf7_after_s_style_tabs');
				// Success tab start
				$this->start_controls_tab(
					'rt_cf7_after_submit_su_tab',
					[
						'label' => __( 'Success', 'royal-addons-for-elementor' ),
					]
				);

					$this->add_control(
						'contact_form_after_submit_s_color',
						[
							'label' => __('Success Text Color', 'royal-addons-for-elementor'),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .wpcf7 form.sent .wpcf7-response-output' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'rt_cf7_after_submit_background',
							'label' => __('Background', 'royal-addons-for-elementor'),
							'types' => ['classic', 'gradient'],
							'selector' => '{{WRAPPER}} .wpcf7 form.sent .wpcf7-response-output',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'rt_cf7_after_submit_border',
							'label' => __('Border', 'royal-addons-for-elementor'),
							'placeholder' => '1px',
							'default' => '1px',
							'selector' => '{{WRAPPER}} .wpcf7 form.sent .wpcf7-response-output',
						]
					);

					$this->add_responsive_control(
						'rt_cf7_after_submit_border_radius',
						[
							'label' => esc_html__('Radius', 'royal-addons-for-elementor'),
							'type' => Controls_Manager::SLIDER,
							'size_units' => ['px', 'em', '%'],
							'range' => [
								'px' => [
									'min' => 10,
									'max' => 1500,
								],
								'em' => [
									'min' => 1,
									'max' => 80,
								],
							],
							'selectors' => [
								'{{WRAPPER}} .wpcf7 form.sent .wpcf7-response-output' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
							'separator' =>'after',

						]
					);
				$this->end_controls_tab();				

				// Fail tab start
				$this->start_controls_tab(
					'rt_cf7_after_submit_fa_tab',
					[
						'label' => __( 'Failed', 'royal-addons-for-elementor' ),
					]
				);

					$this->add_control(
						'contact_form_after_submit_n_color',
						[
							'label' => __('Fail Text Color', 'royal-addons-for-elementor'),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .wpcf7 form.invalid .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.unaccepted .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.payment-required .wpcf7-response-output' => 'color: {{VALUE}}',
							],
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Background::get_type(),
						[
							'name' => 'rt_cf7_after_submit_er_background',
							'label' => __('Background', 'royal-addons-for-elementor'),
							'types' => ['classic', 'gradient'],
							'selector' => '.wpcf7 form.invalid .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.unaccepted .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.payment-required .wpcf7-response-output',
						]
					);

					$this->add_group_control(
						\Elementor\Group_Control_Border::get_type(),
						[
							'name' => 'rt_cf7_after_submit_er_border',
							'label' => __('Border', 'royal-addons-for-elementor'),
							'placeholder' => '1px',
							'default' => '1px',
							'selector' => '.wpcf7 form.invalid .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.unaccepted .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.payment-required .wpcf7-response-output',
						]
					);

					$this->add_responsive_control(
						'rt_cf7_after_submit_er_border_radius',
						[
							'label' => esc_html__('Radius', 'royal-addons-for-elementor'),
							'type' => Controls_Manager::SLIDER,
							'size_units' => ['px', 'em', '%'],
							'range' => [
								'px' => [
									'min' => 10,
									'max' => 1500,
								],
								'em' => [
									'min' => 1,
									'max' => 80,
								],
							],
							'selectors' => [
								'.wpcf7 form.invalid .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.unaccepted .wpcf7-response-output, {{WRAPPER}} .wpcf7 form.payment-required .wpcf7-response-output' => 'border-radius: {{SIZE}}{{UNIT}};',
							],
							'separator' =>'after',

						]
					);						

				$this->end_controls_tab();
				
			$this->end_controls_tabs();

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'rt_cf7_after_submit_typography',
					'label' => __('Typography', 'royal-addons-for-elementor'),
					'selector' => '{{WRAPPER}} .wpcf7-mail-sent-ng, {{WRAPPER}} .wpcf7-mail-sent-ok, {{WRAPPER}} .wpcf7-response-output',
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'rt_cf7_after_submit_margin',
				[
					'label' => esc_html__('Margin', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .wpcf7-mail-sent-ng' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} wpcf7-mail-sent-ok' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'rt_cf7_after_submit_padding',
				[
					'label' => esc_html__('Padding', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .wpcf7-mail-sent-ng' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-mail-sent-ok' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();	

	}	
		
	

    protected function render() {
		$uniqID    		= $this->get_id();
        $settings 		= $this->get_settings_for_display();
		if ( post_type_exists( 'wpcf7_contact_form' ) ) { /*wpcf7 active */
        $extraclass 	= $settings['extraclass'];
        $royalcf7ID 	= $settings['royalcf7'];
        $royalcf7Title 	= get_the_title($royalcf7ID);

		if(!empty($royalcf7ID)){
			echo '<div class="royalcf7 royalcf7id'.$uniqID.' elementor-shortcode '. $extraclass . '">' . do_shortcode('[contact-form-7 id='. $royalcf7ID .' title=' . $royalcf7Title .']') . '</div>';
		} else {
			echo 'No Contact form 7 selected.';  
		}
		
		
		if(!empty($settings['rt_cf7_redirect_page']) || !empty($settings['rt_cf7_redirect_external']) ) {  ?>
 			<script>
			var theform = document.querySelector('.royalcf7id<?php echo $uniqID; ?>');
				theform.addEventListener( 'wpcf7mailsent', function( event ) {
				location = '<?php 
				if( !empty($settings['rt_cf7_redirect_external']) ){
					echo wp_kses_post( $settings['rt_cf7_redirect_external'] );
				}else{
					 echo get_permalink( $settings['rt_cf7_redirect_page'] );
				}
				?>';
			}, false );
			</script>
		<?php
 		}

		} else {
			echo '<div class="royalalert">Contact Form 7 is not installed/activated on your site. Please install and activate.</div>';
		}
		
		/*wpcf7 active */
		
		
    }



    protected function content_template() {
        
    }

}
