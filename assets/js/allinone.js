
/*Royal Mobile Menu Start ---------------------------------*/
jQuery.noConflict();
(function( $ ) {
    $(function() {
        // More code using $ as alias to jQuery
        $(function(){
            var $ul   =   $('.royalmobilemenu');
            
            $ul.find('li a').click(function(e){
            var $li = $(this).parent();
            
            if($li.find('ul').length > 0){
                e.preventDefault();
                
                if($li.hasClass('selected')){
                $li.removeClass('selected').find('li').removeClass('selected');
                $li.find('ul').slideUp(400);
                }else{
                
                if($li.parents('li.selected').length == 0){
                    $ul.find('li').removeClass('selected');
                    $ul.find('ul').slideUp(400);
                }else{
                    $li.parent().find('li').removeClass('selected');
                    $li.parent().find('> li ul').slideUp(400);
                }
                
                $li.addClass('selected');
                $li.find('>ul').slideDown(400);
                }
            }
            });
            
            
            $('.royalmobilemenu ul').each(function(i){
            if($(this).find('>li>ul').length > 0){
                var paddingLeft = $(this).parent().parent().find('>li>a').css('padding-left');
                var pIntPLeft   = parseInt(paddingLeft);
                var result      = pIntPLeft + 10;
                
                $(this).find('>li>a').css('padding-left',result);
            }else{
                var paddingLeft = $(this).parent().parent().find('>li>a').css('padding-left');
                var pIntPLeft   = parseInt(paddingLeft);
                var result      = pIntPLeft + 10;
                
                $(this).find('>li>a').css('padding-left',result).parent().addClass('selected--last');
            }
            });
            
            
            var activeLi = $('li.selected');
            if(activeLi.length){
            opener(activeLi);
            }
            
            function opener(li){
            var ul = li.closest('ul');
            if(ul.length){
                
                li.addClass('selected');
                ul.addClass('open');
                
                if(ul.closest('li').length){
                opener(ul.closest('li'));
                }else{
                return false;
                }
                
            }
            }
            
        });  
        // More code using $ as alias to jQuery
    });
})(jQuery);



/* Royal Mobile Menu Start ---------------------------------*/ 
jQuery(document).ready(function($) {
var openMobileMenu = function(){
    $(".elementor-widget-royalnavmenumobile").addClass("displayblock");
}

var closeMobileMenu = function(){
    $(".elementor-widget-royalnavmenumobile").removeClass("displayblock");
}


$('.royalmobilemenushow').click( function(event) {
    event.stopPropagation();
    $(this).is('.displayblock') ? closeMobileMenu() : openMobileMenu();
});


$('.elementor-widget-royalnavmenumobile .close').click( function(event) {
    event.stopPropagation();
    $(this).is('.displayblock') ? openMobileMenu() : closeMobileMenu();
});


$(document).click( function(event){
    if ( !$(event.target).closest('.royalmobilemenuwarper').length ) {
        closeMobileMenu();   
    }
});

});
/* Royal Mobile Menu End ---------------------------------*/ 







/* Royal Cart Start  ---------------------------------*/
jQuery(document).ready(function($) {
    var openMobileMenu = function(){
        $(".royalwoocartcontainer").addClass("displayblock");
    }
    
    var closeMobileMenu = function(){
        $(".royalwoocartcontainer").removeClass("displayblock");
    }
    
    
    $('.royalwoocartshow').click( function(event) {
        event.stopPropagation();
        $(this).is('.displayblock') ? closeMobileMenu() : openMobileMenu();
    });
    
    
    $('.royalwoocartcontainer .close').click( function(event) {
        event.stopPropagation();
        $(this).is('.displayblock') ? openMobileMenu() : closeMobileMenu();
    });
    
    
    $(document).click( function(event){
        if ( !$(event.target).closest('.royalwoocartcontainer').length ) {
            closeMobileMenu();   
        }
    });
    
    });
/* Royal Cart End  ---------------------------------*/




// Royal Scroll to Top (Legacy Fallback)
jQuery(document).ready(function($){
    var $legacyScrollTop = $('#royalscrolltotop');
    if ($legacyScrollTop.length && !$legacyScrollTop.closest('.royal-scroll-to-top-wrap').length) {
        $(window).scroll(function(){
            if ($(this).scrollTop() < 200) {
                $legacyScrollTop.fadeOut();
            } else {
                $legacyScrollTop.fadeIn();
            }
        });
        $legacyScrollTop.on('click', function(){
            $('html, body').animate({scrollTop:0}, 800);
            return false;
        });
    }
});
