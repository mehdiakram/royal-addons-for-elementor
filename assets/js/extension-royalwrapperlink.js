"use strict";
;
(function ($) {
  'use strict';
  var $window = $(window);
  $window.on('elementor/frontend/init', function () {
	  
    // royalwrapperlink
    $('body').on('click.onWrapperLink', '[data-royal-element-link]', function () {
      var $wrapper = $(this),
          data = $wrapper.data('royal-element-link'),
          id = $wrapper.data('id'),
          anchor = document.createElement('a'),
          anchorReal,
          timeout;
      anchor.id = 'royal-wrapper-link-' + id;
      anchor.href = data.url;
      anchor.target = data.is_external ? '_blank' : '_self';
      anchor.rel = data.nofollow ? 'nofollow noreferer' : '';
      anchor.style.display = 'none';
      document.body.appendChild(anchor);
      anchorReal = document.getElementById(anchor.id);
      anchorReal.click();
      timeout = setTimeout(function () {
        document.body.removeChild(anchorReal);
        clearTimeout(timeout);
      });
    });	
	// royalwrapperlink
	
	
  });
})(jQuery);