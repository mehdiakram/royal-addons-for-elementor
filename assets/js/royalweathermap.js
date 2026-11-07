(function($) {
    var RoyalWeatherMapHandler = function($scope, $) {

		var $_this = $scope.find('.royalweathermap');
			var $currentID     	= '#'+$_this.attr('id'),
			$mapid             	= $_this.data('openweathermapid'),
			$city              	= $_this.data('city'),
			$name              	= $_this.data('name'),
			$clouds            	= $_this.data('clouds'),
			$humidity          	= $_this.data('humidity'),
			$pressure          	= $_this.data('pressure'),
			$temperature      	= $_this.data('temperature'),
			$description       	= $_this.data('description'),
			$cityname       	= $_this.data('cityname'),
			$form       		= $_this.data('form');
	
	
			let id = $mapid;
			let url = 'https://api.openweathermap.org/data/2.5/weather?units=metric&appid=' + id;

			let city = document.getElementById($cityname);
			let form = document.getElementById($form);
			let temperature = document.getElementById($temperature);
			let description = document.getElementById($description);
			let valueSearch = document.getElementById($name);
			let clouds = document.getElementById($clouds);
			let humidity = document.getElementById($humidity);
			let pressure = document.getElementById($pressure);
			let main = document.querySelector('.royalweathermap');
			form.addEventListener("submit", (e) => {
				e.preventDefault();  
				if(valueSearch.value != ''){
					searchWeather();
				}
			});
			const searchWeather = () => {
				fetch(url+'&q='+ valueSearch.value)
					.then(response => response.json())
					.then(data => {
						if(data.cod == 200){
							city.querySelector('figcaption').innerHTML = data.name;
							city.querySelector('img').src = `https://flagsapi.com/${data.sys.country}/shiny/32.png`;
							temperature.querySelector('img').src = `https://openweathermap.org/img/wn/${data.weather[0].icon}@4x.png`;
							temperature.querySelector('span').innerText = data.main.temp;
							description.innerText = data.weather[0].description;
							clouds.innerText = data.clouds.all;
							humidity.innerText = data.main.humidity;
							pressure.innerText = data.main.pressure;
						}else{
							main.classList.add('error');
							setTimeout(() => {
								main.classList.remove('error');
							}, 1000);
						}
						valueSearch.value = '';
					})
			}
			// search Default
			const initApp = () => {
				valueSearch.value = $city;
				searchWeather();
			}
			initApp();
		}
    // Make sure we run this code under Elementor
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalweathermap.default', RoyalWeatherMapHandler);
    });
})(jQuery);
