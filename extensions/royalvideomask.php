<?php
use Elementor\Controls_Manager;
use Elementor\Core\Breakpoints\Manager as Breakpoints_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



class RoyalVideomask {

	public static function init() {

		add_action( 'elementor/element/section/section_background/before_section_end',  [ __CLASS__, 'royal_videomask_get_controls' ], 10, 2 );
		add_action( 'elementor/element/container/section_background/before_section_end',  [ __CLASS__, 'royal_videomask_get_controls' ], 10, 2 );

	}
	private static $registered_elements = [];

	public static function royal_videomask_get_controls( $element, $args ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;


		// selector based on the current element
		$selector = '{{WRAPPER}} .elementor-background-video-container'; 


		$element->add_control(
			'royalcontrolsection_videomask',
			[
				'label' => 'Video Mask [Royal]', 
				'type' => Controls_Manager::HEADING,
				'separator' => 'before', 
				'condition' => [
                    'background_background' => [ 'video' ],
				],
			]
        );

		
		$element->add_responsive_control(
			'_royal_videomask_mask_img',
			[
				'label' => __( 'Choose Video Mask', 'royal-addons-for-elementor' ),
				'description' => __( 'NOTE: The video mask should be black-and-transparent SVG file! Anything that’s 100% black in the mask image with be completely visible, anything that’s transparent will be completely hidden.', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'selectors' => [
					$selector => '-webkit-mask-image: url("{{URL}}"); mask-image: url("{{URL}}"); -webkit-mask-mode: alpha; mask-mode: alpha;',
				],
				'condition' => [
					'background_background' => [ 'video' ], 
				],
			]
		);
		
		
		$element->add_responsive_control(
			'_royal_videomask_mask_position',
			[
				'label' => __( 'Mask position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'center center' => __( 'Center Center', 'royal-addons-for-elementor' ),
					'center left' => __( 'Center Left', 'royal-addons-for-elementor' ),
					'center right' => __( 'Center Right', 'royal-addons-for-elementor' ),
					'top center' => __( 'Top Center', 'royal-addons-for-elementor' ),
					'top left' => __( 'Top Left', 'royal-addons-for-elementor' ),
					'top right' => __( 'Top Right', 'royal-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'royal-addons-for-elementor' ),
					'bottom left' => __( 'Bottom Left', 'royal-addons-for-elementor' ),
					'bottom right' => __( 'Bottom Right', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector => '-webkit-mask-position: {{VALUE}}; mask-position: {{VALUE}};',
				],
				'condition' => [
					'_royal_videomask_mask_img[url]!' => '',
					'background_background' => [ 'video' ], 
				],
			]
		);
		
		
		$element->add_responsive_control(
			'_royal_videomask_mask_size',
			[
				'label' => __( 'Mask size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'contain', 
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'auto' => __( 'Auto', 'royal-addons-for-elementor' ),
					'cover' => __( 'Cover', 'royal-addons-for-elementor' ),
					'contain' => __( 'Contain', 'royal-addons-for-elementor' ),
					'initial' => __( 'Custom', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector => '-webkit-mask-size: {{VALUE}}; mask-size: {{VALUE}};',
				],
				'condition' => [
					'_royal_videomask_mask_img[url]!' => '',
					'background_background' => [ 'video' ], 
				],
			]
		);
		
		
		$element->add_responsive_control(
			'_royal_videomask_mask_size_width', 
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors' => [
					$selector => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
				],
				'condition' => [
					'_royal_videomask_mask_size' => [ 'initial' ],
					'_royal_videomask_mask_img[url]!' => '',
					'background_background' => [ 'video' ], 
				],
				'device_args' => [
					Breakpoints_Manager::BREAKPOINT_KEY_TABLET => [
						'selectors' => [
							$selector => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_royal_videomask_mask_size' => [ 'initial' ],
						],
					],
					Breakpoints_Manager::BREAKPOINT_KEY_MOBILE => [
						'selectors' => [
							$selector => '-webkit-mask-size: {{SIZE}}{{UNIT}} auto; mask-size: {{SIZE}}{{UNIT}} auto;',
						],
						'condition' => [
							'_royal_videomask_mask_size' => [ 'initial' ], 
						],
					],
				],
				
			]
		);
		
		
		$element->add_responsive_control(
			'_royal_videomask_mask_repeat',
			[
				'label' => __( 'Mask repeat', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => [
					'no-repeat' => __( 'No-repeat', 'royal-addons-for-elementor' ),
					'repeat' => __( 'Repeat', 'royal-addons-for-elementor' ),
					'repeat-x' => __( 'Repeat-x', 'royal-addons-for-elementor' ),
					'repeat-y' => __( 'Repeat-y', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					$selector => '-webkit-mask-repeat: {{VALUE}}; mask-repeat: {{VALUE}};',
				],
				'condition' => [
					'_royal_videomask_mask_img[url]!' => '',
					'background_background' => [ 'video' ], 
				],
			]
		);

    }

}

RoyalVideomask::init();