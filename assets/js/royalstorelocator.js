/**
 * Royal Store Locator - Frontend Application Logic
 * Powered by Leaflet & OpenStreetMap (Free, No API Key Required)
 */

;(function($) {
  'use strict';

  // Keep track of active map instances by element ID
  var activeInstances = {};

  /**
   * Initialize a single Store Locator widget
   */
  function initStoreLocator($scope) {
    var $app = $scope.find('.royal-store-locator-app');
    if (!$app.length) return;

    var appId = $app.attr('id');
    if (!appId) return;

    // Cleanup previous Leaflet instance if re-initializing in Elementor editor
    if (activeInstances[appId]) {
      try {
        activeInstances[appId].destroy();
      } catch (err) {
        console.warn('Error destroying prior instance:', err);
      }
      delete activeInstances[appId];
    }

    var config = $app.data('settings') || {};
    var rawStores = $app.data('stores') || [];

    var instance = new StoreLocatorInstance($app, config, rawStores);
    activeInstances[appId] = instance;
    window.RoyalStoreLocatorInstances = activeInstances;
    instance.init();
  }

  /**
   * StoreLocatorInstance Class
   */
  function StoreLocatorInstance($app, config, initialStores) {
    this.$app = $app;
    this.config = config;
    this.stores = Array.isArray(initialStores) ? initialStores : [];

    this.map = null;
    this.markerCluster = null;
    this.markersById = {};
    this.userLocation = null;
    this.userMarker = null;
    this.userAccuracyCircle = null;
    this.activeRadiusCircle = null;

    this.currentCategory = 'all';
    this.currentDivision = 'all';
    this.searchQuery = '';
    this.maxRadius = this.config.defaultRadius || 100;
    this.sortBy = 'default';
    this.openNowOnly = false;
    this.selectedAmenity = 'all';

    // DOM references inside widget scope
    this.$mapCanvas = this.$app.find('.rsl-map-canvas');
    this.$sidebar = this.$app.find('.rsl-sidebar');
    this.$storeList = this.$app.find('.rsl-store-list-container');
    this.$searchInput = this.$app.find('.rsl-search-input');
    this.$clearSearch = this.$app.find('.rsl-clear-search-btn');
    this.$divisionSelect = this.$app.find('.rsl-division-select');
    this.$categoryPills = this.$app.find('.rsl-category-pill');
    this.$nearMeBtn = this.$app.find('.rsl-near-me-btn');
    this.$radiusContainer = this.$app.find('.rsl-radius-container');
    this.$radiusSlider = this.$app.find('.rsl-radius-slider');
    this.$radiusValue = this.$app.find('.rsl-radius-value');
    this.$resultsCount = this.$app.find('.rsl-results-count');
    this.$sortSelect = this.$app.find('.rsl-sort-select');
    this.$emptyState = this.$app.find('.rsl-empty-state');
    this.$resetViewBtn = this.$app.find('.rsl-reset-view-btn');
    this.$locateMeMapBtn = this.$app.find('.rsl-locate-me-map-btn');
    this.$fullscreenBtn = this.$app.find('.rsl-fullscreen-btn');
    this.$sidebarToggleBtn = this.$app.find('.rsl-sidebar-collapse-btn');
    this.$sidebarToggleIcon = this.$app.find('.rsl-sidebar-toggle-icon');
    this.$mobileToggleBtn = this.$app.find('.rsl-mobile-toggle-btn');
    this.$totalBadge = this.$app.find('.rsl-badge-total-count');
    this.$openNowCheckbox = this.$app.find('.rsl-open-now-checkbox');
    this.$amenityToggleBtn = this.$app.find('.rsl-amenity-toggle-btn');
    this.$amenitiesMenu = this.$app.find('.rsl-amenities-menu');
  }

  /**
   * Destroy instance cleanly
   */
  StoreLocatorInstance.prototype.destroy = function() {
    if (this.map) {
      this.map.remove();
      this.map = null;
    }
    this.$app.find('*').off('.rsl');
    this.$app.off('.rsl');
    $(document).off('.rsl-' + this.config.id);
    this.markersById = {};
  };

  /**
   * Initialize map, load data, and bind events
   */
  StoreLocatorInstance.prototype.init = function() {
    var self = this;

    // Check if remote JSON needs to be fetched
    if (self.config.dataSource === 'remote_json' && self.config.remoteJsonUrl) {
      fetch(self.config.remoteJsonUrl)
        .then(function(res) { return res.json(); })
        .then(function(data) {
          self.stores = Array.isArray(data) ? data : [];
          self.initMap();
        })
        .catch(function(err) {
          console.error('Failed to fetch remote store JSON:', err);
          self.initMap();
        });
    } else if (self.config.dataSource === 'preset' && self.stores.length === 0 && window.royalStoreLocatorData && window.royalStoreLocatorData.presetUrl) {
      // Fallback if PHP didn't embed preset
      fetch(window.royalStoreLocatorData.presetUrl)
        .then(function(res) { return res.json(); })
        .then(function(data) {
          self.stores = Array.isArray(data) ? data : [];
          self.initMap();
        })
        .catch(function() {
          self.initMap();
        });
    } else {
      self.initMap();
    }
  };

  /**
   * Initialize Leaflet Map
   */
  StoreLocatorInstance.prototype.initMap = function() {
    var self = this;
    if (!self.$mapCanvas.length) return;

    var mapId = self.$mapCanvas.attr('id');
    if (!mapId || typeof L === 'undefined') return;

    var centerLat = self.config.defaultLat || 23.8103;
    var centerLng = self.config.defaultLng || 90.4125;
    var zoom = self.config.defaultZoom || 7;
    var scrollWheel = !!self.config.scrollWheelZoom;

    // Create Leaflet map
    self.map = L.map(mapId, {
      zoomControl: false,
      attributionControl: true,
      scrollWheelZoom: scrollWheel
    }).setView([centerLat, centerLng], zoom);

    // Zoom control at top-left
    L.control.zoom({ position: 'topleft' }).addTo(self.map);

    // Build Tile Layers
    var baseMaps = self.buildTileLayers();

    // Default layer selection
    var defaultTileKey = self.config.tileLayer || 'osm';
    var activeTile = baseMaps[defaultTileKey] || baseMaps['osm'];
    activeTile.addTo(self.map);

    // Optional Layer Switcher Control
    if (self.config.showLayerControl) {
      var layerControlLabels = {
        'OpenStreetMap (Standard)': baseMaps['osm'],
        'OpenStreetMap (Humanitarian)': baseMaps['osm_hot'],
        'CartoDB (Clean Light)': baseMaps['carto_light'],
        'CartoDB (Dark Matter)': baseMaps['carto_dark'],
        'Satellite Imagery (Esri)': baseMaps['esri_sat'],
        'Topographic (OpenTopo)': baseMaps['opentopo']
      };
      if (baseMaps['custom']) {
        layerControlLabels['Custom Tile Map'] = baseMaps['custom'];
      }
      L.control.layers(layerControlLabels, null, { position: 'topright' }).addTo(self.map);
    }

    // Prevent map click / drag propagation when interacting with floating buttons
    var floatingEl = self.$app.find('.rsl-map-floating-controls')[0];
    if (floatingEl && typeof L !== 'undefined' && L.DomEvent) {
      L.DomEvent.disableClickPropagation(floatingEl);
      L.DomEvent.disableScrollPropagation(floatingEl);
    }

    // Initialize Marker Cluster
    if (self.config.enableClustering && typeof L.markerClusterGroup !== 'undefined') {
      self.markerCluster = L.markerClusterGroup({
        showCoverageOnHover: false,
        maxClusterRadius: self.config.maxClusterRadius || 45,
        spiderfyOnMaxZoom: true,
        zoomToBoundsOnClick: true,
        iconCreateFunction: function(cluster) {
          var count = cluster.getChildCount();
          return L.divIcon({
            html: '<div class="rsl-cluster-badge">' + count + '</div>',
            className: 'rsl-custom-cluster-wrapper',
            iconSize: [40, 40]
          });
        }
      });
      self.map.addLayer(self.markerCluster);
    }

    // Prevent popups from touching the top edge of map
    self.map.on('popupopen', function(e) {
      if (!e.popup) return;
      var el = e.popup.getElement();
      if (!el) return;
      var mapBox = self.map.getContainer().getBoundingClientRect();
      var popupBox = el.getBoundingClientRect();
      var topGap = popupBox.top - mapBox.top;
      if (topGap < 75) {
        self.map.panBy([0, topGap - 95], { animate: true, duration: 0.25 });
      }
    });

    // Populate Filters
    self.populateDivisionDropdown();
    self.populateAmenitiesMenu();
    self.updateTotalBadge();

    // Render store markers and list
    self.render();

    // Fit bounds
    self.fitAllStoresBounds();

    // Setup event listeners
    self.bindEvents();

    // Invalidate map size after animation / layout ready
    setTimeout(function() {
      if (self.map) {
        self.map.invalidateSize();
      }
    }, 350);
  };

  /**
   * Build Tile Layers
   */
  StoreLocatorInstance.prototype.buildTileLayers = function() {
    var layers = {};

    layers['osm'] = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a> contributors',
      maxZoom: 19
    });

    layers['osm_hot'] = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>, Tiles by <a href="https://www.hotosm.org/" target="_blank">HOT</a>',
      maxZoom: 19
    });

    layers['carto_light'] = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://carto.com/">CARTO</a>',
      maxZoom: 20
    });

    layers['carto_dark'] = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
      attribution: '&copy; <a href="https://carto.com/">CARTO</a>',
      maxZoom: 20
    });

    layers['esri_sat'] = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      attribution: 'Tiles &copy; Esri, USGS, NOAA',
      maxZoom: 19
    });

    layers['opentopo'] = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
      attribution: 'Map: &copy; <a href="https://opentopomap.org">OpenTopoMap</a>',
      maxZoom: 17
    });

    if (this.config.customTileUrl) {
      layers['custom'] = L.tileLayer(this.config.customTileUrl, {
        maxZoom: 20
      });
    }

    return layers;
  };

  /**
   * Populate Division / Region dropdown dynamically
   */
  StoreLocatorInstance.prototype.populateDivisionDropdown = function() {
    var self = this;
    if (!self.$divisionSelect.length) return;

    var divisions = [];
    self.stores.forEach(function(s) {
      if (s.division && divisions.indexOf(s.division) === -1) {
        divisions.push(s.division);
      }
    });
    divisions.sort();

    divisions.forEach(function(div) {
      var count = self.stores.filter(function(s) { return s.division === div; }).length;
      var $opt = $('<option>')
        .val(div)
        .text(div + ' (' + count + ')');
      self.$divisionSelect.append($opt);
    });
  };

  /**
   * Populate Amenities filter menu
   */
  StoreLocatorInstance.prototype.populateAmenitiesMenu = function() {
    var self = this;
    if (!self.$amenitiesMenu.length) return;

    var allAmenities = [];
    self.stores.forEach(function(s) {
      if (Array.isArray(s.amenities)) {
        s.amenities.forEach(function(a) {
          if (a && allAmenities.indexOf(a) === -1) {
            allAmenities.push(a);
          }
        });
      }
    });

    if (allAmenities.length === 0) {
      self.$app.find('.rsl-amenities-dropdown-wrap').hide();
      return;
    }

    self.$amenitiesMenu.empty();

    var checkSvg = '<svg class="rsl-amenity-check" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>';

    // "All Amenities" item
    var isAllActive = (self.selectedAmenity === 'all') ? ' active' : '';
    var $allItem = $('<div class="rsl-amenity-item' + isAllActive + '" data-amenity="all">' + checkSvg + '<span>All Amenities</span></div>');
    self.$amenitiesMenu.append($allItem);

    allAmenities.sort().forEach(function(a) {
      var isActive = (self.selectedAmenity === a) ? ' active' : '';
      var $item = $('<div class="rsl-amenity-item' + isActive + '" data-amenity="' + self.escapeHtml(a) + '">' + checkSvg + '<span>' + self.escapeHtml(a) + '</span></div>');
      self.$amenitiesMenu.append($item);
    });

    self.$amenitiesMenu.find('.rsl-amenity-item').off('.rsl').on('click.rsl', function(e) {
      e.stopPropagation();
      self.selectedAmenity = $(this).attr('data-amenity') || $(this).data('amenity');
      var label = (self.selectedAmenity === 'all') ? 'Amenities' : self.selectedAmenity;
      self.$amenityToggleBtn.find('span').text(label);
      if (self.selectedAmenity !== 'all') {
        self.$amenityToggleBtn.addClass('active');
      } else {
        self.$amenityToggleBtn.removeClass('active');
        self.$amenityToggleBtn.find('span').text('Amenities');
      }
      self.$amenitiesMenu.find('.rsl-amenity-item').removeClass('active');
      $(this).addClass('active');
      self.$amenitiesMenu.removeClass('show');

      if (self.map) {
        self.map.closePopup();
      }

      self.render();
      self.fitAllStoresBounds();
    });
  };

  /**
   * Update Total Badge in Header
   */
  StoreLocatorInstance.prototype.updateTotalBadge = function() {
    if (this.$totalBadge.length) {
      this.$totalBadge.text(this.stores.length + ' Locations');
    }
  };

  /**
   * Haversine Distance Calculation (KM or Miles)
   */
  StoreLocatorInstance.prototype.calculateDistance = function(lat1, lon1, lat2, lon2) {
    var R = (this.config.distanceUnit === 'miles') ? 3958.8 : 6371; // Earth radius in miles or km
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
  };

  /**
   * Check if a store is currently open
   */
  StoreLocatorInstance.prototype.isStoreOpen = function(store) {
    if (!store) return null;

    var hoursStr = (typeof store === 'string') ? store : (store.hours || '');
    var offDay = (typeof store === 'object') ? (store.offDay || store.off_day || '') : '';
    var scheduleType = (typeof store === 'object') ? (store.scheduleType || store.schedule_type || '') : '';

    if (scheduleType === '24_7') return true;
    if (scheduleType === 'closed') return false;

    if (!hoursStr) return null;
    var s = hoursStr.toLowerCase();
    if (s.indexOf('24/7') !== -1 || s.indexOf('24 hours') !== -1 || s.indexOf('always open') !== -1) return true;
    if (s.indexOf('temporarily closed') !== -1 || s === 'closed') return false;

    var now = new Date();
    var currentDay = now.getDay(); // 0 = Sunday, 1 = Monday, ..., 5 = Friday, 6 = Saturday
    var dayNames = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    var currentDayName = dayNames[currentDay];

    // Check weekly off day
    if (offDay && offDay.toLowerCase() !== 'none' && offDay.toLowerCase() === currentDayName) {
      return false;
    }

    // Check day restrictions mentioned in text
    if (s.indexOf('sat - thu') !== -1 && currentDay === 5) return false;
    if (s.indexOf('sun - thu') !== -1 && (currentDay === 5 || currentDay === 6)) return false;
    if (s.indexOf('mon - fri') !== -1 && (currentDay === 0 || currentDay === 6)) return false;
    if (s.indexOf('mon - sat') !== -1 && currentDay === 0) return false;
    if (s.indexOf('closed on monday') !== -1 && currentDay === 1) return false;
    if (s.indexOf('closed on friday') !== -1 && currentDay === 5) return false;

    // Match times like 10:00 AM - 8:00 PM or 09:30 AM - 08:30 PM
    var match = hoursStr.match(/(\d{1,2}):?(\d{2})?\s*(am|pm)\s*-\s*(\d{1,2}):?(\d{2})?\s*(am|pm)/i);
    if (!match) return null;

    var startHour = parseInt(match[1], 10);
    var startMin = match[2] ? parseInt(match[2], 10) : 0;
    var startAmPm = match[3].toLowerCase();

    var endHour = parseInt(match[4], 10);
    var endMin = match[5] ? parseInt(match[5], 10) : 0;
    var endAmPm = match[6].toLowerCase();

    if (startAmPm === 'pm' && startHour < 12) startHour += 12;
    if (startAmPm === 'am' && startHour === 12) startHour = 0;

    if (endAmPm === 'pm' && endHour < 12) endHour += 12;
    if (endAmPm === 'am' && endHour === 12) endHour = 0;

    var currentMinutes = now.getHours() * 60 + now.getMinutes();
    var startMinutes = startHour * 60 + startMin;
    var endMinutes = endHour * 60 + endMin;

    return currentMinutes >= startMinutes && currentMinutes <= endMinutes;
  };

  /**
   * Filter and Sort Stores
   */
  StoreLocatorInstance.prototype.getFilteredStores = function() {
    var self = this;
    var list = self.stores.map(function(store) {
      var dist = null;
      if (self.userLocation && store.lat && store.lng) {
        dist = self.calculateDistance(self.userLocation.lat, self.userLocation.lng, parseFloat(store.lat), parseFloat(store.lng));
      }
      var isOpen = self.isStoreOpen(store);
      return $.extend({}, store, { distance: dist, isOpen: isOpen });
    });

    // 1. Category Filter
    if (self.currentCategory !== 'all') {
      list = list.filter(function(s) {
        return (s.category || '').toLowerCase() === self.currentCategory.toLowerCase();
      });
    }

    // 2. Division Filter
    if (self.currentDivision !== 'all') {
      list = list.filter(function(s) {
        return (s.division || '').toLowerCase() === self.currentDivision.toLowerCase();
      });
    }

    // 3. Search Query
    if (self.searchQuery.trim() !== '') {
      var q = self.searchQuery.toLowerCase().trim();
      list = list.filter(function(s) {
        var amenitiesStr = Array.isArray(s.amenities) ? s.amenities.join(' ') : '';
        return (
          (s.name && s.name.toLowerCase().indexOf(q) !== -1) ||
          (s.address && s.address.toLowerCase().indexOf(q) !== -1) ||
          (s.district && s.district.toLowerCase().indexOf(q) !== -1) ||
          (s.division && s.division.toLowerCase().indexOf(q) !== -1) ||
          (s.contact_person && s.contact_person.toLowerCase().indexOf(q) !== -1) ||
          (s.phone && s.phone.toLowerCase().indexOf(q) !== -1) ||
          (amenitiesStr.toLowerCase().indexOf(q) !== -1)
        );
      });
    }

    // 4. Open Now Only Filter
    if (self.openNowOnly) {
      list = list.filter(function(s) {
        return s.isOpen === true;
      });
    }

    // 5. Amenities Filter
    if (self.selectedAmenity && self.selectedAmenity !== 'all') {
      var targetAmenity = self.selectedAmenity.toLowerCase().trim();
      list = list.filter(function(s) {
        if (!Array.isArray(s.amenities)) return false;
        return s.amenities.some(function(a) {
          return (a || '').toLowerCase().trim() === targetAmenity;
        });
      });
    }

    // 6. Radius Filter (when user location active)
    if (self.userLocation && self.maxRadius < (self.config.maxRadius || 150)) {
      list = list.filter(function(s) {
        return s.distance !== null && s.distance <= self.maxRadius;
      });
    }

    // 7. Sorting
    if (self.sortBy === 'distance' && self.userLocation) {
      list.sort(function(a, b) { return (a.distance || 0) - (b.distance || 0); });
    } else if (self.sortBy === 'name-asc') {
      list.sort(function(a, b) { return (a.name || '').localeCompare(b.name || ''); });
    } else if (self.sortBy === 'name-desc') {
      list.sort(function(a, b) { return (b.name || '').localeCompare(a.name || ''); });
    } else if (self.sortBy === 'featured') {
      list.sort(function(a, b) { return (b.featured ? 1 : 0) - (a.featured ? 1 : 0); });
    } else {
      if (self.userLocation) {
        list.sort(function(a, b) { return (a.distance || 0) - (b.distance || 0); });
      } else {
        list.sort(function(a, b) { return (b.featured ? 1 : 0) - (a.featured ? 1 : 0); });
      }
    }

    return list;
  };

  /**
   * Render Store Pins and Cards
   */
  StoreLocatorInstance.prototype.render = function() {
    var self = this;
    var filtered = self.getFilteredStores();

    // Clear marker cluster
    if (self.markerCluster) {
      self.markerCluster.clearLayers();
    } else if (self.map) {
      Object.keys(self.markersById).forEach(function(k) {
        self.map.removeLayer(self.markersById[k]);
      });
    }
    self.markersById = {};
    self.$storeList.empty();

    // Results count text
    var unit = self.config.distanceUnit || 'km';
    var countText = filtered.length === 1 
      ? '1 Location Found' 
      : filtered.length + ' Locations Found';
    self.$resultsCount.text(countText);

    if (filtered.length === 0) {
      self.$emptyState.show();
      return;
    } else {
      self.$emptyState.hide();
    }

    // Add markers & cards
    filtered.forEach(function(store) {
      if (!store.lat || !store.lng) return;

      // Create Custom Pin Icon
      var pinIcon = self.createCustomPin(store);
      var marker = L.marker([parseFloat(store.lat), parseFloat(store.lng)], { icon: pinIcon });

      marker.bindPopup(self.createPopupContent(store), {
        maxWidth: 300,
        minWidth: 260,
        autoPan: true,
        autoPanPaddingTopLeft: [20, 95],
        autoPanPaddingBottomRight: [20, 20]
      });

      marker.on('click', function() {
        self.highlightCard(store.id);
      });

      if (self.markerCluster) {
        self.markerCluster.addLayer(marker);
      } else {
        marker.addTo(self.map);
      }

      self.markersById[store.id] = marker;

      // Card
      var $card = self.createStoreCardElement(store);
      self.$storeList.append($card);
    });
  };

  /**
   * SVG Icon Helpers for zero-dependency 100% reliable rendering
   */
  var RSL_ICONS = {
    star: '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>',
    store: '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/></svg>',
    building: '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>',
    pin: '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>',
    phone: '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>',
    user: '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>',
    email: '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
    clock: '<svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>',
    arrow: '<svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>',
    map: '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>',
    directions: '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.71 11.29l-9-9a.996.996 0 0 0-1.41 0l-9 9a.996.996 0 0 0 0 1.41l9 9c.39.39 1.02.39 1.41 0l9-9a.996.996 0 0 0 0-1.41zm-8.71 6.29V14H9c-.55 0-1-.45-1-1v-4c0-.55.45-1 1-1s1 .45 1 1v3h3V9.41l3.29 3.29-3.29 3.29z"/></svg>',
    copy: '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>',
    share: '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/></svg>'
  };

  /**
   * Create Custom Pin Icon
   */
  StoreLocatorInstance.prototype.createCustomPin = function(store) {
    var cat = (store.category || '').toLowerCase();
    var pinClass = 'rsl-pin-dealer';
    var iconSvg = RSL_ICONS.store;

    if (cat === 'flagship') {
      pinClass = 'rsl-pin-flagship';
      iconSvg = RSL_ICONS.star;
    } else if (cat === 'corporate') {
      pinClass = 'rsl-pin-corporate';
      iconSvg = RSL_ICONS.building;
    }

    // 1. Custom Pin Image (uploaded image)
    var pinImage = store.pinImage || store.pin_image;
    if (pinImage) {
      return L.divIcon({
        className: 'rsl-custom-pin rsl-pin-custom-image',
        html: '<div class="rsl-pin-image-wrap" title="' + this.escapeHtml(store.name) + '"><img src="' + this.escapeHtml(pinImage) + '" alt="' + this.escapeHtml(store.name) + '" /></div>',
        iconSize: [38, 44],
        iconAnchor: [19, 44],
        popupAnchor: [0, -40]
      });
    }

    // 2. Custom Pin Icon (Font Awesome / SVG from Elementor Icon Picker or JSON)
    var customIcon = store.pinIcon || store.pin_icon || store.icon;
    if (customIcon) {
      iconSvg = customIcon;
    }

    // 3. Custom Pin Color (from Color picker or JSON)
    var pinColor = store.pinColor || store.pin_color || store.color;
    var customStyle = '';
    if (pinColor) {
      customStyle = ' style="--rsl-pin-color:' + this.escapeHtml(pinColor) + ';"';
    }

    return L.divIcon({
      className: 'rsl-custom-pin ' + pinClass,
      html: '<div class="rsl-pin-icon-wrap"' + customStyle + ' title="' + this.escapeHtml(store.name) + '">' + iconSvg + '</div>',
      iconSize: [36, 42],
      iconAnchor: [18, 42],
      popupAnchor: [0, -38]
    });
  };

  /**
   * Create Popup HTML Content
   */
  StoreLocatorInstance.prototype.createPopupContent = function(store) {
    var cat = (store.category || '').toLowerCase();
    var badgeClass = cat === 'flagship' ? 'rsl-type-flagship' :
                     cat === 'corporate' ? 'rsl-type-corporate' : 'rsl-type-dealer';

    var directionsUrl = this.getDirectionsUrl(store);
    var phoneClean = store.phone ? store.phone.split(',')[0].replace(/[^0-9+]/g, '') : '';

    var html = '<div class="rsl-popup-card">' +
      '<div class="rsl-popup-header">' +
        '<span class="rsl-popup-badge ' + badgeClass + '">' + this.escapeHtml(store.type || 'Store') + '</span>' +
        '<h4 class="rsl-popup-title">' + this.escapeHtml(store.name) + '</h4>' +
      '</div>' +
      '<div class="rsl-popup-body">';

    if (store.address) {
      html += '<div class="rsl-popup-item">' + RSL_ICONS.pin + '<span>' + this.escapeHtml(store.address) + '</span></div>';
    }
    if (store.phone) {
      html += '<div class="rsl-popup-item">' + RSL_ICONS.phone + '<a href="tel:' + phoneClean + '" class="rsl-detail-link">' + this.escapeHtml(store.phone) + '</a></div>';
    }
    if (store.hours) {
      var statusHtml = store.isOpen === true 
        ? '<span class="rsl-status-indicator open"><span class="rsl-status-dot online"></span> Open Now</span>'
        : (store.isOpen === false ? '<span class="rsl-status-indicator closed"><span class="rsl-status-dot offline"></span> Closed</span>' : '');

      html += '<div class="rsl-popup-item">' + RSL_ICONS.clock + '<span>' + this.escapeHtml(store.hours) + ' ' + statusHtml + '</span></div>';
    }

    html += '</div>' +
      '<div class="rsl-popup-footer">';

    if (phoneClean) {
      html += '<a href="tel:' + phoneClean + '" class="rsl-popup-btn btn-call">' + RSL_ICONS.phone + ' Call Now</a>';
    }
    html += '<a href="' + directionsUrl + '" target="_blank" rel="noopener" class="rsl-popup-btn rsl-btn-primary">' + RSL_ICONS.directions + ' Directions</a>' +
      '</div></div>';

    return html;
  };

  /**
   * Get Directions Navigation URL
   */
  StoreLocatorInstance.prototype.getDirectionsUrl = function(store) {
    var lat = store.lat;
    var lng = store.lng;
    var service = this.config.directionsService || 'google';

    if (service === 'apple') {
      return 'https://maps.apple.com/?daddr=' + lat + ',' + lng;
    } else if (service === 'waze') {
      return 'https://waze.com/ul?ll=' + lat + ',' + lng + '&navigate=yes';
    }
    // Default: Google Maps
    return 'https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lng;
  };

  /**
   * Create Store Card DOM Element
   */
  StoreLocatorInstance.prototype.createStoreCardElement = function(store) {
    var self = this;
    var $card = $('<div class="rsl-store-card" id="card-' + store.id + '"></div>');
    if (store.featured) {
      $card.addClass('featured-card');
    }

    var cat = (store.category || '').toLowerCase();
    var badgeClass = cat === 'flagship' ? 'rsl-type-flagship' :
                     cat === 'corporate' ? 'rsl-type-corporate' : 'rsl-type-dealer';

    var directionsUrl = self.getDirectionsUrl(store);
    var phoneClean = store.phone ? store.phone.split(',')[0].replace(/[^0-9+]/g, '') : '';
    var unit = self.config.distanceUnit || 'km';

    var distanceHtml = (store.distance !== null && store.distance !== undefined)
      ? '<span class="rsl-distance-badge">' + RSL_ICONS.arrow + ' ' + store.distance.toFixed(1) + ' ' + unit + ' away</span>'
      : '';

    // Card Thumbnail Image
    var showImg = self.config.showCardImage !== false;
    var imageHtml = (showImg && store.image)
      ? '<div class="rsl-card-img-wrap"><img src="' + self.escapeHtml(store.image) + '" alt="' + self.escapeHtml(store.name) + '" loading="lazy" /></div>'
      : '';

    // Status Indicator
    var statusHtml = '';
    var showStatus = self.config.showOpenNowStatus !== false;
    if (showStatus && store.hours) {
      if (store.isOpen === true) {
        statusHtml = '<span class="rsl-status-indicator open"><span class="rsl-status-dot online"></span> Open Now</span>';
      } else if (store.isOpen === false) {
        statusHtml = '<span class="rsl-status-indicator closed"><span class="rsl-status-dot offline"></span> Closed</span>';
      }
    }

    // Amenities Chips
    var amenitiesHtml = '';
    if (Array.isArray(store.amenities) && store.amenities.length > 0) {
      amenitiesHtml = '<div class="rsl-amenities-chips">' +
        store.amenities.slice(0, 4).map(function(a) {
          return '<span class="rsl-amenity-chip">' + self.escapeHtml(a) + '</span>';
        }).join('') +
      '</div>';
    }

    var cardContent = imageHtml +
      '<div class="rsl-card-header-row">' +
        '<div class="rsl-card-title-group">' +
          '<span class="rsl-store-type-badge ' + badgeClass + '">' + self.escapeHtml(store.type || 'Showroom') + '</span>' +
          '<h3 class="rsl-store-title">' + self.escapeHtml(store.name) + '</h3>' +
        '</div>' +
        distanceHtml +
      '</div>' +
      '<div class="rsl-card-details">';

    if (store.address) {
      cardContent += '<div class="rsl-detail-item">' + RSL_ICONS.pin + '<span>' + self.escapeHtml(store.address) + '</span></div>';
    }
    if (self.config.showContactPerson !== false && store.contact_person) {
      cardContent += '<div class="rsl-detail-item">' + RSL_ICONS.user + '<span>' + self.escapeHtml(store.contact_person) + '</span></div>';
    }
    if (self.config.showPhone !== false && store.phone) {
      cardContent += '<div class="rsl-detail-item">' + RSL_ICONS.phone + '<a href="tel:' + phoneClean + '" class="rsl-detail-link" onclick="event.stopPropagation()">' + self.escapeHtml(store.phone) + '</a></div>';
    }
    if (self.config.showEmail !== false && store.email) {
      cardContent += '<div class="rsl-detail-item">' + RSL_ICONS.email + '<a href="mailto:' + self.escapeHtml(store.email) + '" class="rsl-detail-link" onclick="event.stopPropagation()">' + self.escapeHtml(store.email) + '</a></div>';
    }
    if (self.config.showHours !== false && store.hours) {
      cardContent += '<div class="rsl-detail-item">' + RSL_ICONS.clock + '<span>' + self.escapeHtml(store.hours) + ' ' + statusHtml + '</span></div>';
    }

    cardContent += amenitiesHtml + '</div>' +
      '<div class="rsl-card-actions">';

      var viewMapLabel = self.config.viewMapBtnText || 'View Map';
      var directionsLabel = self.config.directionsBtnText || 'Directions';

      if (self.config.showViewMapBtn !== false) {
        cardContent += '<button type="button" class="rsl-card-btn rsl-btn-secondary rsl-view-map-btn" data-id="' + store.id + '">' + RSL_ICONS.map + ' <span>' + self.escapeHtml(viewMapLabel) + '</span></button>';
      }
      if (self.config.showDirectionsBtn !== false) {
        cardContent += '<a href="' + directionsUrl + '" target="_blank" rel="noopener" class="rsl-card-btn rsl-btn-primary" onclick="event.stopPropagation()">' + RSL_ICONS.directions + ' <span>' + self.escapeHtml(directionsLabel) + '</span></a>';
      }
    if (self.config.showShareBtn !== false) {
      cardContent += '<button type="button" class="rsl-btn-icon-only rsl-copy-btn" title="Copy Address" data-address="' + self.escapeHtml(store.address) + '" onclick="event.stopPropagation()">' + RSL_ICONS.copy + '</button>';
      cardContent += '<button type="button" class="rsl-btn-icon-only rsl-share-btn" title="Share Location" data-title="' + self.escapeHtml(store.name) + '" data-url="' + directionsUrl + '" onclick="event.stopPropagation()">' + RSL_ICONS.share + '</button>';
    }

    cardContent += '</div>';

    $card.html(cardContent);

    // Event: Click card to focus on store
    $card.on('click', function(e) {
      if ($(e.target).closest('a, button').length) return;
      self.focusOnStore(store.id);
    });

    $card.find('.rsl-view-map-btn').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      self.focusOnStore(store.id);
    });

    // Copy Address Button
    $card.find('.rsl-copy-btn').on('click', function(e) {
      e.stopPropagation();
      var addr = $(this).data('address');
      if (addr && navigator.clipboard) {
        navigator.clipboard.writeText(addr).then(function() {
          self.showToast('📋 Address copied to clipboard!');
        });
      }
    });

    // Share Button
    $card.find('.rsl-share-btn').on('click', function(e) {
      e.stopPropagation();
      var title = $(this).data('title');
      var shareUrl = $(this).data('url');

      if (navigator.share) {
        navigator.share({
          title: title,
          text: 'Find ' + title + ' on Google Maps:',
          url: shareUrl
        }).catch(function() {});
      } else {
        // Fallback: WhatsApp share
        var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out ' + title + ': ' + shareUrl);
        window.open(waUrl, '_blank');
      }
    });

    return $card;
  };

  /**
   * Focus on Store (Fly map and open popup)
   */
  StoreLocatorInstance.prototype.focusOnStore = function(storeId) {
    var self = this;
    var store = self.stores.find(function(s) { return s.id === storeId; });
    var marker = self.markersById[storeId];

    if (!store || !marker || !self.map) return;

    self.highlightCard(storeId);

    // Offset latitude slightly north (+0.0032) to prevent popup cutoff at the top
    var offsetLat = parseFloat(store.lat) + 0.0032;
    var targetZoom = Math.max(self.map.getZoom(), 15);

    if (self.markerCluster) {
      self.markerCluster.zoomToShowLayer(marker, function() {
        self.map.setView([offsetLat, parseFloat(store.lng)], targetZoom, { animate: false });
        marker.openPopup();
      });
    } else {
      self.map.setView([offsetLat, parseFloat(store.lng)], targetZoom, { animate: true });
      marker.openPopup();
    }

    // On mobile screens, collapse drawer slightly so map is visible
    if (window.innerWidth <= 768) {
      self.$sidebar.removeClass('expanded');
    }
  };

  /**
   * Highlight Active Store Card in List
   */
  StoreLocatorInstance.prototype.highlightCard = function(storeId) {
    this.$storeList.find('.rsl-store-card').removeClass('active');
    var $target = this.$storeList.find('#card-' + storeId);
    if ($target.length) {
      $target.addClass('active');
      $target[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
  };

  /**
   * Fit Map Bounds to all store markers
   */
  StoreLocatorInstance.prototype.fitAllStoresBounds = function(options) {
    var self = this;
    if (!self.map || self.stores.length === 0) return;

    var markerArray = Object.values(self.markersById);
    if (markerArray.length > 0) {
      var group = L.featureGroup(markerArray);
      var bounds = group.getBounds();
      if (bounds.isValid()) {
        self.map.fitBounds(bounds.pad(0.12), Object.assign({
          animate: true,
          duration: 0.8,
          maxZoom: 12
        }, options || {}));
        return;
      }
    }

    var centerLat = self.config.defaultLat || 23.8103;
    var centerLng = self.config.defaultLng || 90.4125;
    var zoom = self.config.defaultZoom || 7;
    self.map.flyTo([centerLat, centerLng], zoom, { duration: 0.8 });
  };

  /**
   * Geolocation Handler ("Near Me")
   */
  StoreLocatorInstance.prototype.handleGeolocation = function() {
    var self = this;
    self.$nearMeBtn.html('<i class="fa-solid fa-spinner fa-spin"></i> Locating...');
    self.$locateMeMapBtn.html('<i class="fa-solid fa-spinner fa-spin"></i>');

    function onLocationSuccess(lat, lng, accuracy, label) {
      self.userLocation = {
        lat: parseFloat(lat),
        lng: parseFloat(lng),
        accuracy: accuracy || 1000
      };

      self.$nearMeBtn.html('<i class="fa-solid fa-location-crosshairs"></i> Near Me').addClass('active');
      self.$locateMeMapBtn.html('<i class="fa-solid fa-crosshairs"></i>');

      // Show radius filter slider
      self.$radiusContainer.addClass('visible');

      // Default sort to distance
      self.sortBy = 'distance';
      if (self.$sortSelect.length) {
        self.$sortSelect.val('distance');
      }

      // Add/update User Location Marker & Circle on map
      self.updateUserLocationMarker(label);

      // Re-render stores with distance calculated
      self.render();

      // Zoom to user location
      self.map.flyTo([self.userLocation.lat, self.userLocation.lng], 13, { duration: 1.2 });

      self.showToast('📍 Location found: ' + (label || 'Near you') + ' (Sorted by nearest)');
    }

    function fallbackIpLocation() {
      fetch('https://ipwho.is/')
        .then(function(res) { return res.json(); })
        .then(function(data) {
          if (data && data.success !== false && data.latitude && data.longitude) {
            var cityName = data.city || data.region || 'Dhaka';
            onLocationSuccess(data.latitude, data.longitude, 2500, cityName);
          } else {
            throw new Error('ipwho invalid');
          }
        })
        .catch(function() {
          fetch('https://freeipapi.com/api/json')
            .then(function(res) { return res.json(); })
            .then(function(data) {
              if (data && data.latitude && data.longitude) {
                var cityName = data.cityName || 'Dhaka';
                onLocationSuccess(data.latitude, data.longitude, 3000, cityName);
              } else {
                throw new Error('freeipapi invalid');
              }
            })
            .catch(function() {
              self.$nearMeBtn.html('<i class="fa-solid fa-location-crosshairs"></i> Near Me');
              self.$locateMeMapBtn.html('<i class="fa-solid fa-crosshairs"></i>');
              self.showToast('Could not detect location. Please select a division from dropdown.');
            });
        });
    }

    if (navigator.geolocation && location.protocol !== 'file:') {
      navigator.geolocation.getCurrentPosition(
        function(pos) {
          onLocationSuccess(pos.coords.latitude, pos.coords.longitude, pos.coords.accuracy, 'Your Location');
        },
        function(err) {
          console.warn('Browser GPS unavailable, using IP geolocation fallback...', err);
          fallbackIpLocation();
        },
        { enableHighAccuracy: false, timeout: 3500, maximumAge: 300000 }
      );
    } else {
      fallbackIpLocation();
    }
  };

  /**
   * Update User Location Marker & Accuracy Circle
   */
  StoreLocatorInstance.prototype.updateUserLocationMarker = function(label) {
    var self = this;
    if (!self.userLocation || !self.map) return;

    if (self.userMarker) self.map.removeLayer(self.userMarker);
    if (self.userAccuracyCircle) self.map.removeLayer(self.userAccuracyCircle);
    if (self.activeRadiusCircle) self.map.removeLayer(self.activeRadiusCircle);

    var userPinIcon = L.divIcon({
      className: 'rsl-user-location-pin',
      html: '<div class="rsl-user-location-pulse"></div>',
      iconSize: [20, 20],
      iconAnchor: [10, 10]
    });

    var popupText = '<b>' + self.escapeHtml(label || 'Your Current Location') + '</b><br>Searching nearest showrooms from here';

    self.userMarker = L.marker([self.userLocation.lat, self.userLocation.lng], { icon: userPinIcon, zIndexOffset: 10000 })
      .bindPopup(popupText)
      .addTo(self.map);

    self.userAccuracyCircle = L.circle([self.userLocation.lat, self.userLocation.lng], {
      radius: Math.min(self.userLocation.accuracy || 1000, 3000),
      color: '#2563eb',
      fillColor: '#3b82f6',
      fillOpacity: 0.1,
      weight: 1
    }).addTo(self.map);

    var radiusMeters = (self.config.distanceUnit === 'miles') ? self.maxRadius * 1609.34 : self.maxRadius * 1000;
    self.activeRadiusCircle = L.circle([self.userLocation.lat, self.userLocation.lng], {
      radius: radiusMeters,
      color: '#047857',
      fillColor: '#059669',
      fillOpacity: 0.08,
      weight: 1.5,
      dashArray: '5, 5'
    }).addTo(self.map);
  };

  /**
   * Toast notification feedback
   */
  StoreLocatorInstance.prototype.showToast = function(message) {
    var $toast = $('#rsl-toast');
    if (!$toast.length) {
      $toast = $('<div id="rsl-toast" class="rsl-toast-msg"></div>');
      $('body').append($toast);
    }
    $toast.html('<i class="fa-solid fa-circle-info"></i> ' + message).addClass('show');
    setTimeout(function() {
      $toast.removeClass('show');
    }, 3200);
  };

  /**
   * Helper: Escape HTML
   */
  StoreLocatorInstance.prototype.escapeHtml = function(string) {
    if (!string) return '';
    return String(string).replace(/[&<>"'`=\/]/g, function(s) {
      return ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
        '/': '&#x2F;',
        '`': '&#x60;',
        '=': '&#x3D;'
      })[s];
    });
  };

  /**
   * Bind DOM Events
   */
  StoreLocatorInstance.prototype.bindEvents = function() {
    var self = this;

    // Search Input with debounce
    var searchTimeout;
    self.$searchInput.on('input', function(e) {
      self.searchQuery = $(this).val();
      self.$clearSearch.toggle(Boolean(self.searchQuery));

      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(function() {
        self.render();
      }, 200);
    });

    self.$clearSearch.off('.rsl').on('click.rsl', function() {
      self.$searchInput.val('');
      self.searchQuery = '';
      self.$clearSearch.hide();
      self.render();
      self.$searchInput.focus();
    });

    // Division Filter
    self.$divisionSelect.off('.rsl').on('change.rsl', function() {
      self.currentDivision = $(this).val();
      self.render();
      self.fitAllStoresBounds();
    });

    // Category Pills
    self.$categoryPills.off('.rsl').on('click.rsl', function() {
      var $this = $(this);
      var cat = $this.data('category');

      self.$categoryPills.removeClass('active');
      $this.addClass('active');
      self.currentCategory = cat;

      // When "All Stores" is clicked: show all, reset other filters and zoom out map
      if (cat === 'all') {
        // Reset search query
        self.searchQuery = '';
        self.$searchInput.val('');
        self.$clearSearch.hide();

        // Reset division filter
        self.currentDivision = 'all';
        self.$divisionSelect.val('all');

        // Reset Open Now filter
        self.openNowOnly = false;
        self.$openNowCheckbox.prop('checked', false);

        // Reset Amenity filter
        self.selectedAmenity = 'all';
        self.$amenitiesMenu.find('.rsl-amenity-item').removeClass('active');
        self.$amenitiesMenu.find('[data-amenity="all"]').addClass('active');
        self.$amenityToggleBtn.removeClass('active');
        self.$amenityToggleBtn.find('span').text('Amenities');

        // Reset Near Me location / radius if active
        if (self.activeRadiusCircle && self.map) {
          self.map.removeLayer(self.activeRadiusCircle);
          self.activeRadiusCircle = null;
        }
        if (self.userMarker && self.map) {
          self.map.removeLayer(self.userMarker);
          self.userMarker = null;
        }
        if (self.userAccuracyCircle && self.map) {
          self.map.removeLayer(self.userAccuracyCircle);
          self.userAccuracyCircle = null;
        }
        self.userLocation = null;
        self.$radiusContainer.slideUp(200);
        self.$nearMeBtn.removeClass('active');

        // Close any open popup on map
        if (self.map) {
          self.map.closePopup();
        }

        // Remove active card highlight
        self.$storeList.find('.rsl-store-card').removeClass('active');

        // Scroll store list back to top
        self.$sidebar.find('.rsl-store-list-container').scrollTop(0);
      }

      self.render();
      self.fitAllStoresBounds();
    });

    // Open Now Checkbox
    self.$openNowCheckbox.off('.rsl').on('change.rsl', function() {
      self.openNowOnly = $(this).is(':checked');

      if (self.map) {
        self.map.closePopup();
      }

      self.render();
      self.fitAllStoresBounds();
    });

    // Amenities Toggle Button
    self.$amenityToggleBtn.off('.rsl').on('click.rsl', function(e) {
      e.preventDefault();
      e.stopPropagation();
      self.$amenitiesMenu.toggleClass('show');
    });

    $(document).off('.rsl-' + self.config.id).on('click.rsl-' + self.config.id, function(e) {
      if (!$(e.target).closest('.rsl-amenities-dropdown-wrap').length) {
        self.$amenitiesMenu.removeClass('show');
      }
    });

    // Near Me Buttons
    self.$nearMeBtn.off('.rsl').on('click.rsl', function() { self.handleGeolocation(); });
    self.$locateMeMapBtn.off('.rsl').on('click.rsl', function() { self.handleGeolocation(); });

    // Radius Slider
    self.$radiusSlider.off('.rsl').on('input.rsl', function() {
      self.maxRadius = parseInt($(this).val(), 10);
      var unit = self.config.distanceUnit || 'km';
      var maxAllowed = self.config.maxRadius || 150;
      self.$radiusValue.text(self.maxRadius >= maxAllowed ? 'Unlimited' : (self.maxRadius + ' ' + unit));

      if (self.activeRadiusCircle && self.userLocation) {
        var radiusMeters = (unit === 'miles') ? self.maxRadius * 1609.34 : self.maxRadius * 1000;
        self.activeRadiusCircle.setRadius(radiusMeters);
      }
      self.render();
    });

    // Sort Select
    self.$sortSelect.off('.rsl').on('change.rsl', function() {
      self.sortBy = $(this).val();
      self.render();
    });

    // Reset View
    self.$resetViewBtn.off('.rsl').on('click.rsl', function() {
      self.fitAllStoresBounds();
      self.showToast('Showing all showroom locations');
    });

    // Fullscreen Toggle
    self.$fullscreenBtn.off('.rsl').on('click.rsl', function() {
      var appEl = self.$app[0];
      if (!document.fullscreenElement) {
        if (appEl.requestFullscreen) appEl.requestFullscreen();
        self.$fullscreenBtn.html('<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-14v3h3v2h-5V5h2z"/></svg>');
      } else {
        if (document.exitFullscreen) document.exitFullscreen();
        self.$fullscreenBtn.html('<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>');
      }
      setTimeout(function() {
        if (self.map) self.map.invalidateSize();
      }, 250);
    });

    // Sidebar Collapse / Expand Toggle
    self.$sidebarToggleBtn.off('.rsl').on('click.rsl', function() {
      var isCollapsed = self.$sidebar.toggleClass('collapsed').hasClass('collapsed');
      self.$app.toggleClass('sidebar-hidden', isCollapsed);

      if (isCollapsed) {
        self.$sidebarToggleBtn.html('<svg class="rsl-sidebar-toggle-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>');
        self.$sidebarToggleBtn.attr('aria-label', 'Show sidebar');
      } else {
        self.$sidebarToggleBtn.html('<svg class="rsl-sidebar-toggle-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>');
        self.$sidebarToggleBtn.attr('aria-label', 'Hide sidebar');
      }

      setTimeout(function() {
        if (self.map) self.map.invalidateSize();
      }, 320);
    });

    // Mobile Bottom Sheet Drawer Toggle
    self.$mobileToggleBtn.off('.rsl').on('click.rsl', function() {
      self.$sidebar.toggleClass('expanded');
    });

    self.$app.find('.rsl-sidebar-header').off('.rsl').on('click.rsl', function() {
      if (window.innerWidth <= 768) {
        self.$sidebar.toggleClass('expanded');
      }
    });
  };

  /**
   * DOM Ready
   */
  $(document).ready(function() {
    if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) {
      $('.royal-store-locator-app').each(function() {
        initStoreLocator($(this).closest('.elementor-widget'));
      });
    }
  });

  /**
   * Elementor Frontend Hooks
   */
  $(window).on('elementor/frontend/init', function() {
    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
      elementorFrontend.hooks.addAction('frontend/element_ready/royalstorelocator.default', function($scope) {
        initStoreLocator($scope);
      });
    }
  });

})(jQuery);
