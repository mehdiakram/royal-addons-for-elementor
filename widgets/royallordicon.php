<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

defined( 'ABSPATH' ) || die();

class RoyalLordIcon extends Widget_Base {
    
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_script('royallordicon', ROYAL_ADDONS_DIR_URL. 'assets/vendor/lord-icon/lord-icon-2.1.0.js');
	}
	
	public function get_name() {
		return 'royallordicon';
	}
	
	public function get_title() {
		return __( 'Lord Icon', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-icon-box rtbranding'; }

	public function get_keywords() {
		return ['icon', 'lordicon', 'animation', 'info', 'box', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = [];
		return $styles;
	}

	
	public function get_script_depends() {
		$scripts = ['royallordicon'];
		return $scripts;
	}


	protected function register_controls() {
		$this->royal_lordicon_content_controls();
		$this->royal_lordicon_style_controls();
	}
	
	
	protected function royal_lordicon_content_controls() {
		$this->start_controls_section(
			'royal_section_icon',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon_method',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => __( 'Icon Method', 'royal-addons-for-elementor' ),
				'description' => sprintf( '<a target="_blank" href="%1$s">Learn how to use the Lordicon widget</a>', esc_url( 'https://royal-addons-for-elementorbd.com/docs/royal-addons-for-elementor/widgets/lord-icon' ) ),
				'options'     => [
					'cdn'  => esc_html__( 'Paste Lordicon URL', 'royal-addons-for-elementor' ),
					'file' => esc_html__( 'Upload Lordicon file', 'royal-addons-for-elementor' ),
				],
				'default'     => 'cdn',
				'label_block' => true,
			]
		);
		$this->add_control(
			'icon_cdn',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Paste CDN', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'description' => sprintf(
					'Paste icon code from <a target="_blank" href="%1$s">lordicon.com</a> <br /><br /> <a target="_blank" href="%2$s">Learn how to get Lordicon CDN</a><br><br>
                Example: https://cdn.lordicon.com/lupuorrc.json', esc_url( 'https://lordicon.com/' ), esc_url( 'https://royal-addons-for-elementorbd.com/docs/royal-addons-for-elementor/widgets/lord-icon' )
				),
				'default'     => 'https://cdn.lordicon.com/lupuorrc.json',
				'condition'   => [
					'icon_method' => 'cdn',
				],
			]
		);
		$this->add_control(
			'icon_json',
			[
				'type'        => Controls_Manager::MEDIA,
				'label'       => __( 'JSON File', 'royal-addons-for-elementor' ),
				'media_type'  => 'application/json',
				'description' => sprintf( 'Download Json file from <a href="%1$s" target="_blank">lordicon.com</a>', esc_url( 'https://lordicon.com/' ) ),
				'default'     => [
					'url' => ROYAL_ADDONS_DIR_URL . 'assets/vendor/lord-icon/placeholder.json',
				],
				'condition'   => [
					'icon_method' => 'file',
				],
			]
		);
		$this->add_control(
			'animation_trigger',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Animation Trigger', 'royal-addons-for-elementor' ),
				'options' => [
					'loop'          => esc_html__( 'Loop (infinite)', 'royal-addons-for-elementor' ),
					'click'         => esc_html__( 'Click', 'royal-addons-for-elementor' ),
					'hover'         => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
					'loop-on-hover' => esc_html__( 'Loop on Hover', 'royal-addons-for-elementor' ),
					'morph'         => esc_html__( 'Morph', 'royal-addons-for-elementor' ),
					'morph-two-way' => esc_html__( 'Morph two way', 'royal-addons-for-elementor' ),
				],
				'default' => 'loop',
			]
		);
		$this->add_control(
			'target',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Target', 'royal-addons-for-elementor' ),
				'options' => [
					'widget'  => __( 'On Widget', 'royal-addons-for-elementor' ),
					// 'icon' => __('On Icon', 'royal-addons-for-elementor' ),
					'column'  => __( 'On Column', 'royal-addons-for-elementor' ),
					'section' => __( 'On Section', 'royal-addons-for-elementor' ),
					'custom'  => __( 'Custom', 'royal-addons-for-elementor' ),
				],
				'default' => 'widget',
			]
		);
		$this->add_control(
			'custom_target',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Custom Target', 'royal-addons-for-elementor' ),
				'placeholder' => __( '.example', 'royal-addons-for-elementor' ),
				'default'     => __( '.example', 'royal-addons-for-elementor' ),
				'condition'   => [
					'target' => 'custom',
				],
			]
		);

		$this->add_control(
			'pulse_effect',
			[
				'label'        => esc_html__( 'Pulse Effect', 'royal-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'This will override your box shadow', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'pulse_color',
			[
				'label'     => __( 'Pulse Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B6B6B6',
				'condition' => [
					'pulse_effect' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .pulse_effect' => '--pulse-color:{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'toggle'    => true,
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .royal-lordicon-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function royal_lordicon_style_controls() {
		$this->start_controls_section(
			'royal_section_style_icon',
			[
				'label' => __( 'Icon', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'   => __( 'Size', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				// 'size_units' => [ 'px' ],
				'range'   => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default' => [
					'size' => 150,
				],
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'   => __( 'Primary Color', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#121331',
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label'   => __( 'Secondary Color', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#08a88a',
			]
		);
		$this->add_control(
			'tertiary_color',
			[
				'label'   => __( 'Tertiary Color', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#0816A8',
			]
		);

		$this->add_control(
			'quaternary_color',
			[
				'label'   => __( 'Quaternary Color', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#2CA808',
			]
		);

		$this->add_control(
			'icon_stroke',
			[
				'label'   => __( 'Stroke', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'min' => 1,
					'max' => 500,
				],
				'default' => [
					'size' => '20',
				],
			]
		);

		$this->add_control(
			'icon_bg_color',
			[
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-lordicon-wrapper' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'icon_border',
				'selector' => '{{WRAPPER}} .royal-lordicon-wrapper',
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .royal-lordicon-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .royal-lordicon-wrapper',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$json_url    = '';
		$method      = $settings['icon_method'];
		$target      = $settings['target'];
		$icon_size   = $settings['icon_size'];
		$icon_stroke = $settings['icon_stroke'];

		if ( 'file' == $method ) {
			$json_url = $settings['icon_json']['url'];
		} else {
			$json_url = $settings['icon_cdn'];
		}
		$target_class = '';

		if ( 'custom' == $target ) {
			$target_class = $settings['custom_target'];
		} elseif ( 'column' == $target ) {
			$target_class = '.elementor-column';
		} elseif ( 'section' == $target ) {
			$target_class = '.elementor-section';
		} else {
			$target_class = '.royal-lordicon-wrapper';
		}
		$pulse_effect = ( 'yes' == $settings['pulse_effect'] ) ? ' pulse_effect' : '';

		?>
			<div class="royal-lordicon-wrapper<?php echo esc_attr( $pulse_effect ); ?>">
			<lord-icon
				src="<?php echo esc_url( $json_url ); ?>"
				trigger="<?php echo esc_attr( $settings['animation_trigger'] ); ?>"
				stroke="<?php echo esc_attr( $icon_stroke['size'] ); ?>"
				target="<?php echo esc_attr( $target_class ); ?>"
				colors="primary:<?php echo esc_attr( $settings['primary_color'] ); ?>,secondary:<?php echo esc_attr( $settings['secondary_color'] ); ?>,tertiary:<?php echo esc_attr( $settings['tertiary_color'] ); ?>,quaternary:<?php echo esc_attr( $settings['quaternary_color'] ); ?>"
				style="width:<?php echo esc_attr( $icon_size['size'] ); ?>px;height:<?php echo esc_attr( $icon_size['size'] ); ?>px">
			</lord-icon>
			</div>
		<?php

	}
}
