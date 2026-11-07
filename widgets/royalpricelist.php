<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
if (!defined('ABSPATH')) exit; // Exit if accessed directly



class RoyalPriceList extends Widget_Base {

	public function get_name() {
		return 'royalpricelist';
	}


	public function get_title() {
		return 'Price List';
	}


	public function get_icon() { return 'eicon-price-list rtbranding'; }


	public function get_keywords() {
		return [ 'price', 'list', 'menu', 'menu list', 'restaurant', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_style_depends() {
		$styles = [ 'royalpricelist' ];
		return $styles;
	}

	
    protected function register_controls() {
		$controls = $this;

        $controls->start_controls_section(
			'list_settings',
			[
				'label' => esc_html__( 'List', 'royal-addons-for-elementor' )
			]
		);

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'title',
            [
                'label' => __( 'Title', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Exciting Feature', 'royal-addons-for-elementor' ),
            ]
        );

		$repeater->add_control(
			'currency',
			[
				'label' => __( 'Currency', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'BDT',
				'options' => [
					'$'   => __( 'Dollar ($)', 'royal-addons-for-elementor' ),
					'€'   => __( 'Euro (€)', 'royal-addons-for-elementor' ),
					'£'   => __( 'Pound (£)', 'royal-addons-for-elementor' ),
					'৳'   => __( 'Taka (৳)', 'royal-addons-for-elementor' ),
					'₹'   => __( 'Rupee (₹)', 'royal-addons-for-elementor' ),
					'C$'  => __( 'CAD (C$)', 'royal-addons-for-elementor' ),
					'A$'  => __( 'AUD (A$)', 'royal-addons-for-elementor' ),
					'USD' => __( 'USD', 'royal-addons-for-elementor' ),
					'EUR' => __( 'EUR', 'royal-addons-for-elementor' ),
					'GBP' => __( 'GBP', 'royal-addons-for-elementor' ),
					'BDT' => __( 'BDT', 'royal-addons-for-elementor' ),
					'INR' => __( 'INR', 'royal-addons-for-elementor' ),
					''    => __( 'None', 'royal-addons-for-elementor' ),
				],
			]
		);


        $repeater->add_control(
            'price',
            [
                'label' => __( 'Price', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( '10', 'royal-addons-for-elementor' ),
            ]
        );
		

        $repeater->add_control(
            'regular_price',
            [
                'label' => __( 'Regular Price (Old Price)', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 'e.g. 15',
            ]
        );

        $repeater->add_control(
            'details',
            [
                'label' => __( 'Details', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
				'default' => __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'royal-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'badge_text',
            [
                'label' => __( 'Badge Text', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 'e.g. Popular, Hot, New',
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => __( 'Item Link', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_control(
			'image',
			[
			  'label' => __( 'Price Menu Image', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::MEDIA,
			  'default' => [
				'url' => \Elementor\Utils::get_placeholder_image_src(),
			  ],
			]
		);


        $controls->add_control(
			'price_list',
			[
			  'label' => __( 'Price List Items', 'royal-addons-for-elementor' ),
			  'type' => \Elementor\Controls_Manager::REPEATER,
			  'fields' => $repeater->get_controls(),
			  'show_label' => false,
			  'default' => [
				  [
					  'title' 		=> __( 'Chicken Dhaga Kabab', 'royal-addons-for-elementor' ),
					  'currency' 	=> __( 'BDT', 'royal-addons-for-elementor' ),
					  'price' 		=> __( '120', 'royal-addons-for-elementor' ),					  
					  'details' 	=> __( 'Chicken Dhaga Kabab Just about everyone has eaten a kabab at one time or another in their lifetime', 'royal-addons-for-elementor' ),
				  ],
				  [
					  'title'		=> __( 'Chicken Biryani', 'royal-addons-for-elementor' ),
					  'currency' 	=> __( 'BDT', 'royal-addons-for-elementor' ),
					  'price' 		=> __( '200', 'royal-addons-for-elementor' ),
					  'details' 	=> __( 'Traditional chicken biryani is made by layering marinated chicken and then layered with parboiled rice, herbs,saffron milk & then ghee.', 'royal-addons-for-elementor' ),
				  ],
				  [
					  'title' 		=> __( 'Burger', 'royal-addons-for-elementor' ),
					  'currency' 	=> __( 'BDT', 'royal-addons-for-elementor' ),
					  'price' 		=> __( '90', 'royal-addons-for-elementor' ),
					  'details' 	=> __( 'Where are the Burger lovers? Are you Craving for some Cheesy trip to extra Happiness? A regular bite on Regular Chicken Cheese Burger will drive you', 'royal-addons-for-elementor' ),
				  ],
				  [
					'title' 		=> __( 'Water', 'royal-addons-for-elementor' ),
					'currency' 		=> '',
					'price' 		=> __( 'FREE', 'royal-addons-for-elementor' ),
					'details' 		=> __( 'Water is always free', 'royal-addons-for-elementor' ),
				],
  
			  ],
			  'title_field' => '{{{ title }}}',
			]
		  );

		  
		$controls->add_control(
			'currency_position',
			[
				'label' => __( 'Currency Position', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'        => __( 'Left', 'royal-addons-for-elementor' ),
					'left_space'  => __( 'Left with Space', 'royal-addons-for-elementor' ),
					'right'       => __( 'Right', 'royal-addons-for-elementor' ),
					'right_space' => __( 'Right with Space', 'royal-addons-for-elementor' ),
				],
			]
		);

		$controls->end_controls_section();


		

        $controls->start_controls_section(
            '_section_style_general',
            [
                'label' => __( 'General Style', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $controls->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'royal-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .royalpricelist',
            ]
        );


		$controls->add_control(
			'margin',
			[
				'label' => __( 'Margin', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$controls->add_control(
			'padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);



		$controls->add_control(
			'item_gap',
			[
				'label' => __( 'Item Gap', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem' => 'padding-top: calc({{SIZE}}{{UNIT}} / 2); padding-bottom: calc({{SIZE}}{{UNIT}} / 2);',
					'{{WRAPPER}} .royalpricelist .rplitem:first-child' => 'padding-top: 0;',
					'{{WRAPPER}} .royalpricelist .rplitem:last-child' => 'padding-bottom: 0;',
				],
			]
		);

		$controls->add_control(
			'item_separated_border_width',
			[
				'label' => __( 'Item Border Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$controls->add_control(
			'item_border_style',
			[
				'label' => __( 'Item Border Style', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'solid' => __( 'Solid', 'royal-addons-for-elementor' ),
					'dashed' => __( 'Dashed', 'royal-addons-for-elementor' ),
					'dotted' => __( 'Dotted', 'royal-addons-for-elementor' ),
					'double' => __( 'Double', 'royal-addons-for-elementor' ),
					'none' => __( 'None', 'royal-addons-for-elementor' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
				],
			]
		);

		$controls->add_control(
			'item_border_color',
			[
				'label' => __( 'Item Border Color', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$controls->end_controls_section();




        $controls->start_controls_section(
            '_section_style_title',
            [
                'label' => __( 'Title Style', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );



		$controls->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title & Price Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem .itemandprice' => 'color: {{VALUE}};',
				],				
			]
		);

		$controls->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'title_typo',
			  'label' => __( 'Title Typography', 'royal-addons-for-elementor' ),
			  'global' => [
				'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
			  ],
			  'selector' => '{{WRAPPER}} .royalpricelist .rplitem .itemandprice',
			]
		  );

		$controls->add_control(
			'title_border_style',
			[
				'label' => __( 'Border Type', 'royal-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'dotted',
				'options' => [
					'dotted'  	=> __( 'Dotted', 'royal-addons-for-elementor' ),
					'dashed' 	=> __( 'Dashed', 'royal-addons-for-elementor' ),
					'double' 	=> __( 'Double', 'royal-addons-for-elementor' ),
					'solid' 	=> __( 'Solid', 'royal-addons-for-elementor' ),
					'none' 		=> __( 'None', 'royal-addons-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem .itemandprice:after' => 'border-bottom-style: {{VALUE}};',
				],					
			]
		);



		$controls->add_control(
			'title_border_color',
			[
				'label' => esc_html__( 'Title & Price Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem .itemandprice:after' => 'border-bottom-color: {{VALUE}};',
				],				
			]
		);


		$controls->add_control(
			'title_border_width',
			[
				'label' => __( 'Title Border Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem .itemandprice:after' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		  
		$controls->end_controls_section();

		$controls->start_controls_section(
			'_section_style_image',
			[
				'label' => __( 'Image Style', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$controls->add_control(
			'image_width',
			[
				'label' => __( 'Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$controls->add_control(
			'image_height',
			[
				'label' => __( 'Height', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				],
			]
		);

		$controls->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$controls->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem img' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.rtl {{WRAPPER}} .royalpricelist .rplitem img' => 'margin-right: 0; margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$controls->end_controls_section();


		

        $controls->start_controls_section(
            '_section_style_content',
            [
                'label' => __( 'Content Style', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


		$controls->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Content Color', 'royal-addons-for-elementor' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royalpricelist .rplitem .rplcontainer .rplitemcontent' => 'color: {{VALUE}};',
				],				
			]
		);


		$controls->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
			  'name' => 'content_typo',
			  'label' => __( 'Content Typography', 'royal-addons-for-elementor' ),
			  'global' => [
				'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
			  ],
			  'selector' => '{{WRAPPER}} .royalpricelist .rplitem .rplcontainer .rplitemcontent',
			]
		  );



		$controls->end_controls_section();


	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$currency_position = isset($settings['currency_position']) ? $settings['currency_position'] : 'left';
	?>

	<div class="royalpricelist">
	<?php foreach ( $settings['price_list'] as $index => $pricelist ) : 
		$currency = $pricelist['currency'];
		$price = $pricelist['price'];
		
		$formatted_price = '';
		if ( 'left' === $currency_position ) {
			$formatted_price = $currency . $price;
		} elseif ( 'left_space' === $currency_position ) {
			$formatted_price = $currency . ' ' . $price;
		} elseif ( 'right' === $currency_position ) {
			$formatted_price = $price . $currency;
		} elseif ( 'right_space' === $currency_position ) {
			$formatted_price = $price . ' ' . $currency;
		}
	?>   
	<div class="rplitem">
		<?php if ( ! empty( $pricelist['item_link']['url'] ) ) : ?>
			<a href="<?php echo esc_url( $pricelist['item_link']['url'] ); ?>" class="rplitem-link-overlay" <?php echo !empty($pricelist['item_link']['is_external']) ? 'target="_blank"' : ''; ?>></a>
		<?php endif; ?>
		<?php echo wp_get_attachment_image( $pricelist['image']['id'], 'thumbnail' ); ?>
		<div class="rplcontainer">
		<div class="itemandprice">
		<span>
			<?php echo $pricelist['title'];?>
			<?php if ( ! empty( $pricelist['badge_text'] ) ) : ?>
				<span class="rpl-badge"><?php echo esc_html( $pricelist['badge_text'] ); ?></span>
			<?php endif; ?>
		</span>
		<span>
			<?php if ( ! empty( $pricelist['regular_price'] ) ) : ?>
				<del class="rpl-regular-price"><?php 
					if ( strpos($currency_position, 'left') !== false ) {
						echo $currency . (strpos($currency_position, 'space') !== false ? ' ' : '') . $pricelist['regular_price'];
					} else {
						echo $pricelist['regular_price'] . (strpos($currency_position, 'space') !== false ? ' ' : '') . $currency;
					}
				?></del>
			<?php endif; ?>
			<?php echo $formatted_price; ?>
		</span>
		</div>
		<div class="rplitemcontent"><?php echo $pricelist['details'];?></div>
		</div>
	</div>  
	<?php endforeach; ?> 

	</div>	
	
	<?php
	}	
	protected function content_template() {


	}

	


}

