(function ($) {

    var RoyalEventCalendar = function RoyalEventCalendar($scope) {
      var calendarEl = $scope.find('.royal-ec');
      var popup = $scope.find('.royal-ec-popup-wrapper');
      var popupClose = $scope.find(".royal-ec-popup-close");
      var events = calendarEl.data('events');
      var initialview = calendarEl.data('initialview');
      var firstday = calendarEl.data('firstday');
      var locale = calendarEl.data('locale');
      var showPopup = calendarEl.data('show-popup');
      var allday_text = calendarEl.data('allday-text');
      if ('undefined' == typeof events) {
        return;
      }
      var option = {
        stickyHeaderDates: false,
        locale: locale,
        headerToolbar: {
          left: "prev,next today",
          center: "title",
          right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
        },
        initialView: initialview,
        firstDay: firstday,
        eventTimeFormat: {
          // like '7pm'
          hour: 'numeric',
          minute: '2-digit',
          meridiem: 'short'
        },
        events: events,
        height: 'auto',
        eventClick: function eventClick(info) {
          if ('yes' == showPopup) {
            // don't let the browser navigate
            var getTheDate = function getTheDate(timeString) {
              return new Date(timeString);
            };
            var timeFormat = function timeFormat(date) {
              var hours = date.getHours();
              var minutes = date.getMinutes();
              var ampm = hours >= 12 ? 'pm' : 'am';
              hours = hours % 12;
              hours = hours ? hours : 12; // the hour '0' should be '12'
              minutes = minutes < 10 ? '0' + minutes : minutes;
              var strTime = hours + ':' + minutes + '' + ampm;
              return strTime;
            };
            info.jsEvent.preventDefault();
            var todayDateString = info.view.calendar.currentData.currentDate.toString(),
              allDay = info.event.allDay,
              title = info.event.title,
              startDate = info.event.startStr,
              endDate = info.event.endStr,
              guest = info.event.extendedProps.guest,
              location = info.event.extendedProps.location,
              description = info.event.extendedProps.description,
              detailsUrl = info.event.url,
              imageUrl = info.event.extendedProps.image;
            var titleWrap = popup.find('.royal-ec-event-title'),
              timeWrap = popup.find('.royal-ec-event-time-wrap'),
              guestWrap = popup.find('.royal-ec-event-guest-wrap'),
              locationWrap = popup.find('.royal-ec-event-location-wrap'),
              descWrap = popup.find('.royal-ec-popup-desc'),
              detailsWrap = popup.find('.royal-ec-popup-readmore-link'),
              imageWrap = popup.find('.royal-ec-popup-image');

            // display none
            imageWrap.css('display', 'none');
            titleWrap.css('display', 'none');
            timeWrap.css('display', 'none');
            guestWrap.css('display', 'none');
            locationWrap.css('display', 'none');
            descWrap.css('display', 'none');
            detailsWrap.css('display', 'none');
            popup.addClass("royal-ec-popup-ready");

            // image markup
            if (imageUrl) {
              imageWrap.removeAttr("style");
              imageWrap.find('img').attr("src", imageUrl);
              imageWrap.find('img').attr("alt", title);
            }

            // title markup
            if (title) {
              titleWrap.removeAttr("style");
              titleWrap.text(title);
            }

            // guest markup
            if (guest) {
              guestWrap.removeAttr("style");
              guestWrap.find('span.royal-ec-event-guest').text(guest);
            }

            // location markup
            if (location) {
              locationWrap.removeAttr("style");
              locationWrap.find('span.royal-ec-event-location').text(location);
            }

            // description markup
            if (description) {
              descWrap.removeAttr("style");
              descWrap.html(description);
            }

            // time markup
            if (allDay !== true) {
              timeWrap.removeAttr("style");
              startDate = Date.parse(getTheDate(startDate));
              endDate = Date.parse(getTheDate(endDate));
              var startTimeText = timeFormat(getTheDate(startDate));
              var endTimeText = 'Invalid Data';
              if (startDate < endDate) {
                endTimeText = timeFormat(getTheDate(endDate));
              }
              timeWrap.find('span.royal-ec-event-time').text(startTimeText + ' - ' + endTimeText);
            } else {
              timeWrap.removeAttr("style");
              timeWrap.find('span.royal-ec-event-time').text(allday_text);
            }

            // read more markup
            if (detailsUrl) {
              detailsWrap.removeAttr("style");
              detailsWrap.attr("href", detailsUrl);
              if ("on" === info.event.extendedProps.external) {
                detailsWrap.attr("target", "_blank");
              }
              if ("on" === info.event.extendedProps.nofollow) {
                detailsWrap.attr("rel", "nofollow");
              }
            }
          } else {
            if (info.event.url && info.event.extendedProps.external) {
              info.jsEvent.preventDefault();
              var id = $scope.data('id'),
                anchor = document.createElement('a'),
                anchorReal,
                timeout;
              anchor.id = 'happy-even-calender-link-' + id;
              anchor.href = info.event.url;
              anchor.target = info.event.extendedProps.external ? '_blank' : '_self';
              anchor.rel = info.event.extendedProps.nofollow ? 'nofollow noreferer' : '';
              anchor.style.display = 'none';
              document.body.appendChild(anchor);
              anchorReal = document.getElementById(anchor.id);
              anchorReal.click();
              timeout = setTimeout(function () {
                document.body.removeChild(anchorReal);
                clearTimeout(timeout);
              });
              return false;
            }
          }
        },
        dateClick: function dateClick(arg) {
          itemDate = arg.date.toUTCString();
        }
      };
      var calendar = new FullCalendar.Calendar(calendarEl[0], option);
      calendar.render();
      $scope.find(".royal-ec-popup-wrapper").on("click", function (e) {
        e.stopPropagation();
        if (e.target === e.currentTarget || e.target == popupClose[0] || e.target == popupClose.find(".eicon-editor-close")[0]) {
          popup.addClass("royal-ec-popup-removing").removeClass("royal-ec-popup-ready");
        }
      });
    };
	    
    
    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royaleventcalendar.default', RoyalEventCalendar);
    });
	
})(jQuery);
