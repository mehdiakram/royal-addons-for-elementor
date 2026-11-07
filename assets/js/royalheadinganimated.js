(function ($) {
    var RoyalHeadingAnimatedHandler = function ($scope, $) {

        var $elem = $scope.find(".royal-atext__wrapper"),
            settings = $elem.data("settings"),
            loadingSpeed = settings.delay || 2500,
            $animatedText = $elem.find('.royal-atext__text');


        function escapeHtml(unsafe) {
            return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(
                /"/g, "&quot;");
        }

        if ('switch' === settings.style) {

            var itemCount = $elem.find('.royal-fancy-list-items').length,
                loopCount = ('' === settings.count && !['typing', 'slide', 'autofade'].includes(settings.effect)) ? 'infinite' : (settings.count * itemCount);

            if ("typing" === settings.effect) {

                var fancyStrings = [];

                settings.strings.forEach(function (item) {
                    fancyStrings.push(escapeHtml(item));
                });
                var fancyTextID = '#' + $animatedText.attr('id');
                var typedInstance = new Typed(fancyTextID, {
                    strings: fancyStrings,
                    typeSpeed: settings.typeSpeed,
                    backSpeed: settings.backSpeed,
                    startDelay: settings.startDelay,
                    backDelay: settings.backDelay,
                    showCursor: settings.showCursor,
                    cursorChar: settings.cursorChar,
                    loop: settings.loop
                });

                //To start/stop programmatically.
                if ($scope.hasClass("fancy-text-stop")) {
                    typedInstance.stop();
                }

                $(".fancy-text-stop").bind("fancy-text-start", function () {
                    typedInstance.start();
                });


            } else if ("slide" === settings.effect) {
                loadingSpeed = settings.pause;

                $animatedText.vTicker({
                    speed: settings.speed,
                    showItems: settings.showItems,
                    pause: settings.pause,
                    mousePause: settings.mousePause,
                    direction: "up"
                });

            } else {

                setFancyAnimation();

                function setFancyAnimation() {

                    var $item = $elem.find(".royal-fancy-list-items"),
                        $stringsWrap = $elem.find('.royal-atext__items-wrapper'),
                        current = 1;

                    //Get effect settings
                    var delay = settings.delay || 2500,
                        loopCount = settings.count;

                    //If Loop Count option is set
                    if (loopCount) {
                        var currentLoop = 1,
                            fancyStringsCount = $elem.find(".royal-fancy-list-items").length;
                    }

                    var loopInterval = setInterval(function () {

                        if ('clip' === settings.effect) {

                            $stringsWrap.animate({
                                width: 0
                            }, (settings.speed / 2) || 1000, function () {

                                //Show current active item
                                $item.eq(current).addClass("royal-fancy-item-visible").removeClass("royal-fancy-item-hidden");

                                var $inactiveItems = $item.filter(function (index) {
                                    return index !== current;
                                });

                                //Hide inactive items
                                $inactiveItems.addClass("royal-fancy-item-hidden").removeClass("royal-fancy-item-visible");

                                var visibleTextWidth = $stringsWrap.find('.royal-fancy-item-visible').outerWidth();

                                $stringsWrap.animate({
                                    width: visibleTextWidth + 10
                                }, (settings.speed / 2) || 1000, function () {

                                    current++;

                                    //Restart loop
                                    if ($item.length === current)
                                        current = 0;

                                    //Increment interval and check if loop count is reached
                                    if (loopCount) {
                                        currentLoop++;

                                        if ((fancyStringsCount * loopCount) === currentLoop)
                                            clearInterval(loopInterval);
                                    }

                                });

                            });
                        } else {

                            var animationClass = "";

                            //Add animation class
                            if (settings.effect === "custom")
                                animationClass = "animated " + settings.animation;

                            $stringsWrap.css('transition', 'width 0.5s');

                            //Show current active item
                            $item.eq(current).addClass("royal-fancy-item-visible " + animationClass).removeClass("royal-fancy-item-hidden");

                            var $inactiveItems = $item.filter(function (index) {
                                return index !== current;
                            });

                            //Hide inactive items
                            $inactiveItems.addClass("royal-fancy-item-hidden").removeClass("royal-fancy-item-visible " + animationClass);

                            var visibleTextWidth = $stringsWrap.find('.royal-fancy-item-visible').outerWidth();

                            $stringsWrap.css('width', visibleTextWidth);

                            current++;

                            //Restart loop
                            if ($item.length === current)
                                current = 0;

                            //Increment interval and check if loop count is reached
                            if (loopCount) {
                                currentLoop++;

                                if ((fancyStringsCount * loopCount) === currentLoop)
                                    clearInterval(loopInterval);
                            }

                        }

                    }, delay);

                }
            }

            //Show the strings after the layout is set.
            if ("typing" !== settings.effect) {
                setTimeout(function () {
                    $animatedText.css('opacity', '1');
                }, 500);

            }

            if (settings.loading && 'typing' !== settings.effect) {
                $scope.find('.royal-atext__text').append('<span class="royal-loading-bar"></span>');
                $scope.find('.royal-loading-bar').css({
                    'animation-iteration-count': loopCount,
                    'animation-duration': loadingSpeed + 'ms'
                });
            }
        } else {

            var highlightEffect = settings.effect;

            if (['tilt', 'flipx', 'wave', 'pop', 'sideslide', 'revolvedrop', 'revolvescale', 'balldrop', 'dropvanish', 'twister', 'leftright'].includes(highlightEffect)) {

                var textArray = $animatedText.text().trim().split("");


                // element.firstChild.remove();

                var elArray = textArray.map(function (letter, index) {

                    if (letter == " ")
                        letter = '&nbsp;';

                    var el = document.createElement("span");

                    el.className = "royal-atext__letter";
                    el.innerHTML = letter;
                    el.style.animationDelay = index / (textArray.length) + "s";

                    return el;
                });

                $animatedText.html(elArray);
                setTimeout(function () {
                    $elem.css('opacity', 1);
                }, 1000);


            } else if (['flipy',  'scaledown'].includes(highlightEffect)) {
                var textArray = $animatedText.text().trim().split("");
                var elArray = textArray.map(function (letter, index) {

                    if (letter == " ")
                        letter = '&nbsp;';

                    var el = document.createElement("span");

                    el.className = "royal-atext__letter";
                    el.innerHTML = letter;
                    //.style.animationDelay = index / (textArray.length) + "s";

                    return el;
                });

                $animatedText.html(elArray);
                setTimeout(function () {
                    $elem.css('opacity', 1);
                }, 1000);


            } else if ('shape' === highlightEffect) {

                var animationDelay = settings.delay || 4,
                    animationSpeed = settings.duration || 1.2;

                    $elem.addClass('draw-shape');

                    setInterval(function () {
                        $elem.addClass('hide-shape');

                        setTimeout(function () {
                            $elem.removeClass('hide-shape');
                        }, 1000);
                    }, 1000 * (animationSpeed + animationDelay));

               

            }

        }

    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalheadinganimated.default', RoyalHeadingAnimatedHandler);
    });
})(jQuery);

