(function ($, w) {
  "use strict";
  var $window = $(w);

  $(w).on("elementor/frontend/init", function () {
    var RoyalTimelineHandler = function ($scope) {
      var T_ID = $scope.data("id") || Math.random().toString(36).substring(2, 9);
      var $timeline = $scope.find(".royal-timeline-wrap, .ha-timeline-wrap");
      if (!$timeline.length) {
        return;
      }

      var isEdit = Boolean(window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode());
      var isModernStyle = $timeline.is(".royal-timeline-style-2, .royal-timeline-style-3, .royal-timeline-style-4, .royal-timeline-style-5");
      var eventNamespace = ".royalTimeline" + T_ID;
      var eventNames = "scroll" + eventNamespace + " resize" + eventNamespace;

      // =========================================================================
      // STYLE 1: 100% Backward Compatible Original Behavior
      // =========================================================================
      if (!isModernStyle) {
        var dataScroll = $timeline.data("scroll");
        var $blocks = $timeline.find(".royal-timeline-block, .ha-timeline-block");

        function scroll_tree() {
          $blocks.each(function () {
            var $block = $(this);
            var block_height = $block.outerHeight(true);
            var offset = $block.offset();
            var $offsetTop = offset ? offset.top : 0;
            var window_middle_p = $window.scrollTop() + $window.height() / 2;

            if ($offsetTop < window_middle_p) {
              $block.addClass("royal-timeline-scroll-tree ha-timeline-scroll-tree");
            } else {
              $block.removeClass("royal-timeline-scroll-tree ha-timeline-scroll-tree");
            }

            var $scroll_tree_wrap = $block.find(".royal-timeline-tree-inner, .ha-timeline-tree-inner");
            if (!$scroll_tree_wrap.length) return;

            var treeOffset = $scroll_tree_wrap.offset();
            var scroll_height = $window.scrollTop() - (treeOffset ? treeOffset.top : 0) + $window.outerHeight() / 2;

            if ($offsetTop < window_middle_p && $block.hasClass("royal-timeline-scroll-tree")) {
              if (block_height > scroll_height) {
                $scroll_tree_wrap.css({
                  height: scroll_height * 1.5 + "px"
                });
              } else {
                $scroll_tree_wrap.css({
                  height: block_height * 1.2 + "px"
                });
              }
            } else {
              $scroll_tree_wrap.css("height", "0px");
            }
          });
        }

        if ("yes" === dataScroll) {
          scroll_tree();
          $window.off(eventNamespace);
          $window.on(eventNames, scroll_tree);
        } else {
          $window.off(eventNamespace);
        }
        return;
      }

      // =========================================================================
      // STYLES 2, 3, 4, 5: Modern Interactive Journey Timeline
      // =========================================================================
      var $modernBlocks = $timeline.find(".royal-timeline-block");
      var $endMarker = $timeline.find(".royal-timeline-end");
      var dataReveal = $timeline.data("reveal");
      var $centralFill = $timeline.find(".royal-timeline-central-fill");

      // 1. Scroll Reveal Animation using IntersectionObserver
      var revealTargets = [];
      $modernBlocks.each(function () {
        revealTargets.push(this);
      });
      if ($endMarker.length) {
        revealTargets.push($endMarker[0]);
      }

      if (revealTargets.length) {
        if ("yes" === dataReveal && "IntersectionObserver" in window && !isEdit) {
          var observer = new IntersectionObserver(
            function (entries) {
              entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                  entry.target.classList.add("in");
                  observer.unobserve(entry.target);
                }
              });
            },
            { threshold: 0.15, rootMargin: "0px 0px -40px 0px" }
          );

          revealTargets.forEach(function (el) {
            observer.observe(el);
          });
        } else {
          // Immediately reveal in edit mode or when reveal animation is disabled
          revealTargets.forEach(function (el) {
            el.classList.add("in");
          });
        }
      }

      // 2. Interactive Central Rail Fill
      function updateModernProgress() {
        var tlNode = $timeline[0];
        if (!tlNode) return;

        var rect = tlNode.getBoundingClientRect();
        var vh = window.innerHeight || document.documentElement.clientHeight;
        var progress = (vh * 0.6 - rect.top) / rect.height;
        var pct = Math.min(Math.max(progress, 0), 1) * 100;

        if ($centralFill.length) {
          $centralFill.css("height", pct + "%");
        }

        var windowMiddle = $window.scrollTop() + vh / 2;
        $modernBlocks.each(function () {
          var $block = $(this);
          var offset = $block.offset();
          var offsetTop = offset ? offset.top : 0;
          if (offsetTop < windowMiddle) {
            $block.addClass("is-active royal-timeline-scroll-tree");
          } else {
            $block.removeClass("is-active royal-timeline-scroll-tree");
          }
        });
      }

      updateModernProgress();
      $window.off(eventNamespace);
      $window.on(eventNames, updateModernProgress);
    };

    elementorFrontend.hooks.addAction("frontend/element_ready/royaltimeline.default", RoyalTimelineHandler);
  });
})(jQuery, window);
