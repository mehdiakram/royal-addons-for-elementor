(function ($) {
	"use strict";

	// Apply custom CSS to the live preview in the Elementor editor
	function addCustomCss(css, context) {
		if (!context) {
			return css;
		}
		var model = context.model;
		var settings = model.get('settings');
		var customCSS = '';

		if (settings) {
			if (typeof settings.get === 'function') {
				customCSS = settings.get('custom_css');
			} else {
				customCSS = settings.custom_css;
			}
		}

		if (customCSS && typeof customCSS === 'object') {
			if (customCSS.value) {
				customCSS = customCSS.value;
			} else if (customCSS.default) {
				customCSS = customCSS.default;
			} else {
				try {
					customCSS = String(customCSS);
				} catch (e) {
					customCSS = '';
				}
			}
		}

		if (typeof customCSS !== 'string') {
			customCSS = '';
		}

		var selector = '.elementor-element.elementor-element-' + model.get('id') + ', [data-id="' + model.get('id') + '"]';

		if ('document' === model.get('elType')) {
			selector = elementor.config.document.settings.cssWrapperSelector;
		}

		if (customCSS) {
			css += customCSS.replace(/selector/g, selector);
		}

		return css;
	}

	function initRoyalCustomCSS() {
		if (typeof elementor === 'undefined' || typeof elementor.hooks === 'undefined') {
			return;
		}

		elementor.hooks.addFilter('editor/style/styleText', addCustomCss);

		function addPageCustomCss() {
			var customCSS = elementor.settings.page.model.get('custom_css');
			if (customCSS) {
				customCSS = customCSS.replace(/selector/g, elementor.config.settings.page.cssWrapperSelector);
				elementor.settings.page.getControlsCSS().elements.$stylesheetElement.append(customCSS);
			}
		}

		elementor.on('preview:loaded', addPageCustomCss);
	}

	if (window.elementor && elementor.hooks) {
		initRoyalCustomCSS();
	} else {
		$(window).on('elementor:init', initRoyalCustomCSS);
	}

})(jQuery);