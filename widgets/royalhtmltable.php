<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly





/**
 * Elementor Table Widget.
 *
 * @since 1.0.0
 */
class RoyalHtmlTable extends Widget_Base{

	public function get_name() {
		return 'royalhtmltable';
	}


	public function get_title() {
		return 'HTML Table';
	}


	public function get_icon() { return 'eicon-table rtbranding'; }


	public function get_keywords() {
		return ['html', 'table', 'tbl', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}
  
  
	public function get_categories() {
		return [ 'royaltech' ];
	}


	protected function register_controls() {
		//Table Header start
		$this->start_controls_section(
			'content_table_header',
			[
				'label' => __( 'Table Header', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_header = new Repeater();

		$repeater_header->add_control(
			'text', [
				'label' => __( 'Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'table data', 'royal-addons-for-elementor' ),
				'default' => __( 'table data', 'royal-addons-for-elementor' ),
				'dynamic' => [
		            'active' => true,
		        ]
			]
		);
		$repeater_header->add_control(
			'advance', [
				'label' => __( 'Advance Settings', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);
		$repeater_header->add_control(
			'colspan', [
				'label' => __( 'colSpan', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);
		$repeater_header->add_control(
			'colspannumber', [
				'label' => __( 'colSpan Number', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'advance' => 'yes',
					'colspan' => 'yes',
				],
				'placeholder' => __( '1', 'royal-addons-for-elementor' ),
				'default' => __( '1', 'royal-addons-for-elementor' ),
			]
		);
		$repeater_header->add_control(
			'customwidth', [
				'label' => __( 'Custom Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);
		$repeater_header->add_responsive_control(
			'width', [
				'label' => __( 'Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'condition' => [
					'advance' => 'yes',
					'customwidth' => 'yes',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'default' => [
					'size' => 30,
					'unit' => '%',
				],
				'size_units' => [ '%', 'px' ],
				'selectors' => [ '{{WRAPPER}} table.royal-table {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$repeater_header->add_control(
			'align', [ 
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'advance' => 'yes',
				],
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
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.royal-table {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
				]
			]
		);
		$repeater_header->add_control(
			'decoration', [
				'label' => __( 'Decoration', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'advance' => 'yes',
				],
				'options' => [
					''  => __( 'Default', 'royal-addons-for-elementor' ),
					'underline' => __( 'Underline', 'royal-addons-for-elementor' ),
					'overline' => __( 'Overline', 'royal-addons-for-elementor' ),
					'line-through' => __( 'Line Through', 'royal-addons-for-elementor' ),
					'none' => __( 'None', 'royal-addons-for-elementor' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.royal-table {{CURRENT_ITEM}}' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_header',
			[
				'label' => __( 'Table Header Cell', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater_header->get_controls(),
				'default' => [
					[
						'text' => __( 'SL', 'royal-addons-for-elementor' ),
					],
					[
						'text' => __( 'Name', 'royal-addons-for-elementor' ),
					],
					[
						'text' => __( 'Designation', 'royal-addons-for-elementor' ),
					],
					[
						'text' => __( 'Email', 'royal-addons-for-elementor' ),
					]
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

		// Table Body Start
		$this->start_controls_section(
			'content_table_body',
			[
				'label' => __( 'Table Body', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		//$repeater->start_controls_tabs( 'slides_repeater' );
		//$repeater->start_controls_tab( 'general_table_body', [ 'label' => __( 'General', 'elementor-pro' ) ] );

		$repeater->add_control(
			'row', [
				'label' => __( 'New Row', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'text', [
				'label' => __( 'Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => __( 'Table Data', 'royal-addons-for-elementor' ),
				'default' => __( 'Table Data', 'royal-addons-for-elementor' ),
				'dynamic' => [
		            'active' => true,
		        ]
			]
		);

		//$repeater->end_controls_tab();
		//$repeater->start_controls_tab( 'advance_table_body', [ 'label' => __( 'Advance', 'elementor-pro' ) ] );

		$repeater->add_control(
			'advance', [
				'label' => __( 'Advance Settings', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'colspan', [
				'label' => __( 'colSpan', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'colspannumber', [
				'label' => __( 'colSpan Number', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'advance' => 'yes',
					'colspan' => 'yes',
				],
				'placeholder' => __( '1', 'royal-addons-for-elementor' ),
				'default' => __( '1', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'rowspan', [
				'label' => __( 'rowSpan', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'advance' => 'yes',
				],
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'rowspannumber', [
				'label' => __( 'rowSpan Number', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'advance' => 'yes',
					'rowspan' => 'yes',
				],
				'placeholder' => __( '1', 'royal-addons-for-elementor' ),
				'default' => __( '1', 'royal-addons-for-elementor' ),
			]
		);

		$repeater->add_control(
			'align', [
				'label' => __( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'advance' => 'yes',
				],
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
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.royal-table {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'decoration',
			[
				'label' => __( 'Decoration', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'advance' => 'yes',
				],
				'options' => [
					''  => __( 'Default', 'royal-addons-for-elementor' ),
					'underline' => __( 'Underline', 'royal-addons-for-elementor' ),
					'overline' => __( 'Overline', 'royal-addons-for-elementor' ),
					'line-through' => __( 'Line Through', 'royal-addons-for-elementor' ),
					'none' => __( 'None', 'royal-addons-for-elementor' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} table.royal-table {{CURRENT_ITEM}}' => 'text-decoration: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'table_body',
			[
				'label' => __( 'Table Body Cell', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => __( '1', 'royal-addons-for-elementor' ),
					],
					[
						'text' => __( 'S M Mehdi Akram', 'royal-addons-for-elementor' ),
					],
					[
						'text' => __( 'CEO', 'royal-addons-for-elementor' ),
					],
					[
						'text' => __( 'mehdi@example.com', 'royal-addons-for-elementor' ),
					],
					
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'General Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'table_padding',
			[
				'label' => __( 'Inner Cell Padding', 'plugin-domain' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.royal-table td,{{WRAPPER}} table.royal-table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'table_border',
				'label' => __( 'Border', 'royal-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} table.royal-table td,{{WRAPPER}} table.royal-table th',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'table_header_style',
			[
				'label' => __( 'Table Header Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'header_align',
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
					],
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} table.royal-table .royal-table-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.royal-table .royal-table-header' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_typography',
				'selector' => '{{WRAPPER}} table.royal-table .royal-table-header',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' 	=> '#CCCCCC',				
				'selectors' => [
					'{{WRAPPER}} table.royal-table .royal-table-header' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'table_body_style',
			[
				'label' => __( 'Table Body Style', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'body_align',
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
					],
					'justify' => [
						'title' => __( 'Justified', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} table.royal-table .royal-table-body' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'body_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.royal-table .royal-table-body' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'body_typography',
				'selector' => '{{WRAPPER}} table.royal-table .royal-table-body',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'body_bg_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.royal-table .royal-table-body' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'striped_bg', 
			[
				'label' => __( 'Striped Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on' => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'striped_bg_color', 
			[
				'label' => __( 'Secondary Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' 	=> '#DDDDDD',
				'condition' => [
					'striped_bg' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} table.royal-table .royal-table-body tr:nth-of-type(2n)' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings_for_display();
		?>
		<table class="royal-table">
			<thead  class="royal-table-header">
				<tr>
					<?php
					foreach ($settings['table_header'] as $index => $item) {
						$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'table_header', $index );
						$this->add_inline_editing_attributes( $repeater_setting_key );

						$colspan = ($item['colspan'] == 'yes' && $item['advance'] == 'yes') ? 'colSpan="'.$item['colspannumber'].'"' : '';

						echo '<th class="elementor-inline-editing elementor-repeater-item-'.$item['_id'].'"  '.$colspan.' '.$this->get_render_attribute_string( $repeater_setting_key ).'>'.$item['text'].'</th>';
					}
					?>
				</tr>
			</thead>
			<tbody class="royal-table-body">
				<tr>
					<?php
					foreach ($settings['table_body'] as $index => $item) {
						$table_body_key = $this->get_repeater_setting_key( 'text', 'table_body', $index );

						$this->add_render_attribute( $table_body_key, 'class', 'elementor-repeater-item-'.$item['_id'] );
						$this->add_inline_editing_attributes( $table_body_key );

						if($item['row'] == 'yes'){
							echo '</tr><tr>';
						}

						$colspan = ($item['colspan'] == 'yes' && $item['advance'] == 'yes') ? 'colSpan="'.$item['colspannumber'].'"' : '';

						$rowspan = ($item['rowspan'] == 'yes' & $item['advance'] == 'yes') ? 'rowSpan="'.$item['rowspannumber'].'"' : '';

						echo '<td '.$colspan.' '.$rowspan.' '.$this->get_render_attribute_string( $table_body_key ).' >'.$item['text'].'</td>';
					}
					?>
				</tr>
			</tbody>
		</table>
		
		<?php

	}

	protected function content_template() {
		?>
		<table class="royal-table">
			<thead class="royal-table-header">
				<tr>
					<#
					if ( settings.table_header ) {
						_.each( settings.table_header, function( item, index ) {
							var iconTextKey = view.getRepeaterSettingKey( 'text', 'table_header', index );

							if( 'yes' === item.colspan && 'yes' === item.advance){
								colSpan = 'colSpan="'+item.colspannumber+'"';
							}else{
								colSpan = '';
							}
							
							view.addRenderAttribute( iconTextKey, 'class', 'elementor-repeater-item-'+item._id );
							view.addInlineEditingAttributes( iconTextKey );
							#>
							<th {{{colSpan}}} {{{ view.getRenderAttributeString( iconTextKey ) }}}>{{{ item.text }}}</th>
						<#
						} );
					} #>
				</tr>
			</thead>
			<tbody class="royal-table-body">
				<tr>
					<#
					if ( settings.table_body ) {
						_.each( settings.table_body, function( item, index ) {
							if( 'yes' === item.row){
								newRow = '</tr><tr>';
							}else{
								newRow = '';
							}

							if( 'yes' === item.colspan && 'yes' === item.advance){
								colSpan = 'colSpan="'+item.colspannumber+'"';
							}else{
								colSpan = '';
							}

							if( 'yes' === item.rowspan && 'yes' === item.advance){
								rowSpan = 'rowSpan="'+item.rowspannumber+'"';
							}else{
								rowSpan = '';
							}

							var tdTextKey = view.getRepeaterSettingKey( 'text', 'table_body', index );
							
							view.addRenderAttribute( tdTextKey, 'class', 'elementor-repeater-item-'+item._id );
							view.addInlineEditingAttributes( tdTextKey );

							#>
							{{{newRow}}}
							<td {{{rowSpan}}} {{{colSpan}}} {{{ view.getRenderAttributeString( tdTextKey ) }}}>{{{ item.text }}}</td>
						<#
						} );
					} #>
				</tr>
			</tbody>
		</table>
		<?php
	}
}