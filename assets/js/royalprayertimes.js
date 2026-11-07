(function($) {
    'use strict';

    const RoyalPrayerTimesHandler = function($scope, $) {
        const widgetWrapper = $scope.find('.royal-prayer-times-wrapper');
        if (!widgetWrapper.length || widgetWrapper.hasClass('royal-pt-initialized')) {
            return;
        }
        widgetWrapper.addClass('royal-pt-initialized');

        const settings = widgetWrapper.data('settings');
        const loader = widgetWrapper.find('.royal-prayer-times-loader');
        const errorDiv = widgetWrapper.find('.royal-prayer-times-error');
        const listDiv = widgetWrapper.find('.royal-prayer-times-list');
        const headerLocation = widgetWrapper.find('.location');
        const headerDate = widgetWrapper.find('.date');
        const currentTimeDiv = widgetWrapper.find('.current-time');
        const manualForm = widgetWrapper.find('.royal-prayer-manual-location');
        
        let prayerTimingsData = {};
        let fetchedTimeZone = null;
        let clockIntervalId = 'clockInterval_' + settings.id;
        let highlightIntervalId = 'highlightInterval_' + settings.id;

        // Function to update the current time display.
        const updateCurrentTime = () => {
            if (!currentTimeDiv.length) return;
            const now = new Date();
            const timeOptions = {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: settings.timeFormat === '12h'
            };
            if (fetchedTimeZone) {
                timeOptions.timeZone = fetchedTimeZone;
            }
            currentTimeDiv.text(now.toLocaleTimeString('en-US', timeOptions));
        };

        if (window[clockIntervalId]) clearInterval(window[clockIntervalId]);
        if (settings.showCurrentTime === 'yes') {
            window[clockIntervalId] = setInterval(updateCurrentTime, 1000);
            updateCurrentTime();
        }

        // Function to highlight the current prayer time row (improved).
        const highlightCurrentPrayer = () => {
            if ($.isEmptyObject(prayerTimingsData) || !fetchedTimeZone) return;

            // Using Intl.DateTimeFormat for timezone-aware time — more reliable than parsing new Date().
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-CA', {
                timeZone: fetchedTimeZone,
                year: 'numeric', month: '2-digit', day: '2-digit',
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hour12: false
            });
            
            const parts = formatter.formatToParts(now);
            const locationTime = {};
            parts.forEach(({ type, value }) => { locationTime[type] = parseInt(value); });

            // Build a Date object for the current time at the selected location.
            const nowInLocationTimeZone = new Date(
                locationTime.year, locationTime.month - 1, locationTime.day,
                locationTime.hour, locationTime.minute, locationTime.second
            );
            
            let prayerTimesToday = [];

            $.each(prayerTimingsData, function(prayerName, time) {
                if (['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'].includes(prayerName)) {
                    const timeParts = time.split(':');
                    // Convert prayer times into Date objects using today's date at the selected location.
                    const prayerDate = new Date(
                        locationTime.year, locationTime.month - 1, locationTime.day,
                        parseInt(timeParts[0], 10), parseInt(timeParts[1], 10), 0
                    );
                    prayerTimesToday.push({ name: prayerName, date: prayerDate });
                }
            });

            prayerTimesToday.sort((a, b) => a.date - b.date);

            let currentPrayerName = prayerTimesToday[prayerTimesToday.length - 1].name;

            for (let i = 0; i < prayerTimesToday.length; i++) {
                if (nowInLocationTimeZone < prayerTimesToday[i].date) {
                    currentPrayerName = (i > 0) ? prayerTimesToday[i - 1].name : prayerTimesToday[prayerTimesToday.length - 1].name;
                    break;
                }
            }

            widgetWrapper.find('.royal-prayer-time-row').removeClass('current');
            widgetWrapper.find(`.royal-prayer-time-row[data-prayer="${currentPrayerName.toLowerCase()}"]`).addClass('current');
        };

        // Main function to fetch prayer times from the API.
        const getPrayerTimes = async (city, country) => {
            loader.show();
            listDiv.hide();
            errorDiv.hide();
            manualForm.hide();

            if (!city || !country) {
                showError('Please provide both City and Country.');
                loader.hide();
                return;
            }

            const today = new Date();
            const dateStr = `${today.getDate()}-${today.getMonth() + 1}-${today.getFullYear()}`;
            const apiUrl = `https://api.aladhan.com/v1/timingsByAddress/${dateStr}?address=${encodeURIComponent(city + ', ' + country)}&method=${settings.calculationMethod}`;

            try {
                const response = await fetch(apiUrl);
                if (!response.ok) throw new Error(`API Error: ${response.statusText}`);
                const result = await response.json();

                if (result.code === 200) {
                    displayTimes(result.data);
                    headerLocation.text(`${city}, ${country}`);
                } else {
                    throw new Error(result.data.error || 'Unknown API error.');
                }
            } catch (error) {
                showError('Could not fetch prayer times. Please check the location.');
            } finally {
                loader.hide();
            }
        };
        
        const getPrayerTimesByCoords = async (latitude, longitude) => {
             loader.show();
             listDiv.hide();
             errorDiv.hide();
             manualForm.hide();

             try {
                const geoResponse = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&accept-language=en`);
                const geoData = await geoResponse.json();
                if (geoData && geoData.address) {
                    const city = geoData.address.city || geoData.address.town || geoData.address.village || geoData.address.state;
                    const country = geoData.address.country;
                    if(city && country){
                        getPrayerTimes(city, country);
                    } else {
                        throw new Error('Could not determine city/country from coordinates.');
                    }
                } else {
                     throw new Error('Could not determine location from coordinates.');
                }
             } catch(e) {
                showError('Could not auto-detect location. Please enter manually.');
                manualForm.show();
             }
        }


        // Function to display the fetched prayer times in the widget.
        const displayTimes = (data) => {
            prayerTimingsData = data.timings;
            if (data.meta && data.meta.timezone) {
                fetchedTimeZone = data.meta.timezone;
                updateCurrentTime();
            }

            const date = new Date(data.date.timestamp * 1000);
            headerDate.text(date.toLocaleDateString(undefined, {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }));

            const prayerLabels = {
                'Fajr': settings.fajrLabel, 'Dhuhr': settings.dhuhrLabel, 'Asr': settings.asrLabel,
                'Maghrib': settings.maghribLabel, 'Isha': settings.ishaLabel
            };

            $.each(prayerTimingsData, function(prayerName, time) {
                if (prayerLabels.hasOwnProperty(prayerName)) {
                    const row = listDiv.find(`.royal-prayer-time-row[data-prayer="${prayerName.toLowerCase()}"]`);
                    if (row.length) {
                        let formattedTime = time;
                        if (settings.timeFormat === '12h') {
                            const [hour, minute] = time.split(':');
                            const d = new Date();
                            d.setHours(hour, minute);
                            formattedTime = d.toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: 'numeric',
                                hour12: true
                            });
                        }
                        row.find('.royal-prayer-time-value').text(formattedTime);
                    }
                }
            });

            listDiv.show();
            highlightCurrentPrayer();

            if (window[highlightIntervalId]) clearInterval(window[highlightIntervalId]);
            window[highlightIntervalId] = setInterval(highlightCurrentPrayer, 60000);
        };

        const showError = (message) => {
            errorDiv.text(`Error: ${message}`).show();
            listDiv.hide();
            loader.hide();
        };

        // Main initialization function.
        const init = () => {
            if (elementorFrontend.isEditMode()) {
                loader.hide();
                return;
            }

            if (settings.locationDetection === 'auto') {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        getPrayerTimesByCoords(position.coords.latitude, position.coords.longitude);
                    },
                    () => {
                        showError('Geolocation failed. Please enter location manually.');
                        manualForm.show();
                    }, {
                        timeout: 10000
                    }
                );
            } else {
                getPrayerTimes(settings.manualCity, settings.manualCountry);
            }
        };
        
        manualForm.find('.manual-submit-btn').on('click', () => {
            const city = manualForm.find('.manual-city-input').val().trim();
            const country = manualForm.find('.manual-country-input').val().trim();
            if (city && country) {
                getPrayerTimes(city, country);
            } else {
                alert('Please enter both City and Country.');
            }
        });

        init();
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalprayertimes.default', RoyalPrayerTimesHandler);
    });

})(jQuery);
