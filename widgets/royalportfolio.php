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
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalPortfolio extends Widget_Base {

    public function get_name() {
        return 'royalportfolio';
    }


    public function get_title() {
        return __( 'Portfolio', 'royal-addons-for-elementor' );
    }


    public function get_icon() { return 'eicon-mail rtbranding'; }


    public function get_categories() {
        return array( 'royaltech' );
    }


  public function get_keywords() {
    return ['portfolio', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
  }

	public function get_style_depends() {
		$styles = ['royalportfolio'];
		return $styles;
	}
    

	public function get_script_depends() {
		$scripts = ['royalportfolio',];
		return $scripts;
	}


    protected function register_controls() {
        $this->start_controls_section(
            'portfolio_layout_section',
            [
                'label' => __( 'Portfolio Layout', 'royal-addons-for-elementor' ),
            ]
        );


		$this->add_control(
			'portfolio_style',
			[
				'label' => __( 'Style', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Style 1', 'royal-addons-for-elementor' ),
					'2' => esc_html__( 'Style 2', 'royal-addons-for-elementor' ),
					'3' => esc_html__( 'Style 3', 'royal-addons-for-elementor' ),
					'4' => esc_html__( 'Style 4', 'royal-addons-for-elementor' ),
					'5' => esc_html__( 'Style 5', 'royal-addons-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'frontend_available' => true,
				'selectors' => [

				],
			]
		);

		$this->add_control(
			'columnsgap',
			[
				'label' => esc_html__( 'Column Gap', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 50,
				'step' => 0,
				'default' => 10,
			]
		);

        $this->add_responsive_control(
			'portfolio_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
					],
				],
				'separator'=> 'before',				
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} #royalportfolio' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();


        $this->start_controls_section(
            'portfolio_cat_section',
            [
                'label' => __( 'Portfolio Category', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
          'portfolio_cat_title',
          [
            'label' => __( 'Cat Name', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Personal', 'royal-addons-for-elementor' ),
            'placeholder' => __( 'Type Portfolio Category Here', 'royal-addons-for-elementor' ),
          ]
        );
      
    
        $this->add_control(
          'portfolio_cat',
          [
            'label' => __( 'Portfolio Category', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
              [
                'portfolio_cat_title' => __( 'Personal', 'royal-addons-for-elementor' ),
              ],
              [
                'portfolio_cat_title' => __( 'NGO', 'royal-addons-for-elementor' ),
              ],
              [
                'portfolio_cat_title' => __( 'Ecommerce', 'royal-addons-for-elementor' ),
              ],
              [
                'portfolio_cat_title' => __( 'Medical', 'royal-addons-for-elementor' ),
              ],
              [
                'portfolio_cat_title' => __( 'Resturent', 'royal-addons-for-elementor' ),
              ],                                          
            ],
            'title_field' => '{{{ portfolio_cat_title }}}',
          ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'portfolio_item_section',
            [
                'label' => __( 'Portfolio Items', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
          'portfolio_item_title',
          [
            'label' => __( 'Title', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __( 'Royal Technlogies', 'royal-addons-for-elementor' ),
            'placeholder' => __( 'Type Portfolio Title Here', 'royal-addons-for-elementor' ),
          ]
        );
      
        $repeater->add_control(
            'portfolio_item_url',
            [
              'label' => __( 'URL', 'royal-addons-for-elementor' ),
              'type' => \Elementor\Controls_Manager::TEXT,
              'default' => __( '#', 'royal-addons-for-elementor' ),
              'placeholder' => __( 'Type Portfolio Item URL Here', 'royal-addons-for-elementor' ),
            ]
          );

          $repeater->add_control(
			'image',
			[
				'label' => __('Image', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
                'dynamic' => [
                    'active' => true,
                ]
			]
		);

        $repeater->add_control(
            'portfolio_item_cat',
            [
              'label' => __( 'Category', 'royal-addons-for-elementor' ),
              'type' => \Elementor\Controls_Manager::SELECT2,
              'multiple' => true,
              'options' => self::portfoliocat(),
            ]
          );

        $this->add_control(
          'portfolio_items',
          [
            'label' => __( 'Portfolio Items', 'royal-addons-for-elementor' ),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
              [
                'portfolio_item_title' => __( 'Royal Technlogies', 'royal-addons-for-elementor' ),
                'portfolio_item_url' => __( 'http://royal-addons-for-elementorbd.com/', 'royal-addons-for-elementor' ),
              ],
              [
                'portfolio_item_title' => __( 'Shamokal Darpon', 'royal-addons-for-elementor' ),
                'portfolio_item_url' => __( 'https://www.shamokaldarpon.com/', 'royal-addons-for-elementor' ),
              ],                                         
            ],
            'title_field' => '{{{ portfolio_item_title }}}',
          ]
        );


        $this->end_controls_section();




        $this->start_controls_section(
            'filter_section',
            [
              'label' => __( 'Filter Style', 'royal-addons-for-elementor' ),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
          
        
        $this->add_responsive_control(
			'filter_align',
			[
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
					],
				],
				'separator'=> 'before',				
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} #royalportfoliofilters' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'filter_padding',
			[
				'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} #royalportfoliofilters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'filter_typo',
              'label' => __( 'Filter Typography', 'royal-addons-for-elementor' ),
              'global' => [
                'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
              ],
              'selector' => '{{WRAPPER}} #royalportfoliofilters button',
            ]
          );
          
        $this->start_controls_tabs( '_tab_filtera' );
        $this->start_controls_tab(
            '_tab_filter_normal',
            [
                'label' => __( 'Normal', 'royal-addons-for-elementor' ),
            ]
        );
  
        $this->add_control(
            'filter_background_color',
            [
                'label' => __( 'Filter Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} #royalportfoliofilters button'  => 'background-color:{{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'filter_color',
            [
                'label' => __( 'Filter Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#3e9bd5',
                'selectors' => [
                    '{{WRAPPER}} #royalportfoliofilters button'  => 'color:{{VALUE}};',
                ]
            ]
        );
  
  
          $this->end_controls_tab();
  
          $this->start_controls_tab(
              '_tab_filter_hover',
              [
                  'label' => __( 'Hover & Active', 'royal-addons-for-elementor' ),
              ]
          );
  
          $this->add_control(
            'filter_background_color_hover',
            [
                'label' => __( 'Filter Background Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#3e9bd5',
                'selectors' => [
                    '{{WRAPPER}} #royalportfoliofilters button:hover'  => 'background-color:{{VALUE}};',
                    '{{WRAPPER}} #royalportfoliofilters button.active'  => 'background-color:{{VALUE}};',
                ]
            ]
        );


        $this->add_control(
            'filter_color_hover',
            [
                'label' => __( 'Filter Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} #royalportfoliofilters button:hover'  => 'color:{{VALUE}};',
                    '{{WRAPPER}} #royalportfoliofilters button.active'  => 'color:{{VALUE}};',
                ]
            ]
        );
  

        $this->end_controls_tab();
        $this->end_controls_tabs();
           

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'filter_border',
                'separator' => 'before',
				'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} #royalportfoliofilters button',
			]
		);

        
        $this->end_controls_section();



        $this->start_controls_section(
            'portfolio_section',
            [
              'label' => __( 'Portfolio Style', 'royal-addons-for-elementor' ),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'portfolio_background_color',
            [
                'label' => __( 'Portfolio Background', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#03A679',
                'selectors' => [
                    '{{WRAPPER}} #royalportfolio .style101 figure'  => 'background-color:{{VALUE}};',
                ]
            ]
        );

        $this->add_control(
			'image_opacity',
			[
				'label' => esc_html__( 'Image Opacity', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 1,
                        'step' => .01,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => .25,
				],
				'selectors' => [
					'{{WRAPPER}} #royalportfolio .style101 figure img' => 'opacity: {{SIZE}};',
				],
			]
		);
   

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'portfolio_border',
                'separator' => 'before',
				'label' => esc_html__( 'Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} #royalportfolio .style101 figure figcaption',
			]
		);

        $this->add_control(
			'border_padding',
			[
				'label' => esc_html__( 'Border Padding', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
                        'step' => 1,
					],
				],
				'default' => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} #royalportfolio .style101 figure figcaption' => 'top: {{SIZE}}{{UNIT}}; left: {{SIZE}}{{UNIT}};width: calc(100% - {{SIZE}}*2{{UNIT}}); height: calc(100% - {{SIZE}}*2{{UNIT}});',
				],
			]
		);   

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
              'name' => 'portfolio_title_typo',
              'label' => __( 'Title Typography', 'royal-addons-for-elementor' ),
              'separator'=> 'before',
              'global' => [
                'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
              ],
              'selector' => '{{WRAPPER}} #royalportfolio .style101 figure figcaption h4',
            ]
          );


          $this->add_control(
            'portfolio_title_color',
            [
                'label' => __( 'Title Color', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'separator'=> 'before',
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} #royalportfolio .style101 figure figcaption h4'  => 'color:{{VALUE}};',
                ]
            ]
        );


        $this->end_controls_section();









    }



    public function portfoliocat() {
            $form_info = array();
            $settings = $this->get_settings_for_display();

            foreach( $settings['portfolio_cat'] as $cat ){
                
                $catt  = $cat['portfolio_cat_title'];

                $form_info[$catt] = $catt;
            }

            return $form_info;
        }






    protected function render() {
        $settings = $this->get_settings_for_display();
        $columns                = $settings['columns'];
        $columnsgap             = $settings['columnsgap'];
        $portfolio_style        = $settings['portfolio_style'];
		


        echo '<div id="royalportfoliofilters">';
        echo '<button class="royalportfoliofiltercat active" data-rel="all">All</button>';
        foreach (  $settings['portfolio_cat'] as $cat ) { ?>
           <button class="royalportfoliofiltercat" data-rel="<?php echo $cat['portfolio_cat_title'] ?>"><?php echo $cat['portfolio_cat_title'] ?></button>
        <?php }
        echo '</div>';


        echo '<div id="royalportfolio" class="rp_col_'.$columns.'">';         
        if( 1 == $portfolio_style ){
            foreach (  $settings['portfolio_items'] as $items ) { ?>
                <div class="style101 tile <?php 
                foreach ( $items['portfolio_item_cat'] as $allcat) { 
                    echo $allcat; 
                    } ?> all">
                    <a href="<?php echo $items['portfolio_item_url'] ?>" target="_blank">
                    <figure>
                    <?php echo wp_get_attachment_image( $items['image']['id'], 'image300' );?>

                   
                    
                    <figcaption><h4 class=""><?php echo $items['portfolio_item_title'] ?></h4></figcaption>
                    </figure></a>
                </div>            
            <?php }

        }elseif( 2 == $portfolio_style ){




        }else{
        
        }
        echo  '</div>';




    $gapminus = $columnsgap - ($columnsgap/$columns);
    echo  '<style>
    #royalportfolio .tile{
        width: calc( (100% / '.$columns.') - '.$gapminus.'px);
    }

    #royalportfolio .tile{
        margin-right: '.$columnsgap.'px;
        margin-bottom: '.$columnsgap.'px;
    }

    #royalportfolio .tile:last-child,
    #royalportfolio .tile:nth-child('.$columns.'n){
        margin-right: 0px!important;
    }   
    </style>
    ';

    }



    protected function content_template() {
        
    }

}
