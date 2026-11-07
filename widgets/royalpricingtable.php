<?php

namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly



class RoyalPricingTable extends Widget_Base {

    public function get_name(){
        return 'royalpricingtable';
    }


    public function get_title() {
        return __( 'Pricing Table', 'royal-addons-for-elementor' );
    }


    public function get_icon() { return 'eicon-price-table rtbranding'; }


    public function get_keywords() {
        return [ 'pricing', 'price', 'table', 'package', 'plan' , 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }


	public function get_categories() {
		return [ 'royaltech' ];
	}

    
	public function get_style_depends() {
		$styles = [ 'royalpricingtable' ];
		return $styles;
	}


    protected function register_controls() {

        $this->start_controls_section(
            'section_style_general',
            [
                'label' => __( 'General', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __( 'Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'rptstyle1' => __( 'Style 1', 'royal-addons-for-elementor' ),
                    'rptstyle2' => __( 'Style 2', 'royal-addons-for-elementor' ),

                ],
                'default' => 'rptstyle1',
                'selector' => '{{WRAPPER}} .royalpricingtable',
            ]
        );

        $this->end_controls_section();





        $this->start_controls_section(
            '_section_header',
            [
                'label' => __( 'Header', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __( 'Basic', 'royal-addons-for-elementor' ),
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            '_section_pricing',
            [
                'label' => __( 'Pricing', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'currency',
            [
                'label' => __( 'Currency', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    ''             => __( 'None', 'royal-addons-for-elementor' ),
                    'baht'         => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'bdt'          => '&#2547; ' . _x( 'BD Taka', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'dollar'       => '&#36; ' . _x( 'Dollar', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'euro'         => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'franc'        => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'krona'        => 'kr ' . _x( 'Krona', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'lira'         => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'peso'         => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'real'         => 'R$ ' . _x( 'Real', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'won'          => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'royal-addons-for-elementor' ),
                    'custom'       => __( 'Custom', 'royal-addons-for-elementor' ),
                ],
                'default' => 'bdt',
            ]
        );



        $this->add_control(
            'currency_custom',
            [
                'label' => __( 'Custom Symbol', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'currency' => 'custom',
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => __( 'Price', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '9.99',
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'period',
            [
                'label' => __( 'Period', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Per Month', 'royal-addons-for-elementor' ),
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();




        $this->start_controls_section(
            '_section_features',
            [
                'label' => __( 'Features', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'features_title',
            [
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Features', 'royal-addons-for-elementor' ),
                'separator' => 'after',
                'label_block' => true,
                'dynamic' => [
                    'active' => true
                ]
            ]
        );



        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'text',
            [
                'label' => __( 'Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __( 'Exciting Feature', 'royal-addons-for-elementor' ),
                'dynamic' => [
                    'active' => true
                ]
            ]
        );


        $repeater->add_control(
            'selected_icon',
            [
                'label' => __( 'Icon', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-regular' => [
                        'check-square',
                        'window-close',
                    ],
                    'fa-solid' => [
                        'check',
                    ]
                ]
            ]
        );
        

        $this->add_control(
          'features_list',
          [
            'label' => __( 'Features Items', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'show_label' => false,
            'default' => [
                [
                    'text' => __( 'Standard Feature', 'royal-addons-for-elementor' ),
                    'selected_icon' => 'fa fa-check',
                ],
                [
                    'text' => __( 'Another Great Feature', 'royal-addons-for-elementor' ),
                    'selected_icon' => 'fa fa-check',
                ],
                [
                    'text' => __( 'Obsolete Feature', 'royal-addons-for-elementor' ),
                    'selected_icon' => 'fa fa-close',
                ],
                [
                    'text' => __( 'Exciting Feature', 'royal-addons-for-elementor' ),
                    'selected_icon' => 'fa fa-check',
                ],

            ],
            'title_field' => '{{{ text }}}',
          ]
        );
        $this->end_controls_section();








        $this->start_controls_section(
            '_section_footer',
            [
                'label' => __( 'Footer', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Subscribe', 'royal-addons-for-elementor' ),
                'placeholder' => __( 'Type button text here', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => __( 'Link', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => 'https://example.com',
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '#'
                ]
            ]
        );

        $this->end_controls_section();







        $this->start_controls_section(
            '_section_badge',
            [
                'label' => __( 'Badge', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'show_badge',
            [
                'label' => __( 'Show', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'badge_position',
            [
                'label' => __( 'Position', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => false,
                'default' => 'left',
                'style_transfer' => true,
                'condition' => [
                    'show_badge' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'badge_text',
            [
                'label' => __( 'Badge Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Popular', 'royal-addons-for-elementor' ),
                'placeholder' => __( 'Type badge text', 'royal-addons-for-elementor' ),
                'condition' => [
                    'show_badge' => 'yes'
                ],
                'dynamic' => [
                    'active' => true
                ]
            ]
        );

        $this->end_controls_section();




        $this->start_controls_section(
            '_section_style_general',
            [
                'label' => __( 'General', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'royal-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .royalpricingtable',
            ]
        );



        $this->add_control(
            'item_bg_color',
            [
                'label' => __( 'Item Bankground Color (even)', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-features-list li:nth-child(even)' => 'background: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_section();




        $this->start_controls_section(
            '_section_style_header',
            [
                'label' => __( 'Header', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Bottom Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-title' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'title_bg_color',
            [
                'label' => __( 'Link Bankgroud Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
                'default' => '#FFFFFF00',
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-title' => 'background: {{VALUE}}',
                ],
            ]
        );




        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .royal-pricing-table-title',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .royal-pricing-table-title',
            ]
        );

        $this->end_controls_section();




        $this->start_controls_section(
            '_section_style_pricing',
            [
                'label' => __( 'Pricing', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_price',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Price', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'price_spacing',
            [
                'label' => __( 'Bottom Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-price-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-price-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .royal-pricing-table-price-text',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_control(
            '_heading_currency',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Currency', 'royal-addons-for-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'currency_spacing',
            [
                'label' => __( 'Side Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-currency' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'currency_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-currency' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'currency_typography',
                'selector' => '{{WRAPPER}} .royal-pricing-table-currency',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_control(
            '_heading_period',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Period', 'royal-addons-for-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'period_spacing',
            [
                'label' => __( 'Bottom Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'period_typography',
                'selector' => '{{WRAPPER}} .royal-pricing-table-period',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();





        $this->start_controls_section(
            '_section_style_features',
            [
                'label' => __( 'Features', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'features_container_spacing',
            [
                'label' => __( 'Container Bottom Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-body' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            '_heading_features_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'features_title_spacing',
            [
                'label' => __( 'Bottom Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-features-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'features_title_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-features-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_title_typography',
                'selector' => '{{WRAPPER}} .royal-pricing-table-features-title',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );


        $this->add_control(
            '_heading_features_list',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'List', 'royal-addons-for-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'features_list_spacing',
            [
                'label' => __( 'Spacing Between', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-features-list > li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'features_list_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-features-list > li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_list_typography',
                'selector' => '{{WRAPPER}} .royal-pricing-table-features-list > li',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();





        $this->start_controls_section(
            '_section_style_footer',
            [
                'label' => __( 'Footer', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_button',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Button', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .royal-pricing-table-btn',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .royal-pricing-table-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .royal-pricing-table-btn',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );

        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( '_tabs_button' );

        $this->start_controls_tab(
            '_tab_button_normal',
            [
                'label' => __( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6ec1e4',
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();




        $this->start_controls_tab(
            '_tab_button_hover',
            [
                'label' => __( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-btn:hover, {{WRAPPER}} .royal-pricing-table-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-btn:hover, {{WRAPPER}} .royal-pricing-table-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'button_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-btn:hover, {{WRAPPER}} .royal-pricing-table-btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();






        $this->start_controls_section(
            '_section_style_badge',
            [
                'label' => __( 'Badge', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'badge_padding',
            [
                'label' => __( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'badge_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'badge_bg_color',
            [
                'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#6ec1e4',
                'selectors' => [
                    '{{WRAPPER}} .rptstyle1 .royal-pricing-table-badge' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .rptstyle2 .royal-pricing-table-badge span' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .rptstyle2 .royal-pricing-table-badge::before' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .rptstyle2 .royal-pricing-table-badge::after' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'badge_border',
                'selector' => '{{WRAPPER}} .royal-pricing-table-badge',
            ]
        );

        $this->add_responsive_control(
            'badge_border_radius',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-pricing-table-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'badge_box_shadow',
                'selector' => '{{WRAPPER}} .royal-pricing-table-badge',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'badge_typography',
                'label' => __( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royal-pricing-table-badge',
                'global' => [
                    'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();
    }

    private static function get_currency_symbol( $symbol_name ) {
        $symbols = [
            'baht' => '&#3647;',
            'bdt' => '&#2547;',
            'dollar' => '&#36;',
            'euro' => '&#128;',
            'franc' => '&#8355;',
            'guilder' => '&fnof;',
            'indian_rupee' => '&#8377;',
            'pound' => '&#163;',
            'peso' => '&#8369;',
            'peseta' => '&#8359',
            'lira' => '&#8356;',
            'ruble' => '&#8381;',
            'shekel' => '&#8362;',
            'rupee' => '&#8360;',
            'real' => 'R$',
            'krona' => 'kr',
            'won' => '&#8361;',
            'yen' => '&#165;',
        ];

        return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'badge_text', 'class',
            [
                'royal-pricing-table-badge',
                'royal-pricing-table-badge--' . $settings['badge_position']
            ]
        );

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'royal-pricing-table-title' );

        $this->add_inline_editing_attributes( 'price', 'basic' );
        $this->add_render_attribute( 'price', 'class', 'royal-pricing-table-price-text' );

        $this->add_inline_editing_attributes( 'period', 'basic' );
        $this->add_render_attribute( 'period', 'class', 'royal-pricing-table-period' );

        $this->add_inline_editing_attributes( 'features_title', 'basic' );
        $this->add_render_attribute( 'features_title', 'class', 'royal-pricing-table-features-title' );

        $this->add_inline_editing_attributes( 'button_text', 'none' );
        $this->add_render_attribute( 'button_text', 'class', 'royal-pricing-table-btn' );

        $this->add_link_attributes( 'button_text', $settings['button_link'] );

        if ( $settings['currency'] === 'custom' ) {
            $currency = $settings['currency_custom'];
        } else {
            $currency = self::get_currency_symbol( $settings['currency'] );
        }
        ?>
        <div class="royalpricingtable">  
        <div class=" <?php echo wp_kses_post( $settings['style'] ) ?>">  
        <?php if ( $settings['show_badge'] ) : ?>
            <div <?php $this->print_render_attribute_string( 'badge_text' ); ?>><span><?php echo esc_html( $settings['badge_text'] ); ?></span></div>
        <?php endif; ?>

        <div class="royal-pricing-table-header">
            <?php if ( $settings['title'] ) : ?>
                <h2 <?php $this->print_render_attribute_string( 'title' ); ?>><?php echo wp_kses_post( $settings['title'] ); ?></h2>
            <?php endif; ?>
        </div>
        <div class="royal-pricing-table-price">
            <div class="royal-pricing-table-price-tag"><span class="royal-pricing-table-currency"><?php echo esc_html( $currency ); ?></span><span <?php $this->print_render_attribute_string( 'price' ); ?>><?php echo wp_kses_post( $settings['price'] ); ?></span></div>
            <?php if ( $settings['period'] ) : ?>
                <div <?php $this->print_render_attribute_string( 'period' ); ?>><?php echo wp_kses_post( $settings['period'] ); ?></div>
            <?php endif; ?>
        </div>
        <div class="royal-pricing-table-body">
            <?php if ( $settings['features_title'] ) : ?>
                <h3 <?php $this->print_render_attribute_string( 'features_title' ); ?>><?php echo wp_kses_post( $settings['features_title'] ); ?></h3>
            <?php endif; ?>

            <?php if ( is_array( $settings['features_list'] ) ) : ?>
                <ul class="royal-pricing-table-features-list">
                    <?php foreach ( $settings['features_list'] as $index => $feature ) :
                        $name_key = $this->get_repeater_setting_key( 'text', 'features_list', $index );
                        $this->add_inline_editing_attributes( $name_key, 'intermediate' );
                        $this->add_render_attribute( $name_key, 'class', 'royal-pricing-table-feature-text' );
                        ?>
                        <li class="<?php echo esc_attr( 'elementor-repeater-item-' . $feature['_id'] ); ?>">

                            <i class="<?php echo $feature['selected_icon']['value'] ?>"></i>

                            <div <?php $this->print_render_attribute_string( $name_key ); ?>><?php echo $feature['text']; ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <?php if ( $settings['button_text'] ) : ?>
            <a <?php $this->print_render_attribute_string( 'button_text' ); ?>><?php echo esc_html( $settings['button_text']); ?></a>
        <?php endif; ?>
        </div> 
        </div>
        <style type="text/css">
            

        </style> 
        <?php
    }




}