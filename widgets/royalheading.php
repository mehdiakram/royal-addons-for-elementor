<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalHeading extends Widget_Base {

	public function get_name() {
		return 'royalheading';
	}


	public function get_title() {
		return __( 'Heading', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-heading rtbranding'; }


	public function get_keywords() {
		return [ 'heading', 'header', 'title', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}

	
	public function get_style_depends() {
		$styles = [ 'royalheading' ];
		return $styles;
	}


	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'heading_style',
			[
				'label' => __( 'Heading Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Style 2', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Style 3', 'royal-addons-for-elementor' ),
					'4' => esc_html__( 'Style 4', 'royal-addons-for-elementor' ),
					'5' => esc_html__( 'Style 5', 'royal-addons-for-elementor' ),
				],
			]
		);



        // Sub Heading Start
		$this->add_control(
			'main_sub_heading',
			[
				'label' => __( 'Sub Heading', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Sub Heading',
				'condition' => [
					'heading_style' => '1',
				],				
				'placeholder' => __( 'Write Sub Heading Here', 'royal-addons-for-elementor' ),
			]
        );

        //Color
        $this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#777',
				'condition' => [
					'heading_style' => '1',
				],				
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 h4' => 'color: {{VALUE}}',
				],
			]
        );		
        //Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'condition' => [
					'heading_style' => '1',
				],					
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalheading h4',			
			]
        );		
		// Sub Heading End




        // Heading Start
		$this->add_control(
			'main_heading',
			[
				'label' => __( 'Heading', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Heading',
                'separator'=> 'before',
				'placeholder' => __( 'Write Heading Here', 'royal-addons-for-elementor' ),
			]
        );



		$this->add_control(
			'main_heading_padding_bottom',
			[
				'label' => esc_html__( 'Padding Bottom', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,				
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .royalheading h2' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);		






        //Color
        $this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#333',
				'selectors' => [
					'{{WRAPPER}} .royalheading h2' => 'color: {{VALUE}}',
				],
			]
        );
        
        //Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalheading h2',	
			]
        );        
        // Heading End


        // Description Start
		$this->add_control(
			'main_description',
			[
				'label' => __( 'Description', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => 'Description',
				'condition' => [
					'heading_style' => '1',
				],					
                'separator'=> 'before',
				'placeholder' => __( 'Write Description Here', 'royal-addons-for-elementor' ),
			]
        );

        //Color
        $this->add_control(
			'desc_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#333',
				'condition' => [
					'heading_style' => '1',
				],					
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 p' => 'color: {{VALUE}}',
				],
			]
        );
        
        //Typography 
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'separator'=> 'after',
				'condition' => [
					'heading_style' => '1',
				],					
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalheading p',				
			]
        );
		// Description End



		// Primary Line
		$this->add_control(
			'primaryline_options',
			[
				'label' => esc_html__( 'Primary / Right Line', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'heading_style' => ['1', '2', '4', '5'],
				],					
				'separator' => 'before',
			]
		);

		$this->add_control(
			'primaryline_width',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'heading_style' => ['1', '2', '4', '5'],
				],				
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 h2:after' => 'width: {{SIZE}}{{UNIT}}; margin-left:calc(-{{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .royalheadingtitle2 h2:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle3 h2:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle4 h2:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle5 h2:after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);		

		$this->add_control(
			'primaryline_height',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'heading_style' => ['1', '2', '4', '5'],
				],				
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 h2:after' => 'height: {{SIZE}}{{UNIT}}; bottom: calc(-{{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .royalheadingtitle2 h2:after' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle3 h2:after' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle4 h2:after' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle5 h2:after' => 'height: {{SIZE}}{{UNIT}}; bottom: calc((-{{SIZE}}{{UNIT}} - {{secondaryline_height.SIZE || secondaryline_height.DEFAULT}}{{UNIT}})/2);',
				],
			]
		);		


        $this->add_control(
			'primaryline_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'heading_style' => ['1', '2', '4', '5'],
				],					
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#e16038',
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 h2:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle2 h2:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle3 h2:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle4 h2:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle5 h2:after' => 'background-color: {{VALUE}}',
				],
			]
        );

		// Secondary
		$this->add_control(
			'secondaryline_options',
			[
				'label' => esc_html__( 'Secondary / Left Line', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'heading_style' => ['1', '3', '4', '5'],
				],					
				'separator' => 'before',
			]
		);

		$this->add_control(
			'secondaryline_width',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'heading_style' => ['1', '3', '4'],
				],					
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 h2:before' => 'width: {{SIZE}}{{UNIT}}; margin-left:calc(-{{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .royalheadingtitle2 h2:before' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle3 h2:before' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle4 h2:before' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle5 h2:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);		

		$this->add_control(
			'secondaryline_height',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'heading_style' => ['1', '3', '4', '5'],
				],					
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 h2:before' => 'height: {{SIZE}}{{UNIT}}; bottom: calc(-{{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}} .royalheadingtitle2 h2:before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle3 h2:before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle4 h2:before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle5 h2:before' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalheadingtitle5 h2' => 'border-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);		


        $this->add_control(
			'secondary_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#777',
				'condition' => [
					'heading_style' => ['1', '3', '4', '5'],
				],					
				'selectors' => [
					'{{WRAPPER}} .royalheadingtitle1 h2:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle2 h2:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle3 h2:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle4 h2:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .royalheadingtitle5 h2' 		=> 'border-bottom-color: {{VALUE}}',
				],
			]
        );

		$this->add_control(
			'main_heading_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				'separator'=> 'before',				
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royalheading h2' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .royalheadingtitle1' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .royalheadingtitle2 h2' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .royalheadingtitle3 h2' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .royalheadingtitle4 h2' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .royalheadingtitle5 h2' => 'justify-content: {{VALUE}};',
				],
			]
		);
       
        $this->end_controls_section();

	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		$heading_style     = !empty($settings['heading_style']) ? $settings['heading_style'] : '';
		$main_sub_heading  = !empty($settings['main_sub_heading']) ? $settings['main_sub_heading'] : '';
		$main_heading      = !empty($settings['main_heading']) ? $settings['main_heading'] : '';
		$main_description  = !empty($settings['main_description']) ? $settings['main_description'] : '';

		if ( empty($heading_style) ) {
			return;
		}

		echo '<div class="royalheading">';

		switch ( $heading_style ) {

			case 1:
				echo '<div class="royalheadingtitle1">';
					if ( $main_sub_heading ) {
						echo '<h4>' . esc_html( $main_sub_heading ) . '</h4>';
					}
					if ( $main_heading ) {
						echo '<h2>' . esc_html( $main_heading ) . '</h2>';
					}
					if ( $main_description ) {
						echo '<p>' . esc_html( $main_description ) . '</p>';
					}
				echo '</div>';
				break;

			case 2:
				echo '<div class="royalheadingtitle2">';
					if ( $main_heading ) {
						echo '<h2>' . esc_html( $main_heading ) . '</h2>';
					}
				echo '</div>';
				break;

			case 3:
				echo '<div class="royalheadingtitle3">';
					if ( $main_heading ) {
						echo '<h2>' . esc_html( $main_heading ) . '</h2>';
					}
				echo '</div>';
				break;

			case 4:
				echo '<div class="royalheadingtitle4">';
					if ( $main_heading ) {
						echo '<h2>' . esc_html( $main_heading ) . '</h2>';
					}
				echo '</div>';
				break;

			case 5:
				echo '<div class="royalheadingtitle5">';
					if ( $main_heading ) {
						echo '<h2>' . esc_html( $main_heading ) . '</h2>';
					}
				echo '</div>';
				break;
		}

		echo '</div>'; // .royalheading
	}


}