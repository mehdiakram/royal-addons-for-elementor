<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use RoyalAddons\Modules\Forms\Classes\Form_Base;
use RoyalAddons\Modules\Forms\Module;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class RoyalForm extends Form_Base {

	public function get_name() {
		return 'royal-form';
	}

	public function get_title() {
		return __( 'Royal Form', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-form-horizontal rtbranding'; }

	public function get_categories() {
		return array( 'royaltech' );
	}

	public function get_script_depends() {
		return [ 'royalform' ];
	}

	public function get_style_depends() {
		return [ 'royalform' ];
	}

	protected function register_controls() {
		$this->register_form_fields_section();
		$this->register_submit_actions_section();
		$this->register_email_section();
		$this->register_custom_messages_section();
		$this->register_redirect_section();
		$this->register_webhook_section();
		$this->register_slack_section();
		$this->register_discord_section();
		$this->register_mailchimp_section();
		$this->register_popup_section();
		$this->register_form_style_section();
		$this->register_field_style_section();
		$this->register_label_style_section();
		$this->register_button_style_section();
	}

	private function register_form_fields_section() {
		$this->start_controls_section(
			'section_form_fields',
			[
				'label' => __( 'Form Fields', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'form_name',
			[
				'label' => __( 'Form Name', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'New Form', 'royal-addons-for-elementor' ),
				'placeholder' => __( 'Form Name', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'form_preset',
			[
				'label' => __( 'Form Preset', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( '— Select Preset —', 'royal-addons-for-elementor' ),
					'contact' => __( 'Contact Form', 'royal-addons-for-elementor' ),
					'contact_with_file' => __( 'Contact Form + Attachment', 'royal-addons-for-elementor' ),
					'booking' => __( 'Booking / Appointment', 'royal-addons-for-elementor' ),
					'quote' => __( 'Quote / Estimate Request', 'royal-addons-for-elementor' ),
					'newsletter' => __( 'Newsletter Signup', 'royal-addons-for-elementor' ),
					'feedback' => __( 'Feedback / Survey', 'royal-addons-for-elementor' ),
					'job_application' => __( 'Job Application', 'royal-addons-for-elementor' ),
					'event_registration' => __( 'Event Registration', 'royal-addons-for-elementor' ),
				],
				'description' => __( 'Select a preset to auto-fill form fields. This will replace existing fields.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'apply_preset_btn',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<button type="button" class="elementor-button elementor-button-default royal-apply-preset-btn" style="margin-top:5px;">' . __( 'Apply Preset', 'royal-addons-for-elementor' ) . '</button>',
				'content_classes' => 'royal-apply-preset',
			]
		);

		$repeater = new Repeater();

		// Get field types from registrar
		$field_types = Module::instance()->fields_registrar->get_field_types_options();

		$repeater->add_control(
			'field_type',
			[
				'label' => __( 'Type', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => $field_types,
				'default' => 'text',
			]
		);

		$repeater->add_control(
			'field_label',
			[
				'label' => __( 'Label', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => '!in',
							'value' => [ 'hidden', 'step', 'honeypot', 'recaptcha' ],
						],
					],
				],
			]
		);

		$repeater->add_control(
			'placeholder',
			[
				'label' => __( 'Placeholder', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'text', 'email', 'textarea', 'url', 'tel', 'number', 'date', 'time' ],
						],
					],
				],
			]
		);

		$repeater->add_control(
			'required',
			[
				'label' => __( 'Required', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'true',
				'default' => '',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => '!in',
							'value' => [ 'hidden', 'step', 'html', 'honeypot' ],
						],
					],
				],
			]
		);
		
		$repeater->add_responsive_control(
			'input_size',
			[
				'label' => __( 'Column Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'100.00' => '100%',
					'80.000' => '80%',
					'75.000' => '75%',
					'66.666' => '66.666%',
					'60.000' => '60%',
					'50.000' => '50%',
					'40.000' => '40%',
					'33.333' => '33.333%',
					'25.000' => '25%',
					'20.000' => '20%',
				],
				'default' => '100',
			]
		);



		$repeater->add_responsive_control(
			'layout_mode',
			[
				'label' => __( 'Layout Mode', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inline-flex' => __( 'Inline (Side-by-side)', 'royal-addons-for-elementor' ),
					'block' => __( 'New Line (Block)', 'royal-addons-for-elementor' ),
				],
				'default' => 'inline-flex',
				'description' => __( 'Select "New Line" to force this field to a new row.', 'royal-addons-for-elementor' ),
				'separator' => 'before',
			]
		);
		
		$repeater->add_control(
			'custom_id',
			[
				'label' => __( 'ID', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Unique ID for this field. Used in email templates.', 'royal-addons-for-elementor' ),
				'default' => '',
			]
		);

		// Token display with copy button - placeholder that gets updated via JS
		$repeater->add_control(
			'field_token_display',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<div class="royal-field-token-wrapper" style="display:flex; align-items:center; gap:8px; padding:8px 10px; background:#f8f9fa; border:1px solid #e0e0e0; border-radius:4px; margin-top:5px;">
					<span style="font-weight:500; color:#666; font-size:12px;">' . __( 'Token:', 'royal-addons-for-elementor' ) . '</span>
					<code class="royal-field-token-code" style="background:#e8f4fc; color:#0073aa; padding:3px 8px; border-radius:3px; font-size:12px; font-family:monospace;">[field_id]</code>
					<button type="button" class="royal-copy-field-token elementor-button elementor-button-default" style="padding:4px 10px; font-size:11px;" title="' . __( 'Copy Token', 'royal-addons-for-elementor' ) . '">
						<i class="eicon-copy"></i> ' . __( 'Copy', 'royal-addons-for-elementor' ) . '
					</button>
				</div>',
				'content_classes' => 'royal-field-token-control',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => '!in',
							'value' => [ 'step', 'html', 'honeypot', 'recaptcha' ],
						],
					],
				],
			]
		);



		$repeater->add_control(
			'field_value',
			[
				'label' => __( 'Default Value', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [ 'active' => true ],
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'text', 'email', 'url', 'tel', 'number', 'hidden' ],
						],
					],
				],
			]
		);

		// Field-specific controls
		$this->add_field_specific_controls( $repeater );

		$this->add_control(
			'form_fields',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'_id' => 'field_name',
						'custom_id' => 'name',
						'field_type' => 'text',
						'field_label' => __( 'Name', 'royal-addons-for-elementor' ),
						'placeholder' => __( 'Your Name', 'royal-addons-for-elementor' ),
						'input_size' => '50.000',
						'required' => 'true',
					],
					[
						'_id' => 'field_email',
						'custom_id' => 'email',
						'field_type' => 'email',
						'required' => 'true',
						'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
						'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
						'input_size' => '50.000',
					],
					[
						'_id' => 'field_subject',
						'custom_id' => 'subject',
						'field_type' => 'text',
						'field_label' => __( 'Subject', 'royal-addons-for-elementor' ),
						'placeholder' => __( 'Subject', 'royal-addons-for-elementor' ),
						'input_size' => '100.00',
					],
					[
						'_id' => 'field_message',
						'custom_id' => 'message',
						'field_type' => 'textarea',
						'field_label' => __( 'Message', 'royal-addons-for-elementor' ),
						'placeholder' => __( 'Your Message', 'royal-addons-for-elementor' ),
						'input_size' => '100.00',
						'required' => 'true',
					],
				],
				'title_field' => '{{{ field_label || field_type }}}',
			]
		);

		$this->add_control(
			'input_size_style',
			[
				'label' => __( 'Input Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'xs' => __( 'Extra Small', 'royal-addons-for-elementor' ),
					'sm' => __( 'Small', 'royal-addons-for-elementor' ),
					'md' => __( 'Medium', 'royal-addons-for-elementor' ),
					'lg' => __( 'Large', 'royal-addons-for-elementor' ),
					'xl' => __( 'Extra Large', 'royal-addons-for-elementor' ),
				],
				'default' => 'sm',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label' => __( 'Show Labels', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'mark_required',
			[
				'label' => __( 'Mark Required Fields', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_placeholder',
			[
				'label' => __( 'Show Placeholder', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function add_field_specific_controls( $repeater ) {
		// Textarea rows
		$repeater->add_control(
			'rows',
			[
				'label' => __( 'Rows', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
				'min' => 1,
				'max' => 20,
				'condition' => [ 'field_type' => 'textarea' ],
			]
		);

		// Number field controls
		$repeater->add_control(
			'min_value',
			[
				'label' => __( 'Min Value', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => 'number' ],
			]
		);

		$repeater->add_control(
			'max_value',
			[
				'label' => __( 'Max Value', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'field_type' => 'number' ],
			]
		);

		// Select/Checkbox/Radio options
		$repeater->add_control(
			'field_options',
			[
				'label' => __( 'Options', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => __( 'One option per line. Use value|label format.', 'royal-addons-for-elementor' ),
				'default' => "option1|Option 1\noption2|Option 2\noption3|Option 3",
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'select', 'checkbox', 'radio' ],
						],
					],
				],
			]
		);

		$repeater->add_control(
			'allow_multiple',
			[
				'label' => __( 'Multiple Selection', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'field_type' => 'select' ],
			]
		);

		$repeater->add_control(
			'inline_list',
			[
				'label' => __( 'Inline', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => 'in',
							'value' => [ 'checkbox', 'radio' ],
						],
					],
				],
			]
		);

		// Acceptance
		$repeater->add_control(
			'acceptance_text',
			[
				'label' => __( 'Acceptance Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'I agree to the terms and conditions', 'royal-addons-for-elementor' ),
				'condition' => [ 'field_type' => 'acceptance' ],
			]
		);

		// File upload
		$repeater->add_control(
			'file_types',
			[
				'label' => __( 'Allowed File Types', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Comma separated (e.g., jpg, png, pdf)', 'royal-addons-for-elementor' ),
				'default' => 'jpg, jpeg, png, gif, pdf',
				'condition' => [ 'field_type' => 'file' ],
			]
		);

		$repeater->add_control(
			'max_file_size',
			[
				'label' => __( 'Max File Size (MB)', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5,
				'min' => 1,
				'max' => 100,
				'condition' => [ 'field_type' => 'file' ],
			]
		);

		$repeater->add_control(
			'allow_multiple_upload',
			[
				'label' => __( 'Allow Multiple Files', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'field_type' => 'file' ],
			]
		);

		// HTML content
		$repeater->add_control(
			'html_content',
			[
				'label' => __( 'HTML Content', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<p>' . __( 'Custom HTML content...', 'royal-addons-for-elementor' ) . '</p>',
				'condition' => [ 'field_type' => 'html' ],
			]
		);

		// Step
		$repeater->add_control(
			'step_title',
			[
				'label' => __( 'Step Title', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Step', 'royal-addons-for-elementor' ),
				'condition' => [ 'field_type' => 'step' ],
			]
		);

		$repeater->add_control(
			'previous_button_text',
			[
				'label' => __( 'Previous Button Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Previous', 'royal-addons-for-elementor' ),
				'condition' => [ 'field_type' => 'step' ],
			]
		);

		$repeater->add_control(
			'next_button_text',
			[
				'label' => __( 'Next Button Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Next', 'royal-addons-for-elementor' ),
				'condition' => [ 'field_type' => 'step' ],
			]
		);

		// Conditional Logic Controls
		$repeater->add_control(
			'conditional_logic_heading',
			[
				'label' => __( 'Conditional Logic', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => '!in',
							'value' => [ 'step', 'honeypot', 'recaptcha' ],
						],
					],
				],
			]
		);

		$repeater->add_control(
			'enable_conditions',
			[
				'label' => __( 'Enable', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'conditions' => [
					'terms' => [
						[
							'name' => 'field_type',
							'operator' => '!in',
							'value' => [ 'step', 'honeypot', 'recaptcha' ],
						],
					],
				],
			]
		);

		$repeater->add_control(
			'condition_action',
			[
				'label' => __( 'Action', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'show' => __( 'Show this field if', 'royal-addons-for-elementor' ),
					'hide' => __( 'Hide this field if', 'royal-addons-for-elementor' ),
				],
				'default' => 'show',
				'condition' => [ 'enable_conditions' => 'yes' ],
			]
		);

		$repeater->add_control(
			'condition_field',
			[
				'label' => __( 'Field', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Field ID', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter the ID of the field to check.', 'royal-addons-for-elementor' ),
				'condition' => [ 'enable_conditions' => 'yes' ],
			]
		);

		$repeater->add_control(
			'condition_operator',
			[
				'label' => __( 'Operator', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'equals' => __( 'Equals', 'royal-addons-for-elementor' ),
					'not_equals' => __( 'Not Equals', 'royal-addons-for-elementor' ),
					'contains' => __( 'Contains', 'royal-addons-for-elementor' ),
					'not_contains' => __( 'Does Not Contain', 'royal-addons-for-elementor' ),
					'empty' => __( 'Is Empty', 'royal-addons-for-elementor' ),
					'not_empty' => __( 'Is Not Empty', 'royal-addons-for-elementor' ),
					'greater_than' => __( 'Greater Than', 'royal-addons-for-elementor' ),
					'less_than' => __( 'Less Than', 'royal-addons-for-elementor' ),
				],
				'default' => 'equals',
				'condition' => [ 'enable_conditions' => 'yes' ],
			]
		);

		$repeater->add_control(
			'condition_value',
			[
				'label' => __( 'Value', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_conditions' => 'yes',
					'condition_operator!' => [ 'empty', 'not_empty' ],
				],
			]
		);
	}

	private function register_submit_actions_section() {
		$this->start_controls_section(
			'section_submit_options',
			[
				'label' => __( 'Submit Options', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'submit_actions',
			[
				'label' => __( 'Actions After Submit', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'email' => __( 'Email', 'royal-addons-for-elementor' ),
					'redirect' => __( 'Redirect', 'royal-addons-for-elementor' ),
					'database' => __( 'Save to Database', 'royal-addons-for-elementor' ),
					'webhook' => __( 'Webhook', 'royal-addons-for-elementor' ),
					'slack' => __( 'Slack', 'royal-addons-for-elementor' ),
					'discord' => __( 'Discord', 'royal-addons-for-elementor' ),
					'mailchimp' => __( 'Mailchimp', 'royal-addons-for-elementor' ),
					'popup' => __( 'Popup', 'royal-addons-for-elementor' ),
				],
				'default' => [ 'email' ],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Submit', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Button Size', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => self::get_button_sizes(),
				'default' => 'sm',
			]
		);

		$this->add_control(
			'button_width',
			[
				'label' => __( 'Button Width', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'royal-addons-for-elementor' ),
					'100' => '100%',
					'80' => '80%',
					'75' => '75%',
					'66' => '66%',
					'50' => '50%',
					'33' => '33%',
					'25' => '25%',
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .royal-form-submit-wrapper' => 'width: {{VALUE}}%;',
				],
			]
		);

		$this->add_control(
			'button_align',
			[
				'label' => __( 'Button Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'stretch' => [
						'title' => __( 'Stretch', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'start',
				'selectors' => [
					'{{WRAPPER}} .royal-form-submit-wrapper' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_custom_messages_section() {
		$this->start_controls_section(
			'section_custom_messages',
			[
				'label' => __( 'Custom Messages', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'success_message',
			[
				'label' => __( 'Success Message', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'The message was sent successfully.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'error_message',
			[
				'label' => __( 'Error Message', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'An error occurred, please try again.', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	private function register_email_section() {
		$this->start_controls_section(
			'section_email',
			[
				'label' => __( 'Email', 'royal-addons-for-elementor' ),
				'condition' => [
					'submit_actions' => 'email',
				],
			]
		);

		$this->add_control(
			'available_tokens_list',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<div class="royal-available-tokens-wrapper">
							<p style="margin-bottom:5px; font-weight:600;">' . __( 'Available Tokens:', 'royal-addons-for-elementor' ) . '</p>
							<div class="royal-available-tokens-list" style="display:flex; flex-wrap:wrap; gap:5px; margin-bottom:15px;">
								<span style="color:#888; font-size:12px; font-style:italic;">' . __( 'Save form to see tokens...', 'royal-addons-for-elementor' ) . '</span>
							</div>
						  </div>',
			]
		);

		$this->add_control(
			'email_to',
			[
				'label' => __( 'To', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => get_option( 'admin_email' ),
				'placeholder' => get_option( 'admin_email' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'email_subject',
			[
				'label' => __( 'Subject', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '[subject]',
				'placeholder' => '[subject]',
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'email_from',
			[
				'label' => __( 'From Email', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => get_option( 'admin_email' ),
			]
		);

		$this->add_control(
			'email_from_name',
			[
				'label' => __( 'From Name', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => get_bloginfo( 'name' ),
			]
		);

		$this->add_control(
			'email_reply_to',
			[
				'label' => __( 'Reply To', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Use {{email}} to reply to the form submitter', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'email_cc',
			[
				'label' => __( 'CC', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'email_bcc',
			[
				'label' => __( 'BCC', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'email_content_type',
			[
				'label' => __( 'Send As', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'html' => __( 'HTML', 'royal-addons-for-elementor' ),
					'plain' => __( 'Plain Text', 'royal-addons-for-elementor' ),
				],
				'default' => 'html',
			]
		);



		$this->add_control(
			'email_template_preset',
			[
				'label' => __( 'Email Template', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Select Template', 'royal-addons-for-elementor' ),
					'default' => __( 'Default (All Fields)', 'royal-addons-for-elementor' ),
					'table' => __( 'Table Layout', 'royal-addons-for-elementor' ),
					'plain' => __( 'Simple List', 'royal-addons-for-elementor' ),
				],
				'default' => '',
				'description' => __( 'Select a template to populate the message field below. Note: This will overwrite your current message content.', 'royal-addons-for-elementor' ),
			]
		);
		
		$this->add_control(
			'apply_email_template_btn',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<button type="button" class="elementor-button elementor-button-default royal-apply-email-template-btn" style="margin-top:5px; margin-bottom:10px;">' . __( 'Apply Template', 'royal-addons-for-elementor' ) . '</button>',
				'content_classes' => 'royal-apply-email-template',
			]
		);

		$this->add_control(
			'email_content',
			[
				'label' => __( 'Message', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
				'description' => __( 'Leave empty for default template. Use field tokens like [name], [email], [subject], [message], or system tokens like [all-fields], [site:name], [page:url].', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'email_append_footer',
			[
				'label' => __( 'Append Metadata Footer', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'description' => __( 'Adds submitted from, date, and IP address info to the email footer.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'email_tokens_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<details><summary style="cursor:pointer;color:#0073aa;">' . __( 'Token Reference Guide', 'royal-addons-for-elementor' ) . '</summary>
					<div style="font-size:11px;line-height:1.8;margin-top:10px;">
						<strong style="color:#333;">' . __( 'Field Tokens:', 'royal-addons-for-elementor' ) . '</strong><br>
						<code>[name]</code>, <code>[email]</code>, <code>[subject]</code>, <code>[message]</code> - ' . __( 'Use your field IDs directly', 'royal-addons-for-elementor' ) . '<br><br>
						<strong style="color:#333;">' . __( 'System Tokens:', 'royal-addons-for-elementor' ) . '</strong><br>
						<code>[all-fields]</code> - ' . __( 'All fields as table', 'royal-addons-for-elementor' ) . '<br>
						<code>[site:name]</code> - ' . __( 'Site name', 'royal-addons-for-elementor' ) . '<br>
						<code>[site:url]</code> - ' . __( 'Site URL', 'royal-addons-for-elementor' ) . '<br>
						<code>[page:title]</code> - ' . __( 'Page title', 'royal-addons-for-elementor' ) . '<br>
						<code>[page:url]</code> - ' . __( 'Page URL', 'royal-addons-for-elementor' ) . '<br>
						<code>[form:name]</code> - ' . __( 'Form name', 'royal-addons-for-elementor' ) . '<br>
						<code>[user:ip]</code> - ' . __( 'User IP', 'royal-addons-for-elementor' ) . '<br>
						<code>[submission:date]</code> - ' . __( 'Date', 'royal-addons-for-elementor' ) . '<br>
						<code>[submission:time]</code> - ' . __( 'Time', 'royal-addons-for-elementor' ) . '
					</div>
				</details>',
				'content_classes' => 'royal-token-info',
			]
		);

		$this->add_control(
			'email_attach_files',
			[
				'label' => __( 'Attach Uploaded Files', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	private function register_redirect_section() {
		$this->start_controls_section(
			'section_redirect',
			[
				'label' => __( 'Redirect', 'royal-addons-for-elementor' ),
				'condition' => [
					'submit_actions' => 'redirect',
				],
			]
		);

		$this->add_control(
			'redirect_to',
			[
				'label' => __( 'Redirect To', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'https://your-link.com', 'royal-addons-for-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();
	}

	private function register_webhook_section() {
		$this->start_controls_section(
			'section_webhook',
			[
				'label' => __( 'Webhook', 'royal-addons-for-elementor' ),
				'condition' => [
					'submit_actions' => 'webhook',
				],
			]
		);

		$this->add_control(
			'webhook_url',
			[
				'label' => __( 'Webhook URL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'https://your-webhook-url.com', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter the URL to send form data via POST request.', 'royal-addons-for-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();
	}

	private function register_slack_section() {
		$this->start_controls_section(
			'section_slack',
			[
				'label' => __( 'Slack', 'royal-addons-for-elementor' ),
				'condition' => [
					'submit_actions' => 'slack',
				],
			]
		);

		$this->add_control(
			'slack_webhook_url',
			[
				'label' => __( 'Webhook URL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'https://hooks.slack.com/services/...', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter your Slack Incoming Webhook URL.', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	private function register_discord_section() {
		$this->start_controls_section(
			'section_discord',
			[
				'label' => __( 'Discord', 'royal-addons-for-elementor' ),
				'condition' => [
					'submit_actions' => 'discord',
				],
			]
		);

		$this->add_control(
			'discord_webhook_url',
			[
				'label' => __( 'Webhook URL', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'https://discord.com/api/webhooks/...', 'royal-addons-for-elementor' ),
				'description' => __( 'Enter your Discord Webhook URL.', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	private function register_mailchimp_section() {
		$this->start_controls_section(
			'section_mailchimp',
			[
				'label' => __( 'Mailchimp', 'royal-addons-for-elementor' ),
				'condition' => [
					'submit_actions' => 'mailchimp',
				],
			]
		);

		$this->add_control(
			'mailchimp_list',
			[
				'label' => __( 'Audience ID', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Enter your Mailchimp Audience/List ID.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'mailchimp_email_field',
			[
				'label' => __( 'Email Field ID', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'email',
				'description' => __( 'Enter the ID of the email field.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'mailchimp_first_name_field',
			[
				'label' => __( 'First Name Field ID', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Optional. Field ID for first name.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'mailchimp_last_name_field',
			[
				'label' => __( 'Last Name Field ID', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Optional. Field ID for last name.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'mailchimp_double_optin',
			[
				'label' => __( 'Double Opt-In', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'description' => __( 'Require email confirmation before subscribing.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'mailchimp_tags',
			[
				'label' => __( 'Tags', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Comma-separated tags to apply to subscriber.', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();
	}

	private function register_popup_section() {
		$this->start_controls_section(
			'section_popup',
			[
				'label' => __( 'Popup', 'royal-addons-for-elementor' ),
				'condition' => [
					'submit_actions' => 'popup',
				],
			]
		);

		$this->add_control(
			'popup_action',
			[
				'label' => __( 'Action', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'close' => __( 'Close Popup', 'royal-addons-for-elementor' ),
					'open' => __( 'Open Popup', 'royal-addons-for-elementor' ),
					'close_and_open' => __( 'Close & Open Another', 'royal-addons-for-elementor' ),
				],
				'default' => 'close',
			]
		);

		$this->add_control(
			'popup_to_open',
			[
				'label' => __( 'Popup ID', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'description' => __( 'Enter the Popup template ID to open.', 'royal-addons-for-elementor' ),
				'condition' => [
					'popup_action!' => 'close',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_form_style_section() {
		$this->start_controls_section(
			'section_form_style',
			[
				'label' => __( 'Form', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'column_gap',
			[
				'label' => __( 'Columns Gap', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 'size' => 10 ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-form-item' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
					'{{WRAPPER}} .royal-form-fields-wrapper' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
				],
			]
		);

		$this->add_control(
			'row_gap',
			[
				'label' => __( 'Rows Gap', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 'size' => 10 ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-form-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
	}

	private function register_field_style_section() {
		$this->start_controls_section(
			'section_field_style',
			[
				'label' => __( 'Field', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'selector' => '{{WRAPPER}} .royal-form-field',
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-field' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label' => __( 'Placeholder Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-field::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_background_color',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-field' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'field_border',
				'selector' => '{{WRAPPER}} .royal-form-field',
			]
		);

		$this->add_control(
			'field_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royal-form-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royal-form-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_focus_heading',
			[
				'label' => __( 'Focus State', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_focus_border_color',
			[
				'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-field:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'field_focus_box_shadow',
				'selector' => '{{WRAPPER}} .royal-form-field:focus',
			]
		);

		$this->end_controls_section();
	}

	private function register_label_style_section() {
		$this->start_controls_section(
			'section_label_style',
			[
				'label' => __( 'Label', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_labels' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .royal-form-label',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_spacing',
			[
				'label' => __( 'Spacing', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-form-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'required_mark_color',
			[
				'label' => __( 'Required Mark Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff0000',
				'selectors' => [
					'{{WRAPPER}} .royal-form-required' => 'color: {{VALUE}};',
				],
				'condition' => [
					'mark_required' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	private function register_button_style_section() {
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .royal-form-submit',
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_normal',
			[
				'label' => __( 'Normal', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'selector' => '{{WRAPPER}} .royal-form-submit',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover',
			[
				'label' => __( 'Hover', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'selector' => '{{WRAPPER}} .royal-form-submit:hover',
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-form-submit:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .royal-form-submit',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royal-form-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .royal-form-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .royal-form-submit',
			]
		);

		$this->end_controls_section();
	}

	private function get_field_types_options() {
		$module = Module::instance();
		if ( $module && $module->fields_registrar ) {
			return $module->fields_registrar->get_field_types_options();
		}
		
		// Fallback
		return [
			'text' => __( 'Text', 'royal-addons-for-elementor' ),
			'email' => __( 'Email', 'royal-addons-for-elementor' ),
			'textarea' => __( 'Textarea', 'royal-addons-for-elementor' ),
		];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id = $this->get_id();
		$module = Module::instance();

		$this->add_render_attribute( 'form', [
			'class' => 'royal-form',
			'method' => 'post',
			'data-form-id' => $id,
		] );

		// Check if form has file uploads
		foreach ( $settings['form_fields'] as $field ) {
			if ( 'file' === $field['field_type'] ) {
				$this->add_render_attribute( 'form', 'enctype', 'multipart/form-data' );
				break;
			}
		}

		?>
		<form <?php echo $this->get_render_attribute_string( 'form' ); ?>>
			<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>"/>
			<input type="hidden" name="form_id" value="<?php echo $id; ?>"/>
			<input type="hidden" name="page_url" value="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>"/>
			
			<div class="royal-form-fields-wrapper">
				<?php
				$has_steps = false;
				$step_count = 0;

				// Check if form has steps
				foreach ( $settings['form_fields'] as $field ) {
					if ( 'step' === $field['field_type'] ) {
						$has_steps = true;
						break;
					}
				}

				// Render progress bar for multi-step forms
				if ( $has_steps ) {
					echo '<div class="royal-form-progress-wrapper">';
					echo '<div class="royal-form-progress"><div class="royal-form-progress-bar"></div></div>';
					echo '</div>';
				}

				foreach ( $settings['form_fields'] as $item_index => $item ) {
					$field_type = $item['field_type'];
					$field_handler = $module && $module->fields_registrar ? $module->fields_registrar->get( $field_type ) : null;

					if ( $field_handler ) {
						$field_handler->render( $item, $item_index, $this );
					} else {
						// Fallback for basic field rendering
						$this->render_fallback_field( $item );
					}
				}

				// Close last step if multi-step
				if ( $has_steps ) {
					echo '</div>'; // Close last step
				}
				?>
				
				<div class="royal-form-item royal-form-submit-wrapper">
					<button type="submit" class="royal-form-submit elementor-button elementor-size-<?php echo esc_attr( $settings['button_size'] ); ?>">
						<span class="royal-form-submit-text"><?php echo esc_html( $settings['button_text'] ); ?></span>
						<span class="royal-form-submit-loading" style="display: none;">
							<i class="eicon-loading eicon-animation-spin"></i>
						</span>
					</button>
				</div>
			</div>
			
			<div class="royal-form-message royal-form-message-success" style="display: none;">
				<?php echo esc_html( $settings['success_message'] ); ?>
			</div>
			<div class="royal-form-message royal-form-message-error" style="display: none;">
				<?php echo esc_html( $settings['error_message'] ); ?>
			</div>
		</form>
		<?php
	}

	private function render_fallback_field( $item ) {
		$settings = $this->get_settings_for_display();
		$show_labels = isset( $settings['show_labels'] ) ? $settings['show_labels'] : 'yes';
		$show_placeholder = isset( $settings['show_placeholder'] ) ? $settings['show_placeholder'] : 'yes';
		$mark_required = isset( $settings['mark_required'] ) ? $settings['mark_required'] : 'yes';
		
		$width = isset( $item['input_size'] ) ? $item['input_size'] : '100';
		$width_attr = 'width: ' . esc_attr( $width ) . '%;';
		$placeholder = ( 'yes' === $show_placeholder && ! empty( $item['placeholder'] ) ) ? $item['placeholder'] : '';
		$required_attr = ! empty( $item['required'] ) ? 'required' : '';

		echo '<div class="royal-form-item" style="' . $width_attr . '">';
		echo '<div class="royal-form-field-wrapper">';
		
		if ( 'yes' === $show_labels && ! empty( $item['field_label'] ) ) {
			$required_mark = '';
			if ( ! empty( $item['required'] ) && 'yes' === $mark_required ) {
				$required_mark = '<span class="royal-form-required">*</span>';
			}
			echo '<label class="royal-form-label">' . esc_html( $item['field_label'] ) . $required_mark . '</label>';
		}
		
		if ( 'textarea' === $item['field_type'] ) {
			echo '<textarea class="royal-form-field" name="form_fields[' . esc_attr( $item['custom_id'] ) . ']" placeholder="' . esc_attr( $placeholder ) . '" ' . $required_attr . '></textarea>';
		} else {
			echo '<input type="' . esc_attr( $item['field_type'] ) . '" class="royal-form-field" name="form_fields[' . esc_attr( $item['custom_id'] ) . ']" placeholder="' . esc_attr( $placeholder ) . '" ' . $required_attr . '>';
		}
		
		echo '</div>';
		echo '</div>';
	}
}
