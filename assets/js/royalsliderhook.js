!(function (e, n) {
    "use strict";
    var o = function (e, n) {
            var o = e.find(".royaltech-prime-slider").find(".royaltech-scroll-down"),
                t = o.data("selector"),
                r = o.data("settings");
            o.length &&
                n(o).on("click", function (e) {
                    e.preventDefault(), royaltechUIkit.scroll(o, r).scrollTo(n(t));
                });
        },
        t = function (e, n) {
            var o = e.data("id"),
                t = e.find("[data-reveal-enable]").data("reveal-enable");
            if (void 0 === t || "yes" !== t) return;
            const r = n(".reveal-active-" + o).find('[data-reveal="reveal-active"]');
            n(r).css({ opacity: "1" });
            const d = e.find("[data-reveal-settings]").data("reveal-settings");
            let l = 0;
            n(r).each(function (e, n) {
                l += 80;
                const o = new RevealFx(n, {
                    revealSettings: {
                        bgColors: [d.bgColors],
                        direction: String(d.direction),
                        duration: Number(d.duration + l),
                        easing: String(d.easing),
                        onHalfway: function (e, n) {
                            e.style.opacity = 1;
                        },
                    },
                });
                new Waypoint({
                    element: n,
                    handler: function () {
                        o.reveal(), this.destroy();
                    },
                    offset: "bottom-in-view",
                });
            }),
                setTimeout(() => {
                    const e = n(".reveal-active-" + o);
                    var t = n(e).find(".reveal-muted");
                    n(t).each(function (e, o) {
                        n(o).addClass("reveal-loaded"), n(o).removeClass("reveal-muted");
                    });
                }, 1.3 * (d.duration + l));
        };
    jQuery(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/royalslidergeneral.default", t),
		elementorFrontend.hooks.addAction("frontend/element_ready/prime-slider-general.slide", t),
		
		elementorFrontend.hooks.addAction("frontend/element_ready/prime-slider-fluent.default", o),
		elementorFrontend.hooks.addAction("frontend/element_ready/prime-slider-astoria.default", o);
    });
})(jQuery, window.elementorFrontend);
