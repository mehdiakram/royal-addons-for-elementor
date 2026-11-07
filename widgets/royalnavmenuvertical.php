<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class RoyalNavMenuVertical extends Widget_Base {

	public function get_name() {
        return 'royalnavmenuvertical';
    }

    public function get_title() {
        return esc_html__( 'Vertical Nav Menu', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-menu-bar rtbranding'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_keywords() {
        return [ 'nav', 'menu', 'vertical', 'navigation', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
    }

    public function get_style_depends() {
        return [ 'royalnavmenuvertical' ];
    }

    public function get_script_depends() {
        return [ 'royalnavmenuvertical' ];
    }

    protected function register_controls() {
        // --- All controls from the previous step remain exactly the same ---
        // --- No changes are needed in this function ---
        $this->start_controls_section(
            'section_menu_content',
            [
                'label' => esc_html__( 'Menu Content', 'royal-addons-for-elementor' ),
            ]
        );

        $menus = $this->get_available_menus();
        if ( ! empty( $menus ) ) {
            $this->add_control(
                'nav_menu',
                [
                    'label' => esc_html__( 'Select Menu', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => $menus,
                    'default' => !empty($menus) ? array_keys( $menus )[0] : '',
                    'description' => sprintf( esc_html__( 'Go to the %sMenus screen%s to manage your menus.', 'royal-addons-for-elementor' ), '<a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">', '</a>' ),
                    'save_default' => true,
                    'separator' => 'after',
                ]
            );
        } else {
            $this->add_control(
                'no_menu_message',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf( esc_html__( 'No menus have been created yet. Go to the %sMenus screen%s to create one.', 'royal-addons-for-elementor' ), '<a href="' . esc_url( admin_url( 'nav-menus.php?action=edit&menu=0' ) ) . '" target="_blank">', '</a>' ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $this->end_controls_section();

        $this->start_controls_section(
            'section_menu_layout',
            [
                'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_height',
            [
                'label' => esc_html__( 'Menu Height', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [ 'px' => [ 'min' => 100, 'max' => 1000 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
                'default' => [ 'unit' => 'px', 'size' => 500 ],
                'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical-container' => 'height: {{SIZE}}{{UNIT}}; overflow: hidden;' ],
            ]
        );

        $this->add_control(
            'menu_width',
            [
                'label' => esc_html__( 'Menu Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [ 'px' => [ 'min' => 100, 'max' => 1000 ], '%' => [ 'min' => 10, 'max' => 100 ] ],
                'default' => [ 'unit' => 'px', 'size' => 250 ],
                'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical' => 'width: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'submenu_width',
            [
                'label' => esc_html__( 'Submenu Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [ 'px' => [ 'min' => 100, 'max' => 1000 ], '%' => [ 'min' => 10, 'max' => 100 ] ],
                'default' => [ 'unit' => 'px', 'size' => 250 ],
                'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical-submenu' => 'min-width: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'enable_scrollbar',
            [
                'label' => __( 'Enable Scrollbar', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
                'prefix_class' => 'royal-scrollbar-',
            ]
        );

        $this->add_control(
			'scroll_bar_direction',
			[
				'label' => __( 'Scroll Bar Direction', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'rtl' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'ltr' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'rtl',
				'selectors' => [
					'{{WRAPPER}} .royal-nav-menu-vertical-container' => 'direction:{{VALUE}};',
				],
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],
			]
		);

		$this->add_control(
            'scroll_content_direction',
            [
                'label' => __( 'Content Position', 'text-domain' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'ltr' => [
                        'title' => __( 'Left', 'text-domain' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'rtl' => [
                        'title' => __( 'Right', 'text-domain' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'ltr',
                'prefix_class' => 'royal-content-dir-',
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],                
            ]
        );

        $this->add_control(
            'scrollbar_width',
            [
                'label' => esc_html__( 'Scrollbar Width', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 2, 'max' => 20 ],
                ],
                'default' => [
                    'size' => 12,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-nav-menu-vertical-container::-webkit-scrollbar' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],                
            ]
        );

        $this->add_control(
            'scrollbar_thumb_color',
            [
                'label' => esc_html__( 'Thumb Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1D4C58',
                'selectors' => [
                    '{{WRAPPER}} .royal-nav-menu-vertical-container::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],                
            ]
        );

        $this->add_control(
            'scrollbar_track_color',
            [
                'label' => esc_html__( 'Track Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#C6CACA',
                'selectors' => [
                    '{{WRAPPER}} .royal-nav-menu-vertical-container::-webkit-scrollbar-track' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],                
            ]
        );

        $this->add_control(
            'scrollbar_thumb_hover_color',
            [
                'label' => esc_html__( 'Thumb Hover Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-nav-menu-vertical-container:hover::-webkit-scrollbar-thumb' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],                
            ]
        );

        $this->add_control(
            'scrollbar_radius',
            [
                'label' => esc_html__( 'Scrollbar Radius', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 20 ],
                ],
                'default' => [
                    'size' => 8,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-nav-menu-vertical-container::-webkit-scrollbar-thumb' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royal-nav-menu-vertical-container::-webkit-scrollbar-track' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],                
            ]
        );

        $this->add_control(
            'submenu_visibility_on',
            [
                'label' => esc_html__( 'Submenu Visibility', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'hover' => [ 'title' => esc_html__( 'Hover', 'royal-addons-for-elementor' ), 'icon' => 'eicon-pointer' ],
                    'click' => [ 'title' => esc_html__( 'Click', 'royal-addons-for-elementor' ), 'icon' => 'eicon-click' ],
                ],
                'default' => 'click',
                'toggle' => false,
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => esc_html__( 'Parent Menu', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'selector' => '{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item > a',
            ]
        );

        $this->add_control(
            'menu_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-nav-menu-vertical-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('parent_menu_tabs');

        // Normal Tab
        $this->start_controls_tab('parent_menu_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);
        $this->add_control('parent_menu_color_normal', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item > a' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('parent_menu_bg_normal', [
            'label' => esc_html__('Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'parent_menu_border_normal',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item',
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab('parent_menu_hover', ['label' => esc_html__('Hover', 'royal-addons-for-elementor')]);
        $this->add_control('parent_menu_color_hover', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item:hover > a' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('parent_menu_bg_hover', [
            'label' => esc_html__('Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item:hover' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'parent_menu_border_hover',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item:hover',
        ]);
        $this->end_controls_tab();

        // Active Tab
        $this->start_controls_tab('parent_menu_active', ['label' => esc_html__('Active', 'royal-addons-for-elementor')]);
        $this->add_control('parent_menu_color_active', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item.active > a' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('parent_menu_bg_active', [
            'label' => esc_html__('Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item.active' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'parent_menu_border_active',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical > .royal-nav-menu-vertical-item.active',
        ]);
        $this->end_controls_tab();
        
        // First Child Tab
        $this->start_controls_tab('parent_menu_firstchild', ['label' => esc_html__('First', 'royal-addons-for-elementor')]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'parent_menu_first_typography',
                'selector' => '{{WRAPPER}} .royal-nav-menu-vertical .royal-nav-menu-vertical-item.has-submenu.open > a',
            ]
        );        
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control('heading_icon', [ 'label' => esc_html__( 'Item Icon', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ]);
        $this->add_control('menu_item_icon', [ 'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::ICONS, 'label_block' => true ]);
        $this->add_control('icon_color', [
            'label' => esc_html__( 'Icon Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical-item > a .menu-item-icon' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-nav-menu-vertical-item > a .menu-item-icon svg' => 'fill: {{VALUE}};' ],
            'condition' => [ 'menu_item_icon[value]!' => '' ],
        ]);
        $this->add_responsive_control('icon_size', [
            'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px', 'em' ],
            'range' => [ 'px' => [ 'min' => 5, 'max' => 50 ] ],
            'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical-item > a .menu-item-icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
            'condition' => [ 'menu_item_icon[value]!' => '' ],
        ]);
        $this->add_responsive_control('icon_spacing', [
            'label' => esc_html__( 'Icon Spacing', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SLIDER,
            'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
            'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical-item > a .menu-item-icon' => 'margin-right: {{SIZE}}{{UNIT}};' ],
            'condition' => [ 'menu_item_icon[value]!' => '' ],
        ]);
        
        $this->add_control('heading_indicator', [ 'label' => esc_html__( 'Sub-menu Indicator', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ]);
        $this->add_control('indicator_type', [
            'label' => esc_html__( 'Indicator Type', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::CHOOSE,
            'options' => [ 'text' => [ 'title' => __('Text', 'royal-addons-for-elementor'), 'icon' => 'eicon-text' ], 'icon' => [ 'title' => __('Icon', 'royal-addons-for-elementor'), 'icon' => 'eicon-star' ] ],
            'default' => 'text', 'toggle' => false,
        ]);
        $this->add_control('indicator_text', [
            'label' => esc_html__( 'Indicator Text', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => '>',
            'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical-indicator:after' => 'content: "{{VALUE}}";' ],
            'condition' => [ 'indicator_type' => 'text' ],
        ]);
        $this->add_control('indicator_icon', [
            'label' => esc_html__( 'Indicator Icon', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-chevron-right', 'library' => 'fa-solid' ],
            'condition' => [ 'indicator_type' => 'icon' ],
        ]);
        $this->add_responsive_control('indicator_icon_width', [
            'label' => esc_html__('Icon Width', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SLIDER,
            'default' => ['size' => 10, 'unit' => 'px'], 'size_units' => ['px'],
            'range' => ['px' => ['min' => 5, 'max' => 50]],
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-indicator svg' => 'width: {{SIZE}}{{UNIT}};'],
            'condition' => ['indicator_type' => 'icon'],
        ]);
        $this->add_control('indicator_icon_color', [
            'label' => esc_html__('Icon Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-indicator i' => 'color: {{VALUE}};', '{{WRAPPER}} .royal-nav-menu-vertical-indicator svg' => 'fill: {{VALUE}};'],
            'condition' => ['indicator_type' => 'icon'],
        ]);
        $this->add_control('indicator_rotation', [
            'label' => esc_html__('Rotation on Open', 'royal-addons-for-elementor'), 'type' => Controls_Manager::SLIDER,
            'default' => ['size' => 90], 'unit' => ['deg'],
            'range' => ['deg' => ['min' => 0, 'max' => 360]],
            'selectors' => [ '{{WRAPPER}} .royal-nav-menu-vertical-item.has-submenu.open > a .royal-nav-menu-vertical-indicator' => 'transform: rotate({{SIZE}}deg);' ],
        ]);
        $this->end_controls_section();

        $this->start_controls_section(
            'section_submenu_style',
            [
                'label' => esc_html__( 'Sub Menu', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), [
            'name' => 'submenu_box_shadow',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical-submenu',
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'submenu_typography',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item a',
            'separator' => 'before',
        ]);
        
        $this->start_controls_tabs('submenu_tabs');

        // Normal Tab
        $this->start_controls_tab('submenu_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);
        $this->add_control('submenu_color_normal', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item a' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('submenu_bg_normal', [
            'label' => esc_html__('Background Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-submenu' => 'background-color: {{VALUE}};'],
        ]);
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'submenu_border_normal',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item',
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab('submenu_hover', ['label' => esc_html__('Hover', 'royal-addons-for-elementor')]);
        $this->add_control('submenu_color_hover', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item:hover a' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('submenu_bg_hover', [
            'label' => esc_html__('Background Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item:hover' => 'background-color: {{VALUE}};'],
        ]);
         $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'submenu_border_hover',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item:hover',
        ]);
        $this->end_controls_tab();

        // Active Tab
        $this->start_controls_tab('submenu_active', ['label' => esc_html__('Active', 'royal-addons-for-elementor')]);
        $this->add_control('submenu_color_active', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item.active a' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('submenu_bg_active', [
            'label' => esc_html__('Background Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item.active' => 'background-color: {{VALUE}};'],
        ]);
         $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'submenu_border_active',
            'selector' => '{{WRAPPER}} .royal-nav-menu-vertical-submenu .royal-nav-menu-vertical-item.active',
        ]);
        $this->end_controls_tab();

        // First Child Tab
        $this->start_controls_tab('sub_menu_firstchild', ['label' => esc_html__('First', 'royal-addons-for-elementor')]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_menu_first_typography',
                'selector' => '{{WRAPPER}} .royal-nav-menu-vertical li.royal-nav-menu-vertical-item.has-submenu.open .royal-nav-menu-vertical-submenu li:first-child > a',
            ]
        );        
        $this->end_controls_tab();


        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function get_available_menus() {
        $menus = wp_get_nav_menus();
        $options = [];
        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }
        return $options;
    }

    private function get_menu_items( $menu_slug ) {
        $menu_items = wp_get_nav_menu_items( $menu_slug );
        if ( is_wp_error( $menu_items ) || empty( $menu_items ) ) { return false; }
        $items = [];
        foreach ( $menu_items as $item ) {
            $items[ $item->ID ] = $item;
            $items[ $item->ID ]->children = [];
        }
        $menu_tree = [];
        foreach ( $items as $item ) {
            if ( $item->menu_item_parent != 0 && isset( $items[ $item->menu_item_parent ] ) ) {
                $items[ $item->menu_item_parent ]->children[] = $item;
            } else { $menu_tree[] = $item; }
        }
        return $menu_tree;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $menu_slug = $settings['nav_menu'];
        $menu_tree = $this->get_menu_items( $menu_slug );

        if ( empty( $menu_slug ) || ! $menu_tree ) {
            // Render a placeholder menu if no menu is selected or found.
            // This ensures visibility in the editor.
            ?>
            <div class="royal-nav-menu-vertical-container">
                <ul class="royal-nav-menu-vertical">
                    <li class="royal-nav-menu-vertical-item active has-submenu">
                        <a href="#"><span class="menu-item-text">Editor Menu Item 1</span><span class="royal-nav-menu-vertical-indicator"></span></a>
                        <ul class="royal-nav-menu-vertical-submenu">
                             <li class="royal-nav-menu-vertical-item"><a href="#"><span class="menu-item-text">Sub Menu Item 1</span></a></li>
                             <li class="royal-nav-menu-vertical-item"><a href="#"><span class="menu-item-text">Sub Menu Item 2</span></a></li>
                        </ul>
                    </li>
                    <li class="royal-nav-menu-vertical-item">
                        <a href="#"><span class="menu-item-text">Editor Menu Item 2</span></a>
                    </li>
                    <li class="royal-nav-menu-vertical-item">
                        <a href="#"><span class="menu-item-text">Editor Menu Item 3</span></a>
                    </li>
                </ul>
            </div>
            <?php
            return;
        }
        
        ?>
        <div class="royal-nav-menu-vertical-container">
            <ul class="royal-nav-menu-vertical" data-submenu-visibility="<?php echo esc_attr($settings['submenu_visibility_on']); ?>">
                <?php $this->render_menu_items( $menu_tree, $settings ); ?>
            </ul>
        </div>
        <?php
    }

    protected function render_menu_items( $menu_items, $settings ) {
        foreach ( $menu_items as $item ) {
            $item_classes = 'royal-nav-menu-vertical-item';
            $has_children = !empty( $item->children );
            if ( $has_children ) { $item_classes .= ' has-submenu'; }
            if ( in_array( 'current-menu-item', $item->classes ) || in_array('current-menu-ancestor', $item->classes) ) { $item_classes .= ' active'; }
            ?>
            <li class="<?php echo esc_attr( $item_classes ); ?>">
                <a href="<?php echo $has_children ? '#' : esc_url( $item->url ); ?>" target="<?php echo esc_attr( $item->target ); ?>">
                    <?php if ( ! empty( $settings['menu_item_icon']['value'] ) && $item->menu_item_parent == 0 ) : ?>
                        <span class="menu-item-icon"><?php Icons_Manager::render_icon( $settings['menu_item_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                    <?php endif; ?>
                    <span class="menu-item-text"><?php echo esc_html( $item->title ); ?></span>
                    <?php if ( $has_children ) : ?>
                        <span class="royal-nav-menu-vertical-indicator">
                            <?php if ( $settings['indicator_type'] === 'icon' ) { Icons_Manager::render_icon( $settings['indicator_icon'], [ 'aria-hidden' => 'true' ] ); } ?>
                        </span>
                    <?php endif; ?>
                </a>
                <?php if ( $has_children ) : ?>
                    <ul class="royal-nav-menu-vertical-submenu"><?php $this->render_menu_items( $item->children, $settings ); ?></ul>
                <?php endif; ?>
            </li>
            <?php
        }
    }

    protected function content_template() {
        ?>
        <#
            var activeClass = 'active';
            var iconHTML = elementor.helpers.renderIcon( view, settings.menu_item_icon, { 'aria-hidden': true }, 'i' , 'object' );
            var indicatorIconHTML = elementor.helpers.renderIcon( view, settings.indicator_icon, { 'aria-hidden': true }, 'i' , 'object' );
        #>
        <div class="royal-nav-menu-vertical-container">
            <ul class="royal-nav-menu-vertical" data-submenu-visibility="{{ settings.submenu_visibility_on }}">
                <li class="royal-nav-menu-vertical-item {{{ activeClass }}} has-submenu">
                    <a href="#" class="royal-nav-menu-vertical-link">
                        <# if ( iconHTML.value ) { #><span class="menu-item-icon">{{{ iconHTML.value }}}</span><# } #>
                        <span class="menu-item-text">Menu Item 1</span>
                        <span class="royal-nav-menu-vertical-indicator">
                             <# if ( settings.indicator_type === 'icon' && indicatorIconHTML.value ) { #>{{{ indicatorIconHTML.value }}}<# } #>
                        </span>
                    </a>
                    <ul class="royal-nav-menu-vertical-submenu">
                        <li class="royal-nav-menu-vertical-item"><a href="#"><span class="menu-item-text">Sub Menu 1.1</span></a></li>
                        <li class="royal-nav-menu-vertical-item active"><a href="#"><span class="menu-item-text">Sub Menu 1.2</span></a></li>
                    </ul>
                </li>
                <li class="royal-nav-menu-vertical-item">
                    <a href="#">
                        <# if ( iconHTML.value ) { #><span class="menu-item-icon">{{{ iconHTML.value }}}</span><# } #>
                        <span class="menu-item-text">Menu Item 2</span>
                    </a>
                </li>
            </ul>
        </div>
        <?php
    }
}