<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
do_action( 'woocommerce_before_main_content' );
$html = \RoyalAddons\RoyalLayout\Renderer::instance()->get_layout_html( 'shop_archive' );
echo $html; // phpcs:ignore
do_action( 'woocommerce_after_main_content' );
get_footer();
