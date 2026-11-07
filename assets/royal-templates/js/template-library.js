/**
 * Royal Templates Library - JavaScript
 *
 * @package RoyalAddonsForElementor
 */

(function ($) {
    'use strict';

    // Royal Templates Library
    const RoyalTemplatesLibrary = {
        modal: null,
        previewModal: null,
        currentTab: 'pages',
        currentType: 'all',
        currentCategory: 'all',
        currentSearch: '',
        templates: [],
        isLoading: false,
        observerAttached: false,

        /**
         * Initialize
         */
        init: function () {
            this.modal = $('#royal-templates-modal');
            this.previewModal = $('#royal-template-preview-modal');

            this.bindEvents();
            this.addEditorButton();
        },

        /**
         * Add button to Elementor editor
         */
        addEditorButton: function () {
            const self = this;

            // Wait for Elementor to be ready
            if (typeof elementor !== 'undefined') {
                elementor.on('preview:loaded', function () {
                    setTimeout(function () {
                        self.injectStyles();
                        self.setupObserver();
                        self.injectButton();
                    }, 1500);
                });
            }

            // Also try on document ready
            $(document).ready(function () {
                setTimeout(function () {
                    self.injectStyles();
                    self.setupObserver();
                    self.injectButton();
                }, 3000);
            });
        },

        /**
         * Setup MutationObserver to watch for new add section elements
         */
        setupObserver: function () {
            const self = this;

            if (self.observerAttached) return;
            if (typeof elementor === 'undefined' || !elementor.$previewContents) return;

            self.observerAttached = true;

            const iframeBody = elementor.$previewContents.find('body')[0];
            if (!iframeBody) return;

            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.addedNodes.length) {
                        setTimeout(function () {
                            self.injectButton();
                        }, 100);
                    }
                });
            });

            observer.observe(iframeBody, {
                childList: true,
                subtree: true
            });
        },

        /**
         * Inject styles into preview iframe
         */
        injectStyles: function () {
            if (typeof elementor === 'undefined' || !elementor.$previewContents) return;

            // Check if styles already injected
            if (elementor.$previewContents.find('#royal-templates-iframe-styles').length) return;

            const styles = `<style id="royal-templates-iframe-styles">
    .royal-templates-add-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 40px !important;
        height: 40px !important;
        background: #f3bafd!important;
        border-radius: 50% !important;
        cursor: pointer !important;
        margin: 0 5px !important;
        padding: 4px !important;
        vertical-align: middle !important;
        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            filter 0.3s ease !important;
        animation: royalIdlePulse 2.8s ease-in-out infinite;
    }

    .royal-templates-add-btn:hover {
        transform: translateY(-3px) scale(1.12) !important;
        box-shadow: 0 10px 22px rgba(102, 126, 234, 0.45) !important;
        filter: brightness(1.05);
        animation-play-state: paused;
    }

    .royal-templates-add-btn:active {
        transform: scale(0.94) !important;
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.35) !important;
    }

    .royal-templates-add-btn img {
        width: 32px !important;
        height: 32px !important;
        border-radius: 50% !important;
        pointer-events: none;
    }

    @keyframes royalIdlePulse {
        0% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.35);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
        }
    }
</style>`;

            elementor.$previewContents.find('head').append(styles);
        },

        /**
         * Inject button into Elementor
         */
        injectButton: function () {
            const self = this;

            if (typeof elementor === 'undefined' || !elementor.$previewContents) {
                return;
            }

            // Try multiple selectors
            const selectors = [
                '.elementor-add-section-inner',
                '.elementor-add-section-area',
                '#elementor-add-new-section .elementor-add-section-inner',
                '.elementor-add-section'
            ];

            let containers = null;

            for (let i = 0; i < selectors.length; i++) {
                containers = elementor.$previewContents.find(selectors[i]);
                if (containers.length) {
                    break;
                }
            }

            if (!containers || !containers.length) {
                return;
            }

            containers.each(function () {
                const container = $(this);

                // Skip if button already exists
                if (container.find('.royal-templates-add-btn').length) {
                    return;
                }

                // Create button HTML
                const btnHtml = `
                    <div class="elementor-add-section-area-button royal-templates-add-btn" title="Royal Templates">
                        <img src="${royalTemplatesLib.logoUrl}" alt="RT">
                    </div>
                `;

                // Try to find buttons and insert after the first one
                const buttons = container.find('.elementor-add-section-area-button');
                if (buttons.length) {
                    buttons.first().after(btnHtml);
                } else {
                    // Fallback: just prepend to container
                    container.prepend(btnHtml);
                }
            });

            // Bind click events
            elementor.$previewContents.off('click.royalTemplates', '.royal-templates-add-btn');
            elementor.$previewContents.on('click.royalTemplates', '.royal-templates-add-btn', function (e) {
                e.preventDefault();
                e.stopPropagation();
                self.openModal();
            });
        },

        /**
         * Bind events
         */
        bindEvents: function () {
            const self = this;

            // Close modal
            $(document).on('click', '.royal-templates-close, .royal-templates-modal-backdrop', function () {
                self.closeModal();
            });

            // Close preview modal
            $(document).on('click', '.royal-template-preview-close, .royal-template-preview-backdrop', function () {
                self.closePreviewModal();
            });

            // Tab switch
            $(document).on('click', '.royal-templates-tab', function () {
                const tab = $(this).data('tab');
                self.switchTab(tab);
            });

            // Type filter
            $(document).on('click', '.royal-templates-type-btn', function () {
                const type = $(this).data('type');
                self.filterByType(type);
            });

            // Category filter
            $(document).on('change', '#royal-templates-category', function () {
                self.currentCategory = $(this).val();
                self.loadTemplates();
            });

            // Search
            let searchTimeout;
            $(document).on('input', '#royal-templates-search', function () {
                clearTimeout(searchTimeout);
                const query = $(this).val();
                searchTimeout = setTimeout(function () {
                    self.currentSearch = query;
                    self.loadTemplates();
                }, 300);
            });

            // Import template
            $(document).on('click', '.royal-template-import-btn', function () {
                const card = $(this).closest('.royal-template-card');
                const templateId = card.data('id');
                const isPro = card.data('pro');
                self.importTemplate(templateId, isPro);
            });

            // Preview template
            $(document).on('click', '.royal-template-preview-btn', function () {
                const card = $(this).closest('.royal-template-card');
                const templateId = card.data('id');
                const title = card.find('h4').text();
                const previewUrl = card.data('preview');
                self.openPreview(templateId, title, previewUrl);
            });

            // Import from preview
            $(document).on('click', '#royal-preview-import-btn', function () {
                const templateId = $(this).data('id');
                const isPro = $(this).data('pro');
                self.importTemplate(templateId, isPro);
            });

            // Unlock pro
            $(document).on('click', '.royal-template-unlock-btn', function () {
                window.open('https://www.royaltechbd.com/royal-addons-pro/', '_blank');
            });

            // ESC key to close
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    if (self.previewModal.is(':visible')) {
                        self.closePreviewModal();
                    } else if (self.modal.is(':visible')) {
                        self.closeModal();
                    }
                }
            });
        },

        /**
         * Open modal
         */
        openModal: function () {
            this.modal.fadeIn(200);
            $('body').css('overflow', 'hidden');
            this.loadTemplates();
        },

        /**
         * Close modal
         */
        closeModal: function () {
            this.modal.fadeOut(200);
            $('body').css('overflow', '');
        },

        /**
         * Switch tab
         */
        switchTab: function (tab) {
            this.currentTab = tab;
            $('.royal-templates-tab').removeClass('active');
            $(`.royal-templates-tab[data-tab="${tab}"]`).addClass('active');
            this.loadTemplates();
        },

        /**
         * Filter by type
         */
        filterByType: function (type) {
            this.currentType = type;
            $('.royal-templates-type-btn').removeClass('active');
            $(`.royal-templates-type-btn[data-type="${type}"]`).addClass('active');
            this.loadTemplates();
        },

        /**
         * Load templates via AJAX
         */
        loadTemplates: function () {
            const self = this;

            if (this.isLoading) return;
            this.isLoading = true;

            $('#royal-templates-grid').hide();
            $('#royal-templates-empty').hide();
            $('#royal-templates-loading').show();

            $.ajax({
                url: royalTemplatesLib.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'royal_get_templates',
                    nonce: royalTemplatesLib.nonce,
                    tab: this.currentTab,
                    type: this.currentType,
                    category: this.currentCategory,
                    search: this.currentSearch
                },
                success: function (response) {
                    self.isLoading = false;
                    $('#royal-templates-loading').hide();

                    // Debug info
                    if (response.data.debug) {
                        console.log('Royal Templates Debug:', response.data.debug);
                    }

                    if (response.success && response.data.templates.length > 0) {
                        self.templates = response.data.templates;
                        self.renderTemplates();
                        $('#royal-templates-grid').show();
                        $('#royal-templates-count').text(response.data.templates.length);
                    } else {
                        $('#royal-templates-empty').show();
                        $('#royal-templates-count').text('0');
                    }
                },
                error: function () {
                    self.isLoading = false;
                    $('#royal-templates-loading').hide();
                    $('#royal-templates-empty').show();
                }
            });
        },

        /**
         * Render templates grid
         */
        renderTemplates: function () {
            const grid = $('#royal-templates-grid');
            grid.empty();

            this.templates.forEach(function (template) {
                const isPro = template.is_pro || false;
                const isLocked = template.locked || false;
                const badgeClass = isPro ? 'pro' : 'free';
                const badgeText = isPro ? royalTemplatesLib.i18n.pro : royalTemplatesLib.i18n.free;

                let overlayHtml = '';
                if (isLocked) {
                    overlayHtml = `
                        <div class="royal-template-locked">
                            <span class="dashicons dashicons-lock"></span>
                            <button class="royal-template-unlock-btn">
                                <span class="dashicons dashicons-star-filled"></span>
                                ${royalTemplatesLib.i18n.unlock}
                            </button>
                        </div>
                    `;
                } else {
                    overlayHtml = `
                        <div class="royal-template-overlay">
                            <button class="royal-template-import-btn">
                                <span class="dashicons dashicons-download"></span>
                                ${royalTemplatesLib.i18n.import}
                            </button>
                            ${template.preview_url ? `
                                <button class="royal-template-preview-btn">
                                    <span class="dashicons dashicons-visibility"></span>
                                    ${royalTemplatesLib.i18n.preview}
                                </button>
                            ` : ''}
                        </div>
                    `;
                }

                const tags = (template.tags || []).slice(0, 3).map(tag => `<span>${tag}</span>`).join('');

                const cardHtml = `
                    <div class="royal-template-card" data-id="${template.id}" data-pro="${isPro}" data-preview="${template.preview_url || ''}">
                        <div class="royal-template-thumbnail">
                            <img src="${template.thumbnail}" alt="${template.title}" loading="lazy">
                            <span class="royal-template-badge ${badgeClass}">${badgeText}</span>
                            ${overlayHtml}
                        </div>
                        <div class="royal-template-info">
                            <h4>${template.title}</h4>
                            <div class="royal-template-tags">${tags}</div>
                        </div>
                    </div>
                `;

                grid.append(cardHtml);
            });
        },

        /**
         * Import template
         */
        importTemplate: function (templateId, isPro) {
            const self = this;

            // Show loading
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: royalTemplatesLib.i18n.importing,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            $.ajax({
                url: royalTemplatesLib.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'royal_import_template',
                    nonce: royalTemplatesLib.nonce,
                    template_id: templateId,
                    is_pro: isPro
                },
                success: function (response) {
                    if (response.success && response.data.content) {
                        // Import to Elementor
                        self.insertToElementor(response.data.content);

                        self.closeModal();
                        self.closePreviewModal();

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: royalTemplatesLib.i18n.success,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: royalTemplatesLib.i18n.error,
                                text: response.data?.message || 'Unknown error occurred'
                            });
                        } else {
                            alert(royalTemplatesLib.i18n.error + ': ' + (response.data?.message || 'Unknown error'));
                        }
                    }
                },
                error: function (xhr, status, error) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: royalTemplatesLib.i18n.error,
                            text: 'AJAX Error: ' + error
                        });
                    } else {
                        alert(royalTemplatesLib.i18n.error + ': ' + error);
                    }
                },
                timeout: 30000
            });
        },

        /**
         * Insert content to Elementor
         */
        insertToElementor: function (content) {
            if (typeof elementor === 'undefined') {
                console.error('Royal Templates: Elementor not available');
                return;
            }

            try {
                // Method 1: Use getPreviewView().addChildModel (most compatible)
                const previewView = elementor.getPreviewView();
                if (previewView && typeof previewView.addChildModel === 'function') {
                    // content should be an array of elements
                    if (Array.isArray(content)) {
                        content.forEach(function (element) {
                            previewView.addChildModel(element);
                        });
                    } else {
                        previewView.addChildModel(content);
                    }
                    return;
                }

                // Method 2: Use sections collection
                if (elementor.sections && typeof elementor.sections.add === 'function') {
                    if (Array.isArray(content)) {
                        content.forEach(function (element) {
                            elementor.sections.add(element);
                        });
                    } else {
                        elementor.sections.add(content);
                    }
                    return;
                }

                console.error('Royal Templates: No compatible insert method found');
            } catch (error) {
                console.error('Royal Templates: Insert error', error);
            }
        },

        /**
         * Open preview modal
         */
        openPreview: function (templateId, title, previewUrl) {
            if (!previewUrl) return;

            $('#royal-preview-title').text(title);
            $('#royal-preview-iframe').attr('src', previewUrl);
            $('#royal-preview-import-btn').data('id', templateId);

            this.previewModal.fadeIn(200);
        },

        /**
         * Close preview modal
         */
        closePreviewModal: function () {
            this.previewModal.fadeOut(200);
            $('#royal-preview-iframe').attr('src', 'about:blank');
        }
    };

    // Initialize when Elementor is ready
    $(window).on('elementor:init', function () {
        RoyalTemplatesLibrary.init();
    });

    // Also initialize on document ready as fallback
    $(document).ready(function () {
        if ($('#royal-templates-modal').length) {
            RoyalTemplatesLibrary.init();
        }
    });

})(jQuery);
