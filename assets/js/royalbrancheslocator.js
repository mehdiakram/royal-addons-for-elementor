/**
 * Royal Branches Locator - Modular Controller
 * Fully scoped and instance-safe for Elementor
 * Developed by Royal Technologies (https://royaltechbd.com)
 */

(function () {
  'use strict';

  // Haversine Distance Formula (in kilometers)
  function calculateDistance(lat1, lon1, lat2, lon2) {
    var R = 6371;
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
      Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return (R * c).toFixed(1);
  }

  function initBranchesLocator(wrap) {
    if (!wrap || wrap.dataset.rblInitialized === 'true') return;
    wrap.dataset.rblInitialized = 'true';

    // Instance Settings
    var allowCards = wrap.dataset.allowCards === 'yes';
    var defaultStyle = wrap.dataset.defaultStyle || (allowCards ? 'cards' : 'map');
    if (!allowCards && defaultStyle === 'cards') {
      defaultStyle = 'map';
    }

    var defaultMediaType = wrap.dataset.defaultMediaType || 'icon';
    var defaultImageUrl = wrap.dataset.defaultImageUrl || '';
    var defaultIconTpl = wrap.querySelector('.rbl-default-icon-tpl');
    var defaultIconHtml = defaultIconTpl ? defaultIconTpl.innerHTML : '<i class="bi bi-buildings"></i>';

    var currentStyle = defaultStyle;
    var currentTheme = wrap.getAttribute('data-theme') || 'default';
    var currentArea = 'all';
    var currentDistrict = 'all';
    var searchQuery = '';
    var userLocation = null;
    var leafletMap = null;
    var mapMarkers = [];
    var branchesData = [];

    // Elements inside this widget instance
    var searchInput = wrap.querySelector('.rbl-search-input');
    var districtSelect = wrap.querySelector('.rbl-district-select');
    var areaChips = wrap.querySelectorAll('.rbl-chip');
    var resultCountEl = wrap.querySelector('.rbl-result-count');
    var resetBtn = wrap.querySelector('.btn-reset-filters');
    var emptyStateEl = wrap.querySelector('.rbl-empty-state');
    var gpsBtn = wrap.querySelector('.rbl-btn-gps');
    var themeBtn = wrap.querySelector('.rbl-theme-toggle');
    var exportCsvBtn = wrap.querySelector('.rbl-export-csv');
    var printTableBtn = wrap.querySelector('.rbl-print-table');

    var cardsContainer = wrap.querySelector('.rbl-cards-container');
    var mapLayoutEl = wrap.querySelector('.rbl-map-layout');
    var mapSidebarList = wrap.querySelector('.rbl-map-sidebar-list');
    var mapDiv = wrap.querySelector('.rbl-leaflet-map');
    var directoryContainer = wrap.querySelector('.rbl-directory-container');
    var tableContainer = wrap.querySelector('.rbl-table-container');
    var tableBody = wrap.querySelector('.rbl-table-body');

    // Parse Data Source
    var rawJsonEl = wrap.querySelector('.rbl-raw-data');
    if (rawJsonEl) {
      try {
        var parsed = JSON.parse(rawJsonEl.textContent || '[]');
        if (Array.isArray(parsed) && parsed.length > 0) {
          branchesData = parsed;
        }
      } catch (err) {
        console.warn('Branches Locator: Error parsing inline data', err);
      }
    }

    // Load data if empty
    function loadDataAndRender() {
      if (branchesData.length > 0) {
        updateStats();
        switchStyle(currentStyle);
        return;
      }

      var customJsonUrl = wrap.dataset.jsonUrl || '';
      var fetchUrl = customJsonUrl || ((window.royalBranchesLocatorConfig && window.royalBranchesLocatorConfig.presetUrl) || '');
      if (fetchUrl) {
        fetch(fetchUrl)
          .then(function (res) { return res.json(); })
          .then(function (data) {
            branchesData = Array.isArray(data) ? data : [];
            updateStats();
            switchStyle(currentStyle);
          })
          .catch(function (err) {
            console.error('Branches Locator: Failed to load data from ' + fetchUrl, err);
          });
      }
    }

    // Filter branches
    function getFilteredBranches() {
      if (!branchesData || branchesData.length === 0) return [];

      var list = branchesData.filter(function (b) {
        // Area Match
        if (currentArea && currentArea !== 'all') {
          var areaStr = (b.area || '').toLowerCase();
          if (areaStr !== currentArea.toLowerCase()) return false;
        }

        // District Match
        if (currentDistrict && currentDistrict !== 'all') {
          var dNameEn = (b.district_en || '').toLowerCase();
          var dNameBn = (b.district || '').toLowerCase();
          var qDist = currentDistrict.toLowerCase();
          if (dNameEn !== qDist && dNameBn !== qDist) return false;
        }

        // Live Text Search
        if (searchQuery && searchQuery.trim() !== '') {
          var q = searchQuery.toLowerCase().trim();
          var pool = [
            b.name || '',
            b.bn_name || '',
            b.area || '',
            b.district || '',
            b.district_en || '',
            b.upazila || '',
            b.upazila_en || '',
            b.address || '',
            b.phone || '',
            b.email || ''
          ].join(' ').toLowerCase();

          if (pool.indexOf(q) === -1) return false;
        }

        return true;
      });

      // GPS distance calculation
      if (userLocation) {
        list = list.map(function (b) {
          var dist = calculateDistance(userLocation.lat, userLocation.lng, b.lat, b.lng);
          return Object.assign({}, b, { distance: dist });
        }).sort(function (a, b) {
          return parseFloat(a.distance) - parseFloat(b.distance);
        });
      }

      return list;
    }

    // Switch Active Layout Style
    function switchStyle(styleName) {
      if (!allowCards && styleName === 'cards') {
        styleName = 'map';
      }

      currentStyle = styleName;

      // Update switcher pills inside this widget
      wrap.querySelectorAll('.style-pill').forEach(function (btn) {
        var pillStyle = btn.getAttribute('data-style');
        btn.classList.toggle('active', pillStyle === styleName);
      });

      if (cardsContainer) cardsContainer.style.display = styleName === 'cards' ? 'grid' : 'none';
      if (mapLayoutEl) mapLayoutEl.style.display = styleName === 'map' ? 'grid' : 'none';
      if (directoryContainer) directoryContainer.style.display = styleName === 'directory' ? 'block' : 'none';
      if (tableContainer) tableContainer.style.display = styleName === 'table' ? 'block' : 'none';

      if (styleName === 'map') {
        setTimeout(function () {
          if (!leafletMap) {
            initLeafletMap();
          } else {
            leafletMap.invalidateSize();
          }
        }, 120);
      }

      renderCurrentView();
    }

    // Update Stats counters if present
    function updateStats() {
      var totalBranchesEl = wrap.querySelector('.rbl-stat-total-val');
      var totalDistrictsEl = wrap.querySelector('.rbl-stat-dist-val');
      var totalUpazilasEl = wrap.querySelector('.rbl-stat-upazila-val');

      if (totalBranchesEl && totalBranchesEl.dataset.autoCount === 'yes') {
        totalBranchesEl.textContent = branchesData.length;
      }

      if (totalDistrictsEl && totalDistrictsEl.dataset.autoCount === 'yes') {
        var distSet = new Set(branchesData.map(function (b) { return b.district_en || b.district; }));
        totalDistrictsEl.textContent = distSet.size;
      }

      if (totalUpazilasEl && totalUpazilasEl.dataset.autoCount === 'yes') {
        var upazilaSet = new Set(branchesData.map(function (b) { return b.upazila_en || b.upazila; }));
        totalUpazilasEl.textContent = upazilaSet.size;
      }
    }

    // Render Current View
    function renderCurrentView() {
      var list = getFilteredBranches();

      if (resultCountEl) {
        resultCountEl.innerHTML = 'Showing <b>' + list.length + '</b> of <b>' + branchesData.length + '</b> branches';
      }

      if (emptyStateEl) {
        emptyStateEl.style.display = list.length === 0 ? 'block' : 'none';
      }

      if (currentStyle === 'cards' && allowCards) {
        renderCards(list);
      } else if (currentStyle === 'map') {
        renderMap(list);
      } else if (currentStyle === 'directory') {
        renderDirectory(list);
      } else if (currentStyle === 'table') {
        renderTable(list);
      }
    }

    // 1. Render Cards Grid
    function renderCards(list) {
      if (!cardsContainer) return;
      if (list.length === 0) {
        cardsContainer.innerHTML = '';
        return;
      }

      var html = list.map(function (b, index) {
        var delay = Math.min((index % 8) * 50, 400);

        var mediaHtml = '';
        if (b.media_type === 'image' && b.image_url) {
          mediaHtml = '<img class="br-img-photo" src="' + b.image_url + '" alt="' + (b.name || '') + '">';
        } else if (b.media_type === 'icon' && b.icon_html) {
          mediaHtml = '<div class="br-img-empty">' + b.icon_html + '</div>';
        } else if (defaultMediaType === 'image' && defaultImageUrl) {
          mediaHtml = '<img class="br-img-photo" src="' + defaultImageUrl + '" alt="' + (b.name || '') + '">';
        } else if (defaultIconHtml && defaultIconHtml.trim() !== '') {
          mediaHtml = '<div class="br-img-empty">' + defaultIconHtml + '</div>';
        } else {
          mediaHtml = '<div class="br-img-empty"><i class="bi bi-buildings"></i></div>';
        }

        return (
          '<article class="br-card br-reveal is-visible" style="--delay: ' + delay + 'ms;">' +
            '<span class="br-shine"></span>' +
            '<div class="br-img">' +
              mediaHtml +
              '<span class="br-img-fade"></span>' +
              (b.district ? '<span class="br-dist-badge">' + b.district + '</span>' : '') +
              (b.area ? '<span class="br-area-badge"><i class="bi bi-geo-alt-fill"></i> ' + b.area + '</span>' : '') +
            '</div>' +
            '<div class="br-body">' +
              '<h3 class="br-name">' + (b.name || '') + '</h3>' +
              (b.bn_name ? '<div class="br-bn-name">' + b.bn_name + '</div>' : '') +
              '<ul class="br-meta">' +
                (b.address ? '<li class="br-addr"><i class="bi bi-geo-alt-fill"></i><span>' + b.address + '</span></li>' : '') +
                (b.phone ? '<li class="br-phone"><i class="bi bi-telephone-fill"></i><a href="tel:' + b.phone + '">' + b.phone + '</a></li>' : '') +
                (b.email ? '<li class="br-mail"><i class="bi bi-envelope-fill"></i><span title="' + b.email + '">' + b.email + '</span></li>' : '') +
                (b.distance ? '<li class="text-primary fw-bold" style="color:#0d6efd;"><i class="bi bi-cursor-fill"></i><span>' + b.distance + ' km from you</span></li>' : '') +
              '</ul>' +
              '<div class="br-card-actions">' +
                (b.map_url ? '<a href="' + b.map_url + '" target="_blank" rel="noopener" class="br-btn"><span>Direction</span> <i class="bi bi-arrow-right"></i></a>' : '') +
                (b.phone ? '<a href="tel:' + b.phone + '" class="br-btn-call" title="Call Branch"><i class="bi bi-telephone"></i></a>' : '') +
              '</div>' +
            '</div>' +
          '</article>'
        );
      }).join('');

      cardsContainer.innerHTML = html;
    }

    // 2. Render Interactive Map & Sidebar
    function renderMap(list) {
      if (!mapSidebarList) return;

      if (!leafletMap) {
        initLeafletMap();
      }

      // Clear existing markers
      mapMarkers.forEach(function (m) {
        if (leafletMap) leafletMap.removeLayer(m);
      });
      mapMarkers = [];

      // Render Sidebar
      mapSidebarList.innerHTML = list.map(function (b) {
        return (
          '<div class="map-branch-item" data-id="' + b.id + '" data-lat="' + b.lat + '" data-lng="' + b.lng + '">' +
            '<div class="map-branch-title">' +
              '<span>' + (b.name || '') + ' Branch</span>' +
              (b.distance ? '<span class="map-branch-dist">' + b.distance + ' km</span>' : '') +
            '</div>' +
            '<div class="small fw-semibold mb-1" style="color:var(--br-g2);font-size:0.8rem;">' + (b.bn_name || '') + (b.district ? ' &bull; ' + b.district : '') + '</div>' +
            '<div class="map-branch-addr">' + (b.address || '') + '</div>' +
            '<div class="map-branch-footer">' +
              (b.phone ? '<a href="tel:' + b.phone + '" style="color:var(--br-g2);font-weight:700;text-decoration:none;"><i class="bi bi-telephone-fill me-1"></i>' + b.phone + '</a>' : '<span></span>') +
              (b.map_url ? '<a href="' + b.map_url + '" target="_blank" rel="noopener" style="color:#0d6efd;font-weight:700;text-decoration:none;">Direction &raquo;</a>' : '') +
            '</div>' +
          '</div>'
        );
      }).join('');

      // Attach click events to sidebar items
      mapSidebarList.querySelectorAll('.map-branch-item').forEach(function (item) {
        item.addEventListener('click', function () {
          var id = parseInt(this.getAttribute('data-id'), 10);
          var lat = parseFloat(this.getAttribute('data-lat'));
          var lng = parseFloat(this.getAttribute('data-lng'));

          mapSidebarList.querySelectorAll('.map-branch-item').forEach(function (el) {
            el.classList.remove('is-selected');
          });
          this.classList.add('is-selected');

          if (leafletMap) {
            leafletMap.flyTo([lat, lng], 14, { duration: 1.2 });
            var foundMarker = mapMarkers.find(function (m) { return m.branchId === id; });
            if (foundMarker) foundMarker.openPopup();
          }
        });
      });

      // Add Markers
      if (leafletMap && typeof L !== 'undefined') {
        var bounds = [];
        list.forEach(function (b) {
          if (!b.lat || !b.lng) return;

          var customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div class="custom-branch-marker" id="marker-' + b.id + '"><i class="bi bi-building"></i></div>',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -30]
          });

          var popupHtml = (
            '<div class="map-popup-card">' +
              '<h4>' + (b.name || '') + ' Branch</h4>' +
              '<div class="small fw-bold" style="color:var(--br-g2);">' + (b.bn_name || '') + (b.district ? ' (' + b.district + ')' : '') + '</div>' +
              '<p>' + (b.address || '') + '</p>' +
              '<div style="display:flex;justify-content:space-between;gap:6px;">' +
                (b.phone ? '<a href="tel:' + b.phone + '" class="btn-export" style="background:var(--bg-page);"><i class="bi bi-telephone-fill"></i> ' + b.phone + '</a>' : '') +
                (b.map_url ? '<a href="' + b.map_url + '" target="_blank" rel="noopener" class="btn-export" style="background:#0d6efd;color:#fff;"><i class="bi bi-geo-alt-fill"></i> Direction</a>' : '') +
              '</div>' +
            '</div>'
          );

          var marker = L.marker([b.lat, b.lng], { icon: customIcon }).addTo(leafletMap);
          marker.bindPopup(popupHtml);
          marker.branchId = b.id;

          marker.on('click', function () {
            mapSidebarList.querySelectorAll('.map-branch-item').forEach(function (el) {
              var isThis = parseInt(el.getAttribute('data-id'), 10) === b.id;
              el.classList.toggle('is-selected', isThis);
              if (isThis) {
                el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
              }
            });
          });

          mapMarkers.push(marker);
          bounds.push([b.lat, b.lng]);
        });

        if (bounds.length > 0) {
          leafletMap.fitBounds(bounds, { padding: [40, 40], maxZoom: 13 });
        }
      }
    }

    // Initialize Leaflet Map
    function initLeafletMap() {
      if (!mapDiv || typeof L === 'undefined') return;

      try {
        leafletMap = L.map(mapDiv, {
          zoomControl: true,
          scrollWheelZoom: true
        }).setView([22.75, 89.15], 10);

        var osmStandard = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; OpenStreetMap | Royal Technologies'
        });

        var esriSatellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
          maxZoom: 18,
          attribution: 'Tiles &copy; Esri | Royal Technologies'
        });

        var openTopo = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
          maxZoom: 17,
          attribution: 'Map data &copy; OpenTopoMap'
        });

        osmStandard.addTo(leafletMap);

        var baseMaps = {
          "Standard": osmStandard,
          "Satellite": esriSatellite,
          "Terrain": openTopo
        };

        L.control.layers(baseMaps).addTo(leafletMap);
      } catch (e) {
        console.warn('Branches Locator: Leaflet init error', e);
      }
    }

    // 3. Render District Directory
    function renderDirectory(list) {
      if (!directoryContainer) return;
      if (list.length === 0) {
        directoryContainer.innerHTML = '';
        return;
      }

      var grouped = {};
      list.forEach(function (b) {
        var dist = b.district || b.district_en || 'Other';
        if (!grouped[dist]) grouped[dist] = [];
        grouped[dist].push(b);
      });

      var html = Object.keys(grouped).map(function (distName, idx) {
        var branches = grouped[distName];
        var isOpen = idx === 0 || list.length < 15;

        return (
          '<div class="district-group-card ' + (isOpen ? 'is-open' : '') + '">' +
            '<div class="district-header">' +
              '<h4 class="district-title">' +
                '<i class="bi bi-geo-alt-fill text-success" style="color:var(--br-g2);"></i>' +
                '<span>' + distName + ' (' + (branches[0].district_en || distName) + ')</span>' +
                '<span class="district-badge-count">' + branches.length + ' Branches</span>' +
              '</h4>' +
              '<i class="bi bi-chevron-down district-collapse-icon"></i>' +
            '</div>' +
            '<div class="district-body" style="' + (isOpen ? '' : 'display:none;') + '">' +
              '<div class="dir-branch-row">' +
                branches.map(function (b) {
                  return (
                    '<div class="dir-branch-card">' +
                      '<div class="dir-branch-head">' +
                        '<h5>' + (b.name || '') + ' Branch</h5>' +
                        (b.upazila ? '<span class="dir-tag-upazila">' + b.upazila + '</span>' : '') +
                      '</div>' +
                      (b.bn_name ? '<div class="fw-semibold small mb-2" style="color:var(--br-g2);font-size:0.82rem;">' + b.bn_name + '</div>' : '') +
                      '<div class="dir-branch-meta">' +
                        (b.address ? '<div><i class="bi bi-geo-alt me-1" style="color:#e11d48;"></i> ' + b.address + '</div>' : '') +
                        (b.phone ? '<div><i class="bi bi-telephone me-1" style="color:var(--br-g2);"></i> <a href="tel:' + b.phone + '" style="text-decoration:none;color:inherit;font-weight:700;">' + b.phone + '</a></div>' : '') +
                        (b.email ? '<div><i class="bi bi-envelope me-1" style="color:#0d6efd;"></i> ' + b.email + '</div>' : '') +
                        (b.distance ? '<div style="color:#0d6efd;font-weight:700;"><i class="bi bi-cursor me-1"></i> ' + b.distance + ' km away</div>' : '') +
                      '</div>' +
                      '<div class="dir-branch-actions">' +
                        (b.map_url ? '<a href="' + b.map_url + '" target="_blank" rel="noopener" class="btn-export" style="background:#0d6efd;color:#fff;flex:1;justify-content:center;"><i class="bi bi-geo-alt-fill"></i> Direction</a>' : '') +
                        (b.phone ? '<a href="tel:' + b.phone + '" class="btn-export" style="background:rgba(21, 122, 62, 0.1);color:var(--br-g2);"><i class="bi bi-telephone-fill"></i></a>' : '') +
                      '</div>' +
                    '</div>'
                  );
                }).join('') +
              '</div>' +
            '</div>' +
          '</div>'
        );
      }).join('');

      directoryContainer.innerHTML = html;

      // Accordion toggle
      directoryContainer.querySelectorAll('.district-header').forEach(function (hdr) {
        hdr.addEventListener('click', function () {
          var card = this.parentElement;
          var body = card.querySelector('.district-body');
          var isOpen = card.classList.contains('is-open');
          card.classList.toggle('is-open', !isOpen);
          if (body) body.style.display = isOpen ? 'none' : 'block';
        });
      });
    }

    // 4. Render Table View
    function renderTable(list) {
      if (!tableBody) return;
      if (list.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-muted);">No branches match your filters.</td></tr>';
        return;
      }

      var html = list.map(function (b, idx) {
        var badgeClass =
          b.district_en === 'Satkhira' ? 'badge-satkhira' :
          b.district_en === 'Jashore' ? 'badge-jashore' :
          b.district_en === 'Khulna' ? 'badge-khulna' : 'badge-jhenaidah';

        return (
          '<tr>' +
            '<td style="font-weight:700;color:var(--text-muted);">' + (idx + 1) + '</td>' +
            '<td>' +
              '<div style="font-weight:700;">' + (b.name || '') + '</div>' +
              '<small style="color:var(--text-muted);">' + (b.bn_name || '') + '</small>' +
            '</td>' +
            '<td><span class="br-table-badge ' + badgeClass + '">' + (b.district || b.district_en || '') + '</span></td>' +
            '<td>' +
              '<span style="font-weight:600;">' + (b.upazila || '') + '</span>' +
              (b.area ? '<small style="display:block;color:var(--text-muted);">Area: ' + b.area + '</small>' : '') +
            '</td>' +
            '<td style="font-size:0.82rem;max-width:260px;">' + (b.address || '') + '</td>' +
            '<td>' +
              (b.phone ? '<a href="tel:' + b.phone + '" style="color:var(--br-g2);font-weight:700;text-decoration:none;"><i class="bi bi-telephone-fill me-1"></i> ' + b.phone + '</a>' : '-') +
            '</td>' +
            '<td style="white-space:nowrap;">' +
              (b.map_url ? '<a href="' + b.map_url + '" target="_blank" rel="noopener" class="btn-export" style="padding:4px 8px;" title="Direction"><i class="bi bi-geo-alt"></i></a> ' : '') +
              (b.phone ? '<a href="tel:' + b.phone + '" class="btn-export" style="padding:4px 8px;" title="Call"><i class="bi bi-telephone"></i></a>' : '') +
            '</td>' +
          '</tr>'
        );
      }).join('');

      tableBody.innerHTML = html;
    }

    // Export Table as CSV
    function exportToCSV() {
      var list = getFilteredBranches();
      if (!list || list.length === 0) {
        alert('No branch data available to export.');
        return;
      }

      var headers = ['ID', 'Branch Name', 'Bengali Name', 'District', 'Upazila', 'Area', 'Address', 'Phone', 'Email', 'Latitude', 'Longitude'];
      var rows = list.map(function (b) {
        return [
          b.id || '',
          '"' + (b.name || '').replace(/"/g, '""') + '"',
          '"' + (b.bn_name || '').replace(/"/g, '""') + '"',
          '"' + (b.district || b.district_en || '').replace(/"/g, '""') + '"',
          '"' + (b.upazila || '').replace(/"/g, '""') + '"',
          '"' + (b.area || '').replace(/"/g, '""') + '"',
          '"' + (b.address || '').replace(/"/g, '""') + '"',
          '"' + (b.phone || '').replace(/"/g, '""') + '"',
          '"' + (b.email || '').replace(/"/g, '""') + '"',
          b.lat || '',
          b.lng || ''
        ].join(',');
      });

      var csvContent = '\uFEFF' + headers.join(',') + '\n' + rows.join('\n');
      var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
      var url = URL.createObjectURL(blob);
      var link = document.createElement('a');
      link.setAttribute('href', url);
      link.setAttribute('download', 'royal_branches_directory.csv');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }

    // Event Listeners
    if (searchInput) {
      searchInput.addEventListener('input', function (e) {
        searchQuery = e.target.value;
        renderCurrentView();
      });
    }

    if (districtSelect) {
      districtSelect.addEventListener('change', function (e) {
        currentDistrict = e.target.value;
        renderCurrentView();
      });
    }

    areaChips.forEach(function (chip) {
      chip.addEventListener('click', function (e) {
        e.preventDefault();
        areaChips.forEach(function (c) { c.classList.remove('active'); });
        this.classList.add('active');
        currentArea = this.getAttribute('data-area') || 'all';
        renderCurrentView();
      });
    });

    if (resetBtn) {
      resetBtn.addEventListener('click', function () {
        if (searchInput) searchInput.value = '';
        if (districtSelect) districtSelect.value = 'all';
        areaChips.forEach(function (c) {
          c.classList.toggle('active', (c.getAttribute('data-area') || 'all') === 'all');
        });
        searchQuery = '';
        currentDistrict = 'all';
        currentArea = 'all';
        userLocation = null;
        if (gpsBtn) {
          gpsBtn.innerHTML = '<i class="bi bi-geo-alt-fill"></i> Near Me';
          gpsBtn.disabled = false;
        }
        renderCurrentView();
      });
    }

    if (gpsBtn) {
      gpsBtn.addEventListener('click', function () {
        if (!navigator.geolocation) {
          alert('Geolocation is not supported by your browser.');
          return;
        }

        gpsBtn.disabled = true;
        gpsBtn.innerHTML = '<span class="bi bi-arrow-repeat me-1"></span> Locating...';

        navigator.geolocation.getCurrentPosition(
          function (pos) {
            userLocation = {
              lat: pos.coords.latitude,
              lng: pos.coords.longitude
            };
            gpsBtn.disabled = false;
            gpsBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Sorted Near Me';
            renderCurrentView();
          },
          function (err) {
            gpsBtn.disabled = false;
            gpsBtn.innerHTML = '<i class="bi bi-geo-alt-fill"></i> Near Me';
            alert('Unable to retrieve location. Please check browser permissions.');
          },
          { timeout: 10000 }
        );
      });
    }

    if (themeBtn) {
      themeBtn.addEventListener('click', function () {
        var themes = ['default', 'sapphire', 'dark'];
        var idx = themes.indexOf(currentTheme);
        var nextTheme = themes[(idx + 1) % themes.length];
        currentTheme = nextTheme;
        wrap.setAttribute('data-theme', nextTheme);
      });
    }

    if (exportCsvBtn) {
      exportCsvBtn.addEventListener('click', exportToCSV);
    }

    if (printTableBtn) {
      printTableBtn.addEventListener('click', function () {
        window.print();
      });
    }

    wrap.querySelectorAll('.style-pill').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetStyle = this.getAttribute('data-style');
        switchStyle(targetStyle);
      });
    });

    // Start!
    loadDataAndRender();
  }

  // Auto-init on page load
  function initAll() {
    document.querySelectorAll('.royal-branches-locator-wrap').forEach(function (wrap) {
      initBranchesLocator(wrap);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll();
  }

  // Elementor Frontend Init Hook
  if (typeof jQuery !== 'undefined') {
    jQuery(window).on('elementor/frontend/init', function () {
      if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalbrancheslocator.default', function ($scope) {
          var wrap = $scope.find('.royal-branches-locator-wrap')[0];
          if (wrap) {
            initBranchesLocator(wrap);
          }
        });
      }
    });
  }
})();
