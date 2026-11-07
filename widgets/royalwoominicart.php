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


class RoyalWooMiniCart extends Widget_Base {

	public function get_name() {
		return 'royalwoominicart';
	}

	public function get_title() {
		return __( 'Woo Mini Cart', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-cart rtbranding'; }


	public function get_keywords() {
		return [ 'woo', 'woocommerce', 'mini', 'cart', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
	}


	public function get_style_depends() {
		$styles = ['royalwoominicart'];
		return $styles;
	}


	protected function register_controls() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->rt_content_layout_options();
			
		} else {
			$this->royal_tech_woocommerce_not_found();
		}
	}


	/**
	 * Content Layout Options.
	 */
	private function royal_tech_woocommerce_not_found() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( '"Woocommerce" not found', 'royal-addons-for-elementor' ),
			]
		);	 
		
		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'Woocommerce plugin not active, Please install & active Woocommerce.', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
			]
		);		
		
		$this->end_controls_section();
	}	



	private function rt_content_layout_options() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General Section', 'royal-addons-for-elementor' ),
			]
		);


		$this->add_control(
			'shopicon',
			[
				'label' => esc_html__( 'Shop Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-shopping-bag',
					'library' => 'solid',
				],
                'recommended' => [
                    'fa-regular' => [
                        'map',
                    ],
                    'fa-solid' => [
                        'shopping-bag',
                        'briefcase',
                        'suitcase-rolling',
                        'suitcase',
                        'shopping-cart',
                        'shopping-basket',
                        'cart-arrow-down',
                        'cart-plus',
                    ]
                ]				
			]
		);		
		$this->end_controls_section();



		$this->start_controls_section(
			'cart_section',
			[
				'label' => esc_html__( 'Cart Section', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
	
		$this->add_control(
			'shophideicon',
			[
				'label' => esc_html__( 'Close Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,		
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
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'cart_typography',
				'selector' => '{{WRAPPER}} .royalwoocartcontainer .minicart-items',
			]
		);
		$this->add_control(
			'cart_background',
			[
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'cart_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_cart_style' );
		$this->start_controls_tab(
			'tab_cart_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'view_cart_color',
			[
				'label' => __( 'View Cart Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer .actions .button-viewcart span' => 'color: {{VALUE}}!important;',
				],
			]
		);
		$this->add_control(
			'view_cart_background',
			[
				'label' => __( 'View Cart Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2a2a2a',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer .actions .button-viewcart' => 'background-color: {{VALUE}}!important;',
				],
			]
		);
		$this->add_control(
			'checkout_color',
			[
				'label' => __( 'Checkout Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} royalwoocartcontainer .actions .button-checkout span' => 'color: {{VALUE}}!important;',
				],
			]
		);
		$this->add_control(
			'checkout_background',
			[
				'label' => __( 'Checkout Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer .actions .button-checkout' => 'background-color: {{VALUE}}!important;',
				],
			]
		);





		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_cart_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'view_cart_color_hover',
			[
				'label' => __( 'View Cart Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ddd',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer .actions .button-viewcart span:hover' => 'color: {{VALUE}}!important;',
				],
			]
		);
		$this->add_control(
			'view_cart_background_hover',
			[
				'label' => __( 'View Cart Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2a2a2a',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer .actions .button-viewcart:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);
		$this->add_control(
			'checkout_color_hover',
			[
				'label' => __( 'Checkout Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ddd',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} royalwoocartcontainer .actions .button-checkout span:hover' => 'color: {{VALUE}}!important;',
				],
			]
		);
		$this->add_control(
			'checkout_background_hover',
			[
				'label' => __( 'Checkout Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalwoocartcontainer .actions .button-checkout:hover' => 'background-color: {{VALUE}}!important;',
				],
			]
		);


		$this->end_controls_tab();		
		$this->end_controls_tabs();

		$this->end_controls_section();	
	}



	protected function render() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$settings = $this->get_settings_for_display();
			?>

			<div class="royalwoocartshow">
				<a class="bag" title=""><i class="<?php echo $settings['shopicon']['value'] ?>"></i><span><?php echo is_object( WC()->cart ) ? WC()->cart->get_cart_contents_count() : ''; ?></span></a>
			</div>
			<div class="royalwoocartcontainer">
				<div class="top">
					<div class="cart">Your Cart</div>
					<div class="close"><i class="<?php echo $settings['shophideicon']['value'] ?>"></i></div>
				</div>
				<?php require_once 'woocommerce/minicart.php'; ?>
			</div>
		<?php 
		}
	}



	protected function content_template() {

	}

}
