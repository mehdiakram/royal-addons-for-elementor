(function ($, w) {
  "use strict";

  $(w).on("elementor/frontend/init", function () {
    var RoyalCountdownHandler = function ($scope) {
      var $item = $scope.find(".royal-countdown");
      var $countdown_item = $item.find(".royal-countdown-item");
      var $end_action = $item.data("end-action");
      var $redirect_link = $item.data("redirect-link");
      var $end_action_div = $item.find(".royal-countdown-end-action");
      var $editor_mode_on = $scope.hasClass("elementor-element-edit-mode");

      $item.countdown({
        end: function end() {
          if (("message" === $end_action || "img" === $end_action) && $end_action_div !== undefined) {
            $countdown_item.css("display", "none");
            $end_action_div.css("display", "block");
          } else if ("url" === $end_action && $redirect_link !== undefined && $editor_mode_on !== true) {
            window.location.replace($redirect_link);
          }
        }
      });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/royalcountdown.default', RoyalCountdownHandler);
  });
})(jQuery, window);