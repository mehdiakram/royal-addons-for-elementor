<?php
namespace RoyalAddons\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Css_Filter ;
use  Elementor\Group_Control_Text_Stroke ;
use  Elementor\Repeater;
use RoyalAddons\Elementor\Royal_Helpers;

if ( !defined( 'ABSPATH' ) ) {exit;}// Exit if accessed directly

class RoyalSliderdragon extends Widget_Base{

    public function get_name(){
        return 'royalsliderdragon';
    }
    
    public function get_title(){
        return 'Dragon Slider';
    }
    
    public function get_icon() { return 'royalsliderdragon rtbranding'; }
    
    public function get_categories(){
        return [ 'royaltech' ];
    }
    
    public function get_keywords(){
		return [ 'dragon', 'slider', 'carousel', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }
    
	public function get_style_depends() {
		$styles = ['royalsliderdragon', 'royaltechuikit'];
		return $styles;
	}
	
	public function get_script_depends() {
		$scripts = ['royaltechuikit', 'royalsliderdragon', 'splittext', 'gsap', 'royalanime'];
		return $scripts;
	}	
	
    protected function register_controls(){
        $this->start_controls_section( 'section_content_layout', [
            'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
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
        $this->add_control( 'show_title', [
            'label'     => esc_html__( 'Show Title', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
        ] );
        $this->add_control( 'show_sub_title', [
            'label'   => esc_html__( 'Show Sub Title', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'show_button_text', [
            'label'   => esc_html__( 'Show Button', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'show_excerpt', [
            'label'   => esc_html__( 'Show Excerpt', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'show_social_icon', [
            'label'   => esc_html__( 'Show Social Link', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'show_navigation_dots', [
            'label'   => esc_html__( 'Show Dots', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
		
        $this->add_control( 'title_html_tag', [
            'label'     => __( 'Title HTML Tag', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'h2',
			'options'   => Royal_Helpers::royal_title_tags(),
            'condition' => [
            'show_title' => 'yes',
			],
        ] );

		$this->add_control( 'sub_title_html_tag', [
            'label'     => __( 'Sub Title HTML Tag', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'h4',
			'options'   => Royal_Helpers::royal_title_tags(),
            'condition' => [
            'show_sub_title' => 'yes',
        ],
        ] );
        $this->add_control( 'show_blur_effect', [
            'label'        => esc_html__( 'Show Blur Effect', 'royal-addons-for-elementor' )  ,
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'prefix_class' => 'royaltech-ps-blur-effect--',
        ] );
        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'      => 'thumbnail_size',
            'label'     => esc_html__( 'Image Size', 'royal-addons-for-elementor' ),
            'exclude'   => [ 'custom' ],
            'default'   => 'full',
            'separator' => 'before',
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
        $repeater->add_control( 'sub_title', [
            'label'       => esc_html__( 'Sub Title', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
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
        $repeater->add_control( 'title_link', [
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
            'default'   => [
            'url' => '',
        ],
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'title!' => '',
        ],
        ] );
        $repeater->add_control( 'excerpt', [
            'label'       => esc_html__( 'Excerpt', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::WYSIWYG,
            'default'     => esc_html__( 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem, totam rem aperiam, eaque ipsa quae ab illo inventore et quasi architecto beatae vitae dicta sunt explicabo.', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'image', [
            'label'   => esc_html__( 'Image', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
            'dynamic' => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'slides', [
            'label'       => esc_html__( 'Slider Items', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [ [
            'sub_title' => esc_html__( 'Royal Addons For Elementor', 'royal-addons-for-elementor' ),
            'title'     => esc_html__( 'Dragon Slider', 'royal-addons-for-elementor' ),
        ], [
            'sub_title' => esc_html__( 'Discover your Talents', 'royal-addons-for-elementor' ),
            'title'     => esc_html__( 'Nice Animation Slider', 'royal-addons-for-elementor' ),
        ], [
            'sub_title' => esc_html__( 'Free Addons', 'royal-addons-for-elementor' ),
            'title'     => esc_html__( 'For your Elementor', 'royal-addons-for-elementor' ),
        ] ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_content_social_link', [
            'label'     => __( 'Social Link', 'royal-addons-for-elementor' ),
            'condition' => [
            'show_social_icon' => 'yes',
        ],
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'social_link_title', [
            'label' => __( 'Title', 'royal-addons-for-elementor' ),
            'type'  => Controls_Manager::TEXT,
        ] );
        $repeater->add_control( 'social_link', [
            'label' => __( 'Link', 'royal-addons-for-elementor' ),
            'type'  => Controls_Manager::TEXT,
        ] );
        $this->add_control( 'social_link_list', [
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
				[
				'social_link'       => __( 'http://www.facebook.com/RoyalTechnologies', 'royal-addons-for-elementor' ),
				'social_link_title' => 'Facebook',
				], 
				[
				'social_link'       => __( 'http://www.instagram.com/RoyalTechnologiesBD', 'royal-addons-for-elementor' ),
				'social_link_title' => 'Instagram',
				] 
			],
            'title_field' => '{{{ social_link_title }}}',
        ] 
		);
        $this->end_controls_section();
        $this->start_controls_section( 'section_content_animation', [
            'label' => esc_html__( 'Slider Settings', 'royal-addons-for-elementor' ),
        ] );
        
        $this->add_control( 'autoplay', [
            'label'   => esc_html__( 'Autoplay', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control( 'autoplay_interval', [
            'label'     => esc_html__( 'Autoplay Interval (ms)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 3000,
            'condition' => [
            'autoplay' => 'yes',
			],
        ] );
		
        $this->add_control( 'pause_on_hover', [
            'label' => esc_html__( 'Pause on Hover', 'royal-addons-for-elementor' ),
            'type'  => Controls_Manager::SWITCHER,
        ] );
		
        $this->end_controls_section();
        
        /**
         * Advanced Animation
         */
        $this->start_controls_section( 'section_advanced_animation', [
            'label' => esc_html__( 'Advanced Animation', 'royal-addons-for-elementor' )  ,
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


        //Style Start
        $this->start_controls_section( 'section_style_sliders', [
            'label' => esc_html__( 'Sliders', 'royal-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'overlay', [
            'label'     => esc_html__( 'Overlay', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'none',
            'options'   => [
            'none'       => esc_html__( 'None', 'royal-addons-for-elementor' ),
            'background' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
            'blend'      => esc_html__( 'Blend', 'royal-addons-for-elementor' ),
        ],
            'separator' => 'before',
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
        $this->add_group_control( Group_Control_Css_Filter::get_type(), [
            'name'      => 'css_filters',
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-bg img',
            'separator' => 'before',
        ] );
        $this->add_responsive_control( 'button_padding', [
            'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-wrapper .royaltech-prime-slider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'content_margin', [
            'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-wrapper .royaltech-prime-slider-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'label'     => esc_html__( 'Title Width', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 220,
            'max' => 1200,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-wrapper .royaltech-prime-slider-content' => 'max-width: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-main-title .royaltech-title-tag, {{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-main-title .royaltech-title-tag a' => 'color: {{VALUE}};',
        ],
            'condition' => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'first_word_title_color', [
            'label'     => esc_html__( 'First Word Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-main-title .frist-word' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'title_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-main-title .royaltech-title-tag',
            'condition' => [
            'show_title' => [ 'yes' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Text_Stroke::get_type(), [
            'name'     => 'title_text_stroke',
            'label'    => esc_html__( 'Text Stroke', 'royal-addons-for-elementor' ) ,
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-main-title .royaltech-title-tag',
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
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-main-title .royaltech-title-tag' => 'padding-bottom: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'show_title' => [ 'yes' ],
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
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-sub-title-inner' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'sub_title_typography',
            'label'    => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector' => '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-sub-title-inner',
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
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-prime-slider-content .royaltech-sub-title .royaltech-sub-title-inner' => 'padding-bottom: {{SIZE}}{{UNIT}};',
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
        
        if ( $this->get_skins() ) {
            $this->add_control( 'excerpt_background_color', [
                'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider-skin-slice .royaltech-slide-text-btn-area' => 'background: {{VALUE}};',
            ],
                'condition' => [
                '_skin' => [ 'slice' ],
            ],
            ] );
        } else {
            $this->add_control( 'excerpt_background_color', [
                'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                '{{WRAPPER}} .royaltech-prime-slider-skin-slice .royaltech-slide-text-btn-area' => 'background: {{VALUE}};',
            ],
                'condition' => [
                '_skin' => [ '' ],
            ],
            ] );
        }
        
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
            'max' => 800,
        ],
        ],
            'selectors'      => [
            '{{WRAPPER}} .royaltech-prime-slider .royaltech-slider-excerpt' => 'max-width: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'prime_slider_excerpt_spacing', [
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
        $this->end_controls_tab();
        $this->start_controls_tab( 'slider_button_style', [
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
        $this->add_control( 'slide_button_text_color', [
            'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button .royaltech-ps-button-text' => 'color: {{VALUE}};',
        ],
            'separator' => 'before',
        ] );
        $this->add_control( 'slide_button_icon_color', [
            'label'     => __( 'Icon Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button .royaltech-ps-button-arrow, {{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button .royaltech-ps-button-small-circle' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button .royaltech-ps-button-arrow:after'                                                                                   => ( is_rtl() ? 'border-right-color: {{VALUE}};' : 'border-left-color: {{VALUE}};' ),
        ],
        ] );
        $this->add_control( 'slide_button_circle_color', [
            'label'     => __( 'Circle Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button .royaltech-ps-button-border-circle' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'slide_button_typography',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button .royaltech-ps-button-text',
        ] );
        $this->add_control( 'slider_button_style_hover', [
            'label'     => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );
        $this->add_control( 'slide_button_hover_text_color', [
            'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button:hover .royaltech-ps-button-text' => 'color: {{VALUE}};',
        ],
            'separator' => 'before',
        ] );
        $this->add_control( 'slide_button_hover_circle_color', [
            'label'     => __( 'Circle Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-ps-dragon-button:hover .royaltech-ps-button-border-circle' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_social_icon', [
            'label'     => esc_html__( 'Social Link', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'show_social_icon' => 'yes',
        ],
        ] );
        $this->start_controls_tabs( 'tabs_social_icon_style' );
        $this->start_controls_tab( 'tab_social_icon_normal', [
            'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'social_icon_color', [
            'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-social-icon a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'social_icon_cirlce_color', [
            'label'     => esc_html__( 'Circle Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-social-icon a:before' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'social_icon_spacing', [
            'label'     => esc_html__( 'Spacing', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-social-icon a' => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'social_icon_typography',
            'selector' => '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-social-icon a',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_social_icon_hover', [
            'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
        ] );
        $this->add_control( 'social_icon_hover_color', [
            'label'     => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-prime-slider-social-icon a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_navigation', [
            'label' => __( 'Navigation', 'royal-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'navigation_number_color', [
            'label'     => __( 'Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-dotnav li:after'  => 'color: {{VALUE}}',
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-dotnav li:before' => 'background: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'navigation_number_hover_color', [
            'label'     => __( 'Hover Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-dotnav li:hover:after' => 'color: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
        ],
        ] );
        $this->add_control( 'navigation_number_active_color', [
            'label'     => __( 'Active Color', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-dotnav li.royaltech-active:after'  => 'color: {{VALUE}}',
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-dotnav li.royaltech-active:before' => 'background: {{VALUE}}',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
        ],
        ] );
        $this->add_responsive_control( 'navigation_number_size', [
            'label'     => __( 'Size', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-dotnav li:after' => 'font-size: {{SIZE}}px',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
        ],
        ] );
        $this->add_responsive_control( 'navigation_line_width', [
            'label'     => __( 'Line Width', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [
            '{{WRAPPER}} .royaltech-prime-slider-dragon .royaltech-dotnav li.royaltech-active:before' => 'width: {{SIZE}}px',
        ],
            'condition' => [
            'show_navigation_dots' => [ 'yes' ],
        ],
        ] );
		$this->end_controls_section();
	}




    
    public function render_header( $skin_name = 'dragon' ) {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'slider', 'class', 'royaltech-prime-slider-' . $skin_name );
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
                    ] 
                ) ],
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
        $this->add_render_attribute( 'slideshow', 'id', 'royaltech-' . $this->get_id() );

        $ratio = ( !empty($settings['slider_size_ratio']['width']) && !empty($settings['slider_size_ratio']['height']) ? $settings['slider_size_ratio']['width'] . ":" . $settings['slider_size_ratio']['height'] : '16:9' );
        //Viewport Height
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
            "animation"         => 'fade',
            "ratio"             => $ratio,
            'min-height'        => ( !empty($settings['slider_min_height']['size']) && $ratio !== false ? $settings['slider_min_height']['size'] : (( $ratio !== false ? 480 : false )) ),
            "autoplay" => ( $settings["autoplay"] && ! \Elementor\Plugin::$instance->editor->is_edit_mode() ? true : false ),
            "autoplay-interval" => $settings["autoplay_interval"],
            "pause-on-hover"    => ( "yes" === $settings["pause_on_hover"] ? true : false ),
        ] ) ],
        ],
        ] );
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
    }
    
    public function render_navigation_dots() {
        $settings = $this->get_settings_for_display();
        ?>
            <?php 
        
        if ( $settings['show_navigation_dots'] ) {
            ?>

                <ul class="royaltech-slideshow-nav royaltech-dotnav royaltech-dotnav-vertical reveal-muted">

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
        }
        
        ?>

        <?php 
    }
    
    public function render_footer() {
        ?>
					</ul>

					<?php 
        $this->render_navigation_dots();
        ?>
					
				</div>
				<?php 
        $this->render_social_link();
        ?>
			</div>
		</div>
        <?php 
    }
    
    public function render_social_link( $class = array() ){
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
        foreach ( $settings['social_link_list'] as $link ) {
            ?>

					<a href="<?php 
            echo  esc_url( $link['social_link'] ) ;
            ?>" target="_blank">
						<span class="royaltech-social-share-title">
							<?php 
            echo  esc_html( $link['social_link_title'] ) ;
            ?>
						</span>
					</a>
					
				<?php 
        }
        ?>

			</div>

		<?php 
    }
    
    public function rendar_item_image( $item, $alt = '' ){
        $settings = $this->get_settings_for_display();
        $image_src = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail_size', $settings );
        
        if ( $image_src ) {
            $image_final_src = $image_src;
        } elseif ( $item['image']['url'] ) {
            $image_final_src = $item['image']['url'];
        } else {
            return;
        }
        
        ?>

		<div class="royaltech-ps-slide-img" style="background-image: url('<?php 
        echo  esc_url( $image_final_src ) ;
        ?>')"></div>

		<?php 
    }
	
    
    public function render_button( $content ){
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute(
            'slider-button',
            'class',
            'royaltech-ps-dragon-button reveal-muted',
            true
        );
        
        if ( $content['button_link']['url'] ) {
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
                '#',
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
				
				<div class="royaltech-ps-button">
					<div class="royaltech-ps-button-text"><?php 
            echo  wp_kses( $content['slide_button_text'], 'title' ) ;
            ?></div>
					
					<div class="royaltech-ps-button-wrapper">
						<div class="royaltech-ps-button-arrow"></div>
						<div class="royaltech-ps-button-border-circle"></div>
						<div class="royaltech-ps-button-mask-circle">
						<div class="royaltech-ps-button-small-circle"></div>
						</div>
					</div>
				</div>

			</a>
		<?php 
        }
    
    }
	
    
    public function render_item_content( $slide_content ){
        $settings = $this->get_settings_for_display();
        $parallax_sub_title = 'data-royaltech-slideshow-parallax="x: 100,-100; opacity: 1,1,0"';
        $parallax_title = 'data-royaltech-slideshow-parallax="x: 200,-200; opacity: 1,1,0"';
        $parallax_text = 'data-royaltech-slideshow-parallax="x: 300,-300; opacity: 1,1,0"';
        ?>
			<div class="royaltech-prime-slider-wrapper">
				<div class="royaltech-prime-slider-content">

					<?php 
        
        if ( $slide_content['sub_title'] && 'yes' == $settings['show_sub_title'] ) {
            ?>
						<div class="royaltech-sub-title">
							<<?php 
            echo wp_kses_post( $settings['sub_title_html_tag'] );
            ?> class="royaltech-sub-title-inner" <?php 
            echo  $parallax_sub_title ;
            ?> data-reveal="reveal-active">
								<?php 
            echo  wp_kses_post( $slide_content['sub_title'] ) ;
            ?>
							</<?php 
            echo wp_kses_post( $settings['sub_title_html_tag'] );
            ?>>
						</div>
					<?php 
        }
        
        ?>

					<?php 
        
        if ( $slide_content['title'] && 'yes' == $settings['show_title'] ) {
            ?>
						<div class="royaltech-main-title">
							<<?php 
            echo wp_kses_post( $settings['title_html_tag'] );
            ?> class="royaltech-title-tag" <?php 
            echo  $parallax_title ;
            ?>  data-reveal="reveal-active">
								<?php 
            
            if ( '' !== $slide_content['title_link']['url'] ) {
                ?>
									<a href="<?php 
                echo  esc_url( $slide_content['title_link']['url'] ) ;
                ?>">
									<?php 
            }
            
            ?>
									<?php 
            echo Royal_Helpers::royal_first_word( $slide_content['title'] ) ;
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
        
        if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] ) {
            ?>
						<div class="royaltech-slider-excerpt" data-reveal="reveal-active" <?php 
            echo  $parallax_text ;
            ?>>
							<?php 
            echo  wp_kses_post( $slide_content['excerpt'] ) ;
            ?>
						</div>
					<?php 
        }
        
        ?>

					<div data-royaltech-slideshow-parallax="x: 400,-400; opacity: 1,1,0">
						<?php 
        $this->render_button( $slide_content );
        ?>
					</div>
						
				</div>
			</div>

        <?php 
    }
    
	
	
    public function render_slides_loop(){
        $settings = $this->get_settings_for_display();
        foreach ( $settings['slides'] as $slide ) {
            ?>

            <li class="royaltech-slideshow-item royaltech-flex royaltech-flex-middle elementor-repeater-item-<?php 
            echo  esc_attr( $slide['_id'] ) ;
            ?>">

				<div class="royaltech-ps-dragon-bg">
					<?php 
            $this->rendar_item_image( $slide, $slide['title'] );
            ?>
				</div>

				<div class="royaltech-ps-dragon-slide-image">
					<?php 
            $this->rendar_item_image( $slide, $slide['title'] );
            ?>
				</div>

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
        }
    }
    
    public function render(){
        $this->render_header();
        $this->render_slides_loop();
        $this->render_footer();
    }



}
