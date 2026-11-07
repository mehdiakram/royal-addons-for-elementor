<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalButtonEffects extends Widget_Base {

	public function get_name() {
		return 'royalbuttoneffects';
	}

	public function get_title() {
		return __( 'Button Effects', 'royal-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-button rtbranding';
	}

	public function get_keywords() {
		return [ 'button', 'effects', '3d', 'shine', 'glow', 'modern', 'pulse', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_style_depends() {
		return [ 'royalbuttoneffects' ];
	}

	protected function register_controls() {
		// Content: Button Effects Section
		$this->start_controls_section(
			'buttoneffects_section',
			[
				'label' => __( 'Button Effects', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'buttoneffects',
			[
				'label'   => __( 'Effects', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shineeffect',
				'options' => [
					'shineeffect'      => __( 'Shine & Light Effect', 'royal-addons-for-elementor' ),
					'moderneffect'     => __( 'Modern UI/UX Effect', 'royal-addons-for-elementor' ),
					'slideeffect'      => __( 'Slide Effect', 'royal-addons-for-elementor' ),
					'bordereffect'     => __( 'Border Effect', 'royal-addons-for-elementor' ),
					'shadoweffect'     => __( 'Shadow Effect', 'royal-addons-for-elementor' ),
					'backgroundeffect' => __( 'Background Effect', 'royal-addons-for-elementor' ),
					'animatingeffect'  => __( 'Animating Effect', 'royal-addons-for-elementor' ),
					'otherseffect'     => __( 'Others Effect', 'royal-addons-for-elementor' ),
				],
			]
		);

		// Shine & Light Effect (including Unnayan Prochesta button)
		$this->add_control(
			'shineeffect',
			[
				'label'     => __( 'Shine Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'shinestyle1',
				'options'   => [
					'shinestyle1' => __( 'Light Sweep', 'royal-addons-for-elementor' ),
					'shinestyle2' => __( 'Glass Glare Spotlight', 'royal-addons-for-elementor' ),
					'shinestyle3' => __( 'Double Light Beam', 'royal-addons-for-elementor' ),
					'shinestyle4' => __( 'Laser Shimmer Beam', 'royal-addons-for-elementor' ),
					'shinestyle5' => __( 'Rainbow Prismatic Sheen', 'royal-addons-for-elementor' ),
					'shinestyle6' => __( 'Soft Halo Flash', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'shineeffect',
				],
			]
		);

		// Modern UI/UX Effect
		$this->add_control(
			'moderneffect',
			[
				'label'     => __( 'Modern Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'modernstyle1',
				'options'   => [
					'modernstyle1'  => __( '3D SaaS Elevation Lift', 'royal-addons-for-elementor' ),
					'modernstyle2'  => __( 'Rotating Border Beam (Aceternity)', 'royal-addons-for-elementor' ),
					'modernstyle3'  => __( 'Pulse Ping Ripple Ring', 'royal-addons-for-elementor' ),
					'modernstyle4'  => __( 'Cyberpunk Tech Corners', 'royal-addons-for-elementor' ),
					'modernstyle5'  => __( 'Liquid Jelly Squish', 'royal-addons-for-elementor' ),
					'modernstyle6'  => __( 'Flowing Aurora Gradient', 'royal-addons-for-elementor' ),
					'modernstyle7'  => __( 'Frosted Glass Neumorph', 'royal-addons-for-elementor' ),
					'modernstyle8'  => __( 'Arrow Icon Slide Reveal', 'royal-addons-for-elementor' ),
					'modernstyle9'  => __( '3D Mechanical Press', 'royal-addons-for-elementor' ),
					'modernstyle10' => __( 'Glow Pill Radial Flare', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'moderneffect',
				],
			]
		);

		// Slide Effect
		$this->add_control(
			'slideeffect',
			[
				'label'     => __( 'Slide Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slidestyle1',
				'options'   => [
					'slidestyle1'  => __( 'Slide Style 1', 'royal-addons-for-elementor' ),
					'slidestyle2'  => __( 'Slide Style 2', 'royal-addons-for-elementor' ),
					'slidestyle3'  => __( 'Slide Style 3', 'royal-addons-for-elementor' ),
					'slidestyle4'  => __( 'Slide Style 4', 'royal-addons-for-elementor' ),
					'slidestyle5'  => __( 'Slide Style 5', 'royal-addons-for-elementor' ),
					'slidestyle6'  => __( 'Slide Style 6', 'royal-addons-for-elementor' ),
					'slidestyle7'  => __( 'Slide Style 7', 'royal-addons-for-elementor' ),
					'slidestyle8'  => __( 'Slide Style 8', 'royal-addons-for-elementor' ),
					'slidestyle9'  => __( 'Slide Style 9', 'royal-addons-for-elementor' ),
					'slidestyle10' => __( 'Slide Style 10', 'royal-addons-for-elementor' ),
					'slidestyle11' => __( 'Slide Style 11 (Diagonal)', 'royal-addons-for-elementor' ),
					'slidestyle12' => __( 'Slide Style 12 (Circle Expand)', 'royal-addons-for-elementor' ),
					'slidestyle13' => __( 'Slide Style 13 (Split Meet)', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'slideeffect',
				],
			]
		);

		// Border Effect
		$this->add_control(
			'bordereffect',
			[
				'label'     => __( 'Border Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'borderstyle1',
				'options'   => [
					'borderstyle1'  => __( 'Border Style 1', 'royal-addons-for-elementor' ),
					'borderstyle2'  => __( 'Border Style 2', 'royal-addons-for-elementor' ),
					'borderstyle3'  => __( 'Border Style 3', 'royal-addons-for-elementor' ),
					'borderstyle4'  => __( 'Border Style 4', 'royal-addons-for-elementor' ),
					'borderstyle5'  => __( 'Border Style 5', 'royal-addons-for-elementor' ),
					'borderstyle6'  => __( 'Border Style 6', 'royal-addons-for-elementor' ),
					'borderstyle7'  => __( 'Border Style 7', 'royal-addons-for-elementor' ),
					'borderstyle8'  => __( 'Border Style 8', 'royal-addons-for-elementor' ),
					'borderstyle9'  => __( 'Border Style 9 (Corner Accent)', 'royal-addons-for-elementor' ),
					'borderstyle10' => __( 'Border Style 10 (Offset Brutalist)', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'bordereffect',
				],
			]
		);

		// Shadow Effect
		$this->add_control(
			'shadoweffect',
			[
				'label'     => __( 'Shadow Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'shadowstyle1',
				'options'   => [
					'shadowstyle1'  => __( 'Shadow Style 1', 'royal-addons-for-elementor' ),
					'shadowstyle2'  => __( 'Shadow Style 2', 'royal-addons-for-elementor' ),
					'shadowstyle3'  => __( 'Shadow Style 3', 'royal-addons-for-elementor' ),
					'shadowstyle4'  => __( 'Shadow Style 4', 'royal-addons-for-elementor' ),
					'shadowstyle5'  => __( 'Shadow Style 5', 'royal-addons-for-elementor' ),
					'shadowstyle6'  => __( 'Shadow Style 6', 'royal-addons-for-elementor' ),
					'shadowstyle7'  => __( 'Shadow Style 7', 'royal-addons-for-elementor' ),
					'shadowstyle8'  => __( 'Shadow Style 8 (3D Isometric Extrude)', 'royal-addons-for-elementor' ),
					'shadowstyle9'  => __( 'Shadow Style 9 (Neon Ambient Glow)', 'royal-addons-for-elementor' ),
					'shadowstyle10' => __( 'Shadow Style 10 (Soft Apple Elevation)', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'shadoweffect',
				],
			]
		);

		// Background Effect
		$this->add_control(
			'backgroundeffect',
			[
				'label'     => __( 'Background Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'backgroundstyle1',
				'options'   => [
					'backgroundstyle1'  => __( 'Background Style 1', 'royal-addons-for-elementor' ),
					'backgroundstyle2'  => __( 'Background Style 2', 'royal-addons-for-elementor' ),
					'backgroundstyle3'  => __( 'Background Style 3', 'royal-addons-for-elementor' ),
					'backgroundstyle4'  => __( 'Background Style 4', 'royal-addons-for-elementor' ),
					'backgroundstyle5'  => __( 'Background Style 5', 'royal-addons-for-elementor' ),
					'backgroundstyle6'  => __( 'Background Style 6', 'royal-addons-for-elementor' ),
					'backgroundstyle7'  => __( 'Background Style 7', 'royal-addons-for-elementor' ),
					'backgroundstyle8'  => __( 'Background Style 8', 'royal-addons-for-elementor' ),
					'backgroundstyle9'  => __( 'Background Style 9', 'royal-addons-for-elementor' ),
					'backgroundstyle10' => __( 'Background Style 10 (Radial Ripple)', 'royal-addons-for-elementor' ),
					'backgroundstyle11' => __( 'Background Style 11 (Curtain Reveal)', 'royal-addons-for-elementor' ),
					'backgroundstyle12' => __( 'Background Style 12 (Mesh Gradient Shift)', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'backgroundeffect',
				],
			]
		);

		// Animating Effect
		$this->add_control(
			'animatingeffect',
			[
				'label'     => __( 'Animating Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'animatingping1',
				'options'   => [
					'animatingping1'           => __( 'Ping Ripple Ring', 'royal-addons-for-elementor' ),
					'animatinggradientrotate1' => __( 'Conic Border Beam', 'royal-addons-for-elementor' ),
					'animatingheartbeat1'      => __( 'Heartbeat Throb', 'royal-addons-for-elementor' ),
					'animatingshimmer1'        => __( 'Continuous Shimmer Wave', 'royal-addons-for-elementor' ),
					'animatingbounce1'         => __( 'Floating Gentle Bounce', 'royal-addons-for-elementor' ),
					'animatingglowing1'        => __( 'Glowing Effect 1', 'royal-addons-for-elementor' ),
					'animatingglowing2'        => __( 'Glowing Effect 2', 'royal-addons-for-elementor' ),
					'animatingglowing3'        => __( 'Glowing Effect 3', 'royal-addons-for-elementor' ),
					'animatingpulsing1'        => __( 'Pulsing Effect 1', 'royal-addons-for-elementor' ),
					'animatingpulsing2'        => __( 'Pulsing Effect 2', 'royal-addons-for-elementor' ),
					'animatingpulsing3'        => __( 'Pulsing Effect 3', 'royal-addons-for-elementor' ),
					'animatingsnakeborder1'    => __( 'Snake Border Effect 1', 'royal-addons-for-elementor' ),
					'animatingwiggle1'         => __( 'Wiggle Effect 1', 'royal-addons-for-elementor' ),
					'animatingfloat1'          => __( 'Float Effect 1', 'royal-addons-for-elementor' ),
					'animatingneon1'           => __( 'Neon Effect 1', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'animatingeffect',
				],
			]
		);

		// Others Effect
		$this->add_control(
			'otherseffect',
			[
				'label'     => __( 'Others Style', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cloudeffect1',
				'options'   => [
					'cloudeffect1'  => __( 'Cloud 1', 'royal-addons-for-elementor' ),
					'halfeffect1'   => __( 'Half 1', 'royal-addons-for-elementor' ),
					'halfeffect2'   => __( 'Half 2', 'royal-addons-for-elementor' ),
					'filtereffect1' => __( 'Filter 1', 'royal-addons-for-elementor' ),
					'gooeyeffect1'  => __( 'Gooey 1', 'royal-addons-for-elementor' ),
					'swipe1'        => __( 'Swipe 1', 'royal-addons-for-elementor' ),
					'alternate1'    => __( 'Alternate 1', 'royal-addons-for-elementor' ),
					'diagonals1'    => __( 'Diagonals 1', 'royal-addons-for-elementor' ),
					'pushin'        => __( 'Push In', 'royal-addons-for-elementor' ),
					'pushout'       => __( 'Push Out', 'royal-addons-for-elementor' ),
					'overfold'      => __( 'Overfold', 'royal-addons-for-elementor' ),
					'bubbledown'    => __( 'Bubble Down', 'royal-addons-for-elementor' ),
					'doubledown'    => __( 'Double Down', 'royal-addons-for-elementor' ),
					'burst'         => __( 'Burst', 'royal-addons-for-elementor' ),
					'glowing'       => __( 'Glowing', 'royal-addons-for-elementor' ),
					'fortnite'      => __( 'Fortnite', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'buttoneffects' => 'otherseffect',
				],
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => __( 'Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Click here', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Click here', 'royal-addons-for-elementor' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'button_url',
			[
				'label'         => __( 'Link', 'royal-addons-for-elementor' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://www.royaltechbd.com', 'royal-addons-for-elementor' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
				'dynamic'       => [
					'active' => true,
				],
			]
		);

		$this->add_responsive_control(
			'buttonalignment',
			[
				'label'       => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'    => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'separator'    => 'before',
				'default'      => 'center',
				'prefix_class' => 'elementor%s-align-',
				'selectors'    => [
					'{{WRAPPER}} .royalbuttonstyle' => '{{VALUE}};',
				],
				'selectors_dictionary' => [
					'left'    => 'justify-content: flex-start; text-align: left;',
					'center'  => 'justify-content: center; text-align: center;',
					'right'   => 'justify-content: flex-end; text-align: right;',
					'justify' => 'justify-content: stretch; width: 100%;',
				],
			]
		);

		$this->add_responsive_control(
			'transition',
			[
				'label'      => esc_html__( 'Transition', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0.4,
				],
				'selectors'  => [
					'{{WRAPPER}} .royalbuttonstyle' => '--transition: {{SIZE}}s;',
				],
			]
		);

		$this->end_controls_section();

		// Content: Icon Section
		$this->start_controls_section(
			'icon_section',
			[
				'label' => __( 'Icon Section', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'            => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'default'          => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'       => esc_html__( 'Icon Position (ডানে / বামে)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'right',
				'options'     => [
					'left'  => [
						'title' => esc_html__( 'Left (Before Text)', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right (After Text)', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'toggle'      => false,
			]
		);

		$this->add_responsive_control(
			'icon_indent',
			[
				'label'     => esc_html__( 'Icon Spacing', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext svg'       => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext i'         => 'font-size: {{SIZE}}{{UNIT}}; line-height: 1;',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .royal-btn-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style: Button Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typo',
				'label'    => __( 'Typography', 'royal-addons-for-elementor' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalbuttonstyle .royalbutton, {{WRAPPER}} .royalbuttonstyle .royalbutton .icontext, {{WRAPPER}} .royalbuttonstyle .royalbutton .icontext .text',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalbuttonstyle .royalbutton' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalbuttonstyle .royalbutton' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .royalbuttonstyle .royalbutton',
			]
		);

		$this->add_control(
			'borderradius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalbuttonstyle .royalbutton' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton::before' => 'border-radius: inherit;',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton::after' => 'border-radius: inherit;',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton-animatingglowing1:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton-animatingglowing1:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style' );

		// Normal Tab
		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'buttoncolor',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconcolor',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext svg'       => 'fill: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext svg path'  => 'fill: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .icontext i'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton .royal-btn-icon'     => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royalbuttonstyle .royalbutton, {{WRAPPER}} .royalbuttonstyle .royalbutton-animatingglowing1:after',
			]
		);

		$this->add_control(
			'color1',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Primary / Default Background Color', 'royal-addons-for-elementor' ),
				'default'   => '#0b4d26',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle' => '--color1: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'color2',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Secondary / Accent Color 2', 'royal-addons-for-elementor' ),
				'default'   => '#c9a24a',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle' => '--color2: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .royalbuttonstyle .royalbutton',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'buttonhovercolor',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover .icontext' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover .icontext .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'iconcolorhover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover .icontext svg'      => 'fill: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover .icontext svg path' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover .icontext i'        => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalbuttonstyle .royalbutton:hover .royal-btn-icon'    => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background_hover',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royalbuttonstyle .royalbutton:hover',
			]
		);

		$this->add_control(
			'backgroundcolorhover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Hover Background / Sweep Color', 'royal-addons-for-elementor' ),
				'default'   => '#063519',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle' => '--backgroundcolorhover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bordercolorhover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'default'   => '#c9a24a',
				'selectors' => [
					'{{WRAPPER}} .royalbuttonstyle' => '--bordercolorhover: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .royalbuttonstyle .royalbutton:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		$settings      = $this->get_settings_for_display();
		$buttoneffects = ! empty( $settings['buttoneffects'] ) ? $settings['buttoneffects'] : 'shineeffect';
		$buttonstyle   = ! empty( $settings[ $buttoneffects ] ) ? $settings[ $buttoneffects ] : 'shinestyle1';

		$url         = ! empty( $settings['button_url']['url'] ) ? esc_url( $settings['button_url']['url'] ) : '#';
		$is_external = ! empty( $settings['button_url']['is_external'] );
		$nofollow    = ! empty( $settings['button_url']['nofollow'] );

		$link_attrs = ' href="' . $url . '"';
		if ( $is_external ) {
			$link_attrs .= ' target="_blank" rel="noopener noreferrer' . ( $nofollow ? ' nofollow' : '' ) . '"';
		} elseif ( $nofollow ) {
			$link_attrs .= ' rel="nofollow"';
		}

		$align_class = ! empty( $settings['buttonalignment'] ) ? 'royalalign' . esc_attr( $settings['buttonalignment'] ) : '';

		$category_map = [
			'shineeffect'      => 'shineeffect royalbutton-shine',
			'moderneffect'     => 'moderneffect royalbutton-modern',
			'slideeffect'      => 'slidestyle',
			'bordereffect'     => 'borderstyle',
			'shadoweffect'     => 'shadowstyle',
			'backgroundeffect' => 'backgroundstyle backgroundwstyle',
			'animatingeffect'  => 'animatingeffect',
			'otherseffect'     => 'otherseffect',
		];
		$cat_class = isset( $category_map[ $buttoneffects ] ) ? $category_map[ $buttoneffects ] : '';

		?>
		<div class="royalbuttonstyle <?php echo esc_attr( $align_class ); ?>">
			<a class="royalbutton royalbutton-<?php echo esc_attr( $buttonstyle ); ?> <?php echo esc_attr( $cat_class ); ?>"<?php echo $link_attrs; ?>>
				<?php
				if ( 'animatingsnakeborder1' === $buttonstyle ) {
					echo '<span></span><span></span><span></span><span></span>';
				} elseif ( 'cloudeffect1' === $buttonstyle ) {
					echo '<div class="cloudes"><span></span><span></span><span></span><span></span></div>';
				} elseif ( 'gooeyeffect1' === $buttonstyle ) {
					?>
					<span class="bubbles">
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
						<span class="bubble"></span>
					</span>
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="position: absolute; width: 0; height: 0;">
						<defs>
							<filter id="gooey">
								<feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur" />
								<feColorMatrix in="blur" type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="highContrastGraphic" />
								<feComposite in="SourceGraphic" in2="highContrastGraphic" operator="atop" />
							</filter>
						</defs>
					</svg>
					<?php
				} elseif ( 'filtereffect1' === $buttonstyle ) {
					?>
					<svg style="visibility: hidden; position: absolute;" width="0" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1">
						<defs>
							<filter id="goo">
								<feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
								<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
								<feComposite in="SourceGraphic" in2="goo" operator="atop"/>
							</filter>
						</defs>
					</svg>
					<?php
				}

				$this->icontext();
				?>
			</a>
		</div>
		<?php
	}

	protected function icontext() {
		$settings   = $this->get_settings_for_display();
		$icon_align = ! empty( $settings['icon_align'] ) ? $settings['icon_align'] : 'right';
		$text       = isset( $settings['text'] ) ? $settings['text'] : '';
		$has_icon   = ! empty( $settings['selected_icon']['value'] );

		echo '<span class="icontext royal-icon-align-' . esc_attr( $icon_align ) . '">';
		if ( 'left' === $icon_align ) {
			if ( $has_icon ) {
				echo '<span class="royal-btn-icon royal-btn-icon-left">';
				\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
				echo '</span>';
			}
			if ( '' !== $text ) {
				echo '<span class="text">' . esc_html( $text ) . '</span>';
			}
		} else {
			if ( '' !== $text ) {
				echo '<span class="text">' . esc_html( $text ) . '</span>';
			}
			if ( $has_icon ) {
				echo '<span class="royal-btn-icon royal-btn-icon-right">';
				\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
				echo '</span>';
			}
		}
		echo '</span>';
	}
}
