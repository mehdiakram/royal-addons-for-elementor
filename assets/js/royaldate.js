(function($) {
    'use strict';
    const RoyalDateHandler = function($scope, $) {
        const widgetWrapper = $scope.find('.royal-date-widget-wrapper');
        if (!widgetWrapper.length || widgetWrapper.hasClass('rt-date-initialized')) {
            return;
        }
        widgetWrapper.addClass('rt-date-initialized');
        const settings = widgetWrapper.data('settings');
        const loader = widgetWrapper.find('.royal-date-loader');
        const errorDiv = widgetWrapper.find('.royal-date-error');
        const contentWrapper = widgetWrapper.find('.royal-date-content-wrapper');
        const manualForm = widgetWrapper.find('.royal-date-manual-location');
        let clockIntervalId = null;

        const toBengaliNumeral = (str) => {
            const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
            return String(str).replace(/[0-9]/g, digit => bengaliDigits[digit]);
        };

        const getBengaliDateJS = (gregDay, gregMonth, gregYear) => {
            const bnMonths = ['পৌষ', 'মাঘ', 'ফাল্গুন', 'চৈত্র', 'বৈশাখ', 'জৈষ্ঠ্য', 'আষাঢ়', 'শ্রাবণ', 'ভাদ্র', 'আশ্বিন', 'কার্তিক', 'অগ্রহায়ণ'];
            const enMonths = ['Poush', 'Magh', 'Falgun', 'Chaitra', 'Boishakh', 'Joishtho', 'Ashar', 'Shrabon', 'Bhadro', 'Ashwin', 'Kartik', 'Ogrohayon'];
            let bnYear = (gregMonth < 4 || (gregMonth === 4 && gregDay < 14)) ? gregYear - 594 : gregYear - 593;
            const cal_map = [
                [1, 14, 8], [2, 13, 9], [3, 15, 10], [4, 14, 11], [5, 15, 0], [6, 16, 1],
                [7, 16, 2], [8, 16, 3], [9, 16, 4], [10, 16, 5], [11, 15, 6], [12, 15, 7]
            ];
            let bn_day = 0;
            let bn_month_index = 0;
            for (const cal of cal_map) {
                if (gregMonth === cal[0]) {
                    if (gregDay >= cal[1]) {
                        bn_month_index = cal[2];
                        bn_day = gregDay - cal[1] + 1;
                    } else {
                        const prevMonthGregorian = (gregMonth === 1) ? 12 : gregMonth - 1;
                        const prevYearGregorian = (prevMonthGregorian === 12) ? gregYear - 1 : gregYear;
                        const daysInPrevGregorianMonth = new Date(prevYearGregorian, prevMonthGregorian, 0).getDate();
                        const prevCalRow = cal_map.find(c => c[0] === prevMonthGregorian);
                        if (prevCalRow) {
                           bn_month_index = prevCalRow[2];
                           bn_day = daysInPrevGregorianMonth - prevCalRow[1] + gregDay;
                        }
                    }
                    break;
                }
            }
            return {
                day: bn_day,
                month_bn: bnMonths[bn_month_index],
                month_en: enMonths[bn_month_index],
                year: bnYear
            };
        };

        const displayAllDates = (data) => {
            if (!data || !data.date || !data.date.gregorian || !data.date.hijri) {
                showError("Invalid date format from API.");
                return;
            }
            const gDate = data.date.gregorian;
            const hDate = data.date.hijri;

            if (settings.showGregorian === 'yes') {
                const day = gDate.day;
                const month = settings.gregorianLang === 'bn' ? ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'][gDate.month.number - 1] : gDate.month.en;
                const year = gDate.year;
                const formatted = `${settings.gregorianLang === 'bn' ? toBengaliNumeral(day) : day} ${month} ${settings.gregorianLang === 'bn' ? toBengaliNumeral(year) : year}`;
                widgetWrapper.find('.gregorian-date-item').html(formatted);
            }

            if (settings.showBengali === 'yes') {
                const bDate = getBengaliDateJS(parseInt(gDate.day, 10), gDate.month.number, parseInt(gDate.year, 10));
                const day = bDate.day;
                const month = settings.bengaliLang === 'bn' ? bDate.month_bn : bDate.month_en;
                const year = bDate.year;
                const formatted = `${settings.bengaliLang === 'bn' ? toBengaliNumeral(day) : day} ${month} ${settings.bengaliLang === 'bn' ? toBengaliNumeral(year) : year}`;
                widgetWrapper.find('.bengali-date-item').html(formatted);
            }

            if (settings.showHijri === 'yes') {
                const hijriMonthsBn = ['মুহররম','সফর','রবিউল আউয়াল','রবিউস সানি','জমাদিউল আউয়াল','জমাদিউস সানি','রজব','শাবান','রমজান','শাওয়াল','জিলক্বদ','জিলহজ'];
                const day = hDate.day;
                const month = settings.hijriLang === 'bn' ? hijriMonthsBn[hDate.month.number - 1] : hDate.month.en;
                const year = hDate.year;
                const formatted = `${settings.hijriLang === 'bn' ? toBengaliNumeral(day) : day} ${month} ${settings.hijriLang === 'bn' ? toBengaliNumeral(year) : year}`;
                const hijriElement = widgetWrapper.find('.hijri-date-item');
                hijriElement.html(formatted);
                hijriElement.attr({
                    'data-day': day,
                    'data-month-en': hDate.month.en,
                    'data-month-bn': hijriMonthsBn[hDate.month.number - 1], // Fixed
                    'data-year': year,
                    'data-lang': settings.hijriLang
                });
            }
        };

        const startClock = (timezone) => {
            const clockElement = widgetWrapper.find('.royal-clock');
            if (!clockElement.length || settings.showClock !== 'yes') return;
            if (clockIntervalId) clearInterval(clockIntervalId);
            clockIntervalId = setInterval(() => {
                const now = new Date();
                const timeOptions = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true, timeZone: timezone };
                let timeString = now.toLocaleTimeString('en-US', timeOptions);
                if (settings.clockLang === 'bn') {
                    timeString = toBengaliNumeral(timeString).replace('AM', 'পূর্বাহ্ণ').replace('PM', 'অপরাহ্ণ');
                }
                clockElement.text(timeString);
            }, 1000);
        };

        const updateHijriDateDisplay = (maghribTimeStr, timezone) => {
            const hijriElement = widgetWrapper.find('.hijri-date-item');
            if (!hijriElement.length || settings.hijriChange !== 'yes' || !maghribTimeStr || !timezone) return;
            const maghribParts = maghribTimeStr.split(':');
            const maghribHour = parseInt(maghribParts[0], 10);
            const maghribMinute = parseInt(maghribParts[1], 10);
            const maghribTimeInMinutes = maghribHour * 60 + maghribMinute;
            const nowInLocation = new Date();
            const locationTimeFormatter = new Intl.DateTimeFormat('en-US', { timeZone: timezone, hour: '2-digit', minute: '2-digit', hour12: false });
            const locationTimeParts = locationTimeFormatter.formatToParts(nowInLocation);
            let locationHour = 0; let locationMinute = 0;
            locationTimeParts.forEach(part => {
                if (part.type === 'hour') locationHour = parseInt(part.value, 10);
                if (part.type === 'minute') locationMinute = parseInt(part.value, 10);
            });
            const currentTimeInMinutes = locationHour * 60 + locationMinute;
            if (currentTimeInMinutes >= maghribTimeInMinutes) {
                const day = parseInt(hijriElement.data('day'), 10);
                const lang = hijriElement.data('lang');
                const newDay = day + 1;
                const originalDayDisplay = lang === 'bn' ? toBengaliNumeral(day) : day;
                const newDayDisplay = lang === 'bn' ? toBengaliNumeral(newDay) : newDay;
                const monthDisplay = lang === 'bn' ? hijriElement.data('month-bn') : hijriElement.data('month-en');
                const yearDisplay = lang === 'bn' ? toBengaliNumeral(hijriElement.data('year')) : hijriElement.data('year');
                hijriElement.html(`<del>${originalDayDisplay}</del> ${newDayDisplay} ${monthDisplay} ${yearDisplay}`);
            }
        };

        const showError = (message) => {
            errorDiv.text(`Error: ${message}`).show();
            loader.hide();
            contentWrapper.hide();
            if (settings.locationDetection === 'auto') { manualForm.show(); }
        };

        const fetchPrayerTimes = async (city, country) => {
            loader.show(); contentWrapper.hide(); errorDiv.hide(); manualForm.hide();
            const date = new Date();
            const corrections = settings.hijriCorrection !== '0' ? `&tune=0,0,0,0,0,${settings.hijriCorrection},0,0,0` : '';
            const apiUrl = `https://api.aladhan.com/v1/calendarByAddress/${date.getFullYear()}/${date.getMonth() + 1}?address=${encodeURIComponent(city + ', ' + country)}&method=${settings.calculationMethod}${corrections}`;
            try {
                const response = await fetch(apiUrl);
                if (!response.ok) throw new Error(`API Error: ${response.statusText}`);
                const result = await response.json();
                if (result.code === 200 && result.data && result.data.length > 0) {
                    const timezone = result.data[0].meta.timezone;
                    const dayFormatter = new Intl.DateTimeFormat('en-US', { timeZone: timezone, day: 'numeric' });
                    const remoteDay = dayFormatter.format(new Date());
                    const todayData = result.data.find(d => d.date.gregorian.day == remoteDay);
                    if (todayData) {
                        loader.hide();
                        contentWrapper.show();
                        displayAllDates(todayData);
                        updateHijriDateDisplay(todayData.timings.Maghrib, timezone);
                        if (timezone) startClock(timezone);
                    } else { throw new Error('Could not find data for today in API response.'); }
                } else { throw new Error('Could not get data for today from API.'); }
            } catch (error) {
                showError(error.message || 'Could not fetch data. Please check location or API.');
            }
        };

        const fetchLocationFromCoords = async (latitude, longitude) => {
            try {
                const geoResponse = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&accept-language=en`);
                const geoData = await geoResponse.json();
                if (geoData && geoData.address) {
                    const city = geoData.address.city || geoData.address.town || geoData.address.village || geoData.address.state;
                    const country = geoData.address.country;
                    if (city && country) { fetchPrayerTimes(city, country); } else { throw new Error('Could not determine city/country.'); }
                } else { throw new Error('Could not determine location.'); }
            } catch (e) { showError('Could not auto-detect location. Please enter manually.'); }
        };

        const init = () => {
            if (elementorFrontend.isEditMode()) {
                loader.hide(); contentWrapper.show();
                widgetWrapper.find('.gregorian-date-item').html('25 June 2025');
                widgetWrapper.find('.bengali-date-item').html('১১ আষাঢ় ১৪৩২');
                widgetWrapper.find('.hijri-date-item').html('২৮ জিলহজ ১৪৪৬');
                widgetWrapper.find('.royal-clock').html('09:30:15 PM');
                return;
            }
            if (settings.locationDetection === 'auto') {
                navigator.geolocation.getCurrentPosition(
                    (position) => { fetchLocationFromCoords(position.coords.latitude, position.coords.longitude); },
                    () => { showError('Geolocation failed. Please allow location access or enter manually.'); }, { timeout: 10000 }
                );
            } else {
                fetchPrayerTimes(settings.manualCity, settings.manualCountry);
            }
        };

        manualForm.find('.manual-submit-btn').on('click', () => {
            const city = manualForm.find('.manual-city-input').val().trim();
            const country = manualForm.find('.manual-country-input').val().trim();
            if (city && country) { fetchPrayerTimes(city, country); } else { alert('Please enter both City and Country.'); }
        });

        init();
    };

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royaldate.default', RoyalDateHandler);
    });

})(jQuery);