<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Plugin as ElementorPlugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalOffCanvas extends Widget_Base {

    public function get_name() {
        return 'royaloffcanvas';
    }

    public function get_title() {
        return esc_html__( 'Off-Canvas', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-sidebar rtbranding'; }

    public function get_keywords() {
        return [ 'off', 'canvas', 'sidebar', 'panel', 'drawer', 'royal', 'tech', 'technologies', 'mehdi', 'akram' ];
    }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_style_depends() {
        return [ 'royaloffcanvas' ];
    }

    public function get_script_depends() {
        return [ 'royaloffcanvas' ];
    }

    protected function register_controls() {
        
        //============================================
        // Toggle Button Tab
        //============================================
        $this->start_controls_section(
            'section_button',
            [
                'label' => esc_html__( 'Toggle Button', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Open Panel', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-bars',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__( 'Icon Position', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => esc_html__( 'Before Text', 'royal-addons-for-elementor' ),
                    'after' => esc_html__( 'After Text', 'royal-addons-for-elementor' ),
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => __('Left', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => __('Right', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-offcanvas-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        //============================================
        // Panel Settings Tab
        //============================================
        $this->start_controls_section(
            'section_panel_settings',
            [
                'label' => esc_html__( 'Panel Settings', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'panel_position',
            [
                'label' => esc_html__( 'Position', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
                    'right' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'panel_title',
            [
                'label' => esc_html__( 'Panel Title', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Off-Canvas Menu', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'panel_content_type',
            [
                'label' => esc_html__( 'Content Type', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__( 'Custom Text/HTML', 'royal-addons-for-elementor' ),
                    'template' => esc_html__( 'Elementor Template', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'panel_content_text',
            [
                'label' => esc_html__( 'Custom Content', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Add your custom content here.', 'royal-addons-for-elementor' ),
                'condition' => [
                    'panel_content_type' => 'text',
                ],
            ]
        );

        $this->add_control(
            'panel_template',
            [
                'label' => esc_html__( 'Select Template', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_all_elementor_templates(),
                'label_block' => true,
                'condition' => [
                    'panel_content_type' => 'template',
                ],
            ]
        );

        $this->end_controls_section();

        //============================================
        // Button Style Tab
        //============================================
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__( 'Toggle Button', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .royal-offcanvas-btn',
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab('button_normal', ['label' => esc_html__('Normal', 'royal-addons-for-elementor')]);
        $this->add_control('button_text_color', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-offcanvas-btn' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('button_icon_color', [
            'label' => esc_html__('Icon Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royal-offcanvas-btn i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royal-offcanvas-btn svg' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'button_background',
            'selector' => '{{WRAPPER}} .royal-offcanvas-btn',
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('button_hover', ['label' => esc_html__('Hover', 'royal-addons-for-elementor')]);
        $this->add_control('button_hover_color', [
            'label' => esc_html__('Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-offcanvas-btn:hover' => 'color: {{VALUE}};'],
        ]);
        $this->add_control('button_icon_hover_color', [
            'label' => esc_html__('Icon Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .royal-offcanvas-btn:hover i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .royal-offcanvas-btn:hover svg' => 'fill: {{VALUE}};',
            ],
        ]);
        $this->add_group_control(Group_Control_Background::get_type(), [
            'name' => 'button_hover_background',
            'selector' => '{{WRAPPER}} .royal-offcanvas-btn:hover',
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-offcanvas-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .royal-offcanvas-btn',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-offcanvas-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //============================================
        // Panel Style Tab
        //============================================
        $this->start_controls_section(
            'section_style_panel',
            [
                'label' => esc_html__( 'Panel', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'panel_width',
            [
                'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vw', '%' ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 350,
                ],
                'selectors' => [
                    '#royal-offcanvas-{{ID}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'panel_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '#royal-offcanvas-{{ID}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'panel_header_bg',
            [
                'label' => esc_html__( 'Header Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '#royal-offcanvas-{{ID}} .royal-offcanvas-header' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'panel_title_color',
            [
                'label' => esc_html__( 'Title Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '#royal-offcanvas-{{ID}} .royal-offcanvas-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__( 'Title Typography', 'royal-addons-for-elementor' ),
                'selector' => '#royal-offcanvas-{{ID}} .royal-offcanvas-title',
            ]
        );
        
        $this->add_control(
            'close_icon_color',
            [
                'label' => esc_html__( 'Close Icon Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '#royal-offcanvas-{{ID}} .royal-offcanvas-close' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'close_icon_hover_color',
            [
                'label' => esc_html__( 'Close Icon Hover Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '#royal-offcanvas-{{ID}} .royal-offcanvas-close:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $panel_id = 'royal-offcanvas-' . $id;

        // Render Toggle Button
        ?>
        <div class="royal-offcanvas-wrapper">
            <a href="#" class="royal-offcanvas-btn" data-target="<?php echo esc_attr($panel_id); ?>">
                <?php if ( ! empty($settings['button_icon']['value']) && 'before' === $settings['icon_position'] ) : ?>
                    <?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                <?php endif; ?>
                
                <span><?php echo esc_html( $settings['button_text'] ); ?></span>
                
                <?php if ( ! empty($settings['button_icon']['value']) && 'after' === $settings['icon_position'] ) : ?>
                    <?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                <?php endif; ?>
            </a>
        </div>
        
        <?php
        // Render Panel outside of standard Elementor DOM flow if needed, but for simplicity we render it here.
        // It uses fixed positioning so its location in DOM doesn't strictly matter as long as z-index is high.
        $position_class = 'position-' . esc_attr($settings['panel_position']);
        ?>
        <div id="overlay-<?php echo esc_attr($panel_id); ?>" class="royal-offcanvas-overlay"></div>
        <div id="<?php echo esc_attr($panel_id); ?>" class="royal-offcanvas-panel <?php echo esc_attr($position_class); ?>">
            <div class="royal-offcanvas-header">
                <h4 class="royal-offcanvas-title"><?php echo esc_html($settings['panel_title']); ?></h4>
                <button class="royal-offcanvas-close" aria-label="Close Panel">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="royal-offcanvas-content">
                <?php
                if ( 'template' === $settings['panel_content_type'] && ! empty( $settings['panel_template'] ) ) {
                    echo ElementorPlugin::instance()->frontend->get_builder_content_for_display( $settings['panel_template'], true );
                } else {
                    echo wp_kses_post( $settings['panel_content_text'] );
                }
                ?>
            </div>
        </div>
        <?php
    }

    private function get_all_elementor_templates() {
        $options = [];
        if ( ! class_exists( 'Elementor\Plugin' ) ) { return $options; }
        
        // Use Elementor Templates Manager
        $templates_manager = ElementorPlugin::instance()->templates_manager;
        if ( method_exists( $templates_manager, 'get_source' ) ) {
            $templates = $templates_manager->get_source( 'local' )->get_items();
            if ( empty( $templates ) ) { 
                $options['0'] = esc_html__( 'No templates found.', 'royal-addons-for-elementor' ); 
                return $options; 
            }
            $options['0'] = esc_html__( 'Select a Template', 'royal-addons-for-elementor' );
            foreach ( $templates as $template ) { 
                $options[ $template['template_id'] ] = $template['title'] . ' (' . ucfirst( $template['type'] ) . ')'; 
            }
        }
        return $options;
    }
}
