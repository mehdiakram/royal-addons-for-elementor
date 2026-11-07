<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use RoyalAddons\Elementor\Royal_Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalTaxonomyCarousel extends Widget_Base {

    public function get_name() {
        return  'royaltaxonomycarousel';
    }

    public function get_title() {
        return esc_html__( 'Taxonomy Carousel', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-slider-album rtbranding'; }
    
	public function get_keywords() {
		return [ 'slide', 'slider','carousel', 'animated', 'taxonomy', 'tax', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return [ 'royaltech' ];
    }

	public function get_style_depends() {
		$styles = [ 'royalowlcarousel', 'royalowlcarouseltheme' ,'royalcarousel'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalowlcarousel', 'royalcarousel'];
		return $scripts;
	}


    public function register_controls() {
		$this->rt_content_query_options();
		Royal_Helpers::royal_carousel_options( $this );

        $this->rt_style_item_options();
		Royal_Helpers::royal_style_nav_options( $this );
		Royal_Helpers::royal_style_dot_options( $this );
		Royal_Helpers::royal_style_image_options( $this );
        $this->rt_style_title_options();
        $this->rt_style_button_options();

    }


    private function rt_content_query_options() {
        $this->start_controls_section(
            'content_settings',
            [
                'label' => __( 'Carousel Content', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );       


        $this->add_control(
			'royal_control_taxonomy',
			[
				'label' => __( 'Taxonomy', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'category',
				'options' => Royal_Helpers::royal_taxonomies(),
			]
		);
				

        $this->add_control(
			'royaltaxcarouselstyle',
			[
				'label' => __( 'Item Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'royaltaxcarouselstyle1' 	=> 'Style 1',
					'royaltaxcarouselstyle2' 	=> 'Style 2',
				],
				'default' => 'royaltaxcarouselstyle1',
			]
		);


		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title Tag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => Royal_Helpers::royal_title_tags(),
				'default' => 'h3',
			]
		);


        $this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'See All', 'royal-addons-for-elementor' ),
			]
		);

        $this->end_controls_section();
    }

    

    private function rt_style_item_options() {
		$this->start_controls_section(
			'section_style_item',
			[
				'label' => __( 'Item Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'selector' => '{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item',
			]
		);

        $this->add_control(
			'item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],				
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



        $this->start_controls_tabs(
            'item_style_tabs'
        );
        
        $this->start_controls_tab(
            'item_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_background_normal',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'item_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_background_hover',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .royalmastercarousel .owl-carousel .owl-item:hover',
			]
		);
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();
    }



    private function rt_style_title_options() {
        $this->start_controls_section(
            'title_style',
            [
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );       

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .royalmastercarousel .taxtitle',
			]
		);

        $this->start_controls_tabs(
            'title_style_tabs'
        );
        
        $this->start_controls_tab(
            'title_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control(
			'title_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
                'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .taxtitle' => 'color: {{VALUE}};',
				],
			]
		);	

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control(
			'title_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
                'default'	=> '#4C0A0A',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .item:hover .taxtitle' => 'color: {{VALUE}};',
				],
			]
		);	
        
        $this->end_controls_tab();
        $this->end_controls_tabs();


        

        $this->end_controls_section();
    }



    private function rt_style_button_options() {
        $this->start_controls_section(
            'button_style',
            [
                'label' => __( 'Button', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_text!' => '',
                ],
            ]
        );       

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .royalmastercarousel .taxtbtn',
			]
		);


        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
                'label' => __( 'Button Border', 'royal-addons-for-elementor' ),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#bc172f',
                    ],
                ],
				'selector' => '{{WRAPPER}} .royalmastercarousel .taxtbtn',
			]
		);


        $this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .taxtbtn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'button_border_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 7,
					'right' => 17,
					'bottom' => 7,
					'left' => 17,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .taxtbtn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs(
            'button_style_tabs'
        );
        
        $this->start_controls_tab(
            'button_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control(
			'button_color_normal',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
                'default'	=> '#bc172f',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .taxtbtn' => 'color: {{VALUE}};',
				],
			]
		);	

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_background_normal',
				'types' => [ 'classic', 'gradient'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__('Button Background', 'royal-addons-for-elementor'),
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#fff',
                    ],
                ],
				'selector' => '{{WRAPPER}} .royalmastercarousel .taxtbtn',
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_control(
			'button_color_hover',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
                'default'	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .royalmastercarousel .item:hover .taxtbtn' => 'color: {{VALUE}};',
				],
			]
		);	

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'types' => [ 'classic', 'gradient'],
                'fields_options' => [
                    'background' => [
                        'label' => esc_html__('Button Background', 'royal-addons-for-elementor'),
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '#bc172f',
                    ],
                ],
				'selector' => '{{WRAPPER}} .royalmastercarousel .item:hover .taxtbtn',
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();





        $this->end_controls_section();
    }





    protected function render() {
		$settings 		= $this->get_settings_for_display();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $title_tag      = $settings['title_tag'];
        $loop           = $settings['loop'];
        $button_text    = $settings['button_text'];
        $autoplay       = $settings['autoplay'];
        $margin         = $settings['margin'];
        $timeout        = $settings['timeout'];
        $navposition    = $settings['navposition'];
        $dotposition    = $settings['dotposition'];
        $previous_icon_html = '';
        $next_icon_html = '';
        if ( isset( $settings['previousicon']['value'] ) && ! empty( $settings['previousicon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['previousicon'], [ 'aria-hidden' => 'true' ] );
            $previous_icon_html = ob_get_clean();
        }

        if ( isset( $settings['nexticon']['value'] ) && ! empty( $settings['nexticon']['library'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['nexticon'], [ 'aria-hidden' => 'true' ] );
            $next_icon_html = ob_get_clean();
        }
        $navtext = json_encode( [ $previous_icon_html, $next_icon_html ] );

        $desktopitems   = $settings['desktopitems'];
        if ( 'yes' === $settings['desktopdots'] ) {
			$desktopdots = 'true';
		} else{
            $desktopdots = 'false';
        } 
        if ( 'yes' === $settings['desktopnav'] ) {
			$desktopnav = 'true';
		} else{
            $desktopnav = 'false';
        }           


        $tabitems       = $settings['tabitems'];
        if ( 'yes' === $settings['tabdots'] ) {
			$tabdots = 'true';
		} else{
            $tabdots = 'false';
        }
        if ( 'yes' === $settings['tabnav'] ) {
			$tabnav = 'true';
		} else{
            $tabnav = 'false';
        }                     


        $mobileitems    = $settings['mobileitems'];
        if ( 'yes' === $settings['mobiledots'] ) {
			$mobiledots = 'true';
		} else{
            $mobiledots = 'false';
        } 
        if ( 'yes' === $settings['mobilenav'] ) {
			$mobilenav = 'true';
		} else{
            $mobilenav = 'false';
        } 

        $this->add_render_attribute(
            'royal_carousel_options',
            [
                'id'                	=> $carouselid,
                'data-loop'         	=> $loop,
                'data-autoplay'     	=> $autoplay,
                'data-margin'       	=> $margin,
                'data-autoplayTimeout'	=> $timeout,
                'data-navtext'   		=> $navtext,	

                'data-desktopitems' 	=> $desktopitems,
                'data-desktopdots'  	=> $desktopdots,
                'data-desktopnav'   	=> $desktopnav,

                'data-tabitems'     	=> $tabitems,
				'data-tabdots'  		=> $tabdots,
                'data-tabnav'   		=> $tabnav,

                'data-mobileitems'  	=> $mobileitems,
                'data-mobiledots'  		=> $mobiledots,
                'data-mobilenav'   		=> $mobilenav,	
			
            ]
        );
 
        $royaltaxcarouselstyle = $settings['royaltaxcarouselstyle'];
        $taxonomy = $settings['royal_control_taxonomy'];

		echo '<div class="royalmastercarousel royaltaxcarousel '.$royaltaxcarouselstyle.'">';
		echo '<div class="royalcarousel owl-carousel owl-theme '.$navposition.' '.$dotposition.'" '.$this->get_render_attribute_string( 'royal_carousel_options' ).'>';
			
 
        $product_category_terms = get_terms( array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => 1,
        ));

        foreach($product_category_terms as $term){
            $term_link = get_term_link( $term, 'product_cat' );

			$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
            $term_img = wp_get_attachment_url($thumb_id);
           

            if (!empty($term_img)) {
                
            

            echo '<div class="item">';
                echo '<a href="'. $term_link .'">';
                    echo '<img class="taximage" src="' . esc_attr($term_img) . '" alt="" />';
                    echo '<'.$title_tag.' class="taxtitle">'.$term->name.'</'.$title_tag.'>';
                    $this->render_button();
                   
                    
                echo '</a>';
            echo '</div>';
        } 
            //echo $term->name;
            //echo $term->term_id;
            //echo $term_img;
     
        }
		echo '</div>';
		echo '</div>';
    }



    protected function render_button() {
		$settings = $this->get_settings();
		$button_text = $settings['button_text'];

		if ($button_text == '') {
			return;
		}
        echo '<div class="taxtbtn">'. $button_text .'</div>';

	}






}
