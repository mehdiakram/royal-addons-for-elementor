<?php
/**
 * Royal Templates Library - Main Class
 *
 * @package RoyalAddonsForElementor
 * @since 26.01.19
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Royal_Templates_Library
 */
class Royal_Templates_Library {

    /**
     * Instance
     *
     * @var Royal_Templates_Library
     */
    private static $instance = null;

    /**
     * Local templates directory
     *
     * @var string
     */
    private $local_templates_dir;

    /**
     * Remote API URL for Pro templates
     *
     * @var string
     */
    private $remote_api_url = 'https://api.royaltechbd.com/templates/v1/';

    /**
     * Get instance
     *
     * @return Royal_Templates_Library
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->local_templates_dir = ROYAL_ADDONS_DIR_PATH . 'templates/free/';
        
        // Initialize hooks
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_editor_scripts' ), 99 );
        add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'enqueue_editor_styles' ), 99 );
        add_action( 'elementor/editor/footer', array( $this, 'render_template_library_modal' ) );
        
        // AJAX handlers
        add_action( 'wp_ajax_royal_get_templates', array( $this, 'ajax_get_templates' ) );
        add_action( 'wp_ajax_royal_import_template', array( $this, 'ajax_import_template' ) );
    }

    /**
     * Enqueue editor scripts
     */
    public function enqueue_editor_scripts() {
        // SweetAlert2 for notifications
        wp_enqueue_script(
            'sweetalert2',
            'https://cdn.jsdelivr.net/npm/sweetalert2@11',
            array(),
            '11.0.0',
            true
        );
        
        wp_enqueue_script(
            'royal-templates-library',
            ROYAL_ADDONS_DIR_URL . 'assets/royal-templates/js/template-library.js',
            array( 'jquery', 'elementor-editor', 'sweetalert2' ),
            ROYAL_ADDONS_VERSION,
            true
        );

        wp_localize_script(
            'royal-templates-library',
            'royalTemplatesLib',
            array(
                'ajaxUrl'       => admin_url( 'admin-ajax.php' ),
                'nonce'         => wp_create_nonce( 'royal_templates_nonce' ),
                'logoUrl'       => ROYAL_ADDONS_ASSETS . 'images/logo.png',
                'isProActive'   => $this->is_pro_active(),
                'i18n'          => array(
                    'title'         => __( 'Royal Templates', 'royal-addons-for-elementor' ),
                    'search'        => __( 'Search templates...', 'royal-addons-for-elementor' ),
                    'all'           => __( 'All', 'royal-addons-for-elementor' ),
                    'free'          => __( 'Free', 'royal-addons-for-elementor' ),
                    'pro'           => __( 'Pro', 'royal-addons-for-elementor' ),
                    'import'        => __( 'Import', 'royal-addons-for-elementor' ),
                    'preview'       => __( 'Preview', 'royal-addons-for-elementor' ),
                    'importing'     => __( 'Importing...', 'royal-addons-for-elementor' ),
                    'success'       => __( 'Template imported successfully!', 'royal-addons-for-elementor' ),
                    'error'         => __( 'Failed to import template.', 'royal-addons-for-elementor' ),
                    'unlock'        => __( 'Unlock Pro', 'royal-addons-for-elementor' ),
                    'noResults'     => __( 'No templates found.', 'royal-addons-for-elementor' ),
                    'loading'       => __( 'Loading templates...', 'royal-addons-for-elementor' ),
                    'pages'         => __( 'Pages', 'royal-addons-for-elementor' ),
                    'sections'      => __( 'Sections', 'royal-addons-for-elementor' ),
                    'headers'       => __( 'Headers', 'royal-addons-for-elementor' ),
                    'footers'       => __( 'Footers', 'royal-addons-for-elementor' ),
                ),
                'categories'    => $this->get_categories(),
            )
        );
    }

    /**
     * Enqueue editor styles
     */
    public function enqueue_editor_styles() {
        wp_enqueue_style(
            'royal-templates-library',
            ROYAL_ADDONS_DIR_URL . 'assets/royal-templates/css/template-library.css',
            array(),
            ROYAL_ADDONS_VERSION
        );
    }

    /**
     * Render template library modal HTML
     */
    public function render_template_library_modal() {
        include ROYAL_ADDONS_DIR_PATH . 'includes/royal-templates/views/modal.php';
    }

    /**
     * Check if Pro license is active
     *
     * @return bool
     */
    public function is_pro_active() {
        // Use existing license validation function
        if ( function_exists( 'royaladdons_is_license_valid' ) ) {
            return royaladdons_is_license_valid();
        }
        
        return false;
    }

