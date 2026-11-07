<?php

namespace RoyalAddons\Snippet;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Enhanced Royal Snippet Loader with Modern UI and Display Conditions
 */
class Royal_Snippet_Loader {

    public function __construct() {
        $this->init_components();
        $this->setup_hooks();
    }

    /**
     * Initialize all components
     */
    private function init_components() {
        // Load enhanced classes
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-snippet/class-cpt-manager.php';
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/royal-snippet/class-snippet-output.php';

        // Initialize components
        new Royal_Snippet_CPT_Manager();
        new Royal_Snippet_Output();
    }

    /**
     * Setup additional hooks
     */
    private function setup_hooks() {
        // Add custom admin columns
        add_filter( 'manage_royal_snippet_posts_columns', array( $this, 'add_custom_columns' ) );
        add_action( 'manage_royal_snippet_posts_custom_column', array( $this, 'populate_custom_columns' ), 10, 2 );
        
        // Add custom admin styles for list table
        add_action( 'admin_head', array( $this, 'add_list_table_styles' ) );
        
        // Add bulk actions
        add_filter( 'bulk_actions-edit-royal_snippet', array( $this, 'add_bulk_actions' ) );
        add_filter( 'handle_bulk_actions-edit-royal_snippet', array( $this, 'handle_bulk_actions' ), 10, 3 );
        
        // Add row actions
        add_filter( 'post_row_actions', array( $this, 'add_row_actions' ), 10, 2 );
        
        // Add admin notices
        add_action( 'admin_notices', array( $this, 'show_admin_notices' ) );
        
        // Add dashboard widget
        // add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ) );
    }

    /**
     * Add custom columns to the snippets list table
     */
    public function add_custom_columns( $columns ) {
        $new_columns = array();
        
        // Keep checkbox and title
        $new_columns['cb'] = $columns['cb'];
        $new_columns['title'] = $columns['title'];
        
        // Add custom columns
        $new_columns['royal_snippet_status'] = esc_html__( 'Status', 'royal-addons-for-elementor' );
        $new_columns['royal_snippet_location'] = esc_html__( 'Location', 'royal-addons-for-elementor' );
        $new_columns['royal_snippet_priority'] = esc_html__( 'Priority', 'royal-addons-for-elementor' );
        $new_columns['royal_snippet_conditions'] = esc_html__( 'Conditions', 'royal-addons-for-elementor' );
        $new_columns['royal_snippet_code_preview'] = esc_html__( 'Code Preview', 'royal-addons-for-elementor' );
        
        // Keep date
        $new_columns['date'] = $columns['date'];
        
        return $new_columns;
    }

    /**
     * Populate custom columns
     */
    public function populate_custom_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'royal_snippet_status':
                $status = get_post_status( $post_id );
                $status_class = $status === 'publish' ? 'royal-status-active' : 'royal-status-inactive';
                $status_text = $status === 'publish' ? esc_html__( 'Active', 'royal-addons-for-elementor' ) : esc_html__( 'Inactive', 'royal-addons-for-elementor' );
                echo '<span class="royal-snippet-status ' . esc_attr( $status_class ) . '">' . esc_html( $status_text ) . '</span>';
                break;

            case 'royal_snippet_location':
                $location = get_post_meta( $post_id, '_royal_snippet_location', true );
                $location_labels = array(
                    'head' => esc_html__( 'Head', 'royal-addons-for-elementor' ),
                    'body_start' => esc_html__( 'Body Start', 'royal-addons-for-elementor' ),
                    'body_end' => esc_html__( 'Body End', 'royal-addons-for-elementor' ),
                );
                $location_text = isset( $location_labels[ $location ] ) ? $location_labels[ $location ] : esc_html__( 'Not Set', 'royal-addons-for-elementor' );
                echo '<span class="royal-snippet-location">' . esc_html( $location_text ) . '</span>';
                break;

