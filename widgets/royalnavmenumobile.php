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
use Elementor\Plugin;
use RoyalAddons\Elementor\Royal_Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalNavMenuMobile extends Widget_Base {

	public function get_name() {
		return 'royalnavmenumobile';
	}


	public function get_title() {
		return __( 'Mobile Menu / Off Canvas', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-menu-bar rtbranding'; }


	public function get_keywords() {
		return [ 'nav', 'menu', 'mobile', 'dropdown', 'off', 'canvas', 'offcanvas', 'sidebar', 'template', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech_headerfooter' ];
	}


	public function get_style_depends() {
		$styles = ['royalnavmenumobile'];
		return $styles;
	}

	

	protected function register_controls() {
		$this->general_section();
		$this->general_style_section();
		$this->header_style_section();
		$this->menu_style_section();
		$this->submenu_style_section();
	}


	protected function general_section() {
		$this->start_controls_section(
			'content',
			[
				'label' => __( 'General Section', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'source',
			[
				'label'   		=> __('Source', 'royal-addons-for-elementor'),
				'type'    		=> Controls_Manager::SELECT,
				'default' 		=> 'menu',
				'options' 		=> [
					'menu'  	=> __('Menu', 'royal-addons-for-elementor'),
					'sidebar'  	=> __('Sidebar', 'royal-addons-for-elementor'),
					'template'  => __('Template', 'royal-addons-for-elementor'),
				],
			]
		);

		$this->add_control(
			'sidebars',
			[
				'label'   		=> __('Choose Sidebar', 'royal-addons-for-elementor'),
				'type'    		=> Controls_Manager::SELECT,
				'default' 		=> '0',
				'options' 		=> Royal_Helpers::royal_theme_sidebars(),
				'condition' 	=> [
					'source' => 'sidebar',
				],
			]
		);

		$this->add_control(
			'templates',
			[
				'label'   		=> __('Choose Template', 'royal-addons-for-elementor'),
				'type'    		=> Controls_Manager::SELECT,
				'options' 		=> Royal_Helpers::royal_elementor_templates(),
				'condition' 	=> [
					'source' => 'template',
				],
			]
		);


		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label' => __( 'Choose Menu', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'separator' => 'after',
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'royal-addons-for-elementor' ), admin_url( 'nav-menus.php' ) ),
					'label_block' => 'true',
					'condition' 	=> [
						'source' => 'menu',
					],
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
					'condition' 	=> [
						'source' => 'menu',
					],
				]
			);
		}


		$this->add_control(
			'hamburger_style',
			[
				'label'   		=> __('Hamburger Style', 'royal-addons-for-elementor'),
				'type'    		=> Controls_Manager::SELECT,
				'default' 		=> 'hamburgersvgstyle2',
				'options' 		=> [
					'icon'  			=> __('Icon', 'royal-addons-for-elementor'),
					'hamburgersvgstyle1'  	=> __('SVG Style 1', 'royal-addons-for-elementor'),
					'hamburgersvgstyle2'  	=> __('SVG Style 2', 'royal-addons-for-elementor'),
					'hamburgersvgstyle3'  	=> __('SVG Style 3', 'royal-addons-for-elementor'),
					'hamburgersvgstyle4'  	=> __('SVG Style 4', 'royal-addons-for-elementor'),
					'hamburgersvgstyle5'  	=> __('SVG Style 5', 'royal-addons-for-elementor'),
				],
			]
		);

		$this->add_control(
			'hamburger_icon',
			[
				'label' => esc_html__( 'Hamburger', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' 	=> [
					'hamburger_style' => 'icon',
				],
				'skin' => 'inline',
				'label_block' => false,
				'default' => [
					'value' => 'fas fa-bars',
					'library' => 'solid',
				],
                'recommended' => [
                    'fa-regular' => [
                        'map',
                    ],
                    'fa-solid' => [
                        'bars',
                        'ellipsis-h',
                        'ellipsis-v',
                        'braille',
                        'circle-notch',
                        'dot-circle',
                        'map',
                    ]
                ]				
			]
		);	
		$this->end_controls_section();


		$this->start_controls_section(
			'top_section',
			[
				'label' => esc_html__( 'Header Section', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'mobile_menu_top',
			[
				'label' => __( 'Mobile Menu Top', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Logo Show', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Title Show', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Only Close Button', 'royal-addons-for-elementor' ),
					'4' => esc_html__( 'Nothing', 'royal-addons-for-elementor' ),
				],
			]
		);
		

		$this->add_control(
			'sitelogo',
			[
				'label' => esc_html__( 'Site Logo', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'mobile_menu_top' => '1',
				],				
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'full',
				'condition' => [
					'mobile_menu_top' => '1',
				],				
			]
		);

		$this->add_control(
			'sitetitle',
			[
				'label' => esc_html__( 'Site Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'mobile_menu_top' => '2',
				],					
				'default' => esc_html__( 'Royal Technologies', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Site title here', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'hamburger_close_icon',
			[
				'label' => esc_html__( 'Menu Close Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'condition' => [
					'mobile_menu_top!' => '4',
					'hamburger_style' => 'icon',
				],
				'default' => [
					'value' => 'fas fa-times',
					'library' => 'solid',
				],
                'recommended' => [
                    'fa-regular' => [
                        'window-close',
                        'times-circle',
                        'times-circle',
                    ],
                    'fa-solid' => [
                        'window-close',
                        'times-circle',
                        'times',
                    ]
                ]				
			]
		);

		$this->end_controls_section();

	}

	protected function general_style_section() {
		$this->start_controls_section(
			'general_style_section',
			[
				'label' => __( 'General Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'royalmobilemenucontainerwidth',
			[
				'label' => esc_html__( 'Container Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],					
				],
				'default' => [
					'unit' => 'px',
					'size' => 350,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer .royalmobilemenuwarper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'royalmobilemenucontainermaxwidth',
			[
				'label' => esc_html__( 'Container Max Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],					
				],
				'default' => [
					'unit' => '%',
					'size' => 90,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer .royalmobilemenuwarper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hamburger_icon_size',
			[
				'label' => esc_html__( 'Hamburger Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 32,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenushow i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}' => '--size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hamburger_icon_color',
			[
				'label' => __( 'Hamburger Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,			
				'default' => '#000000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenushow i' => 'color: {{VALUE}};',
					'{{WRAPPER}}' => '--hamburgercolor: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient'],
				'separator' => 'before',
				'fields_options' => [
					'background' => [
						'label' => esc_html__('Container Background', 'royal-addons-for-elementor'),
						'default' => 'classic',
					],
					'color' => [
						'default' => '#ffffff',
					],
				],
				'selector' => '{{WRAPPER}} .royalmobilemenucontainer .royalmobilemenuwarper',
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' 		=> __('Container Padding', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .royalmobilemenucontainer .royalmobilemenuwarper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' 	=> 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'selector' => '{{WRAPPER}} .royalmobilemenushow',
			]
		);


		$this->add_control(
			'container_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenushow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'menu_background_overlay_color',
			[
				'label' => __( 'Overlay Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,			
				'default' => '#00000030',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cursor_mode',
			[
				'label' => __('Cursor Mode', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'plugin',
				'options' => [
					'default' 	=> 'System',
					'plugin'  	=> 'Plugin',
				],
				'prefix_class' => 'cursor-mode-', 
			]
		);

		$this->add_control(
			'cursor_type',
			[
				'label' => __('Cursor Type', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'pointer',
				'options' => [
					'auto' 			=> 'Auto',
					'default' 		=> 'Default',
					'pointer' 		=> 'Pointer',
					'crosshair' 	=> 'Crosshair',
					'text' 			=> 'Text',
					'move' 			=> 'Move',
					'grab' 			=> 'Grab',
					'not-allowed' 	=> 'Not Allowed',
					'wait' 			=> 'Wait',
					'none' 			=> 'None',
				],
				'condition' => [
					'cursor_mode' => 'default'
				],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer' => 'cursor: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_position',
			[
				'label' => __( 'Menu Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer .royalmobilemenuwarper' => '{{VALUE}}: 0;',
				],
			]
		);
		

		$this->add_control(
			'menu_derection',
			[
				'label' => __( 'Menu Direction', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'-100%' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'100%' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '-100',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer' => 'transform: translateX({{VALUE}});',
				],
			]
		);	


        $this->end_controls_section();
	}

	protected function header_style_section() {
		$this->start_controls_section(
			'header_style_section',
			[
				'label' => esc_html__( 'Header Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'header_background',
				'label' => esc_html__( 'Header Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalmobilemenucontainer .top',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label' 		=> __('Header Padding', 'royal-addons-for-elementor'),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .royalmobilemenucontainer .top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' 	=> 'before',
			]
		);

		$this->add_control(
			'hamburger_close_icon_size',
			[
				'label' => esc_html__( 'Hamburger Close Icon Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'mobile_menu_top!' => '4',
				],				
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 32,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer .close i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}' => '--closesize: {{SIZE}}{{UNIT}};',

				],
			]
		);					

		$this->add_control(
			'hamburger_close_icon_color',
			[
				'label' => __( 'Menu Close Icon Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,					
				'default' => '#000000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer .close i' => 'color: {{VALUE}};',
					'{{WRAPPER}}' => '--hamburgerclosecolor: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'sitetitle_typography',
				'condition' => [
					'mobile_menu_top' => '2',
				],				
				'selector' => '{{WRAPPER}} .royalmobilemenucontainer .sitetitle',
			]
		);
		
		$this->add_control(
			'sitetitle_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'mobile_menu_top' => '2',
				],					
				'default' => '#000000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenucontainer .sitetitle' => 'color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
	}



	protected function menu_style_section() {
		$this->start_controls_section(
			'mainmenu_section',
			[
				'label' => esc_html__( 'Main Menu Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'source' => 'menu',
				],
			]
		);
		


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mainmenu_typography',
				'selector' => '{{WRAPPER}} .royalmobilenavmenu li a',
			]
		);

		$this->add_control(
			'mainmenu_full_background',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu > li' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'mainmenu_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .royalmobilemenu > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->start_controls_tabs( 'tabs_mainmenu_style' );
		$this->start_controls_tab(
			'tab_mainmenu_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'mainmenu_color',
			[
				'label' => __( 'Main Menu Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu li a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mainmenu_background',
			[
				'label' => __( 'Main Menu Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF00',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu > li > a' => 'background-color: {{VALUE}};',
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
				'default' => '#000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mainmenu_background_hover',
			[
				'label' => __( 'Main Menu Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#DDDDDD',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu > li:hover > a' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();		
		$this->end_controls_tabs();
		$this->end_controls_section();	
	}

		protected function submenu_style_section() {
		$this->start_controls_section(
			'submenu_section',
			[
				'label' => esc_html__( 'Sub Menu Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' 	=> [
					'source' => 'menu',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'submenu_typography',
				'label' => __( 'Submenu Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royalmobilemenu li ul.sub-menu li a',
			]
		);	



		$this->add_responsive_control(
			'submenu_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Sub Menu Padding', 'royal-addons-for-elementor' ),
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu li ul.sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



		$this->start_controls_tabs( 'tabs_submenu_style' );
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
				'default' => '#fff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu li ul.sub-menu a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submenu_background',
			[
				'label' => __( 'Submenu Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgb(88 89 91/0.80)',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu li ul.sub-menu li a' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalmobilemenu li ul.sub-menu a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submenu_background_hover',
			[
				'label' => __( 'Submenu Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgb(88 89 91/0.80)',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalmobilemenu li ul.sub-menu li a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();

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
		$settings 			= $this->get_settings_for_display();
		$available_menus 	= $this->get_available_menus();
		$source 			= $settings['source'];
		$hamburger_style 	= $settings['hamburger_style'];

		$args = [
			'echo' => false,
			'menu' => $settings['menu'],
			'menu_class' => 'royalmobilemenu',
			'menu_id' => '',
			'fallback_cb' => '__return_empty_string',
			'container' => '',
		];
		$content_html = wp_nav_menu( $args );

		$mobile_menu_top = $settings['mobile_menu_top'];

		?>




	<div class="royalmobilemenushow" role="button" aria-label="Open menu" tabindex="0">
	<?php $this->render_hamburger_open(); ?>
	
	</div>
	<div class="royalmobilemenucontainer">
		<div class="royalmobilemenuwarper">
		<?php if( 1 == $mobile_menu_top ){ ?>
			<div class="top">
				<div class="sitelogo"><?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'sitelogo' ); ?></div>
				<div class="close" role="button" aria-label="Close menu" tabindex="0"><?php $this->render_hamburger_close(); ?></div>
			</div>

		<?php } elseif(2 == $mobile_menu_top ){ ?>
			<div class="top">
				<div class="sitetitle"><?php echo wp_kses_post( $settings['sitetitle'] );?></div>
				<div class="close" role="button" aria-label="Close menu" tabindex="0"><?php $this->render_hamburger_close(); ?></div>
			</div>	
		<?php } elseif(3 == $mobile_menu_top ){ ?>
			<div class="top">
				<div class="nul"></div>
				<div class="close" role="button" aria-label="Close menu" tabindex="0"><?php $this->render_hamburger_close(); ?></div>
			</div>				
		<?php } elseif(4 == $mobile_menu_top ){ ?>		

		<?php } else { ?>

		<?php } ?>

			<div class="royalmobilenavmenu">
				<?php 
				if(! empty($source)) {
	            	if('sidebar' == $source && ('0' != $settings['sidebars'] && ! empty($settings['sidebars']))) {
	            		dynamic_sidebar($settings['sidebars']);
	            	} else if('template' == $source && ('0' != $settings['templates'] && ! empty($settings['templates']))) {
	            		echo Plugin::instance()->frontend->get_builder_content_for_display($settings['templates']);
	            	} else if('menu' == $source && ('0' != $settings['menu'] && ! empty($settings['menu']))) {
	            		echo $content_html;
	            	} else {
	            		echo '<div class="no-menu">'.__('No Menu Found', 'royal-addons-for-elementor').'</div>';
	            	}
	            } ?>
			</div>
		</div>
	</div>
	<?php
	}


	protected function render_hamburger_open() {
		$settings 			= $this->get_settings_for_display();
		$hamburger_style 	= $settings['hamburger_style'];


		 if ($hamburger_style == "icon") { ?>
			<i class="<?php echo $settings['hamburger_icon']['value'] ?>"></i>
	
			<?php } elseif($hamburger_style == "hamburgersvgstyle1"){ ?>
			<div class="hamburgericon hamburgersvg1open">
				<svg class="burger" viewBox="0 0 100 100">
					<path class="line line1" d="M 50,65 H 70 C 70,65 75,65.198488 75,70.762712 C 75,73.779026 74.368822,78.389831 66.525424,78.389831 C 22.092231,78.389831 -18.644068,-30.508475 -18.644068,-30.508475" />
					<path class="line line2" d="M 50,35 H 70 C 70,35 81.355932,35.300135 81.355932,25.635593 C 81.355932,20.906215 78.841706,14.830508 72.881356,14.830508 C 35.648232,14.830508 -30.508475,84.322034 -30.508475,84.322034" />
					<path class="line line3" d="M 50,50 H 30 C 30,50 12.288136,47.749959 12.288136,60.169492 C 12.288136,67.738339 16.712974,73.305085 40.677966,73.305085 C 73.791674,73.305085 108.47458,-19.915254 108.47458,-19.915254" />
					<path class="line line4" d="M 50,50 H 70 C 70,50 81.779661,50.277128 81.779661,36.607372 C 81.779661,28.952694 77.941689,25 69.067797,25 C 39.95532,25 -16.949153,119.91525 -16.949153,119.91525" />
					<path class="line line5" d="M 50,65 H 30 C 30,65 17.79661,64.618439 17.79661,74.152543 C 17.79661,80.667556 25.093813,81.355932 38.559322,81.355932 C 89.504001,81.355932 135.59322,-21.186441 135.59322,-21.186441" />
					<path class="line line6" d="M 50,35 H 30 C 30,35 16.525424,35.528154 16.525424,24.152542 C 16.525424,17.535987 22.597755,13.559322 39.40678,13.559322 C 80.617882,13.559322 94.067797,111.01695 94.067797,111.01695" />
				</svg>
				<svg class="x" viewBox="0 0 68 68">
					<path class="line" d="M 4,4 L 64,64" />
					<path class="line" d="M 64,4 L 4,64" />
				</svg>
			</div>
	
			<?php } elseif($hamburger_style == "hamburgersvgstyle2"){ ?>
			<div class="hamburgericon hamburgersvg2open">
				<svg viewBox="0 0 100 100">
					<path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058"/>
					<path class="line line2" d="M 20,50 H 80"/>
					<path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942"/>
				</svg>
			</div>

			<?php } elseif($hamburger_style == "hamburgersvgstyle3"){ ?>
			<div class="hamburgericon hamburgersvg3open">
			<svg class="burger" viewBox="0 0 100 100">
				<path class="line line1" d="M 30,35 H 60 C 63.595663,35 65,32.357023 65,30 C 65,27.642977 62.357023,25 60,25 C 57.642977,25 55,25.933659 55,30 V 77.828008" />
				<path class="line line2" d="M 70,35 H 50 C 46.404337,35 45,32.357023 45,30 C 45,27.642977 47.642977,25 50,25 C 52.357023,25 55,25.933659 55,30 V 77.828008" />
				<path class="line line3" d="M 30,50 H 55 C 58.595665,50 60.000005,47.357023 60.000005,45 C 60.000005,42.642977 57.357025,40 55,40 C 52.642977,40 50,40.933659 50,45 V 92.828008" />
				<path class="line line4" d="M 70,50 H 45 C 41.404337,50 40,47.357023 40,45 C 40,42.642977 42.642977,40 45,40 C 47.357023,40 50,40.933659 50,45 V 92.828008" />
				<path class="line line5" d="M 30,65 H 50 C 53.595665,65 55.000005,62.357023 55.000005,60 C 55.000005,57.642977 52.357025,55 50,55 C 47.642977,55 45,55.933659 45,60 V 107.82801" />
				<path class="line line6" d="M 70,65 H 40 C 36.404337,65 35,62.357023 35,60 C 35,57.642977 37.642977,55 40,55 C 42.357023,55 45,55.933659 45,60 V 107.82801" />
			</svg>
			<svg class="x" viewBox="0 0 68 68">
				<path class="line" d="M 4,4 L 64,64" />
				<path class="line" d="M 64,4 L 4,64" />
			</svg>
			</div>
	
			<?php } elseif($hamburger_style == "hamburgersvgstyle4"){ ?>
			<div class="hamburgericon hamburgersvg4open">
			<svg class="burger" viewBox="0 0 100 100">
				<path class="line line1" d="M 30,65 H 70"/>
				<path class="line line2" d="M 70,50 H 30 C 30,50 18.644068,50.320751 18.644068,36.016949 C 18.644068,21.712696 24.988973,6.5812347 38.79661,11.016949 C 52.604247,15.452663 46.423729,62.711864 46.423729,62.711864 L 50.423729,49.152542 L 50.423729,16.101695"/>
				<path class="line line3" d="M 30,35 H 70 C 70,35 80.084746,36.737688 80.084746,25.423729 C 80.084746,19.599612 75.882239,9.3123528 64.711864,13.559322 C 53.541489,17.806291 54.423729,62.711864 54.423729,62.711864 L 50.423729,49.152542 V 16.101695"/>
			</svg>
			<svg class="x" viewBox="0 0 68 68">
				<path class="line" d="M 4,4 L 64,64" />
				<path class="line" d="M 64,4 L 4,64" />
			</svg>
			</div>
	
			<?php } elseif($hamburger_style == "hamburgersvgstyle5"){ ?>
			<div class="hamburgericon hamburgersvg5open">
			<svg viewBox="0 0 200 200">
					<g stroke-linecap="round">
					<path d="M72 82.286h28.75" fill-rule="evenodd"/>
					<path d="M100.75 103.714l72.482-.143c.043 39.398-32.284 71.434-72.16 71.434-39.878 0-72.204-32.036-72.204-71.554" fill="none"/>
					<path d="M72 125.143h28.75"/>
					<path d="M100.75 103.714l-71.908-.143c.026-39.638 32.352-71.674 72.23-71.674 39.876 0 72.203 32.036 72.203 71.554" fill="none"/>
					<path d="M100.75 82.286h28.75"/>
					<path d="M100.75 125.143h28.75"/>
					</g>
				</svg>
			</div>
				
			<?php } else { ?>
				<i class="royalicon-bars-solid"></i>
			<?php } 

	}


	protected function render_hamburger_close() {
		$settings 			= $this->get_settings_for_display();
		$hamburger_style 	= $settings['hamburger_style'];


		if ($hamburger_style == "icon") { ?>
			<div class="hamburgerclose hamburgerstyle1close">
				<i class="<?php echo $settings['hamburger_close_icon']['value'] ?>"></i>
			</div>
			
			<?php } elseif($hamburger_style == "hamburgersvgstyle1"){ ?>
			<div class="hamburgerclose hamburgersvg1close">
			<svg class="burger" viewBox="0 0 100 100">
				<path class="line line1" d="M 50,65 H 70 C 70,65 75,65.198488 75,70.762712 C 75,73.779026 74.368822,78.389831 66.525424,78.389831 C 22.092231,78.389831 -18.644068,-30.508475 -18.644068,-30.508475" />
				<path class="line line2" d="M 50,35 H 70 C 70,35 81.355932,35.300135 81.355932,25.635593 C 81.355932,20.906215 78.841706,14.830508 72.881356,14.830508 C 35.648232,14.830508 -30.508475,84.322034 -30.508475,84.322034" />
				<path class="line line3" d="M 50,50 H 30 C 30,50 12.288136,47.749959 12.288136,60.169492 C 12.288136,67.738339 16.712974,73.305085 40.677966,73.305085 C 73.791674,73.305085 108.47458,-19.915254 108.47458,-19.915254" />
				<path class="line line4" d="M 50,50 H 70 C 70,50 81.779661,50.277128 81.779661,36.607372 C 81.779661,28.952694 77.941689,25 69.067797,25 C 39.95532,25 -16.949153,119.91525 -16.949153,119.91525" />
				<path class="line line5" d="M 50,65 H 30 C 30,65 17.79661,64.618439 17.79661,74.152543 C 17.79661,80.667556 25.093813,81.355932 38.559322,81.355932 C 89.504001,81.355932 135.59322,-21.186441 135.59322,-21.186441" />
				<path class="line line6" d="M 50,35 H 30 C 30,35 16.525424,35.528154 16.525424,24.152542 C 16.525424,17.535987 22.597755,13.559322 39.40678,13.559322 C 80.617882,13.559322 94.067797,111.01695 94.067797,111.01695" />
			</svg>
			<svg class="x" viewBox="0 0 68 68">
				<path class="line" d="M 4,4 L 64,64" />
				<path class="line" d="M 64,4 L 4,64" />
			</svg>
			</div>
			
			<?php } elseif($hamburger_style == "hamburgersvgstyle2"){ ?>
			<div class="hamburgerclose hamburgersvg2close">
				<svg viewBox="0 0 100 100">
					<path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058"/>
					<path class="line line2" d="M 20,50 H 80"/>
					<path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942"/>
				</svg>
			</div>

			<?php } elseif($hamburger_style == "hamburgersvgstyle3"){ ?>
			<div class="hamburgerclose hamburgersvg3close">
			<svg class="burger" version="1.1" viewBox="0 0 100 100">
				<path class="line line1" d="M 30,35 H 60 C 63.595663,35 65,32.357023 65,30 C 65,27.642977 62.357023,25 60,25 C 57.642977,25 55,25.933659 55,30 V 77.828008" />
				<path class="line line2" d="M 70,35 H 50 C 46.404337,35 45,32.357023 45,30 C 45,27.642977 47.642977,25 50,25 C 52.357023,25 55,25.933659 55,30 V 77.828008" />
				<path class="line line3" d="M 30,50 H 55 C 58.595665,50 60.000005,47.357023 60.000005,45 C 60.000005,42.642977 57.357025,40 55,40 C 52.642977,40 50,40.933659 50,45 V 92.828008" />
				<path class="line line4" d="M 70,50 H 45 C 41.404337,50 40,47.357023 40,45 C 40,42.642977 42.642977,40 45,40 C 47.357023,40 50,40.933659 50,45 V 92.828008" />
				<path class="line line5" d="M 30,65 H 50 C 53.595665,65 55.000005,62.357023 55.000005,60 C 55.000005,57.642977 52.357025,55 50,55 C 47.642977,55 45,55.933659 45,60 V 107.82801" />
				<path class="line line6" d="M 70,65 H 40 C 36.404337,65 35,62.357023 35,60 C 35,57.642977 37.642977,55 40,55 C 42.357023,55 45,55.933659 45,60 V 107.82801" />
			</svg>
			<svg class="x" viewBox="0 0 68 68">
				<path class="line" d="M 4,4 L 64,64" />
				<path class="line" d="M 64,4 L 4,64" />
			</svg>
			</div>
			
			
			<?php } elseif($hamburger_style == "hamburgersvgstyle4"){ ?>
			<div class="hamburgerclose hamburgersvg4close">
			<svg class="burger" viewBox="0 0 100 100">
				<path class="line line1" d="M 30,65 H 70"/>
				<path class="line line2" d="M 70,50 H 30 C 30,50 18.644068,50.320751 18.644068,36.016949 C 18.644068,21.712696 24.988973,6.5812347 38.79661,11.016949 C 52.604247,15.452663 46.423729,62.711864 46.423729,62.711864 L 50.423729,49.152542 L 50.423729,16.101695"/>
				<path class="line line3" d="M 30,35 H 70 C 70,35 80.084746,36.737688 80.084746,25.423729 C 80.084746,19.599612 75.882239,9.3123528 64.711864,13.559322 C 53.541489,17.806291 54.423729,62.711864 54.423729,62.711864 L 50.423729,49.152542 V 16.101695"/>
			</svg>
			<svg class="x" viewBox="0 0 68 68">
				<path class="line" d="M 4,4 L 64,64" />
				<path class="line" d="M 64,4 L 4,64" />
			</svg>
			</div>
			
			<?php } elseif($hamburger_style == "hamburgersvgstyle5"){ ?>
			<div class="hamburgerclose hamburgersvg5close">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
					<g stroke-linecap="round">
					<path
						d="M72 82.286h28.75"
						fill-rule="evenodd"
					/>
					<path
						d="M100.75 103.714l72.482-.143c.043 39.398-32.284 71.434-72.16 71.434-39.878 0-72.204-32.036-72.204-71.554"
						fill="none"
					/>
					<path
						d="M72 125.143h28.75"
					/>
					<path
						d="M100.75 103.714l-71.908-.143c.026-39.638 32.352-71.674 72.23-71.674 39.876 0 72.203 32.036 72.203 71.554"
						fill="none"
					/>
					<path
						d="M100.75 82.286h28.75"
					/>
					<path
						d="M100.75 125.143h28.75"
					/>
					</g>
				</svg>
			</div>


			<?php } else { ?>
				<i class="royalicon-cancel-1"></i>
			<?php } 

	}	
}
