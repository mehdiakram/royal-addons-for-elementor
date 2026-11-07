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
use RoyalAddons\Elementor\Royal_Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalVideo extends Widget_Base {

    public function get_name() {
        return 'royalvideo';
    }


    public function get_title() {
        return esc_html__( 'Video Carousel', 'royal-addons-for-elementor' );
    }


    public function get_icon() { return 'eicon-youtube rtbranding'; }
    

	public function get_keywords() {
		return [ 'slide', 'carousel', 'animated', 'video', 'youtube', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
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
		Royal_Helpers::royal_style_nav_options( $this );
		Royal_Helpers::royal_style_dot_options( $this );

    }

    private function rt_content_query_options() {
        // Content Settings
        $this->start_controls_section(
            'content_settings',
            [
                'label' => __( 'Carousel Content', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );       

        $this->add_control(
            'videostyle',
            [
                'label' => __( 'Video Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'carousel' 	=> 'Carousel',
                    'grid'      => 'Grid',
                ],
                'default' => 'carousel',
            ]
        );
        
        
        $this->add_control(
            'videosource',
            [
                'label' => __( 'Video Source', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'manually' 	=> 'Manually',
                ],
                'default' => 'manually',
            ]
        );


        // Slider Repeater
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'video_link',
            [
                'label' => __( 'Video Link', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'https://www.youtube.com/watch?v=5dRaZ9C6lII', 'royal-addons-for-elementor' ),
                'label_block' => true
            ]
        );

        $this->add_control(
            'slider',
            [
                'label' => __( 'Video Link', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'video_link' => __( 'https://www.youtube.com/watch?v=5dRaZ9C6lII', 'royal-addons-for-elementor' ),
                    ],
                ],
                'title_field' => '{{{ video_link }}}',
            ]
        );
           
        $this->end_controls_section();
    }



    protected function render() {
		$settings 		= $this->get_settings_for_display();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $loop           = $settings['loop'];
        $autoplay       = $settings['autoplay'];
        $video          = true;
        $lazyLoad       = true;
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
                'data-video'     	    => $video,
                'data-lazyLoad'     	=> $lazyLoad,
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
 
        if('carousel'== $settings['videostyle']){
            echo '<div class="royalmastercarousel">';
            echo '<div class="royalcarousel royalvideocarousel owl-carousel owl-theme '.$navposition.' '.$dotposition.'" '.$this->get_render_attribute_string( 'royal_carousel_options' ).'>';
                foreach( $settings[ 'slider' ] as $slide ):
                   echo '<div class="item-video"><a class="owl-video" href="' . esc_attr($slide['video_link'] ) . '"></a></div>';   
                endforeach;   
            echo '</div>';
            echo '</div>';

        } elseif('grid'== $settings['videostyle']){
            echo '<div class="royalmasterflex">';
                foreach( $settings[ 'slider' ] as $slide ):
                    echo '<div class="responsivevideo"><iframe src="' . esc_attr($slide['video_link'] ) . '"></iframe></div>';  
                endforeach;   
            echo '</div>';            

        } else {

            
        }

    }


    protected function content_template() {
        
    }

}
