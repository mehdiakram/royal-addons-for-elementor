<?php
namespace RoyalAddons\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Control_Media;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;
use \Elementor\Group_Control_Css_Filter;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; 

class RoyalPostFilterable extends Widget_Base {

	public function get_name() {
        return 'royalpostfilterable';
    }

	public function get_title() {
		return __( 'Filterable Post', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-post rtbranding'; }
    

	public function get_keywords() {
		return [ 'blog', 'post', 'filterable', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


    public function get_categories() {
        return [ 'royaltech' ];
    }


	public function get_style_depends() {
		return ['royalpostfilterable', 'royalpost', 'royalimagegrid'];
	}

	public function get_script_depends() {
		return ['matchheight', 'isotope', 'royalisotope', 'imagesloaded', 'royalpostfilterable'];
	}


	protected function register_controls() {
		$this->royal_query_options();
		$this->royal_portfolio_options();

		$this->royal_style_control_options();
		$this->royal_style_item_options();
		$this->royal_portfolio_styling_section();
		$this->royal_style_feature_post_options();
		$this->royal_style_image_options();
		$this->royal_style_content_options();
		$this->royal_style_title_options();
		$this->royal_style_excerpt_options();
		$this->royal_style_category_options();
		$this->royal_style_author_date_options();
		$this->royal_style_time_comment_options();
		$this->royal_style_button_options();
	}


	private function royal_query_options() {
		
        $this->start_controls_section(
            'royal_section_query_post_settings',
            [
                'label' => __( 'Query', 'royal-addons-for-elementor' )
            ]
        );

		$this->add_control(
            'royal_post_type',
            [
				'label'   => __( 'Post Type', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Royal_Helpers::royal_get_post_types(),
				'default' => 'post'

            ]
		);

		$this->add_control(
			'grid_style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Layout 1 (Classic)', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Layout 2 (Meta First)', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Layout 3 (Title Top)', 'royal-addons-for-elementor' ),
					'4' => esc_html__( 'Layout 4 (Title & Image)', 'royal-addons-for-elementor' ),
					'5' => esc_html__( 'Layout 5 (Meta Bottom)', 'royal-addons-for-elementor' ),
					'6' => esc_html__( 'Layout 6 (Clean Card)', 'royal-addons-for-elementor' ),
					'7' => esc_html__( 'Layout 7 (Overlay Card)', 'royal-addons-for-elementor' ),
					'8' => esc_html__( 'Layout 8 (Minimalist Editorial)', 'royal-addons-for-elementor' ),
					'9' => esc_html__( 'Layout 9 (Side by Side)', 'royal-addons-for-elementor' ),
					'10' => esc_html__( 'Layout 10 (Modern Bento)', 'royal-addons-for-elementor' ),
					'portfolio' => esc_html__( 'Portfolio (Web Showcase)', 'royal-addons-for-elementor' ),
					'portfolio_card' => esc_html__( 'Portfolio (Modern Card)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'royal_control_taxonomy',
			[
				'label' => __( 'Taxonomies', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'category',
				'options' => Royal_Helpers::royal_taxonomies(),
			]
		);

        $this->add_control(
            'posts_per_page',
            [
				'label'   => __( 'Posts Per Page', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '12'
            ]
		);

		$this->add_control(
            'column',
            [
                'label' => esc_html__( 'Columns for Desktop', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => esc_html__( 'One', 'royal-addons-for-elementor' ),
                    '2' => esc_html__( 'Two', 'royal-addons-for-elementor' ),
                    '3' => esc_html__( 'Three', 'royal-addons-for-elementor' ),
                    '4' => esc_html__( 'Four', 'royal-addons-for-elementor' ),
                    '5' => esc_html__( 'Five', 'royal-addons-for-elementor' ),
                ],
                'label_block' => true,
                'separator' => 'before',
                'prefix_class' => 'royalcolumns-',
            ]
        );


        $this->add_control(
            'royal_post_offset',
            [
				'label'   => __( 'Offset', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '0'
            ]
		);

		
		$this->add_control(
        	'exclude_post',
        	[
				'label'       => __( 'Exclude Post', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => Royal_Helpers::royal_get_all_posts(),
				'condition'   => [
					'royal_post_type' => 'post'
				]
            ]
        );

        $this->add_control(
        	'royal_post_grid_authors',
        	[
				'label'       => __( 'Author', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [],
				'options'     => Royal_Helpers::royal_get_all_authors()
            ]
		);

		$this->add_control(
        	'royal_post_grid_categories',
        	[
				'label'       => __( 'Categories', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::HIDDEN,
				'multiple'    => true,
				'default'     => [],
				'options'     => Royal_Helpers::royal_get_all_categories(),
				'condition'   => [
					'royal_post_type' => 'post'
				]
            ]
		);

        $this->add_control(
        	'royal_post_grid_tags',
        	[
				'label'       => __( 'Tags', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::HIDDEN,
				'multiple'    => true,
				'default'     => [],
				'options'     => Royal_Helpers::royal_get_all_tags(),
				'condition'   => [
					'royal_post_type' => 'post'
				]
            ]
        );

        $this->add_control(
            'order',
            [
				'label'    => __( 'Order', 'royal-addons-for-elementor' ),
				'type'     => Controls_Manager::SELECT,
                'default'  => 'desc',
				'options'  => [
					'asc'  => __( 'Ascending', 'royal-addons-for-elementor' ),
					'desc' => __( 'Descending', 'royal-addons-for-elementor' )
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
				'label'    => __( 'Order By', 'royal-addons-for-elementor' ),
				'type'     => Controls_Manager::SELECT,
                'default'  => 'date',
				'options'  => [
					'ID'  => __( 'ID', 'royal-addons-for-elementor' ),
					'date'  => __( 'Date', 'royal-addons-for-elementor' ),
					'modified' => __( 'Modified', 'royal-addons-for-elementor' ),
					'author' => __( 'Author Name', 'royal-addons-for-elementor' ),
					'title' => __( 'Post Title', 'royal-addons-for-elementor' ),
					'name' => __( 'Post Name', 'royal-addons-for-elementor' ),
					'rand' => __( 'Random', 'royal-addons-for-elementor' ),
                ]
            ]
        );
		
        $this->add_control(
			'royal_post_grid_filterable_menu',
			[
				'label'        => esc_html__( 'Enable Filterable Menu', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'On', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_control(
            'menu_style',
            [
                'label' => esc_html__( 'Menu Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
				'condition'   => [
					'royal_post_grid_filterable_menu' => 'yes'
				],
                'default' => 'one',
                'options' => [
                    'one'   => esc_html__( 'One', 'royal-addons-for-elementor' ),
                    'two'   => esc_html__( 'Two', 'royal-addons-for-elementor' ),
                    'three' => esc_html__( 'Three', 'royal-addons-for-elementor' ),
                    'four'  => esc_html__( 'Four', 'royal-addons-for-elementor' ),
                    'five'  => esc_html__( 'Five', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
			'royal_post_ignore_sticky',
			[
				'label'        => esc_html__( 'Ignore Sticky?', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'On', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);


        $this->add_control(
			'show_image',
			[
				'label'        => esc_html__( 'Enable Image', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
				],
				'label_on'	   => __( 'On', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'full',
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
					'show_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_default_image',
			[
				'label' => __( 'Default Image', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
					'show_image' => 'yes',
				],				
			]
		);

		$this->add_control(
			'default_image_size',
			[
				'label' => esc_html__( 'Default Image Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 50,
				'max' => 800,
				'step' => 1,
				'default' => 500,
				'condition' => [
					'show_image' => 'yes',
					'show_default_image' => 'yes',
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
				],	
			]
		);


        $this->add_control(
			'show_title',
			[
				'label'        => esc_html__( 'Enable Title', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'On', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes'
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
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
				],
				'default' => [ 'date', 'comments' ],
				'multiple' => true,
				'options' => [
					'author' => __( 'Author', 'royal-addons-for-elementor' ),
					'date' => __( 'Date', 'royal-addons-for-elementor' ),
					'categories' => __( 'Categories', 'royal-addons-for-elementor' ),
					'comments' => __( 'Comments', 'royal-addons-for-elementor' ),
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
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Excerpt', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio', 'portfolio_card' ],
				],
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
				'condition' => [
					'show_excerpt' => 'yes',
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio', 'portfolio_card' ],
				],
				'default' => apply_filters( 'excerpt_length', 25 ),
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
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio', 'portfolio_card' ],
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
					'grid_style!' => ['6', 'portfolio' ],
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
					'grid_style!' => ['6', 'portfolio' ],
				],
			]
		);

		$this->add_control(
            'royal_post_grid_show_read_more_btn_new_tab',
            [
                'label'        => esc_html__( 'Enable New Tab', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'	   => __( 'On', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'Off', 'royal-addons-for-elementor' ),
                'default'      => 'yes',
                'return_value' => 'yes',
				'condition'     => [
                    'royal_post_grid_show_read_more_btn' => 'yes'
				],
            ]
        );  

        $this->add_control(
            'royal_post_grid_all_item_text',
            [   
                'label'         => esc_html__( 'Text for All Item', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__('All', 'royal-addons-for-elementor'),
                'default'       => esc_html__('All', 'royal-addons-for-elementor' ),
            ]
        );

		$this->add_control(
			'royal_filter_show_count',
			[
				'label'        => esc_html__( 'Show Post Count in Filter', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'royal_filter_count_format',
			[
				'label'   => esc_html__( 'Count Display Style', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bracket',
				'options' => [
					'bracket' => esc_html__( 'Parentheses e.g. (12)', 'royal-addons-for-elementor' ),
					'badge'   => esc_html__( 'Pill Badge e.g. 12', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'royal_filter_show_count' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		
	}



	/* Control Style */
	private function royal_style_control_options() {
        $this->start_controls_section(
            'royal_section_fg_control_style_settings',
            [
                'label' => esc_html__('Control', 'royal-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

		$this->add_control(
			'royal_fg_control_container_alignment',
			[
				'label'   => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'default' => 'royal-filterable-menu-container-align-top',
				'options' => [
					'royal-filterable-menu-container-align-left'   => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-arrow-left'
					],
					'royal-filterable-menu-container-align-top' => [
						'title' => __( 'Top', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-arrow-up'
					],
					'royal-filterable-menu-container-align-right'  => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-arrow-right'
					]
				]
			]
		);

		$this->add_responsive_control(
			'royal_fg_control_container_filter_nav_width',
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'devices' => [ 'desktop' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-filterable-menu-container-align-left .royalisotope .royalgallery-filter' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-filterable-menu-container-align-right .royalisotope .royalgallery-filter' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'royal_fg_control_container_alignment' => ['royal-filterable-menu-container-align-left', 'royal-filterable-menu-container-align-right']
                ]
			]
        );

		$this->add_responsive_control(
			'royal_fg_control_container_filter_nav_conten_spacing',
			[
				'label'       => __( 'Left & Right Spacing', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					],
				],
				'devices' => [ 'desktop', 'tablet' ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 10
                ],
                'tablet_default' => [
					'size' => 10,
					'unit' => '%',
				],
                'mobile_default' => [
					'size' => 0,
					'unit' => 'px',
				],
                'condition' => [
					'royal_fg_control_container_alignment' => ['royal-filterable-menu-container-align-left', 'royal-filterable-menu-container-align-right']
                ],
				'selectors'   => [
					'{{WRAPPER}} .royal-filterable-menu-container-align-left .royalisotope .royalgallery-filter' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-filterable-menu-container-align-right .royalisotope .royalgallery-filter' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
			]
		);
        
        $this->add_responsive_control(
            'royal_fg_control_container_padding',
            [
                'label'        => esc_html__('Padding', 'royal-addons-for-elementor'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', 'em', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '30',
                    'bottom'   => '0',
                    'left'     => '30',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'royal_fg_control_container_margin',
            [
                'label'        => esc_html__('Margin', 'royal-addons-for-elementor'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', 'em', '%'],
                'default'      => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '20',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'royal_fg_control_container_background',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'royal_fg_control_container_border',
                'selector' => '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group',
            ]
        );

        $this->add_responsive_control(
            'royal_fg_control_container_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'royal-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                   => 'royal_fg_control_shadow',
                'selector'               => '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li',
                'fields_options'         => [
                    'box_shadow_type'    => [ 
                        'default'        =>'yes' 
                    ],
                    'box_shadow'         => [
                        'default'        => [
                            'horizontal' => 0,
                            'vertical'   => 10,
                            'blur'       => 33,
                            'spread'     => 0,
                            'color'      => 'rgba(51, 77, 128, 0.1)'
                        ]
                    ]
                ]
            ]
        );
  

		$this->add_responsive_control(
            'royal_fg_item_control_item_alignment',
            [
                'label'         => esc_html__('Item Alignment', 'royal-addons-for-elementor'),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'label_block'   => true,
                'default'       => 'center',
                'options'       => [
                    'left'      => [
                        'title' => esc_html__('Left', 'royal-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => esc_html__('Center', 'royal-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => esc_html__('Right', 'royal-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group' => 'justify-content: {{VALUE}};',
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'royal_fg_control_typography',
                'selector' => '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li',
                'fields_options'     => [
                    'text_transform' => [
                        'default'    => 'capitalize'
                    ]
                ]
            ]
        );

        // Tabs
        $this->start_controls_tabs('royal_fg_control_tabs');

        // Normal State Tab
        $this->start_controls_tab('royal_fg_control_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);

        $this->add_control(
            'royal_fg_control_normal_text_color',
            [
                'label'     => esc_html__('Text Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'royal_fg_control_normal_bg_color',
            [
                'label'     => esc_html__('Background Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'royal_fg_control_normal_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'width'            => [
                        'default'      => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'            => [
                        'default'      => 'rgba(255,255,255,0)'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li'
            ]
        );

        $this->add_control(
            'royal_fg_control_normal_border_radius',
            [
                'label'   => esc_html__('Border Radius', 'royal-addons-for-elementor'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px'  => [
                        'max' => 30
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab
        $this->start_controls_tab('royal_fg_control_btn_hover', ['label' => esc_html__('Hover', 'royal-addons-for-elementor')]);

        $this->add_control(
            'royal_fg_control_hover_text_color',
            [
                'label'     => esc_html__('Text Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'royal_fg_control_hover_bg_color',
            [
                'label'     => esc_html__('Background Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li:hover'      => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'royal_fg_control_hover_border',
                'selector' => '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li:hover'
            ]
        );

        $this->add_control(
            'royal_fg_control_hover_border_radius',
            [
                'label'       => esc_html__('Border Radius', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'max' => 30
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li:hover' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        // Active State Tab
        $this->start_controls_tab('royal_fg_control_btn_active', ['label' => esc_html__('Active', 'royal-addons-for-elementor')]);

        $this->add_control(
            'royal_fg_control_active_text_color',
            [
                'label'     => esc_html__('Text Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7a56ff',
                'selectors' => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li.active' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'royal_fg_control_active_bg_color',
            [
                'label'     => esc_html__('Background Color', 'royal-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li.active' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'                 => 'royal_fg_control_active_border',
                'fields_options'       => [
                    'border'           => [
                        'default'      => 'solid'
                    ],
                    'width'            => [
                        'default'      => [
                            'top'      => '0',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'            => [
                        'default'      => '#7a56ff'
                    ]
                ],
                'selector'             => '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li.active'
            ]
        );

        $this->add_control(
            'royal_fg_control_active_border_radius',
            [
                'label'       => esc_html__('Border Radius', 'royal-addons-for-elementor'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'max' => 30
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .royal-filterable-items .royalisotope .royalgallery-filter .filter-button-group li.active' => 'border-radius: {{SIZE}}px;'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->add_control(
			'royal_fg_filter_count_heading',
			[
				'label'     => esc_html__( 'Filter Post Count', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'royal_filter_show_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_fg_filter_count_color',
			[
				'label'     => esc_html__( 'Count Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-filterable-items .royalgallery-filter .filter-button-group li .royal-filter-count' => 'color: {{VALUE}};',
				],
				'condition' => [
					'royal_filter_show_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_fg_filter_count_active_color',
			[
				'label'     => esc_html__( 'Count Active Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-filterable-items .royalgallery-filter .filter-button-group li.active .royal-filter-count' => 'color: {{VALUE}};',
				],
				'condition' => [
					'royal_filter_show_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'royal_fg_filter_count_badge_bg',
			[
				'label'     => esc_html__( 'Badge Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-filterable-items .royalgallery-filter .filter-button-group li .royal-filter-count.count-badge' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'royal_filter_show_count' => 'yes',
					'royal_filter_count_format' => 'badge',
				],
			]
		);

		$this->add_control(
			'royal_fg_filter_count_badge_active_bg',
			[
				'label'     => esc_html__( 'Badge Active Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-filterable-items .royalgallery-filter .filter-button-group li.active .royal-filter-count.count-badge' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'royal_filter_show_count' => 'yes',
					'royal_filter_count_format' => 'badge',
				],
			]
		);

        $this->end_controls_section();
		
	}



	


	/* Item Style */
	private function royal_style_item_options() {

		$this->start_controls_section(
            'royal_section_post_grid_item',
            [
				'label' => __( 'Item', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
            ]
		);

		$this->add_control(
			'royal_single_item_bg_color',
			[
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalpost-inner' => 'background: {{VALUE}};'
				]

			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'royal_single_item_border',
                'selector' => '{{WRAPPER}} .royalpost-inner, {{WRAPPER}} .royal-portfolio-card',
            ]
        );

		$this->add_responsive_control(
			'royal_single_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalpost-inner, {{WRAPPER}} .royal-portfolio-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'royal_single_item_box_shadow',
				'selector' => '{{WRAPPER}} .royalpost-inner, {{WRAPPER}} .royal-portfolio-card',
			]
		);

		$this->add_responsive_control(
			'royal_single_item_padding',
			[
				'label'      => esc_html__( 'Item Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalgridcontainer .royalisotopeitem' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'royal_single_item_margin_bottom',
			[
				'label' => esc_html__( 'Margin Bottom', 'royal-addons-for-elementor' ),
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
				'selectors' => [
					'{{WRAPPER}} .royal-filterable-items .royalisotope .royalisotopegrid .royalisotopeitem' => 'margin-bottom: {{SIZE}}{{UNIT}}!important;',
				],
			]
		);



		$this->end_controls_section();
		
	}

	

	/* Featured Post Style */
	private function royal_style_feature_post_options() {

		$this->start_controls_section(
            'royal_section_post_grid_feature_post',
            [
				'label'     => __( 'Feature Post', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'royal_post_grid_enable_featured_post' => 'yes'
				]
            ]
		);

		$this->add_control(
            'royal_post_grid_feature_post_layout',
            [
				'label'   => __( 'Layout', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default_layout',
				'options' => [
					'default_layout' => esc_html__( 'Default Layout', 'royal-addons-for-elementor' ),
					'layout_one' => esc_html__( 'Layout 1', 'royal-addons-for-elementor' ),
				]
            ]
		);

		$this->add_control(
			'royal_post_grid_feature_post_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-post-grid.royal-post-grid-featured-post-yes.layout_one article.royal-post-grid-three:first-child .royal-post-grid-container .royal-post-grid-body'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();
	}

	

	/* Image Style */
	private function royal_style_image_options() {
		$this->start_controls_section(
            'royal_section_post_grid_image_style',
            [
				'label'     => __( 'Image', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
					'show_image' => 'yes'
				],
            ]
		);

		$this->add_control(
			'royal_section_post_grid_image_padding',
			[
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .royal-row-wrapper .royal-post-grid-container .royal-post-grid-thumbnail, {{WRAPPER}} .post-grid-thumbnail'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'royal_section_post_grid_image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .royal-post-grid-thumbnail img, {{WRAPPER}} .post-grid-thumbnail img, {{WRAPPER}} .post-grid-thumbnail'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
            'royal_post_grid_image_align',
            [
                'label'         => esc_html__( 'Image Position', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'toggle'        => false,
                'default'       => 'top',
                'options'       => [
                    'left'      => [
                        'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-arrow-left'
                    ],
                    'top'    	=> [
                        'title' => esc_html__( 'Top', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-arrow-up'
                    ],
                    'right'     => [
                        'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-arrow-right'
                    ]
                ]
            ]
		);
		
		$this->add_control(
			'royal_post_grid_image-height',
			[
				'label'       => __( 'Image Min Height', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-post-grid-container.image-position-top .royal-post-grid-thumbnail > a' => 'min-height: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'royal_post_grid_image_align' => 'top'
				]
			]
		);

		$this->add_control(
			'royal_post_grid_image_fixed_height',
			[
				'label'        => esc_html__( 'Fixed Height ?', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'	   => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no'
			]
		);

		$this->add_responsive_control(
			'royal_post_grid_image_height',
			[
				'label'       => __( 'Image Height', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' , '%'],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 500
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-post-grid-container.image-position-top .royal-post-grid-thumbnail > a' => 'height: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'royal_post_grid_image_fixed_height' => 'yes',
				]
			]
		);

		$this->add_control(
			'royal_post_grid_image_width',
			[
				'label'       => __( 'Image Width', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'range'       => [
					'%'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-post-grid-container.image-position-left>figure' => 'width: {{SIZE}}%;',
					'{{WRAPPER}} .royal-post-grid-container.image-position-left>div.royal-post-grid-body' => 'width: calc( 100% - {{SIZE}}% );',
					'{{WRAPPER}} .royal-post-grid-container.image-position-right>div.royal-post-grid-body' => 'width: calc( 100% - {{SIZE}}% );',
					'{{WRAPPER}} .royal-post-grid-container.image-position-right>figure' => 'width: {{SIZE}}%;',
				],
				'condition' => [
					'royal_post_grid_image_align' => [ 'left', 'right' ]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'royal_post_grid_image_css_filter',
				'selector' => '{{WRAPPER}} .royal-post-grid-container.image-position-top .royal-post-grid-thumbnail > a img',
			]
		);

		$this->end_controls_section();
	}

	

	/* Content Style */
	private function royal_style_content_options() {
		$this->start_controls_section(
            'royal_post_grid_content_style',
            [
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
				],
            ]
        );

		$this->add_control(
			'royal_post_grid_content_bg_color',
			[
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalpost .post-grid-text-wrap, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-three .royal-post-grid-body' => 'background-color: {{VALUE}};'
				]

			]
		);

        $this->add_responsive_control(
            'royal_post_grid_content_margin',
            [
                'label'         => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .royalpost .post-grid-text-wrap, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-three .royal-post-grid-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
			'royal_post_grid_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20'
				],
				'selectors'  => [
					'{{WRAPPER}} .royalpost .post-grid-text-wrap, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-three .royal-post-grid-body'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_group_control(
        	Group_Control_Border::get_type(),
            [
                'name'      => 'royal_post_grid_content_border',
                'selector'  => '{{WRAPPER}} .royalpost .post-grid-text-wrap, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-three .royal-post-grid-body'
            ]
        );

		$this->add_control(
			'royal_post_grid_content_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .royalpost .post-grid-text-wrap, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-three .royal-post-grid-body'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                   => 'royal_post_grid_content_box_shadow',
				'selector'               => '{{WRAPPER}} .royalpost .post-grid-text-wrap, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-three .royal-post-grid-body'
			]
		);

		$this->end_controls_section();
	}

	

	/* Title Style */
	private function royal_style_title_options() {
        $this->start_controls_section(
            'royal_post_grid_title',
            [
				'label'     => __( 'Title', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes'
				],
            ]
        );

        $this->add_responsive_control(
            'royal_post_grid_title_margin',
            [
                'label'         => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,			
                'size_units'    => [ 'px', 'em', '%' ],                 
                'selectors'     => [
                    '{{WRAPPER}} .royalisotopeitem .title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_responsive_control(
			'royal_grid_title_alignment',
			[
				'label'   => __( 'Title Alignment', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => [
					'left'		=> [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left'
					],
					'center' 	=> [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-center'
					],
					'right' 	=> [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right'
					]
				],
				'selectors' => [
					'{{WRAPPER}} .royalisotopeitem .title' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'royal_grid_title_typography',
				'selector' => '
				{{WRAPPER}} .royalisotopeitem .title, 
				{{WRAPPER}} .royalisotopeitem .title a'
			]
		);

		$this->start_controls_tabs( 'royal_post_grid_title_tabs' );

			$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ) ] );

			$this->add_control(
				'royal_grid_title_color',
				[
					'label'     => __( 'Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .royalisotopeitem .title' => 'color: {{VALUE}};',
						'{{WRAPPER}} .royalisotopeitem .title a' => 'color: {{VALUE}};'
					]	
				]
			);

			$this->add_control(
				'royal_grid_title_bg_color',
				[
					'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .royalisotopeitem .title' => 'background: {{VALUE}};'
					]	
				]
			);

			$this->end_controls_tab();
			
			$this->start_controls_tab( 'hover', [ 'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ) ] );

			$this->add_control(
				'royal_grid_title_hover_color',
				[
					'label'     => __( 'Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .royalisotopeitem:hover .title' => 'color: {{VALUE}};',
						'{{WRAPPER}} .royalisotopeitem:hover .title a' => 'color: {{VALUE}};'
					]
	
				]
			);

			$this->add_control(
				'royal_grid_title_hover_bg_color',
				[
					'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .royalisotopeitem:hover .title' => 'background: {{VALUE}};'
					]	
				]
			);
			$this->end_controls_tab();
		
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	

	/* excerpt Style */
	private function royal_style_excerpt_options() {
		$this->start_controls_section(
            'royal_post_grid_excerpt_style',
            [
				'label' => __( 'Excerpt', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
					'show_excerpt' => 'yes'
				]
            ]
        );

        $this->add_control(
			'royal_grid_excerpt_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#848484',
				'selectors' => [
					'{{WRAPPER}} .royalpost .post-grid-excerpt, {{WRAPPER}} .royalpost .post-grid-excerpt p, {{WRAPPER}} .royal-post-grid-body .royal-post-grid-description' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_responsive_control(
			'royal_grid_excerpt_alignment',
			[
				'label'   => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'toggle'  => false,
				'options' => [
					'left' 		=> [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-left'
					],
					'center' 	=> [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-center'
					],
					'right' 	=> [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-right'
					],
					'justify' 	=> [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' 	=> 'eicon-text-align-justify'
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .royalpost .post-grid-excerpt, {{WRAPPER}} .royal-post-grid-body .royal-post-grid-description' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'royal_post_grid_excerpt_typography',
				'selector' => '{{WRAPPER}} .royalpost .post-grid-excerpt, {{WRAPPER}} .royalpost .post-grid-excerpt p, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-body .royal-post-grid-description'
            ]
        );

        $this->add_responsive_control(
			'royal_post_grid_excerpt_margin',
			[
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'      => '15',
					'right'    => '0',
					'bottom'   => '20',
					'left'     => '0',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .royalpost .post-grid-excerpt, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-body .royal-post-grid-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	

	/* category Style */
	private function royal_style_category_options() {
		$this->start_controls_section(
            'royal_post_grid_category_style',
            [
				'label' => __( 'Category', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'royal_post_grid_show_category' => 'yes'
				]
            ]
        );

        $this->add_control(
			'royal_post_grid_category_default_position',
			[
				'label'        => esc_html__( 'Category Position Default?', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

        $this->add_control(
			'royal_post_grid_category_position_over_image',
			[
				'label'   => esc_html__( 'Category Position Over Image', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '-bottom-left',
				'options' => [
					'-bottom-left' 	=> esc_html__( 'Bottom Left Corner', 'royal-addons-for-elementor' ),
					'-top-right'   	=> esc_html__( 'Top Right Corner', 'royal-addons-for-elementor' )
				],
                'condition' => [
                    '.royal_post_grid_category_default_position!' => 'yes'
                ]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'royal_post_grid_category_typography',
				'selector' => '{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li a'
            ]
        );

		$this->add_control(
			'royal_post_grid_category_padding',
			[
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'default'    => [
					'top'      => '1',
					'right'    => '10',
					'bottom'   => '1',
					'left'     => '10',
					'isLinked' => false
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li'=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'royal_post_grid_category_all_item_margin',
            [
				'label'      => esc_html__( 'Margin(Each Item)', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],                 
				'selectors'  => [
                    '{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'royal_post_grid_category_each_item_margin',
            [
				'label'      => esc_html__( 'Margin(All Items)', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],                 
				'selectors'  => [
                    '{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
			'royal_post_grid_category_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->start_controls_tabs( 'royal_post_grid_category_tabs' );

            // normal state tab
			$this->start_controls_tab( 'royal_post_grid_odd_category', [ 'label' => esc_html__( 'ODD', 'royal-addons-for-elementor' ) ] );
			
				$this->add_control(
					'royal_grid_category_bg_odd_color',
					[
						'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#00d8d8',
						'selectors' => [
							'{{WRAPPER}} .royal-row-wrapper .royal-post-grid-category li:nth-child(2n-1)' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'royal_grid_category_odd_text_color',
					[
						'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li:nth-child(2n-1) a' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'royal_grid_category_odd_border',
						'selector'  => '{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li:nth-child(2n-1)'
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'      => 'royal_grid_category_odd_shadow',
						'selector'  => '{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li:nth-child(2n-1)',
						'separator' => 'before'
					]
				);

            $this->end_controls_tab();

            // hover state tab
			$this->start_controls_tab( 'royal_post_grid_even_category', [ 'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ) ] );
			
				$this->add_control(
					'royal_grid_category_bg_even_color',
					[
						'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#7a56ff',
						'selectors' => [
							'{{WRAPPER}} .royal-row-wrapper .royal-post-grid-category li:nth-child(2n)' => 'background: {{VALUE}};'
						]
					]
				);

				$this->add_control(
					'royal_grid_category_even_text_color',
					[
						'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li:nth-child(2n) a' => 'color: {{VALUE}};'
						]
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'royal_grid_category_even_border',
						'selector'  => '{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li:nth-child(2n)'
					]
				);

				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'      => 'royal_grid_category_even_shadow',
						'selector'  => '{{WRAPPER}} .royal-post-grid-container ul.royal-post-grid-category li:nth-child(2n)',
					]
				);

            $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();
	}

	

	/* Author & Date Style */
	private function royal_style_author_date_options() {
		$this->start_controls_section(
            'royal_post_grid_author_date_style',
            [
				'label' => __( 'Author & Date', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
				],
            ]
		);
		
		$this->add_control(
			'royal_post_grid_author_image_size',
			[
				'label'       => __( 'Author Image Size', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 100
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 40
				],
				'selectors'   => [
					'{{WRAPPER}} .royal-author-avatar img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'royal_post_grid_author_date_margin',
            [
				'label'        => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '10',
					'right'    => '0',
					'bottom'   => '10',
					'left'     => '0',
					'isLinked' => false
				],                 
                'selectors'    => [
                    '{{WRAPPER}} .royalpost .post-grid-meta, {{WRAPPER}} .royal-post-grid-body .royal-post-data' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
			'royal_post_grid_meta_style',
			[
				'label'     => __( 'Meta', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'royal_post_grid_meta_spacing',
			[
				'label'       => __( 'Spacing Between Author & Date', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px'      => [
						'min' => 0,
						'max' => 150
					]
				],
				'default'     => [
					'unit'    => 'px',
					'size'    => 15
				],
				'selectors'   => [
					'{{WRAPPER}} .royalpost .post-grid-meta span, {{WRAPPER}} .royal-post-grid-body .royal-post-data li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_control(
			'royal_grid_author_date_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#848484',
				'selectors' => [
					'{{WRAPPER}} .royalpost .post-grid-meta span, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-body .royal-post-data li span' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'royal_grid_author_date_typography',
				'selector' => '{{WRAPPER}} .royalpost .post-grid-meta span, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-body .royal-post-data li span'
            ]
        );

		$this->add_control(
			'royal_grid_date_style',
			[
				'label'     => __( 'Meta Link', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

        $this->add_control(
			'royal_grid_author_date_link_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .royalpost .post-grid-meta a, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-body .royal-post-data li span a' => 'color: {{VALUE}};'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'royal_grid_author_date_link_typography',
				'selector' => '{{WRAPPER}} .royalpost .post-grid-meta a, {{WRAPPER}} .royal-row-wrapper .royal-post-grid-body .royal-post-data li span a'
            ]
        );

		$this->end_controls_section();
	}

	

	/* Time Comment Style */
	private function royal_style_time_comment_options() {
		$this->start_controls_section(
            'royal_post_grid_reading_time_comment_style',
            [
				'label' => __( 'Reading Time & Comment', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'portfolio_card' ],
				],
            ]
        );

        $this->add_responsive_control(
            'royal_post_grid_reading_time_comment_margin',
            [
				'label'        => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::DIMENSIONS,
				'size_units'   => [ 'px', 'em', '%' ],
				'default'      => [
					'top'      => '10',
					'right'    => '0',
					'bottom'   => '10',
					'left'     => '0',
					'isLinked' => false
				],               
                'selectors'    => [
                    '{{WRAPPER}} .royal-row-wrapper .royal-post-grid-body ul.royal-post-grid-time-comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

		$this->add_control(
			'royal_post_grid_reading_time_style',
			[
				'label'     => __( 'Reading Time', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'royal_post_grid_show_read_time' => 'yes'
				]
			]
		);

        $this->add_control(
			'royal_post_grid_reading_time_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#90929C',
				'selectors' => [
					'{{WRAPPER}} .royal-post-grid-container .royal-post-grid-body ul.royal-post-grid-time-comment li.royal-post-grid-read-time' => 'color: {{VALUE}};'
				],
				'condition' => [
					'royal_post_grid_show_read_time' => 'yes'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'      => 'royal_post_grid_reading_time_typography',
				'selector'  => '{{WRAPPER}} .royal-post-grid-container .royal-post-grid-body ul.royal-post-grid-time-comment li.royal-post-grid-read-time',
				'condition' => [
					'royal_post_grid_show_read_time' => 'yes'
				]
            ]
        );

		$this->add_control(
			'royal_post_grid_comment_style',
			[
				'label'     => __( 'Comment', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'royal_post_grid_show_comment' => 'yes'
				]
			]
		);

        $this->add_control(
			'royal_post_grid_comment_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#90929C',
				'selectors' => [
					'{{WRAPPER}} .royal-post-grid-container .royal-post-grid-body ul.royal-post-grid-time-comment li a.royal-post-grid-comment' => 'color: {{VALUE}};'
				],
				'condition' => [
					'royal_post_grid_show_comment' => 'yes'
				]
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'      => 'royal_post_grid_comment_typography',
				'selector'  => '{{WRAPPER}} .royal-post-grid-container .royal-post-grid-body ul.royal-post-grid-time-comment li a.royal-post-grid-comment',
				'condition' => [
					'royal_post_grid_show_comment' => 'yes'
				]
            ]
        );
        
		$this->end_controls_section();
	}

	

	/* Button Style */
	private function royal_style_button_options() {		
        $this->start_controls_section(
            'royal_post_grid_details_btn_style_section',
            [
				'label'     => esc_html__( 'Button Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style' => [ '1', '2', '3', '4', '5', '7', '8', '9', '10', 'portfolio_card' ],
                    'show_read_more' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'royal_post_grid_details_btn_padding',
            [
				'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,           
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
                    '{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'royal_post_grid_details_btn_margin',
            [
				'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],                 
				'selectors'  => [
                    '{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
				'name'     => 'royal_post_grid_details_btn_typography',
				'selector' => '{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a'
            ]
		);
		
		$this->add_control(
			'royal_post_grid_details_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

        $this->start_controls_tabs( 'royal_post_grid_details_button_style_tabs' );

            // normal state tab
            $this->start_controls_tab( 'royal_post_grid_details_btn_normal', [ 'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ) ] );

            $this->add_control(
                'royal_post_grid_details_btn_normal_text_color',
                [
					'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
                        '{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'royal_post_grid_details_btn_normal_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
            Group_Control_Border::get_type(),
                [
                    'name'      => 'royal_post_grid_details_btn_border',
                    'selector'  => '{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a'
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
					'name'      => 'royal_post_grid_details_button_shadow',
					'selector'  => '{{WRAPPER}} .royalpost a.read-more-btn, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a',
					'separator' => 'before'
                ]
            );

            $this->end_controls_tab();

            // hover state tab
            $this->start_controls_tab( 'royal_post_grid_details_btn_hover', [ 'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ) ] );

            $this->add_control(
                'royal_post_grid_details_btn_hover_text_color',
                [
                    'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royalpost a.read-more-btn:hover, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a:hover' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'royal_post_grid_details_btn_hover_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royalpost a.read-more-btn:hover, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a:hover' => 'background: {{VALUE}};'
                    ]
                ]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
					[
						'name'      => 'royal_post_grid_details_btn_border_hover',
						'selector'  => '{{WRAPPER}} .royalpost a.read-more-btn:hover, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a:hover'
					]
				);

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'      => 'royal_post_grid_details_button_hover_shadow',
                    'selector'  => '{{WRAPPER}} .royalpost a.read-more-btn:hover, {{WRAPPER}} .royal-post-grid-container .royal-post-grid-body .royal-post-footer a:hover',
                    'separator' => 'before'
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }



	/* portfolio Options */
	private function royal_portfolio_options() {

		$this->start_controls_section(
			'post_portfolio_section',
			[
				'label' => esc_html__( 'Portfolio Options', 'royal-addons-for-elementor' ),
				'condition' => [
					'grid_style' => [ 'portfolio', 'portfolio_card' ],
				],
			]
		);

		$this->add_control(
			'portfolio_hover_effect',
			[
				'label'   => esc_html__( 'Hover Effect', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scroll',
				'options' => [
					'scroll'        => esc_html__( 'Web Showcase Scroll (Top to Bottom)', 'royal-addons-for-elementor' ),
					'zoom'          => esc_html__( 'Smooth Image Zoom (Creative)', 'royal-addons-for-elementor' ),
					'overlay_slide' => esc_html__( 'Overlay Slide Up', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'grid_style' => 'portfolio',
				],
			]
		);

		$this->add_control(
			'portfolio_scroll_duration',
			[
				'label' => esc_html__( 'Scroll Duration (Seconds)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 15,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-portfolio-card.hover-scroll .portfolio' => 'transition-duration: {{SIZE}}s !important;',
				],
				'condition' => [
					'grid_style' => 'portfolio',
					'portfolio_hover_effect' => 'scroll',
				],
			]
		);

		$this->add_control(
			'portfolio_mockup_header',
			[
				'label'        => esc_html__( 'Browser Mockup Header', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'grid_style' => 'portfolio',
				],
			]
		);

		$this->add_control(
			'portfolio_mockup_style',
			[
				'label'   => esc_html__( 'Mockup Header Style', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light' => esc_html__( 'Light macOS', 'royal-addons-for-elementor' ),
					'dark'  => esc_html__( 'Dark macOS', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'grid_style' => 'portfolio',
					'portfolio_mockup_header' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'portfolio_height',
			[
				'label' => esc_html__( 'Portfolio Height', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1200,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 420,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 380,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 380,
				],			
				'selectors' => [
					'{{WRAPPER}} .royal-filterable-items .portfolio' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-filterable-items .royal-card-portfolio-creative .royal-portfolio-creative-thumb' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'portfolio_show_badge',
			[
				'label'        => esc_html__( 'Category Badge', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'portfolio_show_actions',
			[
				'label'        => esc_html__( 'Action Buttons', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'portfolio_action_btn_type',
			[
				'label'   => esc_html__( 'Button Display', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'live',
				'options' => [
					'live'   => esc_html__( 'Live Preview Button Only', 'royal-addons-for-elementor' ),
					'detail' => esc_html__( 'View Details Button Only', 'royal-addons-for-elementor' ),
					'both'   => esc_html__( 'Both (Live & Details)', 'royal-addons-for-elementor' ),
					'none'   => esc_html__( 'None (Hide All Buttons)', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'portfolio_show_actions' => 'yes',
				],
			]
		);

		$this->add_control(
			'portfolio_live_new_tab',
			[
				'label'        => esc_html__( 'Open Live Link in New Tab', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'portfolio_show_actions' => 'yes',
					'portfolio_action_btn_type' => [ 'live', 'both' ],
				],
			]
		);

		$this->add_control(
			'portfolio_detail_new_tab',
			[
				'label'        => esc_html__( 'Open Detail Link in New Tab', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'portfolio_show_actions' => 'yes',
					'portfolio_action_btn_type' => [ 'detail', 'both' ],
				],
			]
		);

		$this->add_control(
			'portfolio_show_excerpt',
			[
				'label'        => esc_html__( 'Show Excerpt / Description', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'portfolio_card_border_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 40,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors'  => [
					'{{WRAPPER}} .royal-portfolio-card' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-card-portfolio-creative' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/* Portfolio Style */
	private function royal_portfolio_styling_section() {

		$this->start_controls_section(
			'royal_portfolio_styling_section',
			[
				'label'     => esc_html__( 'Portfolio Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style' => [ 'portfolio', 'portfolio_card' ],
				],
			]
		);

		$this->add_control(
			'portfolio_overlay_heading',
			[
				'label' => esc_html__( 'Overlay', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'portfolio_overlay_bg',
				'label'    => esc_html__( 'Overlay Background', 'royal-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-portfolio-card .portfolio-overlay, {{WRAPPER}} .royal-portfolio-creative-overlay',
			]
		);

		$this->add_control(
			'portfolio_badge_heading',
			[
				'label'     => esc_html__( 'Category Badge', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'portfolio_badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-category-badge' => 'background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'portfolio_badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-category-badge' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'portfolio_action_btn_heading',
			[
				'label'     => esc_html__( 'Action Buttons', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'portfolio_action_btn_bg',
			[
				'label'     => esc_html__( 'Button Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .portfolio-action-icon-btn' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'portfolio_action_btn_color',
			[
				'label'     => esc_html__( 'Button Icon Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .portfolio-action-icon-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'portfolio_action_btn_hover_bg',
			[
				'label'     => esc_html__( 'Button Hover Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .portfolio-action-icon-btn:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'portfolio_action_btn_hover_color',
			[
				'label'     => esc_html__( 'Button Hover Icon Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .portfolio-action-icon-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}






    protected function render() {
		$settings 		= $this->get_settings_for_display();
		$id             = $this->get_id();
		$royalpostfilter= 'royalpostfilter'.$id;
		

        $this->add_render_attribute(
			'royal_post_grid_wrapper',
			[
				'class' => "filterable-post-container royal-row-wrapper"
			]
		);
		
        ?>
		<div class="royal-filterable-items <?php echo esc_attr( $settings['royal_fg_control_container_alignment'] );?>" id ="royal-filterable-filterable-id-<?php echo esc_attr( $this->get_id() ); ?>">
			
			<div class="royalisotope" id="<?php echo $royalpostfilter?>">
			<?php if ( $settings['royal_post_grid_filterable_menu'] === 'yes' ) { ?>
				<?php $this->render_filter_menu(); ?>
			<?php } ?>

			<div class="royalisotopegrid royalgridcontainer royalrow" <?php $this->print_render_attribute_string( 'royal_post_grid_wrapper' ); ?> id="filters-<?php echo esc_attr( $this->get_id() ); ?>">
			<?php $this->royal_get_posts( $settings ); ?>
			</div>
			</div>
		</div>
    	<?php


    }

	public function render_filter_menu() {
		$settings = $this->get_settings_for_display();
		$id             = $this->get_id();

		$tex_cat = !empty($settings['royal_control_taxonomy']) ? $settings['royal_control_taxonomy'] : 'category';
        $args = array(
            'taxonomy' => $tex_cat,
        );
        $terms = get_categories($args);

		$show_count = !empty($settings['royal_filter_show_count']) && 'yes' === $settings['royal_filter_show_count'];
		$count_format = !empty($settings['royal_filter_count_format']) ? $settings['royal_filter_count_format'] : 'bracket';

		$all_count = 0;
		if ( $show_count ) {
			$post_type = !empty($settings['royal_post_type']) ? $settings['royal_post_type'] : 'post';
			$counts = wp_count_posts( $post_type );
			$all_count = isset($counts->publish) ? intval($counts->publish) : 0;
			if ( $all_count === 0 && !empty($terms) && !is_wp_error($terms) ) {
				foreach ( $terms as $t ) {
					$all_count += intval($t->count);
				}
			}
		}

        ?>
		<div class="royalgallery-filter royalgallery-filter-<?php echo esc_attr($settings['menu_style']); ?>">
			<ul class="filter-button-group" data-target="#isotopegallery-<?php echo esc_attr($id); ?>">
				<li class="active" data-filter="*">
					<?php echo esc_html( $settings['royal_post_grid_all_item_text'] ); ?>
					<?php if ( $show_count ) : ?>
						<span class="royal-filter-count count-<?php echo esc_attr($count_format); ?>"><?php echo ($count_format === 'bracket') ? '(' . $all_count . ')' : $all_count; ?></span>
					<?php endif; ?>
				</li>
				<?php
				if ( !empty($terms) && !is_wp_error($terms) ) {
					foreach ( $terms as $term ) {
					?>
						<li data-filter=".<?php echo esc_attr( $term->slug ); ?>">
							<?php echo esc_html( $term->name ); ?>
							<?php if ( $show_count ) : ?>
								<span class="royal-filter-count count-<?php echo esc_attr($count_format); ?>"><?php echo ($count_format === 'bracket') ? '(' . intval($term->count) . ')' : intval($term->count); ?></span>
							<?php endif; ?>
						</li>
					<?php
					}
				}
				?>
			</ul>
		</div>
    <?php
    }

	public function royal_get_posts( $settings ) {
		$settings       = $this->get_settings_for_display();
		$grid_style		= $settings['grid_style'];
		$exclude		= $settings['exclude_post'];
		$offset			= $settings['royal_post_offset'];
		$sticky			= $settings['royal_post_ignore_sticky'];
		$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 12 );

		$column         = $settings['column'];
		$collumval  = 'royalcol-3';
        if( $column !='' ){
            $collumval = 'royalcol-'.esc_attr($column);
        }

		$tex_cat = $settings['royal_control_taxonomy'];
        $args = array(
            'taxonomy' => $tex_cat,
        );
        $cats = get_categories($args);


		if($sticky == 'yes'){
			$stickypost = 'true';
		} else{
			$stickypost = 'false';
		}

		$royal_post_type = $settings['royal_post_type'];
		
		$query_args = array(
			'post_type' 			=> $royal_post_type,
			'posts_per_page' 		=> absint( $posts_per_page ),
			'no_found_rows'  		=> true,
			'post_status'         	=> 'publish',
			'ignore_sticky_posts'   => $stickypost,
			'post__not_in' 			=> $exclude,
			'offset' 				=> $offset,
			'orderby' 				=> $settings['orderby'],
			'order' 				=> $settings['order'],
		);


		$all_posts = new \WP_Query( $query_args );
		if ( $all_posts->have_posts() ) :
			while ( $all_posts->have_posts() ) :
				$all_posts->the_post();
		
			?>
			<div class="royalisotopeitem royalpost <?php echo $collumval; ?> <?php echo esc_attr(Royal_Helpers::royal_get_categories_name_for_class()). ' ' ;?> style-<?php echo esc_attr($grid_style); ?>">
				
			<?php	
			if( 1 == $grid_style ){?>					
				<div class="royalpost-inner royal-card-classic">
					<div class="royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap">
						<?php $this->render_title(); ?>
						<?php $this->render_meta(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>													   
				<?php						
				
			} elseif( 2 == $grid_style ){?>               
				<div class="royalpost-inner royal-card-meta-first">
					<div class="royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap">
						<?php $this->render_meta(); ?>
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>
				<?php

			} elseif( 3 == $grid_style ){?>
				<div class="royalpost-inner royal-card-title-top">
					<div class="post-grid-header-wrap">
						<?php $this->render_title(); ?>
						<?php $this->render_meta(); ?>
					</div>
					<div class="royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap">
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>
				<?php
				
			} elseif( 4 == $grid_style ){ ?>
				<div class="royalpost-inner royal-card-title-img">
					<div class="post-grid-header-wrap">
						<?php $this->render_title(); ?>
					</div>
					<div class="royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap">
						<?php $this->render_meta(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>
				<?php

			} elseif( 5 == $grid_style ){?> 	
				<div class="royalpost-inner royal-card-meta-bottom">
					<div class="royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap">
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
					<div class="post-grid-footer-meta">
						<?php $this->render_meta(); ?>
					</div>
				</div>
				<?php

			} elseif( 6 == $grid_style ){ ?>
				<div class="royalpost-inner royal-card-clean">
					<div class="royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap">
						<?php $this->render_meta(); ?>
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt(); ?>
					</div>
				</div>
				<?php	

			} elseif( 7 == $grid_style ){ 
				$thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : plugin_dir_url( __DIR__ ) . 'assets/images/noimage.png';
			?>
				<div class="royalpost-inner royal-card-overlay" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
					<a href="<?php the_permalink(); ?>" class="royal-overlay-click" aria-label="<?php echo esc_attr(get_the_title()); ?>"></a>
					<?php $this->render_card_category_badge(); ?>
					<div class="royal-overlay-gradient"></div>
					<div class="royal-overlay-content post-grid-text-wrap">
						<?php $this->render_meta(); ?>
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>
				<?php

			} elseif( 8 == $grid_style ){ ?>
				<div class="royalpost-inner royal-card-minimal">
					<div class="royal-minimal-thumb-wrap royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap royal-minimal-content">
						<div class="royal-editorial-meta">
							<span class="royal-editorial-author"><?php the_author(); ?></span>
							<span class="royal-editorial-dot">&bull;</span>
							<span class="royal-editorial-date"><?php echo get_the_date(); ?></span>
						</div>
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>
				<?php

			} elseif( 9 == $grid_style ){ ?>
				<div class="royalpost-inner royal-card-split">
					<div class="royal-split-media royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap royal-split-content">
						<?php $this->render_meta(); ?>
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>
				<?php

			} elseif( 10 == $grid_style ){ ?>
				<div class="royalpost-inner royal-card-bento">
					<div class="royal-bento-media royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
						<div class="royal-bento-date">
							<span class="bento-day"><?php echo get_the_date('d'); ?></span>
							<span class="bento-month"><?php echo get_the_date('M'); ?></span>
						</div>
					</div>
					<div class="post-grid-text-wrap royal-bento-content">
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt(); ?>
						<div class="royal-bento-footer">
							<span class="royal-bento-author"><?php the_author(); ?></span>
							<a href="<?php the_permalink(); ?>" class="royal-bento-btn" aria-label="<?php echo esc_attr(get_the_title()); ?>">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
							</a>
						</div>
					</div>
				</div>
				<?php

			} elseif($grid_style == 'portfolio'){ 
				$thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : plugin_dir_url( __DIR__ ) . 'assets/images/noimage.png';
				$live_portfolio 	= get_post_meta(get_the_ID(), "live_portfolio", true);
				$portfolio_live_url = get_post_meta(get_the_ID(), "portfolio_live_url", true);
				$item_link          = (!empty($live_portfolio) && ($live_portfolio === 'yes' || $live_portfolio == 1) && !empty($portfolio_live_url)) ? $portfolio_live_url : get_permalink();
				$target             = (!empty($live_portfolio) && ($live_portfolio === 'yes' || $live_portfolio == 1) && !empty($portfolio_live_url)) ? '_blank' : '_self';
				$hover_effect       = !empty($settings['portfolio_hover_effect']) ? $settings['portfolio_hover_effect'] : 'scroll';
				$show_mockup        = !empty($settings['portfolio_mockup_header']) && 'yes' === $settings['portfolio_mockup_header'];
				$mockup_style       = !empty($settings['portfolio_mockup_style']) ? $settings['portfolio_mockup_style'] : 'light';
				$show_actions       = !empty($settings['portfolio_show_actions']) && 'yes' === $settings['portfolio_show_actions'];
				$btn_type           = !empty($settings['portfolio_action_btn_type']) ? $settings['portfolio_action_btn_type'] : 'live';
				$live_new_tab       = !isset($settings['portfolio_live_new_tab']) || 'yes' === $settings['portfolio_live_new_tab'];
				$detail_new_tab     = !empty($settings['portfolio_detail_new_tab']) && 'yes' === $settings['portfolio_detail_new_tab'];
				$live_target        = $live_new_tab ? '_blank' : '_self';
				$detail_target      = $detail_new_tab ? '_blank' : '_self';
			?>
				<div class="royal-portfolio-card hover-<?php echo esc_attr($hover_effect); ?> mockup-<?php echo esc_attr($mockup_style); ?>">
					<?php if ( $show_mockup ) : ?>
					<div class="royal-portfolio-mockup-header">
						<div class="mockup-dots">
							<span class="mockup-dot dot-red"></span>
							<span class="mockup-dot dot-yellow"></span>
							<span class="mockup-dot dot-green"></span>
						</div>
						<div class="mockup-url-bar"><?php echo esc_html( wp_trim_words( get_the_title(), 4, '' ) ); ?></div>
					</div>
					<?php endif; ?>

					<div class="portfolio" style="background-image:url('<?php echo esc_url($thumb_url); ?>');">
						<a href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($target); ?>" class="portfolio-direct-link" aria-label="<?php echo esc_attr(get_the_title()); ?>"></a>
						
						<?php if ( !empty($settings['portfolio_show_badge']) && 'yes' === $settings['portfolio_show_badge'] ) : ?>
							<?php $this->render_card_category_badge(); ?>
						<?php endif; ?>

						<div class="portfolio-overlay">
							<div class="portfolio-content-wrap">
								<?php $this->render_title(); ?>
								<?php if ( !empty($settings['portfolio_show_excerpt']) && 'yes' === $settings['portfolio_show_excerpt'] ) : ?>
									<div class="portfolio-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12, '...' ) ); ?></div>
								<?php endif; ?>
							</div>

							<?php if ( $show_actions && $btn_type !== 'none' ) : ?>
							<div class="portfolio-action-buttons">
								<?php if ( in_array( $btn_type, [ 'live', 'both' ] ) ) : ?>
								<a href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($live_target); ?>" class="portfolio-action-icon-btn btn-live" title="<?php esc_attr_e( 'View Live', 'royal-addons-for-elementor' ); ?>" aria-label="<?php esc_attr_e( 'View Live', 'royal-addons-for-elementor' ); ?>">
									<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
								</a>
								<?php endif; ?>
								<?php if ( in_array( $btn_type, [ 'detail', 'both' ] ) ) : ?>
								<a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($detail_target); ?>" class="portfolio-action-icon-btn btn-detail" title="<?php esc_attr_e( 'View Details', 'royal-addons-for-elementor' ); ?>" aria-label="<?php esc_attr_e( 'View Details', 'royal-addons-for-elementor' ); ?>">
									<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
								</a>
								<?php endif; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php	
				
			} elseif($grid_style == 'portfolio_card'){ 
				$thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : plugin_dir_url( __DIR__ ) . 'assets/images/noimage.png';
				$live_portfolio 	= get_post_meta(get_the_ID(), "live_portfolio", true);
				$portfolio_live_url = get_post_meta(get_the_ID(), "portfolio_live_url", true);
				$item_link          = (!empty($live_portfolio) && ($live_portfolio === 'yes' || $live_portfolio == 1) && !empty($portfolio_live_url)) ? $portfolio_live_url : get_permalink();
				$target             = (!empty($live_portfolio) && ($live_portfolio === 'yes' || $live_portfolio == 1) && !empty($portfolio_live_url)) ? '_blank' : '_self';
				$show_actions       = !empty($settings['portfolio_show_actions']) && 'yes' === $settings['portfolio_show_actions'];
				$btn_type           = !empty($settings['portfolio_action_btn_type']) ? $settings['portfolio_action_btn_type'] : 'live';
				$live_new_tab       = !isset($settings['portfolio_live_new_tab']) || 'yes' === $settings['portfolio_live_new_tab'];
				$detail_new_tab     = !empty($settings['portfolio_detail_new_tab']) && 'yes' === $settings['portfolio_detail_new_tab'];
				$live_target        = $live_new_tab ? '_blank' : '_self';
				$detail_target      = $detail_new_tab ? '_blank' : '_self';
			?>
				<div class="royalpost-inner royal-card-portfolio-creative">
					<div class="royal-portfolio-creative-thumb royalpost-thumb-holder">
						<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
						<?php $this->render_card_category_badge(); ?>
						<?php if ( $show_actions && $btn_type !== 'none' ) : ?>
						<div class="royal-portfolio-creative-overlay">
							<div class="royal-portfolio-creative-actions">
								<?php if ( in_array( $btn_type, [ 'live', 'both' ] ) ) : ?>
								<a href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($live_target); ?>" class="portfolio-action-icon-btn" title="<?php esc_attr_e( 'Launch Project', 'royal-addons-for-elementor' ); ?>" aria-label="<?php esc_attr_e( 'Launch Project', 'royal-addons-for-elementor' ); ?>">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
								</a>
								<?php endif; ?>
								<?php if ( in_array( $btn_type, [ 'detail', 'both' ] ) ) : ?>
								<a href="<?php the_permalink(); ?>" target="<?php echo esc_attr($detail_target); ?>" class="portfolio-action-icon-btn" title="<?php esc_attr_e( 'Case Study', 'royal-addons-for-elementor' ); ?>" aria-label="<?php esc_attr_e( 'Case Study', 'royal-addons-for-elementor' ); ?>">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
								</a>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="post-grid-text-wrap royal-portfolio-creative-content">
						<?php $this->render_title(); ?>
						<?php if ( !empty($settings['portfolio_show_excerpt']) && 'yes' === $settings['portfolio_show_excerpt'] ) : ?>
							<div class="portfolio-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 10, '...' ) ); ?></div>
						<?php endif; ?>
					</div>
				</div>
				<?php

			} else{?>								 									
				<div class="royalpost-inner royal-card-classic">
					<div class="royalpost-thumb-holder">
						<?php $this->render_thumbnail(); ?>
						<?php $this->render_card_category_badge(); ?>
					</div>
					<div class="post-grid-text-wrap">
						<?php $this->render_title(); ?>
						<?php $this->render_meta(); ?>
						<?php $this->render_excerpt(); ?>
						<?php $this->render_readmore(); ?>
					</div>
				</div>						   
				<?php
			}
			?>
			</div>
			<?php
			endwhile;
			wp_reset_postdata();
		endif;
	}


	protected function render_card_category_badge() {
		$settings = $this->get_settings();
		$tax = !empty($settings['royal_control_taxonomy']) ? $settings['royal_control_taxonomy'] : 'category';
		$terms = get_the_terms( get_the_ID(), $tax );
		if ( !empty($terms) && !is_wp_error($terms) ) {
			echo '<span class="royal-category-badge">' . esc_html($terms[0]->name) . '</span>';
		}
	}


	protected function render_thumbnail() {
		$settings       = $this->get_settings();
		$show_image     = $settings['show_image'];
		$default_image  = $settings['show_default_image'];
		$image_size     = $settings['default_image_size'];
		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( 'yes' !== $show_image ) {
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
			<div class="post-grid-thumbnail">
				<a href="<?php echo $permalink; ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<?php the_post_thumbnail( $post_thumbnail_size, array( 'alt' => esc_attr( $alt_text ) ) ); ?>
				</a>
			</div>
		<?php
		} elseif ( 'yes' === $default_image ) {
			?>
			<div class="post-grid-thumbnail">
				<a href="<?php echo $permalink; ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<img width="<?php echo esc_attr( $image_size ); ?>" height="<?php echo esc_attr( $image_size ); ?>"
						src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/images/noimage.png'; ?>"
						alt="<?php echo esc_attr( $post_title ); ?>" />
				</a>
			</div>
		<?php
		}
	}



	protected function render_title() {
		$settings = $this->get_settings();
		$show_title = $settings['show_title'];

		if ( 'yes' !== $show_title ) {
			return;
		}

		$title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h3';

		global $post;
		$live_portfolio 	= get_post_meta($post->ID, "live_portfolio", true);
		$portfolio_live_url = get_post_meta($post->ID, "portfolio_live_url", true);

		if (($live_portfolio === "yes" || $live_portfolio == 1) && !empty($portfolio_live_url) ){
			$permalink = $portfolio_live_url;
			$target =	"_blank";
		}else{
			$permalink = get_the_permalink();
			$target =	"_self";
		}; 

		echo '<'. $title_tag .' class="title">';
			echo '<a href="' . esc_url($permalink) . '" target="'.$target.'">'. get_the_title() .'</a>';
		echo '</'. $title_tag. '>';
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
			if ( in_array( 'author', $meta_data ) ) { ?>
				<span class="post-author">
					<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
					<?php the_author_posts_link(); ?>
				</span>
				<?php
			}

			if ( in_array( 'date', $meta_data ) ) {
				$dt = get_date_from_gmt(get_the_date('Y-m-d H:i:s'), 'Y-m-d H:i:s');
				?>				
				<span class="post-date">
					<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
					<a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($dt))); ?></a>
				</span>
				<?php
			}

			if ( in_array( 'categories', $meta_data ) ) {
				$tax = !empty($settings['royal_control_taxonomy']) ? $settings['royal_control_taxonomy'] : 'category';
				$categories_list = get_the_term_list( get_the_ID(), $tax, '', esc_html__( ', ', 'royal-addons-for-elementor' ) );
				if ( !empty($categories_list) && !is_wp_error($categories_list) ) {
				    printf( '<span class="post-categories"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg> %s</span>', $categories_list ); // WPCS: XSS OK.
				}
			}

			if ( in_array( 'comments', $meta_data ) ) { ?>
				<span class="post-comments">
					<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
					<a href="<?php comments_link(); ?>"><?php comments_number(); ?></a>
				</span>
				<?php
			}
			?>
		</div>
		<?php
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
		$read_more_text = !empty($settings['read_more_text']) ? $settings['read_more_text'] : __( 'Read More', 'royal-addons-for-elementor' );
		if ( 'yes' !== $show_read_more ) {
			return;
		}
		$target = !empty($settings['royal_post_grid_show_read_more_btn_new_tab']) && 'yes' === $settings['royal_post_grid_show_read_more_btn_new_tab'] ? '_blank' : '_self';
		?>
		<a class="read-more-btn" href="<?php the_permalink(); ?>" target="<?php echo esc_attr($target); ?>">
			<span><?php echo esc_html( $read_more_text ); ?></span>
			<svg class="read-more-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
		</a>
		<?php
	}








}