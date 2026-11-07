<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



class RoyalCameraSlider extends Widget_Base {

    public function get_name() {
        return 'royalcameraslider';
    }


    public function get_title() {
        return 'Royal Camera Slider';
    }


    public function get_icon() { return 'eicon-slider-album rtbranding'; }


    public function get_categories() {
        return array('royaltech');
    }
    public function get_keywords() { return [ 'royal', 'camera', 'slider', 'tech', 'technologies', 'mehdi', 'akram' ]; }



    protected function register_controls() {
        $this->start_controls_section(
            'section_typing_text',
            [
                'label' => __('Camera Slider', 'royal-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );



        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
          'slider_image',
          [
            'label' => __( 'Slider Image', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
              'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
          ]
        );

        $repeater->add_group_control(
          Group_Control_Image_Size::get_type(),
          [
            'name' => 'slider_image_size', 
            'default' => 'image1400x560',
            'separator' => 'none',
          ]
        );

        $repeater->add_control(
          'slider_title',
          [
            'label' => __( 'Slider Title', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Slider Title', 'royal-addons-for-elementor' ),
            'placeholder' => __( 'Type your title here', 'royal-addons-for-elementor' ),
          ]
        );

        $repeater->add_control(
          'show_title',
          [
            'label' => __( 'Show Title', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => __( 'Show', 'royal-addons-for-elementor' ),
            'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
            'return_value' => 'yes',
            'default' => 'flase',
          ]
        );


        $repeater->add_control(
          'description1',
          [
            'label' => __( 'Description1', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Slider Description1', 'royal-addons-for-elementor' ),
            'placeholder' => __( 'Type your description here', 'royal-addons-for-elementor' ),
          ]
        );

        $repeater->add_control(
            'desc1_color',
            [
                'label' => __( 'Description1 Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
            ]
        );

        $repeater->add_control(
            'desc1_animation',
            [
                'label' => __( 'Description1 Animation', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::ANIMATION,
                // 'prefix_class' => 'animated ',
            ]
        );


        $repeater->add_control(
            'description2',
            [
                'label' => __( 'Description2', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Slider Description2', 'royal-addons-for-elementor' ),
                'placeholder' => __( 'Type your description here', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'desc2_color',
            [
                'label' => __( 'Description2 Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
            ]
        );

        $repeater->add_control(
            'desc2_animation',
            [
                'label' => __( 'Description2 Animation', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::ANIMATION,
                // 'prefix_class' => 'animated ',
            ]
        );


        $this->add_control(
            'sliderimages',
            [
                'label' => __( 'Slider Images', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ slider_title }}}',
            ]
        );


        $this->add_control(
            'slider_Settings',
            [
                'label' => __( 'Slider Settings', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'slider_loader',
            [
                'label' => __( 'Slider Loader', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'pie'  => __( 'Pie', 'royal-addons-for-elementor' ),
                    'bar' => __( 'Bar', 'royal-addons-for-elementor' ),
                    'none' => __( 'None', 'royal-addons-for-elementor' ),
                ],
            ]
        );        


        $this->add_control(
            'slider_navigation',
            [
                'label' => __( 'Slider Navigation', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'false'  => __('Hide', 'royal-addons-for-elementor'),
                    'true' => __('Show', 'royal-addons-for-elementor'),
                ],
            ]
        );


        $this->add_control(
            'duration',
            [
                'label'         => __( 'Slider Duration (Milliseconds)', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min'           => 1000,
                'max'           => 30000,
                'step'          => 100,
                'default'       => 7000,
            ]
        );



        $this->add_control(
            'transperiod',
            [
                'label'         => __( 'Slider Trans Period (Milliseconds)', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min'           => 100,
                'max'           => 9000,
                'step'          => 100,
                'default'       => 1500,
            ]
        );


        $this->end_controls_section();



    }



    protected function render() {
        $settings = $this->get_settings_for_display();
        $sliderid =   'cameraslider'.esc_attr( $this->get_id() );
        

        if ( $settings['sliderimages'] ) { ?>
        <div class="fluid_container">
            <div class="camera_wrap camera_azure_skin" id="<?php echo $sliderid;?>">
            <?php foreach ( $settings['sliderimages'] as $item ) {
            $slider_image_id = $item['slider_image']['id'];
            $image_src = Group_Control_Image_Size::get_attachment_image_src($slider_image_id, 'slider_image_size', $item);
            ?>
                <div data-thumb="<?php echo $image_src; ?>" data-src="<?php echo $image_src; ?>">
                    <div class="cameraverticalcenter">
                      <?php if ( $item['description1'] ) : ?>
                        <div class="camera_effected cameradescription1 animated <?php echo $item['desc1_animation'] ?>" style="color:<?php echo $item['desc1_color']?>;"><?php echo $item['description1']?></div>
                      <?php endif; ?>
                      <?php if ( $item['description2'] ) : ?>
                        <div class="camera_effected cameradescription2 animated <?php echo $item['desc2_animation'] ?>" style="color:<?php echo $item['desc2_color']?>;"><?php echo $item['description2']?></div>
                      <?php endif; ?>
                    </div>
                    <?php if ( 'yes' === $item['show_title'] ) { ?>
                    <div class="camera_caption fadeFromBottom"><?php echo wp_kses_post( $item['slider_title'] );?></div>
                    <?php } ?>
                </div>
            <?php } ?>
            </div>
        </div>
        <?php } ?>

        <script type="text/javascript">
        jQuery.noConflict();
            jQuery(function(){
                jQuery('#<?php echo $sliderid;?>').camera({
                    height      : '40%',
                    loader      : "<?php echo wp_kses_post( $settings['slider_loader'] ) ?>", //pie, bar, none
                    navigation  : <?php echo wp_kses_post( $settings['slider_navigation'] ) ?>,
                    playPause   : <?php echo wp_kses_post( $settings['slider_navigation'] ) ?>,
                    time        : <?php echo wp_kses_post( $settings['duration'] ) ?>,  // Millisecond stay
                    transPeriod : <?php echo wp_kses_post( $settings['transperiod'] ) ?>, // MS txn time

                    pagination  : false,                    
                    thumbnails  : false
                });
            });
        </script>

    <?php
    }



    protected function content_template() {
        
    }



}