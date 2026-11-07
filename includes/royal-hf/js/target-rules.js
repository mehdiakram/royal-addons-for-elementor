(function ($) {
    'use strict';

    var RoyalHF_Target_Rules = {
        init: function () {
            this._bind();
            this._initExclusionRules();
            this._toggleMetaFields();
            $('.royal-hf-target-rule-select').each(this._handleRuleChange); // Initial check on page load for existing rules
        },

        _initExclusionRules: function() {
            var exclusionWrapper = $('.royal-hf-exclusion-rules-wrapper');
            if (exclusionWrapper.find('.rules-wrapper .royal-hf-target-rule-condition').length) {
                exclusionWrapper.show();
                $('.add-exclusion-rule').hide();
            }
        },

        _toggleMetaFields: function() {
            var templateType = $('#royal_template_type').val();
            if (templateType === 'custom_block') {
                $('.royal-hf-display-rules-wrapper').hide();
                $('.royal-hf-shortcode-wrapper').show();
            } else {
                $('.royal-hf-display-rules-wrapper').show();
                $('.royal-hf-shortcode-wrapper').hide();
            }
        },

        _initSpecificsSearch: function(selector) {
            selector.select2({
                placeholder: royalHfTargetRules.search_placeholder,
                minimumInputLength: 2,
                ajax: {
                    url: royalHfTargetRules.ajax_url,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            action: 'royal_hf_get_specific_posts_by_query',
                            nonce: royalHfTargetRules.nonce
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    },
                    cache: true
                }
            });
        },
        
        _handleRuleChange: function() {
            var $this = $(this);
            var $wrapper = $this.closest('.royal-hf-target-rule-condition');
            var $specificsWrapper = $wrapper.find('.royal-hf-specifics-search-wrapper');
            var $specificsSelect = $specificsWrapper.find('.royal-hf-specifics-search');

            if ($this.val() === 'specifics') {
                $specificsWrapper.show();
                if (!$specificsSelect.data('select2')) {
                    RoyalHF_Target_Rules._initSpecificsSearch($specificsSelect);
                }
            } else {
                $specificsWrapper.hide();
            }
        },

        _bind: function () {
            $(document).on('change', '#royal_template_type', this._toggleMetaFields);
            $(document).on('change', '.royal-hf-target-rule-select', this._handleRuleChange);
            $(document).on('click', '.add-display-rule', this._addDisplayRule);
            $(document).on('click', '.add-exclusion-rule', this._addExclusionRule);
            $(document).on('click', '.add-user-rule', this._addUserRule);
            $(document).on('click', '.target-rule-condition-delete', this._deleteRule);
        },

        _addDisplayRule: function (e) {
            e.preventDefault();
            var $this = $(this);
            var $parent = $this.closest('td');
            var template = wp.template('royal-hf-location-rule-template');
            $parent.find('.rules-wrapper').append(template());
        },

        _addExclusionRule: function (e) {
            e.preventDefault();
            var $this = $(this);
            $('.royal-hf-exclusion-rules-wrapper').show();
            var template = wp.template('royal-hf-exclusion-rule-template');
            $('.royal-hf-exclusion-rules-wrapper').find('.rules-wrapper').append(template());
            $this.hide();
        },

        _addUserRule: function (e) {
            e.preventDefault();
            var $this = $(this);
            var $parent = $this.closest('td');
            var template = wp.template('royal-hf-user-rule-template');
            $parent.find('.rules-wrapper').append(template());
        },

        _deleteRule: function (e) {
            e.preventDefault();
            var $this = $(this);
            var $wrapper = $this.closest('.rules-wrapper');
            $this.closest('.royal-hf-target-rule-condition').remove();
            
            if ($wrapper.closest('.royal-hf-exclusion-rules-wrapper').length && $wrapper.find('.royal-hf-target-rule-condition').length === 0) {
                $('.royal-hf-exclusion-rules-wrapper').hide();
                $('.add-exclusion-rule').show();
            }
        }
    };

    $(function () {
        RoyalHF_Target_Rules.init();
    });

})(jQuery);
