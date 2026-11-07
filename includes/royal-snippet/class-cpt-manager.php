<?php

namespace RoyalAddons\Snippet;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Enhanced Royal Snippet Custom Post Type Manager with Modern UI
 */
class Royal_Snippet_CPT_Manager {

    public function __construct() {
        add_action( 'init', array( $this, 'register_royal_snippet_cpt' ), 0 );
        add_action( 'add_meta_boxes', array( $this, 'add_snippet_meta_boxes' ) );
        add_action( 'save_post_royal_snippet', array( $this, 'save_snippet_meta_data' ) );
        add_action( 'admin_menu', array( $this, 'add_custom_code_submenu' ), 250 );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'wp_ajax_royal_snippet_save_conditions', array( $this, 'handle_save_conditions' ) );
    }

    /**
     * Register the 'royal_snippet' Custom Post Type.
     */
    public function register_royal_snippet_cpt() {
        $labels = array(
            'name'                  => esc_html_x( 'Custom Codes', 'royal-addons-for-elementor' ),
            'singular_name'         => esc_html_x( 'Custom Code', 'royal-addons-for-elementor' ),
            'menu_name'             => esc_html__( 'Custom Codes', 'royal-addons-for-elementor' ),
            'name_admin_bar'        => esc_html__( 'Custom Code', 'royal-addons-for-elementor' ),
            'archives'              => esc_html__( 'Snippet Archives', 'royal-addons-for-elementor' ),
            'attributes'            => esc_html__( 'Snippet Attributes', 'royal-addons-for-elementor' ),
            'parent_item_colon'     => esc_html__( 'Parent Snippet:', 'royal-addons-for-elementor' ),
            'all_items'             => esc_html__( 'All Custom Codes', 'royal-addons-for-elementor' ),
            'add_new_item'          => esc_html__( 'Add New Custom Code', 'royal-addons-for-elementor' ),
            'add_new'               => esc_html__( 'Add New', 'royal-addons-for-elementor' ),
            'new_item'              => esc_html__( 'New Custom Code', 'royal-addons-for-elementor' ),
            'edit_item'             => esc_html__( 'Edit Custom Code', 'royal-addons-for-elementor' ),
            'update_item'           => esc_html__( 'Update Custom Code', 'royal-addons-for-elementor' ),
            'view_item'             => esc_html__( 'View Custom Code', 'royal-addons-for-elementor' ),
            'view_items'            => esc_html__( 'View Custom Codes', 'royal-addons-for-elementor' ),
            'search_items'          => esc_html__( 'Search Custom Codes', 'royal-addons-for-elementor' ),
            'not_found'             => esc_html__( 'No Custom Codes found', 'royal-addons-for-elementor' ),
            'not_found_in_trash'    => esc_html__( 'No Custom Codes found in Trash', 'royal-addons-for-elementor' ),
            'featured_image'        => esc_html__( 'Featured Image', 'royal-addons-for-elementor' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'royal-addons-for-elementor' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'royal-addons-for-elementor' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'royal-addons-for-elementor' ),
            'insert_into_item'      => esc_html__( 'Insert into snippet', 'royal-addons-for-elementor' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this snippet', 'royal-addons-for-elementor' ),
            'items_list'            => esc_html__( 'Custom Codes list', 'royal-addons-for-elementor' ),
            'items_list_navigation' => esc_html__( 'Custom Codes list navigation', 'royal-addons-for-elementor' ),
            'filter_items_list'     => esc_html__( 'Filter Custom Codes list', 'royal-addons-for-elementor' ),
        );
        
        $args = array(
            'label'                 => esc_html__( 'Custom Code', 'royal-addons-for-elementor' ),
            'description'           => esc_html__( 'Custom Post Type for Royal Addons Custom Codes', 'royal-addons-for-elementor' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'revisions' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => false,
            'rewrite'               => false,
            'capability_type'       => 'post',
            'show_in_rest'          => false,
        );
        
        register_post_type( 'royal_snippet', $args );
    }

    /**
     * Enqueue admin assets for modern UI
     */
    public function enqueue_admin_assets( $hook ) {
        global $post_type;
        
        if ( 'royal_snippet' !== $post_type ) {
            return;
        }

        // Enqueue CodeMirror
        wp_enqueue_script( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js', array(), '5.65.2', true );
        wp_enqueue_script( 'codemirror-mode-xml', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/xml/xml.min.js', array( 'codemirror' ), '5.65.2', true );
        wp_enqueue_script( 'codemirror-mode-javascript', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js', array( 'codemirror' ), '5.65.2', true );
        wp_enqueue_script( 'codemirror-mode-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/css/css.min.js', array( 'codemirror' ), '5.65.2', true );
        wp_enqueue_script( 'codemirror-mode-htmlmixed', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/htmlmixed/htmlmixed.min.js', array( 'codemirror', 'codemirror-mode-xml', 'codemirror-mode-javascript', 'codemirror-mode-css' ), '5.65.2', true );
        wp_enqueue_script( 'codemirror-mode-php', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/php/php.min.js', array( 'codemirror', 'codemirror-mode-xml', 'codemirror-mode-javascript', 'codemirror-mode-css', 'codemirror-mode-htmlmixed' ), '5.65.2', true );

        
        wp_enqueue_style( 'codemirror', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css', array(), '5.65.2' );
        wp_enqueue_style( 'codemirror-theme-monokai', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css', array( 'codemirror' ), '5.65.2' );

        // Custom admin styles and scripts
        wp_enqueue_style( 'royal-snippet-admin', ROYAL_ADDONS_DIR_URL . 'assets/css/snippet-admin.css', array(), ROYAL_ADDONS_VERSION );
        wp_enqueue_script( 'royal-snippet-admin', ROYAL_ADDONS_DIR_URL . 'assets/js/snippet-admin.js', array( 'jquery', 'codemirror' ), ROYAL_ADDONS_VERSION, true );
        
        wp_localize_script( 'royal-snippet-admin', 'royalSnippetAdmin', array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'nonce'     => wp_create_nonce( 'royal_snippet_nonce' ),
            'isAdmin'   => current_user_can( 'administrator' ) ? 'yes' : 'no',
            'strings'   => array(
                'generating'  => esc_html__( 'Generating...', 'royal-addons-for-elementor' ),
                'error'       => esc_html__( 'Error occurred', 'royal-addons-for-elementor' ),
                'success'     => esc_html__( 'Generated successfully', 'royal-addons-for-elementor' ),
                'php_warning' => esc_html__( 'PHP কোড সরাসরি execute হয়। শুধুমাত্র বিশ্বস্ত কোড লিখুন।', 'royal-addons-for-elementor' ),
            )
        ) );
    }

    /**
     * Add custom meta boxes for snippet settings and conditions
     */
    public function add_snippet_meta_boxes() {
        // Remove default editor
        remove_post_type_support( 'royal_snippet', 'editor' );
        
        add_meta_box(
            'royal_snippet_editor',
            esc_html__( 'Code Editor', 'royal-addons-for-elementor' ),
            array( $this, 'render_code_editor_meta_box' ),
            'royal_snippet',
            'normal',
            'high'
        );

        add_meta_box(
            'royal_snippet_settings',
            esc_html__( 'Snippet Settings', 'royal-addons-for-elementor' ),
            array( $this, 'render_snippet_settings_meta_box' ),
            'royal_snippet',
            'side',
            'high'
        );

        add_meta_box(
            'royal_snippet_conditions',
            esc_html__( 'Display Conditions', 'royal-addons-for-elementor' ),
            array( $this, 'render_conditions_meta_box' ),
            'royal_snippet',
            'side',
            'default'
        );
    }

    /**
     * Render the modern code editor meta box
     */
    public function render_code_editor_meta_box( $post ) {
        wp_nonce_field( 'royal_snippet_save_meta_data', 'royal_snippet_meta_nonce' );
        
        $content   = get_post_meta( $post->ID, '_royal_snippet_content', true );
        $location  = get_post_meta( $post->ID, '_royal_snippet_location', true );
        $priority  = get_post_meta( $post->ID, '_royal_snippet_priority', true );
        $code_type = get_post_meta( $post->ID, '_royal_snippet_code_type', true );
        
        if ( empty( $location ) ) {
            $location = 'head';
        }
        if ( empty( $priority ) ) {
            $priority = 10;
        }
        if ( empty( $code_type ) ) {
            $code_type = 'html';
        }

        $is_admin = current_user_can( 'administrator' );
        ?>
        <div class="royal-snippet-editor-container">
            <div class="royal-snippet-header">
                <div class="royal-snippet-description">
                    <p><?php esc_html_e( 'Manage and create all of your custom code here.', 'royal-addons-for-elementor' ); ?></p>
                    <p><?php esc_html_e( 'Supports HTML, CSS, JavaScript, and PHP code.', 'royal-addons-for-elementor' ); ?> 
                    <a href="https://www.royaltechbd.com/royalcustomcode" class="royal-learn-more" target="_blank"><?php esc_html_e( 'Learn more', 'royal-addons-for-elementor' ); ?></a></p>
                </div>
            </div>

            <!-- PHP Warning Banner (hidden by default) -->
            <div id="royal-php-warning" class="royal-php-warning" style="display: <?php echo $code_type === 'php' ? 'flex' : 'none'; ?>;">
                <span class="royal-php-warning-icon">⚠️</span>
                <div>
                    <strong><?php esc_html_e( 'PHP Mode Active', 'royal-addons-for-elementor' ); ?></strong>
                    <p><?php esc_html_e( 'PHP কোড সরাসরি server-এ execute হয়। <?php লেখার দরকার নেই — শুধু pure PHP code লিখুন। শুধুমাত্র বিশ্বস্ত কোড যোগ করুন।', 'royal-addons-for-elementor' ); ?></p>
                </div>
            </div>

            <div class="royal-snippet-controls">
                <!-- Code Type Dropdown -->
                <div class="royal-snippet-control-group">
                    <label for="royal_snippet_code_type">
                        <span class="royal-control-icon">🧩</span>
                        <?php esc_html_e( 'Code Type:', 'royal-addons-for-elementor' ); ?>
                    </label>
                    <select name="royal_snippet_code_type" id="royal_snippet_code_type" class="royal-select royal-code-type-select">
                        <option value="html"       <?php selected( $code_type, 'html' ); ?>>📄 HTML</option>
                        <option value="css"        <?php selected( $code_type, 'css' ); ?>>🎨 CSS</option>
                        <option value="javascript" <?php selected( $code_type, 'javascript' ); ?>>⚡ JavaScript</option>
                        <?php if ( $is_admin ) : ?>
                        <option value="php"        <?php selected( $code_type, 'php' ); ?>>🐘 PHP</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Location (hidden for PHP) -->
                <div class="royal-snippet-control-group" id="royal-location-group" style="display: <?php echo $code_type === 'php' ? 'none' : 'flex'; ?>;">
                    <label for="royal_snippet_location">
                        <span class="royal-control-icon">📍</span>
                        <?php esc_html_e( 'Location:', 'royal-addons-for-elementor' ); ?>
                    </label>
                    <select name="royal_snippet_location" id="royal_snippet_location" class="royal-select">
                        <option value="head"       <?php selected( $location, 'head' ); ?>><?php esc_html_e( '<head>', 'royal-addons-for-elementor' ); ?></option>
                        <option value="body_start" <?php selected( $location, 'body_start' ); ?>><?php esc_html_e( '<body> - Start', 'royal-addons-for-elementor' ); ?></option>
                        <option value="body_end"   <?php selected( $location, 'body_end' ); ?>><?php esc_html_e( '</body> - End', 'royal-addons-for-elementor' ); ?></option>
                        <option value="admin_head" <?php selected( $location, 'admin_head' ); ?>><?php esc_html_e( 'Admin Head', 'royal-addons-for-elementor' ); ?></option>
                        <option value="admin_footer" <?php selected( $location, 'admin_footer' ); ?>><?php esc_html_e( 'Admin Footer', 'royal-addons-for-elementor' ); ?></option>
                    </select>
                </div>

                <!-- Priority -->
                <div class="royal-snippet-control-group">
                    <label for="royal_snippet_priority">
                        <span class="royal-control-icon">🔢</span>
                        <?php esc_html_e( 'Priority:', 'royal-addons-for-elementor' ); ?>
                    </label>
                    <input type="number" name="royal_snippet_priority" id="royal_snippet_priority" 
                           value="<?php echo esc_attr( $priority ); ?>" min="1" max="999" class="royal-number-input" />
                </div>

                <!-- Auto-wrap Info Badge -->
                <div class="royal-autowrap-badge" id="royal-autowrap-badge">
                    <span class="royal-autowrap-icon">✨</span>
                    <span id="royal-autowrap-text"><?php echo esc_html( $this->get_autowrap_hint( $code_type ) ); ?></span>
                </div>
            </div>
            
            <div class="royal-code-editor-wrapper">
                <textarea id="royal_snippet_content" name="royal_snippet_content" class="royal-code-editor"><?php echo esc_textarea( $content ); ?></textarea>
            </div>
        </div>
        <?php
    }

    /**
     * Return auto-wrap hint text based on code type
     */
    private function get_autowrap_hint( $code_type ) {
        $hints = array(
            'html'       => 'HTML সরাসরি output হবে',
            'css'        => 'স্বয়ংক্রিয়ভাবে <style> tag-এ wrap হবে',
            'javascript' => 'স্বয়ংক্রিয়ভাবে <script> tag-এ wrap হবে',
            'php'        => 'PHP সরাসরি server-এ execute হবে',
        );
        return isset( $hints[ $code_type ] ) ? $hints[ $code_type ] : '';
    }

    /**
     * Render the snippet settings meta box
     */
    public function render_snippet_settings_meta_box( $post ) {
        $status = get_post_status( $post->ID );
        $conditions = get_post_meta( $post->ID, '_royal_snippet_conditions', true );
        $conditions_summary = $this->get_conditions_summary( $conditions );
        ?>
        <div class="royal-snippet-settings">
            <div class="royal-setting-item">
                <span class="royal-setting-icon">📊</span>
                <strong><?php esc_html_e( 'Status:', 'royal-addons-for-elementor' ); ?></strong>
                <span class="royal-status <?php echo esc_attr( $status ); ?>"><?php echo esc_html( ucfirst( $status ) ); ?></span>
                <a href="#" class="royal-edit-link"><?php esc_html_e( 'Edit', 'royal-addons-for-elementor' ); ?></a>
            </div>
            
            <div class="royal-setting-item">
                <span class="royal-setting-icon">📅</span>
                <strong><?php esc_html_e( 'Published on:', 'royal-addons-for-elementor' ); ?></strong>
                <span><?php echo get_the_date( 'M j, Y \a\t H:i', $post ); ?></span>
                <a href="#" class="royal-edit-link"><?php esc_html_e( 'Edit', 'royal-addons-for-elementor' ); ?></a>
            </div>
            
            <div class="royal-setting-item">
                <span class="royal-setting-icon">🎯</span>
                <strong><?php esc_html_e( 'Conditions:', 'royal-addons-for-elementor' ); ?></strong>
                <span><?php echo esc_html( $conditions_summary ); ?></span>
                <a href="#" class="royal-edit-conditions"><?php esc_html_e( 'Edit', 'royal-addons-for-elementor' ); ?></a>
            </div>
        </div>
        <?php
    }

    /**
     * Render the display conditions meta box
     */
    public function render_conditions_meta_box( $post ) {
        $conditions = get_post_meta( $post->ID, '_royal_snippet_conditions', true );
        if ( empty( $conditions ) ) {
            $conditions = array();
        }
        ?>
        <div class="royal-conditions-container">
            <div class="royal-conditions-description">
                <p><?php esc_html_e( 'Set the conditions that determine where your Custom Code will be displayed.', 'royal-addons-for-elementor' ); ?></p>
                <p><?php esc_html_e( 'For example, choose \'Entire Site\' to display the snippet on all pages.', 'royal-addons-for-elementor' ); ?></p>
            </div>
            
            <div id="royal-conditions-list">
                <?php if ( empty( $conditions ) ): ?>
                    <div class="royal-condition-item" data-index="0">
                        <div class="royal-condition-controls">
                            <select name="royal_conditions[0][type]" class="royal-condition-type">
                                <option value="include"><?php esc_html_e( 'Include', 'royal-addons-for-elementor' ); ?></option>
                                <option value="exclude"><?php esc_html_e( 'Exclude', 'royal-addons-for-elementor' ); ?></option>
                            </select>
                            
                            <select name="royal_conditions[0][rule]" class="royal-condition-rule">
                                <option value="entire_site"><?php esc_html_e( 'Entire Site', 'royal-addons-for-elementor' ); ?></option>
                                <option value="front_page"><?php esc_html_e( 'Front Page', 'royal-addons-for-elementor' ); ?></option>
                                <option value="singular"><?php esc_html_e( 'Singular', 'royal-addons-for-elementor' ); ?></option>
                                <option value="all_singular"><?php esc_html_e( 'All Singular', 'royal-addons-for-elementor' ); ?></option>
                                <option value="post"><?php esc_html_e( 'Post', 'royal-addons-for-elementor' ); ?></option>
                                <option value="page"><?php esc_html_e( 'Page', 'royal-addons-for-elementor' ); ?></option>
                                <option value="category"><?php esc_html_e( 'Category', 'royal-addons-for-elementor' ); ?></option>
                                <option value="tag"><?php esc_html_e( 'Tag', 'royal-addons-for-elementor' ); ?></option>
                            </select>
                            
                            <select name="royal_conditions[0][value]" class="royal-condition-value" style="display: none;">
                                <option value=""><?php esc_html_e( 'Select...', 'royal-addons-for-elementor' ); ?></option>
                            </select>
                            
                            <button type="button" class="royal-remove-condition" style="display: none;">×</button>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ( $conditions as $index => $condition ): ?>
                        <div class="royal-condition-item" data-index="<?php echo esc_attr( $index ); ?>">
                            <div class="royal-condition-controls">
                                <select name="royal_conditions[<?php echo esc_attr( $index ); ?>][type]" class="royal-condition-type">
                                    <option value="include" <?php selected( $condition['type'], 'include' ); ?>><?php esc_html_e( 'Include', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="exclude" <?php selected( $condition['type'], 'exclude' ); ?>><?php esc_html_e( 'Exclude', 'royal-addons-for-elementor' ); ?></option>
                                </select>
                                
                                <select name="royal_conditions[<?php echo esc_attr( $index ); ?>][rule]" class="royal-condition-rule">
                                    <option value="entire_site" <?php selected( $condition['rule'], 'entire_site' ); ?>><?php esc_html_e( 'Entire Site', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="front_page" <?php selected( $condition['rule'], 'front_page' ); ?>><?php esc_html_e( 'Front Page', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="singular" <?php selected( $condition['rule'], 'singular' ); ?>><?php esc_html_e( 'Singular', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="all_singular" <?php selected( $condition['rule'], 'all_singular' ); ?>><?php esc_html_e( 'All Singular', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="post" <?php selected( $condition['rule'], 'post' ); ?>><?php esc_html_e( 'Post', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="page" <?php selected( $condition['rule'], 'page' ); ?>><?php esc_html_e( 'Page', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="category" <?php selected( $condition['rule'], 'category' ); ?>><?php esc_html_e( 'Category', 'royal-addons-for-elementor' ); ?></option>
                                    <option value="tag" <?php selected( $condition['rule'], 'tag' ); ?>><?php esc_html_e( 'Tag', 'royal-addons-for-elementor' ); ?></option>
                                </select>
                                
                                <?php if ( isset( $condition['value'] ) && ! empty( $condition['value'] ) ): ?>
                                    <select name="royal_conditions[<?php echo esc_attr( $index ); ?>][value]" class="royal-condition-value">
                                        <option value="<?php echo esc_attr( $condition['value'] ); ?>" selected><?php echo esc_html( $condition['value'] ); ?></option>
                                    </select>
                                <?php endif; ?>
                                
                                <button type="button" class="royal-remove-condition" <?php echo count( $conditions ) <= 1 ? 'style="display: none;"' : ''; ?>>×</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <button type="button" id="royal-add-condition" class="royal-add-condition-btn">
                <?php esc_html_e( 'ADD CONDITION', 'royal-addons-for-elementor' ); ?>
            </button>
        </div>
        <?php
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
        
        return implode( ', ', $summary_parts );
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
     * Save the custom meta data for the snippet
     */
    public function save_snippet_meta_data( $post_id ) {
        if ( ! isset( $_POST['royal_snippet_meta_nonce'] ) || ! wp_verify_nonce( $_POST['royal_snippet_meta_nonce'], 'royal_snippet_save_meta_data' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Save snippet content
        if ( isset( $_POST['royal_snippet_content'] ) ) {
            $content = wp_unslash( $_POST['royal_snippet_content'] );
            update_post_meta( $post_id, '_royal_snippet_content', $content );
        }

        // Save code type
        if ( isset( $_POST['royal_snippet_code_type'] ) ) {
            $allowed_types = array( 'html', 'css', 'javascript' );
            // Only administrators can save php type
            if ( current_user_can( 'administrator' ) ) {
                $allowed_types[] = 'php';
            }
            $code_type = sanitize_text_field( $_POST['royal_snippet_code_type'] );
            if ( in_array( $code_type, $allowed_types, true ) ) {
                update_post_meta( $post_id, '_royal_snippet_code_type', $code_type );
            }
        }

        // Save location (only relevant for non-PHP types)
        if ( isset( $_POST['royal_snippet_location'] ) ) {
            $location = sanitize_text_field( $_POST['royal_snippet_location'] );
            update_post_meta( $post_id, '_royal_snippet_location', $location );
        }

        // Save priority
        if ( isset( $_POST['royal_snippet_priority'] ) ) {
            $priority = absint( $_POST['royal_snippet_priority'] );
            update_post_meta( $post_id, '_royal_snippet_priority', $priority );
        }

        // Save conditions
        if ( isset( $_POST['royal_conditions'] ) ) {
            $conditions = array();
            foreach ( $_POST['royal_conditions'] as $condition ) {
                if ( ! empty( $condition['rule'] ) ) {
                    $conditions[] = array(
                        'type' => sanitize_text_field( $condition['type'] ),
                        'rule' => sanitize_text_field( $condition['rule'] ),
                        'value' => isset( $condition['value'] ) ? sanitize_text_field( $condition['value'] ) : '',
                    );
                }
            }
            update_post_meta( $post_id, '_royal_snippet_conditions', $conditions );
        }
    }

   

    /**
     * Add the "Custom Code" submenu item under "Royal Addons for Elementor"
     */
    public function add_custom_code_submenu() {
        add_submenu_page(
            'royaladdonsforelementor',
            esc_html__( 'Custom Code', 'royal-addons-for-elementor' ),
            esc_html__( 'Custom Code', 'royal-addons-for-elementor' ),
            'manage_options',
            'edit.php?post_type=royal_snippet'
        );
    }
}

