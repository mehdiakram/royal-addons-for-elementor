"use strict";
;
(function ($) {
  'use strict';
  var $window = $(window);
  $window.on('elementor/frontend/init', function () {

    const magneticElements = document.querySelectorAll(".magnetic");
    magneticElements.forEach((magneticElement) =>{
        magneticElement.addEventListener("mousemove", function(e){
            let rect = magneticElement.getBoundingClientRect();

            let x = (e.clientX - rect.left - rect.width / 100) * .5;
            let y = (e.clientY - rect.top - rect.width / 100) * .5;

            magneticElement.style.transform = "translate(" + x + "px, " + y + "px)";
            magneticElement.style.scale = "1.1";
            magneticElement.style.transition = ".1s ease, .3s ease";
            magneticElement.style.transitionProperty = "transform, scale";
            magneticElement.style.cursor = "pointer";
            magneticElement.style.zIndex = "999";
        });

        magneticElement.addEventListener("mouseout", function(e){
            magneticElement.style.transform = "translate(0px, 0px)";
            magneticElement.style.scale = "1";
            magneticElement.style.transition = ".3s ease, .3s ease";
            magneticElement.style.transitionProperty = "transform, scale";
            magneticElement.style.zIndex = "inherit";
        });
    });
	
	
  });
})(jQuery);