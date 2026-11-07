<?php

namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly



class RoyalTeam extends Widget_Base{

  public function get_name(){
    return 'royalteam';
  }


  public function get_title(){
    return 'Royal Team';
  }


  public function get_icon() { return 'eicon-user-circle-o rtbranding'; }


  public function get_keywords() {
    return ['team', 'committee', 'family', 'tribe', 'part', 'wing', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
  }


  public function get_categories(){
    return ['royaltech'];
  }

	public function get_style_depends() {
		$styles = [ 'royalteam' ];
		return $styles;
	}

  
	public function get_script_depends() {
		$scripts = ['royalteam'];
		return $scripts;
	}	


  protected function register_controls(){

    $this->start_controls_section(
      'content_section',
      [
        'label' => __( 'Royal Teams', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );


    $repeater = new \Elementor\Repeater();
    $repeater->add_control(
      'image',
      [
        'label' => __( 'Choose Image', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
        'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );
    
    $repeater->add_control(
      'card_title',
      [
        'label' => __( 'Title', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'SM Mehdi Akram', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor' ),
      ]
    );
    
    $repeater->add_control(
      'card_subtitle',
      [
        'label' => __( 'Sub Title', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'IT specialist', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type sub title here.', 'royal-addons-for-elementor' ),
      ]
    );
    
    $repeater->add_control(
      'card_description',
      [
        'label' => __( 'Description', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'rows' => 10,
        'default' => __( 'SM Mehdi Akram is IT specialist in Bangladesh', 'royal-addons-for-elementor' ),
        'placeholder' => __( 'Type your description here', 'royal-addons-for-elementor' ),
      ]
    );
    
    $repeater->add_control(
      'card_color',
      [
        'label' => __( 'Team Color', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'Red',
        'options' => [
            'Red'  => __( 'Red', 'royal-addons-for-elementor' ),
            'Pink' => __( 'Pink', 'royal-addons-for-elementor' ),
            'Purple' => __( 'Purple', 'royal-addons-for-elementor' ),
            'Deep-Purple' => __( 'Deep-Purple', 'royal-addons-for-elementor' ),
            'Indigo' => __( 'Indigo', 'royal-addons-for-elementor' ),
            'Blue'  => __( 'Blue', 'royal-addons-for-elementor' ),
            'Light-Blue' => __( 'Light-Blue', 'royal-addons-for-elementor' ),
            'Cyan' => __( 'Cyan', 'royal-addons-for-elementor' ),
            'Teal' => __( 'Teal', 'royal-addons-for-elementor' ),
            'Green' => __( 'Green', 'royal-addons-for-elementor' ),
            'Light-Green'  => __( 'Light-Green', 'royal-addons-for-elementor' ),
            'Lime' => __( 'Lime', 'royal-addons-for-elementor' ),
            'Yellow' => __( 'Yellow', 'royal-addons-for-elementor' ),
            'Amber' => __( 'Amber', 'royal-addons-for-elementor' ),
            'Orange' => __( 'Orange', 'royal-addons-for-elementor' ),
            'Deep-Orange' => __( 'Deep-Orange', 'royal-addons-for-elementor' ),
            'Brown' => __( 'Brown', 'royal-addons-for-elementor' ),
            'Grey' => __( 'Grey', 'royal-addons-for-elementor' ),
            'Blue-Grey' => __( 'Blue-Grey', 'royal-addons-for-elementor' ),
        ],
      ]
    );
    
    $repeater->add_control(
      'link_facebook',
      [
        'label' => __( 'Facebook', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://facebook.com', 'royal-addons-for-elementor' ),
        'show_external' => true,
        'default' => [
          'url' => 'https://facebook.com',
          'is_external' => true,
          'nofollow' => true,
        ],
      ]
    );
    
    $repeater->add_control(
      'link_twitter',
      [
        'label' => __( 'Twitter', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://twitter.com', 'royal-addons-for-elementor' ),
        'show_external' => true,
        'default' => [
          'url' => 'https://twitter.com',
          'is_external' => true,
          'nofollow' => true,
        ],
      ]
    );
    
    $repeater->add_control(
      'link_linkedin',
      [
        'label' => __( 'LinkedIn', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://linkedin.com', 'royal-addons-for-elementor' ),
        'show_external' => true,
        'default' => [
          'url' => 'https://linkedin.com',
          'is_external' => true,
          'nofollow' => true,
        ],
      ]
    );
    
    $repeater->add_control(
      'link_instagram',
      [
        'label' => __( 'Instagram', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( '#', 'royal-addons-for-elementor' ),
        'show_external' => true,
        'default' => [
          'url' => '#',
          'is_external' => true,
          'nofollow' => true,
        ],
      ]
    );
    
    $this->add_control(
      'material_card',
      [
        'label' => __( 'Team Members', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'card_title' => __( 'SM Mehdi Akram', 'royal-addons-for-elementor' ),
            'card_subtitle' => __( 'CEO', 'royal-addons-for-elementor' ),
            'card_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'royal-addons-for-elementor' ),
          ],
          [
            'card_title' => __( 'Kh Hasanuzzaman', 'royal-addons-for-elementor' ),
            'card_subtitle' => __( 'Director', 'royal-addons-for-elementor' ),
            'card_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'royal-addons-for-elementor' ),
          ],
          [
            'card_title' => __( 'Emam Hossain Prince', 'royal-addons-for-elementor' ),
            'card_subtitle' => __( 'Manager', 'royal-addons-for-elementor' ),
            'card_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'royal-addons-for-elementor' ),
          ],
          [
            'card_title' => __( 'Masud Rana Suman', 'royal-addons-for-elementor' ),
            'card_subtitle' => __( 'Web Designer', 'royal-addons-for-elementor' ),
            'card_description' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'royal-addons-for-elementor' ),
          ],          
        ],
        'title_field' => '{{{ card_title }}}',
      ]
    );



    $this->add_control(
      'btn_icon',
      [
        'label' => __( 'Button Icon', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'separator' => 'before',
        'fa4compatibility' => 'icon',
        'default' => [
          'value' => 'fas fa-bars',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'bars',
            'align-justify',
            'border-all',
          ],
          'fa-regular' => [
            'list-alt',
          ],
        ],
        'skin' => 'inline',
        'label_block' => false,        
      ]
    );
    
    $this->add_control(
      'btn_icon_clicked',
      [
        'label' => __( 'Button Icon (Clicked)', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::ICONS,
        'fa4compatibility' => 'icon_active',
        'default' => [
          'value' => 'fas fa-times',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'times',
            'times-circle',
            'time',
            'random',
          ],
          'fa-regular' => [
            'times-circle',
            'window-close',
          ],
        ],
        'skin' => 'inline',
        'label_block' => false,  
        'condition' => [
        'btn_icon[value]!' => '',
        ],                
      ]
    );

    $this->end_controls_section();




   



    $this->start_controls_section(
      'typography_section',
      [
        'label' => __( 'Team Typography', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );
    
    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'title_typo',
        'label' => __( 'Title', 'royal-addons-for-elementor' ),
        'global' => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
        ],
        'selector' => '{{WRAPPER}} .material-card h2 .main-title',
      ]
    );
    
    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'subtitle_typo',
        'label' => __( 'Sub-Title', 'royal-addons-for-elementor' ),
        'global' => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_SECONDARY,
        ],
        'selector' => '{{WRAPPER}} .material-card h2 .sub-title',
      ]
    );
    
    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'desc_typo',
        'label' => __( 'Description', 'royal-addons-for-elementor' ),
        'global' => [
          'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
        ],
        'selector' => '{{WRAPPER}} .material-card .mc-description',
      ]
    );
    
    $this->end_controls_section();


  }
  



  protected function render() {
    $settings = $this->get_settings_for_display();



        if ( $settings['material_card'] ) {
                echo '<div class="teamrow active-with-click">';
                foreach (  $settings['material_card'] as $item ) { ?>
                    <div class="teamcol elementor-repeater-item-<?php echo $item['_id'] ?>">
                        <article class="material-card <?php echo $item['card_color'] ?>">
                            <h2>
                                <span class="main-title"><?php echo $item['card_title'] ?></span>
                                <span class="sub-title"><?php echo $item['card_subtitle'] ?></span>
                            </h2>
                            <div class="mc-content">
                                <div class="img-container">
                                    <img class="img-responsive" src="<?php echo $item['image']['url'] ?>">
                                </div>
                                <div class="mc-description"><?php echo $item['card_description'] ?></div>
                            </div>
                            <a class="mc-btn-action">
                                <i class="royalicon-bars-solid"></i>
                            </a>
                            <div class="mc-footer">
                                <!-- <h4>Social</h4> -->
                                <?php
                                    $target_fb = $item['link_facebook']['is_external'] ? ' target="_blank"' : '';
                                    $target_tw = $item['link_twitter']['is_external'] ? ' target="_blank"' : '';
                                    $target_in = $item['link_linkedin']['is_external'] ? ' target="_blank"' : '';
                                    $target_insta = $item['link_instagram']['is_external'] ? ' target="_blank"' : '';
                                    $nofollow_fb = $item['link_facebook']['nofollow'] ? ' rel="nofollow"' : '';
                                    $nofollow_tw = $item['link_twitter']['nofollow'] ? ' rel="nofollow"' : '';
                                    $nofollow_in = $item['link_linkedin']['nofollow'] ? ' rel="nofollow"' : '';
                                    $nofollow_insta = $item['link_instagram']['nofollow'] ? ' rel="nofollow"' : '';
                                ?>
                                <a href="<?php echo $item['link_facebook']['url'] ?>" class="wpacmc-social-icon text-center" <?php echo $target_fb . $nofollow_fb ?>>
                                    <i class="royalicon-facebook"></i>
                                </a>
                                <a href="<?php echo $item['link_twitter']['url'] ?>" class="wpacmc-social-icon text-center" <?php echo $target_tw . $nofollow_tw ?>>
                                    <i class="royalicon-twitter"></i>
                                </a>
                                <a href="<?php echo $item['link_linkedin']['url'] ?>" class="wpacmc-social-icon text-center" <?php echo $target_in . $nofollow_in ?>>
                                    <i class="royalicon-linkedin"></i>
                                </a>
                                <a href="<?php echo $item['link_instagram']['url'] ?>" class="wpacmc-social-icon text-center" <?php echo $target_insta . $nofollow_insta ?>>
                                    <i class="royalicon-globe"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php }
                echo '</div>';
        }
        ?>
        <script>
            jQuery(function() {
                jQuery('.material-card').materialCard({
                    icon_close: '<?php echo $settings['btn_icon_clicked']['value'] ?>',
                    icon_open: '<?php echo $settings['btn_icon']['value'] ?>',
                    icon_spin: 'fa-spin-fast',
                    card_activator: 'click'
                });

        //        $('.active-with-click .material-card').materialCard();

                window.setTimeout(function() {
                    jQuery('.material-card:eq(0)').materialCard('open');
                }, 2000);

                jQuery('.material-card').on('shown.material-card show.material-card hide.material-card hidden.material-card', function (event) {
                });

            });
        </script>
        <?php

  }











}