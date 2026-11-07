(function ($) {
    var RoyalSliderLandingHandler = function ($scope, $) {
        var $_this = $scope.find('.royallandingslider');
        if (!$_this.length) return;

        var $running = $_this.data('running') || 1000;
        var $interval = $_this.data('interval') || 5000;
        var isEditMode = elementorFrontend.isEditMode();

        let royallandingsliderDom = $_this[0];
        let SliderDom = royallandingsliderDom.querySelector('.list');
        let thumbnailBorderDom = royallandingsliderDom.querySelector('.thumbnail');

        if (!SliderDom || !thumbnailBorderDom) return;

        // Safe check: thumbnail item exists
        if (!thumbnailBorderDom.querySelectorAll('.item').length) return;

        // Prepare by appending first thumbnail item
        thumbnailBorderDom.appendChild(thumbnailBorderDom.querySelectorAll('.item')[0]);

        let timeRunning = $running;
        let timeAutoNext = $interval;

        let nextDom = $scope.find('.slider-next').get(0);
        let prevDom = $scope.find('.slider-prev').get(0);

        // Events
        if (nextDom) {
            nextDom.onclick = function () {
                showSlider('next');
            };
        }

        if (prevDom) {
            prevDom.onclick = function () {
                showSlider('prev');
            };
        }

        let runTimeOut;
        let runNextAuto;

        // Initial autoplay setup
        if (!isEditMode) {
            runNextAuto = setTimeout(() => {
                if (nextDom) nextDom.click();
            }, timeAutoNext);
        }

        function showSlider(type) {
            let SliderItemsDom = SliderDom.querySelectorAll('.item');
            let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');

            if (!SliderItemsDom.length || !thumbnailItemsDom.length) return;

            if (type === 'next') {
                SliderDom.appendChild(SliderItemsDom[0]);
                thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
                royallandingsliderDom.classList.add('next');
            } else {
                SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]);
                thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]);
                royallandingsliderDom.classList.add('prev');
            }

            clearTimeout(runTimeOut);
            runTimeOut = setTimeout(() => {
                royallandingsliderDom.classList.remove('next');
                royallandingsliderDom.classList.remove('prev');
            }, timeRunning);

            clearTimeout(runNextAuto);

            if (!isEditMode) {
                runNextAuto = setTimeout(() => {
                    if (nextDom) nextDom.click();
                }, timeAutoNext);
            }
        }
    };

    // Register handler with Elementor
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/royalsliderlanding.default',
            RoyalSliderLandingHandler
        );
    });
})(jQuery);
