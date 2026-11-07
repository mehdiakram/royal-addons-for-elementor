var RoyalPopupHandler = function ($scope, $) {
    var popupWrapper = $scope.find('.royal-popup');
    if (!popupWrapper.length) return;

    var trigger = popupWrapper.data('trigger');
    var entranceAnimation = 'animate__' + popupWrapper.data('animation-in');
    var exitAnimation = 'animate__' + popupWrapper.data('animation-out');
    var exitDuration = popupWrapper.data('animation-out-duration') || 500;
    var cookieName = 'royal_popup_visited_' + popupWrapper.data('popup-id');
    
    var body = $('body');
    var contentWrapper = popupWrapper.find('.royal-popup__content');
    var closeButton = popupWrapper.find('.royal-popup__close');
    var autoCloseTimer;

    var getCookie = function(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
        return null;
    };
    
    var setCookie = function() {
        var time = popupWrapper.data('cookie-time');
        var unit = popupWrapper.data('cookie-time-unit');
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
        
        if (trigger !== 'on_click') {
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
    
    if (body.hasClass('elementor-editor-active')) {
        return;
    }

    if (trigger !== 'on_click' && getCookie(cookieName)) {
        return;
    }

    if (trigger === 'onload') {
        $(window).on('load', showPopup);
    } 
    else if (trigger === 'exit_intent') {
        $(document).on('mouseout.royalPopup', function(e) {
            if (e.clientY <= 0) {
                showPopup();
                $(document).off('mouseout.royalPopup');
            }
        });
    } 
    else if (trigger === 'on_click') {
        $scope.find('.royal-popup-trigger-button').on('click', function(e) {
            e.preventDefault();
            showPopup();
        });
    }

    closeButton.on('click', hidePopup);
    popupWrapper.find('.royal-popup__overlay').on('click', hidePopup);
    $(document).on('keydown', function(e) {
        if (e.key === "Escape" && popupWrapper.hasClass('show')) {
            hidePopup();
        }
    });
};

jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/royalpopup.default', RoyalPopupHandler);
});