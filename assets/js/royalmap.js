/**
 * Royal Map Widget Handler
 * Contains all frontend logic for the Royal Map Elementor widget.
 */
const RoyalMapHandler = function($scope, $) {
    const wrapper = $scope.find('.royal-map-widget-wrapper');
    if (wrapper.length === 0) return;

    const mapContainer = wrapper.find('.royal-map-container')[0];
    const isEditMode = elementorFrontend.isEditMode();

    // More robust cleanup for Elementor editor re-renders
    const existingMap = wrapper.data('map-instance');
    if (existingMap && typeof existingMap.remove === 'function') {
        existingMap.remove();
    }
    if (mapContainer) {
        $(mapContainer).empty().removeClass('leaflet-container leaflet-grab leaflet-touch-drag');
    }
    wrapper.removeData('map-initialized').removeData('map-instance');

    // Use a timeout to ensure the DOM is fully ready after an editor update
    setTimeout(() => {
        const mapData = wrapper.data('map-settings');
        if (!mapData) {
            console.error('Royal Map: Map settings data not found.');
            return;
        }

        // Element references
        const { locations, settings } = mapData;
        const searchInput = wrapper.find('.royal-map-search-input');
        const locationListContainer = wrapper.find('.royal-map-list-inner');
        const userLocationBtn = wrapper.find('.royal-map-user-location-btn');
        const radiusSlider = wrapper.find('.royal-map-radius-slider');
        const radiusValueSpan = wrapper.find('.royal-map-radius-value');
        const toggleListBtn = wrapper.find('.royal-map-toggle-list-btn');
        const pdfExportBtn = wrapper.find('.royal-map-pdf-export-btn');
        const fullscreenBtn = wrapper.find('.royal-map-fullscreen-btn');
        const loader = wrapper.find('.royal-map-loader');

        // State variables
        let map, markerClusterGroup, userMarker, userCircle, routingControl;
        let allMarkers = [];
        let userLatLng = null;

        // Debounce helper function to avoid dependency on Lodash/Underscore
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func.apply(this, args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        /**
         * Initializes the map, layers, and markers.
         */
        const initMap = () => {
            if (!mapContainer || !locations || locations.length === 0) {
                if (mapContainer) mapContainer.innerHTML = '<p>No locations provided.</p>';
                loader.hide();
                return;
            }

            const firstLoc = locations[0];
            map = L.map(mapContainer, {
                scrollWheelZoom: true
            }).setView([firstLoc.lat, firstLoc.lng], settings.zoom);

            if (isEditMode) {
                L.DomEvent.on(mapContainer, 'mousedown', function(e) {
                    e.stopPropagation();
                });
            }

            wrapper.data('map-initialized', true);
            wrapper.data('map-instance', map);

            addTileLayer();

            if (settings.markerClustering) {
                markerClusterGroup = L.markerClusterGroup();
                map.addLayer(markerClusterGroup);
            }

            applyFiltersAndRender();

            if (settings.fitBounds && locations.length > 1) {
                const bounds = L.latLngBounds(locations.map(loc => [loc.lat, loc.lng]));
                if (bounds.isValid()) map.fitBounds(bounds, { padding: [50, 50] });
            }

            const findMyLocationIcon = userLocationBtn.find('svg');
            if (findMyLocationIcon.length > 0) {
                findMyLocationIcon.css({ 'width': '1em', 'height': '1em' });
            }

            bindEvents();

            map.whenReady(() => {
                loader.hide();
                map.invalidateSize();
            });
        };

        /**
         * A unified function to apply all active filters and sorting, then render the map and list.
         */
        const applyFiltersAndRender = () => {
            let filteredLocations = [...locations];

            const searchQuery = searchInput.val().toLowerCase();
            if (searchQuery) {
                filteredLocations = filteredLocations.filter(loc =>
                    loc.title.toLowerCase().includes(searchQuery) ||
                    (loc.description && loc.description.toLowerCase().includes(searchQuery)) ||
                    (loc.address && loc.address.toLowerCase().includes(searchQuery))
                );
            }

            if (userLatLng && settings.showRadiusFilter) {
                const radiusInMeters = radiusSlider.val() * 1000;
                filteredLocations = filteredLocations.filter(loc => {
                    const locLatLng = L.latLng(loc.lat, loc.lng);
                    return userLatLng.distanceTo(locLatLng) <= radiusInMeters;
                });
            }

            if (settings.sortByDistance && userLatLng) {
                filteredLocations.sort((a, b) => {
                    const distA = userLatLng.distanceTo(L.latLng(a.lat, a.lng));
                    const distB = userLatLng.distanceTo(L.latLng(b.lat, b.lng));
                    return distA - distB;
                });
            }

            addMarkers(filteredLocations);
            renderLocationList(filteredLocations);

            if (searchQuery && filteredLocations.length > 0) {
                const firstMatch = allMarkers.find(m => m.locationData.id === filteredLocations[0].id);
                if (firstMatch && firstMatch._icon) {
                    firstMatch._icon.classList.add('marker-jump');
                    setTimeout(() => firstMatch._icon.classList.remove('marker-jump'), 600);
                }
            }
        };

        /**
         * Adds the selected tile layer to the map.
         */
        const addTileLayer = () => {
            let layerUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            let attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            const thunderforestApiKey = settings.thunderforestApiKey || '';
            switch (settings.mapLayer) {
                case 'osm_hot':
                    layerUrl = 'https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png';
                    attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Tiles style by <a href="https://www.hotosm.org/" target="_blank">Humanitarian OpenStreetMap Team</a>';
                    break;
            }
            L.tileLayer(layerUrl, { attribution }).addTo(map);
        };

        /**
         * Clears and adds all location markers to the map.
         * @param {Array} locationsToAdd - Array of location objects.
         */
        const addMarkers = (locationsToAdd) => {
            if (markerClusterGroup) {
                markerClusterGroup.clearLayers();
            }
            allMarkers.forEach(marker => marker.remove());
            allMarkers = [];

            const targetLayer = settings.markerClustering ? markerClusterGroup : map;

            locationsToAdd.forEach(loc => {
                if (!loc.lat || !loc.lng) return;
                const markerOptions = loc.icon ? { icon: L.icon({ iconUrl: loc.icon, iconSize: [38, 38], iconAnchor: [19, 38], popupAnchor: [0, -38] }) } : {};
                const marker = L.marker([loc.lat, loc.lng], markerOptions);

                let popupContent = `<div class="royal-map-popup">`;
                if (loc.image) popupContent += `<img src="${loc.image}" alt="${loc.title}" class="popup-image">`;
                popupContent += `<h4>${loc.title}</h4>`;
                if (loc.description) popupContent += `<p>${loc.description}</p>`;
                if (loc.address) popupContent += `<div class="popup-info"><i class="eicon-map-pin"></i> ${loc.address}</div>`;
                if (loc.phone) popupContent += `<div class="popup-info"><i class="eicon-phone"></i> <a href="tel:${loc.phone}">${loc.phone}</a></div>`;
                popupContent += `</div>`;

                marker.bindPopup(popupContent);
                marker.locationData = loc;
                marker.on('click', () => handleMarkerClick(marker));

                allMarkers.push(marker);
                targetLayer.addLayer(marker);
            });
        };

        /**
         * Renders the list of locations next to the map.
         * @param {Array} locationsToRender - Array of location objects.
         */
        const renderLocationList = (locationsToRender) => {
            if (!settings.showLocationList) return;
            locationListContainer.html('');
            if (locationsToRender.length === 0) {
                locationListContainer.html('<div class="royal-map-list-item-empty">No locations found.</div>');
                return;
            }
            locationsToRender.forEach(loc => {
                const itemHtml = `<div class="royal-map-list-item" data-id="${loc.id}"><h5>${loc.title}</h5>${loc.address ? `<p><i class="eicon-map-pin"></i> ${loc.address}</p>` : ''}</div>`;
                locationListContainer.append(itemHtml);
            });
        };

        /**
         * Gets the user's current location and updates the map.
         */
        const handleGetUserLocation = () => {
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }
            navigator.geolocation.getCurrentPosition(position => {
                userLatLng = L.latLng(position.coords.latitude, position.coords.longitude);
                if (userMarker) {
                    userMarker.setLatLng(userLatLng);
                } else {
                    userMarker = L.marker(userLatLng, { icon: L.divIcon({ className: 'royal-map-user-location-icon' }) }).addTo(map);
                }
                userMarker.bindPopup('You are here.').openPopup();
                map.setView(userLatLng, 13);

                if (settings.showRadiusFilter) {
                    const radiusInKm = radiusSlider.val();
                    if (userCircle) {
                        userCircle.setLatLng(userLatLng).setRadius(radiusInKm * 1000);
                    } else {
                        userCircle = L.circle(userLatLng, { radius: radiusInKm * 1000, color: '#007cff', fillColor: '#007cff', fillOpacity: 0.1 }).addTo(map);
                    }
                    // Show the radius filter now that we have a location
                    wrapper.find('.royal-map-radius-filter-wrapper').css('display', 'flex');
                }
                applyFiltersAndRender();
            }, () => {
                alert('Unable to retrieve your location.');
            });
        };

        /**
         * Handles marker click events, showing a route if enabled.
         * @param {Object} marker - The clicked Leaflet marker object.
         */
        const handleMarkerClick = (marker) => {
            const loc = marker.locationData;

            const buildPopupContent = (distanceInfo = '') => {
                let content = `<div class="royal-map-popup">`;
                if (loc.image) content += `<img src="${loc.image}" alt="${loc.title}" class="popup-image">`;
                content += `<h4>${loc.title}</h4>`;
                if (loc.description) content += `<p>${loc.description}</p>`;
                if (loc.address) content += `<div class="popup-info"><i class="eicon-map-pin"></i> ${loc.address}</div>`;
                if (loc.phone) content += `<div class="popup-info"><i class="eicon-phone"></i> <a href="tel:${loc.phone}">${loc.phone}</a></div>`;
                if (distanceInfo) content += distanceInfo;
                content += `</div>`;
                return content;
            };

            marker.setPopupContent(buildPopupContent());

            if (settings.showRouting && userLatLng) {
                if (routingControl) {
                    map.removeControl(routingControl);
                }

                routingControl = L.Routing.control({
                    waypoints: [userLatLng, marker.getLatLng()],
                    routeWhileDragging: false,
                    show: false,
                    addWaypoints: false,
                    createMarker: function() { return null; },
                    lineOptions: { styles: [{ color: '#007cff', opacity: 0.8, weight: 6 }] }
                }).addTo(map);

                routingControl.once('routesfound', function(e) {
                    if (!e.routes || e.routes.length === 0) return;
                    const summary = e.routes[0].summary;
                    const distance = (summary.totalDistance / 1000).toFixed(2);

                    const distanceHtml = `<div class="popup-route-summary" style="margin-top: 10px; border-top: 1px solid #eee; padding-top: 8px;"><b>Distance:</b> ${distance} km</div>`;
                    marker.setPopupContent(buildPopupContent(distanceHtml)).openPopup();
                });
            }
        };

        const handleExportToPdf = () => {
            const { jsPDF } = window.jspdf;
            const mainArea = wrapper.find('.royal-map-main-area')[0];
            const originalBg = mainArea.style.backgroundColor;
            mainArea.style.backgroundColor = 'white';
            
            pdfExportBtn.prop('disabled', true).html('<svg class="royal-map-svg-icon royal-map-spinner" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg>');
    
            html2canvas(mainArea, {
                useCORS: true,
                allowTaint: true,
                onclone: (document) => {
                    const leafletPane = document.querySelector('.leaflet-pane.leaflet-tile-pane');
                    if (leafletPane) {
                        leafletPane.style.transform = 'none';
                    }
                }
            })
            .then(canvas => {
                mainArea.style.backgroundColor = originalBg;
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const imgHeight = canvas.height * pdfWidth / canvas.width;
                
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, imgHeight);
                pdf.save('royal-map-export.pdf');
                pdfExportBtn.prop('disabled', false).html('<svg class="royal-map-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>');
            }).catch(err => {
                console.error("PDF export failed:", err);
                alert("Could not export to PDF.");
                mainArea.style.backgroundColor = originalBg;
                pdfExportBtn.prop('disabled', false).html('<svg class="royal-map-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>');
            });
        };
    
        const toggleFullscreen = () => {
            wrapper.toggleClass('royal-map-fullscreen-active');
            if (map) {
                map.invalidateSize();
                setTimeout(() => {
                    map.invalidateSize();
                }, 450); // A bit longer than the CSS transition
            }
        };

        /**
         * Binds all event listeners for the widget's interactive elements.
         */
        const bindEvents = () => {
            // FIX: Use 'input' event for better handling of clearing the search box
            searchInput.on('input', debounce(applyFiltersAndRender, 300));

            if (settings.showLocationList) {
                locationListContainer.on('click', '.royal-map-list-item', function() {
                    const id = $(this).data('id');
                    const targetMarker = allMarkers.find(m => m.locationData.id === id);
                    if (targetMarker) {
                        map.setView(targetMarker.getLatLng(), 15);
                        targetMarker.openPopup();
                    }
                });
            }

            if (settings.locationListToggleButton) {
                toggleListBtn.on('click', () => {
                    wrapper.toggleClass('royal-map-list-hidden');
                    setTimeout(() => map.invalidateSize(), 400);
                });
            }

            userLocationBtn.on('click', handleGetUserLocation);
            pdfExportBtn.on('click', handleExportToPdf);
            fullscreenBtn.on('click', toggleFullscreen);

            if (settings.showRadiusFilter) {
                radiusSlider.on('input', () => radiusValueSpan.text(`${radiusSlider.val()} km`));
                radiusSlider.on('change', () => {
                    if (userLatLng) {
                        const radiusInKm = radiusSlider.val();
                        if (userCircle) {
                            userCircle.setRadius(radiusInKm * 1000);
                        } else {
                            userCircle = L.circle(userLatLng, { radius: radiusInKm * 1000, color: '#007cff', fillColor: '#007cff', fillOpacity: 0.1 }).addTo(map);
                        }
                        applyFiltersAndRender();
                        if (userCircle) {
                            map.fitBounds(userCircle.getBounds());
                        }
                    } else {
                        alert('Please find your location first to use the radius filter.');
                    }
                });
            }
        };

        // Initialize the map.
        initMap();

    }, 100); // End of setTimeout
};

// Register the handler with Elementor's frontend hooks
jQuery(window).on('elementor/frontend/init', () => {
    elementorFrontend.hooks.addAction('frontend/element_ready/royalmap.default', RoyalMapHandler);
});
