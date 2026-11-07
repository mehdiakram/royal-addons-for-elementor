jQuery.noConflict();
    (function( $ ) {
        $(function() {
             // More code using $ as alias to jQuery  

            $(function() {
                var selectedClass = "";
                $(".royalportfoliofiltercat").click(function(){   
                    selectedClass = $(this).attr("data-rel");
                    $("#royalportfoliofilters button").not("."+selectedClass).removeClass('active');
                    $(this).addClass('active');
                    
                    $("#royalportfolio").fadeTo(300, 0.1);
                    $("#royalportfolio div").not("."+selectedClass).fadeOut().removeClass('scaleanimation');
                    setTimeout(function() {
                    $("."+selectedClass).fadeIn().addClass('scaleanimation');
                    $("#royalportfolio").fadeTo(300, 1);
                    }, 300); 
                });
            }); 

            // More code using $ as alias to jQuery
    });
})(jQuery);