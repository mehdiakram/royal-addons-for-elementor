<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class RoyalBreadcrumbs extends Widget_Base {
	public function get_name() {
		return 'royalbreadcrumbs';
	}


	public function get_title() {
		return __('Breadcrumbs', 'royal-addons-for-elementor');
	}


	public function get_icon() { return 'eicon-product-breadcrumbs rtbranding'; }


	public function get_keywords() {
		return ['breadcrumbs', 'bread', 'crumb', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	
    public function get_categories() {
        return [ 'royaltech' ];
    }


	protected function register_controls() {
		$this->ads_content_controls();
	}


	protected function ads_content_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => __('General', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'home_type',
			[
				'label' => esc_html__( 'Home Type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
					'icon' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
					'none' => esc_html__( 'None', 'royal-addons-for-elementor' ),
				],
			]
		);   
		
		$this->add_control(
			'home_text',
			[
				'label' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Home', 'royal-addons-for-elementor' ),
				'condition' => [
					'home_type' => 'text',
				],
			]
		);

		$this->add_control(
			'home_icon',
			[
				'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,  
				'condition' => [
					'home_type' => 'icon',
				],
				'default' => [
					'value' => 'fas fa-home',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'laptop-house',
						'house-user',
						'house-damage',
						'hotel',
						'h-square',
					],
				],
			]
		);

		$this->add_control(
			'separator_type',
			[
				'label' => esc_html__( 'Separator Type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
					'icon' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				],
				'separator' => 'before',
			]
		); 

		$this->add_control(
			'separator_text',
			[
				'label' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '/', 'royal-addons-for-elementor' ),
				'condition' => [
					'separator_type' => 'text',
				],
			]
		);

		$this->add_control(
			'separator_icon',
			[
				'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,  
				'condition' => [
					'separator_type' => 'icon',
				],
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'caret-right',
						'angle-right',
						'angle-double-right',
					],
				],
			]
		);

		
		$this->end_controls_section();



        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );    

		$this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 1,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .royalbreadcrumbs',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalbreadcrumbs',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'home_color',
			[
				'label' => esc_html__( 'Home Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'condition' => [
					'home_type!' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs a.home' => 'color: {{VALUE}}',
					'{{WRAPPER}} .royalbreadcrumbs a.home svg' => 'display: flex; align-items: center; fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'parant_color',
			[
				'label' => esc_html__( 'Parants Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs a.parants' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => esc_html__( 'Separator Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs .separator' => 'color: {{VALUE}}',
					'{{WRAPPER}} .royalbreadcrumbs .separator svg' => 'display: flex; align-items: center; fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'current_color',
			[
				'label' => esc_html__( 'Current Page/Post Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs .current' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'home_icon_size',
			[
				'label' => esc_html__( 'Home Icon Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],				
				'condition' => [
					'home_type' => 'icon',
					'home_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs .home svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'separator_icon_size',
			[
				'label' => esc_html__( 'Separator Icon Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],				
				'condition' => [
					'separator_type' => 'icon',
					'separator_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs .separator svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_align',
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
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs' => 'display: flex; align-items: center; justify-content: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);	

		$this->add_responsive_control(
			'icon_gap',
			[
				'label' => esc_html__( 'Gap', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],				
				'selectors' => [
					'{{WRAPPER}} .royalbreadcrumbs' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}



    protected function render() {
        $settings 			= $this->get_settings_for_display();

		global $post;
		$breadcrumbs = [];
	
		if ($post->post_parent) {
			$ancestors = array_reverse(get_post_ancestors($post->ID));
			foreach ($ancestors as $ancestor_id) {
				$breadcrumbs[] = '<a class="parants" href="' . get_permalink($ancestor_id) . '">' . get_the_title($ancestor_id) . '</a>';
			}
		}
	
		$breadcrumbs[] = '<span class="current">' . get_the_title() . '</span>';
	
		echo '<div class="royalbreadcrumbs">';
			$this->render_home();
			$separator = $this->get_separator_output();
			echo implode( $separator, $breadcrumbs );
		echo '</div>';
		
		// Render Breadcrumb JSON-LD Schema
		$schema_list = [];
		$position = 1;
		
		// Home
		if ( $settings['home_type'] !== 'none' ) {
			$schema_list[] = [
				'@type' => 'ListItem',
				'position' => $position,
				'name' => $settings['home_type'] === 'text' ? $settings['home_text'] : 'Home',
				'item' => home_url( '/' )
			];
			$position++;
		}
		
		// Ancestors
		if ( $post->post_parent ) {
			foreach ( $ancestors as $ancestor_id ) {
				$schema_list[] = [
					'@type' => 'ListItem',
					'position' => $position,
					'name' => get_the_title( $ancestor_id ),
					'item' => get_permalink( $ancestor_id )
				];
				$position++;
			}
		}
		
		// Current Item
		$schema_list[] = [
			'@type' => 'ListItem',
			'position' => $position,
			'name' => get_the_title(),
			'item' => get_permalink()
		];
		
		$schema_data = [
			'@context' => 'https://schema.org',
			'@type' => 'BreadcrumbList',
			'itemListElement' => $schema_list
		];
		
		echo '<script type="application/ld+json">' . wp_json_encode( $schema_data ) . '</script>';

    }

	protected function get_separator_output() {
		$settings = $this->get_settings();

		ob_start();
		$this->render_separator(); // outputs the separator
		return ob_get_clean(); // return the output as string
	}



	protected function render_separator() {
		$settings = $this->get_settings();

        if($settings['separator_type'] == 'text'){
			echo'<span class="separator"> ' .$settings['separator_text'] . ' </span>';
		}else if ($settings['separator_type'] == 'icon'){
			if ( ! empty( $settings['separator_icon']['value'] ) ) {
			echo '<span class="separator">';
			\Elementor\Icons_Manager::render_icon( $settings['separator_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
			}
		else{}
		}
	}


	protected function render_home() {
		$settings = $this->get_settings();

        if($settings['home_type'] == 'text'){
			echo '<a class="home" href="' . home_url( '/' ) . '">' .$settings['home_text'] . '</a>'; $this->render_separator();
		}else if ($settings['home_type'] == 'icon'){
			if ( ! empty( $settings['home_icon']['value'] ) ) {
			echo '<a class="home" href="' . home_url( '/' ) . '">';
			\Elementor\Icons_Manager::render_icon( $settings['home_icon'], [ 'aria-hidden' => 'true' ] );
			echo ' </a>'; $this->render_separator();
			}
		else{}
		}
	}





}
