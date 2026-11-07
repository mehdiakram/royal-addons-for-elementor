<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalWooProductsGrid extends Widget_Base {

	public function get_name() {
		return 'royalwooproductsgrid';
	}

	public function get_title() {
		return __( 'Products Grid', 'royal-addons-for-elementor' );
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
			$this->rt_content_query_options();
			$this->rt_content_heading_block_options();
			$this->rt_style_layout_options();
			$this->rt_style_box_options();
			$this->rt_style_image_options();
			$this->rt_style_title_options();
			$this->rt_style_price_options();
			$this->rt_style_cart_options();
			$this->rt_style_heading_block();
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
			'grid_style',
			[
				'label' => __( 'Grid Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'gridstyle1',
				'options' => [
					'gridstyle1' => esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'gridstyle2' => esc_html__( 'Style 2', 'royal-addons-for-elementor' ),
					'gridstyle3' => esc_html__( 'Style 3', 'royal-addons-for-elementor' ),
					'gridstyle4' => esc_html__( 'Style 4', 'royal-addons-for-elementor' ),
					'gridstyle5' => esc_html__( 'Style 5', 'royal-addons-for-elementor' ),
					'gridstyle6' => esc_html__( 'Style 6', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1 Columns',
					'2' => '2 Columns',
					'3' => '3 Columns',
					'4' => '4 Columns',
					'5' => '5 Columns',
					'6' => '6 Columns',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
				'selectors' => [
					'.elementor-msie {{WRAPPER}} .elementor-portfolio-item' => 'width: calc( 100% / {{SIZE}} )',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 7,
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
				'default' => 'full',
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
				'options'   => Royal_Helpers::royal_title_tags(),
				'default' => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_price',
			[
				'label' => __( 'Price', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
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
					'{{WRAPPER}} .royalwooproducts .productsummary' => 'text-align: {{VALUE}};',
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

		// Post categories
		$this->add_control(
			'product_cat',
			[
				'label'       => __( 'Product Categories', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalWooClass::product_cat('product' ),

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


	private function rt_content_heading_block_options() {

		$this->start_controls_section(
			'section_heading_block',
			[
				'label' => __( 'Heading Block', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_heading_block',
			[
				'label' => __( 'Heading Block', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);


		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Heading Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'This is the heading', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your heading', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_heading_block' => 'yes',
				],				
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => esc_html__( 'Heading Description', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your heading description', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_heading_block' => 'yes',
				],					
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Layout Options.
	 */
	private function rt_style_layout_options() {

		// Layout.
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Layout', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Columns margin.
		$this->add_control(
			'grid_style_columns_margin',
			[
				'label'     => __( 'Columns margin', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalwooproducts' => 'grid-column-gap: {{SIZE}}{{UNIT}}',

				],
			]
		);

		// Row margin.
		$this->add_control(
			'grid_style_rows_margin',
			[
				'label'     => __( 'Rows margin', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalwooproducts' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .royalwooproducts .wooproduct' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Border Radius.
		$this->add_control(
			'grid_style_border_radius',
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
					'{{WRAPPER}} .royalwooproducts .wooproduct' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .royalwooproducts .wooproduct' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .royalwooproducts .wooproduct' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalwooproducts .wooproduct' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalwooproducts .wooproduct',
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
					'{{WRAPPER}} .royalwooproducts .wooproduct:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalwooproducts .wooproduct:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalwooproducts .wooproduct:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

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
					'{{WRAPPER}} .post-grid-inner .post-grid-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_style_image_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .post-grid-inner .post-grid-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .royalwooproducts .wooproduct .title, {{WRAPPER}} .royalwooproducts .wooproduct .title > a',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style' );

		$this->start_controls_tab(
			'grid_title_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'grid_title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalwooproducts .wooproduct .title, {{WRAPPER}} .royalwooproducts .wooproduct .title > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'grid_title_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'grid_title_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .royalwooproducts .wooproduct .title, {{WRAPPER}} .royalwooproducts .wooproduct .title > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproducts .wooproduct .title, {{WRAPPER}} .royalwooproducts .wooproduct .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	
	private function rt_style_price_options() {
		$this->start_controls_section(
			'section_grid_price_block_style',
			[
				'label'     => __( 'Price', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_price_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproducts .productsummary .price',
			]
		);

		$this->add_control(
			'grid_price_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => array(
					'{{WRAPPER}} .royalwooproducts .productsummary .price' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'grid_price_bgcolor',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
				'default' 	=> '#fff',
				'selectors' => array(
					'{{WRAPPER}} .royalwooproducts .productsummary .price' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'grid_price_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproducts .productsummary .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_price_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproducts .productsummary .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'grid_price_border',
				'selector' => '{{WRAPPER}} .royalwooproducts .productsummary .price',
			]
		);

		$this->end_controls_section();
	}


	private function rt_style_cart_options() {
		$this->start_controls_section(
			'section_grid_cart_style',
			[
				'label'     => __( 'Cart', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,			
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_cart_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproducts .productsummary .addtocart a',
			]
		);

		$this->add_control(
			'grid_cart_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => array(
					'{{WRAPPER}} .royalwooproducts .productsummary .addtocart a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'grid_cart_bgcolor',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
				'default' 	=> '#fff',
				'selectors' => array(
					'{{WRAPPER}} .royalwooproducts .productsummary .addtocart a' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'grid_cart_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproducts .productsummary .addtocart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_cart_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproducts .productsummary .addtocart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'grid_cart_border',
				'selector' => '{{WRAPPER}} .royalwooproducts .productsummary .addtocart a',
			]
		);
		$this->end_controls_section();
	}


	private function rt_style_heading_block() {
		$this->start_controls_section(
			'section_grid_heading_block_style',
			[
				'label'     => __( 'Heading Block', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_heading_block' => 'yes',
				],					
			]
		);
	
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_block_title_typography',
				'label'     => __( 'Title Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproducts .headingblock h2',
			]
		);

		$this->add_control(
			'heading_block_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalwooproducts .headingblock h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_block_desc_typography',
				'label'     => __( 'Description Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproducts .headingblock div',
			]
		);

		$this->add_control(
			'heading_block_desc_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalwooproducts .headingblock div' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}



	protected function render( $instance = [] ) {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Get settings.
			$settings = $this->get_settings();

				$grid_style = $settings['grid_style'];

				?>
				<div class="royalwooproducts elementor-grid <?php echo $grid_style ?>">
				<?php 
					$this->render_heading_block(); 
				
					$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );
					$product_cat = is_array( $settings['product_cat'] ) ? implode( ',', $settings['product_cat'] ) : $settings['product_cat'];
					
					$query_args = array(
									'post_type'             => 'product',
									'posts_per_page' 		=> absint( $posts_per_page ),
									'no_found_rows'  		=> true,
									'post_status'         	=> 'publish',
									'ignore_sticky_posts'   => true,
									'product_cat' 			=> $product_cat
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
						if( "gridstyle1" == $grid_style ){
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>						
									<article id="post-<?php the_ID(); ?>" <?php post_class('wooproduct'); ?>>								 
										<div class="productinner">										
											<?php $this->render_thumbnail(); ?>						
											<div class="productsummary">
												   <?php $this->render_title(); ?>
												   <?php $this->product_price(); ?>
												   <?php $this->add_to_cart(); ?>
											</div>						
										</div>						   
									</article>						
									<?php						
							endwhile; 						
							wp_reset_postdata();
											

						}elseif( "gridstyle2" == $grid_style ){
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
									<article id="post-<?php the_ID(); ?>" <?php post_class('wooproduct'); ?>>     
										<div class="post-grid-inner">              
											<?php $this->render_thumbnail(); ?>
											<div class="productsummary">
												<?php $this->render_title(); ?>
												<?php $this->product_price(); ?>
											</div>
										</div>          
									</article>
									<?php
							endwhile; 
							wp_reset_postdata();


						}elseif( "gridstyle3" == $grid_style ){
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
									<article id="post-<?php the_ID(); ?>" <?php post_class('wooproduct'); ?>>      
										<div class="post-grid-inner">          	
											<?php $this->render_title(); ?>
											<?php $this->product_price(); ?>
											<?php $this->render_thumbnail(); ?>
										</div>        
									</article>
									<?php
							endwhile; 
							wp_reset_postdata();	


						}elseif( "gridstyle4" == $grid_style ){
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
									<article id="post-<?php the_ID(); ?>" <?php post_class('wooproduct'); ?>>
										<div class="post-grid-inner">
											<?php $this->render_title(); ?>
											<?php $this->product_price(); ?>
											 <?php $this->render_thumbnail(); ?>
										</div>
									</article>
									<?php
							endwhile; 
							wp_reset_postdata();


						}elseif( "gridstyle5" == $grid_style ){
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
									<article id="post-<?php the_ID(); ?>" <?php post_class('wooproduct'); ?>>
										<div class="post-grid-inner">    	
											<?php $this->render_thumbnail(); ?>
											<div class="productsummary">
												   <?php $this->render_title(); ?>
												   <?php $this->product_price(); ?>
											</div>
										</div>
									</article>
									<?php
							endwhile; 
							wp_reset_postdata();


						}elseif( "gridstyle6" == $grid_style ){
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
									<article id="post-<?php the_ID(); ?>" <?php post_class('wooproduct'); ?>>     
										<div class="post-grid-inner">              
											<?php $this->render_thumbnail(); ?>
											<div class="productsummary">
												<?php $this->render_title(); ?>
												<?php $this->product_price(); ?>
												<?php $this->add_to_cart(); ?>
											</div>
										</div>          
									</article>
									<?php
							endwhile; 
							wp_reset_postdata();


						}else{
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>						
									<article id="post-<?php the_ID(); ?>" <?php post_class('wooproduct'); ?>>								 
										<div class="productinner">										
											<?php $this->render_thumbnail(); ?>						
											<div class="productsummary">
												   <?php $this->render_title(); ?>
												   <?php $this->product_price(); ?>
												   <?php $this->add_to_cart(); ?>
											</div>						
										</div>						   
									</article>						
									<?php						
							endwhile; 						
							wp_reset_postdata();
						}

					endif; ?>
			</div>
			<?php

		}
	}


	protected function render_heading_block() {
		$settings = $this->get_settings();
		$show_heading_block = $settings['show_heading_block'];

		if ( 'yes' !== $show_heading_block ) {
			return;
		}

		echo'<article class="headingblock">
				<h2>'.$settings['heading_title'].'</h2>
				<div>'.$settings['heading_description'].'</div>				   
			</article>';
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
			<div class="productthumbnail">
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


	protected function product_price() {
		$settings = $this->get_settings();
		$show_price = $settings['show_price'];

		if ( 'yes' !== $show_price ) {
			return;
		}

		global $product;
		echo '<div class="price">'. $product->get_price_html().'</div>';
	}

	protected function add_to_cart() {
		global $product;
		$id = $product->get_id();
		if( $product->is_type( 'simple' ) ){
			echo'<div class="addtocart"><a href="?add-to-cart='.$id.'">Add to cart</a></div>';
		} else {
			echo'<div class="addtocart"><a href="'. get_the_permalink().'">Details</a></div>';
		}

		
	}



}
