<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RoyalNavMenuMorph extends Widget_Base {

	public function get_name() {
		return 'royalnavmenumorph';
	}

	public function get_title() {
		return esc_html__( 'Morph Menu', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-menu-bar rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [
            'menu', 'navigation', 'morph', 'nav', 'interactive', 'navbar', 'tech', 'technologies', 'royal', 'mehdi', 'akram'
        ];
	}

	public function get_script_depends() {
		return ['royalnavmenumorph']; 
	}

	public function get_style_depends() {
		return ['royalnavmenumorph'];
	}

	protected function register_controls() {
        // SECTION 1: Menu Items (Content Tab)
		$this->start_controls_section('section_menu_content', [
			'label' => esc_html__( 'Menu Items', 'royal-addons-for-elementor' ),
		]);

		$repeater = new Repeater();

		$repeater->add_control('menu_item_icon', [
			'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::ICONS,
			'fa4compatibility' => false,
			'default' => [
				'value' => 'eicon-menu-bar',
				'library' => 'eicons',
			],
		]);

		$repeater->add_control('menu_item_color', [
			'label' => esc_html__( 'Background Ball Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#ff8c00',
		]);

        $repeater->add_control('menu_item_icon_color', [
            'label' => esc_html__( 'Icon Color (Per Item)', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
        ]);

        // NEW CONTROL: Menu Item Link
        $repeater->add_control('menu_item_link', [
            'label' => esc_html__( 'Link', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::URL,
            'placeholder' => esc_html__( 'https://your-link.com', 'royal-addons-for-elementor' ),
            'options' => [ 'url', 'is_external', 'nofollow' ],
            'default' => [
                'url' => '#',
                'is_external' => false,
                'nofollow' => false,
            ],
            'show_external' => true,
        ]);


		$this->add_control('menu_items', [
			'label' => esc_html__( 'Menu Items', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'default' => [
				['menu_item_icon' => ['value' => 'eicon-menu-bar', 'library' => 'eicons'], 'menu_item_color' => '#ff8c00', 'menu_item_icon_color' => '#ffffff', 'menu_item_link' => ['url' => '#']],
				['menu_item_icon' => ['value' => 'eicon-cart-medium', 'library' => 'eicons'], 'menu_item_color' => '#f54888', 'menu_item_icon_color' => '#ffffff', 'menu_item_link' => ['url' => '#']],
				['menu_item_icon' => ['value' => 'eicon-gallery-grid', 'library' => 'eicons'], 'menu_item_color' => '#4343f5', 'menu_item_icon_color' => '#ffffff', 'menu_item_link' => ['url' => '#']],
				['menu_item_icon' => ['value' => 'eicon-star', 'library' => 'eicons'], 'menu_item_color' => '#e0b115', 'menu_item_icon_color' => '#ffffff', 'menu_item_link' => ['url' => '#']],
				['menu_item_icon' => ['value' => 'eicon-wrench', 'library' => 'eicons'], 'menu_item_color' => '#65ddb7', 'menu_item_icon_color' => '#ffffff', 'menu_item_link' => ['url' => '#']],
			],
			'title_field' => 'Menu Item Title',
		]);

		$this->end_controls_section(); // END section_menu_content

        // SECTION 2: Menu Style (Style Tab)
		$this->start_controls_section('section_menu_style', [
			'label' => esc_html__( 'Menu Style', 'royal-addons-for-elementor' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control('menu_width', [
			'label' => esc_html__( 'Menu Width', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', '%' ],
			'range' => [ 
                'px' => [ 'min' => 100, 'max' => 1200, 'step' => 1 ],
                'em' => [ 'min' => 10, 'max' => 60, 'step' => 0.1 ],
                '%' => [ 'min' => 20, 'max' => 100, 'step' => 1 ],
            ],
			'default' => [ 'size' => 32.05, 'unit' => 'em' ],
			'selectors' => [
				'{{WRAPPER}} .royal-morph-menu-wrapper .menu' => 'width: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('menu_font_size', [
			'label' => esc_html__( 'Menu Base Font Size', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', '%' ],
			'range' => [ 
                'px' => [ 'min' => 10, 'max' => 60, 'step' => 1 ],
                'em' => [ 'min' => 0.5, 'max' => 3, 'step' => 0.1 ],
                '%' => [ 'min' => 50, 'max' => 300, 'step' => 1 ],
            ],
			'default' => [ 'size' => 1.5, 'unit' => 'em' ],
			'selectors' => [
				'{{WRAPPER}} .royal-morph-menu-wrapper .menu' => 'font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('menu_padding', [
			'label' => esc_html__( 'Menu Padding', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => ['px', 'em', '%'],
			'default' => [
				'top' => '0',
				'right' => '2.85',
				'bottom' => '0',
				'left' => '2.85',
				'unit' => 'em',
			],
			'selectors' => [
				'{{WRAPPER}} .royal-morph-menu-wrapper .menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		$this->add_control('menu_background_color', [
			'label' => esc_html__( 'Menu Background Color', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::COLOR,
			'default' => '#1d1d27',
			'selectors' => [
				'{{WRAPPER}} .royal-morph-menu-wrapper .menu' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .royal-morph-menu-wrapper .menu__border' => 'background-color: {{VALUE}};',
				'{{WRAPPER}} .royal-morph-menu-wrapper' => '--bgColorMenu: {{VALUE}};',
			],
		]);

		$this->end_controls_section(); // END section_menu_style

        // SECTION 3: Menu Border (Style Tab)
        $this->start_controls_section('section_menu_border', [
            'label' => esc_html__( 'Menu Border', 'royal-addons-for-elementor' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'menu_wrapper_border',
                'selector' => '{{WRAPPER}} .royal-morph-menu-wrapper .menu',
                'fields_options' => [
                    'border' => [
                        'default' => 'none',
                    ],
                ],
            ]
        );

        $this->add_control('menu_border_radius', [
            'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
                '{{WRAPPER}} .royal-morph-menu-wrapper .menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);

        $this->end_controls_section(); // END section_menu_border

        // SECTION 4: Global Icon Style (Style Tab)
		$this->start_controls_section('section_icon_style', [
			'label' => esc_html__( 'Global Icon Style', 'royal-addons-for-elementor' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control('icon_size', [
			'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', '%' ],
			'range' => [ 
                'px' => [ 'min' => 10, 'max' => 100, 'step' => 1 ],
                'em' => [ 'min' => 1, 'max' => 5, 'step' => 0.1 ],
                '%' => [ 'min' => 50, 'max' => 200, 'step' => 1 ],
            ],
			'default' => [ 'size' => 2.6, 'unit' => 'em' ],
			'selectors' => [
				'{{WRAPPER}} .royal-morph-menu-wrapper .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
			],
		]);

		$this->add_control('icon_color', [
			'label' => esc_html__( 'Global Icon Color', 'royal-addons-for-elementor' ), 
			'type' => Controls_Manager::COLOR,
			'default' => '#ffffff',
            'selectors' => [
				'{{WRAPPER}} .royal-morph-menu-wrapper' => '--globaliconColorItem: {{VALUE}}',
			],
		]);

		$this->add_control('icon_stroke_width', [
			'label' => esc_html__( 'Icon Stroke Width (pt)', 'royal-addons-for-elementor' ),
			'type' => Controls_Manager::SLIDER,
			'range' => [ 'px' => [ 'min' => 0.1, 'max' => 5, 'step' => 0.1 ] ],
			'default' => [ 'size' => 1, 'unit' => 'pt' ],
			'selectors' => [
				'{{WRAPPER}} .royal-morph-menu-wrapper .icon svg' => 'stroke-width: {{SIZE}}pt;',
			],
		]);

		$this->end_controls_section(); // END section_icon_style
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		
		// Check if menu items exist
		if ( empty( $settings['menu_items'] ) ) {
			echo '<div class="royal-morph-menu-wrapper">';
			echo '<p style="text-align: center; padding: 20px;">' . esc_html__( 'No menu items configured. Please add menu items in the widget settings.', 'royal-addons-for-elementor' ) . '</p>';
			echo '</div>';
			return;
		}

		$menu_id = esc_attr( $this->get_id() );
		
		echo '<div class="royal-morph-menu-wrapper" data-menu-id="' . $menu_id . '">';
		echo '<nav class="menu">';

		foreach ( $settings['menu_items'] as $index => $item ) {
			$is_active = ( 0 === $index ) ? ' active' : '';
			$item_color_bg_ball = ! empty( $item['menu_item_color'] ) ? $item['menu_item_color'] : '#ff8c00'; // Background ball color
            $item_color_icon_per_item = ! empty( $item['menu_item_icon_color'] ) ? $item['menu_item_icon_color'] : $settings['icon_color']; // Per-item icon color, fallback to global

            // Set CSS custom properties for background ball color and per-item icon color on the button/link
            $button_styles = 'style="--bgColorItem:' . esc_attr( $item_color_bg_ball ) . '; --iconColorItem:' . esc_attr($item_color_icon_per_item) . ';"';
			
            // Hyperlink setup
            $item_link = $item['menu_item_link'];
            $target = $item_link['is_external'] ? ' target="_blank"' : '';
            $nofollow = $item_link['nofollow'] ? ' rel="nofollow"' : '';
            $link_url = !empty($item_link['url']) ? esc_url($item_link['url']) : '#';

            echo '<a class="menu__item' . esc_attr( $is_active ) . '" href="' . $link_url . '"' . $target . $nofollow . ' ' . $button_styles . ' data-index="' . esc_attr( $index ) . '">';
			
			if ( ! empty( $item['menu_item_icon']['value'] ) ) {
				Icons_Manager::render_icon( $item['menu_item_icon'], [ 
					'aria-hidden' => 'true', 
					'class' => 'icon' 
				] );
			}
			
			echo '</a>'; // Changed from </button> to </a>
		}

		echo '<div class="menu__border"></div>';
		echo '</nav>';
		echo '<div class="svg-container">';
		echo '<svg viewBox="0 0 202.9 45.5">';
		echo '<clipPath id="menu_' . $menu_id . '" clipPathUnits="objectBoundingBox" transform="scale(0.0049285362247413 0.021978021978022)">';
		echo '<path d="M6.7,45.5c5.7,0.1,14.1-0.4,23.3-4c5.7-2.3,9.9-5,18.1-10.5c10.7-7.1,11.8-9.2,20.6-14.3c5-2.9,9.2-5.2,15.2-7c7.1-2.1,13.3-2.3,17.6-2.1c4.2-0.2,10.5,0.1,17.6,2.1c6.1,1.8,10.2,4.1,15.2,7c8.8,5,9.9,7.1,20.6,14.3c8.3,5.5,12.4,8.2,18.1,10.5c9.2,3.6,17.6,4.2,23.3,4H6.7z" />';
		echo '</clipPath>';
		echo '</svg>';
		echo '</div>';
		echo '<style>.royal-morph-menu-wrapper[data-menu-id="' . $menu_id . '"] .menu__border { clip-path: url(#menu_' . $menu_id . '); }</style>';
		echo '</div>';
	}
}