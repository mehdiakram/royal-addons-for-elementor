(function($) {
    "use strict";

    // Royal Nav Menu Morph Handler
    var RoyalNavMenuMorphHandler = function($scope, $) {
        const menuElement = $scope.find(".menu")[0];
        if (!menuElement) {
            console.warn('Royal Morph Menu: Menu element not found');
            return;
        }

        const menuItems = menuElement.querySelectorAll(".menu__item");
        const menuBorder = menuElement.querySelector(".menu__border");
        let initialActiveItem = null; // Will be set based on URL or default
        
        if (!menuItems.length) {
            console.warn('Royal Morph Menu: No menu items found');
            return;
        }

        if (!menuBorder) {
            console.warn('Royal Morph Menu: Menu border not found');
            return;
        }

        let isNavigating = false; // Flag to prevent rapid navigation
        let resizeTimeout;

        /**
         * Calculate and set menu border position
         * @param {Element} element - The target item (active or hovered)
         * @param {Element} border - The menu border element
         */
        function offsetMenuBorder(element, border) {
            if (!element || !border || !menuElement) {
                return;
            }

            try {
                const offsetItem = element.getBoundingClientRect();
                const menuOffsetLeft = menuElement.getBoundingClientRect().left;

                const left = Math.floor(
                    offsetItem.left - 
                    menuOffsetLeft - 
                    (border.offsetWidth - offsetItem.width) / 2
                );

                border.style.transform = `translate3d(${left}px, 0, 0)`;
            } catch (e) {
                console.error('Royal Morph Menu: Error calculating border position', e);
            }
        }

        /**
         * Handle menu item hover (moves border and activates full visual feedback via CSS :hover)
         * @param {Element} item - The hovered menu item
         */
        function handleHover(item) {
            offsetMenuBorder(item, menuBorder);
        }

        /**
         * Reset menu border to the initial active item position on mouse leave from the menu
         */
        function resetBorderOnLeave() {
            if (!isNavigating && initialActiveItem) {
                offsetMenuBorder(initialActiveItem, menuBorder);
            } else if (!isNavigating && menuItems.length > 0) {
                 // Fallback: If no URL-matched active item, but there are menu items, snap to the first
                 offsetMenuBorder(menuItems[0], menuBorder);
            }
        }

        /**
         * Handle menu item click (triggers navigation after animation delay)
         * @param {Element} item - The clicked menu item (<a> tag)
         */
        function handleClickAndNavigate(item) {
            // Set flag to indicate navigation is pending
            isNavigating = true;

            const navigateToUrl = item.getAttribute('href');

            // Timeout to allow morphing animation to complete before navigation
            setTimeout(() => {
                isNavigating = false;
                if (navigateToUrl && navigateToUrl !== '#' && navigateToUrl !== '') {
                    const isExternal = item.getAttribute('target') === '_blank';
                    if (isExternal) {
                        window.open(navigateToUrl, '_blank');
                    } else {
                        window.location.href = navigateToUrl;
                    }
                }
            }, 700); // Match CSS transition duration
        }

        /**
         * Handle window resize
         */
        function handleResize() {
            if (resizeTimeout) {
                clearTimeout(resizeTimeout);
            }

            resizeTimeout = setTimeout(() => {
                // Ensure border stays aligned with initial active item on resize, if no hover
                if (initialActiveItem && menuBorder) {
                    offsetMenuBorder(initialActiveItem, menuBorder);
                } else if (menuItems.length > 0) {
                    offsetMenuBorder(menuItems[0], menuBorder); // Default to first item if no active
                }
            }, 150); // Debounce resize events
        }

        /**
         * Sets the active menu item based on the current page's URL.
         */
        function setActiveItemByUrl() {
            const currentPath = window.location.pathname.replace(/\/+$/, ''); // Normalize path (remove trailing slash)
            const currentHash = window.location.hash;
            let foundActive = false;

            // First, remove any existing 'active' class
            const currentlyActiveInDOM = menuElement.querySelector(".active");
            if (currentlyActiveInDOM) {
                currentlyActiveInDOM.classList.remove('active');
            }

            menuItems.forEach((item) => {
                const itemUrl = item.getAttribute('href');
                if (!itemUrl) return;

                const itemPath = new URL(itemUrl, window.location.origin).pathname.replace(/\/+$/, ''); // Normalize item path
                const itemHash = new URL(itemUrl, window.location.origin).hash;

                // Priority 1: Exact match of path and hash (for anchor links on same page)
                if (itemPath === currentPath && itemHash === currentHash && itemHash !== '') {
                    item.classList.add('active');
                    initialActiveItem = item;
                    foundActive = true;
                }
                // Priority 2: Exact path match (for standard pages)
                else if (itemPath === currentPath) {
                    item.classList.add('active');
                    initialActiveItem = item;
                    foundActive = true;
                }
            });

            // If no item matched the URL, default to the very first item
            if (!foundActive && menuItems.length > 0) {
                menuItems[0].classList.add('active');
                initialActiveItem = menuItems[0];
            }
        }


        /**
         * Initialize the menu
         */
        function init() {
            try {
                // Determine the active item based on URL matching
                setActiveItemByUrl();

                // Set initial border position to the active item found by URL (or default)
                if (initialActiveItem) {
                    offsetMenuBorder(initialActiveItem, menuBorder);
                } else if (menuItems.length > 0) { // Fallback to first item if no match and no initial set
                    offsetMenuBorder(menuItems[0], menuBorder);
                }

                // Add event listeners to menu items
                menuItems.forEach((item, index) => {
                    if (!item.dataset.index) {
                        item.dataset.index = index.toString();
                    }

                    item.addEventListener("click", (e) => {
                        e.preventDefault(); 
                        handleClickAndNavigate(item);
                    });

                    item.addEventListener("mouseenter", () => {
                        handleHover(item);
                    });

                    item.addEventListener("keydown", (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            handleClickAndNavigate(item);
                        }
                    });

                    if (!item.hasAttribute('tabindex')) {
                        item.setAttribute('tabindex', '0');
                    }
                });

                // Add mouseleave listener to the entire menu container to reset border
                menuElement.addEventListener("mouseleave", resetBorderOnLeave);

                // Add resize event listeners
                $(window).on('resize.royalMorphMenu', handleResize);

                // Add resize listener specifically for Elementor edit mode
                if (window.elementorFrontend && elementorFrontend.isEditMode()) {
                    elementorFrontend.elements.$window.on('resize.royalMorphMenu', handleResize);
                }

            } catch (e) {
                console.error('Royal Morph Menu: Initialization error', e);
            }
        }

        /**
         * Cleanup function (important for Elementor editor reloads)
         */
        function cleanup() {
            $(window).off('resize.royalMorphMenu');
            if (window.elementorFrontend && elementorFrontend.isEditMode()) {
                elementorFrontend.elements.$window.off('resize.royalMorphMenu');
            }
            if (menuElement) { // Ensure menuElement exists before removing listener
                menuElement.removeEventListener("mouseleave", resetBorderOnLeave);
            }
            if (resizeTimeout) {
                clearTimeout(resizeTimeout);
            }
        }

        init();
        $scope.data('royalMorphMenuCleanup', cleanup);

        if (window.elementorFrontend && elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction('panel/open_editor/widget/royalnavmenumorph', function() {
                setTimeout(init, 100);
            });
        }
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalnavmenumorph.default', RoyalNavMenuMorphHandler);
    });

    $(document).ready(function() {
        if (!window.elementorFrontend) {
            $('.royal-morph-menu-wrapper').each(function() {
                RoyalNavMenuMorphHandler($(this), $);
            });
        }
    });

    window.refreshRoyalMorphMenus = function() {
        $('.royal-morph-menu-wrapper').each(function() {
            const cleanup = $(this).data('royalMorphMenuCleanup');
            if (cleanup && typeof cleanup === 'function') {
                cleanup(); 
            }
            RoyalNavMenuMorphHandler($(this), $); 
        });
    };

    if (typeof document.hidden !== "undefined") {
        document.addEventListener("visibilitychange", function() {
            if (!document.hidden) {
                setTimeout(function() {
                    if (window.refreshRoyalMorphMenus) {
                        window.refreshRoyalMorphMenus();
                    }
                }, 100);
            }
        });
    }

})(jQuery);