    /**
     * Get template categories
     *
     * @return array
     */
    public function get_categories() {
        return array(
            'all'        => __( 'All', 'royal-addons-for-elementor' ),
            'business'   => __( 'Business', 'royal-addons-for-elementor' ),
            'portfolio'  => __( 'Portfolio', 'royal-addons-for-elementor' ),
            'blog'       => __( 'Blog', 'royal-addons-for-elementor' ),
            'landing'    => __( 'Landing Page', 'royal-addons-for-elementor' ),
            'ecommerce'  => __( 'eCommerce', 'royal-addons-for-elementor' ),
            'agency'     => __( 'Agency', 'royal-addons-for-elementor' ),
            'starter'    => __( 'Starter', 'royal-addons-for-elementor' ),
        );
    }

    /**
     * Get all templates (Free local + Pro remote)
     *
     * @return array
     */
    public function get_all_templates() {
        $templates = array();
        
        // Get local free templates
        $local_templates = $this->get_local_templates();
        $templates = array_merge( $templates, $local_templates );
        
        // Get remote pro templates if license is active
        if ( $this->is_pro_active() ) {
            $remote_templates = $this->get_remote_templates();
            $templates = array_merge( $templates, $remote_templates );
        } else {
            // Show pro templates as locked
            $remote_templates = $this->get_remote_templates_preview();
            $templates = array_merge( $templates, $remote_templates );
        }
        
        return $templates;
    }

    /**
     * Get local free templates
     *
     * @return array
     */
    public function get_local_templates() {
        $templates = array();
        $catalog_file = ROYAL_ADDONS_DIR_PATH . 'templates/catalog.json';
        $base_url = ROYAL_ADDONS_DIR_URL . 'templates/';
        
        if ( file_exists( $catalog_file ) ) {
            $catalog = json_decode( file_get_contents( $catalog_file ), true );
            if ( ! empty( $catalog['free'] ) ) {
                $templates = $catalog['free'];
                
                // Convert relative thumbnail paths to full URLs
                foreach ( $templates as &$template ) {
                    if ( ! empty( $template['thumbnail'] ) && strpos( $template['thumbnail'], 'http' ) !== 0 ) {
                        $template['thumbnail'] = $base_url . $template['thumbnail'];
                    }
                }
            }
        }
        
        return $templates;
    }

