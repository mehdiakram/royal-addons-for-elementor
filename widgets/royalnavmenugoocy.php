<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class RoyalNavMenuGoocy extends Widget_Base {

    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );

        // Register CSS & JS
        wp_register_style(
            'royalnavmenugoocy',
            ROYAL_ADDONS_ASSETS . 'css/royalnavmenugoocy.css',
            [],
            '1.0.0'
        );

        wp_register_script(
            'royalnavmenugoocy',
            ROYAL_ADDONS_ASSETS . 'js/royalnavmenugoocy.js',
            ['jquery'],
            '1.0.0',
            true
        );
    }

    public function get_name() {
        return 'royalnavmenugoocy';
    }

    public function get_title() {
        return __( 'Royal Nav Menu Goocy', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-nav-menu rtbranding'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_style_depends() {
        return [ 'royalnavmenugoocy' ];
    }

    public function get_script_depends() {
        return [ 'royalnavmenugoocy' ];
    }

    protected function register_controls() {
        // Menu Source: Dropdown or Custom Menu Items
        $this->start_controls_section(
            'section_menu_source',
            [
                'label' => __( 'Menu Source', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'menu_source',
            [
                'label' => __( 'Select Menu Source', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'custom' => __( 'Custom Menu', 'royal-addons-for-elementor' ),
                    'wp_menu' => __( 'WordPress Menu', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        // If WP Menu selected, show available menus dropdown
        $menus = [];
        foreach ( wp_get_nav_menus() as $menu ) {
            $menus[ $menu->slug ] = $menu->name;
        }

        $this->add_control(
            'wp_menu_select',
            [
                'label' => __( 'Select WordPress Menu', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => $menus,
                'default' => '',
                'condition' => [
                    'menu_source' => 'wp_menu',
                ],
            ]
        );

        $this->end_controls_section();

        // Custom Menu Items Repeater
        $this->start_controls_section(
            'section_custom_menu',
            [
                'label' => __( 'Custom Menu Items', 'royal-addons-for-elementor' ),
                'condition' => [
                    'menu_source' => 'custom',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label' => __( 'Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Menu Item', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => __( 'Link', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
                'default' => [ 'url' => '#' ],
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'custom_menu_items',
            [
                'label' => __( 'Menu Items List', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'item_text' => __( 'Home', 'royal-addons-for-elementor' ) ],
                    [ 'item_text' => __( 'About', 'royal-addons-for-elementor' ) ],
                    [ 'item_text' => __( 'Services', 'royal-addons-for-elementor' ) ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->end_controls_section();

        // Hamburger Icon Color & Menu Width Styling
        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Styling', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_bg_color',
            [
                'label' => __( 'Menu Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenugoocy, {{WRAPPER}} .royalnavmenugoocy #blob-path' => 'background-color: {{VALUE}}; fill: {{VALUE}};',
                ],
                'default' => '#FED057',
            ]
        );

        $this->add_control(
            'menu_item_color',
            [
                'label' => __( 'Menu Item Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenugoocy ul li a' => 'color: {{VALUE}};',
                ],
                'default' => '#26394E',
            ]
        );

        $this->add_control(
            'hamburger_color',
            [
                'label' => __( 'Hamburger Icon Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenugoocy .hamburger .line' => 'background-color: {{VALUE}};',
                ],
                'default' => '#26394E',
            ]
        );

        $this->add_control(
            'menu_width',
            [
                'label' => __( 'Menu Width (px)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 600,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenugoocy' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'label' => __( 'Menu Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalnavmenugoocy ul li a',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = 'royalnavmenugoocy-' . $this->get_id();
        ?>
        <div id="<?php echo esc_attr($id); ?>" class="royalnavmenugoocy" data-widget-id="<?php echo esc_attr($id); ?>">
            <div class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <div class="menu-inner">
                <ul>
                    <?php
                    if ( $settings['menu_source'] === 'custom' ) {
                        if ( $settings['custom_menu_items'] ) {
                            foreach ( $settings['custom_menu_items'] as $item ) {
                                $target = !empty($item['item_link']['is_external']) ? ' target="_blank"' : '';
                                $nofollow = !empty($item['item_link']['nofollow']) ? ' rel="nofollow"' : '';
                                echo '<li><a href="' . esc_url($item['item_link']['url']) . '"' . $target . $nofollow . '>' . esc_html($item['item_text']) . '</a></li>';
                            }
                        }
                    } else {
                        // Render WordPress menu if selected
                        if ( !empty($settings['wp_menu_select']) ) {
                            wp_nav_menu([
                                'menu' => $settings['wp_menu_select'],
                                'container' => false,
                                'items_wrap' => '%3$s',
                                'menu_class' => '',
                                'fallback_cb' => false,
                            ]);
                        }
                    }
                    ?>
                </ul>
            </div>
            <svg version="1.1" id="blob" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path id="blob-path" d="M60,500H0V0h60c0,0,20,172,20,250S60,900,60,500z"/>
            </svg>
        </div>
        <?php
    }
}
