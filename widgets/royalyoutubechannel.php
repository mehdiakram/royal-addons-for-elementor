<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use WP_Http;
use RoyalAddons\Traits\ProWidgetTrait;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalYouTubeChannel extends Widget_Base {
    use ProWidgetTrait;

    public function get_name() {
        return 'royalyoutubechannel';
    }

    public function get_title() {
        return __('YouTube Channel', 'royal-addons-for-elementor');
    }

    public function get_icon() { return 'eicon-video-playlist rtbranding'; }

    public function get_keywords() {
        return [ 'youtube', 'video', 'popup', 'embed', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

    public function get_categories() {
        return ['royaltech'];
    }

    public function get_script_depends() {
        return [ 'magnific-popup', 'royalyoutubechannel' ];
    }

    public function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __('Content', 'royal-addons-for-elementor'),
        ]);

        $this->add_control('api_key', [
            'label' => __('YouTube API Key', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'description' => sprintf(
                __('Enter your YouTube Data API key. You can find it or generate a new one from your %sGoogle Cloud Console%s.', 'royal-addons-for-elementor'),
                '<a href="https://www.youtube.com/embed/2`:`(and" target="_blank">',
                '</a>'
            ),
        ]);

        $this->add_control('channel_url', [
            'label' => __('YouTube Channel URL', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'placeholder' => __('Paste YouTube channel URL...', 'royal-addons-for-elementor'),
        ]);

        $this->add_control('content_type', [
            'label' => __('Content Type', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'all' => __('All', 'royal-addons-for-elementor'),
                'videos' => __('Videos', 'royal-addons-for-elementor'),
                'shorts' => __('Shorts', 'royal-addons-for-elementor'),
                'live' => __('Live', 'royal-addons-for-elementor'),
                'playlists' => __('Playlists', 'royal-addons-for-elementor'),
                'posts' => __('Posts', 'royal-addons-for-elementor'),
            ],
            'default' => 'videos',
        ]);

        $this->add_responsive_control(
            'videos_per_row',
            [
                'label' => __('Videos Per Row', 'royal-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'step' => 1,
                'default' => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'selectors' => [
                    '{{WRAPPER}} .royal-youtube-channel-warper' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control('total_videos', [
            'label' => __('Total Videos to Load', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::NUMBER,
            'default' => 12,
            'min' => 1,
            'max' => 50,
        ]);

        $this->add_control('thumbnail_quality', [
            'label' => __('Thumbnail Quality', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'hqdefault',
            'options' => [
                'default'       => __('Default (120x90)', 'royal-addons-for-elementor'),
                'mqdefault'     => __('Medium (320x180)', 'royal-addons-for-elementor'),
                'hqdefault'     => __('High (480x360)', 'royal-addons-for-elementor'),
                'sddefault'     => __('Standard (640x480)', 'royal-addons-for-elementor'),
                'maxresdefault' => __('Max Res (1280x720)', 'royal-addons-for-elementor'),
                'custom'        => __('Custom Upload', 'royal-addons-for-elementor'),
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

        $this->add_responsive_control('height', [
            'label' => esc_html__('Height', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
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
                '{{WRAPPER}} .royal-youtube-channel-warper .youtubethumbnail' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_responsive_control('grid_gap', [
            'label' => esc_html__('Grid Gap', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 20,
            ],
            'selectors' => [
                '{{WRAPPER}} .royal-youtube-channel-warper' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]);

        
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

    // --- Start: Added/Corrected Helper Functions ---

    // This function extracts the YouTube video ID from various URL formats.
    // This was present in your working 'royal-youtube-channel' widget.
    private function get_youtube_id($url) {
        preg_match("%(?:youtube(?:-nocookie)?\.com/(?:[^/\n\s]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^#&?\n\s]*)%", $url, $matches);
        return $matches[1] ?? '';
    }

    // --- End: Added/Corrected Helper Functions ---


    private function fetch_content($channel_id, $api_key, $content_type = 'videos', $max_results = 12) {
        if ($content_type === 'all') {
            // Fetch all content types and combine
            $videos = $this->fetch_content($channel_id, $api_key, 'videos', $max_results);
            $shorts = $this->fetch_content($channel_id, $api_key, 'shorts', $max_results);
            $live = $this->fetch_content($channel_id, $api_key, 'live', $max_results);
            $playlists = $this->fetch_content($channel_id, $api_key, 'playlists', $max_results);

            // Merge and ensure unique items, then slice to max_results
            $all_items = array_unique(array_merge($videos, $shorts, $live, $playlists));

            return array_slice($all_items, 0, $max_results);
        }

        $endpoint = 'https://www.googleapis.com/youtube/v3/search';
        $params = [
            'key' => $api_key,
            'channelId' => $channel_id,
            'part' => 'id,snippet',
            'order' => 'date',
            'maxResults' => $max_results,
        ];

        switch ($content_type) {
            case 'videos':
                $params['type'] = 'video';
                break;

            case 'shorts':
                $params['type'] = 'video';
                $params['videoDuration'] = 'short'; // Videos under 4 minutes
                break;

            case 'live':
                $params['type'] = 'video';
                $params['eventType'] = 'live';
                break;

            case 'playlists':
                // Different endpoint and parameters for playlists
                $endpoint = 'https://www.googleapis.com/youtube/v3/playlists';
                $params = [
                    'key' => $api_key,
                    'channelId' => $channel_id,
                    'part' => 'id,snippet',
                    'maxResults' => $max_results,
                ];
                break;

            case 'posts':
                // YouTube Community Posts are not available via YouTube Data API v3 Search/Playlists
                return [];

            default:
                $params['type'] = 'video';
                break;
        }

        $response = wp_remote_get(add_query_arg($params, $endpoint));
        if (is_wp_error($response)) return [];

        $data = json_decode(wp_remote_retrieve_body($response), true);
        $items = $data['items'] ?? [];
        $results = [];

        if ($content_type === 'playlists') {
            foreach ($items as $item) {
                if (isset($item['id'])) {
                    $results[] = $item['id'];
                }
            }
        } else {
            foreach ($items as $item) {
                if (isset($item['id']['videoId'])) {
                    $results[] = $item['id']['videoId'];
                }
            }
        }

        return $results;
    }

    private function resolve_channel_id($channel_url, $api_key) {
        if (preg_match('~youtube\\.com/(channel|c|user|@)([a-zA-Z0-9_\\-@]+)~i', $channel_url, $matches)) {
            $type = $matches[1];
            $identifier = $matches[2];

            if ($type === 'channel') return $identifier;

            $endpoint = 'https://www.googleapis.com/youtube/v3/channels';
            $params = [
                'part' => 'id',
                $type === '@' ? 'forHandle' : 'forUsername' => $identifier,
                'key' => $api_key
            ];
            $response = wp_remote_get(add_query_arg($params, $endpoint));

            if (!is_wp_error($response)) {
                $data = json_decode(wp_remote_retrieve_body($response), true);
                if (!empty($data['items'][0]['id'])) return $data['items'][0]['id'];
            }
        }
        return null;
    }

    public function render() {
		if ( $this->maybe_render_license_notice() ) {
			return;
		}

        $settings = $this->get_settings_for_display();
        $api_key = trim($settings['api_key']);

        if (!$api_key) {
            echo '<p>YouTube API Key is required.</p>';
            return;
        }

        $channel_id = $this->resolve_channel_id($settings['channel_url'], $api_key);
        if (!$channel_id) {
            echo '<p>Unable to resolve YouTube channel ID. Ensure the URL is correct or try a Channel ID directly.</p>';
            return;
        }

        $video_ids = $this->fetch_content($channel_id, $api_key, $settings['content_type'], $settings['total_videos']);
        if (empty($video_ids)) {
            echo '<p>No videos found for the selected content type.</p>';
            return;
        }

        $thumbnail_quality = $settings['thumbnail_quality'];
        $custom_thumbnail_url = !empty($settings['custom_thumbnail']['url']) ? $settings['custom_thumbnail']['url'] : '';
        $popup_enabled = ($settings['enable_popup'] === 'yes');
        $popup_autoplay = ($settings['popup_autoplay'] === 'yes') ? '1' : '0';
        $popup_mute = ($settings['popup_mute'] === 'yes') ? '1' : '0';
        $target      = $popup_enabled ? '' : ' target="' . esc_attr($settings['link_target']) . '"';
        $allowed_targets = ['_self', '_blank', '_parent', '_top']; // This line is not used directly, can be removed if not needed elsewhere.
        $link_target = in_array($settings['link_target'], $allowed_targets) ? $settings['link_target'] : '_self'; // This applies to non-popup links.
        // Removed $start variable from here, as it was not applicable to channel videos.
        // If you need a start time for EACH video from a channel, you'd need to fetch more video details via YouTube API.

        echo '<div class="royal-youtube-channel-warper" style="display:grid;">';

        foreach ($video_ids as $video_id) {
            $wrapper_id = 'royalvideo-' . esc_attr( $this->get_id() ) . '-' . uniqid();

            // Construct thumbnail URL
            $thumbnail = ($thumbnail_quality === 'custom' && $custom_thumbnail_url)
                         ? $custom_thumbnail_url
                         : "https://img.youtube.com/vi/{$video_id}/{$thumbnail_quality}.jpg";

            // CONSTRUCT THE FINAL EMBED URL for the link's href
            // This mirrors the working widget's method
            $embed_url = "https://www.youtube.com/embed/{$video_id}?autoplay={$popup_autoplay}&mute={$popup_mute}";
            
            // Determine the final URL for the link based on popup setting
            // For non-popup, directly link to YouTube watch page. For popup, use the embed URL.
            $final_link_href = $popup_enabled ? $embed_url : "https://www.youtube.com/watch?v={$video_id}";
            // Note: I've removed $start from the final_link_href for channel videos,
            // as 'start' time typically applies to a specific single video widget.
            // If you need it, you'd integrate it here.

            echo '<div class="royal-youtube-channel" id="' . $wrapper_id . '">';
            echo '<div class="royalpopup-gallery youtube-video-item" style="position:relative; border-radius:12px; overflow:hidden;">';

            // Use $final_link_href for the href attribute
            echo '<a href="' . esc_url($final_link_href) . '" class="' . ($popup_enabled ? 'royalvideo-popup' : '') . '"' . ($popup_enabled ? '' : ' target="' . esc_attr($link_target) . '"') . ' style="position:relative; display:block;">';

            // Thumbnail Image
            echo '<img class="youtubethumbnail" src="' . esc_url($thumbnail) . '" alt="" ' . ($settings['lazy_load'] === 'yes' ? 'loading="lazy"' : '') . ' style="width:100%;display:block;object-fit:cover;" />';

            // Overlay Play Button (Default or Custom)
            if ($settings['overlay_button_type'] === 'default' || ($settings['overlay_button_type'] === 'custom' && empty($settings['custom_overlay_icon']['url']))) {
                echo '<span style="
                    position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);
                    width:68px; height:64px; display:flex; justify-content:center; align-items:center; pointer-events:none;
                    ">
                    <svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%">
                        <path class="ytp-large-play-button-bg" fill="#f03" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                        <path fill="#fff" d="M 45,24 27,14 27,34"></path>
                    </svg>
                </span>';
            } elseif ($settings['overlay_button_type'] === 'custom' && !empty($settings['custom_overlay_icon']['url'])) {
                echo '<span style="
                    position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); pointer-events:none;
                    ">
                    <img src="' . esc_url($settings['custom_overlay_icon']['url']) . '" alt="Play Button" style="width:64px; height:64px;" />
                </span>';
            }

            echo '</a>'; // close anchor
            echo '</div>'; // close youtube-video-item
            echo '</div>'; // close id
        }

        echo '</div>'; // close grid container
    }
}