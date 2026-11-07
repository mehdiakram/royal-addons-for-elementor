<?php
/**
 * Royal Layout — Canvas Template
 * This template bypasses the theme's page structure to render Elementor layout perfectly.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Determine layout type from globals set in Core
global $royal_layout_type;

if ( ! empty( $royal_layout_type ) ) {
    $html = \RoyalAddons\RoyalLayout\Renderer::instance()->get_layout_html( $royal_layout_type );
    echo '<div class="royal-layout-canvas-' . esc_attr( $royal_layout_type ) . '">';
    echo $html; // phpcs:ignore
    echo '</div>';
}

get_footer();
