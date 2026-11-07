<?php
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class RoyalTextz {

	static $should_script_enqueue = false;

	public static function init() {
        add_action( 'elementor/element/theme-post-content/section_style/after_section_end',  [ __CLASS__, 'add_section' ] ); 
		add_action( 'elementor/element/text-editor/section_style/after_section_end',  [ __CLASS__, 'add_section' ] ); 
        add_action( 'elementor/element/after_add_attributes',  [ __CLASS__, 'add_attributes' ] );

        /* should enqueue? */
		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'should_script_enqueue' ] );
        add_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
        /* add script */
        add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

    }

    /* enqueue script JS */
    public static function enqueue_scripts() {
		wp_enqueue_script('royaltextz', ROYAL_ADDONS_DIR_URL.'assets/js/extension-textz.js', [], '' );
    }

    /* should enqueue? */
    public static function should_script_enqueue( $element ) {

        if( self::$should_script_enqueue ) return;

        if( 'yes' == $element->get_settings_for_display( '_ob_postman_use' ) ) {

            self::$should_script_enqueue = true;
            self::enqueue_scripts();

            remove_action( 'elementor/frontend/widget/before_render', [ __CLASS__, 'should_script_enqueue' ] );
        }
    }

    public static function add_attributes( $element ) {

		if( ! in_array( $element->get_name(), [ 'theme-post-content', 'text-editor' ] ) ) return;
        if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) return;

		$settings = $element->get_settings_for_display();
		
		if ( isset( $settings[ '_ob_postman_use' ] ) && 'yes' === $settings[ '_ob_postman_use' ] ) {

            $element->add_render_attribute( '_wrapper', [
                'class' => 'ob-postman'
            ] );

        }

    }
    
	public static function add_section( $element ) {
		if ( ! ( $element instanceof \Elementor\Element_Base ) ) return;

		$element_id = $element->get_name();
		if ( isset( self::$registered_elements[ $element_id ] ) ) {
			return;
		}
		self::$registered_elements[ $element_id ] = true;

		$element->start_controls_section(
			'royalcontrolsection_textz',
			[
				'label' => 'Textz [Royal]', 
				'tab' => Controls_Manager::TAB_ADVANCED,
			]
        );

        // ------------------------------------------------------------------------- CONTROL: Yes 4 Comments !
		$element->add_control(
			'_ob_postman_use',
			[
                'label' => __( 'Enable Textz', 'royal-addons-for-elementor' ), 
                'description' => __( 'That will allow you to style up the elements of Text Editor', 'royal-addons-for-elementor' ), 
				'type' => Controls_Manager::SWITCHER, 
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'return_value' => 'yes',
                'default' => 'no', 
                'separator' => 'after', 
                'frontend_available' => true, 
			]
        );

		// --------------------------------------------------------------------------------------------- CONTROL Paragraph styles
		$element->add_control(
			'_ob_postman_paragraph_popover',
			[
				'label' => __( 'Paragraph styles', 'royal-addons-for-elementor' ), 
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'frontend_available' => true, 
				'return_value' => 'yes', 
				'condition' => [
					'_ob_postman_use' => 'yes', 
                ],
			]
		);

        $element->start_popover();

        $element->add_responsive_control(
			'_ob_postman_paragraph_padding',
			[
				'label' => __( 'Paragraph padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_paragraph_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_paragraph_margin',
			[
				'label' => __( 'Paragraph margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_paragraph_popover' => 'yes', 
				],
			]
        );

        $element->end_popover(); // popover paragraphs margin


		// --------------------------------------------------------------------------------------------- CONTROL Heading styles
		$element->add_control(
			'_ob_postman_headings_popover',
			[
				'label' => __( 'Heading styles', 'royal-addons-for-elementor' ), 
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'frontend_available' => true, 
				'return_value' => 'yes', 
				'condition' => [
					'_ob_postman_use' => 'yes', 
                ],
			]
		);

        $element->start_popover();

        // --------------------------------------------------------------------------------------------- CONTROL: Headings margin
        $element->add_responsive_control(
			'_ob_postman_headings_margin_h1',
			[
				'label' => __( 'H1 Margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container h1' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_headings_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_headings_margin_h2',
			[
				'label' => __( 'H2 Margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_headings_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_headings_margin_h3',
			[
				'label' => __( 'H3 Margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_headings_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_headings_margin_h4',
			[
				'label' => __( 'H4 Margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_headings_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_headings_margin_h5',
			[
				'label' => __( 'H5 Margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_headings_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_headings_margin_h6',
			[
				'label' => __( 'H6 Margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_headings_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_headings_padding_all',
			[
				'label' => __( 'Padding - all', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container h1, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container h2, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container h3, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container h4, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container h5, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_headings_popover' => 'yes', 
				],
			]
        );

		$element->end_popover(); // popover headings margin

		// --------------------------------------------------------------------------------------------- CONTROL lists styles
		$element->add_control(
			'_ob_postman_lists_popover',
			[
				'label' => __( 'Lists styles: UL and OL', 'royal-addons-for-elementor' ), 
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'frontend_available' => true, 
				'return_value' => 'yes', 
				'condition' => [
					'_ob_postman_use' => 'yes', 
                ],
			]
		);

        $element->start_popover();

        $element->add_responsive_control(
			'_ob_postman_lists_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container > ul, 
					{{WRAPPER}}.ob-postman .elementor-widget-container > ol,
					{{WRAPPER}}.ob-postman .elementor-text-editor > ul, 
					{{WRAPPER}}.ob-postman .elementor-text-editor > ol' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
				],
			]
        );

        $element->add_responsive_control(
			'_ob_postman_lists_margin',
			[
				'label' => __( 'Margins', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container ul, {{WRAPPER}}.ob-postman .elementor-widget-container ol' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_lists_margin_nested',
			[
				'label' => __( 'Margins - nested lists', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container ul li ul, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container ol li ol, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container ul li ol, 
                    {{WRAPPER}}.ob-postman .elementor-widget-container ol li ul' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_lists_spacing',
			[
				'label' => __( 'Items spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
				],
			]
        );
		$element->add_responsive_control(
			'_ob_postman_lists_type_ul',
			[
				'label' => __( 'List type UL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
                'default' => 'inherit', 
				'options' => [
                    'inherit' => __( 'Default', 'royal-addons-for-elementor' ),
					'circle' => __( 'Circle', 'royal-addons-for-elementor' ),
					'square' => __( 'Square', 'royal-addons-for-elementor' ), 
					'disc' => __( 'Disc', 'royal-addons-for-elementor' ), 
                    'none' => __( 'Custom', 'royal-addons-for-elementor' ), 
				],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container ul' => 'list-style-type: {{VALUE}};',
				],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
				],
			]
		);
		$element->add_responsive_control(
			'_ob_postman_lists_type_ul_alt',
			[
				'label' => __( 'List type UL - custom', 'royal-addons-for-elementor' ),
                'description' => __( 'It has to be Unicode HEX escape, like \2192, or \00A9', 'royal-addons-for-elementor' ), 
				'type' => Controls_Manager::TEXT, 
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container ul > li:before' => 'content: "{{VALUE}}\00a0 ";', 
                    '{{WRAPPER}}.ob-postman .elementor-widget-container ul > li' => 'display: block;', 
                    '{{WRAPPER}}.ob-postman .elementor-widget-container ul' => 'padding: 0;', 
				],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
                    '_ob_postman_lists_type_ul' => 'none', 
				],
			]
		);
		$element->add_responsive_control(
			'_ob_postman_lists_type_ol',
			[
				'label' => __( 'List type OL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
                'default' => 'inherit', 
				'options' => [
                    'inherit' 				=> __( 'Default', 'royal-addons-for-elementor' ),
					'decimal' 				=> __( 'Decimal', 'royal-addons-for-elementor' ),
					'decimal-leading-zero' 	=> __( 'Decimal Leading Zero', 'royal-addons-for-elementor' ),
                    'upper-alpha' 			=> __( 'Upper Alpha', 'royal-addons-for-elementor' ), 
                    'lower-alpha' 			=> __( 'Lower Alpha', 'royal-addons-for-elementor' ), 
                    'lower-roman' 			=> __( 'Lower Roman', 'royal-addons-for-elementor' ), 
                    'upper-roman' 			=> __( 'Upper Roman', 'royal-addons-for-elementor' ), 
                    'bengali' 				=> __( 'Bengali', 'royal-addons-for-elementor' ), 
					'circle' 				=> __( 'Circle', 'royal-addons-for-elementor' ),
					'square' 				=> __( 'Square', 'royal-addons-for-elementor' ), 
					'disc' 					=> __( 'Disc', 'royal-addons-for-elementor' ), 
                    'none' 					=> __( 'Custom', 'royal-addons-for-elementor' ), 
				],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container ol' => 'list-style-type: {{VALUE}};',
				],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
				],
			]
		);
		$element->add_responsive_control(
			'_ob_postman_lists_type_ol_alt',
			[
				'label' => __( 'List type OL - custom', 'royal-addons-for-elementor' ),
                'description' => __( 'It has to be Unicode HEX escape, like \2192, or \00A9', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT, 
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container ol > li:before' => 'content: "{{VALUE}}\00a0 ";', 
                    '{{WRAPPER}}.ob-postman .elementor-widget-container ol > li' => 'display: block;', 
                    '{{WRAPPER}}.ob-postman .elementor-widget-container ol' => 'padding: 0;', 
				],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                    '_ob_postman_lists_popover' => 'yes', 
                    '_ob_postman_lists_type_ol' => 'none', 
				],
			]
		);

        $element->end_popover(); // popover lists style

		// --------------------------------------------------------------------------------------------- CONTROL quotes styles
        $element->add_control(
            '_ob_postman_quotes_fake_descr',
            [
                'type' => Controls_Manager::RAW_HTML, 
                'label' => __( 'Quotations', 'royal-addons-for-elementor' ),
                'raw' => __( 'Style up the Post Content Quotations', 'royal-addons-for-elementor' ), 
                'content_classes' => 'elementor-control-field-description', 
				'condition' => [
					'_ob_postman_use' => 'yes', 
				],
            ]
        );

        $element->add_control(
			'_ob_postman_quotes_color',
			[
				'label' => __( 'Quotation Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container blockquote' => 'color: {{VALUE}};',
				],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                ],
			]
		);
        $element->add_responsive_control(
			'_ob_postman_quotes_margin',
			[
				'label' => __( 'Quotation margin', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container blockquote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                    '{{WRAPPER}}.ob-postman .elementor-widget-container blockquote p' => 'margin: 0;', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
				],
			]
        );
        $element->add_responsive_control(
			'_ob_postman_quotes_padding',
			[
				'label' => __( 'Quotation padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                    '{{WRAPPER}}.ob-postman .elementor-widget-container blockquote p' => 'padding: 0;', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
				],
			]
        );
        $element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_ob_postman_quotes_typography', 
				'label' => __( 'Quotation Typography', 'royal-addons-for-elementor' ), 
				'selector' => '{{WRAPPER}}.ob-postman .elementor-widget-container blockquote', 
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				], 
				'condition' => [
					'_ob_postman_use' => 'yes', 
				],
			]
		);

        $element->add_control(
			'_ob_postman_quotes_cite_color',
			[
				'label' => __( 'Cite color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container blockquote cite' => 'color: {{VALUE}};',
				],
				'condition' => [
					'_ob_postman_use' => 'yes', 
                ],
			]
		);
        $element->add_responsive_control(
			'_ob_postman_quotes_cite_margin',
			[
				'label' => __( 'Cite margin', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}}.ob-postman .elementor-widget-container blockquote cite' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: block;', 
                ],
				'condition' => [
					'_ob_postman_use' => 'yes', 
				],
			]
        );
        $element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => '_ob_postman_quotes_cite_typography', 
				'label' => __( 'Cite typography', 'royal-addons-for-elementor' ), 
				'selector' => '{{WRAPPER}}.ob-postman .elementor-widget-container blockquote cite', 
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				], 
				'condition' => [
					'_ob_postman_use' => 'yes', 
				],
			]
		);
		$element->add_group_control(
            Group_Control_Background::get_type(),
            [
				'name' => '_ob_postman_quotes_bg', 
                'types' => [ 'classic' ], 
                'selector' => '{{WRAPPER}}.ob-postman .elementor-widget-container blockquote::before',
				'condition' => [
					'_ob_postman_use' => 'yes', 
				],
            ]
		);
        $element->add_responsive_control(
            '_ob_postman_quotes_bg_opacity',
            [
                'label' => __( 'Background opacity', 'royal-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.ob-postman .elementor-widget-container blockquote::before' => 'opacity: {{SIZE}};',
				],
				'condition' => [
                    '_ob_postman_use' => 'yes', 
                    '_ob_postman_quotes_bg_background' => [ 'classic' ], 
                ],
            ]
		);
		$element->end_controls_section();
	}

	/* Atomic Elements - registered tracker */
	private static $registered_elements = [];

}

RoyalTextz::init();