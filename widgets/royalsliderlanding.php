<?php
namespace RoyalAddons\Widgets;

use  Elementor\Widget_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Css_Filter ;
use  Elementor\Group_Control_Text_Stroke ;
use  Elementor\Repeater;
use RoyalAddons\Elementor\Royal_Helpers;

if ( !defined( 'ABSPATH' ) ) {exit;}// Exit if accessed directly

class RoyalSliderLanding extends Widget_Base{

    public function get_name(){
        return 'royalsliderlanding';
    }
    
    public function get_title(){
        return 'Landing Slider';
    }
    
    public function get_icon() { return 'royalsliderlanding rtbranding'; }
    
    public function get_categories(){
        return [ 'royaltech' ];
    }
    
    public function get_keywords(){
		return [ 'landing', 'slider', 'carousel', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }
    
	public function get_style_depends() {
		$styles = ['royalsliderlanding'];
		return $styles;
	}
	
	public function get_script_depends() {
		$scripts = ['royalsliderlanding'];
		return $scripts;
	}	
	
    protected function register_controls(){
        $this->start_controls_section( 'section_content_layout', [
            'label' => esc_html__( 'Layout', 'royal-addons-for-elementor' ),
        ] );
		
        $this->add_responsive_control(
			'slider_height',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Slider Height', 'royal-addons-for-elementor' ),
                'size_units' => [ 'vh', 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
                    'em' => [
						'min' => 1,
						'max' => 50,
					],
                    'rem' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'vh',
					'size' => 80,
				],
				'selectors' => [
					'{{WRAPPER}} .royallandingslider' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control( 'show_title', [
            'label'     => esc_html__( 'Show Title', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
        ] );

        $this->add_control( 'show_sub_title', [
            'label'   => esc_html__( 'Show Sub Title', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control( 'show_button_text', [
            'label'   => esc_html__( 'Show Button', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control( 'show_excerpt', [
            'label'   => esc_html__( 'Show Excerpt', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );

        $this->add_control( 'title_html_tag', [
            'label'     => __( 'Title HTML Tag', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'h2',
			'options'   => Royal_Helpers::royal_title_tags(),
            'condition' => [
            'show_title' => 'yes',
			],
        ] );

		$this->add_control( 'sub_title_html_tag', [
            'label'     => __( 'Sub Title HTML Tag', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'h4',
			'options'   => Royal_Helpers::royal_title_tags(),
            'condition' => [
            'show_sub_title' => 'yes',
        ],
        ] );

        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'      => 'thumbnail_size',
            'label'     => esc_html__( 'Image Size', 'royal-addons-for-elementor' ),
            'exclude'   => [ 'custom' ],
            'default'   => 'full',
            'separator' => 'before',
        ] );

        $this->end_controls_section();


        $this->start_controls_section( 'section_content_sliders', [
            'label' => esc_html__( 'Sliders', 'royal-addons-for-elementor' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'sub_title', [
            'label'       => esc_html__( 'Sub Title', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'title', [
            'label'       => esc_html__( 'Title', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'title_link', [
            'label'         => esc_html__( 'Title Link', 'royal-addons-for-elementor' ) ,
            'type'          => Controls_Manager::URL,
            'default'       => [
            'url' => '',
        ],
            'show_external' => false,
            'dynamic'       => [
            'active' => true,
        ],
            'condition'     => [
            'title!' => '',
        ],
        ] );
        $repeater->add_control( 'slide_button_text', [
            'label'       => esc_html__( 'Button Text', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Details', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'button_link', [
            'label'     => esc_html__( 'Button Link', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::URL,
            'default'   => [
            'url' => '',
        ],
            'dynamic'   => [
            'active' => true,
        ],
            'condition' => [
            'title!' => '',
        ],
        ] );
        $repeater->add_control( 'excerpt', [
            'label'       => esc_html__( 'Excerpt', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::WYSIWYG,
            'default'     => esc_html__( 'Welcome to our learning development platform at Royal Technologies.', 'royal-addons-for-elementor' ),
            'label_block' => true,
            'dynamic'     => [
            'active' => true,
        ],
        ] );
        $repeater->add_control( 'image', [
            'label'   => esc_html__( 'Image', 'royal-addons-for-elementor' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			],
            'dynamic' => [
            'active' => true,
        ],
        ] );
        $this->add_control( 'slides', [
            'label'       => esc_html__( 'Slider Items', 'royal-addons-for-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [ [
            'sub_title' => esc_html__( 'Royal Addons For Elementor', 'royal-addons-for-elementor' ),
            'title'     => esc_html__( 'Landing Slider', 'royal-addons-for-elementor' ),
        ], [
            'sub_title' => esc_html__( 'Discover your Talents', 'royal-addons-for-elementor' ),
            'title'     => esc_html__( 'Nice Animation Slider', 'royal-addons-for-elementor' ),
        ], [
            'sub_title' => esc_html__( 'Free Addons', 'royal-addons-for-elementor' ),
            'title'     => esc_html__( 'For your Elementor', 'royal-addons-for-elementor' ),
        ] ],
            'title_field' => '{{{ title }}}',
        ] );
        $this->end_controls_section();

        
        $this->start_controls_section( 'section_content_animation', [
            'label' => esc_html__( 'Slider Settings', 'royal-addons-for-elementor' ),
        ] );

        $this->add_control( 'animation_time', [
            'label'     => esc_html__( 'Animation Time (ms)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 3000,
        ] );

        $this->add_control( 'autoplay_interval', [
            'label'     => esc_html__( 'Autoplay Interval (ms)', 'royal-addons-for-elementor' ),
            'type'      => Controls_Manager::NUMBER,
            'default'   => 7000,
        ] );

        $this->end_controls_section();
        
        

        //Style Start
        $this->start_controls_section( 'sub_title_style', [
            'label'     => esc_html__( 'Sub Title', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_sub_title' => [ 'yes' ],
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'sub_title_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royallandingslider .list .item .subtitle',
        ] );

        $this->add_control( 'sub_title_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .list .item .subtitle' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();


        $this->start_controls_section( 'title_style', [
            'label'     => esc_html__( 'Title Style', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_title' => [ 'yes' ],
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'title_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royallandingslider .list .item .title',
        ] );

        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .list .item .title' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();


        $this->start_controls_section( 'excerpt_style', [
            'label'     => esc_html__( 'Excerpt', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_excerpt' => [ 'yes' ],
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'excerpt_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royallandingslider .list .item .excerpt',
        ] );

        $this->add_control( 'excerpt_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .list .item .excerpt' => 'color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();


        $this->start_controls_section( 'button_style', [
            'label' => esc_html__( 'Button', 'royal-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_button_text' => [ 'yes' ],
            ],
        ] );
      
        $this->add_responsive_control( 'button_padding', [
            'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royallandingslider .list .item button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'button_margin', [
            'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .royallandingslider .list .item button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'button_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royallandingslider .list .item button',
        ] );

        $this->add_control( 'button_color', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .list .item button' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .royallandingslider .list .item button',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'buttonborder',
				'selector' => '{{WRAPPER}} .royallandingslider .list .item button',
			]
		);
        
        $this->add_control(
			'buttonradius',
			[
				'label' => __( 'Button Radius', 'rroyal-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', 'em', '%' ],			
				'selectors' => [
					'{{WRAPPER}} .royallandingslider .list .item button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		); 
		$this->end_controls_section();


        $this->start_controls_section( 'navigation_style', [
            'label'     => esc_html__( 'Navigation', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control(
			'nexticon',
			[
				'label' => esc_html__( 'Next Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'skin' 				=> 'inline',
				'label_block' 		=> false,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'caret-right',
						'angle-right',
						'fa-angle-double-right',
						'fa-angle-chevron-right',
					],
				],
			]
		);

        $this->add_control(
			'previcon',
			[
				'label' => esc_html__( 'Previous Icon', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'skin' 				=> 'inline',
				'label_block' 		=> false,
				'default' => [
					'value' => 'fas fa-chevron-left',
					'library' => 'fa-solid',
				],
				'recommended' => [
					'fa-solid' => [
						'caret-left',
						'angle-left',
						'fa-angle-double-left',
						'fa-chevron-left',
					],
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'navigationborder',
				'selector' => '{{WRAPPER}} .royallandingslider .arrows button',
			]
		);
        
        $this->add_control(
			'navigationradius',
			[
				'label' => __( 'Navigation Radius', 'rroyal-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', 'em', '%' ],			
				'selectors' => [
					'{{WRAPPER}} .royallandingslider .arrows button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		); 

        $this->start_controls_tabs(
            'navigation_style_tabs'
        );
        
        $this->start_controls_tab(
            'navigation_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control( 'navigation_color_normal', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .arrows button' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'navigation_background_color_normal', [
            'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'default'   => '#eee4',
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .arrows button' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'navigation_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control( 'navigation_color_hover', [
            'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'default'   => '#000',
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .arrows button:hover' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'navigation_background_color_hover', [
            'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .royallandingslider .arrows button:hover' => 'background-color: {{VALUE}};',
            ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section( 'thumbnail_style', [
            'label'     => esc_html__( 'Thumbnail', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control(
			'thumbnail_height',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Thumbnail Height', 'royal-addons-for-elementor' ),
                'size_units' => ['px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 220,
				],
				'selectors' => [
					'{{WRAPPER}} .royallandingslider .thumbnail .item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'thumbnail_width',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Thumbnail Width', 'royal-addons-for-elementor' ),
                'size_units' => ['px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .royallandingslider .thumbnail .item' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'thumbnailborder',
				'selector' => '{{WRAPPER}} .royallandingslider .thumbnail .item img',
			]
		);
        
        $this->add_control(
			'borderradius',
			[
				'label' => __( 'Border Radius', 'rroyal-addons-for-elementor' ),
				'type' => 'dimensions',
				'size_units' => [ 'px', 'em', '%' ],			
				'selectors' => [
					'{{WRAPPER}} .royallandingslider .thumbnail .item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);        

        $this->end_controls_section();




	}

 


    
    public function render_item_content( $slide_content ){
        $settings = $this->get_settings_for_display();
        ?>
        <div class="content">
            <?php if ( $slide_content['sub_title'] && 'yes' == $settings['show_sub_title'] ) {
            ?>
			<<?php echo wp_kses_post( $settings['sub_title_html_tag'] ); ?> class="subtitle"><?php echo wp_kses_post( $slide_content['sub_title'] ); ?></<?php 
            echo wp_kses_post( $settings['sub_title_html_tag'] ); ?>>
			<?php } ?>

            <?php 
            if ( $slide_content['title'] && 'yes' == $settings['show_title'] ) {
                ?>
                <<?php echo wp_kses_post( $settings['title_html_tag'] ); ?> class="title"><?php if ( '' !== $slide_content['title_link']['url'] ) { ?>
                    <a href="<?php echo esc_url( $slide_content['title_link']['url'] ); ?>"><?php } ?>
                    <?php echo $slide_content['title'] ; ?>
                    <?php if ( '' !== $slide_content['title_link']['url'] ) { ?></a><?php } ?>
                </<?php echo wp_kses_post( $settings['title_html_tag'] ); ?>>
            <?php } ?>

            <?php if ( $slide_content['excerpt'] && 'yes' == $settings['show_excerpt'] ) { ?>
            <div class="excerpt"><?php echo wp_kses_post( $slide_content['excerpt'] ); ?></div>
			<?php } ?>

            <?php if ( $slide_content['slide_button_text'] && 'yes' == $settings['show_button_text'] ) { ?>
                <button>
                <?php if ( '' !== $slide_content['button_link']['url'] ) { ?>
                    <a href="<?php echo esc_url( $slide_content['button_link']['url'] ); ?>"><?php } ?>
                    <?php echo $slide_content['slide_button_text'] ; ?>
                    <?php if ( '' !== $slide_content['button_link']['url'] ) { ?></a><?php } ?>
                </button>
            <?php } ?>
        </div>
        <?php 
    }
    
	
	
    public function render_slides_loop(){
        $settings = $this->get_settings_for_display();
        echo '<div class="list">';
        foreach ( $settings['slides'] as $slide ) {
            ?>
            <div class="item">
                <?php 
                $this->rendar_item_image( $slide, $slide['title'] );
                $this->render_item_content( $slide );
                ?>
	       </div>
        <?php 
        }
        echo '</div>';
    }
    

    public function render_thumbnail() {
        $settings = $this->get_settings_for_display();
        echo '<div class="thumbnail">';
        foreach ( $settings['slides'] as $slide ) {
            $title = isset( $slide['title'] ) ? $slide['title'] : '';
            $image_url = isset( $slide['image']['url'] ) ? esc_url( $slide['image']['url'] ) : '';
            ?>
            <div class="item">
                <a href="<?php echo esc_url( $slide['link'] ?? '#' ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
                    <img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr( $title ); ?>" />
                </a>
                <div style="display:none;" class="content">
                    <div class="title"><?php echo esc_html( $title ); ?></div>
                    <div class="description"><?php echo esc_html( $slide['description'] ?? '' ); ?></div>
                </div>
            </div>
            <?php 
        }
        echo '</div>';
    }





    public function rendar_item_image( $item, $alt = '' ){
        $settings = $this->get_settings_for_display();
        $image_src = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail_size', $settings );
        
        if ( $image_src ) {
            $image_final_src = $image_src;
        } elseif ( $item['image']['url'] ) {
            $image_final_src = $item['image']['url'];
        } else {
            return;
        }
        
        ?>
        <img src="<?php echo esc_url( $image_final_src ); ?>" alt="">
		<?php 
    }



    public function render(){
    $settings   = $this->get_settings_for_display();
    $id         = $this->get_id();
    $sliderid   = 'royallandingslider'.$id;
    $prev       = 'prev'.$id;
    $next       = 'next'.$id;
    $running    = $settings['animation_time'];
    $interval   = $settings['autoplay_interval'];

    $this->add_render_attribute(
        'options',
        [
            'id'             	=> $sliderid,
            'data-running'		=> $running,
            'data-interval'		=> $interval,
            'data-prev'		    => $prev,
            'data-next'		    => $next,
        ]
    );

    ?>
    <div class="royallandingslider" <?php echo $this->get_render_attribute_string( 'options' ) ?>> <?php
        $this->render_slides_loop();
        $this->render_thumbnail();
    ?>
        <div class="arrows">
            <button class="slider-prev"><?php \Elementor\Icons_Manager::render_icon( $settings['previcon'], [ 'aria-hidden' => 'true' ] ); ?></button>
            <button class="slider-next"><?php \Elementor\Icons_Manager::render_icon( $settings['nexticon'], [ 'aria-hidden' => 'true' ] ); ?></button>
        </div>
    </div>
    <?php    
    }


}