<?php
/**
 * Royal Layout — Admin UI (WoodMart-style)
 * @package RoyalAddons\RoyalLayout
 */
namespace RoyalAddons\RoyalLayout;

if ( ! defined( 'ABSPATH' ) ) { exit; }

class Admin {
    private static $instance = null;
    private $cache;

    public static function instance() {
        if ( null === self::$instance ) { self::$instance = new self(); }
        return self::$instance;
    }

    public function __construct() {
        $this->cache = new Conditions_Cache();

        add_action( 'admin_enqueue_scripts',                   [ $this, 'enqueue_assets' ] );
        add_filter( 'manage_royal_layout_posts_columns',       [ $this, 'set_columns' ] );
        add_action( 'manage_royal_layout_posts_custom_column', [ $this, 'render_column' ], 10, 2 );
        add_filter( 'views_edit-royal_layout',                 [ $this, 'render_interface' ] );
        add_action( 'parse_query',                             [ $this, 'filter_by_type' ] );
        add_action( 'add_meta_boxes',                          [ $this, 'add_conditions_box' ], 10, 2 );

        // AJAX
        add_action( 'wp_ajax_royal_layout_create',          [ $this, 'ajax_create' ] );
        add_action( 'wp_ajax_royal_layout_toggle_status',   [ $this, 'ajax_toggle_status' ] );
        add_action( 'wp_ajax_royal_layout_save_conditions', [ $this, 'ajax_save_conditions' ] );
        add_action( 'wp_ajax_royal_layout_conditions_query',[ $this, 'ajax_conditions_query' ] );

        add_action( 'save_post_royal_layout', [ $this, 'on_save_post' ] );
        add_action( 'wp_trash_post',          [ $this, 'on_trash_post' ] );
        add_action( 'admin_head',             [ $this, 'hide_add_new' ] );
    }

    /* ── Types ──────────────────────────────────────────── */
    public function get_types() {
        $t = [];
        if ( function_exists( 'WC' ) ) {
            $t += [
                'single_product'           => 'Single product',
                'shop_archive'             => 'Products archive',
                'cart'                     => 'Cart',
                'empty_cart'               => 'Empty cart',
                'checkout_form'            => 'Checkout form',
                'checkout_content'         => 'Checkout top content',
                'thank_you_page'           => 'Thank you page',
                'my_account_page'          => 'My account',
                'my_account_auth'          => 'Login/Register',
                'my_account_lost_password' => 'Lost password',
            ];
        }
        $t['single_post']       = 'Single post';
        $t['blog_archive']      = 'Blog';
        $t['product_loop_item'] = 'Product loop item';
        return $t;
    }

    public static function get_conditioned_types() {
        return Conditions::get_conditioned_types();
    }

    /* ── Tabs ───────────────────────────────────────────── */
    private function get_tabs() {
        $tabs = [ 'all' => 'All' ];
        if ( function_exists( 'WC' ) ) {
            $tabs['single_product'] = 'Single product';
            $tabs['shop_archive']   = 'Products archive';
            $tabs['cart']           = 'Cart';
            $tabs['checkout']       = 'Checkout';
            $tabs['my_account']     = 'My account';
        }
        $tabs['post']         = 'Single post';
        $tabs['archive']      = 'Posts archive';
        $tabs['loop_item']    = 'Loop item';
        return $tabs;
    }

    private function tab_to_types( $tab ) {
        $map = [
            'checkout'   => [ 'checkout_form', 'checkout_content', 'thank_you_page' ],
            'my_account' => [ 'my_account_page', 'my_account_auth', 'my_account_lost_password' ],
            'cart'       => [ 'cart', 'empty_cart' ],
            'post'       => [ 'single_post' ],
            'archive'    => [ 'blog_archive' ],
            'loop_item'  => [ 'product_loop_item' ],
        ];
        return $map[ $tab ] ?? [ $tab ];
    }

    private function type_to_tab( $type ) {
        $map = [
            'checkout_form' => 'checkout', 'checkout_content' => 'checkout', 'thank_you_page' => 'checkout',
            'my_account_page' => 'my_account', 'my_account_auth' => 'my_account', 'my_account_lost_password' => 'my_account',
            'empty_cart' => 'cart', 'blog_archive' => 'archive', 'product_loop_item' => 'loop_item',
            'single_post' => 'post',
        ];
        return $map[ $type ] ?? $type;
    }

