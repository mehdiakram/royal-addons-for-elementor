<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class RoyalImageCollage extends Widget_Base {

	public function get_name() {
		return 'royalimagecollage';
	}

	public function get_title() {
		return esc_html__( 'Image Collage', 'royal-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid rtbranding';
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'collage', 'image', 'parallax', 'mosaic', 'tilt', 'hero', 'royal', 'interactive', 'float' ];
	}

	public function get_style_depends() {
		return [ 'royalimagecollage' ];
	}

	public function get_script_depends() {
		return [ 'royalimagecollage' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	/* =========================================================
	   CONTENT CONTROLS
	   ========================================================= */
	private function register_content_controls() {

		// 0. Layout Style Preset (7 Distinct Styles)
		$this->start_controls_section(
			'section_layout_preset',
			[
				'label' => esc_html__( 'Layout Style Preset', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'collage_style',
			[
				'label'   => esc_html__( 'Choose Style', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1: 1 + 2 (Left Big, Right 2 Stacked)', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Style 2: 2 + 1 (Left 2 Stacked, Right Big)', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Style 3: 1 + 2 Horizontal (Top Wide, Bottom 2)', 'royal-addons-for-elementor' ),
					'4' => esc_html__( 'Style 4: 2 + 1 Horizontal (Top 2, Bottom Wide)', 'royal-addons-for-elementor' ),
					'5' => esc_html__( 'Style 5: Overlapping Mosaic (Layered 3D Depth)', 'royal-addons-for-elementor' ),
					'6' => esc_html__( 'Style 6: 3 Columns Staggered (Asymmetric Columns)', 'royal-addons-for-elementor' ),
					'7' => esc_html__( 'Style 7: Center Focus (1 Center Big + 2 Floating Flanks)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		// 1. Large Main Image
		$this->start_controls_section(
			'section_main_img',
			[
				'label' => esc_html__( 'Main Featured Image', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'main_image',
			[
				'label'   => esc_html__( 'Choose Image', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'main_image_size',
				'default' => 'large',
			]
		);

		$this->add_control(
			'main_image_zoom',
			[
				'label'        => esc_html__( 'Subtle Zoom Effect (Ken Burns)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'main_image_k',
			[
				'label'       => esc_html__( '3D Depth Multiplier', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0.2,
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'default'     => [
					'size' => 1,
				],
				'description' => esc_html__( 'Controls how much this layer moves when mouse hovers over the collage.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'main_image_link',
			[
				'label'       => esc_html__( 'Link (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		// 2. Small Image 1
		$this->start_controls_section(
			'section_small_img_1',
			[
				'label' => esc_html__( 'Secondary Image 1', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'small_image_1',
			[
				'label'   => esc_html__( 'Choose Image', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'small_image_1_size',
				'default' => 'medium_large',
			]
		);

		$this->add_control(
			'small_image_1_float',
			[
				'label'        => esc_html__( 'Floating Animation', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'small_image_1_k',
			[
				'label'       => esc_html__( '3D Depth Multiplier', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0.2,
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'default'     => [
					'size' => 2,
				],
				'description' => esc_html__( 'Higher multiplier makes this layer move more vigorously for realistic 3D depth.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'small_image_1_link',
			[
				'label'       => esc_html__( 'Link (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		// 3. Small Image 2
		$this->start_controls_section(
			'section_small_img_2',
			[
				'label' => esc_html__( 'Secondary Image 2', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'small_image_2',
			[
				'label'   => esc_html__( 'Choose Image', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'small_image_2_size',
				'default' => 'medium_large',
			]
		);

		$this->add_control(
			'small_image_2_float',
			[
				'label'        => esc_html__( 'Floating Animation', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'small_image_2_k',
			[
				'label'       => esc_html__( '3D Depth Multiplier', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 0.2,
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'default'     => [
					'size' => 3,
				],
			]
		);

		$this->add_control(
			'small_image_2_link',
			[
				'label'       => esc_html__( 'Link (Optional)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		// 4. Floating Badge
		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Floating Badge', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'        => esc_html__( 'Show Badge', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'badge_icon',
			[
				'label'       => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-heartbeat',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_title',
			[
				'label'       => esc_html__( 'Badge Title', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Serving communities', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'e.g. Serving communities', 'royal-addons-for-elementor' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_subtitle',
			[
				'label'       => esc_html__( 'Badge Subtitle', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'since 1996', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'e.g. since 1996', 'royal-addons-for-elementor' ),
				'dynamic'     => [
					'active' => true,
				],
				'condition'   => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_position',
			[
				'label'     => esc_html__( 'Position', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-left',
				'options'   => [
					'bottom-left'  => esc_html__( 'Bottom Left', 'royal-addons-for-elementor' ),
					'top-left'     => esc_html__( 'Top Left', 'royal-addons-for-elementor' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'royal-addons-for-elementor' ),
					'top-right'    => esc_html__( 'Top Right', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_float',
			[
				'label'        => esc_html__( 'Float Animation', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// 5. Interactive 3D Parallax Settings
		$this->start_controls_section(
			'section_parallax',
			[
				'label' => esc_html__( '3D Mouse Parallax Movement', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_parallax',
			[
				'label'        => esc_html__( 'Enable Mouse Parallax', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'When enabled, the photos shift dynamically following the user cursor with realistic 3D depth.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'parallax_intensity',
			[
				'label'       => esc_html__( 'Movement Intensity (px)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 2,
						'max'  => 30,
						'step' => 1,
					],
				],
				'default'     => [
					'size' => 8,
				],
				'condition'   => [
					'enable_parallax' => 'yes',
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-image-collage' => '--tilt-step: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'disable_on_touch',
			[
				'label'        => esc_html__( 'Disable on Touch Devices (Mobile Responsive)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Disables mouse tilt calculation on mobile/touch screens for maximum smoothness and responsive performance.', 'royal-addons-for-elementor' ),
				'condition'    => [
					'enable_parallax' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/* =========================================================
	   STYLE CONTROLS
	   ========================================================= */
	private function register_style_controls() {

		// 1. Layout & Sizing (Fully Responsive)
		$this->start_controls_section(
			'section_style_layout',
			[
				'label' => esc_html__( 'Collage Layout & Size', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'collage_height',
			[
				'label'          => esc_html__( 'Collage Height', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'vh', 'rem' ],
				'range'          => [
					'px' => [
						'min'  => 180,
						'max'  => 850,
						'step' => 5,
					],
					'vh' => [
						'min' => 20,
						'max' => 100,
					],
				],
				'default'        => [
					'unit' => 'px',
					'size' => 430,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 340,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 270,
				],
				'selectors'      => [
					'{{WRAPPER}} .royal-image-collage' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'collage_gap',
			[
				'label'          => esc_html__( 'Gap Between Images', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px' ],
				'range'          => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
				],
				'default'        => [
					'unit' => 'px',
					'size' => 12,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors'      => [
					'{{WRAPPER}} .royal-image-collage' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// 2. Images Style
		$this->start_controls_section(
			'section_style_images',
			[
				'label' => esc_html__( 'Photo Frame Styles', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'          => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px', '%', 'em' ],
				'default'        => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'tablet_default' => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'mobile_default' => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'      => [
					'{{WRAPPER}} .royal-image-collage .royal-ph' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .royal-image-collage .royal-ph',
			]
		);

		$this->add_control(
			'image_bg_color',
			[
				'label'     => esc_html__( 'Placeholder Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cfe3d5',
				'selectors' => [
					'{{WRAPPER}} .royal-image-collage .royal-ph' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_hover_lift',
			[
				'label'        => esc_html__( 'Zoom Image on Hover', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		// 3. Floating Animation Settings
		$this->start_controls_section(
			'section_style_floating',
			[
				'label' => esc_html__( 'Floating Motion Settings', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'float_speed',
			[
				'label'       => esc_html__( 'Float Duration / Speed (Seconds)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 1.5,
						'max'  => 12,
						'step' => 0.5,
					],
				],
				'default'     => [
					'size' => 5,
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-image-collage' => '--float-speed: {{SIZE}}s;',
				],
			]
		);

		$this->add_control(
			'float_distance',
			[
				'label'       => esc_html__( 'Float Distance / Height (px)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min'  => 2,
						'max'  => 25,
						'step' => 1,
					],
				],
				'default'     => [
					'size' => 9,
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-image-collage' => '--float-dist: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		// 4. Badge Style (Responsive)
		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => esc_html__( 'Floating Badge Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royal-image-collage .royal-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0b4d26',
				'selectors' => [
					'{{WRAPPER}} .royal-image-collage .royal-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_icon_bg',
			[
				'label'     => esc_html__( 'Icon Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0b4d26',
				'selectors' => [
					'{{WRAPPER}} .royal-image-collage .royal-badge-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royal-image-collage .royal-badge-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .royal-image-collage .royal-badge',
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label'       => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%' ],
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'     => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-image-collage .royal-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} .royal-image-collage .royal-badge',
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '10',
					'right'    => '16',
					'bottom'   => '10',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-image-collage .royal-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* =========================================================
	   RENDER OUTPUT
	   ========================================================= */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Selected Style (1 to 7)
		$collage_style = ! empty( $settings['collage_style'] ) ? $settings['collage_style'] : '1';

		// Parallax & Interactive Settings
		$enable_parallax    = 'yes' === $settings['enable_parallax'];
		$disable_on_touch   = 'yes' === $settings['disable_on_touch'];
		$parallax_intensity = ! empty( $settings['parallax_intensity']['size'] ) ? $settings['parallax_intensity']['size'] : 8;

		$js_settings = [
			'enable_parallax'    => $enable_parallax,
			'disable_on_touch'   => $disable_on_touch,
			'parallax_intensity' => $parallax_intensity,
		];

		// Hover lift class
		$lift_class = ( 'yes' === $settings['image_hover_lift'] ) ? ' has-hover-lift' : '';

		// Ken Burns class for Main Image
		$kb_class = ( 'yes' === $settings['main_image_zoom'] ) ? ' royal-kb' : '';

		// Float classes
		$float_1_class = ( 'yes' === $settings['small_image_1_float'] ) ? ' royal-float' : '';
		$float_2_class = ( 'yes' === $settings['small_image_2_float'] ) ? ' royal-float' : '';

		// Depth Multipliers
		$k_main = ! empty( $settings['main_image_k']['size'] ) ? $settings['main_image_k']['size'] : 1;
		$k_sm1  = ! empty( $settings['small_image_1_k']['size'] ) ? $settings['small_image_1_k']['size'] : 2;
		$k_sm2  = ! empty( $settings['small_image_2_k']['size'] ) ? $settings['small_image_2_k']['size'] : 3;

		// Links
		if ( ! empty( $settings['main_image_link']['url'] ) ) {
			$this->add_link_attributes( 'main_link', $settings['main_image_link'] );
		}
		if ( ! empty( $settings['small_image_1_link']['url'] ) ) {
			$this->add_link_attributes( 'small_link_1', $settings['small_image_1_link'] );
		}
		if ( ! empty( $settings['small_image_2_link']['url'] ) ) {
			$this->add_link_attributes( 'small_link_2', $settings['small_image_2_link'] );
		}

		?>
		<div class="royal-image-collage-wrap royal-collage-style-<?php echo esc_attr( $collage_style ); ?>">
			<div class="royal-image-collage<?php echo esc_attr( $lift_class ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $js_settings ) ); ?>">
				
				<!-- 1. Main Large Photo -->
				<div class="royal-ph big" style="--k: <?php echo esc_attr( $k_main ); ?>;">
					<?php if ( ! empty( $settings['main_image_link']['url'] ) ) : ?>
						<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'main_link' ) ); ?>>
					<?php endif; ?>

					<?php
					if ( ! empty( $settings['main_image']['url'] ) ) {
						echo Group_Control_Image_Size::get_attachment_image_html(
							$settings,
							'main_image_size',
							'main_image',
							[ 'class' => 'royal-collage-img' . $kb_class ]
						);
					}
					?>

					<?php if ( ! empty( $settings['main_image_link']['url'] ) ) : ?>
						</a>
					<?php endif; ?>
				</div>

				<!-- 2. Small Photo 1 -->
				<div class="royal-ph small sm-1<?php echo esc_attr( $float_1_class ); ?>" style="--k: <?php echo esc_attr( $k_sm1 ); ?>; --fd: 0s;">
					<?php if ( ! empty( $settings['small_image_1_link']['url'] ) ) : ?>
						<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'small_link_1' ) ); ?>>
					<?php endif; ?>

					<?php
					if ( ! empty( $settings['small_image_1']['url'] ) ) {
						echo Group_Control_Image_Size::get_attachment_image_html(
							$settings,
							'small_image_1_size',
							'small_image_1',
							[ 'class' => 'royal-collage-img' ]
						);
					}
					?>

					<?php if ( ! empty( $settings['small_image_1_link']['url'] ) ) : ?>
						</a>
					<?php endif; ?>
				</div>

				<!-- 3. Small Photo 2 -->
				<div class="royal-ph small sm-2<?php echo esc_attr( $float_2_class ); ?>" style="--k: <?php echo esc_attr( $k_sm2 ); ?>; --fd: -2.5s;">
					<?php if ( ! empty( $settings['small_image_2_link']['url'] ) ) : ?>
						<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'small_link_2' ) ); ?>>
					<?php endif; ?>

					<?php
					if ( ! empty( $settings['small_image_2']['url'] ) ) {
						echo Group_Control_Image_Size::get_attachment_image_html(
							$settings,
							'small_image_2_size',
							'small_image_2',
							[ 'class' => 'royal-collage-img' ]
						);
					}
					?>

					<?php if ( ! empty( $settings['small_image_2_link']['url'] ) ) : ?>
						</a>
					<?php endif; ?>
				</div>

				<!-- 4. Floating Badge -->
				<?php if ( 'yes' === $settings['show_badge'] ) :
					$badge_pos_class   = ! empty( $settings['badge_position'] ) ? 'pos-' . $settings['badge_position'] : 'pos-bottom-left';
					$badge_float_class = ( 'yes' === $settings['badge_float'] ) ? ' badge-floating' : '';
				?>
					<div class="royal-badge <?php echo esc_attr( $badge_pos_class . $badge_float_class ); ?>">
						<?php if ( ! empty( $settings['badge_icon']['value'] ) ) : ?>
							<div class="royal-badge-icon">
								<?php Icons_Manager::render_icon( $settings['badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['badge_title'] ) || ! empty( $settings['badge_subtitle'] ) ) : ?>
							<div class="royal-badge-text">
								<?php if ( ! empty( $settings['badge_title'] ) ) : ?>
									<span class="royal-badge-title"><?php echo esc_html( $settings['badge_title'] ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $settings['badge_subtitle'] ) ) : ?>
									<span class="royal-badge-subtitle"><?php echo esc_html( $settings['badge_subtitle'] ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
		<?php
	}
}
