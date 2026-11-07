<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalAuto extends Widget_Base {

	public function get_name() {
		return 'royalauto';
	}

	public function get_title() {
		return __( 'Royal Auto', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-post-list rtbranding'; }

	public function get_keywords() {
		return ['vehicle', 'auto', 'carousel', 'car', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	  }

	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
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
		if ( post_type_exists( 'royalauto' ) ) {
			$this->rt_content_layout_options();
			$this->rt_content_query_options();
			Royal_Helpers::royal_carousel_options( $this, [ 'style' => 'carousel' ] );
			$this->rt_style_box_options();
			Royal_Helpers::royal_style_nav_options( $this );		
			$this->rt_style_image_options();

			$this->rt_style_title_options();
			$this->rt_style_content_options();
		} else {
			$this->royal_tech_post_type_not_found();
		}
	}

	/**
	 * Content Layout Options.
	 */
	private function royal_tech_post_type_not_found() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( '"royalauto" post type not found', 'royal-addons-for-elementor' ),
			]
		);	 
		
		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'No post type "royalauto" found, Please contact Developer.', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);		
		
		$this->end_controls_section();
	}	 
	 
	 
	 
	private function rt_content_layout_options() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
			]
		);


		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid' => __( 'Grid', 'royal-addons-for-elementor' ),
					'carousel' => __( 'Carousel', 'royal-addons-for-elementor' ),
				],
			]
		);
		
		
		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'image400x600',
				'prefix_class' => 'post-thumbnail-size-',
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
				'condition' => [
					'show_title' => 'yes',
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
					'{{WRAPPER}} .post-post-inner' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Content Query Options.
	 */
	private function rt_content_query_options() {

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'royalauto_country',
			[
				'label'       => __( 'Country', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalClass::royalauto_country('royalauto' ),
			]
		);

		$this->add_control(
			'royalauto_type',
			[
				'label'       => __( 'Type', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalClass::royalauto_type('royalauto' ),
			]
		);


		$this->add_control(
			'royalauto_brand',
			[
				'label'       => __( 'Brand', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalClass::royalauto_brand('royalauto' ),
			]
		);


		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'royal-addons-for-elementor' ),
					'post_title' => __( 'Title', 'royal-addons-for-elementor' ),
					'rand' => __( 'Random', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'royal-addons-for-elementor' ),
					'desc' => __( 'DESC', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();

	}




	/**
	 * Style Box Options.
	 */
	private function rt_style_box_options() {

		// Box.
		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'Box', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_box_border_width',
			[
				'label'      => __( 'Border Widget', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Border Radius.
		$this->add_control(
			'style_border_radius',
			[
				'label'     => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Box internal padding.
		$this->add_responsive_control(
			'grid_items_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_button_style_normal_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Normal border color.
		$this->add_control(
			'grid_button_style_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalmastercarousel',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_button_style_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'grid_button_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalmastercarousel:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function rt_style_navigation_options() {
		$this->start_controls_section(
			'section_navigation',
			[
				'label' => __( 'Navigation', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => 'carousel',
				],				
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

	/**
	 * Style Image Options.
	 */
	private function rt_style_image_options() {

		// Box.
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .post-post-inner .post-post-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'style_image_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .post-post-inner .post-post-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style > Title.
	 */
	private function rt_style_title_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label'     => __( 'Title', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_title_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			)
		);

		// Title color.
		$this->add_control(
			'grid_title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_title_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			)
		);

		// Title hover color.
		$this->add_control(
			'grid_title_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Title margin.
		$this->add_responsive_control(
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Meta.
	 */
	private function rt_style_meta_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_meta_style',
			[
				'label'     => __( 'Meta', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => 'carousel',
				],
			]
		);

		// Meta typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_meta_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .royalmastercarousel .post-post-meta span',
			]
		);

		// Meta color.
		$this->add_control(
			'grid_meta_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .post-post-meta span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalmastercarousel .post-post-meta span a' => 'color: {{VALUE}};',
				],
			]
		);

		// Meta margin.
		$this->add_responsive_control(
			'grid_meta_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel .post-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Content.
	 */
	private function rt_style_content_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_content_style',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'style' => 'carousel',
				],
			]
		);

		// Content typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_content_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .royalmastercarousel .post-post-excerpt p',
			]
		);

		// Content color.
		$this->add_control(
			'grid_content_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .post-post-excerpt p' => 'color: {{VALUE}};',
				],
			]
		);

		// Content margin
		$this->add_responsive_control(
			'grid_content_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel .post-post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Readmore.
	 */
	private function rt_style_readmore_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_readmore_style',
			[
				'label' => __( 'Read More', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		// Readmore typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_readmore_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .royalmastercarousel a.read-more-btn',
			]
		);

		$this->start_controls_tabs( 'grid_readmore_color_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_readmore_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			)
		);

		// Readmore color.
		$this->add_control(
			'grid_readmore_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn' => 'color: {{VALUE}};',
				],
			]
		);

		// Readmore background color.
		$this->add_control(
			'grid_readmore_style_background_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Readmore border color.
		$this->add_control(
			'grid_readmore_style_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_readmore_style_color_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			)
		);

		// Readmore hover color.
		$this->add_control(
			'grid_readmore_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn:hover' => 'color: {{VALUE}};',
				),
			)
		);

		// Readmore hover background color.
		$this->add_control(
			'grid_readmore_style_hover_background_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Readmore hover border color.
		$this->add_control(
			'grid_readmore_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Readmore border width.
		$this->add_control(
			'grid_readmore_style_border_width',
			[
				'type'       => Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Width', 'royal-addons-for-elementor' ),
				'separator'  => 'before',
				'size_units' => array( 'px' ),
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Readmore border radius.
		$this->add_control(
			'grid_readmore_style_border_radius',
			array(
				'label'     => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		// Readmore button padding.
		$this->add_responsive_control(
			'grid_readmore_style_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		// Readmore margin.
		$this->add_responsive_control(
			'grid_readmore_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel a.read-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		if ( post_type_exists( 'royalauto' ) ) {
			$settings 		= $this->get_settings();
			$id         	= $this->get_id();
			$carouselid     = 'royalcarousel'.$id;
			$loop           = $settings['loop'];
			$style 			= $settings['style'];
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

			?>

				<div class="royalmastercarousel">
					<?php
					$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );
					$royalauto_country = is_array( $settings['royalauto_country'] ) ? implode( ',', $settings['royalauto_country'] ) : $settings['royalauto_country'];
					$royalauto_type = is_array( $settings['royalauto_type'] ) ? implode( ',', $settings['royalauto_type'] ) : $settings['royalauto_type'];
					$royalauto_brand = is_array( $settings['royalauto_brand'] ) ? implode( ',', $settings['royalauto_brand'] ) : $settings['royalauto_brand'];
								
					$tax_query = array('relation'=>'AND');

					if(isset($royalauto_country) && $royalauto_country!=""){
						$tax_query[] = array(
								   'taxonomy' => 'royalauto_country',
								   'field' => 'slug',
								   'terms' => $royalauto_country,
								   'compare' => 'LIKE',
								   'operator' => 'IN'
						   );
					   }  
			   
				   if(isset($royalauto_type) && $royalauto_type!=""){
						$tax_query[] = array(
								   'taxonomy' => 'royalauto_type',
								   'field' => 'slug',
								   'terms' => $royalauto_type,
								   'compare' => 'LIKE',
								   'operator' => 'IN'
						   );
					   }     
			   
				   if(isset($royalauto_brand) && $royalauto_brand!=""){
						$tax_query[] = array(
								   'taxonomy' => 'royalauto_brand',
								   'field' => 'slug',
								   'terms' => $royalauto_brand,
								   'compare' => 'LIKE',
								   'operator' => 'IN'
						   );
					   }     


					$query_args = array(
									'post_type'             => 'royalauto',
									'posts_per_page' 		=> absint( $posts_per_page ),
									'no_found_rows'  		=> true,
									'post_status'         	=> 'publish',
									'ignore_sticky_posts'   => true,
									'tax_query' 			=> $tax_query,
								);

					// Order by.
					if ( ! empty( $settings['orderby'] ) ) {
						$query_args['orderby'] = $settings['orderby'];
					}

					// Order .
					if ( ! empty( $settings['order'] ) ) {
						$query_args['order'] = $settings['order'];
					}

					$all_posts = new \WP_Query( $query_args );

					if ( $all_posts->have_posts() ) :
						if( 'grid' == $style ){
							echo '<div class="royalautogrid">';
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); 
								echo '<div class="royalautogridsingle">';
									$this->render_thumbnail(); 
									$this->render_title(); 
								echo '</div>';
							endwhile; 
							wp_reset_postdata();
							echo '</div>';
							/* Grid */	


						}elseif( 'carousel' == $style ){
							echo '<div class="royalcarousel owl-carousel owl-theme '.$navposition.' '.$dotposition.'" '.$this->get_render_attribute_string( 'royal_carousel_options' ).'>';
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
									<div class="item">     
										<div class="post-post-inner">          
											<?php $this->render_thumbnail(); ?>
											<div class="post-post-text-wrap">
												<?php $this->render_title(); ?>
											</div>
										</div><!-- .blog-inner -->           
									</div>
									<?php
							endwhile; 
							wp_reset_postdata();
							echo '</div>';
							/* Carousel */
						}
					endif; ?>
				</div>	
			<?php

		}
	}

	protected function render_thumbnail() {
		$settings = $this->get_settings();
		$show_image = $settings['show_image'];
		if ( 'yes' !== $show_image ) {
			return;
		}

		$post_thumbnail_size = $settings['post_thumbnail_size'];
		if ( has_post_thumbnail() ) :
			$post_title = get_the_title();
			$thumbnail_id = get_post_thumbnail_id();
			$alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
			if ( empty( $alt_text ) ) {
				$alt_text = $post_title;
			}
			?>
			<div class="post-post-thumbnail">
				<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<?php the_post_thumbnail( $post_thumbnail_size, array( 'alt' => esc_attr( $alt_text ) ) ); ?>
				</a>
			</div>
		<?php endif;
	}

	protected function render_title() {
		$settings = $this->get_settings();
		$show_title = $settings['show_title'];
		if ( 'yes' !== $show_title ) {
			return;
		}
		$title_tag = $settings['title_tag'];
		?>
		<<?php echo $title_tag; ?> class="title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</<?php echo $title_tag; ?>>
		<?php
	}


}
