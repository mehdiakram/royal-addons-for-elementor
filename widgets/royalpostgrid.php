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
class RoyalPostGrid extends Widget_Base {

	public function get_name() {
		return 'royalpostgrid';
	}

	public function get_title() {
		return __( 'Post Grid', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-post-list rtbranding'; }


	public function get_keywords() {
		return ['post', 'grid', 'list', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = [ 'royalowlcarousel', 'royalowlcarouseltheme', 'royalpost', 'royalcarousel'];
		return $styles;
	}


	public function get_script_depends() {
		$scripts = ['royalowlcarousel', 'royalcarousel'];
		return $scripts;
	}


	protected function register_controls() {

		$this->rt_content_layout_options();
		$this->rt_content_query_options();
		$this->rt_carousel_options();

		$this->rt_style_layout_options();
		$this->rt_style_box_options();
		$this->rt_style_image_options();

		$this->rt_style_title_options();
		$this->rt_style_meta_options();
		$this->rt_style_content_options();
		$this->rt_style_readmore_options();
		$this->rt_style_categories();
	}


	private function rt_content_layout_options() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'enable_carousel',
			[
				'label'        => __( 'Enable Carousel', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'grid_style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'gridstyle1',
				'options' => [
					'gridstyle1' => esc_html__( 'Layout 1', 'royal-addons-for-elementor' ),
					'gridstyle2' => esc_html__( 'Layout 2 Right Image', 'royal-addons-for-elementor' ),
					'gridstyle3' => esc_html__( 'Layout 3 Left Image', 'royal-addons-for-elementor' ),
					'gridstyle4' => esc_html__( 'Layout 4', 'royal-addons-for-elementor' ),
					'gridstyle5' => esc_html__( 'Layout 5', 'royal-addons-for-elementor' ),
					'gridstyle6' => esc_html__( 'Layout 6', 'royal-addons-for-elementor' ),
					'gridstyle7' => esc_html__( 'Layout 7 Left Image', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
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

		$this->add_control(
			'show_default_image',
			[
				'label' => __( 'Default Image', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
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
			'meta_data',
			[
				'label' => __( 'Meta Data', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => [ 'date', 'comments' ],
				'multiple' => true,
				'options' => [
					'author' => __( 'Author', 'royal-addons-for-elementor' ),
					'date' => __( 'Date', 'royal-addons-for-elementor' ),
					'categories' => __( 'Categories', 'royal-addons-for-elementor' ),
					'comments' => __( 'Comments', 'royal-addons-for-elementor' ),
				],
				'separator' => 'before',
				'condition' => [
					'grid_style!' => ['gridstyle4'],
				],
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
					'grid_style!' => ['gridstyle4'],
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
				'condition' => [
					'grid_style!' => ['gridstyle4'],
				],
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
					'grid_style!' => ['gridstyle4'],
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
					'grid_style!' => ['gridstyle4'],
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
					'grid_style!' => ['gridstyle4'],
				],
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More', 'royal-addons-for-elementor' ),
				'condition' => [
					'show_read_more' => 'yes',
					'grid_style!' => ['gridstyle4'],
				],
			]
		);

		$this->add_control(
			'permalink',
			[
				'label' => __( 'Permalink', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'royal-addons-for-elementor' ),
					'external' => __( 'External', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'show_read_more' => 'yes',
					'grid_style!' => ['gridstyle4'],
				],
			]
		);

		$this->add_control(
			'read_more_icon',
			[
				'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'show_read_more' => 'yes',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-right',
						'angle-right',
						'caret-square-right',
						'angle-right',
						'angle-double-right',
						'hand-point-right',
					],
					'fa-regular' => [
						'arrow-alt-circle-right',
					],
				],
			]
		);

		$this->add_control(
			'show_categories',
			[
				'label' => __( 'Show Categories', 'royal-addons-for-elementor' ),
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
			'post_categories',
			[
				'label'       => __( 'Categories', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => Royal_Helpers::royal_categories( 'post' ),

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


	private function rt_carousel_options() {
        $this->start_controls_section(
            'common_settings',
            [
                'label' => __( 'Common Settings', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'previousicon',
			[
				'label' => esc_html__( 'Previous Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-left',
					'library' => 'solid',
				],
			]
		);
		$this->add_control(
			'nexticon',
			[
				'label' => esc_html__( 'Next Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'solid',
				],
			]
		);        
        
        $this->add_control(
            'autoplay',
            [
                'label' => __( 'Auto Play', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => true,
                'default' => true,
            ]
        );
        
        $this->add_control(
            'loop',
            [
                'label' => __( 'Loop', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => true,
                'default' => true,
            ]
        );

        $this->add_control(
            'margin',
            [
                'label' => __( 'Carousel Margin', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
            ]
        );


        $this->add_control(
            'timeout',
            [
                'label' => __( 'Autoplay Timeout (ms)', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2500,
            ]
        );

		$this->add_control(
			'desktop_options',
			[
				'label' => esc_html__( 'Desktop', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
            'desktop_settings',
            [
                'label' => __( 'Desktop Settings', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'desktopitems',
            [
                'label' => __( 'Items', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
				'max' => 10,
				'step' => 1,                
                'default' => 5,
            ]
        );

        //Dots
        $this->add_control(
            'desktopdots',
            [
                'label' => __( 'Dots', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

        //Navs
        $this->add_control(
            'desktopnav',
            [
                'label' => __( 'Navigation', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tab_settings',
            [
                'label' => __( 'Tablet Settings', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'tab_options',
			[
				'label' => esc_html__( 'Tablet', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'tabitems',
            [
                'label' => __('Items', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
				'max' => 6,
				'step' => 1,
                'default' => 3,
            ]
        );
        //Dots
        $this->add_control(
            'tabdots',
            [
                'label' => __( 'Dots', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

        //Navs
        $this->add_control(
            'tabnav',
            [
                'label' => __( 'Navigation', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mobile_settings',
            [
                'label' => __( 'Mobile Settings', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'mobile_options',
			[
				'label' => esc_html__( 'Mobile', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
            'mobileitems',
            [
                'label' => __('Items', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
				'max' => 3,
				'step' => 1,                
                'default' => 1,
            ]
        );
        //Dots
        $this->add_control(
            'mobiledots',
            [
                'label' => __( 'Dots', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
            ]
        );

        //Navs
        $this->add_control(
            'mobilenav',
            [
                'label' => __( 'Navigation', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
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


	private function rt_style_image_options() {

		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'grid_image_width',
			[
				'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'condition' => [
					'grid_style' => ['gridstyle7'],
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer article .post-grid-thumbnail' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'minimum_image_height',
			[
				'label' => esc_html__( 'Minimum Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer .post-grid-thumbnail img' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'default_image_size',
			[
				'label' => esc_html__( 'Default Image Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 50,
				'max' => 500,
				'step' => 1,
				'default' => 150,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'full',
				'prefix_class' => 'post-thumbnail-size-',
			]
		);

		$this->add_control(
			'grid_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer .post-grid-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => ['classic', 'gradient'],
				'fields_options' => [
					'background' => [
						'label' => esc_html__('Overlay Background', 'royal-addons-for-elementor'),
					],
				],
				'selector' => '{{WRAPPER}} .royalgridcontainer article .post-grid-thumbnail:before',
			]
		);


		$this->start_controls_tabs(
			'style_image_tabs'
		);

		$this->start_controls_tab(
			'style_image_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_normal',
				'selector' => '{{WRAPPER}} .royalgridcontainer .post-grid-thumbnail img',
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_image_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border_hover',
				'selector' => '{{WRAPPER}} .royalgridcontainer article:hover .post-grid-thumbnail img',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'backgroundhover',
				'types' => ['classic', 'gradient'],
				'fields_options' => [
					'background' => [
						'label' => esc_html__('Hover Background', 'royal-addons-for-elementor'),
						'default' => 'classic',
					],
					'color' => [
						'default' => '#ffffff00',
					],
				],
				'selector' => '{{WRAPPER}} .royalgridcontainer article:hover .post-grid-thumbnail:before',
			]
		);

		$this->add_control(
			'grid_style_image_zoom',
			[
				'label' => esc_html__( 'Hover Zoom', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => .01,
						'max' => 2,
						'step' => .01,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1.1,
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer article:hover .post-grid-thumbnail img' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

	}


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
				'label'      => __( 'Title Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalgridcontainer article .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	private function rt_style_meta_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_meta_style',
			[
				'label'     => __( 'Meta', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'grid_style!' => ['gridstyle4'],
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

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'meta_background',
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalgridcontainer .royalpost .post-grid-meta',
			]
		);
		
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


	private function rt_style_readmore_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_readmore_style',
			[
				'label' => __( 'Read More', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
					'grid_style!' => ['gridstyle4'],
				],
			]
		);

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


	private function rt_style_categories() {
		$this->start_controls_section(
			'section_categories_style',
			[
				'label' => __( 'Categories', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_categories' => 'yes',
				],
			]
		);

		$this->add_control(
			'categories_margin',
			[
				'label' => esc_html__( 'Categories Margin', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 15,
					'bottom' => 10,
					'left' => 15,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer article .grid-post-categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'categories_gap',
			[
				'label'     => esc_html__( 'Gap', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .royalgridcontainer article .grid-post-categories' => 'gap: {{SIZE}}{{UNIT}}',
				),
			]
		);

		$this->add_control(
			'category_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer article .grid-post-categories a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'category_typography',
				'label' => esc_html__( 'Category Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .royalgridcontainer article .grid-post-categories a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'category_background',
				'label' => esc_html__( 'Category Background', 'royal-addons-for-elementor' ),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalgridcontainer article .grid-post-categories a',
			]
		);

		$this->add_control(
			'category_border_radius',
			[
				'label' => esc_html__( 'Category Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer article .grid-post-categories a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'category_padding',
			[
				'label' => esc_html__( 'Category Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 15,
					'bottom' => 10,
					'left' => 15,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalgridcontainer article .grid-post-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
		$settings 		= $this->get_settings();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $enable_carousel = isset( $settings['enable_carousel'] ) ? $settings['enable_carousel'] : '';
        $loop           = $settings['loop'];
        $autoplay       = $settings['autoplay'];
        $margin         = $settings['margin'];
        $timeout        = $settings['timeout'];

        // Build nav icon HTML
        $previous_icon_html = '';
        $next_icon_html     = '';
        if ( isset( $settings['previousicon']['value'] ) && ! empty( $settings['previousicon']['library'] ) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon( $settings['previousicon'], [ 'aria-hidden' => 'true' ] );
            $previous_icon_html = ob_get_clean();
        }
        if ( isset( $settings['nexticon']['value'] ) && ! empty( $settings['nexticon']['library'] ) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon( $settings['nexticon'], [ 'aria-hidden' => 'true' ] );
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

        // Build carousel render attributes
        $this->add_render_attribute(
            'royal_carousel_options',
            [
                'id'                    => $carouselid,
                'data-loop'             => $loop,
                'data-autoplay'         => $autoplay,
                'data-margin'           => $margin,
                'data-timeout'          => $timeout,
                'data-navtext'          => $navtext,

                'data-desktopitems'     => $desktopitems,
                'data-desktopdots'      => $desktopdots,
                'data-desktopnav'       => $desktopnav,

                'data-tabitems'         => $tabitems,
                'data-tabdots'          => $tabdots,
                'data-tabnav'           => $tabnav,

                'data-mobileitems'      => $mobileitems,
                'data-mobiledots'       => $mobiledots,
                'data-mobilenav'        => $mobilenav,
            ]
        );

		$columns_desktop = ( ! empty( $settings['columns'] ) ? 'royalgrid-desktop-' . $settings['columns'] : 'royalgrid-desktop-3' );
		$columns_tablet = ( ! empty( $settings['columns_tablet'] ) ? ' royalgrid-tablet-' . $settings['columns_tablet'] : ' royalgrid-tablet-2' );
		$columns_mobile = ( ! empty( $settings['columns_mobile'] ) ? ' royalgrid-mobile-' . $settings['columns_mobile'] : ' royalgrid-mobile-1' );
		$grid_style = $settings['grid_style'];
		$styleclass = ' '.$grid_style;
		?>

        <?php if ( 'yes' === $enable_carousel ) : ?>
        <div class="royalmastercarousel royalpostgrid-carousel">
            <div class="royalcarousel owl-carousel owl-theme" <?php echo $this->get_render_attribute_string( 'royal_carousel_options' ); ?>>
        <?php else : ?>
        <div class="royalgridcontainer elementor-grid <?php echo $columns_desktop.$columns_tablet.$columns_mobile.$styleclass; ?>">
        <?php endif; ?>

				<?php

				$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );

				$cats = is_array( $settings['post_categories'] ) ? implode( ',', $settings['post_categories'] ) : $settings['post_categories'];

		        $query_args = array(
					        	'posts_per_page' 		=> absint( $posts_per_page ),
					        	'no_found_rows'  		=> true,
					        	'post_status'         	=> 'publish',
					        	'ignore_sticky_posts'   => true,
					        	'category_name' 		=> $cats
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

        	// In carousel mode, wrap each post in an owl-carousel item div
        	$item_open  = ( 'yes' === $enable_carousel ) ? '<div class="item">' : '';
        	$item_close = ( 'yes' === $enable_carousel ) ? '</div>' : '';

        	if($grid_style == 'gridstyle1'){
				while ( $all_posts->have_posts() ) :
					$all_posts->the_post();
					echo $item_open; ?>						
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>								
									<?php $this->render_thumbnail(); ?>						
									<div class="post-grid-text-wrap">
										<?php $this->render_title(); ?>
										<?php $this->render_categories(); ?>
										<?php $this->render_meta(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>													   
								</article>
								<?php echo $item_close; ?>
								<?php						
						endwhile;
						wp_reset_postdata();
						
		        		
		        	} elseif($grid_style == 'gridstyle2' ){			
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); 
							echo $item_open; ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>
									<div class="post-grid-text-wrap">
										<?php $this->render_categories(); ?>
										<?php $this->render_meta(); ?>
										<?php $this->render_title(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>
									<?php $this->render_thumbnail(); ?>
								</article>
								<?php echo $item_close; ?>
								<?php
						endwhile; 
						wp_reset_postdata();


		        	} elseif($grid_style == 'gridstyle3' ){	
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); 
							echo $item_open; ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>
									<?php $this->render_thumbnail(); ?>
									<div class="post-grid-text-wrap">
										<?php $this->render_categories(); ?>
										<?php $this->render_meta(); ?>
										<?php $this->render_title(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>       
								</article>
								<?php echo $item_close; ?>
								<?php
						endwhile; 
						wp_reset_postdata();	
						
						
		        	} elseif($grid_style == 'gridstyle4' ){	
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); 
							echo $item_open; ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>
									<?php $this->render_thumbnail(); ?>
									<div class="post-grid-text-wrap">
										<?php $this->render_categories(); ?>
										<?php $this->render_title(); ?>
									</div>
								</article>
								<?php echo $item_close; ?>
								<?php
						endwhile; 
						wp_reset_postdata();


		        	} elseif($grid_style == 'gridstyle5' ){	
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); 
							echo $item_open; ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>
									<?php $this->render_thumbnail(); ?>
									<div class="post-grid-text-wrap">
										<?php $this->render_title(); ?>
										<div class="blogcontent">
										<?php $this->render_excerpt(); ?>
										<div class="metacat">
											<?php $this->render_meta(); ?>
											<?php $this->render_categories(); ?>
										</div>
										</div>
									</div>
								</article>
								<?php echo $item_close; ?>
								<?php
						endwhile; 
						wp_reset_postdata();			
						

		        	} elseif($grid_style == 'gridstyle6' ){	
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); 
							echo $item_open; ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>
									<div class="thumbmeta">
										<?php $this->render_thumbnail(); ?>
										<?php $this->render_meta(); ?>
									</div>
									<div class="post-grid-text-wrap">
										<?php $this->render_title(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_categories(); ?>
									</div>
								</article>
								<?php echo $item_close; ?>
								<?php
						endwhile;
						wp_reset_postdata();	

		        	} elseif($grid_style == 'gridstyle7' ){	
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); 
							echo $item_open; ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>
									<div class="thumbmeta">
										<?php $this->render_thumbnail(); ?>
										
									</div>
									<div class="post-grid-text-wrap">
										<?php $this->render_meta(); ?>
										<?php $this->render_title(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_categories(); ?>
									</div>
								</article>
								<?php echo $item_close; ?>
								<?php
						endwhile;
						wp_reset_postdata();	

		        	}else{
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); 
							echo $item_open; ?>						
								<article id="post-<?php the_ID(); ?>" <?php post_class('royalpost'); ?>>								 									
									<?php $this->render_thumbnail(); ?>
									<div class="post-grid-text-wrap">
										<?php $this->render_title(); ?>
										<?php $this->render_categories(); ?>
										<?php $this->render_meta(); ?>
										<?php $this->render_excerpt(); ?>
										<?php $this->render_readmore(); ?>
									</div>						   
								</article>						
								<?php echo $item_close; ?>
								<?php						
						endwhile; 						
						wp_reset_postdata();

		        	}

		        endif; ?>
			</div>
            <?php if ( 'yes' === $enable_carousel ) : ?>
            </div>
            <?php endif; ?>
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


	protected function render_thumbnail() {
		$settings       = $this->get_settings();
		$show_image     = $settings['show_image'];
		$default_image  = $settings['show_default_image'];
		$image_size     = $settings['default_image_size'];
		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( 'yes' !== $show_image ) {
			return;
		}

		$permalink = esc_url( $this->render_permalink() );
		$target = esc_attr( $this->render_permalink_target() );
		$post_title = get_the_title();

		if ( has_post_thumbnail() ) { ?>
			<div class="post-grid-thumbnail">
				<a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<?php
					$alt_text = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					if ( empty( $alt_text ) ) {
						$alt_text = $post_title;
					}
					the_post_thumbnail( $post_thumbnail_size, array(
						'alt'   => esc_attr( $alt_text ),
					) );
					?>
				</a>
			</div>
		<?php } elseif ( 'yes' === $default_image ) { ?>
			<div class="post-grid-thumbnail">
				<a href="<?php echo $permalink; ?>" target="<?php echo $target; ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<img width="<?php echo esc_attr( $image_size ); ?>" height="<?php echo esc_attr( $image_size ); ?>"
						src="<?php echo plugin_dir_url( __DIR__ ) . 'assets/images/noimage.png'; ?>"
						alt="<?php echo esc_attr( $post_title ); ?>" loading="lazy" />
				</a>
			</div>
		<?php }
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
			<a href="<?php echo esc_url( $this->render_permalink() ); ?>" target="<?php echo esc_attr( $this->render_permalink_target() ); ?>"><?php the_title(); ?></a>
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
			if ( in_array( 'author', $meta_data ) ) { ?>

				<span class="post-author"><?php the_author(); ?></span>

				<?php
			}

			if ( in_array( 'date', $meta_data ) ) {
				
				$dt = get_date_from_gmt(get_the_date(), 'Y-m-d H:i:s');
				?>				
				<span class="post-author"><?php echo date_i18n(get_option('date_format'), strtotime($dt)); ?></span>

				<?php
			}

			if ( in_array( 'categories', $meta_data ) ) {

				$categories_list = get_the_category_list( esc_html__( ', ', 'royal-addons-for-elementor' ) );

				if ( $categories_list ) {
				    printf( '<span class="post-categories">%s</span>', $categories_list ); // WPCS: XSS OK.
				}

			}

			if ( in_array( 'comments', $meta_data ) ) { ?>

				<span class="post-comments"><?php comments_number(); ?></span>

				<?php
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
		$settings 			= $this->get_settings();
		$show_read_more 	= $settings['show_read_more'];
		$read_more_text 	= $settings['read_more_text'];
		$read_more_icon 	= $settings['read_more_icon']['value'];
		if (!empty( $read_more_icon ) ) {
			$readmoreiconvalue 	= ' <i class="'.$read_more_icon.'"></i>';
		} else{
			$readmoreiconvalue 	= '';
		}
		
		if ( 'yes' !== $show_read_more ) {
			return;
		}
		?>
		
		<a class="read-more-btn" href="<?php echo esc_url( $this->render_permalink() ); ?>" target="<?php echo esc_attr( $this->render_permalink_target() ); ?>"><?php echo $read_more_text . $readmoreiconvalue; ?></a>
		<?php
	}


	protected function render_categories() {
		$settings 			= $this->get_settings();
		$show_categories 	= $settings['show_categories'];
		
		if ( 'yes' !== $show_categories ) {
			return;
		}

		echo '<div class="grid-post-categories">';
		foreach((get_the_category()) as $category){
			echo '<a href="'. esc_url( get_category_link( $category->term_id ) ).'">'. $category->name. '</a>';
		}
		echo '</div>';
	}

	protected function render_permalink() {
		$settings  = $this->get_settings_for_display();
		$permalink = isset( $settings['permalink'] ) ? $settings['permalink'] : 'default';

		if ( 'external' === $permalink ) {
			$external_link = get_post_meta( get_the_ID(), '_external_link', true );
			if ( ! empty( $external_link ) ) {
				return esc_url( $external_link );
			} else {
				return get_permalink(); // fallback
			}
		}

		// default or anything else
		return get_permalink();
	}

	protected function render_permalink_target() {
		$settings  = $this->get_settings_for_display();
		$permalink = isset( $settings['permalink'] ) ? $settings['permalink'] : 'default';

		if ( 'external' === $permalink ) {
			$external_link = get_post_meta( get_the_ID(), '_external_link', true );
			if ( ! empty( $external_link ) ) {
				return '_blank';
			}
		}

		return '_self'; // default
	}








}