<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use  Elementor\Group_Control_Typography ;

defined('ABSPATH') || die();

class RoyalWeatherMap extends Widget_Base {
	public function get_name() {
		return 'royalweathermap';
	}


	public function get_title() {
		return __('Weather Map', 'royal-addons-for-elementor');
	}


	public function get_icon() { return 'eicon-light-mode rtbranding'; }


	public function get_keywords() {
		return ['weather', 'map', 'open', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	
    public function get_categories() {
        return [ 'royal-addons-for-elementor' ];
    }

	public function get_style_depends() {
		$styles = ['royalweathermap'];
		return $styles;
	}
	
	public function get_script_depends() {
		$scripts = ['royalweathermap'];
		return $scripts;
	}	

	protected function register_controls() {
		$this->ads_content_controls();
	}


	protected function ads_content_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => __('General', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
 
		$this->add_control(
			'openweathermap_id',
			[
				'label' => __( 'Open Weather Map ID', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '9505fd1df737e20152fbd78cdb289b6a',
			]
		);

		$this->add_control(
			'defaultcity',
			[
				'label' => __( 'Default City', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Dhaka',
			]
		);

		$this->end_controls_section();


        //Style Start
        $this->start_controls_section( 'style', [
            'label'     => esc_html__( 'Style', 'royal-addons-for-elementor' ),
            'tab'       => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'sub_title_typography',
            'label'     => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
            'selector'  => '{{WRAPPER}} .royallandingslider .list .item .subtitle',
        ] );

        $this->add_control( 'clouds_bg_color', [
            'label'     => esc_html__( 'Clouds Background Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
			'default' => '#f78a55',
            'selectors' => [
                '{{WRAPPER}} .royalweathermap li:nth-child(1)' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'humidity_bg_color', [
            'label'     => esc_html__( 'Humidity Background Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
			'default' => '#b56291',
            'selectors' => [
                '{{WRAPPER}} .royalweathermap li:nth-child(2)' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'pressure_bg_color', [
            'label'     => esc_html__( 'Pressure Background Color', 'royal-addons-for-elementor' ) ,
            'type'      => Controls_Manager::COLOR,
			'default' => '#48567b',
            'selectors' => [
                '{{WRAPPER}} .royalweathermap li:nth-child(3)' => 'background-color: {{VALUE}};',
            ],
        ] );		
        $this->end_controls_section();






	}



    protected function render() {
        $settings 			= $this->get_settings_for_display();
		$id         		= $this->get_id();
		$royalweathermapname 		= 'royalweathermapname'.$id;
		$royalweathermapclouds 		= 'royalweathermapclouds'.$id;
		$royalweathermaphumidity 	= 'royalweathermaphumidity'.$id;
		$royalweathermappressure 	= 'royalweathermappressure'.$id;
		$royalweathermapdescription = 'royalweathermapdescription'.$id;
		$royalweathermaptemperature = 'royalweathermaptemperature'.$id;
		$royalweathermapcityname 	= 'royalweathermapcityname'.$id;
		$royalweathermapform 		= 'royalweathermapform'.$id;
		$mapid     			= 'royalweathermap'.$id;
        $openweathermap_id 	= $settings['openweathermap_id'];
        $defaultcity       	= $settings['defaultcity'];
		$this->add_render_attribute(
            'options',
            [
                'id'             			=> $mapid,
                'data-openweathermapid'		=> $openweathermap_id,
                'data-city'     			=> $defaultcity,	
                'data-name'     			=> $royalweathermapname,	
                'data-clouds'     			=> $royalweathermapclouds,	
                'data-humidity'     		=> $royalweathermaphumidity,	
                'data-pressure'     		=> $royalweathermappressure,
                'data-description'     		=> $royalweathermapdescription,
                'data-temperature'     		=> $royalweathermaptemperature,
                'data-cityname'     		=> $royalweathermapcityname,
                'data-form'     			=> $royalweathermapform,
            ]
        );


        ?>
		<div class="royalweathermap" <?php echo $this->get_render_attribute_string( 'options' ) ?>>
			<form id="<?php echo $royalweathermapform ?>">
				<input type="text" aria-label="Search weather location" id="<?php echo $royalweathermapname ?>" autocomplete="off">
				<button aria-label="Submit search"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6 .1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg></button>
			</form>
			<section class="result">
				<figure class="name" id="<?php echo $royalweathermapcityname ?>">
					<figcaption>Dhaka</figcaption> 
					<img src="https://flagsapi.com/BD/shiny/32.png">
				</figure>

				<figure class="temperature" id="<?php echo $royalweathermaptemperature ?>">
					<img src="https://openweathermap.org/img/wn/10d@4x.png">
					<figcaption>
						<span>31</span>
						<sup>o</sup>
					</figcaption> 
				</figure>
				<p class="description" id="<?php echo $royalweathermapdescription ?>">haze</p>
				<ul>
					<li>
						<span><?php echo esc_html__( 'clouds', 'royal-addons-for-elementor' ) ?></span>
						<span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M537.6 226.6c4.1-10.7 6.4-22.4 6.4-34.6 0-53-43-96-96-96-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32c-88.4 0-160 71.6-160 160 0 2.7 .1 5.4 .2 8.1C40.2 219.8 0 273.2 0 336c0 79.5 64.5 144 144 144h368c70.7 0 128-57.3 128-128 0-61.9-44-113.6-102.4-125.4z"/></svg></span>
						<span><span id="<?php echo $royalweathermapclouds ?>">98</span>%</span>
					</li>
					<li>
						<span><?php echo esc_html__( 'humidity', 'royal-addons-for-elementor' ) ?></span>
						<span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path d="M205.2 22.1c-7.9-28.8-49.4-30.1-58.4 0C100 179.9 0 222.7 0 333.9 0 432.4 78.7 512 176 512s176-79.7 176-178.1c0-111.8-99.8-153.3-146.8-311.8zM176 448c-61.8 0-112-50.3-112-112 0-8.8 7.2-16 16-16s16 7.2 16 16c0 44.1 35.9 80 80 80 8.8 0 16 7.2 16 16s-7.2 16-16 16z"/></svg></span>
						<span><span id="<?php echo $royalweathermaphumidity ?>">98</span>%</span>
					</li>
					<li>
						<span><?php echo esc_html__( 'pressure', 'royal-addons-for-elementor' ) ?></span>
						<span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M156.7 256H16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h142.2c15.9 0 30.8 10.9 33.4 26.6 3.3 20-12.1 37.4-31.6 37.4-14.1 0-26.1-9.2-30.4-21.9-2.1-6.3-8.6-10.1-15.2-10.1H81.6c-9.8 0-17.7 8.8-15.9 18.4 8.6 44.1 47.6 77.6 94.2 77.6 57.1 0 102.7-50.1 95.2-108.6C249 291 205.4 256 156.7 256zM16 224h336c59.7 0 106.8-54.8 93.8-116.7-7.6-36.2-36.9-65.5-73.1-73.1-55.4-11.6-105.1 24.9-114.9 75.5-1.9 9.6 6.1 18.3 15.8 18.3h32.8c6.7 0 13.1-3.8 15.2-10.1C325.9 105.2 337.9 96 352 96c19.4 0 34.9 17.4 31.6 37.4-2.6 15.7-17.4 26.6-33.4 26.6H16c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16zm384 32H243.7c19.3 16.6 33.2 38.8 39.8 64H400c26.5 0 48 21.5 48 48s-21.5 48-48 48c-17.9 0-33.3-9.9-41.6-24.4-2.9-5-8.7-7.6-14.5-7.6h-33.8c-10.9 0-19 10.8-15.3 21.1 17.8 50.6 70.5 84.8 129.4 72.3 41.2-8.7 75.1-41.6 84.7-82.7C526 321.5 470.5 256 400 256z"/></svg></span>
						<span><span id="<?php echo $royalweathermappressure ?>">1011</span>hPa</span>
					</li>
				</ul>
			</section>
		</div>
        <?php
    }

}
