(function ($, w) {
  "use strict";

  $(w).on("elementor/frontend/init", function () {
    var RoyalFlipBoxHandler = function ($scope) {
      var element = $scope.find('.royalflipboxinner');
      element.on('mouseenter mouseleave touchstart', function (e) {
        if (('mouseenter' == e.type || 'touchstart' == e.type) && !$(this).hasClass('flip')) {
          $(this).addClass('flip');
        } else if (('mouseleave' == e.type || 'touchstart' == e.type) && $(this).hasClass('flip')) {
          $(this).removeClass('flip');
        } else if ('touchstart' == e.type && $(this).hasClass('flip')) {
          $(this).removeClass('flip');
        }
      });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/royalflipbox.default', RoyalFlipBoxHandler);
  });
})(jQuery, window);