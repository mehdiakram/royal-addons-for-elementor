<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}


class RoyalChartProgressbar extends Widget_Base {

	public function get_name() {
		return 'royalchartprogressbar';
	}


	public function get_title() {
		return 'Progress Bar';
	}

	
	public function get_icon() { return 'eicon-skill-bar rtbranding'; }

	
	public function get_categories(){
		return ['royaltech'];
	  }


	public function get_keywords() {
		return ['progress', 'bar', 'line', 'skill', 'chart', 'percent', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_style_depends() {
		return ['royalchartprogressbar'];
	}


	public function get_script_depends() {
		return ['royalchartprogressbar'];
	}
	
	protected function register_controls() {
		$this->royalprogressbar_content_controls();
		$this->royalprogressbar_bar_style_controls();
		$this->royalprogressbar_title_style_controls();

		
	}
	
	protected function royalprogressbar_content_controls() {

		$this->start_controls_section(
			'royalprogressbar_content_section',
			array(
				'label' => __( 'Progress Bar Settings', 'royal-addons-for-elementor' ),
			)
		);
		
		$this->add_control(
			'progress_style',
			[
				'label' => esc_html__( 'Bar Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1'  	=> esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'style2'  	=> esc_html__( 'Style 2', 'royal-addons-for-elementor' ),
				],
			]
		);	
		
		
		$repeater = new \Elementor\Repeater();
				
		$repeater->add_control(
			'progresstext',
			[
				'label' => __( 'progress Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'HTML', 'royal-addons-for-elementor' ),
				'label_block' => true
			]
		);
		$repeater->add_control(
			'progresspercent',
			[
				'label' => esc_html__( 'Percent', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 90,
			]
		);		
		
		$repeater->add_control(
			'progressbarcolor',
			[
				'label' => esc_html__( 'Progress Bar Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#e67e22',
			]
		);		
		
		$repeater->add_control(
			'progressbarbackground',
			[
				'label' => esc_html__( 'Progress Bar Background', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#dddddd',
			]
		);	


		$this->add_control(
		  'royalprogressbar',
		  [
			'label' => __( 'Progress Bars', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'default' => [
			  [
				'progresstext' => __( 'HTML5', 'royal-addons-for-elementor' ),
				'progresspercent' => 100,
				'progressbarcolor' => '#e67e22',
				'progressbarbackground' => '#dddddd',
			  ],
			  [
				'progresstext' => __( 'CSS3', 'royal-addons-for-elementor' ),
				'progresspercent' => 90,
				'progressbarcolor' => '#2980b9',
				'progressbarbackground' => '#dddddd',				
			  ],
			  [
				'progresstext' => __( 'jQuery', 'royal-addons-for-elementor' ),
				'progresspercent' => 70,
				'progressbarcolor' => '#fac552',
				'progressbarbackground' => '#dddddd',				
			  ],
			  [
				'progresstext' => __( 'WordPress', 'royal-addons-for-elementor' ),
				'progresspercent' => 75,
				'progressbarcolor' => '#333333',
				'progressbarbackground' => '#dddddd',				
			  ],
			],
			'title_field' => '{{{ progresstext }}}',
		  ]
		);		
			
			
		$this->add_control(
			'timeractive',
			[
				'label' => __( 'Enable Timer', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);


		$this->add_control(
			'timer',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => esc_html__( 'Timer', 'royal-addons-for-elementor' ),
				'placeholder' => '0',
				'min' => 0,
				'max' => 5000,
				'step' => 1,
				'default' => 500,
				'condition' => [
				  'timeractive' => 'true',
				], 				
			]
		);


		$this->add_control(
			'progress_tooltip',
			[
				'label' => esc_html__( 'Tooltip Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'rpbtooltip1',
				'options' => [
					''  			=> esc_html__( 'No Tooltip', 'royal-addons-for-elementor' ),
					'rpbtooltip1'  	=> esc_html__( 'Tooltip Style 1', 'royal-addons-for-elementor' ),
					'rpbtooltip2'  	=> esc_html__( 'Tooltip Style 2', 'royal-addons-for-elementor' ),
				],
			]
		);	


		$this->add_control(
			'percentactive',
			[
				'label' => __( 'Percent Level', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);


		$this->end_controls_section();
	}
	
	
	protected function royalprogressbar_bar_style_controls() {

        $this->start_controls_section(
			'progressbar_style_section',
			[
				'label' => __( 'Bar Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );

		$this->add_control(
			'progressbar_options',
			[
				'label' => esc_html__( 'Bar Options', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label'      => __( 'Bar Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '10',
					'right' => '0',
					'bottom' => '10',
					'left' => '0',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .royalprogressbarwwarper .royalprogressbar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label'     => __( 'Bar Height', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 35,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalprogressbarwwarper .rpb-style1 .progressbar' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalprogressbarwwarper .rpb-style1 .progressbarwarp' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalprogressbarwwarper .rpb-style2' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalprogressbarwwarper .rpb-style2 .progressbartitle span' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalprogressbarwwarper .rpb-style2 .progressbar' => 'height: {{SIZE}}{{UNIT}};',
					
					
				],
			]
		);

		$this->add_control(
			'progressbar_border_radius',
			[
				'label' => esc_html__( 'Bar Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .royalprogressbarwwarper .progressbar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'progressbar_bg_border_radius',
			[
				'label' => esc_html__( 'Bar Background Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .royalprogressbarwwarper .progressbarwarp' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}


	protected function royalprogressbar_title_style_controls() {	
		
        $this->start_controls_section(
			'progressbar_title_section',
			[
				'label' => __( 'Title Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
        );


		$this->add_control(
			'bar_text_color',
			[
				'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .rpb-style1 .progressbartitle' => 'color: {{VALUE}}',
					'{{WRAPPER}} .rpb-style2 .progressbartitle span' => 'color: {{VALUE}}',
				],				
			]
		);	
		
		$this->add_control(
			'bar_text_bg_color',
			[
				'label' => esc_html__( 'Text Background', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#00000021',
				'condition' => [
					'progress_style' => 'style2',
				],				
				'selectors' => [
					'{{WRAPPER}} .rpb-style2 .progressbartitle span' => 'background: {{VALUE}}',
				],				
			]
		);		
		
		$this->add_control(
			'bar_text_width',
			[
				'label'     => __( 'Text Width', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 110,
				],
				'range'     => [
					'px' => [
						'min' => 50,
						'max' => 1000,
					],
				],
				'condition' => [
					'progress_style' => 'style2',
				],				
				'selectors' => [
					'{{WRAPPER}} .rpb-style2 .progressbartitle' => 'width: {{SIZE}}{{UNIT}};',	
				],
			]
		);		
		
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Text Typography', 'royal-addons-for-elementor' ),
				'name' => 'bar_text_typography',
				'selector' => '
				{{WRAPPER}} .rpb-style1 .progressbartitle,
				{{WRAPPER}} .rpb-style2 .progressbartitle span
				',
			]
		);

		$this->add_control(
			'progressbar_bar_text_border_radius',
			[
				'label' => esc_html__( 'Text Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '',
					'left' => '0',
					'isLinked' => true,
				],				
				'selectors' => [
					'{{WRAPPER}} .rpb-style2 .progressbartitle span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render() {
		$settings 					= $this->get_settings_for_display();
		$id         				= $this->get_id();
        $progressbarid     			= 'royalprogressbar'.$id;
		$progress_style 			= $settings['progress_style'];
		$tooltip 					= $settings['progress_tooltip'];
		$royalprogressbar 			= $settings['royalprogressbar'];
		$timer 						= $settings['timer'];
		$this->add_render_attribute(
			'royal_progressbar_options',
			[
				'id'       			=> $progressbarid,
				'data-timer'		=> $timer,
			]
		);		
			
	if ( "style1" == $progress_style ){
		if ( $settings['royalprogressbar'] ) {
			echo '<div class="royalprogressbarwwarper" '.$this->get_render_attribute_string( 'royal_progressbar_options' ).'>';
			foreach (  $settings['royalprogressbar'] as $item ) { ?>
				<div class="royalprogressbar rpb-style1">
					<div class="progressbartitle"><?php echo wp_kses_post( $item['progresstext'] );?></div>
					<div class="progressbarwarp" style="background:<?php echo wp_kses_post( $item['progressbarbackground'] );?>">
						<div class="progressbar <?php echo $tooltip; ?>" style="background:<?php echo wp_kses_post( $item['progressbarcolor'] );?>" data-percent="<?php echo wp_kses_post( $item['progresspercent'] );?>"></div>
					<?php if ( $settings['percentactive'] ) { ?>
						<div class="progressbarpercent">100%</div>
					<?php } ?>
					</div>
					
				</div><?php
			}
			echo '</div>';
		}
	
	
	} elseif( "style2" == $progress_style ){
		if ( $settings['royalprogressbar'] ) {
			echo '<div class="royalprogressbarwwarper" '.$this->get_render_attribute_string( 'royal_progressbar_options' ).'>';
			foreach (  $settings['royalprogressbar'] as $item ) { ?>
				<div class="royalprogressbar rpb-style2" data-percent="<?php echo wp_kses_post( $item['progresspercent'] );?>%">
					<div class="progressbarwarp" style="background:<?php echo wp_kses_post( $item['progressbarbackground'] );?>">
						<div class="progressbar <?php echo $tooltip; ?>" style="background:<?php echo wp_kses_post( $item['progressbarcolor'] );?>" data-percent="<?php echo wp_kses_post( $item['progresspercent'] );?>"></div>
					</div>
					<h4 class="progressbartitle"><span><?php echo wp_kses_post( $item['progresstext'] );?></span></h4>
					<?php if ( $settings['percentactive'] ) { ?>
					<div class="progressbarpercent">100%</div>
					<?php } ?>
				</div><?php
			}
			echo '</div>';
		}
	
		
	} else { }?>
	
	





	<?php 
	}
}
