( function ( $ ) {	
    $.fn.equalHeights = function() {
      var max_height = 0;
      // Reset min-height first so it can shrink on window resize
      $(this).css('min-height', '');
      $(this).each(function() {
        max_height = Math.max($(this).outerHeight(), max_height);
      });
      if (max_height > 0) {
          $(this).css('min-height', max_height);
      }
    };
    
    var applyEqualHeight = function() {
        var container = $('.elementor-element[data-royal-equal-height-loadded]');
        if(container.length){
            container.each(function() {
                var id = $(this).data('id');
                var new_find = $(this).data('royal-equal-height-loadded');
                
                // If it's a direct child selector, use find or children appropriately
                var $target;
                if (new_find.indexOf('>') === 0) {
                    // It's a direct child selector like "> .elementor-element"
                    // In jQuery, we can't easily prepend the ID and keep the > if we do simple concatenation.
                    // Actually `$('.elementor-element-'+id +' '+ new_find)` works in modern jQuery, but `find()` with scope is safer.
                    // Wait, `$('.elementor-element-'+id).find(new_find)` doesn't work if it starts with `>`.
                    // We just use the string since jQuery handles `div > .child` fine.
                    $target = $('.elementor-element-'+id + ' ' + new_find);
                } else {
                    $target = $('.elementor-element-'+id).find(new_find);
                }

                if ($target.length) {
                    $target.equalHeights();
                }
            });	
        }
    };

    $(window).on("load resize", function() {
        applyEqualHeight();
    });

    $(document).on("elementor/frontend/init", function() {
        elementorFrontend.hooks.addAction("frontend/element_ready/global", function() {
            setTimeout(applyEqualHeight, 300);
        });
    });

} ( jQuery ) );