/**
 * mgaccordion - Lightweight jQuery accordion plugin for menu navigation
 * Used by Royal Mega Menu for mobile and vertical click-expand menus
 */
(function ($) {
    'use strict';

    $.fn.mgaccordion = function (options) {
        var defaults = {
            theme: 'tree',
            speed: 300,
            toggleIcon: true
        };

        var settings = $.extend({}, defaults, options);

        return this.each(function () {
            var $menu = $(this);

            // Prevent double-initialization
            if ($menu.data('mgaccordion-init')) return;
            $menu.data('mgaccordion-init', true);

            // Add theme class
            $menu.addClass('mgaccordion mgaccordion-' + settings.theme);

            // Find all parent items (items with sub-menus)
            var $parentItems = $menu.find('.menu-item-has-children');

            $parentItems.each(function () {
                var $item = $(this);
                var $link = $item.children('a, .menu-text').first();
                var $submenu = $item.children('ul.sub-menu, ul.royal-megamenu-contents');

                // Collapse all sub-menus initially
                $submenu.hide().addClass('mgaccordion-submenu');

                // Add toggle indicator icon if not already present
                if (settings.toggleIcon && $link.find('.mgaccordion-toggle').length === 0) {
                    $link.append('<span class="mgaccordion-toggle"><i class="fas fa-chevron-down"></i></span>');
                }

                // Click handler on the link or toggle icon
                $link.on('click.mgaccordion', function (e) {
                    // Only prevent default if it has children and this is the parent link
                    if ($submenu.length) {
                        e.preventDefault();
                        e.stopPropagation();

                        var $thisSubmenu = $submenu;
                        var isOpen = $thisSubmenu.is(':visible');

                        if (isOpen) {
                            // Close this submenu
                            $thisSubmenu.slideUp(settings.speed);
                            $item.removeClass('mgaccordion-open');
                        } else {
                            // Close sibling submenus (accordion behavior)
                            $item.siblings('.menu-item-has-children').each(function () {
                                $(this).children('ul.sub-menu, ul.royal-megamenu-contents').slideUp(settings.speed);
                                $(this).removeClass('mgaccordion-open');
                            });

                            // Open this submenu
                            $thisSubmenu.slideDown(settings.speed);
                            $item.addClass('mgaccordion-open');
                        }
                    }
                });
            });
        });
    };

})(jQuery);
