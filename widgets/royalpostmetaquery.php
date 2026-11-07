<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Traits\ProWidgetTrait;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalPostMetaQuery extends Widget_Base {
	use ProWidgetTrait;

	public function get_name() {
		return 'royalpostmetaquery';
	}


	public function get_title() {
		return __( 'Post Meta Query [Pro]', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-post-list rtbranding'; }


	public function get_keywords() {
		return [ 'list', 'post', 'category', 'blog', 'custom', 'cpt', 'tech', 'royal',  'mehdi',  'akram', 'pro', 'technologies' ];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = ['royalpost', 'datatables', 'royalpostmetaquery'];
		return $styles;
	}

	public function get_script_depends() {
		return [ 'datatables', 'royalpostmetaquery' ];
	}

	protected function register_controls() {
		$this->rt_query_options();
		$this->rt_display_options();
		$this->rt_display_royaldatatables();
		$this->rt_style_box_options();
		$this->rt_style_content_options();
		$this->rt_style_title_meta_options();
		$this->rt_style_thumbnail_options();
	}

	/* Query Options */
	private function rt_query_options() {

		$this->start_controls_section(
			'post_query_section',
			[
				'label' => esc_html__( 'Post Query', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_control(
			'style',
			[
				'label' => __( 'Display Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'royalpostgrid',
				'options' => [
					'royalpostgrid' 	=> 'Grid',
					'royaldatatables'	=> 'Datatables',
					'royalrow'			=> 'Row',
				],
				
			]
		);

		$this->add_control(
			'custom_post',
			[
				'label' 	=> __( 'Custom Post Type', 'royal-addons-for-elementor' ),
				'type' 		=> Controls_Manager::TEXT,
				'default' 	=> 'member',			
			]
		);		
		
		$this->add_control(
		  'query_by_meta_key',
		  [
			'label' => __( 'Query by Meta Key', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => '',
			'placeholder' => __( 'Type your description here', 'royal-addons-for-elementor' ),			
		  ]
		);
		
		$this->add_control(
		  'query_by_meta_value',
		  [
			'label' => __( 'Query by Meta Value', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => '',
			'placeholder' => __( 'Type your description here', 'royal-addons-for-elementor' ),		
		  ]
		);
	
		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1fr 1fr 1fr 1fr',
				'tablet_default' => '1fr 1fr',
				'mobile_default' => '1fr',
				'options' => [
					'1fr' => '1',
					'1fr 1fr' => '2',
					'1fr 1fr 1fr' => '3',
					'1fr 1fr 1fr 1fr' => '4',
					'1fr 1fr 1fr 1fr 1fr' => '5',
					'1fr 1fr 1fr 1fr 1fr 1fr' => '6',
					'1fr 1fr 1fr 1fr 1fr 1fr 1fr' => '7',
					'1fr 1fr 1fr 1fr 1fr 1fr 1fr 1fr' => '8',
				],
				'condition' => [
					'style' => [ 'royalpostgrid' ],
				],
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .royalpostgrid' => 'grid-template-columns: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'columnsgap',
			[
				'label' => esc_html__( 'Columns Gap', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition' => [
					'style' => [ 'royalpostgrid' ],
				],				
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .royalpostgrid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Posts', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				'max' => 100,
				'step' => 1,
				'default' => 12,
			]
		);


		$this->add_control(
			'list_icon',
			[
			  'label' => __( 'Icon', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::ICONS,
			  'separator' => 'before',
			  'condition' => [
				'style' => [ 'royalnotice1', 'royalnotice2' , 'royalnotice3', 'royalnotice4'],
			],				  
			  'fa4compatibility' => 'icon',		  
			  'default' => [
				'value' => 'fas fa-edit',
				'library' => 'fa-solid',
			  ],
			  'recommended' => [
				'fa-solid' => [
				  'angle-right',
				  'edit',
				  'caret-right',
				  'angle-double-right',
				  'chevron-circle-right',
				  'long-arrow-alt-right',
				  'arrow-alt-circle-right',
				  'arrow-right',
				  'play',
				],
				'fa-regular' => [
				  'caret-square-right',
				  'edit',
				],
			  ],
			  'skin' => 'inline',
			  'label_block' => false,        
			]
		  );

		$this->end_controls_section();

	}
	
	
	/* Display Options */
	private function rt_display_options() {

		$this->start_controls_section(
			'post_display_section',
			[
				'label' => esc_html__( 'Display Options', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_control(
			'show_thumbnail',
			[
				'label' => esc_html__( 'Show Thumbnail', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'image600',
				'condition' => [
					'show_thumbnail' => 'yes',
				],
			]
		);

		$this->add_control(
			'thumbnail_text',
			[
				'label' => __( 'Thumbnail Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Photo', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_thumbnail' => 'yes',
				],				
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Show Ttile', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);	
		
		$this->add_control(
			'title_text',
			[
				'label' => __( 'Title Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Name', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_title' => 'yes',
				],				
			]
		);
		
		
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
		  'meta_title',
		  [
			'label' => __( 'Meta Title', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Position: ', 'royal-addons-for-elementor' ),
		  ]
		);


		$repeater->add_control(
		  'meta_key',
		  [
			'label' => __( 'Meta Key', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( '_position', 'royal-addons-for-elementor' ),
		  ]
		);


		$this->add_control(
		  'metadisplay',
		  [
			'label' => __( 'Meta Display', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'default' => [
			  [
				'meta_title' => __( 'Member', 'royal-addons-for-elementor' ),
				'meta_key' => '_member',
			  ],
			  [
				'meta_title' => __( 'Position', 'royal-addons-for-elementor' ),
				'meta_key' => '_position',
			  ],
			],
			'title_field' => '{{{ meta_title }}}',
		  ]
		);
				
		$this->add_control(
			'show_taxonomy',
			[
				'label' => esc_html__( 'Show Taxonomy', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater2 = new \Elementor\Repeater();
		$repeater2->add_control(
		  'taxonomy_title',
		  [
			'label' => __( 'Taxonomy Title', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'Product Catagory: ', 'royal-addons-for-elementor' ),
		  ]
		);


		$repeater2->add_control(
		  'taxonomy_slug',
		  [
			'label' => __( 'Taxonomy Slug', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'product_cat', 'royal-addons-for-elementor' ),
		  ]
		);


		$this->add_control(
		  'taxonomydisplay',
		  [
			'label' => __( 'Taxonomy Display', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'condition' => [
					'show_taxonomy' => 'yes',
				],	
			'fields' => $repeater2->get_controls(),
			'default' => [
			  [
				'taxonomy_title' => __( 'Product Catagory', 'royal-addons-for-elementor' ),
				'taxonomy_slug' => 'product_cat',
			  ],
			],
			'title_field' => '{{{ taxonomy_title }}}',
		  ]
		);
		$this->end_controls_section();

	}	


	
	private function rt_display_royaldatatables() {

		$this->start_controls_section(
			'box_datatables_section',
			[
				'label' => __( 'Datatables Options', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'datatable_orderno',
			[
				'label' => esc_html__( 'Order Column', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'0' => esc_html__( '1', 'royal-addons-for-elementor' ),
					'1' => esc_html__( '2', 'royal-addons-for-elementor' ),
					'2' => esc_html__( '3', 'royal-addons-for-elementor' ),
					'3' => esc_html__( '4', 'royal-addons-for-elementor' ),
					'4' => esc_html__( '5', 'royal-addons-for-elementor' ),
					'5' => esc_html__( '6', 'royal-addons-for-elementor' ),
					'6' => esc_html__( '7', 'royal-addons-for-elementor' ),
					'7' => esc_html__( '8', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'datatable_orderby',
			[
				'label' => esc_html__( 'Order Column', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'asc',
				'options' => [
					'asc' => esc_html__( 'Ascending', 'royal-addons-for-elementor' ),
					'desc' => esc_html__( 'Descending', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'datatable_dropdown',
			[
				'label' => esc_html__( 'Dropdown Column', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'' => esc_html__( 'None', 'royal-addons-for-elementor' ),
					'1' => esc_html__( '1', 'royal-addons-for-elementor' ),
					'2' => esc_html__( '2', 'royal-addons-for-elementor' ),
					'3' => esc_html__( '3', 'royal-addons-for-elementor' ),
					'4' => esc_html__( '4', 'royal-addons-for-elementor' ),
					'5' => esc_html__( '5', 'royal-addons-for-elementor' ),
					'6' => esc_html__( '6', 'royal-addons-for-elementor' ),
					'7' => esc_html__( '7', 'royal-addons-for-elementor' ),
				],
			]
		);
	

		$this->add_control(
			'datatable_dropdownwidth',
			[
				'label' => esc_html__( 'Dropdown Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 10,
				'max' => 200,
				'step' => 1,
				'default' => 75,
			]
		);


		$this->add_control(
			'datatable_dropdowntitle',
			[
				'label' => __( 'Dropdown All Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'All', 'royal-addons-for-elementor' ),			
			]
		);




		$this->end_controls_section();
	}


	/* Box Style */
	private function rt_style_box_options() {

		$this->start_controls_section(
			'box_style_section',
			[
				'label' => __( 'Box Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalglobalpost',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalglobalpost',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .royalglobalpost',
			]
		);

		$this->add_responsive_control(
			'box_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalglobalpost' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalglobalpost' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/* Content Style */
	private function rt_style_content_options() {

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => __( 'Content Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .royalpostgrid .title' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .royalglobalpost .royalnotice1 .title' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .royalglobalpost .royalnotice2 .title' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .royalglobalpost .royalnotice3.title' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .royalglobalpost .royalpostgrid .metadata' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '
					{{WRAPPER}} .royalglobalpost .royalpostgrid article, 
					{{WRAPPER}} .royalglobalpost .royalnotice1 tr,
					{{WRAPPER}} .royalglobalpost .royalnotice2 li,
					{{WRAPPER}} .royalglobalpost .royalnotice3 li,
					{{WRAPPER}} .royalglobalpost .royalnotice4 li
				',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalglobalpost .royalpostgrid article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice1 tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice2 li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice3 li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice4 li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'content_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalglobalpost .royalpostgrid article' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice1 tr td' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice2 li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice3 li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .royalglobalpost .royalnotice4 li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'selector' => '
					{{WRAPPER}} .royalglobalpost .royalpostgrid article, 
					{{WRAPPER}} .royalglobalpost .royalnotice1 tr,
					{{WRAPPER}} .royalglobalpost .royalnotice2 li,
					{{WRAPPER}} .royalglobalpost .royalnotice3 li,
					{{WRAPPER}} .royalglobalpost .royalnotice4 li
				',
			]
		);		
		$this->end_controls_section();
	}


	/* Title & Meta Style */
	private function rt_style_title_meta_options() {

		$this->start_controls_section(
			'title_meta_style_section',
			[
				'label' => __( 'Title & Meta Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'condition' => [
					'style' => [ 'royalnotice1', 'royalnotice2', 'royalnotice3', 'royalnotice4'],
				],					
				'default' 	=> '#000000',				
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .icon i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_align',
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .title' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .royalglobalpost .title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'selector' => '{{WRAPPER}} .royalglobalpost .metadata',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => esc_html__( 'Meta Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .metadata' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'meta_bg',
			[
				'label' => esc_html__( 'Meta Background', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalglobalpost .metadata' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'meta_border',
				'selector' => '{{WRAPPER}} .royalglobalpost .metadata',
			]
		);

		$this->end_controls_section();
	}


	/* Thumbnail Style */
	private function rt_style_thumbnail_options() {

		$this->start_controls_section(
			'thumbnail_style_section',
			[
				'label' => __( 'Thumbnail Style', 'royal-addons-for-elementor' ),
				// 'condition' => [
				// 	'style' => [ 'royalpostgrid' ],
				// ],
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'thumbnail_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalglobalpost img.thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'thumbnail_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalglobalpost img.thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);


		$this->start_controls_tabs( 'grid_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'thumbnail_style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'thumbnail_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalglobalpost img.thumbnail',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'thumbnail_style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);


		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'thumbnail_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalglobalpost img.thumbnail:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->end_controls_section();

	}



	protected function render_royalpostexcerpt() {
		$settings 				= $this->get_settings();
		$postexcerpt 			= ( ! empty( $settings['postexcerpt'] ) ?  $settings['postexcerpt'] : 40 );		
		\RoyalAddons\Elementor\RoyalClass::royalpostexcerpt($postexcerpt);
	}


	protected function render() {
		if ( $this->maybe_render_license_notice() ) {
			return;
		}

		$settings 				= $this->get_settings();
		$id         			= $this->get_id();
		$queryid   				= 'royalmetaquery'.$id;
		$custom_post 			= $settings['custom_post'];
		$query_by_meta_key 		= $settings['query_by_meta_key'];
		$query_by_meta_value 	= $settings['query_by_meta_value'];
		$posts_per_page 		= $settings['posts_per_page'];
		$title_text 			= $settings['title_text'];
		$show_thumbnail			= $settings['show_thumbnail'];
		$thumbnail_text			= $settings['thumbnail_text'];
		$style					= $settings['style'];
		$show_taxonomy			= $settings['show_taxonomy'];
		

		$orderno				= $settings['datatable_orderno'];
		$orderby				= $settings['datatable_orderby'];
		$dropdown				= $settings['datatable_dropdown'];
		$dropdowntitle			= $settings['datatable_dropdowntitle']; 
		$dropdownwidth			= $settings['datatable_dropdownwidth']; 
		$this->add_render_attribute(
			'options',
			[
				'id'             	=> $queryid,
				'data-orderno'		=> $orderno,
				'data-orderby'		=> $orderby,
				'data-dropdown'		=> $dropdown,
				'data-dropdowntitle'=> $dropdowntitle,
				'data-dropdownwidth'=> $dropdownwidth,
			]
		);

		$query_args 			= array(
			'post_type' 			=> $custom_post,
			'posts_per_page' 		=> $posts_per_page,
			'meta_key' 				=> $query_by_meta_key,
			'meta_value' 			=> $query_by_meta_value,
			'no_found_rows'  		=> true,
			'post_status'         	=> 'publish',
			'ignore_sticky_posts'   => true
		);
		
		$all_posts = new \WP_Query( $query_args );
		
		echo '<div class="royalglobalpost">';	
		
		if( 'royalpostgrid' == $style ){ ?>
			<div class="royalpostgrid">	
				<?php
				if ( $all_posts->have_posts() ) :
					while ( $all_posts->have_posts() ) :
						$all_posts->the_post(); ?>
							<article id="post-<?php the_ID(); ?>">
								<div class="post-grid-inner">
									<?php $this->render_thumbnail(); ?>
									<h3 class="title"><?php echo $title_text; ?><?php $this->render_title(); ?></h3>
									<div class="metadata">
									<?php foreach ($settings['metadisplay'] as $meta ) {
										$metaid = $meta['meta_key'];
										echo '<div>' .$meta['meta_title']; echo get_post_meta(get_the_ID(), $metaid, true).'</div>';
									} ?>
									<?php
									if ( 'yes' == $show_taxonomy ) {
										foreach ($settings['taxonomydisplay'] as $taxonomy ) {
											echo '<th>' .$taxonomy['taxonomy_title'].'</th>';
											$taxonomyslug = $taxonomy['taxonomy_slug'];
											$terms = get_the_terms( get_the_ID(), $taxonomyslug);
											foreach ($terms as $term) {
												$separator = ($term != end($terms)) ? ", " : '';
												echo '<a href="'.get_term_link($term->slug, $taxonomyslug).'">'.$term->name.'</a>' .$separator;
											}
										}
								 	} ?>
									</div>
								</div>
							</article>						
					<?php endwhile; 						
				endif; ?>
			</div>



		<?php } elseif($style =='royaldatatables' ){ ?>
			<div class="royaldatatables">	
			<table class="royalpostmetaquery hover" <?php echo $this->get_render_attribute_string( 'options' ) ?>>
				<thead>
					<tr>
						<th><?php echo $thumbnail_text; ?></th>
						<th><?php echo $title_text; ?></th>
						<?php
						if ( 'yes' == $show_taxonomy ) {						
							foreach ($settings['taxonomydisplay'] as $taxonomy ) {
								echo '<th>' .$taxonomy['taxonomy_title'].'</th>';
							} 
						}
						?>
						<?php foreach ($settings['metadisplay'] as $meta ) {
							echo '<th>' .$meta['meta_title'].'</th>';
						} ?>
					</tr>
				</thead>
		
				<tbody>
						<?php
						if ( $all_posts->have_posts() ) :
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
								<tr>
									<td><a href="<?php the_permalink(); ?>"><?php $this->render_thumbnail(); ?></a></td>
									<td><?php the_title() ?></td>
									<?php
									if ( 'yes' == $show_taxonomy ) {
										foreach ($settings['taxonomydisplay'] as $taxonomy ) {
											$taxonomyslug = $taxonomy['taxonomy_slug'];
											$terms = get_the_terms( get_the_ID(), $taxonomyslug);
											foreach ($terms as $term) {
												$separator = ($term != end($terms)) ? ", " : '';
												echo '<td><a href="'.get_term_link($term->slug, $taxonomyslug).'">'.$term->name.'</a></td>' .$separator;
											}
										}
								 	} ?>
									<?php foreach ($settings['metadisplay'] as $meta ) {
										$metaid = $meta['meta_key'];
										echo '<td>' . get_post_meta(get_the_ID(), $metaid, true).'</td>';
									} ?>
								</tr>					
							<?php endwhile; 						
						endif; ?>
					</tbody>
			</table>
			</div>

		<?php } elseif($style =='royalrow' ){ ?>
			<div class="royalpostrow">	
				<?php
				if ( $all_posts->have_posts() ) :
					while ( $all_posts->have_posts() ) :
						$all_posts->the_post(); ?>
							<article id="post-<?php the_ID(); ?>">
								<div class="postthumbnail">
									<?php $this->render_thumbnail(); ?>
								</div>
								<div class="postcontent">
								<h3 class="title"><?php echo $title_text; ?><?php $this->render_title(); ?></h3>
								<table>							
									<tbody>
											<?php
											if ( 'yes' == $show_taxonomy ) {
												foreach ($settings['taxonomydisplay'] as $taxonomy ) {
													$taxonomyslug = $taxonomy['taxonomy_slug'];
													$terms = get_the_terms( get_the_ID(), $taxonomyslug);
													echo '<tr>';
													foreach ($terms as $term) {
														$separator = ($term != end($terms)) ? ", " : '';
														echo '<td>' .$taxonomy['taxonomy_title']. '</td>';
														echo '<td>:</td>';
														echo '<td><a href="'.get_term_link($term->slug, $taxonomyslug).'">'.$term->name.'</a></td>' .$separator;
													}
													echo '</tr>';
												}
											} ?>
											<?php
											
											 foreach ($settings['metadisplay'] as $meta ) {
												echo '<tr>';
												$metaid = $meta['meta_key'];
												echo '<td>' .$meta['meta_title']. '</td>';
												echo '<td>:</td>';
												echo '<td>' . get_post_meta(get_the_ID(), $metaid, true).'</td>';
												echo '</tr>';
											}
											
											?>
										</tr>
									</tbody>
								</table>
								<a href="<?php the_permalink(); ?>" class="detailsbutton">See Details</a>
								</div>
							</article>						
					<?php endwhile; 						
				endif; ?>
			</div>


				
		<?php } else{ ?>

		<?php } ?> 
			
		</div>
		<?php
	}




	protected function render_thumbnail() {
		$settings = $this->get_settings();
		$show_thumbnail = $settings['show_thumbnail'];
		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( 'yes' !== $show_thumbnail ) {
			return;
		}

		if ( has_post_thumbnail() ) {
			$alt_text = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
			if ( empty( $alt_text ) ) {
				$alt_text = get_the_title();
			}
			the_post_thumbnail( $post_thumbnail_size, array(
				'alt' => esc_attr( $alt_text ),
				'class' => 'thumbnail'
			) );
		} else {
			$alt_text = get_the_title();
			echo "<img src='" . get_bloginfo('template_directory') . "/images/blogimage.png' alt='" . esc_attr( $alt_text ) . "' class='thumbnail' />";
		}
	}



	protected function render_title() {
		$settings = $this->get_settings();
		$show_title = $settings['show_title'];
		if ( 'yes' !== $show_title ) {
			return;
		}?>
		<a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
		<?php
	}




}	