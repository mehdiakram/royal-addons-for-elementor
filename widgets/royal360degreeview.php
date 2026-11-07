<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Royal360DegreeView extends Widget_Base {

    public function get_name() {
        return 'royal360degreeview';
    }

    public function get_title() {
        return esc_html__( '360 Degree View', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-image-rollover rtbranding'; }

    public function get_keywords() {
        return [ '360', 'degree', 'spin', 'rotate', 'product', 'image', 'royal', 'tech', 'technologies', 'mehdi', 'akram' ];
    }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_style_depends() {
        return [ 'royal360degreeview' ];
    }

    public function get_script_depends() {
        return [ 'royal360degreeview' ];
    }

    protected function register_controls() {
        
        //============================================
        // Content Tab
        //============================================
        $this->start_controls_section(
            'section_images',
            [
                'label' => esc_html__( '360 Images', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'images',
            [
                'label' => esc_html__( 'Add Images', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::GALLERY,
                'default' => [],
                'description' => esc_html__( 'Upload a sequence of images (e.g., 36 images for a 360-degree rotation).', 'royal-addons-for-elementor' ),
            ]
        );
        
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        //============================================
        // Settings Tab
        //============================================
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'drag_speed',
            [
                'label' => esc_html__( 'Drag Speed (Sensitivity)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'description' => esc_html__( 'Lower number means faster rotation when dragging.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__( 'Autoplay Speed (ms)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 50,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'description' => esc_html__( 'Time between frame changes in milliseconds. Lower is faster.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->end_controls_section();

        //============================================
        // Style Tab
        //============================================
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Container', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'container_width',
            [
                'label' => esc_html__( 'Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-360-view-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => ['title' => __('Left', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-center'],
                    'right' => ['title' => __('Right', 'royal-addons-for-elementor'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royal-360-view-wrapper' => 'margin-{{VALUE}}: auto;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'container_bg',
                'selector' => '{{WRAPPER}} .royal-360-view-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .royal-360-view-wrapper',
            ]
        );

        $this->add_control(
            'container_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .royal-360-view-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .royal-360-view-wrapper',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if ( empty( $settings['images'] ) ) {
            if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                echo '<div class="royal-elementor-alert">' . esc_html__( 'Please add images to the 360 Degree View gallery.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        $image_urls = [];
        foreach ( $settings['images'] as $image ) {
            $img_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'image', $settings );
            if ( ! $img_url ) {
                $img_url = $image['url'];
            }
            $image_urls[] = $img_url;
        }

        $this->add_render_attribute( 'wrapper', 'class', 'royal-360-view-wrapper' );
        $this->add_render_attribute( 'wrapper', 'data-images', wp_json_encode( $image_urls ) );
        $this->add_render_attribute( 'wrapper', 'data-speed', $settings['drag_speed']['size'] );
        if ( 'yes' === $settings['autoplay'] ) {
            $this->add_render_attribute( 'wrapper', 'data-autoplay', 'true' );
            $this->add_render_attribute( 'wrapper', 'data-autoplay-speed', $settings['autoplay_speed'] );
        }

        // Output first image as placeholder/initial state
        $initial_image = $image_urls[0];
        ?>
        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <div class="royal-360-preloader">
                <div class="royal-360-spinner"></div>
            </div>
            <div class="royal-360-view-container">
                <img src="<?php echo esc_url( $initial_image ); ?>" class="royal-360-view-image" alt="<?php esc_attr_e( '360 Degree Product View', 'royal-addons-for-elementor' ); ?>" />
            </div>
        </div>
        <?php
    }
}
