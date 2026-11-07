<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class RoyalSchema extends Widget_Base {

    public function get_name() {
        return 'royalschema';
    }

    public function get_title() {
        return esc_html__( 'RoyalSchema', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-code rtbranding'; }

    public function get_categories() {
        return [ 'royaltech_headerfooter' ];
    }

    public function get_keywords() {
        return [ 'schema', 'structured data', 'markup', 'seo', 'jsonld', 'rich results', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
    }

    public function get_style_depends() {
        return [ 'royalschema' ];
    }

    public function get_script_depends() {
        return [ 'royalschema' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_schema_type',
            [
                'label' => esc_html__( 'Schema Type', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'schema_type',
            [
                'label'   => esc_html__( 'Select Schema Type', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'person',
                'options' => [
                    'none'          => esc_html__( 'None (No Schema)', 'royal-addons-for-elementor' ),
                    'faqpage'       => esc_html__( 'FAQPage', 'royal-addons-for-elementor' ),
                    'howto'         => esc_html__( 'HowTo', 'royal-addons-for-elementor' ),
                    'localbusiness' => esc_html__( 'LocalBusiness', 'royal-addons-for-elementor' ),
                    'product'       => esc_html__( 'Product (with Offer)', 'royal-addons-for-elementor' ),
                    'person'        => esc_html__( 'Person', 'royal-addons-for-elementor' ),
                    'organization'  => esc_html__( 'Organization', 'royal-addons-for-elementor' ),
                ],
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();

        // FAQPage Schema Controls
        $this->start_controls_section(
            'section_faq_schema',
            [
                'label'     => esc_html__( 'FAQPage Schema Data', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'schema_type' => 'faqpage',
                ],
            ]
        );

        $repeater_faq = new Repeater();

        $repeater_faq->add_control(
            'question',
            [
                'label'       => esc_html__( 'Question', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'New Question', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater_faq->add_control(
            'answer',
            [
                'label'       => esc_html__( 'Answer', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => esc_html__( 'New Answer.', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'faq_items',
            [
                'label'       => esc_html__( 'FAQ Items', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_faq->get_controls(),
                'default'     => [
                    [
                        'question' => esc_html__( 'What is RoyalSchema?', 'royal-addons-for-elementor' ),
                        'answer'   => esc_html__( 'RoyalSchema is an Elementor addon designed to simplify the process of adding various Schema.org markup types to your website.', 'royal-addons-for-elementor' ),
                    ],
                ],
                'title_field' => '{{{ question }}}',
            ]
        );

        $this->end_controls_section();

        // HowTo Schema Controls
        $this->start_controls_section(
            'section_howto_schema',
            [
                'label'     => esc_html__( 'HowTo Schema Data', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'schema_type' => 'howto',
                ],
            ]
        );

        $this->add_control(
            'howto_name',
            [
                'label'       => esc_html__( 'HowTo Name (Title)', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'How to Do Something', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'howto_description',
            [
                'label'       => esc_html__( 'HowTo Description', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'label_block' => true,
                'default'     => esc_html__( 'A step-by-step guide on how to perform a task.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_howto_steps = new Repeater();

        $repeater_howto_steps->add_control(
            'step_name',
            [
                'label'       => esc_html__( 'Step Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'New Step', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater_howto_steps->add_control(
            'step_text',
            [
                'label'       => esc_html__( 'Step Description', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => esc_html__( 'Describe this step in detail.', 'royal-addons-for-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater_howto_steps->add_control(
            'step_image',
            [
                'label'   => esc_html__( 'Step Image', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'description' => esc_html__( 'Add an image illustrating this step.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'howto_steps',
            [
                'label'       => esc_html__( 'HowTo Steps', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_howto_steps->get_controls(),
                'default'     => [
                    [
                        'step_name' => esc_html__( 'Step 1: Gather Materials', 'royal-addons-for-elementor' ),
                        'step_text' => esc_html__( 'Collect all necessary tools and supplies.', 'royal-addons-for-elementor' ),
                    ],
                ],
                'title_field' => '{{{ step_name }}}',
            ]
        );

        $repeater_howto_supplies = new Repeater();

        $repeater_howto_supplies->add_control(
            'supply_name',
            [
                'label'       => esc_html__( 'Supply Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater_howto_supplies->add_control(
            'supply_amount',
            [
                'label' => esc_html__( 'Supply Amount', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'howto_supplies',
            [
                'label'       => esc_html__( 'HowTo Supplies', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_howto_supplies->get_controls(),
                'title_field' => '{{{ supply_name }}}',
            ]
        );

        $repeater_howto_tools = new Repeater();
        $repeater_howto_tools->add_control(
            'tool_name',
            [
                'label'       => esc_html__( 'Tool Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'howto_tools',
            [
                'label'       => esc_html__( 'HowTo Tools', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_howto_tools->get_controls(),
                'title_field' => '{{{ tool_name }}}',
            ]
        );

        $this->end_controls_section();

        // LocalBusiness Schema Controls
        $this->start_controls_section(
            'section_localbusiness_schema',
            [
                'label'     => esc_html__( 'LocalBusiness Schema Data', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'schema_type' => 'localbusiness',
                ],
            ]
        );

        $this->add_control(
            'lb_name',
            [
                'label'       => esc_html__( 'Business Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'My Local Business', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'lb_type',
            [
                'label'   => esc_html__( 'Business Type', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Organization',
                'description' => esc_html__( 'e.g., LocalBusiness, Restaurant, Store, Hotel', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'lb_image_type',
            [
                'label'   => esc_html__( 'Business Logo/Image Source', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'media' => esc_html__( 'Media Library', 'royal-addons-for-elementor' ),
                    'url'   => esc_html__( 'External URL', 'royal-addons-for-elementor' ),
                ],
                'default' => 'media',
            ]
        );

        $this->add_control(
            'lb_logo_media',
            [
                'label'     => esc_html__( 'Business Logo', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'lb_image_type' => 'media',
                ],
            ]
        );

        $this->add_control(
            'lb_logo_url',
            [
                'label'       => esc_html__( 'Business Logo URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-logo-url.com/logo.png', 'royal-addons-for-elementor' ),
                'show_external' => false,
                'condition'   => [
                    'lb_image_type' => 'url',
                ],
            ]
        );

        $this->add_control(
            'lb_address_heading',
            [
                'label' => esc_html__( 'Address', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'lb_street_address',
            [
                'label'       => esc_html__( 'Street Address', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'lb_address_locality',
            [
                'label' => esc_html__( 'City/Locality', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'lb_address_region',
            [
                'label' => esc_html__( 'State/Region', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'lb_postal_code',
            [
                'label' => esc_html__( 'Postal Code', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'lb_address_country',
            [
                'label'   => esc_html__( 'Country', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Bangladesh',
            ]
        );
        $this->add_control(
            'lb_phone',
            [
                'label' => esc_html__( 'Phone Number', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'lb_email',
            [
                'label' => esc_html__( 'Email Address', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater_opening_hours = new Repeater();
        $repeater_opening_hours->add_control(
            'day_of_week',
            [
                'label'   => esc_html__( 'Day of Week', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'Monday'    => esc_html__( 'Monday', 'royal-addons-for-elementor' ),
                    'Tuesday'   => esc_html__( 'Tuesday', 'royal-addons-for-elementor' ),
                    'Wednesday' => esc_html__( 'Wednesday', 'royal-addons-for-elementor' ),
                    'Thursday'  => esc_html__( 'Thursday', 'royal-addons-for-elementor' ),
                    'Friday'    => esc_html__( 'Friday', 'royal-addons-for-elementor' ),
                    'Saturday'  => esc_html__( 'Saturday', 'royal-addons-for-elementor' ),
                    'Sunday'    => esc_html__( 'Sunday', 'royal-addons-for-elementor' ),
                ],
                'default' => 'Monday',
            ]
        );
        $repeater_opening_hours->add_control(
            'opens',
            [
                'label'       => esc_html__( 'Opens', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '09:00',
            ]
        );
        $repeater_opening_hours->add_control(
            'closes',
            [
                'label'       => esc_html__( 'Closes', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '17:00',
            ]
        );
        $this->add_control(
            'lb_opening_hours',
            [
                'label'       => esc_html__( 'Opening Hours', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_opening_hours->get_controls(),
                'title_field' => '{{{ day_of_week }}} {{{ opens }}} - {{{ closes }}}',
            ]
        );

        $repeater_social_profiles = new Repeater();
        $repeater_social_profiles->add_control(
            'social_url',
            [
                'label'       => esc_html__( 'Social Profile URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
                'show_external' => true,
                'default'     => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
            ]
        );
        $this->add_control(
            'lb_social_profiles',
            [
                'label'       => esc_html__( 'Social Media Profiles', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_social_profiles->get_controls(),
                'title_field' => '{{{ social_url.url }}}',
                'description' => esc_html__( 'Enter full URLs to your social media profiles (e.g., Facebook, Twitter, LinkedIn).', 'royal-addons-for-elementor' ),
            ]
        );


        $this->end_controls_section();

        // Product Schema Controls
        $this->start_controls_section(
            'section_product_schema',
            [
                'label'     => esc_html__( 'Product Schema Data', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'schema_type' => 'product',
                ],
            ]
        );

        $this->add_control(
            'product_name',
            [
                'label'       => esc_html__( 'Product Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Awesome Product', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'product_description',
            [
                'label'       => esc_html__( 'Product Description', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'product_image_type',
            [
                'label'   => esc_html__( 'Product Image Source', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'media' => esc_html__( 'Media Library', 'royal-addons-for-elementor' ),
                    'url'   => esc_html__( 'External URL', 'royal-addons-for-elementor' ),
                ],
                'default' => 'media',
            ]
        );

        $this->add_control(
            'product_image_media',
            [
                'label'     => esc_html__( 'Product Image', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'product_image_type' => 'media',
                ],
            ]
        );

        $this->add_control(
            'product_image_url',
            [
                'label'       => esc_html__( 'Product Image URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-product-image.com/image.jpg', 'royal-addons-for-elementor' ),
                'show_external' => false,
                'condition'   => [
                    'product_image_type' => 'url',
                ],
            ]
        );

        $this->add_control(
            'product_sku',
            [
                'label' => esc_html__( 'Product SKU/MPN', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'product_brand_name',
            [
                'label' => esc_html__( 'Brand Name', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'product_offer_heading',
            [
                'label' => esc_html__( 'Offer Details', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'product_price',
            [
                'label'       => esc_html__( 'Price', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 99.99,
                'step'        => 0.01,
                'min'         => 0,
            ]
        );
        $this->add_control(
            'product_price_currency',
            [
                'label'       => esc_html__( 'Currency', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'USD',
                'placeholder' => 'USD, EUR, BDT',
            ]
        );
        $this->add_control(
            'product_availability',
            [
                'label'   => esc_html__( 'Availability', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'https://schema.org/InStock'        => esc_html__( 'In Stock', 'royal-addons-for-elementor' ),
                    'https://schema.org/OutOfStock'     => esc_html__( 'Out of Stock', 'royal-addons-for-elementor' ),
                    'https://schema.org/PreOrder'       => esc_html__( 'Pre-Order', 'royal-addons-for-elementor' ),
                    'https://schema.org/LimitedAvailability' => esc_html__( 'Limited Availability', 'royal-addons-for-elementor' ),
                ],
                'default' => 'https://schema.org/InStock',
            ]
        );
        $this->add_control(
            'product_item_condition',
            [
                'label'   => esc_html__( 'Item Condition', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'https://schema.org/NewCondition'         => esc_html__( 'New', 'royal-addons-for-elementor' ),
                    'https://schema.org/UsedCondition'        => esc_html__( 'Used', 'royal-addons-for-elementor' ),
                    'https://schema.org/RefurbishedCondition' => esc_html__( 'Refurbished', 'royal-addons-for-elementor' ),
                    'https://schema.org/DamagedCondition'     => esc_html__( 'Damaged', 'royal-addons-for-elementor' ),
                ],
                'default' => 'https://schema.org/NewCondition',
            ]
        );
        $this->add_control(
            'product_url',
            [
                'label'       => esc_html__( 'Product URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'show_external' => false,
                'label_block' => true,
                'placeholder' => 'https://your-product-page.com',
            ]
        );

        $this->end_controls_section();

        // Person Schema Controls
        $this->start_controls_section(
            'section_person_schema',
            [
                'label'     => esc_html__( 'Person Schema Data', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'schema_type' => 'person',
                ],
            ]
        );
        $this->add_control(
            'person_name',
            [
                'label'       => esc_html__( 'Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'Mehdi Akram', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_alternate_name = new Repeater();
        $repeater_alternate_name->add_control(
            'alternate_name_item',
            [
                'label'       => esc_html__( 'Alternate Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., Mehdi Akram', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'person_alternate_names',
            [
                'label'       => esc_html__( 'Alternate Names', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_alternate_name->get_controls(),
                'title_field' => '{{{ alternate_name_item }}}',
                'description' => esc_html__( 'Other names this person is known by.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'person_job_title',
            [
                'label'       => esc_html__( 'Primary Job Title', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'WordPress Developer', 'royal-addons-for-elementor' ),
                'description' => esc_html__( 'A general job title.', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'person_description',
            [
                'label'       => esc_html__( 'Description', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'person_image_type',
            [
                'label'   => esc_html__( 'Image Source', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'media' => esc_html__( 'Media Library', 'royal-addons-for-elementor' ),
                    'url'   => esc_html__( 'External URL', 'royal-addons-for-elementor' ),
                ],
                'default' => 'media',
            ]
        );
        $this->add_control(
            'person_image_media',
            [
                'label'     => esc_html__( 'Profile Image', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'person_image_type' => 'media',
                ],
            ]
        );
        $this->add_control(
            'person_image_url',
            [
                'label'       => esc_html__( 'Profile Image URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-profile-image.com/image.jpg', 'royal-addons-for-elementor' ),
                'show_external' => false,
                'condition'   => [
                    'person_image_type' => 'url',
                ],
            ]
        );

        $this->add_control(
            'person_url',
            [
                'label'       => esc_html__( 'Personal Website URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'show_external' => false,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'person_email',
            [
                'label' => esc_html__( 'Email Address', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'person_phone',
            [
                'label' => esc_html__( 'Phone Number', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater_person_social = new Repeater();
        $repeater_person_social->add_control(
            'social_url',
            [
                'label'       => esc_html__( 'Social Profile URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
                'show_external' => true,
                'default'     => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
            ]
        );
        $this->add_control(
            'person_social_profiles',
            [
                'label'       => esc_html__( 'Social Media Profiles', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_person_social->get_controls(),
                'title_field' => '{{{ social_url.url }}}',
            ]
        );

        $repeater_knows_about = new Repeater();
        $repeater_knows_about->add_control(
            'knows_about_item',
            [
                'label'       => esc_html__( 'Skill/Topic', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., Web Development, SEO', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'person_knows_about',
            [
                'label'       => esc_html__( 'Knows About', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_knows_about->get_controls(),
                'title_field' => '{{{ knows_about_item }}}',
                'description' => esc_html__( 'Skills, topics, or areas of expertise.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_knows_language = new Repeater();
        $repeater_knows_language->add_control(
            'language_name',
            [
                'label'       => esc_html__( 'Language Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., English, Bengali', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'person_knows_language',
            [
                'label'       => esc_html__( 'Knows Language', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_knows_language->get_controls(),
                'title_field' => '{{{ language_name }}}',
                'description' => esc_html__( 'Languages the person is proficient in.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_works_for = new Repeater();
        $repeater_works_for->add_control(
            'employer_name',
            [
                'label'       => esc_html__( 'Employer Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., RoyalTechBD', 'royal-addons-for-elementor' ),
            ]
        );
        $repeater_works_for->add_control(
            'employer_url',
            [
                'label'       => esc_html__( 'Employer Website URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'show_external' => false,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'person_works_for',
            [
                'label'       => esc_html__( 'Works For (Current/Past Employers)', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_works_for->get_controls(),
                'title_field' => '{{{ employer_name }}}',
                'description' => esc_html__( 'Organizations this person works/worked for.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_alumni_of = new Repeater();
        $repeater_alumni_of->add_control(
            'org_name',
            [
                'label'       => esc_html__( 'Educational Institution Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., University of Dhaka', 'royal-addons-for-elementor' ),
            ]
        );
        $repeater_alumni_of->add_control(
            'org_url',
            [
                'label'       => esc_html__( 'Institution Website URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'show_external' => false,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'person_alumni_of',
            [
                'label'       => esc_html__( 'Alumni Of (Educational Institutions)', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_alumni_of->get_controls(),
                'title_field' => '{{{ org_name }}}',
                'description' => esc_html__( 'Educational institutions this person attended.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_member_of = new Repeater();
        $repeater_member_of->add_control(
            'member_org_name',
            [
                'label'       => esc_html__( 'Organization/Group Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., IEEE, Local Developer Group', 'royal-addons-for-elementor' ),
            ]
        );
        $repeater_member_of->add_control(
            'member_org_url',
            [
                'label'       => esc_html__( 'Organization/Group URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'show_external' => false,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'person_member_of',
            [
                'label'       => esc_html__( 'Member Of (Organizations/Groups)', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_member_of->get_controls(),
                'title_field' => '{{{ member_org_name }}}',
                'description' => esc_html__( 'Organizations or groups this person is a member of.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_award = new Repeater();
        $repeater_award->add_control(
            'award_name',
            [
                'label'       => esc_html__( 'Award Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., Best Developer Award 2023', 'royal-addons-for-elementor' ),
            ]
        );
        $repeater_award->add_control(
            'award_year',
            [
                'label'       => esc_html__( 'Year', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'e.g., 2023', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'person_awards',
            [
                'label'       => esc_html__( 'Awards Received', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_award->get_controls(),
                'title_field' => '{{{ award_name }}} ({{{ award_year }}})',
                'description' => esc_html__( 'Notable awards or recognitions.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater_has_occupation = new Repeater();
        $repeater_has_occupation->add_control(
            'occupation_name',
            [
                'label'       => esc_html__( 'Occupation Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'e.g., Software Engineer', 'royal-addons-for-elementor' ),
            ]
        );
        $repeater_has_occupation->add_control(
            'occupation_description',
            [
                'label'       => esc_html__( 'Description', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'label_block' => true,
                'placeholder' => esc_html__( 'Brief description of duties and responsibilities.', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'person_has_occupation',
            [
                'label'       => esc_html__( 'Has Occupation', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_has_occupation->get_controls(),
                'title_field' => '{{{ occupation_name }}}',
                'description' => esc_html__( 'Detailed occupations or roles.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->end_controls_section();

        // Organization Schema Controls
        $this->start_controls_section(
            'section_organization_schema',
            [
                'label'     => esc_html__( 'Organization Schema Data', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'schema_type' => 'organization',
                ],
            ]
        );
        $this->add_control(
            'org_name',
            [
                'label'       => esc_html__( 'Organization Name', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => esc_html__( 'RoyalTechBD', 'royal-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'org_url',
            [
                'label'       => esc_html__( 'Organization Website URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'show_external' => false,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'org_logo_type',
            [
                'label'   => esc_html__( 'Organization Logo Source', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'media' => esc_html__( 'Media Library', 'royal-addons-for-elementor' ),
                    'url'   => esc_html__( 'External URL', 'royal-addons-for-elementor' ),
                ],
                'default' => 'media',
            ]
        );
        $this->add_control(
            'org_logo_media',
            [
                'label'     => esc_html__( 'Organization Logo', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'org_logo_type' => 'media',
                ],
            ]
        );
        $this->add_control(
            'org_logo_url',
            [
                'label'       => esc_html__( 'Organization Logo URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-org-logo.com/logo.png', 'royal-addons-for-elementor' ),
                'show_external' => false,
                'condition'   => [
                    'org_logo_type' => 'url',
                ],
            ]
        );

        $this->add_control(
            'org_description',
            [
                'label'       => esc_html__( 'Description', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'org_email',
            [
                'label' => esc_html__( 'Email Address', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'org_phone',
            [
                'label' => esc_html__( 'Phone Number', 'royal-addons-for-elementor' ),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater_org_social = new Repeater();
        $repeater_org_social->add_control(
            'social_url',
            [
                'label'       => esc_html__( 'Social Profile URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'label_block' => true,
                'show_external' => true,
                'default'     => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
            ]
        );
        $this->add_control(
            'org_social_profiles',
            [
                'label'       => esc_html__( 'Social Media Profiles', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_org_social->get_controls(),
                'title_field' => '{{{ social_url.url }}}',
            ]
        );

        $this->end_controls_section();

        // New Schema Test Controls Section
        $this->start_controls_section(
            'section_schema_test',
            [
                'label' => esc_html__( 'Schema Test & Validation', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT, // Can be TAB_SETTINGS or TAB_CONTENT
            ]
        );

        $this->add_control(
            'schema_test_description',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => sprintf(
                    /* translators: %1$s: Link to Schema.org Validator, %2$s: Link to Google Rich Results Test */
                    esc_html__( 'After adding schema markup, it is highly recommended to validate it using the official tools to ensure everything is correct and eligible for rich results. Use the links below:', 'royal-addons-for-elementor' ) .
                    '<ul style="margin-top: 10px; list-style-type: disc; padding-left: 20px;">' .
                    '<li><a href="%1$s" target="_blank">%1$s</a></li>' .
                    '<li><a href="%2$s" target="_blank">%2$s</a></li>' .
                    '</ul>',
                    'https://validator.schema.org/',
                    'https://search.google.com/test/rich-results'
                ),
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_visual_notice',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => esc_html__( 'This widget primarily outputs Schema Markup, which is invisible on the frontend. Visual styling controls would be added here if this widget also displayed content.', 'royal-addons-for-elementor' ),
                'content_classes' => 'elementor-descriptor',
            ]
        );
        $this->end_controls_section();
    }

    protected function parse_text_editor( $content ) {
        $content = apply_filters( 'widget_text', $content, $this->get_settings() );
        $content = shortcode_unautop( $content );
        $content = do_shortcode( $content );
        $content = wptexturize( $content );

        if ( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
            $content = $GLOBALS['wp_embed']->autoembed( $content );
        }

        return $content;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $schema_type = $settings['schema_type'];
        $schema_data = [];

        echo '<div class="royal-schema-widget" data-schema-type="' . esc_attr( $schema_type ) . '">';

        if ( 'faqpage' === $schema_type && ! empty( $settings['faq_items'] ) ) {
            echo '<div class="royal-schema-faq-display">';
            foreach ( $settings['faq_items'] as $item ) {
                echo '<div class="royal-schema-faq-item">';
                echo '<div class="royal-schema-faq-question"><h3>' . esc_html( $item['question'] ) . '</h3></div>';
                echo '<div class="royal-schema-faq-answer">' . $this->parse_text_editor( $item['answer'] ) . '</div>';
                echo '</div>';
            }
            echo '</div>';
        }

        if ( 'howto' === $schema_type && ! empty( $settings['howto_steps'] ) ) {
            echo '<div class="royal-schema-howto-display">';
            echo '<h2>' . esc_html( $settings['howto_name'] ) . '</h2>';
            if ( ! empty( $settings['howto_description'] ) ) {
                echo '<p>' . esc_html( $settings['howto_description'] ) . '</p>';
            }
            echo '<ol class="royal-schema-howto-steps">';
            foreach ( $settings['howto_steps'] as $index => $step ) {
                echo '<li>';
                echo '<h4>' . esc_html( $step['step_name'] ) . '</h4>';
                echo '<p>' . $this->parse_text_editor( $step['step_text'] ) . '</p>';
                if ( ! empty( $step['step_image']['url'] ) ) {
                    echo '<img src="' . esc_url( $step['step_image']['url'] ) . '" alt="' . esc_attr( $step['step_name'] ) . '">';
                }
                echo '</li>';
            }
            echo '</ol>';

            if ( ! empty( $settings['howto_supplies'] ) ) {
                echo '<h4>' . esc_html__( 'Supplies:', 'royal-addons-for-elementor' ) . '</h4>';
                echo '<ul>';
                foreach ( $settings['howto_supplies'] as $supply ) {
                    echo '<li>' . esc_html( $supply['supply_name'] );
                    if ( ! empty( $supply['supply_amount'] ) ) {
                        echo ' (' . esc_html( $supply['supply_amount'] ) . ')';
                    }
                    echo '</li>';
                }
                echo '</ul>';
            }

            if ( ! empty( $settings['howto_tools'] ) ) {
                echo '<h4>' . esc_html__( 'Tools:', 'royal-addons-for-elementor' ) . '</h4>';
                echo '<ul>';
                foreach ( $settings['howto_tools'] as $tool ) {
                    echo '<li>' . esc_html( $tool['tool_name'] ) . '</li>';
                }
                echo '</ul>';
            }
            echo '</div>';
        }

        echo '</div>';

        $json_ld = '';
        switch ( $schema_type ) {
            case 'faqpage':
                $main_entity = [];
                foreach ( $settings['faq_items'] as $item ) {
                    $main_entity[] = [
                        '@type'          => 'Question',
                        'name'           => wp_strip_all_tags( $item['question'] ),
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => wp_strip_all_tags( $item['answer'] ),
                        ],
                    ];
                }
                if ( ! empty( $main_entity ) ) {
                    $schema_data = [
                        '@context'   => 'https://schema.org',
                        '@type'      => 'FAQPage',
                        'mainEntity' => $main_entity,
                    ];
                }
                break;

            case 'howto':
                $steps = [];
                foreach ( $settings['howto_steps'] as $item ) {
                    $step_data = [
                        '@type' => 'HowToStep',
                        'name'  => wp_strip_all_tags( $item['step_name'] ),
                        'text'  => wp_strip_all_tags( $item['step_text'] ),
                    ];
                    if ( ! empty( $item['step_image']['url'] ) ) {
                        $step_data['image'] = esc_url( $item['step_image']['url'] );
                    }
                    $steps[] = $step_data;
                }

                $supplies = [];
                foreach ( $settings['howto_supplies'] as $supply ) {
                    $supply_item = [
                        '@type' => 'HowToSupply',
                        'name'  => wp_strip_all_tags( $supply['supply_name'] ),
                    ];
                    if ( ! empty( $supply['supply_amount'] ) ) {
                        $supply_item['amount'] = wp_strip_all_tags( $supply['supply_amount'] );
                    }
                    $supplies[] = $supply_item;
                }

                $tools = [];
                foreach ( $settings['howto_tools'] as $tool ) {
                    $tools[] = [
                        '@type' => 'HowToTool',
                        'name'  => wp_strip_all_tags( $tool['tool_name'] ),
                    ];
                }

                if ( ! empty( $steps ) ) {
                    $schema_data = [
                        '@context'    => 'https://schema.org',
                        '@type'       => 'HowTo',
                        'name'        => wp_strip_all_tags( $settings['howto_name'] ),
                        'description' => wp_strip_all_tags( $settings['howto_description'] ),
                        'step'        => $steps,
                    ];
                    if ( ! empty( $supplies ) ) {
                        $schema_data['supply'] = $supplies;
                    }
                    if ( ! empty( $tools ) ) {
                        $schema_data['tool'] = $tools;
                    }
                }
                break;

            case 'localbusiness':
                $logo_url = '';
                if ( 'media' === $settings['lb_image_type'] && ! empty( $settings['lb_logo_media']['url'] ) ) {
                    $logo_url = esc_url( $settings['lb_logo_media']['url'] );
                } elseif ( 'url' === $settings['lb_image_type'] && ! empty( $settings['lb_logo_url']['url'] ) ) {
                    $logo_url = esc_url( $settings['lb_logo_url']['url'] );
                }

                $address_data = [];
                if ( ! empty( $settings['lb_street_address'] ) || ! empty( $settings['lb_address_locality'] ) || ! empty( $settings['lb_address_region'] ) || ! empty( $settings['lb_postal_code'] ) || ! empty( $settings['lb_address_country'] ) ) {
                    $address_data = [
                        '@type'           => 'PostalAddress',
                        'streetAddress'   => wp_strip_all_tags( $settings['lb_street_address'] ),
                        'addressLocality' => wp_strip_all_tags( $settings['lb_address_locality'] ),
                        'addressRegion'   => wp_strip_all_tags( $settings['lb_address_region'] ),
                        'postalCode'      => wp_strip_all_tags( $settings['lb_postal_code'] ),
                        'addressCountry'  => wp_strip_all_tags( $settings['lb_address_country'] ),
                    ];
                }

                $opening_hours_data = [];
                foreach ( $settings['lb_opening_hours'] as $hour ) {
                    if ( ! empty( $hour['day_of_week'] ) && ! empty( $hour['opens'] ) && ! empty( $hour['closes'] ) ) {
                        $opening_hours_data[] = 'https://schema.org/' . $hour['day_of_week'] . ' ' . $hour['opens'] . '-' . $hour['closes'];
                    }
                }

                $social_profiles = [];
                foreach ( $settings['lb_social_profiles'] as $profile ) {
                    if ( ! empty( $profile['social_url']['url'] ) ) {
                        $social_profiles[] = esc_url( $profile['social_url']['url'] );
                    }
                }

                if ( ! empty( $settings['lb_name'] ) ) {
                    $schema_data = [
                        '@context' => 'https://schema.org',
                        '@type'    => wp_strip_all_tags( $settings['lb_type'] ),
                        'name'     => wp_strip_all_tags( $settings['lb_name'] ),
                        'url'      => get_permalink(),
                    ];
                    if ( $logo_url ) {
                        $schema_data['logo'] = $logo_url;
                    }
                    if ( ! empty( $address_data ) ) {
                        $schema_data['address'] = $address_data;
                    }
                    if ( ! empty( $settings['lb_phone'] ) ) {
                        $schema_data['telephone'] = wp_strip_all_tags( $settings['lb_phone'] );
                    }
                    if ( ! empty( $settings['lb_email'] ) ) {
                        $schema_data['email'] = wp_strip_all_tags( $settings['lb_email'] );
                    }
                    if ( ! empty( $opening_hours_data ) ) {
                        $schema_data['openingHoursSpecification'] = $opening_hours_data;
                    }
                    if ( ! empty( $social_profiles ) ) {
                        $schema_data['sameAs'] = $social_profiles;
                    }
                }
                break;

            case 'product':
                $product_image = '';
                if ( 'media' === $settings['product_image_type'] && ! empty( $settings['product_image_media']['url'] ) ) {
                    $product_image = esc_url( $settings['product_image_media']['url'] );
                } elseif ( 'url' === $settings['product_image_type'] && ! empty( $settings['product_image_url']['url'] ) ) {
                    $product_image = esc_url( $settings['product_image_url']['url'] );
                }

                if ( ! empty( $settings['product_name'] ) && ! empty( $settings['product_price'] ) && ! empty( $settings['product_price_currency'] ) ) {
                    $schema_data = [
                        '@context'    => 'https://schema.org',
                        '@type'       => 'Product',
                        'name'        => wp_strip_all_tags( $settings['product_name'] ),
                        'description' => wp_strip_all_tags( $settings['product_description'] ),
                        'image'       => $product_image,
                        'offers'      => [
                            '@type'         => 'Offer',
                            'price'         => floatval( $settings['product_price'] ),
                            'priceCurrency' => wp_strip_all_tags( $settings['product_price_currency'] ),
                            'availability'  => $settings['product_availability'],
                            'itemCondition' => $settings['product_item_condition'],
                        ],
                    ];
                    if ( ! empty( $settings['product_sku'] ) ) {
                        $schema_data['sku'] = wp_strip_all_tags( $settings['product_sku'] );
                    }
                    if ( ! empty( $settings['product_brand_name'] ) ) {
                        $schema_data['brand'] = [
                            '@type' => 'Brand',
                            'name'  => wp_strip_all_tags( $settings['product_brand_name'] ),
                        ];
                    }
                    if ( ! empty( $settings['product_url']['url'] ) ) {
                        $schema_data['offers']['url'] = esc_url( $settings['product_url']['url'] );
                    }
                }
                break;

            case 'person':
                $person_image_url = '';
                if ( 'media' === $settings['person_image_type'] && ! empty( $settings['person_image_media']['url'] ) ) {
                    $person_image_url = esc_url( $settings['person_image_media']['url'] );
                } elseif ( 'url' === $settings['person_image_type'] && ! empty( $settings['person_image_url']['url'] ) ) {
                    $person_image_url = esc_url( $settings['person_image_url']['url'] );
                }

                $social_profiles = [];
                foreach ( $settings['person_social_profiles'] as $profile ) {
                    if ( ! empty( $profile['social_url']['url'] ) ) {
                        $social_profiles[] = esc_url( $profile['social_url']['url'] );
                    }
                }

                $knows_about_items = [];
                foreach ( $settings['person_knows_about'] as $item ) {
                    if ( ! empty( $item['knows_about_item'] ) ) {
                        $knows_about_items[] = wp_strip_all_tags( $item['knows_about_item'] );
                    }
                }

                $knows_language_items = [];
                foreach ( $settings['person_knows_language'] as $item ) {
                    if ( ! empty( $item['language_name'] ) ) {
                        $knows_language_items[] = wp_strip_all_tags( $item['language_name'] );
                    }
                }

                $works_for_items = [];
                foreach ( $settings['person_works_for'] as $item ) {
                    if ( ! empty( $item['employer_name'] ) ) {
                        $org_data = [
                            '@type' => 'Organization',
                            'name'  => wp_strip_all_tags( $item['employer_name'] ),
                        ];
                        if ( ! empty( $item['employer_url']['url'] ) ) {
                            $org_data['url'] = esc_url( $item['employer_url']['url'] );
                        }
                        $works_for_items[] = $org_data;
                    }
                }

                $alumni_of_items = [];
                foreach ( $settings['person_alumni_of'] as $item ) {
                    if ( ! empty( $item['org_name'] ) ) {
                        $edu_org_data = [
                            '@type' => 'EducationalOrganization',
                            'name'  => wp_strip_all_tags( $item['org_name'] ),
                        ];
                        if ( ! empty( $item['org_url']['url'] ) ) {
                            $edu_org_data['url'] = esc_url( $item['org_url']['url'] );
                        }
                        $alumni_of_items[] = $edu_org_data;
                    }
                }

                $alternate_names = [];
                foreach ( $settings['person_alternate_names'] as $item ) {
                    if ( ! empty( $item['alternate_name_item'] ) ) {
                        $alternate_names[] = wp_strip_all_tags( $item['alternate_name_item'] );
                    }
                }

                $member_of_items = [];
                foreach ( $settings['person_member_of'] as $item ) {
                    if ( ! empty( $item['member_org_name'] ) ) {
                        $member_org_data = [
                            '@type' => 'Organization',
                            'name'  => wp_strip_all_tags( $item['member_org_name'] ),
                        ];
                        if ( ! empty( $item['member_org_url']['url'] ) ) {
                            $member_org_data['url'] = esc_url( $item['member_org_url']['url'] );
                        }
                        $member_of_items[] = $member_org_data;
                    }
                }

                $award_items = [];
                foreach ( $settings['person_awards'] as $item ) {
                    if ( ! empty( $item['award_name'] ) ) {
                        $award_text = wp_strip_all_tags( $item['award_name'] );
                        if ( ! empty( $item['award_year'] ) ) {
                            $award_text .= ' (' . wp_strip_all_tags( $item['award_year'] ) . ')';
                        }
                        $award_items[] = $award_text;
                    }
                }

                $has_occupation_items = [];
                foreach ( $settings['person_has_occupation'] as $item ) {
                    if ( ! empty( $item['occupation_name'] ) ) {
                        $occupation_data = [
                            '@type' => 'Occupation',
                            'name'  => wp_strip_all_tags( $item['occupation_name'] ),
                        ];
                        if ( ! empty( $item['occupation_description'] ) ) {
                            $occupation_data['description'] = wp_strip_all_tags( $item['occupation_description'] );
                        }
                        $has_occupation_items[] = $occupation_data;
                    }
                }

                if ( ! empty( $settings['person_name'] ) ) {
                    $schema_data = [
                        '@context' => 'https://schema.org',
                        '@type'    => 'Person',
                        'name'     => wp_strip_all_tags( $settings['person_name'] ),
                    ];
                    if ( $person_image_url ) {
                        $schema_data['image'] = $person_image_url;
                    }
                    if ( ! empty( $settings['person_job_title'] ) ) {
                        $schema_data['jobTitle'] = wp_strip_all_tags( $settings['person_job_title'] );
                    }
                    if ( ! empty( $settings['person_description'] ) ) {
                        $schema_data['description'] = wp_strip_all_tags( $settings['person_description'] );
                    }
                    if ( ! empty( $settings['person_url']['url'] ) ) {
                        $schema_data['url'] = esc_url( $settings['person_url']['url'] );
                    }
                    if ( ! empty( $settings['person_email'] ) ) {
                        $schema_data['email'] = wp_strip_all_tags( $settings['person_email'] );
                    }
                    if ( ! empty( $settings['person_phone'] ) ) {
                        $schema_data['telephone'] = wp_strip_all_tags( $settings['person_phone'] );
                    }
                    if ( ! empty( $social_profiles ) ) {
                        $schema_data['sameAs'] = $social_profiles;
                    }
                    if ( ! empty( $knows_about_items ) ) {
                        $schema_data['knowsAbout'] = $knows_about_items;
                    }
                    if ( ! empty( $knows_language_items ) ) {
                        $schema_data['knowsLanguage'] = $knows_language_items;
                    }
                    if ( ! empty( $works_for_items ) ) {
                        $schema_data['worksFor'] = $works_for_items;
                    }
                    if ( ! empty( $alumni_of_items ) ) {
                        $schema_data['alumniOf'] = $alumni_of_items;
                    }
                    if ( ! empty( $alternate_names ) ) {
                        $schema_data['alternateName'] = $alternate_names;
                    }
                    if ( ! empty( $member_of_items ) ) {
                        $schema_data['memberOf'] = $member_of_items;
                    }
                    if ( ! empty( $award_items ) ) {
                        $schema_data['award'] = $award_items;
                    }
                    if ( ! empty( $has_occupation_items ) ) {
                        $schema_data['hasOccupation'] = $has_occupation_items;
                    }
                }
                break;

            case 'organization':
                $org_logo_url = '';
                if ( 'media' === $settings['org_logo_type'] && ! empty( $settings['org_logo_media']['url'] ) ) {
                    $org_logo_url = esc_url( $settings['org_logo_media']['url'] );
                } elseif ( 'url' === $settings['org_logo_type'] && ! empty( $settings['org_logo_url']['url'] ) ) {
                    $org_logo_url = esc_url( $settings['org_logo_url']['url'] );
                }

                $social_profiles = [];
                foreach ( $settings['org_social_profiles'] as $profile ) {
                    if ( ! empty( $profile['social_url']['url'] ) ) {
                        $social_profiles[] = esc_url( $profile['social_url']['url'] );
                    }
                }

                if ( ! empty( $settings['org_name'] ) ) {
                    $schema_data = [
                        '@context' => 'https://schema.org',
                        '@type'    => 'Organization',
                        'name'     => wp_strip_all_tags( $settings['org_name'] ),
                    ];
                    if ( ! empty( $settings['org_url']['url'] ) ) {
                        $schema_data['url'] = esc_url( $settings['org_url']['url'] );
                    }
                    if ( $org_logo_url ) {
                        $schema_data['logo'] = $org_logo_url;
                    }
                    if ( ! empty( $settings['org_description'] ) ) {
                        $schema_data['description'] = wp_strip_all_tags( $settings['org_description'] );
                    }
                    if ( ! empty( $settings['org_email'] ) ) {
                        $schema_data['email'] = wp_strip_all_tags( $settings['org_email'] );
                    }
                    if ( ! empty( $settings['org_phone'] ) ) {
                        $schema_data['telephone'] = wp_strip_all_tags( $settings['org_phone'] );
                    }
                    if ( ! empty( $social_profiles ) ) {
                        $schema_data['sameAs'] = $social_profiles;
                    }
                }
                break;
        }

        if ( ! empty( $schema_data ) ) {
            $json_ld = json_encode( $schema_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
            echo '<script type="application/ld+json" class="royalschema-jsonld">' . $json_ld . '</script>';
        }
    }
}