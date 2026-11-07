<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use RoyalAddons\Elementor\Royal_Helpers;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class RoyalTicker extends Widget_Base {

	public function get_name() {
		return 'royalticker';
	}

	public function get_title() {
		return __( 'News Ticker', 'royal-addons-for-elementor');
	}

	public function get_icon() { return 'royalticker rtbranding'; }

	public function get_keywords() {
		return ['ticker', 'post', 'news', 'bracking', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	  }

	public function get_categories() {
		return [ 'royal-addons-for-elementor'];
	}

	
	public function get_style_depends() {
		$styles = ['royalticker'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalticker'];
		return $scripts;
	}

	protected function register_controls() {

		$this->rt_section_data_source();
		$this->rt_section_control_options();
		$this->rt_content_query_options();
		$this->rt_custom_data_options();
		$this->rt_style_box_options();
		$this->rt_style_label_options();
		$this->rt_style_title_options();
		

	}

	/* Ticker Options Options. */
	private function rt_section_data_source() {

		$this->start_controls_section(
			'section_data_source',
			[
				'label' => esc_html__( 'Data Source', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'ticker_data_source',
			[
				'label' => __( 'Ticker Style', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',				
				'options' => [
					'post' 			=> 'Post',
					'page' 			=> 'Page',
					'custompost' 	=> 'Custom Post Type',
				],

			]
		);

		$this->add_control(
			'custom_post_type',
			[
				'label' => __( 'Custom Post Type', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => 'royalnotice',
				'condition' => [
					'ticker_data_source' => 'custompost',
				],
			]
		);

		$this->end_controls_section();

	}


	/* Ticker Control Options. */
	private function rt_section_control_options() {

		$this->start_controls_section(
			'section_options',
			[
				'label' => esc_html__( 'Ticker Options', 'royal-addons-for-elementor'),
			]
		);

		$this->add_control(
			'ticker_label_onoff',
			[
				'label' => __( 'Label Display', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'royal-addons-for-elementor'),
				'label_off' => __( 'No', 'royal-addons-for-elementor'),
				'default' => 'yes',								
			]
		);

		$this->add_control(
			'ticker_label_text',
			[
				'label' => __( 'Label Text', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Breaking News', 'royal-addons-for-elementor'),
				'condition' => [
					'ticker_label_onoff' => 'yes',
				],
			]
		);


		$this->add_control(
			'ticker_height',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 250,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ticker_style',
			[
				'label' => __( 'Ticker Style', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'typewriter',
				'separator' => 'before',		
				'options' => [
					'typewriter' 	=> 'Type Writer',
					'marquee' 		=> 'Marquee',
					'vertical' 		=> 'Vertical',
					'horizontal' 	=> 'Horizontal',
				],

			]
		);

		$this->add_control(
			'ticker_direction_updown',
			[
				'label' => __( 'Direction', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'up',	
				'condition' => [
					'ticker_style' => ['vertical'],
				],							
				'options' => [
					'up' 			=> 'Up',
					'down' 			=> 'Down',
				],
			]
		);

		$this->add_control(
			'ticker_direction_leftright',
			[
				'label' => __( 'Direction', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',	
				'condition' => [
					'ticker_style' => ['horizontal', 'marquee'],
				],							
				'options' => [
					'right' 		=> 'Right',
					'left' 			=> 'Left',
				],
			]
		);


		$this->add_control(
			'ticker_speed_slide',
			[
				'label' => esc_html__( 'Slide Speed', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'ticker_style' => ['vertical', 'horizontal'],
				],				
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
			]
		);

		$this->add_control(
			'ticker_speed_typewriter',
			[
				'label' => esc_html__( 'Typewriter Speed', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'ticker_style' => ['typewriter'],
				],					
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
			]
		);

		$this->add_control(
			'ticker_speed_marquee',
			[
				'label' => esc_html__( 'Marquee Speed', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'condition' => [
					'ticker_style' => ['marquee'],
				],	
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => .01,
						'max' => 2,
						'step' => .001,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => .5,
				],
			]
		);

		$this->add_control(
			'ticker_pauseonfocus',
			[
				'label' => __( 'Pause On Focus', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'royal-addons-for-elementor'),
				'label_off' => __( 'No', 'royal-addons-for-elementor'),
				'default' => 'yes',
			]
		);


		$this->add_control(
			'ticker_pauseonhover',
			[
				'label' => __( 'Pause On Hover', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'royal-addons-for-elementor'),
				'label_off' => __( 'No', 'royal-addons-for-elementor'),
				'default' => 'yes',
			]
		);


		$this->add_control(
			'ticker_controls',
			[
				'label' 	=> __( 'Controls Display', 'royal-addons-for-elementor'),
				'type' 		=> Controls_Manager::SWITCHER,
				'label_on' 	=> __( 'Yes', 'royal-addons-for-elementor'),
				'label_off' => __( 'No', 'royal-addons-for-elementor'),
				'default' 	=> 'yes',						
			]
		);


		$this->add_control(
			'meta_separator',
			[
				'label' => __( 'Separator Between', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => '/ ',
				'description' => 'Find some ANSI Characters <a href="https://mehdiakram.github.io/HTML-ANSI/" target="_blank">https://mehdiakram.github.io/HTML-ANSI/</a>',
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker-box ul li + li:before' => 'content: "{{VALUE}}"',
				],
			]
		);


		$this->end_controls_section();

	}

	/* Post / Page Query Options. */
	private function rt_content_query_options() {

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Post Query', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'ticker_data_source!' => 'custom',
				],				
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
				'min' => 1,
				'max' => 1000,
				'step' => 1,
				'separator' => 'before',				
			]
		);


		// Post categories
		$this->add_control(
			'post_categories',
			[
				'label'       => __( 'Categories', 'royal-addons-for-elementor'),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => Royal_Helpers::royal_categories( 'post' ),
				'condition' => [
					'ticker_data_source' => 'post',
				],
			]
		);
		
		$this->add_control(
			'meta_data',
			[
				'label' => __( 'Meta Data', 'royal-addons-for-elementor'),
				'label_block' => true,
				'type' => Controls_Manager::SELECT2,
				'default' => [ 'date'],
				'multiple' => true,
				'condition' => [
					'ticker_data_source!' => 'custom',
				],				
				'options' => [
					'date' 		=> __( 'Date', 'royal-addons-for-elementor'),
					'author' 	=> __( 'Author', 'royal-addons-for-elementor'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' 	=> __( 'Date', 'royal-addons-for-elementor'),
					'post_title' 	=> __( 'Title', 'royal-addons-for-elementor'),
					'rand' 			=> __( 'Random', 'royal-addons-for-elementor'),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'royal-addons-for-elementor'),
					'desc' => __( 'DESC', 'royal-addons-for-elementor'),
				],
			]
		);

		$this->end_controls_section();

	}

	/* Style Box Options. */
	private function rt_custom_data_options() {

		$this->start_controls_section(
			'section_custom_data',
			[
				'label' => __( 'Custom Data', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'ticker_data_source' => 'custom',
				],				
			]
		);

		$repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'custom_text',
            [
                'label' => __( 'Text', 'royal-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Royal Technologies won the best Web Hosting Award', 'royal-addons-for-elementor'),
                'label_block' => true
            ]
        );
        $repeater->add_control(
            'custom_url',
            [
                'label' => __( 'URL', 'royal-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'http://www.royaltechbd.com', 'royal-addons-for-elementor'),
                'label_block' => true
            ]
        );
        $this->add_control(
            'custom_data',
            [
                'label' => __( 'Custom Data', 'royal-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'custom_text'	=> 'Royal Technologies won the best Web Hosting Award',
                        'custom_url'   	=> 'http://www.royaltechbd.com',
                    ],
                    [
                        'custom_text'	=> 'Bangladesh won the World Cup',
                        'custom_url'   	=> 'http://www.royaltechbd.com',
                    ],       
                    [
                        'custom_text'	=> '40 Degree celsius temperature today!',
                        'custom_url'   	=> 'http://www.royaltechbd.com',
                    ],                                 
                ],
                'title_field' => '{{{ custom_text }}}',
            ]
        );       

		$this->end_controls_section();

	}


	/* Style Box Options. */
	private function rt_style_box_options() {

		// Box.
		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'Box', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Border radius.
		$this->add_control(
			'box_border_width',
			[
				'label'      => __( 'Border Widget', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalnewsticker' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);


		// Box padding.
		$this->add_responsive_control(
			'box_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royalnewsticker' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'box_style_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'box_style_normal',
			[
				'label'     => __( 'Normal', 'royal-addons-for-elementor'),
			]
		);

		// Normal background color.
		$this->add_control(
			'box_normal_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor'),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Normal border color.
		$this->add_control(
			'box_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor'),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .royalnewsticker',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'box_style_hover',
			[
				'label'     => __( 'Hover', 'royal-addons-for-elementor'),
			]
		);

		// Hover background color.
		$this->add_control(
			'box_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'royal-addons-for-elementor'),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'box_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'royal-addons-for-elementor'),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'box_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .royalnewsticker:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	/* Style Label */
	private function rt_style_label_options() {
		// Tab.
		$this->start_controls_section(
			'section_ticker_label_style',
			[
				'label' => __( 'Label', 'royal-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'ticker_label_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .royalnewsticker .royalnewsticker-label',
			]
		);

		$this->add_control(
			'ticker_label__style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor'),
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker .royalnewsticker-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ticker_label__style_bg',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background', 'royal-addons-for-elementor'),
				'default' => '#1974d2',
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker .royalnewsticker-label' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'ticker_label__style_margin',
			[
				'label'      => __( 'Margin', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalnewsticker .royalnewsticker-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ticker_label__style_Padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royalnewsticker .royalnewsticker-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}


	/* Style Title */
	private function rt_style_title_options() {
		// Tab.
		$this->start_controls_section(
			'ticker_title_style',
			[
				'label'     => __( 'Title', 'royal-addons-for-elementor'),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ticker_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .royalnewsticker-box ul li a',
			]
		);

		$this->start_controls_tabs( 'ticker_title_color_tabs' );

		// Normal tab.
		$this->start_controls_tab(
			'ticker_title_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor'),
			)
		);

		// Title color.
		$this->add_control(
			'ticker_title_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor'),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .royalnewsticker-box ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'ticker_title_style_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor'),
			)
		);

		// Title hover color.
		$this->add_control(
			'ticker_title_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'royal-addons-for-elementor'),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .royalnewsticker-box ul li a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}


	protected function render( $instance = [] ) {
		$settings 		= $this->get_settings();
        $datasource   	= $settings['ticker_data_source'];
        $labelonoff   	= $settings['ticker_label_onoff'];
        $labeltext   	= $settings['ticker_label_text'];
        $id         	= $this->get_id();
        $tickerlid     	= 'royalcarousel'.$id;
        $style   		= $settings['ticker_style'];


		if($datasource == 'custompost' ){
			$posttype  = $settings['custom_post_type']; 
		} elseif ($datasource == 'post') {
			$posttype  = 'post'; 
		} elseif ($datasource == 'page') {
			$posttype  = 'page'; 
		} else {
			$posttype  = 'post'; 
		}


		if($style == 'vertical' ){
			$direction  = $settings['ticker_direction_updown']; 
		} else {
			$direction  = $settings['ticker_direction_leftright']; 
		}

		
		if($style == 'vertical' OR $style == 'horizontal'){
			$speed 		= $settings['ticker_speed_slide']['size'];
		} elseif ($style == 'typewriter') {
			$speed 		= $settings['ticker_speed_typewriter']['size'];
		} else{
			$speed 		= $settings['ticker_speed_marquee']['size'];
		}


        $pauseonfocus   = $settings['ticker_pauseonfocus'];
        $pauseonhover   = $settings['ticker_pauseonhover'];
        $controls   	= $settings['ticker_controls'];




        $this->add_render_attribute(
            'royal_ticker_options',
            [
                'id'                	=> $tickerlid,
                'data-style'         	=> $style,
                'data-direction'        => $direction,
                'data-speed'        	=> $speed,
                'data-pauseonfocus'     => $pauseonfocus,
                'data-pauseonhover'     => $pauseonhover,
                'data-controls'     	=> $controls,
			
            ]
        );


		?>
			<div class="royalnewsticker">
				<?php if ($labelonoff == 'yes') { ?>
				<div class="royalnewsticker-label"><?php echo $labeltext; ?></div>
				<?php } ?>
				<div class="royalnewsticker-box">
				<?php
				$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : 3 );
				if($datasource == 'post'){
					$cats = is_array( $settings['post_categories'] ) ? implode( ',', $settings['post_categories'] ) : $settings['post_categories'];
				} else{
					$cats = '';
				}
			
		        $query_args = array(
					        	'posts_per_page' 		=> absint( $posts_per_page ),
								'post_type' 			=> $posttype,
					        	'no_found_rows'  		=> true,
					        	'post_status'         	=> 'publish',
					        	'ignore_sticky_posts'   => true,
					        	'category_name' 		=> $cats
				        	);

		        // Order by.
		        if ( ! empty( $settings['orderby'] ) ) {
		        	$query_args['orderby'] = $settings['orderby'];
		        }

		        // Order .
		        if ( ! empty( $settings['order'] ) ) {
		        	$query_args['order'] = $settings['order'];
		        }

		        $all_posts = new \WP_Query( $query_args );
				if ($datasource == "post" or $datasource == "page" or $datasource == "custompost"){

					if ( $all_posts->have_posts() ) :
						echo '<ul class="royalnewstickerhandler" '.$this->get_render_attribute_string( 'royal_ticker_options' ).'>';
						while ( $all_posts->have_posts() ) :
							$all_posts->the_post(); ?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?> <?php $this->render_meta(); ?></a></li>
								<?php
						endwhile; 
						wp_reset_postdata();
						echo '</ul>';
					endif; 

				} else {
					echo '<ul class="royalnewstickerhandler" '.$this->get_render_attribute_string( 'royal_ticker_options' ).'>';
					foreach( $settings[ 'custom_data' ] as $customdata ):
						echo '<li><a href="'.$customdata['custom_url'].'">'.$customdata['custom_text'].'</a></li>';
					endforeach;
					echo '</ul>';
				}

				?>
			</div>	
			<?php if ( $controls === 'yes' ) : ?>
				<div class="royalnewsticker-controls royalnewsticker-horizontal-controls">
					<?php if ( $style !== 'marquee' ) : ?>
						<button class="royalnewsticker-arrow royalnewsticker-prev" aria-label="Previous News Item">&#9664;</button>
					<?php endif; ?>
					<button class="royalnewsticker-pause" aria-label="Pause Ticker">||</button>
					<?php if ( $style !== 'marquee' ) : ?>
						<button class="royalnewsticker-arrow royalnewsticker-next" aria-label="Next News Item">&#9654;</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>	
		<?php

	}




	protected function render_meta() {
		$settings = $this->get_settings();
		$meta_data = $settings['meta_data'];
		if ( empty( $meta_data ) ) {
			return;
		}

		?>
			<?php
			if ( in_array( 'author', $meta_data ) ) { ?>
				<?php the_author(); ?>
				<?php
			}

			if ( in_array( 'date', $meta_data ) ) { 
				$dt = get_date_from_gmt(get_the_date(), 'Y-m-d H:i:s');
				echo date_i18n(get_option('date_format'), strtotime($dt));
			}
			?>
		<?php

	}




}
