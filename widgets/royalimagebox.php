<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalImageBox extends Widget_Base{

  public function get_name(){
    return 'royalimagebox';
  }


  public function get_title(){
    return 'Image Box';
  }


  public function get_icon() { return 'eicon-image-box rtbranding'; }


  public function get_keywords() {
    return [ 'image', 'box', 'feature', 'photo', 'visual', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
  }


  public function get_categories(){
    return ['royaltech'];
  }

  
	public function get_style_depends() {
		$styles = ['royalimagebox'];
		return $styles;
	}


  protected function register_controls(){
    $this->start_controls_section(
        'section_content',
        [
            'label' => __( 'Content', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $this->add_control(
      'imagebox_style',
      [
        'label' => __( 'Image Box Style', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'imageboxstyle1',
        'options' => [
          'imageboxstyle1'    => __( 'Style 1', 'royal-addons-for-elementor'),
          'imageboxstyle2'    => __( 'Style 2', 'royal-addons-for-elementor'),
          'imageboxstyle3'    => __( 'Style 3', 'royal-addons-for-elementor'),
          'imageboxstyle4'    => __( 'Style 4 (Business Unit)', 'royal-addons-for-elementor'),
        ],
      ]
    );

    $this->add_control(
      'imagebox_title',
      [
        'label' => __( 'Title', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Collection', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor'),
      ]
    );


    $this->add_control(
      'title_position',
      [
        'label' => __( 'Title Position', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'titletop',
        'options' => [
          'titletop'  => __( 'Top', 'royal-addons-for-elementor'),
          'titlebottom' => __( 'Bottom', 'royal-addons-for-elementor'),
        ],
      ]
    );


    $this->add_control(
      'imagebox_content',
      [
        'label' => __( 'Imagebox Content', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => __( 'Imagebox Content here', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor'),
      ]
    );


    $this->add_control(
      'show_button',
      [
        'label' => __( 'Show Button', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
        'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'button_url',
      [
        'label' => __( 'Button Link', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'http://www.royal-addons-for-elementorbd.com', 'royal-addons-for-elementor' ),
        'show_external' => true,
        'default' => [
          'url' => '',
          'is_external' => true,
          'nofollow' => true,
        ],
        'condition' => array(
          'show_button' => 'yes',
        ),        
      ]
    );


    $this->add_control(
      'button_text',
      [
        'label' => __( 'Button Text', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'placeholder' => __( 'Buy Now', 'royal-addons-for-elementor' ),
        'show_external' => true,
        'default' => 'Buy Now',
        'condition' => array(
          'show_button' => 'yes',
        ),        
      ]
    );


    $this->add_control(
      'imagebox_image',
      [
        'label' => __( 'Image Box Image', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Image_Size::get_type(),
      [
        'name' => 'imagebox_image_size', 
        'default' => 'image600',
        'separator' => 'none',
      ]
    );

    $this->add_control(
      'secondary_icon',
      [
        'label' => __( 'Secondary Icon / Logo', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => '',
        ],
        'description' => __( 'Used in Style 4 (Business Unit)', 'royal-addons-for-elementor' ),
      ]
    );



    $this->end_controls_section();




    $this->start_controls_section(
      'title_color_section',
      [
        'label' => __( 'Style', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'imagebox_hover_animation',
      [
        'label' => __( 'Image Box Hover Animation', 'plugin-domain' ),
        'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
        'prefix_class' => 'elementor-animation-',
      ]
    );




   $this->add_control(
        'box_bg_color',
        [
            'label' => __( 'Box Background Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF00',
            'condition' => array(
              'imagebox_style' => 'imageboxstyle3',
            ), 
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .imageboxstyle3 .royalimagebox:hover .boxinfo' => 'background: {{VALUE}}',
            ],
        ]
    );   






    $this->add_control(
      '_title_style',
      [
        'label' => __( 'Title Style', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
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
        'selector' => '{{WRAPPER}} .royalimagebox .boxinfo .title',
      ]
    );


    $this->add_control(
      'title_hover_animation',
      [
        'label' => __( 'Title Hover Animation', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'royalhovernone',
        'options' => [
          'royalhovernone'    => __( 'None', 'royal-addons-for-elementor'),
          'royalhoverstroke'  => __( 'Stroke', 'royal-addons-for-elementor'),
          'royalhovershift'   => __( 'Shift', 'royal-addons-for-elementor'),
        ],
      ]
    );  




   $this->add_control(
        'title_color',
        [
            'label' => __( 'Title Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo .title' => 'color: {{VALUE}}',
            ],
        ]
    );


   $this->add_control(
        'title_bg_color',
        [
            'label' => __( 'Title Background Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF00',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo .title' => 'background: {{VALUE}}',
            ],
        ]
    );   


   $this->add_control(
        'title_hover_color',
        [
            'label' => __( 'Title Hover Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ddd',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .royalhoverstroke:after' => 'color: {{VALUE}}',
                '{{WRAPPER}} .royalimagebox .royalhovershift:after' => 'color: {{VALUE}}',
            ],
        ]
    );   


   $this->add_control(
        'title_hover_bg',
        [
            'label' => __( 'Title Hover Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ddd',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .royalhoverstroke:after' => 'background: {{VALUE}}',
                '{{WRAPPER}} .royalimagebox .royalhovershift:after' => 'background: {{VALUE}}',
            ],
        ]
    );   


    $this->add_control(
      '_content_style',
      [
        'label' => __( 'Content Style', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'content_typo',
        'label' => __( 'Content Typography', 'royal-addons-for-elementor' ),
        'global' => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
        ],
        'selector' => '{{WRAPPER}} .royalimagebox .boxinfo .content',
      ]
    );


  
   $this->add_control(
        'content_color',
        [
            'label' => __( 'Content Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo .content' => 'color: {{VALUE}}',
            ],
        ]
    );


   $this->add_control(
        'content_bg_color',
        [
            'label' => __( 'Content Background Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF00',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo .content' => 'background: {{VALUE}}',
            ],
        ]
    );   




    $this->add_control(
      '_button_style',
      [
        'label' => __( 'Button Style', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'button_typo',
        'label' => __( 'Button Typography', 'royal-addons-for-elementor' ),
        'global' => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
        ],
        'selector' => '{{WRAPPER}} .royalimagebox .boxinfo a.button',
      ]
    );


  
   $this->add_control(
        'button_color',
        [
            'label' => __( 'Button Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo a.button' => 'color: {{VALUE}}',
            ],
        ]
    );


   $this->add_control(
        'button_bg_color',
        [
            'label' => __( 'Button Background Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF00',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo a.button' => 'background: {{VALUE}}',
            ],
        ]
    );   


  
   $this->add_control(
        'button_color_hover',
        [
            'label' => __( 'Button Hover Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo a.button:hover' => 'color: {{VALUE}}',
            ],
        ]
    );


   $this->add_control(
        'button_bg_color_hover',
        [
            'label' => __( 'Button Hover Background Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF00',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalimagebox .boxinfo a.button:hover' => 'background: {{VALUE}}',
            ],
        ]
    );   



   $this->end_controls_section();   








  }
  



  protected function render() {
    $settings = $this->get_settings_for_display();
    ?>
        <div class="<?php echo esc_attr($settings['imagebox_style']); ?>"> 
        <div class="royalimagebox"> 
            
            <?php if ( 'imageboxstyle4' === $settings['imagebox_style'] ) : ?>
            
                <?php if ( ! empty( $settings['imagebox_image']['url'] ) ) { 
                    $image = Group_Control_Image_Size::get_attachment_image_html( $settings, 'imagebox_image_size', 'imagebox_image' );
                    echo '<div class="bgimg">' . $image . '<div class="royal-overlay"><div class="royal-dotted"></div></div></div>';
                } ?>
                
                <div class="boxinfo">
                    <?php if ( ! empty( $settings['secondary_icon']['url'] ) ) { ?>
                        <div class="royal-secondary-icon">
                            <img src="<?php echo esc_url($settings['secondary_icon']['url']); ?>" alt="Icon">
                        </div>
                    <?php } ?>
                    
                    <?php if ( $settings['imagebox_title'] ) : ?>
                        <h3 class="title <?php echo esc_attr($settings['title_position']); ?> <?php echo esc_attr($settings['title_hover_animation']); ?>"><?php echo wp_kses_post($settings['imagebox_title']); ?></h3>
                    <?php endif; ?>
                    
                    <?php if ( $settings['imagebox_content'] ) : ?>
                        <div class="content"><?php echo wp_kses_post($settings['imagebox_content']); ?></div>
                    <?php endif; ?>
                    
                    <?php if ( 'yes' === $settings['show_button'] ) { ?>
                        <a class="button" href="<?php echo esc_url($settings['button_url']['url']); ?>"><?php echo esc_html($settings['button_text']); ?></a>
                    <?php } ?>
                </div> 

            <?php else : ?>

                <div class="boxinfo">
                <?php if ( $settings['imagebox_title'] ) : ?>
                <h3 class="title <?php echo esc_attr($settings['title_position']); ?> <?php echo esc_attr($settings['title_hover_animation']); ?>"><?php echo wp_kses_post($settings['imagebox_title']); ?></h3>
                <?php endif; ?>
                <?php if ( $settings['imagebox_content'] ) : ?>
                <div class="content"><?php echo wp_kses_post($settings['imagebox_content']); ?></div>
                <?php endif; ?>
                <?php if ( 'yes' === $settings['show_button'] ) { ?>
                <a class="button" href="<?php echo esc_url($settings['button_url']['url']); ?>"><?php echo esc_html($settings['button_text']); ?></a>
                <?php } ?>
                </div> 
                <?php if ( ! empty( $settings['imagebox_image']['url'] ) ) { 
                $image = Group_Control_Image_Size::get_attachment_image_html( $settings, 'imagebox_image_size', 'imagebox_image' );
                echo '<div class="bgimg">' . $image . '</div>';
                } ?>
                
            <?php endif; ?>

        </div>
        </div>
    <?php
  }





}