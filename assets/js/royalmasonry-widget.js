;(function($) {
    'use strict';

    /* ============================
       Royal Masonry Widget JS
       ============================ */

    function royalMasonryInit() {
        $('.royal-masonry-grid').each(function() {
            var $grid = $(this);
            var $wrapper = $grid.closest('.royal-masonry-wrapper');
            var activeFilter = $grid.data('active-filter') || '*';

            $grid.imagesLoaded(function() {
                var iso = $grid.isotope({
                    itemSelector: '.royal-masonry-item',
                    percentPosition: true,
                    filter: activeFilter,
                    masonry: {
                        columnWidth: '.royal-masonry-sizer',
                        gutter: 0
                    },
                    transitionDuration: '0.4s'
                });

                // Filter click
                $wrapper.find('.royal-masonry-filter ul li').on('click', function() {
                    var filterValue = $(this).attr('data-filter');
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');
                    iso.isotope({ filter: filterValue });
                });

                // Entrance animation
                if ($wrapper.hasClass('royal-masonry-animate')) {
                    var $items = $grid.find('.royal-masonry-item');
                    $items.each(function(i) {
                        var $item = $(this);
                        setTimeout(function() {
                            $item.addClass('royal-masonry-visible');
                        }, i * 80);
                    });
                }

                // Relayout after images
                iso.isotope('layout');
            });
        });
    }

    /* Lightbox - Magnific Popup */
    function royalMasonryLightbox() {
        $('.royal-masonry-popup-gallery').each(function() {
            var $gallery = $(this);

            // Prevent default link navigation on lightbox trigger clicks
            $gallery.off('click.royalLightbox').on('click.royalLightbox', 'a.royal-masonry-lightbox', function(e) {
                e.preventDefault();
            });

            $gallery.magnificPopup({
                delegate: 'a.royal-masonry-lightbox',
                type: 'image',
                mainClass: 'royal-mfp-wrap',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                image: {
                    tError: '<a href="%url%">The image</a> could not be loaded.'
                },
                callbacks: {
                    elementParse: function(item) {
                        if (item.el.hasClass('royal-masonry-video-popup')) {
                            item.type = 'iframe';
                        } else {
                            item.type = 'image';
                        }
                    },
                    close: function() {
                        // Remove any residual focus from the popup trigger
                        if (this.currItem && this.currItem.el) {
                            this.currItem.el.blur();
                        }
                    }
                }
            });
        });
    }

    /* Load More - AJAX */
    function royalMasonryLoadMore() {
        $(document).on('click', '.royal-masonry-loadmore button', function() {
            var $btn = $(this);
            var $wrapper = $btn.closest('.royal-masonry-wrapper');
            var $grid = $wrapper.find('.royal-masonry-grid');
            var page = parseInt($btn.data('page')) || 1;
            var maxPages = parseInt($btn.data('max-pages')) || 1;
            var widgetId = $wrapper.data('widget-id');

            if (page >= maxPages) { $btn.hide(); return; }

            $btn.addClass('loading').text('Loading...');
            page++;

            $.ajax({
                url: royalMasonryAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'royal_masonry_load_more',
                    nonce: royalMasonryAjax.nonce,
                    page: page,
                    widget_id: widgetId,
                    settings: $wrapper.data('settings')
                },
                success: function(response) {
                    if (response.success && response.data.html) {
                        var $items = $(response.data.html);
                        $grid.append($items).isotope('appended', $items).isotope('layout');
                        $btn.data('page', page);
                        if (page >= maxPages) { $btn.fadeOut(); }
                        else { $btn.removeClass('loading').text('Load More'); }
                        // Re-init lightbox
                        royalMasonryLightbox();
                    }
                },
                error: function() {
                    $btn.removeClass('loading').text('Load More');
                }
            });
        });
    }

    /* Init on DOM Ready */
    $(document).ready(function() {
        royalMasonryInit();
        royalMasonryLightbox();
        royalMasonryLoadMore();
    });

    /* Elementor Frontend Hook */
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/RoyalMasonry.default', function($scope) {
                royalMasonryInit();
                royalMasonryLightbox();
            });
        }
    });

})(jQuery);
