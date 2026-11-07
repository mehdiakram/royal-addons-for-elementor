<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalWooSliderBuck extends Widget_Base {

	public function get_name() {
		return 'royalwoosliderbuck';
	}

	public function get_title() {
		return __( 'Products Buck Slider', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-products rtbranding'; }
	
	public function get_keywords() {
		return [ 'woo', 'woocommerce', 'products', 'buck', 'slider', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
	
	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
	}

	public function get_style_depends() {
		$styles = [ 'royalsliderbuck' ];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalsliderbuck'];
		return $scripts;
	}	
	
	
	protected function register_controls() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->rt_content_layout_options();
			$this->rt_content_query_options();
			$this->rt_style_slider_options();
			$this->rt_style_circle_options();  
			$this->rt_style_image_options();  
			$this->rt_style_nav_options();
			$this->rt_style_details_options();
		} else {
			$this->royal_tech_woocommerce_not_found();
		}
	}

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
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Slider Height', 'royal-addons-for-elementor' ),
				'range' => [
					'px' => [
						'min' => 400,
						'max' => 1200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 700,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 600,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 500,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .royalwoosliderblurstyle1' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'previousicon',
			[
				'label' => esc_html__( 'Nav Previous Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'default' => [
					'value' => 'fas fa-chevron-left',
					'library' => 'solid',
				],
			]
		);
		$this->add_control(
			'nexticon',
			[
				'label' => esc_html__( 'Nav Next Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,    
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'solid',
				],
			]
		); 

		$this->add_control(
			'show_slide_border',
			[
				'label' => esc_html__( 'Slider Grid Border', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
	
        $this->add_control( 'autoplay_interval', [
            'label'     => esc_html__( 'Autoplay Interval (ms)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 5000,
        ] );		

		$this->end_controls_section();
	}


	private function rt_content_query_options() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Total Items', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 2,
				'max' => 10,
				'step' => 1,
				'default' => 7,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'image300',
				'prefix_class' => 'post-thumbnail-size-',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options'   => Royal_Helpers::royal_title_tags(),
				'default' => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_price',
			[
				'label' => __( 'Price', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_cat',
			[
				'label'       => __( 'Product Categories', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalWooClass::product_cat('product' ),

			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'royal-addons-for-elementor' ),
					'post_title' => __( 'Title', 'royal-addons-for-elementor' ),
					'rand' => __( 'Random', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'royal-addons-for-elementor' ),
					'desc' => __( 'DESC', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section();

	}


	private function rt_style_slider_options() {
		$this->start_controls_section(
			'section_slider',
			[
				'label' => __( 'Slider', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'slider_style_tabs'
		);
		
		$this->start_controls_tab(
			'style_title_tab',
			[
				'label' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'slider_title_typography',
				'label' => __( 'Title Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .title a',
			]
		);

		$this->add_control(
			'slider_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .title a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		

		$this->start_controls_tab(
			'style_price_tab',
			[
				'label' => esc_html__( 'Price', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'slider_price_typography',
				'label' => __( 'Price Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .price',
			]
		);

		$this->add_control(
			'slider_price_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Price Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .price' => 'color: {{VALUE}};',
				],
			]
		);		
		
		$this->end_controls_tab();


		$this->start_controls_tab(
			'style_description_tab',
			[
				'label' => esc_html__( 'Description', 'royal-addons-for-elementor' ),
			]
		);
		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'slide_description_typography',
				'label' => __( 'Description Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .description',
			]
		);

		$this->add_control(
			'slide_description_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'royal-addons-for-elementor' ),
				'default' => '#5559',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .description' => 'color: {{VALUE}};',
				],
			]
		);		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_cart_tab',
			[
				'label' => esc_html__( 'Cart', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'slide_cart_typography',
				'label' => __( 'Cart Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .cart',
			]
		);

		$this->add_control(
			'slide_cart_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Cart Color', 'royal-addons-for-elementor' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .cart a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'slide_cart_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Cart Background Color', 'royal-addons-for-elementor' ),
				'default' => '#4f8b69',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .cart' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_cart_border_radius',
			[
				'label'      => __( 'Cart Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item .main-content .content .cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		
		$this->end_controls_tab();

		$this->end_controls_tabs();		

		$this->end_controls_section();
	}


	private function rt_style_circle_options() {
		$this->start_controls_section(
			'section_circle_style',
			[
				'label'     => __( 'Circle Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'circle_color_style',
			[
				'label' => esc_html__( 'Circle Color Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'singlecolor',
				'options' => [
					'singlecolor' 		=> esc_html__( 'Single Color', 'royal-addons-for-elementor' ),
					'productcolor' 		=> esc_html__( 'Product Color', 'royal-addons-for-elementor' ),
					//'individualcolor' 	=> esc_html__( 'Individual Color', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'circle_singlecolors',
			[
				'label' => esc_html__( 'Circle Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#9c4d2f',
				'condition' => [
					'circle_color_style' => 'singlecolor',
				],
			]
		);

		$this->add_control(
			'circle_individualcolor1',
			[
				'label' => esc_html__( 'Slide 1 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#9c4d2f',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);

		$this->add_control(
			'circle_individualcolor2',
			[
				'label' => esc_html__( 'Slide 2 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#f5bfaf',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);

		$this->add_control(
			'circle_individualcolor3',
			[
				'label' => esc_html__( 'Slide 3 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#dedfe1',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);

		$this->add_control(
			'circle_individualcolor4',
			[
				'label' => esc_html__( 'Slide 4 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#7eb63d',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);

		
		$this->add_control(
			'circle_individualcolor5',
			[
				'label' => esc_html__( 'Slide 5 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#ddd000',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);
		
		$this->add_control(
			'circle_individualcolor6',
			[
				'label' => esc_html__( 'Slide 6 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#9c4d2f',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);
		
		$this->add_control(
			'circle_individualcolor7',
			[
				'label' => esc_html__( 'Slide 7 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#f5bfaf',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);
		
		$this->add_control(
			'circle_individualcolor8',
			[
				'label' => esc_html__( 'Slide 8 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#dedfe1',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);
		
		$this->add_control(
			'circle_individualcolor9',
			[
				'label' => esc_html__( 'Slide 9 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#7eb63d',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);
		
		$this->add_control(
			'circle_individualcolor10',
			[
				'label' => esc_html__( 'Slide 10 Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' 	=> '#ddd000',
				'condition' => [
					'circle_color_style' => 'individualcolor',
				],
			]
		);
		$this->end_controls_section();
	}


	private function rt_style_image_options() {
		$this->start_controls_section(
			'section_image_style',
			[
				'label'     => __( 'Image Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slider_image_border_radius',
			[
				'label'      => __( 'Image Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item .image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'slider_image_title_typography',
				'label' => __( 'Image Title Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .royalsliderbuck .list .item figure figcaption .title a',
			]
		);

		$this->add_control(
			'slider_image_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Image Title Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list .item figure figcaption .title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function rt_style_nav_options() {
		$this->start_controls_section(
			'section_nav_style',
			[
				'label'     => __( 'Nav Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nav_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav Color', 'royal-addons-for-elementor' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .arrows button' => 'color: {{VALUE}};',
				],
			]
		);	

		$this->add_control(
			'nav_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Nav BG Color', 'royal-addons-for-elementor' ),
				'default' => '#232442',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .arrows button' => 'background-color: {{VALUE}};',
				],
			]
		);	

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'nav_border',
				'selector' => '{{WRAPPER}} .royalsliderbuck .arrows button',
			]
		);

		$this->add_control(
			'nav_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
					'unit' => '%',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .arrows button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function rt_style_details_options() {
		$this->start_controls_section(
			'section_border_style',
			[
				'label'     => __( 'Grid Border Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_slide_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_slide_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Slide Grid Border Color', 'royal-addons-for-elementor' ),
				'default' => '#fff5',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalsliderbuck .list::before' => 'border-left: 1px solid {{VALUE}}; border-right: 1px solid {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Get settings.
			$settings 		= $this->get_settings();
			$id         	= $this->get_id();
			$sliderid   	= 'royalsliderbuck'.$id;
			$prev       	= 'prev'.$id;
			$next       	= 'next'.$id;
			$back       	= 'back'.$id;
			$previousicon   = $settings['previousicon']['value'];
			$nexticon    	= $settings['nexticon']['value'];
			$interval    	= $settings['autoplay_interval'];

			if ( 'yes' === $settings['show_slide_border'] ) {
				$show_slide_border = 'showslideborder';
			} else {
				$show_slide_border = '';
			}

			$this->add_render_attribute(
				'options',
				[
					'id'             	=> $sliderid,
					'data-interval'		=> $interval,
					'data-prev'		    => $prev,
					'data-next'		    => $next,
					'data-back'		    => $back,
				]
			);


			?>
			<div class="royalsliderbuck <?php echo $show_slide_border; ?>" <?php echo $this->get_render_attribute_string( 'options' ) ?>>
				<div class="list">
			<?php 				
				$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );
				$product_cat = is_array( $settings['product_cat'] ) ? implode( ',', $settings['product_cat'] ) : $settings['product_cat'];
				
				$query_args = array(
								'post_type'             => 'product',
								'posts_per_page' 		=> absint( $posts_per_page ),
								'no_found_rows'  		=> true,
								'post_status'         	=> 'publish',
								'ignore_sticky_posts'   => true,
								'product_cat' 			=> $product_cat
							);

				// Order by.
				if ( ! empty( $settings['orderby'] ) ) {
					$query_args['orderby'] = $settings['orderby'];
				}

				// Order .
				if ( ! empty( $settings['order'] ) ) {
					$query_args['order'] = $settings['order'];
				}

				$all_posts = new \WP_Query( $query_args );

				if ( $all_posts->have_posts() ) :
					while ( $all_posts->have_posts() ) :
						$all_posts->the_post(); $index = $all_posts->current_post + 1; ?>
						<article class="item postindex_<?php echo $index; ?>">
							<div class="main-content" <?php $this->circle_color(); ?>> 
								<div class="content">
									<?php $this->render_title(); ?>
									<p class="price"><?php $this->product_price(); ?></p>
									<p class="description"><?php $this->short_description(); ?></p>
									<button class="cart"><?php $this->add_to_cart(); ?></button>
								</div>
							</div>
							<figure class="image">
								<?php $this->render_thumbnail(); ?>
								<figcaption><?php $this->render_title(); ?></figcaption>
							</figure>
						</article>
					<?php
					endwhile; 
					wp_reset_postdata();
				endif; ?>
			</div>
			<div class="arrows">
				<button id="<?php echo $prev ;?>" class="prev"><i class='<?php echo $previousicon; ?>'></i></button>
				<button id="<?php echo $next ;?>" class="next"><i class='<?php echo $nexticon; ?>'></i></button>
			</div>									
		</div>
		<?php

		}
	}


	protected function render_thumbnail() {
		$settings = $this->get_settings();
		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( has_post_thumbnail() ) :
			$post_title = get_the_title();
			$thumbnail_id = get_post_thumbnail_id();
			$alt_text = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
			if ( empty( $alt_text ) ) {
				$alt_text = $post_title;
			}
			?>
			<div class="productthumbnail">
				<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( $post_title ); ?>">
					<?php the_post_thumbnail( $post_thumbnail_size, array( 'alt' => esc_attr( $alt_text ) ) ); ?>
				</a>
			</div>
		<?php endif;
	}



	protected function render_title() {
		$settings = $this->get_settings();
		$show_title = $settings['show_title'];

		if ( 'yes' !== $show_title ) {
			return;
		}

		$title_tag = $settings['title_tag'];

		?>
		<<?php echo $title_tag; ?> class="title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</<?php echo $title_tag; ?>>
		<?php
	}


	protected function product_price() {
		$settings = $this->get_settings();
		$show_price = $settings['show_price'];

		if ( 'yes' !== $show_price ) {
			return;
		}

		global $product;
		echo 'Price:'. $product->get_price_html();
	}

	protected function add_to_cart() {
		global $product;
		$id = $product->get_id();
		if( $product->is_type( 'simple' ) ){
			echo'<a href="?add-to-cart='.$id.'">Add to Cart</a>';
		} else {
			echo '<a href="'. get_the_permalink().'">Details</a>';
		}
	}

	protected function short_description() {
		global $product;
		echo $product->get_short_description();
	}

	protected function description() {
		global $product;
		echo $product->get_description();
	}


	protected function see_more_button() {
		$settings = $this->get_settings();
		$see_more_button = $settings['see_more_button'];
		$text_seemore 	= $settings['text_seemore'];

		if ( 'yes' !== $see_more_button ) {
			return;
		}

		echo $text_seemore;
	}
	
	protected function circle_color() {
		global $product;
		$settings 						= $this->get_settings();
		$circle_color_style 			= $settings['circle_color_style'];
		$circle_singlecolor 			= $settings['circle_singlecolor'];

		$circle_individualcolor1 	= $settings['circle_individualcolor1'];
		$circle_individualcolor2 	= $settings['circle_individualcolor2'];
		$circle_individualcolor3 	= $settings['circle_individualcolor3'];
		$circle_individualcolor4 	= $settings['circle_individualcolor4'];
		$circle_individualcolor5 	= $settings['circle_individualcolor5'];
		$circle_individualcolor6 	= $settings['circle_individualcolor6'];
		$circle_individualcolor7 	= $settings['circle_individualcolor7'];
		$circle_individualcolor8 	= $settings['circle_individualcolor8'];
		$circle_individualcolor9 	= $settings['circle_individualcolor9'];
		$circle_individualcolor10 	= $settings['circle_individualcolor10'];

		if ($circle_color_style ==='singlecolor' ) {
			echo 'style="background-color: '.$circle_singlecolor.' ;"';

		} elseif($circle_color_style ==='productcolor'){
			$woo_bg_color = $product->get_meta('woo_bg_color');
			if ($woo_bg_color == '') {
				echo 'style="background-color: #fff ;"';
			} else{
				echo 'style="background-color: '.$woo_bg_color.' ;"';
			}

		} elseif($circle_color_style ==='individualcolor'){
			


		}

	}

	

}
