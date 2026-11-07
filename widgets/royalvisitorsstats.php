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

class RoyalVisitorsStats extends Widget_Base {

    public function get_name() {
        return 'royalvisitorsstats';
    }


    public function get_title() {
        return __( 'Visitors Stats', 'royal-addons-for-elementor' );
    }


    public function get_icon() { return 'eicon-counter-circle rtbranding'; }


	public function get_keywords() {
		return ['stats', 'visitor', 'counter', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


    public function get_categories() {
        return array( 'royaltech_3rdparty' );
    }


	public function get_style_depends() {
		$styles = ['royalvisitorsstats'];
		return $styles;
	}
    
	protected function register_controls() {
		if (class_Exists('vooMainVisitorsClass')) {
		$this->rt_content_layout_options();
		$this->rt_style_options();
		} else {
			$this->voovisitors_not_found();
		}
	}
	
	
	private function voovisitors_not_found() {

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
					'<strong>%s</strong> %s <a href="plugin-install.php?s=Live-Visitor-Counter&tab=search&type=term" target="_blank">%s</a> %s',
					__( 'Live Visitor Counter', 'royal-addons-for-elementor' ),
					__( 'is not installed/activated on your site. Please install and activate.', 'royal-addons-for-elementor' ),
					__( 'Live Visitor Counter', 'royal-addons-for-elementor' ),
					__( ' first.', 'royal-addons-for-elementor' )
				),
			]
		);
		$this->add_control(
			'wp_repository_plugin_link',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => '<a href="https://wordpress.org/plugins/wp-visitors-widget/" target="_blank"><strong>Live Visitor Counter</strong></a> in wordpress plugin repository.',
			]
		);		
		$this->end_controls_section();
	}	
	
	
    private function rt_content_layout_options() {
        $this->start_controls_section(
            'section_royalvisitors',
            [
                'label' => __( 'Stats Settings', 'royal-addons-for-elementor' ),
            ]
        );


		$this->add_control(
			'royalvisitors_style',
			[
				'label' => esc_html__( 'Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Style 2', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Style 3', 'royal-addons-for-elementor' ),
				],
				'separator' => 'after',
			]
		);
		
		

		$this->add_control(
			'show_active',
			[
				'label' => esc_html__( 'Show Active Visitor', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'show',
				'default' => 'show',
			]
		);
		
        $this->add_control(
            'royalvisitors_active',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __( 'Active Text', 'royal-addons-for-elementor' ),
				'default' => 'Live Visitors',
				'condition' => [
					'show_active' => 'show',
				],				
            ]
        );
		
		$this->add_control(
			'show_active_dot',
			[
				'label' => esc_html__( 'Show Active Dot', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'show',
				'default' => 'show',
				'condition' => [
					'show_active' => 'show',
				],				
			]
		);
		
		
        $this->add_control(
            'active_dot_color1',
            [
                'label' => __( 'Live Dot Color 1', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FF0000',
                'selectors' => [
                    '{{WRAPPER}} .royal_pulsating_circle:after' => 'background-color:{{VALUE}};',
                ],
				'condition' => [
					'show_active' => 'show',
					'show_active_dot' => 'show',
				],					
            ]
        );			
		
		
        $this->add_control(
            'active_dot_color2',
            [
                'label' => __( 'Live Dot Color 2', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fd8686',
                'selectors' => [
                    '{{WRAPPER}} .royal_pulsating_circle:before' => 'background-color:{{VALUE}};',
                ],
				'condition' => [
					'show_active' => 'show',				
					'show_active_dot' => 'show',
				],				
            ]
        );			
				
				
		$this->add_control(
			'livedotsize',
			[
				'label' => esc_html__( 'Live Dot Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 30,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .royalvisitorstatswidget .royal_pulsating_circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; left: calc(50% - {{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'show_active' => 'show',				
					'show_active_dot' => 'show',
				],				
			]
		);				
				
		

		$this->add_control(
			'show_today',
			[
				'label' => esc_html__( 'Show Today Visitor', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'show',
				'default' => 'show',
			]
		);
		
        $this->add_control(
            'royalvisitors_today',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __( 'Todays Text', 'royal-addons-for-elementor' ),
				'default' => 'Visitors Today',
				'condition' => [
					'show_today' => 'show',
				],				
            ]
        );

		$this->add_control(
			'show_total',
			[
				'label' => esc_html__( 'Show Total Visitor', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'show',
				'default' => 'show',
			]
		);
		
		$this->add_control(
			'royalvisitors_initial_value',
			[
				'label' => esc_html__( 'Initial Value for Total', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100000,
				'step' => 1,
				'default' => 100,
				'condition' => [
					'show_total' => 'show',
				],					
			]
		);		
		
        $this->add_control(
            'royalvisitors_total',
            [
                'type' => Controls_Manager::TEXT,
                'label' => __( 'Total Text', 'royal-addons-for-elementor' ),
				'default' => 'Total Visitors',
				'condition' => [
					'show_total' => 'show',
				],				
            ]
        );


		$this->add_responsive_control(
			'counter_align',
			[
				'label' => __( 'Counter Alignment', 'royal-addons-for-elementor' ),
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
				],
				'selectors' => [
					'{{WRAPPER}} .royalvisitorstatswidget .counter' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
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
				],
				'selectors' => [
					'{{WRAPPER}} .royalvisitorstatswidget .text' => 'text-align: {{VALUE}};',
				],
			]
		);
        $this->end_controls_section();
    }
	
	
	private function rt_style_options() {

		$this->start_controls_section(
			'section_style_general',
			[
				'label' => __( 'General', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'
					{{WRAPPER}} .royalvisitorstatswidget .style1 .counter, 
					{{WRAPPER}} .royalvisitorstatswidget .style1 .text, 
					{{WRAPPER}} .royalvisitorstatswidget .style2 .counter, 
					{{WRAPPER}} .royalvisitorstatswidget .style2 .text,
					{{WRAPPER}} .royalvisitorstatswidget .style3 td
					' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					
					
				],
			]
		);
		
		
		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_typography',
			[
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);	
	
		// typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Counter', 'royal-addons-for-elementor' ),
				'name' => 'counter_typography',
				'selector'  => '{{WRAPPER}} .royalvisitorstatswidget .counter',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],	
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Text', 'royal-addons-for-elementor' ),
				'name' => 'text_typography',
				'selector'  => '{{WRAPPER}} .royalvisitorstatswidget .text',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);		
		
		$this->end_controls_section();




		$this->start_controls_section(
			'section_style_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
        $this->add_control(
            'counter_color',
            [
                'label' => __( 'Counter Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .royalvisitorstatswidget .counter' => 'color:{{VALUE}};',
                ]
            ]
        );		
		
        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .royalvisitorstatswidget .text' => 'color:{{VALUE}};',
                ]
            ]
        );			
		
		
		
        $this->end_controls_section();
    }
		
	
	
	
	
	
	
	

    protected function render() {
        $settings 		= $this->get_settings_for_display();
		
		if (class_Exists('vooMainVisitorsClass')) {
		
		$style 			= $settings['royalvisitors_style'];
		$active_text	= $settings['royalvisitors_active'];
		$today_text 	= $settings['royalvisitors_today'];
		$total_text 	= $settings['royalvisitors_total'];
		$show_active 	= $settings['show_active'];
		$show_today 	= $settings['show_today'];
		$show_total 	= $settings['show_total'];
		$initial_value 	= $settings['royalvisitors_initial_value'];
		$show_active_dot 	= $settings['show_active_dot'];
	
		
		global $wpdb;
		//$visitors_stat = 'royal_visitor_stats';
		$visitors_stat = 'visitors_stat';
		$visitors_stat = $wpdb->prefix . $visitors_stat; 
		
		// get visitors per day
		$current_timestamp = current_time('timestamp', false);
		$beginOfDay = strtotime("midnight", $current_timestamp);
		$endOfDay = strtotime("tomorrow", $beginOfDay) - 1;	
		$start_time = $current_timestamp - 5 * MINUTE_IN_SECONDS;
		$end_time = $current_timestamp;
		
		$visitors_total = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat ") + $initial_value;
		$visitors_today = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $beginOfDay AND $endOfDay ");
		$visitors_active = count($wpdb->get_col("SELECT DISTINCT ip FROM $visitors_stat WHERE time BETWEEN $start_time AND $end_time "));	
	
	
		
		if( 1 == $style ){
		?>
		<div class="royalvisitorstatswidget">
			<div class="style1">
			<?php if( "show" == $show_active ){ ?>	
				<div class="counter"><?php echo $visitors_active; ?></div>
				<div class="text"><?php if( "show" == $show_active_dot ){ echo '<div class="royal_pulsing_overlap"><div class="royal_pulsating_circle"></div></div>';} ?><?php echo $active_text; ?></div>
			<?php } ?>
			
			<?php if( "show" == $show_today ){ ?>	
				<div class="counter"><?php echo $visitors_today; ?></div>
				<div class="text"><?php echo $today_text; ?></div>
			<?php } ?>
			
			<?php if( "show" == $show_total ){ ?>	
				<div class="counter"><?php echo $visitors_total; ?></div>
				<div class="text"><?php echo $total_text; ?></div>
			<?php } ?>
			
			</div>
		</div>
		<?php
		
		}elseif( 2 == $style ){			
		?>
		<div class="royalvisitorstatswidget">
			<div class="style2">
			<?php if( "show" == $show_active ){ ?>	
				<div class="text"><?php if( "show" == $show_active_dot ){ echo '<div class="royal_pulsing_overlap"><div class="royal_pulsating_circle"></div></div>';} ?><?php echo $active_text; ?></div>
				<div class="counter"><?php echo $visitors_active; ?></div>
			<?php } ?>
			
			<?php if( "show" == $show_today ){ ?>
				<div class="text"><?php echo $today_text; ?></div>
				<div class="counter"><?php echo $visitors_today; ?></div>	
			<?php } ?>
			
			<?php if( "show" == $show_total ){ ?>	
				<div class="text"><?php echo $total_text; ?></div>
				<div class="counter"><?php echo $visitors_total; ?></div>
			<?php } ?>
			
			</div>
		</div>
		<?php				
			
		}elseif( 3 == $style ){
		?>
		<div class="royalvisitorstatswidget">
			<div class="style3">
			<table>
			<?php if( "show" == $show_active ){ ?>
				<tr>
					<td class="text"><?php if( "show" == $show_active_dot ){ echo '<div class="royal_pulsing_overlap"><div class="royal_pulsating_circle"></div></div>';} ?><?php echo $active_text; ?></td>
					<td class="counter"><?php echo $visitors_active; ?></td>
				</tr>
			<?php } ?>
			
			<?php if( "show" == $show_today ){ ?>	
				<tr>
					<td class="text"><?php echo $today_text; ?></td>
					<td class="counter"><?php echo $visitors_today; ?></td>
				</tr>
			<?php } ?>
			
			<?php if( "show" == $show_total ){ ?>	
				<tr>
					<td class="text"><?php echo $total_text; ?></td>
					<td class="counter"><?php echo $visitors_total; ?></td>
				</tr>
			<?php } ?>
			</table>
			</div>
		</div>
		<?php
		
		}elseif( 4 == $style ){
		
		}else{
			
		}
		
		
		} else {
			echo '<div class="royalalert">Live Visitor Counter is not installed/activated on your site. Please install and activate.</div>';
		}
	}



    protected function content_template() {
        
    }

}