    /* ── Assets ─────────────────────────────────────────── */
    public function enqueue_assets( $hook ) {
        $screen = get_current_screen();
        if ( ! $screen || 'royal_layout' !== $screen->post_type ) return;

        wp_enqueue_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
        wp_enqueue_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'] );
        wp_enqueue_style( 'royal-layout-admin', ROYAL_LAYOUT_URL . 'assets/royal-layout-admin.css', [], filemtime( ROYAL_LAYOUT_DIR . 'assets/royal-layout-admin.css' ) );
        wp_enqueue_script( 'royal-layout-admin', ROYAL_LAYOUT_URL . 'assets/royal-layout-admin.js', [ 'jquery', 'select2' ], filemtime( ROYAL_LAYOUT_DIR . 'assets/royal-layout-admin.js' ), true );
        wp_localize_script( 'royal-layout-admin', 'RoyalLayoutAdmin', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'royal-layout-nonce' ),
            'types'    => $this->get_types(),
        ] );
    }

    public function hide_add_new() {
        $screen = get_current_screen();
        if ( ! $screen || 'edit-royal_layout' !== $screen->id ) return;
        echo '<style>.page-title-action{display:none!important}</style>';
    }

    /* ── Interface (tabs + create button + condition template) ── */
    public function render_interface( $views ) {
        $current = sanitize_text_field( $_GET['rl_type'] ?? 'all' );
        $base    = admin_url( 'edit.php?post_type=royal_layout' );
        $tabs    = $this->get_tabs();

        // Map sub-types back to parent tab
        $tab_map = [ 'checkout_form'=>'checkout','checkout_content'=>'checkout','thank_you_page'=>'checkout',
            'my_account_page'=>'my_account','my_account_auth'=>'my_account','my_account_lost_password'=>'my_account',
            'empty_cart'=>'cart','single_post'=>'post','blog_archive'=>'archive','product_loop_item'=>'loop_item' ];
        if ( isset( $tab_map[ $current ] ) ) $current = $tab_map[ $current ];

        // Create button
        echo '<div class="rl-top-bar">';
        echo '<a href="#" id="rl-add-layout-btn" class="button button-primary rl-create-btn">+ ' . esc_html__( 'Add layout', 'royal-addons-for-elementor' ) . '</a>';
        echo '</div>';

        // Tabs
        echo '<div class="rl-tabs-wrap">';
        foreach ( $tabs as $slug => $label ) {
            $url    = 'all' === $slug ? $base : add_query_arg( 'rl_type', $slug, $base );
            $active = $current === $slug ? ' class="current"' : '';
            echo '<a href="' . esc_url( $url ) . '"' . $active . '>' . esc_html( $label ) . '</a>';
        }
        echo '</div>';

        // Condition template (hidden, cloned by JS)
        $this->print_condition_template();

        return $views;
    }

    /* ── Condition Template (WoodMart-style) ─────────── */
    private function print_condition_template() {
        ?>
        <div class="rl-condition-template" style="display:none">
            <div class="rl-condition-row">
                <select class="rl-cond-comparison">
                    <option value="include">Include</option>
                    <option value="exclude">Exclude</option>
                </select>

                <!-- single_product conditions -->
                <select class="rl-cond-type" data-type="single_product">
                    <option value="all">All products</option>
                    <option value="product">Single product id</option>
                    <option value="product_cat">Product category</option>
                    <option value="product_cat_children">Child product categories</option>
                    <option value="product_tag">Product tag</option>
                    <?php if ( taxonomy_exists( 'product_brand' ) ) : ?>
                        <option value="product_brand">Product brand</option>
                    <?php endif; ?>
                    <option value="product_attr_term">Product attribute</option>
                    <option value="product_type">Product type</option>
                </select>

                <!-- shop_archive conditions -->
                <select class="rl-cond-type" data-type="shop_archive">
                    <option value="all">All product archives</option>
                    <option value="shop_page">Shop page</option>
                    <option value="product_search">Shop search results</option>
                    <option value="product_cats">Product categories</option>
                    <option value="product_tags">Product tags</option>
                    <option value="product_attr">Product attribute</option>
                    <option value="product_term">Product term (category, tag, attribute)</option>
                    <option value="product_cat_children">Child product categories</option>
                </select>

                <!-- single_post conditions -->
                <select class="rl-cond-type" data-type="single_post">
                    <option value="all">All posts</option>
                    <option value="post_id">Single post id</option>
                    <option value="post_cat">Post category</option>
                    <option value="post_tag">Post tag</option>
                    <option value="post_format">Post format</option>
                </select>

                <!-- blog_archive conditions -->
                <select class="rl-cond-type" data-type="blog_archive">
                    <option value="all">All blog archives</option>
                    <option value="blog_search_result">Blog search results</option>
                    <option value="blog_category">Blog categories</option>
                    <option value="blog_tag">Blog tags</option>
                    <option value="blog_author">Blog author page</option>
                    <option value="blog_date">Blog archives by date</option>
                </select>

                <!-- thank_you_page conditions -->
                <select class="rl-cond-type" data-type="thank_you_page">
                    <option value="all">All orders</option>
                    <option value="products">Product</option>
                    <option value="product_cat">Product category</option>
                    <option value="product_tag">Product tag</option>
                </select>

                <!-- my_account_page conditions -->
                <select class="rl-cond-type" data-type="my_account_page">
                    <option value="all">All endpoints</option>
                    <?php if ( function_exists( 'WC' ) ) :
                        $items = wc_get_account_menu_items();
                        unset( $items['customer-logout'] );
                        foreach ( $items as $ep => $label ) : ?>
                            <option value="<?php echo esc_attr( $ep ); ?>"><?php echo esc_html( $label ); ?></option>
                        <?php endforeach; endif; ?>
                </select>

                <select class="rl-cond-query" style="display:none" placeholder="Start typing..."></select>
                <a href="javascript:void(0);" class="rl-cond-remove button">&times;</a>
            </div>
        </div>
        <?php
    }

    /* ── Columns ────────────────────────────────────────── */
    public function set_columns( $cols ) {
        return [
            'cb'              => $cols['cb'],
            'title'           => 'Title',
            'rl_type'         => 'Type',
            'rl_conditions'   => 'Conditions',
            'rl_active'       => 'Active',
            'date'            => $cols['date'] ?? 'Date',
        ];
    }

    public function render_column( $col, $post_id ) {
        $types = $this->get_types();
        $type  = get_post_meta( $post_id, '_royal_layout_type', true );
        $conditioned = self::get_conditioned_types();

        if ( 'rl_type' === $col ) {
            $tab = $this->type_to_tab( $type );
            $url = admin_url( 'edit.php?post_type=royal_layout&rl_type=' . $tab );
            echo '<a href="' . esc_url( $url ) . '" class="rl-type-link">' . esc_html( $types[ $type ] ?? $type ) . '</a>';
        }

        if ( 'rl_conditions' === $col ) {
            if ( in_array( $type, $conditioned, true ) ) {
                $conditions = get_post_meta( $post_id, '_royal_layout_conditions', true );
                $summary    = $this->conditions_summary( $conditions );
                $json       = $conditions && is_array( $conditions ) ? wp_json_encode( $conditions ) : '[]';
                echo '<div class="rl-cond-wrap">';
                echo '<span class="rl-cond-text">' . esc_html( $summary ) . '</span>';
                echo '<button type="button" class="rl-edit-cond-btn button button-primary" data-id="' . esc_attr( $post_id ) . '" data-type="' . esc_attr( $type ) . '" data-conditions=\'' . $json . '\'>';
                echo '<span class="dashicons dashicons-edit"></span> Edit conditions</button>';
                echo '</div>';
            } else {
                echo '<span class="rl-cond-na">—</span>';
            }
        }

        if ( 'rl_active' === $col ) {
            if ( str_contains( $type, 'loop_item' ) ) { echo '—'; return; }
            $status = get_post_status( $post_id );
            $is_on  = 'publish' === $status;
            echo '<label class="rl-toggle"><input type="checkbox" class="rl-toggle-input" data-id="' . esc_attr( $post_id ) . '"' . checked( $is_on, true, false ) . '>';
            echo '<span class="rl-toggle-slider"><span class="rl-toggle-label">' . ( $is_on ? 'ON' : 'OFF' ) . '</span></span></label>';
        }
    }

    private function conditions_summary( $conditions ) {
        if ( empty( $conditions ) || ! is_array( $conditions ) ) return 'Not set';
        $labels = [];
        foreach ( $conditions as $c ) {
            $comp = ( $c['condition_comparison'] ?? 'include' ) === 'exclude' ? '✕ ' : '✓ ';
            $labels[] = $comp . ucwords( str_replace( '_', ' ', $c['condition_type'] ?? '' ) );
        }
        return implode( ', ', $labels );
    }

    /* ── Filter by type ────────────────────────────────── */
    public function filter_by_type( $query ) {
        global $pagenow, $typenow;
        if ( ! is_admin() || 'edit.php' !== $pagenow || 'royal_layout' !== $typenow ) return;
        if ( ! $query->is_main_query() || empty( $_GET['rl_type'] ) || 'all' === $_GET['rl_type'] ) return;

        $tab   = sanitize_text_field( $_GET['rl_type'] );
        $types = $this->tab_to_types( $tab );
        $query->set( 'meta_query', [ [ 'key' => '_royal_layout_type', 'value' => $types, 'compare' => 'IN' ] ] );
    }

    /* ── Conditions metabox ────────────────────────────── */
    public function add_conditions_box( $post_type, $post ) {
        if ( 'royal_layout' !== $post_type ) return;
        $type = get_post_meta( $post->ID, '_royal_layout_type', true );
        if ( ! in_array( $type, self::get_conditioned_types(), true ) ) return;

        add_meta_box( 'royal-layout-conditions', 'Layout Conditions', [ $this, 'conditions_box_callback' ], 'royal_layout' );
    }

    public function conditions_box_callback( $post ) {
        $conditions = get_post_meta( $post->ID, '_royal_layout_conditions', true );
        $type       = get_post_meta( $post->ID, '_royal_layout_type', true );
        $json       = $conditions && is_array( $conditions ) ? wp_json_encode( $conditions ) : '[]';

        echo '<div class="rl-metabox-conditions" data-type="' . esc_attr( $type ) . '" data-conditions=\'' . $json . '\' data-id="' . esc_attr( $post->ID ) . '">';
        echo '<div class="rl-metabox-condition-rows"></div>';
        echo '<a href="javascript:void(0);" class="rl-metabox-add-condition button">+ Add condition</a>';
        echo '<div style="margin-top:10px"><button type="button" class="button button-primary rl-metabox-save-conditions">Save conditions</button></div>';
        echo '</div>';
    }

    /* ── Cache ──────────────────────────────────────────── */
    public function on_save_post( $post_id ) {
        $this->cache->regenerate();
    }

    public function on_trash_post( $post_id ) {
        if ( 'royal_layout' === get_post_type( $post_id ) ) {
            $this->cache->remove( $post_id )->save();
        }
    }

    /* ── AJAX: Create ──────────────────────────────────── */
    public function ajax_create() {
        check_ajax_referer( 'royal-layout-nonce', 'nonce' );
        if ( ! current_user_can( 'edit_posts' ) ) wp_send_json_error();

        $type  = sanitize_text_field( $_POST['type'] ?? '' );
        $name  = sanitize_text_field( $_POST['name'] ?? '' );
        $data  = isset( $_POST['data'] ) ? $this->sanitize_conditions( $_POST['data'] ) : [];
        $types = $this->get_types();

        if ( ! $type ) wp_send_json_error( [ 'message' => 'Select a layout type.' ] );
        if ( ! $name ) $name = ( $types[ $type ] ?? 'Layout' ) . ' layout';

        $status = str_contains( $type, 'loop_item' ) ? 'publish' : 'draft';

        $id = wp_insert_post( [
            'post_title'  => $name,
            'post_type'   => 'royal_layout',
            'post_status' => $status,
            'meta_input'  => [
                '_royal_layout_type'       => $type,
                '_royal_layout_conditions' => $data,
            ],
        ] );

        if ( is_wp_error( $id ) ) wp_send_json_error( [ 'message' => $id->get_error_message() ] );

        $this->cache->regenerate();

        $url = add_query_arg( [ 'post' => $id, 'action' => 'elementor' ], admin_url( 'post.php' ) );
        wp_send_json_success( [ 'redirect_url' => $url ] );
    }

    /* ── AJAX: Toggle Status ───────────────────────────── */
    public function ajax_toggle_status() {
        check_ajax_referer( 'royal-layout-nonce', 'nonce' );
        if ( ! current_user_can( 'edit_posts' ) ) wp_send_json_error();

        $id     = absint( $_POST['id'] ?? 0 );
        $status = get_post_status( $id );
        $new    = 'publish' === $status ? 'draft' : 'publish';

        wp_update_post( [ 'ID' => $id, 'post_status' => $new ] );
        wp_send_json_success( [ 'status' => $new ] );
    }

    /* ── AJAX: Save Conditions ─────────────────────────── */
    public function ajax_save_conditions() {
        check_ajax_referer( 'royal-layout-nonce', 'nonce' );
        if ( ! current_user_can( 'edit_posts' ) ) wp_send_json_error();

        $id   = absint( $_POST['id'] ?? 0 );
        $data = isset( $_POST['data'] ) ? $this->sanitize_conditions( $_POST['data'] ) : [];

        update_post_meta( $id, '_royal_layout_conditions', $data );
        $this->cache->regenerate();

        wp_send_json_success( [ 'summary' => $this->conditions_summary( $data ) ] );
    }

    /* ── AJAX: Conditions Query (Select2 search) ─────── */
    public function ajax_conditions_query() {
        check_ajax_referer( 'royal-layout-nonce', 'nonce' );

        $query_type = sanitize_text_field( $_POST['query_type'] ?? '' );
        $search     = sanitize_text_field( $_POST['search'] ?? '' );
        $items      = [];

        switch ( $query_type ) {
            case 'product_cat':
            case 'product_cat_children':
            case 'product_tag':
            case 'product_term':
            case 'product_attr_term':
            case 'product_brand':
            case 'product_shipping_class':
                $taxonomy = [];
                if ( in_array( $query_type, [ 'product_cat', 'product_cat_children', 'product_term' ] ) ) $taxonomy[] = 'product_cat';
                if ( in_array( $query_type, [ 'product_tag', 'product_term' ] ) ) $taxonomy[] = 'product_tag';
                if ( in_array( $query_type, [ 'product_brand', 'product_term' ] ) && taxonomy_exists( 'product_brand' ) ) $taxonomy[] = 'product_brand';
                if ( in_array( $query_type, [ 'product_attr_term', 'product_term' ] ) ) {
                    foreach ( wc_get_attribute_taxonomies() as $tax ) {
                        if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
                            $taxonomy[] = wc_attribute_taxonomy_name( $tax->attribute_name );
                        }
                    }
                }
                if ( 'product_shipping_class' === $query_type ) $taxonomy[] = 'product_shipping_class';

                $terms = get_terms( [ 'hide_empty' => false, 'taxonomy' => $taxonomy, 'search' => $search ] );
                if ( ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $items[] = [ 'id' => $term->term_id, 'text' => $term->name . ' (ID: ' . $term->term_id . ')' ];
                    }
                }
                break;

            case 'product_attr':
                foreach ( wc_get_attribute_taxonomies() as $attr ) {
                    $items[] = [ 'id' => 'pa_' . $attr->attribute_name, 'text' => $attr->attribute_label ];
                }
                break;

            case 'product_type':
                foreach ( wc_get_product_types() as $t => $title ) {
                    $items[] = [ 'id' => $t, 'text' => $title ];
                }
                break;

            case 'product':
            case 'products':
                $posts = get_posts( [ 's' => $search, 'post_type' => 'product', 'posts_per_page' => 50 ] );
                foreach ( $posts as $p ) {
                    $items[] = [ 'id' => $p->ID, 'text' => $p->post_title . ' (ID: ' . $p->ID . ')' ];
                }
                break;

            case 'post_cat':
            case 'post_tag':
                $tax   = 'post_cat' === $query_type ? 'category' : 'post_tag';
                $terms = get_terms( [ 'hide_empty' => false, 'taxonomy' => $tax, 'search' => $search ] );
                if ( ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $items[] = [ 'id' => $term->term_id, 'text' => $term->name . ' (ID: ' . $term->term_id . ')' ];
                    }
                }
                break;

            case 'post_id':
                $posts = get_posts( [ 's' => $search, 'post_type' => 'post', 'posts_per_page' => 50 ] );
                foreach ( $posts as $p ) {
                    $items[] = [ 'id' => $p->ID, 'text' => $p->post_title . ' (ID: ' . $p->ID . ')' ];
                }
                break;

            case 'post_format':
                foreach ( get_post_format_strings() as $f => $l ) {
                    $items[] = [ 'id' => $f, 'text' => $l ];
                }
                break;

            case 'blog_category':
            case 'blog_tag':
                $tax   = 'blog_category' === $query_type ? 'category' : 'post_tag';
                $terms = get_terms( [ 'hide_empty' => false, 'taxonomy' => $tax, 'search' => $search ] );
                if ( ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $items[] = [ 'id' => $term->term_id, 'text' => $term->name ];
                    }
                }
                break;
        }

        wp_send_json( [ 'results' => $items ] );
    }

    private function sanitize_conditions( $data ) {
        if ( ! is_array( $data ) ) return [];
        $clean = [];
        foreach ( $data as $row ) {
            if ( empty( $row['condition_type'] ) ) continue;
            $clean[] = [
                'condition_comparison' => sanitize_text_field( $row['condition_comparison'] ?? 'include' ),
                'condition_type'       => sanitize_text_field( $row['condition_type'] ),
                'condition_query'      => sanitize_text_field( $row['condition_query'] ?? '' ),
            ];
        }
        return $clean;
    }
}
