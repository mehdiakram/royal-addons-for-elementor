(function ($) {
    /**
     * Royal Form Editor Script
     * Handles dynamic token updates and preset application in Elementor Editor
     */

    // Helper: Copy to clipboard
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            return navigator.clipboard.writeText(text);
        } else {
            // Fallback
            var textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            var successful = document.execCommand('copy');
            document.body.removeChild(textarea);
            return Promise.resolve(successful);
        }
    }

    // Helper: Show Toast
    function showToast(message, type) {
        if (typeof elementor !== 'undefined' && elementor.notifications) {
            elementor.notifications.showToast({
                message: message,
                type: type || 'info'
            });
        } else {
            alert(message);
        }
    }

    // Main Logic
    var RoyalFormEditor = {
        init: function () {
            $(window).on('elementor:init', this.onElementorInit.bind(this));
        },

        onElementorInit: function () {
            if (!elementor.hooks) return;

            // Hook into Royal Form widget editing
            elementor.hooks.addAction('panel/open_editor/widget/royal-form', this.onFormEditorOpen.bind(this));
        },

        onFormEditorOpen: function (panel, model, view) {
            var self = this;

            // 1. Initial Update of Token Lists and Badges
            setTimeout(function () {
                self.updateTokenDisplay(model);
                self.updateAvailableTokens(model);
            }, 500);

            // 2. Listen for Repeater Changes (Add/Remove/Sort fields)
            model.on('change:form_fields', function () {
                setTimeout(function () {
                    self.updateTokenDisplay(model);
                    self.updateAvailableTokens(model);
                }, 300);
            });

            // 5. MutationObserver to handle Repeater Item Expansion/Addition
            // This ensures tokens update immediately when the DOM nodes are created
            var observer = new MutationObserver(function (mutations) {
                var shouldUpdate = false;
                mutations.forEach(function (mutation) {
                    if (mutation.addedNodes.length) {
                        // Check if a Repeater row was added or expanded
                        $(mutation.addedNodes).each(function () {
                            if ($(this).hasClass('elementor-repeater-fields') || $(this).find('.royal-field-token-code').length) {
                                shouldUpdate = true;
                            }
                        });
                    }
                });
                if (shouldUpdate) {
                    self.updateTokenDisplay(model);
                    self.updateAvailableTokens(model);
                }
            });

            // Observe the Elementor Panel for changes
            var panelEl = document.getElementById('elementor-panel-content-controls');
            if (panelEl) {
                observer.observe(panelEl, { childList: true, subtree: true });
            }

            // Apply Preset Handlers (Existing logic + Refinements)
            this.bindPresetHandlers(panel, model);
        },

        updateSingleTokenDisplay: function ($input) {
            var val = $input.val();
            var $wrapper = $input.closest('.elementor-repeater-row-controls');
            var $tokenCode = $wrapper.find('.royal-field-token-code');

            if ($tokenCode.length) {
                // If value is empty, try to get from model if possible, otherwise default
                var text = val ? '[' + val + ']' : '[field_id]';

                // If it looks like a "new" field (empty), checking if we can find a default
                if (!val) {
                    // Try to find the placeholder to see if it gives a hint? No.
                }

                $tokenCode.text(text);
            }
        },

        updateTokenDisplay: function (model) {
            // This runs on all open repeater items
            $('.royal-field-token-code').each(function () {
                var $token = $(this);
                // Avoid redundant updates
                // if ($token.data('updated')) return; 

                var $wrapper = $token.closest('.elementor-repeater-row-controls');

                if ($wrapper.length) {
                    var $idInput = $wrapper.find('[data-setting="custom_id"]');
                    // If input exists (item is expanded), use it
                    if ($idInput.length) {
                        var val = $idInput.val();
                        // Logic: If val is present, show it. 
                        // If val is empty, it might be a brand new field in process of init.
                        // But usually default fields have custom_id.
                        if (val) {
                            $token.text('[' + val + ']');
                            $token.data('updated', true);
                        } else {
                            // If empty, keep [field_id] to indicate it needs a value
                            $token.text('[field_id]');
                        }
                    }
                }
            });
        },

        updateAvailableTokens: function (model) {
            var $container = $('.royal-available-tokens-list');
            if (!$container.length) return;

            var fields = model.getSetting('form_fields'); // Backbone collection
            var tokensHtml = '';

            // System Tokens
            var systemTokens = [
                { token: '[all-fields]', label: 'All Fields Table' },
                { token: '[site:name]', label: 'Site Name' },
                { token: '[site:url]', label: 'Site URL' },
                { token: '[page:title]', label: 'Page Title' },
                { token: '[page:url]', label: 'Page URL' },
                { token: '[form:name]', label: 'Form Name' },
                { token: '[submission:date]', label: 'Date' },
                { token: '[submission:time]', label: 'Time' },
                { token: '[user:ip]', label: 'User IP' }
            ];

            systemTokens.forEach(function (t) {
                tokensHtml += '<span class="royal-token-badge system" data-token="' + t.token + '" title="' + t.label + '">' + t.token + '</span>';
            });

            // Field Tokens
            if (fields && fields.models) {
                fields.models.forEach(function (fieldModel) {
                    var id = fieldModel.get('custom_id');
                    var type = fieldModel.get('field_type');
                    var label = fieldModel.get('field_label') || id;

                    // Skip non-data fields
                    if (['step', 'html', 'honeypot', 'recaptcha'].indexOf(type) === -1 && id) {
                        tokensHtml += '<span class="royal-token-badge field" data-token="[' + id + ']" title="' + label + '">[' + id + ']</span>';
                    }
                });
            }

            $container.html(tokensHtml);

            // Add some basic styles if not present
            if (!$('#royal-form-editor-css').length) {
                $('head').append('<style id="royal-form-editor-css">' +
                    '.royal-token-badge { display:inline-block; margin:2px; padding:4px 8px; background:#f1f1f1; border:1px solid #ccc; border-radius:3px; cursor:pointer; font-family:monospace; font-size:11px; transition:all 0.2s; }' +
                    '.royal-token-badge:hover { background:#0073aa; color:#fff; border-color:#0073aa; }' +
                    '.royal-token-badge.system { background:#e3f2fd; border-color:#90caf9; color:#0d47a1; }' +
                    '.royal-token-badge.system:hover { background:#0d47a1; color:#fff; }' +
                    '</style>');
            }
        },

        bindPresetHandlers: function (panel, model) {
            // Apply Email Template
            panel.$el.off('click', '.royal-apply-email-template-btn').on('click', '.royal-apply-email-template-btn', function (e) {
                e.preventDefault();
                var preset = model.getSetting('email_template_preset');

                if (!preset) {
                    showToast('Please select a template first', 'warning');
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

                model.setSetting('email_content', content);

                // Try to update View
                // 1. TinyMCE
                // 2. Textarea
                var $control = panel.$el.find('.elementor-control-email_content');
                var $textarea = $control.find('textarea[data-setting="email_content"]');
                var editorId = $textarea.attr('id');

                if (editorId && window.tinymce && window.tinymce.get(editorId)) {
                    window.tinymce.get(editorId).setContent(content);
                } else {
                    $textarea.val(content).trigger('input');
                }

                showToast('Template Applied!', 'success');
            });
        }
    };

    RoyalFormEditor.init();

})(jQuery);
