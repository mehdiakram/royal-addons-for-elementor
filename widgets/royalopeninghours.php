<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils as Utils;
use Elementor\Repeater as Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalOpeningHours extends Widget_Base {
	
	public function get_name() {
		return 'royalopeninghours';
	}
	
	public function get_title() {
		return __( 'Opening Hours', 'royal-addons-for-elementor' );
	}
	
	public function get_icon() { return 'eicon-clock-o rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
    }
    
    public function get_keywords() {
		return ['opening', 'business', 'hour', 'hours', 'info', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

	public function get_style_depends() {
		return ['royalopeninghours'];
    }
	
	protected function register_controls() {

        $this->start_controls_section(
			'section_openinghours',
			[
				'label' => __( 'Opening Hours', 'royal-addons-for-elementor' ),
			]
        );
        
		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'business_days_timings' );

			$repeater->add_control(
				'business_day',
				[
					'label' => __('Select Day', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::SELECT,
					'default' => 'Monday',
					'options' => [
						'All Days'  => __( 'All Days', 'royal-addons-for-elementor' ),
						'Monday - Friday'  => __( 'Monday - Friday', 'royal-addons-for-elementor' ),
						'Saturday - Sunday'  => __( 'Saturday - Sunday', 'royal-addons-for-elementor' ),
						'Monday'  => __( 'Monday', 'royal-addons-for-elementor' ),
						'Tuesday' => __( 'Tuesday', 'royal-addons-for-elementor' ),
						'Wednesday' => __( 'Wednesday', 'royal-addons-for-elementor' ),
						'Thursday' => __( 'Thursday', 'royal-addons-for-elementor' ),
						'Friday' => __( 'Friday', 'royal-addons-for-elementor' ),
						'Saturday' => __( 'Saturday', 'royal-addons-for-elementor' ),
						'Sunday' => __( 'Sunday', 'royal-addons-for-elementor' ),
					],
				]
			);

			$repeater->add_control(
				'opening_business_time',
				[
					'label' => __('Opening Time', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::SELECT,
					'default' => '24 hours',
					'options' => [
						'Closed' =>      __( 'Closed', 'royal-addons-for-elementor' ),
						'24 hours' =>    __( '24 hours', 'royal-addons-for-elementor' ),
						'12:00 AM' =>    __( '12:00 AM', 'royal-addons-for-elementor' ),
						'12:30 AM' =>    __( '12:30 AM', 'royal-addons-for-elementor' ),
						'1:00 AM' =>     __( '1:00 AM', 'royal-addons-for-elementor' ),
						'1:30 AM' =>     __( '1:30 AM', 'royal-addons-for-elementor' ),
						'2:00 AM' =>     __( '2:00 AM', 'royal-addons-for-elementor' ),
						'2:30 AM' =>     __( '2:30 AM', 'royal-addons-for-elementor' ),
						'3:00 AM' =>     __( '3:00 AM', 'royal-addons-for-elementor' ),
						'3:30 AM' =>     __( '3:30 AM', 'royal-addons-for-elementor' ),
						'4:00 AM' =>     __( '4:00 AM', 'royal-addons-for-elementor' ),
						'4:30 AM' =>     __( '4:30 AM', 'royal-addons-for-elementor' ),
						'5:00 AM' =>     __( '5:00 AM', 'royal-addons-for-elementor' ),
						'5:30 AM' =>     __( '5:30 AM', 'royal-addons-for-elementor' ),
						'6:00 AM' =>     __( '6:00 AM', 'royal-addons-for-elementor' ),
						'6:30 AM' =>     __( '6:30 AM', 'royal-addons-for-elementor' ),
						'7:00 AM' =>     __( '7:00 AM', 'royal-addons-for-elementor' ),
						'7:30 AM' =>     __( '7:30 AM', 'royal-addons-for-elementor' ),
						'8:00 AM' =>     __( '8:00 AM', 'royal-addons-for-elementor' ),
						'8:30 AM' =>     __( '8:30 AM', 'royal-addons-for-elementor' ),
						'9:00 AM' =>     __( '9:00 AM', 'royal-addons-for-elementor' ),
						'9:30 AM' =>     __( '9:30 AM', 'royal-addons-for-elementor' ),
						'10:00 AM' =>    __( '10:00 AM', 'royal-addons-for-elementor' ),
						'10:30 AM' =>    __( '10:30 AM', 'royal-addons-for-elementor' ),
						'11:00 AM' =>    __( '11:00 AM', 'royal-addons-for-elementor' ),
						'11:30 AM' =>    __( '11:30 AM', 'royal-addons-for-elementor' ),
						'12:00 PM' =>    __( '12:00 PM', 'royal-addons-for-elementor' ),
						'12:30 PM' =>    __( '12:30 PM', 'royal-addons-for-elementor' ),
						'1:00 PM' =>     __( '1:00 PM', 'royal-addons-for-elementor' ),
						'1:30 PM' =>     __( '1:30 PM', 'royal-addons-for-elementor' ),
						'2:00 PM' =>     __( '2:00 PM', 'royal-addons-for-elementor' ),
						'2:30 PM' =>     __( '2:30 PM', 'royal-addons-for-elementor' ),
						'3:00 PM' =>     __( '3:00 PM', 'royal-addons-for-elementor' ),
						'3:30 PM' =>     __( '3:30 PM', 'royal-addons-for-elementor' ),
						'4:00 PM' =>     __( '4:00 PM', 'royal-addons-for-elementor' ),
						'4:30 PM' =>     __( '4:30 PM', 'royal-addons-for-elementor' ),
						'5:00 PM' =>     __( '5:00 PM', 'royal-addons-for-elementor' ),
						'5:30 PM' =>     __( '5:30 PM', 'royal-addons-for-elementor' ),
						'6:00 PM' =>     __( '6:00 PM', 'royal-addons-for-elementor' ),
						'6:30 PM' =>     __( '6:30 PM', 'royal-addons-for-elementor' ),
						'7:00 PM' =>     __( '7:00 PM', 'royal-addons-for-elementor' ),
						'7:30 PM' =>     __( '7:30 PM', 'royal-addons-for-elementor' ),
						'8:00 PM' =>     __( '8:00 PM', 'royal-addons-for-elementor' ),
						'8:30 PM' =>     __( '8:30 PM', 'royal-addons-for-elementor' ),
						'9:00 PM' =>     __( '9:00 PM', 'royal-addons-for-elementor' ),
						'9:30 PM' =>     __( '9:30 PM', 'royal-addons-for-elementor' ),
						'10:00 PM' =>    __( '10:00 PM', 'royal-addons-for-elementor' ),
						'10:30 PM' =>    __( '10:30 PM', 'royal-addons-for-elementor' ),
						'11:00 PM' =>    __( '11:00 PM', 'royal-addons-for-elementor' ),
						'11:30 PM' =>    __( '11:30 PM', 'royal-addons-for-elementor' ),
					],
				]
			);

			$repeater->add_control(
				'closing_business_time',
				[
					'label' => __('Closing Time', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::SELECT,
					'default' => '5:00 PM',
					'options' => [
						'12:00 AM' =>    __( '12:00 AM', 'royal-addons-for-elementor' ),
						'12:30 AM' =>    __( '12:30 AM', 'royal-addons-for-elementor' ),
						'1:00 AM' =>     __( '1:00 AM', 'royal-addons-for-elementor' ),
						'1:30 AM' =>     __( '1:30 AM', 'royal-addons-for-elementor' ),
						'2:00 AM' =>     __( '2:00 AM', 'royal-addons-for-elementor' ),
						'2:30 AM' =>     __( '2:30 AM', 'royal-addons-for-elementor' ),
						'3:00 AM' =>     __( '3:00 AM', 'royal-addons-for-elementor' ),
						'3:30 AM' =>     __( '3:30 AM', 'royal-addons-for-elementor' ),
						'4:00 AM' =>     __( '4:00 AM', 'royal-addons-for-elementor' ),
						'4:30 AM' =>     __( '4:30 AM', 'royal-addons-for-elementor' ),
						'5:00 AM' =>     __( '5:00 AM', 'royal-addons-for-elementor' ),
						'5:30 AM' =>     __( '5:30 AM', 'royal-addons-for-elementor' ),
						'6:00 AM' =>     __( '6:00 AM', 'royal-addons-for-elementor' ),
						'6:30 AM' =>     __( '6:30 AM', 'royal-addons-for-elementor' ),
						'7:00 AM' =>     __( '7:00 AM', 'royal-addons-for-elementor' ),
						'7:30 AM' =>     __( '7:30 AM', 'royal-addons-for-elementor' ),
						'8:00 AM' =>     __( '8:00 AM', 'royal-addons-for-elementor' ),
						'8:30 AM' =>     __( '8:30 AM', 'royal-addons-for-elementor' ),
						'9:00 AM' =>     __( '9:00 AM', 'royal-addons-for-elementor' ),
						'9:30 AM' =>     __( '9:30 AM', 'royal-addons-for-elementor' ),
						'10:00 AM' =>    __( '10:00 AM', 'royal-addons-for-elementor' ),
						'10:30 AM' =>    __( '10:30 AM', 'royal-addons-for-elementor' ),
						'11:00 AM' =>    __( '11:00 AM', 'royal-addons-for-elementor' ),
						'11:30 AM' =>    __( '11:30 AM', 'royal-addons-for-elementor' ),
						'12:00 PM' =>    __( '12:00 PM', 'royal-addons-for-elementor' ),
						'12:30 PM' =>    __( '12:30 PM', 'royal-addons-for-elementor' ),
						'1:00 PM' =>     __( '1:00 PM', 'royal-addons-for-elementor' ),
						'1:30 PM' =>     __( '1:30 PM', 'royal-addons-for-elementor' ),
						'2:00 PM' =>     __( '2:00 PM', 'royal-addons-for-elementor' ),
						'2:30 PM' =>     __( '2:30 PM', 'royal-addons-for-elementor' ),
						'3:00 PM' =>     __( '3:00 PM', 'royal-addons-for-elementor' ),
						'3:30 PM' =>     __( '3:30 PM', 'royal-addons-for-elementor' ),
						'4:00 PM' =>     __( '4:00 PM', 'royal-addons-for-elementor' ),
						'4:30 PM' =>     __( '4:30 PM', 'royal-addons-for-elementor' ),
						'5:00 PM' =>     __( '5:00 PM', 'royal-addons-for-elementor' ),
						'5:30 PM' =>     __( '5:30 PM', 'royal-addons-for-elementor' ),
						'6:00 PM' =>     __( '6:00 PM', 'royal-addons-for-elementor' ),
						'6:30 PM' =>     __( '6:30 PM', 'royal-addons-for-elementor' ),
						'7:00 PM' =>     __( '7:00 PM', 'royal-addons-for-elementor' ),
						'7:30 PM' =>     __( '7:30 PM', 'royal-addons-for-elementor' ),
						'8:00 PM' =>     __( '8:00 PM', 'royal-addons-for-elementor' ),
						'8:30 PM' =>     __( '8:30 PM', 'royal-addons-for-elementor' ),
						'9:00 PM' =>     __( '9:00 PM', 'royal-addons-for-elementor' ),
						'9:30 PM' =>     __( '9:30 PM', 'royal-addons-for-elementor' ),
						'10:00 PM' =>    __( '10:00 PM', 'royal-addons-for-elementor' ),
						'10:30 PM' =>    __( '10:30 PM', 'royal-addons-for-elementor' ),
						'11:00 PM' =>    __( '11:00 PM', 'royal-addons-for-elementor' ),
						'11:30 PM' =>    __( '11:30 PM', 'royal-addons-for-elementor' ),
					],
					'condition' =>[
						'opening_business_time!' => ['24 hours', 'Closed']
					]
				]
			);

			$repeater->add_control(
				'enable_styling',
				[
					'label' => __( 'Enable Styling', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'royal-addons-for-elementor' ),
					'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
					'return_value' => 'true',
					'default' => 'true',
				]
			);

			$repeater->add_control(
				'day_color',
				[
					'label' => __( 'Day Color', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#232323',
					'selectors' => [
						'{{WRAPPER}} .royal-openinghours-wrapper {{CURRENT_ITEM}} .royal-oh-day' => 'color: {{VALUE}}',
					],
					'condition' => [
						'enable_styling' => 'true',
					],
				]
			);

			$repeater->add_control(
				'time_color',
				[
					'label' => __( 'Time Color', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#232323',
					'selectors' => [
						'{{WRAPPER}} .royal-openinghours-wrapper {{CURRENT_ITEM}} .royal-oh-time' => 'color: {{VALUE}}',
					],
					'condition' => [
						'enable_styling' => 'true',
					],
				]
			);

			$repeater->add_control(
				'oh_bg_color',
				[
					'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .royal-openinghours-wrapper {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'enable_styling' => 'true',
					],
				]
			);

			$this->add_control(
				'royal_openinghours_data',
				[
					'label' => __('Business Days & Timings', 'royal-addons-for-elementor'),
					'type' => Controls_Manager::REPEATER,
					'fields' => $repeater->get_controls(),
					'default' => [
						[
							'business_day' => __('Saturday', 'royal-addons-for-elementor'),
							'opening_business_time' => __('10:00 AM', 'royal-addons-for-elementor'),
							'closing_business_time' => __('5:00 PM', 'royal-addons-for-elementor'),
							'enable_styling' => 'false',
							'day_color' => '#bb0f0f',
							'time_color' => '#bb0f0f',
							'oh_bg_color' => '#fff',
						],
						[
							'business_day' => __('Sunday', 'royal-addons-for-elementor'),
							'opening_business_time' => __('10:00 AM', 'royal-addons-for-elementor'),
							'closing_business_time' => __('5:00 PM', 'royal-addons-for-elementor'),
							'enable_styling' => 'false',
							'day_color' => '#000',
							'time_color' => '#000',
							'oh_bg_color' => '#fff',
						],					
						[
							'business_day' => __('Monday', 'royal-addons-for-elementor'),
							'opening_business_time' => __('10:00 AM', 'royal-addons-for-elementor'),
							'closing_business_time' => __('5:00 PM', 'royal-addons-for-elementor'),
							'enable_styling' => 'false',
							'day_color' => '#000',
							'time_color' => '#000',
							'oh_bg_color' => '#fff',
						],
						[
							'business_day' => __('Tuesday', 'royal-addons-for-elementor'),
							'opening_business_time' => __('10:00 AM', 'royal-addons-for-elementor'),
							'closing_business_time' => __('5:00 PM', 'royal-addons-for-elementor'),
							'enable_styling' => 'false',
							'day_color' => '#000',
							'time_color' => '#000',
							'oh_bg_color' => '#fff',
						],
						[
							'business_day' => __('Wednesday', 'royal-addons-for-elementor'),
							'opening_business_time' => __('10:00 AM', 'royal-addons-for-elementor'),
							'closing_business_time' => __('5:00 PM', 'royal-addons-for-elementor'),
							'enable_styling' => 'false',
							'day_color' => '#000',
							'time_color' => '#000',
							'oh_bg_color' => '#fff',
						],
						[
							'business_day' => __('Thursday', 'royal-addons-for-elementor'),
							'opening_business_time' => __('10:00 AM', 'royal-addons-for-elementor'),
							'closing_business_time' => __('5:00 PM', 'royal-addons-for-elementor'),
							'enable_styling' => 'false',
							'day_color' => '#000',
							'time_color' => '#000',
							'oh_bg_color' => '#fff',
						],
						[
							'business_day' => __('Friday', 'royal-addons-for-elementor'),
							'opening_business_time' => __('Closed', 'royal-addons-for-elementor'),
							'enable_styling' => 'true',
							'day_color' => '#FF0000',
							'time_color' => '#FF0000',
							'oh_bg_color' => '#fff',
						],
					],
					'title_field' => '{{{ business_day }}}',
				]
			);
		
		$repeater->end_controls_tabs();

		$this->add_control(
			'header_text',
			[
				'label' => __('Header', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Opening Hours',
			]
		);

		$this->add_control(
			'footer_text',
			[
				'label' => __('Footer', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Come in we\'re open!',
			]
		);

		$this->add_control(
			'enable_schema',
			[
				'label' => __( 'Enable openingHours Schema', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'royal-addons-for-elementor' ),
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'false'
			]
		);

		$this->add_control(
			'schema_type',
			[
				'label' => __( 'Type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'CivicStructure'  => __( 'CivicStructure', 'royal-addons-for-elementor' ),
					'LocalBusiness' => __( 'LocalBusiness', 'royal-addons-for-elementor' ),
				],
				'default' => 'LocalBusiness',
				'description' => '<b>CivicStructure</b>: A public structure, such as a town hall or concert hall.<br>
				<b>LocalBusiness</b>:A particular physical business or branch of an organization. Site logo is required to be enabled',
				'condition' => [
					'enable_schema' => 'yes'
				]
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'opening_hours_styling',
			[
				'label' => __( 'Opening Hours Styling', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'row_spacing',
                [
                    'label' => __( 'Row Spacing', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'default' => [
                        'top' => '10',
                        'right' => '10',
                        'bottom' => '10',
                        'left' => '10',
                        'isLinked' => true,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'divider_styling',
			[
				'label' => __( 'Divider', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'enable_divider',
                [
                    'label' => __( 'Divider', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                    'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
                    'return_value' => 'true',
                    'default' => 'true',
                ]
            );

            $this->add_control(
                'divider_style',
                [
                    'label' => __( 'Style', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'solid',
                    'options' => [
                        'solid'  => __( 'Solid', 'royal-addons-for-elementor' ),
                        'dotted' => __( 'Dotted', 'royal-addons-for-elementor' ),
                        'dashed' => __( 'Dashed', 'royal-addons-for-elementor' ),
                    ],
                    'condition' => [
                        'enable_divider' => 'true',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-row:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'divider_color',
                [
                    'label' => __( 'Divider Color', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '#E6E6E65C',
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-row:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
                    ],
                    'condition' => [
                        'enable_divider' => 'true',
                    ],
                ]
            );

            $this->add_control(
                'divider_weight',
                [
                    'label' => __( 'Weight', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 20,
                            'step' => 1,
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 1,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-row:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                    ],
                    'condition' => [
                        'enable_divider' => 'true',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'day_time_styling',
			[
				'label' => __( 'Day & Time', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'day_alignment',
                [
                    'label' => __( 'Day Alignment', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'royal-addons-for-elementor' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'royal-addons-for-elementor' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'royal-addons-for-elementor' ),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default' => 'left',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-day' => "text-align: {{VALUE}}",
                    ]
                ]
            );

            $this->add_control(
                'time_alignment',
                [
                    'label' => __( 'Time Alignment', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'royal-addons-for-elementor' ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'royal-addons-for-elementor' ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'royal-addons-for-elementor' ),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default' => 'right',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-time' => "text-align: {{VALUE}}",
                    ]
                ]
            );

            $this->add_control(
                'oh_day_color',
                [
                    'label' => __( 'Day Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#232323',
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-day' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'day_typography',
                    'label' => __( 'Day Typography', 'royal-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-day',
                ]
            );

            $this->add_control(
                'oh_time_color',
                [
                    'label' => __( 'Time Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#232323',
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-time' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'time_typography',
                    'label' => __( 'Time Typography', 'royal-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-time',
                ]
            );

            $this->add_control(
                'striped_effect',
                [
                    'label' => __( 'Striped Effect', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
                    'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
                    'return_value' => 'true',
                    'default' => 'true',
                ]
            );

            $this->add_control(
                'odd_rows_bg_color',
                [
                    'label' => __( 'Odd Rows Background', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#fff',
                    'selectors' => [
                       '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-row.mt-striped:nth-child(odd)' => 'background: {{VALUE}}',
                    ],
                    'condition' => [
                        'striped_effect' => 'true',
                    ],
                ]
            );

            $this->add_control(
                'even_rows_bg_color',
                [
                    'label' => __( 'Even Rows Background', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#FAFBFD',
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-row.mt-striped:nth-child(even)' => 'background: {{VALUE}}',
                    ],
                    'condition' => [
                        'striped_effect' => 'true',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'header_text_styling',
			[
				'label' => __( 'Header Styling', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
					'header_text!' => ''
				],
			]
        );

            $this->add_control(
                'oh_header_color',
                [
                    'label'     => __( 'Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royal-oh-header' => 'color: {{VALUES}}'
                    ],
                    'default' => '#fff',
                ]
            );

            $this->add_control(
                'oh_header_bgcolor',
                [
                    'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royal-oh-header' => 'background-color: {{VALUES}}'
                    ],
                    'default' => '#6732B8',
                ]
            );

            $this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'oh_header_typography',
					'selector' => '{{WRAPPER}} .royal-oh-header',
				]
            );

            $this->add_control(
                'oh_header_padding',
                [
                    'label' => __( 'Padding', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'default' => [
                        'top' =>  '10',
                        'right' => '10',
                        'bottom' => '10',
                        'left' => '10',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'oh_header_margin',
                [
                    'label' => __( 'Margin', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'default' => [
                        'top' => '0',
                        'right' => '0',
                        'bottom' => '20',
                        'left' => '0',
                        'isLinked' => true,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();

        $this->start_controls_section(
			'footer_text_styling',
			[
				'label' => __( 'Footer Styling', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
					'footer_text!' => ''
				],
			]
        );

            $this->add_control(
                'oh_footer_color',
                [
                    'label'     => __( 'Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royal-oh-footer' => 'color: {{VALUES}}'
                    ],
                    'default' => '#000',
                ]
            );

            $this->add_control(
                'oh_footer_bgcolor',
                [
                    'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royal-oh-footer' => 'background-color: {{VALUES}}'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'oh_footer_typography',
                    'selector' => '{{WRAPPER}} .royal-oh-footer',
                ]
            );

            $this->add_control(
                'oh_footer_padding',
                [
                    'label' => __( 'Padding', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'oh_footer_margin',
                [
                    'label' => __( 'Margin', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-openinghours-wrapper .royal-oh-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

        $this->end_controls_section();
        
	}
	
	protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings[ 'royal_openinghours_data'] ) ) {
            return;
        }
        $enableSchema = $settings['enable_schema'] == "yes" ? true : false;
        $schemaType = $settings['schema_type'];
        ?>

        <div class="royal-openinghours-wrapper" <?php echo $enableSchema ? ' itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/' . $schemaType . '"' : ''; ?>>
            <?php
            // Logo for LocalBusiness Schema
            if ( $enableSchema && $settings['schema_type'] == "LocalBusiness" ) :
                $logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' );
                if ( has_custom_logo() ) {
                    echo '<img style="display:none;" itemprop="image" src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
                }
            endif;
            ?>
            <div <?php echo $enableSchema ? 'itemprop="name"' : ''; ?> class="royal-oh-header"><?php echo wp_kses_post( $settings['header_text'] ); ?></div>

            <div class="royal-oh-rows">
                <?php foreach (  $settings['royal_openinghours_data'] as $item ) : 
                    $closingTime = $item['opening_business_time'] === "Closed" || $item['opening_business_time'] === "24 hours" ? false : true;
                    if ( $enableSchema ) {
                        $schemaDay = "";
                        switch( $item['business_day'] ) {
                            case 'All Days': $schemaDay = "Mo-Su";
                            break;
                            case 'Monday - Friday': $schemaDay = "Mo-Fr";
                            break;
                            case 'Saturday - Sunday': $schemaDay = "Sa-Su";
                            break;
                            default: $schemaDay = substr($item['business_day'], 0, 2);
                        }
                    }
                ?>
                <div class="royal-oh-row <?php echo ($settings['striped_effect'] == true) ? 'mt-striped' : ''; ?> elementor-repeater-item-<?php echo wp_kses_post( $item['_id'] ); ?>">
                    <div class="royal-oh-day">
                        <time <?php echo $enableSchema ? 'itemprop="openingHours" datetime="'. $schemaDay .'"' : ''; ?>><?php echo wp_kses_post( $item['business_day'] ); ?></time>
                    </div>

                    <div class="royal-oh-time" <?php echo $enableSchema ? 'itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification"' : ''; ?>>
                        <?php if ( $item['opening_business_time'] === "24 hours" ) { ?>

                            <time <?php echo $enableSchema ? 'itemprop="opens" content="' . date("H:i", strtotime("12:00 AM")) . '"' : ''; ?>><?php echo wp_kses_post( $item['opening_business_time'] ); ?></time>

                            <?php if ( $enableSchema ) : ?>
                            <time itemprop="closes" content="<?php echo date("H:i", strtotime("12:00 PM")); ?>"></time>
                            <?php endif; ?>

                        <?php } else { ?>
                            <time <?php echo $enableSchema ? 'itemprop="opens" content="' . date("H:i", strtotime($item['opening_business_time'])) . '"' : ''; ?>><?php echo wp_kses_post( $item['opening_business_time'] ); ?></time>
                            
                            <?php if ( $closingTime ) : ?>
                                - <time <?php echo $enableSchema ? 'itemprop="closes" content="' . date("H:i", strtotime($item['closing_business_time'])) . '"' : ''; ?>><?php echo wp_kses_post( $item['closing_business_time'] ); ?></time>
                            <?php endif;
                        } ?>
                        
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

            <div <?php echo $enableSchema ? 'itemprop="description"' : ''; ?> class="royal-oh-footer"><?php echo wp_kses_post( $settings['footer_text'] ); ?></div>

        </div>
        <?php
	}
	
}
