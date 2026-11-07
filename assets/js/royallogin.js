(function ($) {
    'use strict';

    function RoyalLoginWidget(element) {
        this.$el       = $(element);
        this.$form     = this.$el.find('.royal-login-form');
        this.$btn      = this.$el.find('.royal-login-submit-btn');
        this.$error    = this.$el.find('.royal-login-error');
        this.$errorMsg = this.$el.find('.royal-login-error-text');

        this.ajaxUrl     = (typeof royal_login_params !== 'undefined') ? royal_login_params.ajaxurl : '/wp-admin/admin-ajax.php';
        this.errorMode   = this.$form.data('error-mode')   || 'normal';
        this.successMode = this.$form.data('success-mode') || 'normal';

        this.init();
    }

    RoyalLoginWidget.prototype.init = function () {
        var self = this;
        this.$form.on('submit', function (e) {
            e.preventDefault();
            self.handleSubmit();
        });
    };

    RoyalLoginWidget.prototype.handleSubmit = function () {
        var self = this;

        // Clear previous error
        this.clearError();

        // Set loading state
        this.$btn.addClass('is-loading').prop('disabled', true);

        var loginData = {
            action        : 'royal_login_ajax',
            nonce         : this.$form.data('nonce'),
            username      : this.$form.find('input[name="rl_username"]').val(),
            password      : this.$form.find('input[name="rl_password"]').val(),
            remember      : this.$form.find('input[name="rl_remember"]').is(':checked') ? 1 : 0,
            allowed_roles : JSON.stringify( this.$form.data('allowed-roles') || ['all'] ),
            error_msg     : this.$form.data('error-msg') || '',
            redirect      : this.$form.data('redirect') || window.location.href,
        };

        $.ajax({
            url      : this.ajaxUrl,
            type     : 'POST',
            data     : loginData,
            success  : function (response) {
                self.$btn.removeClass('is-loading').prop('disabled', false);

                if (response.success) {
                    self.onSuccess(response.data);
                } else {
                    self.onError(response.data ? response.data.message : 'Login failed.');
                }
            },
            error: function () {
                self.$btn.removeClass('is-loading').prop('disabled', false);
                self.onError('An unexpected error occurred. Please try again.');
            }
        });
    };

    RoyalLoginWidget.prototype.onSuccess = function (data) {
        if (this.successMode === 'popup' && typeof Swal !== 'undefined') {
            var redirectUrl = data.redirect || window.location.href;
            Swal.fire({
                icon             : 'success',
                title            : data.success_title  || 'Welcome!',
                text             : data.success_message || 'You have been logged in successfully.',
                confirmButtonText: 'Continue',
                confirmButtonColor: '#667eea',
                timer            : 2000,
                timerProgressBar : true,
                showConfirmButton: true,
            }).then(function () {
                window.location.href = redirectUrl;
            });
        } else {
            // Normal redirect
            window.location.href = data.redirect || window.location.href;
        }
    };

    RoyalLoginWidget.prototype.onError = function (message) {
        if (this.errorMode === 'popup' && typeof Swal !== 'undefined') {
            Swal.fire({
                icon             : 'error',
                title            : 'Login Failed',
                text             : message,
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#ef4444',
            });
        } else {
            // Normal inline error
            this.$errorMsg.text(message);
            this.$error.addClass('is-visible');
            // Scroll to error smoothly
            this.$error[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    };

    RoyalLoginWidget.prototype.clearError = function () {
        this.$error.removeClass('is-visible');
        this.$errorMsg.text('');
    };

    // ---- Elementor Widget Handler ----
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/royal-login.default',
            function ($scope) {
                new RoyalLoginWidget($scope);
            }
        );
    });

    // Fallback for non-Elementor usage
    $(document).ready(function () {
        if (typeof elementorFrontend === 'undefined') {
            $('.royal-login-widget').each(function () {
                new RoyalLoginWidget(this);
            });
        }
    });

})(jQuery);
