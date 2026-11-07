<?php
/**
 * Royal Layout — Condition Matching (WoodMart-style)
 *
 * @package RoyalAddons\RoyalLayout
 */

namespace RoyalAddons\RoyalLayout;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Conditions {

    private static $instance = null;
    private $layouts_cache = [];

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Types that support conditions.
     */
    public static function get_conditioned_types() {
        return [
            'single_product',
            'shop_archive',
            'my_account_page',
            'single_post',
            'blog_archive',
            'thank_you_page',
        ];
    }

    /**
     * Get matching layout ID for a given type.
     * Uses WoodMart-style priority-based condition resolution.
     * If conditions are empty, treat as "all" (match everything).
     */
    public function get_matching_layout_id( $type ) {
        if ( isset( $this->layouts_cache[ $type ] ) ) {
            return $this->layouts_cache[ $type ];
        }

        $conditions_data         = get_option( 'royal_layouts_conditions', [] );
        $current_conditions_data = $conditions_data[ $type ] ?? [];

        // Fallback: if cache is empty, try direct DB query
        if ( empty( $current_conditions_data ) ) {
            $fallback = $this->get_simple_layout_id( $type );
            if ( $fallback ) {
                $this->layouts_cache[ $type ] = $fallback;
                return $fallback;
            }
        }

        $sorted_data             = [];
        $conditions_priority     = [];

        foreach ( $current_conditions_data as $post_id => $conditions ) {
            $post = get_post( $post_id );

            // If conditions empty or not array, treat as "all" (always active)
            if ( ! is_array( $conditions ) || empty( $conditions ) ) {
                if ( $post && 'publish' === $post->post_status ) {
                    $conditions_priority[ $post_id ] = 10; // lowest priority ("all")
                }
                continue;
            }

            $is_active = false;

            foreach ( $conditions as $condition ) {
                if ( empty( $condition['condition_type'] ) ) {
                    continue;
                }

                // Check by layout type
                if ( function_exists( 'WC' ) ) {
                    if ( 'single_product' === $type ) {
                        $is_active = $this->check_single_product( $condition );
                    }
                    if ( 'shop_archive' === $type ) {
                        $is_active = $this->check_shop_archive( $condition );
                    }
                    if ( 'thank_you_page' === $type ) {
                        $is_active = $this->check_thank_you_page( $condition );
                    }
                    if ( in_array( $type, [ 'my_account_page', 'my_account_auth', 'my_account_lost_password' ], true ) ) {
                        $is_active = $this->check_my_account( $condition, $type );
                    }
                    if ( in_array( $type, [ 'cart', 'empty_cart' ], true ) ) {
                        $is_active = $this->check_cart( $condition, $type );
                    }
                    if ( in_array( $type, [ 'checkout_form', 'checkout_content' ], true ) ) {
                        $is_active = $this->check_checkout( $condition, $type );
                    }
                }

                if ( 'single_post' === $type ) {
                    $is_active = $this->check_single_post( $condition );
                }
                if ( 'blog_archive' === $type ) {
                    $is_active = $this->check_blog_archive( $condition );
                }

                if ( $is_active && $post && 'publish' === $post->post_status ) {
                    $sorted_data[ $post_id ][ $condition['condition_comparison'] ?? 'include' ][] = [
                        'is_active' => $is_active,
                        'priority'  => $this->get_condition_priority( $condition['condition_type'] ),
                    ];
                }
            }
        }

        // Resolve priority
        foreach ( $sorted_data as $post_id => $conditions ) {
            if ( isset( $conditions['include'] ) ) {
                foreach ( $conditions['include'] as $condition ) {
                    if ( $condition['is_active'] ) {
                        $conditions_priority[ $post_id ] = $condition['priority'];
                    }
                }
            }
            if ( isset( $conditions['exclude'] ) ) {
                foreach ( $conditions['exclude'] as $condition ) {
                    if ( $condition['is_active'] ) {
                        unset( $conditions_priority[ $post_id ] );
                    }
                }
            }
        }

        asort( $conditions_priority );
        $conditions_priority = array_flip( $conditions_priority );

        $this->layouts_cache[ $type ] = end( $conditions_priority );

        return $this->layouts_cache[ $type ];
    }

