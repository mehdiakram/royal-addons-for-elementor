(function ($) {
    var RoyalHeadingScrollTriggerHandler = function ($scope, $) {

        var $_this              = $scope.find('.royalheadingscrolltrigger');
        let triggerid           = '#'+$_this.attr('id');
        let triggerselect       = document.querySelector(triggerid);
        let royaltext           = triggerselect.querySelector('.royaltext');

        let gsap_element        = $_this.data('gsap_element');
            if(gsap_element == "char"){
                gsap_element_class  = triggerid + ' .royaltext .char';
            }else if(gsap_element == "word"){
                gsap_element_class  = triggerid + ' .royaltext .word';
            }else if(gsap_element == "all"){
                gsap_element_class  = triggerid + ' .royaltext'; 
            }else{
                gsap_element_class  = triggerid + ' .royaltext';
            }


        let from_opacity        = $_this.data('from_opacity');
        let to_opacity          = $_this.data('to_opacity');
        let from_color          = $_this.data('from_color');
        let to_color            = $_this.data('to_color');
        let from_filter_blur    = $_this.data('from_filter_blur');
        let to_filter_blur      = $_this.data('to_filter_blur');
        let from_scalex         = $_this.data('from_scalex');
        let to_scalex           = $_this.data('to_scalex');
        let from_scaley         = $_this.data('from_scaley');
        let to_scaley           = $_this.data('to_scaley');
        let from_xpercent       = $_this.data('from_xpercent');
        let to_xpercent         = $_this.data('to_xpercent');
        let from_ypercent       = $_this.data('from_ypercent');
        let to_ypercent         = $_this.data('to_ypercent');
        let from_xposition      = $_this.data('from_xposition');
        let to_xposition        = $_this.data('to_xposition');
        let from_yposition      = $_this.data('from_yposition');
        let to_yposition        = $_this.data('to_yposition');
        let from_rotatex        = $_this.data('from_rotatex');
        let to_rotatex          = $_this.data('to_rotatex');

        let duration            = $_this.data('duration');
        let staggeramount       = $_this.data('staggeramount');
        let staggerfrom         = $_this.data('staggerfrom');
        let staggereach         = $_this.data('staggereach');
        let staggergrid         = $_this.data('staggergrid');
        if(staggergrid ="none"){
            staggergrid         = null;
        }else{
            staggergrid         = $_this.data('staggergrid');
        }
        
        let staggeraxis         = $_this.data('staggeraxis');
        let staggerease         = $_this.data('staggerease');
        let scrolltriggerpin    = $_this.data('scrolltriggerpin');
        let scrolltriggerstart  = $_this.data('scrolltriggerstart');
        let scrolltriggerend    = $_this.data('scrolltriggerend');
        let scrolltriggerscrub  = $_this.data('scrolltriggerscrub');
        let scrolltriggerease   = $_this.data('scrolltriggerease');
        let scrolltriggermarkers   = $_this.data('scrolltriggermarkers');

        gsap.registerPlugin(ScrollTrigger);
        
        Splitting({
          target: royaltext,
          by: "chars",
          key: null
        });
        
        
        gsap.fromTo(
            gsap_element_class,
            { 
                display: "inline-block",

                opacity: from_opacity,
                color: from_color,
                filter: "blur(" + from_filter_blur + "px)",
                scaleX: from_scalex,
                scaleY: from_scaley,
                xPercent: from_xpercent,
                yPercent: from_ypercent,
                x: from_xposition,
                y: from_yposition,
                rotateX: from_rotatex,
            },

            {
                opacity: to_opacity,
                color: to_color,
                filter: "blur(" + to_filter_blur + "px)",
                scaleX: to_scalex,
                scaleY: to_scaley,
                xPercent: to_xpercent,
                y: to_ypercent,
                x: to_xposition,
                y: to_yposition,
                rotateX: to_rotatex,

            
                duration: duration,
                stagger: {
                  amount: staggeramount,
                  from: staggerfrom,
                  each: staggereach,
                  grid: staggergrid,
                  axis: staggeraxis,
                  ease: staggerease,
                },
                scrollTrigger: {
                    trigger: royaltext,
                    pin: scrolltriggerpin,
                    start: scrolltriggerstart,
                    end: scrolltriggerend,
                    scrub: scrolltriggerscrub,
                    ease: scrolltriggerease,
                    markers: scrolltriggermarkers,
                },
            }
        );
     
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalheadingscrolltrigger.default', RoyalHeadingScrollTriggerHandler);
    });
})(jQuery);

