<?php
namespace RoyalAddons\Widgets\LayoutWidgets\Woocommerce;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class WC_Hook extends Widget_Base {
    public function get_name() { return 'royal-wc-hook'; }
    public function get_title() { return 'WooCommerce Hook'; }
    public function get_icon() { return 'eicon-code rtbranding'; }
    public function get_categories() { return ['royaltech_singleproduct']; }
    public function get_keywords() { return [ 'woocommerce', 'hook', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ]; }


    protected function register_controls() {
        $this->start_controls_section( 'section_general', [
            'label' => __('General', 'royal-addons-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'hook', [
            'label' => __('Hook', 'royal-addons-for-elementor'),
            'description' => 'Select which WooCommerce action hook to display.',
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'options'     => [
                '0' => 'Select',
                // Single Product hooks
                'woocommerce_before_single_product'                  => 'woocommerce_before_single_product',
                'woocommerce_before_single_product_summary'          => 'woocommerce_before_single_product_summary',
                'woocommerce_product_thumbnails'                     => 'woocommerce_product_thumbnails',
                'woocommerce_single_product_summary'                 => 'woocommerce_single_product_summary',
                'woocommerce_before_add_to_cart_form'                => 'woocommerce_before_add_to_cart_form',
                'woocommerce_before_variations_form'                 => 'woocommerce_before_variations_form',
                'woocommerce_before_add_to_cart_button'              => 'woocommerce_before_add_to_cart_button',
                'woocommerce_before_single_variation'                => 'woocommerce_before_single_variation',
                'woocommerce_single_variation'                       => 'woocommerce_single_variation',
                'woocommerce_after_single_variation'                 => 'woocommerce_after_single_variation',
                'woocommerce_after_add_to_cart_button'               => 'woocommerce_after_add_to_cart_button',
                'woocommerce_after_variations_form'                  => 'woocommerce_after_variations_form',
                'woocommerce_after_add_to_cart_form'                 => 'woocommerce_after_add_to_cart_form',
                'woocommerce_product_meta_start'                     => 'woocommerce_product_meta_start',
                'woocommerce_product_meta_end'                       => 'woocommerce_product_meta_end',
                'woocommerce_share'                                  => 'woocommerce_share',
                'woocommerce_after_single_product_summary'           => 'woocommerce_after_single_product_summary',
                'woocommerce_after_single_product'                   => 'woocommerce_after_single_product',
                // Cart hooks
                'woocommerce_before_cart'                            => 'woocommerce_before_cart',
                'woocommerce_cart_collaterals'                       => 'woocommerce_cart_collaterals',
                'woocommerce_after_cart'                             => 'woocommerce_after_cart',
                // Checkout hooks
                'woocommerce_before_checkout_form'                   => 'woocommerce_before_checkout_form',
                'woocommerce_checkout_before_customer_details'       => 'woocommerce_checkout_before_customer_details',
                'woocommerce_checkout_after_customer_details'        => 'woocommerce_checkout_after_customer_details',
                'woocommerce_checkout_billing'                       => 'woocommerce_checkout_billing',
                'woocommerce_checkout_shipping'                      => 'woocommerce_checkout_shipping',
                'woocommerce_checkout_before_order_review_heading'   => 'woocommerce_checkout_before_order_review_heading',
                'woocommerce_checkout_before_order_review'           => 'woocommerce_checkout_before_order_review',
                'woocommerce_checkout_order_review'                  => 'woocommerce_checkout_order_review',
                'woocommerce_checkout_after_order_review'            => 'woocommerce_checkout_after_order_review',
                'woocommerce_after_checkout_form'                    => 'woocommerce_after_checkout_form',
                // Thank You
                'woocommerce_thankyou'                               => 'woocommerce_thankyou',
                'woocommerce_before_thankyou'                        => 'woocommerce_before_thankyou',
                'woocommerce_order_details_after_order_table'        => 'woocommerce_order_details_after_order_table',
                // My Account
                'woocommerce_before_account_navigation'              => 'woocommerce_before_account_navigation',
                'woocommerce_after_account_navigation'               => 'woocommerce_after_account_navigation',
                'woocommerce_before_my_account'                      => 'woocommerce_before_my_account',
                'woocommerce_after_my_account'                       => 'woocommerce_after_my_account',
                // Login/Register
                'woocommerce_before_customer_login_form'             => 'woocommerce_before_customer_login_form',
                'woocommerce_after_customer_login_form'              => 'woocommerce_after_customer_login_form',
                'woocommerce_login_form_start'                       => 'woocommerce_login_form_start',
                'woocommerce_login_form_end'                         => 'woocommerce_login_form_end',
                'woocommerce_login_form'                             => 'woocommerce_login_form',
                'woocommerce_register_form_start'                    => 'woocommerce_register_form_start',
                'woocommerce_register_form_end'                      => 'woocommerce_register_form_end',
                'woocommerce_register_form'                          => 'woocommerce_register_form',
                // Lost Password
                'woocommerce_before_lost_password_form'              => 'woocommerce_before_lost_password_form',
                'woocommerce_lostpassword_form'                      => 'woocommerce_lostpassword_form',
                'woocommerce_after_lost_password_form'               => 'woocommerce_after_lost_password_form',
            ],
            'default' => '0',
        ] );

        $this->add_control( 'clean_actions', [
            'label' => __('Clean default actions', 'royal-addons-for-elementor'),
            'description'  => 'Remove all default WooCommerce functions hooked to this action.',
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = wp_parse_args( $this->get_settings_for_display(), [
            'hook'          => '0',
            'clean_actions' => 'yes',
        ] );

        if ( '0' === $settings['hook'] || empty( $settings['hook'] ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<p style="padding:20px;text-align:center;color:#999;background:#f5f5f5;border-radius:4px;">Select a WooCommerce hook to display</p>';
            }
            return;
        }

        if ( 'yes' === $settings['clean_actions'] ) {
            $this->clean_default_actions( $settings['hook'] );
        }

        // Execute the hook with proper arguments
        $checkout_hooks = [ 'woocommerce_before_checkout_form', 'woocommerce_after_checkout_form' ];
        $thankyou_hooks = [ 'woocommerce_thankyou', 'woocommerce_before_thankyou', 'woocommerce_order_details_after_order_table' ];

        if ( in_array( $settings['hook'], $checkout_hooks, true ) && function_exists( 'WC' ) ) {
            do_action( $settings['hook'], WC()->checkout() );
        } elseif ( in_array( $settings['hook'], $thankyou_hooks, true ) ) {
            $order_id = (int) get_query_var( 'order-received' );
            $order    = $order_id ? wc_get_order( $order_id ) : '';
            if ( $order ) {
                if ( 'woocommerce_order_details_after_order_table' === $settings['hook'] ) {
                    do_action( $settings['hook'], $order );
                } else {
                    do_action( $settings['hook'], $order_id );
                }
            }
        } else {
            do_action( $settings['hook'] );
        }
    }

    private function clean_default_actions( $hook ) {
        $removals = [
            'woocommerce_before_single_product' => [
                [ 'woocommerce_output_all_notices', 10 ],
                [ 'wc_print_notices', 10 ],
            ],
            'woocommerce_before_single_product_summary' => [
                [ 'woocommerce_show_product_sale_flash', 10 ],
                [ 'woocommerce_show_product_images', 20 ],
            ],
            'woocommerce_single_product_summary' => [
                [ 'woocommerce_template_single_title', 5 ],
                [ 'woocommerce_template_single_rating', 10 ],
                [ 'woocommerce_template_single_price', 10 ],
                [ 'woocommerce_template_single_excerpt', 20 ],
                [ 'woocommerce_template_single_add_to_cart', 30 ],
                [ 'woocommerce_template_single_meta', 40 ],
                [ 'woocommerce_template_single_sharing', 50 ],
            ],
            'woocommerce_after_single_product_summary' => [
                [ 'woocommerce_output_product_data_tabs', 10 ],
                [ 'woocommerce_upsell_display', 15 ],
                [ 'woocommerce_output_related_products', 20 ],
            ],
            'woocommerce_before_cart' => [
                [ 'woocommerce_output_all_notices', 10 ],
            ],
            'woocommerce_cart_collaterals' => [
                [ 'woocommerce_cross_sell_display', 10 ],
                [ 'woocommerce_cart_totals', 10 ],
            ],
            'woocommerce_before_checkout_form' => [
                [ 'woocommerce_checkout_login_form', 10 ],
                [ 'woocommerce_checkout_coupon_form', 10 ],
                [ 'woocommerce_output_all_notices', 10 ],
            ],
        ];

        if ( isset( $removals[ $hook ] ) ) {
            foreach ( $removals[ $hook ] as $removal ) {
                remove_all_actions( $hook );
                break; // remove_all_actions clears everything
            }
        }
    }
}
