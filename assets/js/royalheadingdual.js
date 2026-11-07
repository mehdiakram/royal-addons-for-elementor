(function ($) {

    var RoyalMaskHandler = function ($scope, $) {

        var txtShowcaseElem = $scope.find('.pa-txt-sc__effect-min-mask .pa-txt-sc__main-item.pa-txt-sc__item-text'),
            mask = $scope.hasClass('royal-mask-yes') || txtShowcaseElem.length;

        if (!mask) return;

        if ('royal-addon-title.default' === $scope.data('widget_type')) {
            var target = '.royal-title-header';
            $scope.find(target).find('.royal-title-icon, .royal-title-img').addClass('royal-mask-span');

        } else if ('royal-textual-showcase.default' === $scope.data('widget_type') ) {
            var target = '.pa-txt-sc__effect-min-mask';

        } else {
            var target = '.royal-dual-header-first-header';
        }

        $scope.find(target).find('span:not(.royal-title-style7-stripe-wrap):not(.royal-title-img):not(.pa-txt-sc__hov-item)').each(function (index, span) {
            var html = '';

            $(this).text().split(' ').forEach(function (item) {
                if ('' !== item) {
                    html += ' <span class="royal-mask-span">' + item + '</span>';
                }
            });

            $(this).text('').append(html);
        });

        elementorFrontend.waypoint($scope, function () {
            if ( txtShowcaseElem.length ) {

                $(txtShowcaseElem).addClass('royal-mask-active');

            } else {
                $($scope).addClass('royal-mask-active');
            }
        });
    };


    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalheadingdual.default', RoyalMaskHandler);
    });
})(jQuery);

