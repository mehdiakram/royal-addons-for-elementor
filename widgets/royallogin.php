<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class RoyalLogin extends Widget_Base {

	public function get_name() {
		return 'royal-login';
	}

	public function get_title() {
		return __( 'Royal Login', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'eicon-lock-user rtbranding'; }

	public function get_categories() {
		return array( 'royaltech_3rdparty' );
	}

	public function get_script_depends() {
		return [ 'royallogin', 'sweetalert2' ];
	}

	public function get_style_depends() {
		return [ 'royallogin', 'sweetalert2' ];
	}

	// =========================================================
	// Helper: Get all WordPress user roles
	// =========================================================
	private function get_role_options() {
		$roles   = wp_roles()->get_names();
		$options = [ 'all' => __( 'All (No Restriction)', 'royal-addons-for-elementor' ) ];
		foreach ( $roles as $key => $label ) {
			$options[ $key ] = translate_user_role( $label );
		}
		return $options;
	}

	// =========================================================
	// Controls
	// =========================================================
	protected function register_controls() {

		/* ─────────────────────────────────────────────────────
		   CONTENT TAB — Form Fields
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_fields_content',
			[
				'label' => __( 'Form Fields', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'     => __( 'Show Labels', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'label_on'  => __( 'Show', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'label_username',
			[
				'label'     => __( 'Username Label', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Username or Email Address', 'royal-addons-for-elementor' ),
				'condition' => [ 'show_labels' => 'yes' ],
			]
		);

		$this->add_control(
			'label_password',
			[
				'label'     => __( 'Password Label', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Password', 'royal-addons-for-elementor' ),
				'condition' => [ 'show_labels' => 'yes' ],
			]
		);

		$this->add_control(
			'placeholder_username',
			[
				'label'   => __( 'Username Placeholder', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Enter your username or email', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'placeholder_password',
			[
				'label'   => __( 'Password Placeholder', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Enter your password', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => __( 'Button Text', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Log In', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'show_remember_me',
			[
				'label'     => __( 'Remember Me', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'label_on'  => __( 'Show', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   CONTENT TAB — Additional Options
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_content_additional_options',
			[
				'label' => __( 'Additional Options', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'redirect_after_login',
			[
				'label'     => __( 'Redirect After Login', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_off' => __( 'Off', 'royal-addons-for-elementor' ),
				'label_on'  => __( 'On', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'redirect_url',
			[
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Redirect URL', 'royal-addons-for-elementor' ),
				'condition' => [ 'redirect_after_login' => 'yes' ],
			]
		);

		$this->add_control(
			'show_lost_password',
			[
				'label'     => __( 'Lost your password?', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'label_off' => __( 'Hide', 'royal-addons-for-elementor' ),
				'label_on'  => __( 'Show', 'royal-addons-for-elementor' ),
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   CONTENT TAB — Social Login
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_social_login',
			[
				'label' => __( 'Social Login', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'enable_social_login',
			[
				'label'     => __( 'Enable Social Login', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'label_off' => __( 'No', 'royal-addons-for-elementor' ),
				'label_on'  => __( 'Yes', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'social_login_text',
			[
				'label'     => __( 'Separator Text', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Or continue with', 'royal-addons-for-elementor' ),
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);
		
		$this->add_control(
			'social_buttons_layout',
			[
				'label'   => __( 'Layout', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => [
					'inline' => __( 'Inline (Icons only)', 'royal-addons-for-elementor' ),
					'block'  => __( 'Block (Icon + Text)', 'royal-addons-for-elementor' ),
				],
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);

		$this->add_control(
			'show_google_login',
			[
				'label'     => __( 'Google', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);

		$this->add_control(
			'show_facebook_login',
			[
				'label'     => __( 'Facebook', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);

		$this->add_control(
			'show_twitter_login',
			[
				'label'     => __( 'Twitter (X)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);

		$this->add_control(
			'show_linkedin_login',
			[
				'label'     => __( 'LinkedIn', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);
		
		$this->add_control(
			'show_instagram_login',
			[
				'label'     => __( 'Instagram', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   CONTENT TAB — Role Restriction
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_role_restriction',
			[
				'label' => __( 'Role Restriction', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'allowed_roles',
			[
				'label'       => __( 'Allowed User Roles', 'royal-addons-for-elementor' ),
				'description' => __( 'Select which roles can log in. Choose "All" to allow everyone.', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->get_role_options(),
				'default'     => [ 'all' ],
				'multiple'    => true,
			]
		);

		$this->add_control(
			'role_error_message',
			[
				'label'       => __( 'Role Restriction Error Message', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( 'You are not eligible to log in with this user role.', 'royal-addons-for-elementor' ),
				'rows'        => 3,
				'description' => __( 'Shown when a user with a restricted role tries to log in.', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'error_display_mode',
			[
				'label'   => __( 'Error Display Mode', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'normal' => __( 'Normal (Inline)', 'royal-addons-for-elementor' ),
					'popup'  => __( 'Popup (SweetAlert)', 'royal-addons-for-elementor' ),
				],
				'default' => 'normal',
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   CONTENT TAB — Logged In State
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_logged_in_state',
			[
				'label' => __( 'Logged In State', 'royal-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'logged_in_action',
			[
				'label'   => __( 'When Logged In', 'royal-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'message',
				'options' => [
					'message' => __( 'Show Message & Buttons', 'royal-addons-for-elementor' ),
					'form'    => __( 'Show Login Form', 'royal-addons-for-elementor' ),
					'hide'    => __( 'Hide Widget completely', 'royal-addons-for-elementor' ),
				],
			]
		);
		
		$this->add_control(
			'logged_in_message',
			[
				'label'       => __( 'Message', 'royal-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( 'You are already logged in as {username}.', 'royal-addons-for-elementor' ),
				'description' => __( 'Use {username} to display the current user\'s name.', 'royal-addons-for-elementor' ),
				'condition'   => [ 'logged_in_action' => 'message' ],
			]
		);

		$this->add_control(
			'show_avatar',
			[
				'label'     => __( 'Show User Avatar', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'logged_in_action' => 'message' ],
			]
		);
		
		$this->add_control(
			'show_dashboard_btn',
			[
				'label'     => __( 'Show Dashboard Button', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'logged_in_action' => 'message' ],
			]
		);
		
		$this->add_control(
			'dashboard_btn_text',
			[
				'label'     => __( 'Dashboard Button Text', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Dashboard', 'royal-addons-for-elementor' ),
				'condition' => [ 'logged_in_action' => 'message', 'show_dashboard_btn' => 'yes' ],
			]
		);
		
		$this->add_control(
			'dashboard_btn_url',
			[
				'label'     => __( 'Dashboard URL', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::URL,
				'default'   => [ 'url' => admin_url() ],
				'condition' => [ 'logged_in_action' => 'message', 'show_dashboard_btn' => 'yes' ],
			]
		);
		
		$this->add_control(
			'show_logout_btn',
			[
				'label'     => __( 'Show Logout Button', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 'logged_in_action' => 'message' ],
			]
		);
		
		$this->add_control(
			'logout_btn_text',
			[
				'label'     => __( 'Logout Button Text', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Logout', 'royal-addons-for-elementor' ),
				'condition' => [ 'logged_in_action' => 'message', 'show_logout_btn' => 'yes' ],
			]
		);

		$this->end_controls_section();

		// =============================================================
		// STYLE TAB
		// =============================================================

		/* ─────────────────────────────────────────────────────
		   STYLE — Form Container
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_container',
			[
				'label' => __( 'Form Container', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'form_background',
				'label'    => __( 'Background', 'royal-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-login-form-wrap',
			]
		);

		$this->add_responsive_control(
			'form_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-form-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-form-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'form_border',
				'selector' => '{{WRAPPER}} .royal-login-form-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_box_shadow',
				'selector' => '{{WRAPPER}} .royal-login-form-wrap',
			]
		);

		$this->add_control(
			'show_accent_bar',
			[
				'label'                => __( 'Top Accent Bar', 'royal-addons-for-elementor' ),
				'type'                 => Controls_Manager::SWITCHER,
				'default'              => 'yes',
				'label_off'            => __( 'Hide', 'royal-addons-for-elementor' ),
				'label_on'             => __( 'Show', 'royal-addons-for-elementor' ),
				'return_value'         => 'yes',
				'separator'            => 'before',
				'selectors'            => [
					'{{WRAPPER}} .royal-login-form-wrap::before' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'yes' => '',
					''    => 'display: none;',
				],
			]
		);

		$this->add_responsive_control(
			'accent_bar_height',
			[
				'label'      => __( 'Accent Bar Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 20 ] ],
				'default'    => [ 'size' => 4, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-form-wrap::before' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_accent_bar' => 'yes' ],
			]
		);

		$this->add_control(
			'form_accent_color',
			[
				'label'     => __( 'Accent Bar Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-form-wrap::before' => 'background: {{VALUE}};',
				],
				'condition' => [ 'show_accent_bar' => 'yes' ],
			]
		);

		$this->end_controls_section();


		/* ─────────────────────────────────────────────────────
		   STYLE — Labels
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_labels',
			[
				'label'     => __( 'Labels', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_labels' => 'yes' ],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-field-group label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .royal-login-field-group label',
			]
		);

		$this->add_responsive_control(
			'label_spacing',
			[
				'label'     => __( 'Spacing (bottom)', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'selectors' => [
					'{{WRAPPER}} .royal-login-field-group label' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   STYLE — Input Fields
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_inputs',
			[
				'label' => __( 'Input Fields', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'input_tabs' );

		$this->start_controls_tab(
			'input_tab_normal',
			[ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ]
		);

		$this->add_control(
			'input_bg_color',
			[
				'label'     => __( 'Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"], {{WRAPPER}} .royal-login-field-group input[type="password"], {{WRAPPER}} .royal-login-field-group input[type="email"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"], {{WRAPPER}} .royal-login-field-group input[type="password"], {{WRAPPER}} .royal-login-field-group input[type="email"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'input_border',
				'selector' => '{{WRAPPER}} .royal-login-field-group input[type="text"], {{WRAPPER}} .royal-login-field-group input[type="password"], {{WRAPPER}} .royal-login-field-group input[type="email"]',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'input_tab_focus',
			[ 'label' => __( 'Focus', 'royal-addons-for-elementor' ) ]
		);

		$this->add_control(
			'input_focus_bg_color',
			[
				'label'     => __( 'Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"]:focus, {{WRAPPER}} .royal-login-field-group input[type="password"]:focus, {{WRAPPER}} .royal-login-field-group input[type="email"]:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_focus_border_color',
			[
				'label'     => __( 'Border Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"]:focus, {{WRAPPER}} .royal-login-field-group input[type="password"]:focus, {{WRAPPER}} .royal-login-field-group input[type="email"]:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_focus_shadow_color',
			[
				'label'     => __( 'Focus Glow Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"]:focus, {{WRAPPER}} .royal-login-field-group input[type="password"]:focus, {{WRAPPER}} .royal-login-field-group input[type="email"]:focus' => 'box-shadow: 0 0 0 4px {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'input_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"], {{WRAPPER}} .royal-login-field-group input[type="password"], {{WRAPPER}} .royal-login-field-group input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'input_height',
			[
				'label'      => __( 'Height', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 30, 'max' => 100 ] ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"], {{WRAPPER}} .royal-login-field-group input[type="password"], {{WRAPPER}} .royal-login-field-group input[type="email"]' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-field-group input[type="text"], {{WRAPPER}} .royal-login-field-group input[type="password"], {{WRAPPER}} .royal-login-field-group input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} .royal-login-field-group input[type="text"], {{WRAPPER}} .royal-login-field-group input[type="password"], {{WRAPPER}} .royal-login-field-group input[type="email"]',
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   STYLE — Submit Button
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Submit Button', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab(
			'button_tab_normal',
			[ 'label' => __( 'Normal', 'royal-addons-for-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_background',
				'label'    => __( 'Background', 'royal-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-login-submit-btn',
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-submit-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .royal-login-submit-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_tab_hover',
			[ 'label' => __( 'Hover', 'royal-addons-for-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_hover_background',
				'label'    => __( 'Background', 'royal-addons-for-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .royal-login-submit-btn:hover',
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-submit-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .royal-login-submit-btn:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-submit-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-submit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .royal-login-submit-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .royal-login-submit-btn',
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   STYLE — Social Login Buttons
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_social_buttons',
			[
				'label'     => __( 'Social Login Buttons', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'enable_social_login' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'social_buttons_gap',
			[
				'label'      => __( 'Gap', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'selectors'  => [
					'{{WRAPPER}} .royal-social-login-buttons' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_button_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-social-login-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-social-login-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_size',
			[
				'label'      => __( 'Icon Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
				'selectors'  => [
					'{{WRAPPER}} .royal-social-login-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'social_button_typography',
				'selector'  => '{{WRAPPER}} .royal-social-login-btn span',
				'condition' => [ 'social_buttons_layout' => 'block' ],
			]
		);
		
		$this->add_control(
			'social_button_bg_color',
			[
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-social-login-btn' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'social_button_text_color',
			[
				'label'     => __( 'Text/Icon Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-social-login-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .royal-social-login-btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'social_button_border',
				'selector' => '{{WRAPPER}} .royal-social-login-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'social_button_box_shadow',
				'selector' => '{{WRAPPER}} .royal-social-login-btn',
			]
		);
		
		// Separator Style
		$this->add_control(
			'social_separator_heading',
			[
				'label' => __( 'Separator', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'social_separator_color',
			[
				'label'     => __( 'Separator Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-social-login-separator' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'social_separator_line_color',
			[
				'label'     => __( 'Separator Line Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-social-login-separator::before, {{WRAPPER}} .royal-social-login-separator::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   STYLE — Error Message
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_error',
			[
				'label' => __( 'Error Message', 'royal-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'error_text_color',
			[
				'label'     => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-error' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'error_bg_color',
			[
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-error' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'error_border_color',
			[
				'label'     => __( 'Border / Accent Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-error' => 'border-color: {{VALUE}}; border-left-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'error_typography',
				'selector' => '{{WRAPPER}} .royal-login-error',
			]
		);

		$this->add_control(
			'error_border_radius',
			[
				'label'      => __( 'Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-error' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   STYLE — Logged In State
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_logged_in_state',
			[
				'label'     => __( 'Logged In State', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'logged_in_padding',
			[
				'label'      => __( 'Padding', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-login-logged-in' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'logged_in_bg_color',
			[
				'label'     => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-logged-in' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'logged_in_text_color',
			[
				'label'     => __( 'Message Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-logged-in .royal-logged-in-msg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'logged_in_typography',
				'selector' => '{{WRAPPER}} .royal-login-logged-in .royal-logged-in-msg',
			]
		);
		
		$this->add_responsive_control(
			'logged_in_avatar_size',
			[
				'label'      => __( 'Avatar Size', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 20, 'max' => 150 ] ],
				'selectors'  => [
					'{{WRAPPER}} .royal-logged-in-avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'logged_in_avatar_radius',
			[
				'label'      => __( 'Avatar Border Radius', 'royal-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .royal-logged-in-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'logged_in_heading_buttons',
			[
				'label' => __( 'Buttons', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'logged_in_btn_bg',
			[
				'label'     => __( 'Button Background', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-logged-in-actions a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'logged_in_btn_color',
			[
				'label'     => __( 'Button Text Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-logged-in-actions a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'logged_in_btn_typography',
				'selector' => '{{WRAPPER}} .royal-logged-in-actions a',
			]
		);

		$this->end_controls_section();

		/* ─────────────────────────────────────────────────────
		   STYLE — Lost Password Link
		───────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_lost_password',
			[
				'label'     => __( 'Lost Password Link', 'royal-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_lost_password' => 'yes' ],
			]
		);

		$this->add_control(
			'lost_password_color',
			[
				'label'     => __( 'Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-lost-password' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'lost_password_hover_color',
			[
				'label'     => __( 'Hover Color', 'royal-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-login-lost-password:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'lost_password_typography',
				'selector' => '{{WRAPPER}} .royal-login-lost-password',
			]
		);

		$this->end_controls_section();
	}

	// =========================================================
	// Render
	// =========================================================
	protected function render() {
		$settings = $this->get_settings_for_display();

		// ---- Logged-in state ----
		if ( is_user_logged_in() && ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$action = ! empty( $settings['logged_in_action'] ) ? $settings['logged_in_action'] : 'message';
			
			if ( 'hide' === $action ) {
				return;
			}
			
			if ( 'message' === $action ) {
				$current_user = wp_get_current_user();
				$username     = $current_user->display_name;
				
				$message = ! empty( $settings['logged_in_message'] ) ? $settings['logged_in_message'] : __( 'You are already logged in as {username}.', 'royal-addons-for-elementor' );
				$message = str_replace( '{username}', '<strong>' . esc_html( $username ) . '</strong>', $message );
				
				?>
				<div class="royal-login-logged-in">
					<?php if ( 'yes' === $settings['show_avatar'] ) : ?>
						<div class="royal-logged-in-avatar">
							<?php echo get_avatar( $current_user->ID, 96 ); ?>
						</div>
					<?php endif; ?>
					
					<div class="royal-logged-in-msg">
						<?php echo wp_kses_post( $message ); ?>
					</div>
					
					<?php if ( 'yes' === $settings['show_dashboard_btn'] || 'yes' === $settings['show_logout_btn'] ) : ?>
						<div class="royal-logged-in-actions">
							<?php if ( 'yes' === $settings['show_dashboard_btn'] ) : ?>
								<?php $dash_url = ! empty( $settings['dashboard_btn_url']['url'] ) ? $settings['dashboard_btn_url']['url'] : admin_url(); ?>
								<a href="<?php echo esc_url( $dash_url ); ?>" class="royal-btn-dashboard">
									<?php echo esc_html( $settings['dashboard_btn_text'] ); ?>
								</a>
							<?php endif; ?>
							
							<?php if ( 'yes' === $settings['show_logout_btn'] ) : ?>
								<a href="<?php echo esc_url( wp_logout_url( get_permalink() ) ); ?>" class="royal-btn-logout">
									<?php echo esc_html( $settings['logout_btn_text'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
				<?php
				return;
			}
			// If 'form', just continue and render the form below.
		}

		// ---- Build settings for JS ----
		$allowed_roles  = ! empty( $settings['allowed_roles'] ) ? (array) $settings['allowed_roles'] : [ 'all' ];
		$error_msg      = ! empty( $settings['role_error_message'] ) ? $settings['role_error_message'] : __( 'You are not eligible to log in with this user role.', 'royal-addons-for-elementor' );
		$error_mode     = ! empty( $settings['error_display_mode'] ) ? $settings['error_display_mode'] : 'normal';

		$redirect_url = ( 'yes' === $settings['redirect_after_login'] && ! empty( $settings['redirect_url'] ) )
			? $settings['redirect_url']
			: get_permalink();

		$nonce = wp_create_nonce( 'royal_login_nonce' );

		// ---- Roles as JSON for AJAX ----
		$roles_json = esc_attr( wp_json_encode( $allowed_roles ) );

		?>
		<div class="royal-login-widget">
			<div class="royal-login-form-wrap">
				<form class="royal-login-form"
					data-allowed-roles="<?php echo $roles_json; ?>"
					data-error-msg="<?php echo esc_attr( $error_msg ); ?>"
					data-error-mode="<?php echo esc_attr( $error_mode ); ?>"
					data-redirect="<?php echo esc_url( $redirect_url ); ?>"
					data-nonce="<?php echo esc_attr( $nonce ); ?>"
					novalidate>

					<!-- Username -->
					<div class="royal-login-field-group">
						<?php if ( 'yes' === $settings['show_labels'] && ! empty( $settings['label_username'] ) ) : ?>
							<label for="rl-user-<?php echo esc_attr( $this->get_id() ); ?>">
								<?php echo esc_html( $settings['label_username'] ); ?>
							</label>
						<?php endif; ?>
						<input
							type="text"
							aria-label="<?php echo esc_attr( $settings['label_username'] ?? 'Username' ); ?>"
							id="rl-user-<?php echo esc_attr( $this->get_id() ); ?>"
							name="rl_username"
							placeholder="<?php echo esc_attr( $settings['placeholder_username'] ?? '' ); ?>"
							autocomplete="username"
							required />
					</div>

					<!-- Password -->
					<div class="royal-login-field-group">
						<?php if ( 'yes' === $settings['show_labels'] && ! empty( $settings['label_password'] ) ) : ?>
							<label for="rl-pass-<?php echo esc_attr( $this->get_id() ); ?>">
								<?php echo esc_html( $settings['label_password'] ); ?>
							</label>
						<?php endif; ?>
						<input
							type="password"
							aria-label="<?php echo esc_attr( $settings['label_password'] ?? 'Password' ); ?>"
							id="rl-pass-<?php echo esc_attr( $this->get_id() ); ?>"
							name="rl_password"
							placeholder="<?php echo esc_attr( $settings['placeholder_password'] ?? '' ); ?>"
							autocomplete="current-password"
							required />
					</div>

					<!-- Remember Me -->
					<?php if ( 'yes' === $settings['show_remember_me'] ) : ?>
					<div class="royal-login-remember-row">
						<input type="checkbox" id="rl-remember-<?php echo esc_attr( $this->get_id() ); ?>" name="rl_remember" />
						<label for="rl-remember-<?php echo esc_attr( $this->get_id() ); ?>">
							<?php esc_html_e( 'Remember Me', 'royal-addons-for-elementor' ); ?>
						</label>
					</div>
					<?php endif; ?>

					<!-- Submit Button -->
					<button type="submit" class="royal-login-submit-btn" aria-label="Submit Login">
						<span class="royal-login-spinner"></span>
						<span class="royal-login-btn-text"><?php echo esc_html( $settings['button_text'] ); ?></span>
					</button>

					<!-- Inline Error Box -->
					<div class="royal-login-error" role="alert">
						<span class="royal-login-error-icon">&#9888;</span>
						<span class="royal-login-error-text"></span>
					</div>

				</form>

				<!-- Lost Password -->
				<?php if ( 'yes' === $settings['show_lost_password'] ) : ?>
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="royal-login-lost-password">
						<?php esc_html_e( 'Lost your password?', 'royal-addons-for-elementor' ); ?>
					</a>
				<?php endif; ?>

				<!-- Social Login -->
				<?php if ( 'yes' === $settings['enable_social_login'] ) : ?>
					<?php
					$return_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					$return_url = remove_query_arg( 'royal_auth_code', $return_url );
					$return_url = remove_query_arg( 'auth_code', $return_url );
					$return_url = remove_query_arg( 'royal_login_error', $return_url );

					// Generate Base URLs
					$social_base_url = 'https://auth.royaltechbd.com/social-login/';
					$query_args = [
						'software' => 'royaladdonsforelementor',
						'return_url' => urlencode( $return_url )
					];

					$google_url = add_query_arg( $query_args, $social_base_url . 'google' );
					$facebook_url = add_query_arg( $query_args, $social_base_url . 'facebook' );
					$twitter_url = add_query_arg( $query_args, $social_base_url . 'x' );
					$linkedin_url = add_query_arg( $query_args, $social_base_url . 'linkedin' );
					$instagram_url = add_query_arg( $query_args, $social_base_url . 'instagram' );
					?>

					<?php if ( isset( $_GET['royal_login_error'] ) && ! empty( $_GET['royal_login_error'] ) ) : ?>
						<div class="royal-login-error" style="display:block; margin-top:15px; margin-bottom:15px; background:#fee2e2; border:1px solid #fecaca; color:#ef4444; padding:10px; border-radius:5px;">
							<strong><?php esc_html_e( 'Error:', 'royal-addons-for-elementor' ); ?></strong> <?php echo esc_html( urldecode( $_GET['royal_login_error'] ) ); ?>
						</div>
					<?php endif; ?>

					<div class="royal-social-login-wrapper">
						<?php if ( ! empty( $settings['social_login_text'] ) ) : ?>
							<div class="royal-social-login-separator">
								<span><?php echo esc_html( $settings['social_login_text'] ); ?></span>
							</div>
						<?php endif; ?>
						
						<div class="royal-social-login-buttons" data-layout="<?php echo esc_attr( $settings['social_buttons_layout'] ); ?>">
							<?php if ( 'yes' === $settings['show_google_login'] ) : ?>
								<a href="<?php echo esc_url( $google_url ); ?>" class="royal-social-login-btn royal-social-google" aria-label="Login with Google">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512"><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
									<?php if ( 'block' === $settings['social_buttons_layout'] ) : ?><span><?php esc_html_e( 'Google', 'royal-addons-for-elementor' ); ?></span><?php endif; ?>
								</a>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_facebook_login'] ) : ?>
								<a href="<?php echo esc_url( $facebook_url ); ?>" class="royal-social-login-btn royal-social-facebook" aria-label="Login with Facebook">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
									<?php if ( 'block' === $settings['social_buttons_layout'] ) : ?><span><?php esc_html_e( 'Facebook', 'royal-addons-for-elementor' ); ?></span><?php endif; ?>
								</a>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_twitter_login'] ) : ?>
								<a href="<?php echo esc_url( $twitter_url ); ?>" class="royal-social-login-btn royal-social-twitter" aria-label="Login with Twitter">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
									<?php if ( 'block' === $settings['social_buttons_layout'] ) : ?><span><?php esc_html_e( 'Twitter (X)', 'royal-addons-for-elementor' ); ?></span><?php endif; ?>
								</a>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_linkedin_login'] ) : ?>
								<a href="<?php echo esc_url( $linkedin_url ); ?>" class="royal-social-login-btn royal-social-linkedin" aria-label="Login with LinkedIn">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>
									<?php if ( 'block' === $settings['social_buttons_layout'] ) : ?><span><?php esc_html_e( 'LinkedIn', 'royal-addons-for-elementor' ); ?></span><?php endif; ?>
								</a>
							<?php endif; ?>

							<?php if ( 'yes' === $settings['show_instagram_login'] ) : ?>
								<a href="<?php echo esc_url( $instagram_url ); ?>" class="royal-social-login-btn royal-social-instagram" aria-label="Login with Instagram">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
									<?php if ( 'block' === $settings['social_buttons_layout'] ) : ?><span><?php esc_html_e( 'Instagram', 'royal-addons-for-elementor' ); ?></span><?php endif; ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>

		<?php
		// Enqueue assets for this widget
		wp_enqueue_style( 'sweetalert2' );
		wp_enqueue_script( 'sweetalert2' );
		wp_enqueue_style( 'royallogin' );
		wp_enqueue_script( 'royallogin' );
		wp_localize_script( 'royallogin', 'royal_login_params', [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		] );
	}
}
