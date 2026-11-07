/**
 * Royal Image Collage - Interactive 3D Parallax & Floating Grid
 */
(function () {
  'use strict';

  function initCollage(el) {
    if (!el || el.dataset.royalCollageInit === 'true') return;
    el.dataset.royalCollageInit = 'true';

    var rawSettings = el.dataset.settings;
    var settings = {};
    if (rawSettings) {
      try {
        settings = JSON.parse(rawSettings);
      } catch (err) {
        settings = {};
      }
    }

    var enableParallax = settings.enable_parallax !== false;
    var disableOnTouch = settings.disable_on_touch !== false;
    var isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

    if (!enableParallax || (disableOnTouch && isTouch)) {
      return;
    }

    var ticking = false;
    var mouseX = 0;
    var mouseY = 0;

    function onMouseMove(e) {
      var r = el.getBoundingClientRect();
      if (r.width <= 0 || r.height <= 0) return;

      var x = (e.clientX - r.left) / r.width - 0.5;
      var y = (e.clientY - r.top) / r.height - 0.5;

      mouseX = Math.max(-0.5, Math.min(0.5, x));
      mouseY = Math.max(-0.5, Math.min(0.5, y));

      if (!ticking) {
        window.requestAnimationFrame(function () {
          el.style.setProperty('--mx', mouseX.toFixed(3));
          el.style.setProperty('--my', mouseY.toFixed(3));
          ticking = false;
        });
        ticking = true;
      }
    }

    function onMouseLeave() {
      window.requestAnimationFrame(function () {
        el.style.setProperty('--mx', '0');
        el.style.setProperty('--my', '0');
      });
    }

    el.addEventListener('mousemove', onMouseMove, { passive: true });
    el.addEventListener('mouseleave', onMouseLeave);
  }

  function initAll() {
    var collages = document.querySelectorAll('.royal-image-collage');
    for (var i = 0; i < collages.length; i++) {
      initCollage(collages[i]);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll();
  }

  if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
      if (!window.elementorFrontend || !window.elementorFrontend.hooks) return;
      window.elementorFrontend.hooks.addAction(
        'frontend/element_ready/royalimagecollage.default',
        function ($scope) {
          var items = $scope[0].querySelectorAll('.royal-image-collage');
          for (var i = 0; i < items.length; i++) {
            items[i].removeAttribute('data-royal-collage-init');
            initCollage(items[i]);
          }
        }
      );
    });
  }
})();
