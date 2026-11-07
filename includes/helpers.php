<?php
namespace RoyalAddons\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;
use Elementor\Icons_Manager;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {exit;}

class Royal_Helpers {

    public static function royal_get_pro_widgets() {
        $widgets = include ROYAL_ADDONS_DIR_PATH . 'admin/royalwidgetslist.php';

        if (isset($widgets['pro']) && is_array($widgets['pro'])) {
            return array_keys($widgets['pro']);
        }

        return [];
    }


    
    public static function royal_title_tags() {
        return [
            'h1'   => esc_html__( 'H1', 'royal-addons-for-elementor' ),
            'h2'   => esc_html__( 'H2', 'royal-addons-for-elementor' ),
            'h3'   => esc_html__( 'H3', 'royal-addons-for-elementor' ),
            'h4'   => esc_html__( 'H4', 'royal-addons-for-elementor' ),
            'h5'   => esc_html__( 'H5', 'royal-addons-for-elementor' ),
            'h6'   => esc_html__( 'H6', 'royal-addons-for-elementor' ),
            'div'  => esc_html__( 'div', 'royal-addons-for-elementor' ),
            'span' => esc_html__( 'span', 'royal-addons-for-elementor' ),
            'p'    => esc_html__( 'p', 'royal-addons-for-elementor' ),
        ];
    }

    public static function royal_elementor_templates() {
        $templates = get_posts(array(
            'post_type'      => 'elementor_library', // Elementor templates are stored under this post type
            'posts_per_page' => -1,                  // Retrieve all templates
            'post_status'    => 'publish',           // Only published templates
            'orderby'        => 'title',             // Order by title
            'order'          => 'ASC',               // Ascending order
            'suppress_filters' => false,             // Allow filters to be applied
        ));

        // Initialize with a default "Select" option for dropdowns
        $result = array( '' => esc_html__('-- Select --', 'royal-addons-for-elementor'));

        if (!empty($templates) && !is_wp_error($templates)) {
            foreach ($templates as $item) {
                $result[$item->ID] = $item->post_title;
            }
        }

        return $result;
    }



    public static function royal_theme_sidebars() {
        global $wp_registered_sidebars; // Access the global variable containing registered sidebars

        $sidebars = array(); // Initialize an empty array to store sidebar data

        // Check if any sidebars are registered
        if (empty($wp_registered_sidebars)) {
            // If no sidebars are found, add a specific message
            $sidebars['0'] = esc_html__('No sidebars were found', 'royal-addons-for-elementor');
        } else {
            // If sidebars are found, add a default "Select" option
            $sidebars['0'] = esc_html__('-- Select --', 'royal-addons-for-elementor');

            // Loop through each registered sidebar
            foreach ($wp_registered_sidebars as $id => $sidebar) {
                // Add the sidebar's ID as the key and its name as the value
                $sidebars[$id] = $sidebar['name'];
            }
        }

        return $sidebars; // Return the compiled list of sidebars
    }






        
    public static function royal_categories( $post_type = 'post' ) {
        $options = [];

        $taxonomies = get_object_taxonomies( $post_type, 'objects' );

        $category_tax = null;
        foreach ( $taxonomies as $taxonomy ) {
            if ( $taxonomy->hierarchical ) {
                $category_tax = $taxonomy->name;
                break;
            }
        }

        if ( $category_tax ) {
            $terms = get_terms(
                [
                    'taxonomy'   => $category_tax,
                    'hide_empty' => false,
                ]
            );

            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                foreach ( $terms as $term ) {
                    $options[ $term->slug ] = $term->name;
                }
            }
        }

