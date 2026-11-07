<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Royal Store Locator Widget
 * Complete interactive Store & Showroom Locator powered by Leaflet & OpenStreetMap.
 */
class RoyalStoreLocator extends Widget_Base {

	public function get_name() {
		return 'royalstorelocator';
	}

	public function get_title() {
		return esc_html__( 'Store Locator', 'royal-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-google-maps rtbranding';
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'store', 'locator', 'map', 'dealer', 'showroom', 'openstreetmap', 'leaflet', 'royal', 'location', 'places', 'gps', 'near me', 'bangladesh', 'finder' ];
	}

	public function get_style_depends() {
		return [ 'font-awesome-6', 'elementor-icons-fa-solid', 'elementor-icons-fa-regular', 'leaflet', 'leaflet-markercluster', 'leaflet-markercluster-default', 'royalstorelocator' ];
	}

	public function get_script_depends() {
		return [ 'leaflet', 'leaflet-markercluster', 'royalstorelocator' ];
	}

	protected function register_controls() {

		/* =====================================================================
		 * TAB: CONTENT -> Section 1: Store Locations Data
		 * ===================================================================== */
		$this->start_controls_section(
			'section_stores_data',
			[
				'label' => esc_html__( 'Store Locations Data', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'data_source',
			[
				'label'   => esc_html__( 'Data Source', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'preset',
				'options' => [
					'preset'      => esc_html__( 'Preset Demo (30 Royal Showrooms across BD)', 'royal-addons-for-elementor' ),
					'custom'      => esc_html__( 'Custom Stores (Elementor Repeater)', 'royal-addons-for-elementor' ),
					'remote_json' => esc_html__( 'Remote / Local JSON URL', 'royal-addons-for-elementor' ),
				],
				'description' => esc_html__( 'Choose "Preset Demo" for the complete 30-showroom Bangladesh network ready out-of-the-box, or "Custom Stores" to enter your own locations.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'json_url',
			[
				'label'       => esc_html__( 'Remote JSON / GeoJSON URL', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => 'https://example.com/stores.json',
				'condition'   => [
					'data_source' => 'remote_json',
				],
			]
		);

		$sample_json_url = defined( 'ROYAL_ADDONS_ASSETS' ) ? ROYAL_ADDONS_ASSETS . 'data/stores-preset.json' : plugins_url( 'assets/data/stores-preset.json', dirname( __FILE__ ) );
		$download_action_url = admin_url( 'admin-ajax.php?action=royal_download_sample_stores' );

		$this->add_control(
			'sample_json_download_box',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => '<div style="margin: 10px 0 16px; padding: 12px; background: #f0f7ff; border: 1px solid #bae0ff; border-radius: 6px;">
					<div style="font-weight: 600; color: #0050b3; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; font-size: 13px;">
						<i class="eicon-document-file" style="font-size: 15px;"></i> ' . esc_html__( 'Sample Stores JSON File', 'royal-addons-for-elementor' ) . '
					</div>
					<p style="font-size: 12px; color: #334155; line-height: 1.5; margin: 0 0 10px 0;">
						' . esc_html__( 'Download the official demo JSON (30 BD showrooms) to use as a blueprint, or use its URL for instant testing.', 'royal-addons-for-elementor' ) . '
					</p>
					<div style="display: flex; gap: 8px; flex-wrap: wrap;">
						<a href="' . esc_url( $download_action_url ) . '" download="royal-stores-sample.json" class="elementor-button elementor-button-default" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; background: #0073aa; color: #fff; font-size: 11px; text-decoration: none; border-radius: 4px; font-weight: 600;">
							<i class="eicon-download-bold"></i> ' . esc_html__( 'Download Sample JSON', 'royal-addons-for-elementor' ) . '
						</a>
						<a href="' . esc_url( $sample_json_url ) . '" target="_blank" rel="noopener" class="elementor-button elementor-button-default" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; background: #ffffff; color: #0073aa; border: 1px solid #0073aa; font-size: 11px; text-decoration: none; border-radius: 4px; font-weight: 500;">
							<i class="eicon-external-link-square"></i> ' . esc_html__( 'View Demo JSON', 'royal-addons-for-elementor' ) . '
						</a>
					</div>
				</div>',
				'content_classes' => 'rsl-sample-json-box',
				'condition'       => [
					'data_source' => 'remote_json',
				],
			]
		);

		// Repeater for Custom Stores
		$repeater = new Repeater();

		$repeater->add_control(
			'store_name',
			[
				'label'       => esc_html__( 'Store / Showroom Name', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Downtown Flagship Showroom', 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'store_category',
			[
				'label'   => esc_html__( 'Category', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flagship',
				'options' => [
					'flagship'  => esc_html__( 'Flagship Showroom', 'royal-addons-for-elementor' ),
					'dealer'    => esc_html__( 'Authorized Dealer', 'royal-addons-for-elementor' ),
					'corporate' => esc_html__( 'Head Office / Corporate', 'royal-addons-for-elementor' ),
					'branch'    => esc_html__( 'Branch / Outlet', 'royal-addons-for-elementor' ),
					'service'   => esc_html__( 'Service Center', 'royal-addons-for-elementor' ),
					'custom'    => esc_html__( 'Custom Category (type below)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'store_custom_category',
			[
				'label'       => esc_html__( 'Custom Category Name', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g. Warehouse, Experience Center', 'royal-addons-for-elementor' ),
				'condition'   => [
					'store_category' => 'custom',
				],
			]
		);

		$repeater->add_control(
			'store_pin_icon',
			[
				'label'            => esc_html__( 'Map Marker Pin Icon', 'royal-addons-for-elementor' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => '',
					'library' => '',
				],
				'recommended'      => [
					'fa-solid' => [
						'star',
						'store',
						'building',
						'map-marker-alt',
						'location-dot',
						'shop',
						'cart-shopping',
						'wrench',
						'warehouse',
						'circle-dot',
						'gem',
						'tag',
					],
				],
			]
		);

		$repeater->add_control(
			'store_pin_color',
			[
				'label'       => esc_html__( 'Map Marker Pin Color', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '',
				'description' => esc_html__( 'Optional: Custom color for this pin marker on the map.', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'store_pin_image',
			[
				'label'       => esc_html__( 'Custom Pin Image (PNG/SVG)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [],
				'description' => esc_html__( 'Optional: Upload a custom marker image instead of pin icon.', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'store_type_label',
			[
				'label'       => esc_html__( 'Type Badge Label', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Flagship Showroom', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'e.g. Flagship Showroom', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'store_division',
			[
				'label'       => esc_html__( 'Division / State / Region', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Dhaka', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'e.g. Dhaka, Chattogram, California', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'store_district',
			[
				'label'       => esc_html__( 'District / City', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Dhaka', 'royal-addons-for-elementor' ),
				'placeholder' => esc_html__( 'e.g. Dhaka, Gulshan, Mirpur', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'store_address',
			[
				'label'       => esc_html__( 'Full Address', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'House # 58/11-A, 20 Shaikh Rasel Square, Panthapath, Dhaka-1205', 'royal-addons-for-elementor' ),
				'rows'        => 2,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'store_lat',
			[
				'label'       => esc_html__( 'Latitude', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 23.7516,
				'step'        => 0.000001,
				'label_block' => false,
			]
		);

		$repeater->add_control(
			'store_lng',
			[
				'label'       => esc_html__( 'Longitude', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 90.3872,
				'step'        => 0.000001,
				'label_block' => false,
			]
		);

		$repeater->add_control(
			'store_phone',
			[
				'label'       => esc_html__( 'Phone Number', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01713-245419',
				'placeholder' => '+880 1713-245419',
			]
		);

		$repeater->add_control(
			'store_email',
			[
				'label'       => esc_html__( 'Email Address', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'info@example.com',
				'placeholder' => 'contact@example.com',
			]
		);

		$time_options = [
			'12:00 AM' => '12:00 AM (Midnight)', '12:30 AM' => '12:30 AM', '01:00 AM' => '01:00 AM', '01:30 AM' => '01:30 AM',
			'02:00 AM' => '02:00 AM', '02:30 AM' => '02:30 AM', '03:00 AM' => '03:00 AM', '03:30 AM' => '03:30 AM',
			'04:00 AM' => '04:00 AM', '04:30 AM' => '04:30 AM', '05:00 AM' => '05:00 AM', '05:30 AM' => '05:30 AM',
			'06:00 AM' => '06:00 AM', '06:30 AM' => '06:30 AM', '07:00 AM' => '07:00 AM', '07:30 AM' => '07:30 AM',
			'08:00 AM' => '08:00 AM', '08:30 AM' => '08:30 AM', '09:00 AM' => '09:00 AM', '09:30 AM' => '09:30 AM',
			'10:00 AM' => '10:00 AM', '10:30 AM' => '10:30 AM', '11:00 AM' => '11:00 AM', '11:30 AM' => '11:30 AM',
			'12:00 PM' => '12:00 PM (Noon)',    '12:30 PM' => '12:30 PM', '01:00 PM' => '01:00 PM', '01:30 PM' => '01:30 PM',
			'02:00 PM' => '02:00 PM', '02:30 PM' => '02:30 PM', '03:00 PM' => '03:00 PM', '03:30 PM' => '03:30 PM',
			'04:00 PM' => '04:00 PM', '04:30 PM' => '04:30 PM', '05:00 PM' => '05:00 PM', '05:30 PM' => '05:30 PM',
			'06:00 PM' => '06:00 PM', '06:30 PM' => '06:30 PM', '07:00 PM' => '07:00 PM', '07:30 PM' => '07:30 PM',
			'08:00 PM' => '08:00 PM', '08:30 PM' => '08:30 PM', '09:00 PM' => '09:00 PM', '09:30 PM' => '09:30 PM',
			'10:00 PM' => '10:00 PM', '10:30 PM' => '10:30 PM', '11:00 PM' => '11:00 PM', '11:30 PM' => '11:30 PM',
		];

		$repeater->add_control(
			'store_schedule_type',
			[
				'label'   => esc_html__( 'Schedule Type', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'regular',
				'options' => [
					'regular' => esc_html__( 'Regular Hours (Select Start / End)', 'royal-addons-for-elementor' ),
					'24_7'    => esc_html__( 'Always Open (24/7)', 'royal-addons-for-elementor' ),
					'closed'  => esc_html__( 'Temporarily Closed', 'royal-addons-for-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'store_open_time',
			[
				'label'     => esc_html__( 'Opening Time (Start)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '10:00 AM',
				'options'   => $time_options,
				'condition' => [
					'store_schedule_type' => 'regular',
				],
			]
		);

		$repeater->add_control(
			'store_close_time',
			[
				'label'     => esc_html__( 'Closing Time (End)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '08:00 PM',
				'options'   => $time_options,
				'condition' => [
					'store_schedule_type' => 'regular',
				],
			]
		);

		$repeater->add_control(
			'store_working_days',
			[
				'label'     => esc_html__( 'Working Days', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'Everyday',
				'options'   => [
					'Everyday'            => esc_html__( 'Everyday (7 Days)', 'royal-addons-for-elementor' ),
					'Sat - Thu'           => esc_html__( 'Saturday - Thursday (Fri Off)', 'royal-addons-for-elementor' ),
					'Sun - Thu'           => esc_html__( 'Sunday - Thursday (Fri & Sat Off)', 'royal-addons-for-elementor' ),
					'Mon - Sat'           => esc_html__( 'Monday - Saturday (Sun Off)', 'royal-addons-for-elementor' ),
					'Mon - Fri'           => esc_html__( 'Monday - Friday (Sat & Sun Off)', 'royal-addons-for-elementor' ),
					'custom'              => esc_html__( 'Custom Schedule Note', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'store_schedule_type' => 'regular',
				],
			]
		);

		$repeater->add_control(
			'store_custom_days',
			[
				'label'       => esc_html__( 'Custom Schedule Note', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'e.g. Except Govt Holidays', 'royal-addons-for-elementor' ),
				'condition'   => [
					'store_schedule_type' => 'regular',
					'store_working_days'  => 'custom',
				],
			]
		);

		$repeater->add_control(
			'store_off_day',
			[
				'label'     => esc_html__( 'Weekly Off Day', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => [
					'none'      => esc_html__( 'None (Open all 7 days)', 'royal-addons-for-elementor' ),
					'friday'    => esc_html__( 'Friday', 'royal-addons-for-elementor' ),
					'saturday'  => esc_html__( 'Saturday', 'royal-addons-for-elementor' ),
					'sunday'    => esc_html__( 'Sunday', 'royal-addons-for-elementor' ),
					'monday'    => esc_html__( 'Monday', 'royal-addons-for-elementor' ),
					'tuesday'   => esc_html__( 'Tuesday', 'royal-addons-for-elementor' ),
					'wednesday' => esc_html__( 'Wednesday', 'royal-addons-for-elementor' ),
					'thursday'  => esc_html__( 'Thursday', 'royal-addons-for-elementor' ),
				],
				'condition' => [
					'store_schedule_type' => 'regular',
				],
			]
		);

		$repeater->add_control(
			'store_contact_person',
			[
				'label'       => esc_html__( 'Contact Person / Manager', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Mr. Md. Shamsul Alam', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'store_image',
			[
				'label'   => esc_html__( 'Store Image', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=600&q=80',
				],
			]
		);

		$repeater->add_control(
			'store_amenities',
			[
				'label'       => esc_html__( 'Amenities & Services (Comma separated)', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Air Conditioned, Card Payment, Parking Available, Official Warranty',
				'placeholder' => 'Parking, Card Payment, Wifi',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'store_featured',
			[
				'label'        => esc_html__( 'Featured Store', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'custom_stores',
			[
				'label'       => esc_html__( 'Custom Stores List', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'store_name'           => 'Panthapath Flagship Showroom',
						'store_category'       => 'flagship',
						'store_type_label'     => 'Flagship Showroom',
						'store_division'       => 'Dhaka',
						'store_district'       => 'Dhaka',
						'store_address'        => 'House # 58/11-A, 20 Shaikh Rasel Square, Panthapath, Dhaka-1205',
						'store_lat'            => 23.7516,
						'store_lng'            => 90.3872,
						'store_phone'          => '01713-245419',
						'store_email'          => 's.alam@navanafurniture.com',
						'store_hours'          => '10:00 AM - 8:00 PM (Everyday)',
						'store_contact_person' => 'Mr. Md. Shamsul Alam',
						'store_amenities'      => 'Air Conditioned, Card Payment, Parking Available, Official Warranty',
						'store_featured'       => 'yes',
						'store_image'          => [ 'url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=600&q=80' ],
					],
					[
						'store_name'           => 'Uttara Showroom',
						'store_category'       => 'flagship',
						'store_type_label'     => 'Flagship Showroom',
						'store_division'       => 'Dhaka',
						'store_district'       => 'Dhaka',
						'store_address'        => '52, Sonargaon Janapath Road, Sector-9, Uttara, Dhaka-1230',
						'store_lat'            => 23.8738,
						'store_lng'            => 90.3984,
						'store_phone'          => '01729-245395',
						'store_email'          => 'mostofa@navanafurniture.com',
						'store_hours'          => '10:00 AM - 8:00 PM (Everyday)',
						'store_contact_person' => 'Golam Mostafa',
						'store_amenities'      => 'Air Conditioned, Card Payment, Official Warranty',
						'store_featured'       => 'yes',
						'store_image'          => [ 'url' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=600&q=80' ],
					],
					[
						'store_name'           => 'Agrabad Showroom',
						'store_category'       => 'flagship',
						'store_type_label'     => 'Flagship Showroom',
						'store_division'       => 'Chattogram',
						'store_district'       => 'Chattogram',
						'store_address'        => '385/2, Rokeya Mahbub Mansion, Agrabad Access Road, Chattogram-4100',
						'store_lat'            => 22.3275,
						'store_lng'            => 91.8080,
						'store_phone'          => '01729-245410',
						'store_email'          => 'agrabad@navanafurniture.com',
						'store_hours'          => '10:00 AM - 8:00 PM (Everyday)',
						'store_contact_person' => 'Abul Kalam Azad',
						'store_amenities'      => 'Air Conditioned, Card Payment, Parking Available',
						'store_featured'       => 'yes',
						'store_image'          => [ 'url' => 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?auto=format&fit=crop&w=600&q=80' ],
					],
				],
				'title_field' => '{{{ store_name }}} ({{{ store_division }}})',
				'condition'   => [
					'data_source' => 'custom',
				],
			]
		);

		$this->end_controls_section();

		/* =====================================================================
		 * TAB: CONTENT -> Section 2: Layout & Map Configuration
		 * ===================================================================== */
		$this->start_controls_section(
			'section_map_options',
			[
				'label' => esc_html__( 'Layout & Map Options', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label'   => esc_html__( 'Layout Mode', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sidebar_left',
				'options' => [
					'sidebar_left'  => esc_html__( 'Sidebar Left + Map Right (Classic Split)', 'royal-addons-for-elementor' ),
					'sidebar_right' => esc_html__( 'Map Left + Sidebar Right', 'royal-addons-for-elementor' ),
					'stacked'       => esc_html__( 'Stacked (Map Top + Store Cards Bottom)', 'royal-addons-for-elementor' ),
					'map_only'      => esc_html__( 'Map Only (With Floating Search & Drawer)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'widget_height',
			[
				'label'      => esc_html__( 'Widget Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 400, 'max' => 1200, 'step' => 10 ],
					'vh' => [ 'min' => 40, 'max' => 100 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 740 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-store-locator-app' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sidebar_width',
			[
				'label'      => esc_html__( 'Sidebar Width', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 300, 'max' => 600 ],
					'%'  => [ 'min' => 25, 'max' => 50 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 430 ],
				'selectors'  => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-sidebar-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'layout_style!' => [ 'stacked', 'map_only' ],
				],
			]
		);

		$this->add_control(
			'tile_layer',
			[
				'label'   => esc_html__( 'Default Map Tile Style', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'osm',
				'options' => [
					'osm'         => esc_html__( 'OpenStreetMap (Standard Free)', 'royal-addons-for-elementor' ),
					'osm_hot'     => esc_html__( 'OpenStreetMap (Humanitarian HOT)', 'royal-addons-for-elementor' ),
					'carto_light' => esc_html__( 'CartoDB Positron (Clean Light)', 'royal-addons-for-elementor' ),
					'carto_dark'  => esc_html__( 'CartoDB Dark Matter (Modern Dark)', 'royal-addons-for-elementor' ),
					'esri_sat'    => esc_html__( 'Esri Satellite Imagery', 'royal-addons-for-elementor' ),
					'opentopo'    => esc_html__( 'OpenTopoMap (Topographic)', 'royal-addons-for-elementor' ),
					'custom'      => esc_html__( 'Custom Tile Server URL', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'custom_tile_url',
			[
				'label'       => esc_html__( 'Custom Tile Layer URL', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'https://{s}.tile.example.com/{z}/{x}/{y}.png',
				'condition'   => [
					'tile_layer' => 'custom',
				],
			]
		);

		$this->add_control(
			'show_layer_control',
			[
				'label'        => esc_html__( 'Show Map Layer Switcher', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Allows visitors to toggle between Standard OSM, Humanitarian, Satellite, and Topo view directly on the map.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'default_lat',
			[
				'label'   => esc_html__( 'Initial Center Latitude', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 23.8103,
				'step'    => 0.0001,
			]
		);

		$this->add_control(
			'default_lng',
			[
				'label'   => esc_html__( 'Initial Center Longitude', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 90.4125,
				'step'    => 0.0001,
			]
		);

		$this->add_control(
			'default_zoom',
			[
				'label'   => esc_html__( 'Initial Zoom Level', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'min' => 1, 'max' => 19 ],
				'default' => [ 'size' => 7 ],
			]
		);

		$this->add_control(
			'scroll_wheel_zoom',
			[
				'label'        => esc_html__( 'Scroll Wheel Zoom', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'description'  => esc_html__( 'Recommended "No" to avoid trapping mouse scrolling on the webpage.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'enable_clustering',
			[
				'label'        => esc_html__( 'Enable Marker Clustering', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* =====================================================================
		 * TAB: CONTENT -> Section 3: Search, Geolocation & Filters
		 * ===================================================================== */
		$this->start_controls_section(
			'section_search_filters',
			[
				'label' => esc_html__( 'Search, Geolocation & Filters', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_search_box',
			[
				'label'        => esc_html__( 'Show Instant Live Search', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label'       => esc_html__( 'Search Placeholder', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Search by name, district, area or phone...', 'royal-addons-for-elementor' ),
				'condition'   => [ 'show_search_box' => 'yes' ],
			]
		);

		$this->add_control(
			'show_division_filter',
			[
				'label'        => esc_html__( 'Show Region / Division Dropdown', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'division_filter_all_label',
			[
				'label'       => esc_html__( '"All Regions" Label', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All Bangladesh (All Divisions)', 'royal-addons-for-elementor' ),
				'condition'   => [ 'show_division_filter' => 'yes' ],
			]
		);

		$this->add_control(
			'show_category_pills',
			[
				'label'        => esc_html__( 'Show Category Pills / Tabs', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_near_me',
			[
				'label'        => esc_html__( 'Show "Near Me" GPS Geolocation', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Uses Browser GPS with automatic IP fallback to detect user location and calculate distance.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'distance_unit',
			[
				'label'     => esc_html__( 'Distance Unit', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'km',
				'options'   => [
					'km'    => esc_html__( 'Kilometers (km)', 'royal-addons-for-elementor' ),
					'miles' => esc_html__( 'Miles (mi)', 'royal-addons-for-elementor' ),
				],
				'condition' => [ 'show_near_me' => 'yes' ],
			]
		);

		$this->add_control(
			'default_radius',
			[
				'label'     => esc_html__( 'Default Search Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 100,
				'min'       => 5,
				'max'       => 500,
				'step'      => 5,
				'condition' => [ 'show_near_me' => 'yes' ],
			]
		);

		$this->add_control(
			'max_radius',
			[
				'label'     => esc_html__( 'Maximum Search Radius', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 150,
				'min'       => 10,
				'max'       => 1000,
				'step'      => 10,
				'condition' => [ 'show_near_me' => 'yes' ],
			]
		);

		$this->add_control(
			'show_sort_select',
			[
				'label'        => esc_html__( 'Show Sorting Dropdown', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_open_now_status',
			[
				'label'        => esc_html__( 'Show Dynamic Open / Closed Status', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Calculates real-time store operating status (Open Now 🟢 or Closed 🔴) based on visitor current time.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_open_now_filter',
			[
				'label'        => esc_html__( 'Show "Open Now Only" Filter', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_open_now_status' => 'yes' ],
			]
		);

		$this->add_control(
			'show_amenities_filter',
			[
				'label'        => esc_html__( 'Show Amenities & Services Filter', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* =====================================================================
		 * TAB: CONTENT -> Section 4: Store Cards & Details Display
		 * ===================================================================== */
		$this->start_controls_section(
			'section_card_settings',
			[
				'label' => esc_html__( 'Store Cards & Action Buttons', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_card_image',
			[
				'label'        => esc_html__( 'Show Store Thumbnail Image', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_contact_person',
			[
				'label'        => esc_html__( 'Show Contact Person / Manager', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_phone',
			[
				'label'        => esc_html__( 'Show Phone Number', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_email',
			[
				'label'        => esc_html__( 'Show Email Address', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label'        => esc_html__( 'Show Operating Hours', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_view_map_btn',
			[
				'label'        => esc_html__( 'Show "View Map" Button', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'view_map_btn_text',
			[
				'label'       => esc_html__( 'Map Button Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'View Map', 'royal-addons-for-elementor' ),
				'placeholder' => 'View Map',
				'condition'   => [ 'show_view_map_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'show_directions_btn',
			[
				'label'        => esc_html__( 'Show "Directions" Button', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'directions_btn_text',
			[
				'label'       => esc_html__( 'Directions Button Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Directions', 'royal-addons-for-elementor' ),
				'placeholder' => 'Directions',
				'condition'   => [ 'show_directions_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'directions_service',
			[
				'label'     => esc_html__( 'Directions Service', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'google',
				'options'   => [
					'google' => esc_html__( 'Google Maps Navigation', 'royal-addons-for-elementor' ),
					'apple'  => esc_html__( 'Apple Maps', 'royal-addons-for-elementor' ),
					'waze'   => esc_html__( 'Waze Navigation', 'royal-addons-for-elementor' ),
				],
				'condition' => [ 'show_directions_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'show_share_btn',
			[
				'label'        => esc_html__( 'Show Share & Copy Actions', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Includes 1-click "Copy Address" and "Share Location" buttons.', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		/* =====================================================================
		 * TAB: CONTENT -> Section 5: Sidebar Header & Floating Map Controls
		 * ===================================================================== */
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Header & Floating Map Controls', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_header',
			[
				'label'        => esc_html__( 'Show Sidebar Brand Header', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'header_title',
			[
				'label'     => esc_html__( 'Header Title', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Royal Store', 'royal-addons-for-elementor' ),
				'condition' => [ 'show_header' => 'yes' ],
			]
		);

		$this->add_control(
			'header_subtitle',
			[
				'label'     => esc_html__( 'Header Subtitle', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Store & Dealer Locator', 'royal-addons-for-elementor' ),
				'condition' => [ 'show_header' => 'yes' ],
			]
		);

		$this->add_control(
			'show_total_badge',
			[
				'label'        => esc_html__( 'Show Total Showrooms Badge', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'show_header' => 'yes' ],
			]
		);

		$this->add_control(
			'show_reset_view_btn',
			[
				'label'        => esc_html__( 'Show Reset View Button (Globe)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_locate_me_map_btn',
			[
				'label'        => esc_html__( 'Show Locate Me Button (Crosshairs)', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_fullscreen_btn',
			[
				'label'        => esc_html__( 'Show Fullscreen Toggle Button', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_sidebar_toggle',
			[
				'label'        => esc_html__( 'Show Sidebar Collapse/Expand Toggle', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* =====================================================================
		 * TAB: STYLE -> Section 1: Colors & Theme
		 * ===================================================================== */
		$this->start_controls_section(
			'section_style_theme',
			[
				'label' => esc_html__( 'Colors & Branding', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'     => esc_html__( 'Primary Brand Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#047857',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-primary: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_hover_color',
			[
				'label'     => esc_html__( 'Primary Hover / Dark Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#065f46',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-primary-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_flagship_color',
			[
				'label'     => esc_html__( 'Flagship Pin & Badge Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d97706',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-accent-flagship: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_dealer_color',
			[
				'label'     => esc_html__( 'Dealer Pin & Badge Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#047857',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-accent-dealer: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_corporate_color',
			[
				'label'     => esc_html__( 'Corporate Pin & Badge Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0284c7',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-accent-corporate: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'header_background',
				'label'     => esc_html__( 'Header Background', 'royal-addons-for-elementor' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .rsl-sidebar-header',
			]
		);

		$this->add_control(
			'sidebar_bg_color',
			[
				'label'     => esc_html__( 'Sidebar Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .rsl-sidebar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'app_border',
				'label'    => esc_html__( 'Container Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royal-store-locator-app',
			]
		);

		$this->add_responsive_control(
			'app_border_radius',
			[
				'label'      => esc_html__( 'Container Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-store-locator-app' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'app_box_shadow',
				'label'    => esc_html__( 'Container Shadow', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royal-store-locator-app',
			]
		);

		$this->end_controls_section();

		/* =====================================================================
		 * TAB: STYLE -> Section 2: Store Cards Style
		 * ===================================================================== */
		$this->start_controls_section(
			'section_style_cards',
			[
				'label' => esc_html__( 'Store Cards Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__( 'Card Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .rsl-store-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_active_bg_color',
			[
				'label'     => esc_html__( 'Active / Hover Card Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f0fdf4',
				'selectors' => [
					'{{WRAPPER}} .rsl-store-card:hover, {{WRAPPER}} .rsl-store-card.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'card_title_typography',
				'label'    => esc_html__( 'Store Title Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .rsl-store-title',
			]
		);

		$this->add_control(
			'card_title_color',
			[
				'label'     => esc_html__( 'Store Title Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f172a',
				'selectors' => [
					'{{WRAPPER}} .rsl-store-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'label'    => esc_html__( 'Card Box Shadow', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .rsl-store-card',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Card Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .rsl-store-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rsl-store-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_image_height',
			[
				'label'      => esc_html__( 'Card Image Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 80, 'max' => 350 ] ],
				'selectors'  => [
					'{{WRAPPER}} .rsl-card-img-wrap' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

		/* =====================================================================
		 * TAB: STYLE -> Section 3: Map Markers & Cluster Badges
		 * ===================================================================== */
		$this->start_controls_section(
			'section_style_markers',
			[
				'label' => esc_html__( 'Map Markers & Clusters', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cluster_color_start',
			[
				'label'     => esc_html__( 'Cluster Gradient Start', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#059669',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-cluster-start: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cluster_color_end',
			[
				'label'     => esc_html__( 'Cluster Gradient End', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#047857',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-cluster-end: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'user_location_color',
			[
				'label'     => esc_html__( 'User Location Pin Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2563eb',
				'selectors' => [
					'{{WRAPPER}} .royal-store-locator-app' => '--rsl-user-pin-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Widget Output
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$widget_id = $this->get_id();

		// Compile store locations data
		$stores_data = [];

		$data_source = ! empty( $settings['data_source'] ) ? $settings['data_source'] : 'preset';

		if ( 'preset' === $data_source ) {
			// Read preset JSON
			$preset_file = ROYAL_ADDONS_DIR_PATH . 'assets/data/stores-preset.json';
			if ( file_exists( $preset_file ) ) {
				$raw_json = file_get_contents( $preset_file );
				$stores_data = json_decode( $raw_json, true ) ?: [];
			}
		} elseif ( 'custom' === $data_source && ! empty( $settings['custom_stores'] ) ) {
			foreach ( $settings['custom_stores'] as $index => $item ) {
				$amenities = [];
				if ( ! empty( $item['store_amenities'] ) ) {
					$amenities = array_filter( array_map( 'trim', explode( ',', $item['store_amenities'] ) ) );
				}
				$image_url = ! empty( $item['store_image']['url'] ) ? $item['store_image']['url'] : '';

				$custom_icon_html = '';
				if ( ! empty( $item['store_pin_icon']['value'] ) ) {
					ob_start();
					\Elementor\Icons_Manager::render_icon( $item['store_pin_icon'], [ 'aria-hidden' => 'true' ] );
					$custom_icon_html = ob_get_clean();
				}
				$pin_image_url = ! empty( $item['store_pin_image']['url'] ) ? $item['store_pin_image']['url'] : '';
				$pin_color = ! empty( $item['store_pin_color'] ) ? $item['store_pin_color'] : '';
				$cat_val = ( ! empty( $item['store_category'] ) && 'custom' === $item['store_category'] && ! empty( $item['store_custom_category'] ) ) 
					? trim( $item['store_custom_category'] ) 
					: ( ! empty( $item['store_category'] ) ? $item['store_category'] : 'dealer' );

				$stores_data[] = [
					'id'             => 'store-' . $widget_id . '-' . $index,
					'name'           => $item['store_name'],
					'category'       => $cat_val,
					'pinIcon'        => $custom_icon_html,
					'pinColor'       => $pin_color,
					'pinImage'       => $pin_image_url,
					'type'           => ! empty( $item['store_type_label'] ) ? $item['store_type_label'] : 'Store Outlet',
					'division'       => ! empty( $item['store_division'] ) ? $item['store_division'] : '',
					'district'       => ! empty( $item['store_district'] ) ? $item['store_district'] : '',
					'address'        => ! empty( $item['store_address'] ) ? $item['store_address'] : '',
					'lat'            => ! empty( $item['store_lat'] ) ? (float) $item['store_lat'] : 0,
					'lng'            => ! empty( $item['store_lng'] ) ? (float) $item['store_lng'] : 0,
					'phone'          => ! empty( $item['store_phone'] ) ? $item['store_phone'] : '',
					'email'          => ! empty( $item['store_email'] ) ? $item['store_email'] : '',
					'hours'          => (function() use ($item) {
						$sched = ! empty( $item['store_schedule_type'] ) ? $item['store_schedule_type'] : 'regular';
						if ( '24_7' === $sched ) {
							return esc_html__( 'Open 24/7', 'royal-addons-for-elementor' );
						} elseif ( 'closed' === $sched ) {
							return esc_html__( 'Temporarily Closed', 'royal-addons-for-elementor' );
						} elseif ( ! empty( $item['store_open_time'] ) && ! empty( $item['store_close_time'] ) ) {
							$days_val = ( ! empty( $item['store_working_days'] ) && 'custom' === $item['store_working_days'] && ! empty( $item['store_custom_days'] ) )
								? $item['store_custom_days']
								: ( ! empty( $item['store_working_days'] ) ? $item['store_working_days'] : 'Everyday' );
							$days_sfx = ( 'Everyday' !== $days_val ) ? ' (' . $days_val . ')' : ' (Everyday)';
							return $item['store_open_time'] . ' - ' . $item['store_close_time'] . $days_sfx;
						}
						return ! empty( $item['store_hours'] ) ? $item['store_hours'] : '10:00 AM - 08:00 PM (Everyday)';
					})(),
					'openTime'       => ! empty( $item['store_open_time'] ) ? $item['store_open_time'] : '',
					'closeTime'      => ! empty( $item['store_close_time'] ) ? $item['store_close_time'] : '',
					'offDay'         => ! empty( $item['store_off_day'] ) ? $item['store_off_day'] : 'none',
					'scheduleType'   => ! empty( $item['store_schedule_type'] ) ? $item['store_schedule_type'] : 'regular',
					'contact_person' => ! empty( $item['store_contact_person'] ) ? $item['store_contact_person'] : '',
					'amenities'      => $amenities,
					'featured'       => ( 'yes' === ( $item['store_featured'] ?? 'no' ) ),
					'image'          => $image_url,
				];
			}
		}

		// Helper to check switcher setting with true as fallback default
		$is_on = function( $key, $default = true ) use ( $settings ) {
			if ( ! isset( $settings[ $key ] ) || '' === $settings[ $key ] ) {
				return $default;
			}
			return 'yes' === $settings[ $key ] || '1' === $settings[ $key ];
		};

		// Widget Configuration Object
		$config = [
			'id'                 => $widget_id,
			'dataSource'         => ! empty( $settings['data_source'] ) ? $settings['data_source'] : 'preset',
			'remoteJsonUrl'      => ! empty( $settings['json_url'] ) ? esc_url( $settings['json_url'] ) : '',
			'layoutStyle'        => ! empty( $settings['layout_style'] ) ? $settings['layout_style'] : 'sidebar_left',
			'tileLayer'          => ! empty( $settings['tile_layer'] ) ? $settings['tile_layer'] : 'osm',
			'customTileUrl'      => ! empty( $settings['custom_tile_url'] ) ? $settings['custom_tile_url'] : '',
			'showLayerControl'   => $is_on( 'show_layer_control' ),
			'defaultLat'         => ! empty( $settings['default_lat'] ) ? (float) $settings['default_lat'] : 23.8103,
			'defaultLng'         => ! empty( $settings['default_lng'] ) ? (float) $settings['default_lng'] : 90.4125,
			'defaultZoom'        => ! empty( $settings['default_zoom']['size'] ) ? (int) $settings['default_zoom']['size'] : 7,
			'scrollWheelZoom'    => $is_on( 'scroll_wheel_zoom', false ),
			'enableClustering'   => $is_on( 'enable_clustering' ),
			'maxClusterRadius'   => ! empty( $settings['max_cluster_radius'] ) ? (int) $settings['max_cluster_radius'] : 45,
			'showSearch'         => $is_on( 'show_search_box' ),
			'showDivisionFilter' => $is_on( 'show_division_filter' ),
			'divisionAllLabel'   => ! empty( $settings['division_filter_all_label'] ) ? $settings['division_filter_all_label'] : esc_html__( 'All Bangladesh (All Divisions)', 'royal-addons-for-elementor' ),
			'showCategoryPills'  => $is_on( 'show_category_pills' ),
			'showNearMe'         => $is_on( 'show_near_me' ),
			'distanceUnit'       => $settings['distance_unit'] ?? 'km',
			'defaultRadius'      => ! empty( $settings['default_radius'] ) ? (int) $settings['default_radius'] : 100,
			'maxRadius'          => ! empty( $settings['max_radius'] ) ? (int) $settings['max_radius'] : 150,
			'showSortSelect'     => $is_on( 'show_sort_select' ),
			'showOpenNowStatus'  => $is_on( 'show_open_now_status' ),
			'showOpenNowFilter'  => $is_on( 'show_open_now_filter' ),
			'showAmenitiesFilter'=> $is_on( 'show_amenities_filter' ),
			'showCardImage'      => $is_on( 'show_card_image' ),
			'showContactPerson'  => $is_on( 'show_contact_person' ),
			'showPhone'          => $is_on( 'show_phone' ),
			'showEmail'          => $is_on( 'show_email' ),
			'showHours'          => $is_on( 'show_hours' ),
			'showViewMapBtn'     => $is_on( 'show_view_map_btn' ),
			'viewMapBtnText'     => ! empty( $settings['view_map_btn_text'] ) ? $settings['view_map_btn_text'] : 'View Map',
			'showDirectionsBtn'  => $is_on( 'show_directions_btn' ),
			'directionsBtnText'  => ! empty( $settings['directions_btn_text'] ) ? $settings['directions_btn_text'] : 'Directions',
			'directionsService'  => $settings['directions_service'] ?? 'google',
			'showShareBtn'       => $is_on( 'show_share_btn' ),
			'showResetViewBtn'   => $is_on( 'show_reset_view_btn' ),
			'showLocateMeMapBtn' => $is_on( 'show_locate_me_map_btn' ),
			'showFullscreenBtn'  => $is_on( 'show_fullscreen_btn' ),
			'showSidebarToggle'  => $is_on( 'show_sidebar_toggle' ),
		];

		$show_header = $is_on( 'show_header' );
		$layout_class = 'layout-' . esc_attr( $config['layoutStyle'] );
		if ( ! empty( $config['showLayerControl'] ) ) {
			$layout_class .= ' has-layer-control';
		}
		$wrapper_id = 'rsl-app-' . esc_attr( $widget_id );
		?>
		<div id="<?php echo esc_attr( $wrapper_id ); ?>" 
			 class="royal-store-locator-app <?php echo esc_attr( $layout_class ); ?>" 
			 data-settings="<?php echo esc_attr( wp_json_encode( $config ) ); ?>"
			 data-stores="<?php echo esc_attr( wp_json_encode( $stores_data ) ); ?>">

			<!-- ==========================================
			     SIDEBAR: Search, Filters & Store List
			     ========================================== -->
			<aside class="rsl-sidebar" id="rsl-sidebar-<?php echo esc_attr( $widget_id ); ?>">
				
				<?php if ( $show_header ) : ?>
					<div class="rsl-sidebar-header">
						<div class="rsl-brand-row">
							<div class="rsl-brand-info">
								<div class="rsl-brand-icon">
									<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
								</div>
								<div class="rsl-brand-text">
									<h2 class="rsl-header-title"><?php echo esc_html( ! empty( $settings['header_title'] ) ? $settings['header_title'] : 'Royal Store' ); ?></h2>
									<p class="rsl-header-subtitle"><?php echo esc_html( ! empty( $settings['header_subtitle'] ) ? $settings['header_subtitle'] : 'Store & Dealer Locator' ); ?></p>
								</div>
							</div>
							<?php if ( $is_on( 'show_total_badge' ) ) : ?>
								<span class="rsl-total-badge rsl-badge-total-count"><?php echo esc_html( count( $stores_data ) ); ?> Showrooms</span>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Search & Filter Controls -->
				<div class="rsl-filter-section">
					<?php if ( $config['showSearch'] ) : ?>
						<div class="rsl-search-box-wrap">
							<span class="rsl-search-icon" aria-hidden="true">
								<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
							</span>
							<input 
								type="text" 
								class="rsl-search-input" 
								placeholder="<?php echo esc_attr( ! empty( $settings['search_placeholder'] ) ? $settings['search_placeholder'] : 'Search by name, district, area or phone...' ); ?>" 
								autocomplete="off"
								aria-label="<?php echo esc_attr__( 'Search stores', 'royal-addons-for-elementor' ); ?>"
							/>
							<button type="button" class="rsl-clear-search-btn" title="<?php echo esc_attr__( 'Clear search', 'royal-addons-for-elementor' ); ?>">
								<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
							</button>
						</div>
					<?php endif; ?>

					<!-- Division & Geolocation Row -->
					<?php if ( $config['showDivisionFilter'] || $config['showNearMe'] ) : ?>
						<div class="rsl-filter-row">
							<?php if ( $config['showDivisionFilter'] ) : ?>
								<select class="rsl-division-select" aria-label="<?php echo esc_attr__( 'Filter by region', 'royal-addons-for-elementor' ); ?>">
									<option value="all"><?php echo esc_html( $config['divisionAllLabel'] ); ?></option>
								</select>
							<?php endif; ?>

							<?php if ( $config['showNearMe'] ) : ?>
								<button type="button" class="rsl-near-me-btn" title="<?php echo esc_attr__( 'Find nearest stores from your location', 'royal-addons-for-elementor' ); ?>">
									<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0 0 13 3.06V1h-2v2.06A8.994 8.994 0 0 0 3.06 11H1v2h2.06A8.994 8.994 0 0 0 11 20.94V23h2v-2.06A8.994 8.994 0 0 0 20.94 13H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/></svg>
									<span><?php echo esc_html__( 'Near Me', 'royal-addons-for-elementor' ); ?></span>
								</button>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<!-- Category Pills -->
					<?php if ( $config['showCategoryPills'] ) : ?>
						<div class="rsl-category-pills">
							<button type="button" class="rsl-category-pill active" data-category="all">
								<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/></svg>
								<span><?php echo esc_html__( 'All Stores', 'royal-addons-for-elementor' ); ?></span>
							</button>
							<button type="button" class="rsl-category-pill" data-category="flagship">
								<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
								<span><?php echo esc_html__( 'Flagship', 'royal-addons-for-elementor' ); ?></span>
							</button>
							<button type="button" class="rsl-category-pill" data-category="dealer">
								<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/></svg>
								<span><?php echo esc_html__( 'Dealers', 'royal-addons-for-elementor' ); ?></span>
							</button>
							<button type="button" class="rsl-category-pill" data-category="corporate">
								<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
								<span><?php echo esc_html__( 'Head Office', 'royal-addons-for-elementor' ); ?></span>
							</button>
						</div>
					<?php endif; ?>

					<!-- Quick Filter Badges (Open Now & Amenities) -->
					<?php if ( $config['showOpenNowFilter'] || $config['showAmenitiesFilter'] ) : ?>
						<div class="rsl-quick-filters">
							<?php if ( $config['showOpenNowFilter'] ) : ?>
								<label class="rsl-filter-checkbox-label">
									<input type="checkbox" class="rsl-open-now-checkbox" />
									<span class="rsl-checkbox-custom"></span>
									<span class="rsl-open-now-text"><span class="rsl-status-dot online"></span> <?php echo esc_html__( 'Open Now Only', 'royal-addons-for-elementor' ); ?></span>
								</label>
							<?php endif; ?>

							<?php if ( $config['showAmenitiesFilter'] ) : ?>
								<div class="rsl-amenities-dropdown-wrap">
									<button type="button" class="rsl-amenity-toggle-btn">
										<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17v2h6v-2H3zM3 5v2h10V5H3zm10 16v-2h8v-2h-8v-2h-2v6h2zM7 9v2H3v2h4v2h2V9H7zm14 4v-2H11v2h10zm-6-4h2V7h4V5h-4V3h-2v6z"/></svg>
										<span><?php echo esc_html__( 'Amenities', 'royal-addons-for-elementor' ); ?></span>
										<svg class="rsl-caret" width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
									</button>
									<div class="rsl-amenities-menu">
										<!-- Populated dynamically via JS -->
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<!-- Radius Slider Box (Activates on Near Me) -->
					<?php if ( $config['showNearMe'] ) : ?>
						<div class="rsl-radius-container">
							<div class="rsl-radius-header">
								<span>
									<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" style="display:inline-block;vertical-align:middle;margin-right:4px;"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4-1.79 4-4-1.79-4-4-4zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
									<?php echo esc_html__( 'Search Radius:', 'royal-addons-for-elementor' ); ?>
								</span>
								<span class="rsl-radius-value"><?php echo esc_html( $config['defaultRadius'] . ' ' . $config['distanceUnit'] ); ?></span>
							</div>
							<input 
								type="range" 
								class="rsl-radius-slider" 
								min="5" 
								max="<?php echo esc_attr( $config['maxRadius'] ); ?>" 
								step="5" 
								value="<?php echo esc_attr( $config['defaultRadius'] ); ?>" 
							/>
						</div>
					<?php endif; ?>
				</div>

				<!-- Results Bar -->
				<div class="rsl-results-info-bar">
					<span class="rsl-results-count"><?php echo esc_html__( 'Loading locations...', 'royal-addons-for-elementor' ); ?></span>
					<?php if ( $config['showSortSelect'] ) : ?>
						<select class="rsl-sort-select" aria-label="<?php echo esc_attr__( 'Sort locations', 'royal-addons-for-elementor' ); ?>">
							<option value="default"><?php echo esc_html__( 'Default Order', 'royal-addons-for-elementor' ); ?></option>
							<option value="distance"><?php echo esc_html__( 'Nearest Distance', 'royal-addons-for-elementor' ); ?></option>
							<option value="name-asc"><?php echo esc_html__( 'Name (A to Z)', 'royal-addons-for-elementor' ); ?></option>
							<option value="name-desc"><?php echo esc_html__( 'Name (Z to A)', 'royal-addons-for-elementor' ); ?></option>
							<option value="featured"><?php echo esc_html__( 'Featured First', 'royal-addons-for-elementor' ); ?></option>
						</select>
					<?php endif; ?>
				</div>

				<!-- Store Cards List -->
				<div class="rsl-store-list-container">
					<!-- Dynamically rendered by JS -->
				</div>

				<!-- Empty State -->
				<div class="rsl-empty-state">
					<div class="rsl-empty-icon">
						<svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
					</div>
					<h3><?php echo esc_html__( 'No Locations Found', 'royal-addons-for-elementor' ); ?></h3>
					<p><?php echo esc_html__( 'Try adjusting your search query, increasing your search radius, or selecting a different division.', 'royal-addons-for-elementor' ); ?></p>
				</div>
			</aside>

			<!-- Desktop Sidebar Collapse / Expand Toggle Button -->
			<?php if ( $config['showSidebarToggle'] && ! in_array( $config['layoutStyle'], [ 'stacked', 'map_only' ], true ) ) : ?>
				<button type="button" class="rsl-sidebar-collapse-btn" aria-label="<?php echo esc_attr__( 'Toggle sidebar', 'royal-addons-for-elementor' ); ?>">
					<svg class="rsl-sidebar-toggle-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
				</button>
			<?php endif; ?>

			<!-- ==========================================
			     MAP VIEWPORT: Leaflet Interactive Map
			     ========================================== -->
			<main class="rsl-map-viewport">
				<div class="rsl-map-canvas" id="rsl-map-<?php echo esc_attr( $widget_id ); ?>"></div>

				<!-- Floating Controls on Map -->
				<div class="rsl-map-floating-controls">
					<?php if ( $config['showResetViewBtn'] ) : ?>
						<button type="button" class="rsl-map-control-btn rsl-reset-view-btn" title="<?php echo esc_attr__( 'Fit All Stores View', 'royal-addons-for-elementor' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
						</button>
					<?php endif; ?>

					<?php if ( $config['showLocateMeMapBtn'] && $config['showNearMe'] ) : ?>
						<button type="button" class="rsl-map-control-btn rsl-locate-me-map-btn" title="<?php echo esc_attr__( 'My Current Location', 'royal-addons-for-elementor' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0 0 13 3.06V1h-2v2.06A8.994 8.994 0 0 0 3.06 11H1v2h2.06A8.994 8.994 0 0 0 11 20.94V23h2v-2.06A8.994 8.994 0 0 0 20.94 13H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/></svg>
						</button>
					<?php endif; ?>

					<?php if ( $config['showFullscreenBtn'] ) : ?>
						<button type="button" class="rsl-map-control-btn rsl-fullscreen-btn" title="<?php echo esc_attr__( 'Toggle Fullscreen', 'royal-addons-for-elementor' ); ?>">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
						</button>
					<?php endif; ?>
				</div>

				<!-- Mobile List View Toggle Button -->
				<button type="button" class="rsl-mobile-toggle-btn">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/></svg>
					<span><?php echo esc_html__( 'View Showrooms List', 'royal-addons-for-elementor' ); ?></span>
				</button>
			</main>
		</div>
		<?php
	}
}
