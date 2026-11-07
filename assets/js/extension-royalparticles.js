(function ($) {
    'use strict';

    var RoyalParticlesHandler = function ($scope) {
        // --- NEW: Find the data source for both editor and live frontend ---
        var $editorWrapper = $scope.find('.royal-background-preview-wrapper');
        var configString;

        if ($editorWrapper.length && typeof $editorWrapper.attr('data-royal-particles-config') !== 'undefined') {
            configString = $editorWrapper.attr('data-royal-particles-config');
        } else {
            configString = $scope.attr('data-royal-particles-config');
        }
        // --------------------------------------------------------------------

        var particlesId = 'royal-particles-container-' + $scope.data('id');
        
        // Cleanup old instances
        var oldContainer = tsParticles.dom().find(c => c.id === particlesId);
        if (oldContainer) {
            oldContainer.destroy();
        }
        $scope.find('#' + particlesId).remove();
        $('body').find('#' + particlesId).remove();

        if (typeof configString === 'undefined' || configString === '') {
            return;
        }

        var config = JSON.parse(configString);
        var particlesOptions = config.style || {};
        
        particlesOptions.fullScreen = {
            enable: false
        };

        var $particlesContainer = $('<div />')
            .attr('id', particlesId)
            .addClass('royal-particles-wrapper')
            .css('z-index', config.zindex || 0);

        if (config.scope === 'fullscreen') {
            $particlesContainer.addClass('royal-particles-fullscreen');
            $('body').prepend($particlesContainer); // Append to body for fullscreen
        } else {
            $scope.css('position', 'relative');
            $scope.prepend($particlesContainer); // Append to element for contained
        }

        tsParticles.load({
            id: particlesId,
            options: particlesOptions
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/section', RoyalParticlesHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/container', RoyalParticlesHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/column', RoyalParticlesHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/div-block', RoyalParticlesHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/e-div-block', RoyalParticlesHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/e-flexbox', RoyalParticlesHandler);
    });
})(jQuery);