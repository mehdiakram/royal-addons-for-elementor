<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) : the_post();
    echo '<article id="post-' . esc_attr( get_the_ID() ) . '" '; post_class('royal-layout-single-post'); echo '>';
    $html = \RoyalAddons\RoyalLayout\Renderer::instance()->get_layout_html( 'single_post' );
    echo $html; // phpcs:ignore
    echo '</article>';
endwhile;
get_footer();
