<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
if (!defined('ABSPATH')) exit; // Exit if accessed directly



class RoyalProfileCard extends Widget_Base {

	public function get_name() {
		return 'royalprofilecard';
	}

  
	public function get_title() {
		return 'Profile Card';
	}


	public function get_icon() { return 'eicon-user-circle-o rtbranding'; }


	public function get_keywords() {
		return [ 'profile', 'card', 'team', 'tm', 'member', 'animated', 'image', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = ['royalprofilecard'];
		return $styles;
	}


	protected function register_controls() {
		$this->rt_content_options();
		$this->rt_style_contentwraper_options();
		$this->rt_style_style23_options();
		$this->rt_style_style24_options();
		$this->rt_style_title_options();
		$this->rt_style_desig_options();
		$this->rt_style_content_options();
		$this->rt_style_social_options();
	}



  private function rt_content_options() {

    $this->start_controls_section(
        'content_settings',
        [
          'label' => __( 'Content', 'royal-addons-for-elementor' ),
          'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );


    $this->add_control(
        'profilecardstyle',
        [
			'label' => __( 'Profile Card Style', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => '15',
			'options' => [
				'1'     			=> __( 'Style 1', 'royal-addons-for-elementor' ),
				'2'     			=> __( 'Style 2', 'royal-addons-for-elementor' ),
				'3'     			=> __( 'Style 3', 'royal-addons-for-elementor' ),
				'4'     			=> __( 'Style 4', 'royal-addons-for-elementor' ),
				'5'     			=> __( 'Style 5', 'royal-addons-for-elementor' ),
				'6'     			=> __( 'Style 6', 'royal-addons-for-elementor' ),
				'7'     			=> __( 'Style 7', 'royal-addons-for-elementor' ),
				'8'     			=> __( 'Style 8', 'royal-addons-for-elementor' ),
				'9'     			=> __( 'Style 9', 'royal-addons-for-elementor' ),
				'10'    			=> __( 'Style 10', 'royal-addons-for-elementor' ),
				'11'    			=> __( 'Style 11', 'royal-addons-for-elementor' ),
				'12'    			=> __( 'Style 12', 'royal-addons-for-elementor' ),
				'13'    			=> __( 'Style 13', 'royal-addons-for-elementor' ),
				'14'    			=> __( 'Style 14', 'royal-addons-for-elementor' ),
				'15'    			=> __( 'Style 15', 'royal-addons-for-elementor' ),
				'16'    			=> __( 'Style 16', 'royal-addons-for-elementor' ),
				'17'    			=> __( 'Style 17', 'royal-addons-for-elementor' ),
				'18'    			=> __( 'Style 18', 'royal-addons-for-elementor' ),
				'19'     			=> __( 'Style 19', 'royal-addons-for-elementor' ),
				'20'     			=> __( 'Style 20', 'royal-addons-for-elementor' ),
				'21'     			=> __( 'Style 21', 'royal-addons-for-elementor' ),
				'22'     			=> __( 'Style 22', 'royal-addons-for-elementor' ),
				'23'     			=> __( 'Style 23 (Rotating Circle)', 'royal-addons-for-elementor' ),
				'24'     			=> __( 'Style 24 (Organization Management)', 'royal-addons-for-elementor' ),
				'101fadein'    		=> __( 'Style 101 Fade In', 'royal-addons-for-elementor' ),
				'102overlay'    	=> __( 'Style 102 Overlay', 'royal-addons-for-elementor' ),
				'103zoom'    		=> __( 'Style 103 Zoom', 'royal-addons-for-elementor' ),			
          ],
        ]
    );

	$this->add_control(
        'direction',
        [
			'label' => __( 'Direction', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'left',
			'condition' => [
				'profilecardstyle' => ['16', '21'],
			],  			
			'options' => [
				'bottom'    	=> __( 'Bottom', 'royal-addons-for-elementor' ),
				'top'    		=> __( 'Top', 'royal-addons-for-elementor' ),				
				'left'    		=> __( 'Left', 'royal-addons-for-elementor' ),
				'right'    		=> __( 'Right', 'royal-addons-for-elementor' ),			
          ],
        ]
    );


    $this->add_control(
        '101fadeinstyle',
        [
			'label' => __( 'Fade In Direction', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'fadeinbottom',
			'condition' => [
				'profilecardstyle' => ['101fadein'],
			],  			
			'options' => [
				'fadeinbottom'    	=> __( 'Fade In Bottom', 'royal-addons-for-elementor' ),
				'fadeintop'    		=> __( 'Fade In Top', 'royal-addons-for-elementor' ),				
				'fadeinleft'    	=> __( 'Fade In Left', 'royal-addons-for-elementor' ),
				'fadeinright'    	=> __( 'Fade In Right', 'royal-addons-for-elementor' ),
				'fadeintopleft'    	=> __( 'Fade In Top Left', 'royal-addons-for-elementor' ),
				'fadeintopright'    => __( 'Fade In Top Right', 'royal-addons-for-elementor' ),	
				'fadeinbottomleft'  => __( 'Fade In Bottom Left', 'royal-addons-for-elementor' ),
				'fadeinbottomright' => __( 'Fade In Bottom Right', 'royal-addons-for-elementor' ),					
          ],
        ]
    );
	
	$this->add_control(
        '102overlaystyle',
        [
			'label' => __( 'Overlay Direction', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'default' => 'bottomoverlay',
			'condition' => [
				'profilecardstyle' => ['102overlay'],
			],  			
			'options' => [
				'topoverlay'    	=> __( 'Top Overlay', 'royal-addons-for-elementor' ),
				'bottomoverlay'    	=> __( 'Bottom Overlay', 'royal-addons-for-elementor' ),		
				'rightoverlay'    	=> __( 'Right Overlay', 'royal-addons-for-elementor' ),		
				'leftoverlay'    	=> __( 'Left Overlay', 'royal-addons-for-elementor' ),			
				'fadeoverlay'    	=> __( 'Fade Overlay', 'royal-addons-for-elementor' ),			
							
          ],
        ]
    );
	
    $this->add_control(
        'profilebackground',
        [
			'label' => esc_html__( 'Background Image', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
        ]
    );


    $this->add_control(
        'profiletitle',
        [
			'label' => __( 'Title', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,          
			'default' => __( 'S M Mehdi Akram', 'royal-addons-for-elementor' ),
			'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor' ),
        ]
    );
  
      $this->add_control(
        'profiledesig',
        [
          'label' => __( 'Designation', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::TEXT,          
          'default' => __( 'Engineer', 'royal-addons-for-elementor' ),
          'placeholder' => __( 'Type your designation here', 'royal-addons-for-elementor' ),
        ]
      );

      $this->add_control(
        'profilecontent',
        [
          'label' => __( 'Content', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::TEXTAREA,
          'rows' => 10,           
          'default' => __( 'Hi, this is Mehdi Akram', 'royal-addons-for-elementor' ),
          'placeholder' => __( 'Type your designation here', 'royal-addons-for-elementor' ),
        ]
      );

      $this->add_control(
        'card_number',
        [
          'label' => __( 'Card Number (e.g. 01)', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::TEXT,
          'default' => '01',
          'condition' => [
            'profilecardstyle' => ['24'],
          ],
        ]
      );

      $this->add_control(
        'content_bg_color1',
        [
          'type'      => Controls_Manager::COLOR,
          'label'     => __( 'Hover Color 1', 'royal-addons-for-elementor' ),
          'default'	=> '#ffffff',
          'selectors' => [
            '{{WRAPPER}} .royalprofilecard .profilecardstyle1 .info' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle2:after' => 'border-color: transparent transparent transparent {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle3' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle4:hover figcaption::before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle5:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle6' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle7' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle8' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle9:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle10:before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle10:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle12 figcaption' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle13 .picture::before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle13 .picture::after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle14 .designation' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle18 .line1' => 'background: linear-gradient(to right, {{VALUE}}, #6A1662 );',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle19 input:checked ~ .toggle' => 'box-shadow: 0 0 0 500px {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle20 .name' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle21:before' => 'background-color: {{VALUE}};',

            '{{WRAPPER}} .royalprofilecard .profilecardstylefadein .contentwraper .contentwraper-overlay' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardoverlaystyle .profilecardoverlay' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle100 .wholeoverlay' => 'background-image: linear-gradient(to top, {{VALUE}} 50%, transparent 50%);',
          ],
        ]
      );
      $this->add_control(
        'content_bg_color2',
        [
          'type'      => Controls_Manager::COLOR,
          'label'     => __( 'Hover Color 2', 'royal-addons-for-elementor' ),
          'default'	=> '#00000047',
          'condition' => [
            'profilecardstyle!' => ['3', '5', '9', '18', '19', '20', '23', '24', '101fadein', '102overlay'],
          ],       
          'selectors' => [
            '{{WRAPPER}} .royalprofilecard figure.profilecardstyle1 .name' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle2:before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle4' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle6 figcaption::before' => 'border-left: 4px solid {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle7 .tblock:before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle7 .tblock:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle7 .tblock div:before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle7 .tblock div:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle8:before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle8:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle8 figcaption:before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle8 figcaption:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle10 figcaption:before' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle10 figcaption:after' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle12 .profile-image' => 'border: 2px solid {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle13 .socialstyle' => 'background-color: {{VALUE}};',
            '{{WRAPPER}} .royalprofilecard .profilecardstyle14 img.profilepic' => 'border: 4px solid {{VALUE}};',
			'{{WRAPPER}} .royalprofilecard .profilecardstyle21 .content' => 'background-color: {{VALUE}};',

          ],
        ]
      );


      $repeater = new \Elementor\Repeater();
      $repeater->add_control(
        'socialtitle',
        [
			'label' => __( 'Title', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'dynamic' => [
				'active' => true,
			],		  
			'default' => __( 'Facebook', 'royal-addons-for-elementor' ),
        ]
      );
      $repeater->add_control(
        'sociallink',
        [
			'label' => __( 'Link', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'dynamic' => [
				'active' => true,
			],			  
			'default' => __( 'http://www.royaltechbd.com', 'royal-addons-for-elementor' ),
        ]
      );
	  
		
      $repeater->add_control(
        'socialicon',
        [
          'label' => __( 'Icon', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::ICONS,
          'fa4compatibility' => 'icon',
          'default' => [
            'value' => 'fab fa-facebook',
            'library' => 'fa-solid',
          ],      
        ]
      );

      $this->add_control(
        'show_socialcontent',
        [
			'label' => esc_html__( 'Show Social', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
			'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
			'return_value' => 'yes',
			'default' => 'yes',		  
        ]
      );
      
      $this->add_control(
        'socialcontent',
        [
			'label' => __( 'Social Content', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::REPEATER,
			'condition' => [
				'show_socialcontent' => 'yes',
			],        
			'fields' => $repeater->get_controls(),
			'default' => [
				[
					'socialtitle' => esc_html__( 'Social Icon #1', 'royal-addons-for-elementor' ),
					'socialicon' => [
						'value' => 'fab fa-facebook',
						'library' => 'fa-solid',
					],
				],
				[
					'socialtitle' => esc_html__( 'Social Icon #2', 'royal-addons-for-elementor' ),
					'socialicon' => [
						'value' => 'fab fa-twitter',
						'library' => 'fa-solid',
					],
				],
				[
					'socialtitle' => esc_html__( 'Social Icon #3', 'royal-addons-for-elementor' ),
					'socialicon' => [
						'value' => 'fa fa-envelope',
						'library' => 'fa-solid',
					],
				],
			],
			'title_field' => '{{{ elementor.helpers.renderIcon( this, socialicon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ socialtitle }}}',
        ]
      );

		$this->add_control(
			'socialstyle',
			[
				'label' => __( 'Social Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontalsocial',
				'condition' => [
					'show_socialcontent' => 'yes',
				],   			
				'options' => [
					'horizontalsocial'    	=> __( 'Horizontal', 'royal-addons-for-elementor' ),
					'verticalsocial'    	=> __( 'Vertical', 'royal-addons-for-elementor' ),				
						
			  ],
			]
		);



		$this->end_controls_section();
	}



	private function rt_style_contentwraper_options() {
		$this->start_controls_section(
		  'style_contentwraper_settings',
		  [
			'label' => __( 'Content Wraper Style', 'royal-addons-for-elementor' ),
			'tab' => Controls_Manager::TAB_STYLE,
			'condition' => [
					  'profilecardstyle' => ['22'],
				  ], 
		  ]
		);
	  
		$this->start_controls_tabs(
			'top_position_tabs'
		);
		
		$this->start_controls_tab(
			'top_position_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_responsive_control(
			'top_normal',
			[
				'label' => esc_html__( 'Top', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle22 .contentwraper' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
		$this->add_control(
			'content_bg_color_normal',
			[
			  'type'      => Controls_Manager::COLOR,
			  'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
			  'default'	=> '#131313bf',
			  'selectors' => [
				'{{WRAPPER}} .profilecardstyle22 .contentwraper' => 'background: {{VALUE}};',
			  ],
			]
		  );
	
		$this->end_controls_tab();
		
	
		$this->start_controls_tab(
			'top_position_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_responsive_control(
			'top_hover',
			[
				'label' => esc_html__( 'Top', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle22:hover .contentwraper' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
		$this->add_control(
			'content_bg_color_hover',
			[
			  'type'      => Controls_Manager::COLOR,
			  'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
			  'default'	=> '#131313e6',
			  'selectors' => [
				'{{WRAPPER}} .profilecardstyle22 .team-img::after' => 'background: {{VALUE}};',
			  ],
			]
		  );
	
		$this->end_controls_tab();
		$this->end_controls_tabs();
	
	
		$this->end_controls_section(); 
	}
	



	private function rt_style_style23_options() {
		$this->start_controls_section(
			'style_style23_settings',
			[
				'label' => __( 'Rotating Circle Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'profilecardstyle' => ['23'],
				], 
			]
		);

		$this->add_responsive_control(
			'style23_layout',
			[
				'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'vertical' => [
						'title' => esc_html__( 'Vertical (Centered)', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'horizontal' => [
						'title' => esc_html__( 'Horizontal (Row)', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
				],
				'default' => 'vertical',
				'prefix_class' => 'royal-layout-',
			]
		);

		$this->add_responsive_control(
			'style23_circle_size',
			[
				'label' => esc_html__( 'Circle Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'px' => [
						'min' => 80,
						'max' => 450,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'style23_ring_offset',
			[
				'label' => esc_html__( 'Ring Gap / Offset', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 2,
						'max' => 40,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 14,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring::before' => 'inset: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style23_ring_color',
			[
				'label' => esc_html__( 'Rotating Ring Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#c9a24a',
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring::before' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style23_ring_border_width',
			[
				'label' => esc_html__( 'Ring Border Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring::before' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style23_ring_border_style',
			[
				'label' => esc_html__( 'Ring Border Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'dashed',
				'options' => [
					'dashed' => esc_html__( 'Dashed', 'royal-addons-for-elementor' ),
					'dotted' => esc_html__( 'Dotted', 'royal-addons-for-elementor' ),
					'solid'  => esc_html__( 'Solid', 'royal-addons-for-elementor' ),
					'double' => esc_html__( 'Double', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring::before' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style23_ring_speed',
			[
				'label' => esc_html__( 'Rotation Speed (Seconds)', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 120,
				'step' => 1,
				'default' => 24,
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring::before' => 'animation-duration: {{VALUE}}s;',
				],
			]
		);

		$this->add_control(
			'style23_ring_direction',
			[
				'label' => esc_html__( 'Rotation Direction', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => esc_html__( 'Clockwise', 'royal-addons-for-elementor' ),
					'reverse' => esc_html__( 'Counter Clockwise', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring::before' => 'animation-direction: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style23_ring_pause_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'no',
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23:hover .royal-ring::before' => 'animation-play-state: paused;',
				],
			]
		);

		$this->add_control(
			'style23_image_border_heading',
			[
				'label' => esc_html__( 'Image Inner Border', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'style23_image_border_width',
			[
				'label' => esc_html__( 'Image Border Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring img.profilepic' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style23_image_border_color',
			[
				'label' => esc_html__( 'Image Border Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-ring img.profilepic' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style23_card_heading',
			[
				'label' => esc_html__( 'Card Container', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'style23_card_bg_color',
			[
				'label' => esc_html__( 'Card Background Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style23_card_box_shadow',
				'selector' => '{{WRAPPER}} .profilecardstyle23',
			]
		);

		$this->add_responsive_control(
			'style23_card_padding',
			[
				'label' => esc_html__( 'Card Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'style23_card_border_radius',
			[
				'label' => esc_html__( 'Card Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'style23_left_accent_heading',
			[
				'label' => esc_html__( 'Left Accent Bar', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'style23_left_accent_sw',
			[
				'label' => esc_html__( 'Enable Left Accent Bar', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'style23_left_accent_width',
			[
				'label' => esc_html__( 'Accent Bar Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'condition' => [
					'style23_left_accent_sw' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23.has-left-accent' => 'border-left-width: {{SIZE}}{{UNIT}}; border-left-style: solid;',
				],
			]
		);

		$this->add_control(
			'style23_left_accent_color',
			[
				'label' => esc_html__( 'Accent Bar Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#c9a24a',
				'condition' => [
					'style23_left_accent_sw' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23.has-left-accent' => 'border-left-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style23_quote_heading',
			[
				'label' => esc_html__( 'Quote Mark (Testimonial)', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'style23_show_quote',
			[
				'label' => esc_html__( 'Show Quote Mark', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'style23_quote_size',
			[
				'label' => esc_html__( 'Quote Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'px' => [
						'min' => 16,
						'max' => 120,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 48,
				],
				'condition' => [
					'style23_show_quote' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-quote-mark' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .profilecardstyle23 .royal-quote-mark svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_control(
			'style23_quote_color',
			[
				'label' => esc_html__( 'Quote Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => 'rgba(201, 162, 74, 0.55)',
				'condition' => [
					'style23_show_quote' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle23 .royal-quote-mark' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'style23_text_order',
			[
				'label' => esc_html__( 'Content Order', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'quote_first',
				'options' => [
					'quote_first' => esc_html__( 'Message / Quote First (Leader Message)', 'royal-addons-for-elementor' ),
					'title_first' => esc_html__( 'Name & Title First (Standard Profile)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->end_controls_section(); 
	}



	private function rt_style_style24_options() {
		$this->start_controls_section(
			'style_style24_settings',
			[
				'label' => __( 'Organization Management Card Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'profilecardstyle' => ['24'],
				], 
			]
		);

		$this->add_responsive_control(
			'style24_layout',
			[
				'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal (Row)', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'vertical' => [
						'title' => esc_html__( 'Vertical (Centered)', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
				],
				'default' => 'horizontal',
				'prefix_class' => 'royal-mg-layout-',
			]
		);

		$this->add_responsive_control(
			'style24_photo_width',
			[
				'label' => esc_html__( 'Photo Width', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'px' => [
						'min' => 70,
						'max' => 300,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 110,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle24 .royal-mg-photo' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'style24_photo_radius',
			[
				'label' => esc_html__( 'Photo Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 17,
				],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle24 .royal-mg-frame' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .profilecardstyle24 .royal-mg-ring' => 'border-radius: calc({{SIZE}}{{UNIT}} + 3px);',
				],
			]
		);

		$this->add_control(
			'style24_accent_color1',
			[
				'label' => esc_html__( 'Primary Accent Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0b4d26',
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle24::before' => 'background: linear-gradient(180deg, {{VALUE}}, {{style24_accent_color2.VALUE || "#1fa35a"}});',
					'{{WRAPPER}} .profilecardstyle24 .royal-mg-ring' => 'background: linear-gradient(135deg, {{VALUE}}, {{style24_accent_color2.VALUE || "#1fa35a"}});',
					'{{WRAPPER}} .profilecardstyle24 .royal-mg-card-no' => 'color: {{VALUE}};',
					'{{WRAPPER}} .profilecardstyle24 .royal-mg-role' => 'color: {{VALUE}}; border-color: {{VALUE}}40; background-color: {{VALUE}}1f;',
				],
			]
		);

		$this->add_control(
			'style24_accent_color2',
			[
				'label' => esc_html__( 'Secondary Accent Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#1fa35a',
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle24::before' => 'background: linear-gradient(180deg, {{style24_accent_color1.VALUE || "#0b4d26"}}, {{VALUE}});',
					'{{WRAPPER}} .profilecardstyle24 .royal-mg-ring' => 'background: linear-gradient(135deg, {{style24_accent_color1.VALUE || "#0b4d26"}}, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'style24_card_heading',
			[
				'label' => esc_html__( 'Card Container', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'style24_card_bg_color',
			[
				'label' => esc_html__( 'Card Background Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle24' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'style24_card_box_shadow',
				'selector' => '{{WRAPPER}} .profilecardstyle24',
			]
		);

		$this->add_responsive_control(
			'style24_card_padding',
			[
				'label' => esc_html__( 'Card Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle24' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'style24_card_border_radius',
			[
				'label' => esc_html__( 'Card Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .profilecardstyle24' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 
	}



  private function rt_style_title_options() {
		$this->start_controls_section(
				'style_title_settings',
				[
					'label' => __( 'Title Style', 'royal-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

		$this->add_group_control(
		  \Elementor\Group_Control_Typography::get_type(),
		  [
			'name' => 'title_typo',
			'label' => __( 'Title Typography', 'royal-addons-for-elementor' ),
			'global' => [
				'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
			  ],
	  
			'selector' => '{{WRAPPER}} .royalprofilecard h2',
		  ]
		);

		$this->add_control(
		  'title_color',
		  [
			'type'      => Controls_Manager::COLOR,
			'label'     => __( 'Title Color', 'royal-addons-for-elementor' ),
			'default'	=> '#ffffff',
			'selectors' => [
			  '{{WRAPPER}} .royalprofilecard .title' => 'color: {{VALUE}};',
			],
		  ]
		);

		$this->add_control(
			'title_ball_color',
			[
			  'type'      => Controls_Manager::COLOR,
			  'condition' => [
					'profilecardstyle' => ['22'],
				], 
			  'label'     => __( 'Title Ball Color', 'royal-addons-for-elementor' ),
			  'default'	=> '#D7B474',
			  'selectors' => [
				'{{WRAPPER}} .profilecardstyle22 .contentwraper .title::after' => 'background: {{VALUE}};',
			  ],
			]
		  );

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'title_align',
			[
				'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'=> esc_html__( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title'=> esc_html__( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center'
					],
					'right' => [
						'title'=> esc_html__( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right'
					]
				],
				'default' => 'left',
				'toggle'  => false,
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard .title' => 'text-align: {{VALUE}};',
				],
			]
		);    
    $this->end_controls_section(); 
  }



  private function rt_style_desig_options() {
		$this->start_controls_section(
			'style_desig_settings',
			[
				'label' => __( 'Designation Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
    

		$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name' => 'desig_typo',
			'label' => __( 'Designation Typography', 'royal-addons-for-elementor' ),
			'global' => [
				'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
			  ],
			'selector' => '{{WRAPPER}} .royalprofilecard .designation',
		]
		);

		$this->add_control(
		'desig_color',
		[
			'type'      => Controls_Manager::COLOR,
			'label'     => __( 'Designation Color', 'royal-addons-for-elementor' ),
			'default'	=> '#ffffff',
			'selectors' => [
			'{{WRAPPER}} .royalprofilecard .designation' => 'color: {{VALUE}};',
			],
		]
		);

		$this->add_responsive_control(
			'desig_margin',
			[
				'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard .designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'desig_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard .designation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'designation_align',
			[
				'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title'=> esc_html__( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title'=> esc_html__( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center'
					],
					'right' => [
						'title'=> esc_html__( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right'
					]
				],
				'default' => 'left',
				'toggle'  => false,
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard .designation' => 'text-align: {{VALUE}};',
				],
			]
		);

    $this->end_controls_section(); 
  }



  
  private function rt_style_content_options() {
      $this->start_controls_section(
        'style_content_settings',
        [
          'label' => __( 'Content Style', 'royal-addons-for-elementor' ),
          'tab' => Controls_Manager::TAB_STYLE,
		  'condition' => [
					'profilecardstyle!' => ['22'],
				], 
        ]
      );
    

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'content_typo',
        'label' => __( 'Content Typography', 'royal-addons-for-elementor' ),
        'global' => [
			'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
		  ],
        'selector' => '{{WRAPPER}} .royalprofilecard .content',
      ]
    );

    $this->add_control(
      'content_color',
      [
        'type'      => Controls_Manager::COLOR,
        'label'     => __( 'Content Color', 'royal-addons-for-elementor' ),
        'default'	=> '#000000',
        'selectors' => [
          '{{WRAPPER}} .royalprofilecard .content' => 'color: {{VALUE}};',
        ],
      ]
    );

	$this->add_responsive_control(
		'content_margin',
		[
			'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .royalprofilecard .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_responsive_control(
		'content_padding',
		[
			'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} .royalprofilecard .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);


	$this->add_responsive_control(
		'content_align',
		[
			'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
			'type'  => Controls_Manager::CHOOSE,
			'options' => [
				'left' => [
					'title'=> esc_html__( 'Left', 'royal-addons-for-elementor' ),
					'icon' => 'eicon-text-align-left',
				],
				'center' => [
					'title'=> esc_html__( 'Center', 'royal-addons-for-elementor' ),
					'icon' => 'eicon-text-align-center'
				],
				'right' => [
					'title'=> esc_html__( 'Right', 'royal-addons-for-elementor' ),
					'icon' => 'eicon-text-align-right'
				]
			],
			'default' => 'left',
			'toggle'  => false,
			'selectors' => [
				'{{WRAPPER}} .royalprofilecard .content' => 'text-align: {{VALUE}};',
			],
		]
	);

    $this->end_controls_section(); 
  }





 
  private function rt_style_social_options() {
		$this->start_controls_section(
		  'style_social_settings',
		  [
			'label' => __( 'Social Style', 'royal-addons-for-elementor' ),
			'tab' => Controls_Manager::TAB_STYLE,
		  ]
		);
	  
		$this->add_control(
			'social_font_size',
			[
				'label' => esc_html__( 'Font Size', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard ul.socialstyle li a i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
		  'social_color',
		  [
			'type'      => Controls_Manager::COLOR,
			'label'     => __( 'Social Color', 'royal-addons-for-elementor' ),
			'default'	=> '#000000',
			'selectors' => [
			  '{{WRAPPER}} .royalprofilecard ul.socialstyle li a i' => 'color: {{VALUE}};',
			],
		  ]
		);

		$this->add_control(
		  'social_color_hover',
		  [
			'type'      => Controls_Manager::COLOR,
			'label'     => __( 'Social Hover Color', 'royal-addons-for-elementor' ),
			'default'	=> '#ffffff',
			'selectors' => [
			  '{{WRAPPER}} .royalprofilecard ul.socialstyle li a i:hover' => 'color: {{VALUE}};',
			],
		  ]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'social_border',
					'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
					'selector' => '{{WRAPPER}} .royalprofilecard ul.socialstyle li a i',
				]
			);


		$this->add_responsive_control(
		  'social_margin',
		  [
			'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
			  '{{WRAPPER}} .royalprofilecard ul.socialstyle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		  ]
		);

		$this->add_responsive_control(
		  'social_padding',
		  [
			'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
			  '{{WRAPPER}} .royalprofilecard ul.socialstyle li a i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		  ]
		);

		$this->add_responsive_control(
			'social_align',
			[
				'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title'=> esc_html__( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title'=> esc_html__( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center'
					],
					'flex-end' => [
						'title'=> esc_html__( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right'
					]
				],
				'default' => 'center',
				'toggle'  => false,
				'selectors' => [
					'{{WRAPPER}} .royalprofilecard .horizontalsocial' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .royalprofilecard .verticalsocial' => 'align-items: {{VALUE}};',
				],
			]
		);

    $this->end_controls_section(); 
}





	protected function render() {
		$settings           = $this->get_settings_for_display();
		$profilecardstyle	= $settings['profilecardstyle'];
		$profilebackground	= $settings['profilebackground']['url'];
		$profiletitle	    = $settings['profiletitle'];
		$profiledesig	    = $settings['profiledesig'];
		$profilecontent	    = $settings['profilecontent'];
		$alt	= \Elementor\Control_Media::get_image_alt( $settings['profilecardstyle'] );
  ?>
  <div class="royalprofilecard">
  <?php if('1'== $profilecardstyle){ ?>
    <figure class="profilecardstyle1">
    <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
    <figcaption>
    <div class="name">
    <h2 class="title"><?php echo $profiletitle;?></h2>
      <h3 class="designation"><?php echo $profiledesig;?></h3>
    </div>
    <div class="info">
    <p class="content"><?php echo $profilecontent;?></p>
    <?php $this->socialcontent(); ?> 
    </div>      	
    </figcaption>	
    </figure>


    <?php }elseif('2'== $profilecardstyle){ ?>
      <figure class="profilecardstyle2">
        <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
        <figcaption>
        <div class="name">
          <h2 class="title"><?php echo $profiletitle;?></h2>
          <h3 class="designation"><?php echo $profiledesig;?></h3>
          <p class="content"><?php echo $profilecontent;?></p>
		  <?php $this->socialcontent(); ?>
        </div>
        </figcaption>       
      </figure>


      <?php }elseif('3'== $profilecardstyle){ ?>
        <figure class="profilecardstyle3">
        <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
        <figcaption>
        <div class="name">
        <h2 class="title"><?php echo $profiletitle;?></h2>
        <h3 class="designation"><?php echo $profiledesig;?></h3>
        <p class="content"><?php echo $profilecontent;?></p>
        <?php $this->socialcontent(); ?>      
        </div>
        </figcaption>
        </figure>


        <?php }elseif('4'== $profilecardstyle){ ?>
          <figure class="profilecardstyle4">
          <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
          <figcaption>
            <div class="name">
            <h2 class="title"><?php echo $profiletitle;?></h2>
            <h3 class="designation"><?php echo $profiledesig;?></h3>
            <p class="content"><?php echo $profilecontent;?></p>           
            </div>
            <?php $this->socialcontent(); ?>
          </figcaption>			
        </figure>
          

      <?php }elseif('5'== $profilecardstyle){ ?>
        <figure class="profilecardstyle5">
        <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
        <figcaption>
          <div class="name">
            <h2 class="title"><?php echo $profiletitle;?></h2>
            <h3 class="designation"><?php echo $profiledesig;?></h3>
            <p class="content"><?php echo $profilecontent;?></p>
          </div>
          <?php $this->socialcontent(); ?>  
        </figcaption>
      </figure>


    <?php }elseif('6'== $profilecardstyle){ ?>
      <figure class="profilecardstyle6">
      <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
      <figcaption>
      <div class="name">
        <h2 class="title"><?php echo $profiletitle;?></h2>
        <h3 class="designation"><?php echo $profiledesig;?></h3>
      </div>        
      <p class="content"><?php echo $profilecontent;?></p>
      <?php $this->socialcontent(); ?>
      </figcaption>			
      </figure>


    <?php }elseif('7'== $profilecardstyle){ ?>
    <figure class="profilecardstyle7">
    <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
      <div class="tblock">
        <div>
          <h2 class="title"><?php echo $profiletitle;?></h2>
          <h4 class="designation"><?php echo $profiledesig;?></h4>
        </div>
      </div>
      <figcaption>
      <p class="content"><?php echo $profilecontent;?></p>
      <?php $this->socialcontent(); ?>
      </figcaption>
    </figure>


    <?php }elseif('8'== $profilecardstyle){ ?>
      <figure class="profilecardstyle8">
      <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
      <figcaption>
        <h2 class="title"><?php echo $profiletitle;?></h2>
        <h3 class="designation"><?php echo $profiledesig;?></h3>
        <p class="content"><?php echo $profilecontent;?></p>
        <?php $this->socialcontent(); ?>
      </figcaption>
      </figure>


  <?php }elseif('9'== $profilecardstyle){ ?>
  <figure class="profilecardstyle9">
    <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
    <figcaption>
      <h2 class="title"><?php echo $profiletitle;?></h2>
      <h3 class="designation"><?php echo $profiledesig;?></h3>
      <p class="content"><?php echo $profilecontent;?></p>
      <?php $this->socialcontent(); ?>
    </figcaption>
  </figure>


  <?php }elseif('10'== $profilecardstyle){ ?>
    <figure class="profilecardstyle10">
      <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
      <figcaption>
      <h2 class="title"><?php echo $profiletitle;?></h2>
      <h3 class="designation"><?php echo $profiledesig;?></h3>
      <p class="content"><?php echo $profilecontent;?></p>
      <?php $this->socialcontent(); ?>
      </figcaption>
    </figure>


    <?php }elseif('11'== $profilecardstyle){ ?>
      <figure class="profilecardstyle11">
        <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
        <figcaption>
        <h2 class="title"><?php echo $profiletitle;?></h2>
        <h3 class="designation"><?php echo $profiledesig;?></h3>
        <p class="content"><?php echo $profilecontent;?></p>
        <?php $this->socialcontent(); ?>
        </figcaption>			
			</figure>


      <?php }elseif('12'== $profilecardstyle){ ?>
        <figure class="profilecardstyle12">
          <div class="profile-image"><img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/></div>
          <figcaption>
          <h2 class="title"><?php echo $profiletitle;?></h2>
          <h3 class="designation"><?php echo $profiledesig;?></h3>
          <p class="content"><?php echo $profilecontent;?></p>
          <?php $this->socialcontent(); ?>
          </figcaption>
        </figure>


    <?php }elseif('13'== $profilecardstyle){ ?>
     <div class="profilecardstyle13">
        <div class="picture">
			<img src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
        </div>
        <div class="name">
          <h2 class="title"><?php echo $profiletitle;?></h2>
          <h3 class="designation"><?php echo $profiledesig;?></h3>
          <p class="content"><?php echo $profilecontent;?></p>
        </div>
        <?php $this->socialcontent(); ?>
      </div>


    <?php }elseif('14'== $profilecardstyle){ ?>
      <figure class="profilecardstyle14">
      <figcaption>
      <h2 class="title"><?php echo $profiletitle;?></h2>
      <p class="content"><?php echo $profilecontent;?></p>
      <?php $this->socialcontent(); ?>
      <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
      </figcaption>
      
      <h3 class="designation"><?php echo $profiledesig;?></h3>
      </figure>



    <?php }elseif('15'== $profilecardstyle){ ?>
		<div class="profilecardstyle15">
			<img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
			<div class="contentwraper">
				<h2 class="title"><?php echo $profiletitle;?></h2>
				<h3 class="designation"><?php echo $profiledesig;?></h3>
				<p class="content"><?php echo $profilecontent;?></p>
				<?php $this->socialcontent(); ?>
			</div>
		</div>


	<?php }elseif('16'== $profilecardstyle){ $direction	= $settings['direction']; ?>
	<div class="profilecardstyle16">
		<div class="pill-<?php echo $direction;?>">
			<div class="profilepic">
			<img src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
			</div>
		<div class="name">
			<h2 class="title"><?php echo $profiletitle;?></h2>
			<h3 class="designation"><?php echo $profiledesig;?></h3>
			<p class="content"><?php echo $profilecontent;?></p>
			<?php $this->socialcontent(); ?>
		</div>
		</div>
	</div>


	<?php }elseif('17'== $profilecardstyle){ ?>
	<div class="profilecardstyle17">
		<div class="region region1"></div>
		<div class="region region2"></div>
		<div class="region region3"></div>
		<div class="region region4"></div>
		<div class="region region5"></div>
		<div class="region region6"></div>
		<div class="region region7"></div>
		<div class="region region8"></div>
		<div class="region region9"></div>
		<div class="name">
			<img src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
			<div>
				<h2 class="title"><?php echo $profiletitle;?></h2>
				<h3 class="designation"><?php echo $profiledesig;?></h3>
				<p class="content"><?php echo $profilecontent;?></p>
				<?php $this->socialcontent(); ?>
			</div>
		</div>
	</div>


	<?php } elseif('18'== $profilecardstyle){ ?>
	<div class="profilecardstyle18" style="background-image: url(<?php echo $profilebackground;?>);">
        <div class="name">
			<h2 class="title"><?php echo $profiletitle;?></h2>
            <div class="line1"></div>
            <div class="contentwraper">
				<h3 class="designation"><?php echo $profiledesig;?></h3>
				<p class="content"><?php echo $profilecontent;?></p>
				<?php $this->socialcontent(); ?>
            </div>
            
        </div>
    </div>


	<?php } elseif('19'== $profilecardstyle){ ?>
	<div class="profilecardstyle19">
		<input type="checkbox" name=""/>
		<div class="toggle">+</div>
		<img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
		<div class="name">
			<h2 class="title"><?php echo $profiletitle;?></h2>
          	<h3 class="designation"><?php echo $profiledesig;?></h3>
         	<p class="content"><?php echo $profilecontent;?></p>
			 <?php $this->socialcontent(); ?>
		</div>
	</div>


	<?php } elseif('20'== $profilecardstyle){ ?>
	<div class="profilecardstyle20">
	<img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
		<div class="name">
			<h2 class="title"><?php echo $profiletitle;?></h2>
          	<h3 class="designation"><?php echo $profiledesig;?></h3>
         	<p class="content"><?php echo $profilecontent;?></p>
			 <?php $this->socialcontent(); ?>
		</div>
	</div>


	<?php } elseif('21'== $profilecardstyle){ $direction = $settings['direction']; ?>
	<div class="profilecardstyle21 <?php echo $direction;?>">
		<img src="<?php echo $profilebackground;?>" alt="">
		<div class="content">
			<h2 class="title"><?php echo $profiletitle;?></h2>
			<h3 class="designation"><?php echo $profiledesig;?></h3>
			<p><?php echo $profilecontent;?></p>
			<?php $this->socialcontent(); ?>
		</div>
	</div>


	<?php } elseif('22'== $profilecardstyle){ ?>
		<div class="profilecardstyle22">
			<div class="team-img">
				<img src="<?php echo $profilebackground;?>" alt="">
			</div>
			<div class="contentwraper">
				<h2 class="title"><?php echo $profiletitle;?></h2>
				<h3 class="designation"><?php echo $profiledesig;?></h3>
				<?php $this->socialcontent(); ?>
			</div>
		</div>

	<?php } elseif('23'== $profilecardstyle){
		$has_left_accent = ( ! isset( $settings['style23_left_accent_sw'] ) || 'yes' === $settings['style23_left_accent_sw'] ) ? ' has-left-accent' : '';
		$show_quote      = ( ! isset( $settings['style23_show_quote'] ) || 'yes' === $settings['style23_show_quote'] );
		$text_order      = ! empty( $settings['style23_text_order'] ) ? $settings['style23_text_order'] : 'quote_first';
	?>
		<div class="profilecardstyle23<?php echo esc_attr( $has_left_accent ); ?>">
			<div class="royal-ring-container">
				<div class="royal-ring">
					<img class="profilepic" src="<?php echo esc_url($profilebackground);?>" alt="<?php echo esc_attr($alt);?>"/>
				</div>
			</div>
			<div class="contentwraper">
				<?php if ( $show_quote ) : ?>
					<div class="royal-quote-mark"><svg width="44" height="34" viewBox="0 0 46 36" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M0 21.6C0 9.72 8.28 1.44 20.16 0L21.6 4.32C14.04 5.76 10.44 10.44 9.72 15.48C11.52 14.76 13.68 14.4 15.84 14.4C21.6 14.4 25.92 18.72 25.92 24.84C25.92 31.32 20.88 36 14.04 36C6.12 36 0 29.88 0 21.6ZM20.16 21.6C20.16 9.72 28.44 1.44 40.32 0L41.76 4.32C34.2 5.76 30.6 10.44 29.88 15.48C31.68 14.76 33.84 14.4 36 14.4C41.76 14.4 46.08 18.72 46.08 24.84C46.08 31.32 41.04 36 34.2 36C26.28 36 20.16 29.88 20.16 21.6Z"/></svg></div>
				<?php endif; ?>

				<?php if ( 'title_first' === $text_order ) : ?>
					<?php if ( ! empty( $profiletitle ) ) : ?>
						<h2 class="title"><?php echo esc_html($profiletitle);?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $profiledesig ) ) : ?>
						<h3 class="designation"><?php echo esc_html($profiledesig);?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $profilecontent ) ) : ?>
						<div class="content"><?php echo wp_kses_post($profilecontent);?></div>
					<?php endif; ?>
				<?php else : ?>
					<?php if ( ! empty( $profilecontent ) ) : ?>
						<div class="content"><?php echo wp_kses_post($profilecontent);?></div>
					<?php endif; ?>
					<div class="royal-sign-wrap">
						<?php if ( ! empty( $profiletitle ) ) : ?>
							<span class="royal-sign-dash">—</span>
							<h2 class="title royal-sign-title"><?php echo esc_html($profiletitle);?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $profiledesig ) ) : ?>
							<h3 class="designation royal-sign-desig"><?php echo esc_html($profiledesig);?></h3>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php $this->socialcontent(); ?>
			</div>
		</div>



	<?php } elseif('24'== $profilecardstyle){
		$card_number = ! empty( $settings['card_number'] ) ? $settings['card_number'] : '';
	?>
		<div class="profilecardstyle24">
			<span class="royal-mg-shine"></span>
			<?php if ( ! empty( $card_number ) ) : ?>
				<span class="royal-mg-card-no"><?php echo esc_html( $card_number ); ?></span>
			<?php endif; ?>

			<div class="royal-mg-photo">
				<div class="royal-mg-ring"></div>
				<div class="royal-mg-frame">
					<img class="profilepic" src="<?php echo esc_url( $profilebackground ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
				</div>
			</div>

			<div class="royal-mg-info">
				<?php if ( ! empty( $profiletitle ) ) : ?>
					<h4 class="title royal-mg-name"><?php echo esc_html( $profiletitle ); ?></h4>
				<?php endif; ?>

				<?php if ( ! empty( $profiledesig ) ) : ?>
					<span class="designation royal-mg-role"><?php echo esc_html( $profiledesig ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $profilecontent ) ) : ?>
					<div class="content royal-mg-content">
						<?php echo wp_kses_post( $profilecontent ); ?>
					</div>
				<?php endif; ?>

				<?php $this->socialcontent(); ?>
			</div>
		</div>



    <?php } elseif('101fadein'== $profilecardstyle){ $fadeinstyle = $settings['101fadeinstyle']; ?>
	<div class="profilecardstylefadein">
		<div class="contentwraper">
			<div class="contentwraper-overlay"></div>
			<img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
			<div class="contentwraper-details <?php echo $fadeinstyle;?>">
			<h2 class="title"><?php echo $profiletitle;?></h2>
			<h3 class="designation"><?php echo $profiledesig;?></h3>
			<p class="content"><?php echo $profilecontent;?></p>
			<?php $this->socialcontent(); ?>
			</div>
		</div>
	</div>


    <?php } elseif('102overlay'== $profilecardstyle){ $overlaystyle	= $settings['102overlaystyle'];	?>
	<div class="profilecardoverlaystyle">
		<div class="contentwraper">
		<img src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>">
			<div class="profilecardoverlay <?php echo $overlaystyle;?>">
				<div class="text">
					<h2 class="title"><?php echo $profiletitle;?></h2>
					<h3 class="designation"><?php echo $profiledesig;?></h3>
					<p class="content"><?php echo $profilecontent;?></p>
					<?php $this->socialcontent(); ?>					
				</div>
			</div>
		</div>
	</div>	


    <?php } elseif('103zoom'== $profilecardstyle){ ?>
	<div class="profilecardstyle103" style="background-image:url(<?php echo $profilebackground;?>)">
	<img src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>">
		<div class="contentwraper" >
			<h2 class="title"><?php echo $profiletitle;?></h2>
			<h3 class="designation"><?php echo $profiledesig;?></h3>
			<p class="content"><?php echo $profilecontent;?></p>
			<?php $this->socialcontent(); ?>
		</div>
	</div>	
	

	<?php }else{ ?>
    <figure class="profilecardstyle1">
      <img class="profilepic" src="<?php echo $profilebackground;?>" alt="<?php echo $alt;?>"/>
      <figcaption>
        <div class="name">
          <h2 class="title"><?php echo $profiletitle;?></h2>
          <h3 class="designation"><?php echo $profiledesig;?></h3>
          <a class="wholelink" href="#"></a>
        </div>
        <div class="info">
        <p class="content"><?php echo $profilecontent;?></p>
        <?php $this->socialcontent(); ?>
      </div>      	
      </figcaption>	
    </figure>
    <?php } ?>
  </div>
  <?php
	}












	protected function socialcontent() {
		$settings = $this->get_settings();
		$show_socialcontent = $settings['show_socialcontent'];
		$socialstyle = $settings['socialstyle'];
		$socialcontent = $settings['socialcontent'];
		if ( 'yes' !== $show_socialcontent ) {
			return;
		}

		if ( $settings['socialcontent'] ) {
		  echo '<ul class="socialstyle '.$socialstyle.'">';
		  foreach (  $settings['socialcontent'] as $item ) {
			echo '<li><a href="'.$item['sociallink'].'"><i class="'.$item['socialicon']['value'].'"></i></a></li>';
		  }
		  echo '</ul>';
		}
	}

	


}

