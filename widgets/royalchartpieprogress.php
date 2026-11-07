<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalChartPieProgress extends Widget_Base {

	public function get_name() {
		return 'royalchartpieprogress';
	}


	public function get_title() {
		return __( 'Pie Progress', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-loading rtbranding'; }


	public function get_keywords() {
		return [ 'pie', 'chart', 'progress', 'persentage', 'animation', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		return ['royalchart'];
	}

	
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Pie Content', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'piewidth',
			[
				'label' => esc_html__( 'Pie Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .royalchartpieprogress' => '--piewidth: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'piepercentage',
			[
				'label' => esc_html__( 'Pie Percentage', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 90,
				],
				'selectors' => [
					'{{WRAPPER}} .royalchartpieprogress' => '--percentage: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'pieborder',
			[
				'label' => esc_html__( 'Pie Border', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 22,
				],
				'selectors' => [
					'{{WRAPPER}} .royalchartpieprogress' => '--border: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#61CE70',
				'selectors' => [
					'{{WRAPPER}} .royalchartpieprogress' => '--piecolor: {{VALUE}};',
				],
			]
        );

		$this->add_control(
			'round_style',
			[
				'label' => esc_html__( 'Border Round', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' 						=> esc_html__( 'Round', 'royal-addons-for-elementor' ),
					'royalchartpienoround' 	=> esc_html__( 'No Round', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .royalchartpieprogress' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],	
				'selector' => '{{WRAPPER}} .royalchartpieprogress',
			]
        );

		$this->add_control(
			'animation_style',
			[
				'label' => esc_html__( 'Pie Animation', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'royalchartpieanimation',
				'options' => [
					'royalchartpieanimation' 	=> esc_html__( 'Animation', 'royal-addons-for-elementor' ),
					'' 							=> esc_html__( 'No Animation', 'royal-addons-for-elementor' ),
				],
			]
		);


		


        $this->end_controls_section();
	}


	protected function render() {
		$settings 			= $this->get_settings_for_display();
		$round_style 		= $settings['round_style'];
		$animation_style	= $settings['animation_style'];
		
		if ( ! empty( $settings['piepercentage']['size'] ) ) {
			$piepercentage = $settings['piepercentage']['size'];
		} else {
			$piepercentage = 0;
		}
	
		echo '<div class="royalchartpieprogress '.$animation_style.' '.$round_style.'">' . esc_html( $piepercentage ) . '%</div>';
	}
	

}