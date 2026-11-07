var RoyalFlipbookHandler = function ($scope, $) {
	'use strict';

	const $wrapper = $scope.find('.royal-flipbook-wrapper');
	if (!$wrapper.length) {
		return;
	}

	// --- DOM Elements ---
	const $viewport = $wrapper.find('.royal-flipbook-viewport');
	const $container = $wrapper.find('.royal-flipbook-container');
	const $loader = $wrapper.find('.royal-flipbook-loading');
	const $controls = $wrapper.find('.royal-flipbook-controls');

	// --- Widget Settings ---
	const pdfUrl = $wrapper.data('pdf-url');
	const config = {
		direction: $wrapper.data('direction'),
		displayMode: $wrapper.data('display-mode') || 'double',
		cornerEffect: $wrapper.data('corner-effect') === 'yes'
	};

	// --- State Variables ---
	let totalPages = 0;
	let initialFitScale = 1;
	let zoom = { scale: 1, x: 0, y: 0 };
	let isPanning = false;
	let panStart = { x: 0, y: 0 };
	
	if (!pdfUrl) {
		$loader.hide();
		return;
	}

	// Toggle corner effect class based on settings
	if (config.cornerEffect) {
		$wrapper.addClass('royal-flipbook-corner-fx-active');
	}

	pdfjsLib.GlobalWorkerOptions.workerSrc = `https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js`;

	/**
	 * Renders a single PDF page onto a canvas and returns it as a div.
	 */
	const renderPage = (pdf, pageNum) => {
		return pdf.getPage(pageNum).then(page => {
			const viewport = page.getViewport({ scale: 1.5 }); // High-res for better zoom
			const $pageDiv = $('<div />').css({
				width: viewport.width,
				height: viewport.height,
			});
			const canvas = document.createElement('canvas');
			canvas.height = viewport.height;
			canvas.width = viewport.width;

			const renderContext = {
				canvasContext: canvas.getContext('2d'),
				viewport: viewport
			};

			return page.render(renderContext).promise.then(() => {
				$pageDiv.css('background-image', 'url(' + canvas.toDataURL() + ')');
				return $pageDiv;
			});
		});
	};

	/**
	 * Applies the current zoom and pan state to the container.
	 */
	const updateZoom = () => {
		$controls.find('.royal-flipbook-zoom-level').text(Math.round(zoom.scale * 100) + '%');
		$container.css('transform', `translate(-50%, -50%) translate(${zoom.x}px, ${zoom.y}px) scale(${zoom.scale})`);
		$wrapper.toggleClass('is-zoomed', zoom.scale > initialFitScale);
	};

	/**
	 * Resets zoom and pan to the initial "fit-to-screen" state.
	 */
	const resetZoom = () => {
		zoom.scale = initialFitScale;
		zoom.x = 0;
		zoom.y = 0;
		updateZoom();
	};

	/**
	 * Initializes the turn.js library and calculates the initial fit.
	 */
	const initializeFlipbook = (firstPage) => {
		const pageMultiplier = (config.displayMode === 'double') ? 2 : 1;
		const bookWidth = firstPage.width() * pageMultiplier;
		const bookHeight = firstPage.height();
		const viewportWidth = $viewport.width();
		const viewportHeight = $viewport.height();

		$container.turn({
			width: bookWidth,
			height: bookHeight,
			direction: config.direction,
			display: config.displayMode,
			acceleration: true,
			duration: 800,
			elevation: 50,
			gradients: true,
			when: {
				turned: (event, page, view) => {
					updatePageNumberDisplay(view);
				}
			}
		});

		// Calculate the initial scale required to fit the book within the viewport.
		if (bookWidth > viewportWidth || bookHeight > viewportHeight) {
			const scaleX = viewportWidth / bookWidth;
			const scaleY = viewportHeight / bookHeight;
			initialFitScale = Math.min(scaleX, scaleY);
			zoom.scale = initialFitScale;
		}

		$loader.hide();
		$container.show();
		$controls.css('display', 'flex');

		updateZoom();
		updatePageNumberDisplay($container.turn('view'));
	};

	/**
	 * Updates the page number display in the toolbar.
	 */
	const updatePageNumberDisplay = (view) => {
		const from = view[0] || '';
		const to = view[1] || '';
		let displayText = (from && to) ? `${from}-${to}` : (from || to);
		$controls.find('.royal-flipbook-page-input').val(displayText);
		$controls.find('.royal-flipbook-page-total').text('of ' + totalPages);
	};

	/**
	 * Binds all user interaction events.
	 */
	const bindEvents = () => {
		// Toolbar Events
		$controls.find('.royal-flipbook-prev-btn').on('click', () => $container.turn('previous'));
		$controls.find('.royal-flipbook-next-btn').on('click', () => $container.turn('next'));
		$controls.find('.royal-flipbook-page-input').on('keypress', function (e) {
			if (e.which === 13) {
				$(this).blur();
				$container.turn('page', parseInt($(this).val(), 10));
			}
		});
		$controls.find('.royal-flipbook-zoom-in-btn').on('click', () => { zoom.scale = Math.min(3, zoom.scale + 0.25); updateZoom(); });
		$controls.find('.royal-flipbook-zoom-out-btn').on('click', () => { zoom.scale = Math.max(initialFitScale, zoom.scale - 0.25); updateZoom(); });
		$controls.find('.royal-flipbook-zoom-reset-btn').on('click', resetZoom);
		$controls.find('.royal-flipbook-fullscreen-btn').on('click', () => {
			if (!document.fullscreenElement) { $wrapper[0].requestFullscreen(); } else { document.exitFullscreen(); }
		});

		// Mousewheel Zooming (requires Ctrl key)
		$viewport.on('wheel', (e) => {
			if (!e.ctrlKey) return;
			e.preventDefault();
			const delta = e.originalEvent.deltaY > 0 ? -0.25 : 0.25;
			zoom.scale = Math.max(initialFitScale, Math.min(3, zoom.scale + delta));
			updateZoom();
		});

		// Panning/Dragging when zoomed in
		$viewport.on('mousedown', (e) => {
			if (zoom.scale > initialFitScale) {
				isPanning = true;
				panStart.x = e.clientX - zoom.x;
				panStart.y = e.clientY - zoom.y;
				$wrapper.addClass('is-panning');
			}
		});

		$(window).on('mouseup', () => {
			isPanning = false;
			$wrapper.removeClass('is-panning');
		}).on('mousemove', (e) => {
			if (!isPanning) return;
			zoom.x = e.clientX - panStart.x;
			zoom.y = e.clientY - panStart.y;
			updateZoom();
		}).on('resize', () => {
			if ($container.is(':visible')) {
				const pageMultiplier = (config.displayMode === 'double') ? 2 : 1;
				const singlePageWidth = $container.turn('size').width / pageMultiplier;
				const bookWidth = singlePageWidth * pageMultiplier;
				const bookHeight = $container.turn('size').height;
				const viewportWidth = $viewport.width();
				const viewportHeight = $viewport.height();

				$container.turn('size', bookWidth, bookHeight);

				if (bookWidth > viewportWidth || bookHeight > viewportHeight) {
					const scaleX = viewportWidth / bookWidth;
					const scaleY = viewportHeight / bookHeight;
					initialFitScale = Math.min(scaleX, scaleY);
				} else {
					initialFitScale = 1;
				}
				resetZoom();
			}
		});
	};

	/**
	 * Main execution flow.
	 */
	pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
		totalPages = pdf.numPages;
		const pagePromises = Array.from({ length: totalPages }, (_, i) => renderPage(pdf, i + 1));

		Promise.all(pagePromises).then(pages => {
			pages.forEach($page => $container.append($page));
			initializeFlipbook(pages[0]);
			bindEvents();
		});
	}).catch(err => {
		console.error("Royal Flipbook Error:", err);
		$loader.hide();
		$wrapper.append('<div class="elementor-alert elementor-alert-danger">Failed to load PDF.</div>');
	});
};

jQuery(window).on('elementor/frontend/init', function () {
	elementorFrontend.hooks.addAction('frontend/element_ready/royalflipbook.default', RoyalFlipbookHandler);
});