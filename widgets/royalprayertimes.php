<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RoyalPrayerTimes extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_style( 'royalprayertimes', plugins_url( '../assets/css/royalprayertimes.css', __FILE__ ), [], '1.1.2' );
        wp_register_script( 'royalprayertimes', plugins_url( '../assets/js/royalprayertimes.js', __FILE__ ), [ 'jquery' ], '1.1.2', true );
    }

    public function get_script_depends() {
        return [ 'royalprayertimes' ];
    }

    public function get_style_depends() {
        return [ 'royalprayertimes' ];
    }

	public function get_name() {
		return 'royalprayertimes';
	}

	public function get_title() {
		return esc_html__( 'Prayer Times', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-clock-o rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'prayer', 'times', 'islam', 'salah', 'namaz', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	protected function register_controls() {
		$this->start_controls_section(
            'section_content_settings',
            [
                'label' => esc_html__( 'Prayer Times Settings', 'royal-addons-for-elementor' )
            ]
        );

		$this->add_control(
            'location_detection',
            [
                'label' => esc_html__( 'Location Detection', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => [
                    'auto' => esc_html__( 'Auto-detect Location', 'royal-addons-for-elementor' ),
                    'manual' => esc_html__( 'Manual Location', 'royal-addons-for-elementor' ),
                ],
            ]
        );

		$this->add_control(
            'manual_location_city',
            [
                'label' => esc_html__( 'City', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Mecca', 'royal-addons-for-elementor' ),
                'condition' => [
                    'location_detection' => 'manual',
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'manual_location_country',
            [
                'label' => esc_html__( 'Country', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Saudi Arabia', 'royal-addons-for-elementor' ),
                'condition' => [
                    'location_detection' => 'manual',
                ],
                'label_block' => true,
            ]
        );

		$this->add_control(
            'calculation_method',
            [
                'label' => esc_html__( 'Calculation Method', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => 'Shia Ithna-Ashari (Jafari)', 
                    '2' => 'Islamic Society of North America (ISNA)',
                    '3' => 'Muslim World League (MWL)', 
                    '4' => 'Umm al-Qura University, Makkah',
                    '5' => 'Egyptian General Authority of Survey', 
                    '7' => 'Institute of Geophysics, University of Tehran',
                    '8' => 'Gulf Region Method', 
                    '9' => 'Kuwait University', 
                    '10' => 'Qatar Calendar House',
                    '11' => 'Majlis Ugama Islam Singapura (Singapore)', 
                    '12' => 'Union des Organisations Islamiques de France (UOIF)',
                    '13' => 'Diyanet İşleri Başkanlığı (Turkey)', 
                    '14' => 'Spiritual Administration of Muslims of Russia',
                ]
            ]
        );

        $this->add_control(
            'time_format',
            [
                'label' => esc_html__( 'Time Format', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '12h',
                'options' => [ '12h' => '12-Hour', '24h' => '24-Hour' ],
            ]
        );

        $this->add_control(
            'display_style',
            [
                'label' => esc_html__( 'Display Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__( 'Style 1 (List)', 'royal-addons-for-elementor' ),
                    'style2' => esc_html__( 'Style 2 (Horizontal)', 'royal-addons-for-elementor' ),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control( 'show_location', [ 'label' => esc_html__( 'Show Location', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', ] );
        $this->add_control( 'show_date', [ 'label' => esc_html__( 'Show Date', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', ] );
        $this->add_control( 'show_current_time', [ 'label' => esc_html__( 'Show Current Time', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', ] );
		$this->add_control( 'hr_labels', [ 'type' => Controls_Manager::DIVIDER, 'style' => 'thick' ] );
		$this->add_control( 'fajr_label', [ 'label' => __('Fajr Label', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Fajr' ] );
        $this->add_control( 'dhuhr_label', [ 'label' => __('Dhuhr Label', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Dhuhr' ] );
		$this->add_control( 'asr_label', [ 'label' => __('Asr Label', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Asr' ] );
		$this->add_control( 'maghrib_label', [ 'label' => __('Maghrib Label', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Maghrib' ] );
		$this->add_control( 'isha_label', [ 'label' => __('Isha Label', 'royal-addons-for-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Isha' ] );
		$this->end_controls_section();

		$this->start_controls_section(
            'section_style_container',
            [
                'label' => esc_html__( 'Container', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-times-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .royal-prayer-times-wrapper',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-times-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .royal-prayer-times-wrapper',
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-times-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
            'section_style_header',
            [
                'label' => esc_html__( 'Header', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_text_color',
            [
                'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-times-header' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'label' => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royal-prayer-times-header .location, {{WRAPPER}} .royal-prayer-times-header .date, {{WRAPPER}} .royal-prayer-times-header .current-time',
            ]
        );
        
        $this->add_responsive_control(
            'header_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-times-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
            'section_style_prayer_rows',
            [
                'label' => esc_html__( 'Prayer Rows', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'prayer_name_heading',
            [
                'label' => esc_html__( 'Prayer Name', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'prayer_name_color',
            [
                'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-time-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'prayer_name_typography',
                'selector' => '{{WRAPPER}} .royal-prayer-time-name',
            ]
        );

        $this->add_control(
            'prayer_time_heading',
            [
                'label' => esc_html__( 'Prayer Time', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'prayer_time_color',
            [
                'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-time-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'prayer_time_typography',
                'selector' => '{{WRAPPER}} .royal-prayer-time-value',
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'section_style_current_prayer',
            [
                'label' => esc_html__( 'Current Prayer', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'current_prayer_background',
            [
                'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-time-row.current' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'current_prayer_text_color',
            [
                'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royal-prayer-time-row.current .royal-prayer-time-name' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .royal-prayer-time-row.current .royal-prayer-time-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        
        $wrapper_classes = ['royal-prayer-times-wrapper', $settings['display_style']];
        if ( 'yes' !== $settings['show_location'] && 'yes' !== $settings['show_date'] && 'yes' !== $settings['show_current_time'] ) {
            $wrapper_classes[] = 'royal-header-hidden';
        }

        $data_settings = [
            'id' => $this->get_id(), 'locationDetection' => $settings['location_detection'],
            'manualCity' => $settings['manual_location_city'], 'manualCountry' => $settings['manual_location_country'],
            'calculationMethod' => $settings['calculation_method'], 'timeFormat' => $settings['time_format'],
            'showCurrentTime' => $settings['show_current_time'],
            'fajrLabel' => $settings['fajr_label'], 'dhuhrLabel' => $settings['dhuhr_label'], 'asrLabel' => $settings['asr_label'],
            'maghribLabel' => $settings['maghrib_label'], 'ishaLabel' => $settings['isha_label'],
        ];
        
        $this->add_render_attribute( 'wrapper', [ 'class' => $wrapper_classes, 'id' => 'royal-prayer-times-' . $this->get_id(), 'data-settings' => wp_json_encode( $data_settings ), ] );
		?>
		<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php if (
                ( 'yes' === $settings['show_location'] ) ||
                ( 'yes' === $settings['show_date'] ) ||
                ( 'yes' === $settings['show_current_time'] )
            ) : ?>
                <div class="royal-prayer-times-header">
                    <?php if ( 'yes' === $settings['show_location'] ) : ?>
                        <div class="location">--</div>
                    <?php endif; ?>

                    <?php if ( 'yes' === $settings['show_date'] ) : ?>
                        <div class="date">--</div>
                    <?php endif; ?>

                    <?php if ( 'yes' === $settings['show_current_time'] ) : ?>
                        <div class="current-time"></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="royal-prayer-times-body">
                <div class="royal-prayer-times-loader">
                    <?php esc_html_e( 'Loading Prayer Times...', 'royal-addons-for-elementor' ); ?>
                </div>
                <div class="royal-prayer-times-error" style="display: none;"></div>
                <div class="royal-prayer-times-list" style="display: none;">
                    <?php
                    $prayers = [ 'Fajr' => $settings['fajr_label'], 'Dhuhr' => $settings['dhuhr_label'], 'Asr' => $settings['asr_label'], 'Maghrib' => $settings['maghrib_label'], 'Isha' => $settings['isha_label'], ];
                    foreach ( $prayers as $key => $label ) {
                        echo '<div class="royal-prayer-time-row" data-prayer="' . strtolower($key) . '"><span class="royal-prayer-time-name">' . esc_html( $label ) . '</span><span class="royal-prayer-time-value">--:--</span></div>';
                    }
                    ?>
                </div>
            </div>
            <div class="royal-prayer-manual-location" style="display: none;">
                <p><?php esc_html_e('Could not auto-detect location. Please enter manually.', 'royal-addons-for-elementor'); ?></p>
                <input type="text" aria-label="City" class="manual-city-input" placeholder="<?php esc_attr_e( 'City', 'royal-addons-for-elementor' ); ?>">
                <input type="text" aria-label="Country" class="manual-country-input" placeholder="<?php esc_attr_e( 'Country', 'royal-addons-for-elementor' ); ?>">
                <button class="manual-submit-btn"><?php esc_html_e( 'Get Times', 'royal-addons-for-elementor' ); ?></button>
            </div>
		</div>
		<?php
	}

    protected function content_template() {
        ?>
		<#
            var wrapper_classes = 'royal-prayer-times-wrapper ' + settings.display_style;
            if ( 'yes' !== settings.show_location && 'yes' !== settings.show_date && 'yes' !== settings.show_current_time ) {
                wrapper_classes += ' royal-header-hidden';
            }
        #>
		<div class="{{ wrapper_classes }}">
            <div class="royal-prayer-times-header">
                <# if ( 'yes' === settings.show_location ) { #><div class="location">Location Preview</div><# } #>
                <# if ( 'yes' === settings.show_date ) { #><div class="date">Date Preview</div><# } #>
                <# if ( 'yes' === settings.show_current_time ) { #><div class="current-time">Time Preview</div><# } #>
            </div>
            <div class="royal-prayer-times-body">
                <div class="royal-prayer-times-list">
                     <#
                        var prayers = { 
                            'Fajr': settings.fajr_label, 'Dhuhr': settings.dhuhr_label, 'Asr': settings.asr_label,
                            'Maghrib': settings.maghrib_label, 'Isha': settings.isha_label
                        };
                        _.each(prayers, function(label, key) { #>
                            <div class="royal-prayer-time-row" data-prayer="{{ key.toLowerCase() }}">
                                <span class="royal-prayer-time-name">{{{ label }}}</span>
                                <span class="royal-prayer-time-value">--:--</span>
                            </div>
                        <# });
                    #>
                </div>
            </div>
		</div>
	<?php }
}
