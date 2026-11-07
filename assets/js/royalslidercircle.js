jQuery(document).ready(function ($) {
    $('.royalcircleslider').each(function () {
        var $slider = $(this);
        var dotCircle = $slider.find('.dotcircle');
        var fields = $slider.find('.itemdot');
        var cirItems = $slider.find('.ciritem');
        var autoRotate = $slider.data('auto-rotate') == 1;
        var rotateSpeed = parseInt($slider.data('speed')) || 5000;
        var radius = parseInt($slider.data('radius')) || 200;
        var direction = $slider.data('direction') || 'clockwise';

        var width = dotCircle.width();
        var height = dotCircle.height();
        var step = (2 * Math.PI) / fields.length;
        var positions = [];

        fields.each(function (i) {
            var angle = i * step - Math.PI / 2;
            var x = Math.round(width / 2 + radius * Math.cos(angle) - $(this).width() / 2);
            var y = Math.round(height / 2 + radius * Math.sin(angle) - $(this).height() / 2);
            positions.push({ left: x, top: y });
        });

        var currentIndex = 0;

        function rotateCircle(index) {
            fields.each(function (i) {
                let newIndex = (i - index + fields.length) % fields.length;
                $(this).css({
                    left: positions[newIndex].left + 'px',
                    top: positions[newIndex].top + 'px',
                    transition: 'all 1s ease'
                });
            });

            fields.removeClass('active');
            cirItems.removeClass('active');
            fields.eq(index).addClass('active');
            cirItems.eq(index).addClass('active');
        }

        fields.on('click', function () {
            currentIndex = $(this).index();
            rotateCircle(currentIndex);
            stopAutoRotate();
        });

        var autoRotateInterval;

        function startAutoRotate() {
            if (autoRotate) {
                autoRotateInterval = setInterval(function () { if (window.elementorFrontend && elementorFrontend.isEditMode()) return;
                    if (direction === 'clockwise') {
                        currentIndex = (currentIndex + 1) % fields.length;
                    } else {
                        currentIndex = (currentIndex - 1 + fields.length) % fields.length;
                    }
                    rotateCircle(currentIndex);
                }, rotateSpeed);
            }
        }

        function stopAutoRotate() {
            clearInterval(autoRotateInterval);
        }

        rotateCircle(currentIndex);
        startAutoRotate();
    });
});
