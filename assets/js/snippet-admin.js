/**
 * Enhanced Royal Snippet Admin JavaScript with Advanced Conditions UI
 */
(function($) {
    'use strict';

    let codeEditor;
    let conditionIndex = 0;
    let conditionRules = {};

    $(document).ready(function() {
        initCodeEditor();
        initConditions();
        initAIFeatures();
        initEventHandlers();
        loadConditionRules();
    });

    /**
     * Initialize CodeMirror editor with enhanced features
     */
    function initCodeEditor() {
        const textarea = document.getElementById('royal_snippet_content');
        if (!textarea || typeof CodeMirror === 'undefined') {
            return;
        }

        const initialType = $('#royal_snippet_code_type').val() || 'html';

        codeEditor = CodeMirror.fromTextArea(textarea, {
            lineNumbers: true,
            mode: getCodeMirrorMode(initialType),
            theme: 'monokai',
            indentUnit: 2,
            tabSize: 2,
            lineWrapping: true,
            autoCloseTags: true,
            autoCloseBrackets: true,
            matchBrackets: true,
            foldGutter: true,
            gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
            extraKeys: {
                'Ctrl-Space': 'autocomplete',
                'Ctrl-/': 'toggleComment',
                'Cmd-/': 'toggleComment',
                'F11': function(cm) {
                    cm.setOption('fullScreen', !cm.getOption('fullScreen'));
                },
                'Esc': function(cm) {
                    if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false);
                }
            },
            hintOptions: {
                completeSingle: false
            }
        });

        // Switch mode when code type changes
        $('#royal_snippet_code_type').on('change', function() {
            updateEditorMode($(this).val());
            handleCodeTypeChange($(this).val());
        });

        // Add editor toolbar
        addEditorToolbar();
    }

    /**
     * Add toolbar to code editor
     */
    function addEditorToolbar() {
        const toolbar = $(`
            <div class="royal-editor-toolbar">
                <div class="royal-toolbar-group">
                    <button type="button" class="royal-toolbar-btn" data-action="format" title="Format Code">
                        <span class="dashicons dashicons-editor-code"></span>
                    </button>
                    <button type="button" class="royal-toolbar-btn" data-action="fullscreen" title="Fullscreen (F11)">
                        <span class="dashicons dashicons-fullscreen-alt"></span>
                    </button>
                    <button type="button" class="royal-toolbar-btn" data-action="wrap" title="Toggle Line Wrap">
                        <span class="dashicons dashicons-editor-break"></span>
                    </button>
                </div>
                <div class="royal-toolbar-group">
                    <select class="royal-toolbar-select" id="royal-editor-theme">
                        <option value="monokai">Monokai</option>
                        <option value="default">Default</option>
                        <option value="material">Material</option>
                        <option value="dracula">Dracula</option>
                    </select>
                </div>
            </div>
        `);

        $('.royal-code-editor-wrapper').prepend(toolbar);

        // Toolbar event handlers
        $('.royal-toolbar-btn').on('click', handleToolbarAction);
        $('#royal-editor-theme').on('change', function() {
            if (codeEditor) {
                codeEditor.setOption('theme', $(this).val());
            }
        });
    }

    /**
     * Handle toolbar actions
     */
    function handleToolbarAction() {
        const action = $(this).data('action');
        
        switch (action) {
            case 'format':
                formatCode();
                break;
            case 'fullscreen':
                toggleFullscreen();
                break;
            case 'wrap':
                toggleLineWrap();
                break;
        }
    }

    /**
     * Format code in editor
     */
    function formatCode() {
        if (!codeEditor) return;
        
        const code = codeEditor.getValue();
        const mode = codeEditor.getOption('mode');
        
        // Basic formatting for different modes
        let formattedCode = code;
        
        if (mode === 'htmlmixed' || mode === 'xml') {
            formattedCode = formatHTML(code);
        } else if (mode === 'javascript') {
            formattedCode = formatJavaScript(code);
        } else if (mode === 'css') {
            formattedCode = formatCSS(code);
        }
        
        codeEditor.setValue(formattedCode);
        showNotification('Code formatted successfully!', 'success');
    }

    /**
     * Basic HTML formatting
     */
    function formatHTML(html) {
        // Simple HTML formatting - in production, use a proper formatter
        return html
            .replace(/></g, '>\n<')
            .replace(/^\s+|\s+$/g, '')
            .split('\n')
            .map(line => line.trim())
            .filter(line => line.length > 0)
            .join('\n');
    }

    /**
     * Basic JavaScript formatting
     */
    function formatJavaScript(js) {
        // Simple JS formatting - in production, use a proper formatter
        return js
            .replace(/;/g, ';\n')
            .replace(/{/g, '{\n')
            .replace(/}/g, '\n}')
            .split('\n')
            .map(line => line.trim())
            .filter(line => line.length > 0)
            .join('\n');
    }

    /**
     * Basic CSS formatting
     */
    function formatCSS(css) {
        // Simple CSS formatting - in production, use a proper formatter
        return css
            .replace(/;/g, ';\n')
            .replace(/{/g, ' {\n')
            .replace(/}/g, '\n}\n')
            .split('\n')
            .map(line => line.trim())
            .filter(line => line.length > 0)
            .join('\n');
    }

    /**
     * Toggle fullscreen mode
     */
    function toggleFullscreen() {
        if (codeEditor) {
            codeEditor.setOption('fullScreen', !codeEditor.getOption('fullScreen'));
        }
    }

    /**
     * Toggle line wrap
     */
    function toggleLineWrap() {
        if (codeEditor) {
            codeEditor.setOption('lineWrapping', !codeEditor.getOption('lineWrapping'));
        }
    }

    /**
     * Get CodeMirror mode string from code type
     */
    function getCodeMirrorMode(codeType) {
        const modeMap = {
            'html':       'htmlmixed',
            'css':        'css',
            'javascript': 'javascript',
            'php':        'php',
        };
        return modeMap[codeType] || 'htmlmixed';
    }

    /**
     * Update editor mode based on code type
     */
    function updateEditorMode(codeType) {
        if (!codeEditor) return;
        codeEditor.setOption('mode', getCodeMirrorMode(codeType));
    }

    /**
     * Handle all UI changes when code type dropdown changes
     */
    function handleCodeTypeChange(codeType) {
        const $locationGroup = $('#royal-location-group');
        const $phpWarning    = $('#royal-php-warning');
        const $autowrapText  = $('#royal-autowrap-text');

        const hints = {
            'html':       'HTML সরাসরি output হবে',
            'css':        'স্বয়ংক্রিয়ভাবে <style> tag-এ wrap হবে',
            'javascript': 'স্বয়ংক্রিয়ভাবে <script> tag-এ wrap হবে',
            'php':        'PHP সরাসরি server-এ execute হবে',
        };

        if (codeType === 'php') {
            $locationGroup.slideUp(200);
            $phpWarning.slideDown(200);
        } else {
            $locationGroup.slideDown(200);
            $phpWarning.slideUp(200);
        }

        $autowrapText.text(hints[codeType] || '');

        // Update code type badge color
        updateCodeTypeBadge(codeType);
    }

    /**
     * Update the visual badge color based on code type
     */
    function updateCodeTypeBadge(codeType) {
        const $badge = $('#royal-autowrap-badge');
        $badge.removeClass('type-html type-css type-javascript type-php');
        $badge.addClass('type-' + codeType);
    }

    /**
     * Load condition rules from server
     */
    function loadConditionRules() {
        // For now, use static rules. In production, load from server
        conditionRules = {
            'basic': {
                'label': 'Basic',
                'rules': {
                    'entire_site': 'Entire Site',
                    'front_page': 'Front Page'
                }
            },
            'singular': {
                'label': 'Singular',
                'rules': {
                    'singular': 'Singular',
                    'all_singular': 'All Singular'
                }
            },
            'post': {
                'label': 'Post',
                'rules': {
                    'post': 'Posts',
                    'category': 'In Category',
                    'tag': 'In Tag'
                }
            },
            'page': {
                'label': 'Page',
                'rules': {
                    'page': 'Pages'
                }
            },
            'archive': {
                'label': 'Archive',
                'rules': {
                    'archive': 'Archive',
                    'search': 'Search Results',
                    'error_404': '404 Page'
                }
            },
            'user': {
                'label': 'User',
                'rules': {
                    'user_logged_in': 'Logged In Users',
                    'user_logged_out': 'Logged Out Users'
                }
            },
            'device': {
                'label': 'Device',
                'rules': {
                    'mobile': 'Mobile',
                    'desktop': 'Desktop'
                }
            }
        };
    }

    /**
     * Initialize enhanced conditions functionality
     */
    function initConditions() {
        // Set initial condition index
        conditionIndex = $('#royal-conditions-list .royal-condition-item').length;

        // Add condition button
        $('#royal-add-condition').on('click', addCondition);

        // Remove condition buttons
        $(document).on('click', '.royal-remove-condition', removeCondition);

        // Condition rule change handler
        $(document).on('change', '.royal-condition-rule', handleRuleChange);

        // Update remove button visibility
        updateRemoveButtons();

        // Initialize existing conditions
        $('.royal-condition-rule').each(function() {
            handleRuleChange.call(this);
        });
    }

    /**
     * Add new condition with enhanced UI
     */
    function addCondition() {
        const conditionHtml = createConditionHTML(conditionIndex);
        $('#royal-conditions-list').append(conditionHtml);
        conditionIndex++;
        updateRemoveButtons();
        
        // Animate the new condition
        const $newCondition = $('#royal-conditions-list .royal-condition-item').last();
        $newCondition.hide().slideDown(300);
    }

    /**
     * Create condition HTML with grouped options
     */
    function createConditionHTML(index, condition = null) {
        let ruleOptions = '';
        
        // Create grouped options
        Object.keys(conditionRules).forEach(groupKey => {
            const group = conditionRules[groupKey];
            ruleOptions += `<optgroup label="${group.label}">`;
            
            Object.keys(group.rules).forEach(ruleKey => {
                const selected = condition && condition.rule === ruleKey ? 'selected' : '';
                ruleOptions += `<option value="${ruleKey}" ${selected}>${group.rules[ruleKey]}</option>`;
            });
            
            ruleOptions += '</optgroup>';
        });

        const typeSelected = {
            include: condition && condition.type === 'include' ? 'selected' : '',
            exclude: condition && condition.type === 'exclude' ? 'selected' : ''
        };

        return `
            <div class="royal-condition-item" data-index="${index}">
                <div class="royal-condition-header">
                    <span class="royal-condition-number">${index + 1}</span>
                    <span class="royal-condition-label">Condition</span>
                    <button type="button" class="royal-remove-condition" style="display: none;">×</button>
                </div>
                <div class="royal-condition-controls">
                    <div class="royal-condition-row">
                        <label class="royal-condition-field-label">Type:</label>
                        <select name="royal_conditions[${index}][type]" class="royal-condition-type">
                            <option value="include" ${typeSelected.include}>Include</option>
                            <option value="exclude" ${typeSelected.exclude}>Exclude</option>
                        </select>
                    </div>
                    
                    <div class="royal-condition-row">
                        <label class="royal-condition-field-label">Rule:</label>
                        <select name="royal_conditions[${index}][rule]" class="royal-condition-rule">
                            ${ruleOptions}
                        </select>
                    </div>
                    
                    <div class="royal-condition-row royal-condition-value-row" style="display: none;">
                        <label class="royal-condition-field-label">Value:</label>
                        <select name="royal_conditions[${index}][value]" class="royal-condition-value">
                            <option value="">Select...</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Remove condition with animation
     */
    function removeCondition() {
        const $condition = $(this).closest('.royal-condition-item');
        $condition.slideUp(300, function() {
            $(this).remove();
            updateRemoveButtons();
            updateConditionNumbers();
        });
    }

    /**
     * Update condition numbers
     */
    function updateConditionNumbers() {
        $('#royal-conditions-list .royal-condition-item').each(function(index) {
            $(this).find('.royal-condition-number').text(index + 1);
        });
    }

    /**
     * Update remove button visibility
     */
    function updateRemoveButtons() {
        const conditions = $('#royal-conditions-list .royal-condition-item');
        const removeButtons = $('.royal-remove-condition');
        
        if (conditions.length <= 1) {
            removeButtons.hide();
        } else {
            removeButtons.show();
        }
    }

    /**
     * Handle condition rule change with enhanced UI
     */
    function handleRuleChange() {
        const $this = $(this);
        const rule = $this.val();
        const $conditionItem = $this.closest('.royal-condition-item');
        const $valueRow = $conditionItem.find('.royal-condition-value-row');
        const $valueSelect = $conditionItem.find('.royal-condition-value');

        // Rules that need value selection
        const rulesWithValues = ['post', 'page', 'category', 'tag'];

        if (rulesWithValues.includes(rule)) {
            $valueRow.slideDown(200);
            loadConditionValues(rule, $valueSelect);
        } else {
            $valueRow.slideUp(200);
        }

        // Update condition preview
        updateConditionPreview($conditionItem);
    }

    /**
     * Update condition preview
     */
    function updateConditionPreview($conditionItem) {
        const type = $conditionItem.find('.royal-condition-type').val();
        const rule = $conditionItem.find('.royal-condition-rule').val();
        const value = $conditionItem.find('.royal-condition-value').val();
        
        let preview = type === 'exclude' ? 'Exclude: ' : 'Include: ';
        
        // Find rule label
        let ruleLabel = rule;
        Object.keys(conditionRules).forEach(groupKey => {
            const group = conditionRules[groupKey];
            if (group.rules[rule]) {
                ruleLabel = group.rules[rule];
            }
        });
        
        preview += ruleLabel;
        
        if (value) {
            const valueText = $conditionItem.find('.royal-condition-value option:selected').text();
            preview += ` (${valueText})`;
        }
        
        // Update or create preview element
        let $preview = $conditionItem.find('.royal-condition-preview');
        if ($preview.length === 0) {
            $preview = $('<div class="royal-condition-preview"></div>');
            $conditionItem.find('.royal-condition-controls').append($preview);
        }
        
        $preview.text(preview);
    }

    /**
     * Load condition values via AJAX with enhanced UI
     */
    function loadConditionValues(rule, $select) {
        $select.html('<option value="">Loading...</option>').prop('disabled', true);

        const data = {
            action: 'royal_snippet_get_condition_values',
            rule: rule,
            nonce: royalSnippetAdmin.nonce
        };

        $.post(royalSnippetAdmin.ajaxurl, data, function(response) {
            if (response.success) {
                let options = '<option value="">Select...</option>';
                response.data.forEach(function(item) {
                    options += `<option value="${item.value}">${item.label}</option>`;
                });
                $select.html(options).prop('disabled', false);
            } else {
                $select.html('<option value="">Error loading options</option>').prop('disabled', false);
            }
        }).fail(function() {
            $select.html('<option value="">Network error</option>').prop('disabled', false);
        });
    }

    /**
     * Initialize AI features with enhanced modal
     */
    function initAIFeatures() {
        createEnhancedAIModal();
        $('#royal-code-ai-btn').on('click', showAIModal);
    }

    /**
     * Create enhanced AI modal
     */
    function createEnhancedAIModal() {
        const modalHtml = `
            <div id="royal-ai-modal" class="royal-ai-modal">
                <div class="royal-ai-modal-content">
                    <div class="royal-ai-modal-header">
                        <h3 class="royal-ai-modal-title">
                            <span class="royal-ai-icon">✨</span>
                            Generate Code with AI
                        </h3>
                        <button type="button" class="royal-ai-modal-close">×</button>
                    </div>
                    <div class="royal-ai-modal-body">
                        <div class="royal-ai-templates">
                            <h4>Quick Templates:</h4>
                            <div class="royal-ai-template-grid">
                                <button type="button" class="royal-ai-template" data-template="google-analytics">
                                    📊 Google Analytics
                                </button>
                                <button type="button" class="royal-ai-template" data-template="facebook-pixel">
                                    📘 Facebook Pixel
                                </button>
                                <button type="button" class="royal-ai-template" data-template="custom-css">
                                    🎨 Custom CSS
                                </button>
                                <button type="button" class="royal-ai-template" data-template="javascript">
                                    ⚡ JavaScript
                                </button>
                            </div>
                        </div>
                        <div class="royal-ai-divider">
                            <span>or describe your needs</span>
                        </div>
                        <textarea id="royal-ai-prompt" class="royal-ai-prompt-input" 
                                  placeholder="Describe what code you want to generate...

Examples:
• Google Analytics tracking code for GA4
• Facebook Pixel code with custom events
• Custom CSS for responsive navigation menu
• JavaScript for smooth scrolling to anchors
• Meta tags for SEO optimization"></textarea>
                        <div class="royal-ai-modal-actions">
                            <button type="button" class="royal-ai-cancel-btn">Cancel</button>
                            <button type="button" class="royal-ai-generate-btn">
                                <span class="royal-ai-btn-icon">✨</span>
                                Generate Code
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('body').append(modalHtml);

        // Enhanced modal event handlers
        $('#royal-ai-modal .royal-ai-modal-close, #royal-ai-modal .royal-ai-cancel-btn').on('click', hideAIModal);
        $('#royal-ai-modal .royal-ai-generate-btn').on('click', generateAICode);
        $('#royal-ai-modal .royal-ai-template').on('click', selectAITemplate);
        
        // Close modal on outside click
        $('#royal-ai-modal').on('click', function(e) {
            if (e.target === this) {
                hideAIModal();
            }
        });

        // Close modal on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $('#royal-ai-modal').hasClass('show')) {
                hideAIModal();
            }
        });
    }

    /**
     * Select AI template
     */
    function selectAITemplate() {
        const template = $(this).data('template');
        const prompts = {
            'google-analytics': 'Generate Google Analytics 4 (GA4) tracking code',
            'facebook-pixel': 'Generate Facebook Pixel tracking code with PageView event',
            'custom-css': 'Generate custom CSS for styling elements',
            'javascript': 'Generate JavaScript code for interactive functionality'
        };
        
        $('#royal-ai-prompt').val(prompts[template] || '').focus();
    }

    /**
     * Show AI modal with animation
     */
    function showAIModal() {
        $('#royal-ai-modal').addClass('show');
        $('#royal-ai-prompt').focus();
    }

    /**
     * Hide AI modal with animation
     */
    function hideAIModal() {
        $('#royal-ai-modal').removeClass('show');
        $('#royal-ai-prompt').val('');
        $('.royal-ai-generate-btn').prop('disabled', false).html('<span class="royal-ai-btn-icon">✨</span>Generate Code');
    }

    /**
     * Generate AI code with enhanced feedback
     */
    function generateAICode() {
        const prompt = $('#royal-ai-prompt').val().trim();
        
        if (!prompt) {
            showNotification('Please enter a description for the code you want to generate.', 'error');
            $('#royal-ai-prompt').focus();
            return;
        }

        const $generateBtn = $('.royal-ai-generate-btn');
        $generateBtn.prop('disabled', true).html('<span class="royal-ai-btn-icon">⏳</span>Generating...');

        const data = {
            action: 'royal_snippet_ai_generate',
            prompt: prompt,
            nonce: royalSnippetAdmin.nonce
        };

        $.post(royalSnippetAdmin.ajaxurl, data, function(response) {
            if (response.success) {
                insertGeneratedCode(response.data.code);
                hideAIModal();
                showNotification('Code generated successfully!', 'success');
            } else {
                showNotification(response.data.message || 'Error generating code', 'error');
            }
        }).fail(function() {
            showNotification('Network error occurred', 'error');
        }).always(function() {
            $generateBtn.prop('disabled', false).html('<span class="royal-ai-btn-icon">✨</span>Generate Code');
        });
    }

    /**
     * Insert generated code into editor
     */
    function insertGeneratedCode(code) {
        if (codeEditor) {
            const currentCode = codeEditor.getValue();
            const newCode = currentCode ? currentCode + '\n\n' + code : code;
            codeEditor.setValue(newCode);
            codeEditor.focus();
        } else {
            const $textarea = $('#royal_snippet_content');
            const currentCode = $textarea.val();
            const newCode = currentCode ? currentCode + '\n\n' + code : code;
            $textarea.val(newCode);
        }
    }

    /**
     * Initialize enhanced event handlers
     */
    function initEventHandlers() {
        // Enhanced auto-save functionality
        let saveTimeout;
        
        function autoSave() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(function() {
                if (typeof wp !== 'undefined' && wp.autosave) {
                    wp.autosave.server.triggerSave();
                }
                showSaveIndicator();
            }, 2000);
        }

        function showSaveIndicator() {
            const $indicator = $('.royal-save-indicator');
            if ($indicator.length === 0) {
                $('body').append('<div class="royal-save-indicator">Saved</div>');
            }
            
            $('.royal-save-indicator').addClass('show');
            setTimeout(function() {
                $('.royal-save-indicator').removeClass('show');
            }, 2000);
        }

        // Auto-save on editor change
        if (codeEditor) {
            codeEditor.on('change', autoSave);
        }

        // Auto-save on form field changes
        $('#royal_snippet_location, #royal_snippet_priority').on('change', autoSave);
        $(document).on('change', '.royal-condition-type, .royal-condition-rule, .royal-condition-value', autoSave);

        // Enhanced form validation
        $('form#post').on('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });

        // Keyboard shortcuts
        $(document).on('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.keyCode === 83) {
                e.preventDefault();
                $('form#post').submit();
            }
        });
    }

    /**
     * Enhanced form validation
     */
    function validateForm() {
        const title = $('#title').val().trim();
        const content = codeEditor ? codeEditor.getValue().trim() : $('#royal_snippet_content').val().trim();

        if (!title) {
            showNotification('Please enter a title for your code snippet', 'error');
            $('#title').focus();
            return false;
        }

        if (!content) {
            showNotification('Please enter some code for your snippet', 'error');
            if (codeEditor) {
                codeEditor.focus();
            } else {
                $('#royal_snippet_content').focus();
            }
            return false;
        }

        // Validate conditions
        const conditions = $('#royal-conditions-list .royal-condition-item');
        let hasValidCondition = false;
        
        conditions.each(function() {
            const rule = $(this).find('.royal-condition-rule').val();
            if (rule && rule !== '') {
                hasValidCondition = true;
                return false; // break
            }
        });

        if (conditions.length > 0 && !hasValidCondition) {
            showNotification('Please configure at least one valid display condition or remove empty conditions', 'error');
            return false;
        }

        return true;
    }

    /**
     * Enhanced notification system
     */
    function showNotification(message, type = 'info', duration = 5000) {
        // Remove existing notifications
        $('.royal-notification').remove();

        const icons = {
            success: '✅',
            error: '❌',
            warning: '⚠️',
            info: 'ℹ️'
        };

        const notificationClass = type === 'error' ? 'notice-error' : 
                                 type === 'success' ? 'notice-success' : 
                                 type === 'warning' ? 'notice-warning' : 'notice-info';

        const notification = $(`
            <div class="notice ${notificationClass} is-dismissible royal-notification">
                <p>
                    <span class="royal-notification-icon">${icons[type] || icons.info}</span>
                    ${message}
                </p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
        `);

        $('.wrap h1').after(notification);

        // Auto-dismiss
        if (duration > 0) {
            setTimeout(function() {
                notification.fadeOut(function() {
                    $(this).remove();
                });
            }, duration);
        }

        // Manual dismiss
        notification.find('.notice-dismiss').on('click', function() {
            notification.fadeOut(function() {
                $(this).remove();
            });
        });
    }

    // Export utility functions
    window.RoyalSnippetAdmin = {
        getEditorContent: function() {
            return codeEditor ? codeEditor.getValue() : $('#royal_snippet_content').val();
        },
        setEditorContent: function(content) {
            if (codeEditor) {
                codeEditor.setValue(content);
            } else {
                $('#royal_snippet_content').val(content);
            }
        },
        showNotification: showNotification,
        insertCode: insertGeneratedCode
    };

})(jQuery);

