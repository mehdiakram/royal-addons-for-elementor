// wp-content/plugins/royal-addons-for-elementor/includes/royal-megamenu/public/assets/public/js/royal-mega-menu-public.js
function openRoyalMobileMenu() {
    document.querySelector('.enabled-mobile-menu .mobile-menu-area').classList.add('opened');
    event.preventDefault();
    // Prevent body scroll when mobile menu is open
    document.body.style.overflow = 'hidden';
}

function closeRoyalMobileMenu() {
    document.querySelector('.enabled-mobile-menu .mobile-menu-area').classList.remove('opened');
    event.preventDefault();
    // Re-enable body scroll when mobile menu is closed
    document.body.style.overflow = '';
}


(function($) {

    RoyalMegaMenu = { // This is your object definition
        init: function () {
            this.enableAccordion();
            this.enableHeaderScript();
            $( document )
            .on( 'click.RoyalMegaMenu', '.royal-menu-vertical-expand-button-wrapper a', this.expandVerticalMenu )
            // Global handlers for mobile menu open/close buttons, if not already handled by inline onclick
            .on( 'click.RoyalMegaMenu', '.royal-menu-mobile-button[onclick="openRoyalMobileMenu()"]', openRoyalMobileMenu)
            .on( 'click.RoyalMegaMenu', '.royal-menu-mobile-close[onclick="closeRoyalMobileMenu()"], .royal-menu-area .mobile-menu-area .overlay[onclick="closeRoyalMobileMenu()"]', closeRoyalMobileMenu);

            // Handle closing vertical top menu with specific button
            if ($('.royal-menu-vertical-expanded').length) {
                function closeRoyalMobileMenu_top() {
                    $(".royal-menu-vertical-expanded").removeClass("opened");
                }
                $(".royal-menu-top-cls").on("click", closeRoyalMobileMenu_top);
            }

            // Handle showing/hiding royal-menu-top-cls
            if ($('.expand-position-top').length) {
                // Hide on click of non-parent menu item or the closer button itself
                $(".expand-position-top ul.royal-mega-menu .menu-item .menu-text span:not(.submenu-parent-icon), .royal-menu-top-cls").on("click", function () {
                   $(".royal-menu-top-cls").removeClass("top-opened"); // Use class to toggle visibility
                });
                // Show on click of the main mobile button
                $(".royal-menu-mobile-button").on("click", function () {
                   $(".royal-menu-top-cls").addClass("top-opened");
                });
            }

            // Close main mobile menu or vertical top menu when non-parent item is clicked
            if ($('.mobile-menu-area, .expand-position-top').length) {
                function closeRoyalMobileMenu_on_item_click() {
                    $(".mobile-menu-area, .expand-position-top").removeClass("opened");
                }
                $("ul.royal-mega-menu .menu-item:not(.menu-item-has-children) .menu-text span:not(.submenu-parent-icon), .expand-position-top ul.royal-mega-menu .menu-item:not(.menu-item-has-children) .menu-text span:not(.submenu-parent-icon)").on("click", closeRoyalMobileMenu_on_item_click);
            }
        },
        expandVerticalMenu: function(e){
            e.preventDefault();
            let widgetID = $(this).attr('widget_id');
            $('.enabled-vertical-menu .vertical-expaned-menu-area'+'.'+widgetID+ ' .royal-menu-vertical-expanded').toggleClass('opened');
        },
        enableAccordion: function(){
            // Ensure mgaccordion plugin is loaded (e.g., from royal-mega-accordion.js)
            if (typeof $.fn.mgaccordion === 'function') {
                if($(".royal-menu-area .mobile-menu-area .royal-menu-mobile-sidebar .royal-mega-menu").length){
                    $(".royal-menu-area .mobile-menu-area .royal-menu-mobile-sidebar .royal-mega-menu").mgaccordion({
                        theme: 'tree', // Assuming 'tree' or 'flat' are defined in mgaccordion
                    });
                }

                if($(".royal-menu-area .royal-mega-menu.vertical.vertical-submenu-expand-mode-click").length){
                    $(".royal-menu-area .royal-mega-menu.vertical.vertical-submenu-expand-mode-click").mgaccordion({
                        theme: 'tree',
                    });
                }
            } else {
                console.warn('mgaccordion plugin not found. Accordion functionality may not work.');
            }
        },
        enableHeaderScript: function () {
            // Adjust to find appropriate full-width container in Royal Addons context
            let headerInnerWidth = $('.header-inner .e-con > .e-con-inner').width();
            // Fallback for different Elementor container structures
            if (!headerInnerWidth && $('.elementor-container').length) {
                headerInnerWidth = $('.elementor-container').width();
            }
            if (!headerInnerWidth && $('.elementor-section-wrap').length) {
                headerInnerWidth = $('.elementor-section-wrap').width();
            }


            $('.royal-megamenu-contents.full-width-mega-menu').css('width', headerInnerWidth+'px');
            $('.royal-megamenu-contents.full-width-mega-menu').css('max-width', headerInnerWidth+'px');
            // Ensure Elementor widget containers don't have conflicting positioning
            $('.elementor-widget.elementor-widget-royal-mega-navigation-menu').css('position', 'static');
            $('.elementor-widget.elementor-widget-royal-mega-navigation-menu').parent().css('position', 'static');

            $(window).resize(function(){
                let resizedHeaderInnerWidth = $('.header-inner .e-con > .e-con-inner').width();
                if (!resizedHeaderInnerWidth && $('.elementor-container').length) {
                    resizedHeaderInnerWidth = $('.elementor-container').width();
                }
                if (!resizedHeaderInnerWidth && $('.elementor-section-wrap').length) {
                    resizedHeaderInnerWidth = $('.elementor-section-wrap').width();
                }

                $('.royal-megamenu-contents.full-width-mega-menu').css('width', resizedHeaderInnerWidth+'px');
                $('.royal-megamenu-contents.full-width-mega-menu').css('max-width', resizedHeaderInnerWidth+'px');
            });
        },
        setupStickyHeaderBehavior: function() {
            // This logic is adapted from the provided rtmega-widget.php render function
            // for sticky header. It assumes your header has the class 'sticky-header-on'
            // and the content area has id 'page'.

            var header = $('header.sticky-header-on');
            var page = $('#page'); // Assuming your main content area has this ID
            var topbar = $('.rt-topbar-hide'); // From original code, might not exist in your theme

            if (header.length) {
                function updatePaddingAndMargin() {
                    var headerHeight = header.outerHeight();
                    var topbarHeight = topbar.length ? topbar.outerHeight() : 0;

                    if (page.length) {
                        if (!header.hasClass('fixed-header')) { // 'fixed-header' might be a class you apply manually
                            page.css('padding-top', headerHeight + 'px');
                        } else {
                            page.css('padding-top', '');
                        }
                    }

                    if (header.hasClass('royal-mega-up-scroll-hide')) {
                        header.css('margin-top', `-${topbarHeight}px`);
                    } else {
                        header.css('margin-top', '0px');
                    }
                }

                let lastScroll = 0;
                function sticky_header_scroll_logic() {
                    var headerOffset = header.offset().top; // Get initial offset, or 0 if fixed from start
                    var scroll = $(window).scrollTop();
                    var headerHeight = header.outerHeight();

                    if (scroll > headerHeight) { // Once scrolled past header height
                        header.addClass('sticky-header');
                    } else {
                        header.removeClass('sticky-header');
                    }

                    // For 'backscroll top hide' effect
                    if (header.hasClass('royal-mega-up-scroll-hide-active')) { // Add this class to header if option is enabled
                        if (scroll > headerHeight && scroll > lastScroll) {
                            header.addClass('sticky-headers'); // Class for hidden state on scroll down
                        } else if (scroll < lastScroll) {
                            header.removeClass('sticky-headers'); // Remove class to show on scroll up
                        }
                    } else {
                        // Regular sticky behavior without scroll-up hide
                        if (scroll > headerHeight) {
                            header.addClass('sticky-headers'); // Just add sticky-headers class
                        } else {
                            header.removeClass('sticky-headers');
                        }
                    }

                    lastScroll = scroll;
                    updatePaddingAndMargin();
                }

                $(document).ready(function() {
                    // Add a class to header if 'enable_backscroll_header_top' option is 'yes'
                    // This needs to be set dynamically via PHP or another JS snippet if you want the effect
                    // Example: if ( your_widget_settings.enable_backscroll_header_top == 'yes' ) header.addClass('royal-mega-up-scroll-hide-active');

                    updatePaddingAndMargin();
                    sticky_header_scroll_logic();
                });

                $(window).on('scroll resize', function() {
                    sticky_header_scroll_logic();
                    updatePaddingAndMargin();
                });
            }
        },
        // enableAccordion: function() {
        //     // If you adapt the rtmega-accordion.js logic, integrate it here
        // }
    };
    RoyalMegaMenu.init(); // <-- Changed from RoyalMegaMenuPublic.init()
})(jQuery);