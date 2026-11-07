(function($) {
    var RoyalSliderBlurHandler = function($scope, $) {
        var $_this          = $scope.find('.royalsliderblur');
        let sliderid        = '#'+$_this.attr('id');
        let interval        = $_this.data('interval');
        let prevbutton      = $_this.data('prev');
        let nextbutton      = $_this.data('next');
        let backbutton      = $_this.data('back');

        let nextDom         = document.getElementById(nextbutton);
        let prevDom         = document.getElementById(prevbutton);
        let backDom         = document.getElementById(backbutton);
        let carousel        = document.querySelector(sliderid);
        let listHTML        = carousel.querySelector('.list');
        let seeMoreButtons  = carousel.querySelectorAll('.seemore');
    
        nextDom.onclick = function(){
            showSlider('next');
        }

        prevDom.onclick = function(){
            showSlider('prev');
        }
        
        let unAcceppClick;
        const showSlider = (type) => {
            nextDom.style.pointerEvents = 'none';
           prevDom.style.pointerEvents = 'none';
        
            carousel.classList.remove('next', 'prev');
            let items = listHTML.querySelectorAll('.item');

            if(type === 'next'){
                listHTML.appendChild(items[0]);
                carousel.classList.add('next');
            }else{
                listHTML.prepend(items[items.length - 1]);
                carousel.classList.add('prev');
            }
            clearTimeout(unAcceppClick);
            unAcceppClick = setTimeout(()=>{
                nextDom.style.pointerEvents = 'auto';
                prevDom.style.pointerEvents = 'auto';
            }, 2000)
        }
        
        seeMoreButtons.forEach((button) => {
            button.onclick = function(){
                carousel.classList.remove('next', 'prev');
                carousel.classList.add('showdetail');
            }
        });
        
        backDom.onclick = function(){
            carousel.classList.remove('showdetail');
        }
        
        setInterval(() => { if (window.elementorFrontend && elementorFrontend.isEditMode()) return;
            if (carousel.classList.contains('showdetail')) {
            } else {
                showSlider('next');
            }
        }, interval);



    };
    
    // Make sure we run this code under Elementor
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalwoosliderblur.default', RoyalSliderBlurHandler);
    });
})(jQuery);
