<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalWooCategory extends Widget_Base {

	public function get_name() {
		return 'royalwoocategory';
	}

	public function get_title() {
		return __( 'Products Category', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-products rtbranding'; }
	
	public function get_keywords() {
		return [ 'woo', 'woocommerce', 'products', 'grid', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
	
	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
	}

	public function get_style_depends() {
		$styles = [ 'royalwooproducts' ];
		return $styles;
	}

	protected function register_controls() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->rt_content_layout_options();
			$this->rt_style_box_options();
			$this->rt_style_image_options();
			$this->rt_style_title_options();
			$this->rt_style_aditiontext();
		} else {
			$this->royal_tech_woocommerce_not_found();
		}
	}

	private function royal_tech_woocommerce_not_found() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( '"Woocommerce" not found', 'royal-addons-for-elementor' ),
			]
		);	 
		
		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'Woocommerce plugin not active, Please install & active Woocommerce.', 'royal-addons-for-elementor' ),
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
			'cat_style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'catstyle1',
				'options' => [
					'catstyle1' => esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'catstyle2' => esc_html__( 'Style 2', 'royal-addons-for-elementor' ),

				],
			]
		);

		$this->add_control(
			'product_cat',
			[
				'label'       => __( 'Product Categories', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalWooClass::product_cat_id('product' ),

			]
		);


		$this->add_control(
			'aditiontext',
			[
				'label' => esc_html__( 'Adition Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( '25% off', 'royal-addons-for-elementor' ),
				'condition' => [
					'cat_style' => 'catstyle2',
				],
			]
		);


		$this->end_controls_section();

	}



	private function rt_style_box_options() {
		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'Box', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cat_style_border_radius',
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
					'{{WRAPPER}} .royalwoocategory .catbox' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'grid_items_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwoocategory .catstyle1 .catbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalwoocategory .catstyle2 .catinfo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style' );

		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'grid_button_style_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalwoocategory .catbox' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalwoocategory .catbox',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'grid_button_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalwoocategory .catbox:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalwoocategory .catbox:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}


	private function rt_style_image_options() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'grid_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalwoocategory .catbox img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .royalwoocategory .catbox img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cat_style_image_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwoocategory .catbox img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}


	private function rt_style_title_options() {
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label'     => __( 'Title', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwoocategory .catbox a .categorytitle',
			]
		);

		$this->add_responsive_control(
			'title_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwoocategory .catbox a .categorytitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'selector' => '{{WRAPPER}} .royalwoocategory .catbox a .categorytitle',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style' );

		$this->start_controls_tab(
			'title_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalwoocategory .catbox a .categorytitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalwoocategory .catbox a .categorytitle' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			)
		);


		$this->add_control(
			'title_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000000',
				'selectors' => array(
					'{{WRAPPER}} .royalwoocategory .catbox a .categorytitle:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_background',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
				'selectors' => array(
					'{{WRAPPER}} .royalwoocategory .catbox a .categorytitle:hover' => 'background: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	private function rt_style_aditiontext() {
		$this->start_controls_section(
			'section_aditiontext_style',
			[
				'label'     => __( 'Adition Text', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'aditiontext_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwoocategory .aditiontext',
			]
		);

		$this->add_control(
			'aditiontext_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#1d1d1d',
				'selectors' => array(
					'{{WRAPPER}} .royalwoocategory .aditiontext' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$settings = $this->get_settings();
			$cat_style 	= $settings['cat_style'];
			$aditiontext = $settings['aditiontext'];
			
			

			?>
			<div class="royalwoocategory">
			<?php 
				$product_cat = $settings['product_cat'];
				$cat = get_term($product_cat, 'product_cat' ); 
				$link = get_term_link($cat->term_id);
				$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true ); 
				$image = wp_get_attachment_url( $thumbnail_id ); 					

					if($cat_style == "catstyle1"){
						echo "<div class='catbox catstyle1'>";
						echo "<a href='{$link}'><img src='{$image}' alt='' width='200' height='200'><h2 class='categorytitle'>{$cat->name}<mark class='count'>{$cat->count} Products</mark></h2></a>";
						echo "</div>";

					}elseif($cat_style == "catstyle2" ){
						echo "<div class='catbox catstyle2'>";
						echo "<a href='{$link}'>";
						echo "<img src='{$image}' alt='' />";
						echo "<div class='catinfo'>";
						echo "<div class='catinfotop'><h2 class='categorytitle'>{$cat->name}</h2><div class='count'>Shop Now - {$cat->count} Products</div></div>";
						echo "<div class='aditiontext'>{$aditiontext}</div>";
						echo "</div>";
						echo "</a>";
						echo "</div>";
					}else{



					}
			?>
			</div>
			<?php

		}
	}









}
