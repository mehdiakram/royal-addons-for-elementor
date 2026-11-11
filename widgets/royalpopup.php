<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Plugin as ElementorPlugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class RoyalPopup extends Widget_Base {

    public function get_name() {
        return 'royalpopup';
    }

    public function get_title() {
        return esc_html__( 'Popup', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-frame-expand rtbranding'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_keywords() {
        return [ 'popup', 'modal', 'onload', 'exit', 'intent', 'click', 'window', 'royal', 'tech', 'technologies', 'mehdi', 'akram' ];
    }

    public function get_style_depends() {
        return [ 'royalpopup', 'royalanimate' ];
    }

    public function get_script_depends() {
        return [ 'royalpopup' ];
    }

    protected function register_controls() {
        //============================================
        // Content Tab
        //============================================
        $this->start_controls_section( 'section_trigger', [ 'label' => esc_html__( 'Trigger & Content', 'royal-addons-for-elementor' ) ]);
        $this->add_control( 'popup_trigger', [ 
            'label' => esc_html__( 'Display Trigger', 'royal-addons-for-elementor' ), 
            'type' => Controls_Manager::SELECT, 
            'default' => 'onload', 
            'options' => [ 
                'onload'       => esc_html__( 'On Page Load', 'royal-addons-for-elementor' ), 
                'after_scroll' => esc_html__( 'After Page Scroll', 'royal-addons-for-elementor' ),
                'inactivity'   => esc_html__( 'After Inactivity', 'royal-addons-for-elementor' ),
                'exit_intent'  => esc_html__( 'On Exit Intent', 'royal-addons-for-elementor' ), 
                'on_click'     => esc_html__( 'On Button Click', 'royal-addons-for-elementor' ),
            ] 
        ]);
        $this->add_control( 'onload_delay', [
            'label' => esc_html__( 'Open Delay (sec)', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
            'max' => 60,
            'step' => 1,
            'condition' => [ 'popup_trigger' => 'onload' ],
        ]);
        $this->add_control( 'scroll_progress', [
            'label' => esc_html__( 'Scroll Depth (%)', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SLIDER,
            'default' => [ 'unit' => '%', 'size' => 50 ],
            'range' => [
                '%' => [ 'min' => 5, 'max' => 95, 'step' => 1 ],
            ],
            'condition' => [ 'popup_trigger' => 'after_scroll' ],
        ]);
        $this->add_control( 'inactivity_delay', [
            'label' => esc_html__( 'Inactivity Time (sec)', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 10,
            'min' => 3,
            'max' => 120,
            'step' => 1,
            'condition' => [ 'popup_trigger' => 'inactivity' ],
        ]);
        $this->add_control( 'popup_template', [ 'label' => esc_html__( 'Popup Content Template', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'options' => $this->get_all_elementor_templates(), 'label_block' => true, 'separator' => 'before' ]);
        $this->add_control( 'preview_in_editor', [
            'label' => esc_html__( 'Preview in Editor', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'description' => esc_html__( 'Display a live preview of the popup template inside the Elementor editor canvas.', 'royal-addons-for-elementor' ),
            'separator' => 'before',
        ]);
        $this->end_controls_section();

        $this->start_controls_section( 'section_trigger_button', [ 'label' => esc_html__( 'Trigger Button', 'royal-addons-for-elementor' ), 'condition' => [ 'popup_trigger' => 'on_click' ] ]);
        $this->add_control( 'button_text', [ 'label' => esc_html__( 'Button Text', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Open Popup', 'royal-addons-for-elementor' )]);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .royal-popup-trigger-button span',
			]
		);
        $this->add_control(
            'button_icon',
            [
                'label'   => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-times',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control( 'icon_position', [ 'label' => esc_html__( 'Icon Position', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'before', 'options' => [ 'before' => esc_html__( 'Before Text', 'royal-addons-for-elementor' ), 'after' => esc_html__( 'After Text', 'royal-addons-for-elementor' ) ], 'condition' => [ 'button_icon[value]!' => '' ] ]);
        $this->add_control(
            'iconsize',
            [
                'label' => esc_html__( 'Icon Size', 'textdomain' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'condition' => [
                    'button_icon[value]!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-popup-trigger-button svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );        
        $this->add_responsive_control( 'align', [ 'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::CHOOSE, 'options' => [ 'left' => ['title' => __('Left', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-left'], 'center' => ['title' => __('Center', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-center'], 'right' => ['title' => __('Right', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-right']], 'prefix_class' => 'elementor-align%s-']);
        $this->end_controls_section();

        $this->start_controls_section( 'section_popup_settings', [ 'label' => esc_html__( 'Popup Settings', 'royal-addons-for-elementor' ) ]);
        $this->add_control( 'display_on', [ 
            'label' => esc_html__( 'Display On', 'royal-addons-for-elementor' ), 
            'type' => Controls_Manager::SELECT, 
            'default' => 'entire_site', 
            'options' => [ 
                'this_page'      => esc_html__( 'This Page Only', 'royal-addons-for-elementor' ),
                'entire_site'    => esc_html__( 'Entire Site', 'royal-addons-for-elementor' ), 
                'home_page'      => esc_html__( 'Home Page', 'royal-addons-for-elementor' ), 
                'all_pages'      => esc_html__( 'All Pages', 'royal-addons-for-elementor' ),
                'all_posts'      => esc_html__( 'All Single Posts', 'royal-addons-for-elementor' ),
                'specific_pages' => esc_html__( 'Specific Pages', 'royal-addons-for-elementor' ),
            ], 
            'condition' => [ 'popup_trigger!' => 'on_click' ] 
        ]);
        $this->add_control( 'specific_page_ids', [
            'label' => esc_html__( 'Select Pages', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => true,
            'options' => $this->get_all_pages_list(),
            'condition' => [
                'display_on' => 'specific_pages',
                'popup_trigger!' => 'on_click',
            ],
        ]);
        $this->add_control( 'enable_cookie', [
            'label' => esc_html__( 'Enable Cookie (Show Again Rule)', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
            'separator' => 'before',
            'condition' => [ 'popup_trigger!' => 'on_click' ],
        ]);
        $this->add_control( 'cookie_time', [
            'label' => esc_html__( 'Show Again After', 'royal-addons-for-elementor' ), 
            'type' => Controls_Manager::NUMBER, 
            'default' => 1, 
            'condition' => [ 
                'popup_trigger!' => 'on_click',
                'enable_cookie'  => 'yes',
                'cookie_time_unit!' => 'session',
            ] 
        ]);
        $this->add_control( 'cookie_time_unit', [ 
            'label' => esc_html__( 'Time Unit', 'royal-addons-for-elementor' ), 
            'type' => Controls_Manager::SELECT, 
            'default' => 'days', 
            'options' => [
                'minutes' => esc_html__( 'Minutes', 'royal-addons-for-elementor' ), 
                'hours'   => esc_html__( 'Hours', 'royal-addons-for-elementor' ), 
                'days'    => esc_html__( 'Days', 'royal-addons-for-elementor' ),
                'session' => esc_html__( 'Until Browser Closed (Session)', 'royal-addons-for-elementor' ),
            ], 
            'condition' => [ 
                'popup_trigger!' => 'on_click',
                'enable_cookie'  => 'yes',
            ] 
        ]);
        $this->add_control( 'cookie_per_page', [
            'label' => esc_html__( 'Cookie Per Page Only', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'description' => esc_html__( 'When enabled, dismissing the popup on this page will not hide it on other pages.', 'royal-addons-for-elementor' ),
            'condition' => [ 
                'popup_trigger!' => 'on_click',
                'enable_cookie'  => 'yes',
            ],
        ]);
        $this->add_control( 'enable_auto_close', ['label' => esc_html__( 'Automatic Close', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'separator' => 'before']);
        $this->add_control( 'auto_close_delay', ['label' => esc_html__( 'Auto Close Delay (sec)', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::NUMBER, 'default' => 5, 'condition' => ['enable_auto_close' => 'yes']]);
        $this->add_control( 'close_on_overlay', [
            'label' => esc_html__( 'Close on Overlay Click', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
            'separator' => 'before',
        ]);
        $this->add_control( 'close_on_esc', [
            'label' => esc_html__( 'Close on ESC Key', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'return_value' => 'yes',
        ]);
        $this->add_control( 'delay_close_button', ['label' => esc_html__( 'Delay Close Button Visibility', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER]);
        $this->add_control( 'close_button_delay', ['label' => esc_html__( 'Button Visible After (sec)', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::NUMBER, 'default' => 3, 'condition' => ['delay_close_button' => 'yes']]);
        $this->add_control( 'hide_on_mobile', [
            'label' => esc_html__( 'Hide on Mobile (< 768px)', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'return_value' => 'yes',
            'separator' => 'before',
        ]);
        $this->end_controls_section();

        //============================================
        // Style Tab
        //============================================
        $this->start_controls_section( 'section_style_button', [ 'label' => esc_html__( 'Trigger Button', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => [ 'popup_trigger' => 'on_click' ] ]);
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'button_typography', 'selector' => '{{WRAPPER}} .royal-popup-trigger-button' ]);
        $this->add_responsive_control( 'button_padding', [ 'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .royal-popup-trigger-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ]);
        $this->start_controls_tabs( 'button_tabs' );
        $this->start_controls_tab( 'button_normal', [ 'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'button_text_color', [ 'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-popup-trigger-button' => 'color: {{VALUE}};' ] ]);
        $this->add_control(
            'button_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .royal-popup-trigger-button svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control( Group_Control_Background::get_type(), [ 'name' => 'button_background', 'selector' => '{{WRAPPER}} .royal-popup-trigger-button' ]);
        $this->end_controls_tab();
        $this->start_controls_tab( 'button_hover', [ 'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'button_hover_color', [ 'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-popup-trigger-button:hover' => 'color: {{VALUE}};' ] ]);
        $this->add_control( 'button_icon_hover_color', [ 'label' => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-popup-trigger-button:hover i' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-popup-trigger-button:hover svg' => 'fill: {{VALUE}};' ] ]);
        $this->add_group_control( Group_Control_Background::get_type(), [ 'name' => 'button_hover_background', 'selector' => '{{WRAPPER}} .royal-popup-trigger-button:hover' ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_container', [ 'label' => esc_html__( 'Popup Container', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ]);
        $this->add_control( 'enable_fullscreen', ['label' => esc_html__( 'Enable Full Screen', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SWITCHER, 'prefix_class' => 'royal-popup-fullscreen--']);
        $this->add_responsive_control( 'popup_width', ['label' => esc_html__( 'Width', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', '%', 'vw' ], 'range' => [ 'px' => [ 'min' => 200, 'max' => 1600 ]], 'default' => [ 'unit' => 'px', 'size' => 700 ], 'selectors' => [ '{{WRAPPER}} .royal-popup__content' => 'max-width: {{SIZE}}{{UNIT}};' ], 'condition' => [ 'enable_fullscreen!' => 'yes' ]]);
        $this->add_responsive_control( 'popup_height', ['label' => esc_html__( 'Height', 'royal-addons-for-elementor' ), 
        'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', '%', 'vh' ], 'range' => [ 'px' => [ 'min' => 100, 'max' => 1200 ]], 
        'default' => [ 'unit' => 'px', 'size' => 500 ],
        'selectors' => [
            '{{WRAPPER}} .royal-popup__content' => 'height: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .royal-popup__content-inner' => 'height: {{SIZE}}{{UNIT}};'
            
        ], 
        'condition' => [ 'enable_fullscreen!' => 'yes' ]
        ]);
        $this->add_control( 'content_overflow', [
            'label' => esc_html__( 'Content Overflow', 'royal-addons-for-elementor' ), 
            'type' => Controls_Manager::SELECT, 'default' => 'hidden', 
            'options' => [
                'auto' => esc_html__('Scroll', 'royal-addons-for-elementor' ), 
                'hidden' => esc_html__( 'Hidden', 'royal-addons-for-elementor' )
            ], 
            'selectors' => [ '{{WRAPPER}} .royal-popup__content-inner' => 'overflow-y: {{VALUE}}; overflow-x: hidden;' ]
        ]);

        $this->add_control( 'popup_bg_color', ['label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#FFFFFF', 'selectors' => [ '{{WRAPPER}} .royal-popup__content' => 'background-color: {{VALUE}};' ]]);
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_animation', [ 'label' => esc_html__( 'Animation', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ]);
        $this->add_control( 'popup_animation', ['label' => esc_html__( 'Entrance Animation', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'zoomIn', 'options' => array_merge(['none' => esc_html__('None', 'royal-addons-for-elementor')], \RoyalAddons\Elementor\RoyalClass::royal_animation_in())]);
        $this->add_control( 'animation_in_duration', ['label' => esc_html__( 'Entrance Duration (ms)', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER, 'default' => ['size' => 500], 'range' => [ 'px' => ['min' => 100, 'max' => 2000]], 'selectors' => ['{{WRAPPER}} .royal-popup__content' => '--animate-duration: {{SIZE}}ms;'], 'condition' => [ 'popup_animation!' => 'none' ]]);
        $this->add_control( 'popup_animation_out', ['label' => esc_html__( 'Exit Animation', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'zoomOut', 'options' => array_merge(['none' => esc_html__('None', 'royal-addons-for-elementor')], \RoyalAddons\Elementor\RoyalClass::royal_animation_out()), 'separator' => 'before']);
        $this->add_control( 'animation_out_duration', ['label' => esc_html__( 'Exit Duration (ms)', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER, 'default' => ['size' => 500], 'range' => [ 'px' => ['min' => 100, 'max' => 2000]], 'condition' => [ 'popup_animation_out!' => 'none' ]]);
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_close_button', [ 'label' => esc_html__( 'Close Button', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ]);
        $this->add_control( 'enable_close_button', ['label' => esc_html__( 'Enable Close Button', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes', 'return_value' => 'yes']);
        $this->add_control( 'close_button_icon', ['label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::ICONS, 'default' => [ 'value' => 'fas fa-times', 'library' => 'fa-solid' ], 'condition' => [ 'enable_close_button' => 'yes' ]]);
        $this->add_responsive_control( 'close_button_icon_size', [ 'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => ['px'], 'range' => ['px' => ['min' => 10, 'max' => 50]], 'selectors' => [ '{{WRAPPER}} .royal-popup__close i' => 'font-size: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .royal-popup__close svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ], 'condition' => [ 'enable_close_button' => 'yes' ]]);
        $this->add_control( 'close_button_color', ['label' => esc_html__( 'Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-popup__close i' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-popup__close svg' => 'fill: {{VALUE}};' ], 'condition' => [ 'enable_close_button' => 'yes' ]]);
        $this->add_control( 'close_button_bg_color', ['label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-popup__close' => 'background-color: {{VALUE}};' ], 'condition' => [ 'enable_close_button' => 'yes' ]]);
        $this->add_responsive_control( 'close_button_top', ['label' => esc_html__( 'Position Top', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => ['px', '%'], 'range' => [ 'px' => ['min' => -100, 'max' => 200]], 'default' => ['unit' => 'px', 'size' => -15], 'selectors' => [ '{{WRAPPER}} .royal-popup__close' => 'top: {{SIZE}}{{UNIT}};' ], 'condition' => [ 'enable_close_button' => 'yes' ]]);
        $this->add_responsive_control( 'close_button_right', ['label' => esc_html__( 'Position Right', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => ['px', '%'], 'range' => [ 'px' => ['min' => -100, 'max' => 200]], 'default' => ['unit' => 'px', 'size' => -15], 'selectors' => [ '{{WRAPPER}} .royal-popup__close' => 'right: {{SIZE}}{{UNIT}};' ], 'condition' => [ 'enable_close_button' => 'yes' ]]);
        $this->end_controls_section();

        $this->start_controls_section( 'section_style_overlay', [ 'label' => esc_html__( 'Overlay', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ]);
        $this->add_control( 'enable_overlay', ['label' => esc_html__( 'Enable Overlay', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes', 'return_value' => 'yes']);
        $this->add_control( 'overlay_bg_color', ['label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => 'rgba(0, 0, 0, 0.75)', 'selectors' => [ '{{WRAPPER}} .royal-popup__overlay' => 'background-color: {{VALUE}};' ], 'condition' => [ 'enable_overlay' => 'yes' ]]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if ( ElementorPlugin::$instance->editor->is_edit_mode() ) {
            $this->render_editor_preview( $settings );
            return;
        }

        if ( 'on_click' === $settings['popup_trigger'] ) {
            $this->render_trigger_button( $settings );
        }
        
        if ( empty( $settings['popup_template'] ) ) { return; }
        if ( 'on_click' !== $settings['popup_trigger'] && ! $this->check_display_condition( $settings['display_on'], $settings ) ) { return; }

        $this->render_popup_html( $settings );
    }
    
    private function render_trigger_button( $settings ) {
        $this->add_render_attribute( 'button', 'class', 'royal-popup-trigger-button' );
        $this->add_render_attribute( 'button', 'role', 'button' );
        ?>
        <div class="royal-popup-trigger-button-wrapper">
            <a <?php $this->print_render_attribute_string( 'button' ); ?>>
                <?php if ( ! empty($settings['button_icon']['value']) && 'before' === $settings['icon_position'] ) Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                <span><?php echo esc_html( $settings['button_text'] ); ?></span>
                <?php if ( ! empty($settings['button_icon']['value']) && 'after' === $settings['icon_position'] ) Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </a>
        </div>
        <?php
    }

    private function render_popup_html( $settings ) {
        $this->add_render_attribute( 'wrapper', 'class', 'royal-popup' );
        $this->add_render_attribute( 'wrapper', 'data-trigger', $settings['popup_trigger'] );
        $this->add_render_attribute( 'wrapper', 'data-popup-id', $this->get_id() );
        $this->add_render_attribute( 'wrapper', 'data-animation-in', $settings['popup_animation'] );
        $this->add_render_attribute( 'wrapper', 'data-animation-out', $settings['popup_animation_out'] );
        $this->add_render_attribute( 'wrapper', 'data-animation-out-duration', $settings['animation_out_duration']['size'] );

        if ( 'onload' === $settings['popup_trigger'] && ! empty( $settings['onload_delay'] ) ) {
            $this->add_render_attribute( 'wrapper', 'data-onload-delay', $settings['onload_delay'] );
        }
        if ( 'after_scroll' === $settings['popup_trigger'] ) {
            $scroll_progress = ! empty( $settings['scroll_progress']['size'] ) ? $settings['scroll_progress']['size'] : 50;
            $this->add_render_attribute( 'wrapper', 'data-scroll-progress', $scroll_progress );
        }
        if ( 'inactivity' === $settings['popup_trigger'] && ! empty( $settings['inactivity_delay'] ) ) {
            $this->add_render_attribute( 'wrapper', 'data-inactivity-delay', $settings['inactivity_delay'] );
        }

        if ( 'on_click' !== $settings['popup_trigger'] ) {
            $enable_cookie = ( 'yes' === ( $settings['enable_cookie'] ?? 'yes' ) ) ? 'yes' : 'no';
            $this->add_render_attribute( 'wrapper', 'data-enable-cookie', $enable_cookie );
            $this->add_render_attribute( 'wrapper', 'data-cookie-time', $settings['cookie_time'] );
            $this->add_render_attribute( 'wrapper', 'data-cookie-time-unit', $settings['cookie_time_unit'] );
            if ( 'yes' === ( $settings['cookie_per_page'] ?? '' ) ) {
                $this->add_render_attribute( 'wrapper', 'data-cookie-per-page', 'yes' );
            }
        }
        if ( 'yes' === $settings['enable_auto_close'] ) $this->add_render_attribute( 'wrapper', 'data-auto-close', $settings['auto_close_delay'] );
        if ( 'yes' === $settings['delay_close_button'] ) $this->add_render_attribute( 'wrapper', 'data-close-button-delay', $settings['close_button_delay'] );

        $close_on_overlay = ( 'yes' === ( $settings['close_on_overlay'] ?? 'yes' ) ) ? 'yes' : 'no';
        $close_on_esc = ( 'yes' === ( $settings['close_on_esc'] ?? 'yes' ) ) ? 'yes' : 'no';
        $this->add_render_attribute( 'wrapper', 'data-close-on-overlay', $close_on_overlay );
        $this->add_render_attribute( 'wrapper', 'data-close-on-esc', $close_on_esc );

        if ( 'yes' === ( $settings['hide_on_mobile'] ?? '' ) ) {
            $this->add_render_attribute( 'wrapper', 'data-hide-mobile', 'yes' );
        }
        ?>
        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <?php if ( 'yes' === $settings['enable_overlay'] ) : ?>
                <div class="royal-popup__overlay"></div>
            <?php endif; ?>
            <div class="royal-popup__content">
                <div class="royal-popup__content-inner">
                    <?php if ( ! empty( $settings['popup_template'] ) ) { echo ElementorPlugin::instance()->frontend->get_builder_content_for_display( $settings['popup_template'], true ); } ?>
                </div>
                <?php if ( 'yes' === $settings['enable_close_button'] ) : ?>
                    <div class="royal-popup__close" role="button" aria-label="<?php esc_attr_e( 'Close Popup', 'royal-addons-for-elementor' ); ?>">
                        <?php Icons_Manager::render_icon( $settings['close_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function render_editor_preview( $settings ) {
        if ( 'yes' === ( $settings['preview_in_editor'] ?? '' ) && ! empty( $settings['popup_template'] ) ) {
            ?>
            <div class="royal-popup-editor-preview-card" style="border: 2px dashed #673ab7; border-radius: 8px; overflow: hidden; background: #fff; margin: 15px 0; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
                <div style="background: #673ab7; color: #fff; padding: 8px 16px; font-size: 13px; font-weight: 600; display: flex; justify-content: space-between; align-items: center;">
                    <span><i class="eicon-preview-medium" style="margin-right: 6px;"></i><?php esc_html_e( 'Popup Live Content Preview', 'royal-addons-for-elementor' ); ?></span>
                    <span style="font-size: 11px; opacity: 0.85;"><?php esc_html_e( 'Preview in Editor is Active', 'royal-addons-for-elementor' ); ?></span>
                </div>
                <div style="padding: 20px;">
                    <?php echo ElementorPlugin::instance()->frontend->get_builder_content_for_display( $settings['popup_template'], true ); ?>
                </div>
            </div>
            <?php
            if ( 'on_click' === $settings['popup_trigger'] ) {
                $this->render_trigger_button( $settings );
            }
            return;
        }
        ?>
        <div class="royal-popup-editor-placeholder">
            <div class="placeholder-icon"><i class="eicon-popup-modal"></i></div>
            <div class="placeholder-title"><?php echo esc_html( $this->get_title() ); ?></div>
            <div class="placeholder-text">Trigger: <strong><?php echo esc_html( $settings['popup_trigger'] ); ?></strong> | Display On: <strong><?php echo esc_html( $settings['display_on'] ); ?></strong>.</div>
        </div>
        <?php
        if ( 'on_click' === $settings['popup_trigger'] ) {
            $this->render_trigger_button( $settings );
        }
    }

    private function get_all_elementor_templates() {
        $options = [];
        if ( ! class_exists( 'Elementor\Plugin' ) ) { return $options; }
        $templates = ElementorPlugin::instance()->templates_manager->get_source( 'local' )->get_items();
        if ( empty( $templates ) ) { $options['0'] = esc_html__( 'No templates found.', 'royal-addons-for-elementor' ); return $options; }
        $options['0'] = esc_html__( 'Select a Template', 'royal-addons-for-elementor' );
        foreach ( $templates as $template ) { $options[ $template['template_id'] ] = $template['title'] . ' (' . ucfirst( $template['type'] ) . ')'; }
        return $options;
    }

    private function get_all_pages_list() {
        $pages = get_pages([
            'sort_column' => 'post_title',
            'sort_order'  => 'ASC',
        ]);
        $options = [];
        if ( ! empty( $pages ) ) {
            foreach ( $pages as $page ) {
                $options[ $page->ID ] = $page->post_title;
            }
        }
        return $options;
    }
    
    private function check_display_condition( $condition, $settings = [] ) {
        if ( ElementorPlugin::$instance->editor->is_edit_mode() ) { return false; }
        switch ( $condition ) {
            case 'this_page':
                return is_singular();
            case 'entire_site':
                return true;
            case 'home_page':
                return is_front_page();
            case 'all_pages':
                return is_page() && ! is_front_page();
            case 'all_posts':
                return is_single();
            case 'specific_pages':
                if ( empty( $settings['specific_page_ids'] ) ) {
                    return false;
                }
                $current_id = get_queried_object_id();
                $selected_ids = array_map( 'intval', (array) $settings['specific_page_ids'] );
                return in_array( (int) $current_id, $selected_ids, true ) || is_page( $selected_ids );
            default:
                return false;
        }
    }
}