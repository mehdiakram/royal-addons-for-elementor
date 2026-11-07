// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/admin/assets/admin/js/royal-mega-menu-admin.js
(function($){

    window.RoyalMegaMenuAdmin = {

        init: function() {
             $( document )
                 .on( 'click.RoyalMegaMenuAdmin', '.save-royal-mega-menu', this.saveGlobalMenuOptions )
                 .on( 'click.RoyalMegaMenuAdmin', '.royal-mega-menu-opener', this.openMegaMenuModal )
                 .on( 'click.RoyalMegaMenuAdmin', '.royal-mega-menu-modal-closer', this.closeMegaMenuModal )
                 .on( 'click.RoyalMegaMenuAdmin', '.save-royal-menu-item-options', this.updateRoyalMenuItemSettings )
                 .on( 'click.RoyalMegaMenuAdmin', '.disable-royal-mega-menu-item', this.disableRoyalMenuItemSettings )
                 ;
        },
        openMegaMenuModal: function () {
            $('#royal-mega-menu-setting-modal').css('display', 'flex');
            $('#royal-mega-menu-setting-modal #tabs-nav li').removeClass('active');
            $('#royal-mega-menu-setting-modal #tabs-nav li:first-child').addClass('active'); // Activate first tab by default
            $('#royal-mega-menu-setting-modal .tab-content').hide();
            $('#royal-mega-menu-setting-modal .tab-content:first').show(); // Show first tab content

            let menuItemId = $(this).attr('data-menu_item_id');
            $('.save-royal-menu-item-options').attr('data-menu_item_id', menuItemId);
            $('.disable-royal-mega-menu-item').attr('data-menu_item_id', menuItemId);
            RoyalMegaMenuAdmin.showModalAjaxLoader();
            RoyalMegaMenuAdmin.getMenuItemOptions(menuItemId);
        },
        closeMegaMenuModal: function () {
            $('#royal-mega-menu-setting-modal').css('display', 'none');
        },
        showModalAjaxLoader: function () {
            $('#royal-mega-menu-setting-modal .ajax-loader').css('display', 'flex');
        },
        hideModalAjaxLoader: function () {
            $('#royal-mega-menu-setting-modal .ajax-loader').css('display', 'none');
        },
        getMenuItemOptions: function (menu_item_id) {
            $.ajax({
                type: 'POST',
                url: royal_mega_menu_ajax.ajaxurl,
                data: {
                    action: "royal_get_menu_options",
                    menu_item_id: menu_item_id,
                    nonce: royal_mega_menu_ajax.nonce,
                },
                cache: false,
                success: function(response) {
                    $('#royal-mega-menu-setting-modal .tab-contents-wrapper').html(response);
                    RoyalMegaMenuAdmin.hideModalAjaxLoader();
                }
            });
        },
        saveGlobalMenuOptions: function( that ){
            var spinner = $(this).parent().parent().find('.ajax-loader');
            spinner.addClass('show');

            let menu_id = $("#nav-menu-meta-object-id").val();

            var settings = {
                    'enable_menu': $(".royal_mega_menu_switch").is(':checked') === true  ? 'on' : 'off'
                };

            $.ajax({
                type: 'POST',
                url: royal_mega_menu_ajax.ajaxurl,
                data: {
                    action          : "royal_update_menu_options",
                    actualAction    : 'saveMenuOptions',
                    settings        : settings,
                    menu_id         : menu_id,
                    nonce : royal_mega_menu_ajax.nonce,
                },
                cache: false,
                success: function(response) {
                    location.reload();
                }
            });

        },
        updateRoyalMenuItemSettings: function( that ){

            let footerAction = $(this).attr('data-action');
            RoyalMegaMenuAdmin.showModalAjaxLoader();
            let menu_id = $("#nav-menu-meta-object-id").val();
            let menu_item_id = $(this).attr('data-menu_item_id');

            let status_form = $('#royal-mega-menu-setting-modal .form-status');

            let css = {};
            let settings = {};

            $('#royal_mega_menu_items_settings').find('input, select').each(function() {
                if ($(this).attr('type') !== 'submit') {
                    settings[$(this).attr('name')] = $(this).val();
                }
            });

            $('#royal_mega_menu_items_css').find('input, select').each(function() {
                if ($(this).attr('type') !== 'submit') {
                    css[$(this).attr('name')] = $(this).val();
                }
            });


            $.ajax({
                type: 'POST',
                url: royal_mega_menu_ajax.ajaxurl,
                data: {
                    action          : "royal_update_menu_options",
                    actualAction    : 'saveMenuItemSettings',
                    settings        : settings,
                    css             : css,
                    menu_id         : menu_id,
                    menu_item_id    : menu_item_id,
                    nonce : royal_mega_menu_ajax.nonce,
                },
                cache: false,
                success: function(response) {

                    if(response.success == true){
                        $(status_form).html('<span class="royal-text-success">Settings Saved!</span>');
                        setTimeout(() => {
                            $(status_form).html('');
                        }, 2000);
                        RoyalMegaMenuAdmin.hideModalAjaxLoader();
                        if(footerAction == 'save-close') {
                            RoyalMegaMenuAdmin.closeMegaMenuModal();
                            location.reload();
                        } else {
                            // Update the menu item button to show it has mega menu content
                            $('.royal-mega-menu-opener[data-menu_item_id="'+menu_item_id+'"]').addClass('has-mega-menu-content');
                        }
                    }

                }
            });

        },
        disableRoyalMenuItemSettings: function( that ){
            RoyalMegaMenuAdmin.showModalAjaxLoader($(this));
            let menu_id = $("#nav-menu-meta-object-id").val();
            let menu_item_id = $(this).attr('data-menu_item_id');
            let status_form = $('#royal-mega-menu-setting-modal .form-status');

            $.ajax({
                type: 'POST',
                url: royal_mega_menu_ajax.ajaxurl,
                data: {
                    action          : "royal_delete_menu_options",
                    menu_id         : menu_id, // menu_id might not be strictly needed for delete_post_meta but included for consistency
                    menu_item_id    : menu_item_id,
                    nonce : royal_mega_menu_ajax.nonce,
                },
                cache: false,
                success: function(response) {
                    if(response.success == true){
                        $(status_form).html('<span class="royal-text-success">Settings Deleted!</span>');
                        setTimeout(() => {
                            $(status_form).html('');
                            location.reload();
                        }, 2000);
                        RoyalMegaMenuAdmin.hideModalAjaxLoader($(this));
                    }

                }
            });
        },
    }

 })(jQuery); // Close the immediate anonymous function

