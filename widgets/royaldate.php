<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit;

class RoyalDate extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style(
            'royaldate',
            ROYAL_ADDONS_ASSETS . 'css/royaldate.css',
            [],
            '1.0.5'
        );
        wp_register_script(
            'royaldate',
            ROYAL_ADDONS_ASSETS . 'js/royaldate.js',
            [ 'elementor-frontend', 'jquery' ],
            '1.0.5',
            true
        );
    }

	public function get_name() {
		return 'royaldate';
	}

	public function get_title() {
		return esc_html__( 'Royal Date & Clock', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-calendar rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'date', 'calendar', 'bengali', 'hijri', 'clock', 'time', 'location', 'maghrib', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
	}

	public function get_style_depends() {
		return [ 'royaldate' ];
	}

	public function get_script_depends() {
		return [ 'royaldate' ];
	}

	protected function register_controls() {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'General Settings', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'horizontal' => [
                        'title' => esc_html__( 'Horizontal', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-ellipsis-h',
                    ],
                    'vertical' => [
                        'title' => esc_html__( 'Vertical', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-ellipsis-v',
                    ],
                ],
                'default' => 'horizontal',
                'prefix_class' => 'royal-date-layout-',
            ]
        );

		$this->add_control(
            'show_clock',
            [
                'label' => esc_html__( 'Show Location Clock', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'no',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'clock_lang',
            [
                'label' => esc_html__( 'Clock Language', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'en',
                'options' => [
                    'en' => 'English',
                    'bn' => 'Bengali',
                ],
                'condition' => [ 'show_clock' => 'yes' ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_location',
			[
				'label' => esc_html__( 'Location Settings', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'location_detection',
			[
				'label' => esc_html__( 'Location Detection', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'auto' => [
                        'title' => esc_html__( 'Auto', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-map-pin',
                    ],
					'manual' => [
                        'title' => esc_html__( 'Manual', 'royal-addons-for-elementor' ),
                        'icon' => 'eicon-edit',
                    ],
				],
				'default' => 'auto',
				'toggle' => false,
			]
		);

		$this->add_control(
            'manual_city',
            [
                'label' => esc_html__( 'City', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Dhaka',
                'condition' => [ 'location_detection' => 'manual' ],
            ]
        );

		$this->add_control(
            'manual_country',
            [
                'label' => esc_html__( 'Country', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Bangladesh',
                'condition' => [ 'location_detection' => 'manual' ],
            ]
        );

        $this->add_control(
            'calculation_method',
            [
                'label' => esc_html__( 'Prayer Time Calculation Method', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => 'Karachi',
                    '2' => 'ISNA',
                    '3' => 'Muslim World League',
                    '4' => 'Makkah',
                    '5' => 'Egyptian',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Calendar Settings', 'royal-addons-for-elementor' ),
            ]
        );

		$this->add_control(
            'show_gregorian',
            [
                'label' => esc_html__( 'Show English Calendar', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'gregorian_lang',
            [
                'label' => esc_html__( 'Language', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'en',
                'options' => [ 'en' => 'English', 'bn' => 'Bengali' ],
                'condition' => [ 'show_gregorian' => 'yes' ],
            ]
        );

		$this->add_control(
            'show_bengali',
            [
                'label' => esc_html__( 'Show Bengali Calendar', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'bengali_lang',
            [
                'label' => esc_html__( 'Language', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bn',
                'options' => [ 'bn' => 'Bengali', 'en' => 'English' ],
                'condition' => [ 'show_bengali' => 'yes' ],
            ]
        );

		$this->add_control(
            'show_hijri',
            [
                'label' => esc_html__( 'Show Hijri Calendar', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'hijri_lang',
            [
                'label' => esc_html__( 'Language', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bn',
                'options' => [ 'bn' => 'Bengali', 'en' => 'English' ],
                'condition' => [ 'show_hijri' => 'yes' ],
            ]
        );

        $this->add_control(
            'hijri_correction',
            [
                'label' => esc_html__( 'Hijri Date Adjustment', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [ '2' => '+2 Days', '1' => '+1 Day', '0' => 'Default', '-1' => '-1 Day', '-2' => '-2 Days' ],
                'condition' => [ 'show_hijri' => 'yes' ],
            ]
        );

        $this->add_control(
            'hijri_change_after_maghrib',
            [
                'label' => esc_html__( 'Change Hijri Date After Maghrib', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [ 'show_hijri' => 'yes' ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
            'section_style_main',
            [
                'label' => esc_html__( 'Layout & Alignment', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'widget_align',
            [
                'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [ 'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => esc_html__( 'Center', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-center' ],
                    'flex-end' => [ 'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .royal-date-content-wrapper' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}}.royal-date-layout-horizontal .royal-date-container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'vertical_spacing',
            [
                'label' => esc_html__( 'Vertical Spacing', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}}.royal-date-layout-vertical .royal-date-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 'layout' => 'vertical' ],
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => esc_html__( 'Separator', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => ',',
                'selectors' => [
                    '{{WRAPPER}}.royal-date-layout-horizontal .royal-date-item:not(:last-child)::after' => 'content: "{{VALUE}}"; margin: 0 0.5em;',
                ],
                'condition' => [ 'layout' => 'horizontal' ],
            ]
        );
        
        $this->end_controls_section();

		$this->start_controls_section(
            'section_style_gregorian',
            [
                'label' => esc_html__( 'Gregorian Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_gregorian' => 'yes' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'gregorian_typography', 'selector' => '{{WRAPPER}} .gregorian-date-item' ]);
        $this->add_control( 'gregorian_color', [ 'label' => __('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .gregorian-date-item' => 'color: {{VALUE}}' ] ]);
        $this->end_controls_section();

		$this->start_controls_section(
            'section_style_bengali',
            [
                'label' => esc_html__( 'Bengali Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_bengali' => 'yes' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'bengali_typography', 'selector' => '{{WRAPPER}} .bengali-date-item' ]);
        $this->add_control( 'bengali_color', [ 'label' => __('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .bengali-date-item' => 'color: {{VALUE}}' ] ]);
        $this->end_controls_section();

		$this->start_controls_section(
            'section_style_hijri',
            [
                'label' => esc_html__( 'Hijri Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_hijri' => 'yes' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'hijri_typography', 'selector' => '{{WRAPPER}} .hijri-date-item' ]);
        $this->add_control( 'hijri_color', [ 'label' => __('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .hijri-date-item' => 'color: {{VALUE}}' ] ]);
        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_style_clock',
            [
                'label' => esc_html__( 'Clock Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_clock' => 'yes' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'clock_typography', 'selector' => '{{WRAPPER}} .royal-clock' ]);
        $this->add_control( 'clock_color', [ 'label' => __('Color', 'royal-addons-for-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .royal-clock' => 'color: {{VALUE}}' ] ]);
        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $widget_settings = [
            'id' => $this->get_id(),
            'locationDetection' => $settings['location_detection'],
            'manualCity' => $settings['manual_city'],
            'manualCountry' => $settings['manual_country'],
            'calculationMethod' => $settings['calculation_method'],
            'hijriChange' => $settings['hijri_change_after_maghrib'],
            'hijriCorrection' => $settings['hijri_correction'],
            'showClock' => $settings['show_clock'],
            'clockLang' => $settings['clock_lang'],
            'showGregorian' => $settings['show_gregorian'],
            'gregorianLang' => $settings['gregorian_lang'],
            'showBengali' => $settings['show_bengali'],
            'bengaliLang' => $settings['bengali_lang'],
            'showHijri' => $settings['show_hijri'],
            'hijriLang' => $settings['hijri_lang'],
        ];
        ?>
        <div class="royal-date-widget-wrapper" data-settings='<?php echo htmlspecialchars(json_encode($widget_settings), ENT_QUOTES, 'UTF-8'); ?>'>
            <div class="royal-date-loader"></div>
            <div class="royal-date-error" style="display: none;"></div>
            <div class="royal-date-content-wrapper" style="display: none;">
                <div class="royal-date-container">
                    <?php if ( 'yes' === $settings['show_clock'] ) : ?>
                        <div class="royal-date-item royal-clock"></div>
                    <?php endif; ?>
                    <?php if ( 'yes' === $settings['show_gregorian'] ) : ?>
                        <div class="royal-date-item gregorian-date-item"></div>
                    <?php endif; ?>
                    <?php if ( 'yes' === $settings['show_bengali'] ) : ?>
                        <div class="royal-date-item bengali-date-item"></div>
                    <?php endif; ?>
                    <?php if ( 'yes' === $settings['show_hijri'] ) : ?>
                        <div class="royal-date-item hijri-date-item"></div>
                    <?php endif; ?>
                </div>
            </div>
            <form class="royal-date-manual-location" style="display: none;">
                <p>Could not auto-detect location. Please enter manually.</p>
                <input type="text" aria-label="City" class="manual-city-input" placeholder="City">
                <input type="text" aria-label="Country" class="manual-country-input" placeholder="Country">
                <button type="button" class="manual-submit-btn">Show Date</button>
            </form>
        </div>
        <?php
	}
}
