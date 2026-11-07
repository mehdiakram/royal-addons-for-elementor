<?php
/**
 * Target Rules Fields
 */

namespace RoyalAddons\RoyalHF;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Target_Rules {

    private static $instance;
    private static $location_options = null;

    public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

    public function __construct() {
        add_action( 'admin_enqueue_scripts', [ $this, 'royal_hf_admin_styles' ] );
        add_action( 'wp_ajax_royal_hf_get_specific_posts_by_query', [ $this, 'get_specific_posts_by_query' ] );
        add_action( 'admin_footer-post.php', [ $this, 'render_js_templates' ] );
        add_action( 'admin_footer-post-new.php', [ $this, 'render_js_templates' ] );
    }

    public function royal_hf_admin_styles( $hook ) {
        global $post;
        if ( ! $post || 'royal-hf' !== $post->post_type ) {
            return;
        }
        wp_enqueue_style( 'select2', \ROYAL_ADDONS_DIR_URL . 'assets/vendor/select2/select2.min.css', [], '4.0.3' );
        wp_enqueue_script( 'select2', \ROYAL_ADDONS_DIR_URL . 'assets/vendor/select2/select2.full.min.js', ['jquery'], '4.0.3', true );
        wp_enqueue_style( 'royal-hf-admin-target-rules', \ROYAL_ADDONS_DIR_URL . 'includes/royal-hf/css/target-rules.css', [], \ROYAL_ADDONS_VERSION );
        wp_enqueue_script( 'royal-hf-admin-target-rules', \ROYAL_ADDONS_DIR_URL . 'includes/royal-hf/js/target-rules.js', ['jquery', 'wp-util', 'select2'], \ROYAL_ADDONS_VERSION, true );
        wp_localize_script( 'royal-hf-admin-target-rules', 'royalHfTargetRules', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'royal-hf-specifics-nonce' ),
            'search_placeholder' => __( 'Search pages / posts / categories', 'royal-addons-for-elementor' ),
        ]);
    }

    public function get_specific_posts_by_query() {
        check_ajax_referer( 'royal-hf-specifics-nonce', 'nonce' );
        $search_term = isset( $_GET['q'] ) ? sanitize_text_field( $_GET['q'] ) : '';
        $results = [];

        $post_types = get_post_types( [ 'public' => true ], 'names' );
        unset( $post_types['attachment'] );

        // Search Posts and Pages
        $post_query = new \WP_Query([
            's' => $search_term,
            'post_type' => array_keys($post_types),
            'posts_per_page' => 100,
        ]);

        if ( $post_query->have_posts() ) {
            while ( $post_query->have_posts() ) {
                $post_query->the_post();
                $results[] = [
                    'id'   => 'post-' . get_the_ID(),
                    'text' => get_the_title(),
                ];
            }
        }
        wp_reset_postdata();

        // Search Taxonomies
        $taxonomies = get_taxonomies(['public' => true]);
        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'name__like' => $search_term,
                'hide_empty' => false,
            ]);
            foreach ($terms as $term) {
                $results[] = [
                    'id'   => 'tax-' . $term->term_id,
                    'text' => $term->name . ' (' . $taxonomy . ')',
                ];
            }
        }
        wp_send_json( [ 'data' => $results ] );
    }

    public function display_rules_tab() {
        $display_rules = get_post_meta( get_the_ID(), '_royal_hf_target_include_locations', true );
        $exclusion_rules = get_post_meta( get_the_ID(), '_royal_hf_target_exclude_locations', true );
        $user_roles = get_post_meta( get_the_ID(), '_royal_hf_target_user_roles', true );
        $exclusion_style = ( empty( $exclusion_rules ) || ! is_array( $exclusion_rules ) ) ? 'style="display: none;"' : '';
        ?>
        <tr class="royal-hf-options-row">
            <th scope="row">
                <label><?php esc_html_e( 'Display On', 'royal-addons-for-elementor' ); ?></label>
                 <i class="dashicons dashicons-editor-help" title="<?php esc_attr_e( 'Add locations for where this template should appear.', 'royal-addons-for-elementor' ); ?>"></i>
            </th>
            <td>
                <?php $this->target_rule_settings_field( '_royal_hf_target_include_locations', $display_rules, 'display' ); ?>
            </td>
        </tr>
        <tr class="royal-hf-options-row royal-hf-exclusion-rules-wrapper" <?php echo $exclusion_style; ?>>
            <th scope="row">
                <label><?php esc_html_e( 'Do Not Display On', 'royal-addons-for-elementor' ); ?></label>
                <i class="dashicons dashicons-editor-help" title="<?php esc_attr_e( 'Add locations for where this template should not appear.', 'royal-addons-for-elementor' ); ?>"></i>
            </th>
            <td>
                <?php $this->target_rule_settings_field( '_royal_hf_target_exclude_locations', $exclusion_rules, 'exclude' ); ?>
            </td>
        </tr>
        <tr class="royal-hf-options-row">
            <th scope="row">
                <label><?php esc_html_e( 'User Roles', 'royal-addons-for-elementor' ); ?></label>
                 <i class="dashicons dashicons-editor-help" title="<?php esc_attr_e( 'Display custom template based on user role.', 'royal-addons-for-elementor' ); ?>"></i>
            </th>
            <td>
                <?php $this->user_role_settings_field( '_royal_hf_target_user_roles', $user_roles ); ?>
            </td>
        </tr>
        <?php
    }

    public function target_rule_settings_field( $name, $saved_values, $type ) {
        echo '<div class="rules-wrapper">';
        if ( ! empty( $saved_values ) && is_array( $saved_values ) ) {
            foreach( $saved_values as $value ) {
                $this->render_location_rule_template( $name . '[]', $value, $type );
            }
        } else {
             $this->render_location_rule_template( $name . '[]', '', $type );
        }
        echo '</div>';
        echo '<button type="button" class="button add-display-rule">' . esc_html__( 'Add Display Rule', 'royal-addons-for-elementor' ) . '</button>';
        if ( 'display' === $type ) {
            $exclusion_button_style = ( ! empty( $saved_values ) && is_array( $saved_values ) ) ? 'style="display: none;"' : '';
             echo '<button type="button" class="button add-exclusion-rule" ' . $exclusion_button_style . '>' . esc_html__( 'Add Exclusion Rule', 'royal-addons-for-elementor' ) . '</button>';
        }
    }

    public function user_role_settings_field( $name, $saved_values ) {
        echo '<div class="rules-wrapper">';
        if ( ! empty( $saved_values ) && is_array( $saved_values ) ) {
             foreach( $saved_values as $value ) {
                $this->render_user_role_template( $name . '[]', $value );
            }
        } else {
            $this->render_user_role_template( $name . '[]', '' );
        }
        echo '</div>';
        echo '<button type="button" class="button add-user-rule">' . esc_html__( 'Add User Rule', 'royal-addons-for-elementor' ) . '</button>';
    }

    private function get_location_selections() {
        if ( ! is_null( self::$location_options ) ) {
            return self::$location_options;
        }

        $post_types = get_post_types( [ 'public' => true ], 'objects' );
        unset( $post_types['attachment'] );

        $options = [
            'Basic' => [
                'basic-global'    => 'Entire Website',
                'basic-singulars' => 'All Singulars',
                'basic-archives'  => 'All Archives',
            ],
            'Special Pages' => [
                'special-404'    => '404 Page',
                'special-search' => 'Search Page',
                'special-blog'   => 'Blog / Posts Page',
                'special-front'  => 'Front Page',
                'special-date'   => 'Date Archive',
                'special-author' => 'Author Archive',
            ],
        ];

        foreach ( $post_types as $post_type ) {
            if ( 'royal-hf' === $post_type->name ) {
                continue;
            }
            $options[ $post_type->label ] = [
                $post_type->name . '|all' => 'All ' . $post_type->label,
            ];
            if ($post_type->has_archive) {
                 $options[ $post_type->label ][ $post_type->name . '|all|archive' ] = 'All ' . $post_type->label . ' Archive';
            }

            $taxonomies = get_object_taxonomies( $post_type->name, 'objects' );
            foreach ( $taxonomies as $taxonomy ) {
                if ( $taxonomy->public ) {
                    $options[ $post_type->label ][ $post_type->name . '|all|taxarchive|' . $taxonomy->name ] = 'All ' . $taxonomy->label . ' Archive';
                }
            }
        }
        
        $options['Specific Target'] = [
            'specifics' => 'Specific Pages / Posts / Taxonomies, etc.',
        ];

        self::$location_options = $options;
        return self::$location_options;
    }

    public function get_rule_labels_string( $rules, $post_id ) {
        if ( empty( $rules ) || ! is_array( $rules ) ) {
            return '—';
        }

        $all_options = [];
        $location_groups = $this->get_location_selections();
        foreach ( $location_groups as $group ) {
            $all_options += $group;
        }

        $labels = [];
        foreach ( $rules as $rule ) {
            if ( 'specifics' === $rule ) {
                $specifics = get_post_meta( $post_id, '_royal_hf_target_include_specific', true );
                if( ! empty( $specifics ) ) {
                    $labels[] = 'Specific Targets';
                }
            } else {
                $labels[] = $all_options[ $rule ] ?? ucwords( str_replace( ['-', '|'], ' ', $rule ) );
            }
        }
        return implode( ', ', $labels );
    }

    public function render_js_templates() {
        ?>
        <script type="text/html" id="tmpl-royal-hf-location-rule-template">
            <?php $this->render_location_rule_template( '_royal_hf_target_include_locations[]', '', 'display' ); ?>
        </script>
        <script type="text/html" id="tmpl-royal-hf-exclusion-rule-template">
            <?php $this->render_location_rule_template( '_royal_hf_target_exclude_locations[]', '', 'exclude' ); ?>
        </script>
        <script type="text/html" id="tmpl-royal-hf-user-rule-template">
             <?php $this->render_user_role_template( '_royal_hf_target_user_roles[]' ); ?>
        </script>
        <?php
    }

    private function render_location_rule_template( $name, $selected_value = '', $type = 'display' ) {
        $is_specifics = ( 'specifics' === $selected_value );
        $specifics_style = $is_specifics ? '' : 'style="display:none;"';
        
        $specific_meta_key = ( 'display' === $type ) ? '_royal_hf_target_include_specific' : '_royal_hf_target_exclude_specific';
        $specific_name_html = $specific_meta_key . '[]';
        ?>
        <div class="royal-hf-target-rule-condition">
            <div class="royal-hf-rule-row">
                <select name="<?php echo esc_attr( $name ); ?>" class="royal-hf-target-rule-select">
                    <option value=""><?php esc_html_e( 'Select', 'royal-addons-for-elementor' ); ?></option>
                    <?php
                    $locations = $this->get_location_selections();
                    foreach ( $locations as $group => $options ) {
                        echo '<optgroup label="' . esc_attr( $group ) . '">';
                        foreach ( $options as $key => $value ) {
                            echo '<option value="' . esc_attr( $key ) . '" ' . selected( $selected_value, $key, false ) . '>' . esc_html( $value ) . '</option>';
                        }
                        echo '</optgroup>';
                    }
                    ?>
                </select>
                <span class="target-rule-condition-delete">&times;</span>
            </div>
            <div class="royal-hf-specifics-search-wrapper" <?php echo $specifics_style; ?>>
                 <select name="<?php echo esc_attr( $specific_name_html ); ?>" class="royal-hf-specifics-search" multiple="multiple" style="width:100%;">
                    <?php
                    if ( $is_specifics ) {
                        $specific_values = get_post_meta( get_the_ID(), $specific_meta_key, true );
                        if( ! empty( $specific_values ) ) {
                            foreach( $specific_values as $val ) {
                                $item_id_parts = explode( '-', $val );
                                $item_type = $item_id_parts[0];
                                $item_id = $item_id_parts[1];
                                $text = '';
                                if ( 'post' === $item_type ) {
                                    $text = get_the_title( $item_id );
                                } elseif ( 'tax' === $item_type ) {
                                    $term = get_term( $item_id );
                                    if ( $term && ! is_wp_error( $term ) ) {
                                        $text = $term->name . ' (' . $term->taxonomy . ')';
                                    }
                                }
                                if ( $text ) {
                                    echo '<option value="' . esc_attr( $val ) . '" selected="selected">' . esc_html( $text ) . '</option>';
                                }
                            }
                        }
                    }
                    ?>
                 </select>
            </div>
        </div>
        <?php
    }

    private function render_user_role_template( $name, $selected_value = '' ) {
         global $wp_roles;
        ?>
         <div class="royal-hf-target-rule-condition">
            <select name="<?php echo esc_attr( $name ); ?>" class="royal-hf-user-role-select" style="width:100%;">
                <option value="all" <?php selected( $selected_value, 'all' ); ?>><?php esc_html_e( 'All', 'royal-addons-for-elementor' ); ?></option>
                <option value="logged-in" <?php selected( $selected_value, 'logged-in' ); ?>><?php esc_html_e( 'Logged In', 'royal-addons-for-elementor' ); ?></option>
                <option value="logged-out" <?php selected( $selected_value, 'logged-out' ); ?>><?php esc_html_e( 'Logged Out', 'royal-addons-for-elementor' ); ?></option>
                <?php
                if ( ! empty( $wp_roles->roles ) ) {
                    foreach ( $wp_roles->roles as $role => $details ) {
                        echo '<option value="' . esc_attr( $role ) . '" ' . selected( $selected_value, $role, false ) . '>' . esc_html( $details['name'] ) . '</option>';
                    }
                }
                ?>
            </select>
            <span class="target-rule-condition-delete">&times;</span>
        </div>
        <?php
    }

    private function get_rule_score( $rule ) {
        $rule_parts = explode( '|', $rule );
        if ( count( $rule_parts ) > 2 ) {
            return 110; // Taxonomy archives are more specific
        }
        if ( count( $rule_parts ) > 1 ) {
            return 100; // Specific post types are high priority
        }
        switch ( $rule ) {
            case 'specifics':
                return 200;
            case 'special-front':
            case 'special-404':
                return 150;
            case 'special-blog':
            case 'special-search':
                return 120;
            case 'basic-singulars':
            case 'basic-archives':
                return 50;
            case 'basic-global':
                return 10;
            default:
                return 1;
        }
    }

    public function get_display_score( $rules, $post_id, $rule_type = 'include' ) {
        $highest_score = -1;
        if ( empty( $rules ) || ! is_array( $rules ) ) {
            return $highest_score;
        }

        foreach ( $rules as $rule ) {
            if ( $this->is_rule_matched( $rule, $post_id, $rule_type ) ) {
                $score = $this->get_rule_score( $rule );
                if ( $score > $highest_score ) {
                    $highest_score = $score;
                }
            }
        }
        return $highest_score;
    }

    private function is_rule_matched( $rule, $post_id, $rule_type = 'include' ) {
        if ( 'specifics' === $rule ) {
            $meta_key = ( 'include' === $rule_type ) ? '_royal_hf_target_include_specific' : '_royal_hf_target_exclude_specific';
            $specifics = get_post_meta( $post_id, $meta_key, true );
            
            if ( empty( $specifics ) || ! is_array( $specifics ) ) {
                return false;
            }
            $current_id = get_queried_object_id();
            if ( is_singular() && in_array( 'post-' . $current_id, $specifics ) ) {
                return true;
            }
            if ( is_tax() || is_category() || is_tag() ) {
                 if( in_array( 'tax-' . $current_id, $specifics ) ) {
                    return true;
                 }
            }
            return false;
        }

        $rule_parts = explode( '|', $rule );
        $general_rule = $rule_parts[0];

        switch ( $general_rule ) {
            case 'basic-global': return true;
            case 'basic-singulars': return is_singular();
            case 'basic-archives': return is_archive();
            case 'special-404': return is_404();
            case 'special-search': return is_search();
            case 'special-blog': return is_home();
            case 'special-front': return is_front_page();
            case 'special-date': return is_date();
            case 'special-author': return is_author();
            default: // This handles post types and taxonomies
                if ( isset( $rule_parts[1] ) && 'all' === $rule_parts[1] ) {
                    if ( isset( $rule_parts[2] ) && 'taxarchive' === $rule_parts[2] ) {
                        $taxonomy = $rule_parts[3] ?? false;
                        return is_tax( $taxonomy );
                    }
                    $is_archive = isset( $rule_parts[2] ) && 'archive' === $rule_parts[2];
                    if ( $is_archive ) {
                        return is_post_type_archive( $general_rule );
                    }
                    return is_singular( $general_rule );
                }
        }
        return false;
    }

    public function parse_layout_display_condition( $rules, $post_id, $rule_type = 'include' ) {
        if ( empty( $rules ) || ! is_array( $rules ) ) {
            return false;
        }
        foreach ( $rules as $rule ) {
            if ( $this->is_rule_matched( $rule, $post_id, $rule_type ) ) {
                return true;
            }
        }
        return false;
    }

    public function parse_user_role_condition( $rules ) {
        if ( empty( $rules ) || ! is_array( $rules ) || in_array( 'all', $rules ) ) {
            return true;
        }
        $is_logged_in = is_user_logged_in();
        if ( in_array( 'logged-in', $rules ) && $is_logged_in ) {
            return true;
        }
        if ( in_array( 'logged-out', $rules ) && ! $is_logged_in ) {
            return true;
        }
        if ( $is_logged_in ) {
            $current_user = wp_get_current_user();
            $user_roles = $current_user->roles;
            if ( ! empty( array_intersect( $user_roles, $rules ) ) ) {
                return true;
            }
        }
        return false;
    }
}
