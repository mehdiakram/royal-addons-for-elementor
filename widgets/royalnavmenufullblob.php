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


class RoyalNavMenuFullBlob extends Widget_Base {

	public function get_name() {
		return 'royalnavmenufullblob';
	}


	public function get_title() {
		return __( 'Blob Menu', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-menu-bar rtbranding'; }


	public function get_keywords() {
		return [ 'nav', 'menu', 'blob', 'dropdown', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech_headerfooter' ];
	}


	public function get_style_depends() {
		$styles = ['royalnavmenufullblob'];
		return $styles;
	}


	public function get_script_depends() {
		$scripts = ['royalnavmenufullblob',];
		return $scripts;
	}	
	
	
	protected function register_controls() {
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
		
		$this->end_controls_section();




		$this->start_controls_section(
			'mainmenu_section',
			[
				'label' => esc_html__( 'Main Menu Style', 'royal-addons-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mainmenu_typography',
				'selector' => '{{WRAPPER}} .royalnavmenufullbloboverlay nav',
			]
		);

		$this->add_control(
			'hamburger',
			[
				'label' => __( 'Hamburger Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalnavmenufullblob' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mainmenu_full_background',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffc901',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalnavmenufullblob-container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mainmenu_text_color',
			[
				'label' => __( 'Menu Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'separator' => 'none',
				'selectors' => [
					'{{WRAPPER}} .royalnavmenufullbloboverlay ul li a ' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .royalnavmenufullblob-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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

		$args = [
			'echo' => false,
			'menu' => $settings['menu'],
			'menu_class' => '',
			'menu_id' => '',
			'fallback_cb' => '__return_empty_string',
			'container' => '',
		];
		$content_html = wp_nav_menu( $args );
		?>


		<div class="royalnavmenufullblob-container" id="royalnavmenufullblobtoggle">
		<a class="royalnavmenufullblob" ><i class="royaliocn-bars-solid"></i></a>
		<div class="royalnavmenufullbloboverlay" id="royalnavmenufullbloboverlay">
			<nav>
				<?php echo $content_html; ?>
			</nav>
		</div>
		</div>
		<?php
	}


	protected function content_template() {

	}

}
