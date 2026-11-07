<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalGoogleReviews extends Widget_Base {
    
    public function get_name() {
        return 'royalgooglereviews';
    }
    
    public function get_title() {
        return __( 'Google Reviews', 'royal-addons-for-elementor' );
    }

    public function get_icon() { 
        return 'eicon-review'; 
    }

    public function get_categories() {
        return ['royaltech'];
    }
    
    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Settings', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'reviews_count',
            [
                'label' => __( 'Number of Reviews', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 5,
            ]
        );
        
        $this->add_responsive_control(
            'columns',
            [
                'label' => __( 'Columns', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-google-reviews-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->end_controls_section();
        
        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Card Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'card_bg',
            [
                'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-review-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-review-card' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $is_connected = get_option('royaladdons_google_connected') === 'yes';
        $license_key  = get_option('royaladdons_license_key', '');
        $reviews_count = $settings['reviews_count'];

        if ( ! $is_connected || empty($license_key) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'Please connect your Google account from Royal Addons -> Social settings.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        // Fetch reviews from RoyalAuth API
        $transient_key = 'royal_google_feed_proxy_' . md5( $license_key . $reviews_count );
        $reviews = get_transient( $transient_key );

        if ( false === $reviews ) {
            $api_url = "https://auth.royaltechbd.com/api/social/feed";
            $api_url = add_query_arg( [
                'platform' => 'google',
                'limit'    => $reviews_count,
            ], $api_url );

            $response = wp_remote_get( $api_url, [
                'headers' => [
                    'X-License-Key' => $license_key
                ],
                'timeout' => 15
            ]);

            if ( is_wp_error( $response ) ) {
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                    echo '<div class="elementor-alert elementor-alert-danger">' . esc_html__( 'Unable to connect to RoyalAuth API.', 'royal-addons-for-elementor' ) . '</div>';
                }
                return;
            }

            $body = json_decode( wp_remote_retrieve_body( $response ), true );

            if ( isset( $body['success'] ) && $body['success'] === false ) {
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                    $error_msg = isset($body['error']) ? $body['error'] : 'Unknown Error';
                    echo '<div class="elementor-alert elementor-alert-danger">API Error: ' . esc_html( $error_msg ) . '</div>';
                }
                return;
            }

            $reviews = isset($body['data']) ? $body['data'] : [];
            set_transient( $transient_key, $reviews, 4 * HOUR_IN_SECONDS );
        }
        
        ?>
        <style>
            .royal-google-reviews-grid {
                display: grid;
                gap: 20px;
            }
            .royal-review-card {
                padding: 20px;
                border-radius: 8px;
                border: 1px solid #eee;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }
            .royal-review-header {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 15px;
            }
            .royal-reviewer-img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
            }
            .royal-reviewer-name {
                font-weight: bold;
                font-size: 16px;
                margin: 0;
            }
            .royal-review-rating {
                color: #fbbc05;
                font-size: 18px;
            }
            .royal-review-text {
                font-size: 14px;
                line-height: 1.6;
            }
        </style>

        <div class="royal-google-reviews-grid">
            <?php if ( !empty($reviews) ) : ?>
                <?php foreach ( $reviews as $review ) : 
                    // Assume standard Google review format: author_name, profile_photo_url, rating, text
                    $author_name = isset($review['author_name']) ? $review['author_name'] : 'User';
                    $profile_photo_url = isset($review['profile_photo_url']) ? $review['profile_photo_url'] : 'https://ui-avatars.com/api/?name='.urlencode($author_name);
                    $rating = isset($review['rating']) ? (int)$review['rating'] : 5;
                    $text = isset($review['text']) ? $review['text'] : '';
                ?>
                <div class="royal-review-card">
                    <div class="royal-review-header">
                        <img class="royal-reviewer-img" src="<?php echo esc_url($profile_photo_url); ?>" alt="<?php echo esc_attr($author_name); ?>">
                        <div>
                            <p class="royal-reviewer-name"><?php echo esc_html($author_name); ?></p>
                            <div class="royal-review-rating">
                                <?php echo str_repeat('&#9733;', $rating) . str_repeat('&#9734;', 5 - $rating); ?>
                            </div>
                        </div>
                    </div>
                    <div class="royal-review-text">
                        <?php echo wp_kses_post( wp_trim_words( $text, 40 ) ); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p><?php _e('No reviews found.', 'royal-addons-for-elementor'); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }
}
