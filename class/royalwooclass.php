<?php
namespace RoyalAddons\Elementor;

class RoyalWooClass {

		public static function product_cat( $post_type ) {
		$options = array();
		$taxonomy = 'product_cat';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}



	public static function product_cat_id( $post_type ) {
		$options = array();
		$taxonomy = 'product_cat';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->term_id ) && isset( $term->name ) ) {
							$options[ $term->term_id ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}

	public static function royalproduct(){
		$products = get_posts( [
			'post_type'         => 'product',
			'posts_per_page'    => -1
		] );
	
		$options = [];
	
		if ( ! empty( $products ) && ! is_wp_error( $products ) ){
			foreach ( $products as $product ) {
				$options[ $product->ID ] = $product->post_title;
			}
		}
		return $options;
	}

	public static function get_current_product() {
		global $product;
		if ( $product && is_a( $product, 'WC_Product' ) ) {
			return $product;
		}

		$product_id = get_the_ID();
		$_product = wc_get_product( $product_id );

		if ( ! $_product ) {
			// Check if we are in Elementor editor or preview
			if ( \Elementor\Plugin::instance()->editor->is_edit_mode() || \Elementor\Plugin::instance()->preview->is_preview_mode() ) {
				// Get a mock product
				$products = wc_get_products( [ 'limit' => 1, 'return' => 'ids', 'status' => 'publish' ] );
				if ( ! empty( $products ) ) {
					$_product = wc_get_product( $products[0] );
					// Also set the global product for other functions
					$GLOBALS['product'] = $_product;
				}
			}
		}

		return $_product;
	}
}