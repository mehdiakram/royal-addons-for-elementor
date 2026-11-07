<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RoyalZakatCalculator extends Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_style(
			'royalzakatcalculator',
			ROYAL_ADDONS_ASSETS . 'css/royalzakatcalculator.css',
			[],
			'1.0.0'
		);
		wp_register_script(
			'royalzakatcalculator',
			ROYAL_ADDONS_ASSETS . 'js/royalzakatcalculator.js',
			[ 'elementor-frontend', 'jquery' ],
			'1.0.0',
			true
		);
	}

	public function get_name() {
		return 'royalzakatcalculator';
	}

	public function get_title() {
		return __( 'Royal Zakat Calculator', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-price-table rtbranding'; }

	public function get_categories() {
		return [ 'royaltech' ];
	}

    public function get_keywords() {
        return [ 'zakat', 'calculator', 'islamic', 'finance', 'royal addons', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
    }

    public function get_style_depends() {
        return [ 'royalzakatcalculator' ];
    }

    public function get_script_depends() {
        return [ 'royalzakatcalculator' ];
    }

	protected function register_controls() {

		$this->start_controls_section(
			'section_backend_values',
			[
				'label' => __( 'Default Values', 'royal-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'gold_price_backend_notice',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<strong>Gold & Silver Price:</strong> <a href="https://www.bajus.org/gold-price" target="_blank" rel="nofollow noopener">https://www.bajus.org/gold-price</a>',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label' => __( 'Currency Symbol', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'BDT', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'nisab_value_default',
			[
				'label' => __( 'Default Nisab Value', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'step' => 'any',
				'default' => 144845,
			]
		);

		$this->add_control(
			'gold_price_default',
			[
				'label' => __( 'Default Gold Price (per gram)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER, 'step' => 'any', 'default' => 14283,
			]
		);
		$this->add_control(
			'silver_price_default',
			[
				'label' => __( 'Default Silver Price (per gram)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER, 'step' => 'any', 'default' => 230,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section('section_labels', ['label' => __( 'Calculator Labels', 'royal-addons-for-elementor' )]);
		
		$this->add_control('heading_main', ['label' => __( 'Main Labels', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::HEADING]);
		$this->add_control('nisab_value_label', ['label' => __( 'Nisab Value Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Nisab Value', 'royal-addons-for-elementor' )]);
		$this->add_control('assets_title_label', ['label' => __( 'Assets Title Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Zakatable Assets', 'royal-addons-for-elementor' )]);
		$this->add_control('liabilities_title_label', ['label' => __( 'Liabilities Title Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Deductible Liabilities', 'royal-addons-for-elementor' )]);

		$this->add_control('heading_assets', ['label' => __( 'Asset Field Labels', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before']);
		$this->add_control('gold_grams_label', ['label' => __( 'Gold (grams) Label', 'royal-addons-for-elementor' ),'type' => Controls_Manager::TEXT,'default' => __( 'Gold (in grams)', 'royal-addons-for-elementor' )]);
		$this->add_control('gold_price_label', ['label' => __( 'Gold Price Label', 'royal-addons-for-elementor' ),'type' => Controls_Manager::TEXT,'default' => __( 'Gold Price (per gram)', 'royal-addons-for-elementor' )]);
		$this->add_control('gold_value_label', ['label' => __( 'Value of Gold Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Value of Gold', 'royal-addons-for-elementor' )]);
		$this->add_control('silver_grams_label', ['label' => __( 'Silver (grams) Label', 'royal-addons-for-elementor' ),'type' => Controls_Manager::TEXT,'default' => __( 'Silver (in grams)', 'royal-addons-for-elementor' )]);
		$this->add_control('silver_price_label', ['label' => __( 'Silver Price Label', 'royal-addons-for-elementor' ),'type' => Controls_Manager::TEXT,'default' => __( 'Silver Price (per gram)', 'royal-addons-for-elementor' )]);
		$this->add_control('silver_value_label', ['label' => __( 'Value of Silver Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Value of Silver', 'royal-addons-for-elementor' )]);
		$this->add_control('cash_label', ['label' => __( 'Cash Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'In hand and in bank accounts', 'royal-addons-for-elementor' )]);
		$this->add_control('hajj_deposit_label', ['label' => __( 'Hajj Deposit Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Deposited for ( e.g. Hajj )', 'royal-addons-for-elementor' )]);
		$this->add_control('loans_given_label', ['label' => __( 'Loans Given Out Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Given out in loans', 'royal-addons-for-elementor' )]);
		$this->add_control('investments_label', ['label' => __( 'Investments Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Business investments, shares, saving certificates, pensions', 'royal-addons-for-elementor' )]);
		$this->add_control('stock_value_label', ['label' => __( 'Stock Value Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Value of stock (Trade Goods)', 'royal-addons-for-elementor' )]);

		$this->add_control('heading_liabilities', ['label' => __( 'Liability Field Labels', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before']);
		$this->add_control('borrowed_money_label', ['label' => __( 'Borrowed Money Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Borrowed money, goods bought on credit', 'royal-addons-for-elementor' )]);
		$this->add_control('wages_due_label', ['label' => __( 'Wages Due Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Wages due to employees', 'royal-addons-for-elementor' )]);
		$this->add_control('bills_due_label', ['label' => __( 'Bills Due Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Taxes, rent, utility bills due immediately', 'royal-addons-for-elementor' )]);
		
		$this->add_control('heading_results', ['label' => __( 'Result Labels', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before']);
		$this->add_control('total_assets_label', ['label' => __( 'Total Assets Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Total Assets:', 'royal-addons-for-elementor' )]);
		$this->add_control('total_liabilities_label', ['label' => __( 'Total Liabilities Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Total Liabilities:', 'royal-addons-for-elementor' )]);
		$this->add_control('net_worth_label', ['label' => __( 'Net Worth Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Net Zakatable Wealth:', 'royal-addons-for-elementor' )]);
		$this->add_control('zakat_due_label', ['label' => __( 'Zakat Due Label', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Zakat Due:', 'royal-addons-for-elementor' )]);
		$this->add_control('msg_below_nisab_label', ['label' => __( 'Message (Below Nisab)', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => __( 'Your wealth is below the Nisab threshold. No Zakat is due.', 'royal-addons-for-elementor' )]);
		$this->add_control('msg_above_nisab_label', ['label' => __( 'Message (Above Nisab)', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'default' => __( 'Zakat is due based on your calculations.', 'royal-addons-for-elementor' )]);

		$this->end_controls_section();

		//==================================================
        // STYLE TAB
        //==================================================

		$this->start_controls_section('section_style_titles', ['label' => __( 'Section Titles', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE]);
		$this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'title_typography', 'selector' => '{{WRAPPER}} .rzc-section-title']);
		$this->add_control('title_color', ['label' => __( 'Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-section-title' => 'color: {{VALUE}};']]);
		$this->add_control('title_border_color', ['label' => __( 'Border Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-section-title' => 'border-bottom-color: {{VALUE}};']]);
		$this->end_controls_section();

		$this->start_controls_section('section_style_labels', ['label' => __( 'Field Labels', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE]);
		$this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'label_typography', 'selector' => '{{WRAPPER}} .rzc-label']);
		$this->add_control('label_color', ['label' => __( 'Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-label' => 'color: {{VALUE}};']]);
		$this->end_controls_section();

		$this->start_controls_section('section_style_inputs', ['label' => __( 'Input Fields', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE]);
		$this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'input_typography', 'selector' => '{{WRAPPER}} .rzc-input']);
		$this->add_control('input_text_color', ['label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-input' => 'color: {{VALUE}};']]);
		$this->add_control('input_bg_color', ['label' => __( 'Background Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-input' => 'background-color: {{VALUE}};']]);
		$this->add_group_control(Group_Control_Border::get_type(), ['name' => 'input_border', 'selector' => '{{WRAPPER}} .rzc-input']);
		$this->add_responsive_control('input_border_radius', ['label' => __( 'Border Radius', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => ['px', '%'], 'selectors' => ['{{WRAPPER}} .rzc-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};']]);
		$this->end_controls_section();

		$this->start_controls_section('section_style_results', ['label' => __( 'Results Area', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_STYLE]);
		$this->add_control('results_bg_color', ['label' => __( 'Background Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-results-section' => 'background-color: {{VALUE}};']]);
		$this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'results_typography', 'selector' => '{{WRAPPER}} .rzc-result-row span']);
		$this->add_control('results_text_color', ['label' => __( 'Text Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-result-row span' => 'color: {{VALUE}};']]);
		$this->add_control('results_final_zakat_color', ['label' => __( 'Final Zakat Amount Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => ['{{WRAPPER}} .rzc-result-row.rzc-final-zakat span:last-child' => 'color: {{VALUE}};']]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        
        $this->add_render_attribute( 'wrapper', [
            'class' => 'royal-zakat-calculator-wrapper',
            'data-settings' => wp_json_encode([
                'currency_symbol' => $settings['currency_symbol'],
				'nisab_value'     => $settings['nisab_value_default'],
                'gold_price'      => $settings['gold_price_default'],
                'silver_price'    => $settings['silver_price_default'],
				'msg_below_nisab' => $settings['msg_below_nisab_label'],
				'msg_above_nisab' => $settings['msg_above_nisab_label'],
            ])
        ]);
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            
            <div class="rzc-section rzc-nisab-section">
                <div class="rzc-field-group rzc-field-group-inline">
                    <label for="rzc-nisab-value" class="rzc-label"><?php echo esc_html($settings['nisab_value_label']); ?></label>
                    <input type="number" aria-label="Enter Amount" id="rzc-nisab-value" class="rzc-input" placeholder="0.00">
                </div>
            </div>

            <!-- ASSETS -->
            <div class="rzc-section">
                <h3 class="rzc-section-title"><?php echo esc_html($settings['assets_title_label']); ?></h3>
                <div class="rzc-metal-group">
                    <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['gold_grams_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-gold-grams" class="rzc-input" placeholder="0.00"></div>
                    <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['gold_price_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-gold-price" class="rzc-input" placeholder="0.00"></div>
                    <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['gold_value_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-gold-value" class="rzc-input" placeholder="0.00"></div>
                </div>
                <div class="rzc-metal-group">
                    <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['silver_grams_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-silver-grams" class="rzc-input" placeholder="0.00"></div>
                    <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['silver_price_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-silver-price" class="rzc-input" placeholder="0.00"></div>
                    <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['silver_value_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-silver-value" class="rzc-input" placeholder="0.00"></div>
                </div>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['cash_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-cash" class="rzc-input" placeholder="0.00"></div>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['hajj_deposit_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-hajj-deposit" class="rzc-input" placeholder="0.00"></div>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['loans_given_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-loans-given" class="rzc-input" placeholder="0.00"></div>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['investments_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-investments" class="rzc-input" placeholder="0.00"></div>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['stock_value_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-stock-value" class="rzc-input" placeholder="0.00"></div>
            </div>

            <!-- LIABILITIES -->
            <div class="rzc-section">
                <h3 class="rzc-section-title"><?php echo esc_html($settings['liabilities_title_label']); ?></h3>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['borrowed_money_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-borrowed-money" class="rzc-input" placeholder="0.00"></div>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['wages_due_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-wages-due" class="rzc-input" placeholder="0.00"></div>
                <div class="rzc-field-group"><label class="rzc-label"><?php echo esc_html($settings['bills_due_label']); ?></label><input type="number" aria-label="Enter Amount" id="rzc-bills-due" class="rzc-input" placeholder="0.00"></div>
            </div>

            <!-- RESULTS -->
            <div class="rzc-section rzc-results-section">
                <div class="rzc-result-row"><span><?php echo esc_html($settings['total_assets_label']); ?></span><span id="rzc-total-assets">--</span></div>
                <div class="rzc-result-row"><span><?php echo esc_html($settings['total_liabilities_label']); ?></span><span id="rzc-total-liabilities">--</span></div>
                <div class="rzc-result-row rzc-net-worth"><span><?php echo esc_html($settings['net_worth_label']); ?></span><span id="rzc-net-worth">--</span></div>
                <div class="rzc-result-row rzc-final-zakat"><span><?php echo esc_html($settings['zakat_due_label']); ?></span><span id="rzc-zakat-due">--</span></div>
				<div id="rzc-message" class="rzc-message"></div>
            </div>

			<div class="rzc-actions">
				<button id="rzc-print-btn" class="rzc-button rzc-button-secondary"><?php _e('Print', 'royal-addons-for-elementor'); ?></button>
				<button id="rzc-clear-btn" class="rzc-button"><?php _e('Clear Calculator', 'royal-addons-for-elementor'); ?></button>
			</div>
        </div>
		<?php
	}
}
