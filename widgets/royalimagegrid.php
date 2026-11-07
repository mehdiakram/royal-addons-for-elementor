<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit;


class RoyalImageGrid extends Widget_Base {

    public function get_name() {
        return 'royalimagegrid';
    }

    public function get_title() {
        return esc_html__( 'Image Grid', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-gallery-grid rtbranding'; }

    public function get_keywords() {
        return [ 'grid', 'image', 'gallery', 'filter', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
    }

    public function get_categories() {
		return [ 'royaltech' ];
	}

    public function get_style_depends() {
        return [ 'royalimagegrid' ];
    }

    public function get_script_depends() {
        return ['magnific-popup', 'masonry', 'isotope', 'royalmasonry', 'royalisotope', 'royalmagnificpopup'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Gallery', 'royal-addons-for-elementor' ),
            ]
        );
            
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'popuptype',
            [
                'label' => esc_html__( 'Popup Type', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'video'  => esc_html__( 'Pop Up Video', 'royal-addons-for-elementor' ),
                    'image'  => esc_html__( 'Pop Up Image', 'royal-addons-for-elementor' ),
                    'link'   => esc_html__( 'Custom Link', 'royal-addons-for-elementor' ),
                ],
                'label_block'=>true,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'   => esc_html__( 'Title', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'label_block'=>true,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'filtername',
            [
                'label'   => esc_html__( 'Filter Name', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'label_block'=>true,
                'description' => esc_html__( 'Please add seperate by comma, no space. Ex. <b>Design,Branding</b>', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'video_url',
            [
                'label'     => esc_html__( 'Video Url', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'https://www.youtube.com/watch?v=XHOmBV4js_E', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'condition'=>[
                    'popuptype'=>'video',
                ],
            ]
        );

        $repeater->add_control(
            'customlink',
            [
                'label'     => esc_html__( 'Custom Link', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'label_block' => true,
                'condition'=>[
                    'popuptype'=>'link',
                ],
            ]
        );

        $this->add_control(
            'image_list',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => esc_html__('Image One','royal-addons-for-elementor'),
                        'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                        'filtername' => 'Branding,Websites',
                        'popuptype' => 'image',
                    ],
                    [
                        'title' => esc_html__('Image Two','royal-addons-for-elementor'),
                        'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                        'filtername' => 'Design,Websites',
                        'popuptype' => 'image',
                    ],
                    [
                        'title' => esc_html__('Image Three','royal-addons-for-elementor'),
                        'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
                        'filtername' => 'Design,Branding',
                        'popuptype' => 'image',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'common_options',
            [
                'label' => esc_html__( 'Options', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'showmasonry',
            [
                'label' => esc_html__( 'Show Masonry', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'showfilter',
            [
                'label' => esc_html__( 'Show Filter', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'imagesize',
                'default' => 'full',
                'separator' => 'none',
                'condition'=>[
                    'showmasonry!' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'show_all',
            [
                'label' => esc_html__( 'Show All Menu', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
                'condition'=>[
                    'showfilter' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'all_menu_text',
            [
                'label' => esc_html__( 'All Menu Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'All', 'royal-addons-for-elementor' ),
                'condition'=>[
                    'show_all' => 'yes',
                    'showfilter' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'active_menu_key',
            [
                'label' => esc_html__( 'Active Menu Key', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'condition'=>[
                    'showfilter' => 'yes',
                ],
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label' => esc_html__( 'Columns', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => esc_html__( 'One', 'royal-addons-for-elementor' ),
                    '2' => esc_html__( 'Two', 'royal-addons-for-elementor' ),
                    '3' => esc_html__( 'Three', 'royal-addons-for-elementor' ),
                    '4' => esc_html__( 'Four', 'royal-addons-for-elementor' ),
                    '5' => esc_html__( 'Five', 'royal-addons-for-elementor' ),
                    '6' => esc_html__( 'Six', 'royal-addons-for-elementor' ),
                    '7' => esc_html__( 'Seven', 'royal-addons-for-elementor' ),
                    '8' => esc_html__( 'Eight', 'royal-addons-for-elementor' ),
                    '9' => esc_html__( 'Nine', 'royal-addons-for-elementor' ),
                    '10'=> esc_html__( 'Ten', 'royal-addons-for-elementor' ),
                ],
                'label_block' => true,
                'separator' => 'before',
                'prefix_class' => 'royalcolumns%s-',
            ]
        );

        $this->add_control(
            'no_gutters',
            [
                'label' => esc_html__( 'No Gutters', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'royal-addons-for-elementor' ),
                'label_off' => esc_html__( 'No', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_responsive_control(
            'item_space',
            [
                'label' => esc_html__( 'Space', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'condition'=>[
                    'no_gutters!'=>'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalrow > [class*="col-"]' => 'padding: 0  {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_bottom_space',
            [
                'label' => esc_html__( 'Bottom Space', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'condition'=>[
                    'no_gutters!'=>'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalrow > [class*="col-"]' => 'margin-bottom:{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        
        $this->start_controls_section(
            'menu_style_section',
            [
                'label' => esc_html__( 'Menu Style', 'royal-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
            
        $this->add_control(
            'menu_style',
            [
                'label' => esc_html__( 'Menu Style', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'one',
                'options' => [
                    'one'   => esc_html__( 'One', 'royal-addons-for-elementor' ),
                    'two'   => esc_html__( 'Two', 'royal-addons-for-elementor' ),
                    'three' => esc_html__( 'Three', 'royal-addons-for-elementor' ),
                    'four'  => esc_html__( 'Four', 'royal-addons-for-elementor' ),
                    'five'  => esc_html__( 'Five', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'area_border',
                'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalgallery-filter',
            ]
        );

        $this->add_control(
            'area_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royalgallery-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'area_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royalgallery-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'area_background',
                'label' => esc_html__( 'Background', 'royal-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .royalgallery-filter',
            ]
        );

        $this->add_responsive_control(
            'area_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start'    => [
                        'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalgallery-filter > ul'   => 'justify-content: {{VALUE}};',
                ],
                'prefix_class'=>'royalmenu-align-%s',
            ]
        );

        $this->add_control(
            'menu_item_heading',
            [
                'label' => esc_html__( 'Menu Item', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_item_typography',
                'label' => esc_html__( 'Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .royalgallery-filter > ul > li',
            ]
        );

        $this->add_control(
            'menu_item_padding',
            [
                'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .royalgallery-filter > ul > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'menu_item_space',
            [
                'label' => esc_html__( 'Space', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .royalgallery-filter > ul > li' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('menu_style_tabs');
                
        $this->start_controls_tab(
            'menu_style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
            
            $this->add_control(
                'menu_normal_color',
                [
                    'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royalgallery-filter > ul > li' => 'color: {{VALUE}};',
                    ],
                ]
            );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'menu_style_active_tab',
            [
                'label' => esc_html__( 'Active', 'royal-addons-for-elementor' ),
            ]
        );
            
            $this->add_control(
                'menu_active_color',
                [
                    'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royalgallery-filter > ul > li.active' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .royalgallery-filter > ul > li:hover' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .royalgallery-filter-one > ul > li::before' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_control(
                'menu_active_bg_before_color',
                [
                    'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royalgallery-filter-two > ul > li::before' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .royalgallery-filter-three > ul > li::before' => 'background-color: {{VALUE}};',
                    ],
                    'condition'=>[
                        'menu_style'=>['two','three']
                    ]
                ]
            );

            $this->add_control(
                'menu_active_bg_color',
                [
                    'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .royalgallery-filter-four > ul > li' => 'background-color: {{VALUE}};',
                    ],
                    'condition'=>[
                        'menu_style'=>['four']
                    ]
                ]
            );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render( $instance = [] ) {
        $settings       = $this->get_settings_for_display();
        $id             = $this->get_id();
        $royalimagegrid = 'royalimagegrid'.$id;
        $column         = $settings['column'];
        $images         = $settings['image_list'];
        $size           = $settings['imagesize_size'];
        $showmasonry    = $settings['showmasonry'];
        $showfilter     = $settings['showfilter'];
        $image_size     = Null;

        $collumval  = 'royalcol-3';
        if( $column !='' ){
            $collumval = 'royalcol-'.esc_attr($column);
        }


        if($showmasonry   == 'yes'){
            $masonrygrid    = 'royalmasonry-grid';
            $masonryitem    = 'royalmasonry-item';
            $masonrysizer   = 'royalmasonry-sizer';
            $image_size     = 'full';
        } else{
            $masonrygrid    = '';
            $masonryitem    = '';
            $masonrysizer   = '';
        }


        $activemenukey = !empty( $settings['active_menu_key'] ) ? '.1_'.$settings['active_menu_key'] : '*';

        $this->add_render_attribute( 'area_attr', 'class', 'royalisotopegallery royalpopup-gallery royalisotopegrid '.$masonrygrid.' royalrow' );
        $this->add_render_attribute( 'area_attr', 'id', 'isotopegallery-'.esc_attr($id) );
        $this->add_render_attribute( 'area_attr', 'data-gallery-active', esc_attr($activemenukey) );

        if( $settings['no_gutters'] === 'yes' ){
            $this->add_render_attribute( 'area_attr', 'class', 'royalno-gutters' );
        }

        $item_class = array( 'royalisotopeitem', $masonryitem, $collumval );

        if($showmasonry !== 'yes'){
            if( $size === 'custom'){
                $image_size = [
                    $settings['imagesize_custom_dimension']['width'],
                    $settings['imagesize_custom_dimension']['height']
                ];
            }else{ $image_size = $size; }
        }
        // Class Explode
        $classes = '';
        $i = 0;
        foreach ( $images as $item ) {
            if( $i == 0 ){
                $classes .= $item['filtername'];
            }else{
                $classes .= ','.$item['filtername'];
            }
            $i++;
        }

        $alltext = ( $settings['all_menu_text'] ? $settings['all_menu_text'] : esc_html__('All','royal-addons-for-elementor') );

        $classes = explode( ",", $classes );
        if( $settings['show_all'] == 'yes' ){
            $classes = array( 'allfi' => $alltext ) + $classes;
        }
        $preclasses = array_map( function($value) { return '1_'.$value; }, $classes );
        $preclasses = array_unique( $preclasses );
        echo '<div class="royalisotope" id="'.$royalimagegrid.'">';
        if($showfilter == 'yes'){
        ?>
            <div class="royalgallery-filter royalgallery-filter-<?php echo esc_attr($settings['menu_style']); ?>">
                <ul class="filter-button-group" data-target="#isotopegallery-<?php echo esc_attr($id); ?>">
                    <?php
                        foreach ( $preclasses as $key => $class ) {
                            if( $key === 'allfi' ){
                                echo '<li class="active" data-filter="*">'.esc_html( $classes[$key] ).'</li>';
                            }else{
                                echo '<li data-filter=".'.esc_attr( $class ).'">'.esc_html( $classes[$key] ).'</li>';
                            }
                        }
                    ?>
                </ul>
            </div>
        <?php
        }

        if( is_array( $images ) ){
            echo '<div '.$this->get_render_attribute_string( 'area_attr' ).'><div class="royalgallery-sizer '.$masonrysizer.'"></div>';
                foreach ( $images as $image ) {

                    $filter_class = explode( ",", $image['filtername'] );
                    $filter_class = array_map( function($value) { return '1_'.$value; }, $filter_class );

                    $url = ( ( $image['popuptype'] == 'video' ) ? $image['video_url'] : ( ( $image['popuptype'] == 'link' ) ? $image['customlink'] : $image['image']['url'] ) );

                    $class = ( ( $image['popuptype'] == 'video' ) ? 'royalimage-grid royalvideo-popup' : ( ( $image['popuptype'] == 'link' ) ? 'royalimage-grid royalexternal-link' : 'royalimage-grid' ) );

                    if( !empty( $image['image']['id'] ) ){
                        $imagehtml = wp_get_attachment_image( $image['image']['id'], $image_size );
                    }else{
                        $imagehtml = '<img src="'.esc_url($image['image']['url']).'" alt="'.esc_attr($image['title']).'">';
                    }

                    $item = sprintf('<a href="%s" class="%s" data-elementor-open-lightbox="no">%s</a>', esc_url($url), esc_attr($class), $imagehtml );

                    echo sprintf('<div class="%1$s %2$s">%3$s</div>', implode( " ", $item_class ), implode(" ", $filter_class ), $item );
                }
            echo '</div>';
        }
        echo '</div>';
    }

}