<?php
namespace RoyalAddons\Modules\Forms\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Form Presets - Pre-defined form templates
 */
class Form_Presets {

	/**
	 * Get all available presets
	 */
	public static function get_presets() {
		return [
			'contact' => self::get_contact_preset(),
			'contact_with_file' => self::get_contact_with_file_preset(),
			'booking' => self::get_booking_preset(),
			'quote' => self::get_quote_preset(),
			'newsletter' => self::get_newsletter_preset(),
			'feedback' => self::get_feedback_preset(),
			'job_application' => self::get_job_application_preset(),
			'event_registration' => self::get_event_registration_preset(),
		];
	}

	/**
	 * Get a specific preset
	 */
	public static function get_preset( $preset_id ) {
		$presets = self::get_presets();
		return isset( $presets[ $preset_id ] ) ? $presets[ $preset_id ] : [];
	}

	/**
	 * Contact Form - Basic 4 fields
	 */
	private static function get_contact_preset() {
		return [
			'name' => __( 'Contact Form', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Name', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'subject',
					'field_type' => 'text',
					'field_label' => __( 'Subject', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Subject', 'royal-addons-for-elementor' ),
					'input_size' => '100',
				],
				[
					'custom_id' => 'message',
					'field_type' => 'textarea',
					'field_label' => __( 'Message', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Message', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'required' => 'yes',
				],
			],
		];
	}

	/**
	 * Contact Form with File Attachment
	 */
	private static function get_contact_with_file_preset() {
		return [
			'name' => __( 'Contact Form + Attachment', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Name', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'phone',
					'field_type' => 'tel',
					'field_label' => __( 'Phone', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Phone Number', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'subject',
					'field_type' => 'text',
					'field_label' => __( 'Subject', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Subject', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'message',
					'field_type' => 'textarea',
					'field_label' => __( 'Message', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Message', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'required' => 'yes',
				],
				[
					'custom_id' => 'attachment',
					'field_type' => 'file',
					'field_label' => __( 'Attachment', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'file_types' => 'pdf,doc,docx,jpg,png',
					'max_file_size' => '5',
				],
			],
		];
	}

	/**
	 * Booking / Appointment Form
	 */
	private static function get_booking_preset() {
		return [
			'name' => __( 'Booking / Appointment', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Full Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Full Name', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'phone',
					'field_type' => 'tel',
					'field_label' => __( 'Phone Number', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Phone', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'service',
					'field_type' => 'select',
					'field_label' => __( 'Service', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'field_options' => "service1|Service 1\nservice2|Service 2\nservice3|Service 3",
					'required' => 'yes',
				],
				[
					'custom_id' => 'date',
					'field_type' => 'date',
					'field_label' => __( 'Preferred Date', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'time',
					'field_type' => 'time',
					'field_label' => __( 'Preferred Time', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'notes',
					'field_type' => 'textarea',
					'field_label' => __( 'Additional Notes', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Any special requests or notes...', 'royal-addons-for-elementor' ),
					'input_size' => '100',
				],
			],
		];
	}

	/**
	 * Quote / Estimate Request Form
	 */
	private static function get_quote_preset() {
		return [
			'name' => __( 'Quote / Estimate Request', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Full Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Name', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'company',
					'field_type' => 'text',
					'field_label' => __( 'Company Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Company', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'phone',
					'field_type' => 'tel',
					'field_label' => __( 'Phone', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Phone', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'service_type',
					'field_type' => 'select',
					'field_label' => __( 'Service Type', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'field_options' => "web_design|Web Design\nweb_development|Web Development\nmobile_app|Mobile App\nseo|SEO Services\nother|Other",
					'required' => 'yes',
				],
				[
					'custom_id' => 'budget',
					'field_type' => 'select',
					'field_label' => __( 'Budget Range', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'field_options' => "under_1000|Under $1,000\n1000_5000|$1,000 - $5,000\n5000_10000|$5,000 - $10,000\n10000_plus|$10,000+",
				],
				[
					'custom_id' => 'project_details',
					'field_type' => 'textarea',
					'field_label' => __( 'Project Details', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Describe your project requirements...', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'required' => 'yes',
				],
				[
					'custom_id' => 'attachment',
					'field_type' => 'file',
					'field_label' => __( 'Attach Files (Optional)', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'file_types' => 'pdf,doc,docx,jpg,png,zip',
					'max_file_size' => '10',
				],
			],
		];
	}

	/**
	 * Newsletter Signup Form
	 */
	private static function get_newsletter_preset() {
		return [
			'name' => __( 'Newsletter Signup', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email Address', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Enter your email', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'required' => 'yes',
				],
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Name (Optional)', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Name', 'royal-addons-for-elementor' ),
					'input_size' => '100',
				],
				[
					'custom_id' => 'acceptance',
					'field_type' => 'acceptance',
					'field_label' => __( 'I agree to receive newsletters and promotional emails.', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'required' => 'yes',
				],
			],
		];
	}

	/**
	 * Feedback / Survey Form
	 */
	private static function get_feedback_preset() {
		return [
			'name' => __( 'Feedback / Survey', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Name', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'rating',
					'field_type' => 'radio',
					'field_label' => __( 'How would you rate our service?', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'field_options' => "5|⭐⭐⭐⭐⭐ Excellent\n4|⭐⭐⭐⭐ Very Good\n3|⭐⭐⭐ Good\n2|⭐⭐ Fair\n1|⭐ Poor",
					'required' => 'yes',
				],
				[
					'custom_id' => 'recommend',
					'field_type' => 'radio',
					'field_label' => __( 'Would you recommend us to others?', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'field_options' => "yes|Yes, definitely\nmaybe|Maybe\nno|No",
					'required' => 'yes',
				],
				[
					'custom_id' => 'improvements',
					'field_type' => 'checkbox',
					'field_label' => __( 'What areas can we improve?', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'field_options' => "customer_service|Customer Service\nproduct_quality|Product Quality\npricing|Pricing\ndelivery|Delivery Speed\nwebsite|Website Experience",
				],
				[
					'custom_id' => 'feedback',
					'field_type' => 'textarea',
					'field_label' => __( 'Additional Comments', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Share your thoughts with us...', 'royal-addons-for-elementor' ),
					'input_size' => '100',
				],
			],
		];
	}

	/**
	 * Job Application Form
	 */
	private static function get_job_application_preset() {
		return [
			'name' => __( 'Job Application', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Full Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Full Name', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'phone',
					'field_type' => 'tel',
					'field_label' => __( 'Phone Number', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Phone', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'position',
					'field_type' => 'select',
					'field_label' => __( 'Position Applied For', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'field_options' => "developer|Developer\ndesigner|Designer\nmarketing|Marketing\nsales|Sales\nother|Other",
					'required' => 'yes',
				],
				[
					'custom_id' => 'experience',
					'field_type' => 'select',
					'field_label' => __( 'Years of Experience', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'field_options' => "0_1|0-1 Years\n1_3|1-3 Years\n3_5|3-5 Years\n5_10|5-10 Years\n10_plus|10+ Years",
					'required' => 'yes',
				],
				[
					'custom_id' => 'portfolio_url',
					'field_type' => 'url',
					'field_label' => __( 'Portfolio / LinkedIn URL', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'https://', 'royal-addons-for-elementor' ),
					'input_size' => '100',
				],
				[
					'custom_id' => 'cover_letter',
					'field_type' => 'textarea',
					'field_label' => __( 'Cover Letter', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Tell us about yourself and why you want to join our team...', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'required' => 'yes',
				],
				[
					'custom_id' => 'resume',
					'field_type' => 'file',
					'field_label' => __( 'Resume / CV', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'file_types' => 'pdf,doc,docx',
					'max_file_size' => '5',
					'required' => 'yes',
				],
			],
		];
	}

	/**
	 * Event Registration Form
	 */
	private static function get_event_registration_preset() {
		return [
			'name' => __( 'Event Registration', 'royal-addons-for-elementor' ),
			'fields' => [
				[
					'custom_id' => 'name',
					'field_type' => 'text',
					'field_label' => __( 'Full Name', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Full Name', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'email',
					'field_type' => 'email',
					'field_label' => __( 'Email', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Email', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'required' => 'yes',
				],
				[
					'custom_id' => 'phone',
					'field_type' => 'tel',
					'field_label' => __( 'Phone', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Phone', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'company',
					'field_type' => 'text',
					'field_label' => __( 'Company / Organization', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Your Company', 'royal-addons-for-elementor' ),
					'input_size' => '50',
				],
				[
					'custom_id' => 'ticket_type',
					'field_type' => 'select',
					'field_label' => __( 'Ticket Type', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'field_options' => "standard|Standard Ticket\nvip|VIP Ticket\nstudent|Student Ticket",
					'required' => 'yes',
				],
				[
					'custom_id' => 'attendees',
					'field_type' => 'number',
					'field_label' => __( 'Number of Attendees', 'royal-addons-for-elementor' ),
					'input_size' => '50',
					'min_value' => 1,
					'max_value' => 10,
					'required' => 'yes',
				],
				[
					'custom_id' => 'dietary',
					'field_type' => 'checkbox',
					'field_label' => __( 'Dietary Requirements', 'royal-addons-for-elementor' ),
					'input_size' => '100',
					'field_options' => "vegetarian|Vegetarian\nvegan|Vegan\ngluten_free|Gluten-Free\nhalal|Halal\nkosher|Kosher\nnone|No Special Requirements",
				],
				[
					'custom_id' => 'special_requirements',
					'field_type' => 'textarea',
					'field_label' => __( 'Special Requirements', 'royal-addons-for-elementor' ),
					'placeholder' => __( 'Any special requirements or accessibility needs...', 'royal-addons-for-elementor' ),
					'input_size' => '100',
				],
			],
		];
	}
}
