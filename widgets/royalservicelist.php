<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalServiceList extends Widget_Base{

  public function get_name(){
    return 'royalservicelist';
  }


  public function get_title(){
    return 'Service List';
  }


  public function get_icon() { return 'eicon-editor-list-ul rtbranding'; }


  public function get_keywords() {
    return [ 'service', 'list', 'image', 'photo', 'feature', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
  }


  public function get_categories(){
    return ['royaltech'];
  }

  
	public function get_style_depends() {
		$styles = ['royalservicelist'];
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
      'servicetitle',
      [
        'label' => __( 'Title', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Collection', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor'),
      ]
    );


    $this->add_control(
      'image',
      [
        'label' => __( 'Image', 'royal-addons-for-elementor' ),
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

    $repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'list_title', [
				'label' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'royal-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_url',
			[
				'label' => esc_html__( 'Link', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '#' , 'royal-addons-for-elementor' ),
			]
		);

  	$this->add_control(
			'list',
			[
				'label' => esc_html__( 'Repeater List', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => esc_html__( 'Title #1', 'royal-addons-for-elementor' ),
						'list_url' => esc_html__( 'https://royal-addons-for-elementorbd.com', 'royal-addons-for-elementor' ),
					],
					[
						'list_title' => esc_html__( 'Title #2', 'royal-addons-for-elementor' ),
						'list_url' => esc_html__( 'https://royal-addons-for-elementorbd.com', 'royal-addons-for-elementor' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
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
      'title_style',
      [
        'label' => __( 'Title Style', 'royal-addons-for-elementor' ),
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
        'selector' => '{{WRAPPER}} .royalservicelist .boxinfo .title',
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
                '{{WRAPPER}} .royalservicelist .boxinfo .title' => 'color: {{VALUE}}',
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
                '{{WRAPPER}} .royalservicelist .boxinfo .title' => 'background: {{VALUE}}',
            ],
        ]
    );   


   $this->add_control(
        'title_hover_color',
        [
            'label' => __( 'Title Hover Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalservicelist .boxinfo .title:hover' => 'color: {{VALUE}}',
            ],
        ]
    );   


   $this->add_control(
        'title_hover_bg',
        [
            'label' => __( 'Title Hover Color', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff00',
            'global' => [
              'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
            ],
            'selectors' => [
                '{{WRAPPER}} .royalservicelist .boxinfo .title:hover' => 'background: {{VALUE}}',
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
        'selector' => '{{WRAPPER}} .royalservicelist .imageboxcontent ul li a',
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
                '{{WRAPPER}} .royalservicelist .imageboxcontent ul li a' => 'color: {{VALUE}}',
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
                '{{WRAPPER}} .royalservicelist .imageboxcontent ul li a' => 'background: {{VALUE}}',
            ],
        ]
    );   


    $this->end_controls_section();







    $this->start_controls_section(
      'List_section',
      [
        'label' => __( 'List Style', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );    




		$this->add_control(
			'list_icon',
			[
			  'label' => __( 'List Icon', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::ICONS,
			  'separator' => 'before',
			  'fa4compatibility' => 'icon',
			  'default' => [
				'value' => 'fas fa-caret-right',
				'library' => 'fa-solid',
			  ],
			  'recommended' => [
				'fa-solid' => [
				  'angle-right',
				  'angle-double-right',
				  'chevron-circle-right',
				  'long-arrow-alt-right',
				  'arrow-alt-circle-right',
				  'arrow-right',
				  'play',
				],
				'fa-regular' => [
				  'caret-square-right',
				],
			  ],
			  'skin' => 'inline',
			  'label_block' => false,        
			]
		  );

		  $this->add_control(
			'list_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'default' 	=> '#29C944',
				'selectors' => [
					'{{WRAPPER}} .royalservicelist .imageboxcontent ul li>i' => 'border-color: {{VALUE}};',
				],
			]
		);



    $this->end_controls_section();




  

}
  



  protected function render() {
    $settings = $this->get_settings_for_display();
    ?>
        <div class="royalservicelist"> 
            <div class="boxinfo">
                <?php if ( $settings['servicetitle'] ) : ?>
                <h3 class="title"><?php echo wp_kses_post( $settings['servicetitle'] ) ?></h3>
                <?php endif; ?>

              <div class="imageboxcontent">
                <?php if ( ! empty( $settings['image']['url'] ) ) { 
                $image = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
                echo '<div class="image">' . $image . '</div>';
                } ?>
              <ul>
              <?php
                  if ( $settings['list'] ) {
                    foreach (  $settings['list'] as $item ) {    
                      echo'<li><i class="'.$settings['list_icon']['value'].'"></i><a href="'.$item['list_url'].'">'.$item['list_title'].'</a></li>';                  
                    }
                  }
              ?>
              </ul>
              </div>
            </div> 
        </div>
    <?php
  }






}