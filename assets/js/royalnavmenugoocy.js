jQuery(window).on('load', function($){
    var $ = jQuery;
    var height = window.innerHeight,
        x = 0, y = height / 2,
        curveX = 10,
        curveY = 0,
        targetX = 0,
        xIteration = 0,
        yIteration = 0,
        menuExpanded = false;

    var blob = $('#blob'),
        blobPath = $('#blob-path'),
        hamburger = $('.hamburger'),
        menuWrapper = $('.royalnavmenugoocy');

    $(document).on('mousemove', function(e){
        x = e.pageX;
        y = e.pageY;
    });

    hamburger.add(menuWrapper.find('.menu-inner')).on('mouseenter', function(){
        menuWrapper.addClass('expanded');
        menuExpanded = true;
    });

    menuWrapper.find('.menu-inner').on('mouseleave', function(){
        menuExpanded = false;
        menuWrapper.removeClass('expanded');
    });

    function easeOutExpo(currentIteration, startValue, changeInValue, totalIterations) {
        return changeInValue * (-Math.pow(2, -10 * currentIteration / totalIterations) + 1) + startValue;
    }

    var hoverZone = 300;
    var expandAmount = 100;

    function svgCurve() {
        if ((curveX > x - 1) && (curveX < x + 1)) {
            xIteration = 0;
        } else {
            if (menuExpanded) {
                targetX = 0;
            } else {
                xIteration = 0;
                if (x > hoverZone) {
                    targetX = 0;
                } else {
                    targetX = -(((60 + expandAmount) / 100) * (x - hoverZone));
                }
            }
            xIteration++;
        }

        if ((curveY > y - 1) && (curveY < y + 1)) {
            yIteration = 0;
        } else {
            yIteration = 0;
            yIteration++;
        }

        curveX = easeOutExpo(xIteration, curveX, targetX - curveX, 100);
        curveY = easeOutExpo(yIteration, curveY, y - curveY, 100);

        var anchorDistance = 200;
        var curviness = anchorDistance - 40;

        var newCurve = "M60," + height + "H0V0h60v" + (curveY - anchorDistance) + 
                       "c0," + curviness + "," + curveX + "," + curviness + "," + 
                       curveX + "," + anchorDistance + "S60," + curveY + ",60," + 
                       (curveY + (anchorDistance * 2)) + "V" + height + "z";

        blobPath.attr('d', newCurve);
        blob.width(curveX + 60);
        hamburger.css('transform', 'translate(' + curveX + 'px, ' + curveY + 'px)');

        window.requestAnimationFrame(svgCurve);
    }

    window.requestAnimationFrame(svgCurve);
});
