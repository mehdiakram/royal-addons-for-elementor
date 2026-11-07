<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit;


class RoyalSliderNatural extends Widget_Base {

    public function get_name() {
        return 'royalslidernatural';
    }

    public function get_title() {
        return esc_html__( 'Natural Slider', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-slider-full-screen rtbranding'; }

    public function get_keywords() {
        return [ 'slide', 'image', 'nature', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

    public function get_categories() {
		return [ 'royaltech' ];
	}

    public function get_style_depends() {
        return [ 'royalslidernatural' ];
    }

    public function get_script_depends() {
        return ['royalslidernatural'];
    }


    protected function register_controls() {
		$this->royalslidernatural_slider();
		$this->royalslidernatural_slider_settings();

		$this->royalslidernatural_slider_title_style();
		$this->royalslidernatural_slider_sub_title_style();
		$this->royalslidernatural_slider_image_para_style();
		$this->royalslidernatural_slider_video_button_style();
		$this->royalslidernatural_slider_video_modal_style();
		$this->royalslidernatural_slider_social();
		$this->royalslidernatural_slider_naviation();
		$this->royalslidernatural_slider_pagination();
		$this->royalslidernatural_slider_indicator();
		
	}


    private function royalslidernatural_slider() {
		$this->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__( 'Slider', 'royal-addons-for-elementor' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'title',
            [
                'label'   => esc_html__( 'Image Title', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'label_block'=>true,
                'description' => esc_html__( 'Please add title', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'sub_title',
            [
                'label'   => esc_html__( 'Image Sub Title', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Natural',
                'label_block'=>true,
                'description' => esc_html__( 'Please add sub title', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Forground Image', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'background',
            [
                'label' => esc_html__( 'Background Image', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'imagedes',
            [
                'label'   => esc_html__( 'Image Description', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'label_block'=>true,
                'description' => esc_html__( 'Please add Image Description', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'videodes',
            [
                'label'   => esc_html__( 'Video Description', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'label_block'=>true,
                'description' => esc_html__( 'Please add Video Description', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'videotype',
            [
                'label' => esc_html__( 'Video Type', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube'       => esc_html__( 'Youtube', 'royal-addons-for-elementor' ),
                    'selfhosted'    => esc_html__( 'Shelf Hosted', 'royal-addons-for-elementor' ),
                    'external'      => esc_html__( 'External', 'royal-addons-for-elementor' ),
                ],
                'label_block'=>true,
            ]
        );

        $repeater->add_control(
            'youtube_url',
            [
                'label'     => esc_html__( 'Youtube Url', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'https://www.youtube.com/watch?v=k2kiyWu_XNc', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'condition'=>[
                    'videotype'=>'youtube',
                ],
            ]
        );

		$repeater->add_control(
			'selfhosted_url',
			[
				'label' => esc_html__( 'Choose Video File', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::MEDIA_CATEGORY,
					],
				],
				'media_types' => [
					'video',
				],
				'condition' => [
					'videotype' => [ 'selfhosted' ],
				],
			]
		);

        $repeater->add_control(
			'external_url',
			[
				'label' => esc_html__( 'External Video URL', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'videotype' => [ 'external' ],
				],
			]
		);

        $this->add_control(
            'slides',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'title'         => esc_html__('Parrots','royal-addons-for-elementor'),
                        'background'    => ['url' => Royal_Helpers::royalassetspath(). 'images/nature1.jpg' ],
                        'image'         => ['url' => Royal_Helpers::royalassetspath(). 'images/parrots.png' ],
                        'imagedes'      => 'Parrots, also known as psittacines are birds with a strong curved beak, upright stance, and clawed feet. They are conformed by four families that contain roughly 410 species in 101 genera, found mostly in tropical and subtropical regions.',
                        'videodes'      => 'Parrots, also known as psittacines are birds with a strong curved beak, upright stance, and clawed feet. They are conformed by four families that contain roughly 410 species in 101 genera, found mostly in tropical and subtropical regions.',
                        'videotype'     => 'youtube',
                    ],
                    [
                        'title'         => esc_html__('Bengal Tiger','royal-addons-for-elementor'),
                        'background'    => [ 'url' => Royal_Helpers::royalassetspath(). 'images/nature2.jpg' ],
                        'image'         => [ 'url' => Royal_Helpers::royalassetspath(). 'images/tiger.png' ],
                        'imagedes'      => 'The Royal Bengal tiger is a population of the Panthera tigris tigris subspecies and the nominate tiger subspecies. It ranks among the biggest wild cats alive today.',
                        'videodes'      => 'The Royal Bengal tiger is a population of the Panthera tigris tigris subspecies and the nominate tiger subspecies. It ranks among the biggest wild cats alive today.',
                        'videotype'     => 'youtube',
                    ]
                ],
                'title_field' => '{{{ title }}}',
            ]
        );
        
	$this->end_controls_section();
	}


    private function royalslidernatural_slider_settings() {
        $this->start_controls_section(
            'section_slider_settings',
            [
                'label' => esc_html__( 'Slider Settings', 'royal-addons-for-elementor' ),
            ]
        );
    
        $this->add_responsive_control(
			'slider_height',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Slider Height', 'royal-addons-for-elementor' ),
                'size_units' => [ 'vh', 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
                    'em' => [
						'min' => 1,
						'max' => 50,
					],
                    'rem' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'vh',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .royalslidernatural' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'interval',
			[
				'label' => esc_html__( 'Interval (Second)', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 30,
				'step' => .1,
				'default' => 8.5,
                'selectors' => [
					'{{WRAPPER}} .royalslidernatural .slide-indicator-bars .indicator-bar.active' => 'transition-duration: {{VALUE}}s;',
				],
			]
		);

        $this->add_control( 'title_html_tag', [
            'label'     => __( 'Title HTML Tag', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'h2',
			'options'   => Royal_Helpers::royal_title_tags(),
        ] );

        $this->add_control( 'sub_title_html_tag', [
            'label'     => __( 'Sub Title HTML Tag', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'h4',
			'options'   => Royal_Helpers::royal_title_tags(),
        ] );

        $this->add_control( 'show_video_button', [
            'label'   => esc_html__( 'Show Video Button', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control(
            'video_button_text',
            [
                'label'   => esc_html__( 'Watch Video', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Watch Video',
                'label_block'=>true,
                'condition' => [
                    'show_video_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
			'previousicon',
			[
				'label' => esc_html__( 'Previous Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
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
				'skin' => 'inline',
				'label_block' => false,    
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'solid',
				],
			]
		);

        $this->add_control( 'show_indicator', [
            'label'   => esc_html__( 'Show Indicator', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control( 'show_social', [
            'label'   => esc_html__( 'Show Social', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        
        $repeater = new Repeater();
		$repeater->add_control(
			'social_icon',
			[
				'label' => esc_html__( 'Icon', 'elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'elementor',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mix',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'telegram',
						'thumb-tack',
						'threads',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'x-twitter',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],
			]
		);

		$repeater->add_control(
			'social_link',
			[
				'label' => esc_html__( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'default' => [
					'is_external' => 'true',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'social_icon_list',
			[
				'label' => esc_html__( 'Social Icons', 'elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'condition' => [
                    'show_social' => 'yes',
                ],
				'default' => [
					[
						'social_icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
                        'social_link' => ['url' =>'http://www.facebook.com/RoyalTechnologies'],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
                        'social_link' => ['url' =>'http://www.twitter.com/mehdiakram'],
					],
					[
						'social_icon' => [
							'value' => 'fab fa-youtube',
							'library' => 'fa-brands',
						],
                        'social_link' => ['url' =>'https://www.youtube.com/@royaltechnologies3619'],
					],
				],
				'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
			]
		);
    $this->end_controls_section();
    }

    
    private function royalslidernatural_slider_title_style() { 
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'title_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royalslidernatural .slide .animal-name',
        ] );

        $this->add_group_control( Group_Control_Text_Stroke::get_type(), [
            'name'     => 'title_stroke',
            'label'    => esc_html__( 'Title Stroke', 'royal-addons-for-elementor' ) ,
            'selector' => '{{WRAPPER}} .royalslidernatural .slide .animal-name',
        ] );

        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide .animal-name' => 'color: {{VALUE}};',
            ],
        ] );
    $this->end_controls_section();
    }


    private function royalslidernatural_slider_sub_title_style() {
        $this->start_controls_section(
            'section_style_sub_title',
            [
                'label' => esc_html__( 'Sub Title', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'sub_title_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royalslidernatural .slide .slide-caption',
        ] );

        $this->add_control( 'sub_title_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide .slide-caption' => 'color: {{VALUE}};',
            ],
        ] );
    $this->end_controls_section();
    }


    private function royalslidernatural_slider_image_para_style() {
        $this->start_controls_section(
            'section_style_image_para',
            [
                'label' => esc_html__( 'Image Paragraph', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'image_para_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royalslidernatural .slide .slide-paragraph',
        ] );

        $this->add_control( 'image_para_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide .slide-paragraph' => 'color: {{VALUE}};',
            ],
        ] );
    $this->end_controls_section();
    }


    private function royalslidernatural_slider_video_button_style() {
        $this->start_controls_section(
            'section_style_video_button',
            [
                'label' => esc_html__( 'Video Button', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_video_button' => 'yes',
                ],
            ]
        );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'video_button_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royalslidernatural .slide .watch-video-btn',
        ] );

        $this->start_controls_tabs(
            'style_video_button_tabs'
        );
        
        $this->start_controls_tab(
            'style_video_button_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'video_button_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide .watch-video-btn' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'video_button_bg', [
            'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fffff00',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide .watch-video-btn' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'video_button_border',
				'selector' => '{{WRAPPER}} .royalslidernatural .slide .watch-video-btn',
			]
		);
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_video_button_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'video_button_hover_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#000',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide .watch-video-btn:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'video_button_bg_hover', [
            'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide .watch-video-btn:hover' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'video_button_border_hover',
				'selector' => '{{WRAPPER}} .royalslidernatural .slide .watch-video-btn:hover',
			]
		);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        
    $this->end_controls_section();
    }


    private function royalslidernatural_slider_video_modal_style() {
        $this->start_controls_section(
            'section_style_video_modal',
            [
                'label' => esc_html__( 'Video Modal', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_video_button' => 'yes',
                ],
            ]
        );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'video_modal_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royalslidernatural .video-card .video-paragraph',
        ] );

        $this->add_control( 'video_modal_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#000',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .video-card .video-paragraph' => 'color: {{VALUE}};',
            ],
        ] );
        
        $this->add_control( 'video_modal_bg_color', [
            'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .video-card' => 'background: {{VALUE}};',
            ],
        ] );

        
        $this->add_control( 'video_modal_close_btn_color', [
            'label'     => esc_html__( 'Close Button Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide-video-modal .video-close-btn' => 'color: {{VALUE}};',
            ],
        ] );
        
    $this->end_controls_section();
    }




    private function royalslidernatural_slider_social() {
        $this->start_controls_section(
            'section_style_social',
            [
                'label' => esc_html__( 'Social', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_social' => 'yes',
                ],
            ]
        );
       
        $this->start_controls_tabs(
            'style_social_tabs'
        );
        
        $this->start_controls_tab(
            'style_social_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'social_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slider-media-icons .media-links' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_social_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'social_hover_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#5d9afc',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slider-media-icons .media-links:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    private function royalslidernatural_slider_naviation() {
        $this->start_controls_section(
            'section_style_naviation',
            [
                'label' => esc_html__( 'Naviation', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
       
        $this->start_controls_tabs(
            'style_naviation_tabs'
        );
        
        $this->start_controls_tab(
            'style_naviation_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'naviation_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slider-naviation .prev-btn' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royalslidernatural .slider-naviation .next-btn' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_naviation_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'naviation_hover_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#5d9afc',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slider-naviation .prev-btn:hover' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royalslidernatural .slider-naviation .next-btn:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    private function royalslidernatural_slider_pagination() {
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => esc_html__( 'Pagination', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
       
        $this->start_controls_tabs(
            'style_pagination_tabs'
        );
        
        $this->start_controls_tab(
            'style_pagination_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'pagination_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide-pagination .slide-btn' => 'background: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_pagination_hover_tab',
            [
                'label' => esc_html__( 'Active', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control( 'pagination_hover_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#5d9afc',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide-pagination .slide-btn.active' => 'background: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }



    private function royalslidernatural_slider_indicator() {
        $this->start_controls_section(
            'section_style_indicator',
            [
                'label' => esc_html__( 'Indicator', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_indicator' => 'yes',
                ],
            ]
        );
       
        $this->add_control( 'indicator_hover_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#5d9afc',
            'selectors' => [
                '{{WRAPPER}} .royalslidernatural .slide-indicator-bars .indicator-bar' => 'background: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control(
			'indicator_height',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 25,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .royalslidernatural .slide-indicator-bars .indicator-bar' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
    }




    public function rendar_item_image( $item, $alt = '' ){
        $settings = $this->get_settings_for_display();       
        ?>
        <img src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="" class="slide-animal-img">
		<?php 
    }

    public function rendar_item_bg( $item, $alt = '' ){
        $settings = $this->get_settings_for_display();       
        ?>
        <img src="<?php echo esc_url( $item['background']['url'] ); ?>" alt="" class="slide-bg-img">
		<?php 
    }

    public function rendar_title( $item ){
        $settings = $this->get_settings_for_display();
            ?>
            <<?php echo wp_kses_post( $settings['title_html_tag'] ); ?> class="animal-name"><?php echo wp_kses_post( $item['title'] ); ?></<?php echo wp_kses_post( $settings['title_html_tag'] ); ?>>
        <?php
    }

    public function rendar_sub_title( $item ){
        $settings = $this->get_settings_for_display();
            ?>
            <<?php echo wp_kses_post( $settings['sub_title_html_tag'] ); ?> class="slide-caption"><?php echo wp_kses_post( $item['sub_title'] ); ?></<?php echo wp_kses_post( $settings['sub_title_html_tag'] ); ?>>
        <?php
    }

    public function rendar_social(){
        $settings = $this->get_settings_for_display();       
        if ('yes' == $settings['show_social'] ) {
            ?>
            <div class="slider-media-icons">
                <?php foreach ( $settings['social_icon_list'] as $index => $item ) { ?>
                    <a href="<?php echo $item['social_link']['url']; ?>" class="media-links"><i class="<?php echo $item['social_icon']['value']; ?>"></i></a>
                <?php } ?>
            </div>
        <?php }
    }

    public function render_video_button(){
        $settings = $this->get_settings_for_display();
        ?>
            <?php if ( $settings['video_button_text'] && 'yes' == $settings['show_video_button'] ) { ?>
                <button class="watch-video-btn"><?php echo wp_kses_post( $settings['video_button_text'] ); ?></button>
            <?php } ?>
        <?php 
    }

    public function render_video($slide_video){
        $settings = $this->get_settings_for_display();
        ?>
            <?php if ( $slide_video['youtube_url'] && 'youtube' == $slide_video['videotype'] ) { 
                $url = $slide_video['youtube_url'];
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
                $youtube_id = $match[1]; ?>
                <div class="videoinner">
                <div class="youtube">
                <iframe
                  src="https://www.youtube.com/embed/<?php echo $youtube_id ?>"
                  frameborder="0"
                  allow="accelerometer; autoplay; encrypted-media; gyroscope;"
                  allowfullscreen></iframe>
                </div>
                </div>

            <?php } elseif( $slide_video['selfhosted_url'] && 'selfhosted' == $slide_video['videotype']){ ?>
                <div class="videoinner"><video src="<?php echo $slide_video['selfhosted_url']['url'] ?>" class="animal-video" controls autoplay loop></video></div>

            <?php } elseif( $slide_video['external_url'] && 'external' == $slide_video['videotype']){ ?>
                <div class="videoinner"><video src="<?php echo $slide_video['external_url'] ?>" class="animal-video" controls autoplay loop></video></div>
            <?php } ?>
        <?php 
    }

    
    protected function render( $instance = [] ) {
        $settings       = $this->get_settings_for_display();
        $id             = $this->get_id();
        $sliderid       = 'royalslidernatural'.$id;
        $previousicon   = $settings['previousicon']['value'];
        $nexticon    	= $settings['nexticon']['value'];
        $interval       = $settings['interval'];
        $indicator      = $settings['show_indicator'];

        $this->add_render_attribute(
            'options',
            [
                'id'             	    => $sliderid,
                'data-interval'		    => $interval,
                'data-indicator'		=> $indicator,
            ]
        );

      ?>
      
    <div class="royalslidernatural" <?php echo $this->get_render_attribute_string( 'options' ) ?>>
    <?php
        echo '<div class="slider">';
        foreach ( $settings['slides'] as $slide ) {
            ?>
            <div class="slide">
            <div class="slide-images">
                <?php $this->rendar_item_bg($slide, $slide['title'] ); ?>
                <?php $this->rendar_title($slide); ?>
                <?php $this->rendar_item_image($slide, $slide['title'] ); ?>
            </div>

            <div class="slide-text-content">
                <?php $this->rendar_sub_title($slide); ?>
                <p class="slide-paragraph"><?php echo $slide['imagedes'] ; ?></p>
                <?php $this->render_video_button(); ?>
            </div>

            <div class="slide-video-modal">
            <i class="royalicon-cancel-1 video-close-btn" role="button" aria-label="Close Video" tabindex="0"></i>
            <div class="video-modal-content">
                <div class="video-card">
                    <?php $this->render_video($slide); ?>
                    <p class="video-paragraph"><?php echo $slide['videodes'] ; ?></p>
                </div>
            </div>
        </div>

            </div>
        <?php } 
        echo '</div>';
        ?>

        <?php $this->rendar_social(); ?>

        <div class="slider-naviation">
        <div class="prev-btn"><i class='<?php echo $previousicon; ?>'></i></div>
        <div class="next-btn"><i class='<?php echo $nexticon; ?>'></i></div>
        </div>

        <div class="slide-pagination">
        <?php foreach ( $settings['slides'] as $slide ) { ?>
            <div class="slide-btn"></div>
        <?php } ?> 
        </div>
        
        <div class="slide-indicator-bars">
        <?php 
        if($settings['show_indicator']=='yes'){
            foreach ( $settings['slides'] as $slide ) { ?>
                <div class="indicator-bar"></div>
            <?php 
            } 
        }?>
        </div>
    </div>
  <?php
    }


}