<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use RoyalAddons\Elementor\Royal_Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalSlides extends Widget_Base {

    public function get_name() {
        return 'royalslides';
    }

    public function get_title() {
        return esc_html__( 'Royal Slides', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-slider-3d rtbranding'; }
    
    public function get_keywords() {
        return [ 'slide', 'slider', 'royal slide', 'templates', 'woodmart', 'royal', 'mehdi', 'akram', 'tech', 'technologies' ];
    }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_style_depends() {
        return [ 'royalowlcarousel', 'royalowlcarouseltheme', 'royalcarousel' ];
    }

    public function get_script_depends() {
        return [ 'royalowlcarousel', 'royalcarousel' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__( 'Query', 'royal-addons-for-elementor' ),
            ]
        );

        $sliders = get_terms( [
            'taxonomy'   => 'royal-slider',
            'hide_empty' => false,
        ] );

        $slider_options = [
            '' => esc_html__( 'Select Slider', 'royal-addons-for-elementor' ),
        ];

        if ( ! is_wp_error( $sliders ) && ! empty( $sliders ) ) {
            foreach ( $sliders as $slider ) {
                $slider_options[ $slider->term_id ] = $slider->name;
            }
        }

        $this->add_control(
            'slider_id',
            [
                'label'   => esc_html__( 'Select Slider', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $slider_options,
                'default' => '',
            ]
        );

        $this->end_controls_section();

        // Include carousel options using the helper
        Royal_Helpers::royal_carousel_options( $this );
        Royal_Helpers::royal_style_nav_options( $this );
        Royal_Helpers::royal_style_dot_options( $this );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['slider_id'] ) ) {
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo '<div class="royal-elementor-alert">' . esc_html__( 'Please select a slider to display.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        $query_args = [
            'post_type'      => 'royal-slide',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => [
                [
                    'taxonomy' => 'royal-slider',
                    'field'    => 'term_id',
                    'terms'    => $settings['slider_id'],
                ],
            ],
            // Order logic can be added here
        ];

        $slides_query = new \WP_Query( $query_args );

        if ( ! $slides_query->have_posts() ) {
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo '<div class="royal-elementor-alert">' . esc_html__( 'No slides found in this slider.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        $id          = $this->get_id();
        $carouselid  = 'royalcarousel' . $id;
        $loop        = $settings['loop'] ?? 'yes';
        $autoplay    = $settings['autoplay'] ?? 'yes';
        $margin      = $settings['margin'] ?? 0;
        $timeout     = $settings['timeout'] ?? 5000;
        $navposition = $settings['navposition'] ?? '';
        $dotposition = $settings['dotposition'] ?? '';

        $previous_icon_html = '';
        $next_icon_html = '';
        if ( isset( $settings['previousicon']['value'] ) && ! empty( $settings['previousicon']['library'] ) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon( $settings['previousicon'], [ 'aria-hidden' => 'true' ] );
            $previous_icon_html = ob_get_clean();
        }

        if ( isset( $settings['nexticon']['value'] ) && ! empty( $settings['nexticon']['library'] ) ) {
            ob_start();
            \Elementor\Icons_Manager::render_icon( $settings['nexticon'], [ 'aria-hidden' => 'true' ] );
            $next_icon_html = ob_get_clean();
        }
        $navtext = wp_json_encode( [ $previous_icon_html, $next_icon_html ] );

        $desktopitems = $settings['desktopitems'] ?? 1;
        $desktopdots  = ( 'yes' === ( $settings['desktopdots'] ?? 'yes' ) ) ? 'true' : 'false';
        $desktopnav   = ( 'yes' === ( $settings['desktopnav'] ?? 'yes' ) ) ? 'true' : 'false';

        $tabitems = $settings['tabitems'] ?? 1;
        $tabdots  = ( 'yes' === ( $settings['tabdots'] ?? 'yes' ) ) ? 'true' : 'false';
        $tabnav   = ( 'yes' === ( $settings['tabnav'] ?? 'yes' ) ) ? 'true' : 'false';

        $mobileitems = $settings['mobileitems'] ?? 1;
        $mobiledots  = ( 'yes' === ( $settings['mobiledots'] ?? 'yes' ) ) ? 'true' : 'false';
        $mobilenav   = ( 'yes' === ( $settings['mobilenav'] ?? 'yes' ) ) ? 'true' : 'false';

        $this->add_render_attribute(
            'royal_carousel_options',
            [
                'id'                   => $carouselid,
                'data-loop'            => $loop,
                'data-autoplay'        => $autoplay,
                'data-margin'          => $margin,
                'data-autoplayTimeout' => $timeout,
                'data-navtext'         => $navtext,
                'data-desktopitems'    => $desktopitems,
                'data-desktopdots'     => $desktopdots,
                'data-desktopnav'      => $desktopnav,
                'data-tabitems'        => $tabitems,
                'data-tabdots'         => $tabdots,
                'data-tabnav'          => $tabnav,
                'data-mobileitems'     => $mobileitems,
                'data-mobiledots'      => $mobiledots,
                'data-mobilenav'       => $mobilenav,
                'data-animatein'       => $settings['animate_in'] ?? 'none',
                'data-animateout'      => $settings['animate_out'] ?? 'none',
            ]
        );

        echo '<div class="royalmastercarousel royalslides-widget">';
        echo '<div class="royalcarousel owl-carousel owl-theme ' . esc_attr( $navposition ) . ' ' . esc_attr( $dotposition ) . '" ' . $this->get_render_attribute_string( 'royal_carousel_options' ) . '>';

        // Prevent WP notice about missing elementor-frontend dependency when rendering nested templates in editor
        if ( ! wp_style_is( 'elementor-frontend', 'registered' ) ) {
            wp_register_style( 'elementor-frontend', false );
        }

        while ( $slides_query->have_posts() ) {
            $slides_query->the_post();
            global $post;
            
            echo '<div class="item royal-slide-item">';
            
            // Backup slide data
            $slide_id = get_the_ID();
            $raw_content = $post->post_content;
            
            // Render the Elementor content of the slide
            $elementor = \Elementor\Plugin::instance();
            
            // IMPORTANT: Elementor's get_builder_content_for_display checks if the requested ID 
            // is equal to get_the_ID() to prevent infinite loops. Since the_post() sets get_the_ID() 
            // to the slide ID, Elementor throws an "Invalid Data" error.
            // We must reset postdata temporarily so get_the_ID() returns the main page ID!
            wp_reset_postdata();
            
            // Get Elementor content with CSS
            $content = $elementor->frontend->get_builder_content_for_display( $slide_id, true );
            
            // Fallback to standard WP content if not built with Elementor or empty
            if ( empty( trim( $content ) ) ) {
                $content = apply_filters( 'the_content', $raw_content );
            }
            
            echo $content;
            
            echo '</div>';
            
            // Restore the slide post for the next iteration of the while loop
            $post = get_post( $slide_id );
            setup_postdata( $post );
        }
        wp_reset_postdata();

        echo '</div>';
        echo '</div>';
    }
}
