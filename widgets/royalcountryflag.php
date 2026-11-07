<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_royal_get_preview_flag', [ __NAMESPACE__ . '\RoyalCountryFlag', 'handle_ajax_preview' ] );

class RoyalCountryFlag extends Widget_Base {

	public function get_name() {
		return 'royalcountryflag';
	}

	public function get_title() {
		return esc_html__( 'Country Flag', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-font-awesome rtbranding'; }

	public function get_keywords() {
		return [ 'royal', 'flag', 'country', 'svg', 'ip', 'visitor', 'detect', 'github', 'remote', 'tech', 'mehdi', 'akram', 'technologies' ];
	}

	public function get_categories() {
		return [ 'royaltech' ];
	}

	private static function get_visitor_country_code() {
		$ip_address = ! empty( $_SERVER['REMOTE_ADDR'] ) ? filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP ) : false;

		if ( ! $ip_address ) {
			return 'un';
		}
		
		if ( in_array( $ip_address, [ '127.0.0.1', '::1' ], true ) ) {
			return 'bd';
		}

		if ( ! filter_var( $ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
			return 'un';
		}

		$transient_key = 'royal_visitor_country_' . md5( $ip_address );
		$cached_code   = get_transient( $transient_key );

		if ( false !== $cached_code ) {
			return $cached_code;
		}

		$response = wp_remote_get( 'http://ip-api.com/json/' . $ip_address . '?fields=status,countryCode' );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ) );

		if ( isset( $data->status ) && 'success' === $data->status && ! empty( $data->countryCode ) ) {
			$country_code = sanitize_text_field( $data->countryCode );
			set_transient( $transient_key, $country_code, 12 * HOUR_IN_SECONDS );
			return $country_code;
		}

		return false;
	}

	private static function get_svg_from_github( $country_code, $aspect_ratio = '4x3' ) {
		if ( empty( $country_code ) ) {
			return false;
		}

		$github_user   = 'mehdiakram';
		$github_repo   = 'country-flags';
		$transient_key = 'royal_svg_v2_' . $country_code . '_' . $aspect_ratio;

		$cached_svg = get_transient( $transient_key );
		if ( false !== $cached_svg ) {
			return $cached_svg;
		}

		$svg_url = sprintf(
			'https://raw.githubusercontent.com/%s/%s/main/flags/%s/%s.svg',
			$github_user, $github_repo, esc_attr( $aspect_ratio ), strtolower( esc_attr( $country_code ) )
		);

		$response = wp_remote_get( $svg_url, [ 'timeout' => 10 ] );

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return false;
		}

		$svg_content = wp_remote_retrieve_body( $response );

		if ( false !== strpos( $svg_content, '<script' ) ) {
			return false;
		}
		
		if ( false === strpos( $svg_content, 'viewBox' ) ) {
			$svg_content = preg_replace(
				'/<svg([^>]*)width="(\d+)"[^>]*height="(\d+)"([^>]*)>/i',
				'<svg$1viewBox="0 0 $2 $3"$4>',
				$svg_content
			);
		}

		set_transient( $transient_key, $svg_content, DAY_IN_SECONDS );

