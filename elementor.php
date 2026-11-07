<?php
namespace RoyalAddons;

use Elementor\Controls_Manager;
use Elementor\Elements_Manager;

// The enqueue manager is loaded here, which is correct.
require_once ROYAL_ADDONS_DIR_PATH . 'includes/enqueue.php';

class ROYAL_Widget_Loader{

    private static $_instance = null;
    public $enqueue_manager;

    public static function instance()  {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct(){
        $this->enqueue_manager = new Royal_Enqueue_Manager();
        $this->setup_hooks();
    }

    protected function setup_hooks() {
        // Hooks for frontend and editor scripts
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this->enqueue_manager, 'register_all_scripts' ] );
        add_action( 'elementor/preview/enqueue_styles', function() {
            wp_enqueue_style( 'royalanimatedshapedivider' );
        } );
        add_action( 'elementor/preview/enqueue_scripts', function() {
            wp_enqueue_script( 'royalanimatedshapedivider' );
        } );
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'royal_elementor_admin' ] ); 
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'royal_elementor_admin_after' ] ); 
        add_action( 'admin_enqueue_scripts', [ $this, 'royal_elementor_admin' ] );

        // Hooks for Elementor integration
        add_action( 'elementor/elements/categories_registered', [ $this, 'elementor_widget_category' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
        add_action( 'elementor/widgets/register', [ $this, 'register_layout_widgets' ], 20 );
        add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
        add_action( 'elementor/init', [ $this, 'init_modules' ] );   

        // Hook for modifying controls
        add_action( 'elementor/element/after_section_end', [$this, 'remove_pro_controls'], 10, 2);

        // Hook to include all other necessary files
        add_action( 'init', [ $this, 'filesinclude' ], 11 );

        // Mock post for layout previews in Elementor Editor
        add_action( 'elementor/widget/before_render_content', [ $this, 'mock_post_for_preview' ] );
        add_filter( 'elementor/widget/render_content', [ $this, 'restore_post_after_preview' ], 10, 2 );
    }

    private $original_post = null;

    public function mock_post_for_preview( $widget ) {
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && 'royal_layout' === get_post_type() ) {
            $layout_type = get_post_meta( get_the_ID(), '_royal_layout_type', true );
            if ( 'single_post' === $layout_type ) {
                global $post;
                if ( null === $this->original_post ) {
                    $this->original_post = clone $post;
                    $mock_posts = get_posts(['numberposts' => 1, 'post_type' => 'post', 'post_status' => 'publish']);
                    if ( ! empty($mock_posts) ) {
                        $post = $mock_posts[0];
                        setup_postdata($post);
                    }
                }
            }
        }
    }

    public function restore_post_after_preview( $content, $widget ) {
        if ( null !== $this->original_post ) {
            global $post;
            $post = clone $this->original_post;
            setup_postdata($post);
            $this->original_post = null;
        }
        return $content;
    }

    public function register_controls($controls_manager) {
        // This can be expanded as you add more custom controls
        require_once( ROYAL_ADDONS_DIR_PATH . 'controls/gradient.php' );
        $gradient = __NAMESPACE__ . '\Controls\Group_Control_Text_Gradient';
        \Elementor\Plugin::instance()->controls_manager->add_group_control( $gradient::get_type(), new $gradient() );

        // Register Royal Post Filter Control
        require_once( ROYAL_ADDONS_DIR_PATH . 'controls/royal-post-filter.php' );
        $royal_post_filter = __NAMESPACE__ . '\Controls\Royal_Post_Filter';
        $controls_manager->register( new $royal_post_filter() );
    }   

    public function init_modules() {
        // Initialize Form Module
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/modules/royalforms/module.php';
        \RoyalAddons\Modules\Forms\Module::instance();
    }

    public function register_widgets( $widgets_manager ) {
        // 1. Load the widget list from the file.
        $widget_lists = require ROYAL_ADDONS_DIR_PATH . 'admin/royalwidgetslist.php';

        // 2. Validate the data.
        if ( ! is_array( $widget_lists ) || ! isset( $widget_lists['free'], $widget_lists['pro'] ) ) {
            error_log( 'royalwidgetslist.php did not return a valid widget list.' );
            return;
        }

        // 3. Combine the 'free' and 'pro' widget arrays into a single list.
        $all_widgets = array_merge( $widget_lists['free'], $widget_lists['pro'] );

                // 4. Loop through the combined list and register each widget.
        foreach ( $all_widgets as $slug => $title ) {
            if (get_option(strtolower($slug)) == 1) {
                continue; // Skip disabled widgets
            }

            $file_path = ROYAL_ADDONS_DIR_PATH . 'widgets/' . strtolower( $slug ) . '.php';
            $class_name = 'RoyalAddons\\Widgets\\' . $slug;

            if ( file_exists( $file_path ) ) {
                require_once $file_path;
                if ( class_exists( $class_name ) ) {
                    $widgets_manager->register( new $class_name() );
                }
            }
        }
    }

    public function register_layout_widgets( $widgets_manager ) {
        $layout_widgets = [
            'single-product' => [
                'class-product-title.php'             => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Title',
                'class-product-price.php'             => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Price',
                'class-product-gallery.php'           => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Gallery',
                'class-product-add-to-cart.php'       => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Add_To_Cart',
                'class-product-tabs.php'              => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Tabs',
                'class-product-short-description.php' => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Short_Description',
                'class-product-meta.php'              => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Meta',
                'class-product-rating.php'            => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Rating',
                'class-product-reviews.php'           => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Reviews',
                'class-product-stock.php'             => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Stock',
                'class-product-content.php'           => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Content',
                'class-product-additional-info.php'   => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Additional_Info',
                'class-product-navigation.php'        => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Navigation',
                'class-product-sale-badge.php'        => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Sale_Badge',
                'class-product-upsells.php'           => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Upsells',
                'class-product-related.php'           => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Related',
                'class-product-sharing.php'           => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_Sharing',
                'class-product-sku.php'               => 'RoyalAddons\\Widgets\\LayoutWidgets\\SingleProduct\\Product_SKU',
            ],
            'single-post' => [
                'class-post-title.php'       => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Title',
                'class-post-content.php'     => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Content',
                'class-post-image.php'       => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Image',
                'class-post-author-bio.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Author_Bio',
                'class-post-categories.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Categories',
                'class-post-tags.php'        => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Tags',
                'class-post-comments.php'    => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Comments',
                'class-post-navigation.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Navigation',
                'class-post-date.php'        => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Date',
                'class-post-excerpt.php'     => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Excerpt',
                'class-post-author.php'      => 'RoyalAddons\\Widgets\\LayoutWidgets\\SinglePost\\Post_Author',
            ],
            'woocommerce' => [
                'class-wc-hook.php'    => 'RoyalAddons\\Widgets\\LayoutWidgets\\Woocommerce\\WC_Hook',
                'class-breadcrumb.php' => 'RoyalAddons\\Widgets\\LayoutWidgets\\Woocommerce\\Breadcrumb',
                'class-notices.php'    => 'RoyalAddons\\Widgets\\LayoutWidgets\\Woocommerce\\Notices',
            ],
            'cart' => [
                'class-cart-table.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\Cart\\Cart_Table',
                'class-cart-totals.php' => 'RoyalAddons\\Widgets\\LayoutWidgets\\Cart\\Cart_Totals',
                'class-empty-cart.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\Cart\\Empty_Cart',
            ],
            'checkout' => [
                'class-billing-details.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\Checkout\\Billing_Details',
                'class-shipping-details.php' => 'RoyalAddons\\Widgets\\LayoutWidgets\\Checkout\\Shipping_Details',
                'class-coupon-form.php'      => 'RoyalAddons\\Widgets\\LayoutWidgets\\Checkout\\Coupon_Form',
                'class-login-form.php'       => 'RoyalAddons\\Widgets\\LayoutWidgets\\Checkout\\Login_Form',
                'class-order-review.php'     => 'RoyalAddons\\Widgets\\LayoutWidgets\\Checkout\\Order_Review',
                'class-payment-methods.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\Checkout\\Payment_Methods',
            ],
            'my-account' => [
                'class-account-navigation.php'    => 'RoyalAddons\\Widgets\\LayoutWidgets\\MyAccount\\Account_Navigation',
                'class-account-content.php'       => 'RoyalAddons\\Widgets\\LayoutWidgets\\MyAccount\\Account_Content',
                'class-account-login.php'         => 'RoyalAddons\\Widgets\\LayoutWidgets\\MyAccount\\Account_Login',
                'class-account-register.php'      => 'RoyalAddons\\Widgets\\LayoutWidgets\\MyAccount\\Account_Register',
                'class-account-lost-password.php' => 'RoyalAddons\\Widgets\\LayoutWidgets\\MyAccount\\Account_Lost_Password',
            ],
            'thank-you' => [
                'class-order-message.php'          => 'RoyalAddons\\Widgets\\LayoutWidgets\\ThankYou\\Order_Message',
                'class-order-overview.php'         => 'RoyalAddons\\Widgets\\LayoutWidgets\\ThankYou\\Order_Overview',
                'class-order-details.php'          => 'RoyalAddons\\Widgets\\LayoutWidgets\\ThankYou\\Order_Details',
                'class-order-meta.php'             => 'RoyalAddons\\Widgets\\LayoutWidgets\\ThankYou\\Order_Meta',
                'class-customer-details.php'       => 'RoyalAddons\\Widgets\\LayoutWidgets\\ThankYou\\Customer_Details',
                'class-payment-instructions.php'   => 'RoyalAddons\\Widgets\\LayoutWidgets\\ThankYou\\Payment_Instructions',
            ],
            'shop-archive' => [
                'class-archive-products.php'     => 'RoyalAddons\\Widgets\\LayoutWidgets\\ShopArchive\\Archive_Products',
                'class-archive-orderby.php'      => 'RoyalAddons\\Widgets\\LayoutWidgets\\ShopArchive\\Archive_Orderby',
                'class-archive-result-count.php' => 'RoyalAddons\\Widgets\\LayoutWidgets\\ShopArchive\\Archive_Result_Count',
                'class-archive-description.php'  => 'RoyalAddons\\Widgets\\LayoutWidgets\\ShopArchive\\Archive_Description',
                'class-woocommerce-title.php'    => 'RoyalAddons\\Widgets\\LayoutWidgets\\ShopArchive\\Woocommerce_Title',
                'class-active-filters.php'       => 'RoyalAddons\\Widgets\\LayoutWidgets\\ShopArchive\\Active_Filters',
            ],
            'post-archive' => [
                'class-blog-archive.php' => 'RoyalAddons\\Widgets\\LayoutWidgets\\PostArchive\\Blog_Archive',
            ],
        ];

        foreach ( $layout_widgets as $dir => $widgets ) {
            foreach ( $widgets as $file => $class ) {
                $path = ROYAL_ADDONS_DIR_PATH . 'widgets/layout-widgets/' . $dir . '/' . $file;
                if ( file_exists( $path ) ) {
                    require_once $path;
                    if ( class_exists( $class ) ) {
                        $widgets_manager->register( new $class() );
                    }
                }
            }
        }
    }

    public function filesinclude() {
        /* Common Class files that were missing */
        require_once ROYAL_ADDONS_DIR_PATH. 'class/royalclass.php';   
        require_once ROYAL_ADDONS_DIR_PATH. 'class/royalclone.php'; 
        require_once ROYAL_ADDONS_DIR_PATH. 'class/royalnavmenuwalker.php';
        require_once ROYAL_ADDONS_DIR_PATH. 'includes/presets.php';
        require_once ROYAL_ADDONS_DIR_PATH. 'includes/royal-hf/loader.php';
        require_once ROYAL_ADDONS_DIR_PATH. 'includes/royal-login-ajax.php';

        /* Woo Commerce (optional, if WooCommerce is active) */
        if ( class_exists( 'WooCommerce' ) ) {
            require_once ROYAL_ADDONS_DIR_PATH. 'class/royalwooclass.php';   
        }

        /* Extensions */
        $extention_lists = require ROYAL_ADDONS_DIR_PATH . 'admin/royalextentionslist.php';

        if ( is_array( $extention_lists ) && isset( $extention_lists['free'], $extention_lists['pro'] ) ) {
            foreach (['free', 'pro'] as $type) {
                if (!empty($extention_lists[$type])) {
                    foreach ($extention_lists[$type] as $extention => $data) {
                        if (get_option($extention) != 1) {
                            if ($type === 'pro' && (!defined('ROYAL_ADDONS_PRO_ACTIVE') || ROYAL_ADDONS_PRO_ACTIVE !== true)) {
                                continue;
                            }
                            require_once ROYAL_ADDONS_DIR_PATH . 'extensions/' . $extention . '.php';
                        }
                    }
                }
            }
        }
    }
 
    /* Remove the Elementor Pro controls if Elementor Pro is not active */
    public function remove_pro_controls($element, $section_id) {
        if (!defined('ELEMENTOR_PRO_VERSION')) {
            // Suppress errors in case controls don't exist (e.g. Atomic elements that never had these)
            try {
                $element->remove_control('section_custom_attributes_pro');
            } catch (\Exception $e) {}
            try {
                $element->remove_control('section_custom_css_pro');
            } catch (\Exception $e) {}
        }
    }

    public function royal_elementor_admin(){
        wp_enqueue_style('royalelementoradmin', ROYAL_ADDONS_DIR_URL.'assets/css/admin.css', [], ROYAL_ADDONS_VERSION, 'all' );
        wp_enqueue_script(
            'royaleditor',
            ROYAL_ADDONS_DIR_URL . 'assets/editor/js/editor.js',
            ['jquery'],
            ROYAL_ADDONS_VERSION,
            true
        );

      // Enqueue SweetAlert2 from local vendor folder
        wp_enqueue_style('sweetalert2', ROYAL_ADDONS_DIR_URL . 'assets/vendor/sweetalert2/sweetalert2.min.css', [], ROYAL_ADDONS_VERSION, 'all');
        wp_enqueue_script('sweetalert2', ROYAL_ADDONS_DIR_URL . 'assets/vendor/sweetalert2/sweetalert2.all.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true);


        // Enqueue admin-settings.js for settings page functionality
        wp_enqueue_script(
            'royal-admin-settings',
            ROYAL_ADDONS_DIR_URL . 'assets/js/admin-settings.js',
            ['jquery', 'sweetalert2'], // Depends on jQuery and SweetAlert2
            ROYAL_ADDONS_VERSION,
            true
        );
        // Localize script with ajaxurl and nonces
        wp_localize_script('royal-admin-settings', 'royalAdminSettings', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'license_nonce' => wp_create_nonce('ajax-nonce'),
            'tweak_nonce' => wp_create_nonce('royal-tweak-nonce'),
        ));

    }
    
    public function royal_elementor_admin_after(){
        wp_enqueue_script(
            'royalpresets',
            ROYAL_ADDONS_DIR_URL . 'assets/editor/js/royalpresets.js',
            ['jquery', 'elementor-editor'],
            ROYAL_ADDONS_VERSION,
            true
        );

        wp_enqueue_script(
            'royalform-editor',
            ROYAL_ADDONS_DIR_URL . 'assets/editor/js/royalform-editor.js',
            ['jquery', 'elementor-editor'],
            ROYAL_ADDONS_VERSION,
            true
        );
    }
    
    public function elementor_widget_category( $widgets_manager ) {

        // Layout categories definition
        $layout_categories = [
            'royaltech_singleproduct' => [
                'title' => esc_html__( 'Royal Single Product', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-single-product',
            ],
            'royaltech_singlepost' => [
                'title' => esc_html__( 'Royal Single Post', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-single-post',
            ],
            'royaltech_shoparchive' => [
                'title' => esc_html__( 'Royal Shop Archive', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-products',
            ],
            'royaltech_postarchive' => [
                'title' => esc_html__( 'Royal Post Archive', 'royal-addons-for-elementor' ),
                'icon'  => 'eicon-post-list',
            ],
        ];

        // Map layout types to categories
        $type_to_cat = [
            'single_product'           => 'royaltech_singleproduct',
            'single_post'              => 'royaltech_singlepost',
            'shop_archive'             => 'royaltech_shoparchive',
            'blog_archive'             => 'royaltech_postarchive',
            'cart'                     => 'royaltech_singleproduct',
            'empty_cart'               => 'royaltech_singleproduct',
            'checkout_form'            => 'royaltech_singleproduct',
            'checkout_content'         => 'royaltech_singleproduct',
            'thank_you_page'           => 'royaltech_singleproduct',
            'my_account_page'          => 'royaltech_singleproduct',
            'my_account_auth'          => 'royaltech_singleproduct',
            'my_account_lost_password' => 'royaltech_singleproduct',
            'product_loop_item'        => 'royaltech_singleproduct',
        ];

        // Check current editing layout type
        $current_cat = '';
        $post_id     = absint( $_GET['post'] ?? 0 );
        if ( $post_id && 'royal_layout' === get_post_type( $post_id ) ) {
            $current_type = get_post_meta( $post_id, '_royal_layout_type', true );
            $current_cat  = $type_to_cat[ $current_type ] ?? '';
        }

        // 1. Register MATCHING layout category FIRST (appears at top, auto-expanded)
        if ( $current_cat && isset( $layout_categories[ $current_cat ] ) ) {
            $cat_data = $layout_categories[ $current_cat ];
            $cat_data['active'] = true; // Auto-expand this category
            $widgets_manager->add_category( $current_cat, $cat_data );
        }

        // 2. Standard categories
        $widgets_manager->add_category(
            'royaltech',
            [
                'title' => esc_html__( 'Royal Pro', 'royal-addons-for-elementor' ),
                'icon'  => 'fa fa-plug',
            ]
        );
        $widgets_manager->add_category(
            'royaltech_headerfooter',
            [
                'title' => esc_html__( 'Royal Header Footer', 'royal-addons-for-elementor' ),
                'icon'  => 'fa fa-plug',
            ]
        );
        $widgets_manager->add_category(
            'royaltech_3rdparty',
            [
                'title' => esc_html__( 'Royal 3rd Party', 'royal-addons-for-elementor' ),
                'icon'  => 'fa fa-plug',
            ]
        );

        // 3. Remaining layout categories (below standard)
        foreach ( $layout_categories as $slug => $data ) {
            if ( $slug !== $current_cat ) {
                $widgets_manager->add_category( $slug, $data );
            }
        }
    }
}

ROYAL_Widget_Loader::instance();