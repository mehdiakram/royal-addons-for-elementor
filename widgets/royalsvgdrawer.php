<?php
namespace RoyalAddons\Widgets;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use RoyalAddons\Traits\ProWidgetTrait;

defined( 'ABSPATH' ) || die();

class RoyalSVGDrawer extends Widget_Base {
    use ProWidgetTrait;

    public function get_name() {
        return 'royalsvgdrawer';
    }

    public function get_title() {
        return __( 'SVG Draw', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'pa-pro-svg-drawer rtbranding'; }

    public function get_categories() {
        return array( 'royaltech' );
    }

    public function get_keywords() {
        return array( 'pa', 'svg draw', 'icon', 'animate', 'custom', 'library', 'animation' );
    }

    public function get_style_depends() {
        return ['royaltechXXX'];
    }

    public function get_script_depends() {
        return [
            'tweenmax',
            'scrolltrigger',
            'gsap',
            'royalsvgdrawer',
            'motionpath',
        ];
    }


    protected function register_controls() {

        $this->start_controls_section(
            'general_section',
            array(
                'label' => __( 'General', 'royal-addons-for-elementor' ),
            )
        );

        $this->add_control(
            'icon_type',
            array(
                'label'       => __( 'SVG Type', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    'icon'   => __( 'Font Awesome Icon', 'royal-addons-for-elementor' ),
                    'custom' => __( 'Custom SVG', 'royal-addons-for-elementor' ),
                ),
                'default'     => 'icon',
                'label_block' => true,
            )
        );

        $this->add_control(
            'font_icon',
            array(
                'label'              => __( 'Select Icon', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::ICONS,
                'skin'               => 'inline',
                'classes'            => 'editor-pa-icon-control',
                'exclude_inline_options' => array( 'svg' ),
                'default'            => array(
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ),
                'label_block'        => false,
                'condition'          => array(
                    'icon_type' => 'icon',
                ),
            )
        );

        $this->add_control(
            'custom_svg',
            array(
                'label'       => __( 'SVG Code', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'description' => 'You can use these sites to create SVGs: <a href="https://mehdiakram.github.io/google-font-to-svg-path/" target="_blank">Google Fonts</a> and <a href="https://boxy-svg.com/" target="_blank">Boxy SVG</a>',
                'condition'   => array(
                    'icon_type' => 'custom',
                ),
            )
        );

        $this->add_control(
            'custom_svg_note',
            array(
                'raw'             => __( 'Please note that your SVG code must contain a path element so it can be animated. For example, path, circle, square, etc.', 'royal-addons-for-elementor' ),
                'type'            => Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'condition'       => array(
                    'icon_type' => 'custom',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_width',
            array(
                'label'      => __( 'Width', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em', '%', 'custom' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 600,
                    ),
                    'em' => array(
                        'min' => 1,
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 100,
                    'unit' => 'px',
                ),
                'condition'  => array(
                    'icon_type' => 'custom',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .royal-svg-draw svg' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_height',
            array(
                'label'      => __( 'Height', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em', 'custom' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 600,
                    ),
                    'em' => array(
                        'min' => 1,
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 100,
                    'unit' => 'px',
                ),
                'condition'  => array(
                    'icon_type' => 'custom',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .royal-svg-draw svg' => 'height: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_size',
            array(
                'label'      => __( 'Size', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 500,
                    ),
                    'em' => array(
                        'min' => 1,
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 250,
                    'unit' => 'px',
                ),
                'condition'  => array(
                    'icon_type' => 'icon',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .royal-svg-draw svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_align',
            array(
                'label'     => __( 'Alignment', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => array(
                    'left'   => array(
                        'title' => __( 'Left', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => __( 'Center', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => __( 'Right', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'default'   => 'center',
                'selectors' => array(
                    '{{WRAPPER}} .royal-svg-draw' => 'text-align: {{VALUE}};',
                ),
                'toggle'    => false,
            )
        );

        $this->add_control(
            'animate_icon',
            array(
                'label'        => __( 'Draw SVG', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'royal-svg-animated-',
                'render_type'  => 'template',
                'separator'    => 'before',
                'default'      => 'yes', // Ensure this is explicitly 'yes'
                'condition'    => array(
                    'magic_scroll!' => 'yes',
                ),
            )
        );

        $this->add_control(
            'animation_reverse',
            array(
                'label'        => __( 'Reverse Animation', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'royal-svg-anim-rev-',
                'render_type'  => 'template',
                'separator'    => 'before',
                'default'      => '', // Explicitly empty for "no"
                'condition'    => array(
                    'animate_icon'  => 'yes',
                    'magic_scroll!' => 'yes',
                ),
            )
        );

        $this->add_control(
            'animate_start_point',
            array(
                'label'              => __( 'Start Point (%)', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SLIDER,
                'description'        => __( 'Set the point that the SVG should start from.', 'royal-addons-for-elementor' ),
                'default'            => array(
                    'unit' => '%',
                    'size' => 0,
                ),
                'condition'          => array(
                    'animate_icon'       => 'yes',
                    'magic_scroll!'      => 'yes',
                    'animation_reverse!' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'animate_end_point',
            array(
                'label'              => __( 'End Point (%)', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SLIDER,
                'description'        => __( 'Set the point that the SVG should end at.', 'royal-addons-for-elementor' ),
                'default'            => array(
                    'unit' => '%',
                    'size' => 100, // Changed from 0 to 100 as an endpoint usually goes to 100%
                ),
                'condition'          => array(
                    'animate_icon'      => 'yes',
                    'magic_scroll!'     => 'yes',
                    'animation_reverse' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'scroll_action',
            array(
                'label'              => __( 'How this animation should work?', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SELECT,
                'options'            => array(
                    'automatic' => __( 'Complete Draw When Visible On Viewport', 'royal-addons-for-elementor' ),
                    'viewport'  => __( 'Draw On Scroll', 'royal-addons-for-elementor' ),
                    'hover'     => __( 'Draw On Hover', 'royal-addons-for-elementor' ),
                ),
                'default'            => 'viewport',
                'label_block'        => true,
                'condition'          => array(
                    'animate_icon'  => 'yes',
                    'magic_scroll!' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'frames',
            array(
                'label'              => __( 'Speed', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::NUMBER,
                'description'        => __( 'Larger value means longer drawing duration', 'royal-addons-for-elementor' ),
                'default'            => 5, // Explicitly set to 5
                'min'                => 1,
                'max'                => 100,
                'condition'          => array(
                    'animate_icon'   => 'yes',
                    'scroll_action!' => 'viewport',
                    'magic_scroll!'  => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'loop',
            array(
                'label'              => __( 'Loop', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SWITCHER,
                'condition'          => array(
                    'animate_icon'   => 'yes',
                    'scroll_action!' => 'viewport',
                    'magic_scroll!'  => 'yes',
                ),
                'return_value'       => 'true', // JS checks for 'true' string
                'default'            => '', // Explicitly empty string for "no"
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'yoyo',
            array(
                'label'              => __( 'Yoyo Effect', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SWITCHER,
                'condition'          => array(
                    'animate_icon'   => 'yes',
                    'scroll_action!' => 'viewport',
                    'magic_scroll!'  => 'yes',
                    'loop'           => 'true',
                ),
                'default'            => '', // Explicitly empty string for "no"
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'animate_trigger',
            array(
                'label'              => __( 'When the draw should start?', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SELECT,
                'options'            => array(
                    'top'    => __( 'Top of Viewport Hits The Widget', 'royal-addons-for-elementor' ),
                    'center' => __( 'Center of Viewport Hits The Widget', 'royal-addons-for-elementor' ),
                    'custom' => __( 'Custom Offset', 'royal-addons-for-elementor' ),
                ),
                'default'            => 'center',
                'label_block'        => true,
                'condition'          => array(
                    'animate_icon'  => 'yes',
                    'scroll_action' => 'automatic',
                    'magic_scroll!' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'animate_offset',
            array(
                'label'              => __( 'Offset (%)', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SLIDER,
                'default'            => array(
                    'size' => 50,
                    'unit' => '%',
                ),
                'frontend_available' => true,
                'conditions'         => array(
                    'terms' => array(
                        array(
                            'name'  => 'animate_icon',
                            'value' => 'yes',
                        ),
                        array(
                            'name'     => 'magic_scroll',
                            'operator' => '!=',
                            'value'    => 'yes',
                        ),
                        array(
                            'name'     => 'scroll_action',
                            'operator' => '!=',
                            'value'    => 'hover',
                        ),
                        array(
                            'relation' => 'or',
                            'terms'    => array(
                                array(
                                    'name'  => 'scroll_action',
                                    'value' => 'viewport',
                                ),
                                array(
                                    'name'  => 'animate_trigger',
                                    'value' => 'custom',
                                ),
                            ),
                        ),
                    ),
                ),
            )
        );

        $this->add_control(
            'draw_speed',
            array(
                'label'              => __( 'Decrease Draw Speed By', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SLIDER,
                'description'        => __( 'The larger the value you set the slower the SVG is drawn.', 'royal-addons-for-elementor' ),
                'range'              => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.1,
                    ],
                ],
                'default'            => array(
                    'size' => 0.3,
                    'unit' => 'px',
                ),
                'condition'          => array(
                    'animate_icon'  => 'yes',
                    'scroll_action' => 'viewport',
                    'magic_scroll!' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'animation_sync',
            array(
                'label'        => __( 'Draw All Paths Together', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'royal-svg-sync-',
                'separator'    => 'before',
                'render_type'  => 'template',
                'default'      => '', // Explicitly empty string for "no"
                'condition'    => array(
                    'animate_icon'  => 'yes',
                    'icon_type!'    => 'icon',
                    'magic_scroll!' => 'yes',
                ),
            )
        );

        $this->add_control(
            'anim_rev',
            array(
                'label'              => __( 'Restart Animation on Scroll Up', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SWITCHER,
                'render_type'        => 'template',
                'default'            => 'yes', // Explicitly 'yes'
                'condition'          => array(
                    'animate_icon'  => 'yes',
                    'scroll_action' => 'automatic',
                    'magic_scroll!' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'svg_fill',
            array(
                'label'              => __( 'Fill Color After Draw', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SWITCHER,
                'condition'          => array(
                    'animate_icon'  => 'yes',
                    'magic_scroll!' => 'yes',
                ),
                'default'            => '', // Explicitly empty string for "no"
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'svg_fill_speed',
            array(
                'label'              => __( 'Fill Color Speed', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::SLIDER,
                'range'              => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 5,
                        'step' => 0.1,
                    ],
                ],
                'default'            => array( // Explicitly set default for slider
                    'size' => 1,
                    'unit' => 'px',
                ),
                'condition'          => array(
                    'animate_icon'   => 'yes',
                    'scroll_action!' => 'viewport',
                    'magic_scroll!'  => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'link',
            array(
                'label'       => __( 'Link', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => array( 'active' => true ),
                'placeholder' => 'https://royaltechbd.com/',
                'label_block' => true,
                'separator'   => 'before',
                'default'     => array( 'url' => '' ), // Explicitly set default for URL
            )
        );

        $this->add_control(
            'magic_scroll',
            array(
                'label'       => __( 'Use With Magic Scroll', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
                'description' => __( 'Enable this option if you want to draw the SVG using ', 'royal-addons-for-elementor' ) . '<a href="https://royaltechbd.com/royalmagicscroll/" target="_blank">Magic Scroll addon.</a>',
                'render_type' => 'template',
                'separator'   => 'before',
                'default'     => '', // Explicitly empty for "no"
            )
        );

        $this->end_controls_section();


        /*Start Icon Style*/
        $this->start_controls_section(
            'icon_style',
            array(
                'label' => __( 'Icon', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'icon_color',
            array(
                'label'     => __( 'Stroke Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6EC1E4',
                'selectors' => array(
                    '{{WRAPPER}} .royal-svg-draw svg'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-svg-draw svg *' => 'stroke: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'fill_color',
            array(
                'label'     => __( 'Fill Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'transparent', // Added default to avoid null if not set
                'selectors' => array(
                    '{{WRAPPER}} .royal-svg-draw svg path, {{WRAPPER}} .royal-svg-draw svg circle, {{WRAPPER}} .royal-svg-draw svg square, {{WRAPPER}} .royal-svg-draw svg ellipse, {{WRAPPER}} .royal-svg-draw svg rect, {{WRAPPER}} .royal-svg-draw svg polyline, {{WRAPPER}} .royal-svg-draw svg line' => 'fill: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'svg_stroke',
            array(
                'label'              => __( 'After Draw Stroke Color', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::COLOR,
                'global'             => false,
                'default'            => '#6EC1E4', // Explicitly set default
                'condition'          => array(
                    'animate_icon'  => 'yes',
                    'svg_fill'      => 'yes',
                    'magic_scroll!' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_control(
            'svg_color',
            array(
                'label'              => __( 'After Draw Fill Color', 'royal-addons-for-elementor' ),
                'type'               => Controls_Manager::COLOR,
                'global'             => false,
                'default'            => '#000000', // Explicitly set default
                'condition'          => array(
                    'animate_icon'  => 'yes',
                    'svg_fill'      => 'yes',
                    'magic_scroll!' => 'yes',
                ),
                'frontend_available' => true,
            )
        );

        $this->add_responsive_control(
            'path_width',
            array(
                'label'     => __( 'Path Thickness', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 20,
                        'step' => 0.1,
                    ),
                ),
                'default'   => array(
                    'size' => 3,
                    'unit' => 'px',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .royal-svg-draw svg path, {{WRAPPER}} .royal-svg-draw svg circle, {{WRAPPER}} .royal-svg-draw svg square, {{WRAPPER}} .royal-svg-draw svg ellipse, {{WRAPPER}} .royal-svg-draw svg rect, {{WRAPPER}} .royal-svg-draw svg polyline, {{WRAPPER}} .royal-svg-draw svg line' => 'stroke-width: {{SIZE}}',
                ),
            )
        );

        $this->add_control(
            'path_dashes',
            array(
                'label'     => __( 'Space Between Dashes', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min'  => 0,
                        'max'  => 10,
                        'step' => 0.1,
                    ),
                ),
                'default'   => array( 'size' => 0, 'unit' => 'px' ), // Added default for slider
                'condition' => array(
                    'animate_icon!' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .royal-svg-draw svg path, {{WRAPPER}} .royal-svg-draw svg circle, {{WRAPPER}} .royal-svg-draw svg square, {{WRAPPER}} .royal-svg-draw svg ellipse, {{WRAPPER}} .royal-svg-draw svg rect, {{WRAPPER}} .royal-svg-draw svg polyline, {{WRAPPER}} .royal-svg-draw svg line' => 'stroke-dasharray: {{SIZE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'icon_background',
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .royal-svg-draw svg',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'icon_box',
                'selector' => '{{WRAPPER}} .royal-svg-draw svg',
            )
        );

        $this->add_control(
            'icon_radius',
            array(
                'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .royal-svg-draw svg' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
                'condition'  => array(
                    'icon_adv_radius!' => 'yes',
                ),
            )
        );

        $this->add_control(
            'icon_adv_radius',
            array(
                'label'       => __( 'Advanced Border Radius', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
                'description' => __( 'Apply custom radius values. Get the radius value from ', 'royal-addons-for-elementor' ) . '<a href="https://mehdiakram.github.io/fancy-border-radius/" target="_blank">here</a>' . __( '. See ', 'royal-addons-for-elementor' ) . '<a href="https://www.youtube.com/watch?v=S0BJazLHV-M" target="_blank">tutorial</a>',
                'default'     => '', // Explicitly empty for "no"
            )
        );

        $this->add_control(
            'icon_adv_radius_value',
            array(
                'label'     => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'dynamic'   => array( 'active' => true ),
                'selectors' => array(
                    '{{WRAPPER}} .royal-svg-draw svg' => 'border-radius: {{VALUE}};',
                ),
                'condition' => array(
                    'icon_adv_radius' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
                'label'    => __( 'Shadow', 'royal-addons-for-elementor' ),
                'name'     => 'icon_shadow',
                'selector' => '{{WRAPPER}} .royal-svg-draw svg',
            )
        );

        $this->add_control(
            'blend_mode',
            array(
                'label'     => __( 'Blend Mode', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => array(
                    ''            => __( 'Normal', 'royal-addons-for-elementor' ),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'luminosity'  => 'Luminosity',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .royal-svg-draw' => 'mix-blend-mode: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_padding',
            array(
                'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} .royal-svg-draw svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        if ( $this->maybe_render_license_notice() ) {
			return;
		}

       $settings = $this->get_settings_for_display();

        $type = $settings['icon_type'];

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_link_attributes( 'link', $settings['link'] );
        }

        // This line passes all the $settings to the JavaScript.
        $this->add_render_attribute( 'svg-wrapper', 'data-settings', wp_json_encode( $settings ) );

        ?>

            <div class="royal-svg-draw elementor-invisible" <?php $this->print_render_attribute_string( 'svg-wrapper' ); ?>>

                <?php if ( ! empty( $settings['link']['url'] ) ) : ?>
                    <a <?php echo wp_kses_post( $this->get_render_attribute_string( 'link' ) ); ?>>
                <?php endif; ?>

                <?php if ( 'icon' === $type ) : ?>

                    <?php
                    // This relies on your custom Royal_Helpers::get_svg_by_icon function.
                    // Ensure this function correctly returns the <svg> markup with <path> elements.
                    echo Royal_Helpers::get_svg_by_icon(
                        $settings['font_icon'],
                        array(
                            'id'         => 'royal-svg-icon-' . $this->get_id(),
                            'class'      => 'royal-svg-icon',
                            'data-start' => 'manual', // This is actually not used in your current JS for Font Awesome, but harmless.
                        )
                    );

                    ?>

                <?php else : ?>

                    <?php $this->print_unescaped_setting( 'custom_svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

                <?php endif; ?>

                <?php if ( ! empty( $settings['link']['url'] ) ) : ?>
                    </a>
                <?php endif; ?>

            </div>

        <?php
    }
}