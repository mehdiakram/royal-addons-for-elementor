(function($) {
    var RoyalSliderNikeHandler = function($scope, $) {
    // Make sure we run this code under Elementor
        var $_this          = $scope.find('.royalslidernike');
        let sliderid        = '#'+$_this.attr('id');
        let interval        = $_this.data('interval');
        let prevbutton      = $_this.data('prev');
        let nextbutton      = $_this.data('next');

  
        let nextBtn         = document.getElementById(nextbutton);
        let prevBtn         = document.getElementById(prevbutton);
        let carousel        = document.querySelector(sliderid);     
        let items           = carousel.querySelectorAll('.list .item');
        let indicator       = carousel.querySelector('.indicators');
        let dots            = carousel.querySelectorAll('.indicators ul li');


        let active = 0;
        let firstPosition = 0;
        let lastPosition = items.length - 1;
        let autoPlay;

        const startAutoPlay = () => {
            clearInterval(autoPlay); 
            autoPlay = setInterval(() => { if (window.elementorFrontend && elementorFrontend.isEditMode()) return;
                nextBtn.click();
            }, 5000);
        }
        startAutoPlay();

        const setSlider = () => {
            let itemActiveOld = carousel.querySelector('.list .item.active');
            if(itemActiveOld) itemActiveOld.classList.remove('active');
            items[active].classList.add('active');

            let dotActiveOld = carousel.querySelector('.indicators ul li.active');
            if(dotActiveOld) dotActiveOld.classList.remove('active');
            dots[active].classList.add('active');

            indicator.querySelector('.number').innerText = '0' + (active + 1);
            startAutoPlay();
        }
        setSlider();

        nextBtn.onclick = () => {
            active = active + 1 > lastPosition ? 0 : active + 1;
            carousel.style.setProperty('--calculation', 1);
            setSlider();
        }
        prevBtn.onclick = () => {
            active = active - 1 < firstPosition ? lastPosition : active - 1;
            carousel.style.setProperty('--calculation', -1);
            setSlider();
            clearInterval(autoPlay);
            autoPlay = setInterval(() => { if (window.elementorFrontend && elementorFrontend.isEditMode()) return;
                nextBtn.click();
            }, interval);
        }
        dots.forEach((item, position) => {
            item.onclick = () => {
                active = position;
                setSlider();
            }
        })
  
    
    // Make sure we run this code under Elementor
    };
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalwooslidernike.default', RoyalSliderNikeHandler);
    });
})(jQuery);
