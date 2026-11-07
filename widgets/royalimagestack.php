<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || die();

class RoyalImageStack extends Widget_Base {

	public function get_name() {
        return 'royalimagestack';
    }

	public function get_title() {
		return __( 'Image Stack Group', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'royalimagestack rtbranding'; }

	public function get_keywords() {
		return [ 'image', 'stack', 'icon', 'group', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

    public function get_categories() {
        return ['royaltech'];
    }

    public function get_style_depends() {
		$styles = ['royalimagestack'];
		return $styles;
	}

	protected function register_controls() {
		$this->content_controls(); 
		$this->style_controls(); 
	}

	private function content_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Items', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'media_type',
			[
				'label' => __( 'Media Type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'img' => [
						'title' => __( 'Image', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-image',
					],
					'icon' => [
						'title' => __( 'Icon', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-star',
					],
				],
				'default' => 'img',
				'toggle' => false,
			]
		);
	
		$repeater->add_control(
			'selected_icon',
			[
				'label' => __('Icon', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block' => false,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
				'default' => [
					'value' => 'fas fa-smile-wink',
					'library' => 'fa-solid',
				],
				'condition' => [ 'media_type' => 'icon' ]
			]
		);

		$repeater->add_control(
			'image',
			[
				'type' => Controls_Manager::MEDIA,
				'label' => __( 'Image', 'royal-addons-for-elementor' ),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [ 'media_type' => 'img' ],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'tooltip',
			[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => __( 'Tooltip', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Type title here', 'royal-addons-for-elementor' ),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'tooltip_position',
			[
				'label' => __( 'Tooltip Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'  => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left'
					],
					'up'  => [
						'title' => __( 'Up', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top'
					],
					'down'  => [
						'title' => __( 'Down', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom'
					],
					'right'  => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right'
					],
				],
				'toggle' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'https://example.com',
				'dynamic' => [
					'active' => true,
				]
			]
		);


		$repeater->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'media_type' => 'icon' ],
				'selectors' => [
					'{{WRAPPER}} .royal-imagestack-item{{CURRENT_ITEM}} i,{{WRAPPER}} .royal-imagestack-item{{CURRENT_ITEM}} .fw-svg-wrap' => 'color: {{VALUE}}'
				]
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg_color',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .royal-imagestack-item{{CURRENT_ITEM}} i'
			]
		);

		$repeater->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);


		$repeater->add_control(
			'border_color_item',
			[
				'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}} img' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} {{CURRENT_ITEM}} .fw-svg-wrap' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$placeholder = [
			'image' => [
				'url' => Utils::get_placeholder_image_src(),
			],
		];

		$this->add_control(
			'images',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print(tooltip || "Image Group Item"); #>',
				'default' => array_fill( 0, 4, $placeholder )
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					]
				],
				'toggle' => true,
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();
	}

	private function style_controls() {
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Image / Icon', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'img_size',
			[
				'label' => __( 'Item Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-imagestack-item i,{{WRAPPER}} .royal-imagestack-item img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-imagestack-item i,{{WRAPPER}} .royal-imagestack-item .fw-svg-wrap' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-imagestack-item i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .royal-imagestack-item svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-imagestack-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hr1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_responsive_control(
			'icon_border_size',
			[
				'label' => __( 'Border Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'default' => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-imagestack-item i,{{WRAPPER}} .royal-imagestack-item img,{{WRAPPER}} .royal-imagestack-item .fw-svg-wrap' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-imagestack-item i' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .royal-imagestack-item img' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .royal-imagestack-item .fw-svg-wrap' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-imagestack-item,{{WRAPPER}}  .royal-imagestack-item i, {{WRAPPER}} .royal-imagestack-item img, {{WRAPPER}} .royal-imagestack-item .fw-svg-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_control(
			'hr2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-imagestack-item i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .royal-imagestack-item .fw-svg-wrap' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg_color',
				'label' => __( 'Background', 'royal-addons-for-elementor' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .royal-imagestack-item i,{{WRAPPER}} .royal-imagestack-item .fw-svg-wrap'
			]
		);

		$this->add_group_control( Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'label' => __( 'Box Shadow', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .royal-imagestack-item-outline',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'_section_style_tooltip',
			[
				'label' => __( 'Tooltips', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tooltip_position',
			[
				'label' => __( 'Position', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'  => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left'
					],
					'up'  => [
						'title' => __( 'Up', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top'
					],
					'down'  => [
						'title' => __( 'Down', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom'
					],
					'right'  => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right'
					],
				],
				'default' => 'up',
				'toggle' => false,
			]
		);

		$this->add_responsive_control(
			'tooltip_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} [tooltip]::after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
            'tooltip_border_radius',
            [
                'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} [tooltip]::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

		$this->add_control(
			'hr3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control( Group_Control_Typography::get_type(),
			[
				'name' => 'tooltip_content_typography',
				'label' => __( 'Typography', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} [tooltip]::after',
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label' => __( 'Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} [tooltip]::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tooltip_background',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} [tooltip]::after' => 'background: {{VALUE}};',
					'{{WRAPPER}} [tooltip]::before' => '--caret-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control( Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'tooltip_box_shadow',
				'label' => __( 'Box Shadow', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} [tooltip]::after',
			]
		);

		$this->end_controls_section();
	}

	
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['images'] ) ) {
			return;
		}

		$fs_inline_fw = \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_font_icon_svg' );
		?>

		<div class="royal-imagestack">
			<?php foreach ( $settings['images'] as $item ) :
				$media_type = $item['media_type'];


				$item_id = 'elementor-repeater-item-' . esc_attr( $item['_id'] );

				if($media_type == "icon"){
					$bgType = $item['icon_bg_color_background'];
					$bg = $item['icon_bg_color_color'];
					$bgGlobal = isset($item['__globals__'])?$item['__globals__']['icon_bg_color_color']:'';

					$library = $item['selected_icon']['library'];
					$library = explode('-', $library);
					$library = $library[0];

					if($bgGlobal){
						$bgGlobal = explode("=",$bgGlobal);
						$bgGlobal = $bgGlobal[1];
						$bgGlobal = 'var(--e-global-color-'.$bgGlobal.')';
					}

					$backGround = $bg?$bg:$bgGlobal;

					if($bgType == 'classic'){
						$attr['style'] = "background:".$backGround." !important";
					}else{
						$attr['style'] = "";
					}

					ob_start();
					ha_render_icon( $item, 'icon', 'selected_icon', $attr);
					$content = ob_get_clean();

					if($fs_inline_fw && $library == "fa"){
						$content = '<span class="fw-svg-wrap">'.$content.'</span>';
					}
				}else{

					if(isset($item['image']) && $item['image']['url'] != ''){
						$img_url = $item['image']['url'];
					}else{
						$img_url = Utils::get_placeholder_image_src();
					}

					$content = '<img src="'.esc_url($img_url).'" alt="">';
				}

				$tooltip_data = '';

				$tooltip_txt = $item['tooltip'];
				if(!empty($item['tooltip_position'])){
					$tooltip_position = $item['tooltip_position'];
				}else{
					$tooltip_position = $settings['tooltip_position'];
				}

				if($tooltip_txt){
					$tooltip_data = 'tooltip="' . esc_attr( $tooltip_txt ) . '" flow="' . esc_attr( $tooltip_position ) . '"';
				}

				$id = 'royal-imagestack-item-' . esc_attr( $item['_id'] );

				$link = $item['link'];

				if(!empty($link['url'])){
					$this->add_link_attributes( $id, $item['link'] );
					$wrap_start = '<a '.$this->get_render_attribute_string( $id ).' class="royal-imagestack-item royal-imagestack-item-outline '.$item_id.'" '.$tooltip_data.'>';
					$wrap_end   = '</a>';
				}else{
					$wrap_start = '<span class="royal-imagestack-item royal-imagestack-item-outline '.$item_id.'" '.$tooltip_data.'>';
					$wrap_end   = '</span>';
				}

				echo $wrap_start, $content, $wrap_end;

			endforeach; ?>

		</div>

		<?php
	}
}
