    (function($) {
      var AgeGateHandler = function($scope, $) {
      // Make sure we run this code under Elementor
      if (elementorFrontend.isEditMode()) {
        localStorage.removeItem("royalagegate-expire-time");
        if ($scope.find('.royalagegate-wrapper').length) {
          var editor_mood = $scope.find('.royalagegate-wrapper').data('editor_mood');
          if ('no' == editor_mood) {
            $scope.find('.royalagegate-wrapper').hide();
          }
        }
      } else if (!elementorFrontend.isEditMode()) {
        var container = $scope.find('.royalagegate-wrapper'),
          cookies_time = container.data('age_gate_cookies_time'),
          exd = localStorage.getItem("royalagegate-expire-time");
        //container.closest("body").find("header").css("display","none");
        container.closest("body").css("overflow", "hidden");
        var cdate = new Date();
        var endDate = new Date();
        endDate.setDate(cdate.getDate() + cookies_time);
        if (exd != '' && exd != undefined && new Date(cdate) <= new Date(exd)) {
          $('.royalagegate-wrapper').hide();
          container.closest("body").css("overflow", "");
        } else if (exd != '' && exd != undefined && new Date(cdate) > new Date(exd)) {
          localStorage.removeItem("royalagegate-expire-time");
          $('.royalagegate-wrapper').show();
        } else {
          $('.royalagegate-wrapper').show();
        }

        /*confirm-age*/
        if ($scope.find('.royalagegate-wrapper.royalagegate-confirm-age').length) {
          $(".royalagegate-confirm-age-btn").on("click", function () {
            localStorage.setItem("royalagegate-expire-time", endDate);
            $(this).closest(".royalagegate-wrapper").hide();
            //$(this).closest("body").find("header").css("display","block");
            $(this).closest("body").css("overflow", "");
          });
        }

        /*confirm-dob*/
        if ($scope.find('.royalagegate-wrapper.royalagegate-confirm-dob').length) {
          $(".royalagegate-confirm-dob-btn").on("click", function () {
            var birthYear = new Date(Date.parse($(this).closest('.royalagegate-form-body').find('.royalagegate-date-input').val())),
              agebirth = birthYear.getFullYear(),
              currentYear = cdate.getFullYear(),
              userage = currentYear - agebirth,
              agelimit = $(this).closest('.royalagegate-wrapper').data("userbirth");
            if (userage < agelimit) {
              $(this).closest('.royalagegate-boxes').find('.royalagegate-warning-msg').show();
            } else {
              localStorage.setItem("royalagegate-expire-time", endDate);
              $(this).closest('.royalagegate-wrapper').hide();
              //$(this).closest("body").find("header").css("display","block");
              $(this).closest("body").css("overflow", "");
            }
          });
        }

        /*confirm-by-boolean*/
        if ($scope.find('.royalagegate-wrapper.royalagegate-confirm-by-boolean').length) {
          $(".royalagegate-wrapper .royalagegate-confirm-yes-btn").on("click", function () {
            localStorage.setItem("royalagegate-expire-time", endDate);
            $(this).closest('.royalagegate-wrapper').hide();
            //$(this).closest("body").find("header").css("display","block");
            $(this).closest("body").css("overflow", "");
          });
          $(".royalagegate-wrapper .royalagegate-confirm-no-btn").on("click", function () {
            $(this).closest('.royalagegate-boxes').find('.royalagegate-warning-msg').show();
          });
        }
      }
    
      
      // Make sure we run this code under Elementor
      };
      $(window).on('elementor/frontend/init', function() {
          elementorFrontend.hooks.addAction('frontend/element_ready/royalagegate.default', AgeGateHandler);
      });
  })(jQuery);