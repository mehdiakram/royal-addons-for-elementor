<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalChartPieDonut extends Widget_Base {

    public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
		wp_register_script( 'royalchart', ROYAL_ADDONS_DIR_URL . 'assets/js/chart.js', [ 'jquery' ], ROYAL_ADDONS_VERSION, true );
		wp_register_script( 'royalchartpiedonut', ROYAL_ADDONS_DIR_URL . 'assets/js/royalchartpiedonut.js', [ 'jquery' ], ROYAL_ADDONS_VERSION, true );
	}

	public function get_name() {
		return 'royalchartpiedonut';
	}

	public function get_title() {
		return __( 'Pie Donut Chart', 'royal-addons-for-elementor' );
    }
    
	public function get_icon() { return 'eicon-sort-amount-desc rtbranding'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_script_depends() {
        return ['royalchart', 'royalchartpiedonut'];
    }

    public function get_style_depends() {
		return [];
    }
    
	public function get_keywords() {
		return [ 'pie', 'donut', 'chart', 'graph', 'product', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }
    
	protected function register_controls() {
		$this->start_controls_section(
			'section_mpdc_basic',
			[
				'label' => __( 'Basic', 'royal-addons-for-elementor' ),
			]
		);

            $repeater = new \Elementor\Repeater();

            $repeater->add_control(
                'data_label',
                [
                    'label' => __('Data Label', 'royal-addons-for-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $repeater->add_control(
                'data_value', [
                    'label' => __( 'Data Value', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'label_block' => true,
                ]
            );

            $repeater->add_control(
                'background_image',
                [
                    'label' => __( 'Background Image', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::MEDIA,
                ]
            );

            $repeater->add_control(
                'background_color', [
                    'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                ]
            );

            $repeater->add_control(
                'background_hover_color', [
                    'label' => __( 'Background Hover Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                ]
            );

            $repeater->add_control(
                'border_color', [
                    'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                ]
            );

            $repeater->add_control(
                'border_hover_color', [
                    'label' => __( 'Border Hover Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                ]
            );

            $this->add_control(
                'data_list',
                [
                    'label' => __( 'Data Sets', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => 
                    array(
                    [
                            'data_value' => __( '10', 'royal-addons-for-elementor' ),
                            'data_label' => __( 'Label 1', 'royal-addons-for-elementor' ),
                            'background_color' => __( '#68cfbc', 'royal-addons-for-elementor' ),
                            'background_hover_color' => __( '#B7AFAF', 'royal-addons-for-elementor' ),
                            'background_image' => __( 'Background Image', 'royal-addons-for-elementor' ),
                            'border_color' => __( '#B7AFAF', 'royal-addons-for-elementor' ),
                            'border_hover_color' => __( '#B7AFAF', 'royal-addons-for-elementor' ),
                    ],
                    [
                        
                            'data_value' => __( '30', 'royal-addons-for-elementor' ),
                            'data_label' => __( 'Label 2', 'royal-addons-for-elementor' ),
                            'background_color' => __( '#58b5d8', 'royal-addons-for-elementor' ),
                            'background_hover_color' => __( '#827C7C', 'royal-addons-for-elementor' ),
                            'background_image' => __( 'Background Image', 'royal-addons-for-elementor' ),
                            'border_color' => __( '#827C7C', 'royal-addons-for-elementor' ),
                            'border_hover_color' => __( '#827C7C', 'royal-addons-for-elementor' ),
                    ],
                    [
                        
                            'data_value' => __( '60', 'royal-addons-for-elementor' ),
                            'data_label' => __( 'Label 3', 'royal-addons-for-elementor' ),
                            'background_color' => __( '#f2cd5c', 'royal-addons-for-elementor' ),
                            'background_hover_color' => __( '#484444', 'royal-addons-for-elementor' ),
                            'background_image' => __( 'Background Image', 'royal-addons-for-elementor' ),
                            'border_color' => __( '#484444', 'royal-addons-for-elementor' ),
                            'border_hover_color' => __( '#484444', 'royal-addons-for-elementor' ),
                    ],
                   
                ),
                    'title_field' => '{{{data_label}}}',
                ]
            );

            $this->add_control(
                'chart_title',
                [
                    'label' => __('Title', 'royal-addons-for-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                ]
            );

            $this->add_control(
                'chart_description',
                [
                    'label' => __('Description', 'royal-addons-for-elementor'),
                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                ]
            );

        $this->end_controls_section();
        // style 
        $this->start_controls_section(
			'section_cg_style',
			[
				'label' => __( 'Basic', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'chart_alignment',
                [
                    'label' => __( 'Chart Alignment', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Start', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'right' => [
                            'title' => __( 'End', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                ]
            );

            
            $this->add_control(
                'chart_type',
                [
                    'label' => __('Chart Type', 'royal-addons-for-elementor'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'pie',
                    'options' => [
                        'pie' => __('Pie', 'royal-addons-for-elementor'),
                        'doughnut' => __('Donut', 'royal-addons-for-elementor'),
                    ],
                ]
            );

            $this->add_responsive_control(
                'chart_width',
                [
                    'label' => __( 'Chart Width', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%', 'px' , 'em' ],
                    'range' => [
                        '%' => [
                            'min' => 1,
                            'max' => 100
                        ],
                        'px' => [
                            'min' => 1,
                            'max' => 1000
                        ]
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 600,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-chart' => 'width: {{SIZE}}{{UNIT}};',
                    ]
                ]
            );


            $this->add_control(
                'chart_aspect_ratio',
                [
                    'label' => __( 'Chart Aspect Ratio', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%' , 'px' , 'EM' ],
                    'range' => [
                        '%' => [
                            'min' => 1,
                            'max' => 10,
                            'step' => 0.1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 2,
                    ],
                ]
            );


            $this->add_control(
                'chart_border_width',
                [
                    'label' => __( 'Border Width', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                ]
            );

            $this->add_control(
                'chart_hover_border_width',
                [
                    'label' => __( 'Hover Border Width', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                ]
            );

        $this->end_controls_section();

        // content
        $this->start_controls_section(
			'section_cg_tick_style',
			[
				'label' => __( 'Content', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'text_alignment',
                [
                    'label' => __( 'Text Alignment', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'left', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-center',
                        ],
                        'right' => [
                            'title' => __( 'right', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} .royal-chart .chart-text' => "text-align: {{VALUE}}",
                    ]
                ]
            );

            $this->add_control(
                'title_html_tag',
                [
                    'label' => __( 'Title HTML Tag', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        'H5' => __('Default', 'royal-addons-for-elementor'),
                        'h1' => __('H1', 'royal-addons-for-elementor'),
                        'h2' => __('H2', 'royal-addons-for-elementor'),
                        'h3' => __('H3', 'royal-addons-for-elementor'),
                        'h4' => __('H4', 'royal-addons-for-elementor'),
                        'h5' => __('H5', 'royal-addons-for-elementor'),
                        'h6' => __('H6', 'royal-addons-for-elementor'),
                        'p' => __('P', 'royal-addons-for-elementor'),
                    ],
                    'default' => 'h5',
                ]
            );

            $this->add_control(
                'title_color',
                [
                    'label' => __( 'Title Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => 'grey',
                    'selectors' => [
                        '{{WRAPPER}} .royal-chart .chart-title' => "color: {{VALUE}}",
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'title_typography',
                    'label' => __('Title Typography', 'royal-addons-for-elementor'),
                    'selector' => '{{WRAPPER}} .royal-chart .chart-title',
                ]
            );

            $this->add_control(
                'background_color',
                [
                    'label' => __( 'Description Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => 'grey',
                    'selectors' => [
                        '{{WRAPPER}} .royal-chart .chart-desc' => "color: {{VALUE}}",
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'description_typography',
                    'label' => __('Description Typography', 'royal-addons-for-elementor'),
                    'selector' => '{{WRAPPER}} .royal-chart .chart-desc',
                ]
            );

            $this->add_responsive_control(
                'space_between_chart_content',
                [
                    'label' => __( 'Space Between Chart & Content', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-chart .chart-text' => "margin-top: {{SIZE}}{{UNIT}}",
                    ]
                ]
            );

            $this->add_responsive_control(
                'space_between_title_description',
                [
                    'label' => __( 'Space Between Title & Description', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 5,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .royal-chart .chart-desc' => "margin-top: {{SIZE}}{{UNIT}}",
                    ]
                ]
            );

        $this->end_controls_section();

        // legend
        $this->start_controls_section(
			'section_cg_legend_style',
			[
				'label' => __( 'Legend', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

            $this->add_control(
                'enable_chart_legend', [
                    'label' => __( 'Chart Legend', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );

            $this->add_control(
                'legend_position',
                [
                    'label' => __( 'Position', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-left',
                        ],
                        'top' => [
                            'title' => __( 'top', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-v-align-top',
                        ],
                        'right' => [
                            'title' => __( 'Right', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-h-align-right',
                        ],
                        'bottom' => [
                            'title' => __( 'Bottom', 'royal-addons-for-elementor' ),
                            'icon' => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default' => 'top',
                    'toggle' => true,
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'legend_alignment',
                [
                    'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'icon',
                    'options' => [
                        'start' => __('Start', 'royal-addons-for-elementor'),
                        'center' => __('Center', 'royal-addons-for-elementor'),
                        'end' => __('End', 'royal-addons-for-elementor'),
                    ],
                    'default' => 'center',
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'legend_bar_width',
                [
                    'label' => __( 'Bar Width', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%' ],
                    'range' => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 40,
                    ],
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'legend_bar_height',
                [
                    'label' => __( 'Bar Height', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%' ],
                    'range' => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 0.1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 10,
                    ],
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'space_between_legend',
                [
                    'label' => __( 'Space Between Legends', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ '%' ],
                    'range' => [
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 20,
                    ],
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'legend_label_color',
                [
                    'label' => __( 'Label Color', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => 'grey',
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'legend_label_font',
                [
                    'label' => __( 'Label Font', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::FONT,
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ],
                    'default' => "'Open Sans', sans-serif",
                ]
            );

            $this->add_control(
                'legend_label_font_size',
                [
                    'label' => __( 'Font Size', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SLIDER ,
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ],
                    'size_units' => [ '%' ],
                    'range' => [
                        '%' => [
                            'min' => 10,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 10,
                    ],
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );

            $this->add_control(
                'legend_font_weight',
                [
                    'label' => __( 'Font weight', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'options' => [
                        '100' => __('100', 'royal-addons-for-elementor'),
                        '200' => __('200', 'royal-addons-for-elementor'),
                        '300' => __('300', 'royal-addons-for-elementor'),
                        '400' => __('400', 'royal-addons-for-elementor'),
                        '500' => __('500', 'royal-addons-for-elementor'),
                        '600' => __('600', 'royal-addons-for-elementor'),
                        '700' => __('700', 'royal-addons-for-elementor'),
                        '800' => __('800', 'royal-addons-for-elementor'),
                        '900' => __('900', 'royal-addons-for-elementor'),
                        'default' => __('Default', 'royal-addons-for-elementor'),
                        'normal' => __('Normal', 'royal-addons-for-elementor'),
                        'bold' => __('Bold', 'royal-addons-for-elementor'),
                    ],
                    'default' => 'normal',
                    'condition' => [
                        'enable_chart_legend' => 'yes'
                    ]
                ]
            );


        $this->end_controls_section();

    }
    
	protected function render() {
        
        $settings = $this->get_settings_for_display();
        $label = [];
        $values = [];
        $backgroundColor = [];
        $borderColor = [];
        $hoverBorderColor = [];
        $hoverBackgroundColor = [];
        $backgroundImage = [];
        
        foreach ($settings['data_list'] as $key => $value) {
            array_push($label, $value['data_label']);
            array_push($values, $value['data_value']);
            array_push($borderColor, $value['border_color']);
            array_push($hoverBorderColor, $value['border_hover_color']);
            array_push($backgroundColor, $value['background_color']);
            array_push($hoverBackgroundColor, $value['background_hover_color']);
            array_push($backgroundImage, $value['background_image']['url']);
            
        }
        if( $settings['chart_alignment'] == 'left' ){

            $this->add_render_attribute( 'royal-chart-position', 'class', 'mt-chart-left' );

            } elseif( $settings['chart_alignment'] == 'right' ){
                
            $this->add_render_attribute( 'royal-chart-position', 'class', 'mt-chart-right' );
            
        } else {

            $this->add_render_attribute( 'royal-chart-position', 'class', 'mt-chart-center' );
            
        }
        $this->add_render_attribute( 'royal-chart-position', 'class', 'royal-chart' );

        $this->add_render_attribute( 'royal-chart', 'id', 'canvas'.$this->get_id() );
        $this->add_render_attribute( 'chart_title', 'class', 'chart-title' );
        $this->add_render_attribute( 'royal-chart', 'data-id', $this->get_id() );
        $this->add_render_attribute( 'royal-chart', 'data-label', json_encode($label) );
        $this->add_render_attribute( 'royal-chart', 'data-values', json_encode($values) );
        $this->add_render_attribute( 'royal-chart', 'data-borderColor', json_encode($borderColor) );
        $this->add_render_attribute( 'royal-chart', 'data-hoverBorderColor', json_encode($hoverBorderColor) );
        $this->add_render_attribute( 'royal-chart', 'data-backgroundColor', json_encode($backgroundColor) );
        $this->add_render_attribute( 'royal-chart', 'data-backgroundImage', json_encode($backgroundImage) );
        $this->add_render_attribute( 'royal-chart', 'data-hoverBackgroundColor', json_encode($hoverBackgroundColor) );
        $this->add_render_attribute( 'royal-chart', 'data-type', $settings['chart_type'] );
        $this->add_render_attribute( 'royal-chart', 'data-borderWidth', intval($settings['chart_border_width']) );
        $this->add_render_attribute( 'royal-chart', 'data-borderHoverWidth', intval($settings['chart_hover_border_width']) );
        $this->add_render_attribute( 'royal-chart', 'data-legend_style', $settings['enable_chart_legend'] );
        $this->add_render_attribute( 'royal-chart', 'data-legend_position', $settings['legend_position'] );
        $this->add_render_attribute( 'royal-chart', 'data-legend_alignment', $settings['legend_alignment'] );
        $this->add_render_attribute( 'royal-chart', 'data-legend_bar_height', isset($settings['legend_bar_height']) ? $settings['legend_bar_height']['size'] : '' );
        $this->add_render_attribute( 'royal-chart', 'data-legend_bar_width', isset($settings['legend_bar_width']) ? $settings['legend_bar_width']['size'] : '' );
        $this->add_render_attribute( 'royal-chart', 'data-space_between_legend', isset($settings['space_between_legend']) ? $settings['space_between_legend']['size'] : '' );
        $this->add_render_attribute( 'royal-chart', 'data-legend_label_font_size', isset($settings['legend_label_font_size']) ? $settings['legend_label_font_size']['size'] : '' );
        $this->add_render_attribute( 'royal-chart', 'data-legend_label_color', $settings['legend_label_color'] );
        $this->add_render_attribute( 'royal-chart', 'data-legend_label_font', $settings['legend_label_font'] );
        $this->add_render_attribute( 'royal-chart', 'data-legend_font_weight', $settings['legend_font_weight'] );
        $this->add_render_attribute( 'royal-chart', 'data-aspect_ratio', isset($settings['chart_aspect_ratio']) ? $settings['chart_aspect_ratio']['size'] : '' );
        ?>
        <?php echo '<div '.$this->get_render_attribute_string('royal-chart-position').'  id="mt-chart-' . $this->get_id() . '" >' ?>

        <canvas <?php echo $this->get_render_attribute_string('royal-chart'); ?> ></canvas>
        <div class="chart-text">
            <<?php echo wp_kses_post( $settings['title_html_tag'] );?> <?php echo $this->get_render_attribute_string('chart_title');?>><?php echo wp_kses_post( $settings['chart_title'] ); ?></<?php echo wp_kses_post( $settings['title_html_tag'] );?>>
            <p class="chart-desc"><?php echo wp_kses_post( $settings['chart_description'] ); ?></p>
        </div>
        <?php echo '</div>'; ?>

    <?php

	}
}
