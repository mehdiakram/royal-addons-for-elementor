<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


// Your Royal_Data_Hover_Nav_Walker class definition goes here (outside RoyalNavMenu)
// ... (Your Royal_Data_Hover_Nav_Walker class code) ...


class RoyalNavMenu extends Widget_Base {

    public function get_name() {
        return 'royalnavmenu';
    }

    public function get_title() {
        return __( 'Nav Menu', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-nav-menu rtbranding'; }

    public function get_keywords() {
        return [ 'nav', 'menu', 'desktop', 'dropdown', 'tech', 'technologies', 'royal', 'mehdi', 'akram'];
    }

    public function get_categories() {
        return [ 'royaltech_headerfooter' ];
    }

    public function get_style_depends() {
        $styles = ['royalnavmenu', 'royalanimate'];
        return $styles;
    }

    protected function register_controls() {
        $this->rt_menu_selection_options();
        $this->rt_menu_style_options();
        $this->rt_main_menu_style_options();
        $this->rt_sub_menu_style_options();

        if (ROYAL_ADDONS_PRO_ACTIVE) {
            $this->rt_data_hover_options();
            $this->rt_multiple_color_options();
        }
    }

    private function rt_menu_selection_options() {
        $this->start_controls_section(
            'content',
            [
                'label' => __( 'Menu Selection', 'royal-addons-for-elementor' ),
            ]
        );

        $menus = $this->get_available_menus();

        if ( ! empty( $menus ) ) {
            $this->add_control(
                'menu',
                [
                    'label' => __( 'Select Menu', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => $menus,
                    'default' => array_keys( $menus )[0],
                    'separator' => 'after',
                    'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'royal-addons-for-elementor' ), admin_url( 'nav-menus.php' ) ),
                    'label_block' => 'true',
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus</a> screen to create one.', 'royal-addons-for-elementor' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                    'separator' => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        
        $this->add_control(
            'menu_layout',
            [
                'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal'    => esc_html__( 'Horizontal', 'royal-addons-for-elementor' ),
                    'vertical'      => esc_html__( 'Vertical', 'royal-addons-for-elementor' ),
                ],
            ]
        );
        
        $this->add_control(
            'sub_menu_showhide',
            [
                'label' => esc_html__( 'Submenu Hide', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'return_value' => 'submenuhide',
                'default' => 'submenuhide',
                'condition' => [
                    'menu_layout' => ['vertical', 'blank' ],
                ],      
            ]
        );          

        $this->add_control(
            'menu_alignment',
            [
                'label'   => __( 'Menu Alignment', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'flex-start',
                'separator' => 'before',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'menu_layout' => 'horizontal',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenuwarper' => 'display: flex; justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'hover_effect_section',
            [
                'label' => esc_html__( 'Hover Effect Section', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'menu_layout!' => [
                        'vertical'          
                    ],
                ],                      
            ]
        );

        $this->add_control(
            'menu_warper_hover_effect',
            [
                'label' => esc_html__( 'Hover Effect', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'menuhoverstroke',
                'options' => [
                    'menuhoverstroke'  => esc_html__( 'Stroke', 'royal-addons-for-elementor' ),
                    'menuhovershift'  => esc_html__( 'Shift', 'royal-addons-for-elementor' ),
                    'menuhovercircle'  => esc_html__( 'Circle', 'royal-addons-for-elementor' ),
                    'menuhoverfill'  => esc_html__( 'Fill', 'royal-addons-for-elementor' ),
                    '' => esc_html__( 'None', 'royal-addons-for-elementor' ),
                ],
            ]
        );
        $this->add_control(
            'menu_warper_hover_effect_color1',
            [
                'label' => __( 'Hover Effect Color 1', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#DDDDDD',
                'separator' => 'none',
                'condition' => [
                    'menu_warper_hover_effect' => [
                        'menuhoverstroke',
                        'menuhovershift',
                        'menuhovercircle',
                        'menuhoverfill',
                    ],
                ],                  
                'selectors' => [
                    '{{WRAPPER}} .menuhoverstroke ul li a:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .menuhovershift ul li a:after' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .menuhoverfill ul li a:after' => 'background-color: {{VALUE}};',
                    
                ],
            ]
        );
        
        $this->end_controls_section();  
    }


    private function rt_data_hover_options() {
        $this->start_controls_section(
            'data_hover_section',
            [
                'label' => esc_html__( 'Data Hover Effect', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_data_hover',
            [
                'label' => esc_html__( 'Enable Data Hover', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'data_hover_style',
            [
                'label' => esc_html__( 'Data Hover Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__( 'Style 1: Text Fade In', 'royal-addons-for-elementor' ),
                    'style2' => esc_html__( 'Style 2: Text Shift Up', 'royal-addons-for-elementor' ),
                    'style3' => esc_html__( 'Style 3: Background Reveal', 'royal-addons-for-elementor' ),
                    'style4' => esc_html__( 'Style 4: Custom Effect', 'royal-addons-for-elementor' ), // Example
                ],
                'condition' => [
                    'enable_data_hover' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'data_hover_transition_duration',
            [
                'label' => esc_html__( 'Data Hover Speed', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 's', 'ms' ],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'ms' => [
                        'min' => 100,
                        'max' => 5000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu li a' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu li[data-hover]::after' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu.data-hover-style-style3 li[data-hover]::before' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu.data-hover-style-style3 li[data-hover]::after' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu.data-hover-style-style4 li[data-hover]::after' => 'transition-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_data_hover' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'data_hover_typography',
                'label' => esc_html__( 'Data Hover Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu li[data-hover]::after',
                'condition' => [
                    'enable_data_hover' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'data_hover_color',
            [
                'label' => esc_html__( 'Data Hover Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu li[data-hover]::after' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_data_hover' => 'yes',
                    'menu_style' => 'default',
                ],
            ]
        );

        $this->add_control(
            'data_hover_bg_color',
            [
                'label' => esc_html__( 'Data Hover Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled .royalhorizontalmenu li[data-hover]::after' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_data_hover' => 'yes',
                    'menu_style' => 'default',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function rt_menu_style_options() {
        $this->start_controls_section(
            'section_menu_Style',
            [
                'label' => esc_html__( 'Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'menu_style',
            [
                'label' => esc_html__( 'Menu Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'royal-addons-for-elementor' ),
                    'multiple_colors' => esc_html__( 'Multiple Colors (Pro)', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        if ( ! ROYAL_ADDONS_PRO_ACTIVE ) {
            $this->add_control(
                'pro_notice_multiple_colors',
                [
                    'type' => Controls_Manager::NOTICE,
                    'notice_type' => 'warning',
                    'title' => esc_html__( 'Pro Feature', 'royal-addons-for-elementor' ),
                    'content' => esc_html__( 'This feature is available in the Pro version. Please upgrade to unlock.', 'royal-addons-for-elementor' ),
                    'show_icon' => true,
                    'condition' => [
                        'menu_style' => 'multiple_colors',
                    ],
                ]
            );
        }

        $this->end_controls_section();
    }


    private function rt_multiple_color_options() {
        $this->start_controls_section(
            'section_multiple_colors',
            [
                'label' => esc_html__( 'Multiple Colors', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_style' => 'multiple_colors',
                ],
            ]
        );

        $this->add_control(
            'multiplecolors_style',
            [
                'label' => esc_html__( 'Multiple Style ', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'multiplecolorsborder',
                'options' => [
                    'multiplecolorsborder' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
                    'multiplecolorsmenu' => esc_html__( 'Menu', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
			'multiplecolors_style_border_bottom',
			[
				'label' => esc_html__( 'Border Bottom', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
                'condition' => [
                    'multiplecolors_style' => 'multiplecolorsborder',
                ],
				'selectors' => [
					'{{WRAPPER}} .multiplecolorsborder .royalhorizontalmenu > li > a' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'multiplecolors_hover',
            [
                'label' => esc_html__( 'Hover Style ', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'individualhover',
                'options' => [
                    'individualhover' => esc_html__( 'Individual', 'royal-addons-for-elementor' ),
                    'globalhover' => esc_html__( 'Global', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $repeater = new Repeater();
		$repeater->add_control(
			'item_label',
			[
				'label'       => esc_html__( 'Color Set Name', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Custom Color', 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'menu_item_color',
			[
				'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} > a' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} li a' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'menu_item_background',
			[
				'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#17479d',
				'selectors' => [
					'{{WRAPPER}} .multiplecolorsmenu {{CURRENT_ITEM}} > a' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .multiplecolorsborder {{CURRENT_ITEM}} > a' => 'border-bottom-color: {{VALUE}};',
                    '{{WRAPPER}} .individualhover {{CURRENT_ITEM}} > a:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .sub-menu' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled.individualhover {{CURRENT_ITEM}}[data-hover]::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'menu_item_hover_color',
			[
				'label' => esc_html__( 'Hover Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalhorizontalmenu {{CURRENT_ITEM}} > a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalverticalmenu {{CURRENT_ITEM}} > a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalhorizontalmenu {{CURRENT_ITEM}} li a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royalverticalmenu {{CURRENT_ITEM}} li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'menu_item_hover_background',
			[
				'label' => esc_html__( 'Hover Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0000008C',
				'selectors' => [
					'{{WRAPPER}} .globalhover {{CURRENT_ITEM}} > a:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .globalhover {{CURRENT_ITEM}} li a:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .individualhover {{CURRENT_ITEM}} li a:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royalnavmenuwarper.data-hover-enabled.globalhover {{CURRENT_ITEM}}[data-hover]::after' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'menu_colors_list',
            [
                'label' => esc_html__( 'Menu Item Colors', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
					[ // Default Set 1
						'menu_item_color' => '#ffffff',
						'menu_item_background' => '#17479d',
						'menu_item_hover_color' => '#ffffff',
						'menu_item_hover_background' => '#8224e3',
					],
					[ // Default Set 2
						'menu_item_color' => '#ffffff', // different color example
						'menu_item_background' => '#FF6600',
						'menu_item_hover_color' => '#FFFFFF',
						'menu_item_hover_background' => '#8224e3', // default purple
					],
					[ // Default Set 3
						'menu_item_color' => '#ffffff',
						'menu_item_background' => '#C40A2A',
						'menu_item_hover_color' => '#ffffff',
						'menu_item_hover_background' => '#8224e3',
					],
					[ // Default Set 4
						'menu_item_color' => '#ffffff',
						'menu_item_background' => '#84154D',
						'menu_item_hover_color' => '#FFFFFF',
						'menu_item_hover_background' => '#8224e3',
					],
					[ // Default Set 5
						'menu_item_color' => '#ffffff',
						'menu_item_background' => '#098346',
						'menu_item_hover_color' => '#FFC107',
						'menu_item_hover_background' => '#8224e3',
					],
					[ // Default Set 6
						'menu_item_color' => '#ffffff',
						'menu_item_background' => '#1399BE',
						'menu_item_hover_color' => '#FFFFFF',
						'menu_item_hover_background' => '#8224e3',
					],
					[ // Default Set 7
						'menu_item_color' => '#ffffff',
						'menu_item_background' => '#8768DE',
						'menu_item_hover_color' => '#FFFFFF',
						'menu_item_hover_background' => '#8224e3',
					],
				],
                'title_field' => 'Color Set: {{{ item_label }}}',
                'max_items' => 10,
            ]
        );

        $this->end_controls_section();
    }


    private function rt_main_menu_style_options() {

        $this->start_controls_section(
            'main_menu_style_section',
            [
                'label' => esc_html__( 'Main Menu', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'royal_mainmenu_background',
            [
                'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#00000000',
                'separator' => 'none',
                'condition' => [
                    'menu_style' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalnavmenuwarper' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mainmenu_typography',
                'selector' => '
                {{WRAPPER}} .royalhorizontalmenu > li > a, 
                {{WRAPPER}} .royalverticalmenu > li > a',
            ]
        );

        $this->add_responsive_control(
            'mainmenu_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .royalverticalmenu > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'mainmenu_margin',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .royalverticalmenu > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'mainmenu_border_radius',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .royalverticalmenu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mainmenu_border',
                'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
                'selector' => '
                {{WRAPPER}} .royalhorizontalmenu > li > a, 
                {{WRAPPER}} .royalverticalmenu > li > a',

            ]
        );

        // --- CORRECTED LOCATION FOR MAIN MENU TRANSITION DURATION ---
        $this->add_control(
            'mainmenu_transition_duration',
            [
                'label' => esc_html__( 'Main Menu Transition Speed', 'royal-addons-for-elementor' ), // Renamed for clarity
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 's', 'ms' ],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'ms' => [
                        'min' => 100,
                        'max' => 5000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3, // Default to 0.3 seconds
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu > li > a' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .royalverticalmenu > li > a' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    // Apply to original hover effects' pseudo-elements if they use transition-duration (not animation-duration)
                    '{{WRAPPER}} .menuhoverstroke ul li a:after' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .menuhovershift ul li a:after' => 'transition-duration: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .menuhoverfill ul li a:after' => 'transition-duration: {{SIZE}}{{UNIT}};',
                ],
                // No condition here, as it should always be available for main menu styling
            ]
        );
        // --- END CORRECTED LOCATION ---


        $this->add_control(
            'mainmenu_text_align',
            [
                'label' => __( 'Text Align', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors_dictionary' => [
                    'left' => 'text-align: left',
                    'center' => 'text-align: center',
                    'right' => 'text-align: right',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu' => '{{VALUE}}',
                    '{{WRAPPER}} .royalverticalmenu' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'menu_dropdown_arrow',
            [
                'label' => esc_html__( 'Submenu Top Arrow', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'menudropdownarrow',
                'options' => [
                    'menudropdownnoarrow' => esc_html__( 'No Arrow', 'royal-addons-for-elementor' ),
                    'menudropdownarrow' => esc_html__( 'Arrow', 'royal-addons-for-elementor' ),
                    'menudropdownplusminus' => esc_html__( 'Plus Minus', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'menu_dropdown_arrow_padding_right',
            [
                'label' => esc_html__( 'Extra Padding', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'condition' => [
                    'menu_dropdown_arrow!' => 'menudropdownnoarrow',
                ],
                'selectors' => [
                    '{{WRAPPER}} .menudropdownarrow .royalhorizontalmenu > li.menu-item-has-children > a' => 'padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .menudropdownplusminus .royalhorizontalmenu > li.menu-item-has-children > a' => 'padding-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs(
            'tabs_mainmenu_style',
            [
                'condition' => [
                    'menu_style' => 'default',
                ]
            ]
            
        );

        $this->start_controls_tab(
            'tab_mainmenu_normal',
            [
                'label' => __( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'mainmenu_color_normal',
            [
                'label' => __( 'Main Menu Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu li a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mainmenu_background_normal',
            [
                'label' => __( 'Main Menu Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF00',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu > li > a' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu > li > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();


        $this->start_controls_tab(
            'tab_mainmenu_hover',
            [
                'label' => __( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'mainmenu_color_hover',
            [
                'label' => __( 'Main Menu Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mainmenu_background_hover',
            [
                'label' => __( 'Main Menu Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0000008C',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu > li:hover > a' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu > li:hover > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();  
        
        $this->start_controls_tab(
            'tab_mainmenu_active',
            [
                'label' => __( 'Active', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'mainmenu_color_active',
            [
                'label' => __( 'Main Menu Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li.current-menu-item a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu li.current-menu-item a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mainmenu_background_active',
            [
                'label' => __( 'Main Menu Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0000008C',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu > li.current-menu-item > a' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu > li.current-menu-item > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();  

    }


    private function rt_sub_menu_style_options() {

        $this->start_controls_section(
            'sub_menu_style_section',
            [
                'label' => esc_html__( 'Sub Menu', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'sub_menu_showhide',
                            'operator' => '!==',
                            'value' => 'submenuhide',
                        ],
                        [
                            'name' => 'menu_layout',
                            'operator' => '!==',
                            'value' => 'vertical',
                        ],
                    ],
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submenu_typography',
                'label' => __( 'Submenu Typography', 'royal-addons-for-elementor' ),
                'selector' => '
                    {{WRAPPER}} .royalhorizontalmenu li ul.sub-menu li a,
                    {{WRAPPER}} .royalverticalmenu li ul.sub-menu li a',
            ]
        );  

        $this->add_control(
            'submenu_animation',
            [
                'label' => esc_html__( 'Submenu Animation', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fadeInRight',
                'options'       => \RoyalAddons\Elementor\RoyalClass::royal_animation_in(),
                'selectors' => [
                    '{{WRAPPER}}' => '--submenuanimation: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_top_arrow',
            [
                'label' => esc_html__( 'Submenu Top Arrow', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'submenutoparrow',
                'options' => [
                    '' => esc_html__( 'No Arrow', 'royal-addons-for-elementor' ),
                    'submenutoparrow' => esc_html__( 'Arrow', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'submenu_top_arrow_color',
            [
                'label' => esc_html__( 'Arrow Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00b3dc',
                'condition' => [
                    'submenu_top_arrow' => [ 'submenutoparrow' ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu.submenutoparrow > .menu-item-has-children > .sub-menu:before' => 'border-bottom: 12px {{VALUE}} solid;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submenu_border',
                'label' => esc_html__( 'Submenu Border', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu',
            ]
        );

        $this->add_control(
            'submenu_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs(
            'tabs_submenu_style',
            [
                'condition' => [
                    'menu_style' => 'default',
                ]
            ]
        );

        $this->start_controls_tab(
            'tab_submenu_normal',
            [
                'label' => __( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'submenu_color',
            [
                'label' => __( 'Submenu Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu li ul.sub-menu a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu .menu-item-has-children a::after' => 'border-left-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_background',
            [
                'label' => __( 'Submenu Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu li ul.sub-menu' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'tab_submenu_style_hover',
            [
                'label' => __( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'submenu_color_hover',
            [
                'label' => __( 'Submenu Hover Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu li ul.sub-menu a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_background_hover',
            [
                'label' => __( 'Submenu Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#0000008C',
                'separator' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu a:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .royalverticalmenu li ul.sub-menu a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        ); 

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'submenu_padding',
            [
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'label' => esc_html__( 'Submenu Item Padding', 'royal-addons-for-elementor' ),
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .royalverticalmenu li ul.sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submenu_li_border',
                'label' => esc_html__( 'Submenu Item Border', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalhorizontalmenu li ul.sub-menu li a, {{WRAPPER}} .royalverticalmenu li ul.sub-menu li a',
                
            ]
        );

        $this->end_controls_section();  
    }


    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
    }


	protected function render() {
		$settings = $this->get_settings_for_display();
		$available_menus = $this->get_available_menus();

		if ( ! $available_menus ) {
			return;
		}
		
		$menu_layout            = $settings['menu_layout'];
		$hover_effect           = $settings['menu_warper_hover_effect'];
		$sub_menu_showhide      = $settings['sub_menu_showhide'];
		$enable_data_hover      = $settings['enable_data_hover'] ?? '';
		$data_hover_style       = $settings['data_hover_style'] ?? '';
		$menu_style             = $settings['menu_style'] ?? 'default';
		$multiplecolors_style   = $settings['multiplecolors_style'] ?? '';
		$multiplecolors_hover   = $settings['multiplecolors_hover'] ?? '';
                
        if ( 'multiple_colors' === $menu_style && ! ROYAL_ADDONS_PRO_ACTIVE ) {
            $menu_style = 'default';
        }

		$menu_colors_list = [];
		if ( $menu_style === 'multiple_colors' && ! empty( $settings['menu_colors_list'] ) ) {
			$menu_colors_list = $settings['menu_colors_list'];
		}


        $args = [
            'echo'               => false,
            'menu'               => $settings['menu'],
            'menu_id'            => '',
            'fallback_cb'        => '__return_empty_string',
            'container'          => '',
            'enable_data_hover'  => $enable_data_hover,
            'menu_style'         => $menu_style,
            'menu_colors_list'   => $menu_colors_list,
            'repeater_id_prefix' => 'elementor-repeater-item-',
        ];

        if (ROYAL_ADDONS_PRO_ACTIVE) {
            $args['walker'] = new \Royal_Mega_Nav_Walker();
        }


		if( "horizontal" == $menu_layout ){
			$args['menu_class'] = 'royalhorizontalmenu';
		} elseif( "vertical" == $menu_layout ){
			$args['menu_class'] = 'royalverticalmenu';
		} else {
			$args['menu_class'] = 'royalhorizontalmenu';
		}

		$content_html = wp_nav_menu( $args );

		$mainclasses = [
			'royalnavmenuwarper',
			$settings['submenu_top_arrow'],
			$settings['menu_dropdown_arrow'],
		];

		$secondclasses = [
			$settings['menu_warper_hover_effect'],
			$settings['sub_menu_showhide'],
		];

		if ( $enable_data_hover === 'yes' ) {
			$mainclasses[] = 'data-hover-enabled';
			$secondclasses[] = 'data-hover-style-' . $data_hover_style;
		}
		
		if ( $menu_style === 'multiple_colors' ) {
			$mainclasses[] = $multiplecolors_style;
			$mainclasses[] = $multiplecolors_hover;
		}
		
		$mainclasses_attribute = implode( ' ', array_map( 'sanitize_html_class', $mainclasses ) );
		$secondclasses_attribute = implode( ' ', array_map( 'sanitize_html_class', $secondclasses ) );
		
		echo '<div class="' . esc_attr( $mainclasses_attribute ) . '">';
			echo '<div class="' . esc_attr( $secondclasses_attribute ) . '">';
				echo $content_html;
			echo '</div>';
		echo '</div>';
	}









}