<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalPhoneCall extends Widget_Base {
			
	public function get_name() {
		return 'royalphonecall';
	}

	public function get_title() {
		return esc_html__( 'Phone Call', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-tel-field rtbranding'; }

	public function get_categories() {
		return [ 'royaltech'];
	}

	public function get_style_depends() {
		$styles = [ 'royalphonecall' ];
		return $styles;
	}

	public function get_keywords() {
		return [ 'call', 'phone', 'mobile', 'graph', 'product', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }


	protected function register_controls() {
	$this->start_controls_section(
		'section_general',
		[
			'label' => esc_html__( 'General', 'royal-addons-for-elementor' ),
			'tab' => Controls_Manager::TAB_CONTENT,
		]
	);

	$this->add_control(
		'telnumber',
		[
			'label' => esc_html__( 'Phone Number', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::TEXT,
			'dynamic' => [
				'active' => true,
			],
			'default' => '+8801552333272',
		]
	);
	$this->add_control(
		'button_position',
		[
			'label' => esc_html__( 'Button Position', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'fixed',
			'label_block' => false,
			'render_type' => 'template',
			'options' => [
				'fixed' => esc_html__( 'Fixed', 'royal-addons-for-elementor' ),
				'inline' => esc_html__( 'Inline', 'royal-addons-for-elementor' ),
				],
			'prefix_class' => 'royalphonecallbtn-align-',
			'separator' => 'before',
		]
	);

	$this->add_responsive_control(
		'button_position_inline',
		[
			'label' => esc_html__( 'Inline Position', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::CHOOSE,
			'default' => 'center',
			'label_block' => false,
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
					'icon' => 'eicon-h-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
					'icon' => 'eicon-h-align-center',
				],
				'flex-end' => [
					'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
					'icon' => 'eicon-h-align-right',
				],
			],
			'selectors' => [
				'{{WRAPPER}} .royalphonecallwrapper' => 'justify-content: {{VALUE}}',
			],

			'separator' => 'before',
			'condition' => [
				'button_position' => 'inline',
			],
		]
	);
	
	$this->add_responsive_control(
		'button_position_fixed',
		[
			'label' => esc_html__( 'Fixed Position', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::CHOOSE,
			'default' => 'right',
			'label_block' => false,
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
			'separator' => 'before',
			'default' => 'right',
			'condition' => [
				'button_position' => 'fixed',
			],
			'prefix_class' => 'royalphonecallbtn-align-fixed-',
		]
	);
	$this->add_responsive_control(
		'distance_x_right',
		[
			'label' => esc_html__( 'Distance Right', 'royal-addons-for-elementor' ),
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
				'size' => 30,
			],
			'selectors' => [
				'{{WRAPPER}}.royalphonecallbtn-align-fixed-right .royalphonecallbtn' => 'right: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'button_position' => 'fixed',
				'button_position_fixed' => 'right',
			],
		]
	);
	$this->add_responsive_control(
		'distance_y_right',
		[
			'label' => esc_html__( 'Distance Bottom', 'royal-addons-for-elementor' ),
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
				'size' => 30,
			],
			'selectors' => [
				'{{WRAPPER}}.royalphonecallbtn-align-fixed-right .royalphonecallbtn' => 'bottom: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'button_position' => 'fixed',
				'button_position_fixed' => 'right',
			],
		]
	);

	$this->add_responsive_control(
		'distance_x_left',
		[
			'label' => esc_html__( 'Distance Left', 'royal-addons-for-elementor' ),
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
				'size' => 30,
			],
			'selectors' => [
				'{{WRAPPER}}.royalphonecallbtn-align-fixed-left .royalphonecallbtn' => 'left: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'button_position' => 'fixed',
				'button_position_fixed' => 'left',
			],
		]
	);

	$this->add_responsive_control(
		'distance_y_left',
		[
			'label' => esc_html__( 'Distance Bottom', 'royal-addons-for-elementor' ),
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
				'size' => 30,
			],
			'selectors' => [
				'{{WRAPPER}}.royalphonecallbtn-align-fixed-left .royalphonecallbtn' => 'bottom: {{SIZE}}{{UNIT}};',
			],
			'condition' => [
				'button_position' => 'fixed',
				'button_position_fixed' => 'left',
			],
		]
	);

	$this->add_control(
		'pc_icon',
		[
			'label' => esc_html__( 'Select Icon', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::ICONS,
			'skin' => 'inline',
			'label_block' => false,
			'default' => [
				'value' => 'fas fa-phone',
				'library' => 'fa-solid',
			],
			'separator' => 'before',
			'recommended' => [
				'fa-solid' => [
					'phone',
					'phone-alt',
					'search',
				],
			],
		]
	);

	$this->add_control(
			'button_txt_show',
			[
				'label' => __( 'Button Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
	);

	$this->add_control(
		'pc_icon_layout_select',
		[
			'label' => esc_html__( 'Icon Align', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'right',
			'label_block' => false,
			'options' => [
				'top' => esc_html__( 'Top', 'royal-addons-for-elementor' ),
				'bottom' => esc_html__( 'Bottom', 'royal-addons-for-elementor' ),
				'right' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
				'left' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
			],
			'condition' => [
				'pc_icon[value]!' => '',
				'button_txt_show' => 'yes',
			],
			'prefix_class' => 'royalphonecallbtn-icon-',
		]
	);
	
	$this->add_control(
		'pc_icon_animation',
		[
			'label' => esc_html__( 'Icon Animation', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'phoneringanimation',
			'label_block' => false,
			'options' => [
				'noanimation' 			=> esc_html__( 'No Animation', 'royal-addons-for-elementor' ),
				'phoneringanimation' 	=> esc_html__( 'Ring Animation', 'royal-addons-for-elementor' ),
			],
			'condition' => [
				'pc_icon[value]!' => '',
				'button_txt_show' => 'yes',
			],
			'prefix_class' => 'royalphonecallbtn-icon-',
		]
	);

	$this->add_control(
		'button_text',
		[
			'label' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::TEXT,
			'dynamic' => [
				'active' => true,
			],
			'default' => 'Call Now',
			'condition' => [
				'button_txt_show' => 'yes',
			],
		]
	);

	$this->end_controls_section();

	// Section Button ------------
	$this->start_controls_section(
		'section_style_button',
		[
			'label' => esc_html__( 'Button', 'royal-addons-for-elementor' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	);


	$this->start_controls_tabs( 'tabs_pc_button_colors' );

	// Normal Tab ------------
	$this->start_controls_tab(
		'tab_pc_button_normal_colors',
		[
			'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
		]
	);

	$this->add_control(
		'button_text_color',
		[
			'label' => esc_html__( ' Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#ffffff',
			'selectors' => [
				'{{WRAPPER}} .royalphonecallcontent' => 'color: {{VALUE}}',
				'{{WRAPPER}} .royalphonecallbtn-icon' => 'color: {{VALUE}}',
				'{{WRAPPER}} .royalphonecallbtn-icon svg' => 'fill: {{VALUE}}',
			],
		]
	);
	
	$this->add_control(
		'button_bg_color',
		[
			'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#39B54A',
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn' => 'background-color: {{VALUE}}',
				'{{WRAPPER}} .royalphonecallbtn .phone-ring-circle' => 'border: 2px solid {{VALUE}}',
				'{{WRAPPER}} .royalphonecallbtn .phone-ring-circle-fill' => 'background-color: {{VALUE}}',
				'{{WRAPPER}} .royalphonecallbtn .phone-ring-img-circle' => 'background-color: {{VALUE}}',
			],
		]
	);
	$this->add_control(
		'button_border_color',
		[
			'label' => esc_html__( 'Border Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#E8E8E8',
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn' => 'border-color: {{VALUE}}',
			],
			'condition' =>[
				'border_switcher' => 'yes',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'button_box_shadow',
			'label' => __( 'Box Shadow', 'royal-addons-for-elementor' ),
			'selector' => '{{WRAPPER}} .royalphonecallbtn',
		]
	);

	$this->end_controls_tab();// normal tab end

	// Hover Tab -------------
	$this->start_controls_tab(
		'tab_button_hover_colors',
		[
			'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
		]
	);

	$this->add_control(
		'button_texte_color_hover',
		[
			'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#fff',
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn:hover > .royalphonecallbtn-icon' => 'Color: {{VALUE}}',
			],
		]
	);

	$this->add_control(
		'button_bg_color_hover',
		[
			'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#1FD538',
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn:hover' => 'background-color: {{VALUE}}',
			],
		]
	);

	$this->add_control(
		'button_border_color_hover',
		[
			'label' => esc_html__( 'Border Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#E8E8E8',
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn:hover' => 'border-color: {{VALUE}}',
			],
			'condition' =>[
				'border_switcher' => 'yes',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'button_box_shadow_hover',
			'label' => __( 'Box Shadow', 'royal-addons-for-elementor' ),
			'selector' => '{{WRAPPER}} .royalphonecallbtn:hover',
		]
	);

	$this->end_controls_tab();// hover tab end

	$this->end_controls_tabs();// End tabs

	$this->add_control(
			'hover_animation_hover_duration',
			[
				'label' => __( 'Hover Animation Duration', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'default' => 0.3,
				'selectors' => [
					'{{WRAPPER}} .royalphonecallbtn' => 'transition:  all  {{VALUE}}s ease-in-out 0s;',
				],
				'separator' => 'before',
			]
		);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'button_typography',
			'selector' => '{{WRAPPER}} .royalphonecallcontent,{{WRAPPER}} .royalphonecallcontent::after',
			'separator' => 'before',
			'condition' => [
				'button_txt_show' => 'yes',
			],
		]
	);

	$this->add_control(
		'icon_size',
		[
			'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
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
				'size' => 20,
			],
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn-icon' => 'font-size: {{SIZE}}{{UNIT}}; width:calc({{SIZE}}{{UNIT}} * 1.2)',
				'{{WRAPPER}} .royalphonecallbtn-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				
				'{{WRAPPER}} .phoneringanimation .phone-ring-circle' => 'width:calc({{SIZE}}{{UNIT}} * 4); height:calc({{SIZE}}{{UNIT}} * 4); top:calc({{SIZE}}{{UNIT}} * -2); left:calc({{SIZE}}{{UNIT}} * -1.5);',
				'{{WRAPPER}} .phoneringanimation .phone-ring-circle-fill' => 'width:calc({{SIZE}}{{UNIT}} * 2); height:calc({{SIZE}}{{UNIT}} * 2); top:calc({{SIZE}}{{UNIT}} * -1); left:calc({{SIZE}}{{UNIT}} * -.5);',
				'{{WRAPPER}} .phoneringanimation .phone-ring-img-circle' => 'width:calc({{SIZE}}{{UNIT}} * 1.5); height:calc({{SIZE}}{{UNIT}} * 1.5); top:calc({{SIZE}}{{UNIT}} * -.8); left:calc({{SIZE}}{{UNIT}} * -.25);',
				
				'{{WRAPPER}}.royalphonecallbtn-icon-bottom .phoneringanimation .phone-ring-circle' => 'width:calc({{SIZE}}{{UNIT}} * 4); height:calc({{SIZE}}{{UNIT}} * 4); top:calc({{SIZE}}{{UNIT}} * -.5); left:calc({{SIZE}}{{UNIT}} * -1.5);',
				'{{WRAPPER}}.royalphonecallbtn-icon-bottom .phoneringanimation .phone-ring-circle-fill' => 'width:calc({{SIZE}}{{UNIT}} * 2); height:calc({{SIZE}}{{UNIT}} * 2); top:calc({{SIZE}}{{UNIT}} * .5); left:calc({{SIZE}}{{UNIT}} * -.5);',
				'{{WRAPPER}}.royalphonecallbtn-icon-bottom .phoneringanimation .phone-ring-img-circle' => 'top:calc({{SIZE}}{{UNIT}} * .75); margin: 0 auto;',
			
				'{{WRAPPER}}.royalphonecallbtn-icon-top .phoneringanimation .phone-ring-circle' => 'width:calc({{SIZE}}{{UNIT}} * 4); height:calc({{SIZE}}{{UNIT}} * 4); top:calc({{SIZE}}{{UNIT}} * -3.5); left:calc({{SIZE}}{{UNIT}} * -1.5);',
				'{{WRAPPER}}.royalphonecallbtn-icon-top .phoneringanimation .phone-ring-circle-fill' => 'width:calc({{SIZE}}{{UNIT}} * 2); height:calc({{SIZE}}{{UNIT}} * 2); top:calc({{SIZE}}{{UNIT}} * -2.5); left:calc({{SIZE}}{{UNIT}} * -.5);',
				'{{WRAPPER}}.royalphonecallbtn-icon-top .phoneringanimation .phone-ring-img-circle' => 'top:calc({{SIZE}}{{UNIT}} * -2.25); margin: 0 auto;',			
			],
			'separator' => 'before',
			'condition' => [
				'pc_icon[value]!' => '',
			],
		]
	);

	$this->add_control(
		'pc_icon_distance',
		[
			'label' => esc_html__( 'Icon Distance', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => ['px'],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 25,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 7,
			],
			'selectors' => [
				'{{WRAPPER}}.royalphonecallbtn-icon-top .royalphonecallbtn-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}}.royalphonecallbtn-icon-left .royalphonecallbtn-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}}.royalphonecallbtn-icon-right .royalphonecallbtn-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}}.royalphonecallbtn-icon-bottom .royalphonecallbtn-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
			],
			'separator' => 'before',
			'condition' => [
				'pc_icon[value]!' => '',
				'button_txt_show' => 'yes',
			],
		]
	);

	$this->add_responsive_control(
		'button_padding',
		[
			'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default' => [
				'top' => 13,
				'right' => 14,
				'bottom' => 13,
				'left' => 14,
			],
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'separator' => 'before',
		]
	);

	$this->add_control(
		'border_switcher',
		[
			'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SWITCHER,
			'separator' => 'before',
			'return_value' => 'yes',
			'label_block' => false,
			'default' => 'yes',

		]
	);

	$this->add_control(
		'button_border_type',
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
				'{{WRAPPER}} .royalphonecallbtn' => 'border-style: {{VALUE}};',
			],
			'condition' =>[
				'border_switcher' => 'yes',
			],
		]
	);

	$this->add_responsive_control(
		'border_width',
		[
			'label' => esc_html__( 'Border Width', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'default' => [
				'top' => 1,
				'right' => 1,
				'bottom' => 1,
				'left' => 1,
			],
			'selectors' => [
				'{{WRAPPER}} .royalphonecallbtn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			'separator' => 'before',
			'condition' =>[
					'border_switcher' => 'yes',
					'button_border_type!' => 'none',
			],
		]
	);

	$this->add_responsive_control(
			'button_border_radius',
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
					'{{WRAPPER}} .royalphonecallbtn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
	);

	$this->end_controls_section();

	}

	protected function render() {
	// Get Settings
	$settings = $this->get_settings();
	$pc_icon_animation = $settings ['pc_icon_animation'];

		echo '<div class="royalphonecallwrapper">';
			echo '<a href="tel:'. esc_attr($settings['telnumber']) .'" class="royalphonecallbtn">';
				echo '<div class="royalphonecallcontent '.$pc_icon_animation.'">';
				if ( '' !== $settings['button_text'] && $settings['button_txt_show'] == 'yes' ) {
					echo '<span class="royalphonecalltext">'. esc_html($settings ['button_text']) .'</span>';
				}
				if ( '' !== $settings['pc_icon']['value'] ) {
					echo '<span class="royalphonecallbtn-icon"><div class="phone-ring-circle"></div>
				<div class="phone-ring-circle-fill"></div><div class="phone-ring-img-circle">';
			 			\Elementor\Icons_Manager::render_icon( $settings['pc_icon'] );
					echo '</div></span>';
				}
				echo '</div>';
			echo '</a>';
		echo '</div>';


	}

}