// This jQuery(document).ready block was moved from menu-metabox.php
// and updated to use .on('click', ...)
jQuery(document).ready(function($) {
    // Init the main RoyalMegaMenuAdmin
    RoyalMegaMenuAdmin.init();

    // Show the first tab and hide the rest
    $('div#royal-mega-menu-setting-modal #tabs-nav li:first-child').addClass('active');
    $('div#royal-mega-menu-setting-modal .tab-content').hide();
    $('div#royal-mega-menu-setting-modal .tab-content:first').show();

    // Click function for tabs (updated to .on)
    $('div#royal-mega-menu-setting-modal #tabs-nav li').on('click', function(){ // Changed .click() to .on('click')
        $('div#royal-mega-menu-setting-modal #tabs-nav li').removeClass('active');
        $(this).addClass('active');
        $('div#royal-mega-menu-setting-modal .tab-content').hide();

        var activeTab = $(this).find('a').attr('href');
        $(activeTab).fadeIn();
        return false;
    });

    //Change Edit url when change template
    $(document).on('change', 'select#royal-template-select', function () {
        let templateId = $(this).val();
        let newEditLink = royal_mega_menu_ajax.adminURL+'post.php?post='+templateId+'&action=elementor';
        $('a#edit-royal-selected-template').attr('href', newEditLink);
    })
});