    /**
     * Simple layout matching for non-condition types.
     * Just returns the first published layout of that type.
     */
    public function get_simple_layout_id( $type ) {
        if ( isset( $this->layouts_cache[ $type ] ) ) {
            return $this->layouts_cache[ $type ];
        }

        $layouts = get_posts( [
            'post_type'      => 'royal_layout',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'meta_query'     => [
                [ 'key' => '_royal_layout_type', 'value' => $type ],
            ],
            'fields' => 'ids',
        ] );

        $this->layouts_cache[ $type ] = ! empty( $layouts ) ? $layouts[0] : false;
        return $this->layouts_cache[ $type ];
    }

    /**
     * Check if a type has a matching layout.
     */
    public function has_layout( $type ) {
        $conditioned = self::get_conditioned_types();

        if ( in_array( $type, $conditioned, true ) ) {
            return (bool) $this->get_matching_layout_id( $type );
        }

        return (bool) $this->get_simple_layout_id( $type );
    }

    /**
     * Get the layout ID for a type.
     */
    public function get_layout_id( $type ) {
        $conditioned = self::get_conditioned_types();

        if ( in_array( $type, $conditioned, true ) ) {
            return $this->get_matching_layout_id( $type );
        }

        return $this->get_simple_layout_id( $type );
    }

    /* =========================================================
     * Condition Priority (WoodMart-identical)
     * ========================================================= */

    private function get_condition_priority( $type ) {
        $priority = 100;

        switch ( $type ) {
            case 'all':
                $priority = 10;
                break;
            case 'shop_page':
                $priority = 20;
                break;
            case 'product_cats':
            case 'product_tags':
            case 'product_attr':
                $priority = 30;
                break;
            case 'product_cat_children':
                $priority = 40;
                break;
            case 'product_search':
                $priority = 50;
                break;
            case 'product_cat':
            case 'product_tag':
            case 'product_brand':
            case 'product_attr_term':
            case 'product_term':
            case 'product_shipping_class':
                $priority = 70;
                break;
            case 'product':
            case 'products':
            case 'post_id':
                $priority = 90;
                break;
        }

        return $priority;
    }

    /* =========================================================
     * Condition Checkers — per type (WoodMart-identical)
     * ========================================================= */

    private function check_single_product( $condition ) {
        $is_active = false;
        $query     = $condition['condition_query'] ?? '';

        switch ( $condition['condition_type'] ) {
            case 'all':
                $is_active = is_singular( 'product' );
                break;
            case 'product':
                $is_active = is_singular( 'product' ) && (int) get_the_ID() === (int) $query;
                break;
            case 'product_type':
                if ( function_exists( 'WC_Product_Factory' ) && is_singular( 'product' ) ) {
                    $is_active = \WC_Product_Factory::get_product_type( get_the_ID() ) === $query;
                }
                break;
            case 'product_cat':
            case 'product_tag':
            case 'product_brand':
            case 'product_attr_term':
                if ( is_singular( 'product' ) ) {
                    $terms = wp_get_post_terms( get_the_ID(), get_taxonomies(), [ 'fields' => 'ids' ] );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $is_active = in_array( (int) $query, $terms, true );
                    }
                }
                break;
            case 'product_cat_children':
                if ( is_singular( 'product' ) ) {
                    $terms         = wp_get_post_terms( get_the_ID(), 'product_cat', [ 'fields' => 'ids' ] );
                    $term_children = get_term_children( (int) $query, 'product_cat' );
                    if ( $terms && ! is_wp_error( $terms ) && ! empty( $term_children ) ) {
                        $is_active = count( array_intersect( $terms, $term_children ) ) > 0;
                    }
                }
                break;
        }

