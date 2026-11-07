(function ($, w) {
  "use strict";

  $.fn.RoyalTicker = function (options) {
    const opts = $.extend({}, $.fn.RoyalTicker.defaults, options);
    const thisTicker = $(this);
    let intervalID, timeoutID, isPause = false;

    // Wrap and basic styling
    if (!thisTicker.parent().hasClass('royalticker-wrap')) {
      thisTicker.wrap("<div class='royalticker-wrap'></div>");
    }
    const wrap = thisTicker.parent();
    wrap.css({ position: 'relative', overflow: 'hidden' });

    thisTicker.css({
      position: 'absolute',
      display: 'flex',
      flexWrap: 'nowrap',
      top: 0,
      left: 0,
      whiteSpace: 'nowrap',
      alignItems: 'center'
    });

    // Hide all except first for vertical/horizontal/typewriter init
    if (opts.type !== 'marquee') {
      thisTicker.children("li").not(":first").hide();
    }

    init();

    function init() {
      switch (opts.type) {
        case 'vertical':
        case 'horizontal':
          vertiZontal();
          break;
        case 'marquee':
          marQuee();
          break;
        case 'typewriter':
          typeWriter();
          break;
        default:
          break;
      }
    }

    // Vertical / Horizontal Scroll
    function vertiZontal(prevNext = false) {
      let speed = opts.speed;
      let autoplay = opts.autoplay;
      const direction = opts.direction;

      if (prevNext) {
        speed = 0;
        autoplay = 0;
        clearInterval(intervalID);
        intervalID = false;
      }

      function play() {
        if (isPause) {
          clearInterval(intervalID);
          intervalID = false;
          return;
        }

        let dChild = thisTicker.find('li:first');
        const eqType = (direction === 'up' || direction === 'right') ? '-=' : '+=';
        const mType = (opts.type === 'horizontal') ? 'left' : 'margin-top';
        const mVal = (opts.type === 'horizontal') ? dChild.outerWidth(true) : dChild.outerHeight(true);

        if (prevNext === 'prev') {
          thisTicker.find('li:last').detach().prependTo(thisTicker);
        } else {
          dChild.detach().appendTo(thisTicker);
        }

        thisTicker.find('li').css({ opacity: '0', display: 'none' });
        thisTicker.find('li:first').css({
          opacity: '1',
          position: 'absolute',
          display: 'block',
          [mType]: eqType + mVal + 'px'
        }).animate(
          { [mType]: '0px' },
          speed,
          function () {
            clearInterval(intervalID);
            intervalID = false;
            vertiZontal();
          }
        );
      }

      if (!intervalID) intervalID = setInterval(play, autoplay);
    }

    // Typewriter effect
    function typeWriter(prevNext = false) {
      if (isPause) return;

      if (prevNext) {
        clearInterval(intervalID);
        clearTimeout(timeoutID);
        intervalID = timeoutID = false;

        if (prevNext === 'prev') {
          thisTicker.find('li:last').detach().prependTo(thisTicker);
        } else {
          thisTicker.find('li:first').detach().appendTo(thisTicker);
        }
      }

      const typeEl = thisTicker.find('li:first');
      const wrapEl = typeEl.children();
      let count = 0;

      if (typeEl.attr('data-text')) {
        wrapEl.text(typeEl.attr('data-text'));
      }

      const allText = typeEl.text();
      thisTicker.find('li').css({ opacity: '0', display: 'none' });

      function tNext() {
        thisTicker.find('li:first').detach().appendTo(thisTicker);
        clearTimeout(timeoutID);
        timeoutID = false;
        typeWriter();
      }

      function type() {
        count++;
        const typeText = allText.substring(0, count);
        if (!typeEl.attr('data-text')) typeEl.attr('data-text', allText);

        if (count <= allText.length) {
          wrapEl.text(typeText);
          typeEl.css({ opacity: '1', display: 'block' });
        } else {
          clearInterval(intervalID);
          intervalID = false;
          timeoutID = setTimeout(tNext, opts.autoplay);
        }
      }

      if (!intervalID) intervalID = setInterval(type, opts.speed);
    }

    // Marquee: seamless continuous scrolling
    function marQuee() {
      const direction = opts.direction;
      const dir = (direction === 'right') ? 'right' : 'left';

      let tickerWidth = 0;
      let pos = 0;
      const speed = opts.speed || 1; // pixels per frame

      // Append duplicate content for seamless loop
      thisTicker.append(thisTicker.html());

      // Calculate total width of content (both originals and duplicate)
      thisTicker.find("li").each(function () {
        tickerWidth += $(this).outerWidth(true);
      });

      thisTicker.css({
        width: tickerWidth,
        position: 'absolute',
        [dir]: 0,
        display: 'flex',
        flexWrap: 'nowrap',
        whiteSpace: 'nowrap',
        alignItems: 'center',
        top: 0,
        height: '100%'
      });

      function animate() {
        if (!isPause) {
          pos -= speed;
          if (Math.abs(pos) >= tickerWidth / 2) {
            pos = 0;
          }
          thisTicker.css(dir, pos + 'px');
        }
        requestAnimationFrame(animate);
      }

      animate();

      if (opts.controls.toggle) {
        opts.controls.toggle.on('click', function () {
          isPause = !isPause;
          $(document).trigger('royalTickerToggle', thisTicker, isPause);
        });
      }

      if (opts.pauseOnHover) {
        thisTicker.on('mouseenter', () => { isPause = true; });
        thisTicker.on('mouseleave', () => { isPause = false; });
      }
      if (opts.pauseOnFocus) {
        thisTicker.on('focusin', () => { isPause = true; });
        thisTicker.on('focusout', () => { isPause = false; });
      }
    }

    // Controls for non-marquee types
    if (opts.type !== 'marquee') {
      opts.controls.prev && opts.controls.prev.on('click', function (e) {
        e.preventDefault();
        (opts.type === 'typewriter') ? typeWriter('prev') : vertiZontal('prev');
      });

      opts.controls.next && opts.controls.next.on('click', function (e) {
        e.preventDefault();
        (opts.type === 'typewriter') ? typeWriter('next') : vertiZontal('next');
      });

      opts.controls.toggle && opts.controls.toggle.on('click', function (e) {
        e.preventDefault();
        isPause = !isPause;
        $(document).trigger('royalTickerToggle', thisTicker, isPause);
        init();
      });

      if (opts.pauseOnHover) {
        thisTicker.on('mouseenter', () => { isPause = true; init(); });
        thisTicker.on('mouseleave', () => { isPause = false; init(); });
      }
      if (opts.pauseOnFocus) {
        thisTicker.on('focusin', () => { isPause = true; init(); });
        thisTicker.on('focusout', () => { isPause = false; init(); });
      }
    }
  };

  // Plugin Defaults
  $.fn.RoyalTicker.defaults = {
    type: 'horizontal',       // vertical / horizontal / marquee / typewriter
    autoplay: 2000,           // autoplay delay in ms
    speed: 1,                 // px per animation frame (for marquee), or ms for others
    direction: 'left',        // up / down / left / right
    pauseOnFocus: true,
    pauseOnHover: true,
    controls: {
      prev: '',
      next: '',
      toggle: ''
    }
  };

  // Elementor Scoped Init
  $(w).on('elementor/frontend/init', function () {
    const RoyalTickerHandler = function ($scope, $) {
      const $el = $scope.find('.royalnewstickerhandler');
      if (!$el.length) return;

      const instance = $('#' + $el.attr('id'));
      instance.RoyalTicker({
        type: $el.data('style'),
        direction: $el.data('direction'),
        speed: $el.data('speed'),
        pauseOnFocus: $el.data('pauseonfocus'),
        pauseOnHover: $el.data('pauseonhover'),
        controls: {
          prev: $('.royalnewsticker-prev', $scope),
          toggle: $('.royalnewsticker-pause', $scope),
          next: $('.royalnewsticker-next', $scope)
        }
      });
    };

    elementorFrontend.hooks.addAction(
      'frontend/element_ready/royalticker.default',
      RoyalTickerHandler
    );
  });

})(jQuery, window);
