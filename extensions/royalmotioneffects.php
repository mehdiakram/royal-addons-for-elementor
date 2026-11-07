<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;

defined( 'ABSPATH' ) || die();

class RoyalMotionEffects {

    public static function init() {
        add_action( 'elementor/element/after_section_end', [ __CLASS__, 'register_controls' ], 10, 2 );
        add_action( 'elementor/frontend/before_render', [ __CLASS__, 'render_fx' ] );
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'royalmotioneffects_enqueue' ], 100 );
        add_action( 'elementor/editor/before_enqueue_scripts', [ __CLASS__, 'royalmotioneffects_enqueue' ] );
    }

    public static function royalmotioneffects_enqueue() {
        $js_v = filemtime(ROYAL_ADDONS_DIR_PATH . 'assets/js/extension-royalmotioneffects.js');
        $css_v = filemtime(ROYAL_ADDONS_DIR_PATH . 'assets/css/extension-royalmotioneffects.css');
        wp_enqueue_script( 'royal-motion-effects-js', ROYAL_ADDONS_DIR_URL . 'assets/js/extension-royalmotioneffects.js', ['jquery'], $js_v, true );
        wp_enqueue_style( 'royal-motion-effects-css', ROYAL_ADDONS_DIR_URL . 'assets/css/extension-royalmotioneffects.css', [], $css_v );
    }

    private static $registered_elements = [];

    public static function register_controls( $element, $section_id = '' ) {
        if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

        if ( ! in_array( $section_id, [ 'section_advanced', 'section_custom_css_pro', 'section_effects' ] ) ) {
            return;
        }

        $element_id = $element->get_name();
        if ( isset( self::$registered_elements[ $element_id ] ) ) {
            return;
        }
        self::$registered_elements[ $element_id ] = true;

        $element->start_controls_section(
            'royalcontrolsection_motioneffects',
            [
                'label' => __( 'Motion Effects [Royal]', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        // --- SCROLLING EFFECTS ---
        $element->add_control(
            'royal_scrolling_effects',
            [
                'label' => __( 'Scrolling Effects', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => '',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_scroll_speed_y',
            [
                'label' => __( 'Vertical Scroll Speed', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => -10, 'max' => 10, 'step' => 0.1 ],
                ],
                'default' => [ 'size' => 4 ],
                'condition' => [
                    'royal_scrolling_effects' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_scroll_speed_x',
            [
                'label' => __( 'Horizontal Scroll Speed', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => -10, 'max' => 10, 'step' => 0.1 ],
                ],
                'default' => [ 'size' => 0 ],
                'condition' => [
                    'royal_scrolling_effects' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_motioneffects_divider_1',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        // --- MOUSE EFFECTS ---
        $element->add_control(
            'royal_mouse_effects',
            [
                'label' => __( 'Mouse Effects', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => '',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_mouse_track_speed',
            [
                'label' => __( 'Mouse Track Speed', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
                ],
                'default' => [ 'size' => 1 ],
                'condition' => [
                    'royal_mouse_effects' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_mouse_track_dir',
            [
                'label' => __( 'Direction', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'opposite' => __( 'Opposite', 'royal-addons-for-elementor' ),
                    'direct' => __( 'Direct', 'royal-addons-for-elementor' ),
                ],
                'default' => 'opposite',
                'condition' => [
                    'royal_mouse_effects' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_motioneffects_divider_2',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        // --- STICKY ---
        $element->add_control(
            'royal_custom_sticky',
            [
                'label' => __( 'Sticky', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'None', 'royal-addons-for-elementor' ),
                    'top' => __( 'Top', 'royal-addons-for-elementor' ),
                    'bottom' => __( 'Bottom', 'royal-addons-for-elementor' ),
                ],
                'default' => '',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_custom_sticky_stay_in_column',
            [
                'label' => __( 'Stay In Column', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => __( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'royal_custom_sticky!' => '',
                ],
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_custom_sticky_offset',
            [
                'label' => __( 'Sticky Offset (px)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'royal_custom_sticky!' => '',
                ],
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'royal_custom_sticky_effects_offset',
            [
                'label' => __( 'Effects Offset (px)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'condition' => [
                    'royal_custom_sticky!' => '',
                ],
                'frontend_available' => true,
            ]
        );

        $element->end_controls_section();
    }

    public static function render_fx( $element ) {
        $el_name = $element->get_name();
        $is_atomic = in_array($el_name, ['div-block', 'e-div-block', 'e-flexbox', 'atomic-widget-base']) || (strpos($el_name, 'atomic-') === 0);
        $settings = $is_atomic && method_exists($element, 'get_atomic_settings') ? $element->get_atomic_settings() : $element->get_settings_for_display();
        
        $has_fx = !empty($settings['royal_custom_sticky']) || !empty($settings['royal_scrolling_effects']) || !empty($settings['royal_mouse_effects']);

        if ( $has_fx ) {
            $element->add_render_attribute( '_wrapper', 'class', 'royal-custom-motioneffects-el' );
            $element->add_render_attribute( '_wrapper', 'data-royal-motioneffects', wp_json_encode([
                'sticky' => $settings['royal_custom_sticky'] ?? '',
                'stayInColumn' => isset($settings['royal_custom_sticky_stay_in_column']) && $settings['royal_custom_sticky_stay_in_column'] !== '' ? $settings['royal_custom_sticky_stay_in_column'] : 'yes',
                'stickyOffset' => $settings['royal_custom_sticky_offset'] ?? 0,
                'effectsOffset' => $settings['royal_custom_sticky_effects_offset'] ?? 0,
                'scrolling' => $settings['royal_scrolling_effects'] ?? '',
                'scrollY' => isset($settings['royal_scroll_speed_y']['size']) ? $settings['royal_scroll_speed_y']['size'] : 0,
                'scrollX' => isset($settings['royal_scroll_speed_x']['size']) ? $settings['royal_scroll_speed_x']['size'] : 0,
                'mouse' => $settings['royal_mouse_effects'] ?? '',
                'mouseSpeed' => isset($settings['royal_mouse_track_speed']['size']) ? $settings['royal_mouse_track_speed']['size'] : 1,
                'mouseDir' => $settings['royal_mouse_track_dir'] ?? 'opposite',
            ]) );
        }
    }
}
RoyalMotionEffects::init();
