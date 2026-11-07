<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalFloatSocialButtons extends Widget_Base{

	public function get_name(){ return 'royalfloatsocialbuttons'; }
	public function get_title(){ return 'Advanced Floating Buttons'; }
	public function get_icon() { return 'eicon-social-icons rtbranding'; }
	public function get_keywords() { return [ 'float', 'social', 'buttons', 'advanced', 'corner', 'edge', 'royal',  'mehdi',  'akram', 'tech', 'technologies' ]; }
	public function get_categories(){ return ['royaltech_headerfooter']; }
	public function get_style_depends() { return ['royalfloatsocialbuttons']; }

	protected function register_controls(){

		// --- Content Tab: Social Icons ---
		$this->start_controls_section('content_section', ['label' => __( 'Social Icons', 'royal-addons-for-elementor' )]);

		$repeater = new Repeater();
		$repeater->add_control('social_icon', ['label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::ICONS, 'default' => ['value' => 'fab fa-wordpress', 'library' => 'fa-brands'],]);
		$repeater->add_control('link', ['label' => esc_html__( 'Link', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '#', 'is_external' => true, 'nofollow' => true ], 'dynamic' => [ 'active' => true ],]);
		$repeater->add_control('item_icon_color', ['label' => esc_html__( 'Color Type', 'elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'default', 'options' => ['default' => esc_html__( 'Official Color', 'elementor' ), 'custom' => esc_html__( 'Custom', 'elementor' )],]);
		$repeater->add_control('item_icon_primary_color', ['label' => esc_html__( 'Background Color', 'elementor' ), 'type' => Controls_Manager::COLOR, 'condition' => [ 'item_icon_color' => 'custom' ], 'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}.rfs-item' => 'background-color: {{VALUE}} !important;'],]);
		$repeater->add_control('item_icon_secondary_color', ['label' => esc_html__( 'Icon Color', 'elementor' ), 'type' => Controls_Manager::COLOR, 'condition' => [ 'item_icon_color' => 'custom' ], 'default' => '#FFFFFF', 'selectors' => ['{{WRAPPER}} {{CURRENT_ITEM}}.rfs-item .elementor-icon, {{WRAPPER}} {{CURRENT_ITEM}}.rfs-item .elementor-icon svg' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important;'],]);
		$this->add_control('social_icon_list', ['label' => esc_html__( 'Icons List', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'default' => [['social_icon' => ['value' => 'fab fa-facebook-f', 'library' => 'fa-brands']],['social_icon' => ['value' => 'fab fa-twitter', 'library' => 'fa-brands']],['social_icon' => ['value' => 'fab fa-youtube', 'library' => 'fa-brands']],], 'title_field' => '{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon ) }}}',]);
		$this->end_controls_section();

		// --- Content Tab: Settings ---
		$this->start_controls_section('settings_section', ['label' => __( 'Settings', 'royal-addons-for-elementor' )]);
		$this->add_control('widget_position', ['label' => __( 'Widget Position', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'bottom-right', 'options' => ['top-left' => __( 'Top Left', 'royal-addons-for-elementor' ),'top-center' => __( 'Top Center', 'royal-addons-for-elementor' ),'top-right' => __( 'Top Right', 'royal-addons-for-elementor' ),'center-left' => __( 'Center Left', 'royal-addons-for-elementor' ),'center-right' => __( 'Center Right', 'royal-addons-for-elementor' ),'bottom-left' => __( 'Bottom Left', 'royal-addons-for-elementor' ),'bottom-center' => __( 'Bottom Center', 'royal-addons-for-elementor' ),'bottom-right' => __( 'Bottom Right', 'royal-addons-for-elementor' ),],]);
		$this->add_control('icon_direction', ['label' => __( 'Icon Direction', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'br_both_tl', 'options' => ['br_both_tl' => 'Bottom Right -> Top & Left','br_top' => 'Bottom Right -> Top','br_left' => 'Bottom Right -> Left','bl_both_tr' => 'Bottom Left -> Top & Right','bl_top' => 'Bottom Left -> Top','bl_right' => 'Bottom Left -> Right','tr_both_bl' => 'Top Right -> Bottom & Left','tr_bottom' => 'Top Right -> Bottom','tr_left' => 'Top Right -> Left','tl_both_br' => 'Top Left -> Bottom & Right','tl_bottom' => 'Top Left -> Bottom','tl_right' => 'Top Left -> Right','bc_both_lr' => 'Bottom Center -> Left & Right',],]);
		$this->add_control('social_behavior', ['label' => esc_html__( 'Behavior', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'open_close', 'options' => ['open_close' => esc_html__( 'Open & Close on Click', 'royal-addons-for-elementor' ), 'always_open' => esc_html__( 'Always Open', 'royal-addons-for-elementor' )], 'separator' => 'before',]);
		$this->add_control('toggle_settings_heading', ['label' => __( 'Toggle Button', 'elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before', 'condition' => [ 'social_behavior' => 'open_close' ],]);
		$this->add_control('social_open_icon', ['label' => __( 'Open Icon', 'elementor' ), 'type' => Controls_Manager::ICONS, 'default' => [ 'value' => 'fas fa-plus', 'library' => 'fa-solid' ], 'skin' => 'inline', 'label_block' => false, 'condition' => [ 'social_behavior' => 'open_close' ],]);
		$this->add_control('social_close_icon', ['label' => __( 'Close Icon', 'elementor' ), 'type' => Controls_Manager::ICONS, 'default' => [ 'value' => 'fas fa-times', 'library' => 'fa-solid' ], 'skin' => 'inline', 'label_block' => false, 'condition' => [ 'social_behavior' => 'open_close' ],]);
		$this->add_control('pulse_animation', ['label' => esc_html__( 'Pulse Animation', 'elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => [ 'social_behavior' => 'open_close' ],]);
		$this->end_controls_section();

		// --- Style Tab ---
		$this->start_controls_section('style_button_section', ['label' => __( 'Button Style', 'elementor' ), 'tab' => Controls_Manager::TAB_STYLE]);
		
        $this->add_responsive_control('button_size', [
            'label' => __( 'Button Size', 'elementor' ), 
            'type' => Controls_Manager::SLIDER, 
            'size_units' => [ 'px' ], 
            'range' => [ 'px' => [ 'min' => 20, 'max' => 100 ] ], 
            'default' => [ 'unit' => 'px', 'size' => 50 ], 
            'selectors' => [
                '{{WRAPPER}} .royalfloatsocialbuttons' => '--rfs-button-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .royalfloatsocialbuttons:not(.behavior-always-open)' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .royalfloatsocialbuttons.behavior-always-open .rfs-item' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ],
        ]);

		$this->add_responsive_control('icon_size', [
            'label' => __( 'Icon Size', 'elementor' ), 
            'type' => Controls_Manager::SLIDER, 
            'size_units' => [ 'px', 'em', 'rem' ], 
            'range' => [ 'px' => [ 'min' => 10, 'max' => 50 ] ], 
            'default' => [ 'unit' => 'rem', 'size' => 1.2 ], 
            'selectors' => [
                '{{WRAPPER}} .rfs-item .elementor-icon, {{WRAPPER}} .rfs-toggle .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);
		
        $this->add_responsive_control('icon_padding', [
			'label' => __( 'Icon Padding', 'elementor' ), 
            'type' => Controls_Manager::DIMENSIONS, 
            'size_units' => [ 'px', 'em', '%' ],
			'selectors' => [
                '{{WRAPPER}} .rfs-item .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing: content-box !important;',
            ],
		]);

		$this->add_control('toggle_colors_heading', ['label' => __( 'Toggle Button Colors', 'elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before', 'condition' => [ 'social_behavior' => 'open_close' ],]);
		$this->add_control('toggle_bg_color', ['label' => esc_html__( 'Background Color', 'elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#333', 'selectors' => [ '{{WRAPPER}} .rfs-toggle' => 'background-color: {{VALUE}};' ], 'condition' => [ 'social_behavior' => 'open_close' ],]);
		$this->add_control('toggle_icon_color', ['label' => esc_html__( 'Icon Color', 'elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#fff', 'selectors' => [ '{{WRAPPER}} .rfs-toggle' => 'color: {{VALUE}};' ], 'condition' => [ 'social_behavior' => 'open_close' ],]);
		$this->end_controls_section();

		$this->start_controls_section('style_position_section', ['label' => __( 'Position & Spacing', 'elementor' ), 'tab' => Controls_Manager::TAB_STYLE]);
		$this->add_responsive_control('offset_x', ['label' => __( 'Offset X', 'elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => -500, 'max' => 500 ] ], 'default' => [ 'unit' => 'px', 'size' => 20 ], 'selectors' => ['{{WRAPPER}} .royalfloatsocialbuttons' => '--rfs-offset-x: {{SIZE}}{{UNIT}};'],]);
		$this->add_responsive_control('offset_y', ['label' => __( 'Offset Y', 'elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => -500, 'max' => 500 ] ], 'default' => [ 'unit' => 'px', 'size' => 20 ], 'selectors' => ['{{WRAPPER}} .royalfloatsocialbuttons' => '--rfs-offset-y: {{SIZE}}{{UNIT}};'],]);
		$this->add_responsive_control('icon_spacing', ['label' => __( 'Spacing Between Icons', 'elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => [ 'px' ], 'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ], 'default' => [ 'unit' => 'px', 'size' => 10 ], 'selectors' => ['{{WRAPPER}} .royalfloatsocialbuttons' => '--rfs-spacing: {{SIZE}}{{UNIT}};'],]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id = $this->get_id();
        $is_always_open = $settings['social_behavior'] === 'always_open';

		$this->add_render_attribute('wrapper', [
			'class' => ['royalfloatsocialbuttons', $is_always_open ? 'behavior-always-open' : ''],
			'data-widget-id' => $id, 
            'data-position' => $settings['widget_position'],
			'data-direction' => $settings['icon_direction'], 
            'data-spacing' => !empty($settings['icon_spacing']['size']) ? $settings['icon_spacing']['size'] : 10,
		]);
		?>
		<div <?php $this->print_render_attribute_string('wrapper'); ?>>
			<?php if (!$is_always_open) : ?>
				<div class="rfs-toggle <?php echo $settings['pulse_animation'] === 'yes' ? 'pulse-active' : '' ?>" role="button" aria-label="Toggle Social Links" tabindex="0">
					<span class="rfs-icon-open"><?php Icons_Manager::render_icon( $settings['social_open_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
					<span class="rfs-icon-close"><?php Icons_Manager::render_icon( $settings['social_close_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
				</div>
			<?php endif; ?>

			<?php foreach ($settings['social_icon_list'] as $index => $item ) :
				$repeater_setting_key = $this->get_repeater_setting_key( 'social_icon', 'social_icon_list', $index );
				$social_class = 'elementor-social-icon-' . preg_replace('/(fa-)|(fab )|(fas )|(far )/', '', $item['social_icon']['value']);
                
                $style = '';
                if ($item['item_icon_color'] === 'custom') {
                    if (!empty($item['item_icon_primary_color'])) {
                        $style .= 'background-color: ' . esc_attr($item['item_icon_primary_color']) . ' !important;';
                    }
                    if (!empty($item['item_icon_secondary_color'])) {
                        $style .= 'color: ' . esc_attr($item['item_icon_secondary_color']) . ' !important;';
                    }
                }

				$this->add_render_attribute($repeater_setting_key, [
					'class' => ['rfs-item', 'elementor-social-icon', $social_class, 'elementor-repeater-item-' . $item['_id']],
					'href' => esc_url($item['link']['url'] ?? '#'),
					'aria-label' => esc_attr( $social_class ),
                    'target' => $item['link']['is_external'] ? '_blank' : '_self',
					'rel' => $item['link']['nofollow'] ? 'nofollow' : '',
                    'style' => $style,
				]);
				?>
				<a <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>>
                    <?php 
                        $icon_style = ($item['item_icon_color'] === 'custom' && !empty($item['item_icon_secondary_color'])) 
                            ? 'style="fill: ' . esc_attr($item['item_icon_secondary_color']) . ' !important;"' 
                            : '';
                    ?>
                    <span class="elementor-icon" <?php echo $icon_style; ?>>
					    <?php Icons_Manager::render_icon( $item['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
				</a>
			<?php endforeach; ?>
		</div>

		<script>
		jQuery(document).ready(function($) {
			function RoyalFloatingButtons_<?php echo esc_attr($id); ?>() {
				const widget = $('.royalfloatsocialbuttons[data-widget-id="<?php echo esc_attr($id); ?>"]');
				if (!widget.length) return;

				const isAlwaysOpen = widget.hasClass('behavior-always-open');
                
                // If always open, CSS handles everything. No JS needed for positioning.
                if (isAlwaysOpen) {
                    return; 
                }

                // The rest of the script is for 'open_close' mode only
				const toggle = widget.find('.rfs-toggle');
				const items = widget.find('.rfs-item');
				const direction = widget.data('direction');
				const spacing = widget.data('spacing');
				let isOpen = false;

				function applyPositions(openState) {
					const buttonSize = widget.outerWidth();
					const totalSpacing = buttonSize + spacing;
					let half = Math.ceil(items.length / 2);

					items.each(function(i) {
						let h_offset = 0, v_offset = 0;
						let transform = 'translate(0, 0) scale(0.5)';
						
						if (openState) {
							let index = i + 1;
							
							switch(direction) {
								case 'br_both_tl':
									if (i < half) { h_offset = index * totalSpacing; } else { v_offset = (index - half) * totalSpacing; }
									transform = `translate(-${h_offset}px, -${v_offset}px) scale(1)`; break;
								case 'br_top':
									v_offset = index * totalSpacing; transform = `translate(0, -${v_offset}px) scale(1)`; break;
								case 'br_left':
									h_offset = index * totalSpacing; transform = `translate(-${h_offset}px, 0) scale(1)`; break;
								case 'bl_both_tr':
									if (i < half) { h_offset = index * totalSpacing; } else { v_offset = (index - half) * totalSpacing; }
									transform = `translate(${h_offset}px, -${v_offset}px) scale(1)`; break;
								case 'bl_top':
									v_offset = index * totalSpacing; transform = `translate(0, -${v_offset}px) scale(1)`; break;
								case 'bl_right':
									h_offset = index * totalSpacing; transform = `translate(${h_offset}px, 0) scale(1)`; break;
								case 'tr_both_bl':
									if (i < half) { h_offset = index * totalSpacing; } else { v_offset = (index - half) * totalSpacing; }
									transform = `translate(-${h_offset}px, ${v_offset}px) scale(1)`; break;
								case 'tr_bottom':
									v_offset = index * totalSpacing; transform = `translate(0, ${v_offset}px) scale(1)`; break;
								case 'tr_left':
									h_offset = index * totalSpacing; transform = `translate(-${h_offset}px, 0) scale(1)`; break;
								case 'tl_both_br':
									if (i < half) { h_offset = index * totalSpacing; } else { v_offset = (index - half) * totalSpacing; }
									transform = `translate(${h_offset}px, ${v_offset}px) scale(1)`; break;
								case 'tl_bottom':
									v_offset = index * totalSpacing; transform = `translate(0, ${v_offset}px) scale(1)`; break;
								case 'tl_right':
									h_offset = index * totalSpacing; transform = `translate(${h_offset}px, 0) scale(1)`; break;
								case 'bc_both_lr':
									let mid = (items.length -1) / 2; h_offset = (i - mid) * totalSpacing;
									transform = `translate(${h_offset}px, 0) scale(1)`; break;
                                default:
                                    v_offset = index * totalSpacing; transform = `translate(0, -${v_offset}px) scale(1)`; break;
							}
						}
						$(this).css('transform', transform);
					});
				}

				toggle.on('click', function() {
					isOpen = !isOpen;
					widget.toggleClass('is-open', isOpen);
					applyPositions(isOpen);
				});
			}
			RoyalFloatingButtons_<?php echo esc_attr($id); ?>();
		});
		</script>
		<?php
	}
}
