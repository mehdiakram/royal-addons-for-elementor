(function ($) {
    "use strict";

    var Royal360DegreeViewHandler = function ($scope, $) {
        var $wrapper = $scope.find('.royal-360-view-wrapper');
        if (!$wrapper.length) {
            return;
        }

        var $img = $wrapper.find('.royal-360-view-image');
        var $preloader = $wrapper.find('.royal-360-preloader');
        
        var imagesData = $wrapper.data('images');
        if (!imagesData || imagesData.length === 0) {
            $preloader.addClass('loaded');
            return;
        }

        var speed = $wrapper.data('speed') || 10;
        var autoplay = $wrapper.data('autoplay');
        var autoplaySpeed = $wrapper.data('autoplay-speed') || 50;

        var images = [];
        var loadedCount = 0;
        var totalImages = imagesData.length;
        var currentIndex = 0;
        var isDragging = false;
        var startX = 0;
        var lastX = 0;
        var autoplayInterval;

        // Preload all images
        for (var i = 0; i < totalImages; i++) {
            var imgObj = new Image();
            imgObj.onload = function() {
                loadedCount++;
                if (loadedCount === totalImages) {
                    init360();
                }
            };
            imgObj.onerror = function() {
                loadedCount++;
                if (loadedCount === totalImages) {
                    init360();
                }
            };
            imgObj.src = imagesData[i];
            images.push(imgObj);
        }

        function init360() {
            $preloader.addClass('loaded');
            
            if (images[0] && images[0].src) {
                $img.attr('src', images[0].src);
            }

            if (autoplay) {
                startAutoplay();
            }

            // Mouse / Touch Events
            $wrapper.on('mousedown touchstart', function(e) {
                e.preventDefault();
                isDragging = true;
                startX = e.pageX || e.originalEvent.touches[0].pageX;
                lastX = startX;
                stopAutoplay();
            });

            $(window).on('mousemove touchmove', function(e) {
                if (!isDragging) return;
                
                var currentX = e.pageX || (e.originalEvent.touches ? e.originalEvent.touches[0].pageX : lastX);
                var diffX = currentX - lastX;

                if (Math.abs(diffX) >= speed) {
                    if (diffX > 0) {
                        // Dragging right
                        currentIndex--;
                        if (currentIndex < 0) currentIndex = totalImages - 1;
                    } else {
                        // Dragging left
                        currentIndex++;
                        if (currentIndex >= totalImages) currentIndex = 0;
                    }
                    
                    if (images[currentIndex] && images[currentIndex].src) {
                        $img.attr('src', images[currentIndex].src);
                    }
                    
                    lastX = currentX;
                }
            });

            $(window).on('mouseup touchend', function() {
                if (isDragging) {
                    isDragging = false;
                    // Optional: resume autoplay
                    // if (autoplay) startAutoplay();
                }
            });
        }

        function startAutoplay() {
            autoplayInterval = setInterval(function() {
                currentIndex++;
                if (currentIndex >= totalImages) currentIndex = 0;
                if (images[currentIndex] && images[currentIndex].src) {
                    $img.attr('src', images[currentIndex].src);
                }
            }, autoplaySpeed);
        }

        function stopAutoplay() {
            if (autoplayInterval) {
                clearInterval(autoplayInterval);
            }
        }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royal360degreeview.default', Royal360DegreeViewHandler);
    });

})(jQuery);
