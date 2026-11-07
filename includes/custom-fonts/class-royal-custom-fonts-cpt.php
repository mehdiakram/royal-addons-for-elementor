<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Royal_Addons_Custom_Fonts_Cpt {

    public function __construct() {
        add_action( 'init', array( $this, 'register_cpt' ) );
        add_action( 'admin_menu', array( $this, 'add_custom_fonts_submenu' ), 999 );
        
        add_action( 'add_meta_boxes', array( $this, 'add_font_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_font_meta_box_data' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 999 ); // <-- run after default admin scripts
        add_filter( 'manage_royal_custom_font_posts_columns', array( $this, 'set_custom_columns' ) );
        add_action( 'manage_royal_custom_font_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
        add_filter( 'manage_edit-royal_custom_font_sortable_columns', array( $this, 'set_sortable_columns' ) );
        add_action( 'before_delete_post', array( $this, 'delete_font_files_on_post_delete' ) );
    }

    public function register_cpt() {
        $labels = array(
            'name'                  => _x( 'Custom Fonts', 'Post Type General Name', 'royal-addons-for-elementor' ),
            'singular_name'         => _x( 'Custom Font', 'Post Type Singular Name', 'royal-addons-for-elementor' ),
            'menu_name'             => __( 'Custom Fonts', 'royal-addons-for-elementor' ),
            'name_admin_bar'        => __( 'Custom Font', 'royal-addons-for-elementor' ),
            'archives'              => __( 'Font Archives', 'royal-addons-for-elementor' ),
            'attributes'            => __( 'Font Attributes', 'royal-addons-for-elementor' ),
            'parent_item_colon'     => __( 'Parent Font:', 'royal-addons-for-elementor' ),
            'all_items'             => __( 'All Custom Fonts', 'royal-addons-for-elementor' ),
            'add_new_item'          => __( 'Add New Custom Font', 'royal-addons-for-elementor' ),
            'add_new'               => __( 'Add New', 'royal-addons-for-elementor' ),
            'new_item'              => __( 'New Custom Font', 'royal-addons-for-elementor' ),
            'edit_item'             => __( 'Edit Custom Font', 'royal-addons-for-elementor' ),
            'update_item'           => __( 'Update Custom Font', 'royal-addons-for-elementor' ),
            'view_item'             => __( 'View Custom Font', 'royal-addons-for-elementor' ),
            'view_items'            => __( 'View Custom Fonts', 'royal-addons-for-elementor' ),
            'search_items'          => __( 'Search Custom Font', 'royal-addons-for-elementor' ),
            'not_found'             => __( 'Not found', 'royal-addons-for-elementor' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'royal-addons-for-elementor' ),
            'featured_image'        => __( 'Featured Image', 'royal-addons-for-elementor' ),
            'set_featured_image'    => __( 'Set featured image', 'royal-addons-for-elementor' ),
            'remove_featured_image' => __( 'Remove featured image', 'royal-addons-for-elementor' ),
            'use_featured_image'    => __( 'Use as featured image', 'royal-addons-for-elementor' ),
            'insert_into_item'      => __( 'Insert into font', 'royal-addons-for-elementor' ),
            'uploaded_to_this_item' => __( 'Uploaded to this font', 'royal-addons-for-elementor' ),
            'items_list'            => __( 'Fonts list', 'royal-addons-for-elementor' ),
            'items_list_navigation' => __( 'Fonts list navigation', 'royal-addons-for-elementor' ),
            'filter_items_list'     => __( 'Filter fonts list', 'royal-addons-for-elementor' ),
        );
        $args = array(
            'label'                 => __( 'Custom Font', 'royal-addons-for-elementor' ),
            'description'           => __( 'Allows you to upload and manage custom fonts for Elementor.', 'royal-addons-for-elementor' ),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
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
            'capability_type'       => 'post',
            'show_in_rest'          => false,
        );
        register_post_type( 'royal_custom_font', $args );
    }

    public function add_font_meta_box() {
        add_meta_box(
            'royal_custom_font_files',
            __( 'Font Files & Variants', 'royal-addons-for-elementor' ),
            array( $this, 'render_font_meta_box' ),
            'royal_custom_font',
            'normal',
            'high'
        );
    }

    public function render_font_meta_box( $post ) {
        wp_nonce_field( 'royal_save_font_meta', 'royal_font_meta_nonce' );

        $font_data = get_post_meta( $post->ID, '_royal_custom_font_data', true );
        if ( ! is_array( $font_data ) || empty( $font_data ) ) {
            $font_data = array(
                array(
                    'weight'    => 'regular',
                    'style'     => 'normal',
                    'woff'      => '',
                    'woff2'     => '',
                    'ttf'       => '',
                    'otf'       => '',
                ),
            );
        }
        ?>
        <div id="royal-font-files-wrapper">
            <p class="description"><?php _e( 'Upload font files for different weights and styles. It is recommended to upload WOFF2 for modern browsers and WOFF for broader compatibility. TTF/OTF are often used as fallbacks or for specific scenarios.', 'royal-addons-for-elementor' ); ?></p>
            <table class="form-table royal-font-table">
                <thead>
                    <tr>
                        <th style="width: 30%;"><?php _e( 'Options', 'royal-addons-for-elementor' ); ?></th>
                        <th style="width: 70%;"><?php _e( 'Font Files', 'royal-addons-for-elementor' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $font_data as $index => $data ) : ?>
                        <tr class="royal-font-row">
                            <td>
                                <div class="royal-font-options-group">
                                    <div class="royal-font-option-wrapper">
                                        <label for="royal_font_data_<?php echo esc_attr( $index ); ?>_weight"><?php _e( 'Weight', 'royal-addons-for-elementor' ); ?>:</label>
                                        <select id="royal_font_data_<?php echo esc_attr( $index ); ?>_weight" name="royal_font_data[<?php echo esc_attr( $index ); ?>][weight]">
                                            <?php
                                            $weights = array(
                                                '100' => '100 (Thin)', '200' => '200 (Extra Light)', '300' => '300 (Light)',
                                                'normal' => '400 (Normal / Regular)', '500' => '500 (Medium)', '600' => '600 (Semi Bold)',
                                                'bold' => '700 (Bold)', '800' => '800 (Extra Bold)', '900' => '900 (Black)',
                                            );
                                            foreach ( $weights as $value => $label ) {
                                                printf( '<option value="%s" %s>%s</option>', esc_attr( $value ), selected( $data['weight'], $value, false ), esc_html( $label ) );
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="royal-font-option-wrapper">
                                        <label for="royal_font_data_<?php echo esc_attr( $index ); ?>_style"><?php _e( 'Style', 'royal-addons-for-elementor' ); ?>:</label>
                                        <select id="royal_font_data_<?php echo esc_attr( $index ); ?>_style" name="royal_font_data[<?php echo esc_attr( $index ); ?>][style]">
                                            <?php
                                            $styles = array(
                                                'normal'  => 'Normal', 'italic'  => 'Italic', 'oblique' => 'Oblique',
                                            );
                                            foreach ( $styles as $value => $label ) {
                                                printf( '<option value="%s" %s>%s</option>', esc_attr( $value ), selected( $data['style'], $value, false ), esc_html( $label ) );
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="button" class="button button-secondary royal-remove-row"><?php _e( 'Remove Row', 'royal-addons-for-elementor' ); ?></button>
                                </div>
                            </td>
                            <td>
                                <div class="royal-font-files-group">
                                    <?php
                                    $font_formats_info = array(
                                        'woff2' => __( 'WOFF2 File', 'royal-addons-for-elementor' ),
                                        'woff'  => __( 'WOFF File', 'royal-addons-for-elementor' ),
                                        'ttf'   => __( 'TTF File', 'royal-addons-for-elementor' ),
                                        'otf'   => __( 'OTF File', 'royal-addons-for-elementor' ),
                                    );
                                    foreach ( $font_formats_info as $format => $label ) :
                                        $file_url = isset( $data[ $format ] ) ? esc_url( $data[ $format ] ) : '';
                                        ?>
                                        <div class="royal-font-file-input-wrapper">
                                            <label><?php echo esc_html( $label ); ?>:</label>
                                            <input type="text" class="royal-font-file-url" name="royal_font_data[<?php echo esc_attr( $index ); ?>][<?php echo esc_attr( $format ); ?>]" value="<?php echo $file_url; ?>" placeholder="<?php esc_attr_e( 'Upload or enter URL', 'royal-addons-for-elementor' ); ?>" />
                                            <div class="button-group">
                                                <button type="button" class="button royal-upload-button" data-file-type="<?php echo esc_attr( $format ); ?>"><?php _e( 'Upload', 'royal-addons-for-elementor' ); ?></button>
                                                <?php if ( $file_url ) : ?>
                                                    <button type="button" class="button button-secondary royal-remove-button"><?php _e( 'Remove', 'royal-addons-for-elementor' ); ?></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>
                <button type="button" class="button button-primary" id="royal-add-font-row"><?php _e( 'Add Font Variant', 'royal-addons-for-elementor' ); ?></button>
            </p>
        </div>

        <script type="text/template" id="royal-font-row-template">
            <tr class="royal-font-row">
                <td>
                    <div class="royal-font-options-group">
                        <div class="royal-font-option-wrapper">
                            <label for="royal_font_data___INDEX___weight"><?php _e( 'Weight', 'royal-addons-for-elementor' ); ?>:</label>
                            <select id="royal_font_data___INDEX___weight" name="royal_font_data[__INDEX__][weight]">
                                <option value="100">100 (Thin)</option>
                                <option value="200">200 (Extra Light)</option>
                                <option value="300">300 (Light)</option>
                                <option value="normal" selected>400 (Normal / Regular)</option>
                                <option value="500">500 (Medium)</option>
                                <option value="600">600 (Semi Bold)</option>
                                <option value="bold">700 (Bold)</option>
                                <option value="800">800 (Extra Bold)</option>
                                <option value="900">900 (Black)</option>
                            </select>
                        </div>
                        <div class="royal-font-option-wrapper">
                            <label for="royal_font_data___INDEX___style"><?php _e( 'Style', 'royal-addons-for-elementor' ); ?>:</label>
                            <select id="royal_font_data___INDEX___style" name="royal_font_data[__INDEX__][style]">
                                <option value="normal" selected>Normal</option>
                                <option value="italic">Italic</option>
                                <option value="oblique">Oblique</option>
                            </select>
                        </div>
                        <button type="button" class="button button-secondary royal-remove-row"><?php _e( 'Remove Row', 'royal-addons-for-elementor' ); ?></button>
                    </div>
                </td>
                <td>
                    <div class="royal-font-files-group">
                        <div class="royal-font-file-input-wrapper">
                            <label><?php _e( 'WOFF2 File', 'royal-addons-for-elementor' ); ?>:</label>
                            <input type="text" class="royal-font-file-url" name="royal_font_data[__INDEX__][woff2]" value="" placeholder="<?php esc_attr_e( 'Upload or enter URL', 'royal-addons-for-elementor' ); ?>" />
                            <div class="button-group">
                                <button type="button" class="button royal-upload-button" data-file-type="woff2"><?php _e( 'Upload', 'royal-addons-for-elementor' ); ?></button>
                            </div>
                        </div>
                        <div class="royal-font-file-input-wrapper">
                            <label><?php _e( 'WOFF File', 'royal-addons-for-elementor' ); ?>:</label>
                            <input type="text" class="royal-font-file-url" name="royal_font_data[__INDEX__][woff]" value="" placeholder="<?php esc_attr_e( 'Upload or enter URL', 'royal-addons-for-elementor' ); ?>" />
                            <div class="button-group">
                                <button type="button" class="button royal-upload-button" data-file-type="woff"><?php _e( 'Upload', 'royal-addons-for-elementor' ); ?></button>
                            </div>
                        </div>
                        <div class="royal-font-file-input-wrapper">
                            <label><?php _e( 'TTF File', 'royal-addons-for-elementor' ); ?>:</label>
                            <input type="text" class="royal-font-file-url" name="royal_font_data[__INDEX__][ttf]" value="" placeholder="<?php esc_attr_e( 'Upload or enter URL', 'royal-addons-for-elementor' ); ?>" />
                            <div class="button-group">
                                <button type="button" class="button royal-upload-button" data-file-type="ttf"><?php _e( 'Upload', 'royal-addons-for-elementor' ); ?></button>
                            </div>
                        </div>
                        <div class="royal-font-file-input-wrapper">
                            <label><?php _e( 'OTF File', 'royal-addons-for-elementor' ); ?>:</label>
                            <input type="text" class="royal-font-file-url" name="royal_font_data[__INDEX__][otf]" value="" placeholder="<?php esc_attr_e( 'Upload or enter URL', 'royal-addons-for-elementor' ); ?>" />
                            <div class="button-group">
                                <button type="button" class="button royal-upload-button" data-file-type="otf"><?php _e( 'Upload', 'royal-addons-for-elementor' ); ?></button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </script>
        <?php
    }

    public function save_font_meta_box_data( $post_id ) {
        if ( ! isset( $_POST['royal_font_meta_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['royal_font_meta_nonce'], 'royal_save_font_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] ) && 'royal_custom_font' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        } else {
            return;
        }

        if ( isset( $_POST['royal_font_data'] ) && is_array( $_POST['royal_font_data'] ) ) {
            $cleaned_data = array();
            foreach ( $_POST['royal_font_data'] as $font_entry ) {
                $cleaned_entry = array(
                    'weight'    => sanitize_text_field( $font_entry['weight'] ),
                    'style'     => sanitize_text_field( $font_entry['style'] ),
                    'woff'      => esc_url_raw( $font_entry['woff'] ),
                    'woff2'     => esc_url_raw( $font_entry['woff2'] ),
                    'ttf'       => esc_url_raw( $font_entry['ttf'] ),
                    'otf'       => esc_url_raw( $font_entry['otf'] ),
                );
                if ( ! empty( array_filter( $cleaned_entry, function($k) { return in_array($k, ['woff','woff2','ttf','otf']); }, ARRAY_FILTER_USE_KEY ) ) ) {
                     $cleaned_data[] = $cleaned_entry;
                }
            }
            update_post_meta( $post_id, '_royal_custom_font_data', $cleaned_data );
        } else {
            delete_post_meta( $post_id, '_royal_custom_font_data' );
        }
    }


    public function add_custom_fonts_submenu() {
        add_submenu_page(
            'royaladdonsforelementor',
            __( 'Custom Fonts', 'royal-addons-for-elementor' ),
            __( 'Custom Fonts', 'royal-addons-for-elementor' ),
            'manage_options',
            'edit.php?post_type=royal_custom_font',
            false
        );
    }


    public function enqueue_admin_scripts( $hook_suffix ) {
        $screen = get_current_screen();

        // Exit immediately if we're not on a screen related to our custom post type.
        // This single check replaces all the previous `if/elseif` conditions.
        if ( ! $screen || 'royal_custom_font' !== $screen->post_type ) {
            return;
        }

        // Enqueue media uploader scripts and our custom scripts/styles.
        wp_enqueue_media();
        wp_enqueue_script( 'royal-font-admin', ROYAL_ADDONS_DIR_URL . 'assets/js/admin-custom-fonts.js', array( 'jquery' ), ROYAL_ADDONS_VERSION, true );
        wp_enqueue_style( 'royal-font-admin', ROYAL_ADDONS_DIR_URL . 'assets/css/admin-custom-fonts.css', array(), ROYAL_ADDONS_VERSION );

        // Localize script for translations and data.
        wp_localize_script( 'royal-font-admin', 'royalFontAdmin', array(
            'allowedFileTypes' => array(
                'woff'  => array( 'woff' ),
                'woff2' => array( 'woff2' ),
                'ttf'   => array( 'ttf' ),
                'otf'   => array( 'otf' ),
            ),
            'i18n' => array(
                'selectFontTitle' => __( 'Select Font File', 'royal-addons-for-elementor' ),
                'useFontButton'   => __( 'Use This Font', 'royal-addons-for-elementor' ),
            ),
        ) );
    }


    public function set_custom_columns( $columns ) {
        $new_columns = array(
            'cb'          => '<input type="checkbox" />',
            'title'       => __( 'Font Name', 'royal-addons-for-elementor' ),
            'formats'     => __( 'Formats', 'royal-addons-for-elementor' ),
            'preview'     => __( 'Preview', 'royal-addons-for-elementor' ),
            'date'        => __( 'Date', 'royal-addons-for-elementor' ),
        );
        return $new_columns;
    }

    public function render_custom_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'formats':
                $font_data = get_post_meta( $post_id, '_royal_custom_font_data', true );
                $available_formats = array();
                if ( is_array( $font_data ) ) {
                    foreach ( $font_data as $data_entry ) {
                        if ( ! empty( $data_entry['woff2'] ) ) $available_formats['WOFF2'] = true;
                        if ( ! empty( $data_entry['woff'] ) ) $available_formats['WOFF'] = true;
                        if ( ! empty( $data_entry['ttf'] ) ) $available_formats['TTF'] = true;
                        if ( ! empty( $data_entry['otf'] ) ) $available_formats['OTF'] = true;
                    }
                }
                echo implode( ', ', array_keys( $available_formats ) );
                break;
            case 'preview':
                $font_name = get_the_title( $post_id );
                $font_data = get_post_meta( $post_id, '_royal_custom_font_data', true );
                if ( is_array( $font_data ) && ! empty( $font_data ) ) {
                    $first_variant = $font_data[0];

                    $woff2 = !empty($first_variant['woff2']) ? $first_variant['woff2'] : '';
                    $woff = !empty($first_variant['woff']) ? $first_variant['woff'] : '';
                    $ttf = !empty($first_variant['ttf']) ? $first_variant['ttf'] : '';
                    $otf = !empty($first_variant['otf']) ? $first_variant['otf'] : '';

                    if ( $woff2 || $woff || $ttf || $otf ) {
                        $css = "
                        @font-face {
                            font-family: '{$font_name}';
                            src: ";
                            if ($woff2) $css .= "url('{$woff2}') format('woff2'),";
                            if ($woff) $css .= "url('{$woff}') format('woff'),";
                            if ($ttf) $css .= "url('{$ttf}') format('truetype'),";
                            if ($otf) $css .= "url('{$otf}') format('opentype');";
                            $css = rtrim($css, ',');
                            $css .= "font-weight: normal;
                            font-style: normal;
                        }";
                        echo '<style>' . $css . '</style>';
                        echo '<div style="font-family: \'' . esc_attr( $font_name ) . '\'; font-size: 20px; line-height: 1.2; border: 1px solid #ddd; padding: 5px; min-width: 150px; text-align: center;">';
                        echo esc_html( $font_name );
                        echo '<br>Royal Technologies 0123456789';
                        echo '</div>';
                    } else {
                        echo '<em>' . __( 'No files uploaded', 'royal-addons-for-elementor' ) . '</em>';
                    }
                } else {
                    echo '<em>' . __( 'No files uploaded', 'royal-addons-for-elementor' ) . '</em>';
                }
                break;
        }
    }

    public function set_sortable_columns( $columns ) {
        $columns['title'] = 'title';
        return $columns;
    }

    public function delete_font_files_on_post_delete( $post_id ) {
        if ( get_post_type( $post_id ) !== 'royal_custom_font' ) {
            return;
        }

        $font_data = get_post_meta( $post_id, '_royal_custom_font_data', true );

        if ( is_array( $font_data ) ) {
            foreach ( $font_data as $data_entry ) {
                $file_urls = array_filter( $data_entry, function( $key ) {
                    return in_array( $key, array( 'woff', 'woff2', 'ttf', 'otf' ) );
                }, ARRAY_FILTER_USE_KEY );

                foreach ( $file_urls as $file_url ) {
                    if ( ! empty( $file_url ) ) {
                        $attachment_id = attachment_url_to_postid( $file_url );
                        if ( $attachment_id ) {
                            wp_delete_attachment( $attachment_id, true );
                        }
                    }
                }
            }
        }
    }
}