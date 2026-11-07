<?php

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RoyalReadingProgressBar {

    private static $_instance = null;

    public static function init() {
		
		add_action( 'elementor/documents/register_controls', [__CLASS__, 'register_controls' ], 10, 3 );
		add_action( 'elementor/editor/after_save', [__CLASS__, 'save_global_values' ], 10, 2 );
		add_action( 'wp_footer', [__CLASS__, 'render_progress_bar'] );

	}
    
    public static function register_controls( $element ) {
        
		$element->start_controls_section(
			'royalcontrolsection_reading_progress_bar',
			[
                'tab' => Controls_Manager::TAB_SETTINGS,
				'label' => __( 'Reading Progress Bar [Royal]', 'royal-addons-for-elementor' ),
			]
        );

            $element->add_control(
                'royal_enable_rpb',
                [
                    'label' => __( 'Enable Progress Bar', 'royal-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'On', 'royal-addons-for-elementor' ),
                    'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
                    'return_value' => 'yes',
                ]
            );

			$element->add_control(
				'royal_enable_rpb_globally',
				[
					'label' => __( 'Enable Progress Bar Globally', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'royal-addons-for-elementor' ),
					'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
					'return_value' => 'yes',
					'condition' => [
						'royal_enable_rpb' => 'yes'
					]
				]
			);

			$element->add_control(
				'royal_display_on',
				[
					'label' => __( 'Display On', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'all-pages',
					'options' => [
						'all-pages' => __( 'All Pages', 'royal-addons-for-elementor' ),
						'all-posts' => __( 'All Posts', 'royal-addons-for-elementor' ),
						'all-pages-posts' => __( 'All Pages & Posts', 'royal-addons-for-elementor' ),
					],
					'condition' => [
						'royal_enable_rpb' => 'yes',
						'royal_enable_rpb_globally' => 'yes'
					]
				]
			);


            $element->add_control(
				'royal_select_view',
				[
					'label' => __( 'Select View', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'view1',
					'options' => [
						'view1' => __( 'View 1', 'royal-addons-for-elementor' ),
						'view2' => __( 'View 2', 'royal-addons-for-elementor' ),
					],
                    'separator' => 'after',
					'condition' => [
						'royal_enable_rpb' => 'yes',
					],
				]
			);

            // View 1 controls
            $element->add_control(
				'royal_position',
				[
					'label' => __( 'Position', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'top',
					'options' => [
						'top' => __( 'Top', 'royal-addons-for-elementor' ),
						'bottom' => __( 'Bottom', 'royal-addons-for-elementor' ),
					],
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view1'
					],
				]
			);

            $element->add_control(
				'royal_height',
				[
					'label' => __( 'Height', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min'  => 1,
							'max'  => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10,
					],
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view1'
					],
					'selectors' => [
						'.royal-rpb-progress-container' => 'height: {{SIZE}}{{UNIT}} !important',
						'.royal-rpb-progress-container .royal-rpb-progress-bar' => 'height: {{SIZE}}{{UNIT}} !important',
					],
				]
			);

            $element->add_control(
				'royal_background_color',
				[
					'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#C5C5C6',
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view1'
					],
					'selectors' => [
						'.royal-rpb-progress-container' => 'background-color: {{VALUE}};'
					]
				]
			);

            $element->add_control(
				'royal_fill_color',
				[
					'label' => __( 'Fill Color', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#6A63DA',
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view1'
					],
					'selectors' => [
						'.royal-rpb-progress-container .royal-rpb-progress-bar' => 'background-color: {{VALUE}};'
					]
				]
			);

            // View 2 controls
            $element->add_control(
                'royal_rpb_icon',
                [
                    'label' => __( 'Select Icon', 'royal-addons-for-elementor' ),
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-arrow-up',
                        'library' => 'solid',
                    ],
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view2'
					]
                ]
            );

            $element->add_control(
				'royal_icon_size',
				[
					'label' => __( 'Icon Size', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min'  => 1,
							'max'  => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 30,
					],
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view2'
					],
					'selectors' => [
						'#royal-btt-rpb .royal-rpb-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
						'#royal-btt-rpb.royal-progress-wrap' => 'height: calc(46px + ({{SIZE}}{{UNIT}} - 20px)) !important; width: calc(46px + ({{SIZE}}{{UNIT}} - 20px)) !important;',
					]
				]
			);
			

			$element->start_controls_tabs( 'grid_readmore_color_style' );
                $element->start_controls_tab( 'normaltab',
                    [
                        'label' => __( 'Normal', 'royal-addons-for-elementor' ),
                        'condition' => [
                            'royal_enable_rpb' => 'yes',
                            'royal_select_view' => 'view2'
                        ]
                    ]
				);

                    $element->add_control(
                        'royal_icon_color',
                        [
                            'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'condition' => [
                                'royal_enable_rpb' => 'yes',
                                'royal_select_view' => 'view2'
							],
							'selectors' => [
								'.royal-progress-wrap .royal-rpb-icon' => 'color: {{VALUE}};'
							]
                        ]
                    );

                    $element->add_control(
                        'royal_icon_bg_color',
                        [
                            'label' => __( 'Icon Background Color', 'royal-addons-for-elementor' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'condition' => [
                                'royal_enable_rpb' => 'yes',
                                'royal_select_view' => 'view2'
							],
							'selectors' => [
								'#royal-btt-rpb svg' => 'background-color: {{VALUE}} !important;'
							]
                        ]
                    );

                $element->end_controls_tab();

                $element->start_controls_tab( 'hovertab',
                    [
                        'label' => __( 'Hover', 'royal-addons-for-elementor' ),
                        'condition' => [
                            'royal_enable_rpb' => 'yes',
                            'royal_select_view' => 'view2'
                        ]
                    ]
				);
				
                    $element->add_control(
                        'royal_icon_hover_color',
                        [
                            'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'condition' => [
                                'royal_enable_rpb' => 'yes',
                                'royal_select_view' => 'view2'
							],
							'selectors' => [
								'#royal-btt-rpb .royal-rpb-icon:hover' => 'color: {{VALUE}} !important;'
							]
                        ]
                    );

                    $element->add_control(
                        'royal_icon_bg_hover_color',
                        [
                            'label' => __( 'Icon Background Color', 'royal-addons-for-elementor' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'condition' => [
                                'royal_enable_rpb' => 'yes',
                                'royal_select_view' => 'view2'
							],
							'selectors' => [
								'#royal-btt-rpb:hover svg' => 'background-color: {{VALUE}} !important;'
							]
                        ]
                    );

                $element->end_controls_tab();
			$element->end_controls_tabs();			
			
			

            $element->add_control(
				'royal_bar_size',
				[
					'label' => __( 'Bar Size', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min'  => 1,
							'max'  => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10,
					],
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view2'
					],
					'selectors' => [
						'#royal-btt-rpb svg.progress-circle path.bar' => 'stroke-width: {{SIZE}} !important;',
						'#royal-btt-rpb svg.progress-circle path.bar-bg' => 'stroke-width: {{SIZE}} !important;'
					]
				]
			);

			$element->add_control(
				'royal_bar_color',
				[
					'label' => __( 'Bar Color', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view2'
					],
					'selectors' => [
						'#royal-btt-rpb svg.progress-circle path.bar' => 'stroke: {{VALUE}} !important;'
					]
				]
			);

			$element->add_control(
				'royal_bar_bg_color',
				[
					'label' => __( 'Bar Background Color', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#B3A9A97A',
					'condition' => [
						'royal_enable_rpb' => 'yes',
                        'royal_select_view' => 'view2'
					],
					'selectors' => [
						'#royal-btt-rpb svg.progress-circle path.bar-bg' => 'stroke: {{VALUE}} !important;'
					]
				]
			);

            $element->add_control(
				'royal_animation_speed',
				[
					'label' => __( 'Animation Speed (Milliseconds)', 'royal-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min'  => 1,
							'max'  => 2000,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10,
					],
                    'separator' => 'before',
					'condition' => [
						'royal_enable_rpb' => 'yes'
					],
					'selectors' => [
						'.royal-rpb-progress-container .royal-rpb-progress-bar' => 'transition: width {{SIZE}}ms ease;',
						'.royal-progress-wrap svg.progress-circle path.bar' => 'transition: stroke-dashoffset {{SIZE}}ms ease !important;'
					],
				]
			);

			$element->add_control(
				'royal_hide_on_desktop',
				[
					'label' => __( 'Hide On Desktop', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
					'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
					'return_value' => 'yes',
					'condition' => [
						'royal_enable_rpb' => 'yes',
					],
				]
			);

			$element->add_control(
				'royal_hide_on_tablet',
				[
					'label' => __( 'Hide On Tablet', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
					'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
					'return_value' => 'yes',
					'condition' => [
						'royal_enable_rpb' => 'yes',
					],
				]
			);

			$element->add_control(
				'royal_hide_on_mobile',
				[
					'label' => __( 'Hide On Mobile', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
					'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
					'return_value' => 'yes',
					'condition' => [
						'royal_enable_rpb' => 'yes',
					],
				]
			);
			$element->add_control(
				'royal_z_index',
				[
					'label' => __( 'Z-Index', 'royal-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'default' => 9999,
					'condition' => [
						'royal_enable_rpb' => 'yes',
					],
					'selectors' => [
						'.royal-rpb-progress-container' => 'z-index: {{VALUE}} !important;',
						'#royal-btt-rpb.royal-progress-wrap' => 'z-index: {{VALUE}} !important;',
					],
				]
			);
			
        $element->end_controls_section();
        
	}


	public static function save_global_values( $post_id, $editor_data ) {

		$document = \Elementor\Plugin::$instance->documents->get( $post_id, false );
		$settings = $document->get_settings();
		$integrationOptions = get_option( 'royal_rpb_addons_integration' );

		if ( $settings['royal_enable_rpb'] == 'yes' ) {

			// Global Settings	
			if ( $settings['royal_enable_rpb_globally'] == 'yes' ) {
				$integrationOptions['reading-progress-bar-globally'][$post_id] = self::createOption( $settings );
				$integrationOptions['reading-progress-bar-globally'][$post_id]['post_id'] = get_the_ID();
				$integrationOptions['reading-progress-bar-globally'][$post_id]['display_on'] = $settings['royal_display_on'];

				// Updating old settings if present
				if ( $integrationOptions['reading-progress-bar'][$post_id] ) {
					$integrationOptions['reading-progress-bar'][$post_id] = self::createOption( $settings );
				}
			} else {
				$integrationOptions['reading-progress-bar'][$post_id] = self::createOption( $settings );

				// Removing global values if disabled
				if( isset( get_option('royal_rpb_addons_integration')['reading-progress-bar-globally'] ) && array_key_exists( $post_id, get_option('royal_rpb_addons_integration')['reading-progress-bar-globally'] ) ) {
					unset( $integrationOptions['reading-progress-bar-globally'] );
				}
			}

		} else {
				if( isset( get_option('royal_rpb_addons_integration')['reading-progress-bar'] ) && array_key_exists( $post_id, get_option('royal_rpb_addons_integration')['reading-progress-bar'] ) ) {
					// removing the disabled RPB
					unset( $integrationOptions['reading-progress-bar'][$post_id] );
				}
		}
		
		update_option( 'royal_rpb_addons_integration', $integrationOptions );

	}


	public static function createOption( $settings ) {

		$rpbSetting = [];

		$rpbSetting['select_view'] = $settings['royal_select_view'];
		$rpbSetting['animation_speed'] = $settings['royal_animation_speed'];
		$rpbSetting['hide_on_desktop'] = $settings['royal_hide_on_desktop'];
		$rpbSetting['hide_on_tablet'] = $settings['royal_hide_on_tablet'];
		$rpbSetting['hide_on_mobile'] = $settings['royal_hide_on_mobile'];
		$rpbSetting['z_index'] = $settings['royal_z_index'];

		if( $settings['royal_select_view'] == 'view1' ) {
			// view 1
			$rpbSetting['position'] = $settings['royal_position'];
			$rpbSetting['height'] = $settings['royal_height'];
			$rpbSetting['background_color'] = $settings['royal_background_color'];
			$rpbSetting['fill_color'] = $settings['royal_fill_color'];
		} else {
			// view 2
			$rpbSetting['rpb_icon'] = $settings['royal_rpb_icon'];
			$rpbSetting['icon_size'] = $settings['royal_icon_size'];
			$rpbSetting['icon_color'] = $settings['royal_icon_color'];
			$rpbSetting['icon_bg_color'] = $settings['royal_icon_bg_color'];
			$rpbSetting['icon_hover_color'] = $settings['royal_icon_hover_color'];
			$rpbSetting['icon_bg_hover_color'] = $settings['royal_icon_bg_hover_color'];
			$rpbSetting['icon_shape'] = $settings['royal_icon_shape'];
			$rpbSetting['bar_size'] = $settings['royal_bar_size'];
			$rpbSetting['bar_color'] = $settings['royal_bar_color'];
			$rpbSetting['bar_bg_color'] = $settings['royal_bar_bg_color'];
		}

		return $rpbSetting;
	}
    
    public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    public static function render_progress_bar() {
        if ( is_admin() || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) ) {
            return;
        }

        $post_id = get_the_ID();
        $integrationOptions = get_option( 'royal_rpb_addons_integration', [] );
        $rpbSetting = false;

        if ( isset( $integrationOptions['reading-progress-bar'][$post_id] ) ) {
            $rpbSetting = $integrationOptions['reading-progress-bar'][$post_id];
        } elseif ( isset( $integrationOptions['reading-progress-bar-globally'] ) && is_array($integrationOptions['reading-progress-bar-globally']) ) {
            foreach( $integrationOptions['reading-progress-bar-globally'] as $global_id => $global_setting ) {
                if ( ! isset($global_setting['display_on']) ) continue;
                $display_on = $global_setting['display_on'];
                
                if ( $display_on == 'all-pages' && is_page() ) {
                    $rpbSetting = $global_setting;
                    break;
                } elseif ( $display_on == 'all-posts' && is_single() ) {
                    $rpbSetting = $global_setting;
                    break;
                } elseif ( $display_on == 'all-pages-posts' && (is_page() || is_single()) ) {
                    $rpbSetting = $global_setting;
                    break;
                }
            }
        }

        if ( ! $rpbSetting ) {
            return;
        }

        $classes = [];
        if ( isset($rpbSetting['hide_on_desktop']) && $rpbSetting['hide_on_desktop'] == 'yes' ) {
            $classes[] = 'elementor-hidden-desktop';
        }
        if ( isset($rpbSetting['hide_on_tablet']) && $rpbSetting['hide_on_tablet'] == 'yes' ) {
            $classes[] = 'elementor-hidden-tablet';
        }
        if ( isset($rpbSetting['hide_on_mobile']) && $rpbSetting['hide_on_mobile'] == 'yes' ) {
            $classes[] = 'elementor-hidden-mobile';
        }
        
        $class_str = implode(' ', $classes);
        $view = isset($rpbSetting['select_view']) ? $rpbSetting['select_view'] : 'view1';
        $z_index = isset($rpbSetting['z_index']) && $rpbSetting['z_index'] !== '' ? intval($rpbSetting['z_index']) : 9999;

        if ( $view == 'view1' ) {
            $position = isset($rpbSetting['position']) ? $rpbSetting['position'] : 'top';
            $pos_style = $position == 'bottom' ? 'bottom: 0;' : 'top: 0;';
            echo '<div class="royal-rpb-progress-container ' . esc_attr($class_str) . '" style="position: fixed; left: 0; width: 100%; z-index: ' . esc_attr($z_index) . '; ' . $pos_style . '">';
            echo '<div class="royal-rpb-progress-bar" style="width: 0%; height: 5px; background: #6A63DA;"></div>';
            echo '</div>';
            ?>
            <script>
            jQuery(window).on('scroll', function() {
                var scrollTop = jQuery(window).scrollTop();
                var docHeight = jQuery(document).height() - jQuery(window).height();
                var scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                jQuery('.royal-rpb-progress-bar').css('width', scrollPercent + '%');
            });
            </script>
            <?php
        } else {
            $icon = isset($rpbSetting['rpb_icon']['value']) ? $rpbSetting['rpb_icon']['value'] : 'fas fa-arrow-up';
            echo '<div id="royal-btt-rpb" class="royal-progress-wrap ' . esc_attr($class_str) . '" style="position: fixed; right: 30px; bottom: 30px; z-index: ' . esc_attr($z_index) . '; cursor: pointer; display: flex; align-items: center; justify-content: center; border-radius: 50%; width: 46px; height: 46px; background: transparent;">';
            echo '<svg class="progress-circle" width="100%" height="100%" viewBox="-1 -1 102 102" style="position: absolute; top: 0; left: 0; transform: rotate(-90deg); border-radius: 50%;">';
            echo '<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" class="bar-bg" fill="none" stroke="#B3A9A97A" stroke-width="10" />';
            echo '<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" class="bar" fill="none" stroke="#6A63DA" stroke-width="10" stroke-dasharray="307.919" stroke-dashoffset="307.919" />';
            echo '</svg>';
            echo '<div class="royal-rpb-icon" style="z-index: 1;"><i class="' . esc_attr($icon) . '"></i></div>';
            echo '</div>';
            ?>
            <script>
            jQuery(window).on('scroll', function() {
                var scrollTop = jQuery(window).scrollTop();
                var docHeight = jQuery(document).height() - jQuery(window).height();
                if (docHeight > 0) {
                    var scrollPercent = scrollTop / docHeight;
                    var offset = 307.919 - (scrollPercent * 307.919);
                    jQuery('#royal-btt-rpb .bar').css('stroke-dashoffset', offset);
                    
                    if (scrollTop > 100) {
                        jQuery('#royal-btt-rpb').fadeIn();
                    } else {
                        jQuery('#royal-btt-rpb').fadeOut();
                    }
                }
            });
            jQuery('#royal-btt-rpb').on('click', function() {
                jQuery('html, body').animate({scrollTop: 0}, 300);
                return false;
            });
            </script>
            <?php
        }
    }

}

RoyalReadingProgressBar::instance()->init();