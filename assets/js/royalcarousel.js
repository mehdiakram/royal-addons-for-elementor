(function ($, w) {
  "use strict";

  $(w).on("elementor/frontend/init", function () {
    var RoyalCarouselHandler = function ($scope, $) {
      var $_this = $scope.find('.royalcarousel');
      if (!$_this.length) return;

      var $currentID = '#' + $_this.attr('id'),
        $loop = $_this.data('loop'),
        $video = $_this.data('video'),
        $lazyLoad = $_this.data('lazyLoad'),
        $autoplay = $_this.data('autoplay'),
        $margin = $_this.data('margin'),
        $autoplaytimeout = $_this.data('timeout'),
        $navtext = $_this.data('navtext'),
        $desktopitems = $_this.data('desktopitems'),
        $desktopdots = $_this.data('desktopdots'),
        $desktopnav = $_this.data('desktopnav'),
        $tabitems = $_this.data('tabitems'),
        $tabdots = $_this.data('tabdots'),
        $tabnav = $_this.data('tabnav'),
        $mobileitems = $_this.data('mobileitems'),
        $mobiledots = $_this.data('mobiledots'),
        $mobilenav = $_this.data('mobilenav'),
        $animateIn = $_this.data('animatein'),
        $animateOut = $_this.data('animateout');

      var owlOptions = {
        autoplay: $autoplay,
        video: $video,
        lazyLoad: $lazyLoad,
        loop: $loop,
        margin: $margin,
        autoplayTimeout: $autoplaytimeout,
        navText: $navtext,
        responsive: {
          0: {
            items: $mobileitems,
            dots: $mobiledots,
            nav: $mobilenav
          },
          600: {
            items: $tabitems,
            dots: $tabdots,
            nav: $tabnav
          },
          1000: {
            items: $desktopitems,
            dots: $desktopdots,
            nav: $desktopnav
          }
        }
      };

      if ($animateIn && $animateIn !== 'none') {
          owlOptions.animateIn = $animateIn;
      }
      if ($animateOut && $animateOut !== 'none') {
          owlOptions.animateOut = $animateOut;
      }

      var owl = $($currentID);
      owl.owlCarousel(owlOptions);

      owl.on('initialized.owl.carousel changed.owl.carousel refreshed.owl.carousel', function (e) {
        setTimeout(function () {
          var $navButtons = owl.find('.owl-prev, .owl-next');
          $navButtons.each(function () {
            $(this).removeAttr('role'); // remove role="presentation" to avoid ARIA conflict
            if ($(this).hasClass('owl-prev')) {
              $(this).attr('aria-label', 'Previous').attr('title', 'Previous');
            } else if ($(this).hasClass('owl-next')) {
              $(this).attr('aria-label', 'Next').attr('title', 'Next');
            }
          });
        }, 100);
      });

      // Re-trigger Elementor animations for elements inside the active slide
      owl.on('translate.owl.carousel', function(e) {
          // Before slide changes, reset animations on all slides
          owl.find('.owl-item [data-settings*="animation"]').each(function() {
              var $el = $(this);
              var settings = $el.data('settings');
              if (settings && settings.animation) {
                  $el.removeClass('animated ' + settings.animation).addClass('elementor-invisible');
              }
          });

          // Stop all Lottie animations in the carousel
          owl.find('lottie-player').each(function() {
              if (typeof this.stop === 'function') {
                  this.stop();
              }
          });

          // Pause HTML5 Videos
          owl.find('video').each(function() {
              if (typeof this.pause === 'function') {
                  this.pause();
              }
          });

          // Trigger custom inactive event for widgets to listen to
          $(e.target).find('.owl-item.active').trigger('royal-slide-inactive');
      });

      owl.on('translated.owl.carousel', function(e) {
          // After slide changes, animate elements in the active slide
          var $currentSlide = $(e.target).find('.owl-item.active');
          
          $currentSlide.find('[data-settings*="animation"]').each(function() {
              var $el = $(this);
              var settings = $el.data('settings');
              if (settings && settings.animation) {
                  var delay = settings._animation_delay ? settings._animation_delay : 0;
                  setTimeout(function() {
                      $el.removeClass('elementor-invisible').addClass('animated ' + settings.animation);
                  }, delay + 50); // add a slight 50ms buffer for DOM reflow
              }
          });

          // Restart Lottie animations in the active slide
          $currentSlide.find('lottie-player').each(function() {
              if (typeof this.seek === 'function') {
                  this.seek(0);
              }
              if (typeof this.play === 'function') {
                  this.play();
              }
          });

          // Play HTML5 Videos from beginning
          $currentSlide.find('video').each(function() {
              if (typeof this.play === 'function') {
                  this.currentTime = 0;
                  this.play();
              }
          });

          // Re-trigger CSS animations by removing and re-adding style tags or specific classes
          $currentSlide.find('.royal-animated-svg, .royal-progress-bar, .royal-counter').each(function() {
              var $el = $(this);
              var clone = $el.clone(true);
              $el.replaceWith(clone);
          });

          // Trigger custom active event for widgets to listen to and re-init
          $currentSlide.trigger('royal-slide-active');
      });


    };

    const widgets = [
      'royalpostcarousel',
      'royalpostgrid',
      'royalimagecarousel',
      'royalcontentslider',
      'royaltestimonialcarousel',
      'royalvideo',
      'royalauto',
      'royalproperty',
      'royaltravel',
      'royalwooproductscarousel',
      'royaltaxonomycarousel',
      'royalslides'
    ];

    widgets.forEach(widget => {
      elementorFrontend.hooks.addAction(`frontend/element_ready/${widget}.default`, RoyalCarouselHandler);
    });
  });
})(jQuery, window);
