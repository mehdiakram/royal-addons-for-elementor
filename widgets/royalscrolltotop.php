<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalScrollToTop extends Widget_Base {

	public function get_name() {
		return 'royalscrolltotop';
	}

	public function get_title() {
		return __( 'Scroll To Top', 'royal-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-v-align-top rtbranding';
	}

	public function get_keywords() {
		return [ 'scroll', 'top', 'to top', 'back to top', 'progress', 'rocket', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
	}

	public function get_categories() {
		return [ 'royaltech_headerfooter' ];
	}

	public function get_style_depends() {
		return [ 'royalscrolltotop' ];
	}

	public function get_script_depends() {
		return [ 'royalscrolltotop' ];
	}

	protected function register_controls() {

		// =========================================================================
		// CONTENT TAB: Content & Settings
		// =========================================================================
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Button Content', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Button Type
		$this->add_control(
			'button_type',
			[
				'label'   => __( 'Button Type', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'      => __( 'Icon Only', 'royal-addons-for-elementor' ),
					'text'      => __( 'Text Only', 'royal-addons-for-elementor' ),
					'icon_text' => __( 'Icon & Text', 'royal-addons-for-elementor' ),
					'progress'  => __( 'Scroll Progress Ring (Smart)', 'royal-addons-for-elementor' ),
				],
			]
		);

		// Top Icon
		$this->add_control(
			'topicon',
			[
				'label'       => __( 'Icon', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-chevron-up',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-up',
						'angle-up',
						'arrow-up',
						'rocket',
						'caret-up',
						'plane-up',
						'turn-up',
						'circle-up',
					],
				],
				'condition'   => [
					'button_type!' => 'text',
				],
			]
		);

		// Button Text
		$this->add_control(
			'button_text',
			[
				'label'       => __( 'Button Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Top', 'royal-addons-for-elementor' ),
				'condition'   => [
					'button_type' => [ 'text', 'icon_text' ],
				],
				'dynamic'     => [ 'active' => true ],
			]
		);

		// Text Position relative to Icon
		$this->add_control(
			'text_position',
			[
				'label'     => __( 'Text Layout', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'below',
				'options'   => [
					'after'  => __( 'Right of Icon', 'royal-addons-for-elementor' ),
					'before' => __( 'Left of Icon', 'royal-addons-for-elementor' ),
					'below'  => __( 'Below Icon', 'royal-addons-for-elementor' ),
					'above'  => __( 'Above Icon', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'button_type' => 'icon_text',
				],
			]
		);

		// Show Scroll Percentage
		$this->add_control(
			'show_percentage',
			[
				'label'        => __( 'Show Percentage (%)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		// Tooltip Switcher
		$this->add_control(
			'show_tooltip',
			[
				'label'        => __( 'Show Tooltip', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		// Tooltip Text
		$this->add_control(
			'tooltip_text',
			[
				'label'       => __( 'Tooltip Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Back to Top', 'royal-addons-for-elementor' ),
				'condition'   => [
					'show_tooltip' => 'yes',
				],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->end_controls_section();


		// =========================================================================
		// CONTENT TAB: Position & Smart Triggers
		// =========================================================================
		$this->start_controls_section(
			'position_section',
			[
				'label' => __( 'Position & Triggers', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Position Preset
		$this->add_control(
			'position_preset',
			[
				'label'   => __( 'Position', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-right',
				'options' => [
					'bottom-right'  => __( 'Bottom Right', 'royal-addons-for-elementor' ),
					'bottom-left'   => __( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom-center' => __( 'Bottom Center', 'royal-addons-for-elementor' ),
					'top-right'     => __( 'Top Right', 'royal-addons-for-elementor' ),
					'top-left'      => __( 'Top Left', 'royal-addons-for-elementor' ),
				],
			]
		);

		// Offset X (Horizontal)
		$this->add_responsive_control(
			'offset_x',
			[
				'label'      => __( 'Horizontal Offset', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 300, 'step' => 1 ],
					'%'  => [ 'min' => 0, 'max' => 50 ],
					'vw' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 30 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-scroll-to-top-wrap' => '--r-stt-offset-x: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'position_preset!' => 'bottom-center',
				],
			]
		);

		// Offset Y (Vertical)
		$this->add_responsive_control(
			'offset_y',
			[
				'label'      => __( 'Vertical Offset', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 300, 'step' => 1 ],
					'%'  => [ 'min' => 0, 'max' => 50 ],
					'vh' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 30 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-scroll-to-top-wrap' => '--r-stt-offset-y: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Z-Index
		$this->add_control(
			'z_index',
			[
				'label'     => __( 'Z-Index', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 99999,
				'selectors' => [
					'{{WRAPPER}} .royal-scroll-to-top-wrap' => 'z-index: {{VALUE}};',
				],
			]
		);

		// Scroll Distance to Trigger
		$this->add_control(
			'scroll_offset',
			[
				'label'       => __( 'Scroll Distance to Show (px)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 50,
				'max'         => 3000,
				'step'        => 20,
				'default'     => 200,
				'description' => __( 'The button appears after user scrolls down this distance in pixels.', 'royal-addons-for-elementor' ),
				'separator'   => 'before',
			]
		);

		// Smart Direction Visibility
		$this->add_control(
			'smart_direction_visibility',
			[
				'label'        => __( 'Smart Direction Visibility', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'description'  => __( 'Automatically hides the button when scrolling down to keep page clean, and reveals when scrolling up.', 'royal-addons-for-elementor' ),
			]
		);

		// Auto Hide
		$this->add_control(
			'auto_hide',
			[
				'label'        => __( 'Auto Hide on Inactivity', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		// Auto Hide Delay
		$this->add_control(
			'auto_hide_delay',
			[
				'label'     => __( 'Inactivity Delay (seconds)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 1, 'max' => 10, 'step' => 1 ],
				],
				'default'   => [ 'unit' => 'px', 'size' => 3 ],
				'condition' => [
					'auto_hide' => 'yes',
				],
			]
		);

		// Scroll Duration (Speed)
		$this->add_control(
			'scroll_duration',
			[
				'label'       => __( 'Scroll Duration (ms)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [ 'min' => 200, 'max' => 2000, 'step' => 50 ],
				],
				'default'     => [ 'unit' => 'px', 'size' => 500 ],
				'description' => __( 'Speed of smooth scrolling to top in milliseconds.', 'royal-addons-for-elementor' ),
			]
		);

		// Preview in Editor
		$this->add_control(
			'preview_in_editor',
			[
				'label'        => __( 'Preview in Editor', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => __( 'Keeps the button visible inside Elementor editor canvas for styling.', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();


		// =========================================================================
		// CONTENT TAB: Smart Animations
		// =========================================================================
		$this->start_controls_section(
			'animation_section',
			[
				'label' => __( 'Smart Animations', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Entrance & Exit Animation
		$this->add_control(
			'entrance_animation',
			[
				'label'   => __( 'Entrance Animation', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide-up',
				'options' => [
					'slide-up' => __( 'Smart Slide Up (Elastic)', 'royal-addons-for-elementor' ),
					'fade'     => __( 'Smooth Fade In', 'royal-addons-for-elementor' ),
					'zoom'     => __( 'Spring Zoom In', 'royal-addons-for-elementor' ),
					'flip'     => __( '3D Flip In', 'royal-addons-for-elementor' ),
					'rotate'   => __( 'Rotate Zoom In', 'royal-addons-for-elementor' ),
					'bounce'   => __( 'Bouncy Pop In', 'royal-addons-for-elementor' ),
				],
			]
		);

		// Idle / Floating Attention Animation
		$this->add_control(
			'idle_animation',
			[
				'label'   => __( 'Idle Animation (Attention)', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'floating',
				'options' => [
					'none'     => __( 'None (Static)', 'royal-addons-for-elementor' ),
					'floating' => __( 'Gentle Floating (ভাসমান)', 'royal-addons-for-elementor' ),
					'pulse'    => __( 'Heartbeat Pulse (পালস)', 'royal-addons-for-elementor' ),
					'glow'     => __( 'Neon Glow Pulse (নিয়ন গ্লো)', 'royal-addons-for-elementor' ),
					'ripple'   => __( 'Radar / Water Ripple (রিপল ওয়েভ)', 'royal-addons-for-elementor' ),
				],
			]
		);

		// Hover Animation
		$this->add_control(
			'hover_animation',
			[
				'label'   => __( 'Hover Micro-Interaction', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon-fly-up',
				'options' => [
					'icon-fly-up'  => __( 'Icon Fly Up & Return (স্মার্ট ফ্লাই-আপ)', 'royal-addons-for-elementor' ),
					'hover-grow'   => __( 'Scale & Elevate (গ্রো ও লিফট)', 'royal-addons-for-elementor' ),
					'hover-rotate' => __( '360° Icon Spin', 'royal-addons-for-elementor' ),
					'hover-bounce' => __( 'Micro Bounce', 'royal-addons-for-elementor' ),
					'hover-glow'   => __( 'Aura Glow Expansion', 'royal-addons-for-elementor' ),
					'none'         => __( 'None', 'royal-addons-for-elementor' ),
				],
			]
		);

		// Click Animation
		$this->add_control(
			'click_animation',
			[
				'label'   => __( 'Click Animation', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'rocket-launch',
				'options' => [
					'rocket-launch' => __( 'Rocket Launch Blast (রকেট উড্ডয়ন)', 'royal-addons-for-elementor' ),
					'ripple'        => __( 'Material Water Ripple', 'royal-addons-for-elementor' ),
					'shrink'        => __( 'Tactile Click Depress', 'royal-addons-for-elementor' ),
					'none'          => __( 'Standard Click', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();


		// =========================================================================
		// STYLE TAB: Button Style
		// =========================================================================
		$this->start_controls_section(
			'button_style_section',
			[
				'label' => __( 'Button Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Button Width
		$this->add_responsive_control(
			'button_width',
			[
				'label'      => __( 'Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 30, 'max' => 120, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 48 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-scroll-to-top-btn' => '--r-stt-btn-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Button Height
		$this->add_responsive_control(
			'button_height',
			[
				'label'      => __( 'Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 30, 'max' => 120, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 48 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-scroll-to-top-btn' => '--r-stt-btn-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Icon Size
		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => __( 'Icon Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 10, 'max' => 60, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-scroll-to-top-btn' => '--r-stt-icon-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'button_type!' => 'text',
				],
			]
		);

		// Glassmorphism
		$this->add_control(
			'glassmorphism',
			[
				'label'        => __( 'Glassmorphism (Frosted Glass)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		// Glow Color for idle/hover glow
		$this->add_control(
			'glow_color',
			[
				'label'     => __( 'Glow Accent Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(50, 182, 122, 0.6)',
				'selectors' => [
					'{{WRAPPER}} .royal-scroll-to-top-wrap' => '--r-stt-glow-color: {{VALUE}};',
				],
			]
		);

		// Style Tabs: Normal & Hover
		$this->start_controls_tabs( 'button_style_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'button_tab_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		// Color
		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Icon & Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royal-scroll-to-top-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royal-stt-icon svg'     => 'fill: {{VALUE}};',
				],
			]
		);

		// Background
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-scroll-to-top-btn',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'default' => '#1e293b',
					],
				],
			]
		);

		// Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .royal-scroll-to-top-btn',
			]
		);

		// Border Radius
		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-scroll-to-top-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Box Shadow
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .royal-scroll-to-top-btn',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 4,
							'blur'       => 15,
							'spread'     => 0,
							'color'      => 'rgba(0, 0, 0, 0.2)',
						],
					],
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'button_tab_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		// Hover Color
		$this->add_control(
			'button_color_hover',
			[
				'label'     => __( 'Icon & Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royal-scroll-to-top-btn:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royal-scroll-to-top-btn:hover .royal-stt-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		// Hover Background
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_bg_hover',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-scroll-to-top-btn:hover',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'default' => '#32B67A',
					],
				],
			]
		);

		// Hover Border Color
		$this->add_control(
			'button_border_color_hover',
			[
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-scroll-to-top-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover Box Shadow
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .royal-scroll-to-top-btn:hover',
				'fields_options' => [
					'box_shadow_type' => [
						'default' => 'yes',
					],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 8,
							'blur'       => 25,
							'spread'     => 0,
							'color'      => 'rgba(50, 182, 122, 0.45)',
						],
					],
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		// =========================================================================
		// STYLE TAB: Progress Ring Style
		// =========================================================================
		$this->start_controls_section(
			'progress_style_section',
			[
				'label'     => __( 'Progress Ring Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button_type' => 'progress',
				],
			]
		);

		// Progress Stroke Width
		$this->add_control(
			'progress_stroke_width',
			[
				'label'      => __( 'Stroke Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 1, 'max' => 10, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 3 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-scroll-to-top-wrap' => '--r-stt-stroke-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Progress Color
		$this->add_control(
			'progress_color',
			[
				'label'     => __( 'Progress Fill Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#32B67A',
				'selectors' => [
					'{{WRAPPER}} .royal-scroll-to-top-wrap' => '--r-stt-progress-color: {{VALUE}};',
				],
			]
		);

		// Progress Track Color
		$this->add_control(
			'progress_track_color',
			[
				'label'     => __( 'Background Track Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .royal-stt-ring-track' => 'stroke: {{VALUE}};',
				],
			]
		);

		// Progress Glow
		$this->add_control(
			'progress_glow',
			[
				'label'        => __( 'Glow Effect on Progress', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();


		// =========================================================================
		// STYLE TAB: Typography (Text & Percentage)
		// =========================================================================
		$this->start_controls_section(
			'typography_section',
			[
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .royal-stt-text, {{WRAPPER}} .royal-stt-percentage',
			]
		);

		$this->end_controls_section();


		// =========================================================================
		// STYLE TAB: Tooltip Style
		// =========================================================================
		$this->start_controls_section(
			'tooltip_style_section',
			[
				'label'     => __( 'Tooltip Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_tooltip' => 'yes',
				],
			]
		);

		$this->add_control(
			'tooltip_bg',
			[
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1e293b',
				'selectors' => [
					'{{WRAPPER}} .royal-stt-tooltip'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .royal-stt-tooltip::after' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royal-stt-tooltip' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tooltip_typography',
				'selector' => '{{WRAPPER}} .royal-stt-tooltip',
			]
		);

		$this->add_control(
			'tooltip_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20, 'step' => 1 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 5 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-stt-tooltip' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tooltip_shadow',
				'selector' => '{{WRAPPER}} .royal-stt-tooltip',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$button_type       = ! empty( $settings['button_type'] ) ? $settings['button_type'] : 'icon';
		$position_preset   = ! empty( $settings['position_preset'] ) ? $settings['position_preset'] : 'bottom-right';
		$entrance_anim     = ! empty( $settings['entrance_animation'] ) ? $settings['entrance_animation'] : 'slide-up';
		$idle_anim         = ! empty( $settings['idle_animation'] ) ? $settings['idle_animation'] : 'floating';
		$hover_anim        = ! empty( $settings['hover_animation'] ) ? $settings['hover_animation'] : 'icon-fly-up';
		$click_anim        = ! empty( $settings['click_animation'] ) ? $settings['click_animation'] : 'rocket-launch';
		$glassmorphism     = ! empty( $settings['glassmorphism'] ) && 'yes' === $settings['glassmorphism'];
		$show_percentage   = ! empty( $settings['show_percentage'] ) && 'yes' === $settings['show_percentage'];
		$show_tooltip      = ! empty( $settings['show_tooltip'] ) && 'yes' === $settings['show_tooltip'];
		$tooltip_text      = ! empty( $settings['tooltip_text'] ) ? $settings['tooltip_text'] : __( 'Back to Top', 'royal-addons-for-elementor' );
		$button_text       = ! empty( $settings['button_text'] ) ? $settings['button_text'] : __( 'Top', 'royal-addons-for-elementor' );
		$text_pos          = ! empty( $settings['text_position'] ) ? $settings['text_position'] : 'below';
		$progress_glow     = ! empty( $settings['progress_glow'] ) && 'yes' === $settings['progress_glow'];

		$scroll_offset     = isset( $settings['scroll_offset'] ) ? $settings['scroll_offset'] : 200;
		$scroll_duration   = ! empty( $settings['scroll_duration']['size'] ) ? $settings['scroll_duration']['size'] : 500;
		$smart_direction   = ! empty( $settings['smart_direction_visibility'] ) ? $settings['smart_direction_visibility'] : 'no';
		$auto_hide         = ! empty( $settings['auto_hide'] ) ? $settings['auto_hide'] : 'no';
		$auto_hide_delay   = ! empty( $settings['auto_hide_delay']['size'] ) ? $settings['auto_hide_delay']['size'] : 3;
		$preview_in_editor = ! empty( $settings['preview_in_editor'] ) ? $settings['preview_in_editor'] : 'yes';

		$wrap_classes = [
			'royal-scroll-to-top-wrap',
			'position-' . sanitize_html_class( $position_preset ),
			'entrance-' . sanitize_html_class( $entrance_anim ),
			'royal-stt-hidden', // Initially hidden until scrolled
		];

		if ( 'none' !== $idle_anim ) {
			$wrap_classes[] = 'royal-stt-idle-' . sanitize_html_class( $idle_anim );
		}

		if ( 'none' !== $hover_anim ) {
			$wrap_classes[] = 'royal-stt-hover-' . sanitize_html_class( $hover_anim );
		}

		if ( 'none' !== $click_anim ) {
			$wrap_classes[] = 'royal-stt-click-' . sanitize_html_class( $click_anim );
		}

		if ( $progress_glow ) {
			$wrap_classes[] = 'royal-stt-ring-glow';
		}

		$btn_classes = [ 'royal-scroll-to-top-btn' ];
		if ( $glassmorphism ) {
			$btn_classes[] = 'glassmorphism';
		}

		$content_classes = [
			'royal-stt-content',
			'layout-icon-' . sanitize_html_class( $text_pos ),
		];

		$json_settings = wp_json_encode( [
			'offset'            => (int) $scroll_offset,
			'duration'          => (int) $scroll_duration,
			'smart_direction'   => $smart_direction,
			'auto_hide'         => $auto_hide,
			'auto_hide_delay'   => (int) $auto_hide_delay,
			'click_anim'        => $click_anim,
			'preview_in_editor' => $preview_in_editor,
		] );

		$unique_id = 'royalscrolltotop_' . $this->get_id();
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrap_classes ) ); ?>"
		     id="<?php echo esc_attr( $unique_id ); ?>"
		     data-settings="<?php echo esc_attr( $json_settings ); ?>">

			<a href="#top" id="royalscrolltotop" class="<?php echo esc_attr( implode( ' ', $btn_classes ) ); ?>" role="button" aria-label="<?php echo esc_attr__( 'Scroll to Top', 'royal-addons-for-elementor' ); ?>">

				<?php if ( 'progress' === $button_type || $show_percentage ) : ?>
					<svg class="royal-stt-progress-ring" viewBox="0 0 50 50" aria-hidden="true">
						<circle class="royal-stt-ring-track" cx="25" cy="25" r="22"></circle>
						<circle class="royal-stt-ring-fill" cx="25" cy="25" r="22"></circle>
					</svg>
				<?php endif; ?>

				<div class="<?php echo esc_attr( implode( ' ', $content_classes ) ); ?>">
					<?php if ( 'text' !== $button_type && ! empty( $settings['topicon']['value'] ) ) : ?>
						<span class="royal-stt-icon">
							<?php Icons_Manager::render_icon( $settings['topicon'], [ 'aria-hidden' => 'true' ] ); ?>
						</span>
					<?php endif; ?>

					<?php if ( in_array( $button_type, [ 'text', 'icon_text' ], true ) && ! empty( $button_text ) ) : ?>
						<span class="royal-stt-text"><?php echo esc_html( $button_text ); ?></span>
					<?php endif; ?>

					<?php if ( $show_percentage ) : ?>
						<span class="royal-stt-percentage">0%</span>
					<?php endif; ?>
				</div>

				<?php if ( $show_tooltip && ! empty( $tooltip_text ) ) : ?>
					<span class="royal-stt-tooltip"><?php echo esc_html( $tooltip_text ); ?></span>
				<?php endif; ?>

			</a>

		</div>
		<?php
	}

}
