<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
    $product = wc_get_product( get_the_ID() );
    if ( $product ) {
        echo '<div id="product-' . esc_attr( get_the_ID() ) . '" ';
        wc_product_class( 'single-product-page royal-layout-single-product' );
        echo '>';
        $html = \RoyalAddons\RoyalLayout\Renderer::instance()->get_layout_html( 'single_product' );
        echo $html; // phpcs:ignore
        if ( function_exists( 'WC' ) && is_object( WC()->structured_data ) ) {
            WC()->structured_data->generate_product_data();
        }
        echo '</div>';
    }
endwhile;
get_footer();
