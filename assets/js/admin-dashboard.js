/**
 * Royal Addons Admin Dashboard JavaScript
 * Enhanced with smooth animations and better UX
 */

// Checkbox functions for bulk selection
function RoyalCheckboxCheckAll() {
    var inputs = document.querySelectorAll('.royalcheckbox');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].checked = true;
    }
}

function RoyalCheckboxUncheckAll() {
    var inputs = document.querySelectorAll('.royalcheckbox');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].checked = false;
    }
}

jQuery.noConflict();
(function ($) {
    $(function () {

        // Tab Handling with smooth animations
        var activeTab = localStorage.getItem('royalActiveTab');
        if (activeTab && activeTab.startsWith('#') && $(activeTab).length > 0 && $('ul.tabs li a[href="' + activeTab + '"]').length > 0) {
            $(".tabcontent").hide();
            $("ul.tabs li").removeClass("active");
            $('ul.tabs li a[href="' + activeTab + '"]').parent().addClass("active");
            $(activeTab).fadeIn(300);
        } else {
            $(".tabcontent").hide();
            $("ul.tabs li:first").addClass("active");
            $(".tabcontent:first").fadeIn(300);
        }

        $("ul.tabs li a").click(function (e) {
            e.preventDefault();

            var $parentLi = $(this).parent();

            // Skip if already active
            if ($parentLi.hasClass("active")) return false;

            $("ul.tabs li").removeClass("active");
            $parentLi.addClass("active");

            var targetTab = $(this).attr("href");
            localStorage.setItem('royalActiveTab', targetTab);

            $(".tabcontent").hide();
            $(targetTab).fadeIn(250);

            return false;
        });

        // Deactivate License with SweetAlert2 confirmation
        $(document).on("click", "#deactivate_license", function (e) {
            e.preventDefault();

            var $btn  = $(this);
            var i18n  = (typeof RoyalAdminConfig !== "undefined" && RoyalAdminConfig.i18n) ? RoyalAdminConfig.i18n : {};

            Swal.fire({
                title:             i18n.deactivate_title       || "Deactivate License?",
                text:              i18n.deactivate_text        || "Are you sure you want to deactivate your license? All Pro features will be disabled.",
                icon:              "warning",
                showCancelButton:  true,
                confirmButtonColor: "#dc2626",
                cancelButtonColor:  "#6b7280",
                confirmButtonText: i18n.deactivate_confirm_btn || "Yes, Deactivate",
                cancelButtonText:  i18n.deactivate_cancel_btn  || "Cancel",
                reverseButtons:    true,
                focusCancel:       true
            }).then(function (result) {
                if ( ! result.isConfirmed ) {
                    return;
                }

                // Show loading popup
                Swal.fire({
                    title:             i18n.deactivating_title || "Deactivating...",
                    text:              i18n.deactivating_text  || "Please wait while your license is being deactivated.",
                    icon:              "info",
                    allowOutsideClick: false,
                    allowEscapeKey:    false,
                    showConfirmButton: false,
                    didOpen: function () {
                        Swal.showLoading();
                    }
                });

                $btn.prop("disabled", true).css("opacity", "0.6");

                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: {
                        action: "royal_deactivate_license",
                        nonce:  (typeof RoyalAdminConfig !== "undefined") ? RoyalAdminConfig.license_nonce : ""
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title:             i18n.deactivated_title || "Deactivated!",
                                text:              response.data.message,
                                icon:              "success",
                                timer:             1800,
                                showConfirmButton: false
                            }).then(function () {
                                window.location.reload();
                            });
                        } else {
                            $btn.prop("disabled", false).css("opacity", "1");
                            Swal.fire({
                                title: i18n.error_title      || "Error",
                                text:  response.data ? response.data.message : (i18n.deactivate_failed || "Deactivation failed."),
                                icon:  "error"
                            });
                        }
                    },
                    error: function () {
                        $btn.prop("disabled", false).css("opacity", "1");
                        Swal.fire({
                            title: i18n.connection_error_title || "Connection Error",
                            text:  i18n.connection_error_text  || "Could not connect. Please try again.",
                            icon:  "error"
                        });
                    }
                });
            });
        });


        // Add smooth hover effect to cards
        $(document).on('mouseenter', '.royal-item-card', function () {
            $(this).css('transform', 'translateY(-4px)');
        }).on('mouseleave', '.royal-item-card', function () {
            $(this).css('transform', 'translateY(0)');
        });

        // Add ripple effect to buttons
        $(document).on('click', '.royal-save-button', function (e) {
            var $button = $(this);
            var ripple = $('<span class="royal-ripple"></span>');
            $button.append(ripple);

            setTimeout(function () {
                ripple.remove();
            }, 600);
        });

        // Keyboard accessibility for tabs
        $("ul.tabs li a").on('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).parent().click();
            }
        });

        // Bulk Actions
        $('.royal-enable-all').on('click', function() {
            var targetClass = $(this).data('target');
            $(targetClass).prop('checked', true);
        });

        $('.royal-disable-all').on('click', function() {
            var targetClass = $(this).data('target');
            $(targetClass).prop('checked', false);
        });

        // Search functionality for widgets and extensions
        $('.royal-item-search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            var $container = $(this).closest('.tabcontent').find('.royalwidgetextensionlist');
            
            $container.find('.royal-item-card').each(function() {
                var text = $(this).text().toLowerCase();
                if (text.indexOf(searchTerm) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

    });
})(jQuery);