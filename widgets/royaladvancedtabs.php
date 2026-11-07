<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Plugin as ElementorPlugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalAdvancedTabs extends Widget_Base {

    public function get_name() {
        return 'royaladvancedtabs';
    }

    public function get_title() {
        return esc_html__( 'Advanced Tabs', 'royal-addons-for-elementor' );
    }

    public function get_icon() { 
        return 'eicon-tabs rtbranding'; 
    }

    public function get_keywords() {
        return [ 'tabs', 'advanced', 'accordion', 'toggle', 'template', 'royal', 'story', 'testimonials', 'voices', 'vertical', 'tech', 'unnayan', 'mehdi' ];
    }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_style_depends() {
        return [ 'royaladvancedtabs' ];
    }

    public function get_script_depends() {
        return [ 'royaladvancedtabs' ];
    }

    protected function register_controls() {
        
        //============================================
        // Layout & General Section
        //============================================
        $this->start_controls_section(
            'section_general_layout',
            [
                'label' => esc_html__( 'Layout & Preset', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'tabs_style',
            [
                'label' => esc_html__( 'Tabs Preset Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-story-cards',
                'options' => [
                    'style-story-cards' => esc_html__( 'Style 1 - Story Avatar Cards (Voices / Unnayan)', 'royal-addons-for-elementor' ),
                    'style-underline'   => esc_html__( 'Style 2 - Classic Minimal Underline', 'royal-addons-for-elementor' ),
                    'style-pills'       => esc_html__( 'Style 3 - Rounded Pills / Capsule', 'royal-addons-for-elementor' ),
                    'style-segmented'   => esc_html__( 'Style 4 - Segmented Inset Box', 'royal-addons-for-elementor' ),
                    'style-feature-box' => esc_html__( 'Style 5 - Feature Elevated Cards', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'tabs_layout',
            [
                'label' => esc_html__( 'Orientation Layout', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical'   => esc_html__( 'Vertical (Side by Side)', 'royal-addons-for-elementor' ),
                    'horizontal' => esc_html__( 'Horizontal (Top & Bottom)', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_width',
            [
                'label' => esc_html__( 'Nav Column Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [ 'min' => 15, 'max' => 60 ],
                    'px' => [ 'min' => 180, 'max' => 600 ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 35,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-wrapper.layout-vertical .royal-advanced-tabs-nav' => 'width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'tabs_layout' => 'vertical',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_content_gap',
            [
                'label' => esc_html__( 'Gap Between Nav & Content', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-wrapper.layout-vertical' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royal-advanced-tabs-wrapper.layout-horizontal .royal-advanced-tabs-content-container' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'open_event',
            [
                'label' => esc_html__( 'Tab Trigger Action', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'click',
                'options' => [
                    'click' => esc_html__( 'On Click', 'royal-addons-for-elementor' ),
                    'hover' => esc_html__( 'On Hover / Mouseover', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->end_controls_section();

        //============================================
        // Content Tab
        //============================================
        $this->start_controls_section(
            'section_tabs',
            [
                'label' => esc_html__( 'Tab Items', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Field Day Organized on High-Yielding BARI...', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_subtitle',
            [
                'label' => esc_html__( 'Subtitle / Tagline', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Integrated Agriculture Unit', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'media_type',
            [
                'label' => esc_html__( 'Media Type', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'none' => [
                        'title' => esc_html__( 'None', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image / Avatar', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-image-bold',
                    ],
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-star',
                    ],
                ],
                'default' => 'image',
            ]
        );

        $repeater->add_control(
            'tab_image',
            [
                'label' => esc_html__( 'Thumbnail / Avatar', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'media_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'tab_icon',
            [
                'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'media_type' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'content_type',
            [
                'label' => esc_html__( 'Content Type', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'story',
                'options' => [
                    'story'    => esc_html__( 'Story / Testimonial Card', 'royal-addons-for-elementor' ),
                    'text'     => esc_html__( 'Custom Content (WYSIWYG)', 'royal-addons-for-elementor' ),
                    'template' => esc_html__( 'Elementor Template', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        // Story Fields
        $repeater->add_control(
            'story_quote_icon',
            [
                'label' => esc_html__( 'Show Quote Mark', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'content_type' => 'story',
                ],
            ]
        );

        $repeater->add_control(
            'story_quote',
            [
                'label' => esc_html__( 'Quote / Story Excerpt', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( '"Tahmina Begum, the name of one woman engaged in action with her husband Shirajul Islam and two Child, she lives in Prosadpur village of Khalil Nagar Union under Tala upazila of Satkhira district. Since all basic facilities, including herbal and medical services were inadequate for her husband, often..."', 'royal-addons-for-elementor' ),
                'rows' => 5,
                'condition' => [
                    'content_type' => 'story',
                ],
            ]
        );

        $repeater->add_control(
            'story_title',
            [
                'label' => esc_html__( 'Story Headline / Title', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'The story of the development of the fate of one woman zealous in action is the story of the development of women.', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'condition' => [
                    'content_type' => 'story',
                ],
            ]
        );

        $repeater->add_control(
            'story_meta',
            [
                'label' => esc_html__( 'Location / Subtitle', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Satkhira', 'royal-addons-for-elementor' ),
                'condition' => [
                    'content_type' => 'story',
                ],
            ]
        );

        $repeater->add_control(
            'story_button_text',
            [
                'label' => esc_html__( 'Read More Label', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Read More', 'royal-addons-for-elementor' ),
                'condition' => [
                    'content_type' => 'story',
                ],
            ]
        );

        $repeater->add_control(
            'story_button_url',
            [
                'label' => esc_html__( 'Read More Link', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'content_type' => 'story',
                ],
            ]
        );

        // Standard WYSIWYG
        $repeater->add_control(
            'tab_content',
            [
                'label' => esc_html__( 'Content', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Tab content goes here.', 'royal-addons-for-elementor' ),
                'condition' => [
                    'content_type' => 'text',
                ],
            ]
        );

        // Elementor Template
        $repeater->add_control(
            'tab_template',
            [
                'label' => esc_html__( 'Select Template', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_all_elementor_templates(),
                'label_block' => true,
                'condition' => [
                    'content_type' => 'template',
                ],
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => esc_html__( 'Tabs Items', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__( 'Field Day Organized on High-Yielding BARI...', 'royal-addons-for-elementor' ),
                        'tab_subtitle' => esc_html__( 'Integrated Agriculture Unit', 'royal-addons-for-elementor' ),
                        'media_type' => 'image',
                        'content_type' => 'story',
                        'story_quote' => esc_html__( '"Tahmina Begum, the name of one woman engaged in action with her husband Shirajul Islam and two Child, she lives in Prosadpur village of Khalil Nagar Union under Tala upazila of Satkhira district. Since all basic facilities, including herbal and medical services were inadequate for her husband, often..."', 'royal-addons-for-elementor' ),
                        'story_title' => esc_html__( 'The story of the development of the fate of one woman zealous in action is the story of the development of women.', 'royal-addons-for-elementor' ),
                        'story_meta' => esc_html__( 'Satkhira', 'royal-addons-for-elementor' ),
                        'story_button_text' => esc_html__( 'Read More', 'royal-addons-for-elementor' ),
                    ],
                    [
                        'tab_title' => esc_html__( 'The Sustainable Transformation of Jiwla Ghos...', 'royal-addons-for-elementor' ),
                        'tab_subtitle' => esc_html__( 'Microfinance beneficiary', 'royal-addons-for-elementor' ),
                        'media_type' => 'image',
                        'content_type' => 'story',
                        'story_quote' => esc_html__( '"Through dedicated guidance and community microfinance support, local entrepreneurs are empowered to create resilient, eco-friendly livelihoods that support generations."', 'royal-addons-for-elementor' ),
                        'story_title' => esc_html__( 'Transforming rural economies through women-led grassroots initiatives.', 'royal-addons-for-elementor' ),
                        'story_meta' => esc_html__( 'Khulna', 'royal-addons-for-elementor' ),
                        'story_button_text' => esc_html__( 'Read More', 'royal-addons-for-elementor' ),
                    ],
                    [
                        'tab_title' => esc_html__( 'Climate-Resilient Slatted-Platform Sheep Rea...', 'royal-addons-for-elementor' ),
                        'tab_subtitle' => esc_html__( 'Microfinance beneficiary', 'royal-addons-for-elementor' ),
                        'media_type' => 'image',
                        'content_type' => 'story',
                        'story_quote' => esc_html__( '"Adapting to climate challenges requires innovation and resilience. Slatted-platform farming ensures animal safety, hygiene, and higher yield during monsoon seasons."', 'royal-addons-for-elementor' ),
                        'story_title' => esc_html__( 'Innovative agricultural models paving the way for climate disaster resilience.', 'royal-addons-for-elementor' ),
                        'story_meta' => esc_html__( 'Jessore', 'royal-addons-for-elementor' ),
                        'story_button_text' => esc_html__( 'Read More', 'royal-addons-for-elementor' ),
                    ],
                    [
                        'tab_title' => esc_html__( 'Sustainable farming brings success for Piya Bi...', 'royal-addons-for-elementor' ),
                        'tab_subtitle' => esc_html__( 'Microfinance beneficiary', 'royal-addons-for-elementor' ),
                        'media_type' => 'image',
                        'content_type' => 'story',
                        'story_quote' => esc_html__( '"Organic fertilizers and community seed banks have turned barren plots into flourishing seasonal vegetable harvests, ensuring food sovereignty."', 'royal-addons-for-elementor' ),
                        'story_title' => esc_html__( 'Organic farming transforms household stability and family nutritional security.', 'royal-addons-for-elementor' ),
                        'story_meta' => esc_html__( 'Satkhira', 'royal-addons-for-elementor' ),
                        'story_button_text' => esc_html__( 'Read More', 'royal-addons-for-elementor' ),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->end_controls_section();

        //============================================
        // Nav Style Tab
        //============================================
        $this->start_controls_section(
            'section_style_nav',
            [
                'label' => esc_html__( 'Navigation Items', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'nav_align',
            [
                'label' => esc_html__( 'Horizontal Alignment', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => ['title' => __('Left', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-left'],
                    'center'     => ['title' => __('Center', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-center'],
                    'flex-end'   => ['title' => __('Right', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-wrapper.layout-horizontal .royal-advanced-tabs-nav' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'tabs_layout' => 'horizontal',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_spacing',
            [
                'label' => esc_html__( 'Spacing Between Items', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-wrapper.layout-horizontal .royal-advanced-tabs-nav-item' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom: 0;',
                    '{{WRAPPER}} .royal-advanced-tabs-wrapper.layout-vertical .royal-advanced-tabs-nav-item' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-right: 0;',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_padding',
            [
                'label' => esc_html__( 'Item Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-nav-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'nav_typography',
                'label' => esc_html__( 'Title Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'nav_subtitle_typography',
                'label' => esc_html__( 'Subtitle Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-subtitle',
            ]
        );

        $this->start_controls_tabs('nav_style_tabs');

        // Normal
        $this->start_controls_tab('nav_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);

        $this->add_control('nav_color', [
            'label' => esc_html__('Title Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-advanced-tabs-nav-item' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-advanced-tabs-nav-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('nav_subtitle_color', [
            'label' => esc_html__('Subtitle Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-advanced-tabs-nav-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('nav_icon_color', [
            'label' => esc_html__('Icon Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royal-advanced-tabs-nav-item i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royal-advanced-tabs-nav-item svg' => 'fill: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'nav_bg',
            'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-item',
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'nav_border',
            'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-item',
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'nav_box_shadow',
            'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-item',
        ]);

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab('nav_hover', ['label' => esc_html__('Hover', 'royal-addons-for-elementor')]);

        $this->add_control('nav_hover_color', [
            'label' => esc_html__('Title Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-advanced-tabs-nav-item:hover' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-advanced-tabs-nav-item:hover .royal-advanced-tabs-nav-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('nav_hover_subtitle_color', [
            'label' => esc_html__('Subtitle Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-advanced-tabs-nav-item:hover .royal-advanced-tabs-nav-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('nav_hover_icon_color', [
            'label' => esc_html__('Icon Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royal-advanced-tabs-nav-item:hover i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royal-advanced-tabs-nav-item:hover svg' => 'fill: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'nav_hover_bg',
            'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-item:hover',
        ]);

        $this->add_control('nav_hover_border_color', [
            'label' => esc_html__('Border Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-advanced-tabs-nav-item:hover' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'nav_hover_box_shadow',
            'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-item:hover',
        ]);

        $this->end_controls_tab();

        // Active
        $this->start_controls_tab('nav_active', ['label' => esc_html__('Active', 'royal-addons-for-elementor')]);

        $this->add_control('nav_active_color', [
            'label' => esc_html__('Title Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-advanced-tabs-nav-item.active' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-advanced-tabs-nav-item.active .royal-advanced-tabs-nav-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('nav_active_subtitle_color', [
            'label' => esc_html__('Subtitle Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-advanced-tabs-nav-item.active .royal-advanced-tabs-nav-subtitle' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('nav_active_icon_color', [
            'label' => esc_html__('Icon Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royal-advanced-tabs-nav-item.active i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royal-advanced-tabs-nav-item.active svg' => 'fill: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'nav_active_bg',
            'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-item.active',
        ]);

        $this->add_control('nav_active_border_color', [
            'label' => esc_html__('Active Border Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royal-advanced-tabs-nav-item.active' => 'border-color: {{VALUE}} !important;',
                '{{WRAPPER}} .royal-tabs-style-underline.layout-horizontal .royal-advanced-tabs-nav-item.active' => 'border-bottom-color: {{VALUE}} !important;',
                '{{WRAPPER}} .royal-tabs-style-underline.layout-vertical .royal-advanced-tabs-nav-item.active' => 'border-right-color: {{VALUE}} !important;',
            ],
        ]);

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'nav_active_box_shadow',
            'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-item.active',
        ]);

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        //============================================
        // Media / Avatar Style Tab
        //============================================
        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__( 'Nav Media / Avatar', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'media_size',
            [
                'label' => esc_html__( 'Media Dimensions (Size)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [ 'min' => 24, 'max' => 120 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 48,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-nav-media' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important; min-width: {{SIZE}}{{UNIT}} !important; min-height: {{SIZE}}{{UNIT}} !important; max-width: {{SIZE}}{{UNIT}} !important; max-height: {{SIZE}}{{UNIT}} !important; flex: 0 0 {{SIZE}}{{UNIT}} !important; flex-shrink: 0 !important; aspect-ratio: 1 / 1 !important;',
                    '{{WRAPPER}} .royal-advanced-tabs-nav-media img' => 'width: 100% !important; height: 100% !important; min-width: 100% !important; min-height: 100% !important; max-width: 100% !important; max-height: 100% !important; aspect-ratio: 1 / 1 !important; object-fit: cover !important;',
                    '{{WRAPPER}} .royal-advanced-tabs-nav-media.royal-media-icon' => 'font-size: calc({{SIZE}}{{UNIT}} * 0.45);',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '50',
                    'right' => '50',
                    'bottom' => '50',
                    'left' => '50',
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-nav-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} .royal-advanced-tabs-nav-media img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_spacing_right',
            [
                'label' => esc_html__( 'Spacing to Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-nav-media' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'media_border',
                'selector' => '{{WRAPPER}} .royal-advanced-tabs-nav-media',
            ]
        );

        $this->end_controls_section();

        //============================================
        // Content Area Style Tab
        //============================================
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__( 'Content Area', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '36',
                    'right' => '36',
                    'bottom' => '36',
                    'left' => '36',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-content-pane' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '24',
                    'right' => '24',
                    'bottom' => '24',
                    'left' => '24',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-content-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .royal-advanced-tabs-content-pane' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .royal-advanced-tabs-content-pane',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-advanced-tabs-content-pane' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_bg',
                'selector' => '{{WRAPPER}} .royal-advanced-tabs-content-pane, {{WRAPPER}} .royal-advanced-tabs-content-container',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .royal-advanced-tabs-content-pane, {{WRAPPER}} .royal-advanced-tabs-content-container',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .royal-advanced-tabs-content-pane, {{WRAPPER}} .royal-advanced-tabs-content-container',
            ]
        );

        $this->end_controls_section();

        //============================================
        // Story Card Elements Style Tab
        //============================================
        $this->start_controls_section(
            'section_style_story',
            [
                'label' => esc_html__( 'Story Card Elements', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'story_quote_icon_heading',
            [
                'label' => esc_html__( 'Quote Mark Icon', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'story_quote_icon_color',
            [
                'label' => esc_html__( 'Quote Icon Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#d4a373',
                'selectors' => [
                    '{{WRAPPER}} .royal-story-quote-icon svg' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'story_quote_icon_size',
            [
                'label' => esc_html__( 'Quote Icon Size', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 80 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-story-quote-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_control(
            'story_quote_text_heading',
            [
                'label' => esc_html__( 'Quote / Story Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'story_quote_typography',
                'selector' => '{{WRAPPER}} .royal-story-quote-text',
            ]
        );

        $this->add_control(
            'story_quote_color',
            [
                'label' => esc_html__( 'Quote Text Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#334155',
                'selectors' => [
                    '{{WRAPPER}} .royal-story-quote-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'story_divider_heading',
            [
                'label' => esc_html__( 'Separator Line', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'story_divider_color',
            [
                'label' => esc_html__( 'Divider Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e2e8f0',
                'selectors' => [
                    '{{WRAPPER}} .royal-story-divider' => 'border-color: {{VALUE}}; background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'story_divider_spacing',
            [
                'label' => esc_html__( 'Divider Margin', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 5, 'max' => 60 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-story-divider' => 'margin: {{SIZE}}{{UNIT}} 0;',
                ],
            ]
        );

        $this->add_control(
            'story_title_heading',
            [
                'label' => esc_html__( 'Story Headline', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'story_title_typography',
                'selector' => '{{WRAPPER}} .royal-story-title',
            ]
        );

        $this->add_control(
            'story_title_color',
            [
                'label' => esc_html__( 'Headline Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0f172a',
                'selectors' => [
                    '{{WRAPPER}} .royal-story-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'story_meta_heading',
            [
                'label' => esc_html__( 'Meta / Location', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'story_meta_typography',
                'selector' => '{{WRAPPER}} .royal-story-meta',
            ]
        );

        $this->add_control(
            'story_meta_color',
            [
                'label' => esc_html__( 'Meta Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#64748b',
                'selectors' => [
                    '{{WRAPPER}} .royal-story-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        //============================================
        // Read More Button Styling Section
        //============================================
        $this->add_control(
            'story_link_heading',
            [
                'label' => esc_html__( 'Read More Button', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'story_button_style',
            [
                'label' => esc_html__( 'Button Preset Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'button_fill',
                'options' => [
                    'button_fill'    => esc_html__( 'Modern Filled Pill (Recommended)', 'royal-addons-for-elementor' ),
                    'button_outline' => esc_html__( 'Clean Outline Button', 'royal-addons-for-elementor' ),
                    'link_badge'     => esc_html__( 'Text with Arrow Badge', 'royal-addons-for-elementor' ),
                    'link_clean'     => esc_html__( 'Simple Minimal Link', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'story_link_typography',
                'selector' => '{{WRAPPER}} .royal-story-link',
            ]
        );

        $this->add_responsive_control(
            'story_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-story-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'story_btn_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-story-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('story_btn_style_tabs');

        // Normal
        $this->start_controls_tab('story_btn_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);

        $this->add_control(
            'story_link_color',
            [
                'label' => esc_html__( 'Text / Icon Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-story-link' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .royal-story-link-icon svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'story_btn_bg',
            [
                'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-story-link' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'story_btn_border',
                'selector' => '{{WRAPPER}} .royal-story-link',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'story_btn_box_shadow',
                'selector' => '{{WRAPPER}} .royal-story-link',
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab('story_btn_hover', ['label' => esc_html__('Hover', 'royal-addons-for-elementor')]);

        $this->add_control(
            'story_link_hover_color',
            [
                'label' => esc_html__( 'Text / Icon Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-story-link:hover' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .royal-story-link:hover .royal-story-link-icon svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'story_btn_hover_bg',
            [
                'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-story-link:hover' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'story_btn_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-story-link:hover' => 'border-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'story_btn_hover_box_shadow',
                'selector' => '{{WRAPPER}} .royal-story-link:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $tabs = $settings['tabs'];

        if ( empty( $tabs ) ) {
            return;
        }

        $id = $this->get_id();
        $layout = !empty($settings['tabs_layout']) ? $settings['tabs_layout'] : 'vertical';
        $style = !empty($settings['tabs_style']) ? $settings['tabs_style'] : 'style-story-cards';
        $open_event = !empty($settings['open_event']) ? $settings['open_event'] : 'click';
        $btn_style = !empty($settings['story_button_style']) ? $settings['story_button_style'] : 'button_fill';

        $wrapper_classes = [
            'royal-advanced-tabs-wrapper',
            'layout-' . esc_attr($layout),
            'royal-tabs-' . esc_attr($style),
        ];

        $this->add_render_attribute( 'wrapper', [
            'class' => $wrapper_classes,
            'data-open-event' => esc_attr($open_event),
            'id' => 'royal-tabs-' . esc_attr($id),
        ]);
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            
            <ul class="royal-advanced-tabs-nav" role="tablist">
                <?php foreach ( $tabs as $index => $item ) : 
                    $active_class = ( 0 === $index ) ? 'active' : '';
                    $media_type = !empty($item['media_type']) ? $item['media_type'] : 'image';
                ?>
                    <li class="royal-advanced-tabs-nav-item <?php echo esc_attr( $active_class ); ?>" data-tab-index="<?php echo esc_attr( $index ); ?>" role="tab" tabindex="0" aria-selected="<?php echo ( 0 === $index ) ? 'true' : 'false'; ?>">
                        
                        <?php if ( 'image' === $media_type && !empty($item['tab_image']['url']) ) : ?>
                            <span class="royal-advanced-tabs-nav-media royal-media-image" style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; max-width: 48px; max-height: 48px; flex: 0 0 48px; aspect-ratio: 1/1; border-radius: 50%; overflow: hidden; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <img src="<?php echo esc_url($item['tab_image']['url']); ?>" alt="<?php echo esc_attr($item['tab_title']); ?>" style="width: 100% !important; height: 100% !important; min-width: 100% !important; min-height: 100% !important; max-width: none !important; aspect-ratio: 1/1 !important; object-fit: cover !important; object-position: center !important; border-radius: 50% !important; display: block !important;">
                            </span>
                        <?php elseif ( 'icon' === $media_type && !empty($item['tab_icon']['value']) ) : ?>
                            <span class="royal-advanced-tabs-nav-media royal-media-icon" style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; max-width: 48px; max-height: 48px; flex: 0 0 48px; aspect-ratio: 1/1; border-radius: 50%; overflow: hidden; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <?php Icons_Manager::render_icon( $item['tab_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </span>
                        <?php endif; ?>

                        <span class="royal-advanced-tabs-nav-text" style="display: flex; flex-direction: column; min-width: 0; flex: 1;">
                            <span class="royal-advanced-tabs-nav-title" style="display: block;"><?php echo esc_html( $item['tab_title'] ); ?></span>
                            <?php if ( !empty($item['tab_subtitle']) ) : ?>
                                <span class="royal-advanced-tabs-nav-subtitle" style="display: block;"><?php echo esc_html( $item['tab_subtitle'] ); ?></span>
                            <?php endif; ?>
                        </span>

                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="royal-advanced-tabs-content-container">
                <?php foreach ( $tabs as $index => $item ) : 
                    $active_class = ( 0 === $index ) ? 'active' : '';
                    $content_type = !empty($item['content_type']) ? $item['content_type'] : 'story';
                ?>
                    <div class="royal-advanced-tabs-content-pane <?php echo esc_attr( $active_class ); ?>" data-tab-index="<?php echo esc_attr( $index ); ?>" role="tabpanel">
                        <?php
                        if ( 'story' === $content_type ) :
                        ?>
                            <div class="royal-advanced-tabs-story-card">
                                <?php if ( 'yes' === ($item['story_quote_icon'] ?? 'yes') ) : ?>
                                    <div class="royal-story-quote-icon">
                                        <svg width="36" height="28" viewBox="0 0 36 28" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.818 0C4.396 0 0 4.396 0 9.818c0 5.422 4.396 9.818 9.818 9.818.647 0 1.275-.069 1.882-.196-1.157 4.34-5.132 7.545-9.914 7.859-.48.029-.862.421-.862.902v.03c0 .49.402.891.892.882C10.026 29.143 16.68 22.454 16.68 14.227V9.818C16.68 4.396 12.24 0 9.818 0zm19.32 0C23.716 0 19.32 4.396 19.32 9.818c0 5.422 4.396 9.818 9.818 9.818.647 0 1.275-.069 1.882-.196-1.157 4.34-5.132 7.545-9.914 7.859-.48.029-.862.421-.862.902v.03c0 .49.402.891.892.882C29.346 29.143 36 22.454 36 14.227V9.818C36 4.396 31.56 0 29.138 0z"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>

                                <?php if ( !empty($item['story_quote']) ) : ?>
                                    <div class="royal-story-quote-text">
                                        <?php echo wp_kses_post( $item['story_quote'] ); ?>
                                    </div>
                                <?php endif; ?>

                                <hr class="royal-story-divider" />

                                <?php if ( !empty($item['story_title']) ) : ?>
                                    <h4 class="royal-story-title"><?php echo esc_html( $item['story_title'] ); ?></h4>
                                <?php endif; ?>

                                <?php if ( !empty($item['story_meta']) ) : ?>
                                    <div class="royal-story-meta"><?php echo esc_html( $item['story_meta'] ); ?></div>
                                <?php endif; ?>

                                <?php if ( !empty($item['story_button_text']) ) : 
                                    $link_url = !empty($item['story_button_url']['url']) ? $item['story_button_url']['url'] : '#';
                                    $target = !empty($item['story_button_url']['is_external']) ? ' target="_blank"' : '';
                                    $nofollow = !empty($item['story_button_url']['nofollow']) ? ' rel="nofollow"' : '';
                                ?>
                                    <div class="royal-story-action">
                                        <a href="<?php echo esc_url($link_url); ?>" class="royal-story-link royal-story-btn-<?php echo esc_attr($btn_style); ?>"<?php echo $target . $nofollow; ?>>
                                            <span class="royal-story-link-text"><?php echo esc_html( $item['story_button_text'] ); ?></span>
                                            <span class="royal-story-link-icon" aria-hidden="true">
                                                <svg width="15" height="15" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.333 8h9.334M8.667 4l4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php
                        elseif ( 'template' === $content_type && ! empty( $item['tab_template'] ) ) :
                            echo ElementorPlugin::instance()->frontend->get_builder_content_for_display( $item['tab_template'], true );
                        else :
                            echo wp_kses_post( $item['tab_content'] );
                        endif;
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <?php
    }

    private function get_all_elementor_templates() {
        $options = [];
        if ( ! class_exists( 'Elementor\Plugin' ) ) { return $options; }
        
        $templates_manager = ElementorPlugin::instance()->templates_manager;
        if ( method_exists( $templates_manager, 'get_source' ) ) {
            $templates = $templates_manager->get_source( 'local' )->get_items();
            if ( empty( $templates ) ) { 
                $options['0'] = esc_html__( 'No templates found.', 'royal-addons-for-elementor' ); 
                return $options; 
            }
            $options['0'] = esc_html__( 'Select a Template', 'royal-addons-for-elementor' );
            foreach ( $templates as $template ) { 
                $options[ $template['template_id'] ] = $template['title'] . ' (' . ucfirst( $template['type'] ) . ')'; 
            }
        }
        return $options;
    }
}