        return $options;
    }


    public static function royal_image_options($widget, $condition = []) {
    
        $section_args = [
            'label' => __( 'Image Options', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ];


        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'section_image_settings', $section_args );

        $widget->add_control(
            'carousel',
            [
                'label' => esc_html__( 'Add Images', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::GALLERY,
                'default' => [],
                'show_label' => false,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );			

        $widget->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'exclude' => [ 'custom' ],
                'default' => 'large',
            ]
        );            
        $widget->end_controls_section();
    }



    public static function royal_carousel_options($widget, $condition = []) {

        $section_args = [
            'label' => __( 'Carousel Settings', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ];

        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'section_carousel_settings', $section_args );


        $widget->add_control(
			'navposition',
			[
				'label'    => __( 'Navigation Position', 'royal-addons-for-elementor' ),
				'type'     => Controls_Manager::SELECT,
                'options' => [
                    'royalcarouselnavboth' 		=> 'Both Side',
                    'royalcarouselnavbothlast'	=> 'Both Side Last',
                    'royalcarouselnavoutside'	=> 'Both Outside',
                    'royalcarouselnavbottomcenter'	=> 'Bottom Center',	
                    'royalcarouselnavcenter2' 	=> 'Bottom Center 2',
                    'royalcarouselnavleft' 		=> 'Bottom Left',
                    'royalcarouselnavright' 	=> 'Bottom Right',
                    'royalcarouselnavtopright' 	=> 'Top Right',
				],
				'default'  => 'royalcarouselnavbottomcenter',
				'conditions' => [
					'relation' => 'or',
					'terms'    => [
						[ 'name' => 'desktopnav', 'operator' => '==', 'value' => 'yes' ],
						[ 'name' => 'tabnav', 'operator' => '==', 'value' => 'yes' ],
						[ 'name' => 'mobilenav', 'operator' => '==', 'value' => 'yes' ],
					],
				],
			]
		);

        $widget->add_control(
            'previousicon',
            [
                'label' => esc_html__( 'Nav Previous Icon', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-left',
                    'library' => 'fa-solid',
                ],
                'conditions' => [
                'relation' => 'or',
                'terms'    => [
                    [ 'name' => 'desktopnav', 'operator' => '==', 'value' => 'yes' ],
                    [ 'name' => 'tabnav', 'operator' => '==', 'value' => 'yes' ],
                    [ 'name' => 'mobilenav', 'operator' => '==', 'value' => 'yes' ],
                ],
            ],
            ]
        );

        $widget->add_control(
            'nexticon',
            [
                'label' => esc_html__( 'Nav Next Icon', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ],
                'conditions' => [
                'relation' => 'or',
                'terms'    => [
                    [ 'name' => 'desktopnav', 'operator' => '==', 'value' => 'yes' ],
                    [ 'name' => 'tabnav', 'operator' => '==', 'value' => 'yes' ],
                    [ 'name' => 'mobilenav', 'operator' => '==', 'value' => 'yes' ],
                ],
            ],
            ]
        );        
        
        $widget->add_control(
            'dotposition',
            [
                'label' => __( 'Dot Position', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' 								=> 'Bottom Center',
                    'royalcarouseldotleft' 			=> 'Bottom Left',
                    'royalcarouseldotright'			=> 'Bottom Right',
                    'royalcarouseldotinsidecenter'	=> 'Bottom Inside Center',
				],
                'default' => '',
                'conditions' => [
                'relation' => 'or',
                'terms'    => [
                    [ 'name' => 'desktopnav', 'operator' => '==', 'value' => 'yes' ],
                    [ 'name' => 'tabnav', 'operator' => '==', 'value' => 'yes' ],
                    [ 'name' => 'mobilenav', 'operator' => '==', 'value' => 'yes' ],
                ],
            ],
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
            'animate_in',
            [
                'label' => __( 'Transition In', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => RoyalClass::royal_animation_in(),
                'default' => 'none',
                'description' => __( 'Works only when showing 1 item per slide.', 'royal-addons-for-elementor' ),
            ]
        );

        $widget->add_control(
            'animate_out',
            [
                'label' => __( 'Transition Out', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => RoyalClass::royal_animation_out(),
                'default' => 'none',
                'description' => __( 'Works only when showing 1 item per slide.', 'royal-addons-for-elementor' ),
            ]
        );
        
        $widget->add_control(
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

        $widget->add_control(
            'margin',
            [
                'label' => __( 'Carousel Margin', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 10,
            ]
        );


        $widget->add_control(
            'timeout',
            [
                'label' => __( 'Autoplay Timeout (ms)', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 2500,
            ]
        );

        $widget->end_controls_section();


        $section_args = [
            'label' => __( 'Desktop Settings', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ];

        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'desktop_settings', $section_args );

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->end_controls_section();


        $section_args = [
            'label' => __( 'Tablet Settings', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ];


        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'tablet_settings', $section_args );

        $widget->add_control(
            'tab_options',
            [
                'label' => esc_html__( 'Tablet', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->end_controls_section();


        $section_args = [
            'label' => __( 'Mobile Settings', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ];

        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'mobile_settings', $section_args );


        $widget->add_control(
            'mobile_options',
            [
                'label' => esc_html__( 'Mobile', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_control(
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
        $widget->end_controls_section();
    }


	public static function royal_style_nav_options($widget, $condition = []) {

        $section_args = [
            'label' => __( 'Navigation Style', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'desktopnav',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'tabnav',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'mobilenav',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                    ],
                ],
        ];

        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'section_style_nav', $section_args );

		$widget->add_control(
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
					'{{WRAPPER}} .royalmastercarousel .owl-nav button' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royalcarouselnavoutside.owl-carousel .owl-nav button.owl-prev' => 'left: calc({{SIZE}}{{UNIT}} * -1);',
					'{{WRAPPER}} .royalcarouselnavoutside.owl-carousel .owl-nav button.owl-next' => 'right: calc({{SIZE}}{{UNIT}} * -1);',
				],
			]
		);

		$widget->add_control(
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
					'{{WRAPPER}} .royalmastercarousel .owl-nav button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$widget->add_control(
			'nav_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Color', 'royal-addons-for-elementor' ),
				'default'	=> '#869791',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'nav_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Color Hover', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);	
		
		$widget->add_control(
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
					'{{WRAPPER}} .royalmastercarousel .owl-nav button' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$widget->add_control(
			'nav_background',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Background', 'royal-addons-for-elementor' ),
				'default'	=> '#ffffff00',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button' => 'background-color: {{VALUE}}!important;',
				],
			]
		);

		$widget->add_control(
			'nav_background_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Background Hover', 'royal-addons-for-elementor' ),
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-nav button:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);	
		

		$widget->add_control(
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

		$widget->add_control(
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
	

		$widget->end_controls_section();
	}


	public static function royal_style_dot_options($widget, $condition = []) {

        $section_args = [
            'label' => __( 'Dot Style', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'desktopdots',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'tabdots',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'mobiledots',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                    ],
                ],
        ];


        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'section_style_dot', $section_args );
    	
		$widget->add_control(
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

		$widget->add_control(
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

		$widget->add_control(
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

		$widget->add_control(
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

    $widget->end_controls_section();
}



    public static function royal_style_image_options($widget, $condition = []) {
         $section_args = [
            'label' => __( 'Image Style', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ];


        if ( ! empty( $condition ) ) {
         $section_args['condition'] = $condition;
        }

        $widget->start_controls_section( 'section_style_image', $section_args );


        $widget->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item img',
			]
		);

        $widget->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],				
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $widget->add_control(
			'image_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $widget->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item img',
			]
		);

        $widget->end_controls_section();
    }




    /* Royal Ajax search */

    public static function royal_ajax_search_function() {

        $search = sanitize_text_field(wp_unslash($_POST['search']));
        $post_type = sanitize_text_field(wp_unslash($_POST['post_type']));
        $args = array(
            's' => $search,
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => 5,
        );
        $query = new WP_Query($args);
        $output = '';

        // Icons
        if (is_RTL()) {
            $icon = 'left';
        } else {
            $icon = 'right';
        }

        if ($query->have_posts()) {

            $output .= '<ul>';

            while ($query->have_posts()) : $query->the_post();
                $output .= '<li>';
                $output .= '<a href="' . get_permalink() . '" class="search-result-link clr">';

                if (has_post_thumbnail()) {
                    $output .= get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('alt' => get_the_title(), 'itemprop' => 'image',));
                }

                $output .= '<div class="result-title">' . get_the_title() . '</div>';
                $output .= '<i class="icon fa fa-arrow-' . $icon . '" aria-hidden="true"></i>';
                $output .= '</a>';
                $output .= '</li>';
            endwhile;

            if ($query->found_posts > 1) {
                $search_link = get_search_link($search);

                /* if(strpos($search_link, '?') !== false) {
                  $search_link .= '?post_type='. $post_type;
                  } */

                $output .= '<li><a href="' . $search_link . '" class="all-results"><span>' . sprintf(esc_html__('View all %d results', 'etww'), $query->found_posts) . '<i class="fa fa-long-arrow-' . $icon . '" aria-hidden="true"></i></span></a></li>';
            }

            $output .= '</ul>';
        } else {

            $output .= '<div class="royal-no-search-results">';
            $output .= '<h6>' . esc_html__('No results', 'royal-addons-for-elementor') . '</h6>';
            $output .= '<p>' . esc_html__('No search results could be found, please try another search.', 'royal-addons-for-elementor') . '</p>';
            $output .= '</div>';
        }

        wp_reset_query();

        echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        die();
    }


    /* Hook a class for first word */
    public static function royal_first_word( $string ){
        $words = explode( ' ', $string );
        $html = '<span class="frist-word">' . $words[0] . '</span> ' . implode( " ", array_slice( $words, 1 ) );
        return $html;
    }



    public static function royal_taxonomies() {
        $taxonomies = get_taxonomies( [ 'show_in_nav_menus' => true ], 'objects' );
        $options = [ '' => '' ];
        foreach ( $taxonomies as $taxonomy ) {
            $options[ $taxonomy->name ] = $taxonomy->label;
        }
        return $options;
    }


    // Blend Type
    public static function royal_blend_options(){
        $blend_options = [
            'multiply'    => esc_html__( 'Multiply', 'royal-addons-for-elementor' ),
            'screen'      => esc_html__( 'Screen', 'royal-addons-for-elementor' ),
            'overlay'     => esc_html__( 'Overlay', 'royal-addons-for-elementor' ),
            'darken'      => esc_html__( 'Darken', 'royal-addons-for-elementor' ),
            'lighten'     => esc_html__( 'Lighten', 'royal-addons-for-elementor' ),
            'color-dodge' => esc_html__( 'Color-Dodge', 'royal-addons-for-elementor' ),
            'color-burn'  => esc_html__( 'Color-Burn', 'royal-addons-for-elementor' ),
            'hard-light'  => esc_html__( 'Hard-Light', 'royal-addons-for-elementor' ),
            'soft-light'  => esc_html__( 'Soft-Light', 'royal-addons-for-elementor' ),
            'difference'  => esc_html__( 'Difference', 'royal-addons-for-elementor' ),
            'exclusion'   => esc_html__( 'Exclusion', 'royal-addons-for-elementor' ),
            'hue'         => esc_html__( 'Hue', 'royal-addons-for-elementor' ),
            'saturation'  => esc_html__( 'Saturation', 'royal-addons-for-elementor' ),
            'color'       => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'luminosity'  => esc_html__( 'Luminosity', 'royal-addons-for-elementor' ),
        ];
        return $blend_options;
    }


    // Allow Tags
    public static function royal_allow_tags( $tag = null ){
        $tag_allowed = wp_kses_allowed_html( 'post' );
        $tag_allowed['input'] = [
            'class'   => [],
            'id'      => [],
            'name'    => [],
            'value'   => [],
            'checked' => [],
            'type'    => [],
        ];
        $tag_allowed['select'] = [
            'class'    => [],
            'id'       => [],
            'name'     => [],
            'value'    => [],
            'multiple' => [],
            'type'     => [],
        ];
        $tag_allowed['option'] = [
            'value'    => [],
            'selected' => [],
        ];
        $tag_allowed['title'] = [
            'a'      => [
            'href'  => [],
            'title' => [],
            'class' => [],
        ],
            'br'     => [],
            'em'     => [],
            'strong' => [],
            'hr'     => [],
        ];
        $tag_allowed['logo'] = [
            'br'     => [],
            'em'     => [],
            'strong' => [],
            'span'   => [],
        ];
        $tag_allowed['text'] = [
            'a'      => [
            'href'  => [],
            'title' => [],
            'class' => [],
        ],
            'br'     => [],
            'em'     => [],
            'strong' => [],
            'hr'     => [],
            'i'      => [
            'class' => [],
        ],
            'span'   => [
            'class' => [],
        ],
        ];
        
        if ( $tag == null ) {
            return $tag_allowed;
        } elseif ( is_array( $tag ) ) {
            $new_tag_allow = [];
            foreach ( $tag as $_tag ) {
                $new_tag_allow[$_tag] = $tag_allowed[$_tag];
            }
            return $new_tag_allow;
        } else {
            return ( isset( $tag_allowed[$tag] ) ? $tag_allowed[$tag] : [] );
        }
    }


    // Background Position
    public static function royal_background_image_position(){
        $position_options = [
            ''              => esc_html__( 'Default', 'royal-addons-for-elementor' ),
            'top-left'      => esc_html__( 'Top Left', 'royal-addons-for-elementor' ),
            'top-center'    => esc_html__( 'Top Center', 'royal-addons-for-elementor' ),
            'top-right'     => esc_html__( 'Top Right', 'royal-addons-for-elementor' ),
            'center'        => esc_html__( 'Center', 'royal-addons-for-elementor' ),
            'center-left'   => esc_html__( 'Center Left', 'royal-addons-for-elementor' ),
            'center-right'  => esc_html__( 'Center Right', 'royal-addons-for-elementor' ),
            'bottom-left'   => esc_html__( 'Bottom Left', 'royal-addons-for-elementor' ),
            'bottom-center' => esc_html__( 'Bottom Center', 'royal-addons-for-elementor' ),
            'bottom-right'  => esc_html__( 'Bottom Right', 'royal-addons-for-elementor' ),
        ];
        return $position_options;
    }


    // Background Repeat
    public static function royal_background_image_repeat(){
        $position_options = [
            ''          => _x( 'Default', 'royal-addons-for-elementor' ),
            'no-repeat' => _x( 'No-repeat', 'royal-addons-for-elementor' ),
            'repeat'    => _x( 'Repeat', 'royal-addons-for-elementor' ),
            'repeat-x'  => _x( 'Repeat-x', 'royal-addons-for-elementor' ),
            'repeat-y'  => _x( 'Repeat-y', 'royal-addons-for-elementor' ),
        ];
        return $position_options;
    }

    // Background Size
    public static function royal_background_image_size(){
        $position_options = [
            ''        => _x( 'Default', 'royal-addons-for-elementor' ),
            'auto'    => _x( 'Auto', 'royal-addons-for-elementor' ),
            'cover'   => _x( 'Cover', 'royal-addons-for-elementor' ),
            'contain' => _x( 'Contain', 'royal-addons-for-elementor' ),
            'initial' => _x( 'Custom', 'royal-addons-for-elementor' ),
        ];
        return $position_options;
    }


    // Royal Assets Path
    public static function royalassetspath(){
        $assetpath = plugin_dir_url(__DIR__) . 'assets/';
        return $assetpath;
    }


    // Royal Masking Shape
    public static function royal_masking_shape_list($element) {
        $dir = ROYAL_ADDONS_ASSETS . 'shape-masking/';
        $shape_name = 'shape';
        $extension = '.svg';
        $list = [];
        if ('list' == $element) {
            for ($i = 1; $i <= 113; $i++) {
                $list[$shape_name . $i] = [
                    'title' => ucwords($shape_name . ' ' . $i),
                    'url' => $dir . $shape_name . $i . $extension,
                ];
            }
        } elseif ('url' == $element) {
            for ($i = 1; $i <= 113; $i++) {
                $list[$shape_name . $i] = $dir . $shape_name . $i . $extension;
            }
        }
        return $list;
    }

    public static function royal_masking_map_list($element) {
        $dir = ROYAL_ADDONS_ASSETS . 'shape-masking/';
        $shape_name = 'map';
        $extension = '.svg';
        $list = [];
        if ('list' == $element) {
                $list[$shape_name . 'bangladesh'] = [
                    'title' => ucwords('Bangladesh '. $shape_name),
                    'url' => $dir . $shape_name . 'bangladesh' . $extension,
                ];

                $list[$shape_name . 'world'] = [
                    'title' => ucwords('World '. $shape_name),
                    'url' => $dir . $shape_name . 'world' . $extension,
                ];
            
        } elseif ('url' == $element) {
                $list[$shape_name . 'bangladesh'] = $dir . $shape_name . 'bangladesh' . $extension;
                $list[$shape_name . 'world'] = $dir . $shape_name . 'world' . $extension;
        }
        return $list;
    }



    public static function royal_all_posts() {
        $all_posts = get_posts(
            array(
                'posts_per_page'         => 100,
                'post_type'              => array( 'page', 'post' ),
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
                'fields'                 => array( 'ids' ),
            )
        );

        $is_mbinstalled = extension_loaded( 'mbstring' );
        $options        = array();

        if ( ! empty( $all_posts ) && ! is_wp_error( $all_posts ) ) {
            foreach ( $all_posts as $post ) {

                if ( $is_mbinstalled ) {
                    $options[ $post->ID ] = mb_strlen( $post->post_title ) > 30 ? mb_substr( $post->post_title, 0, 30 ) . '...' : $post->post_title;
                } else {
                    $options[ $post->ID ] = strlen( $post->post_title ) > 30 ? substr( $post->post_title, 0, 30 ) . '...' : $post->post_title;
                }
            }
        }
        return $options;
    }


    public static function royal_get_post_types() {
        $post_type_args = array(
            'public'            => true,
            'show_in_nav_menus' => true
        );

        $post_types = get_post_types($post_type_args, 'objects');
        $post_lists = array();
        foreach ($post_types as $post_type) {
            $post_lists[$post_type->name] = $post_type->labels->singular_name;
        }
        return $post_lists;
    }


    public static function royal_get_all_posts() {
        $posts = [];
        $args = array(
            'posts_per_page' => -1,
            'fields' => [
                'ID',
                'post_title'
            ]
        );
        
        $query = get_posts( $args );
        
        foreach ( $query as $post ) {
            
            $posts[$post->ID] = $post->post_title;
        }
        
        wp_reset_postdata();

        return $posts;
    } 



    public static function royal_get_categories_name_for_class( ) {
        $separator = ' ';
        $cat_name_as_class = '';
        $post_type = get_post_type(get_the_ID());   
        $taxonomies = get_object_taxonomies($post_type);   
        $taxonomy_slugs = wp_get_object_terms(get_the_ID(), $taxonomies,  array("fields" => "slugs"));
        
            foreach($taxonomy_slugs as $tax_slug) :            
                $cat_name_as_class .= $tax_slug . $separator ; 
            endforeach;
            return trim( $cat_name_as_class, $separator );
        
    }


    public static function royal_get_all_authors() {
        $user_query = new \WP_User_Query(
            [
                // 'who' => 'authors', //who is deprecated Use capability instead
                'has_published_posts' => true,
                'fields' => [
                    'ID',
                    'display_name',
                ],
            ]
        );

        $authors = array();

        foreach ( $user_query->get_results() as $result ) {
            $authors[ $result->ID ] = $result->display_name;
        }

        return $authors;
    }


    public static function royal_get_all_categories() {
        $cat_array = array();
        $categories = get_categories('orderby=name&hide_empty=0');
        foreach ($categories as $category):
            $cat_array[$category->term_id] = $category->name;
        endforeach;

        return $cat_array;
    }


    public static function royal_get_all_tags() {
        $tag_array = array();
        $tags = get_tags();
        foreach ( $tags as $tag ) {
            $tag_array[$tag->term_id] = $tag->name;
        }

        return $tag_array;
    } 


    public static function get_all_breakpoints( $type = 'assoc' ) {

        $devices = array(
            'desktop' => __( 'Desktop', 'royal-addons-for-elementor' ),
            'tablet'  => __( 'Tablet', 'royal-addons-for-elementor' ),
            'mobile'  => __( 'Mobile', 'royal-addons-for-elementor' ),
        );

        $method_available = method_exists( Plugin::$instance->breakpoints, 'royal_custom_breakpoints' );

        if ( ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.4.0', '>' ) ) && $method_available ) {

            if ( Plugin::$instance->breakpoints->royal_custom_breakpoints() ) {
                $devices = array_merge(
                    $devices,
                    array(
                        'widescreen'   => __( 'Widescreen', 'royal-addons-for-elementor' ),
                        'laptop'       => __( 'Laptop', 'royal-addons-for-elementor' ),
                        'tablet_extra' => __( 'Tablet Extra', 'royal-addons-for-elementor' ),
                        'mobile_extra' => __( 'Mobile Extra', 'royal-addons-for-elementor' ),
                    )
                );
            }
        }

        if ( 'keys' === $type ) {
            $devices = array_keys( $devices );
        }

        return $devices;
    }


    public static function get_icon_svg_data( $icon ) {

        if ( ! defined( 'ELEMENTOR_ASSETS_PATH' ) ) {
            return;
        }

        preg_match( '/fa(.*) fa-/', $icon['value'], $icon_name_matches );

        if( empty( $icon_name_matches ) ) {
            return;
        }

        $icon_name = str_replace( $icon_name_matches[0], '', $icon['value'] );

        $icon_key = str_replace( ' fa-', '-', $icon['value'] );

        $icon_file_name = str_replace( 'fa-', '', $icon['library'] );

        $path = ELEMENTOR_ASSETS_PATH . 'lib/font-awesome/json/' . $icon_file_name . '.json';

        if ( ! file_exists( $path ) ) {
            return;
        }

        $data = file_get_contents( $path );

        if( ! $data ) {
            return;
        }

        $data = json_decode( $data, true );

        if ( ! isset( $data['icons'][ $icon_name ] ) ) {
            return;
        }

        $svg_data = $data['icons'][ $icon_name ];

        return array(
            'width'  => $svg_data[0],
            'height' => $svg_data[1],
            'path'   => $svg_data[4],
        );
    }


    public static function get_allowed_icon_tags() {
        return array(
            'svg'   => array(
                'id'              => array(),
                'class'           => array(),
                'aria-hidden'     => array(),
                'aria-labelledby' => array(),
                'role'            => array(),
                'xmlns'           => array(),
                'width'           => array(),
                'height'          => array(),
                'viewbox'         => array(),
                'data-*'          => true,
            ),
            'g'     => array( 'fill' => array() ),
            'title' => array( 'title' => array() ),
            'path'  => array(
                'd'    => array(),
                'fill' => array(),
            ),
            'i'     => array(
                'class' => array(),
                'id'    => array(),
                'style' => array(),
            ),
        );
    }



    public static function get_svg_by_icon( $icon, $attributes = array() ) {

        if ( empty( $icon ) || empty( $icon['value'] ) ) {
            return '';
        }

        if ( empty( $icon['library'] ) || 'solid' === $icon['library'] ) {
            $icon['library'] = 'fa-solid';
        }

        //If icon library is SVG, then go to Elementor. Used for widgets where this widget is called in all cases.
        if( 'svg' === $icon['library'] ) {

            $svg_html = Icons_Manager::try_get_icon_html( $icon, $attributes );

            return $svg_html;
        }

        $icon['font_family'] = 'font-awesome';

        $i_class = is_string( $icon['value'] ) ? str_replace( ' ', '-', $icon['value'] ) : '';

        $svg_html = '<svg ';

        $svg_data = self::get_icon_svg_data( $icon );

        if( ! $svg_data ) {
            ob_start();
            Icons_Manager::render_icon( $icon, is_array( $attributes ) ? $attributes : [ 'aria-hidden' => 'true' ] );
            return ob_get_clean();
        }

        $view_box = '0 0 ' . $svg_data['width'] . ' ' . $svg_data['height'];

        $has_class = false;
        $has_width = false;
        $has_height = false;
        if ( is_array( $attributes ) ) {

            foreach ( $attributes as $key => $value ) {

                if ( 'class' === $key ) {
                    $has_class = true;
                    $svg_html .= 'class="svg-inline--' . $i_class . ' ' . $value . '" ';
                } else {
                    if ( 'width' === $key ) {
                        $has_width = true;
                    } elseif ( 'height' === $key ) {
                        $has_height = true;
                    }
                    $svg_html .= " {$key}='{$value}' ";
                }
            }
            if ( ! $has_class ) {
                $svg_html .= 'class="svg-inline--' . $i_class . '" ';
            }
        } else {

            $attributes = str_replace( 'class="', 'class="svg-inline--' . $i_class . ' ', $attributes );

            $svg_html .= $attributes;
        }

        $width_attr = ! $has_width ? " width='1em'" : "";
        $height_attr = ! $has_height ? " height='1em'" : "";

        $svg_html .= " aria-hidden='true' xmlns='http://www.w3.org/2000/svg' viewBox='{$view_box}'{$width_attr}{$height_attr}>";

        $svg_html .= '<path d="' . esc_attr( $svg_data['path'] ) . '"></path>';
        $svg_html .= '</svg>';

        return wp_kses( $svg_html, self::get_allowed_icon_tags() );
    }

}

if (!function_exists('royal_ajax_search_function_wrapper')) {
    add_action('wp_ajax_royal_ajax_search', ['RoyalAddons\Elementor\Royal_Helpers', 'royal_ajax_search_function']);
    add_action('wp_ajax_nopriv_royal_ajax_search', ['RoyalAddons\Elementor\Royal_Helpers', 'royal_ajax_search_function']);
}
