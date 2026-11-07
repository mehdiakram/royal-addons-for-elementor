<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Css_Filter;
use RoyalAddons\Traits\ProWidgetTrait;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RoyalMap extends Widget_Base {
    use ProWidgetTrait;

    public function get_name() {
        return 'royalmap';
    }

    public function get_title() {
        return esc_html__( 'Royal Map', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'rtbranding eicon-map-pin'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_keywords() {
        return [ 'map', 'location', 'google map', 'openstreetmap', 'leaflet', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
    }

    public function get_style_depends() {
        wp_register_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4' );
        wp_register_style( 'leaflet-routing-machine', 'https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css', ['leaflet'], '3.2.12' );
        wp_register_style( 'leaflet-markercluster', 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css', ['leaflet'], '1.5.3' );
        wp_register_style( 'leaflet-markercluster-default', 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css', ['leaflet-markercluster'], '1.5.3' );
        wp_register_style( 'royalmap', ROYAL_ADDONS_ASSETS . 'css/royalmap.css', ['leaflet', 'leaflet-markercluster', 'leaflet-routing-machine'], time() );
        return [ 'leaflet', 'leaflet-markercluster', 'leaflet-markercluster-default', 'leaflet-routing-machine', 'royalmap' ];
    }

    public function get_script_depends() {
        wp_register_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true );
        wp_register_script( 'leaflet-routing-machine', 'https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js', ['leaflet'], '3.2.12', true );
        wp_register_script( 'leaflet-markercluster', 'https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js', ['leaflet'], '1.5.3', true );
        wp_register_script( 'jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', [], '2.5.1', true );
        wp_register_script( 'html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', [], '1.4.1', true );
        wp_register_script( 'royalmap', ROYAL_ADDONS_ASSETS . 'js/royalmap.js', [ 'elementor-frontend', 'leaflet', 'leaflet-markercluster', 'leaflet-routing-machine', 'jspdf', 'html2canvas' ], time(), true );
        return [ 'royalmap' ];
    }

    protected function register_controls() {

        //=============================================
        // Content Tab
        //=============================================

        // Section: Locations
        $this->start_controls_section(
            'section_locations',
            [
                'label' => esc_html__( 'Locations', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'lat_lng_finder_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<div class="elementor-control-title" style="margin-bottom: 5px;">' . esc_html__( 'How to find Latitude & Longitude', 'royal-addons-for-elementor' ) . '</div><div class="elementor-control-field-description" style="line-height: 1.4;">' . sprintf(
                    /* translators: %s: Link to OpenStreetMap */
                    esc_html__('Go to %s, find the location, right-click and select "Show Address". You will find the Latitude & Longitude in the left panel.', 'royal-addons-for-elementor'),
                    '<a href="https://www.openstreetmap.org/" target="_blank" rel="noopener">OpenStreetMap.org</a>'
                ) . '</div>',
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'location_title',
            [
                'label' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Location Title', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'latitude',
            [
                'label' => esc_html__( 'Latitude', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '23.90332',
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'longitude',
            [
                'label' => esc_html__( 'Longitude', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '89.12203',
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'location_description',
            [
                'label' => esc_html__( 'Description', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'location_image',
            [
                'label' => esc_html__( 'Image', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'location_phone',
            [
                'label' => esc_html__( 'Phone Number', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'location_address',
            [
                'label' => esc_html__( 'Address', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'custom_marker',
            [
                'label' => esc_html__( 'Custom Pin/Icon', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'description' => esc_html__('Upload a custom icon for this specific location.', 'royal-addons-for-elementor'),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'locations',
            [
                'label' => esc_html__( 'Add Locations', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'location_title' => esc_html__( 'Royal Technologies', 'royal-addons-for-elementor' ),
                        'latitude' => '23.894183',
                        'longitude' => '89.136023',
                        'location_description' => esc_html__( 'This is a sample location.', 'royal-addons-for-elementor' ),
                    ],
                    [
                        'location_title' => esc_html__( 'Methan Plastic Industries', 'royal-addons-for-elementor' ),
                        'latitude' => '23.93134681524222',
                        'longitude' => '89.07349619535081',
                        'location_description' => esc_html__( 'This is another sample location.', 'royal-addons-for-elementor' ),
                    ],
                ],
                'title_field' => '{{{ location_title }}}',
            ]
        );

        $this->end_controls_section();

        // Section: Map Settings
        $this->start_controls_section(
            'section_map_settings',
            [
                'label' => esc_html__( 'Map Settings', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_responsive_control(
            'map_height',
            [
                'label' => esc_html__( 'Map Height', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [ 'min' => 200, 'max' => 1200, ],
                    'vh' => [ 'min' => 20, 'max' => 100, ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 500, ],
                'selectors' => [
                    '{{WRAPPER}} .royal-map-container, {{WRAPPER}} .royal-map-location-list' => 'height: calc({{SIZE}}{{UNIT}} + 17px);',
                    '{{WRAPPER}} .royal-map-widget-wrapper .royal-map-main-area' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'map_zoom',
            [
                'label' => esc_html__( 'Zoom Level', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [ 'size' => 12 ],
                'range' => [ 'px' => [ 'min' => 1, 'max' => 20 ], ],
            ]
        );

        $this->add_control(
            'map_layer',
            [
                'label' => esc_html__( 'Map Layer Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'osm_standard',
                'options' => [
                    'osm_standard' => esc_html__( 'OpenStreetMap Standard', 'royal-addons-for-elementor' ),
                    'osm_hot' => esc_html__( 'OpenStreetMap Humanitarian', 'royal-addons-for-elementor' ),
                    'osm_de' => esc_html__( 'OpenStreetMap DE', 'royal-addons-for-elementor' ),
                    'osm_fr' => esc_html__( 'OpenStreetMap France', 'royal-addons-for-elementor' ),
                    'osm_bzh' => esc_html__( 'OpenStreetMap BZH', 'royal-addons-for-elementor' ),
                    'opentopomap' => esc_html__( 'OpenTopoMap', 'royal-addons-for-elementor' ),
                    'cyclosm' => esc_html__( 'CyclOSM', 'royal-addons-for-elementor' ),
                    'opencyclemap' => esc_html__( 'OpenCycleMap (API Key Req)', 'royal-addons-for-elementor' ),
                    'transport' => esc_html__( 'Transport Map (API Key Req)', 'royal-addons-for-elementor' ),
                    'hikebike' => esc_html__( 'Hike & Bike Map', 'royal-addons-for-elementor' ),
                    'openmap_surfer' => esc_html__( 'OpenMapSurfer', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'thunderforest_api_key',
            [
                'label' => esc_html__( 'Thunderforest API Key', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'description' => sprintf(
                    esc_html__('Required for OpenCycleMap & Transport Map. Get your key %s.', 'royal-addons-for-elementor'),
                    '<a href="https://www.thunderforest.com/docs/apikeys/" target="_blank">' . esc_html__('here', 'royal-addons-for-elementor') . '</a>'
                ),
                'condition' => [
                    'map_layer' => ['opencyclemap', 'transport'],
                ],
            ]
        );

        $this->add_control(
            'fit_bounds',
            [
                'label' => esc_html__( 'Fit All Markers on Map', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__( 'Automatically adjust zoom to show all markers.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'marker_clustering',
            [
                'label' => esc_html__( 'Enable Marker Clustering', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Section: Features
        $this->start_controls_section(
            'section_features',
            [
                'label' => esc_html__( 'Features', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'show_search',
            [
                'label' => esc_html__( 'Show Live Search Bar', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_location_list',
            [
                'label' => esc_html__( 'Show Location List', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'location_list_toggle_button',
            [
                'label' => esc_html__( 'Show List Toggle Button', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'show_location_list' => 'yes', ],
            ]
        );

        $this->add_control(
            'sort_by_distance',
            [
                'label' => esc_html__( 'Sort List by Proximity', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'When user location is found, sort the list by nearest first.', 'royal-addons-for-elementor' ),
                'condition' => [
                    'show_location_list' => 'yes',
                    'show_user_location' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_user_location',
            [
                'label' => esc_html__( 'Show "Find My Location" Button', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'user_location_icon',
            [
                'label' => esc_html__( 'Find Location Icon', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'default' => [
					'value' => 'fas fa-map-marker-alt',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'map-marker-alt',
						'map-pin',
						'map-marker',
						'location-arrow',
						'thumbtack',
					],
					'fa-regular' => [
						'circle',
						'dot-circle',
						'square-full',
					],
				],
                'condition' => [ 'show_user_location' => 'yes', ],
            ]
        );

        $this->add_control(
            'show_routing',
            [
                'label' => esc_html__( 'Show Route & Distance on Click', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => esc_html__( 'From user\'s location to marker. Requires "Find My Location" to be used first.', 'royal-addons-for-elementor' ),
                'condition' => [ 'show_user_location' => 'yes', ],
            ]
        );

        $this->add_control(
            'show_radius_search',
            [
                'label' => esc_html__( 'Show Radius Filter', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'show_user_location' => 'yes', ],
            ]
        );

        $this->add_control(
            'search_radius_default',
            [
                'label' => esc_html__( 'Default Search Radius (km)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'min' => 1,
                'max' => 1000,
                'condition' => [
                    'show_user_location' => 'yes',
                    'show_radius_search' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_pdf_export',
            [
                'label' => esc_html__( 'Show PDF Export Button', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        //=============================================
        // Style Tab
        //=============================================
        $this->start_controls_section(
            'section_style_popup',
            [
                'label' => esc_html__( 'Popup', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'popup_width',
            [
                'label' => esc_html__( 'Max Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 150, 'max' => 500, ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 250, ],
                'selectors' => [
                    '{{WRAPPER}} .leaflet-popup-content-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if ( $this->maybe_render_license_notice() ) {
			return;
		}

        $settings = $this->get_settings_for_display();
        $locations = $settings['locations'];

        $map_data = [
            'locations' => [],
            'settings' => [
                'zoom' => $settings['map_zoom']['size'],
                'mapLayer' => $settings['map_layer'],
                'fitBounds' => $settings['fit_bounds'] === 'yes',
                'markerClustering' => $settings['marker_clustering'] === 'yes',
                'showSearch' => $settings['show_search'] === 'yes',
                'showLocationList' => $settings['show_location_list'] === 'yes',
                'locationListToggleButton' => $settings['location_list_toggle_button'] === 'yes',
                'sortByDistance' => $settings['sort_by_distance'] === 'yes',
                'showUserLocation' => $settings['show_user_location'] === 'yes',
                'showRouting' => $settings['show_routing'] === 'yes',
                'showRadiusFilter' => $settings['show_radius_search'] === 'yes',
                'defaultRadius' => $settings['search_radius_default'],
                'showPdfExport' => $settings['show_pdf_export'] === 'yes',
                'thunderforestApiKey' => $settings['thunderforest_api_key'],
            ]
        ];

        foreach ($locations as $index => $item) {
            $map_data['locations'][] = [ 'id' => $item['_id'], 'title' => $item['location_title'], 'lat' => $item['latitude'], 'lng' => $item['longitude'], 'description' => $item['location_description'], 'image' => $item['location_image']['url'] ?? '', 'phone' => $item['location_phone'], 'address' => $item['location_address'], 'icon' => $item['custom_marker']['url'] ?? '' ];
        }

        $wrapper_classes = ['royal-map-widget-wrapper'];
        if ($settings['show_location_list'] !== 'yes') {
            $wrapper_classes[] = 'royal-map-list-hidden-initial';
        }

        $this->add_render_attribute('wrapper', [ 'class' => $wrapper_classes, 'id' => 'royal-map-' . $this->get_id(), 'data-map-settings' => wp_json_encode($map_data), ]);
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div class="royal-map-controls">
                <?php if ($settings['show_search'] === 'yes') : ?>
                    <div class="royal-map-search-wrapper"><input type="search" aria-label="Search locations" class="royal-map-search-input" placeholder="<?php esc_attr_e('Search locations...', 'royal-addons-for-elementor'); ?>"></div>
                <?php endif; ?>

                <div class="royal-map-buttons-wrapper">
                    <?php if ($settings['show_location_list'] === 'yes' && $settings['location_list_toggle_button'] === 'yes') : ?>
                        <button class="royal-map-btn royal-map-toggle-list-btn" aria-label="Toggle Location List" title="<?php esc_attr_e('Toggle Location List', 'royal-addons-for-elementor'); ?>">
                            <svg class="royal-map-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                        </button>
                    <?php endif; ?>
                    <?php if ($settings['show_user_location'] === 'yes') : ?>
                        <button class="royal-map-btn royal-map-user-location-btn" aria-label="Find My Location" title="<?php esc_attr_e('Find My Location', 'royal-addons-for-elementor'); ?>">
                            <?php \Elementor\Icons_Manager::render_icon( $settings['user_location_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </button>
                    <?php endif; ?>
                    <?php if ($settings['show_pdf_export'] === 'yes') : ?>
                        <button class="royal-map-btn royal-map-pdf-export-btn" aria-label="Export as PDF" title="<?php esc_attr_e('Export as PDF', 'royal-addons-for-elementor'); ?>">
                            <svg class="royal-map-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($settings['show_user_location'] === 'yes' && $settings['show_radius_search'] === 'yes') : ?>
            <div class="royal-map-radius-filter-wrapper">
                <label for="radius-slider-<?php echo $this->get_id(); ?>"><?php esc_html_e('Filter by radius:', 'royal-addons-for-elementor'); ?></label>
                <input type="range" id="radius-slider-<?php echo $this->get_id(); ?>" class="royal-map-radius-slider" min="1" max="1000" value="<?php echo esc_attr($settings['search_radius_default']); ?>">
                <span class="royal-map-radius-value"><?php echo esc_html($settings['search_radius_default']); ?> km</span>
            </div>
            <?php endif; ?>

            <div class="royal-map-main-area">
                <div class="royal-map-container">
                    <div class="royal-map-loader"></div>
                </div>
                <?php if ($settings['show_location_list'] === 'yes') : ?>
                    <div class="royal-map-location-list"><div class="royal-map-list-inner"></div></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
