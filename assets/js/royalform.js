/**
 * Royal Form Widget JavaScript
 * Handles form submission, validation, and multi-step functionality
 */

(function ($) {
	'use strict';

	class RoyalForm {
		constructor(form) {
			this.$form = $(form);
			this.$submitButton = this.$form.find('.royal-form-submit');
			this.$submitText = this.$form.find('.royal-form-submit-text');
			this.$loadingIcon = this.$form.find('.royal-form-submit-loading');
			this.$successMessage = this.$form.find('.royal-form-message-success');
			this.$errorMessage = this.$form.find('.royal-form-message-error');

			this.isMultiStep = this.$form.find('.royal-form-step').length > 0;
			this.currentStep = 0;
			this.totalSteps = this.$form.find('.royal-form-step').length;
			this.isSubmitting = false; // Prevent duplicate submissions

			this.init();
		}

		init() {
			this.bindEvents();

			if (this.isMultiStep) {
				this.initMultiStep();
			}
		}

		bindEvents() {
			this.$form.off('submit').on('submit', (e) => this.handleSubmit(e));

			// Field validation on blur
			this.$form.off('blur', '.royal-form-field').on('blur', '.royal-form-field', (e) => this.validateField($(e.target)));

			// File input change
			this.$form.off('change', 'input[type="file"]').on('change', 'input[type="file"]', (e) => this.handleFileChange(e));

			// Multi-step navigation
			this.$form.off('click', '.royal-form-step-next').on('click', '.royal-form-step-next', () => this.nextStep());
			this.$form.off('click', '.royal-form-step-prev').on('click', '.royal-form-step-prev', () => this.prevStep());
		}

		initMultiStep() {
			// Show first step
			this.$form.find('.royal-form-step').eq(0).addClass('royal-form-step-active');
			this.updateProgress();
		}

		nextStep() {
			if (!this.validateCurrentStep()) {
				return;
			}

			if (this.currentStep < this.totalSteps - 1) {
				this.$form.find('.royal-form-step').eq(this.currentStep).removeClass('royal-form-step-active');
				this.currentStep++;
				this.$form.find('.royal-form-step').eq(this.currentStep).addClass('royal-form-step-active');
				this.updateProgress();
				this.scrollToForm();
			}
		}

		prevStep() {
			if (this.currentStep > 0) {
				this.$form.find('.royal-form-step').eq(this.currentStep).removeClass('royal-form-step-active');
				this.currentStep--;
				this.$form.find('.royal-form-step').eq(this.currentStep).addClass('royal-form-step-active');
				this.updateProgress();
				this.scrollToForm();
			}
		}

		updateProgress() {
			const progress = ((this.currentStep + 1) / this.totalSteps) * 100;
			this.$form.find('.royal-form-progress-bar').css('width', progress + '%');
		}

		scrollToForm() {
			$('html, body').animate({
				scrollTop: this.$form.offset().top - 100
			}, 300);
		}

		validateCurrentStep() {
			const $currentStep = this.$form.find('.royal-form-step').eq(this.currentStep);
			const $requiredFields = $currentStep.find('.royal-form-field[required]');
			let isValid = true;

			$requiredFields.each((index, field) => {
				if (!this.validateField($(field))) {
					isValid = false;
				}
			});

			return isValid;
		}

		validateField($field) {
			const value = $field.val();
			const type = $field.attr('type') || $field.prop('tagName').toLowerCase();
			const required = $field.attr('required');
			let isValid = true;
			let errorMessage = '';

			// Clear previous errors
			$field.removeClass('royal-form-field-error');
			$field.siblings('.royal-form-error-message').remove();

			// Required validation
			if (required && !value) {
				isValid = false;
				errorMessage = 'This field is required.';
			}

			// Email validation
			if (type === 'email' && value) {
				const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				if (!emailRegex.test(value)) {
					isValid = false;
					errorMessage = 'Please enter a valid email address.';
				}
			}

			// URL validation
			if (type === 'url' && value) {
				try {
					new URL(value);
				} catch (e) {
					isValid = false;
					errorMessage = 'Please enter a valid URL.';
				}
			}

			// Number validation
			if (type === 'number' && value) {
				const min = $field.attr('min');
				const max = $field.attr('max');
				const numValue = parseFloat(value);

				if (min && numValue < parseFloat(min)) {
					isValid = false;
					errorMessage = `Value must be at least ${min}.`;
				}
				if (max && numValue > parseFloat(max)) {
					isValid = false;
					errorMessage = `Value must be no more than ${max}.`;
				}
			}

			// Show error
			if (!isValid) {
				$field.addClass('royal-form-field-error');
				$field.after(`<div class="royal-form-error-message">${errorMessage}</div>`);
			}

			return isValid;
		}

		handleFileChange(e) {
			const $input = $(e.target);
			const files = e.target.files;
			const maxSize = parseInt($input.data('max-size')) || 5 * 1024 * 1024;
			const maxFiles = parseInt($input.data('max-files')) || 5;
			const $preview = $input.siblings('.royal-form-upload-preview');

			$preview.empty();

			if (files.length > maxFiles) {
				alert(`You can only upload up to ${maxFiles} files.`);
				$input.val('');
				return;
			}

			for (let i = 0; i < files.length; i++) {
				const file = files[i];

				if (file.size > maxSize) {
					alert(`File "${file.name}" exceeds the maximum size of ${Math.round(maxSize / 1024 / 1024)}MB.`);
					$input.val('');
					return;
				}

				// Show preview for images
				if (file.type.startsWith('image/')) {
					const reader = new FileReader();
					reader.onload = function (e) {
						$preview.append(`<img src="${e.target.result}" alt="${file.name}">`);
					};
					reader.readAsDataURL(file);
				} else {
					$preview.append(`<div class="royal-form-file-name">${file.name}</div>`);
				}
			}
		}

		handleSubmit(e) {
			e.preventDefault();

			// Prevent duplicate submissions
			if (this.isSubmitting) {
				return;
			}

			// Validate all fields for non-multistep forms
			if (!this.isMultiStep) {
				const $requiredFields = this.$form.find('.royal-form-field[required]');
				let isValid = true;

				$requiredFields.each((index, field) => {
					if (!this.validateField($(field))) {
						isValid = false;
					}
				});

				if (!isValid) {
					return;
				}
			} else {
				// For multi-step, validate current (last) step
				if (!this.validateCurrentStep()) {
					return;
				}
			}

			// Lock submission
			this.isSubmitting = true;

			// Show loading state
			this.setLoadingState(true);
			this.hideMessages();

			const formData = new FormData(this.$form[0]);
			formData.append('action', 'royal_elementor_form_submit');

			$.ajax({
				url: typeof royal_addons_settings !== 'undefined' ? royal_addons_settings.ajaxurl : '/wp-admin/admin-ajax.php',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: (response) => {
					this.isSubmitting = false; // Unlock
					this.setLoadingState(false);

					if (response.success) {
						this.showSuccessMessage(response.data.message);
						this.$form[0].reset();

						// Clear file previews
						this.$form.find('.royal-form-upload-preview').empty();

						// Reset multi-step form
						if (this.isMultiStep) {
							this.$form.find('.royal-form-step').removeClass('royal-form-step-active');
							this.$form.find('.royal-form-step').eq(0).addClass('royal-form-step-active');
							this.currentStep = 0;
							this.updateProgress();
						}

						// Handle redirect
						if (response.data.data && response.data.data.redirect_url) {
							setTimeout(() => {
								window.location.href = response.data.data.redirect_url;
							}, 1000);
						}
					} else {
						this.showErrorMessage(response.data.message);
					}
				},
				error: (xhr, status, error) => {
					this.isSubmitting = false; // Unlock on error
					this.setLoadingState(false);
					this.showErrorMessage('An error occurred. Please try again.');
					console.error('Form submission error:', error);
				}
			});
		}

		setLoadingState(loading) {
			if (loading) {
				this.$submitButton.attr('disabled', true);
				this.$submitText.hide();
				this.$loadingIcon.show();
			} else {
				this.$submitButton.attr('disabled', false);
				this.$submitText.show();
				this.$loadingIcon.hide();
			}
		}

		hideMessages() {
			this.$successMessage.hide();
			this.$errorMessage.hide();
		}

		showSuccessMessage(message) {
			if (message) {
				this.$successMessage.text(message);
			}
			this.$successMessage.fadeIn();
		}

		showErrorMessage(message) {
			if (message) {
				this.$errorMessage.text(message);
			}
			this.$errorMessage.fadeIn();
		}
	}

	// Conditional Logic Handler
	class RoyalFormConditional {
		constructor(form) {
			this.$form = $(form);
			this.conditions = [];
			this.init();
		}

		init() {
			this.parseConditions();
			this.bindEvents();
			this.evaluateAll();
		}

		parseConditions() {
			// Parse conditions from data attributes on field wrappers
			this.$form.find('.royal-form-item[data-conditions]').each((index, element) => {
				const $field = $(element);
				const conditionData = $field.data('conditions');

				if (conditionData && conditionData.enabled) {
					this.conditions.push({
						$element: $field,
						fieldId: conditionData.field_id,
						action: conditionData.action || 'show',
						targetField: conditionData.condition_field,
						operator: conditionData.condition_operator || 'equals',
						value: conditionData.condition_value || ''
					});
				}
			});
		}

		bindEvents() {
			// Bind change events to all form fields
			this.$form.on('change keyup', '.royal-form-field', () => this.evaluateAll());
			this.$form.on('change', 'input[type="checkbox"], input[type="radio"]', () => this.evaluateAll());
		}

		evaluateAll() {
			this.conditions.forEach(condition => {
				const result = this.evaluateCondition(condition);
				this.applyAction(condition, result);
			});
		}

		evaluateCondition(condition) {
			const $targetField = this.$form.find(`[name="form_fields[${condition.targetField}]"]`);

			if ($targetField.length === 0) {
				return false;
			}

			let fieldValue = this.getFieldValue($targetField);
			const checkValue = condition.value;

			switch (condition.operator) {
				case 'equals':
					return fieldValue === checkValue;

				case 'not_equals':
					return fieldValue !== checkValue;

				case 'contains':
					return fieldValue.toLowerCase().includes(checkValue.toLowerCase());

				case 'not_contains':
					return !fieldValue.toLowerCase().includes(checkValue.toLowerCase());

				case 'empty':
					return fieldValue === '' || fieldValue === null || (Array.isArray(fieldValue) && fieldValue.length === 0);

				case 'not_empty':
					return fieldValue !== '' && fieldValue !== null && !(Array.isArray(fieldValue) && fieldValue.length === 0);

				case 'greater_than':
					return parseFloat(fieldValue) > parseFloat(checkValue);

				case 'less_than':
					return parseFloat(fieldValue) < parseFloat(checkValue);

				default:
					return false;
			}
		}

		getFieldValue($field) {
			const type = $field.attr('type');

			// Handle checkbox groups
			if (type === 'checkbox') {
				const name = $field.attr('name');
				const $checked = this.$form.find(`input[name="${name}"]:checked`);
				return $checked.map((i, el) => $(el).val()).get().join(',');
			}

			// Handle radio buttons
			if (type === 'radio') {
				const name = $field.attr('name');
				return this.$form.find(`input[name="${name}"]:checked`).val() || '';
			}

			// Handle select with multiple
			if ($field.is('select[multiple]')) {
				return $field.val() ? $field.val().join(',') : '';
			}

			return $field.val() || '';
		}

		applyAction(condition, result) {
			const $element = condition.$element;
			const $input = $element.find('.royal-form-field');

			// Determine visibility based on action and result
			let shouldShow = false;

			if (condition.action === 'show') {
				shouldShow = result;
			} else if (condition.action === 'hide') {
				shouldShow = !result;
			}

			if (shouldShow) {
				$element.slideDown(200);
				$input.prop('disabled', false);
			} else {
				$element.slideUp(200);
				$input.prop('disabled', true);
				// Clear value when hidden to prevent validation issues
				if ($input.attr('type') === 'checkbox' || $input.attr('type') === 'radio') {
					$input.prop('checked', false);
				} else {
					$input.val('');
				}
			}
		}
	}

	// Initialize forms
	// Initialize forms
	function initRoyalForms() {
		$('.royal-form').each(function () {
			var $form = $(this);
			if (!$form.data('royal-form-init')) {
				new RoyalForm(this);
				new RoyalFormConditional(this);
				$form.data('royal-form-init', true);
			}
		});
	}

	$(document).ready(function () {
		initRoyalForms();
	});

	// Elementor frontend handler for editor preview
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/royal-form.default', function ($scope) {
			$scope.find('.royal-form').each(function () {
				var $form = $(this);
				if (!$form.data('royal-form-init')) {
					new RoyalForm(this);
					new RoyalFormConditional(this);
					$form.data('royal-form-init', true);
				}
			});
		});
	});

})(jQuery);
