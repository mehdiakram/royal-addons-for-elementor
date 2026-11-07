<?php

namespace RoyalAddons\Snippet;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Enhanced Royal Snippet Output with Display Conditions
 */
class Royal_Snippet_Output {

    public function __construct() {
        add_action( 'wp_head',       array( $this, 'output_head_snippets' ), 1 );
        add_action( 'wp_body_open',  array( $this, 'output_body_start_snippets' ), 1 );
        add_action( 'wp_footer',     array( $this, 'output_body_end_snippets' ), 999 );
        add_action( 'admin_head',    array( $this, 'output_admin_head_snippets' ), 1 );
        add_action( 'admin_footer',  array( $this, 'output_admin_footer_snippets' ), 999 );
        add_action( 'init',          array( $this, 'execute_php_snippets' ), 1 );
        add_action( 'wp_ajax_royal_snippet_get_condition_values', array( $this, 'get_condition_values' ) );
    }

    /**
     * Fetches snippets based on location and code type, ordered by priority
     *
     * @param string $location The desired snippet location ('head', 'body_start', 'body_end').
     * @return array An array of snippet post objects.
     */
    private function get_snippets_by_location( $location ) {
        $args = array(
            'post_type'      => 'royal_snippet',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'     => '_royal_snippet_location',
                    'value'   => $location,
                    'compare' => '=',
                ),
                array(
                    'relation' => 'OR',
                    array(
                        'key'     => '_royal_snippet_code_type',
                        'value'   => array( 'html', 'css', 'javascript' ),
                        'compare' => 'IN',
                    ),
                    // Also include snippets without code_type set (legacy HTML)
                    array(
                        'key'     => '_royal_snippet_code_type',
                        'compare' => 'NOT EXISTS',
                    ),
                ),
            ),
            'orderby'          => 'meta_value_num',
            'meta_key'         => '_royal_snippet_priority',
            'order'            => 'ASC',
            'suppress_filters' => true,
        );

        $snippets = get_posts( $args );
        
        // Filter snippets based on display conditions
        $filtered_snippets = array();
        foreach ( $snippets as $snippet ) {
            if ( $this->should_display_snippet( $snippet->ID ) ) {
                $filtered_snippets[] = $snippet;
            }
        }

        return $filtered_snippets;
    }

    /**
     * Fetches PHP snippets (not location-based, runs globally via init)
     *
     * @return array An array of PHP snippet post objects.
     */
    private function get_php_snippets() {
        $args = array(
            'post_type'      => 'royal_snippet',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'     => '_royal_snippet_code_type',
                    'value'   => 'php',
                    'compare' => '=',
                ),
            ),
            'orderby'          => 'meta_value_num',
            'meta_key'         => '_royal_snippet_priority',
            'order'            => 'ASC',
            'suppress_filters' => true,
        );

        $snippets = get_posts( $args );

        $filtered_snippets = array();
        foreach ( $snippets as $snippet ) {
            if ( $this->should_display_snippet( $snippet->ID ) ) {
                $filtered_snippets[] = $snippet;
            }
        }

        return $filtered_snippets;
    }

    /**
     * Check if snippet should be displayed based on conditions
     *
     * @param int $snippet_id The snippet post ID
     * @return bool Whether the snippet should be displayed
     */
    private function should_display_snippet( $snippet_id ) {
        $conditions = get_post_meta( $snippet_id, '_royal_snippet_conditions', true );
        
        // If no conditions are set, display everywhere (default behavior)
        if ( empty( $conditions ) ) {
            return true;
        }

        $include_conditions = array();
        $exclude_conditions = array();

        // Separate include and exclude conditions
        foreach ( $conditions as $condition ) {
            if ( $condition['type'] === 'include' ) {
                $include_conditions[] = $condition;
            } else {
                $exclude_conditions[] = $condition;
            }
        }

        // Check exclude conditions first (they take precedence)
        foreach ( $exclude_conditions as $condition ) {
            if ( $this->evaluate_condition( $condition ) ) {
                return false; // Exclude this snippet
            }
        }

        // If there are include conditions, at least one must match
        if ( ! empty( $include_conditions ) ) {
            foreach ( $include_conditions as $condition ) {
                if ( $this->evaluate_condition( $condition ) ) {
                    return true; // Include this snippet
                }
            }
            return false; // No include conditions matched
        }

        // If only exclude conditions exist and none matched, display the snippet
        return true;
    }

    /**
     * Evaluate a single condition
     *
     * @param array $condition The condition to evaluate
     * @return bool Whether the condition matches
     */
    private function evaluate_condition( $condition ) {
        $rule = $condition['rule'];
        $value = isset( $condition['value'] ) ? $condition['value'] : '';

        switch ( $rule ) {
            case 'entire_site':
                return true;

            case 'front_page':
                return is_front_page();

            case 'singular':
                return is_singular();

            case 'all_singular':
                return is_singular();

            case 'post':
                if ( empty( $value ) ) {
                    return is_singular( 'post' );
                } else {
                    return is_single( $value );
                }

            case 'page':
                if ( empty( $value ) ) {
                    return is_page();
                } else {
                    return is_page( $value );
                }

            case 'category':
                if ( empty( $value ) ) {
                    return is_category();
                } else {
                    return is_category( $value ) || in_category( $value );
                }

            case 'tag':
                if ( empty( $value ) ) {
                    return is_tag();
                } else {
                    return is_tag( $value ) || has_tag( $value );
                }

            case 'archive':
                return is_archive();

            case 'search':
                return is_search();

            case 'error_404':
                return is_404();

            case 'user_logged_in':
                return is_user_logged_in();

            case 'user_logged_out':
                return ! is_user_logged_in();

            case 'mobile':
                return wp_is_mobile();

            case 'desktop':
                return ! wp_is_mobile();

            default:
                // Allow custom condition evaluation via filter
                return apply_filters( 'royal_snippet_evaluate_condition', false, $condition );
        }
    }

    /**
     * Wrap snippet content based on its code type
     *
     * @param string $content   Raw code content.
     * @param string $code_type Code type: html | css | javascript.
     * @return string           Wrapped output ready to echo.
     */
    private function wrap_snippet_output( $content, $code_type ) {
        switch ( $code_type ) {
            case 'css':
                return "<style>\n" . $content . "\n</style>\n";
            case 'javascript':
                return "<script>\n" . $content . "\n</script>\n";
            case 'html':
            default:
                return do_shortcode( $content ) . "\n";
        }
    }

    /**
     * Outputs snippets located in the <head> section
     */
    public function output_head_snippets() {
        $snippets = $this->get_snippets_by_location( 'head' );
        foreach ( $snippets as $snippet ) {
            $content   = get_post_meta( $snippet->ID, '_royal_snippet_content', true );
            $code_type = get_post_meta( $snippet->ID, '_royal_snippet_code_type', true );
            if ( empty( $code_type ) ) {
                $code_type = 'html';
            }
            if ( ! empty( $content ) ) {
                echo "<!-- Royal Snippet: " . esc_html( $snippet->post_title ) . " -->\n";
                echo $this->wrap_snippet_output( $content, $code_type ); // phpcs:ignore WordPress.Security.EscapeOutput
            }
        }
    }

    /**
     * Outputs snippets located at the beginning of the <body> section
     */
    public function output_body_start_snippets() {
        $snippets = $this->get_snippets_by_location( 'body_start' );
        foreach ( $snippets as $snippet ) {
            $content   = get_post_meta( $snippet->ID, '_royal_snippet_content', true );
            $code_type = get_post_meta( $snippet->ID, '_royal_snippet_code_type', true );
            if ( empty( $code_type ) ) {
                $code_type = 'html';
            }
            if ( ! empty( $content ) ) {
                echo "<!-- Royal Snippet: " . esc_html( $snippet->post_title ) . " -->\n";
                echo $this->wrap_snippet_output( $content, $code_type ); // phpcs:ignore WordPress.Security.EscapeOutput
            }
        }
    }

    /**
     * Outputs snippets located at the end of the <body> section (before </body>)
     */
    public function output_body_end_snippets() {
        $snippets = $this->get_snippets_by_location( 'body_end' );
        foreach ( $snippets as $snippet ) {
            $content   = get_post_meta( $snippet->ID, '_royal_snippet_content', true );
            $code_type = get_post_meta( $snippet->ID, '_royal_snippet_code_type', true );
            if ( empty( $code_type ) ) {
                $code_type = 'html';
            }
            if ( ! empty( $content ) ) {
                echo "<!-- Royal Snippet: " . esc_html( $snippet->post_title ) . " -->\n";
                echo $this->wrap_snippet_output( $content, $code_type ); // phpcs:ignore WordPress.Security.EscapeOutput
            }
        }
    }

    /**
     * Outputs snippets located in the admin <head> section
     */
    public function output_admin_head_snippets() {
        $snippets = $this->get_snippets_by_location( 'admin_head' );
        foreach ( $snippets as $snippet ) {
            $content   = get_post_meta( $snippet->ID, '_royal_snippet_content', true );
            $code_type = get_post_meta( $snippet->ID, '_royal_snippet_code_type', true );
            if ( empty( $code_type ) ) {
                $code_type = 'html';
            }
            if ( ! empty( $content ) ) {
                echo "<!-- Royal Snippet: " . esc_html( $snippet->post_title ) . " -->\n";
                echo $this->wrap_snippet_output( $content, $code_type ); // phpcs:ignore WordPress.Security.EscapeOutput
            }
        }
    }

    /**
     * Outputs snippets located at the admin <footer> section
     */
    public function output_admin_footer_snippets() {
        $snippets = $this->get_snippets_by_location( 'admin_footer' );
        foreach ( $snippets as $snippet ) {
            $content   = get_post_meta( $snippet->ID, '_royal_snippet_content', true );
            $code_type = get_post_meta( $snippet->ID, '_royal_snippet_code_type', true );
            if ( empty( $code_type ) ) {
                $code_type = 'html';
            }
            if ( ! empty( $content ) ) {
                echo "<!-- Royal Snippet: " . esc_html( $snippet->post_title ) . " -->\n";
                echo $this->wrap_snippet_output( $content, $code_type ); // phpcs:ignore WordPress.Security.EscapeOutput
            }
        }
    }

    /**
     * Execute PHP snippets via init hook.
     * Only runs snippets created by administrators.
     */
    public function execute_php_snippets() {
        // Skip in admin area (except AJAX)
        if ( is_admin() && ! wp_doing_ajax() ) {
            return;
        }

        $snippets = $this->get_php_snippets();

        foreach ( $snippets as $snippet ) {
            $content = get_post_meta( $snippet->ID, '_royal_snippet_content', true );

            if ( empty( $content ) ) {
                continue;
            }

            // Safety: only execute snippets authored by an administrator
            $author_id = (int) $snippet->post_author;
            if ( ! user_can( $author_id, 'administrator' ) ) {
                continue;
            }

            ob_start();
            try {
                // phpcs:ignore Squiz.PHP.Eval.Discouraged
                eval( $content );
            } catch ( \Throwable $e ) {
                // Silently fail — avoid breaking the site
                ob_end_clean();
                continue;
            }
            ob_end_flush();
        }
    }

    /**
     * AJAX handler to get condition values
     */
    public function get_condition_values() {
        check_ajax_referer( 'royal_snippet_nonce', 'nonce' );

        $rule = sanitize_text_field( $_POST['rule'] ?? '' );
        $values = array();

        switch ( $rule ) {
            case 'post':
                $posts = get_posts( array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'numberposts' => 50,
                    'orderby' => 'title',
                    'order' => 'ASC'
                ) );
                
                foreach ( $posts as $post ) {
                    $values[] = array(
                        'value' => $post->ID,
                        'label' => $post->post_title
                    );
                }
                break;

            case 'page':
                $pages = get_pages( array(
                    'post_status' => 'publish',
                    'number' => 50,
                    'sort_column' => 'post_title',
                    'sort_order' => 'ASC'
                ) );
                
                foreach ( $pages as $page ) {
                    $values[] = array(
                        'value' => $page->ID,
                        'label' => $page->post_title
                    );
                }
                break;

            case 'category':
                $categories = get_categories( array(
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ) );
                
                foreach ( $categories as $category ) {
                    $values[] = array(
                        'value' => $category->term_id,
                        'label' => $category->name
                    );
                }
                break;

            case 'tag':
                $tags = get_tags( array(
                    'hide_empty' => false,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ) );
                
                foreach ( $tags as $tag ) {
                    $values[] = array(
                        'value' => $tag->term_id,
                        'label' => $tag->name
                    );
                }
                break;

            default:
                // Allow custom condition values via filter
                $values = apply_filters( 'royal_snippet_condition_values', $values, $rule );
                break;
        }

        wp_send_json_success( $values );
    }

    /**
     * Get available condition rules
     *
     * @return array Array of condition rules
     */
    public static function get_condition_rules() {
        $rules = array(
            'basic' => array(
                'label' => esc_html__( 'Basic', 'royal-addons-for-elementor' ),
                'rules' => array(
                    'entire_site' => esc_html__( 'Entire Site', 'royal-addons-for-elementor' ),
                    'front_page' => esc_html__( 'Front Page', 'royal-addons-for-elementor' ),
                )
            ),
            'singular' => array(
                'label' => esc_html__( 'Singular', 'royal-addons-for-elementor' ),
                'rules' => array(
                    'singular' => esc_html__( 'Singular', 'royal-addons-for-elementor' ),
                    'all_singular' => esc_html__( 'All Singular', 'royal-addons-for-elementor' ),
                )
            ),
            'post' => array(
                'label' => esc_html__( 'Post', 'royal-addons-for-elementor' ),
                'rules' => array(
                    'post' => esc_html__( 'Posts', 'royal-addons-for-elementor' ),
                    'category' => esc_html__( 'In Category', 'royal-addons-for-elementor' ),
                    'tag' => esc_html__( 'In Tag', 'royal-addons-for-elementor' ),
                )
            ),
            'page' => array(
                'label' => esc_html__( 'Page', 'royal-addons-for-elementor' ),
                'rules' => array(
                    'page' => esc_html__( 'Pages', 'royal-addons-for-elementor' ),
                )
            ),
            'archive' => array(
                'label' => esc_html__( 'Archive', 'royal-addons-for-elementor' ),
                'rules' => array(
                    'archive' => esc_html__( 'Archive', 'royal-addons-for-elementor' ),
                    'search' => esc_html__( 'Search Results', 'royal-addons-for-elementor' ),
                    'error_404' => esc_html__( '404 Page', 'royal-addons-for-elementor' ),
                )
            ),
            'user' => array(
                'label' => esc_html__( 'User', 'royal-addons-for-elementor' ),
                'rules' => array(
                    'user_logged_in' => esc_html__( 'Logged In Users', 'royal-addons-for-elementor' ),
                    'user_logged_out' => esc_html__( 'Logged Out Users', 'royal-addons-for-elementor' ),
                )
            ),
            'device' => array(
                'label' => esc_html__( 'Device', 'royal-addons-for-elementor' ),
                'rules' => array(
                    'mobile' => esc_html__( 'Mobile', 'royal-addons-for-elementor' ),
                    'desktop' => esc_html__( 'Desktop', 'royal-addons-for-elementor' ),
                )
            ),
        );

        return apply_filters( 'royal_snippet_condition_rules', $rules );
    }

    /**
     * Check if a condition rule needs a value selection
     *
     * @param string $rule The condition rule
     * @return bool Whether the rule needs a value
     */
    public static function rule_needs_value( $rule ) {
        $rules_with_values = array( 'post', 'page', 'category', 'tag' );
        return in_array( $rule, $rules_with_values );
    }
}

