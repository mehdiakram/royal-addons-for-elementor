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

/**
 * @since 1.1.0
 */
class RoyalJob extends Widget_Base {

	public function get_name() {
		return 'royaljob';
	}

	public function get_title() {
		return __( 'Job Post', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-post-list rtbranding'; }


	public function get_keywords() {
		return ['post', 'job', 'list', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
	}


	public function get_style_depends() {
		$styles = [ 'royalowlcarousel', 'royalowlcarouseltheme', 'royalpost'];
		return $styles;
	}


	public function get_script_depends() {
		$scripts = ['royalowlcarousel'];
		return $scripts;
	}


	protected function register_controls() {
		if ( post_type_exists( 'royaljob' ) ) {

		$this->rt_content_layout_options();
		$this->rt_content_query_options();
		Royal_Helpers::royal_carousel_options( $this );

		$this->rt_style_layout_options();
		$this->rt_style_box_options();
		$this->rt_style_image_options();

		$this->rt_style_title_options();
		$this->rt_style_meta_options();
		$this->rt_style_content_options();
		$this->rt_style_readmore_options();

		} else {
			$this->royal_tech_post_type_not_found();
		}
	}




	private function royal_tech_post_type_not_found() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( '"royaljob" post type not found', 'royal-addons-for-elementor' ),
			]
		);	 
		
		$this->add_control(
			'view',
			[
				'label' => esc_html__( '"royaljob" post type not found or actived, Please contact Developer.', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);		
		
		$this->end_controls_section();
	}	



	/**
	 * Content Layout Options.
	 */
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
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Layout 1', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Layout 2', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Layout 3', 'royal-addons-for-elementor' ),
					'4' => esc_html__( 'Layout 4', 'royal-addons-for-elementor' ),
					'5' => esc_html__( 'Layout 5', 'royal-addons-for-elementor' ),
					'6' => esc_html__( 'Layout 6', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Jobs Per Page', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 10,
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
			'meta_data',
			[
				'label' => __( 'Meta Data', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => [ 'date'],
				'multiple' => true,
				'options' => [
					'date' 			=> __( 'Job Post Date', 'royal-addons-for-elementor' ),
					'categories' 	=> __( 'Job Categories', 'royal-addons-for-elementor' ),
					'jobexpiredate' => __( 'Job Expire Date', 'royal-addons-for-elementor' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'meta_separator',
			[
				'label' => __( 'Separator Between', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '/',
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-meta span + span:before' => 'content: "{{VALUE}}"',
				],
				'condition' => [
					'meta_data!' => [],
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Excerpt', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				/** This filter is documented in wp-includes/formatting.php */
				'default' => apply_filters( 'excerpt_length', 25 ),
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_append',
			[
				'label' => __( 'Excerpt Append', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '&hellip;',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_read_more',
			[
				'label' => __( 'Read More', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'grid_style!' => '6',
				],				
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More »', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_read_more' => 'yes',
					'grid_style!' => '6',
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
					'{{WRAPPER}} .royalgridcontainer article' => 'text-align: {{VALUE}};',
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
			'royaljob_categories',
			[
				'label'       => __( 'Job Categories', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalClass::royaljob_categories('royaljob' ),

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
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer' => 'grid-column-gap: {{SIZE}}{{UNIT}}',

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
					'size' => 10,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalgridcontainer .royalpost',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalgridcontainer .royalpost:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
					'{{WRAPPER}} .royalgridcontainer .post-grid-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .royalgridcontainer .post-grid-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .royalgridcontainer .royalpost .title, {{WRAPPER}} .royalgridcontainer .royalpost .title > a',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost .title, {{WRAPPER}} .royalgridcontainer .royalpost .title > a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost .title, {{WRAPPER}} .royalgridcontainer .royalpost .title > a:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost .title, {{WRAPPER}} .royalgridcontainer .royalpost .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-meta span',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-meta span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-meta span a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'  => '{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-excerpt p',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-excerpt p' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'  => '{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .royalgridcontainer .royalpost a.read-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {
		if ( post_type_exists( 'royaljob' ) ) {

		$settings 		= $this->get_settings();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $loop           = $settings['loop'];
        $autoplay       = $settings['autoplay'];
        $margin         = $settings['margin'];
        $timeout        = $settings['timeout'];

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
		?>
			<?php
			$columns_desktop = ( ! empty( $settings['columns'] ) ? 'royalgrid-desktop-' . $settings['columns'] : 'royalgrid-desktop-3' );
			$columns_tablet = ( ! empty( $settings['columns_tablet'] ) ? ' royalgrid-tablet-' . $settings['columns_tablet'] : ' royalgrid-tablet-2' );
			$columns_mobile = ( ! empty( $settings['columns_mobile'] ) ? ' royalgrid-mobile-' . $settings['columns_mobile'] : ' royalgrid-mobile-1' );
			$grid_style = $settings['grid_style'];
			$styleclass = 'gridstyle'.$grid_style;

			$grid_class = '';

			if( 5 == $grid_style ){
				$grid_class = ' grid-meta-bottom';
			}
			?>
			<div class="royalgridcontainer elementor-grid <?php echo $columns_desktop.$columns_tablet.$columns_mobile.$grid_class; ?>">

				<?php

				$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );
				$job_cat = $settings['royaljob_categories'];
		        $query_args = array(
					        	'posts_per_page' 		=> absint( $posts_per_page ),
					        	'no_found_rows'  		=> true,
					        	'post_status'         	=> 'publish',
					        	'post_type' 			=> 'royaljob',
								'tax_query' => array(
									array (
										'taxonomy' => 'royaljob_categories',
										'field' => 'slug',
										'terms' => $job_cat,
									)
								),
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

				if ( $all_posts->have_posts() ) {

		        	if( 1 == $grid_style ){
						while ( $all_posts->have_posts() ) {
							$all_posts->the_post(); ?>						
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>												
									<div class="post-grid-text-wrap">
											<?php $this->render_title(); ?>
										<?php $this->render_meta(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>													   
								</article>
								<?php						
						}
						
		        		
		        	} elseif( 2 == $grid_style ){		        		
						while ( $all_posts->have_posts() ) {
							$all_posts->the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>                  
									<div class="post-grid-text-wrap">
										<?php $this->render_meta(); ?>
										<?php $this->render_title(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>       
								</article>
								<?php
						}


		        	} elseif( 3 == $grid_style ){
						while ( $all_posts->have_posts() ) {
							$all_posts->the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>              	
									<?php $this->render_title(); ?>
									<?php $this->render_meta(); ?>
									<div class="post-grid-text-wrap">
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>        
								</article>
								<?php
						}
						
						
		        	} elseif( 4 == $grid_style ){
						while ( $all_posts->have_posts() ) {
							$all_posts->the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>
									<?php $this->render_title(); ?>
									<div class="post-grid-text-wrap">
										<?php $this->render_meta(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>
								</article>
								<?php
						}


		        	} elseif( 5 == $grid_style ){
						while ( $all_posts->have_posts() ) {
							$all_posts->the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>   	
									<div class="post-grid-text-wrap">
											<?php $this->render_title(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>
									<?php $this->render_meta(); ?>
								</article>
								<?php
						}			
						

		        	} elseif( 6 == $grid_style ){
						while ( $all_posts->have_posts() ) {
							$all_posts->the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost ' . $styleclass); ?>>   	
									<div class="post-grid-text-wrap">
										<?php $this->render_meta(); ?>
										<?php $this->render_title(); ?>
										<?php $this->render_excerpt(); ?>
									</div>
								</article>
								<?php
						}	


		        	}else{
						while ( $all_posts->have_posts() ) {
							$all_posts->the_post(); ?>						
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>								 									
									<div class="post-grid-text-wrap">
											<?php $this->render_title(); ?>
										<?php $this->render_meta(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>						   
								</article>						
								<?php						
						}					
						

		        	}

				} else {
					esc_html_e( 'Sorry, no job matched your criteria.', 'royal-addons-for-elementor' );
				}
				wp_reset_postdata();
				?>
			</div>
		<?php
		} else {
			echo esc_html__( '"royaljob" post type not found or actived, Please contact Developer.', 'royal-addons-for-elementor' );
		}
	}

	public function rt_filter_excerpt_length( $length ) {
		$settings = $this->get_settings();
		$excerpt_length = (!empty( $settings['excerpt_length'] ) ) ? absint( $settings['excerpt_length'] ) : 25;
		return absint( $excerpt_length );
	}

	
	public function rt_filter_excerpt_more( $more ) {
		$settings = $this->get_settings();
		return $settings['excerpt_append'];
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


	protected function render_meta() {
		$settings = $this->get_settings();
		$meta_data = $settings['meta_data'];

		if ( empty( $meta_data ) ) {
			return;
		}

		?>
		<div class="post-grid-meta">
			<?php

			if ( in_array( 'date', $meta_data ) ) {
				
				$dt = get_date_from_gmt(get_the_date(), 'Y-m-d H:i:s');
				?>				
				<span class="post-author">Job Post Date: <?php echo date_i18n(get_option('date_format'), strtotime($dt)); ?></span>

				<?php
			}

			

			if ( in_array( 'categories', $meta_data ) ) {
				global $post;
				//$categories_list = get_the_category_list( esc_html__( ', ', 'royal-addons-for-elementor' ) );
				$categories_list = get_the_term_list( $post->ID, 'royaljob_categories', 'Job Categories: ', ', ' );

				if ( $categories_list ) {
				    printf( '<span class="post-categories">%s</span>', $categories_list );
				}

			}

			if ( in_array( 'jobexpiredate', $meta_data ) ) {
				global $post;
				$jobexpiredate = get_post_meta( $post->ID, '_jobexpiredate', true );

				if ( $jobexpiredate ) {
					echo '<span class="post-author">Job Expire Date: ' . date_i18n(get_option('date_format'), strtotime($jobexpiredate)) .'</span>';
				}

			}

			?>
		</div>
		<?php
	}


	protected function render_excerpt() {
		$settings = $this->get_settings();
		$show_excerpt = $settings['show_excerpt'];

		if ( 'yes' !== $show_excerpt ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'rt_filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'rt_filter_excerpt_length' ], 9999 );

		?>
		<div class="post-grid-excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'rt_filter_excerpt_length' ], 9999 );
		remove_filter( 'excerpt_more', [ $this, 'rt_filter_excerpt_more' ], 20 );
	}


	protected function render_readmore() {
		$settings = $this->get_settings();
		$show_read_more = $settings['show_read_more'];
		$read_more_text = $settings['read_more_text'];
		if ( 'yes' !== $show_read_more ) {
			return;
		}
		?>
		<a class="read-more-btn" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_more_text ); ?></a>
		<?php

	}

}