        return $is_active;
    }

    private function check_shop_archive( $condition ) {
        $is_active = false;
        $query     = $condition['condition_query'] ?? '';

        switch ( $condition['condition_type'] ) {
            case 'all':
                $is_active = ( function_exists( 'is_shop' ) && is_shop() ) || is_product_category() || is_product_tag() || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() );
                break;
            case 'shop_page':
                $is_active = function_exists( 'is_shop' ) && is_shop();
                break;
            case 'product_search':
                $query_vars = get_query_var( 'post_type' );
                $is_active  = is_search() && ( 'product' === $query_vars || ( is_array( $query_vars ) && in_array( 'product', $query_vars, true ) ) );
                break;
            case 'product_cats':
                $is_active = is_product_category();
                break;
            case 'product_tags':
                $is_active = is_product_tag();
                break;
            case 'product_term':
                $object      = get_queried_object();
                $taxonomy_id = is_object( $object ) && property_exists( $object, 'term_id' ) ? $object->term_id : false;
                $is_active   = (int) $taxonomy_id === (int) $query && ! is_search();
                break;
            case 'product_cat_children':
                $object        = get_queried_object();
                $taxonomy_id   = is_object( $object ) && property_exists( $object, 'term_id' ) ? $object->term_id : false;
                $term_children = get_term_children( (int) $query, 'product_cat' );
                $is_active     = in_array( $taxonomy_id, $term_children ); // phpcs:ignore
                break;
            case 'product_attr':
                $object   = get_queried_object();
                $taxonomy = is_object( $object ) && property_exists( $object, 'taxonomy' ) ? $object->taxonomy : false;
                $is_active = $taxonomy === $query;
                break;
        }

        return $is_active;
    }

    private function check_single_post( $condition ) {
        $is_active = false;
        $query     = $condition['condition_query'] ?? '';

        switch ( $condition['condition_type'] ) {
            case 'all':
                $is_active = is_singular( 'post' );
                break;
            case 'post_id':
                $is_active = is_singular( 'post' ) && (int) get_the_ID() === (int) $query;
                break;
            case 'post_cat':
                if ( is_singular( 'post' ) ) {
                    $terms = wp_get_post_terms( get_the_ID(), 'category', [ 'fields' => 'ids' ] );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $is_active = in_array( (int) $query, $terms, true );
                    }
                }
                break;
            case 'post_tag':
                if ( is_singular( 'post' ) ) {
                    $terms = wp_get_post_terms( get_the_ID(), 'post_tag', [ 'fields' => 'ids' ] );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $is_active = in_array( (int) $query, $terms, true );
                    }
                }
                break;
            case 'post_format':
                if ( is_singular( 'post' ) ) {
                    $is_active = get_post_format() === $query;
                }
                break;
        }

        return $is_active;
    }

    private function check_blog_archive( $condition ) {
        $is_active = false;
        $query     = $condition['condition_query'] ?? '';

        switch ( $condition['condition_type'] ) {
            case 'all':
                $is_active = is_home() || is_category() || is_tag() || is_author() || is_date() || ( is_search() && 'post' === get_query_var( 'post_type', 'post' ) );
                break;
            case 'blog_search_result':
                $is_active = is_search() && 'post' === get_query_var( 'post_type', 'post' );
                break;
            case 'blog_category':
                $is_active = is_category( $query );
                break;
            case 'blog_tag':
                $is_active = is_tag( $query );
                break;
            case 'blog_author':
                $is_active = is_author();
                break;
            case 'blog_date':
                $is_active = is_date();
                break;
        }

        return $is_active;
    }

    private function check_thank_you_page( $condition ) {
        $is_active = false;
        $query     = $condition['condition_query'] ?? '';

        switch ( $condition['condition_type'] ) {
            case 'all':
                $is_active = function_exists( 'is_order_received_page' ) && is_order_received_page();
                break;
            case 'products':
            case 'product_cat':
            case 'product_tag':
            case 'product_brand':
            case 'product_attr_term':
            case 'product_type':
            case 'product_shipping_class':
            case 'product_cat_children':
                // TY page order-based product checks (simplified)
                $is_active = function_exists( 'is_order_received_page' ) && is_order_received_page();
                break;
        }

        return $is_active;
    }

    private function check_my_account( $condition, $type ) {
        if ( ! function_exists( 'is_account_page' ) || ! is_account_page() ) {
            return false;
        }

        $is_active = false;
        switch ( $condition['condition_type'] ) {
            case 'all':
                if ( 'my_account_page' === $type ) {
                    $is_active = is_user_logged_in();
                } elseif ( 'my_account_auth' === $type ) {
                    $is_active = ! is_user_logged_in() && ! ( isset( $_GET['action'] ) && 'lostpassword' === $_GET['action'] );
                } elseif ( 'my_account_lost_password' === $type ) {
                    $is_active = ! is_user_logged_in() && isset( $_GET['action'] ) && 'lostpassword' === $_GET['action'];
                }
                break;
        }

        return $is_active;
    }

    private function check_cart( $condition, $type ) {
        if ( ! function_exists( 'is_cart' ) || ! is_cart() ) {
            return false;
        }

        $wc_cart  = WC()->cart;
        $is_empty = $wc_cart && $wc_cart->is_empty();

        if ( 'cart' === $type ) {
            return ! $is_empty;
        }
        if ( 'empty_cart' === $type ) {
            return $is_empty;
        }

        return false;
    }

    private function check_checkout( $condition, $type ) {
        if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_order_received_page() ) {
            return false;
        }

        return in_array( $condition['condition_type'], [ 'checkout_form', 'checkout_content' ], true )
            ? $condition['condition_type'] === $type
            : true;
    }
}
