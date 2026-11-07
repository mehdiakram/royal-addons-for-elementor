<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class RoyalSocialShare extends Widget_Base {

    public function get_name() {
        return 'royalsocialshare';
    }

	public function get_title () {
		return __( 'Social Share', 'royal-addons-for-elementor' );
	}


	public function get_icon () {
		return 'eicon-share rtbranding';
	}

	public function get_keywords () {
		return [ 'social', 'share', 'facebook', 'twitter', 'instagram', 'linkedin', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	public function get_categories() {
        return array( 'royaltech' );
    }

    public function get_style_depends() {
		$styles = ['royalsocialshare'];
		return $styles;
	}
	
	public function get_script_depends() {
		$scripts = ['sharer'];
		return $scripts;
	}

	protected function register_controls() {
		$this->register_content_controls(); 
		$this->register_style_controls(); 
	}


	private function register_content_controls () {

		$this->start_controls_section(
			'_section_content',
			[
				'label' => __( 'Buttons', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'share_network',
			[
				'label'   => __( 'Network', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'facebook'    => __( 'Facebook', 'royal-addons-for-elementor' ),
					'twitter'     => __( 'Twitter', 'royal-addons-for-elementor' ),
					'linkedin'    => __( 'Linkedin', 'royal-addons-for-elementor' ),
					'email'       => __( 'Email', 'royal-addons-for-elementor' ),
					'whatsapp'    => __( 'Whatsapp', 'royal-addons-for-elementor' ),
					'telegram'    => __( 'Telegram', 'royal-addons-for-elementor' ),
					'viber'       => __( 'Viber', 'royal-addons-for-elementor' ),
					'pinterest'   => __( 'Pinterest', 'royal-addons-for-elementor' ),
					'tumblr'      => __( 'Tumblr', 'royal-addons-for-elementor' ),
					'reddit'      => __( 'Reddit', 'royal-addons-for-elementor' ),
					'vk'          => __( 'VK', 'royal-addons-for-elementor' ),
					'xing'        => __( 'Xing', 'royal-addons-for-elementor' ),
					'get-pocket'  => __( 'Get Pocket', 'royal-addons-for-elementor' ),
					'digg'        => __( 'Digg', 'royal-addons-for-elementor' ),
					'stumbleupon' => __( 'StumbleUpon', 'royal-addons-for-elementor' ),
					'weibo'       => __( 'Weibo', 'royal-addons-for-elementor' ),
					'renren'      => __( 'Renren', 'royal-addons-for-elementor' ),
					'skype'       => __( 'Skype', 'royal-addons-for-elementor' ),
				],
				'default' => 'facebook',
			]
		);

		$repeater->add_control(
			'custom_link',
			[
				'label'       => __( 'Custom Link', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'https://your-share-link.com', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'hashtags',
			[
				'label'       => __( 'Hashtags', 'royal-addons-for-elementor' ),
				'description' => __( 'Write hashtags without # sign and with comma separated value', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'      => 2,
				'dynamic'     => [
					'active' => true,
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'facebook',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'linkedin',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'whatsapp',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'reddit',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'skype',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'pinterest',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'email',
						],
					]
				]
			]
		);

		$repeater->add_control(
			'share_title',
			[
				'label'     => __( 'Custom Title', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXTAREA,
				'rows'      => 2,
				'dynamic'   => [
					'active' => true,
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'facebook',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'linkedin',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'reddit',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'skype',
						],
						[
							'name' => 'share_network',
							'operator' => '!==',
							'value' => 'pinterest',
						],
					]
				]
			]
		);

		$repeater->add_control(
			'email_to',
			[
				'label'     => __( 'To', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'share_network' => 'email',
				]
			]
		);

		$repeater->add_control(
			'email_subject',
			[
				'label'     => __( 'Subject', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'share_network' => 'email',
				]
			]
		);

		$repeater->add_control(
			'twitter_handle',
			[
				'label'     => __( 'Twitter Handle', 'royal-addons-for-elementor' ),
				'description' => __( 'Write without @ sign.', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'share_network' => 'twitter',
				]
			]
		);

		$repeater->add_control(
			'image',
			[
				'type' => Controls_Manager::MEDIA,
				'label' => __( 'Custom Image', 'royal-addons-for-elementor' ),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'share_network' => 'pinterest'
				]
			]
		);

		$repeater->add_control(
			'share_text',
			[
				'label'       => __( 'Button Text', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => __( 'Share on Facebook', 'royal-addons-for-elementor' ),
				'dynamic'     => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'customize',
			[
				'label'          => __( 'Want To Customize?', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'      => __( 'No', 'royal-addons-for-elementor' ),
				'return_value'   => 'yes',
				'separator'      => 'before'
			]
		);

		$repeater->start_controls_tabs(
			'_tab_share_colors',
			[
				'condition' => [ 'customize' => 'yes' ]
			]
		);

		$repeater->start_controls_tab(
			'_tab_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'single_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'condition'      => [
					'customize' => 'yes'
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-share-network' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royal-share-icon-and-text > {{CURRENT_ITEM}} .royal-share-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'single_bg_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'condition'      => [
					'customize' => 'yes'
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-share-network' => 'background-color: {{VALUE}};',
				]
			]
		);

		$repeater->add_control(
			'single_border_color',
			[
				'label'          => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [
					'customize' => 'yes'
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-share-network' => 'border-color: {{VALUE}};',
				]
			]
		);

		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'_tab_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'signle_hover_color',
			[
				'label'          => __( 'Color', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [
					'customize' => 'yes'
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-share-network:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$repeater->add_control(
			'single_hover_bg_color',
			[
				'label'          => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [
					'customize' => 'yes'
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-share-network:hover' => 'background-color: {{VALUE}};',
				]
			]
		);

		$repeater->add_control(
			'single_hover_border_color',
			[
				'label'          => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'condition'      => [
					'customize' => 'yes'
				],
				'selectors'      => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .royal-share-network:hover' => 'border-color: {{VALUE}};',
				]
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$this->add_control(
			'icon_list',
			[
				'label'       => __( 'Share Icons', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{ share_network }}',
				'default'     => [
					[
						'share_icon'    => [
							'value'   => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
						'share_network' => 'facebook',
					],
					[
						'share_icon'    => [
							'value'   => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
						'share_network' => 'twitter',
					],
					[
						'share_icon'    => [
							'value'   => 'fab fa-linkedin',
							'library' => 'fa-brands',
						],
						'share_network' => 'linkedin',
					],
				]
			]
		);

		$this->add_control(
			'network_view',
			[
				'label'     => __( 'View', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'icon_and_text',
				'options'   => [
					'icon_and_text' => __( 'Icon and Text', 'royal-addons-for-elementor' ),
					'icon_only'     => __( 'Icon', 'royal-addons-for-elementor' ),
					'text_only'     => __( 'Text', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'separator_show',
			[
				'label'          => __( 'Separator', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::SWITCHER,
				'label_on'       => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off'      => __( 'No', 'royal-addons-for-elementor' ),
				'return_value'   => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'royal-separator-',
				'condition' => [
					'network_view' => 'icon_and_text'
				]
			]
		);

		$this->add_responsive_control(
			'display',
			[
				'label'       => __( 'Display', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'inline-block'   => [
						'title' => __( 'Inline', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-ellipsis-h',
					],
					'block' => [
						'title' => __( 'Block', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-ellipsis-v',
					]
				],
				'desktop_default' => 'inline-block',
				'tablet_default' => 'inline-block',
				'mobile_default' => 'block',
				'toggle' => false,
				'selectors'   => [
					'{{WRAPPER}} .royal-share-button' => 'display: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'       => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'left'   => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .royal-share-buttons' => 'text-align: {{VALUE}};'
				],
			]
		);

		$this->end_controls_section();
	}

	
	private function register_style_controls () {

		$this->start_controls_section(
			'_section_button_style',
			[
				'label' => __( 'Button', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'          => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px', '%' ],
				'selectors'      => [
					'{{WRAPPER}} .royal-share-network' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'     => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .royal-share-button:not(:last-child)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-share-network' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .royal-share-network',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .royal-share-network',
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'separator' => 'before',
				'range'     => [
					'px' => [
						'min' => 5,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-share-network' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'          => __( 'Icon Right Spacing', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'selectors'      => [
					'{{WRAPPER}} .royal-share-network i' => 'margin-right: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'separator_spacing',
			[
				'label'          => __( 'Separator Right Spacing', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'selectors'      => [
					'{{WRAPPER}} .royal-share-label' => 'padding-left: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'label'    => __( 'Typography', 'royal-addons-for-elementor' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .royal-share-network .royal-share-label'
			]
		);

		$this->start_controls_tabs( '_tab_icons_colors' );

		$this->start_controls_tab(
			'_tab_normal_color',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,

				'selectors'      => [
					'{{WRAPPER}} .royal-share-network ' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .royal-share-network' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => __( 'Separator Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .royal-share-label' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'_tab_common_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'common_hover_color',
			[
				'label'          => __( 'Color', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .royal-share-network:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'common_hover_bg_color',
			[
				'label'          => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .royal-share-network:hover' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'common_hover_border_color',
			[
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-share-network:hover' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'separator_hover_color',
			[
				'label' => __( 'Separator Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .royal-share-network:hover .royal-share-label' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render () {
		$settings = $this->get_settings_for_display();
		$social_icons = $settings['icon_list'];
		$network_view = $settings['network_view'];
		?>
		<ul class="royalsocialshare">
		<ul class="royal-share-buttons">
			<?php
			foreach ( $social_icons as $icon ) :
				$social_media_name  = $icon['share_network'];
				$custom_share_title = esc_html( $icon['share_title'] );
				$share_text         = esc_html( $icon['share_text'] );
				$default_share_text = ucfirst( $social_media_name );
				$image = isset($icon['image']['url'])? $icon['image']['url']: '';
				$twitter_handle = $icon['twitter_handle'];
				$email_to = $icon['email_to'];
				$email_subject = $icon['email_subject'];

				$share_on_text = $share_text ? $share_text : $default_share_text;

				$hashtags = $icon['hashtags'];
				$url = get_the_permalink();

				$custom_share_url = $icon['custom_link']['url'];
				$share_url        = $custom_share_url ? $custom_share_url : $url;

				$this->set_render_attribute( 'list_classes', 'class', [
					'royal-share-button',
					'elementor-repeater-item-' . $icon['_id']
				] );

				$this->set_render_attribute( 'link_classes', 'class', [
					'sharer',
					'royal-share-network',
					'elementor-social-icon-' . esc_attr( $social_media_name ),
				] );
				$this->set_render_attribute( 'link_classes', 'aria-label', 'Share on ' . esc_attr( $social_media_name ) );

				$this->set_render_attribute( 'link_classes', 'data-sharer', esc_attr( $social_media_name ) );
				$this->set_render_attribute( 'link_classes', 'data-url', $share_url );
				$this->set_render_attribute( 'link_classes', 'data-hashtags', $hashtags ? esc_html( $hashtags ) : '' );
				$this->set_render_attribute( 'link_classes', 'data-title', $custom_share_title );
				$this->set_render_attribute( 'link_classes', 'data-image', esc_url( $image ) );
				$this->set_render_attribute( 'link_classes', 'data-to', esc_attr( $email_to ) );
				$this->set_render_attribute( 'link_classes', 'data-subject', esc_attr( $email_subject ) );
				?>
				<li <?php $this->print_render_attribute_string( 'list_classes' ); ?>>
					<a <?php $this->print_render_attribute_string( 'link_classes' ); ?>>
						<?php
						$social_media_name = $social_media_name == 'email' ? 'envelope' : $social_media_name;
						$ico_library = $social_media_name == 'envelope' ? 'fa' : 'fab';
						
						if ( 'icon_and_text' == $network_view ) {
							?>
							<i class="<?=$ico_library?> fa-<?php echo esc_attr( $social_media_name ); ?>" aria-hidden="true"></i>
							<?php
							if ( ! empty( $share_on_text ) && '' != $share_on_text ) {
								printf( "<span class='royal-share-label'>%s</span>", $share_on_text );
							}
						}
						if ( 'icon_only' == $network_view ) {
							?>
							<i class="<?=$ico_library?> fa-<?php echo esc_attr( $social_media_name ); ?>" aria-hidden="true"></i>
							<?php
						}
						if ( 'text_only' == $network_view ) {
							if ( ! empty( $share_on_text ) && '' != $share_on_text ) {
								printf( "<span class='royal-share-label'>%s</span>", $share_on_text );
							}
						}
						?>
					</a>
				</li>
				<?php
			endforeach;
			?>

		</ul>
		</div>
		<?php

	}

	}
