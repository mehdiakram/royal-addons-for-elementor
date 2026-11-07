<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use RoyalAddons\Elementor\Royal_Helpers;

if ( !defined( 'ABSPATH' ) ) {exit;}// Exit if accessed directly

class RoyalSliderGeneral extends Widget_Base{
	private $total_slides = 1;
    public function get_name(){
        return 'royalslidergeneral';
    }
    
    public function get_title(){
        return esc_html__( 'General Slider', 'royal-addons-for-elementor' );
    }
    
    public function get_icon() { return 'royalslidergeneral rtbranding'; }
    
    public function get_categories(){
        return [ 'royaltech' ];
    }

    public function get_keywords(){
		return [ 'general', 'crelly', 'meteor', 'slider', 'carousel', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }
	
    public function get_style_depends(){
        return [ 'royalslidergeneral', 'royaltechuikit' ];
    }
    
	public function get_script_depends(){
		$scripts = ['royaltechuikit', 'royalslidergeneral', 'splittext', 'gsap', 'royalanime'];
		return $scripts;
	}	
	
    
    protected function register_controls(){
        $this->start_controls_section( 'section_content_layout', [
            'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
        ] );
		
		$this->add_control( 'slider_skin', [
            'label'     => esc_html__( 'Slider Animations', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'separator' => 'before',
            'default'   => 'general',
            'options'   => [
				'general' 	=> esc_html__( 'General', 'royal-addons-for-elementor' ),
				'regal' 	=> esc_html__( 'Regal', 'royal-addons-for-elementor' ),
				'crelly' 	=> esc_html__( 'Crelly', 'royal-addons-for-elementor' ),
				'slide' 	=> esc_html__( 'Slide', 'royal-addons-for-elementor' ),
				'meteor' 	=> esc_html__( 'Meteor', 'royal-addons-for-elementor' ),
			],
        ] );
		
        $this->add_control( 'slider_size_ratio', [
            'label'       => esc_html__( 'Size Ratio', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::IMAGE_DIMENSIONS,
            'description' => 'Slider ratio to width and height, such as 16:9',
            'separator'   => 'before',
            'condition'   => [
            'enable_height!' => 'yes',
			],
        ] );
		
		$this->add_control( 'slider_min_height', [
            'label'     => esc_html__( 'Minimum Height', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
				'px' => [
					'min' => 50,
					'max' => 1024,
				],
			],
            'condition' => [
            'enable_height!' => 'yes',
        ],
        ] );
		
        $this->add_control( 'enable_height', [
            'label'   => esc_html__( 'Enable Viewport Height', 'royal-addons-for-elementor' )  ,
            'type'    => Controls_Manager::SWITCHER,
        ] );        
		
        $this->add_control( 'viewport_height', [
            'label'      => esc_html__( 'Height', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'vh' ],
            'range'      => [
            'vh' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'default'    => [
            'unit' => 'vh',
            'size' => 70,
        ],
            'condition'  => [
            'enable_height' => 'yes',
        ],
        ] );
		
        $this->add_responsive_control( 'content_max_width', [
            'label'      => esc_html__( 'Content Max Width', 'royal-addons-for-elementor' )  ,
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', '%' ],
            'range'      => [
            'px' => [
            'min' => 100,
            'max' => 1600,
        ],
            '%'  => [
            'min' => 10,
            'max' => 100,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc' => 'width: {{SIZE}}{{UNIT}};',
        ],
        ] );

        $this->add_responsive_control( 'content_alignment', [
            'label'     => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'left'   => [
            'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
            'icon'  => 'eicon-text-align-left',
        ],
            'center' => [
            'title' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
            'icon'  => 'eicon-text-align-center',
        ],
            'right'  => [
            'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
            'icon'  => 'eicon-text-align-right',
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content *' => 'text-align: {{VALUE}} !important;',
        ],
        ] );
        $this->add_control( 'hr', [
            'type' => Controls_Manager::DIVIDER,
        ] );
        $this->add_control( 'show_sub_title', [
            'label'   => esc_html__( 'Show Sub Title', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'show_title', [
            'label'   => esc_html__( 'Show Title', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'title_html_tag', [
            'label'     => __( 'Title HTML Tag', 'royaltechhemes-element-pack' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'h1',
            'options'   => Royal_Helpers::royal_title_tags(),
            'condition' => [
            'show_title' => 'yes',
        ],
        ] );
        $this->add_control( 'show_button_text', [
            'label'   => esc_html__( 'Show Button', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        
        // show button icon control
        $this->add_control( 'show_button_icon', [
            'label'     => esc_html__( 'Show Button Icon', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => [
                'show_button_text' => 'yes',
            ],
        ] );

        $this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'condition' => [
                    'show_button_text' => 'yes',
                    'show_button_icon' => 'yes',
                ],
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'chevron-right',
						'angle-right',
						'angle-double-right',
						'chevron-circle-right',
						'caret-square-right',
						'hand-point-right',
						'caret-right',
					],
					'fa-regular' => [
						'hand-point-right',
						'arrow-alt-circle-right',
						'caret-square-right',
					],
				],
			]
		);

        $this->add_control( 'show_excerpt', [
            'label'   => esc_html__( 'Show Excerpt', 'royal-addons-for-elementor' ) ,
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
		
        $this->add_control( 
		'show_otherview', [
            'label'     => esc_html__( 'Show Otherview Text', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => [
				'slider_skin' => [ 'crelly' ],
			],
        ] );
		
		
		$this->add_control(
			'otherview_text',
			[
				'label' => esc_html__( 'Otherview Text', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Otherview', 'textdomain' ),
				'condition' => [
					'slider_skin' => [ 'crelly' ],
					'show_otherview' => [ 'yes' ],
				],
			]
		);
		
        $this->add_control( 'alter_btn_excerpt', [
            'label'     => esc_html__( 'Alter Button and Excerpt', 'royal-addons-for-elementor' )  ,
            'type'      => Controls_Manager::SWITCHER,
            'condition' => [
				'slider_skin' => '',
			],
        ] );

        $this->add_control( 'show_share_us', [
            'label'     => esc_html__( 'Show Share Us', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => [
                'slider_skin' => [ 'crelly' ],
            ],
        ] );

        $this->add_control( 'show_social_icon', [
            'label'     => esc_html__( 'Show Social Icon', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => [
                'slider_skin!' => [ 'slide' ],
            ],
        ] );

        $this->add_control( 'show_scroll_button', [
            'label'   => esc_html__( 'Show Scroll Button', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control( 'show_navigation_arrows', [
            'label'   => esc_html__( 'Show Arrows', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control( 'show_navigation_dots', [
            'label'   => esc_html__( 'Show Dots', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'         => 'thumbnail_size',
            'label'        => esc_html__( 'Image Size', 'royal-addons-for-elementor' ) ,
            'exclude'      => [ 'custom' ],
            'default'      => 'full',
            'prefix_class' => 'royaltech-prime-slider-thumbnail-size-',
            'separator'    => 'before',
        ] );

		$this->add_control( 'background_image_toggle', [
            'label'        => __( 'Background Image Settings', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_off'    => __( 'None', 'royal-addons-for-elementor' ),
            'label_on'     => __( 'Custom', 'royal-addons-for-elementor' ),
            'return_value' => 'yes',
        ] );
		
        $this->start_popover();
        $this->add_responsive_control( 'background_image_position', [
            'label'       => _x( 'Position', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => '',
            'options'     => Royal_Helpers::royal_background_image_position(),
            'selectors'   => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slideshow-item .royaltech-ps-slide-img' => 'background-position: {{VALUE}};',
			],
            'condition'   => [
                'background_image_toggle' => 'yes',
			],
            'render_type' => 'ui',
        ] 
		);


		$this->add_responsive_control( 'background_image_repeat', [
            'label'       => _x( 'Repeat', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => '',
            'options'     => Royal_Helpers::royal_background_image_repeat(),
            'selectors'   => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slideshow-item .royaltech-ps-slide-img' => 'background-repeat: {{VALUE}};',
			],
            'condition'   => [
                'background_image_toggle' => 'yes',
			],
            'render_type' => 'ui',
        ]
		);
        $this->add_responsive_control( 'background_image_size', [
            'label'       => _x( 'Size', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::SELECT,
            'default'     => '',
            'options'     => Royal_Helpers::royal_background_image_size(),
            'selectors'   => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slideshow-item .royaltech-ps-slide-img' => 'background-size: {{VALUE}};',
            ],
            'condition'   => [
                'background_image_toggle' => 'yes',
            ],
            'render_type' => 'ui',
        ] );
        $this->add_responsive_control( 'background_image_width', [
            'label'       => _x( 'Width', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::SLIDER,
            'size_units'  => [
            'px',
            'em',
            '%',
            'vw'
        ],
            'range'       => [
            'px' => [
            'min' => 0,
            'max' => 1000,
        ],
            '%'  => [
            'min' => 0,
            'max' => 100,
        ],
            'vw' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'default'     => [
            'size' => 100,
            'unit' => '%',
        ],
            'required'    => true,
            'selectors'   => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slideshow-item .royaltech-ps-slide-img' => 'background-size: {{SIZE}}{{UNIT}} auto',
        ],
            'condition'   => [
            'background_image_size' => [ 'initial' ],
        ],
            'render_type' => 'ui',
        ] );
        $this->end_popover();
		$this->end_controls_section();

        $this->start_controls_section( 'section_content_sliders', [
            'label' => esc_html__( 'Sliders', 'royal-addons-for-elementor' ),
        ] );

        $repeater = new Repeater();
        $repeater->start_controls_tabs( 'tabs_slider_items' );
        $repeater->start_controls_tab( 'tab_slider_content', [
            'label' => esc_html__( 'Content', 'royal-addons-for-elementor' ),
        ] );
        $repeater->add_control( 'sub_title', [
            'label'       => esc_html__( 'Sub Title', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Explore', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'title', [
            'label'       => esc_html__( 'Title', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'slide_button_text', [
            'label'       => esc_html__( 'Button Text', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Details', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'button_link', [
            'label'     => esc_html__( 'Button Link', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::URL,
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'slide_button_text!' => '',
        ],
        ] );

        $repeater->add_control( 'background', [
            'label'   => esc_html__( 'Background', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::CHOOSE,
            'default' => 'color',
            'toggle'  => false,
            'options' => [
            'color'   => [
            'title' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-paint-brush',
            ],
            'image'   => [
                'title' => esc_html__( 'Image', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-image',
            ],
            'video'   => [
                'title' => esc_html__( 'Video', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-play',
            ],
            'youtube' => [
                'title' => esc_html__( 'Youtube', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-youtube',
            ],
        ],
        ] );

        $repeater->add_control( 'color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#193d4c',
            'condition' => [
                'background' => 'color',
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
            ],
        ] );

        $repeater->add_control( 'image', [
            'label'     => esc_html__( 'Image', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::MEDIA,
            'default'   => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'background' => 'image',
            ],
            'dynamic'   => [
            'active' => true,
        ],
        ] );

        $repeater->add_control( 'video_link', [
            'label'     => esc_html__( 'Video Link', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'condition' => [
                'background' => 'video',
            ],
            'default'   => 'https://clips.vorwaerts-gmbh.de/big_buck_bunny.mp4',
            'dynamic'   => [
                'active' => true,
            ],
        ] );

        $repeater->add_control( 'youtube_link', [
            'label'     => esc_html__( 'Youtube Link', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'condition' => [
                'background' => 'youtube',
            ],
            'default'   => 'https://youtu.be/YE7VzlLtp-4',
            'dynamic'   => [
            'active' => true,
        ],
        ] );
        $repeater->end_controls_tab();

        $repeater->start_controls_tab( 'tab_slider_Optional', [
            'label' => esc_html__( 'Optional', 'royal-addons-for-elementor' ),
        ] );

        $repeater->add_control('title_link', [
            'label'         => esc_html__( 'Title Link', 'royal-addons-for-elementor' ) ,
            'type'          => Controls_Manager::URL,
            'default'       => [
                'url' => '',
            ],
            'show_external' => false,
                'dynamic'       => [
                'active' => true,
            ],
            'condition'     => [
                'title!' => '',
            ],
        ] );

        $repeater->add_control('optional_image',
			[
				'label' => esc_html__( 'Choose Image', 'royal-addons-for-elementor' ),
                'description' => esc_html__( 'This image will be shown for Regal slider item.', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                
			]
		);

        $repeater->add_control( 'excerpt', [
            'label'       => esc_html__( 'Excerpt', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::WYSIWYG,
            'default'     => esc_html__( 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem, totam rem aperiam, eaque ipsa quae ab illo inventore et quasi architecto beatae vitae dicta sunt explicabo.', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control( 'slides', [
            'label'       => esc_html__( 'Slider Items', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'title' => esc_html__( 'Web Development', 'royal-addons-for-elementor' ), ], 
                [ 'title' => esc_html__( 'Wordpress', 'royal-addons-for-elementor' ), ], 
                [ 'title' => esc_html__( 'Training', 'royal-addons-for-elementor' ),
                ] 
            ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_content_social_link', [
            'label'     => __( 'Social Icon', 'royal-addons-for-elementor' ),
            'condition' => [
            'show_social_icon' => 'yes',
            'slider_skin!' => [ 'slide' ],
        ],
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'social_link_title', [
            'label'   => __( 'Title', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'Facebook',
        ] );
        $repeater->add_control( 'social_link', [
            'label'   => __( 'Link', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'http://www.facebook.com/RoyalTechnologies', 'royal-addons-for-elementor' ),
        ] );
        $repeater->add_control( 'social_icon', [
            'label'   => __( 'Choose Icon', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::ICONS,
            'default' => [
            'value'   => 'fab fa-facebook-f',
            'library' => 'fa-brands',
        ],
        ] );
        $this->add_control( 'social_link_list', [
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [ [
            'social_link'       => __( 'http://www.facebook.com/RoyalTechnologies', 'royal-addons-for-elementor' ),
            'social_icon'       => [
            'value'   => 'fab fa-facebook-f',
            'library' => 'fa-brands',
			],
            'social_link_title' => 'Facebook',
        ], [
            'social_link'       => __( 'http://www.twitter.com', 'royal-addons-for-elementor' ),
            'social_icon'       => [
            'value'   => 'fab fa-twitter',
            'library' => 'fa-brands',
        ],
            'social_link_title' => 'Twitter',
        ], [
            'social_link'       => __( 'http://www.instagram.com/RoyalTechnologiesBD/', 'royal-addons-for-elementor' ),
            'social_icon'       => [
            'value'   => 'fab fa-instagram',
            'library' => 'fa-brands',
        ],
            'social_link_title' => 'Instagram',
        ] ],
            'title_field' => '{{{ social_link_title }}}',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_content_scroll_button', [
            'label'     => esc_html__( 'Scroll Down', 'royal-addons-for-elementor' ),
            'condition' => [
            'show_scroll_button' => [ 'yes' ],
            'slider_skin!'       => [ 'slide', 'crelly' ],
        ],
        ] );
        $this->add_control( 'duration', [
            'label'      => esc_html__( 'Duration', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [
				'px' => [
					'min'  => 100,
					'max'  => 5000,
					'step' => 50,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 200,
			],
        ] );
        $this->add_control( 'offset', [
            'label' => esc_html__( 'Offset', 'royal-addons-for-elementor' ) ,
            'type'  => Controls_Manager::SLIDER,
            'range' => [
				'px' => [
					'min'  => -200,
					'max'  => 200,
					'step' => 10,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 0,
			],
        ] );
        $this->add_control( 'scroll_button_text', [
            'label'       => esc_html__( 'Button Text', 'royal-addons-for-elementor' ) ,
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
            'active' => true,
        ],
            'default'     => esc_html__( 'Scroll Down', 'royal-addons-for-elementor' ),
            'placeholder' => esc_html__( 'Scroll Down', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'section_id', [
            'label'       => esc_html__( 'Section ID', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => 'my-header',
            'description' => esc_html__( "By clicking this scroll button, to which section in your page you want to go? Just write that's section ID here such 'my-header'. N.B: No need to add '#'.", 'royal-addons-for-elementor' ),
        ] );
        $this->end_controls_section();


        $this->start_controls_section( 'section_style_animation', [
            'label' => esc_html__( 'Slider Settings', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'finite', [
            'label'   => esc_html__( 'Loop', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'autoplay', [
            'label'   => esc_html__( 'Autoplay', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'autoplay_interval', [
            'label'     => esc_html__( 'Autoplay Interval (ms)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 7000,
            'condition' => [
            'autoplay' => 'yes',
        ],
        ] );
        $this->add_control( 'pause_on_hover', [
            'label' => esc_html__( 'Pause on Hover', 'royal-addons-for-elementor' ),
            'type'  => Controls_Manager::SWITCHER,
        ] );
        $this->add_control( 'draggable', [
            'label'   => esc_html__( 'Draggable', 'royal-addons-for-elementor' ) ,
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'velocity', [
            'label' => __( 'Animation Speed', 'royaltechhemes-element-pack' ),
            'type'  => Controls_Manager::SLIDER,
            'range' => [
            'px' => [
            'min'  => 0.1,
            'max'  => 1,
            'step' => 0.1,
        ],
        ],
        ] );
        $this->add_control( 'slider_animations', [
            'label'     => esc_html__( 'Slider Animations', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'separator' => 'before',
            'default'   => 'fade',
            'options'   => [
				'slide' => esc_html__( 'Slide', 'royal-addons-for-elementor' ),
				'fade'  => esc_html__( 'Fade', 'royal-addons-for-elementor' ),
				'scale' => esc_html__( 'Scale', 'royal-addons-for-elementor' ),
				'push'  => esc_html__( 'Push', 'royal-addons-for-elementor' ),
				'pull'  => esc_html__( 'Pull', 'royal-addons-for-elementor' ),
			],
            'condition' => [
                'slider_skin!' => 'slide',
            ],
        ] );
        $this->add_control( 'animation_parallax', [
            'label'     => esc_html__( 'Parallax Animation', 'royaltechhemes-element-pack' ) ,
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
                'condition' => [
                'animation_status' => '',
            ],
        ] );
        $this->add_control( 'kenburns_animation', [
            'label'     => esc_html__( 'Kenburns Animation', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'separator' => 'before',
        ] );
        $this->add_control( 'kenburns_reverse', [
            'label'     => esc_html__( 'Kenburn Reverse', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SWITCHER,
            'condition' => [
            'kenburns_animation' => 'yes',
        ],
        ] );
        $this->end_controls_section();

        /**
         * Advanced Animation
         */

        $this->start_controls_section( 'section_advanced_animation', [
            'label' => esc_html__( 'Advanced Animation', 'royal-addons-for-elementor' ) ,
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'animation_status', [
            'label'   => esc_html__( 'Advanced Animation', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
        ] );


        $this->add_control( 'animation_of', [
            'label'     => __( 'Animation Of', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SELECT2,
            'multiple'  => true,
            'options'   => [
                '.royaltech-sub-title-inner' => __( 'Sub Title', 'royal-addons-for-elementor' ),
                '.royaltech-title-tag'       => __( 'Title', 'royal-addons-for-elementor' ),
                '.royaltech-slider-excerpt'  => __( 'Excerpt', 'royal-addons-for-elementor' ),
            ],
            'default'   => [ '.royaltech-title-tag' ],
            'condition' => [
                'animation_status' => 'yes',
            ],
        ] );
        $this->add_control( 'animation_on', [
            'label'     => __( 'Animation On', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'words',
            'options'   => [
				'chars' => 'Chars',
				'words' => 'Words',
				'lines' => 'Lines',
			],
            'condition' => [
            'animation_status' => 'yes',
        ],
        ] );
        $this->add_control( 'animation_options', [
            'label'        => __( 'Animation Options', 'royal-addons-for-elementor' ),
            'type'         => Controls_Manager::POPOVER_TOGGLE,
            'label_off'    => __( 'Default', 'royal-addons-for-elementor' ),
            'label_on'     => __( 'Custom', 'royal-addons-for-elementor' ),
            'return_value' => 'yes',
            'default'      => 'yes',
            'condition'    => [
            'animation_status' => 'yes',
        ],
        ] );
        $this->start_popover();
        $this->add_control( 'anim_perspective', [
            'label'       => esc_html__( 'Perspective', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::SLIDER,
            'placeholder' => '400',
            'range'       => [
            'px' => [
            'min' => 50,
            'max' => 400,
        ],
        ],
            'condition'   => [
            'animation_status'  => 'yes',
            'animation_options' => 'yes',
        ],
        ] );
        $this->add_control( 'anim_duration', [
            'label'     => esc_html__( 'Transition Duration', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => 0.1,
            'step' => 0.1,
            'max'  => 1,
        ],
        ],
            'condition' => [
            'animation_status'  => 'yes',
            'animation_options' => 'yes',
        ],
        ] );
        $this->add_control( 'anim_scale', [
            'label'     => esc_html__( 'Scale', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 1,
            'max' => 10,
        ],
        ],
            'condition' => [
            'animation_status'  => 'yes',
            'animation_options' => 'yes',
        ],
        ] );
        $this->add_control( 'anim_rotationY', [
            'label'     => esc_html__( 'rotationY', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => -360,
            'max' => 360,
        ],
        ],
            'condition' => [
            'animation_status'  => 'yes',
            'animation_options' => 'yes',
        ],
        ] );
        $this->add_control( 'anim_rotationX', [
            'label'     => esc_html__( 'rotationX', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => -360,
            'max' => 360,
        ],
        ],
            'condition' => [
            'animation_status'  => 'yes',
            'animation_options' => 'yes',
        ],
        ] );
        $this->add_control( 'anim_transform_origin', [
            'label'     => esc_html__( 'Transform Origin', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::TEXT,
            'default'   => '0% 50% -50',
            'condition' => [
            'animation_status'  => 'yes',
            'animation_options' => 'yes',
        ],
        ] );
        $this->end_popover();
        $this->end_controls_section();

        //Style
        $this->start_controls_section( 'section_style_sliders', [
            'label' => esc_html__( 'Sliders', 'royal-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'overlay', [
            'label'   => esc_html__( 'Overlay', 'royal-addons-for-elementor' ) ,
            'type'    => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none'       => esc_html__( 'None', 'royal-addons-for-elementor' ),
                'background' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
                'blend'      => esc_html__( 'Blend', 'royal-addons-for-elementor' ),
            ],
        ] );
        $this->add_control( 'overlay_color', [
            'label'     => esc_html__( 'Overlay Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'overlay' => [ 'background', 'blend' ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-slideshow .royaltech-overlay-default' => 'background-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'blend_type', [
            'label'     => esc_html__( 'Blend Type', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'multiply',
            'options'   => Royal_Helpers::royal_blend_options(),
            'condition' => [
                'overlay' => 'blend',
            ],
        ] );
        $this->add_control( 'overlay_divider', [
            'type' => Controls_Manager::DIVIDER,
        ] );
        $this->add_control( 'shape_background_color', [
            'label'     => __( 'Shape Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider-skin-slide .royaltech-slide-shape' => 'background: {{VALUE}};',
            ],
            'condition' => [
                'slider_skin' => 'slide',
            ],
        ] );

        $this->start_controls_tabs( 'slider_item_style' );
        $this->start_controls_tab( 'slider_title_style', [
            'label'     => __( 'Title', 'royal-addons-for-elementor' ),
            'condition' => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_responsive_control( 'title_width', [
            'label'      => esc_html__( 'Title Width', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [
            'px' => [
            'min' => 220,
            'max' => 1200,
        ],
            '%'  => [
            'min' => 10,
            'max' => 100,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title' => 'width: {{SIZE}}{{UNIT}};',
        ],
            'condition'  => [
            'show_title' => [ 'yes' ],
        ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag' => 'color: {{VALUE}};',
        ],
            'condition' => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'title_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag',
            'condition' => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Text_Stroke::get_type(), [
            'name'           => 'title_text_stroke',
            'selector'       => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag',
            'fields_options' => [
            'text_stroke_type' => [
            'label' => esc_html__( 'Text Stroke', 'royal-addons-for-elementor' ) ,
        ],
        ],
            'condition'      => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_responsive_control( 'prime_slider_title_spacing', [
            'label'     => esc_html__( 'Title Spacing', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'title_advanced_style', [
            'label'     => esc_html__( 'Advanced Style', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'condition' => [
            'animation_status' => '',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'      => 'title_background',
            'label'     => __( 'Background', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag',
            'condition' => [
            'title_advanced_style' => 'yes',
            'animation_status'     => '',
        ],
        ] );
        $this->add_group_control( Group_Control_Text_Shadow::get_type(), [
            'name'      => 'title_text_shadow',
            'label'     => __( 'Text Shadow', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag',
            'condition' => [
            'title_advanced_style' => 'yes',
            'animation_status'     => '',
        ],
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'      => 'title_border',
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag',
            'condition' => [
            'title_advanced_style' => 'yes',
            'animation_status'     => '',
        ],
        ] );
        $this->add_responsive_control( 'title_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'title_advanced_style' => 'yes',
            'animation_status'     => '',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'      => 'title_box_shadow',
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag',
            'condition' => [
            'title_advanced_style' => 'yes',
            'animation_status'     => '',
        ],
        ] );
        $this->add_responsive_control( 'title_text_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-main-title .royaltech-title-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'title_advanced_style' => 'yes',
            'animation_status'     => '',
        ],
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'slider_sub_title_style', [
            'label'     => __( 'Sub Title', 'royal-addons-for-elementor' ),
            'condition' => [
            'show_sub_title' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'sub_title_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc h4' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'sub_title_typography',
            'label'    => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc h4',
        ] );
        $this->add_responsive_control( 'prime_slider_sub_title_spacing', [
            'label'     => esc_html__( 'Sub Title Spacing', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-desc .royaltech-sub-title h4' => 'padding-bottom: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'show_sub_title' => [ 'yes' ],
        ],
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'slider_style_excerpt', [
            'label'     => esc_html__( 'Excerpt', 'royal-addons-for-elementor' ),
            'condition' => [
            'show_excerpt' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'excerpt_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slider-excerpt' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'excerpt_title_color', [
            'label'     => esc_html__( 'Title Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slider-excerpt-content h3' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'slider_skin' => [ 'crelly' ],
            ],
        ] );
        $this->add_responsive_control( 'excerpt_title_spacing', [
            'label'     => esc_html__( 'Top Spacing', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 200,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-slider-excerpt-content' => 'margin-top: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'slider_skin' => [ 'crelly' ],
        ],
        ] );
        $this->add_control( 'excerpt_background_color', [
            'label'     => esc_html__( 'Primary Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-meteor .royaltech-prime-slider-footer-content .royaltech-social-background, {{WRAPPER}} .royaltech-prime-slider-skin-slide .royaltech-slide-featured' => 'background-color: {{VALUE}}',
        ],
            'condition' => [
            'slider_skin' => [ 'meteor', 'slide' ],
        ],
        ] );
        $this->add_control( 'excerpt_style_color', [
            'label'     => esc_html__( 'Style Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-slider-excerpt:before' => 'background: {{VALUE}}',
        ],
            'condition' => [
            'slider_skin' => 'crelly',
        ],
        ] );
        $this->add_control( 'excerpt_style_border_color', [
            'label'     => esc_html__( 'Line Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-slide .royaltech-slide-featured .royaltech-slider-excerpt' => 'border-color: {{VALUE}}',
        ],
            'condition' => [
            'slider_skin' => 'slide',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'excerpt_typography',
            'label'    => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-slider-excerpt',
        ] );
        $this->add_responsive_control( 'excerpt_width', [
            'label'          => __( 'Width (px)', 'royal-addons-for-elementor' ),
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
            'unit' => 'px',
        ],
            'tablet_default' => [
            'unit' => 'px',
        ],
            'mobile_default' => [
            'unit' => 'px',
        ],
            'size_units'     => [ 'px' ],
            'range'          => [
            'px' => [
            'min' => 100,
            'max' => 1200,
        ],
        ],
            'selectors'      => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slider-excerpt' => 'max-width: {{SIZE}}{{UNIT}};',
        ],
        ] );
		
        $this->add_responsive_control( 
		'prime_slider_excerpt_spacing', [
            'label'     => esc_html__( 'Excerpt Spacing', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 200,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slider-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'show_excerpt' => [ 'yes' ],
        ],
        ] );
		
		$this->add_responsive_control( 
		'slider_column', [
            'label'     => esc_html__( 'Column', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 4,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 1,
					'unit' => 'px',
				],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-slider-excerpt-content .royaltech-slider-excerpt' => 'column-count: {{SIZE}};',
        ],
            'condition' => [
            'show_excerpt' => [ 'yes' ],
        ],
        ] );
		
        $this->end_controls_tab();
		
        $this->start_controls_tab(
            'slider_button_style', [
            'label'     => __( 'Button', 'royal-addons-for-elementor' ),
            'condition' => [
                'show_button_text' => 'yes',
            ],
        ] );

        $this->add_control( 'slider_button_style_normal', [
            'label'     => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'slide_button_text_color_normal', [
            'label'     => __( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'slide_button_background_color_normal',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn, {{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-slide-btn:before',
        ] );

        $this->add_control( 'slider_button_style_hover', [
            'label'     => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'slide_button_text_color_hover', [
            'label'     => __( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'slide_button_background_color_hover',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn:hover, {{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-slide-btn:hover:before',
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'slide_button_border',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn',
        ] );

        $this->add_responsive_control( 'slide_button_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );

        $this->add_responsive_control( 'slide_button_text_padding', [
            'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );

        $this->add_responsive_control( 'slide_button_margin', [
            'label'      => __( 'Margin', 'royal-addons-for-elementor' ) ,
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'slide_button_box_shadow',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn',
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'slide_button_typography',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn',
        ] );

        $this->add_control( 'icon_custom_style', [
            'label' => esc_html__( 'Icon Custom Style', 'royal-addons-for-elementor' ) ,
            'type'  => Controls_Manager::SWITCHER,
        ] );

        $this->add_control( 'hr1', [
            'type'      => Controls_Manager::DIVIDER,
            'condition' => [
                'icon_custom_style' => 'yes',
            ],
        ] );

        $this->add_control( 'icon_custom_heading', [
            'label'     => esc_html__( 'Icon Style', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'condition' => [
                'icon_custom_style' => 'yes',
            ],
        ] );


        $this->add_responsive_control( 'slide_button_icon_size', [
            'label'     => esc_html__( 'Size', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                    'min' => 5,
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn .buttonicon i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'icon_custom_style' => 'yes',
            ],
        ] );

        $this->add_control(
			'button_pedding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn .buttonicon i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
                    'icon_custom_style' => 'yes',
                ],
			]
		);



        $this->add_control(
            'slide_button_icon_color', [
                'label'     => __( 'Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn .buttonicon i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'icon_custom_style' => 'yes',
                ],
            ] );


        $this->add_control( 'slide_button_hover_color', [
            'label'     => __( 'Hover Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-slide-btn .buttonicon i:hover' => 'color: {{VALUE}};',
            ],
            'condition' => [
                    'icon_custom_style' => 'yes',
                ],
        ] );


        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_social_icon', [
            'label'     => esc_html__( 'Social Icon', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'show_social_icon' => 'yes',
            'slider_skin!'           => [ 'slide' ],
        ],
        ] );
        $this->start_controls_tabs( 'tabs_social_icon_style' );
        $this->start_controls_tab( 'tab_social_icon_normal', [
            'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'social_icon_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon i'   => 'color: {{VALUE}};',
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'social_icon_text_color', [
            'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon h3' => 'color: {{VALUE}};',
        ],
            'condition' => [
            'slider_skin' => 'crelly',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'social_icon_background',
            'types'    => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'        => 'social_icon_border',
            'placeholder' => '1px',
            'default'     => '1px',
            'selector'    => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a',
        ] );
        $this->add_responsive_control( 'social_icon_radius', [
            'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'social_icon_padding', [
            'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'social_icon_shadow',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a',
        ] );
        $this->add_responsive_control( 'social_icon_size', [
            'label'     => __( 'Icon Size', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 10,
            'max' => 100,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'social_icon_spacing', [
            'label'     => esc_html__( 'Icon Space Between', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 100,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'slider_skin!' => [ 'crelly', 'meteor' ],
        ],
        ] );
        $this->add_responsive_control( 'skin_social_icon_spacing', [
            'label'     => esc_html__( 'Icon Space Between', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'max' => 100,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a' => 'margin-left: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'slider_skin' => [ 'crelly', 'meteor' ],
        ],
        ] );
        $this->add_responsive_control( 'social_icon_left_spacing', [
            'label'     => esc_html__( 'Horizontal Spacing', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 300,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon' => 'left: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'slider_skin' => '',
        ],
        ] );
        $this->add_control( 'social_background_color', [
            'label'     => esc_html__( 'Primary Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-meteor .royaltech-prime-slider-footer-content .royaltech-social-bg-color' => 'background-color: {{VALUE}}',
        ],
            'condition' => [
            'slider_skin' => 'meteor',
        ],
        ] );
        $this->add_control( 'social_icon_tooltip', [
            'label'   => esc_html__( 'Show Tooltip', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_social_icon_hover', [
            'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'social_icon_hover_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a:hover i'   => 'color: {{VALUE}};',
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a:hover svg' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'      => 'social_icon_hover_background',
            'types'     => [ 'classic', 'gradient' ],
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a:hover',
            'separator' => 'after',
        ] );
        $this->add_control( 'icon_hover_border_color', [
            'label'     => esc_html__( 'Border Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'social_icon_border_border!' => '',
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-social-icon a:hover' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_scroll_button', [
            'label'     => esc_html__( 'Scroll Down', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'show_scroll_button' => [ 'yes' ],
                'slider_skin!' => [ 'slide', 'crelly' ],
            ],
        ] );
        $this->start_controls_tabs( 'tabs_scroll_button_style' );
        $this->start_controls_tab( 'tab_scroll_button_normal', [
            'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'scroll_button_text_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-scroll-down span'       => 'color: {{VALUE}};',
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-scroll-down span svg *' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'scroll_button_typography',
            'label'    => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-scroll-down span',
        ] );
        $this->add_responsive_control( 'scroll_down_spacing', [
            'label'     => esc_html__( 'Horizontal Spacing', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
                'px' => [
                'min' => 0,
                'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider .royaltech-scroll-down' => 'right: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'slider_skin' => ['general', 'regal'],
            ],
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_scroll_button_hover', [
            'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'scroll_button_hover_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-scroll-down:hover span'       => 'color: {{VALUE}};',
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-scroll-down:hover span svg *' => 'fill: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        //Navigation
        $this->start_controls_section( 'section_style_navigation', [
            'label'      => __( 'Navigation', 'royal-addons-for-elementor' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'conditions' => [
            'relation' => 'or',
            'terms'    => [ [
            'name'     => 'show_navigation_arrows',
            'operator' => '==',
            'value'    => 'yes',
        ], [
            'name'     => 'show_navigation_dots',
            'operator' => '==',
            'value'    => 'yes',
        ] ],
        ],
        ] );
        $this->start_controls_tabs( 'tabs_navigation_style' );
        $this->start_controls_tab( 'tab_navigation_arrows_style', [
            'label' => __( 'Normal', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'arrows_color', [
            'label'     => __( 'Arrows Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous svg, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next svg'       => 'color: {{VALUE}}',
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next:before, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous:before' => 'background: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_arrows' => [ 'yes' ],
            'slider_skin!'                 => [ 'meteor' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'      => 'arrows_background',
            'label'     => __( 'Background', 'royal-addons-for-elementor' ),
            'types'     => [ 'classic', 'gradient' ],
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous',
            'condition' => [
            'show_navigation_arrows' => [ 'yes' ],
            'slider_skin!'                 => [ 'meteor' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'      => 'arrows_border',
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous',
            'condition' => [
            'show_navigation_arrows' => [ 'yes' ],
            'slider_skin!'                 => [ 'meteor' ],
        ],
        ] );
        $this->add_responsive_control( 'arrows_border_radius', [
            'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'show_navigation_arrows' => [ 'yes' ],
            'slider_skin!'                 => [ 'meteor' ],
        ],
        ] );
        $this->add_control( 'dot_heading', [
            'label'     => __( 'D O T S', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
        ],
            'separator' => 'before',
        ] );
        $this->add_control( 'dot_color', [
            'label'     => __( 'Dot Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-general .royaltech-slideshow-nav li a, {{WRAPPER}} .royaltech-prime-slider-skin-slide .royaltech-dotnav li a' => 'background: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
            'slider_skin!'               => [ 'meteor', 'crelly' ],
        ],
        ] );
        $this->add_control( 'active_dot_color', [
            'label'     => __( 'Active Dot Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-slideshow-nav li a:before' => 'border-color: {{VALUE}}',
            '{{WRAPPER}} .royaltech-dotnav li.royaltech-active a'    => 'background: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
            'slider_skin!'               => [ 'meteor', 'crelly' ],
        ],
        ] );
        $this->add_control( 'meteor_active_dot_color', [
            'label'     => __( 'Active Dot Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-meteor .royaltech-dotnav li.royaltech-active a, {{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-dotnav li.royaltech-active a:after' => 'border-color: {{VALUE}}',
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-dotnav li.royaltech-active a:before, {{WRAPPER}} .royaltech-prime-slider .royaltech-dotnav li a:before'                            => 'background: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
            'slider_skin'                => [ 'meteor', 'crelly' ],
        ],
            'separator' => 'before',
        ] );
        $this->add_control( 'active_dot_number_color', [
            'label'     => __( 'Number Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-slide .royaltech-dotnav li:after, {{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-ps-counternav span, {{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-ps-counternav li a' => 'color: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_arrows' => [ 'yes' ],
            'slider_skin'                  => [ 'slide', 'crelly' ],
        ],
        ] );
        $this->add_control( 'active_dot_number_color_skin', [
            'label'     => __( 'Active Number Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-crelly .royaltech-ps-counternav li.royaltech-active a' => 'color: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_arrows' => [ 'yes' ],
            'slider_skin'                  => [ 'crelly' ],
        ],
        ] );
        $this->add_responsive_control( 'navigation_dots_spacing', [
            'label'     => __( 'Dots Space Between', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-skin-general .royaltech-slideshow-nav li' => 'margin-right: {{SIZE}}px;',
        ],
            'condition' => [
                'show_navigation_dots' => [ 'yes' ],
                'slider_skin' => ['general', 'regal'],
            ],
        ] );
        $this->add_responsive_control( 'navigation_dots_h_spacing', [
            'label'     => __( 'Dots Horizontal Spacing', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 300,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slideshow-nav' => 'left: {{SIZE}}px;',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
            'slider_skin'                => '',
        ],
        ] );
        $this->add_responsive_control( 'navigation_dots_v_spacing', [
            'label'     => __( 'Dots Vertical Spacing', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 300,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slideshow-nav' => 'margin-bottom: {{SIZE}}px;',
        ],
            'condition' => [
                'show_navigation_dots' => [ 'yes' ],
                'slider_skin' => ['general', 'regal'],
            ],
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_navigation_arrows_hover_style', [
            'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
            'condition' => [
            'slider_skin!' => [ 'meteor' ],
        ],
        ] );
        $this->add_control( 'arrows_hover_color', [
            'label'     => __( 'Arrows Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous:hover svg, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next:hover svg' => 'color: {{VALUE}}',
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next:before, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous:before'       => 'background: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_arrows' => [ 'yes' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'      => 'arrows_hover_background',
            'label'     => __( 'Background', 'royal-addons-for-elementor' ),
            'types'     => [ 'classic', 'gradient' ],
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next:hover, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous:hover',
            'condition' => [
            'show_navigation_arrows' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'arrows_hover_border_color', [
            'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'arrows_border_border!'  => 'none',
            'show_navigation_arrows' => [ 'yes' ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-next:hover, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-previous:hover' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();		
        $this->end_controls_section();
    }
	
    
    public function adv_anim(){
        $settings = $this->get_settings_for_display();
        $animation_of = ( isset( $settings['animation_of'] ) ? implode( ", ", $settings['animation_of'] ) : '.royaltech-image-expand-sub-title' );
        $animation_of = ( strlen( $animation_of ) > 0 ? $animation_of : '.royaltech-image-expand-sub-title' );
        $animation_status = $settings['animation_status'];
        
        if ( $animation_status == 'yes' ) {
            $this->add_render_attribute( [
                'slideshow' => [
                'data-settings' => [ wp_json_encode( [
                'id'                    => '#royaltech-' . $this->get_id(),
                'animation_status'      => $animation_status,
                'animation_of'          => $animation_of,
                'animation_on'          => $settings['animation_on'],
                'anim_perspective'      => ( $settings['anim_perspective']['size'] ? $settings['anim_perspective']['size'] : 400 ),
                'anim_duration'         => ( $settings['anim_duration']['size'] ? $settings['anim_duration']['size'] : 0.1 ),
                'anim_scale'            => ( $settings['anim_scale']['size'] ? $settings['anim_scale']['size'] : 0 ),
                'anim_rotation_y'       => ( $settings['anim_rotationY']['size'] ? $settings['anim_rotationY']['size'] : 80 ),
                'anim_rotation_x'       => ( $settings['anim_rotationX']['size'] ? $settings['anim_rotationX']['size'] : 180 ),
                'anim_transform_origin' => ( $settings['anim_transform_origin'] ? $settings['anim_transform_origin'] : '0% 50% -50' ),
            ] ) ],
            ],
            ] );
        } else {
            $this->add_render_attribute( [
                'slideshow' => [
                'data-settings' => [ wp_json_encode( [
                'id'               => '#royaltech-' . $this->get_id(),
                'animation_status' => $animation_status,
            ] ) ],
            ],
            ] );
        }
    }
    
    public function render_header($skin_name){
		$settings = $this->get_settings_for_display();
		$skin_name = $settings['slider_skin'];
        $this->add_render_attribute( 'slider', 'class', 'royaltech-prime-slider-skin-' . $skin_name );

        //Viewport Height
        $ratio = ( !empty($settings['slider_size_ratio']['width']) && !empty($settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'] . ":" . $settings['slider_size_ratio']['height'] : '16:9' );
        if ( isset( $settings["viewport_height"]["size"] ) && 'vh' == $settings['viewport_height']['unit'] ) {
            $ratio = false;
        }
        $this->add_render_attribute( 'slideshow-items', 'class', 'royaltech-slideshow-items' );
        if ( isset( $settings["viewport_height"]["size"] ) && $ratio == false ) {
            $this->add_render_attribute( [
                'slideshow-items' => [
                'style' => 'min-height:' . $settings["viewport_height"]["size"] . 'vh',
            ],
            ] );
        }
        $this->add_render_attribute( [
            'slideshow' => [
            'royaltech-slideshow' => [ wp_json_encode( [
            "animation"         => $settings["slider_animations"],
            "ratio"             => $ratio,
            'min-height'        => ( !empty($settings['slider_min_height']['size']) && $ratio !== false ? $settings['slider_min_height']['size'] : (( $ratio !== false ? 480 : false )) ),
            "autoplay" => ( $settings["autoplay"] && ! \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ),
            "autoplay-interval" => $settings["autoplay_interval"],
            "pause-on-hover"    => ( "yes" === $settings["pause_on_hover"] ? true : false ),
            "draggable" => ( "yes" === $settings["draggable"] && ! \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ),
            "velocity"          => ( $settings["velocity"]["size"] ? $settings["velocity"]["size"] : 1 ),
            "finite"            => ( $settings["finite"] ? false : true ),
        ] ) ],
        ],
        ] );
        //function call
        $this->adv_anim();
        $this->add_render_attribute( 'slideshow', 'id', 'royaltech-' . $this->get_id() );
		
		if($skin_name == 'general' OR $skin_name == 'regal' OR $skin_name == 'crelly' OR $skin_name == 'meteor'){
		?>
		<div class="royaltech-prime-slider">
			<div <?php 
        $this->print_render_attribute_string( 'slider' );
        ?>>
				<div class="royaltech-position-relative royaltech-visible-toggle" <?php 
        $this->print_render_attribute_string( 'slideshow' );
        ?>>
					<ul <?php 
        $this->print_render_attribute_string( 'slideshow-items' );
        ?>>			
		<?php 
		} elseif($skin_name == 'slide'){
		?>
			<div class="royaltech-prime-slider">
				<div <?php 
        $this->print_render_attribute_string( 'slider' );
        ?>>
				<div class="royaltech-position-relative royaltech-visible-toggle" <?php 
        $this->print_render_attribute_string( 'slideshow' );
        ?>>
					<ul class="royaltech-slideshow-items">
		<?php 
			
		} else{
			
		}  
		
    }
    
    public function render_footer(){
		$settings = $this->get_active_settings();
		$slider_skin = $settings['slider_skin'];
		if($slider_skin == 'general'){
            ?>
            </ul>
            <?php 
            $this->render_navigation_arrows();

            $this->render_navigation_dots();
            ?>
                    </div>
                    <?php 
            $this->render_social_link();

            $this->render_scroll_button();
            ?>
                </div>
            </div>
            <?php 

        } elseif($slider_skin == 'regal'){
            ?>
            </ul>
            <?php 
            $this->render_navigation_arrows();

            $this->render_navigation_dots();
            ?>
                    </div>
                    <?php 
            $this->render_social_link();

            $this->render_scroll_button();
            ?>
                </div>
            </div>
            <?php 


		} elseif($slider_skin == 'slide'){
            ?>          
                    </ul>  
                        <?php 
            $this->render_navigation_arrows();
            ?>
                        <?php 
            $this->render_navigation_dots();
            ?>
                    </div>
                </div>
            </div>
            <?php 
		
		} elseif ($slider_skin =='crelly'){	
            ?>
            </ul>   
                    <?php 
            $this->render_navigation_arrows();
            ?>
                    <?php 
            $this->render_navigation_dots();
            ?>
                    </div>
                    <?php 
            $this->render_social_link( 'top', true, [
                'royaltech-flex',
                'royaltech-flex-middle',
                'royaltech-margin-large-bottom',
                'royaltech-position-bottom-right'
            ] );
            ?>
            </div>
        </div>		
		<?php 	
		} elseif ($slider_skin =='meteor'){
			
		?>
        </ul>

                <?php 
        $this->render_navigation_dots();
        ?>

                    <div class="royaltech-prime-slider-footer-content royaltech-height-small royaltech-flex-middle royaltech-position-bottom-right" royaltech-grid>
                        <div class="royaltech-width-1-6">
                            <?php 
        $this->render_scroll_button();
        ?>
                        </div>
                        <div class="royaltech-width-1-6">
                            <div class="royaltech-slide-thumbnav-img royaltech-height-small">
                                <?php 
        $slide_index = 1;
        foreach ( $settings['slides'] as $slide ) {
            ?>
                                    <li royaltech-slideshow-item="<?php 
            echo  ( $slide_index - 2 == -1 ? $this->total_slides - 2 : $slide_index - 2 ) ;
            ?>" data-label="<?php 
            echo  str_pad(
                $slide_index,
                2,
                '0',
                STR_PAD_LEFT
            ) ;
            ?>">

            <?php 
            
            if ( $slide['background'] == 'image' && $slide['image'] ) {
                $this->rendar_item_image( $slide, $slide['title'] );

            } elseif ( $slide['background'] == 'video' && $slide['video_link'] ) {
                $this->rendar_item_video( $slide );

            } elseif ( $slide['background'] == 'youtube' && $slide['youtube_link'] ) {
                $this->rendar_item_youtube( $slide );
            }
            
            ?>

                                    </li>
                                <?php 
            $slide_index++;
        }
        ?>
                            </div>
                        </div>
                        <div class="royaltech-width-expand royaltech-social-background royaltech-height-small">
                            <ul class="royaltech-ps-meta">
                                <?php 
			$slide_index = 1;
			foreach ( $settings['slides'] as $slide ) {
            ?>
                                    <li royaltech-slideshow-item="<?php 
            echo  $slide_index - 1 ;
            ?>" data-label="<?php 
            echo  str_pad(
                $slide_index,
                2,
                '0',
                STR_PAD_LEFT
            ) ;
            ?>">
                                        <?php 
            
            if ( $slide['excerpt'] && 'yes' == $settings['show_excerpt'] ) {
                ?>
                                            <div class="royaltech-slider-excerpt" data-reveal="reveal-active" data-royaltech-slideshow-parallax="y: 300,0,-100; opacity: 1,1,0">
                                                <?php 
                echo  wp_kses_post( $slide['excerpt'] ) ;
                ?>
                                            </div>
                                        <?php 
            }
            
            ?>

                                    </li>
                                <?php 
            $slide_index++;
        }
        ?>

                            </ul>
                        </div>
                        <div class="royaltech-width-1-6 royaltech-flex royaltech-flex-middle royaltech-flex-center royaltech-height-small  royaltech-social-bg-color royaltech-padding-remove">
                            <?php 
        $this->render_social_link( 'top' );
        ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>		
		<?php		
		} else{
			
		}
    }
    
    public function render_social_link( $position = 'right', $label = false, $class = array() ){
        $settings = $this->get_active_settings();
        if ( '' == $settings['show_social_icon'] ) {
            return;
        }
        $this->add_render_attribute( 'social-icon', 'class', 'royaltech-prime-slider-social-icon reveal-muted' );
        $this->add_render_attribute( 'social-icon', 'class', $class );
        ?>

		<div <?php 
        $this->print_render_attribute_string( 'social-icon' );
        ?>>

			<?php 
        
        if ( $label ) {
            ?>
				<?php 
            
            if ( '' !== $settings['show_share_us'] ) {
                ?>
					<h3><?php 
                esc_html_e( 'Share Us', 'royal-addons-for-elementor' );
                ?></h3>
				<?php 
            }
            
            ?>
			<?php 
        }
        
        ?>

			<?php 
        foreach ( $settings['social_link_list'] as $link ) {
            $tooltip = ( 'yes' == $settings['social_icon_tooltip'] ? ' title="' . esc_attr( $link['social_link_title'] ) . '" royaltech-tooltip="pos: ' . $position . '"' : '' );
            ?>

				<a class="royaltech-social-animate" href="<?php 
            echo  esc_url( $link['social_link'] ) ;
            ?>" target="_blank" <?php 
            echo  wp_kses_post( $tooltip ) ;
            ?>>
					<?php 
            Icons_Manager::render_icon( $link['social_icon'], [
                'aria-hidden' => 'true',
                'class'       => 'fa-fw',
            ] );
            ?>
				</a>
			<?php 
        }
        ?>
		</div>

	<?php 
    }
    
    public function render_scroll_button_text( $settings ){
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'content-wrapper', 'class', 'royaltech-scroll-down-content-wrapper' );
        $this->add_render_attribute( 'text', 'class', 'royaltech-scroll-down-text' );
        ?>
		<span royaltech-scrollspy="cls: royaltech-animation-slide-right; repeat: true" <?php 
        $this->print_render_attribute_string( 'content-wrapper' );
        ?>>
			<span class="royaltech-scroll-icon">

				<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 64" style="enable-background:new 0 0 64 64;" xml:space="preserve">
					<g>
						<g>
							<polygon points="31,0 31,60.586 23.707,53.293 22.293,54.854 31.293,64 32.707,64 41.707,54.854 40.293,53.366 33,60.586 33,0 " />
						</g>
					</g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
					<g></g>
				</svg>

			</span>
			<span <?php 
        $this->print_render_attribute_string( 'text' );
        ?>><?php 
        echo  wp_kses( $settings['scroll_button_text'], Royal_Helpers::royal_allow_tags( 'title' ) ) ;
        ?></span>
		</span>
	<?php 
    }
    
    public function render_scroll_button(){
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'royaltech-scroll-down', 'class', [ 'royaltech-scroll-down reveal-muted' ] );
		$slider_skin = $settings['slider_skin'];
		

		
		if($slider_skin =='general'){
			$durationsize = $settings['duration']['size'];
			$offsetsize = $settings['offset']['size'];			
		} elseif($slider_skin =='regal'){
            $durationsize = $settings['duration']['size'];
			$offsetsize = $settings['offset']['size'];
		} else{
			$durationsize = 0;
			$offsetsize = 0;
		}
		
        if ( '' == $settings['show_scroll_button'] ) {
            return;
        }
        $this->add_render_attribute( [
            'royaltech-scroll-down' => [
            'data-settings' => [ wp_json_encode( array_filter( [
            'duration' => ( '' != $durationsize ? $durationsize : '' ),
            'offset'   => ( '' != $offsetsize ? $offsetsize : '' ),
        ] ) ) ],
        ],
        ]);
        $this->add_render_attribute( 'royaltech-scroll-down', 'data-selector', '#' . esc_attr( $settings['section_id'] ) );
        $this->add_render_attribute( 'royaltech-scroll-wrapper', 'class', 'royaltech-scroll-down-wrapper' );
        ?>
		<div <?php 
        $this->print_render_attribute_string( 'royaltech-scroll-wrapper' );
        ?>>
			<button aria-label="Scroll Down" <?php 
        $this->print_render_attribute_string( 'royaltech-scroll-down' );
        ?>>
				<?php 
        $this->render_scroll_button_text( $settings );
        ?>
			</button>
		</div>

	<?php 
    }
    
    public function render_navigation_arrows(){
        $settings = $this->get_settings_for_display();
        $slider_skin = $settings['slider_skin'];
        
        if ( $settings['show_navigation_arrows'] ) {
			if($slider_skin =="general"){
                $this->add_render_attribute( 'navi_arrow_animate', 'class', 'reveal-muted' );
                ?>
                <div <?php 
                $this->print_render_attribute_string( 'navi_arrow_animate' );
                ?>>
                    <a class="royaltech-position-bottom-right royaltech-prime-slider-previous" href="#" royaltech-slidenav-previous royaltech-slideshow-item="previous"></a>
                    <a class="royaltech-position-bottom-right royaltech-prime-slider-next" href="#" royaltech-slidenav-next royaltech-slideshow-item="next"></a>
                </div>
                <?php 

            } elseif ($slider_skin =='regal'){
                $this->add_render_attribute( 'navi_arrow_animate', 'class', 'reveal-muted' );
                ?>
                <div <?php 
                $this->print_render_attribute_string( 'navi_arrow_animate' );
                ?>>
                    <a class="royaltech-position-bottom-right royaltech-prime-slider-previous" href="#" royaltech-slidenav-previous royaltech-slideshow-item="previous"></a>
                    <a class="royaltech-position-bottom-right royaltech-prime-slider-next" href="#" royaltech-slidenav-next royaltech-slideshow-item="next"></a>
                </div>
                <?php 

			} elseif ($slider_skin =='slide'){
			    ?>
				<div class="royaltech-navigation-arrows royaltech-position-center-right reveal-muted">
                    <a class="royaltech-prime-slider-previous" href="#" royaltech-slidenav-previous royaltech-slideshow-item="previous"></a>
                    <a class="royaltech-prime-slider-next" href="#" royaltech-slidenav-next royaltech-slideshow-item="next"></a>
                </div>
			    <?php	

			} elseif ($slider_skin =='crelly'){	
			    ?>
				<div class="royaltech-navigation-arrows royaltech-position-bottom-left royaltech-margin-large-bottom reveal-muted">
                    <a class="royaltech-prime-slider-previous" href="#" royaltech-slidenav-previous royaltech-slideshow-item="previous" ></a>
        
                    <a class="royaltech-prime-slider-next" href="#" royaltech-slidenav-next royaltech-slideshow-item="next"></a>

                    <ul class="royaltech-ps-counternav royaltech-position-bottom royaltech-visible@s">
                        <?php 
					$slide_index = 1;
					foreach ( $settings['slides'] as $slide ) {
						?>
									<li royaltech-slideshow-item="<?php 
						echo  $slide_index - 1 ;
						?>" data-label="<?php 
						echo  str_pad(
							$slide_index,
							2,
							'0',
							STR_PAD_LEFT
						) ;
						?>" ><a href="#"><?php 
						echo  str_pad(
							$slide_index,
							2,
							'0',
							STR_PAD_LEFT
						) ;
						?></a></li>
								<?php 
						$slide_index++;
					}
					?>
                        <span><?php 
				echo str_pad(
                $slide_index - 1,
                2,
                '0',
                STR_PAD_LEFT
            ) ;
            ?></span>
                    </ul>
                </div>			
			<?php 
			} else{
				
			}

		}
    }
    
    public function render_navigation_dots(){
        $settings = $this->get_settings_for_display();
		$slider_skin = $settings['slider_skin'];
        
        if ( $settings['show_navigation_dots'] ) {
			if($slider_skin =="general"){
                ?>
                <div <?php 
                $this->print_render_attribute_string( 'navi_dots_animate' );
                ?>>
                    <ul class="royaltech-slideshow-nav royaltech-dotnav royaltech-margin-large royaltech-position-bottom-left royaltech-text-center reveal-muted"></ul>
                </div>
                <?php 

            } elseif ($slider_skin =='regal'){
                ?>
                <div <?php 
                $this->print_render_attribute_string( 'navi_dots_animate' );
                ?>>
                    <ul class="royaltech-slideshow-nav royaltech-dotnav royaltech-margin-large royaltech-position-bottom-left royaltech-text-center reveal-muted"></ul>
                </div>
                <?php 
                
			} elseif ($slider_skin =='slide'){
			?>
			<ul class="royaltech-dotnav royaltech-dotnav-vertical royaltech-margin-bottom-100 royaltech-margin-left-100 royaltech-position-bottom-left royaltech-text-center reveal-muted">
            <?php 
            $slide_index = 1;
            foreach ( $settings['slides'] as $slide ) {
                ?>
                    <li royaltech-slideshow-item="<?php 
                echo  $slide_index - 1 ;
                ?>" data-label="<?php 
                echo  str_pad(
                    $slide_index,
                    2,
                    '0',
                    STR_PAD_LEFT
                ) ;
                ?>" ><a href="#"></a></li>
                    <?php 
                $slide_index++;
            }
            ?>
			</ul>			
			<?php
			
			} elseif ($slider_skin =='crelly'){	
			?>
			<ul class="royaltech-slideshow-nav royaltech-dotnav royaltech-dotnav-vertical royaltech-position-center-left reveal-muted"></ul>
			<?php 
			
			} elseif ($slider_skin =='meteor'){	
			?>
			<ul class="royaltech-slideshow-nav royaltech-dotnav royaltech-dotnav-vertical royaltech-margin-large-right royaltech-position-center-right reveal-muted"></ul>
			
			<?php
			} else{
				
			}
        }
    }
    
    public function rendar_item_image($image, $alt = '' ){
        $settings = $this->get_settings_for_display();
		$slider_skin = $settings['slider_skin'];
		
		if($slider_skin =='general' OR $slider_skin =='regal' OR $slider_skin =='crelly' OR $slider_skin =='slide'){
        $image_src = Group_Control_Image_Size::get_attachment_image_src( $image['image']['id'], 'thumbnail_size', $settings );
        if ( $image_src ) {
            $image_final_src = $image_src;
        } elseif ( $image['image']['url'] ) {
            $image_final_src = $image['image']['url'];
        } else {
            return;
        }
        ?>
		<div class="royaltech-ps-slide-img" style="background-image: url('<?php 
        echo  esc_url( $image_final_src ) ;
        ?>')"></div>
		
		<?php
		} elseif ($slider_skin =='meteor'){
			$image_src = wp_get_attachment_image_src( $image['image']['id'], 'thumbnail' );
			if ( $image_src ) {
				?>
			<img src="<?php 
				echo  esc_url( $image_src[0] ) ;
				?>" alt="<?php 
				echo  esc_html( $image['title'] ) ;
				?>" royaltech-cover>
			<?php 
			}
			return 0;
		
		}else{
			
		}
    }
    
    public function rendar_item_video( $link ){
        $video_src = $link['video_link'];
        ?>
		<video autoplay loop muted playsinline royaltech-cover>
			<source src="<?php 
        echo  $video_src ;
        ?>" type="video/mp4">
		</video>
	<?php 
    }
    
    public function rendar_item_youtube( $link ){
        $match = [];
        $id = ( preg_match( '%(?:youtube(?:-nocookie)?\\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\\.be/)([^"&?/ ]{11})%i', $link['youtube_link'], $match ) ? $match[1] : false );
        $url = '//www.youtube.com/embed/' . $id . '?autoplay=1&amp;mute=1&amp;controls=0&amp;showinfo=0&amp;rel=0&amp;loop=1&amp;modestbranding=1&amp;wmode=transparent&amp;playsinline=1&playlist=' . $id;
        ?>
		<iframe src="<?php 
        echo  esc_url( $url ) ;
        ?>" allowfullscreen royaltech-cover></iframe>
	<?php 
    }
    
    public function render_button( $content ){
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute(
            'slider-button',
            'class',
            'royaltech-slide-btn',
            true
        );
        $this->add_render_attribute(
            'slider-button',
            'data-reveal',
            'reveal-active',
            true
        );
        
        if ( isset( $content['button_link']['url'] ) && !empty($content['button_link']['url']) ) {
            $this->add_render_attribute(
                'slider-button',
                'href',
                $content['button_link']['url'],
                true
            );
            
            if ( $content['button_link']['is_external'] ) {
                $this->add_render_attribute(
                    'slider-button',
                    'target',
                    '_blank',
                    true
                );
            } else {
                $this->add_render_attribute(
                    'slider-button',
                    'target',
                    '_self',
                    true
                );
            }
            
            if ( $content['button_link']['nofollow'] ) {
                $this->add_render_attribute(
                    'slider-button',
                    'rel',
                    'nofollow',
                    true
                );
            }
        } else {
            $this->add_render_attribute(
                'slider-button',
                'href',
                'javascript:void(0);',
                true
            );
        }
        
        ?>

		<?php 
        
        if ( $content['slide_button_text'] && 'yes' == $settings['show_button_text'] ) {
            ?>

			<a <?php 
            $this->print_render_attribute_string( 'slider-button' );
            ?>>

				<?php 
            $this->add_render_attribute(
                [
                'content-wrapper' => [
                'class' => 'royaltech-prime-slider-button-wrapper',
            ],
                'text'            => [
                'class' => 'royaltech-prime-slider-button-text royaltech-flex royaltech-flex-middle royaltech-flex-inline',
            ],
            ],
                '',
                '',
                true
            );
            ?>
			<span <?php $this->print_render_attribute_string( 'content-wrapper' ); ?>>
                <span <?php $this->print_render_attribute_string( 'text' ); ?>><?php 
                echo wp_kses( $content['slide_button_text'], Royal_Helpers::royal_allow_tags( 'title' ) ) ;
                if ( $settings['show_button_icon'] == 'yes' ) {
                    echo '<span class="buttonicon">';
                    \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); 
                    echo '</span>';
                }
                ?>
                </span>
            </span>
			</a>
		<?php 
        }
    
    }
    


    public function render_item_content( $slide_content ){
        $settings = $this->get_settings_for_display();
		$slider_skin = $settings['slider_skin'];
		if($slider_skin =='general' OR $slider_skin =='crelly' OR $slider_skin =='slide'){	

            $parallax_button = $parallax_sub_title = $parallax_title = $parallax_inner_excerpt = $parallax_excerpt = '';
            
            if ( $settings['animation_parallax'] == 'yes' ) {
                $parallax_sub_title = 'data-royaltech-slideshow-parallax="x: 50,0,-10; opacity: 1,1,0"';
                $parallax_title = 'data-royaltech-slideshow-parallax="x: 100,0,-20; opacity: 1,1,0"';
                $parallax_inner_excerpt = 'data-royaltech-slideshow-parallax="x: 120,0,-30; opacity: 1,1,0"';
                $parallax_excerpt = 'data-royaltech-slideshow-parallax="y: 50,0,-10; opacity: 1,1,0"';
                $parallax_button = 'data-royaltech-slideshow-parallax="x: 150,0,-30; opacity: 1,1,0"';
            }
        
            $this->add_render_attribute( 'slide_content_animate', 'class', 'royaltech-prime-slider-content' );
            
            if ( $slide_content['title'] ) {
                $title_link_href = ( isset( $slide_content['title_link']['url'] ) ? esc_url( $slide_content['title_link']['url'] ) : 'javascript:void(0);' );
                $title_link_target = ( $slide_content['title_link']['is_external'] ? '_blank' : '_self' );
                $this->add_render_attribute(
                    [
                    'title-link' => [
                    'class'  => [ 'royaltech-slider-title-link' ],
                    'href'   => $title_link_href,
                    'target' => $title_link_target,
                ],
                ],
                    '',
                    '',
                    true
                );
            }
            
            ?>
            <div class="royaltech-position-z-index royaltech-position-large">
                <div class="royaltech-prime-slider-wrapper">
                    <div <?php $this->print_render_attribute_string( 'slide_content_animate' ); ?>>
                        <div class="royaltech-prime-slider-desc">
                            <?php if ( $slide_content['sub_title'] && 'yes' == $settings['show_sub_title'] ) { ?>
                                <div class="royaltech-sub-title">
                                    <h4 data-reveal="reveal-active" class="royaltech-ps-sub-title" <?php echo  $parallax_sub_title ; ?>>
                                        <?php echo  wp_kses_post( $slide_content['sub_title'] ) ; ?>
                                    </h4>
                                </div>
                            <?php }
            
                        if ( $slide_content['title'] && 'yes' == $settings['show_title'] ) { ?>
                            <div data-reveal="reveal-active" class="royaltech-main-title" <?php echo  $parallax_title; ?>>
                                    <<?php echo wp_kses_post( $settings['title_html_tag'] ); ?> class="royaltech-title-tag">
                                        <?php if ( '' !== $slide_content['title_link']['url'] ) { ?>
                                            <a <?php $this->print_render_attribute_string( 'title-link' ); ?>>
                                            <?php } ?>
                                            <?php echo wp_kses_post( $slide_content['title'] ) ; ?>
                                            <?php if ( '' !== $slide_content['title_link']['url'] ) { ?>
                                            </a>
                                        <?php } ?>
                                    </<?php echo wp_kses_post( $settings['title_html_tag'] ); ?>>
                                </div>
                            <?php } ?>

                            <?php if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] && 'yes' == $settings['alter_btn_excerpt'] ) { ?>
                                <div data-reveal="reveal-active" class="royaltech-slider-excerpt" <?php echo  $parallax_inner_excerpt; ?>>
                                    <?php echo  wp_kses_post( $slide_content['excerpt'] ) ; ?>
                                </div>
                            <?php } ?>

                            <div <?php echo  $parallax_button ; ?>>
                                <div class="royaltech-btn-wrapper">
                                    <?php $this->render_button( $slide_content ); ?>
                                </div>
                            </div>
                        </div>

                        <?php if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] && '' == $settings['alter_btn_excerpt'] ) { ?>
                            <div data-reveal="reveal-active" class="royaltech-slider-excerpt" <?php echo $parallax_excerpt ;?>>
                                <?php echo wp_kses_post( $slide_content['excerpt'] ); ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <?php 


		} elseif ($slider_skin =='regal'){	
            $parallax_button = $parallax_sub_title = $parallax_title = $parallax_inner_excerpt = $parallax_excerpt = '';
            
            if ( $settings['animation_parallax'] == 'yes' ) {
                $parallax_image = 'data-royaltech-slideshow-parallax="x: -250,0,10; opacity: 1,1,0"';
                $parallax_sub_title = 'data-royaltech-slideshow-parallax="y: 50,0,-10; opacity: 1,1,0"';
                $parallax_title = 'data-royaltech-slideshow-parallax="y: 100,0,-20; opacity: 1,1,0"';
                $parallax_inner_excerpt = 'data-royaltech-slideshow-parallax="y: 120,0,-30; opacity: 1,1,0"';
                $parallax_excerpt = 'data-royaltech-slideshow-parallax="y: 50,0,-10; opacity: 1,1,0"';
                $parallax_button = 'data-royaltech-slideshow-parallax="y: 150,0,-30; opacity: 1,1,0"';
            }
        
            $this->add_render_attribute( 'slide_content_animate', 'class', 'royaltech-prime-slider-content' );
            
            if ( $slide_content['title'] ) {
                $title_link_href = ( isset( $slide_content['title_link']['url'] ) ? esc_url( $slide_content['title_link']['url'] ) : 'javascript:void(0);' );
                $title_link_target = ( $slide_content['title_link']['is_external'] ? '_blank' : '_self' );
                $this->add_render_attribute(
                    [
                    'title-link' => [
                    'class'  => [ 'royaltech-slider-title-link' ],
                    'href'   => $title_link_href,
                    'target' => $title_link_target,
                ],
                ],
                    '',
                    '',
                    true
                );
            }
            
            ?>
            <div class="royaltech-position-z-index royaltech-position-large">
                <div class="royaltech-prime-slider-wrapper">
                    <div class="optionalimage" data-reveal="reveal-active" <?php echo  $parallax_image ; ?>>
                    <?php echo '<img src="' . $slide_content['optional_image']['url'] . '">';?>
                    </div>


                    <div <?php $this->print_render_attribute_string( 'slide_content_animate' ); ?>>
                        <div class="royaltech-prime-slider-desc">

                            <?php if ( $slide_content['sub_title'] && 'yes' == $settings['show_sub_title'] ) { ?>
                                <div class="royaltech-sub-title">
                                    <h4 data-reveal="reveal-active" class="royaltech-ps-sub-title" <?php echo  $parallax_sub_title ; ?>>
                                        <?php echo  wp_kses_post( $slide_content['sub_title'] ) ; ?>
                                        
                                    </h4>
                                </div>
                            <?php }
            
                        if ( $slide_content['title'] && 'yes' == $settings['show_title'] ) { ?>
                            <div data-reveal="reveal-active" class="royaltech-main-title" <?php echo  $parallax_title; ?>>
                                    <<?php echo wp_kses_post( $settings['title_html_tag'] ); ?> class="royaltech-title-tag">
                                        <?php if ( '' !== $slide_content['title_link']['url'] ) { ?>
                                            <a <?php $this->print_render_attribute_string( 'title-link' ); ?>>
                                            <?php } ?>
                                            <?php echo wp_kses_post( $slide_content['title'] ) ; ?>
                                            <?php if ( '' !== $slide_content['title_link']['url'] ) { ?>
                                            </a>
                                        <?php } ?>
                                    </<?php echo wp_kses_post( $settings['title_html_tag'] ); ?>>
                                </div>
                            <?php } ?>

                            <?php if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] && 'yes' == $settings['alter_btn_excerpt'] ) { ?>
                                <div data-reveal="reveal-active" class="royaltech-slider-excerpt" <?php echo  $parallax_inner_excerpt; ?>>
                                    <?php echo  wp_kses_post( $slide_content['excerpt'] ) ; ?>
                                </div>
                            <?php } ?>

                            <?php if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] && '' == $settings['alter_btn_excerpt'] ) { ?>
                            <div data-reveal="reveal-active" class="royaltech-slider-excerpt" <?php echo $parallax_excerpt ;?>>
                                <?php echo wp_kses_post( $slide_content['excerpt'] ); ?>
                            </div>
                            <?php } ?>

                            <div <?php echo  $parallax_button ; ?>>
                                <div class="royaltech-btn-wrapper">
                                    <?php $this->render_button( $slide_content ); ?>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <?php 


		} elseif ($slider_skin =='meteor'){	
		$this->add_render_attribute(
            [
            'title-link' => [
            'class'  => [ 'royaltech-slider-title-link' ],
            'href'   => ( $slide_content['title_link']['url'] ? esc_url( $slide_content['title_link']['url'] ) : 'javascript:void(0);' ),
            'target' => ( $slide_content['title_link']['is_external'] ? '_blank' : '_self' ),
        ],
        ],
            '',
            '',
            true
        );
        $parallax_sub_title = 'data-royaltech-slideshow-parallax="x: 300,0,-100; opacity: 1,1,0"';
        $parallax_title = 'data-royaltech-slideshow-parallax="x: 500,0,-100; opacity: 1,1,0"';
        $parallax_excerpt = 'data-royaltech-slideshow-parallax="y: 200,0,-100; opacity: 1,1,0"';
        ?>
        <div class="royaltech-prime-slider-container">
            <div class="royaltech-slideshow-content-wrapper royaltech-position-z-index">
                <div class="royaltech-prime-slider-wrapper">
                    <div class="royaltech-prime-slider-content">
                        <div class="royaltech-prime-slider-desc">

                            <?php 
        
        if ( $slide_content['sub_title'] && 'yes' == $settings['show_sub_title'] ) {
            ?>
                                <div class="royaltech-sub-title royaltech-ps-sub-title">
                                    <h4 <?php 
            echo  $parallax_sub_title ;
            ?> data-reveal="reveal-active">
                                        <?php 
            echo  wp_kses_post( $slide_content['sub_title'] ) ;
            ?>
                                    </h4>
                                </div>
                            <?php 
        }
        
        ?>

                            <?php 
        
        if ( $slide_content['title'] && 'yes' == $settings['show_title'] ) {
            ?>
                                <div class="royaltech-main-title"  <?php 
            echo  $parallax_title ;
            ?> data-reveal="reveal-active">
                                    <<?php 
            echo wp_kses_post( $settings['title_html_tag'] );
            ?> class="royaltech-title-tag">
                                        <?php 
            
            if ( '' !== $slide_content['title_link']['url'] ) {
                ?>
                                            <a <?php 
                $this->print_render_attribute_string( 'title-link' );
                ?>>
                                        <?php 
            }
            
            ?>
                                            <?php 
            echo  wp_kses_post( $slide_content['title'] ) ;
            ?>
                                        <?php 
            if ( '' !== $slide_content['title_link']['url'] ) {
                ?>
                                            </a>
                                        <?php 
            }
            ?>
                                    </<?php 
            echo wp_kses_post( $settings['title_html_tag'] );
            ?>>
                                </div>
                            <?php 
        }
        
        ?>

                            <div data-royaltech-slideshow-parallax="x: 700,0,-100; opacity: 1,1,0">

                                <?php 
        $this->render_button( $slide_content );
        ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
		
		<?php		
		}else{
			
		}
    }
    
    public function render_slides_loop(){
        $settings = $this->get_settings_for_display();
		$slider_skin = $settings['slider_skin'];

        $kenburns_reverse = ( $settings['kenburns_reverse'] ? ' royaltech-animation-reverse' : '' );
        foreach ( $settings['slides'] as $slide ) {
			if($slider_skin == 'general'){
            ?>
			<li class="royaltech-slideshow-item royaltech-flex royaltech-flex-middle royaltech-flex-center elementor-repeater-item-<?php 
            echo  esc_attr( $slide['_id'] ) ;
            ?>">
				<?php 
            
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
					<div class="royaltech-position-cover royaltech-animation-kenburns<?php 
                echo  esc_attr( $kenburns_reverse ) ;
                ?> royaltech-transform-origin-center-left">
					<?php 
            }
            
            if ( $slide['background'] == 'image' && $slide['image'] ) {
                $this->rendar_item_image( $slide, $slide['title'] );
            } elseif ( $slide['background'] == 'video' && $slide['video_link'] ) {
                $this->rendar_item_video( $slide );
            } elseif ( $slide['background'] == 'youtube' && $slide['youtube_link'] ) {
                $this->rendar_item_youtube( $slide );
            }
            
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
					</div>
				<?php 
            }
            
            if ( 'none' !== $settings['overlay'] ) {
                $blend_type = ( 'blend' == $settings['overlay'] ? ' royaltech-blend-' . $settings['blend_type'] : '' );
                ?>
					<div class="royaltech-overlay-default royaltech-position-cover<?php 
                echo  esc_attr( $blend_type ) ;
                ?>"></div>
				<?php 
            }
            
            ?>

				<?php 
            $this->render_item_content( $slide );
            ?>
			</li>
			<?php 
			

			} elseif($slider_skin=='regal'){
                ?>
			<li class="royaltech-slideshow-item royaltech-flex royaltech-flex-middle royaltech-flex-center elementor-repeater-item-<?php 
            echo  esc_attr( $slide['_id'] ) ;
            ?>">
				<?php 
            
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
					<div class="royaltech-position-cover royaltech-animation-kenburns<?php 
                echo  esc_attr( $kenburns_reverse ) ;
                ?> royaltech-transform-origin-center-left">
					<?php 
            }
            
            
            if ( $slide['background'] == 'image' && $slide['image'] ) {
                $this->rendar_item_image( $slide, $slide['title'] );

            } elseif ( $slide['background'] == 'video' && $slide['video_link'] ) {
                $this->rendar_item_video( $slide );
   
            } elseif ( $slide['background'] == 'youtube' && $slide['youtube_link'] ) {
                $this->rendar_item_youtube( $slide );

            }

            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
					</div>
				<?php 
            }

            
            if ( 'none' !== $settings['overlay'] ) {
                $blend_type = ( 'blend' == $settings['overlay'] ? ' royaltech-blend-' . $settings['blend_type'] : '' );
                ?>
					<div class="royaltech-overlay-default royaltech-position-cover<?php 
                echo  esc_attr( $blend_type ) ;
                ?>"></div>
				<?php 
            }

            $this->render_item_content( $slide );
            ?>
			</li>
			<?php 



			} elseif($slider_skin=='slide'){
			?> 
            <li class="royaltech-slideshow-item royaltech-flex royaltech-flex-middle royaltech-flex-center elementor-repeater-item-<?php 
            echo  esc_attr( $slide['_id'] ) ;
            ?>">
                <?php 
            
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
                    <div class="royaltech-position-cover royaltech-animation-kenburns<?php 
                echo  esc_attr( $kenburns_reverse ) ;
                ?> royaltech-transform-origin-center-left">
                <?php 
            }

            if ( $slide['background'] == 'image' && $slide['image'] ) {
                ?>
                        <?php 
                $this->rendar_item_image( $slide, $slide['title'] );
                ?>
                    <?php 
            } elseif ( $slide['background'] == 'video' && $slide['video_link'] ) {
                ?>
                        <?php 
                $this->rendar_item_video( $slide );
                ?>
                    <?php 
            } elseif ( $slide['background'] == 'youtube' && $slide['youtube_link'] ) {
                ?>
                        <?php 
                $this->rendar_item_youtube( $slide );
                ?>
                    <?php 
            }
            
            ?>

                <?php 
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
                    </div>
                <?php 
            }
            ?>

                <?php 
            
            if ( 'none' !== $settings['overlay'] ) {
                $blend_type = ( 'blend' == $settings['overlay'] ? ' royaltech-blend-' . $settings['blend_type'] : '' );
                ?>
                    <div class="royaltech-overlay-default royaltech-position-cover<?php 
                echo  esc_attr( $blend_type ) ;
                ?>"></div>
                <?php 
            }
            
            ?>

                <?php 
            $this->rendar_item_content( $slide );
            ?>
            </li>
			<?php 	
			
			} elseif ($slider_skin =='crelly'){
			?>
			<li class="royaltech-slideshow-item royaltech-flex royaltech-flex-middle royaltech-flex-center elementor-repeater-item-<?php 
            echo  esc_attr( $slide['_id'] ) ;
            ?>">
                <?php 
            
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
                    <div class="royaltech-position-cover royaltech-animation-kenburns<?php 
                echo  esc_attr( $kenburns_reverse ) ;
                ?> royaltech-transform-origin-center-left">
                <?php 
            }
            
            ?>

                    <?php 
            
            if ( $slide['background'] == 'image' && $slide['image'] ) {
                ?>
                        <?php 
                $this->rendar_item_image( $slide, $slide['title'] );
                ?>
                    <?php 
            } elseif ( $slide['background'] == 'video' && $slide['video_link'] ) {
                ?>
                        <?php 
                $this->rendar_item_video( $slide );
                ?>
                    <?php 
            } elseif ( $slide['background'] == 'youtube' && $slide['youtube_link'] ) {
                ?>
                        <?php 
                $this->rendar_item_youtube( $slide );
                ?>
                    <?php 
            }
            
            ?>

                <?php 
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
                    </div>
                <?php 
            }
            ?>

                <?php 
            
            if ( 'none' !== $settings['overlay'] ) {
                $blend_type = ( 'blend' == $settings['overlay'] ? ' royaltech-blend-' . $settings['blend_type'] : '' );
                ?>
                    <div class="royaltech-overlay-default royaltech-position-cover<?php 
                echo  esc_attr( $blend_type ) ;
                ?>"></div>
                <?php 
            }
            
            ?>

                <?php 
            $this->rendar_item_content( $slide );
            ?>
            </li>
			
			<?php 
			} elseif ($slider_skin =='meteor'){	
			?>
			<li class="royaltech-slideshow-item royaltech-flex royaltech-flex-middle elementor-repeater-item-<?php 
            echo  esc_attr( $slide['_id'] ) ;
            ?>">
                <?php 
            
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
                    <div class="royaltech-position-cover royaltech-animation-kenburns<?php 
                echo  esc_attr( $kenburns_reverse ) ;
                ?> royaltech-transform-origin-center-left">
                    <?php 
            }
            
            ?>

                    <?php 
            
            if ( $slide['background'] == 'image' && $slide['image'] ) {
                ?>
                        <?php 
                $this->rendar_item_image( $slide, $slide['title'] );
                ?>
                    <?php 
            } elseif ( $slide['background'] == 'video' && $slide['video_link'] ) {
                ?>
                        <?php 
                $this->rendar_item_video( $slide );
                ?>
                    <?php 
            } elseif ( $slide['background'] == 'youtube' && $slide['youtube_link'] ) {
                ?>
                        <?php 
                $this->rendar_item_youtube( $slide );
                ?>
                    <?php 
            }
            
            ?>

                    <?php 
            if ( 'yes' == $settings['kenburns_animation'] ) {
                ?>
                    </div>
                <?php 
            }
            ?>

                <?php 
            
            if ( 'none' !== $settings['overlay'] ) {
                $blend_type = ( 'blend' == $settings['overlay'] ? ' royaltech-blend-' . $settings['blend_type'] : '' );
                ?>
                    <div class="royaltech-overlay-default royaltech-position-cover<?php 
                echo  esc_attr( $blend_type ) ;
                ?>"></div>
                <?php 
            }
            
            ?>

                <?php 
            $this->render_item_content( $slide );
            ?>
            </li>
			<?php 
            $this->total_slides++;
			} else{
				
			}
		}	
    }
	public function rendar_item_content( $slide_content ){
        $settings = $this->get_settings_for_display();
		$slider_skin = $settings['slider_skin'];
		if ($slider_skin =='slide'){
        $this->add_render_attribute(
            [
            'title-link' => [
            'class'  => [ 'royaltech-slider-title-link' ],
            'href'   => ( $slide_content['title_link']['url'] ? esc_url( $slide_content['title_link']['url'] ) : 'javascript:void(0);' ),
            'target' => ( $slide_content['title_link']['is_external'] ? '_blank' : '_self' ),
        ],
        ],
            '',
            '',
            true
        );
        $parallax_sub_title = 'data-royaltech-slideshow-parallax="x: 50,0,-10; opacity: 1,1,0"';
        $parallax_title = 'data-royaltech-slideshow-parallax="x: 100,0,-20; opacity: 1,1,0"';
        $parallax_excerpt = 'data-royaltech-slideshow-parallax="y: 50,0,-10; opacity: 1,1,0"';
        ?>
        <div class="royaltech-ps-content-wrapper royaltech-position-z-index royaltech-position-large">
            <div class="royaltech-slide-shape" data-royaltech-slideshow-parallax="Y: -100,0,100; opacity: 1,1,0"></div>
            <div class="royaltech-prime-slider-wrapper">
                <div class="royaltech-prime-slider-content">
                    <div class="royaltech-prime-slider-desc">
                        <?php 
        
        if ( $slide_content['title'] && 'yes' == $settings['show_title'] ) {
            ?>
                            <div class="royaltech-main-title" <?php 
            echo  $parallax_title ;
            ?> data-reveal="reveal-active">
                                <<?php 
            echo wp_kses_post( $settings['title_html_tag'] );
            ?> class="royaltech-title-tag">
                                    <?php 
            
            if ( '' !== $slide_content['title_link']['url'] ) {
                ?>
                                        <a <?php 
                $this->print_render_attribute_string( 'title-link' );
                ?>>
                                    <?php 
            }
            ?>
                                        <?php 
            echo  wp_kses_post( $slide_content['title'] ) ;
            ?>
                                    <?php 
            if ( '' !== $slide_content['title_link']['url'] ) {
                ?>
                                        </a>
                                    <?php 
            }
            ?>
                                </<?php 
            echo wp_kses_post( $settings['title_html_tag'] );
            ?>>
                            </div>
                        <?php 
        }
        ?>

                        <?php 
        
        if ( $slide_content['sub_title'] && 'yes' == $settings['show_sub_title'] ) {
            ?>
                            <div class="royaltech-sub-title royaltech-ps-sub-title">
                                <h4 <?php 
            echo  $parallax_sub_title ;
            ?> data-reveal="reveal-active">
                                <?php 
            echo  wp_kses_post( $slide_content['sub_title'] ) ;
            ?>
                                </h4>
                            </div>
                        <?php 
        }
        ?>        
                    </div>
                </div>
            </div>

        </div>

        <div class="royaltech-slide-featured royaltech-flex">
            
            <?php 
        
        if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] ) {
            ?>
                <div class="royaltech-slider-excerpt" <?php 
            echo  $parallax_excerpt ;
            ?> data-reveal="reveal-active">
                    
                    <?php 
            echo  wp_kses_post( $slide_content['excerpt'] ) ;
            ?>

                </div>
            <?php 
        }
        
        ?>
            
            <div class="royaltech-prime-slider-arrow-button" data-royaltech-slideshow-parallax="x: 100,0,-50; opacity: 1,1,0">
               <?php 
        $this->render_button( $slide_content );
        ?>
            </div>

        </div>

        <?php 
		
		} elseif ($slider_skin =='crelly'){	
		$this->add_render_attribute(
            [
            'title-link' => [
                'class'  => [ 'royaltech-slider-title-link' ],
                'href'   => ( $slide_content['title_link']['url'] ? esc_url( $slide_content['title_link']['url'] ) : 'javascript:void(0);' ),
                'target' => ( $slide_content['title_link']['is_external'] ? '_blank' : '_self' ),
            ],
            ],
            '',
            '',
            true
        );
        $parallax_sub_title = 'data-royaltech-slideshow-parallax="x: 300,0,-100; opacity: 1,1,0"';
        $parallax_title = 'data-royaltech-slideshow-parallax="x: 500,0,-100; opacity: 1,1,0"';
        $parallax_excerpt = 'data-royaltech-slideshow-parallax="y: 200,0,-100; opacity: 1,1,0"';
        ?>

        <div class="royaltech-container">
            <div class="royaltech-slideshow-content-wrapper">
                <div class="royaltech-prime-slider-wrapper">
                    <div class="royaltech-prime-slider-content">
                        <div class="royaltech-prime-slider-desc">
                            <?php 
                            if ( $slide_content['sub_title'] && 'yes' == $settings['show_sub_title'] ) {
                            ?>
                                <div class="royaltech-sub-title royaltech-text-left royaltech-ps-sub-title">
                                    <h4 <?php echo  $parallax_sub_title ;?> data-reveal="reveal-active">
                                    <?php echo wp_kses_post( $slide_content['sub_title'] ) ; ?>
                                    </h4>
                                </div>
                            <?php } 
                            if ( $slide_content['title'] && 'yes' == $settings['show_title'] ) {?>
                                <div class="royaltech-main-title royaltech-text-left" <?php echo  $parallax_title; ?> data-reveal="reveal-active">
                                    <<?php echo wp_kses_post( $settings['title_html_tag'] ); ?> class="royaltech-title-tag">
                                        <?php 
                                if ( '' !== $slide_content['title_link']['url'] ) {
                                    echo '<a '.$this->print_render_attribute_string( 'title-link' ).'>';
                                }
                    
                                echo wp_kses_post( $slide_content['title'] ) ;

                                if ( '' !== $slide_content['title_link']['url'] ) {
                                    echo '</a>';
                                }

                                echo '</'. $settings['title_html_tag'].'>';
                
                                echo '</div>';
                                    
                            }
        
                        ?>
                        </div>  
                    </div>
                    <?php 
        
                    if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] ) {
                        echo '<div class="royaltech-slider-excerpt-content" '. $parallax_excerpt .'>';
                        
                        if ( $settings['show_otherview'] == 'yes' ) {
                            echo '<h3 data-reveal="reveal-active">'. $settings['otherview_text'] .'</h3>';
                        }
                        
                        ?>
                            <div class="royaltech-slider-excerpt" data-reveal="reveal-active">
                                <?php echo wp_kses_post( $slide_content['excerpt'] ) ; ?>
                            </div>
                            <div class="royaltech-crelly-btn" data-royaltech-slideshow-parallax="y: 200,0,-100; opacity: 1,1,0">
                                <?php 
                                $this->render_button( $slide_content );
                        ?>
                                    </div>
                                </div>
                                <?php 
                    }
                    
                    ?>
                </div>
            </div>
        </div>
		<?php
		
		}else{
			
		}
    }
    
    public function render(){
		$settings = $this->get_settings_for_display();
		$skin_name = $settings['slider_skin'];
        $this->render_header( $skin_name );
        $this->render_slides_loop();
        $this->render_footer();
    }

}
