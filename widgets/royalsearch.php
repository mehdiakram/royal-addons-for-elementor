<?php

namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalSearch extends Widget_Base{

  public function get_name(){
    return 'royalsearch';
  }


  public function get_title(){
    return 'Search';
  }


  public function get_icon() { return 'eicon-site-search rtbranding'; }


  public function get_keywords() {
    return [ 'site', 'search', 'find', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
  }


  public function get_categories(){
    return ['royaltech'];
  }


	public function get_style_depends() {
		return ['royalsearch'];
	}

  public function get_script_depends() {
      return ['royalsearch'];
  }


  protected function register_controls(){

    $this->start_controls_section(
        'content_section',
        [
          'label' => __( 'Royal Search', 'royal-addons-for-elementor' ),
          'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
      );


		$this->add_control(
			'search_type',
			[
				'label' => __( 'Search Type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'   => __( 'Default', 'royal-addons-for-elementor' ),
					'woo'       => __( 'Woo', 'royal-addons-for-elementor' ),
					'woocat'    => __( 'Woo with Cat', 'royal-addons-for-elementor' ),
				],
			]
		);


		$this->add_control(
			'search_style',
			[
				'label' => __( 'Search Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'fullscreen',
				'options' => [
          'fullscreen' => __( 'Fullscreen', 'royal-addons-for-elementor' ),
				],
			]
		);
      
    $this->end_controls_section();


    $this->start_controls_section(
      'search_icon_section',
      [
        'label' => __( 'Search Icon', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'royalsearchicon',
      [
        'label' => __( 'Search Icon', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'separator' => 'before',
        'default' => [
          'value' => 'fas fa-search',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'search',
            'search-plus',
            'search-minus',
            'search-location',
            'search-dollar',
          ],
          'fa-brands' => [
            'searchengin',
          ],
        ],
        'skin' => 'inline',
        'label_block' => false,        
      ]
    );

    $this->add_responsive_control(
        'search_icon_size',
        [
          'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'size_units' => [ 'px'],
          'range' => [
            'px' => [
              'min' => 5,
              'max' => 200,
              'step' => 1,
            ],
          ],
          'default' => [
            'unit' => 'px',
            'size' => 20,
          ],
          'selectors' => [
            '{{WRAPPER}} .royalsearchicon svg' => 'width: {{SIZE}}{{UNIT}};',
          ],
        ]
      );

    $this->add_control(
      'search_icon_color',
        [
            'label' => __( 'Search Icon Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} .royalsearchicon svg' => 'fill: {{VALUE}}',
            ],
        ]
    );   

    $this->add_control(
      'search_icon_color_hover',
        [
            'label' => __( 'Search Icon Hover', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} .royalsearchicon:hover svg' => 'fill: {{VALUE}}',
            ],
        ]
    );   


    $this->end_controls_section();


    $this->start_controls_section(
        'overlay_close_section',
        [
          'label' => __( 'Close Button', 'royal-addons-for-elementor' ),
          'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
      );
      
    $this->add_control(
          'royalcartcloseicon',
          [
            'label' => __( 'Close Icon', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::ICONS,
            'separator' => 'before',
            'fa4compatibility' => 'icon',
            'default' => [
              'value' => 'fas fa-times',
              'library' => 'fa-solid',
            ],
            'recommended' => [
              'fa-regular' => [
                  'window-close',
                  'times-circle',
                  'times-circle',
              ],
              'fa-solid' => [
                  'window-close',
                  'times-circle',
                  'times',
              ]
              ],
            'skin' => 'inline',
            'label_block' => false,        
          ]
        );  


    $this->add_responsive_control(
        'close_icon_size',
        [
          'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'size_units' => [ 'px'],
          'range' => [
            'px' => [
              'min' => 5,
              'max' => 200,
              'step' => 1,
            ],
          ],
          'default' => [
            'unit' => 'px',
            'size' => 20,
          ],
          'selectors' => [
            '{{WRAPPER}} .royalsearchoverly .closebtn svg' => 'width: {{SIZE}}{{UNIT}};',
          ],
        ]
    );
    

    $this->add_control(
          'close_icon_color',
          [
              'label' => __( 'Close Color', 'royal-addons-for-elementor' ),
              'type' => \Elementor\Controls_Manager::COLOR,
              'default' => '#ffffff',
              'selectors' => [
                  '{{WRAPPER}} .royalsearchoverly .closebtn svg' => 'fill: {{VALUE}}',
              ],
          ]
      );

    $this->add_control(
          'close_icon_color_hover',
          [
              'label' => __( 'Close Hover Color', 'royal-addons-for-elementor' ),
              'type' => \Elementor\Controls_Manager::COLOR,
              'default' => '#ffffff',
              'selectors' => [
                  '{{WRAPPER}} .royalsearchoverly .closebtn:hover svg' => 'fill: {{VALUE}}',
              ],
          ]
      );

    $this->end_controls_section();


    $this->start_controls_section(
        'overlay_section',
        [
          'label' => __( 'Overlay', 'royal-addons-for-elementor' ),
          'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
      );
    
    $this->add_control(
      'searchboxicon',
      [
        'label' => __( 'Search Box Icon', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'separator' => 'before',
        'fa4compatibility' => 'icon',
        'default' => [
          'value' => 'fas fa-search',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'search',
            'search-plus',
            'search-minus',
            'search-location',
            'search-dollar',
          ],
          'fa-brands' => [
            'searchengin',
          ],
        ],
        'skin' => 'inline',
        'label_block' => false,        
      ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Background::get_type(),
        [
          'name' => 'overlay_background',
          'types' => [ 'classic', 'gradient', 'video' ],
          'selector' => '{{WRAPPER}} .royalsearchoverly',
        ]
      );


    $this->add_responsive_control(
        'overlay_icon_size',
        [
          'label' => esc_html__( 'Icon Size', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'size_units' => [ 'px'],
          'range' => [
            'px' => [
              'min' => 5,
              'max' => 200,
              'step' => 1,
            ],
          ],
          'default' => [
            'unit' => 'px',
            'size' => 20,
          ],
          'selectors' => [
            '{{WRAPPER}} .royalsearchoverly .royalsearchform button svg' => 'width: {{SIZE}}{{UNIT}};',
          ],
        ]
      );

    $this->add_control(
          'overlay_search_button_color',
          [
              'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
              'type' => \Elementor\Controls_Manager::COLOR,
              'default' => '#000000',
              'selectors' => [
                  '{{WRAPPER}} .royalsearchoverly .royalsearchform button svg' => 'fill: {{VALUE}}',
              ],
          ]
      );     

    $this->add_control(
          'overlay_search_button_color_hover',
          [
              'label' => __( 'Icon Hover Color', 'royal-addons-for-elementor' ),
              'type' => \Elementor\Controls_Manager::COLOR,
              'default' => '#00000f',
              'selectors' => [
                  '{{WRAPPER}} .royalsearchoverly .royalsearchform button:hover svg' => 'fill: {{VALUE}}',
              ],
          ]
      );    


    $this->add_control(
			'button_border_radius',
        [
          'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
          'default' => [
            'top' => 0,
            'right' => 50,
            'bottom' => 50,
            'left' => 0,
            'unit' => 'px',
            'isLinked' => false,
          ],
          'selectors' => [
            '{{WRAPPER}} .royalsearchoverly .royalsearchform button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
		);

    $this->add_control(
        'overlay_search_button_bg',
        [
            'label' => __( 'Search Button Background', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#F2F2F2',
            'selectors' => [
                '{{WRAPPER}} .royalsearchoverly .royalsearchform button' => 'background: {{VALUE}}',
            ],
        ]
    );    

    $this->add_control(
        'overlay_search_button_bg_hover',
        [
            'label' => __( 'Search Button Background Hover', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#F2F2F2',
            'selectors' => [
                '{{WRAPPER}} .royalsearchoverly .royalsearchform button:hover' => 'background: {{VALUE}}',
            ],
        ]
    );    


    $this->add_control(
        'overlay_search_box',
        [
            'label' => __( 'Search Box Background', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .royalsearchoverly .royalsearchform input.searchbox' => 'background: {{VALUE}}',
            ],
        ]
    );  

    $this->add_control(
        'search_box_placeholder',
        [
          'label' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::TEXT,
          'default' => esc_html__( 'Search here...', 'royal-addons-for-elementor' ),
        ]
      );


    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
          'name' => 'search_box_typography',
          'selector' => '{{WRAPPER}} .royalsearchoverly .royalsearchform input.searchbox',
        ]
      );

    $this->add_control(
			'searchbox_border_radius',
        [
          'label' => esc_html__( 'Search Box Border Radius', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::DIMENSIONS,
          'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
          'default' => [
            'top' => 0,
            'right' => 0,
            'bottom' => 0,
            'left' => 0,
            'unit' => 'px',
            'isLinked' => false,
          ],
          'selectors' => [
            '{{WRAPPER}} .royalsearchoverly .royalsearchform input.searchbox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          ],
        ]
		);

    $this->add_responsive_control(
        'box_icon_height',
        [
          'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
          'type' => \Elementor\Controls_Manager::SLIDER,
          'size_units' => [ 'px'],
          'range' => [
            'px' => [
              'min' => 20,
              'max' => 200,
              'step' => 1,
            ],
          ],
          'default' => [
            'unit' => 'px',
            'size' => 55,
          ],
          'selectors' => [
            '{{WRAPPER}} .royalsearchoverly .royalsearchform input.searchbox' => 'height: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .royalsearchoverly .royalsearchform button' => 'height: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .royalsearchoverly .royalsearchform select#product_cat' => 'height: {{SIZE}}{{UNIT}};',
          ],
        ]
      );



		$this->add_control(
			'woocatborderradius',
			[
				'label' => esc_html__( 'Select Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 50,
					'right' => 0,
					'bottom' => 0,
					'left' => 50,
					'unit' => 'px',
					'isLinked' => false,
				],
        'condition' => [
          'search_type' => [ 'woocat'],
        ],
				'selectors' => [
					'{{WRAPPER}} .royalsearchoverly .royalsearchform select#product_cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

   $this->end_controls_section();

  }
  



  protected function render() {
    $settings = $this->get_settings_for_display();
    $search_box_placeholder = $settings['search_box_placeholder'];
    ?>
    <div class="royalsearchicon"><?php \Elementor\Icons_Manager::render_icon( $settings['royalsearchicon'], [ 'aria-hidden' => 'true' ] ); ?></div>
    
    <?php
    if ('default' == $settings['search_type']  &&  'default' == $settings['search_style'] ){

    } 
    elseif ('default' == $settings['search_type']  &&  'fullscreen' == $settings['search_style'] ){
      ?>
      <div class="royalsearchoverly">
        <span class="closebtn" title=""><?php \Elementor\Icons_Manager::render_icon( $settings['royalcartcloseicon'], [ 'aria-hidden' => 'true' ] ); ?></span>
        <div class="searchoverlycontent">
          <form class="royalsearchform" method="GET" action="<?php echo esc_url(home_url('/'));?>">
          <input type="text" aria-label="Search form" name="s" class="searchbox" maxlength="128" value="<?php echo get_search_query();?>" placeholder="<?php echo $search_box_placeholder; ?>">
          <button type="submit" aria-label="Submit search"><?php \Elementor\Icons_Manager::render_icon( $settings['searchboxicon'], [ 'aria-hidden' => 'true' ] ); ?></button> 
          </form>
        </div>
    </div>
    <?php
    } 
    elseif ('woo' == $settings['search_type']  &&  'fullscreen' == $settings['search_style'] ){
      ?>
      <div class="royalsearchoverly">
        <span class="closebtn" title=""><?php \Elementor\Icons_Manager::render_icon( $settings['royalcartcloseicon'], [ 'aria-hidden' => 'true' ] ); ?></span>
        <div class="searchoverlycontent">
          <form class="royalsearchform" method="GET" action="<?php echo esc_url(home_url('/'));?>">
          <input type="hidden" value="product" name="post_type">
          <input type="text" aria-label="Search form" name="s" class="searchbox" maxlength="128" value="<?php echo get_search_query();?>" placeholder="<?php echo $search_box_placeholder; ?>">
          <button type="submit" aria-label="Submit search"><?php \Elementor\Icons_Manager::render_icon( $settings['searchboxicon'], [ 'aria-hidden' => 'true' ] ); ?></button> 
          </form>
        </div>
    </div>
    <?php
    }  
    elseif ('woocat' == $settings['search_type']  &&  'fullscreen' == $settings['search_style'] ){
      ?>
      <div class="royalsearchoverly">
        <span class="closebtn" title=""><?php \Elementor\Icons_Manager::render_icon( $settings['royalcartcloseicon'], [ 'aria-hidden' => 'true' ] ); ?></span>
        <div class="searchoverlycontent">
        <form class="royalsearchform" method="GET" action="<?php echo esc_url(home_url('/'));?>">
          <?php if (class_exists('WooCommerce')): ?>
          <?php
          if (isset($_REQUEST['product_cat']) && !empty($_REQUEST['product_cat'])) {
              $optsetlect = $_REQUEST['product_cat'];
          } else {
              $optsetlect = 0;
          }
          $args = array(
              'show_option_all' => esc_html__('All Categories', 'royal-addons-for-elementor'),
              'hierarchical' => 1,
              'class' => 'cat',
              'echo' => 1,
              'value_field' => 'slug',
              'selected' => $optsetlect,
          );
          $args['taxonomy'] = 'product_cat';
          $args['name'] = 'product_cat';
          $args['class'] = 'cate-dropdown hidden-xs';
          wp_dropdown_categories($args);

          ?>
          <input type="hidden" value="product" name="post_type">
          <?php endif;?>
          <input type="text" aria-label="Search form" name="s" class="searchbox" maxlength="128" value="<?php echo get_search_query();?>" placeholder="<?php echo $search_box_placeholder; ?>">
          <button type="submit" aria-label="Submit search"><?php \Elementor\Icons_Manager::render_icon( $settings['searchboxicon'], [ 'aria-hidden' => 'true' ] ); ?></button> 
          </form>
        </div>
    </div>
    <?php
    }
    else
    {

    }
    

  }









}