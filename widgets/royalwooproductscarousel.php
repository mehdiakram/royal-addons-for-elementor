<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalWooProductsCarousel extends Widget_Base {

	public function get_name() {
		return 'royalwooproductscarousel';
	}

	public function get_title() {
		return __( 'Products Carousel', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-products rtbranding'; }

	public function get_keywords() {
		return [ 'woo', 'product', 'carousel', 'products', 'royal', 'technologies', 'royal',  'mehdi',  'akram', 'tech' ];
	  }

	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
	}

	
	public function get_style_depends() {
		$styles = ['royalowlcarousel', 'royalowlcarouseltheme' ,'royalcarousel'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalowlcarousel', 'royalcarousel'];
		return $scripts;
	}


	protected function register_controls() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->rt_content_layout_options();
			$this->rt_content_query_options();
			Royal_Helpers::royal_carousel_options( $this );
			$this->rt_style_box_options();
			Royal_Helpers::royal_style_nav_options( $this );
			Royal_Helpers::royal_style_dot_options( $this );
			Royal_Helpers::royal_style_image_options( $this );
			$this->rt_style_title_options();

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

		$this->add_control(
			'carosuel_style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'royalwooproductscarouselstyle1',
				'options' => [
					'royalwooproductscarouselstyle1' 	=> esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'royalwooproductscarouselstyle2' 	=> esc_html__( 'Style 2', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 7,
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'thumbnail',
				'prefix_class' => 'post-thumbnail-size-',
				'condition' => [
					'show_image' => 'yes',
				],
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
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
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
			'content_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .post-post-inner' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'royalcarouselhoverstyle',
			[
				'label' => __( 'Item Hover', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' 							=> 'No Hover',
					'royalcarouselhoverstyle1' 	=> 'Hover 1',
					'royalcarouselhoverstyle2' 	=> 'Hover 2',
				],
				'default' => '',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Content Query Options.
	 */
	private function rt_content_query_options() {

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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




	/**
	 * Style Box Options.
	 */
	private function rt_style_box_options() {

		// Box.
		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'Box', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_box_border_width',
			[
				'label'      => __( 'Border Widget', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Border Radius.
		$this->add_control(
			'style_border_radius',
			[
				'label'     => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Box internal padding.
		$this->add_responsive_control(
			'grid_items_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'royalcarouselhoverstyle_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Item Hover Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'default' => '#5b2978',
				'selectors' => [
					'{{WRAPPER}} .royalcarouselhoverstyle1 .owl-item::after' => 'background: {{VALUE}};',
				],
			]
		);


		$this->start_controls_tabs( 'grid_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_button_style_normal_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Normal border color.
		$this->add_control(
			'grid_button_style_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalmastercarousel',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_button_style_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'grid_button_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalmastercarousel:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}


	private function rt_style_title_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label'     => __( 'Title', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_title_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			)
		);

		// Title color.
		$this->add_control(
			'grid_title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_title_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			)
		);

		// Title hover color.
		$this->add_control(
			'grid_title_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Title margin.
		$this->add_responsive_control(
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalmastercarousel .title, {{WRAPPER}} .royalmastercarousel .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}




	protected function render( $instance = [] ) {
		$settings 		= $this->get_settings();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $loop           = $settings['loop'];
        $autoplay       = $settings['autoplay'];
        $margin         = $settings['margin'];
        $timeout        = $settings['timeout'];
        $navposition    = $settings['navposition'];
        $dotposition    = $settings['dotposition'];
		
        $previous_icon_html = '';
        $next_icon_html = '';
        if ( isset( $settings['previousicon']['value'] ) && ! empty( $settings['previousicon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['previousicon'], [ 'aria-hidden' => 'true' ] );
            $previous_icon_html = ob_get_clean();
        }

        if ( isset( $settings['nexticon']['value'] ) && ! empty( $settings['nexticon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['nexticon'], [ 'aria-hidden' => 'true' ] );
            $next_icon_html = ob_get_clean();
        }
        $navtext = json_encode( [ $previous_icon_html, $next_icon_html ] );

        $desktopitems   = $settings['desktopitems'];
        if ( 'yes' === $settings['desktopdots'] ) {
			$desktopdots = 'true';
		} else{
            $desktopdots = 'false';
        } 
        if ( 'yes' === $settings['desktopnav'] ) {
			$desktopnav = 'true';
		} else{
            $desktopnav = 'false';
        }           


        $tabitems       = $settings['tabitems'];
        if ( 'yes' === $settings['tabdots'] ) {
			$tabdots = 'true';
		} else{
            $tabdots = 'false';
        }
        if ( 'yes' === $settings['tabnav'] ) {
			$tabnav = 'true';
		} else{
            $tabnav = 'false';
        }                     


        $mobileitems    = $settings['mobileitems'];
        if ( 'yes' === $settings['mobiledots'] ) {
			$mobiledots = 'true';
		} else{
            $mobiledots = 'false';
        } 
        if ( 'yes' === $settings['mobilenav'] ) {
			$mobilenav = 'true';
		} else{
            $mobilenav = 'false';
        } 

        $this->add_render_attribute(
            'royal_carousel_options',
            [
                'id'                	=> $carouselid,
                'data-loop'         	=> $loop,
                'data-autoplay'     	=> $autoplay,
                'data-margin'       	=> $margin,
                'data-autoplayTimeout'	=> $timeout,
                'data-navtext'   		=> $navtext,	

                'data-desktopitems' 	=> $desktopitems,
                'data-desktopdots'  	=> $desktopdots,
                'data-desktopnav'   	=> $desktopnav,

                'data-tabitems'     	=> $tabitems,
				'data-tabdots'  		=> $tabdots,
                'data-tabnav'   		=> $tabnav,

                'data-mobileitems'  	=> $mobileitems,
                'data-mobiledots'  		=> $mobiledots,
                'data-mobilenav'   		=> $mobilenav,	
			
            ]
        );

		$carosuel_style 			= $settings['carosuel_style'];
		$royalcarouselhoverstyle 	= $settings['royalcarouselhoverstyle'];
		?>
		<div class="royalmastercarousel royalcarouselhoverstyle <?php echo $carosuel_style . ' ' . $royalcarouselhoverstyle ?>">
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
				echo '<div class="royalcarousel owl-carousel owl-theme '.$navposition.' '.$dotposition.'" '.$this->get_render_attribute_string( 'royal_carousel_options' ).'>';
				if( $carosuel_style =="royalwooproductscarouselstyle1" ){
					while ( $all_posts->have_posts() ) :
						$all_posts->the_post(); ?>
							<div class="item">            
								<?php $this->render_thumbnail(); ?>
								<div class="productinner">
									<?php $this->render_title(); ?>
									<?php $this->product_price(); ?>
								</div>      
							</div>
							<?php
					endwhile; 
				wp_reset_postdata();
				}elseif($carosuel_style =="royalwooproductscarouselstyle2"){
					while ( $all_posts->have_posts() ) :
						$all_posts->the_post(); ?>
							<div class="item">     
								<?php $this->render_thumbnail(); ?>
								<div class="productinner">
									<?php $this->render_title(); ?>
									<div class="pricecart">
									<?php $this->product_price(); ?>
									<?php $this->add_to_cart(); ?>
									</div>
								</div>         
							</div>
							<?php
					endwhile; 
					wp_reset_postdata();
				}

				echo '</div>';
			endif; ?>
		</div>	
		<?php

	}

	





/* */

	protected function render_heading_block() {
		$settings = $this->get_settings();
		$show_heading_block = $settings['show_heading_block'];

		if ( 'yes' !== $show_heading_block ) {
			return;
		}

		echo'<article class="headingblock">
				<h2>'.$settings['heading_title'].'</h2>
				<div>'.$settings['heading_description'].'</div>				   
			</article>';
	}


	protected function render_thumbnail() {
		$settings = $this->get_settings();
		$show_image = $settings['show_image'];

		if ( 'yes' !== $show_image ) {
			return;
		}

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
		echo '<div class="price">' .$product->get_price_html() .'</div>';
	}

	protected function add_to_cart() {
		global $product;
		$id = $product->get_id();
		echo '<div class="addtocart"><a href="?add-to-cart='.$id.'">Add to cart</a></div>';
	}


















}
