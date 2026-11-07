/**
 * Royal Ads – Frontend JS
 * Handles: random, sequential (fade/slide), auto-change, dots, arrows, popup.
 */
(function ($) {
	'use strict';

	/* ─────────────────────────────────────────────
	   Core Ad Manager
	───────────────────────────────────────────── */
	function RoyalAd(cfg) {
		var self        = this;
		self.cfg        = cfg;
		self.uid        = cfg.uid;
		self.$wrapper   = $('#' + self.uid);
		self.$ads       = self.$wrapper.find('.royalad');
		self.$dots      = self.$wrapper.find('.royalads-dot');
		self.$prev      = self.$wrapper.find('.royalads-nav-prev');
		self.$next      = self.$wrapper.find('.royalads-nav-next');
		self.$overlay   = $('#' + self.uid + '_overlay');
		self.total      = self.$ads.length;
		self.current    = 0;
		self.timer      = null;

		if (self.total === 0) return;

		self.init();
	}

	RoyalAd.prototype.init = function () {
		var self = this;
		var cfg  = self.cfg;

		/* ── All at once ── */
		if (cfg.order === 'all') {
			self.$ads.show();
			return;
		}

		/* ── Random (pick one on load) ── */
		if (cfg.order === 'random') {
			var idx = Math.floor(Math.random() * self.total);
			self.showAd(idx, false);
			return;
		}

		/* ── Sequential ── */
		if (cfg.order === 'sequential') {
			// Init slide mode
			if (cfg.transition === 'slide') {
				self.$wrapper.find('.royaladscontainer').css({
					'display'   : 'flex',
					'transition': 'transform 0.5s ease',
				});
				self.$ads.css({ 'display': 'block', 'flex': '0 0 100%', 'min-width': '100%' });
			}

			// Pick starting index
			if (cfg.changeOn === 'load' || !cfg.auto) {
				// Just show a random starting ad on load
				var startIdx = Math.floor(Math.random() * self.total);
				self.showAd(startIdx, false);
			} else {
				self.showAd(0, false);
			}

			// Auto-change on interval
			if (cfg.auto && cfg.changeOn === 'timer') {
				self.timer = setInterval(function () {
					var next = (self.current + 1) % self.total;
					self.showAd(next, true);
				}, cfg.interval);
			}

			// Arrows
			if (cfg.showArrows) {
				self.$prev.on('click', function () {
					clearInterval(self.timer);
					var prev = (self.current - 1 + self.total) % self.total;
					self.showAd(prev, true);
				});
				self.$next.on('click', function () {
					clearInterval(self.timer);
					var next = (self.current + 1) % self.total;
					self.showAd(next, true);
				});
			}

			// Dots click
			if (cfg.showDots) {
				self.$dots.on('click', function () {
					var idx = parseInt($(this).data('index'), 10);
					clearInterval(self.timer);
					self.showAd(idx, true);
				});
			}
		}

		/* ── Popup ── */
		self.initPopup();
	};

	/* Show an ad by index */
	RoyalAd.prototype.showAd = function (idx, animate) {
		var self = this;
		var cfg  = self.cfg;

		if (cfg.transition === 'slide') {
			/* slide via transform */
			self.$wrapper.find('.royaladscontainer').css('transform', 'translateX(-' + (idx * 100) + '%)');
		} else if (cfg.transition === 'fade' && animate) {
			self.$ads.eq(self.current).fadeOut(400);
			self.$ads.eq(idx).fadeIn(400);
		} else {
			self.$ads.hide();
			self.$ads.eq(idx).show();
		}

		/* Update dots */
		self.$dots.removeClass('active').eq(idx).addClass('active');

		self.current = idx;
	};

	/* ─────────────────────────────────────────────
	   Popup
	───────────────────────────────────────────── */
	RoyalAd.prototype.initPopup = function () {
		var self    = this;
		var pcfg    = self.cfg.popup;

		if (!pcfg.enable || self.$overlay.length === 0) return;

		function openPopup() {
			self.$overlay.addClass('is-open');
			$('body').css('overflow', 'hidden');

			// Auto-close
			if (pcfg.autoClose > 0) {
				setTimeout(function () { self.closePopup(); }, pcfg.autoClose);
			}
		}

		// Trigger
		if (pcfg.trigger === 'load') {
			openPopup();
		} else if (pcfg.trigger === 'delay') {
			setTimeout(openPopup, pcfg.delay);
		} else if (pcfg.trigger === 'scroll') {
			var fired = false;
			$(window).on('scroll.royalads_' + self.uid, function () {
				if (fired) return;
				var scrollPct = ($(window).scrollTop() / ($(document).height() - $(window).height())) * 100;
				if (scrollPct >= pcfg.scrollPct) {
					fired = true;
					openPopup();
					$(window).off('scroll.royalads_' + self.uid);
				}
			});
		}

		// Close button
		self.$overlay.find('.royalads-close').on('click', function () {
			self.closePopup();
		});

		// Overlay click close
		if (pcfg.overlayClose) {
			self.$overlay.on('click', function (e) {
				if ($(e.target).is(self.$overlay)) {
					self.closePopup();
				}
			});
		}

		// ESC key
		$(document).on('keyup.royalads_' + self.uid, function (e) {
			if (e.key === 'Escape') { self.closePopup(); }
		});
	};

	RoyalAd.prototype.closePopup = function () {
		var self = this;
		self.$overlay.removeClass('is-open');
		$('body').css('overflow', '');
	};

	/* ─────────────────────────────────────────────
	   Boot – process queue
	───────────────────────────────────────────── */
	function boot() {
		if (!window.RoyalAdsQueue) return;
		$.each(window.RoyalAdsQueue, function (i, cfg) {
			new RoyalAd(cfg);
		});
		window.RoyalAdsQueue = [];
	}

	$(document).ready(boot);

	// Elementor editor live preview
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/royalads.default', function ($scope) {
			// Re-boot for this widget instance (queue already populated inline)
			boot();
		});
	});

})(jQuery);
