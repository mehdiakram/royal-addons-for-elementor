<?php
/**
 * Royal Layout — Conditions Cache (WoodMart-style)
 *
 * @package RoyalAddons\RoyalLayout
 */

namespace RoyalAddons\RoyalLayout;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Conditions_Cache {

    private $option_name        = 'royal_layouts_conditions';
    private $post_type          = 'royal_layout';
    private $conditions_meta_key = '_royal_layout_conditions';
    private $type_meta_key       = '_royal_layout_type';
    private $conditions          = [];

    public function __construct() {
        $this->refresh();
    }

    public function add( $type, $conditions, $post_id ) {
        if ( $type ) {
            if ( ! isset( $this->conditions[ $type ] ) ) {
                $this->conditions[ $type ] = [];
            }
            $this->conditions[ $type ][ $post_id ] = $conditions;
        }
        return $this;
    }

    public function remove( $post_id ) {
        $post_id = absint( $post_id );
        foreach ( $this->conditions as $type => $templates ) {
            foreach ( $templates as $id => $template ) {
                if ( $post_id === $id ) {
                    unset( $this->conditions[ $type ][ $id ] );
                }
            }
        }
        return $this;
    }

    public function save() {
        return update_option( $this->option_name, $this->conditions );
    }

    public function refresh() {
        $this->conditions = get_option( $this->option_name, [] );
    }

    public function clear() {
        $this->conditions = [];
    }

    public function get( $type ) {
        return $this->conditions[ $type ] ?? [];
    }

    public function get_all() {
        return $this->conditions;
    }

    public function regenerate() {
        $this->clear();

        $query = new \WP_Query( [
            'posts_per_page'   => -1,
            'post_type'        => $this->post_type,
            'post_status'      => [ 'publish', 'draft' ],
            'fields'           => 'ids',
            'meta_key'         => $this->type_meta_key,
            'suppress_filters' => true,
        ] );

        foreach ( $query->posts as $post_id ) {
            $conditions = get_post_meta( $post_id, $this->conditions_meta_key, true );
            $type       = get_post_meta( $post_id, $this->type_meta_key, true );
            $this->add( $type, $conditions ? $conditions : [], $post_id );
        }

        $this->save();
        return $this;
    }
}
