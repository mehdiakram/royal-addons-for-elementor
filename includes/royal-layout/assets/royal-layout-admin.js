/* Royal Layout Admin JS — WoodMart-style */
jQuery(function($) {
    'use strict';
    var cfg = window.RoyalLayoutAdmin || {};
    var $template = $('.rl-condition-template');

    // Move "Add layout" button next to the page title h1
    var $btn = $('#rl-add-layout-btn');
    if ($btn.length) {
        var $h1 = $('.wrap > h1, .wrap > .wp-heading-inline').first();
        if ($h1.length) {
            $btn.detach().insertAfter($h1);
        }
    }

    // Conditions that don't need a query search
    var noQueryConditions = [
        'all','shop_page','product_search','product_cats','product_tags','product_brands',
        'checkout_form','checkout_content','cart','empty_cart',
        'blog_search_result','blog_author','blog_date',
        'dashboard','orders','downloads','edit-address','edit-account'
    ];

    /* ── Helpers ──────────────────────────────────────── */
    function cloneConditionRow(layoutType, data) {
        var $clone = $template.find('.rl-condition-row').clone();
        // Keep only the matching type select, remove others
        $clone.find('.rl-cond-type[data-type="' + layoutType + '"]').siblings('.rl-cond-type').remove();
        // If no matching type, use first available
        if (!$clone.find('.rl-cond-type').length) {
            $clone = $template.find('.rl-condition-row').clone();
            $clone.find('.rl-cond-type').not(':first').remove();
        }

        if (data) {
            $clone.find('.rl-cond-comparison').val(data.condition_comparison || 'include');
            $clone.find('.rl-cond-type').val(data.condition_type || 'all');
            // Show query if needed
            var ct = data.condition_type || 'all';
            if (!noQueryConditions.includes(ct) && data.condition_query) {
                var $q = $clone.find('.rl-cond-query');
                $q.show().append('<option value="' + data.condition_query + '" selected>' + (data.condition_query_text || data.condition_query) + '</option>');
                initSelect2($q, ct);
            }
        }

        return $clone;
    }

    function initSelect2($el, queryType) {
        if ($el.data('select2')) $el.select2('destroy');
        $el.attr('data-query-type', queryType);
        $el.select2({
            ajax: {
                url: cfg.ajax_url,
                method: 'POST',
                data: function(params) {
                    return {
                        action: 'royal_layout_conditions_query',
                        nonce: cfg.nonce,
                        query_type: $el.attr('data-query-type'),
                        search: params.term
                    };
                },
                dataType: 'json'
            },
            placeholder: 'Start typing...',
            allowClear: true,
            width: 'resolve'
        });
    }

    function collectConditions($wrapper) {
        var data = [];
        $wrapper.find('.rl-condition-row').each(function() {
            var $row = $(this);
            var cond = {
                condition_comparison: $row.find('.rl-cond-comparison').val(),
                condition_type: $row.find('.rl-cond-type').val(),
                condition_query: $row.find('.rl-cond-query').val() || ''
            };
            if (cond.condition_type) data.push(cond);
        });
        return data;
    }

    /* ── Condition type change ────────────────────────── */
    $(document).on('change', '.rl-cond-type', function() {
        var $row = $(this).closest('.rl-condition-row');
        var ct = $(this).val();
        var $q = $row.find('.rl-cond-query');

        if ($q.data('select2')) { $q.val(''); $q.select2('destroy'); }

        if (noQueryConditions.includes(ct)) {
            $q.hide();
        } else {
            $q.show();
            initSelect2($q, ct);
        }
    });

    /* ── Condition remove ────────────────────────────── */
    $(document).on('click', '.rl-cond-remove', function() {
        var $row = $(this).closest('.rl-condition-row');
        var $wrap = $row.parent();
        if ($wrap.find('.rl-condition-row').length > 1) {
            $row.remove();
        }
    });

    /* ── Create Modal ────────────────────────────────── */
    var createModalHTML =
        '<div class="rl-modal-overlay" id="rl-create-overlay" style="display:none"></div>' +
        '<div class="rl-modal-box" id="rl-create-modal" style="display:none">' +
            '<div class="rl-modal-head"><h2>Create layout</h2><button class="rl-modal-close">&times;</button></div>' +
            '<div class="rl-modal-body">' +
                '<div class="rl-form-field"><label>Layout type</label>' +
                '<select id="rl-create-type"><option value="">Select...</option>';
    $.each(cfg.types || {}, function(k, v) {
        createModalHTML += '<option value="' + k + '">' + v + '</option>';
    });
    createModalHTML += '</select></div>' +
                '<div class="rl-form-field"><label>Layout name</label><input type="text" id="rl-create-name" placeholder="Enter layout name" value="New layout"></div>' +
                '<div class="rl-conditions-section" style="display:none"><label>Conditions</label><div id="rl-create-conditions"></div>' +
                '<a href="javascript:void(0);" class="rl-add-condition-btn" id="rl-create-add-cond">+ Add condition</a></div>' +
                '<div class="rl-modal-msg" id="rl-create-msg"></div>' +
            '</div>' +
            '<div class="rl-modal-foot">' +
                '<button class="button rl-modal-close">Cancel</button>' +
                '<button class="button button-primary" id="rl-create-submit">Create layout</button>' +
            '</div>' +
        '</div>';

    $('body').append(createModalHTML);

    var conditionedTypes = ['single_product','shop_archive','my_account_page','single_post','blog_archive','thank_you_page'];

    $('#rl-add-layout-btn').on('click', function(e) {
        e.preventDefault();
        $('#rl-create-overlay, #rl-create-modal').fadeIn(150);
        $('#rl-create-name').focus();
    });

    $(document).on('click', '#rl-create-overlay, #rl-create-modal .rl-modal-close', function() {
        $('#rl-create-overlay, #rl-create-modal').fadeOut(100);
        $('#rl-create-msg').hide();
    });

    $('#rl-create-type').on('change', function() {
        var type = $(this).val();
        var $condSection = $('.rl-conditions-section');
        var $rows = $('#rl-create-conditions');

        $rows.empty();

        if (type) {
            var typeName = $(this).find('option:selected').text();
            $('#rl-create-name').val(typeName.trim() + ' layout');
        }

        if (conditionedTypes.includes(type)) {
            $condSection.show();
            var $row = cloneConditionRow(type);
            $rows.append($row);
        } else {
            $condSection.hide();
        }
    });

    $('#rl-create-add-cond').on('click', function() {
        var type = $('#rl-create-type').val();
        if (!type) return;
        var $row = cloneConditionRow(type);
        $('#rl-create-conditions').append($row);
    });

    $('#rl-create-submit').on('click', function() {
        var type = $('#rl-create-type').val();
        var name = $.trim($('#rl-create-name').val());
        var $btn = $(this);
        var $msg = $('#rl-create-msg');

        if (!type) { $msg.removeClass('success').addClass('error').text('Please select a layout type.').show(); return; }

        var data = collectConditions($('#rl-create-conditions'));

        $btn.prop('disabled', true).text('Creating...');
        $msg.hide();

        $.post(cfg.ajax_url, {
            action: 'royal_layout_create',
            nonce: cfg.nonce,
            name: name,
            type: type,
            data: data
        }, function(res) {
            if (res.success && res.data.redirect_url) {
                $msg.removeClass('error').addClass('success').text('Success! Redirecting...').show();
                setTimeout(function() { window.location.href = res.data.redirect_url; }, 500);
            } else {
                $msg.removeClass('success').addClass('error').text(res.data && res.data.message ? res.data.message : 'Error').show();
                $btn.prop('disabled', false).text('Create layout');
            }
        }).fail(function() {
            $msg.removeClass('success').addClass('error').text('Error').show();
            $btn.prop('disabled', false).text('Create layout');
        });
    });

    /* ── Edit Conditions Modal ───────────────────────── */
    var editModalHTML =
        '<div class="rl-modal-overlay" id="rl-edit-overlay" style="display:none"></div>' +
        '<div class="rl-modal-box" id="rl-edit-modal" style="display:none;width:620px">' +
            '<div class="rl-modal-head"><h2>Edit conditions</h2><button class="rl-modal-close">&times;</button></div>' +
            '<div class="rl-modal-body">' +
                '<input type="hidden" id="rl-edit-post-id">' +
                '<input type="hidden" id="rl-edit-layout-type">' +
                '<div id="rl-edit-conditions"></div>' +
                '<a href="javascript:void(0);" class="rl-add-condition-btn" id="rl-edit-add-cond">+ Add condition</a>' +
                '<div class="rl-modal-msg" id="rl-edit-msg"></div>' +
            '</div>' +
            '<div class="rl-modal-foot">' +
                '<button class="button rl-modal-close">Cancel</button>' +
                '<button class="button button-primary" id="rl-edit-save">Save conditions</button>' +
            '</div>' +
        '</div>';

    $('body').append(editModalHTML);

    $(document).on('click', '.rl-edit-cond-btn', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var id = $btn.data('id');
        var type = $btn.data('type');
        var conditions = $btn.data('conditions') || [];

        $('#rl-edit-post-id').val(id);
        $('#rl-edit-layout-type').val(type);

        var $rows = $('#rl-edit-conditions').empty();

        if (conditions.length) {
            $.each(conditions, function(i, cond) {
                var $row = cloneConditionRow(type, cond);
                $rows.append($row);
            });
        } else {
            $rows.append(cloneConditionRow(type));
        }

        $('#rl-edit-overlay, #rl-edit-modal').fadeIn(150);
    });

    $(document).on('click', '#rl-edit-overlay, #rl-edit-modal .rl-modal-close', function() {
        $('#rl-edit-overlay, #rl-edit-modal').fadeOut(100);
        $('#rl-edit-msg').hide();
    });

    $('#rl-edit-add-cond').on('click', function() {
        var type = $('#rl-edit-layout-type').val();
        if (!type) return;
        var $row = cloneConditionRow(type);
        $('#rl-edit-conditions').append($row);
    });

    $('#rl-edit-save').on('click', function() {
        var $btn = $(this);
        var id = $('#rl-edit-post-id').val();
        var data = collectConditions($('#rl-edit-conditions'));
        var $msg = $('#rl-edit-msg');

        $btn.prop('disabled', true).text('Saving...');

        $.post(cfg.ajax_url, {
            action: 'royal_layout_save_conditions',
            nonce: cfg.nonce,
            id: id,
            data: data
        }, function(res) {
            $btn.prop('disabled', false).text('Save conditions');
            if (res.success) {
                // Update the button data and summary text
                var $editBtn = $('.rl-edit-cond-btn[data-id="' + id + '"]');
                $editBtn.data('conditions', data);
                $editBtn.siblings('.rl-cond-text').text(res.data.summary);
                $msg.removeClass('error').addClass('success').text('Conditions saved!').show();
                setTimeout(function() {
                    $('#rl-edit-overlay, #rl-edit-modal').fadeOut(100);
                    $msg.hide();
                }, 800);
            } else {
                $msg.removeClass('success').addClass('error').text('Error saving').show();
            }
        }).fail(function() {
            $btn.prop('disabled', false).text('Save conditions');
            $msg.removeClass('success').addClass('error').text('Error').show();
        });
    });

    /* ── Toggle Status ───────────────────────────────── */
    $(document).on('change', '.rl-toggle-input', function() {
        var $input = $(this);
        var id = $input.data('id');
        var $label = $input.siblings('.rl-toggle-slider').find('.rl-toggle-label');

        $input.prop('disabled', true);
        $label.text('...');

        $.post(cfg.ajax_url, {
            action: 'royal_layout_toggle_status',
            nonce: cfg.nonce,
            id: id
        }, function(res) {
            $input.prop('disabled', false);
            if (res.success) {
                var isOn = res.data.status === 'publish';
                $input.prop('checked', isOn);
                $label.text(isOn ? 'ON' : 'OFF');
            }
        });
    });

    /* ── Metabox conditions (edit post screen) ────────── */
    var $metabox = $('.rl-metabox-conditions');
    if ($metabox.length) {
        var mType = $metabox.data('type');
        var mConditions = $metabox.data('conditions') || [];
        var $mRows = $metabox.find('.rl-metabox-condition-rows');

        if (mConditions.length) {
            $.each(mConditions, function(i, cond) {
                $mRows.append(cloneConditionRow(mType, cond));
            });
        } else {
            $mRows.append(cloneConditionRow(mType));
        }

        $metabox.find('.rl-metabox-add-condition').on('click', function() {
            $mRows.append(cloneConditionRow(mType));
        });

        $metabox.find('.rl-metabox-save-conditions').on('click', function() {
            var $btn = $(this);
            var id = $metabox.data('id');
            var data = collectConditions($mRows);

            $btn.prop('disabled', true).text('Saving...');

            $.post(cfg.ajax_url, {
                action: 'royal_layout_save_conditions',
                nonce: cfg.nonce,
                id: id,
                data: data
            }, function(res) {
                $btn.prop('disabled', false).text('Save conditions');
                if (res.success) {
                    $btn.text('Saved ✓');
                    setTimeout(function() { $btn.text('Save conditions'); }, 1500);
                }
            });
        });
    }

    /* ── Escape to close ─────────────────────────────── */
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            $('#rl-create-overlay, #rl-create-modal, #rl-edit-overlay, #rl-edit-modal').fadeOut(100);
        }
    });
});
