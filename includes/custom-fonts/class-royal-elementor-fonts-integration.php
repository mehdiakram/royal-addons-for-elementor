<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Royal_Addons_Custom_Fonts_Elementor_Fonts_Integration {

    public function __construct() {
        add_filter( 'elementor/fonts/groups', array( $this, 'add_custom_font_group' ) );
        add_filter( 'elementor/fonts/additional_fonts', array( $this, 'add_custom_fonts_to_elementor' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_custom_fonts_frontend' ) );
        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_custom_fonts_editor' ) );
    }

    /**
     * Add a custom font group to Elementor's font dropdown.
     */
    public function add_custom_font_group( $font_groups ) {
        $font_groups['royal_custom_fonts_group'] = __( 'Royal Custom Fonts', 'royal-addons-custom-fonts' );
        return $font_groups;
    }

    /**
     * Add custom fonts to Elementor's available fonts.
     */
    public function add_custom_fonts_to_elementor( $additional_fonts ) {
        $custom_fonts = $this->get_all_custom_fonts_data();
        if ( ! empty( $custom_fonts ) ) {
            foreach ( $custom_fonts as $font_name => $font_data_variants ) {
                $additional_fonts[ $font_name ] = 'royal_custom_fonts_group';
            }
        }
        return $additional_fonts;
    }

    /**
     * Enqueue custom fonts on the frontend.
     */
    public function enqueue_custom_fonts_frontend() {
        $this->generate_and_enqueue_font_css();
    }

    /**
     * Enqueue custom fonts in the Elementor editor.
     */
    public function enqueue_custom_fonts_editor() {
        $this->generate_and_enqueue_font_css();
    }

    /**
     * Get all custom font data from the CPT.
     * Returns an array where keys are font names and values are their variants data.
     */
    private function get_all_custom_fonts_data() {
        $fonts = get_posts( array(
            'post_type'      => 'royal_custom_font',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'fields'         => 'ids', // Get only IDs for performance
        ) );

        $custom_fonts_data = array();
        if ( ! empty( $fonts ) ) {
            foreach ( $fonts as $font_id ) {
                $font_name = get_the_title( $font_id );
                $font_variants = get_post_meta( $font_id, '_royal_custom_font_data', true );
                if ( ! empty( $font_name ) && is_array( $font_variants ) ) {
                    $custom_fonts_data[ $font_name ] = $font_variants;
                }
            }
        }
        return $custom_fonts_data;
    }

    /**
     * Generate and enqueue the @font-face CSS for all custom fonts.
     */
    private function generate_and_enqueue_font_css() {
        $custom_fonts = $this->get_all_custom_fonts_data();
        $generated_css = '';

        foreach ( $custom_fonts as $font_name => $variants ) {
            foreach ( $variants as $variant_data ) {
                $src_parts = array();
                if ( ! empty( $variant_data['woff2'] ) ) {
                    $src_parts[] = "url('" . esc_url( $variant_data['woff2'] ) . "') format('woff2')";
                }
                if ( ! empty( $variant_data['woff'] ) ) {
                    $src_parts[] = "url('" . esc_url( $variant_data['woff'] ) . "') format('woff')";
                }
                if ( ! empty( $variant_data['ttf'] ) ) {
                    $src_parts[] = "url('" . esc_url( $variant_data['ttf'] ) . "') format('truetype')";
                }
                if ( ! empty( $variant_data['otf'] ) ) {
                    $src_parts[] = "url('" . esc_url( $variant_data['otf'] ) . "') format('opentype')";
                }

                if ( ! empty( $src_parts ) ) {
                    $generated_css .= "@font-face {";
                    $generated_css .= "font-family: '" . esc_attr( $font_name ) . "';";
                    $generated_css .= "src: " . implode( ', ', $src_parts ) . ";";
                    $generated_css .= "font-weight: " . esc_attr( $variant_data['weight'] ) . ";";
                    $generated_css .= "font-style: " . esc_attr( $variant_data['style'] ) . ";";
                    $generated_css .= "font-display: swap; /* Improve performance with font-display */";
                    $generated_css .= "}";
                }
            }
        }

        if ( ! empty( $generated_css ) ) {
            // Enqueue the CSS
            wp_add_inline_style( 'royal-addons-custom-fonts-style', $generated_css );
        }
    }
}