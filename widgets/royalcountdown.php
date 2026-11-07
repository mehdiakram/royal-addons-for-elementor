<?php

namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Control_Media;

defined('ABSPATH') || die();

class RoyalCountdown extends Widget_Base {

	public function get_name() {
		return 'royalcountdown';
	}


	public function get_title() {
		return __('Countdown', 'royal-addons-for-elementor');
	}


	public function get_icon() { return 'eicon-countdown rtbranding'; }


	public function get_keywords() {
		return ['countdown', 'count down', 'down', 'timer', 'count', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_style_depends() {
		$styles = [ 'royalcountdown' ];
		return $styles;
	}


	public function get_script_depends() {
		$scripts = ['countdown', 'royalcountdown'];
		return $scripts;
	}	


	protected function register_controls() {
		$this->time_content_controls();
		$this->settings_content_controls();
		$this->end_action_content_controls();

		$this->common_style_controls();
		$this->days_style_controls();
		$this->hours_style_controls();
		$this->minutes_style_controls();
		$this->seconds_style_controls();		
	}

	protected function time_content_controls() {

		$this->start_controls_section(
			'_section_time',
			[
				'label' => __('Time', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'due_date',
			[
				'label' => __('Time', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DATE_TIME,
				'default' => date("Y-m-d", strtotime("+ 7 day")),
				'description' => esc_html__('Set the due date and time', 'royal-addons-for-elementor'),
			]
		);
		$this->end_controls_section();
	}

	protected function settings_content_controls() {

		$this->start_controls_section(
			'_section_countdown_settings',
			[
				'label' => __('Countdown Settings', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'label_position',
			[
				'label' => __('Label Position', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'right' => [
						'title' => __('Right', 'royal-addons-for-elementor'),
						'icon' => 'eicon-h-align-right',
					],
					'bottom' => [
						'title' => __('Bottom', 'royal-addons-for-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => false,
				'default' => 'bottom',
				'prefix_class' => 'royal-countdown-label-',
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'label_space',
			[
				'label' => __('Label Space', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'label_position' => 'right',
				],
                'style_transfer' => true,
			]
		);
		$this->start_popover();
		$this->add_control(
			'label_space_top',
			[
				'label' => __('Label Space Top', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.royal-countdown-label-right .royal-countdown-item .royal-countdown-label' => 'top: {{SIZE || 0}}{{UNIT}};',
				],
				'condition' => [
					'label_position' => 'right',
				],
                'style_transfer' => true,
			]
		);

		$this->add_control(
			'label_space_left',
			[
				'label' => __('Label Space Left', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.royal-countdown-label-right .royal-countdown-item .royal-countdown-label' => 'left: {{SIZE || 0}}{{UNIT}};',
				],
				'condition' => [
					'label_position' => 'right',
				],
                'style_transfer' => true,
			]
		);
		$this->end_popover(); //End Prover

		$this->add_control(
			'show_label_days',
			[
				'label' => esc_html__('Show Label Days?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'label_days',
			[
				'label' => esc_html__('Label Days', 'royal-addons-for-elementor'),
				'description' => esc_html__('Set the label for days.', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Days', 'royal-addons-for-elementor'),
				'default' => 'Days',
				'condition' => [
					'show_label_days' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_label_hours',
			[
				'label' => esc_html__('Show Label Hours?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'label_hours',
			[
				'label' => esc_html__('Label Hours', 'royal-addons-for-elementor'),
				'description' => esc_html__('Set the label for hours.', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Hours', 'royal-addons-for-elementor'),
				'default' => 'Hours',
				'condition' => [
					'show_label_hours' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_label_minutes',
			[
				'label' => esc_html__('Show Label Minutes?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'label_minutes',
			[
				'label' => esc_html__('Label Minutes', 'royal-addons-for-elementor'),
				'description' => esc_html__('Set the label for minutes.', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Minutes', 'royal-addons-for-elementor'),
				'default' => 'Minutes',
				'condition' => [
					'show_label_minutes' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_label_seconds',
			[
				'label' => esc_html__('Show Label Seconds?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'label_seconds',
			[
				'label' => esc_html__('Label Seconds', 'royal-addons-for-elementor'),
				'description' => esc_html__('Set the label for seconds.', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Seconds', 'royal-addons-for-elementor'),
				'default' => 'Seconds',
				'condition' => [
					'show_label_seconds' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'align',
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
					]
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}}'
				]
			]
		);
		$this->add_control(
			'show_separator',
			[
				'label' => esc_html__('Show Separator?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'default' => '',
				'separator' => 'before',
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'separator',
			[
				'label' => __('Separator', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => ':',
				'condition' => [
					'show_separator' => 'on',
				],
			]
		);
		$this->add_control(
			'separator_color',
			[
				'label' => __('Separator Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item.royal-countdown-separator-on .royal-countdown-separator' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_separator' => 'on',
				],
                'style_transfer' => true,
			]
		);
		$this->add_responsive_control(
			'separator_font',
			[
				'label' => __('Separator Font Size', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item.royal-countdown-separator-on .royal-countdown-separator' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_separator' => 'on',
				],
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'separator_position',
			[
				'label' => __('Separator Position', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'condition' => [
					'show_separator' => 'on',
				],
                'style_transfer' => true,
			]
		);

		$this->start_popover();
		$this->add_control(
			'separator_position_top',
			[
				'label' => __('Position Top', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item.royal-countdown-separator-on .royal-countdown-separator' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_separator' => 'on'
				],
                'style_transfer' => true,
			]
		);

		$this->add_control(
			'separator_position_right',
			[
				'label' => __('Position Right', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item.royal-countdown-separator-on .royal-countdown-separator' => 'right: {{SIZE || -16}}{{UNIT}};',
				],
				'condition' => [
					'show_separator' => 'on'
				],
                'style_transfer' => true,
			]
		);

		$this->end_popover();

		$this->end_controls_section();
	}

	protected function end_action_content_controls() {

		$this->start_controls_section(
			'_section_end_action',
			[
				'label' => __('End Action', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'end_action_type',
			[
				'label' => esc_html__('End Action Type', 'royal-addons-for-elementor'),
				'label_block' => false,
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('Choose which action you want to at the end of countdown.', 'royal-addons-for-elementor'),
				'options' => [
					'none' => esc_html__('None', 'royal-addons-for-elementor'),
					'message' => esc_html__('Message', 'royal-addons-for-elementor'),
					'url' => esc_html__('Redirection Link', 'royal-addons-for-elementor'),
					'img' => esc_html__('Image', 'royal-addons-for-elementor'),
				],
				'default' => 'none'
			]
		);
		$this->add_control(
			'end_message',
			[
				'label' => __('Countdown End Message', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __('Countdown End!', 'royal-addons-for-elementor'),
				'placeholder' => __('Type your message here', 'royal-addons-for-elementor'),
				'condition' => [
					'end_action_type' => 'message'
				],
			]
		);
		$this->add_control(
			'end_redirect_link',
			[
				'label' => __('Redirection Link', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('http://www.royal-addons-for-elementor.com/', 'royal-addons-for-elementor'),
				'condition' => [
					'end_action_type' => 'url'
				],
			]
		);

		$this->add_control(
			'end_image',
			[
				'label' => __('Image', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'end_action_type' => 'img'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'end_image_size',
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'end_action_type' => 'img'
				],
			]
		);

		$this->end_controls_section();
	}


	protected function common_style_controls() {

		$this->start_controls_section(
			'_section_common_style',
			[
				'label' => __('Common Style', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'box_width',
			[
				'label' => __('Box Width', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_height',
			[
				'label' => __('Box Height', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'common_box_bg',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-countdown-item',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'label' => __('Box Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-countdown-item',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'box_border_radius',
			[
				'label' => __('Border Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_box_shadow',
				'label' => __('Box Shadow', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-countdown-item',
			]
		);
		$this->add_control(
			'common_box_time_color',
			[
				'label' => __('Time Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-time' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'common_box_time_typography',
				'label' => __('Time Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => ['']
				],
				'selector' => '{{WRAPPER}} .royal-countdown-time',
			]
		);
		$this->add_control(
			'common_box_label_color',
			[
				'label' => __('Label Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-label' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'common_box_label_typography',
				'label' => __('Label Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => [''],
				],
				'selector' => '{{WRAPPER}} .royal-countdown-label',
			]
		);
		$this->add_responsive_control(
			'common_box_spacing',
			[
				'label' => __('Spacing Between Box', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};'
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'box_padding',
			[
				'label' => __('Box Padding', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function days_style_controls() {

		$this->start_controls_section(
			'_section_days_style',
			[
				'label' => __('Days Style', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'days_bg',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-days',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'days_border',
				'label' => __('Box Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-days',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'days_time_color',
			[
				'label' => __('Days Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-days .royal-countdown-time' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'days_time_typography',
				'label' => __('Days Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => ['']
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-days .royal-countdown-time',
			]
		);
		$this->add_control(
			'days_label_color',
			[
				'label' => __('Days Label Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-days .royal-countdown-label' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'days_label_typography',
				'label' => __('Days Label Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => [''],
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-days .royal-countdown-label',
			]
		);

		$this->end_controls_section();
	}

	protected function hours_style_controls() {

		$this->start_controls_section(
			'_section_hours_style',
			[
				'label' => __('Hours Style', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'hours_bg',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-hours',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'hours_border',
				'label' => __('Box Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-hours',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'hours_time_color',
			[
				'label' => __('Hours Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-hours .royal-countdown-time' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hours_time_typography',
				'label' => __('Hours Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => ['']
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-hours .royal-countdown-time',
			]
		);
		$this->add_control(
			'hours_label_color',
			[
				'label' => __('Hours Label Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-hours .royal-countdown-label' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hours_label_typography',
				'label' => __('Hours Label Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => [''],
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-hours .royal-countdown-label',
			]
		);

		$this->end_controls_section();
	}

	protected function minutes_style_controls() {

		$this->start_controls_section(
			'_section_minutes_style',
			[
				'label' => __('Minutes Style', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'minutes_bg',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-minutes',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'minutes_border',
				'label' => __('Box Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-minutes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'minutes_time_color',
			[
				'label' => __('Minutes Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-minutes .royal-countdown-time' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'minutes_time_typography',
				'label' => __('Minutes Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => ['']
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-minutes .royal-countdown-time',
			]
		);
		$this->add_control(
			'minutes_label_color',
			[
				'label' => __('Minutes Label Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-minutes .royal-countdown-label' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'minutes_label_typography',
				'label' => __('Minutes Label Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => [''],
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-minutes .royal-countdown-label',
			]
		);

		$this->end_controls_section();
	}

	protected function seconds_style_controls() {

		$this->start_controls_section(
			'_section_seconds_style',
			[
				'label' => __('Seconds Style', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'seconds_bg',
				'label' => __('Background', 'royal-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-seconds',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'seconds_border',
				'label' => __('Box Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .royal-countdown-item.royal-countdown-item-seconds',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'seconds_time_color',
			[
				'label' => __('Time Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-seconds .royal-countdown-time' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'seconds_time_typography',
				'label' => __('Time Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => ['']
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-seconds .royal-countdown-time',
			]
		);
		$this->add_control(
			'seconds_label_color',
			[
				'label' => __('Label Color', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-countdown-item-seconds .royal-countdown-label' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'seconds_label_typography',
				'label' => __('Label Typography', 'royal-addons-for-elementor'),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => [''],
				],
				'selector' => '{{WRAPPER}} .royal-countdown-item-seconds .royal-countdown-label',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$due_date = date("M d Y G:i:s", strtotime($settings['due_date']));
		$this->add_render_attribute('royal-countdown', 'class', 'royal-countdown');
		$this->add_render_attribute('royal-countdown', 'data-date', esc_attr($due_date));
		$this->add_render_attribute('royal-countdown', 'data-end-action', esc_attr($settings['end_action_type']));
		if ('url' === $settings['end_action_type'] && $settings['end_redirect_link']) {
			$this->add_render_attribute('royal-countdown', 'data-redirect-link', esc_url($settings['end_redirect_link']));
		}
		$this->add_render_attribute('days', 'class', 'royal-countdown-item royal-countdown-item-days');
		$this->add_render_attribute('hours', 'class', 'royal-countdown-item royal-countdown-item-hours');
		$this->add_render_attribute('minutes', 'class', 'royal-countdown-item royal-countdown-item-minutes');
		$this->add_render_attribute('seconds', 'class', 'royal-countdown-item royal-countdown-item-seconds');
		if ('on' == $settings['show_separator']) {
			$this->add_render_attribute('days', 'class', 'royal-countdown-separator-on');
			$this->add_render_attribute('hours', 'class', 'royal-countdown-separator-on');
			$this->add_render_attribute('minutes', 'class', 'royal-countdown-separator-on');
			$this->add_render_attribute('seconds', 'class', 'royal-countdown-separator-on');
		}
		?>
		<?php if (!empty($due_date)): ?>
			<div class="royal-countdown-wrap">
				<div <?php $this->print_render_attribute_string('royal-countdown'); ?>>
					<div <?php $this->print_render_attribute_string('days'); ?>>
						<span data-days class="royal-countdown-time royal-countdown-days">0</span>
						<?php if ('yes' == $settings['show_label_days'] && !empty($settings['label_days'])): ?>
							<span
								class="royal-countdown-label royal-countdown-label-days"><?php echo esc_html($settings['label_days']); ?></span>
						<?php endif; ?>
						<?php if ('on' == $settings['show_separator'] && !empty($settings['separator'])): ?>
							<span class="royal-countdown-separator"><?php echo esc_attr($settings['separator']); ?></span>
						<?php endif; ?>
					</div>
					<div <?php $this->print_render_attribute_string('hours'); ?>>
						<span class="royal-countdown-time royal-countdown-hours" data-hours>0</span>
						<?php if ('yes' == $settings['show_label_hours'] && !empty($settings['label_hours'])): ?>
							<span
								class="royal-countdown-label royal-countdown-label-hours"><?php echo esc_html($settings['label_hours']); ?></span>
						<?php endif; ?>
						<?php if ('on' == $settings['show_separator'] && !empty($settings['separator'])): ?>
							<span class="royal-countdown-separator"><?php echo esc_attr($settings['separator']); ?></span>
						<?php endif; ?>
					</div>
					<div <?php $this->print_render_attribute_string('minutes'); ?>>
						<span class="royal-countdown-time royal-countdown-minutes" data-minutes>0</span>
						<?php if ('yes' == $settings['show_label_minutes'] && !empty($settings['label_minutes'])): ?>
							<span
								class="royal-countdown-label royal-countdown-label-minutes"><?php echo esc_html($settings['label_minutes']); ?></span>
						<?php endif; ?>
						<?php if ('on' == $settings['show_separator'] && !empty($settings['separator'])): ?>
							<span class="royal-countdown-separator"><?php echo esc_attr($settings['separator']); ?></span>
						<?php endif; ?>
					</div>
					<div <?php $this->print_render_attribute_string('seconds'); ?>>
						<span class="royal-countdown-time royal-countdown-seconds" data-seconds>0</span>
						<?php if ('yes' == $settings['show_label_seconds'] && !empty($settings['label_seconds'])): ?>
							<span
								class="royal-countdown-label royal-countdown-label-seconds"><?php echo esc_html($settings['label_seconds']); ?></span>
						<?php endif; ?>
					</div>
					<!--End action markup-->
					<?php if ('none' != $settings['end_action_type'] && !empty($settings['end_action_type'])): ?>
						<div class="royal-countdown-end-action">
							<?php if ('message' == $settings['end_action_type'] && $settings['end_message']) :
								echo '<div class="royal-countdown-end-message">' . wpautop(wp_kses_post($settings['end_message'])) . '</div>';
							endif; ?>
							<?php if ('img' == $settings['end_action_type'] && ($settings['end_image']['url'] || $settings['end_image']['id'])) :
								$this->add_render_attribute('image', 'src', $settings['end_image']['url']);
								$this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['end_image']));
								$this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['end_image']));
								?>
								<figure class="royal-countdown-end-action-image">
									<?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'end_image_size', 'end_image'); ?>
								</figure>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php

	}
}
