<?php
/**
 * The core plugin class.
 */

namespace RoyalAddons\RoyalHF;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Core {

    private static $instance = null;

    public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    public function __construct() {
        $this->includes();
        add_action( 'init', [ $this, 'setup_cpt' ] );
		add_action( 'add_meta_boxes', [ $this, 'register_metabox' ] );
		add_action( 'save_post', [ $this, 'save_meta' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp', [ $this, 'hooks' ] );

        // Custom Columns for royal-hf CPT
        add_filter( 'manage_royal-hf_posts_columns', [ $this, 'set_custom_columns' ] );
        add_action( 'manage_royal-hf_posts_custom_column', [ $this, 'render_custom_columns' ], 10, 2 );

        // Hook into Elementor's theme location system (for themes using elementor_theme_do_location)
        add_action( 'elementor/theme/register_locations', [ $this, 'register_elementor_locations' ] );
    }

    /**
     * Register our header/footer templates as Elementor theme locations.
     * This makes our templates work with themes that use elementor_theme_do_location().
     */
    public function register_elementor_locations( $elementor_theme_manager ) {
        // Register header location
        $elementor_theme_manager->register_location(
            'header',
            [
                'label'           => __( 'Header', 'royal-addons-for-elementor' ),
                'multiple'        => false,
                'edit_in_content' => true,
            ]
        );

        // Register footer location
        $elementor_theme_manager->register_location(
            'footer',
            [
                'label'           => __( 'Footer', 'royal-addons-for-elementor' ),
                'multiple'        => false,
                'edit_in_content' => true,
            ]
        );
    }

	public function includes() {
		require_once ROYAL_HF_CORE_DIR . 'functions.php';
		require_once ROYAL_HF_CORE_DIR . 'class-royal-hf-admin.php';
        require_once ROYAL_HF_CORE_DIR . 'class-royal-hf-target-rules.php';
        require_once ROYAL_HF_CORE_DIR . 'class-royal-hf-theme-support.php';
        Admin::instance();
        Target_Rules::get_instance();
	}

	public function setup_cpt() {
		$labels = [
			'name'               => __( 'Royal Templates', 'royal-addons-for-elementor' ),
			'singular_name'      => __( 'Royal Template', 'royal-addons-for-elementor' ),
			'menu_name'          => __( 'Royal HF', 'royal-addons-for-elementor' ),
			'name_admin_bar'     => __( 'Royal Template', 'royal-addons-for-elementor' ),
			'add_new'            => __( 'Add New', 'royal-addons-for-elementor' ),
			'add_new_item'       => __( 'Add New Template', 'royal-addons-for-elementor' ),
			'new_item'           => __( 'New Template', 'royal-addons-for-elementor' ),
			'edit_item'          => __( 'Edit Template', 'royal-addons-for-elementor' ),
			'view_item'          => __( 'View Template', 'royal-addons-for-elementor' ),
			'all_items'          => __( 'All Templates', 'royal-addons-for-elementor' ),
			'search_items'       => __( 'Search Templates', 'royal-addons-for-elementor' ),
			'not_found'          => __( 'No Templates found.', 'royal-addons-for-elementor' ),
			'not_found_in_trash' => __( 'No Templates found in Trash.', 'royal-addons-for-elementor' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => [ 'title', 'elementor' ],
		];

		register_post_type( 'royal-hf', $args );
	}

	public function register_metabox() {
		add_meta_box(
			'royal-hf-meta-box',
			__( 'Royal Template Options', 'royal-addons-for-elementor' ),
			[ $this, 'render_metabox' ],
			'royal-hf',
			'normal',
			'high'
		);
	}

	public function render_metabox( $post ) {
		$template_type = get_post_meta( $post->ID, '_royal_template_type', true );
		wp_nonce_field( 'royal_hf_meta_nonce', 'royal_hf_meta_nonce' );
		?>
		<table class="form-table">
			<tbody>
				<tr class="royal-hf-options-row">
					<th scope="row">
						<label for="royal_template_type"><?php esc_html_e( 'Type of Template', 'royal-addons-for-elementor' ); ?></label>
					</th>
					<td>
						<select name="_royal_template_type" id="royal_template_type">
							<option value="" <?php selected( $template_type, '' ); ?>><?php esc_html_e( 'Select Option', 'royal-addons-for-elementor' ); ?></option>
							<option value="type_header" <?php selected( $template_type, 'type_header' ); ?>><?php esc_html_e( 'Header', 'royal-addons-for-elementor' ); ?></option>
							<option value="type_footer" <?php selected( $template_type, 'type_footer' ); ?>><?php esc_html_e( 'Footer', 'royal-addons-for-elementor' ); ?></option>
							<option value="type_before_footer" <?php selected( $template_type, 'type_before_footer' ); ?>><?php esc_html_e( 'Before Footer', 'royal-addons-for-elementor' ); ?></option>
							<option value="custom_block" <?php selected( $template_type, 'custom_block' ); ?>><?php esc_html_e( 'Custom Block', 'royal-addons-for-elementor' ); ?></option>
						</select>
					</td>
				</tr>
                <tbody class="royal-hf-display-rules-wrapper">
                    <?php Target_Rules::get_instance()->display_rules_tab(); ?>
                </tbody>
                <tr class="royal-hf-options-row royal-hf-shortcode-wrapper" style="display: none;">
                    <th scope="row">
                        <label><?php esc_html_e( 'Shortcode', 'royal-addons-for-elementor' ); ?></label>
                    </th>
                    <td>
                        <input type="text" readonly="readonly" value="[rhf_template id='<?php echo esc_attr( $post->ID ); ?>']" class="widefat">
                    </td>
                </tr>
			</tbody>
		</table>
		<?php
	}

	public function save_meta( $post_id ) {
        if ( ! isset( $_POST['royal_hf_meta_nonce'] ) || ! wp_verify_nonce( $_POST['royal_hf_meta_nonce'], 'royal_hf_meta_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['_royal_template_type'] ) ) {
			update_post_meta( $post_id, '_royal_template_type', sanitize_text_field( $_POST['_royal_template_type'] ) );
		}

        $target_locations = isset( $_POST['_royal_hf_target_include_locations'] ) ? array_map( 'sanitize_text_field', $_POST['_royal_hf_target_include_locations'] ) : [];
        $target_exclusion = isset( $_POST['_royal_hf_target_exclude_locations'] ) ? array_map( 'sanitize_text_field', $_POST['_royal_hf_target_exclude_locations'] ) : [];
        $target_users     = isset( $_POST['_royal_hf_target_user_roles'] ) ? array_map( 'sanitize_text_field', $_POST['_royal_hf_target_user_roles'] ) : [];
        
        $specific_include = isset( $_POST['_royal_hf_target_include_specific'] ) ? array_map( 'sanitize_text_field', $_POST['_royal_hf_target_include_specific'] ) : [];
        $specific_exclude = isset( $_POST['_royal_hf_target_exclude_specific'] ) ? array_map( 'sanitize_text_field', $_POST['_royal_hf_target_exclude_specific'] ) : [];

		update_post_meta( $post_id, '_royal_hf_target_include_locations', $target_locations );
		update_post_meta( $post_id, '_royal_hf_target_exclude_locations', $target_exclusion );
		update_post_meta( $post_id, '_royal_hf_target_user_roles', $target_users );
        update_post_meta( $post_id, '_royal_hf_target_include_specific', $specific_include );
        update_post_meta( $post_id, '_royal_hf_target_exclude_specific', $specific_exclude );
	}

	public function enqueue_scripts() {
        $header_id = royal_get_header_id();
        $footer_id = royal_get_footer_id();
        $before_footer_id = royal_get_before_footer_id();

        if ( $header_id || $footer_id || $before_footer_id ) {
            if ( class_exists( '\Elementor\Plugin' ) ) {
                \Elementor\Plugin::instance()->frontend->enqueue_styles();
            }
        }

		if ( $header_id ) {
			$this->enqueue_template_css( $header_id );
		}
		if ( $footer_id ) {
			$this->enqueue_template_css( $footer_id );
		}
		if ( $before_footer_id ) {
			$this->enqueue_template_css( $before_footer_id );
		}
	}

	private function enqueue_template_css( $post_id ) {
        if ( ! $post_id ) return;
		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			$css_file = new \Elementor\Core\Files\CSS\Post( $post_id );
		} elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
			$css_file = new \Elementor\Post_CSS_File( $post_id );
		} else {
			return;
		}
		$css_file->enqueue();
	}

    public function set_custom_columns( $columns ) {
        unset( $columns['date'] );
        $columns['title'] = __( 'Title', 'royal-addons-for-elementor' );
        $columns['rhf_template_type'] = __( 'Type of Template', 'royal-addons-for-elementor' );
        $columns['rhf_display_rules'] = __( 'Display Rules', 'royal-addons-for-elementor' );
        $columns['rhf_shortcode'] = __( 'Shortcode', 'royal-addons-for-elementor' );
        $columns['date'] = __( 'Date', 'royal-addons-for-elementor' );
        return $columns;
    }

    public function render_custom_columns( $column, $post_id ) {
        $template_type = get_post_meta( $post_id, '_royal_template_type', true );

        switch ( $column ) {
            case 'rhf_template_type':
                $types = [
                    'type_header'        => 'Header',
                    'type_footer'        => 'Footer',
                    'type_before_footer' => 'Before Footer',
                    'custom_block'       => 'Custom Block',
                ];
                echo $types[ $template_type ] ?? '—';
                break;

            case 'rhf_display_rules':
                if ( 'custom_block' === $template_type ) {
                    echo '—';
                    break;
                }
                $display_rules = get_post_meta( $post_id, '_royal_hf_target_include_locations', true );
                echo Target_Rules::get_instance()->get_rule_labels_string( $display_rules, $post_id );
                break;

            case 'rhf_shortcode':
                if ( 'custom_block' === $template_type ) {
                    echo "<input type='text' readonly='readonly' value=\"[rhf_template id='" . esc_attr( $post_id ) . "']\" class='widefat'>";
                } else {
                    echo '—';
                }
                break;
        }
    }

	public function hooks() {
		add_action( 'get_header', [ $this, 'override_header' ] );
		add_action( 'get_footer', [ $this, 'override_footer' ] );
	}

	public function override_header() {
        global $royal_hf_header_id, $royal_hf_header_rendered;
        
        // Skip if already rendered by elementor_theme_do_location
        if ( ! empty( $royal_hf_header_rendered ) ) {
            return;
        }
        
		$royal_hf_header_id = royal_get_header_id();

		if ( $royal_hf_header_id ) {
            $royal_hf_header_rendered = true;
			require \ROYAL_HF_CORE_DIR . 'themes/default/royal-hf-header.php';
			$templates   = [ 'header.php' ];
			// Start output buffering to capture and discard theme's header.php
			// The second parameter (true) of ob_start enables chunk mode
			ob_start();
			locate_template( $templates, true );
			// Discard the captured output (theme's header)
			ob_end_clean();
		}
	}

	public function override_footer() {
        global $royal_hf_footer_id, $royal_hf_before_footer_id, $royal_hf_footer_rendered, $royal_hf_before_footer_rendered;
        
		$royal_hf_footer_id        = royal_get_footer_id();
		$royal_hf_before_footer_id = royal_get_before_footer_id();

        // Case 1: A custom footer is set. This takes precedence.
        if ( $royal_hf_footer_id ) {
            // Skip if already rendered by elementor_theme_do_location
            if ( ! empty( $royal_hf_footer_rendered ) ) {
                return;
            }
            
            $royal_hf_footer_rendered = true;
            $royal_hf_before_footer_rendered = true;
            
            // We will replace the theme's footer entirely.
            // Our template file will handle rendering before-footer, footer, and wp_footer().
            require \ROYAL_HF_CORE_DIR . 'themes/default/royal-hf-footer.php';
            
            // Suppress the original theme's footer.php
            $templates   = [ 'footer.php' ];
            ob_start();
            locate_template( $templates, true );
            ob_get_clean();
        } 
        // Case 2: No custom footer, but a "before footer" is set.
        elseif ( $royal_hf_before_footer_id ) {
            // Skip if already rendered by elementor_theme_do_location
            if ( ! empty( $royal_hf_before_footer_rendered ) ) {
                return;
            }
            
            $royal_hf_before_footer_rendered = true;
            
            // We just want to display our content before the theme's footer.
            // So we echo it directly here. The theme's get_footer() will then proceed normally.
            echo '<div class="royal-before-footer-wrap">';
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $royal_hf_before_footer_id );
            echo '</div>';
        }
	}
}
