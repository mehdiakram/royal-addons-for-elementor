<?php
/**
 * Royal HF Functions
 */
namespace RoyalAddons\RoyalHF;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get the template ID based on the display rules by finding the best match.
 *
 * @param string $type The type of template (e.g., 'type_header', 'type_footer').
 * @return int|false The post ID of the best matched template, or false if not found.
 */
function get_royal_hf_by_type( $type ) {
    static $template_cache = [];

    if ( isset( $template_cache[ $type ] ) ) {
        return $template_cache[ $type ];
    }

    $args = [
        'post_type'      => 'royal-hf',
        'posts_per_page' => -1,
        'meta_key'       => '_royal_template_type',
        'meta_value'     => $type,
        'post_status'    => 'publish',
    ];
    $query = new \WP_Query( $args );

    $best_match_id = false;
    $highest_score = -1;

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();

            $display_rules   = get_post_meta( $post_id, '_royal_hf_target_include_locations', true );
            $exclusion_rules = get_post_meta( $post_id, '_royal_hf_target_exclude_locations', true );
            $user_roles      = get_post_meta( $post_id, '_royal_hf_target_user_roles', true );

            $is_exclude   = Target_Rules::get_instance()->parse_layout_display_condition( $exclusion_rules, $post_id, 'exclude' );
            $is_user_role = Target_Rules::get_instance()->parse_user_role_condition( $user_roles );
            
            if ( ! $is_exclude && $is_user_role ) {
                $current_score = Target_Rules::get_instance()->get_display_score( $display_rules, $post_id, 'include' );
                if ( $current_score > $highest_score ) {
                    $highest_score = $current_score;
                    $best_match_id = $post_id;
                }
            }
        }
    }
    wp_reset_postdata();

    $template_cache[ $type ] = $best_match_id;
    return $best_match_id;
}

function royal_get_header_id() {
    return get_royal_hf_by_type( 'type_header' );
}

function royal_get_footer_id() {
    return get_royal_hf_by_type( 'type_footer' );
}

function royal_get_before_footer_id() {
    return get_royal_hf_by_type( 'type_before_footer' );
}

/**
 * Render the custom header template.
 */
function royal_render_header() {
    $header_id = royal_get_header_id();
    if ( $header_id ) {
        echo '<header id="masthead" class="site-header royal-hf-header" role="banner">';
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header_id );
        echo '</header>';
    }
}

/**
 * Render the custom footer template.
 */
function royal_render_footer() {
    $before_footer_id = royal_get_before_footer_id();
    $footer_id = royal_get_footer_id();

    if ( $before_footer_id ) {
        echo '<div class="royal-before-footer-wrap">';
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $before_footer_id );
        echo '</div>';
    }

    if ( $footer_id ) {
        echo '<footer id="colophon" class="site-footer royal-hf-footer" role="contentinfo">';
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_id );
        echo '</footer>';
    }
}

/**
 * Render only the before-footer template.
 * This is used when we only have a before-footer but no custom footer,
 * allowing the theme's default footer to show after our before-footer content.
 */
function royal_render_before_footer() {
    global $royal_hf_before_footer_rendered;
    
    // Skip if already rendered
    if ( ! empty( $royal_hf_before_footer_rendered ) ) {
        return;
    }
    
    $before_footer_id = royal_get_before_footer_id();
    if ( $before_footer_id ) {
        $royal_hf_before_footer_rendered = true;
        echo '<div class="royal-before-footer-wrap">';
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $before_footer_id );
        echo '</div>';
    }
}

function rhf_template_shortcode( $atts ) {
    $atts = shortcode_atts(
        [
            'id' => '',
        ],
        $atts,
        'rhf_template'
    );

    $id = ! empty( $atts['id'] ) ? intval( $atts['id'] ) : '';

    if ( empty( $id ) ) {
        return '';
    }

    return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id );
}
add_shortcode( 'rhf_template', __NAMESPACE__ . '\\rhf_template_shortcode' );

/**
 * Override Elementor's theme location for our custom header/footer.
 * This function renders our content and returns true if we have a custom template,
 * allowing themes that use elementor_theme_do_location() to skip their default header/footer.
 * 
 * @param string $location The location ('header' or 'footer').
 * @return bool Whether the location was rendered.
 */
function royal_do_elementor_location( $location ) {
    global $royal_hf_header_rendered, $royal_hf_footer_rendered, $royal_hf_before_footer_rendered;

    if ( 'header' === $location ) {
        // Skip if already rendered
        if ( ! empty( $royal_hf_header_rendered ) ) {
            return true; // Return true since we already rendered it
        }
        
        $header_id = royal_get_header_id();
        if ( $header_id ) {
            // Mark as rendered to prevent double rendering
            $royal_hf_header_rendered = true;
            
            echo '<header id="masthead" class="site-header royal-hf-header" role="banner">';
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header_id );
            echo '</header>';
            return true;
        }
    }

    if ( 'footer' === $location ) {
        $before_footer_id = royal_get_before_footer_id();
        $footer_id = royal_get_footer_id();
        
        // If we have a custom footer, render both before-footer (if exists) and footer
        // Return true to tell the theme NOT to show its default footer
        if ( $footer_id ) {
            // Skip if already rendered
            if ( ! empty( $royal_hf_footer_rendered ) ) {
                return true; // Return true since we already rendered it
            }
            
            // Mark as rendered to prevent double rendering
            $royal_hf_footer_rendered = true;
            $royal_hf_before_footer_rendered = true;
            
            if ( $before_footer_id ) {
                echo '<div class="royal-before-footer-wrap">';
                echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $before_footer_id );
                echo '</div>';
            }
            
            echo '<footer id="colophon" class="site-footer royal-hf-footer" role="contentinfo">';
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_id );
            echo '</footer>';
            return true;
        }
        
        // If we only have before-footer (no custom footer), render it but return false
        // so the theme's default footer will still show after our before-footer content
        if ( $before_footer_id ) {
            // Skip if already rendered
            if ( ! empty( $royal_hf_before_footer_rendered ) ) {
                return false; // Return false since theme should still show its footer
            }
            
            // Mark before-footer as rendered to prevent double rendering
            $royal_hf_before_footer_rendered = true;
            
            echo '<div class="royal-before-footer-wrap">';
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $before_footer_id );
            echo '</div>';
            return false; // Let theme show its default footer
        }
    }

    return false;
}

