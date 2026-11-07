<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly



class RoyalCopyright extends Widget_Base{

  public function get_name(){
    return 'royalcopyright';
  }


  public function get_title(){
    return __('Royal Copyright', 'royal-addons-for-elementor');
  }


  public function get_icon() { return 'royalcopyright rtbranding'; }


  public function get_keywords() {
    return [ 'copyright', 'text', 'copy right', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
  }


  public function get_categories(){
    return ['royaltech_headerfooter'];
  }


  protected function register_controls(){

   $this->start_controls_section(
      'content_section',
      [
        'label' => __( 'Royal Copyright', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
			'copyright_text_prefix',
			[
				'label' => esc_html__( 'Prefix', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT, 
        'default' => __( 'Copyright', 'royal-addons-for-elementor' ),   
				'placeholder' => esc_html__( 'Copyright', 'royal-addons-for-elementor' ),
			]
		);

    $this->add_control(
			'copyright_symbol',
			[
				'label' => esc_html__( 'Symbol', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'copysymbol',
				'options' => [
					'copysymbol' => esc_html__( '© Symbol', 'royal-addons-for-elementor' ),
					'nosymbol' => esc_html__( 'No Symbol', 'royal-addons-for-elementor' ),
				],
			]
		);

    $this->add_control(
			'copyright_year',
			[
				'label' => esc_html__( 'Year', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'firstandlast',
				'options' => [
					'firstandlast' => esc_html__( 'First And Last', 'royal-addons-for-elementor' ),
					'currentyear' => esc_html__( 'Current Year', 'royal-addons-for-elementor' ),
				],
			]
		);


    $this->add_control(
			'copyright_text',
			[
				'label' => esc_html__( 'Copyright Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'sitetitle',
				'options' => [
					'sitetitle' => esc_html__( 'Site Title', 'royal-addons-for-elementor' ),
					'customttext' => esc_html__( 'Custom Text', 'royal-addons-for-elementor' ),
					'notext' => esc_html__( 'No Text', 'royal-addons-for-elementor' ),          
				],
			]
		);

    $this->add_control(
			'custom_text',
			[
				'label' => esc_html__( 'Custom Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
        'condition' => [
          'copyright_text' => [ 'customttext', 'style6' ],
        ],        
				'placeholder' => esc_html__( 'Royal Technologies', 'royal-addons-for-elementor' ),
			]
		);

    $this->add_control(
			'reserved_text',
			[
				'label' => esc_html__( 'Reserved Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'All rights reserved.', 'royal-addons-for-elementor' ),
			]
		);

    $this->end_controls_section();




    $this->start_controls_section(
      'style_section',
      [
        'label' => __( 'Style', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

  
   $this->add_control(
        'color',
        [
            'label' => __( 'Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000000',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalcopyrightwrapper' => 'color: {{VALUE}}',
            ],
        ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'copyright_typo',
        'label' => __( 'Typography', 'royal-addons-for-elementor' ),
        'global' => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
        ],
        'selector' => '{{WRAPPER}} .royalcopyrightwrapper',
      ]
    );


		$this->add_responsive_control(
			'copy_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .royalcopyrightwrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

    
    $this->end_controls_section();



  }
  



  protected function render() {
    $settings         = $this->get_settings_for_display();
    $prefix           = $settings['copyright_text_prefix'];
    $customtext       = $settings['custom_text'];
    $reservedtext     = $settings['reserved_text'];


    if ( 'copysymbol' === $settings['copyright_symbol'] ) {
      $symbol = '&copy; ';
		} else{
      $symbol = '';
    } 


    if ( 'sitetitle' === $settings['copyright_text'] ) {
      $copyrighttext = get_bloginfo('name') . '. ';
		} elseif ('customttext' === $settings['copyright_text'] ){
      $copyrighttext = $customtext;
    } else{
      $copyrighttext = '';
    } 

    


		global $wpdb;
		$copyright_dates = $wpdb->get_results("
		SELECT
		YEAR(min(post_date_gmt)) AS firstyear
		FROM
		$wpdb->posts
		WHERE
		post_status = 'publish'
		");
		$firstyear 		= date_i18n($copyright_dates[0]->firstyear);

		$currentyear 	= date_i18n("Y");

    if($copyright_dates) {
      $copyrightyear = $firstyear;
      if('firstandlast' === $settings['copyright_year']){
        
        if($firstyear != $currentyear) {
        $copyrightyear .= '-' . $currentyear;
        }
        
      } else {
        $copyrightyear = $currentyear;
      }
    }  

    echo '<div class="royalcopyrightwrapper">' . $prefix .' '. $symbol . $copyrightyear . ' '. $copyrighttext . $reservedtext. '</div>';
  }









}