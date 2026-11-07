<?php
namespace RoyalAddons\Widgets;

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Frontend;
use \Elementor\Repeater;
use \Elementor\Plugin;
use RoyalAddons\Elementor\Royal_Helpers;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RoyalContentSlider extends Widget_Base{

	public function get_name() {
		return 'royalcontentslider';
	}

	public function get_title() {
		return esc_html__( 'Content Slider', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-post-slider rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'content', 'slider', 'carousel', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_style_depends() {
		$styles = ['royalowlcarousel', 'royalowlcarouseltheme' ,'royalcarousel'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalowlcarousel', 'royalcarousel'];
		return $scripts;
	}	

	protected function register_controls() {
		$this->rt_content_layout_options();
		Royal_Helpers::royal_carousel_options( $this );
		Royal_Helpers::royal_style_nav_options( $this );
		Royal_Helpers::royal_style_dot_options( $this );
		Royal_Helpers::royal_style_image_options( $this );
	}


	private function rt_content_layout_options() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'slider_title',
			[
				'label' => __( 'Slider Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Slider Title #1', 'royal-addons-for-elementor' ),
				'label_block' => true
			]
		);


		$repeater->add_control(
			'templates',
			[
				'label'   		=> __('Choose Template', 'royal-addons-for-elementor'),
				'type'    		=> Controls_Manager::SELECT,
				'default' 		=> '0',
				'options' 		=> Royal_Helpers::royal_elementor_templates(),
			]
		);


		$this->add_control(
			'slider',
			[
				'label' => __( 'Slider', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'slider_title' => __( 'Slider Title', 'royal-addons-for-elementor' ),
					],
				],
				'title_field' => '{{{ slider_title }}}',
			]
		);
		$this->end_controls_section();		
	}

	

	private function rt_style_carousel_options() {
		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => __( 'Carousel', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'carousel_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Carousel Background Color', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();		
	}



	private function rt_style_navigation_options() {
		$this->start_controls_section(
			'section_navigation',
			[
				'label' => __( 'Navigation', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nav_options',
			[
				'label' => esc_html__( 'Nav Options', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'nav_dev_size',
			[
				'label'     => __( 'Nav Dev height & width', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_size',
			[
				'label'     => __( 'Nav Size', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Color', 'royal-addons-for-elementor' ),
				'default'	=> '#869791',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'nav_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Color Hover', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button:hover i' => 'color: {{VALUE}};',
				],
			]
		);	
		
		$this->add_control(
			'nav_radius',
			[
				'label'     => __( 'Nav Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_control(
			'nav_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Background', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff00',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i' => 'background-color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_control(
			'nav_background_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Background Hover', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button i:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);	
		

		$this->add_control(
			'nav_whole_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Whole Background', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff00',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button' => 'background-color: {{VALUE}}!important;',
				],
			]
		);

		$this->add_control(
			'nav_whole_background_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Whole Background Hover', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff00',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);	
	


		$this->add_control(
			'dot_options',
			[
				'label' => esc_html__( 'Dot Options', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);		
		$this->add_control(
			'dot_size',
			[
				'label'     => __( 'Dot Size', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .royalcarouseldotinsidecenter.owl-carousel .owl-dots .owl-dot' => 'width: calc({{SIZE}}{{UNIT}} + 10px); height: calc({{SIZE}}{{UNIT}} + 10px);',
				],
			]
		);

		$this->add_control(
			'dot_radius',
			[
				'label'     => __( 'Dot Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 50,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot span' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'dot_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Dot Color', 'royal-addons-for-elementor' ),
				'default'	=> '#869791',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_color_active',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Active Dot Color', 'royal-addons-for-elementor' ),
				'default'	=> '#dddddd',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-dots .owl-dot.active span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}






	protected function render() {
		$settings 			= $this->get_settings();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $loop           = $settings['loop'];
        $autoplay       = $settings['autoplay'];
        $margin         = $settings['margin'];
        $timeout        = $settings['timeout'];
        $navposition    = $settings['navposition'];
        $dotposition    = $settings['dotposition'];
        $previous_icon_html = '';
        $next_icon_html = '';
        if ( isset( $settings['previousicon']['value'] ) && ! empty( $settings['previousicon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['previousicon'], [ 'aria-hidden' => 'true' ] );
            $previous_icon_html = ob_get_clean();
        }

        if ( isset( $settings['nexticon']['value'] ) && ! empty( $settings['nexticon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['nexticon'], [ 'aria-hidden' => 'true' ] );
            $next_icon_html = ob_get_clean();
        }
        $navtext = json_encode( [ $previous_icon_html, $next_icon_html ] );
        $desktopitems   = $settings['desktopitems'];
        if ( 'yes' === $settings['desktopdots'] ) {
			$desktopdots = 'true';
		} else{
            $desktopdots = 'false';
        } 
        if ( 'yes' === $settings['desktopnav'] ) {
			$desktopnav = 'true';
		} else{
            $desktopnav = 'false';
        }           


        $tabitems       = $settings['tabitems'];
        if ( 'yes' === $settings['tabdots'] ) {
			$tabdots = 'true';
		} else{
            $tabdots = 'false';
        }
        if ( 'yes' === $settings['tabnav'] ) {
			$tabnav = 'true';
		} else{
            $tabnav = 'false';
        }                     


        $mobileitems    = $settings['mobileitems'];
        if ( 'yes' === $settings['mobiledots'] ) {
			$mobiledots = 'true';
		} else{
            $mobiledots = 'false';
        } 
        if ( 'yes' === $settings['mobilenav'] ) {
			$mobilenav = 'true';
		} else{
            $mobilenav = 'false';
        } 

        $this->add_render_attribute(
            'royal_carousel_options',
            [
                'id'                	=> $carouselid,
                'data-loop'         	=> $loop,
                'data-autoplay'     	=> $autoplay,
                'data-margin'       	=> $margin,
                'data-autoplayTimeout'	=> $timeout,
                'data-navtext'   		=> $navtext,	

                'data-desktopitems' 	=> $desktopitems,
                'data-desktopdots'  	=> $desktopdots,
                'data-desktopnav'   	=> $desktopnav,

                'data-tabitems'     	=> $tabitems,
				'data-tabdots'  		=> $tabdots,
                'data-tabnav'   		=> $tabnav,

                'data-mobileitems'  	=> $mobileitems,
                'data-mobiledots'  		=> $mobiledots,
                'data-mobilenav'   		=> $mobilenav,	
			
            ]
        );


		echo'<div class="royalmastercarousel">';
		echo '<div class="royalcarousel owl-carousel owl-theme '.$navposition.' '.$dotposition.'" '.$this->get_render_attribute_string( 'royal_carousel_options' ).'>';
		foreach( $settings[ 'slider' ] as $slide ):

		echo '<div class="item">';
		echo Plugin::instance()->frontend->get_builder_content_for_display($slide['templates']);
		echo '</div>';
		
		endforeach; 
		echo'</div>';	
		echo'</div>';	
	}


	protected function content_template() {

	}
}