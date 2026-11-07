<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

class RoyalScrollToTop_KitSetings extends Tab_Base {

	public function get_id() {
		return 'royalscrolltotopkitsettings';
	}


	public function get_title() {
		return __( 'Scroll to Top [Royal]', 'royal-addons-for-elementor' );
	}


	public function get_icon() {
		return 'eicon-v-align-top';
	}
	
	
	public function get_group() {
		return 'settings';
	}


	protected function register_tab_controls() {
		$this->start_controls_section(
			'royal_scroll_to_top_kit_section',
			[
				'tab'   => 'royalscrolltotopkitsettings',
				'label' => __( 'Scroll to Top [Royal]', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'royal_scroll_to_top_global',
			[
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Enable Scroll To Top', 'royal-addons-for-elementor' ),
				'default'   => '',
				'label_on'  => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
			]
		);

		$device_default['desktop_default'] = 'yes';
		$this->add_responsive_control(
			'royal_scroll_to_top_responsive_visibility',
			array_merge(
				[
					'type'                 => Controls_Manager::SWITCHER,
					'label'                => __( 'Responsive Visibility', 'royal-addons-for-elementor' ),
					'default'              => 'yes',
					'return_value'         => 'yes',
					'label_on'             => __( 'Show', 'royal-addons-for-elementor' ),
					'label_off'            => __( 'Hide', 'royal-addons-for-elementor' ),
					'selectors_dictionary' => [
						''    => 'visibility: hidden; opacity: 0;',
						'yes' => 'visibility: visible; opacity: 1;',
					],
					'selectors'            => [
						'body[data-elementor-device-mode="widescreen"] .royal-scroll-to-top-wrap,
						body[data-elementor-device-mode="widescreen"] .royal-scroll-to-top-wrap.edit-mode,
						body[data-elementor-device-mode="widescreen"] .royal-scroll-to-top-wrap.single-page-off' => '{{VALUE}}',

						'body[data-elementor-device-mode="desktop"] .royal-scroll-to-top-wrap,
						body[data-elementor-device-mode="desktop"] .royal-scroll-to-top-wrap.edit-mode,
						body[data-elementor-device-mode="desktop"] .royal-scroll-to-top-wrap.single-page-off' => '{{VALUE}}',

						'body[data-elementor-device-mode="laptop"] .royal-scroll-to-top-wrap,
						body[data-elementor-device-mode="laptop"] .royal-scroll-to-top-wrap.edit-mode,
						body[data-elementor-device-mode="laptop"] .royal-scroll-to-top-wrap.single-page-off' => '{{VALUE}}',

						'body[data-elementor-device-mode="tablet_extra"] .royal-scroll-to-top-wrap,
						body[data-elementor-device-mode="tablet_extra"] .royal-scroll-to-top-wrap.edit-mode,
						body[data-elementor-device-mode="tablet_extra"] .royal-scroll-to-top-wrap.single-page-off' => '{{VALUE}}',

						'body[data-elementor-device-mode="tablet"] .royal-scroll-to-top-wrap,
						body[data-elementor-device-mode="tablet"] .royal-scroll-to-top-wrap.edit-mode,
						body[data-elementor-device-mode="tablet"] .royal-scroll-to-top-wrap.single-page-off' => '{{VALUE}}',

						'body[data-elementor-device-mode="mobile_extra"] .royal-scroll-to-top-wrap,
						body[data-elementor-device-mode="mobile_extra"] .royal-scroll-to-top-wrap.edit-mode,
						body[data-elementor-device-mode="mobile_extra"] .royal-scroll-to-top-wrap.single-page-off' => '{{VALUE}}',

						'body[data-elementor-device-mode="mobile"] .royal-scroll-to-top-wrap,
						body[data-elementor-device-mode="mobile"] .royal-scroll-to-top-wrap.edit-mode,
						body[data-elementor-device-mode="mobile"] .royal-scroll-to-top-wrap.single-page-off' => '{{VALUE}}',
					],
					'condition'            => [
						'royal_scroll_to_top_global' => 'yes',
					],
				],
				$device_default
			)
		);

		$this->add_control(
			'royal_scroll_to_top_position_text',
			[
				'label'       => esc_html__( 'Position', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'bottom-right',
				'label_block' => false,
				'options'     => [
					'bottom-left'  => esc_html__( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'royal-addons-for-elementor' ),
				],
				'separator'   => 'before',
				'condition'   => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_position_bottom',
			[
				'label'      => __( 'Bottom', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_position_left',
			[
				'label'      => __( 'Left', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'.royal-scroll-to-top-button' => 'left: 15px',
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'royal_scroll_to_top_global'        => 'yes',
					'royal_scroll_to_top_position_text' => 'bottom-left',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_position_right',
			[
				'label'      => __( 'Right', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
					'em' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
					'%'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'royal_scroll_to_top_global'        => 'yes',
					'royal_scroll_to_top_position_text' => 'bottom-right',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_width',
			[
				'label'      => __( 'Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'selectors'  => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_height',
			[
				'label'      => __( 'Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					],
				],
				'selectors'  => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_z_index',
			[
				'label'      => __( 'Z Index', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 9999,
						'step' => 10,
					],
				],
				'selectors'  => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'z-index: {{SIZE}}',
				],
				'condition'  => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_opacity',
			[
				'label'     => __( 'Opacity', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_media_type',
			[
				'label'          => __( 'Media Type', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::CHOOSE,
				'label_block'    => false,
				'options'        => [
					'icon'  => [
						'title' => __( 'Icon', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => __( 'Image', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-image',
					],
					'text'  => [
						'title' => __( 'Text', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-animation-text',
					],
				],
				'default'        => 'icon',
				'separator'      => 'before',
				'toggle'         => false,
				'style_transfer' => true,
				'condition'      => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_icon',
			[
				'label'      => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::ICONS,
				'show_label' => false,
				'default'    => [
					'value'   => 'fas fa-chevron-up',
					'library' => 'fa-solid',
				],
				'condition'  => [
					'royal_scroll_to_top_global'     => 'yes',
					'royal_scroll_to_top_media_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_image',
			[
				'label'      => __( 'Image', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false,
				'dynamic'    => [
					'active' => true,
				],
				'condition'  => [
					'royal_scroll_to_top_global'     => 'yes',
					'royal_scroll_to_top_media_type' => 'image',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_text',
			[
				'label'       => __( 'Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'show_label'  => false,
				'label_block' => true,
				'default'     => 'Top',
				'condition'   => [
					'royal_scroll_to_top_global'     => 'yes',
					'royal_scroll_to_top_media_type' => 'text',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_icon_size',
			[
				'label'      => __( 'Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors'  => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button i' => 'font-size: {{SIZE}}{{UNIT}};',
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'royal_scroll_to_top_global'      => 'yes',
					'royal_scroll_to_top_media_type!' => 'text',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'royal_scroll_to_top_button_text_typo',
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '.royal-scroll-to-top-wrap .royal-scroll-to-top-button span',
				'condition' => [
					'royal_scroll_to_top_global'     => 'yes',
					'royal_scroll_to_top_media_type' => 'text',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'royal_scroll_to_top_button_border',
				'exclude'   => ['color'], //remove border color
				'selector'  => '{{WRAPPER}} .royal-scroll-to-top-wrap .royal-scroll-to-top-button',
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->start_controls_tabs(
			'royal_scroll_to_top_tabs',
			[
				'separator' => 'before',
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->start_controls_tab(
			'royal_scroll_to_top_tab_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_icon_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button i' => 'color: {{VALUE}}',
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button span' => 'color: {{VALUE}}',
				],
				'condition' => [
					'royal_scroll_to_top_global'      => 'yes',
					'royal_scroll_to_top_media_type!' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'royal_scroll_to_top_button_bg_color',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '.royal-scroll-to-top-wrap .royal-scroll-to-top-button',
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_border_color',
			[
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
					'royal_scroll_to_top_button_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'royal_scroll_to_top_tab_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_icon_hvr_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button:hover i' => 'color: {{VALUE}}',
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button:hover span' => 'color: {{VALUE}}',
				],
				'condition' => [
					'royal_scroll_to_top_global'      => 'yes',
					'royal_scroll_to_top_media_type!' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'royal_scroll_to_top_button_bg_hvr_color',
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '.royal-scroll-to-top-wrap .royal-scroll-to-top-button:hover',
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_scroll_to_top_button_hvr_border_color',
			[
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button:hover' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
					'royal_scroll_to_top_button_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'royal_scroll_to_top_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'.royal-scroll-to-top-wrap .royal-scroll-to-top-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
				'condition'  => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'royal_scroll_to_top_button_box_shadow',
				'exclude'   => [
					'box_shadow_position',
				],
				'selector'  => '.royal-scroll-to-top-wrap .royal-scroll-to-top-button',
				'condition' => [
					'royal_scroll_to_top_global' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}
}