		return $svg_content;
	}

	public static function handle_ajax_preview() {
		check_ajax_referer( 'royal-addons-editor-nonce', 'nonce' );

		if ( ! isset( $_POST['country_code'], $_POST['aspect_ratio'] ) ) {
			wp_send_json_error();
		}

		$country_code = sanitize_text_field( $_POST['country_code'] );
		$aspect_ratio = sanitize_text_field( $_POST['aspect_ratio'] );
		$svg          = self::get_svg_from_github( $country_code, $aspect_ratio );

		if ( $svg ) {
			wp_send_json_success( [ 'svg' => $svg ] );
		} else {
			wp_send_json_error();
		}
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Flag Settings', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'location_detection',
			[
				'label' => esc_html__( 'Location Detection', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'auto' => [
						'title' => esc_html__( 'Auto', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-map-pin',
					],
					'manual' => [
						'title' => esc_html__( 'Manual', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-edit',
					],
				],
				'default' => 'auto',
				'toggle' => false,
			]
		);

		$this->add_control(
			'country_code',
			[
				'label'   => esc_html__( 'Select Country Flag', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bd',
				'options' => [
					'af' => 'Afghanistan',
					'al' => 'Albania',
					'dz' => 'Algeria',
					'ad' => 'Andorra',
					'ao' => 'Angola',
					'ar' => 'Argentina',
					'am' => 'Armenia',
					'au' => 'Australia',
					'at' => 'Austria',
					'az' => 'Azerbaijan',
					'bs' => 'Bahamas',
					'bh' => 'Bahrain',
					'bd' => 'Bangladesh',
					'bb' => 'Barbados',
					'by' => 'Belarus',
					'be' => 'Belgium',
					'bz' => 'Belize',
					'bj' => 'Benin',
					'bt' => 'Bhutan',
					'bo' => 'Bolivia',
					'ba' => 'Bosnia and Herzegovina',
					'bw' => 'Botswana',
					'br' => 'Brazil',
					'bn' => 'Brunei Darussalam',
					'bg' => 'Bulgaria',
					'bf' => 'Burkina Faso',
					'bi' => 'Burundi',
					'kh' => 'Cambodia',
					'cm' => 'Cameroon',
					'ca' => 'Canada',
					'cf' => 'Central African Republic',
					'td' => 'Chad',
					'cl' => 'Chile',
					'cn' => 'China',
					'co' => 'Colombia',
					'cg' => 'Congo',
					'cr' => 'Costa Rica',
					'hr' => 'Croatia',
					'cu' => 'Cuba',
					'cy' => 'Cyprus',
					'cz' => 'Czech Republic',
					'dk' => 'Denmark',
					'dj' => 'Djibouti',
					'dm' => 'Dominica',
					'do' => 'Dominican Republic',
					'ec' => 'Ecuador',
					'eg' => 'Egypt',
					'sv' => 'El Salvador',
					'gq' => 'Equatorial Guinea',
					'er' => 'Eritrea',
					'ee' => 'Estonia',
					'et' => 'Ethiopia',
					'fj' => 'Fiji',
					'fi' => 'Finland',
					'fr' => 'France',
					'ga' => 'Gabon',
					'gm' => 'Gambia',
					'ge' => 'Georgia',
					'de' => 'Germany',
					'gh' => 'Ghana',
					'gr' => 'Greece',
					'gd' => 'Grenada',
					'gt' => 'Guatemala',
					'gn' => 'Guinea',
					'gy' => 'Guyana',
					'ht' => 'Haiti',
					'hn' => 'Honduras',
					'hu' => 'Hungary',
					'is' => 'Iceland',
					'in' => 'India',
					'id' => 'Indonesia',
					'ir' => 'Iran',
					'iq' => 'Iraq',
					'ie' => 'Ireland',
					'il' => 'Israel',
					'it' => 'Italy',
					'jm' => 'Jamaica',
					'jp' => 'Japan',
					'jo' => 'Jordan',
					'kz' => 'Kazakhstan',
					'ke' => 'Kenya',
					'kr' => 'Korea, Republic of',
					'kw' => 'Kuwait',
					'kg' => 'Kyrgyzstan',
					'lv' => 'Latvia',
					'lb' => 'Lebanon',
					'lr' => 'Liberia',
					'ly' => 'Libya',
					'li' => 'Liechtenstein',
					'lt' => 'Lithuania',
					'lu' => 'Luxembourg',
					'mg' => 'Madagascar',
					'mw' => 'Malawi',
					'my' => 'Malaysia',
					'mv' => 'Maldives',
					'ml' => 'Mali',
					'mt' => 'Malta',
					'mr' => 'Mauritania',
					'mu' => 'Mauritius',
					'mx' => 'Mexico',
					'md' => 'Moldova',
					'mc' => 'Monaco',
					'mn' => 'Mongolia',
					'me' => 'Montenegro',
					'ma' => 'Morocco',
					'mz' => 'Mozambique',
					'mm' => 'Myanmar',
					'na' => 'Namibia',
					'np' => 'Nepal',
					'nl' => 'Netherlands',
					'nz' => 'New Zealand',
					'ni' => 'Nicaragua',
					'ne' => 'Niger',
					'ng' => 'Nigeria',
					'no' => 'Norway',
					'om' => 'Oman',
					'pk' => 'Pakistan',
					'pa' => 'Panama',
					'pg' => 'Papua New Guinea',
					'py' => 'Paraguay',
					'pe' => 'Peru',
					'ph' => 'Philippines',
					'pl' => 'Poland',
					'pt' => 'Portugal',
					'qa' => 'Qatar',
					'ro' => 'Romania',
					'ru' => 'Russian Federation',
					'rw' => 'Rwanda',
					'sa' => 'Saudi Arabia',
					'sn' => 'Senegal',
					'rs' => 'Serbia',
					'sc' => 'Seychelles',
					'sl' => 'Sierra Leone',
					'sg' => 'Singapore',
					'sk' => 'Slovakia',
					'si' => 'Slovenia',
					'so' => 'Somalia',
					'za' => 'South Africa',
					'es' => 'Spain',
					'lk' => 'Sri Lanka',
					'sd' => 'Sudan',
					'sr' => 'Suriname',
					'se' => 'Sweden',
					'ch' => 'Switzerland',
					'sy' => 'Syrian Arab Republic',
					'tw' => 'Taiwan',
					'tj' => 'Tajikistan',
					'tz' => 'Tanzania',
					'th' => 'Thailand',
					'tg' => 'Togo',
					'to' => 'Tonga',
					'tt' => 'Trinidad and Tobago',
					'tn' => 'Tunisia',
					'tr' => 'Turkey',
					'tm' => 'Turkmenistan',
					'ug' => 'Uganda',
					'ua' => 'Ukraine',
					'ae' => 'United Arab Emirates',
					'gb' => 'United Kingdom',
					'us' => 'United States',
					'uy' => 'Uruguay',
					'uz' => 'Uzbekistan',
					've' => 'Venezuela',
					'vn' => 'Viet Nam',
					'ye' => 'Yemen',
					'zm' => 'Zambia',
					'zw' => 'Zimbabwe',
				],

				'condition' => [
					'location_detection' => 'manual',
				],
			]
		);
		
		$this->add_control(
			'auto_preview_flag',
			[
				'label' => esc_html__( 'Editor Preview Flag', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'un',
				'options' => [
					'un' => 'United Nations',
					'us' => 'United States',
					'gb' => 'United Kingdom',
					'eu' => 'European Union',
					'bd' => 'Bangladesh',
					'in' => 'India',
				],
				'condition' => [
					'location_detection' => 'auto',
				],
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => esc_html__( 'Aspect Ratio', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4x3',
				'options' => [
					'4x3' => esc_html__( 'Rectangle (4x3)', 'royal-addons-for-elementor' ),
					'1x1' => esc_html__( 'Square (1x1)', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'flag_section_style',
			[
				'label' => esc_html__( 'Flag Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 200,
				],				
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-svg-flag-container' => 'line-height: 0;',
					'{{WRAPPER}} .royal-svg-flag-container svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .royal-svg-flag-container' => 'display: flex; justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$detection_mode = $settings['location_detection'];
		$country_code   = '';
		$fallback_code  = 'un';

		if ( 'auto' === $detection_mode ) {
			$country_code = self::get_visitor_country_code();
		} else {
			$country_code = $settings['country_code'];
		}

		if ( empty( $country_code ) ) {
			$country_code = $fallback_code;
		}

		$this->add_render_attribute( 'container', 'class', 'royal-svg-flag-container' );
		$tag = 'div';

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'container', $settings['link'] );
			$tag = 'a';
		}

		$svg = self::get_svg_from_github( $country_code, $settings['aspect_ratio'] );

		echo '<' . $tag . ' ' . $this->get_render_attribute_string( 'container' ) . '>';
		if ( $svg ) {
			echo $svg;
		} else {
			echo self::get_svg_from_github( $fallback_code, $settings['aspect_ratio'] );
		}
		echo '</' . $tag . '>';
	}

	protected function content_template() {
		?>
		<#
			var tag = 'div';
			var containerClass = 'royal-svg-flag-container';

			if ( settings.link && settings.link.url ) {
				tag = 'a';
			}
		#>
		<{{{ tag }}} class="{{ containerClass }}" href="{{ settings.link.url }}"></{{{ tag }}}>
		<#
			var countryCode;

			if ( 'auto' === settings.location_detection ) {
				countryCode = settings.auto_preview_flag;
			} else {
				countryCode = settings.country_code;
			}

			if ( countryCode ) {
				var widgetID = view.getID();
				var aspectRatio = settings.aspect_ratio;
				var nonce = '<?php echo wp_create_nonce( 'royal-addons-editor-nonce' ); ?>';
				var flagContainer = jQuery( '#elementor-widget-' + widgetID ).find( '.royal-svg-flag-container' );
				var placeholder = '<i class="eicon-loading eicon-animation-spin"></i>';
				
				flagContainer.html( placeholder );

				jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'royal_get_preview_flag',
						country_code: countryCode,
						aspect_ratio: aspectRatio,
						nonce: nonce
					},
					success: function( response ) {
						if ( response.success && response.data.svg ) {
							flagContainer.html( response.data.svg );
						} else {
							flagContainer.html( '<i class="eicon-close-circle" role="button" aria-label="Close" tabindex="0"></i>' );
						}
					},
					error: function() {
						flagContainer.html( '<i class="eicon-error"></i>' );
					}
				});
			} else {
                view.$el.find('.royal-svg-flag-container').html('');
            }
		#>
		<?php
	}
}
