<?php
namespace RoyalAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

defined( 'ABSPATH' ) || die();

class RoyalCalendly extends Widget_Base {

    public function get_name() {
        return 'royalcalendly';
    }
	
	public function get_title() {
		return __( 'Calendly', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'royalcalendly rtbranding'; }

	public function get_keywords() {
		return [ 'info', 'blurb', 'calender', 'calendy', 'content', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return array( 'royaltech_3rdparty' );
    }


	protected function register_controls() {
		$this->rt_calendly_general_section();
		$this->rt_calendly_style_section();
	}


	private function rt_calendly_general_section() {
		$this->start_controls_section(
			'_section_calendly',
			[
				'label' => __( 'Calendly', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'calendly_username',
			[
				'label'       => __( 'Username', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'mehdiakram',
				'placeholder' => __( 'Type calendly username here', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'calendly_time',
			[
				'label'   => __( 'Time Slot', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'5min' => __( '5 Minutes', 'royal-addons-for-elementor' ),
					'10min' => __( '10 Minutes', 'royal-addons-for-elementor' ),
					'15min' => __( '15 Minutes', 'royal-addons-for-elementor' ),
					'30min' => __( '30 Minutes', 'royal-addons-for-elementor' ),
					'60min' => __( '60 Minutes', 'royal-addons-for-elementor' ),
					'' => __( 'All', 'royal-addons-for-elementor' ),
				],
				'default' => '10min'
			]
		);

		$this->add_control(
			'event_type_details',
			[
				'label'        => __( 'Hide Event Type Details', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'royal-addons-for-elementor' ),
				'label_off'    => __( 'no', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'      => __( 'Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 100,
						'max'  => 1000,
						'step' => 1,
					],
					'%'  => [
						'min' => 5,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => '680',
				],
				'selectors'  => [
					'{{WRAPPER}} .calendly-inline-widget' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .calendly-wrapper'       => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}



	private function rt_calendly_style_section() {
		$this->start_controls_section(
			'_section_style_calendly',
			[
				'label' => __( 'Calendly', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_calendly_pro_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf(
					__( 'The following color customization controls only work with %s. Free plan users cannot customize colors as per Calendy pricing plan. For more information please %s.', 'royal-addons-for-elementor' ),
					'<a href="https://calendly.com/pages/pricing" target="_blank">Calendly Pro plan</a>',
					'<a href="https://calendly.com/pages/pricing" target="_blank">click here</a>'
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'alpha' => false,
			]
		);

		$this->add_control(
			'button_link_color',
			[
				'label' => __( 'Button & Link Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$calendly_time = $settings['calendly_time']!=''?"/{$settings['calendly_time']}":'';
		?>
		<?php if ( $settings['calendly_username'] ): ?>
            <div class="calendly-inline-widget"
                 data-url="https://calendly.com/<?php echo esc_attr( $settings['calendly_username'] ); ?><?php echo esc_attr( $calendly_time ); ?>/?<?php if ( 'yes' === $settings['event_type_details'] ): echo 'hide_event_type_details=1'; endif; ?><?php if ( $settings['text_color'] ): echo "&text_color=" . str_replace( '#', '', esc_attr($settings['text_color']) ); endif; ?><?php if ( $settings['button_link_color'] ): echo "&primary_color=" . str_replace( '#', '', esc_attr($settings['button_link_color']) ); endif; ?><?php if ( $settings['background_color'] ): echo "&background_color=" . str_replace( '#', '', esc_attr($settings['background_color']) ); endif; ?>"
                 style="min-width:320px;"></div>
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
			<?php if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
                <div class="calendly-wrapper" style="width:100%; position:absolute; top:0; left:0; z-index:100;"></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php
	}
}