            case 'royal_snippet_priority':
                $priority = get_post_meta( $post_id, '_royal_snippet_priority', true );
                echo '<span class="royal-snippet-priority">' . esc_html( $priority ?: '10' ) . '</span>';
                break;

            case 'royal_snippet_conditions':
                $conditions = get_post_meta( $post_id, '_royal_snippet_conditions', true );
                if ( empty( $conditions ) ) {
                    echo '<span class="royal-conditions-summary royal-conditions-all">' . esc_html__( 'Entire Site', 'royal-addons-for-elementor' ) . '</span>';
                } else {
                    $summary = $this->get_conditions_summary( $conditions );
                    echo '<span class="royal-conditions-summary">' . esc_html( $summary ) . '</span>';
                }
                break;

            case 'royal_snippet_code_preview':
                $content = get_post_meta( $post_id, '_royal_snippet_content', true );
                if ( ! empty( $content ) ) {
                    $preview = wp_trim_words( strip_tags( $content ), 10, '...' );
                    echo '<code class="royal-code-preview" title="' . esc_attr( $content ) . '">' . esc_html( $preview ) . '</code>';
                } else {
                    echo '<span class="royal-no-code">' . esc_html__( 'No code', 'royal-addons-for-elementor' ) . '</span>';
                }
                break;
        }
    }

    /**
     * Get conditions summary for display
     */
    private function get_conditions_summary( $conditions ) {
        if ( empty( $conditions ) ) {
            return esc_html__( 'Entire site', 'royal-addons-for-elementor' );
        }
        
        $summary_parts = array();
        foreach ( $conditions as $condition ) {
            $rule_label = $this->get_condition_rule_label( $condition['rule'] );
            $summary_parts[] = $condition['type'] === 'exclude' ? 'Exclude ' . $rule_label : $rule_label;
        }
        
        return implode( ', ', array_slice( $summary_parts, 0, 2 ) ) . ( count( $summary_parts ) > 2 ? '...' : '' );
    }

    /**
     * Get human-readable label for condition rule
     */
    private function get_condition_rule_label( $rule ) {
        $labels = array(
            'entire_site' => esc_html__( 'Entire site', 'royal-addons-for-elementor' ),
            'front_page' => esc_html__( 'Front page', 'royal-addons-for-elementor' ),
            'singular' => esc_html__( 'Singular', 'royal-addons-for-elementor' ),
            'all_singular' => esc_html__( 'All singular', 'royal-addons-for-elementor' ),
            'post' => esc_html__( 'Posts', 'royal-addons-for-elementor' ),
            'page' => esc_html__( 'Pages', 'royal-addons-for-elementor' ),
            'category' => esc_html__( 'Categories', 'royal-addons-for-elementor' ),
            'tag' => esc_html__( 'Tags', 'royal-addons-for-elementor' ),
        );
        
        return isset( $labels[ $rule ] ) ? $labels[ $rule ] : $rule;
    }

    /**
     * Add custom styles for list table
     */
    public function add_list_table_styles() {
        $screen = get_current_screen();
        if ( $screen && $screen->post_type === 'royal_snippet' ) {
            ?>
            <style>
                .royal-snippet-status {
                    padding: 4px 8px;
                    border-radius: 12px;
                    font-size: 11px;
                    font-weight: 600;
                    text-transform: uppercase;
                }
                .royal-status-active {
                    background: #d4edda;
                    color: #155724;
                }
                .royal-status-inactive {
                    background: #f8d7da;
                    color: #721c24;
                }
                .royal-snippet-location {
                    background: #e3f2fd;
                    color: #1565c0;
                    padding: 2px 6px;
                    border-radius: 4px;
                    font-size: 11px;
                    font-weight: 500;
                }
                .royal-snippet-priority {
                    background: #fff3e0;
                    color: #e65100;
                    padding: 2px 6px;
                    border-radius: 4px;
                    font-size: 11px;
                    font-weight: 600;
                }
                .royal-conditions-summary {
                    font-size: 12px;
                    color: #666;
                }
                .royal-conditions-all {
                    color: #28a745;
                    font-weight: 500;
                }
                .royal-code-preview {
                    background: #f8f9fa;
                    padding: 2px 4px;
                    border-radius: 3px;
                    font-size: 11px;
                    max-width: 200px;
                    display: inline-block;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }
                .royal-no-code {
                    color: #999;
                    font-style: italic;
                    font-size: 12px;
                }
                .column-royal_snippet_status { width: 80px; }
                .column-royal_snippet_location { width: 100px; }
                .column-royal_snippet_priority { width: 70px; }
                .column-royal_snippet_conditions { width: 150px; }
                .column-royal_snippet_code_preview { width: 200px; }
            </style>
            <?php
        }
    }

    /**
     * Add bulk actions
     */
    public function add_bulk_actions( $actions ) {
        $actions['royal_activate'] = esc_html__( 'Activate Snippets', 'royal-addons-for-elementor' );
        $actions['royal_deactivate'] = esc_html__( 'Deactivate Snippets', 'royal-addons-for-elementor' );
        $actions['royal_duplicate'] = esc_html__( 'Duplicate Snippets', 'royal-addons-for-elementor' );
        return $actions;
    }

    /**
     * Handle bulk actions
     */
    public function handle_bulk_actions( $redirect_to, $action, $post_ids ) {
        if ( ! in_array( $action, array( 'royal_activate', 'royal_deactivate', 'royal_duplicate' ) ) ) {
            return $redirect_to;
        }

        $count = 0;
        foreach ( $post_ids as $post_id ) {
            switch ( $action ) {
                case 'royal_activate':
                    wp_update_post( array( 'ID' => $post_id, 'post_status' => 'publish' ) );
                    $count++;
                    break;

                case 'royal_deactivate':
                    wp_update_post( array( 'ID' => $post_id, 'post_status' => 'draft' ) );
                    $count++;
                    break;

                case 'royal_duplicate':
                    $this->duplicate_snippet( $post_id );
                    $count++;
                    break;
            }
        }

        $redirect_to = add_query_arg( array(
            'royal_action' => $action,
            'royal_count' => $count
        ), $redirect_to );

        return $redirect_to;
    }

    /**
     * Duplicate a snippet
     */
    private function duplicate_snippet( $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post ) {
            return false;
        }

        $new_post = array(
            'post_title' => $post->post_title . ' (Copy)',
            'post_content' => $post->post_content,
            'post_status' => 'draft',
            'post_type' => 'royal_snippet',
            'post_author' => get_current_user_id(),
        );

        $new_post_id = wp_insert_post( $new_post );
        if ( $new_post_id ) {
            // Copy meta data
            $meta_keys = array( '_royal_snippet_content', '_royal_snippet_location', '_royal_snippet_priority', '_royal_snippet_conditions' );
            foreach ( $meta_keys as $meta_key ) {
                $meta_value = get_post_meta( $post_id, $meta_key, true );
                if ( $meta_value ) {
                    update_post_meta( $new_post_id, $meta_key, $meta_value );
                }
            }
        }

        return $new_post_id;
    }

    /**
     * Add row actions
     */
    public function add_row_actions( $actions, $post ) {
        if ( $post->post_type === 'royal_snippet' ) {
            $actions['royal_duplicate'] = '<a href="' . wp_nonce_url( admin_url( 'admin-post.php?action=royal_duplicate_snippet&post=' . $post->ID ), 'royal_duplicate_' . $post->ID ) . '">' . esc_html__( 'Duplicate', 'royal-addons-for-elementor' ) . '</a>';
            
            if ( $post->post_status === 'publish' ) {
                $actions['royal_deactivate'] = '<a href="' . wp_nonce_url( admin_url( 'admin-post.php?action=royal_toggle_snippet&post=' . $post->ID . '&status=draft' ), 'royal_toggle_' . $post->ID ) . '">' . esc_html__( 'Deactivate', 'royal-addons-for-elementor' ) . '</a>';
            } else {
                $actions['royal_activate'] = '<a href="' . wp_nonce_url( admin_url( 'admin-post.php?action=royal_toggle_snippet&post=' . $post->ID . '&status=publish' ), 'royal_toggle_' . $post->ID ) . '">' . esc_html__( 'Activate', 'royal-addons-for-elementor' ) . '</a>';
            }
        }
        return $actions;
    }

    /**
     * Show admin notices
     */
    public function show_admin_notices() {
        if ( isset( $_GET['royal_action'] ) && isset( $_GET['royal_count'] ) ) {
            $action = sanitize_text_field( $_GET['royal_action'] );
            $count = intval( $_GET['royal_count'] );
            
            $messages = array(
                'royal_activate' => sprintf( _n( '%d snippet activated.', '%d snippets activated.', $count, 'royal-addons-for-elementor' ), $count ),
                'royal_deactivate' => sprintf( _n( '%d snippet deactivated.', '%d snippets deactivated.', $count, 'royal-addons-for-elementor' ), $count ),
                'royal_duplicate' => sprintf( _n( '%d snippet duplicated.', '%d snippets duplicated.', $count, 'royal-addons-for-elementor' ), $count ),
            );
            
            if ( isset( $messages[ $action ] ) ) {
                echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $messages[ $action ] ) . '</p></div>';
            }
        }
    }

    /**
     * Add dashboard widget
     */
    public function add_dashboard_widget() {
        if ( current_user_can( 'manage_options' ) ) {
            wp_add_dashboard_widget(
                'royal_snippets_dashboard',
                esc_html__( 'Royal Code Snippets', 'royal-addons-for-elementor' ),
                array( $this, 'render_dashboard_widget' )
            );
        }
    }

    /**
     * Render dashboard widget
     */
    public function render_dashboard_widget() {
        $total_snippets = wp_count_posts( 'royal_snippet' );
        $active_snippets = $total_snippets->publish ?? 0;
        $inactive_snippets = $total_snippets->draft ?? 0;
        
        ?>
        <div class="royal-dashboard-widget">
            <div class="royal-dashboard-stats">
                <div class="royal-stat-item">
                    <span class="royal-stat-number"><?php echo esc_html( $active_snippets ); ?></span>
                    <span class="royal-stat-label"><?php esc_html_e( 'Active Snippets', 'royal-addons-for-elementor' ); ?></span>
                </div>
                <div class="royal-stat-item">
                    <span class="royal-stat-number"><?php echo esc_html( $inactive_snippets ); ?></span>
                    <span class="royal-stat-label"><?php esc_html_e( 'Inactive Snippets', 'royal-addons-for-elementor' ); ?></span>
                </div>
            </div>
            <div class="royal-dashboard-actions">
                <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=royal_snippet' ) ); ?>" class="button button-primary">
                    <?php esc_html_e( 'Add New Snippet', 'royal-addons-for-elementor' ); ?>
                </a>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=royal_snippet' ) ); ?>" class="button">
                    <?php esc_html_e( 'Manage Snippets', 'royal-addons-for-elementor' ); ?>
                </a>
            </div>
        </div>
        <style>
            .royal-dashboard-widget {
                padding: 10px 0;
            }
            .royal-dashboard-stats {
                display: flex;
                gap: 20px;
                margin-bottom: 15px;
            }
            .royal-stat-item {
                text-align: center;
                flex: 1;
            }
            .royal-stat-number {
                display: block;
                font-size: 24px;
                font-weight: 600;
                color: #0073aa;
            }
            .royal-stat-label {
                display: block;
                font-size: 12px;
                color: #666;
                margin-top: 5px;
            }
            .royal-dashboard-actions {
                display: flex;
                gap: 10px;
            }
            .royal-dashboard-actions .button {
                flex: 1;
                text-align: center;
            }
        </style>
        <?php
    }
}

// Initialize the enhanced loader
new Royal_Snippet_Loader();