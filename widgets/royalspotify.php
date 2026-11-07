<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class RoyalSpotify extends Widget_Base {
	public function get_name() {
		return 'royalspotify';
	}


	public function get_title() {
		return __('Spotify', 'royal-addons-for-elementor');
	}


	public function get_icon() { return 'eicon-animated-headline rtbranding'; }


	public function get_keywords() {
		return ['spotify', 'music', 'song', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	
    public function get_categories() {
        return [ 'royaltech' ];
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
			'spotify_link',
			[
				'label' => __( 'Spotify <bold> Embed </bold> Link', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => 'https://open.spotify.com/embed/track/4xHWH1jwV5j4mBYRhxPbwZ',
				'placeholder' => __( 'Spotify Link Here', 'royal-addons-for-elementor'),
			]
		);     
		

		$this->add_control(
			'spotify_height',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 80,
				'max' => 1400,
				'step' => 10,
				'default' => 380,
			]
		);

		$this->end_controls_section();
	}



    protected function render() {
        $settings = $this->get_settings_for_display();
	    $spotify_height = $settings['spotify_height'];
        ?>
            <iframe src="<?php echo esc_url($settings['spotify_link']); ?>" width="100%" height="<?php echo esc_html__($spotify_height)?>" frameBorder="0" allowtransparency="true" allow="encrypted-media"></iframe>
        <?php
    }

}
