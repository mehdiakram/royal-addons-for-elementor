var RoyalPopupHandler = function ($scope, $) {
    var popupWrapper = $scope.find('.royal-popup');
    if (!popupWrapper.length) return;

    var body = $('body');
    if (body.hasClass('elementor-editor-active')) {
        return;
    }

    var trigger = popupWrapper.data('trigger');
    var entranceAnimation = 'animate__' + popupWrapper.data('animation-in');
    var exitAnimation = 'animate__' + popupWrapper.data('animation-out');
    var exitDuration = popupWrapper.data('animation-out-duration') || 500;
    var popupId = popupWrapper.data('popup-id');

    // Responsive: check hide on mobile (< 768px)
    var hideOnMobile = popupWrapper.data('hide-mobile') === 'yes';
    if (hideOnMobile && $(window).width() < 768) {
        return;
    }

    // Cookie & session management
    var enableCookie = popupWrapper.data('enable-cookie') !== 'no';
    var cookiePerPage = popupWrapper.data('cookie-per-page') === 'yes';
    var cookieName = 'royal_popup_visited_' + popupId;
    if (cookiePerPage) {
        var pageSlug = window.location.pathname.replace(/[^a-zA-Z0-9]/g, '_') || 'home';
        cookieName += '_' + pageSlug;
    }
    
    var contentWrapper = popupWrapper.find('.royal-popup__content');
    var closeButton = popupWrapper.find('.royal-popup__close');
    var autoCloseTimer;
    var inactivityTimer;

    var getCookie = function(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null;
    };
    
    var setCookie = function() {
        if (!enableCookie) return;
        var unit = popupWrapper.data('cookie-time-unit');
        if (unit === 'session') {
            document.cookie = cookieName + "=true; path=/";
            return;
        }
        var time = popupWrapper.data('cookie-time');
        if (typeof time === 'undefined' || typeof unit === 'undefined') return;
        var expires = "";
        var date = new Date();
        var multiplier = 1;
        if (unit === 'hours') multiplier = 60;
        if (unit === 'days') multiplier = 60 * 24;
        date.setTime(date.getTime() + (time * multiplier * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
        document.cookie = cookieName + "=true" + expires + "; path=/";
    };

    var showPopup = function() {
        if (popupWrapper.hasClass('show')) return;
        
        contentWrapper.removeClass('animate__animated ' + entranceAnimation + ' ' + exitAnimation);
        
        // Remove inline display:none (FOUC protection) before showing
        popupWrapper.css('display', '');

        body.addClass('royal-popup-is-active');
        popupWrapper.addClass('show');

        if (entranceAnimation && entranceAnimation !== 'animate__none') {
            contentWrapper.addClass('animate__animated ' + entranceAnimation);
        }

        var autoCloseDelay = popupWrapper.data('auto-close');
        if (autoCloseDelay) {
            autoCloseTimer = setTimeout(hidePopup, autoCloseDelay * 1000);
        }
        var closeButtonDelay = popupWrapper.data('close-button-delay');
        if (closeButtonDelay) {
            closeButton.addClass('is-delayed');
            setTimeout(function() { closeButton.addClass('is-visible'); }, closeButtonDelay * 1000);
        }
    };

    var hidePopup = function() {
        if (!popupWrapper.hasClass('show')) return;
        clearTimeout(autoCloseTimer);
        
        if (trigger !== 'on_click' && enableCookie) {
            setCookie();
        }
        
        body.removeClass('royal-popup-is-active');

        if (exitAnimation && exitAnimation !== 'animate__none') {
            contentWrapper.removeClass(entranceAnimation).addClass('animate__animated ' + exitAnimation);
            
            setTimeout(function() {
                popupWrapper.removeClass('show');
                contentWrapper.removeClass('animate__animated ' + exitAnimation); 
            }, exitDuration);
        } else {
            popupWrapper.removeClass('show');
        }
    };

    if (trigger !== 'on_click' && enableCookie && getCookie(cookieName)) {
        return;
    }

    if (trigger === 'onload') {
        var onloadDelay = parseInt(popupWrapper.data('onload-delay'), 10) || 0;
        var triggerOnload = function() {
            if (onloadDelay > 0) {
                setTimeout(showPopup, onloadDelay * 1000);
            } else {
                showPopup();
            }
        };

        if (document.readyState === 'complete') {
            triggerOnload();
        } else {
            $(window).on('load', triggerOnload);
        }
    } 
    else if (trigger === 'after_scroll') {
        var scrollTargetPercent = parseInt(popupWrapper.data('scroll-progress'), 10) || 50;
        var scrollEventName = 'scroll.royalPopupScroll_' + popupId;
        var onScrollHandler = function() {
            var scrollTop = $(window).scrollTop();
            var docHeight = $(document).height() - $(window).height();
            if (docHeight > 0) {
                var currentScrollPercent = (scrollTop / docHeight) * 100;
                if (currentScrollPercent >= scrollTargetPercent) {
                    showPopup();
                    $(window).off(scrollEventName);
                }
            }
        };
        $(window).on(scrollEventName, onScrollHandler);
    }
    else if (trigger === 'inactivity') {
        var inactivityDelay = (parseInt(popupWrapper.data('inactivity-delay'), 10) || 10) * 1000;
        var inactivityEventName = '.royalInactivity_' + popupId;
        var resetInactivity = function() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(function() {
                showPopup();
                $(document).off(inactivityEventName);
            }, inactivityDelay);
        };
        resetInactivity();
        $(document).on('mousemove' + inactivityEventName + ' keydown' + inactivityEventName + ' scroll' + inactivityEventName + ' touchstart' + inactivityEventName, resetInactivity);
    }
    else if (trigger === 'exit_intent') {
        var exitEventName = 'mouseout.royalPopup_' + popupId;
        $(document).on(exitEventName, function(e) {
            if (e.clientY <= 0) {
                showPopup();
                $(document).off(exitEventName);
            }
        });
    } 
    else if (trigger === 'on_click') {
        $scope.find('.royal-popup-trigger-button').on('click', function(e) {
            e.preventDefault();
            showPopup();
        });
    }

    // Default close button
    closeButton.on('click', hidePopup);

    // Custom close elements inside template (.royal-popup-close-btn or [data-royal-popup-close])
    popupWrapper.on('click', '.royal-popup-close-btn, [data-royal-popup-close]', function(e) {
        e.preventDefault();
        hidePopup();
    });

    // Close on overlay
    if (popupWrapper.data('close-on-overlay') !== 'no') {
        popupWrapper.find('.royal-popup__overlay').on('click', hidePopup);
    }

    // Close on ESC key
    if (popupWrapper.data('close-on-esc') !== 'no') {
        var escEventName = 'keydown.royalPopupEsc_' + popupId;
        $(document).on(escEventName, function(e) {
            if (e.key === "Escape" && popupWrapper.hasClass('show')) {
                hidePopup();
            }
        });
    }
};

jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/royalpopup.default', RoyalPopupHandler);
});
