<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalWooSliderNike extends Widget_Base {

	public function get_name() {
		return 'royalwooslidernike';
	}

	public function get_title() {
		return __( 'Products Nike Slider', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-products rtbranding'; }
	
	public function get_keywords() {
		return [ 'woo', 'woocommerce', 'products', 'nike', 'slider', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
	
	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
	}

	public function get_style_depends() {
		$styles = [ 'royalslidernike' ];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalslidernike'];
		return $scripts;
	}	
	
	
	protected function register_controls() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->rt_content_layout_options();
			$this->rt_content_query_options();

			$this->rt_style_introduce_options();
			$this->rt_style_button_options();
			$this->rt_style_nav_options();
			$this->rt_style_indicators_options();
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
					'{{WRAPPER}} .royalslidernike' => 'height: {{SIZE}}{{UNIT}};',
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

        $this->add_control( 'autoplay_interval', [
            'label'     => esc_html__( 'Autoplay Interval (ms)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 5000,
        ] );	

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
			'posts_per_page',
			[
				'label' => __( 'Total Items', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
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


	private function rt_style_introduce_options() {
		$this->start_controls_section(
			'section_slide',
			[
				'label' => __( 'Slide Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_slide_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Slide Grid Border Color', 'royal-addons-for-elementor' ),
				'default' => '#5559',
				'condition' => [
					'show_slide_border' => 'yes',
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .showslideborder .list::after' => 'border-left: 1px solid {{VALUE}}; border-right: 1px solid {{VALUE}};',
					'{{WRAPPER}} .showslideborder .list::before' => 'border-top: 1px solid {{VALUE}}; border-bottom: 1px solid {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'category_typography',
				'label' => __( 'Category Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalslidernike .list .item .content .category',
			]
		);

		$this->add_control(
			'category_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Category Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'introduce_title_typography',
				'label' => __( 'Title Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalslidernike .list .item .content .title a',
			]
		);

		$this->add_control(
			'introduce_title_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'introduce_description_typography',
				'label' => __( 'Description Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalslidernike .list .item .content .description',
			]
		);

		$this->add_control(
			'introduce_description_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Description Color', 'royal-addons-for-elementor' ),
				'default' => '#5559',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}


	private function rt_style_button_options() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label' => __( 'Button Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalslidernike .list .item .content .more button',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label' => esc_html__( 'Button Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 5,
					'right' => 15,
					'bottom' => 5,
					'left' => 15,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .more button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .royalslidernike .list .item .content .more button',
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 30,
					'right' => 30,
					'bottom' => 30,
					'left' => 30,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .more button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_cart_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Cart Button Color', 'royal-addons-for-elementor' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .more button:nth-child(1) a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_cart_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Cart Button BG Color', 'royal-addons-for-elementor' ),
				'default' => '#46a39c',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .more button:nth-child(1)' => 'background-color: {{VALUE}};',
				],
			]
		);		
		$this->add_control(
			'button_price_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Price Button Color', 'royal-addons-for-elementor' ),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .more button:nth-child(2) a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_price_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Price Button BG Color', 'royal-addons-for-elementor' ),
				'default' => '#242745',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .list .item .content .more button:nth-child(2)' => 'background-color: {{VALUE}};',
				],
			]
		);	

		$this->end_controls_section();

	}


	private function rt_style_indicators_options() {
		$this->start_controls_section(
			'section_indicators_style',
			[
				'label'     => __( 'Indicators Style', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'indicators_number_typography',
				'label' => __( 'Indicators Number Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalslidernike .indicators .number',
			]
		);

		$this->add_control(
			'indicators_number_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Title Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .indicators .number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'indicators_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Indicators Color', 'royal-addons-for-elementor' ),
				'default' => '#659cdf',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .indicators ul li' => 'background-color: {{VALUE}};',
				],
			]
		);		

		$this->add_control(
			'indicators_color_active',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Indicators Active Color', 'royal-addons-for-elementor' ),
				'default' => '#e3e30b',
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .royalslidernike .indicators ul li.active' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .royalslidernike .arrows button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .royalslidernike .arrows button' => 'background-color: {{VALUE}};',
				],
			]
		);	

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'nav_border',
				'selector' => '{{WRAPPER}} .royalslidernike .arrows button',
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
					'{{WRAPPER}} .royalslidernike .arrows button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Get settings.
			$settings 		= $this->get_settings();
			$text_seemore 	= $settings['text_seemore'];
			$text_seeall 	= $settings['text_seeall'];
			$id         	= $this->get_id();
			$sliderid   	= 'royalslidernike'.$id;
			$prev       	= 'prev'.$id;
			$next       	= 'next'.$id;
			$back       	= 'back'.$id;
			$previousicon   = $settings['previousicon']['value'];
			$nexticon    	= $settings['nexticon']['value'];
			$interval    	= $settings['autoplay_interval'];

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
			
			if ( 'yes' === $settings['show_slide_border'] ) {
				$show_slide_border = 'showslideborder';
			} else {
				$show_slide_border = '';
			}

				?>
				<div class="royalslidernike <?php echo $show_slide_border; ?>" <?php echo $this->get_render_attribute_string( 'options' ) ?>>
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
							$all_posts->the_post(); ?>
							<div class="item">
								<figure>
									<?php $this->render_thumbnail(); ?>
								</figure>
								<div class="content">
									<p class="category">
									<?php $this->category(); ?>
									</p>
									<?php $this->render_title(); ?>
									<p class="description"><?php $this->description(); ?></p>
									<div class="more">
										<button class="cart"><?php $this->add_to_cart(); ?></button>
										<button class="price"><?php $this->product_price(); ?></button>
									</div>
								</div>
							</div>
							<?php
						endwhile; 
						wp_reset_postdata();
					endif; ?>
				</div>
				<div class="arrows">
					<button id="<?php echo $prev ;?>" class="prev"><i class='<?php echo $previousicon; ?>'></i></button>
					<button id="<?php echo $next ;?>" class="next"><i class='<?php echo $nexticon; ?>'></i></button>
				</div>	
				<div class="indicators">
					<div class="number">02</div>
					<ul>
						<?php
						if ( $all_posts->have_posts() ) :
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>
								<li></li>
								<?php
							endwhile; 
							wp_reset_postdata();
						endif;
						?>
					</ul>
				</div>
												
			</div>
			<?php

		}
	}


	protected function render_thumbnail() {
		$settings = $this->get_settings();
		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( has_post_thumbnail() ) {
			$post_title = get_the_title();
			$thumbnail_id = get_post_thumbnail_id();
			$alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );

			if ( empty( $alt ) ) {
				$alt = $post_title;
			}

			echo get_the_post_thumbnail( get_the_ID(), $post_thumbnail_size, array(
				'alt' => esc_attr( $alt ),
			) );
		}
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

	protected function category() {
		global $product;
		$product_cats_ids = wc_get_product_term_ids( $product->get_id(), 'product_cat' );
		foreach( $product_cats_ids as $cat_id ) {
			$term = get_term_by( 'id', $cat_id, 'product_cat' );
			echo $term->name.', ';
		}
	}

}
