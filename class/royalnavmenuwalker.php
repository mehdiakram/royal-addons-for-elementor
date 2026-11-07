<?php
namespace RoyalAddons\Widgets;

if (!defined('ABSPATH')) exit;

class Royal_Data_Hover_Nav_Walker extends \Walker_Nav_Menu {

    private $top_level_item_count = 0;

    public function __construct() {
        $this->top_level_item_count = 0;
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        if ( null === $args || ! is_object( $args ) ) {
            $args = (object) [];
        }

        if ( $depth === 0 ) {
            $this->top_level_item_count++;
        }

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? esc_url( $item->url ) : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = ( property_exists( $args, 'before' ) ? $args->before : '' ) .
                       '<a' . $attributes . '>' .
                       ( property_exists( $args, 'link_before' ) ? $args->link_before : '' ) .
                       $title .
                       ( property_exists( $args, 'link_after' ) ? $args->link_after : '' ) .
                       '</a>' .
                       ( property_exists( $args, 'after' ) ? $args->after : '' );

        $data_hover_attr = '';
        if ( isset( $args->enable_data_hover ) && $args->enable_data_hover === 'yes' ) {
            $data_hover_attr = ' data-hover="' . esc_attr( $item->title ) . '"';
        }

        $css_classes = empty( $item->classes ) ? array() : (array) $item->classes;

        if ( ! in_array( 'menu-item', $css_classes, true ) ) {
            $css_classes[] = 'menu-item';
        }

        if ( isset( $args->menu_style ) && $args->menu_style === 'multiple_colors' ) {
            $menu_colors_list = property_exists( $args, 'menu_colors_list' ) ? (array) $args->menu_colors_list : [];
            $repeater_id_prefix = property_exists( $args, 'repeater_id_prefix' ) ? $args->repeater_id_prefix : 'elementor-repeater-item-';

            $num_repeater_items = count( $menu_colors_list );

            if ( $depth === 0 && $num_repeater_items > 0 ) {
                $repeater_map_index = ( $this->top_level_item_count - 1 ) % $num_repeater_items;

                if ( isset( $menu_colors_list[ $repeater_map_index ]['_id'] ) ) {
                    $css_classes[] = $repeater_id_prefix . $menu_colors_list[ $repeater_map_index ]['_id'];
                } else {
                    $css_classes[] = $repeater_id_prefix . ( $repeater_map_index + 1 );
                }
            }
        }

        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $css_classes ), $item, $args, $depth ) ) );

        // No onclick added here. The <a> tag will handle clicks directly.
        $output .= '<li' . $data_hover_attr . ' id="menu-item-' . esc_attr( $item->ID ) . '" class="' . $class_names . '">';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }

    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n" . $indent . '<ul class="sub-menu">' . "\n";
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= $indent . '</ul>' . "\n";
    }
}