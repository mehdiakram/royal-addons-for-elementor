(function($) {
  var RoyalImageCarousel3DHandler = function($scope, $) {
      var $_this      = $scope.find('.royalimagecarousel3d');
      $sliderid       = '#'+$_this.attr('id');
      $spinid         = $_this.data('spinid');
      $cargroundid    = $_this.data('groundid');

      var radius      = $_this.data('radius'); // how big of the radius
      var autoRotate  = true; // auto rotate or not
      var rotateSpeed = $_this.data('rotatespeed'); // unit: seconds/360 degrees
      var imgWidth    = $_this.data('imgwidth'); // width of images (unit: px)
      var imgHeight   = $_this.data('imgheight'); // height of images (unit: px)
      var timeout     = $_this.data('timeout'); // height of images (unit: px)
      
      setTimeout(init, timeout);
      
      var odrag       = document.querySelector($sliderid);
      var ospin       = document.getElementById($spinid);
      var aImg        = ospin.getElementsByTagName('img');
      var aVid        = ospin.getElementsByTagName('video');
      var aEle        = [...aImg, ...aVid]; // combine 2 arrays
      
      // Size of images
      ospin.style.width = imgWidth + "px";
      ospin.style.height = imgHeight + "px";
      
      var ground = document.getElementById($cargroundid);
      ground.style.width = radius * 3 + "px";
      ground.style.height = radius * 3 + "px";
      
      function init(delayTime) {
        for (var i = 0; i < aEle.length; i++) {
          aEle[i].style.transform = "rotateY(" + (i * (360 / aEle.length)) + "deg) translateZ(" + radius + "px)";
          aEle[i].style.transition = "transform 1s";
          aEle[i].style.transitionDelay = delayTime || (aEle.length - i) / 4 + "s";
        }
      }
      
      function applyTranform(obj) {
        // Constrain the angle of camera (between 0 and 180)
        if(tY > 180) tY = 180;
        if(tY < 0) tY = 0;
      
        // Apply the angle
        obj.style.transform = "rotateX(" + (-tY) + "deg) rotateY(" + (tX) + "deg)";
      }
      
      function playSpin(yes) {
        ospin.style.animationPlayState = (yes?'running':'paused');
      }
      
      var sX, sY, nX, nY, desX = 0,
          desY = 0,
          tX = 0,
          tY = 10;
      
      // auto spin
      if (autoRotate) {
        var animationName = (rotateSpeed > 0 ? 'royalimagecarousel3dspin' : 'royalimagecarousel3dspinRevert');
        ospin.style.animation = `${animationName} ${Math.abs(rotateSpeed)}s infinite linear`;
      }
      
      // setup events
      odrag.onpointerdown = function (e) {
        clearInterval(odrag.timer);
        e = e || window.event;
        var sX = e.clientX,
            sY = e.clientY;
      
        this.onpointermove = function (e) {
          e = e || window.event;
          var nX = e.clientX,
              nY = e.clientY;
          desX = nX - sX;
          desY = nY - sY;
          tX += desX * 0.1;
          tY += desY * 0.1;
          applyTranform(odrag);
          sX = nX;
          sY = nY;
        };
      
        this.onpointerup = function (e) {
          odrag.timer = setInterval(function () {
            desX *= 0.95;
            desY *= 0.95;
            tX += desX * 0.1;
            tY += desY * 0.1;
            applyTranform(odrag);
            playSpin(false);
            if (Math.abs(desX) < 0.5 && Math.abs(desY) < 0.5) {
              clearInterval(odrag.timer);
              playSpin(true);
            }
          }, 17);
          this.onpointermove = this.onpointerup = null;
        };
      
        return false;
      };
      
      odrag.onmousewheel = function(e) {
        e = e || window.event;
        var d = e.wheelDelta / 20 || -e.detail;
        radius += d;
        init(1);
      };


  };
  
  // Make sure we run this code under Elementor
  $(window).on('elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction('frontend/element_ready/royalimagecarousel3d.default', RoyalImageCarousel3DHandler);
  });
})(jQuery);