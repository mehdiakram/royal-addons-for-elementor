<?php
namespace RoyalAddons\Modules\Forms;

use Elementor\Core\Base\Module as BaseModule;
use RoyalAddons\Modules\Forms\Classes\Ajax_Handler;
use RoyalAddons\Modules\Forms\Classes\Field_Registrar;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Module extends BaseModule {

	public $actions_registrar;
	public $fields_registrar;

	protected static $_instance = null;

	public function get_name() {
		return 'royalforms';
	}

	public function __construct() {
		parent::__construct();

		// Load all required files
		$this->load_files();

		// Initialize registrars
		$this->actions_registrar = new \RoyalAddons\Modules\Forms\Classes\Action_Base();
		$this->fields_registrar = new Field_Registrar();

		// Register default actions
		$this->register_actions();
		
		// Initialize Ajax Handler
		new Ajax_Handler();

		// Register form presets AJAX
		add_action( 'wp_ajax_royal_form_get_preset', [ $this, 'ajax_get_preset' ] );
		
		// Enqueue editor script for presets
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
	}

	public function ajax_get_preset() {
		$preset_id = isset( $_POST['preset'] ) ? sanitize_text_field( $_POST['preset'] ) : '';
		
		if ( empty( $preset_id ) ) {
			wp_send_json_error( 'No preset specified' );
		}

		$preset = Classes\Form_Presets::get_preset( $preset_id );
		
		if ( empty( $preset ) ) {
			wp_send_json_error( 'Preset not found' );
		}

		wp_send_json_success( $preset );
	}

	public function enqueue_editor_scripts() {
		wp_enqueue_script( 'royal-elementor-editor', \ROYAL_ADDONS_DIR_URL . 'assets/js/royal-elementor-editor.js', [ 'jquery', 'elementor-editor' ], \ROYAL_ADDONS_VERSION, true );
		wp_add_inline_script( 'elementor-editor', $this->get_editor_preset_script() );
	}

	private function get_editor_preset_script() {
		$presets = Classes\Form_Presets::get_presets();
		$presets_json = wp_json_encode( array_map( function( $preset ) {
			return $preset['fields'] ?? [];
		}, $presets ) );
		
		return <<<'JS'
		(function($) {
			var royalFormPresets = 
JS
		. $presets_json . <<<'JS'
		;
			
			// Preset apply handler
			$(document).on('royal-form-preset-apply', function(e, presetId) {
				if (!royalFormPresets[presetId]) {
					return;
				}
				
				var fields = royalFormPresets[presetId];
				if (typeof elementor === 'undefined') return;
				var panel = elementor.getPanelView();
				if (!panel) return;
				var currentElement = panel.getCurrentPageView().getOption('editedElementView');
				
				if (currentElement) {
					currentElement.model.setSetting('form_fields', fields);
					currentElement.renderOnChange();
				}
			});

			function findElement(selector, retries = 5, delay = 100) {
				return new Promise((resolve, reject) => {
					function check() {
						const el = $(selector);
						if (el.length > 0) {
							resolve(el);
						} else if (retries > 0) {
							retries--;
							setTimeout(check, delay);
						} else {
							reject('Element not found: ' + selector);
						}
					}
					check();
				});
			}

			// Wait for Elementor to be ready before adding hooks
			$(window).on('elementor:init', function() {
				if (typeof elementor !== 'undefined' && elementor.hooks) {
					elementor.hooks.addAction('panel/open_editor/widget/royal-form', function(panel, model, view) {
						
						// Listen for Apply Email Template Button Click
						panel.$el.on('click', '.royal-apply-email-template-btn', function(e) {
							e.preventDefault();
							var preset = model.getSetting('email_template_preset');
							
							if (!preset) {
								if (typeof elementor !== 'undefined' && elementor.notifications) {
									elementor.notifications.showToast({
										message: 'Please select a template first',
										type: 'warning'
									});
								} else {
									alert('Please select a template first');
								}
								return;
							}

							var content = '';
							if (preset === 'table') {
								content = '<p>Hi Admin,</p><p>You have a new form submission from [form:name]:</p>[all-fields]<p>Thanks,<br>[site:name]</p>';
							} else if (preset === 'plain') {
								content = 'New Submission from [form:name]:\n\n[all-fields]\n\nSent from [site:name]';
							} else if (preset === 'default') {
								content = '[all-fields]'; 
							}

							// 1. Update the Model first (Source of Truth)
							model.setSetting('email_content', content);
							
							console.log('Royal Addons: Applying Preset (Button Click)', preset);

							// 2. Locate the Control View and Update Visuals
							var attemptUpdate = function(attempts) {
								if (attempts > 10) {
									console.log('Royal Addons: Could not find editor after 10 attempts');
									return;
								}

								// Find the control wrapper
								var $control = $('.elementor-control-email_content');
								var $textarea = $control.find('textarea[data-setting="email_content"]');
								
								if (!$textarea.length) {
									$textarea = $control.find('.wp-editor-area');
								}

								console.log('Royal Addons: Attempt ' + attempts + ' found textarea:', $textarea.length);

								if ($textarea.length) {
									var editorId = $textarea.attr('id');
									var updated = false;

									// Case A: TinyMCE (Visual Editor)
									if (editorId && typeof window.tinymce !== 'undefined' && window.tinymce.get(editorId)) {
										var editor = window.tinymce.get(editorId);
										if (!editor.isHidden()) {
											editor.setContent(content);
											editor.save(); 
											updated = true;
											console.log('Royal Addons: Updated via TinyMCE ID');
										}
									}

									// Case B: Textarea (Text Mode or No TinyMCE)
									if (!updated) {
										$textarea.val(content);
										$textarea.trigger('input'); 
										updated = true;
										console.log('Royal Addons: Updated via Textarea val()');
									}

									if (updated) {
										if (typeof elementor !== 'undefined' && elementor.notifications) {
											elementor.notifications.showToast({
												message: 'Template Applied Successfully!',
												type: 'info'
											});
										}
									}
								} else {
									setTimeout(function() { attemptUpdate(attempts + 1); }, 100);
								}
							};

							// Start attempts
							setTimeout(function() { attemptUpdate(0); }, 50);
						});
					});
				}
			});
			
			// Update field token display in repeater items
			function updateFieldTokenDisplay() {
				$('.royal-field-token-code').each(function() {
					var tokenEl = $(this);
					var wrapper = tokenEl.closest('.elementor-repeater-row-controls');
					if (wrapper.length) {
						var customIdInput = wrapper.find('[data-setting="custom_id"]');
						if (customIdInput.length && customIdInput.val()) {
							tokenEl.text('[' + customIdInput.val() + ']');
						}
					}
				});
			}
			
			// Copy field token button handler
			$(document).on('click', '.royal-copy-field-token', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				var btn = $(this);
				var tokenCode = btn.siblings('.royal-field-token-code').text();
				
				if (navigator.clipboard && tokenCode && tokenCode !== '[field_id]') {
					navigator.clipboard.writeText(tokenCode).then(function() {
						if (typeof elementor !== 'undefined') {
							elementor.notifications.showToast({
								message: 'Token copied: ' + tokenCode
							});
						}
					});
				} else if (tokenCode === '[field_id]') {
					if (typeof elementor !== 'undefined') {
						elementor.notifications.showToast({
							message: 'Please enter a Field ID first'
						});
					}
				}
			});
			
			// Update token when custom_id changes
			$(document).on('input change', '[data-setting="custom_id"]', function() {
				var input = $(this);
				var wrapper = input.closest('.elementor-repeater-row-controls');
				var tokenCode = wrapper.find('.royal-field-token-code');
				if (tokenCode.length && input.val()) {
					tokenCode.text('[' + input.val() + ']');
				}
			});
			
			// Dynamic token display for Royal Form - in Email section
			function updateAvailableTokens() {
				var tokensContainer = $('.royal-available-tokens-list');
				if (!tokensContainer.length) return;
				
				if (typeof elementor === 'undefined') return;
				var panel = elementor.getPanelView();
				if (!panel) return;
				
				var currentPage = panel.getCurrentPageView();
				if (!currentPage) return;
				
				var editedElement = currentPage.getOption('editedElementView');
				if (!editedElement || editedElement.model.get('widgetType') !== 'royal-form') return;
				
				var formFields = editedElement.model.getSetting('form_fields');
				if (!formFields || !formFields.models) return;
				
				var tokensHtml = '';
				
				// System tokens first
				var systemTokens = [
					{ token: '[all-fields]', label: 'All Fields' },
					{ token: '[site:name]', label: 'Site Name' },
					{ token: '[page:url]', label: 'Page URL' }
				];
				
				systemTokens.forEach(function(item) {
					tokensHtml += '<span class="royal-token-badge" data-token="' + item.token + '" style="background:#e0f0ff; color:#0056b3; padding:4px 10px; border-radius:4px; cursor:pointer; font-size:11px; font-family:monospace; border:1px solid #b8daff;" title="' + item.label + ' - Click to copy">' + item.token + '</span>';
				});
				
				// Field tokens from form fields
				formFields.models.forEach(function(field) {
					var fieldId = field.get('custom_id');
					var fieldLabel = field.get('field_label') || fieldId;
					var fieldType = field.get('field_type');
					
					if (fieldId && fieldType !== 'step' && fieldType !== 'html' && fieldType !== 'honeypot' && fieldType !== 'recaptcha') {
						var token = '[' + fieldId + ']';
						tokensHtml += '<span class="royal-token-badge" data-token="' + token + '" style="background:#f0f0f1; color:#1e1e1e; padding:4px 10px; border-radius:4px; cursor:pointer; font-size:11px; font-family:monospace; border:1px solid #ddd;" title="' + fieldLabel + ' - Click to copy">' + token + '</span>';
					}
				});
				
				tokensContainer.html(tokensHtml);
				
				// Also update field token displays
				updateFieldTokenDisplay();
			}
			
			// Copy token to clipboard on click - for email section tokens
			$(document).on('click', '.royal-token-badge', function() {
				var token = $(this).data('token');
				var badge = $(this);
				if (navigator.clipboard && typeof elementor !== 'undefined') {
					navigator.clipboard.writeText(token).then(function() {
						elementor.notifications.showToast({
							message: 'Token copied: ' + token
						});
						// Visual feedback
						badge.css('background', '#d4edda');
						setTimeout(function() {
							badge.css('background', badge.data('token').indexOf(':') > -1 ? '#e0f0ff' : '#f0f0f1');
						}, 500);
					});
				}
			});
			
			// Wait for Elementor to be ready before adding hooks
			$(window).on('elementor:init', function() {
				if (typeof elementor !== 'undefined' && elementor.hooks) {
					elementor.hooks.addAction('panel/open_editor/widget/royal-form', function(panel, model, view) {
						setTimeout(updateAvailableTokens, 100);
						setTimeout(updateFieldTokenDisplay, 200);
						
						// Listen for repeater changes
						model.on('change:form_fields', function() {
							setTimeout(updateAvailableTokens, 100);
							setTimeout(updateFieldTokenDisplay, 200);
						});

						// Listen for Email Template Preset changes
						model.on('change:email_template_preset', function() {
							var preset = model.getSetting('email_template_preset');
							var content = '';

							if (preset === 'table') {
								content = '<p>Hi Admin,</p><p>You have a new form submission from [form:name]:</p>[all-fields]<p>Thanks,<br>[site:name]</p>';
							} else if (preset === 'plain') {
								content = 'New Submission from [form:name]:\n\n[all-fields]\n\nSent from [site:name]';
							} else if (preset === 'default') {
								content = ''; // Empty triggers default
							}

							if (preset !== '') {
								// Update model
								model.setSetting('email_content', content);
								
								// Wait for DOM to catch up or ensure we find it
								setTimeout(function() {
									// Use global selector to find active control in panel
									var wrapper = $('body').find('.elementor-control-email_content');
									var textarea = wrapper.find('textarea[data-setting="email_content"]');
									
									if (!textarea.length) {
										textarea = wrapper.find('textarea');
									}

									if (textarea.length) {
										textarea.val(content).trigger('input');
										
										// Update TinyMCE if active
										var editorId = textarea.attr('id');
										if (editorId && typeof window.tinymce !== 'undefined') {
											var editor = window.tinymce.get(editorId);
											if (editor && !editor.isHidden()) {
												editor.setContent(content);
												editor.save();
											}
										}
									}
									
									// Show notification
									if (typeof elementor !== 'undefined' && elementor.notifications) {
										elementor.notifications.showToast({
											message: 'Email Template Applied!',
											type: 'info'
										});
									}
								}, 200);
							}
						});
					});
				}
			});
			
			// Update on section change and repeater item expand
			$(document).on('click', '.elementor-panel-navigation-tab, .elementor-repeater-row-item-title', function() {
				setTimeout(updateAvailableTokens, 200);
				setTimeout(updateFieldTokenDisplay, 300);
			});
			
		})(jQuery);
		JS;
	}

	private function load_files() {
		// Core classes
		require_once __DIR__ . '/classes/action-base.php';
		require_once __DIR__ . '/classes/form-record.php';
		require_once __DIR__ . '/classes/ajax-handler.php';
		require_once __DIR__ . '/classes/form-base.php';
		require_once __DIR__ . '/classes/field-registrar.php';
		require_once __DIR__ . '/classes/validation.php';
		require_once __DIR__ . '/classes/mail-template.php';
		require_once __DIR__ . '/classes/form-presets.php';

		// Field types
		require_once __DIR__ . '/fields/field-base.php';
		require_once __DIR__ . '/fields/text.php';
		require_once __DIR__ . '/fields/email.php';
		require_once __DIR__ . '/fields/textarea.php';
		require_once __DIR__ . '/fields/url.php';
		require_once __DIR__ . '/fields/tel.php';
		require_once __DIR__ . '/fields/number.php';
		require_once __DIR__ . '/fields/date.php';
		require_once __DIR__ . '/fields/time.php';
		require_once __DIR__ . '/fields/select.php';
		require_once __DIR__ . '/fields/checkbox.php';
		require_once __DIR__ . '/fields/radio.php';
		require_once __DIR__ . '/fields/acceptance.php';
		require_once __DIR__ . '/fields/file-upload.php';
		require_once __DIR__ . '/fields/hidden.php';
		require_once __DIR__ . '/fields/html.php';
		require_once __DIR__ . '/fields/step.php';
		require_once __DIR__ . '/fields/recaptcha.php';
		require_once __DIR__ . '/fields/honeypot.php';

		// Actions
		require_once __DIR__ . '/actions/email.php';
		require_once __DIR__ . '/actions/redirect.php';
		require_once __DIR__ . '/actions/database.php';
		require_once __DIR__ . '/actions/webhook.php';
		require_once __DIR__ . '/actions/slack.php';
		require_once __DIR__ . '/actions/discord.php';
		require_once __DIR__ . '/actions/mailchimp.php';
		require_once __DIR__ . '/actions/popup.php';
	}

	private function register_actions() {
		$actions = [
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Email',
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Redirect',
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Database',
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Webhook',
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Slack',
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Discord',
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Mailchimp',
			'\\RoyalAddons\\Modules\\Forms\\Actions\\Popup',
		];

		foreach ( $actions as $action_class ) {
			$action = new $action_class();
			$this->actions_registrar->register( $action );
		}
	}
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

