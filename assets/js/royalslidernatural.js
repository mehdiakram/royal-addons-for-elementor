(function($) {
    var RoyalSliderNaturalHandler = function($scope, $) {
    // Make sure we run this code under Elementor
        var $_this          = $scope.find('.royalslidernatural');
        let sliderid        = '#'+$_this.attr('id');
        let interval        = $_this.data('interval') * 1000;
        let indicator       = $_this.data('indicator');
        let naturalslider   = document.querySelector(sliderid);

        let firstslide         = naturalslider.querySelector('.slide:nth-child(1)');
        let firstpagination    = naturalslider.querySelector('.slide-pagination .slide-btn:nth-child(1)');
        let firstindicator     = naturalslider.querySelector('.slide-indicator-bars .indicator-bar:nth-child(1)');
        firstslide.classList.add('active');
        firstpagination.classList.add('active');
        
        if(indicator =='yes'){
            firstindicator.classList.add('active');
        }

        var playSlider;
        var repeater = () =>{
            playSlider = setInterval(function(){ if (window.elementorFrontend && elementorFrontend.isEditMode()) return;
                slides.forEach((slide) => {
                    slide.classList.remove("active");
                });
        
                slideBtns.forEach((slideBtn) => {
                    slideBtn.classList.remove("active");
                });
        
                slideIndicatorBars.forEach((slideIndicatorBar) => {
                    slideIndicatorBar.classList.remove("active");
                });
        
                slideNumber++;
                
                if(slideNumber > (numberOfSlides - 1)){
                    slideNumber = 0;
                }
        
                slides[slideNumber].classList.add("active");
                slideBtns[slideNumber].classList.add("active");
                slideIndicatorBars[slideNumber].classList.add("active");
            }, interval);
        }
    
        repeater();
    
        const slider = naturalslider.querySelector(".slider");
        const slides = slider.querySelectorAll(".slide");
        const numberOfSlides = slides.length;
        const slideBtns = naturalslider.querySelectorAll(".slide-btn");
        const slideIndicatorBars = naturalslider.querySelectorAll(".indicator-bar");
        var slideNumber = 0;
    
        const nextBtn = naturalslider.querySelector(".next-btn");
        const prevBtn = naturalslider.querySelector(".prev-btn");
    
        nextBtn.addEventListener("click", () =>{
            slides.forEach((slide) => {
                slide.classList.remove("active");
            });
    
            slideBtns.forEach((slideBtn) => {
                slideBtn.classList.remove("active");
            });
    
            slideIndicatorBars.forEach((slideIndicatorBar) => {
                slideIndicatorBar.classList.remove("active");
            });
    
            slideNumber++;
            
            if(slideNumber > (numberOfSlides - 1)){
                slideNumber = 0;
            }
    
            slides[slideNumber].classList.add("active");
            slideBtns[slideNumber].classList.add("active");
            slideIndicatorBars[slideNumber].classList.add("active");
    
            clearInterval(playSlider);
            repeater();
    
        });
    
        prevBtn.addEventListener("click", () =>{
            slides.forEach((slide) => {
                slide.classList.remove("active");
            });
    
            slideBtns.forEach((slideBtn) => {
                slideBtn.classList.remove("active");
            });
    
            slideIndicatorBars.forEach((slideIndicatorBar) => {
                slideIndicatorBar.classList.remove("active");
            });
    
            slideNumber--;
            
            if(slideNumber < 0){
                slideNumber = numberOfSlides -1;
            }
    
            slides[slideNumber].classList.add("active");
            slideBtns[slideNumber].classList.add("active");
            slideIndicatorBars[slideNumber].classList.add("active");
    
            clearInterval(playSlider);
            repeater();
        });
    
        var slideBtnNav = function(slideBtnlick){
            slides.forEach((slide) => {
                slide.classList.remove("active");
            });
    
            slideBtns.forEach((slideBtn) => {
                slideBtn.classList.remove("active");
            });
    
            slideIndicatorBars.forEach((slideIndicatorBar) => {
                slideIndicatorBar.classList.remove("active");
            });
    
            slides[slideBtnlick].classList.add("active");
            slideBtns[slideBtnlick].classList.add("active");
            slideIndicatorBars[slideBtnlick].classList.add("active");
        };
    
        slideBtns.forEach((slideBtn, i) =>{
            slideBtn.addEventListener("click", () =>{
                slideBtnNav(i);
                clearInterval(playSlider);
                repeater();
                slideNumber = i;
            })
    
        });
    
        slides.forEach((slide, i) =>{
            let watchVideoBtn = slide.querySelector(".watch-video-btn");
            let slideVideoModal = slide.querySelector(".slide-video-modal");
            let videoModalContent = slide.querySelector(".video-modal-content");
            let videoCloseBtn = slide.querySelector(".video-close-btn");
            let animalVideo = slide.querySelector(".animal-video");
            //let youtubeVideo = slide.querySelector(".youtube");
    
            watchVideoBtn.addEventListener("click", () =>{
                slideVideoModal.classList.add("active");
                
                setTimeout(() => {
                    videoModalContent.classList.add("active");
                }, 300);
    
                if (animalVideo instanceof NodeList) {
                    animalVideo.play();
                }
    
                if(slideVideoModal.classList.contains("active")){
                    clearInterval(playSlider);
                }
            });
    
            slideVideoModal.addEventListener("mouseover", () =>{
                clearInterval(playSlider);
            });
    
            const videoClose = function(closeBtnClick){
    
                slideIndicatorBars.forEach((slideIndicatorBar)=>{
                    slideIndicatorBar.classList.remove("active");
                });
    
                setTimeout(() => {
                    slideIndicatorBars[closeBtnClick].classList.add("active");
                }, 0);
                
            }
    
            videoCloseBtn.addEventListener("click", () =>{
                slideVideoModal.classList.remove("active");
                videoModalContent.classList.remove("active");
    
                slideIndicatorBars.forEach((slideIndicatorBar)=>{
                    slideIndicatorBar.classList.remove("active");
                });
    
                
                if (animalVideo instanceof NodeList) {
                    animalVideo.pause();
                }
                
    
                clearInterval(playSlider);
                repeater();
                videoClose(i);
            });
            
    
        });

    // Make sure we run this code under Elementor
    };
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalslidernatural.default', RoyalSliderNaturalHandler);
    });
})(jQuery);
