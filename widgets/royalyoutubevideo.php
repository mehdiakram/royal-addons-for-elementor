<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalYouTubeVideo extends Widget_Base {

    public function get_name() {
        return 'royalyoutubevideo';
    }

    public function get_title() {
        return __('YouTube Video', 'royal-addons-for-elementor');
    }

    public function get_icon() { return 'eicon-youtube rtbranding'; }

    public function get_keywords() {
        return [ 'youtube', 'video', 'popup', 'embed', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

    public function get_categories() {
        return ['royaltech'];
    }

    public function get_script_depends() {
        return [ 'magnific-popup', 'royalyoutubevideo' ];
    }

    public function register_controls() {

        $this->start_controls_section('content_section', [
            'label' => __('Content', 'royal-addons-for-elementor'),
        ]);

        $this->add_control('video_url', [
            'label' => __('YouTube URL', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __('https://www.youtube.com/watch?v=VIDEO_ID', 'royal-addons-for-elementor'),
        ]);

        $this->add_control('start_time', [
            'label' => __('Start Time (seconds)', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'min' => 0,
            'default' => 0,
        ]);

        $this->add_control('thumbnail_quality', [
            'label' => __('Thumbnail Quality', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'hqdefault',
            'options' => [
                'default'        => __('Default (120x90)', 'royal-addons-for-elementor'),
                'mqdefault'      => __('Medium (320x180)', 'royal-addons-for-elementor'),
                'hqdefault'      => __('High (480x360)', 'royal-addons-for-elementor'),
                'sddefault'      => __('Standard (640x480)', 'royal-addons-for-elementor'),
                'maxresdefault'  => __('Max Res (1280x720)', 'royal-addons-for-elementor'),
                'custom'         => __('Custom Upload', 'royal-addons-for-elementor'),
            ],
        ]);

        $this->add_control('custom_thumbnail', [
            'label' => __('Custom Thumbnail Image', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [],
            'condition' => [
                'thumbnail_quality' => 'custom',
            ],
        ]);

        $this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .royalyoutubevideo .youtubethumbnail' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);



        $this->add_control('lazy_load', [
            'label' => __('Lazy Load', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('enable_popup', [
            'label' => __('Enable Popup', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->add_control('link_target', [
            'label' => __('Link Target', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => '_blank',
            'options' => [
                '_self' => __('Same Tab', 'royal-addons-for-elementor'),
                '_blank' => __('New Tab', 'royal-addons-for-elementor'),
            ],
            'condition' => [
                'enable_popup!' => 'yes',
            ],
        ]);

        $this->add_control('popup_autoplay', [
            'label' => __('Autoplay', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'enable_popup' => 'yes',
            ],
        ]);

        $this->add_control('popup_mute', [
            'label' => __('Mute Video', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
                'enable_popup' => 'yes',
            ],
        ]);

        $this->add_control('overlay_button_type', [
            'label' => __('Overlay Play Button', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => __('Default', 'royal-addons-for-elementor'),
                'custom' => __('Custom Upload', 'royal-addons-for-elementor'),
            ],
        ]);

        $this->add_control('custom_overlay_icon', [
            'label' => __('Custom Overlay Image', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [],
            'condition' => [
                'overlay_button_type' => 'custom',
            ],
        ]);

        $this->end_controls_section();
    }

    private function get_youtube_id($url) {
        preg_match("%(?:youtube(?:-nocookie)?\.com/(?:[^/\n\s]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^#&?\n\s]*)%", $url, $matches);
        return $matches[1] ?? '';
    }

    public function render() {
        $settings = $this->get_settings_for_display();
        $video_id = $this->get_youtube_id($settings['video_url']);
        if (!$video_id) return;

        if ($settings['thumbnail_quality'] === 'custom' && !empty($settings['custom_thumbnail']['url'])) {
            $thumbnail = esc_url($settings['custom_thumbnail']['url']);
        } else {
            $thumbnail = "https://img.youtube.com/vi/{$video_id}/{$settings['thumbnail_quality']}.jpg";
        }

        $autoplay   = $settings['popup_autoplay'] === 'yes' ? '1' : '0';
        $mute       = $settings['popup_mute'] === 'yes' ? '1' : '0';
        $start      = $settings['start_time'] ? '&start=' . intval($settings['start_time']) : '';
        $lazy       = $settings['lazy_load'] === 'yes';
        $popup      = $settings['enable_popup'] === 'yes';
        $target     = $popup ? '' : ' target="' . esc_attr($settings['link_target']) . '"';
        $embed_url  = "https://www.youtube.com/embed/{$video_id}?autoplay={$autoplay}&mute={$mute}{$start}";
        $link_url   = $popup ? $embed_url : "https://www.youtube.com/watch?v={$video_id}{$start}";
        $wrapper_id = 'royalvideo-' . esc_attr($this->get_id());
        $popupclass = $popup ? 'royalisotope' : '';

        echo '<div class="' . $popupclass . ' royalyoutubevideo" id="' . $wrapper_id . '">
            <div class="royalpopup-gallery" style="position:relative;display:inline-block;cursor:pointer;width:100%;">
                <a href="' . esc_url($link_url) . '" class="' . ($popup ? 'royalvideo-popup' : '') . '"' . $target . ' aria-label="Watch video">
                    <img class="youtubethumbnail" src="' . esc_url($thumbnail) . '" ' . ($lazy ? 'loading="lazy"' : '') . ' alt="" style="width:100%;object-fit: cover;display:block;" />';

        if ($settings['overlay_button_type'] === 'default' || ($settings['overlay_button_type'] === 'custom' && empty($settings['custom_overlay_icon']['url']))) {
            echo '<span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:68px;height:64px;display:flex;justify-content:center;align-items:center;">
                <svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%">
                    <path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f03"></path>
                    <path d="M 45,24 27,14 27,34" fill="#fff"></path>
                </svg>
            </span>';
        } elseif ($settings['overlay_button_type'] === 'custom' && !empty($settings['custom_overlay_icon']['url'])) {
            echo '<span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
                <img src="' . esc_url($settings['custom_overlay_icon']['url']) . '" style="width:64px;height:64px;" alt="Play Button" />
            </span>';
        }

        echo '</a></div></div>';
    }
}