    /**
     * Get remote pro templates
     *
     * @return array
     */
    /**
     * Get remote pro templates
     *
     * @return array
     */
    public function get_remote_templates() {
        $cache_key = 'royal_pro_templates';
        $cached = get_transient( $cache_key );
        
        if ( false !== $cached ) {
            return $cached;
        }
        
        $license_key = get_option( 'royaladdons_license_key', '' );
        
        $response = wp_remote_get(
            $this->remote_api_url . 'templates/catalog.json',
            array(
                'timeout' => 30,
                'headers' => array(
                    'X-License-Key' => $license_key,
                ),
            )
        );
        
        if ( is_wp_error( $response ) ) {
            return array();
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        
        if ( ! empty( $data['templates'] ) ) {
            set_transient( $cache_key, $data['templates'], HOUR_IN_SECONDS );
            return $data['templates'];
        }
        
        return array();
    }

    /**
     * Get remote pro templates preview (locked)
     *
     * @return array
     */
    public function get_remote_templates_preview() {
        $cache_key = 'royal_pro_templates_preview';
        $cached = get_transient( $cache_key );
        
        if ( false !== $cached ) {
            return $cached;
        }
        
        $response = wp_remote_get(
            $this->remote_api_url . 'templates/catalog.json',
            array( 'timeout' => 30 )
        );
        
        if ( is_wp_error( $response ) ) {
            // Fallback: try local catalog pro section
            $catalog_file = ROYAL_ADDONS_DIR_PATH . 'templates/catalog.json';
            
            if ( file_exists( $catalog_file ) ) {
                $catalog = json_decode( file_get_contents( $catalog_file ), true );
                if ( ! empty( $catalog['pro'] ) ) {
                    return $catalog['pro'];
                }
            }
            return array();
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        
        if ( ! empty( $data['templates'] ) ) {
            // Mark all as locked since this is preview
            // Actually, frontend handles locking based on license, but we can double ensure
            // or just serve the list. The `is_pro` flag is enough.
            
            set_transient( $cache_key, $data['templates'], HOUR_IN_SECONDS );
            return $data['templates'];
        }
        
        return array();
    }

    /**
     * AJAX: Get templates
     */
    public function ajax_get_templates() {
        check_ajax_referer( 'royal_templates_nonce', 'nonce' );
        
        $tab = isset( $_POST['tab'] ) ? sanitize_text_field( $_POST['tab'] ) : 'pages';
        $type = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : 'all';
        $category = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : 'all';
        $search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
        
        $templates = $this->get_all_templates();
        
        // Filter by tab (template type: pages, sections, headers, footers)
        if ( ! empty( $tab ) ) {
            $templates = array_filter( $templates, function( $t ) use ( $tab ) {
                return isset( $t['type'] ) && $t['type'] === $tab;
            });
        }
        
        // Filter by type (free/pro)
        if ( 'free' === $type ) {
            $templates = array_filter( $templates, function( $t ) {
                return empty( $t['is_pro'] );
            });
        } elseif ( 'pro' === $type ) {
            $templates = array_filter( $templates, function( $t ) {
                return ! empty( $t['is_pro'] );
            });
        }
        
        // Filter by category
        if ( 'all' !== $category ) {
            $templates = array_filter( $templates, function( $t ) use ( $category ) {
                return in_array( $category, (array) $t['category'], true );
            });
        }
        
        // Filter by search
        if ( ! empty( $search ) ) {
            $templates = array_filter( $templates, function( $t ) use ( $search ) {
                return false !== stripos( $t['title'], $search ) || 
                       false !== stripos( implode( ' ', (array) $t['tags'] ), $search );
            });
        }
        
        // Filter by search
        if ( ! empty( $search ) ) {
            $templates = array_filter( $templates, function( $t ) use ( $search ) {
                return ( stripos( $t['title'], $search ) !== false ) || ( stripos( $t['type'], $search ) !== false );
            });
        }
        
        wp_send_json_success( array(
            'templates' => array_values( $templates ),
            'count' => count( $templates ),
        ));
    }

    /**
     * AJAX: Import template
     */
    public function ajax_import_template() {
        check_ajax_referer( 'royal_templates_nonce', 'nonce' );
        
        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( array( 'message' => __( 'Permission denied.', 'royal-addons-for-elementor' ) ) );
        }
        
        $template_id = isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : '';
        $is_pro_raw = isset( $_POST['is_pro'] ) ? $_POST['is_pro'] : false;
        $is_pro = filter_var( $is_pro_raw, FILTER_VALIDATE_BOOLEAN );
        
        if ( empty( $template_id ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid template.', 'royal-addons-for-elementor' ) ) );
        }
        
        // Check Pro license for Pro templates
        if ( $is_pro && ! $this->is_pro_active() ) {
            wp_send_json_error( array( 'message' => __( 'Pro license required.', 'royal-addons-for-elementor' ) ) );
        }
        
        // Get template content
        $content = $this->get_template_content( $template_id, $is_pro );
        
        if ( empty( $content ) ) {
            $debug_path = $this->local_templates_dir . $template_id . '.json';
            wp_send_json_error( array( 
                'message' => sprintf( 
                    __( 'Template not found: %s', 'royal-addons-for-elementor' ), 
                    $template_id 
                ),
                'debug' => array(
                    'path' => $debug_path,
                    'exists' => file_exists( $debug_path )
                )
            ));
        }
        
        wp_send_json_success( array(
            'content' => $content,
        ));
    }

    /**
     * Get template content
     *
     * @param string $template_id Template ID.
     * @param bool   $is_pro      Is Pro template.
     * @return array|null
     */
    public function get_template_content( $template_id, $is_pro = false ) {
        if ( $is_pro ) {
            return $this->get_remote_template_content( $template_id );
        }
        
        return $this->get_local_template_content( $template_id );
    }

    /**
     * Get local template content
     *
     * @param string $template_id Template ID.
     * @return array|null
     */
    public function get_local_template_content( $template_id ) {
        $template_file = $this->local_templates_dir . $template_id . '.json';
        
        if ( ! file_exists( $template_file ) ) {
            return null;
        }
        
        $content = file_get_contents( $template_file );
        $data = json_decode( $content, true );
        
        if ( ! empty( $data['content'] ) ) {
            return $data['content'];
        }
        
        return null;
    }

    /**
     * Get remote template content
     *
     * @param string $template_id Template ID.
     * @return array|null
     */
    public function get_remote_template_content( $template_id ) {
        $license_key = get_option( 'royaladdons_license_key', '' );
        
        $response = wp_remote_get(
            $this->remote_api_url . 'templates/pro/' . $template_id . '.json',
            array(
                'timeout' => 30,
                'headers' => array(
                    'X-License-Key' => $license_key,
                ),
            )
        );
        
        if ( is_wp_error( $response ) ) {
            return null;
        }
        
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );
        
        if ( ! empty( $data['content'] ) ) {
            return $data['content'];
        }
        
        return null;
    }
}

// Initialize
Royal_Templates_Library::get_instance();
