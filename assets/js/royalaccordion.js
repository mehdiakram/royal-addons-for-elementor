(function ($) {
    "use strict";

    var RoyalAccordionHandler = function ($scope, $) {
        var $wrapper = $scope.hasClass('royalaccwrapper') ? $scope : $scope.find('.royalaccwrapper');
        if (!$wrapper.length) {
            return;
        }

        var isMultiple = $wrapper.data('multiple') === true || $wrapper.data('multiple') === 'true' || $wrapper.data('multiple') === 'multiple';
        var isCollapsible = $wrapper.data('collapsible') !== false && $wrapper.data('collapsible') !== 'false';
        var duration = parseInt($wrapper.data('duration'), 10);
        if (isNaN(duration)) {
            duration = 300;
        }

        // Toggle click handler
        $wrapper.off('click', '.royalaccitemheading').on('click', '.royalaccitemheading', function (e) {
            e.preventDefault();
            var $heading = $(this);
            var $item = $heading.closest('.royalaccitem');
            var $content = $item.find('.royalaccitemcontent');
            var isActive = $heading.hasClass('ui-accordion-header-active');

            if (isActive) {
                if (isCollapsible) {
                    $heading.removeClass('ui-accordion-header-active').addClass('ui-accordion-header-collapsed').attr('aria-expanded', 'false');
                    $item.removeClass('royalacc-active');
                    $content.stop(true, true).slideUp(duration, function () {
                        $(this).removeClass('ui-accordion-content-active');
                    });
                }
            } else {
                if (!isMultiple) {
                    var $otherItems = $wrapper.find('.royalaccitem').not($item);
                    $otherItems.removeClass('royalacc-active');
                    $otherItems.find('.royalaccitemheading').removeClass('ui-accordion-header-active').addClass('ui-accordion-header-collapsed').attr('aria-expanded', 'false');
                    $otherItems.find('.royalaccitemcontent').stop(true, true).slideUp(duration, function () {
                        $(this).removeClass('ui-accordion-content-active');
                    });
                }

                $heading.removeClass('ui-accordion-header-collapsed').addClass('ui-accordion-header-active').attr('aria-expanded', 'true');
                $item.addClass('royalacc-active');
                $content.stop(true, true).slideDown(duration, function () {
                    $(this).addClass('ui-accordion-content-active');

                    // Trigger resize so any nested widgets (sliders, maps, etc.) re-render properly
                    if (typeof elementorFrontend !== 'undefined') {
                        $content.find('.elementor-element').each(function () {
                            elementorFrontend.elementsHandler.runReadyTrigger($(this));
                        });
                        $(window).trigger('resize');
                    }
                });
            }
        });

        // Accessibility: Keyboard trigger (Enter or Space)
        $wrapper.off('keydown', '.royalaccitemheading').on('keydown', '.royalaccitemheading', function (e) {
            if (e.which === 13 || e.which === 32) {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        // Live Search Filter
        var $searchInput = $wrapper.find('.royalacc-search-input');
        if ($searchInput.length) {
            var $noResults = $wrapper.find('.royalacc-no-results');
            $searchInput.off('keyup input').on('keyup input', function () {
                var query = $(this).val().toLowerCase().trim();
                var matchCount = 0;

                $wrapper.find('.royalaccitem').each(function () {
                    var $faqItem = $(this);
                    var titleText = $faqItem.find('.royalaccitemheading .title').text().toLowerCase();
                    var descText = $faqItem.find('.royalaccitemcontent').text().toLowerCase();

                    if (!query || titleText.indexOf(query) !== -1 || descText.indexOf(query) !== -1) {
                        $faqItem.stop(true, true).fadeIn(200);
                        matchCount++;
                    } else {
                        $faqItem.stop(true, true).fadeOut(200);
                    }
                });

                if (matchCount === 0 && query !== '') {
                    $noResults.stop(true, true).fadeIn(200);
                } else {
                    $noResults.stop(true, true).fadeOut(200);
                }
            });
        }

        // Deep Linking / URL Hash Scroll & Open
        var hashLinking = $wrapper.data('hash-linking');
        if (hashLinking === 'yes' || hashLinking === true || hashLinking === 'true') {
            var checkHash = function () {
                var hash = window.location.hash ? window.location.hash.substring(1) : '';
                if (!hash) return;

                var $target = $wrapper.find('#' + hash + ', [data-hash="' + hash + '"]');
                if ($target.length) {
                    var $targetHeading = $target.hasClass('royalaccitemheading') ? $target : $target.find('.royalaccitemheading');
                    if ($targetHeading.length && !$targetHeading.hasClass('ui-accordion-header-active')) {
                        $targetHeading.trigger('click');
                    }
                    var offset = parseInt($wrapper.data('scroll-offset'), 10) || 100;
                    $('html, body').stop().animate({
                        scrollTop: ($target.offset().top - offset)
                    }, 500);
                }
            };

            // Check on init
            setTimeout(checkHash, 300);

            // Listen for hashchange
            $(window).off('hashchange.royalacc').on('hashchange.royalacc', checkHash);
        }
    };

    window.royalAccordionInit = RoyalAccordionHandler;

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalaccordion.default', function ($scope) {
            RoyalAccordionHandler($scope, $);
        });
    });

    $(document).ready(function () {
        if (typeof elementorFrontend === 'undefined' || !elementorFrontend.isEditMode()) {
            $('.royalaccwrapper').each(function () {
                RoyalAccordionHandler($(this), $);
            });
        }
    });

})(jQuery);
