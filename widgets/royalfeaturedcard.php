<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalFeaturedCard extends Widget_Base{

  public function get_name(){
    return 'royalfeaturedcard';
  }

  public function get_title(){
    return 'Featured Card';
  }

  public function get_icon() { return 'eicon-price-list rtbranding'; }

  public function get_keywords() {
    return [ 'featured', 'card', 'project', 'service', 'step', 'count', 'number' ];
  }

  public function get_categories(){
    return ['royaltech'];
  }

  public function get_style_depends() {
    $styles = ['royalfeaturedcard'];
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
      'count_text',
      [
        'label' => __( 'Count Number', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => '01',
      ]
    );

    $this->add_control(
      'title',
      [
        'label' => __( 'Title', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __( 'Featured Product', 'royal-addons-for-elementor' ),
      ]
    );
    
    $this->add_control(
      'title_link',
      [
        'label' => __( 'Title Link', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
        'default' => [
          'url' => '',
        ],
      ]
    );

    $this->add_control(
      'description',
      [
        'label' => __( 'Description', 'royal-addons-for-elementor'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => __( 'There are many new variations of available but majority is simple free text or randomized words.', 'royal-addons-for-elementor' ),
      ]
    );

    $this->add_control(
      'show_button',
      [
        'label' => __( 'Show Button', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'button_text',
      [
        'label' => __( 'Button Text', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'READ MORE',
        'condition' => [
          'show_button' => 'yes',
        ],        
      ]
    );

    $this->add_control(
      'button_url',
      [
        'label' => __( 'Button Link', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
        'default' => [
          'url' => '#',
        ],
        'condition' => [
          'show_button' => 'yes',
        ],        
      ]
    );

    $this->end_controls_section();

    // Style Section
    $this->start_controls_section(
      'section_style',
      [
        'label' => __( 'Style', 'royal-addons-for-elementor' ),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'box_bg',
      [
        'label' => __( 'Box Background', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#f9f9f9',
        'selectors' => [
          '{{WRAPPER}} .royal-featured-card' => 'background-color: {{VALUE}}',
        ],
      ]
    );
    
    $this->add_control(
      'box_hover_bg',
      [
        'label' => __( 'Box Hover Background', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
          '{{WRAPPER}} .royal-featured-card:hover' => 'background-color: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'count_color',
      [
        'label' => __( 'Count Color', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#e2e2e2',
        'selectors' => [
          '{{WRAPPER}} .royal-featured-card .count-text' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'title_color',
      [
        'label' => __( 'Title Color', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#222222',
        'selectors' => [
          '{{WRAPPER}} .royal-featured-card .title' => 'color: {{VALUE}}',
          '{{WRAPPER}} .royal-featured-card .title a' => 'color: {{VALUE}}',
        ],
      ]
    );
    
    $this->add_control(
      'title_hover_color',
      [
        'label' => __( 'Title Hover Color', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ff5e14',
        'selectors' => [
          '{{WRAPPER}} .royal-featured-card .title a:hover' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'desc_color',
      [
        'label' => __( 'Description Color', 'royal-addons-for-elementor' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#777777',
        'selectors' => [
          '{{WRAPPER}} .royal-featured-card .description' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();
  }

  protected function render() {
    $settings = $this->get_settings_for_display();
    
    $target = $settings['title_link']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $settings['title_link']['nofollow'] ? ' rel="nofollow"' : '';
    $link = !empty($settings['title_link']['url']) ? $settings['title_link']['url'] : '';

    $btn_target = $settings['button_url']['is_external'] ? ' target="_blank"' : '';
    $btn_nofollow = $settings['button_url']['nofollow'] ? ' rel="nofollow"' : '';
    $btn_link = !empty($settings['button_url']['url']) ? $settings['button_url']['url'] : '';
    
    ?>
    <div class="royal-featured-card">
        <div class="inner-block">
            <?php if ( ! empty( $settings['count_text'] ) ) : ?>
            <div class="count-block">
                <div class="count-text"><?php echo esc_html( $settings['count_text'] ); ?></div>
            </div>
            <?php endif; ?>
            
            <div class="text-block">
                <?php if ( ! empty( $settings['title'] ) ) : ?>
                    <h3 class="title">
                        <?php if($link) : ?><a href="<?php echo esc_url($link); ?>" <?php echo $target.$nofollow; ?>><?php endif; ?>
                            <?php echo wp_kses_post( $settings['title'] ); ?>
                        <?php if($link) : ?></a><?php endif; ?>
                    </h3>
                <?php endif; ?>
                
                <?php if ( ! empty( $settings['description'] ) ) : ?>
                    <p class="description"><?php echo wp_kses_post( $settings['description'] ); ?></p>
                <?php endif; ?>
                
                <?php if ( 'yes' === $settings['show_button'] && ! empty( $settings['button_text'] ) ) : ?>
                    <a href="<?php echo esc_url($btn_link); ?>" class="read-more" <?php echo $btn_target.$btn_nofollow; ?>>
                        <?php echo esc_html( $settings['button_text'] ); ?>
                        <i class="fa fa-long-arrow-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
  }
}
