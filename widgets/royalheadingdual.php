<?php
namespace RoyalAddons\Widgets;

use royalAddons\Includes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use RoyalAddons\Elementor\Royal_Helpers;


if ( ! defined( 'ABSPATH' ) ) {	exit; }


class RoyalHeadingDual extends Widget_Base {

	public function get_name() {
		return 'royalheadingdual';
	}

	
	public function get_title() {
		return __( 'Dual Heading', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-heading rtbranding'; }

	  
	public function get_keywords() {
		return [ 'dual', 'header', 'heading', 'double', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
	
	
	public function get_categories(){
		return ['royaltech'];
	}


	public function get_style_depends() {
		return array(
			'royalheadingdual',
		);
	}

	
	public function get_script_depends() {
		return array(
			'royalheadingdual',
			'waypoints',
		);
	}


	protected function register_controls() { 
		$this->start_controls_section(
			'royal_dual_header_general_settings',
			array(
				'label' => __( 'Dual Heading', 'royal-addons-for-elementor' ),
			)
		);

		
		$this->add_control(
			'royal_dual_header_first_header_text',
			array(
				'label'       => __( 'First Heading', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Royal', 'royal-addons-for-elementor' ),
				'label_block' => true,
			)
		);

		
		$this->add_control(
			'royal_dual_header_second_header_text',
			array(
				'label'       => __( 'Second Heading', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true ),
				'default'     => __( 'Addons', 'royal-addons-for-elementor' ),
				'label_block' => true,
			)
		);

		
		$this->add_control(
			'royal_dual_header_first_header_tag',
			array(
				'label'       => __( 'HTML Tag', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h2',
				'options'     => Royal_Helpers::royal_title_tags(),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_position',
			array(
				'label'        => __( 'Display', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'inline' => __( 'Inline', 'royal-addons-for-elementor' ),
					'block'  => __( 'Block', 'royal-addons-for-elementor' ),
				),
				'default'      => 'inline',
				'prefix_class' => 'royal-header-',
				'selectors'    => array(
					'{{WRAPPER}} .royal-dual-header-first-header span' => 'display: {{VALUE}}',
				),
				'label_block'  => true,
			)
		);

		$this->add_control(
			'royal_dual_header_link_switcher',
			array(
				'label'       => __( 'Link', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Enable or disable link', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'royal_dual_heading_link_selection',
			array(
				'label'       => __( 'Link Type', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'url'  => __( 'URL', 'royal-addons-for-elementor' ),
					'link' => __( 'Existing Page', 'royal-addons-for-elementor' ),
				),
				'default'     => 'url',
				'label_block' => true,
				'condition'   => array(
					'royal_dual_header_link_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'royal_dual_heading_link',
			array(
				'label'       => __( 'Link', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array( 'active' => true ),
				'default'     => array(
					'url' => '#',
				),
				'placeholder' => 'https://www.royaltechbd.com/',
				'label_block' => true,
				'separator'   => 'after',
				'condition'   => array(
					'royal_dual_header_link_switcher'   => 'yes',
					'royal_dual_heading_link_selection' => 'url',
				),
			)
		);

		$this->add_control(
			'royal_dual_heading_existing_link',
			array(
				'label'       => __( 'Existing Page', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => Royal_Helpers::royal_all_posts(),
				'condition'   => array(
					'royal_dual_header_link_switcher'   => 'yes',
					'royal_dual_heading_link_selection' => 'link',
				),
				'multiple'    => false,
				'separator'   => 'after',
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_text_align',
			array(
				'label'     => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'first_rotate',
			array(
				'label'     => __( 'First Heading Rotation (degrees)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -180,
				'max'       => 180,
				'selectors' => array(
					'{{WRAPPER}}.royal-header-inline .royal-dual-header-first-span' => 'display:inline-block !important; transform: rotate({{VALUE}}deg);',
					'{{WRAPPER}}.royal-header-block .royal-dual-header-first-span' => 'transform: rotate({{VALUE}}deg);',
				),
			)
		);

		$this->add_responsive_control(
			'second_rotate',
			array(
				'label'     => __( 'Second Heading Rotation (degrees)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -180,
				'max'       => 180,
				'selectors' => array(
					'{{WRAPPER}}.royal-header-inline .royal-dual-header-second-header' => 'display:inline-block !important; transform: rotate({{VALUE}}deg);',
					'{{WRAPPER}}.royal-header-block .royal-dual-header-second-header' => 'transform: rotate({{VALUE}}deg);',
				),
			)
		);

		$this->add_responsive_control(
			'transform_origin_x',
			array(
				'label'       => __( 'X Anchor Point', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'center',
				'options'     => array(
					'left'   => array(
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'label_block' => false,
				'toggle'      => false,
				'render_type' => 'ui',
				'condition'   => array(
					'rotate!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'transform_origin_y',
			array(
				'label'       => __( 'Y Anchor Point', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'center',
				'options'     => array(
					'top'    => array(
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => __( 'Bottom', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors'   => array(
					'{{WRAPPER}} .elementor-widget-container' => 'transform-origin: {{transform_origin_x.VALUE}} {{VALUE}}',
				),
				'label_block' => false,
				'toggle'      => false,
				'condition'   => array(
					'rotate!' => '',
				),
			)
		);

		$this->add_control(
			'background_text_switcher',
			array(
				'label'        => __( 'Background Text', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'separator'    => 'before',
				'prefix_class' => 'royal-bg-text-',
			)
		);

		$this->add_control(
			'background_text',
			array(
				'label'     => __( 'Text', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Awesome Title', 'royal-addons-for-elementor' ),
				'condition' => array(
					'background_text_switcher' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'content: "{{VALUE}}"',
				),

			)
		);

		$this->add_control(
			'background_text_width',
			array(
				'label'       => __( 'Width', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'auto' => __( 'Auto', 'royal-addons-for-elementor' ),
					'100%' => __( 'Full Width', 'royal-addons-for-elementor' ),
				),
				'default'     => 'auto',
				'label_block' => true,
				'selectors'   => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'width: {{VALUE}}',
				),
				'condition'   => array(
					'background_text_switcher' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'background_text_left',
			array(
				'label'      => __( 'Horizontal Offset', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => -500,
						'max' => 500,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'left: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'background_text_switcher' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'background_text_top',
			array(
				'label'      => __( 'Vertical Offset', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => -500,
						'max' => 500,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
					'%'  => array(
						'min' => -100,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'top: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'background_text_switcher' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'background_text_align',
			array(
				'label'     => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'text-align: {{VALUE}};',
				),
				'condition' => array(
					'background_text_switcher' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'background_text_rotate',
			array(
				'label'      => __( 'Rotate (degrees)', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'default'    => array(
					'unit' => 'deg',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'transform: rotate({{SIZE}}{{UNIT}})',
				),
				'condition'  => array(
					'background_text_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'mask_switcher',
			array(
				'label'        => __( 'Minimal Mask Effect', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'render_type'  => 'template',
				'prefix_class' => 'royal-mask-',
				'description'  => __( 'Please note That this effect takes place once the element is in the viewport', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'mask_color',
			array(
				'label'       => __( 'Mask Color', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}}.royal-mask-yes .royal-dual-header-first-header span::after'   => 'background: {{VALUE}};',
				),
				'condition'   => array(
					'mask_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'royal_mask_dir',
			array(
				'label'        => __( 'Direction', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'tr',
				'prefix_class' => 'royal-mask-',
				'render_type'  => 'template',
				'options'      => array(
					'tr' => __( 'To Right', 'royal-addons-for-elementor' ),
					'tl' => __( 'To Left', 'royal-addons-for-elementor' ),
					'tt' => __( 'To Top', 'royal-addons-for-elementor' ),
					'tb' => __( 'To Bottom', 'royal-addons-for-elementor' ),
				),
				'condition'    => array(
					'mask_switcher' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'mask_padding',
			array(
				'label'      => __( 'Words Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-mask-span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'mask_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'noise_first',
			array(
				'label'        => __( 'First Heading Noise Effect', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'royal-title-first-noise-',
				'render_type'  => 'template',
				'condition'    => array(
					'mask_switcher!'                      => 'yes',
					'royal_dual_header_first_back_clip' => 'color',
				),
			)
		);

		$this->add_control(
			'noise_second',
			array(
				'label'        => __( 'Second Heading Noise Effect', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'royal-title-second-noise-',
				'render_type'  => 'template',
				'condition'    => array(
					'mask_switcher!'                       => 'yes',
					'royal_dual_header_second_back_clip' => 'color',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'royal_dual_header_first_style',
			array(
				'label' => __( 'First Heading', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'first_header_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .royal-dual-header-first-span',
			)
		);

		$this->add_control(
			'royal_dual_header_first_animated',
			array(
				'label' => __( 'Animated Background', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'royal_dual_header_first_back_clip',
			array(
				'label'       => __( 'Background Style', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'color',
				'description' => __( 'Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.', 'royal-addons-for-elementor' ),
				'options'     => array(
					'color'   => __( 'Normal', 'royal-addons-for-elementor' ),
					'clipped' => __( 'Clipped', 'royal-addons-for-elementor' ),
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'royal_dual_header_first_color',
			array(
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'condition' => array(
					'royal_dual_header_first_back_clip' => 'color',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-first-span'   => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'royal_dual_header_first_background',
				'types'     => array( 'classic', 'gradient' ),
				'condition' => array(
					'royal_dual_header_first_back_clip' => 'color',
				),
				'selector'  => '{{WRAPPER}} .royal-dual-header-first-span',
			)
		);

		$this->add_control(
			'royal_dual_header_first_stroke',
			array(
				'label'     => __( 'Stroke', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'royal_dual_header_first_back_clip' => 'clipped',
				),
			)
		);

		$this->add_control(
			'royal_dual_header_first_stroke_text_color',
			array(
				'label'     => __( 'Stroke Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'royal_dual_header_first_back_clip' => 'clipped',
					'royal_dual_header_first_stroke'    => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-first-clip.stroke .royal-dual-header-first-span'   => '-webkit-text-stroke-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'royal_dual_header_first_stroke_color',
			array(
				'label'     => __( 'Stroke Fill Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'royal_dual_header_first_back_clip' => 'clipped',
					'royal_dual_header_first_stroke'    => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-first-clip.stroke .royal-dual-header-first-span'   => '-webkit-text-fill-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_first_stroke_width',
			array(
				'label'     => __( 'Stroke Fill Width', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'royal_dual_header_first_back_clip' => 'clipped',
					'royal_dual_header_first_stroke'    => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-first-clip.stroke .royal-dual-header-first-span'   => '-webkit-text-stroke-width: {{SIZE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'royal_dual_header_first_clipped_background',
				'types'     => array( 'classic', 'gradient' ),
				'condition' => array(
					'royal_dual_header_first_back_clip' => 'clipped',
					'royal_dual_header_first_stroke!'   => 'yes',
				),
				'selector'  => '{{WRAPPER}} .royal-dual-header-first-span',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'first_header_border',
				'selector'  => '{{WRAPPER}} .royal-dual-header-first-span',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'royal_dual_header_first_border_radius',
			array(
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-dual-header-first-span' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'    => __( 'Shadow', 'royal-addons-for-elementor' ),
				'name'     => 'royal_dual_header_first_text_shadow',
				'selector' => '{{WRAPPER}} .royal-dual-header-first-span',
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_first_margin',
			array(
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .royal-dual-header-first-span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_first_padding',
			array(
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-dual-header-first-span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'first_noise_heading',
			array(
				'label'     => __( 'Glitch Effect', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'noise_first' => 'yes',
				),
			)
		);

		$this->add_control(
			'noise_first_color',
			array(
				'label'     => __( 'Color #1', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'noise_first' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-title-first-noise-yes .royal-dual-header-first-span::before' => 'text-shadow: 1px 0 {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'noise_second_color',
			array(
				'label'     => __( 'Color #2', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'noise_first' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-title-first-noise-yes .royal-dual-header-first-span::after' => 'text-shadow: -1px 0 {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'royal_dual_header_second_style',
			array(
				'label' => __( 'Second Heading', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'second_header_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .royal-dual-header-second-header',
			)
		);

		$this->add_control(
			'royal_dual_header_second_animated',
			array(
				'label' => __( 'Animated Background', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'royal_dual_header_second_back_clip',
			array(
				'label'       => __( 'Background Style', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'color',
				'description' => __( 'Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.', 'royal-addons-for-elementor' ),
				'options'     => array(
					'color'   => __( 'Normal', 'royal-addons-for-elementor' ),
					'clipped' => __( 'Clipped', 'royal-addons-for-elementor' ),
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'royal_dual_header_second_color',
			array(
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'condition' => array(
					'royal_dual_header_second_back_clip' => 'color',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-second-header'   => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'royal_dual_header_second_background',
				'types'     => array( 'classic', 'gradient' ),
				'condition' => array(
					'royal_dual_header_second_back_clip' => 'color',
				),
				'selector'  => '{{WRAPPER}} .royal-dual-header-second-header',
			)
		);

		$this->add_control(
			'royal_dual_header_second_stroke',
			array(
				'label'     => __( 'Stroke', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'royal_dual_header_second_back_clip' => 'clipped',
				),
			)
		);

		$this->add_control(
			'royal_dual_header_second_stroke_text_color',
			array(
				'label'     => __( 'Stroke Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'royal_dual_header_second_back_clip' => 'clipped',
					'royal_dual_header_second_stroke'    => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-second-clip.stroke'   => '-webkit-text-stroke-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'royal_dual_header_second_stroke_color',
			array(
				'label'     => __( 'Stroke Fill Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'royal_dual_header_second_back_clip' => 'clipped',
					'royal_dual_header_second_stroke'    => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-second-clip.stroke'   => '-webkit-text-fill-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_second_stroke_width',
			array(
				'label'     => __( 'Stroke Fill Width', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'royal_dual_header_second_back_clip' => 'clipped',
					'royal_dual_header_second_stroke'    => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .royal-dual-header-second-clip.stroke'   => '-webkit-text-stroke-width: {{SIZE}}px;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'royal_dual_header_second_clipped_background',
				'types'     => array( 'classic', 'gradient' ),
				'condition' => array(
					'royal_dual_header_second_back_clip' => 'clipped',
					'royal_dual_header_second_stroke!'   => 'yes',
				),
				'selector'  => '{{WRAPPER}} .royal-dual-header-second-header',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'second_header_border',
				'selector'  => '{{WRAPPER}} .royal-dual-header-second-header',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'royal_dual_header_second_border_radius',
			array(
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-dual-header-second-header' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'    => __( 'Shadow', 'royal-addons-for-elementor' ),
				'name'     => 'royal_dual_header_second_text_shadow',
				'selector' => '{{WRAPPER}} .royal-dual-header-second-header',
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_second_margin',
			array(
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'separator'  => 'before',
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-dual-header-second-header' => 'margin : {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'royal_dual_header_second_padding',
			array(
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .royal-dual-header-second-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'second_noise_heading',
			array(
				'label'     => __( 'Glitch Effect', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'noise_second' => 'yes',
				),
			)
		);

		$this->add_control(
			'noise_third_color',
			array(
				'label'     => __( 'Color #1', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'noise_second' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-title-second-noise-yes .royal-dual-header-second-header::before' => 'text-shadow: 1px 0 {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'noise_fourth_color',
			array(
				'label'     => __( 'Color #2', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'noise_second' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-title-second-noise-yes .royal-dual-header-second-header::after' => 'text-shadow: -1px 0 {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'background_text_style_section',
			array(
				'label'     => __( 'Background Text', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'background_text_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'background_text_color',
			array(
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'background_text_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'background_text_shadow',
				'selector' => '{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before',
			)
		);

		$this->add_control(
			'background_text_mix_blend',
			array(
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''            => __( 'Normal', 'elementor' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay            ',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'luminosity'  => 'Luminosity',
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'mix-blend-mode: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'background_text_zindex',
			array(
				'label'     => __( 'z-Index', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => -10,
				'max'       => 20,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}}.royal-bg-text-yes .elementor-widget-container:before' => 'z-index: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Dual Heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'royal_dual_header_first_header_text' );

		$this->add_inline_editing_attributes( 'royal_dual_header_second_header_text' );

		$first_title_tag = $settings['royal_dual_header_first_header_tag'];

		$first_title_text = $settings['royal_dual_header_first_header_text'] . ' ';

		$second_title_text = $settings['royal_dual_header_second_header_text'];

		$first_clip = '';

		$second_clip = '';

		$first_stroke = '';

		$second_stroke = '';

		if ( 'clipped' === $settings['royal_dual_header_first_back_clip'] ) {
			$first_clip = 'royal-dual-header-first-clip';
		}

		if ( 'clipped' === $settings['royal_dual_header_second_back_clip'] ) {
			$second_clip = 'royal-dual-header-second-clip';
		}

		if ( ! empty( $first_clip ) && 'yes' === $settings['royal_dual_header_first_stroke'] ) {
			$first_stroke = ' stroke';
		}

		if ( ! empty( $second_clip ) && 'yes' === $settings['royal_dual_header_second_stroke'] ) {
			$second_stroke = ' stroke';
		}

		$first_grad = 'yes' === $settings['royal_dual_header_first_animated'] ? ' gradient' : '';

		$second_grad = 'yes' === $settings['royal_dual_header_second_animated'] ? ' gradient' : '';

		$first_noise = 'yes' === $settings['noise_first'] ? 'data-text="' . $first_title_text . '"' : '';

		$second_noise = 'yes' === $settings['noise_second'] ? 'data-text="' . $second_title_text . '"' : '';

		$full_title = '<' . $first_title_tag . ' class="royal-dual-header-first-header ' . $first_clip . $first_stroke . $first_grad . '"><span class="royal-dual-header-first-span" ' . $first_noise . ' >' . $first_title_text . '</span>';

		if ( ! empty( $second_title_text ) ) {
			$full_title .= '<span class="royal-dual-header-second-header ' . $second_clip . $second_stroke . $second_grad . '" ' . $second_noise . ' >' . $second_title_text . '</span>';
		}

		$full_title .= '</' . $first_title_tag . '> ';

		if ( 'yes' === $settings['royal_dual_header_link_switcher'] ) {

			if ( 'url' === $settings['royal_dual_heading_link_selection'] ) {

				$this->add_link_attributes( 'link', $settings['royal_dual_heading_link'] );
			} else {

				$this->add_render_attribute( 'link', 'href', get_permalink( $settings['royal_dual_heading_existing_link'] ) );
			}
		}

		$this->add_render_attribute( 'container', 'class', 'royal-dual-header-container' );

		if ( 'yes' === $settings['background_text_switcher'] ) {
			$this->add_render_attribute(
				'container',
				array(
					'class'           => 'royal-title-bg-text',
					'data-background' => $settings['background_text'],
				)
			);
		}

		?>

		<?php if ( 'yes' === $settings['royal_dual_header_link_switcher'] ) : ?>
		<a <?php echo wp_kses_post( $this->get_render_attribute_string( 'link' ) ); ?>>
		<?php endif; ?>
			<?php echo wp_kses_post( $full_title ); ?>
		<?php if ( 'yes' === $settings['royal_dual_header_link_switcher'] ) : ?>
		</a>
		<?php endif; ?>

		<?php
	}

	
	protected function content_template() {
		?>
		<#

			view.addInlineEditingAttributes('royal_dual_header_first_header_text');

			view.addInlineEditingAttributes('royal_dual_header_second_header_text');

			var firstTag = elementor.helpers.validateHTMLTag( settings.royal_dual_header_first_header_tag ),

			firstText = settings.royal_dual_header_first_header_text + ' ',

			secondText = settings.royal_dual_header_second_header_text,

			firstClip = '',

			secondClip = '',

			firstStroke = '',

			secondStroke = '';

			if( 'clipped' === settings.royal_dual_header_first_back_clip )
				firstClip = "royal-dual-header-first-clip";

			if( 'clipped' === settings.royal_dual_header_second_back_clip )
				secondClip = "royal-dual-header-second-clip";

			if( 'yes' === settings.royal_dual_header_first_stroke )
				firstStroke = "stroke";

			if( 'yes' === settings.royal_dual_header_second_stroke )
				secondStroke = "stroke";

			var firstGrad = 'yes' === settings.royal_dual_header_first_animated  ? ' gradient' : '',
				secondGrad = 'yes' === settings.royal_dual_header_second_animated ? ' gradient' : '';

				view.addRenderAttribute('first_title', 'class', ['royal-dual-header-first-header', firstClip, firstGrad, firstStroke ] );
				view.addRenderAttribute('second_title', 'class', ['royal-dual-header-second-header', secondClip, secondGrad, secondStroke ] );

				view.addRenderAttribute('second_title', 'data-text', 'yes' === settings.noise_second ? secondText : '' );

			var link = '';
			if( 'yes' === settings.royal_dual_header_link_switcher ) {

				if( 'link' === settings.royal_dual_heading_link_selection ) {

					link = settings.royal_dual_heading_existing_link;

				} else {

					link = settings.royal_dual_heading_link.url;

				}
			}

			view.addRenderAttribute('container', 'class', 'royal-dual-header-container' );

			if( 'yes' === settings.background_text_switcher ) {
				view.addRenderAttribute( 'container', {
					'class': 'royal-title-bg-text',
					'data-background': settings.background_text
				});
			}

            view.addRenderAttribute( 'button', 'href', link );


		#>

		<# if( 'yes' === settings.royal_dual_header_link_switcher && '' !== link ) { #>
			<a {{{ view.getRenderAttributeString('button') }}}>
		<# } #>
		<{{{firstTag}}} {{{ view.getRenderAttributeString('first_title') }}}>
			<span class="royal-dual-header-first-span" data-text="{{ firstText }}">{{{ firstText }}}</span>
			<# if ( '' != secondText ) { #>
				<span {{{ view.getRenderAttributeString('second_title') }}}>{{{ secondText }}}</span>
			<# } #>
		</{{{firstTag}}}>
		<# if( 'yes' == settings.royal_dual_header_link_switcher && '' !== link ) { #>
			</a>
		<# } #>

		<?php
	}
}
