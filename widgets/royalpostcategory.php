<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalPostCategory extends Widget_Base {

	public function get_name() {
		return 'royalpostcategory';
	}


	public function get_title() {
		return __( 'Post Category', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-post-list rtbranding'; }


	public function get_keywords() {
		return [ 'list', 'post', 'category', 'blog', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = ['royalpostcategory'];
		return $styles;
	}


	protected function register_controls() {

		$this->rt_content_layout_options();
		$this->rt_style_box_options();
	}

	/**
	 * Content Layout Options.
	 */
	private function rt_content_layout_options() {

		$this->start_controls_section(
			'post_query_section',
			[
				'label' => esc_html__( 'Post Query', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'cat_style',
			[
				'label' => __( 'Category Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style1' 	=> 'Style 1',
					'style2' 	=> 'Style 2',
					'style3' 	=> 'Style 3',
					'style4' 	=> 'Style 4',
					'style5' 	=> 'Style 5',
				],
				'default' => 'style2',
			]
		);

		$this->add_control(
			'cat_columns',
			[
				'label'   => __( 'Columns', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label' => __( 'Show Thumbnail', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'cat_style' => ['style2'],
				],				
			]
		);

		$this->add_control(
			'show_date',
			[
				'label' => __( 'Show Date', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',				
			]
		);
		
		$this->add_control(
			'post_category',
			[
				'label'       => __( 'Category', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'multiple'    => true,
				'options'     => Royal_Helpers::royal_categories( 'post' ),

			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5,
			]
		);
		
		$this->add_control(
			'offset',
			[
				'label' => __( 'Posts Offset', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
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

		$this->add_control(
			'list_icon',
			[
			  'label' => __( 'List Icon', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::ICONS,
			  'separator' => 'before',
			  'fa4compatibility' => 'icon',		  
			  'default' => [
				'value' => 'fas fa-caret-right',
				'library' => 'fa-solid',
			  ],
			  'recommended' => [
				'fa-solid' => [
				  'angle-right',
				  'angle-double-right',
				  'chevron-circle-right',
				  'long-arrow-alt-right',
				  'arrow-alt-circle-right',
				  'arrow-right',
				  'play',
				],
				'fa-regular' => [
				  'caret-square-right',
				],
			  ],
			  'skin' => 'inline',
			  'label_block' => false,        
			]
		  );

		$this->add_responsive_control(
			'list_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
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
					'list_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory span.icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_icon_gap',
			[
				'label' => esc_html__( 'Icon Gap', 'royal-addons-for-elementor' ),
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
				'condition' => [
					'list_icon[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .title' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'list_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000000',
				'condition' => [
					'list_icon[value]!' => '',
				],			
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory span.icon svg' => 'fill: {{VALUE}};',
				],
			]
		);	

		
		$this->add_control(
			'list_icon_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Hover Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#666666',
				'condition' => [
					'list_icon[value]!' => '',
				],			
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .title:hover span.icon svg' => 'fill: {{VALUE}};',
				],
			]
		);	

		$this->add_control(
			'show_postexcerpt',
			[
				'label' => __( 'Show Post Excerpt', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',				
			]
		);

		$this->add_control(
			'postexcerpt',
			[
				'label' => __( 'Post Excerpt', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 40,
				'condition' => [ 
					'show_postexcerpt' 	=> 'yes',  
				],					
			]
		);		
		$this->end_controls_section();


		$this->start_controls_section(
			'post_cat_title_section',
			[
				'label' => esc_html__( 'Category Title', 'royal-addons-for-elementor' ),
			]
		);


		$this->add_control(
			'cat_show',
			[
				'label' => __( 'Category Title Show', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'original' 	=> 'Original Cat Name',
					'custom' 	=> 'Custom Cat Name',
					'no' 		=> 'Hide Cat Name',
				],
				'default' => 'original',
			]
		);

		$this->add_control(
			'custom_title',
			[
				'label' => __( 'Custom Category Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Category Name', 'royal-addons-for-elementor' ),
				'condition' => [
					'cat_show' => 'custom',
				],				
			]
		);

		$this->add_control(
			'category_title_url',
			[
				'label' => __( 'Category Title URL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'show_all_button' => 'yes',
					'cat_show!' 	=> 'no',
				],					
			]
		);

		$this->add_control(
			'content_align',
			[
				'label' => __( 'Title Alignment', 'royal-addons-for-elementor' ),
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
				'condition' => [
					'cat_show!' 	=> 'no',
				],				
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory h2' => 'text-align: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'cat_title_tag',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options'   => Royal_Helpers::royal_title_tags(),
				'default' => 'h2',
				'condition' => [
					'cat_show!' 	=> 'no',
				],
			]
		);

		$this->add_control(
			'cat_title_icon',
			[
			  'label' => __( 'Cat Title Icon', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::ICONS,
			  'separator' => 'before',
			  'fa4compatibility' => 'cat_title_icon_fa4',
			  'default' => [
				'value' => '',
				'library' => 'fa-solid',
			  ],
			  'recommended' => [
				'fa-solid' => [
				  'fire', 'star', 'bolt', 'newspaper',
				  'bookmark', 'tag', 'th-list', 'align-left',
				  'angle-double-right', 'chevron-right',
				],
			  ],
			  'skin' => 'inline',
			  'label_block' => false,
			  'condition' => [
				'cat_show!' => 'no',
			  ],				  
			]
		);

		$this->add_responsive_control(
			'cat_title_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 8, 'max' => 60, 'step' => 1 ],
				],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'condition' => [
					'cat_title_icon[value]!' => '',
					'cat_show!' => 'no',
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .cattitleicon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalpostcategory .cattitleicon i'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'post_content_section',
			[
				'label' => esc_html__( 'Content', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'content_title_tag',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options'   => Royal_Helpers::royal_title_tags(),
				'default' => 'h3',				
			]
		);

		$this->end_controls_section();

		
		$this->start_controls_section(
			'post_cat_button_section',
			[
				'label' => esc_html__( 'Button', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_all_button',
			[
				'label' => __( 'Show All Button', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_all_text',
			[
				'label' => __( 'Show All Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Show All', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_all_button' => 'yes',
				],				
			]
		);

		$this->add_control(
			'show_all_url',
			[
				'label' => __( 'Custom URL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'condition' => [
					'show_all_button' => 'yes',
				],					
			]
		);


		$this->add_control(
			'show_all_custom_url',
			[
				'label' => __( 'Show All URL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '#', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_all_button' 	=> 'yes',
					'show_all_url' 		=> 'yes',
				],				
			]
		);

		$this->end_controls_section();

	}


	private function rt_style_box_options() {

		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'General', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'block_border',
				'selector' => '{{WRAPPER}} .royalpostcategory .catblock',
			]
		);

		$this->add_responsive_control(
			'block_order_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory .catblock' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);		

		$this->add_responsive_control(
			'block_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory .catblock' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'block_style_tabs' );
		// Normal tab.
		$this->start_controls_tab(
			'block_style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		// Normal background color.
		$this->add_control(
			'block_style_normal_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .catblock' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Normal border color.
		$this->add_control(
			'block_style_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .catblock' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'block_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalpostcategory .catblock',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'block_style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'block_style_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .catblock:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'block_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .catblock:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'block_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalpostcategory .catblock:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_thumbnail',
			[
				'label' => __( 'Thumbnail', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_thumbnail' => 'yes',
				],				
			]
		);
		
		$this->add_responsive_control(
			'thumbnail_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],					
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory .thumbnail img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],				
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory .thumbnail img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'thumbnail_border_width',
			[
				'label'      => __( 'Border', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],				
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory .thumbnail img' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'thumbnail_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],				
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .thumbnail img' => 'border-color: {{VALUE}};',
				],
			]
		);	
		
		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_cat_title',
			[
				'label' => __( 'Cat Title', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'condition' => [
					'cat_show!' 	=> 'no',
				],					
				'selector' => '{{WRAPPER}} .royalpostcategory h2',
			]
		);


		$this->start_controls_tabs( 'cat_title_color_tabs' );
		// Normal tab.
		$this->start_controls_tab(
			'cat_title_style_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
				'condition' => [
					'cat_show!' 	=> 'no',
				],					
			)
		);

		// Title color.
		$this->add_control(
			'cat_title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'condition' => [
					'cat_show!' 	=> 'no',
				],					
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory h2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalpostcategory h2 a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'cat_title_style_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
				'condition' => [
					'cat_show!' 	=> 'no',
				],					
			)
		);

		// Title hover color.
		$this->add_control(
			'cat_title_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'condition' => [
					'cat_show!' 	=> 'no',
				],					
				'selectors' => array(
					'{{WRAPPER}} .royalpostcategory h2:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalpostcategory h2 a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'cat_title_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition' => [
					'cat_show!' 	=> 'no',
				],					
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cat_title_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'condition' => [
					'cat_show!' 	=> 'no',
				],					
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'cat_title_border_width',
			[
				'label'      => __( 'Title Border', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory h2' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'cat_title_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Border Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory h2' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cat_title_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Background Color', 'royal-addons-for-elementor' ),
				'separator' => 'before',
				'condition' => [
					'cat_show!' => 'no',
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory h2.cattitle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cat_title_icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Icon Color', 'royal-addons-for-elementor' ),
				'condition' => [
					'cat_title_icon[value]!' => '',
					'cat_show!' => 'no',
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .cattitleicon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .royalpostcategory .cattitleicon i'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_post_content',
			[
				'label' => esc_html__( 'Post Content', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'post_title_typography',
				'label' => __( 'Post Title Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .royalpostcategory ul li h3',
			]
		);

		$this->add_responsive_control(
			'post_title_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'post_title_border',
				'selector' => '{{WRAPPER}} .royalpostcategory ul li a',
			]
		);


		$this->add_responsive_control(
			'post_title_style_padding',
			[
				'label'      => __( 'Post Title Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory ul li h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'post_content_typography',
				'label' => __( 'Post Content Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'condition' => [
					'show_postexcerpt' => 'yes',
				],				
				'selector'  => '{{WRAPPER}} .royalpostcategory .royalpostexcerpt',
			]
		);

		$this->add_control(
			'post_content_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Post Content Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'condition' => [
					'show_postexcerpt' => 'yes',
				],					
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .royalpostexcerpt' => 'color: {{VALUE}};',
				],
			]
		);	

		$this->start_controls_tabs( 'post_title_style_color_tabs' );
		$this->start_controls_tab(
			'post_title_color_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'post_title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Post Title Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory h3 a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'post_title_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Post Title Background', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory ul li' => 'background: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		

		// Hover tab.
		$this->start_controls_tab(
			'post_title_color_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			)
		);
		$this->add_control(
			'post_title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Post Title Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory h3 a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'post_title_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Post Title Background', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory ul li:hover' => 'background: {{VALUE}};',
				],
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Button', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_all_button' => 'yes',
				],	
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .royalpostcategory .allbutton',
				'condition' => [
					'show_all_button' => 'yes',
				],				
			]
		);


		$this->start_controls_tabs( 'button_text_style_normal_tabs' );
        // Normal tab.
		$this->start_controls_tab(
			'button_text_style_normal_tab',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_all_button' => 'yes',
				],					
			]
		);

		$this->add_control(
			'button_text_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .allbutton' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_all_button' => 'yes',
				],				
			]
		);

		$this->add_control(
			'button_bg_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .allbutton' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_all_button' => 'yes',
				],				
			]
		);		

		$this->end_controls_tab();


        // Hover tab.
		$this->start_controls_tab(
			'button_text_style_hover_tab',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_all_button' => 'yes',
				],					
			]
		);
		
		$this->add_control(
			'button_text_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .allbutton:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_all_button' => 'yes',
				],				
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .allbutton:hover' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_all_button' => 'yes',
				],				
			]
		);			

		$this->end_controls_tab();
		$this->end_controls_tabs();




		$this->add_responsive_control(
			'button_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory .allbutton' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition' => [
					'show_all_button' => 'yes',
				],				
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .royalpostcategory .allbutton',
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_date',
			[
				'label' => __( 'Date', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'cat_style' => [ 'style1', 'style3', 'style4' , 'style5'],
				],
			]
		);


		$this->add_control(
			'date_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .date' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'date_padding',
			[
				'label'      => __( 'Date Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpostcategory .date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'date_border',
				'selector' => '{{WRAPPER}} .royalpostcategory .date',
			]
		);

		$this->start_controls_tabs( 'date_tab_style' );
		$this->start_controls_tab(
			'date_day',
			[
				'label'     => __( 'Day', 'royal-addons-for-elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'date_day_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .date .day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'day_typography',
				'selector' => '{{WRAPPER}} .royalpostcategory .date .day',
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'date_year',
			[
				'label'     => __( 'Year', 'royal-addons-for-elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'date_year_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalpostcategory .date .year' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'year_typography',
				'selector' => '{{WRAPPER}} .royalpostcategory .date .year',
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}



	protected function render() {
		$settings 				= $this->get_settings();
		$posts_per_page 		= ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 5 );
		$offset 				= ( ! empty( $settings['offset'] ) ?  $settings['offset'] : 0 );
		$cat_style 				= $settings['cat_style'];
		$show_date				= $settings['show_date'];
		$cat 					= $settings['post_category'];
		$show_all_button		= $settings['show_all_button'];
		$show_all_text			= $settings['show_all_text'];
		$show_all_url			= $settings['show_all_url'];
		$show_all_custom_url	= $settings['show_all_custom_url'];
		$cat_columns			= ( ! empty( $settings['cat_columns'] ) ? absint( $settings['cat_columns'] ) : 1 );
		$cat_columns			= max( 1, min( 5, $cat_columns ) );


		$query_args 			= array(
			'posts_per_page' 		=> absint( $posts_per_page ),
			'no_found_rows'  		=> true,
			'post_status'         	=> 'publish',
			'ignore_sticky_posts'   => true,
			'offset' 				=> $offset,
			'category_name' 		=> $cat
		);
		// Order by.
		if ( ! empty( $settings['orderby'] ) ) {
			$query_args['orderby'] = $settings['orderby'];
		}

		// Order .
		if ( ! empty( $settings['order'] ) ) {
			$query_args['order'] = $settings['order'];
		}

		// All Button
		if ('yes' == $show_all_button){					
			if('' == $show_all_url){
				$royalallbutton = '<a class="allbutton" href="'.esc_url( $category_link ).'">'.$show_all_text.'</a>';
			} elseif('yes' == $show_all_url){
				$royalallbutton ='<a class="allbutton" href="'.esc_url( $show_all_custom_url ).'">'.$show_all_text.'</a>';
			}									
		} else {
			$royalallbutton = '';
		}
		
		$all_posts = new \WP_Query( $query_args );

		// Collect all posts into an array first
		$posts_data = array();
		if ( $all_posts->have_posts() ) {
			while ( $all_posts->have_posts() ) {
				$all_posts->the_post();
				$posts_data[] = get_post();
			}
			wp_reset_postdata();
		}

		// posts_per_col = ceil( total / columns )
		$total_posts   = count( $posts_data );
		$posts_per_col = $cat_columns > 1 ? (int) ceil( $total_posts / $cat_columns ) : $total_posts;
		$posts_per_col = max( 1, $posts_per_col );

		// Chunk posts into column groups
		$post_chunks = $total_posts > 0 ? array_chunk( $posts_data, $posts_per_col ) : array();

		// Grid wrapper
		$columns_style = $cat_columns > 1 ? ' style="display:grid;grid-template-columns:repeat(' . $cat_columns . ',1fr);gap:15px;"' : '';
		echo '<div class="royalpostcategory royalcat-columns-' . $cat_columns . '"' . $columns_style . '>';

		if ( empty( $post_chunks ) ) {
			echo '</div>';
			return;
		}

		foreach ( $post_chunks as $chunk ) :
			echo '<div class="royalcat-col">';

			if ( 'style1' == $cat_style ) { ?>
				<div class="style1">
				<div class="catblock">
					<?php $this->render_cat_title(); ?>
					<ul>
					<?php foreach ( $chunk as $post ) :
						setup_postdata( $GLOBALS['post'] = $post ); ?>
						<li>
						<div class="content"><?php $this->render_content_title(); ?></div>
						<?php if($show_date == 'yes'){ ?><div class="date"><span class="day"><?php echo get_the_date('d'); ?></span><span class="year"><?php echo get_the_date('m-Y'); ?></span></div><?php } ?>
						</li>
					<?php endforeach; wp_reset_postdata(); ?>
					</ul>
				</div>
				<?php echo $royalallbutton; ?>
				</div>

			<?php } elseif ( 'style2' == $cat_style ) { ?>
				<div class="style2">
				<div class="catblock">
					<?php $this->render_cat_title(); ?>
					<ul>
					<?php foreach ( $chunk as $post ) :
						setup_postdata( $GLOBALS['post'] = $post ); ?>
						<li>
						<?php $this->render_thumbnail(); ?>
						<div class="content">
						<?php $this->render_content_title(); ?>
						<?php $this->render_postexcerpt(); ?>
						<?php if($show_date == 'yes'){ ?><span class="date"><span class="day"><?php echo get_the_date('d'); ?>-<span class="year"><?php echo get_the_date('m-Y'); ?></span></span> <?php } ?>
						</div>
						</li>
					<?php endforeach; wp_reset_postdata(); ?>
					</ul>
				</div>
				<?php echo $royalallbutton; ?>
				</div>

			<?php } elseif ( 'style3' == $cat_style ) { ?>
				<div class="style3">
				<div class="catblock">
					<?php $this->render_cat_title(); ?>
					<ul>
					<?php foreach ( $chunk as $post ) :
						setup_postdata( $GLOBALS['post'] = $post ); ?>
						<li>
						<?php $this->render_content_title(); ?>
						<?php $this->render_postexcerpt(); ?>
						<?php if($show_date == 'yes'){ ?><span class="date"><span class="day"><?php echo get_the_date('d'); ?>-<span class="year"><?php echo get_the_date('m-Y'); ?></span></span></span><?php } ?>
						</li>
					<?php endforeach; wp_reset_postdata(); ?>
					</ul>
				</div>
				<?php echo $royalallbutton; ?>
				</div>

			<?php } elseif ( 'style4' == $cat_style ) { ?>
				<div class="style4">
					<div class="catblock">
						<?php $this->render_cat_title(); ?>
						<ul>
						<?php foreach ( $chunk as $post ) :
							setup_postdata( $GLOBALS['post'] = $post ); ?>
							<li><?php if($show_date == 'yes'){ ?><div class="date"><span class="day"><?php echo get_the_date('d'); ?></span><span class="year"><?php echo get_the_date('m-Y'); ?></span></div><?php } ?>
							<?php $this->render_content_title(); ?>
							</li>
						<?php endforeach; wp_reset_postdata(); ?>
						</ul>
					</div>
				<?php echo $royalallbutton; ?>
				</div>

			<?php } elseif ( 'style5' == $cat_style ) { ?>
				<div class="style5">
					<div class="catblock">
						<?php $this->render_cat_title(); ?>
						<ul>
						<?php foreach ( $chunk as $post ) :
							setup_postdata( $GLOBALS['post'] = $post ); ?>
							<li>
							<?php $this->render_content_title(); ?>
							<?php if($show_date == 'yes'){ ?><div class="date">
								<span class="day"><?php echo get_the_date('d'); ?></span>
								<span class="year"><?php echo get_the_date('m-Y'); ?></span>
							</div><?php } ?>
							</li>
						<?php endforeach; wp_reset_postdata(); ?>
						</ul>
					</div>
				<?php echo $royalallbutton; ?>
				</div>

			<?php } else { ?>
				<div class="style1">
				<div class="catblock">
					<?php echo isset( $royalcattitle ) ? $royalcattitle : ''; ?>
					<ul>
					<?php foreach ( $chunk as $post ) :
						setup_postdata( $GLOBALS['post'] = $post ); ?>
						<li><?php $this->render_content_title(); ?></li>
					<?php endforeach; wp_reset_postdata(); ?>
					</ul>
				</div>
				<?php echo $royalallbutton; ?>
				</div>
			<?php } ?>

			<?php echo '</div>'; // end .royalcat-col
		endforeach;

		echo '</div>'; // end .royalpostcategory
	}

	protected function render_content_title() {
		$settings = $this->get_settings();
		$content_title_tag = $settings['content_title_tag'];
		echo '<'.$content_title_tag.' class="title">';

		if ( ! empty( $settings['list_icon']['value'] ) ) {
			echo '<span class="icon">';
			\Elementor\Icons_Manager::render_icon( $settings['list_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
		}
		echo '<a href="'. get_permalink().'">'. get_the_title().'</a>';
		echo'</'.$content_title_tag.'>';

	}


	protected function render_cat_title() {	
		$settings 			= $this->get_settings();
		$cat_title_tag 		= $settings['cat_title_tag'];
		$cat_show 			= $settings['cat_show'];
		$custom_title 		= $settings['custom_title'];
		$category_title_url = $settings['category_title_url'];
		$cat 				= $settings['post_category'];
		$cat_slug 			= get_category_by_slug($cat); 
		$category_id 		= $cat_slug->term_id;	
		$category_link 		= get_category_link( $category_id );
		$category_name		= get_cat_name( $category_id = $category_id );

		// Cat Title Icon
		$icon_html = '';
		if ( ! empty( $settings['cat_title_icon']['value'] ) ) {
			ob_start();
			echo '<span class="cattitleicon">';
			\Elementor\Icons_Manager::render_icon( $settings['cat_title_icon'], [ 'aria-hidden' => 'true' ] );
			echo '</span>';
			$icon_html = ob_get_clean();
		}

		if('yes' == $category_title_url){
			if ('original' == $cat_show){
				echo '<'.$cat_title_tag.' class="cattitle">'.$icon_html.'<a href="'.esc_url( $category_link ).'">'.$category_name.'</a></'.$cat_title_tag.'>';	
			}elseif('custom' == $cat_show ){
				echo '<'.$cat_title_tag.' class="cattitle">'.$icon_html.'<a href="'.esc_url( $category_link ).'">'.$custom_title.'</a></'.$cat_title_tag.'>';
			} else{
				echo'';
			}
		} else{
			if ('original' == $cat_show){
				echo '<'.$cat_title_tag.' class="cattitle">'.$icon_html.$category_name.'</'.$cat_title_tag.'>';		
			}elseif('custom' == $cat_show ){
				echo '<'.$cat_title_tag.' class="cattitle">'.$icon_html.$custom_title.'</'.$cat_title_tag.'>';
			}else{
				echo '';
			}
		}

	}


	protected function render_thumbnail() {
		$settings        = $this->get_settings();
		$show_thumbnail  = $settings['show_thumbnail'];

		if ( 'yes' !== $show_thumbnail ) {
			return;
		}

		$permalink = esc_url( get_permalink() );
		$post_title = get_the_title();

		if ( has_post_thumbnail() ) {
			$thumbnail_id = get_post_thumbnail_id();
			$alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
			if ( empty( $alt_text ) ) {
				$alt_text = $post_title;
			}
			?>
			<div class="thumbnail">
				<a href="<?php echo $permalink; ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<?php the_post_thumbnail( 'thumbnail', array(
						'alt' => esc_attr( $alt_text )
					) ); ?>
				</a>
			</div>
		<?php
		} else {
			?>
			<div class="thumbnail">
				<a href="<?php echo $permalink; ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<img width="150" height="150"
						src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/images/noimage.png'; ?>"
						alt="<?php echo esc_attr( $post_title ); ?>" />
				</a>
			</div>
		<?php
		}
	}



	protected function render_postexcerpt() {
		$settings 				= $this->get_settings();
		$postexcerpt 			= ( ! empty( $settings['postexcerpt'] ) ?  $settings['postexcerpt'] : 40 );
		
		if ( 'yes' == $settings['show_postexcerpt'] ) {
			echo '<div class="royalpostexcerpt">';
			\RoyalAddons\Elementor\RoyalClass::royalpostexcerpt($postexcerpt);
			echo '</div>';
		}
		
	}


}	