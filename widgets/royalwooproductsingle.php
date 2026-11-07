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

class RoyalWooProductSingle extends Widget_Base {

	public function get_name() {
		return 'royalwooproductsingle';
	}

	public function get_title() {
		return __( 'Products Single', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-products rtbranding'; }
	
	public function get_keywords() {
		return [ 'woo', 'woocommerce', 'product', 'grid', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
	
	public function get_categories() {
		return [ 'royaltech_3rdparty' ];
	}

	public function get_style_depends() {
		$styles = [ 'royalwooproducts' ];
		return $styles;
	}

	protected function register_controls() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$this->rt_content_layout_options();
			$this->rt_style_box_options();
			$this->rt_style_image_options();
			$this->rt_style_title_options();
			$this->rt_style_description();
			$this->rt_style_price_options();
			$this->rt_style_cart_options();
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
			'singleproduct_style',
			[
				'label' => __( 'Grid Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'singleproductstyle1',
				'options' => [
					'singleproductstyle1' => esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'product_single',
			[
				'label'       => __( 'Product', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'multiple'    => true,
				'options'     => \RoyalAddons\Elementor\RoyalWooClass::royalproduct('product'),

			]
		);

		$this->add_control(
			'singleproduct_image',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'postthumbnail',
				'options' => [
					'postthumbnail' => esc_html__( 'Post Thumbnail', 'royal-addons-for-elementor' ),
					'customimage' => esc_html__( 'Custom Image', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'custom_image',
			array(
				'label'      => esc_html__('Custom Image','royal-addons-for-elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'singleproduct_image' => 'customimage',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'full',
				'prefix_class' => 'post-thumbnail-size-',
				'condition' => [
					'singleproduct_image' => 'postthumbnail',
				],
			]
		);
		
		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options'   => Royal_Helpers::royal_title_tags(),
				'default' => 'h3',
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
					'{{WRAPPER}} .royalwooproductsingle .productsummary' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}



	private function rt_style_box_options() {

		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'Box', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'grid_items_style_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .royalwooproductsingle' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'grid_button_style_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalwooproductsingle:hover' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	private function rt_style_image_options() {

		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royalwooproductsingle .productthumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'style_image_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .productthumbnail img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'style_image_border',
				'selector' => '{{WRAPPER}} .royalwooproductsingle .productthumbnail img',
			]
		);

		$this->end_controls_section();

	}


	private function rt_style_title_options() {
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label'     => __( 'Title', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproductsingle .title a',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style' );

		$this->start_controls_tab(
			'title_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalwooproductsingle .title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'selectors' => array(
					'{{WRAPPER}} .royalwooproductsingle .title a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}



	

	private function rt_style_description() {
		$this->start_controls_section(
			'section_description_block_style',
			[
				'label'     => __( 'Description', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproductsingle .productsummary .description',
			]
		);

		$this->add_control(
			'description_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => array(
					'{{WRAPPER}} .royalwooproductsingle .productsummary .description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .productsummary .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .productsummary .description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}



	
	private function rt_style_price_options() {
		$this->start_controls_section(
			'section_grid_price_block_style',
			[
				'label'     => __( 'Price', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_price_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproductsingle .price',
			]
		);

		$this->add_control(
			'price_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => array(
					'{{WRAPPER}} .royalwooproductsingle .productsummary .price' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_bgcolor',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
				'selectors' => array(
					'{{WRAPPER}} .royalwooproductsingle .productsummary .price' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'price_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .productsummary .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .productsummary .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'price_border',
				'selector' => '{{WRAPPER}} .royalwooproductsingle .productsummary .price a',
			]
		);

		$this->end_controls_section();
	}


	private function rt_style_cart_options() {
		$this->start_controls_section(
			'section_grid_cart_style',
			[
				'label'     => __( 'Cart', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,			
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'cart_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalwooproductsingle .productsummary .addtocart a',
			]
		);

		$this->add_control(
			'cart_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#000',
				'selectors' => array(
					'{{WRAPPER}} .royalwooproductsingle .productsummary .addtocart a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cart_bgcolor',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Background', 'royal-addons-for-elementor' ),
				'selectors' => array(
					'{{WRAPPER}} .royalwooproductsingle .productsummary .addtocart a' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'cart_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .productsummary .addtocart' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_cart_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalwooproductsingle .productsummary .addtocart a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'cart_border',
				'selector' => '{{WRAPPER}} .royalwooproductsingle .productsummary .addtocart a',
			]
		);
		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Get settings.
			$settings = $this->get_settings();

				$style = $settings['singleproduct_style'];
				$product_id = $settings['product_single'];
				
				?>
				<div class="royalwooproductsingle">
				<div class="<?php echo $style ?>">
				<?php 
					$query_args = array(
									'post_type' 			=> 'product',
									'p'						=> $product_id,
									'ignore_sticky_posts'   => true
								);

					$all_posts = new \WP_Query( $query_args );

					if ( $all_posts->have_posts() ) :
						if( "singleproductstyle1" == $style ){
							while ( $all_posts->have_posts() ) :
								$all_posts->the_post(); ?>														
									<?php $this->render_thumbnail(); ?>						
									<div class="productsummary">
										<?php $this->render_title(); ?>
										<?php $this->short_description(); ?>
										<?php $this->product_price(); ?>
										<?php $this->add_to_cart(); ?>
									</div>					
									<?php		
							endwhile; 						
							wp_reset_postdata();
											

						}elseif( "gridstyle2" == $grid_style ){




						}else{

						}

					endif; ?>
			</div>
			</div>
			<?php

		}
	}


	protected function render_thumbnail() {
		$settings = $this->get_settings();
		$singleproduct_image = $settings['singleproduct_image'];
		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( $singleproduct_image === 'postthumbnail' ) {
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
		} else {
			$custom_image_url = esc_url( $settings['custom_image']['url'] ?? '' );
			$custom_alt = esc_attr( $settings['custom_image']['alt'] ?? get_the_title() );
			echo '<div class="productthumbnail">';
			echo '<img src="' . $custom_image_url . '" alt="' . $custom_alt . '" />';
			echo '</div>';
		}
	}



	protected function render_title() {
		$settings = $this->get_settings();

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
		echo '<div class="price">'. $product->get_price_html().'</div>';
	}

	
	protected function add_to_cart() {
		global $product;
		$id = $product->get_id();
		if( $product->is_type( 'simple' ) ){
			echo'<div class="addtocart"><a href="?add-to-cart='.$id.'">Add to cart</a></div>';
		} else {
			echo'<div class="addtocart"><a href="'. get_the_permalink().'">Details</a></div>';
		}
	}


	protected function short_description() {
		global $product;
		$id = $product->get_id();

		echo '<div class="description">'. $product->get_short_description().'</div>';
		
	}


}
