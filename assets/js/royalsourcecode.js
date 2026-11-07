(function ($, w) {
  "use strict";

  $(w).on("elementor/frontend/init", function () {
    var RoyalSourceCodeHandler = function ($scope) {
      var $item = $scope.find(".royal-source-code");
      var $lng_type = $item.data("lng-type");
      var $after_copy_text = $item.data("after-copy");
      var $code = $item.find("code.language-" + $lng_type);
      var $copy_btn = $scope.find(".royal-copy-code-button");

      $copy_btn.on("click", function () {
        var $temp = $("<textarea>");
        $(this).append($temp);
        $temp.val($code.text()).select();
        document.execCommand("copy");
        $temp.remove();

        if ($after_copy_text.length) {
          $(this).text($after_copy_text);
        }
      });

      if ($lng_type !== undefined && $code !== undefined) {
        Prism.highlightElement($code.get(0));
      }
    };

    elementorFrontend.hooks.addAction("frontend/element_ready/royalsourcecode.default", RoyalSourceCodeHandler);
  });
})(jQuery, window);