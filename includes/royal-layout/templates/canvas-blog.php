<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
echo '<div class="royal-layout-blog-archive">';
$html = \RoyalAddons\RoyalLayout\Renderer::instance()->get_layout_html( 'blog_archive' );
echo $html; // phpcs:ignore
echo '</div>';
get_footer();
