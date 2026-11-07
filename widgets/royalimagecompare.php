<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
if (!defined('ABSPATH')) exit; // Exit if accessed directly


class RoyalImageCompare extends Widget_Base {
    public function get_name(){
        return 'royalimagecompare';
    }

    public function get_title() {
        return 'Image Compare';
    }


    public function get_icon() { return 'eicon-image-box rtbranding'; }


    public function get_keywords() {
        return [ 'compare', 'image', 'before', 'after', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

    public function get_categories(){
        return ['royaltech'];
    }


    protected function register_controls() {

        $this->start_controls_section(
          'content_section',
          [
            'label' => __( 'Images', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
          ]
        );


        $this->start_controls_tabs( '_tab_images' );
        $this->start_controls_tab(
            '_tab_before_image',
            [
                'label' => __( 'Before', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'before_image',
            [
                'label' => __( 'Before Image', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'before_label',
            [
                'label' => __( 'Label', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Before', 'royal-addons-for-elementor' ),
                'placeholder' => __( 'Type before image label', 'royal-addons-for-elementor' ),
                'description' => __( 'Label will not be shown if Hide Overlay is enabled in Settings', 'royal-addons-for-elementor' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            '_tab_after_image',
            [
                'label' => __( 'After', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'after_image',
            [
                'label' => __( 'After Image', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'after_label',
            [
                'label' => __( 'Label', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'After', 'royal-addons-for-elementor' ),
                'placeholder' => __( 'Type after image label', 'royal-addons-for-elementor' ),
                'description' => __( 'Label will not be shown if Hide Overlay is enabled in Settings', 'royal-addons-for-elementor' ),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'image1140x570',
                'separator' => 'before',
            ]
        );


        $this->end_controls_section();




        $this->start_controls_section(
          'icon_section',
          [
            'label' => __( 'Handler Icon', 'royal-addons-for-elementor' ),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
          ]
        );


        $this->add_control(
            'handler_icon', [
                'label' => __( 'Choose Handler Icon', 'royal-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrows-alt-h',
                    'library' => 'solid',
                ],
                'recommended' => [
                  'fa-solid' => [
                    'arrows-alt-h',
                    'arrows-alt',
                    'expand-arrows-alt',
                  ],
                  'fa-regular' => [
                    'hand-paper',
                  ],
                ],
                'label_block' => true,
            ]
        );


        $this->end_controls_section();



        // Style Section TAB
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Icon', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        // Handle Icon Background
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'handleiconbackground',
                'label' => __( 'Handle Icon Background', 'royal-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .royalimagecompare .handle .icon',
            ]
        );


        $this->end_controls_section();





        // Style Handler TAB
        $this->start_controls_section(
            'style_section_handler',
            [
                'label' => __( 'Handler', 'royal-addons-for-elementor' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'handler_color',
            [
                'label' => __( 'Handler Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .royalimagecompare .handle .icon' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .royalimagecompare .handle' => 'background: {{VALUE}}',

                ],
            ]
        );





        $this->add_responsive_control(
            'handler_box_width',
            [
                'label' => __( 'Handler Box Width', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalimagecompare .handle .icon' => 'width: {{SIZE}}{{UNIT}}; margin-left: calc(-1 * ({{SIZE}}{{UNIT}} / 2));',
                ],
            ]
        );


        $this->add_responsive_control(
            'arrow_box_height',
            [
                'label' => __( 'Handler Box Height', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalimagecompare .handle .icon' => 'height: {{SIZE}}{{UNIT}}; margin-top: calc(-1 * ({{SIZE}}{{UNIT}} / 2));',
                ],
            ]
        );



        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .royalimagecompare .handle .icon',
                'exclude' => [
                     'color'
                ]
            ]
        );





        $this->add_responsive_control(
            'handler_box_size',
            [
                'label' => __( 'Handler Icon Size', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 84,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalimagecompare .handle .icon i' => 'font-size: {{SIZE}}{{UNIT}}; top: calc(50% - ({{SIZE}}{{UNIT}} / 2)); left: calc(50% - ({{SIZE}}{{UNIT}} / 2));',
                ],
            ]
        );


        $this->add_responsive_control(
            'handler_box_border_radius',
            [
                'label' => __( 'Box Border Radious', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .royalimagecompare .handle .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();






    }

	protected function render() {
        $settings = $this->get_settings_for_display();     
        ?>

    <div class="royalimagecompare">
      <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'after_image' ); ?>    
      <div class="resize"><?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'before_image' ); ?></div>
      <span class="handle"><span class="icon"><i class="<?php echo $settings['handler_icon']['value']; ?>"></i></span></span>

      <?php if ( $settings['before_label'] && $settings['after_label']) : ?>
      <span class="beforetext"><?php echo wp_kses_post( $settings['before_label'] ) ?></span>
      <span class="aftertext"><?php echo wp_kses_post( $settings['after_label'] ) ?></span>        
      <?php endif; ?>
    </div>

    <script type="text/javascript">
    jQuery.noConflict();
    (function( $ ) {
        $(function() {

            // More code using $ as alias to jQuery
             // Call & init
            $(document).ready(function(){
              $('.royalimagecompare').each(function(){
                var cur = $(this);
                // Adjust the slider
                var width = cur.width()+'px';
                cur.find('.resize img').css('width', width);
                // Bind dragging events
                drags(cur.find('.handle'), cur.find('.resize'), cur);
              });
            });

            // Update sliders on resize. 
            // Because we all do this: i.imgur.com/YkbaV.gif
            $(window).resize(function(){
              $('.royalimagecompare').each(function(){
                var cur = $(this);
                var width = cur.width()+'px';
                cur.find('.resize img').css('width', width);
              });
            });

            function drags(dragElement, resizeElement, container) {
              
              // Initialize the dragging event on mousedown.
              dragElement.on('mousedown touchstart', function(e) {
                
            //     gtag('create', 'UA-15279170-3', 'auto');
            // ga('send', 'pageview');
                
                dragElement.addClass('draggable');
                resizeElement.addClass('resizable');
                
                
                // Check if it's a mouse or touch event and pass along the correct value
                var startX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;
                
                // Get the initial position
                var dragWidth = dragElement.outerWidth(),
                    posX = dragElement.offset().left + dragWidth - startX,
                    containerOffset = container.offset().left,
                    containerWidth = container.outerWidth();
             
                // Set limits
                minLeft = containerOffset + 10;
                maxLeft = containerOffset + containerWidth - dragWidth - 10;
                
                // Calculate the dragging distance on mousemove.
                dragElement.parents().on("mousemove touchmove", function(e) {
                  
                  // Check if it's a mouse or touch event and pass along the correct value
                  var moveX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;
                  
                  leftValue = moveX + posX - dragWidth;
                  
                  // Prevent going off limits
                  if ( leftValue < minLeft) {
                    leftValue = minLeft;
                  } else if (leftValue > maxLeft) {
                    leftValue = maxLeft;
                  }
                  
                  // Translate the handle's left value to masked divs width.
                  widthValue = (leftValue + dragWidth/2 - containerOffset)*100/containerWidth+'%';
                  
                  // Set the new values for the slider and the handle. 
                  // Bind mouseup events to stop dragging.
                  $('.draggable').css('left', widthValue).on('mouseup touchend touchcancel', function () {
                    $(this).removeClass('draggable');
                    resizeElement.removeClass('resizable');
                  });
                  $('.resizable').css('width', widthValue);
                }).on('mouseup touchend touchcancel', function(){
                  dragElement.removeClass('draggable');
                  resizeElement.removeClass('resizable');
                });
                e.preventDefault();
              }).on('mouseup touchend touchcancel', function(e){
                dragElement.removeClass('draggable');
                resizeElement.removeClass('resizable');
              });
            }   

           // More code using $ as alias to jQuery
        });
    })(jQuery); 
  </script>

        <?php
    }



}
