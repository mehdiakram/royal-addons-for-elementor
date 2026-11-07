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


class RoyalImageCarousel extends Widget_Base {

    public function get_name() {
        return  'royalimagecarousel';
    }

    public function get_title() {
        return esc_html__( 'Image Carousel', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-slider-album rtbranding'; }
    
	public function get_keywords() {
		return [ 'slide', 'slider','carousel', 'animated', 'image', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return [ 'royaltech' ];
    }

	public function get_style_depends() {
		$styles = [ 'royalowlcarousel', 'royalowlcarouseltheme' ,'royalcarousel'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['royalowlcarousel','royalcarousel'];
		return $scripts;
	}


    public function register_controls() {
		Royal_Helpers::royal_image_options( $this );
		Royal_Helpers::royal_carousel_options( $this );
		Royal_Helpers::royal_style_nav_options( $this );
		Royal_Helpers::royal_style_dot_options( $this );
		Royal_Helpers::royal_style_image_options( $this );
    }


    protected function render() {
		$settings 		= $this->get_settings_for_display();
        $id         	= $this->get_id();
        $carouselid     = 'royalcarousel'.$id;
        $loop           = $settings['loop'];
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
 
 		if ( empty( $settings['carousel'] ) ) {
			return;
		} 
 
		echo '<div class="royalmastercarousel">';
		echo '<div class="royalcarousel owl-carousel owl-theme '.$navposition.' '.$dotposition.'" '.$this->get_render_attribute_string( 'royal_carousel_options' ).'>';
			
			foreach ( $settings['carousel'] as $index => $attachment ) {
				$image_url = Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );
				if ( ! $image_url && isset( $attachment['url'] ) ) {
					$image_url = $attachment['url'];
				}
				
				
				echo '<img class="item" src="' . esc_attr($image_url) . '" alt="" />';
			} 

		echo '</div>';
		echo '</div>';
    }

}
