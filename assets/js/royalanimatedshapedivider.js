/**
 * Royal Animated Shape Divider v3.1
 * Universal Shape Animation Engine: Infinite Flow (RTL / LTR / Alternate),
 * Multi-layer 3D Parallax Drift, Wave Sway, Breathing Pulse, Scroll Reveal, Parallax.
 */
(function () {
    'use strict';

    /* ══ SEEDED RANDOM ══════════════════════════════════════════════ */
    function seededRand(s) {
        return function () {
            s |= 0; s = (s + 0x6D2B79F5) | 0;
            var t = Math.imul(s ^ s >>> 15, 1 | s);
            t = (t + Math.imul(t ^ t >>> 7, 61 | t)) ^ t;
            return ((t ^ t >>> 14) >>> 0) / 4294967296;
        };
    }

    /* ══ WAVE PATH BUILDER ══════════════════════════════════════════ */
    function buildWavePath(W, H, gran, seed, intens, rand, phase) {
        var rng = seededRand(seed), off = [], segW = W / gran, baseY = H;
        for (var k = 0; k <= gran; k++) off.push(rand ? (rng() - 0.5) * H * 0.6 : 0);
        var pts = [{ x: 0, y: baseY }];
        for (var i = 0; i <= gran; i++) {
            var x = i * segW;
            var wave = Math.sin((i / gran) * Math.PI * 2 + phase) * H * intens * 0.5;
            pts.push({ x: x, y: Math.max(0, Math.min(baseY, baseY - H * intens * 0.5 + wave + off[i])) });
        }
        pts.push({ x: W, y: baseY });
        var d = 'M 0,' + baseY.toFixed(2);
        for (var j = 1; j < pts.length - 1; j++) {
            var p0 = pts[j - 1], p1 = pts[j], p2 = pts[j + 1] || p1;
            var cx1 = (p0.x + p1.x) / 2, cx2 = (p1.x + p2.x) / 2;
            d += j === 1
                ? ' C ' + cx1.toFixed(2) + ',' + p0.y.toFixed(2) + ' ' + cx2.toFixed(2) + ',' + p1.y.toFixed(2) + ' ' + p1.x.toFixed(2) + ',' + p1.y.toFixed(2)
                : ' S ' + cx2.toFixed(2) + ',' + p1.y.toFixed(2) + ' ' + p1.x.toFixed(2) + ',' + p1.y.toFixed(2);
        }
        return d + ' L ' + W.toFixed(2) + ',' + baseY.toFixed(2) + ' Z';
    }

    /* ══ SVG GRADIENT FILL ══════════════════════════════════════════ */
    function buildFill(layer, idx, seed, svgEl) {
        var ns = 'http://www.w3.org/2000/svg';
        if (layer.fillType === 'gradient' || layer.fillType === 'radial') {
            var linear = layer.fillType === 'gradient';
            var id = 'rsd-' + (linear ? 'l' : 'r') + idx + '-' + seed;
            var defs = document.createElementNS(ns, 'defs');
            var grad = document.createElementNS(ns, linear ? 'linearGradient' : 'radialGradient');
            grad.setAttribute('id', id);
            if (linear) {
                var r = ((layer.gradientAngle || 180) * Math.PI) / 180;
                grad.setAttribute('x1', (0.5 - 0.5 * Math.cos(r)).toFixed(4));
                grad.setAttribute('y1', (0.5 - 0.5 * Math.sin(r)).toFixed(4));
                grad.setAttribute('x2', (0.5 + 0.5 * Math.cos(r)).toFixed(4));
                grad.setAttribute('y2', (0.5 + 0.5 * Math.sin(r)).toFixed(4));
                grad.setAttribute('gradientUnits', 'objectBoundingBox');
            } else {
                grad.setAttribute('cx', '50%'); grad.setAttribute('cy', '50%'); grad.setAttribute('r', '50%');
            }
            [layer.gradientStart || '#4f46e5', layer.gradientEnd || '#818cf8'].forEach(function (c, i) {
                var stop = document.createElementNS(ns, 'stop');
                stop.setAttribute('offset', i === 0 ? '0%' : '100%');
                stop.setAttribute('stop-color', c);
                grad.appendChild(stop);
            });
            defs.appendChild(grad);
            svgEl.insertBefore(defs, svgEl.firstChild);
            return 'url(#' + id + ')';
        }
        return layer.color || '#4f46e5';
    }

    /* ══ SCROLL REVEAL ═══════════════════════════════════════════════ */
    var EASE = {
        smooth:   'cubic-bezier(0.25,0.46,0.45,0.94)',
        ease_out: 'cubic-bezier(0.16,1,0.3,1)',
        spring:   'cubic-bezier(0.34,1.56,0.64,1)',
        elastic:  'cubic-bezier(0.68,-0.55,0.265,1.55)',
    };
    var REVEAL_INIT = {
        bottom: 'translateY(60px)', top: 'translateY(-60px)',
        left:   'translateX(-60px)', right: 'translateX(60px)',
        scale:  'scale(0.85) translateY(25px)', fade: 'scale(1)',
    };

    function setupScrollReveal(wrapper, cfg) {
        var ease  = EASE[cfg.revealEasing] || EASE.smooth;
        var dur   = (cfg.revealDuration || 800) + 'ms';
        var delay = (cfg.revealDelay || 0) + 'ms';
        var initT = REVEAL_INIT[cfg.revealDirection] || REVEAL_INIT.bottom;
        wrapper.style.opacity   = '0';
        wrapper.style.transform = initT;
        wrapper.style.transition = 'opacity ' + dur + ' ' + ease + ' ' + delay + ',transform ' + dur + ' ' + ease + ' ' + delay;
        if ('IntersectionObserver' in window) {
            var obs = new IntersectionObserver(function (entries) {
                if (entries[0].isIntersecting) {
                    wrapper.style.opacity   = '1';
                    wrapper.style.transform = 'translateY(0) translateX(0) scale(1)';
                    obs.unobserve(wrapper);
                }
            }, { threshold: 0.05 });
            obs.observe(wrapper);
        } else {
            wrapper.style.opacity = '1'; wrapper.style.transform = '';
        }
    }

    /* ══ CSS WAVE FLOW (BACKWARD COMPATIBILITY) ═══════════════════════ */
    function setupCSSWave(wrapper, cfg) {
        var inner = wrapper.querySelector('.rsd-wave-inner');
        if (!inner) return;
        inner.style.animationDuration = (cfg.animSpeed || 8) + 's';
        inner.classList.add('rsd-wave-flowing');
    }

    /* ══ PARALLAX ════════════════════════════════════════════════════ */
    function setupParallax(wrapper, cfg) {
        var speed = parseFloat(cfg.parallaxSpeed) || 0.3;
        var ticking = false;
        wrapper.style.setProperty('--rsd-parallax-shift', '0px');
        window.addEventListener('scroll', function () {
            if (!ticking) {
                requestAnimationFrame(function () {
                    var rect  = wrapper.getBoundingClientRect();
                    var vH    = window.innerHeight;
                    var prog  = Math.max(0, Math.min(1, (vH - rect.top) / (vH + rect.height)));
                    wrapper.style.setProperty('--rsd-parallax-shift', ((prog - 0.5) * speed * 80).toFixed(2) + 'px');
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

    /* ══ RESPONSIVE HEIGHT (ALL SHAPES) ═════════════════════════════ */
    function setupResponsiveHeight(wrapper, cfg) {
        function apply() {
            var w = window.innerWidth;
            var h = w <= 767 ? cfg.heightMobile : w <= 1024 ? cfg.heightTablet : cfg.height;
            wrapper.querySelectorAll('.rsd-static-container, .rsd-flow-container, .rsd-wave-inner, .rsd-flow-track, .rsd-layer-track, .rsd-custom-svg-container').forEach(function (el) {
                el.style.height = h + 'px';
            });
        }
        apply();
        var timer;
        window.addEventListener('resize', function () {
            clearTimeout(timer); timer = setTimeout(apply, 150);
        });
    }

    /* ══ DYNAMIC WAVE ENGINE ═════════════════════════════════════════ */
    function initDynamicWave(wrapper, cfg) {
        var cont = wrapper.querySelector('.rsd-layers-container');
        if (!cont) return;
        var rafId = null, speedMul = 1, curIntensity = cfg.intensity, layers = [];

        if (cfg.blur)       wrapper.classList.add('rsd-blur-enabled');
        if (cfg.glow)       { wrapper.classList.add('rsd-glow-enabled'); wrapper.style.setProperty('--rsd-glow-filter', 'drop-shadow(0 0 ' + cfg.glowBlur + 'px ' + cfg.glowColor + ')'); }
        if (cfg.hoverMorph)  wrapper.classList.add('rsd-hover-morph');

        if (!cfg.layers || !cfg.layers.length) {
            cfg.layers = [
                { fillType: 'solid',    color: '#4f46e5', opacity: 0.4, seedOffset: 0 },
                { fillType: 'solid',    color: '#6366f1', opacity: 0.7, seedOffset: 150 },
                { fillType: 'gradient', gradientStart: '#818cf8', gradientEnd: '#a5b4fc', gradientAngle: 180, opacity: 1, seedOffset: 300 },
            ];
        }

        function getH() {
            var w = window.innerWidth;
            return w <= 767 ? cfg.heightMobile : w <= 1024 ? cfg.heightTablet : cfg.height;
        }

        function build() {
            cont.innerHTML = ''; layers = [];
            var H = getH();
            var W = cont.offsetWidth || (cont.parentElement && cont.parentElement.offsetWidth) || window.innerWidth || 1200;
            cont.style.height = H + 'px';
            cont.style.setProperty('--rsd-parallax-shift', '0px');

            var flowDir = cfg.flowDirection || 'rtl';

            cfg.layers.forEach(function (layer, idx) {
                var lSeed = cfg.seed + (layer.seedOffset !== undefined ? layer.seedOffset : idx * 337);
                var d     = buildWavePath(W, H, cfg.granularity, lSeed, cfg.intensity, cfg.randomness, idx * (Math.PI / 3));
                var div   = document.createElement('div');
                div.className = 'rsd-single-layer rsd-wave-layer';
                div.style.opacity = layer.opacity !== undefined ? layer.opacity : 1;

                var ns  = 'http://www.w3.org/2000/svg';
                var svg = document.createElementNS(ns, 'svg');
                svg.setAttribute('width', '100%'); svg.setAttribute('height', H);
                svg.setAttribute('viewBox', '0 0 ' + W + ' ' + H);
                svg.setAttribute('preserveAspectRatio', 'none');

                var fill = buildFill(layer, idx, cfg.seed, svg);
                if (cfg.glow) svg.style.filter = 'drop-shadow(0 0 ' + cfg.glowBlur + 'px ' + cfg.glowColor + ')';
                if (cfg.blur) svg.style.filter = (svg.style.filter ? svg.style.filter + ' ' : '') + 'blur(4px)';

                var path = document.createElementNS(ns, 'path');
                path.setAttribute('d', d); path.setAttribute('fill', fill);
                svg.appendChild(path); div.appendChild(svg); cont.appendChild(div);

                layers.push({
                    svg: svg,
                    path: path,
                    seed: lSeed,
                    speed: cfg.animSpeed * (1 + idx * 0.35),
                    dir: (flowDir === 'ltr') ? (idx % 2 === 0 ? -1 : 1) : (idx % 2 === 0 ? 1 : -1),
                });
            });
        }

        function start() {
            stop();
            if (!cfg.animEnabled || cfg.animStyle === 'none') return;
            var startT = performance.now();
            function loop(time) {
                var elapsed = (time - startT) / 1000;
                var H = getH();
                var W = cont.offsetWidth || window.innerWidth || 1200;
                layers.forEach(function (l) {
                    var phase = (elapsed / (l.speed / speedMul)) * Math.PI * 2 * l.dir;
                    var d     = buildWavePath(W, H, cfg.granularity, l.seed, curIntensity, cfg.randomness, phase);
                    l.path.setAttribute('d', d);
                });
                rafId = requestAnimationFrame(loop);
            }
            rafId = requestAnimationFrame(loop);
        }

        function stop() { if (rafId) { cancelAnimationFrame(rafId); rafId = null; } }

        build();
        start();

        if (cfg.hoverMorph) {
            wrapper.addEventListener('mouseenter', function () { speedMul = 2.5; });
            wrapper.addEventListener('mouseleave', function () { speedMul = 1.0; });
        }

        if (cfg.scrollTrigger) {
            window.addEventListener('scroll', function () {
                var rect = wrapper.getBoundingClientRect(), vH = window.innerHeight;
                var prog = Math.max(0, Math.min(1, (vH - rect.top) / (vH + rect.height)));
                curIntensity = Math.max(0.1, cfg.intensity * (0.5 + 0.5 * Math.sin(prog * Math.PI)));
            }, { passive: true });
        }

        var ro = ('ResizeObserver' in window) ? new ResizeObserver(function () {
            stop(); build(); start();
        }) : null;
        if (ro) {
            ro.observe(cont);
        } else {
            var rt;
            window.addEventListener('resize', function () {
                clearTimeout(rt); rt = setTimeout(function () { stop(); build(); start(); }, 200);
            });
        }
    }

    /* ══ MAIN INIT ═══════════════════════════════════════════════════ */
    function init(wrapper) {
        if (wrapper.dataset.rsdInitialized) return;
        wrapper.dataset.rsdInitialized = 'true';

        var isDynamic = !wrapper.dataset.rsdShapeType || wrapper.dataset.rsdShapeType === 'dynamic_wave';

        var cfg = {
            shapeType:       wrapper.dataset.rsdShapeType        || 'dynamic_wave',
            height:          parseInt(wrapper.dataset.rsdHeight, 10)          || 120,
            heightTablet:    parseInt(wrapper.dataset.rsdHeightTablet, 10)    || 80,
            heightMobile:    parseInt(wrapper.dataset.rsdHeightMobile, 10)    || 60,
            animEnabled:     wrapper.dataset.rsdAnimEnabled      !== 'no',
            animStyle:       wrapper.dataset.rsdAnimStyle        || 'flow',
            flowDirection:   wrapper.dataset.rsdFlowDirection    || 'rtl',
            animType:        wrapper.dataset.rsdAnimType         || 'float',
            animSpeed:       parseFloat(wrapper.dataset.rsdAnimSpeed)         || 10,
            scrollReveal:    wrapper.dataset.rsdScrollReveal      === 'yes',
            revealDirection: wrapper.dataset.rsdRevealDirection    || 'bottom',
            revealDuration:  parseInt(wrapper.dataset.rsdRevealDuration, 10)  || 800,
            revealDelay:     parseInt(wrapper.dataset.rsdRevealDelay, 10)     || 0,
            revealEasing:    wrapper.dataset.rsdRevealEasing       || 'smooth',
            parallax:        wrapper.dataset.rsdParallax           === 'yes',
            parallaxSpeed:   parseFloat(wrapper.dataset.rsdParallaxSpeed)     || 0.3,
            blur:            wrapper.dataset.rsdBlur               === 'yes',
            glow:            wrapper.dataset.rsdGlow               === 'yes',
            glowColor:       wrapper.dataset.rsdGlowColor          || 'rgba(0,0,0,0.3)',
            glowBlur:        parseInt(wrapper.dataset.rsdGlowBlur, 10)        || 8,
            /* dynamic wave */
            granularity:     parseInt(wrapper.dataset.rsdGranularity, 10)     || 8,
            intensity:       parseFloat(wrapper.dataset.rsdIntensity)         || 0.6,
            randomness:      wrapper.dataset.rsdRandomness         === 'yes',
            seed:            parseInt(wrapper.dataset.rsdSeed, 10)            || 1234,
            hoverMorph:      wrapper.dataset.rsdHoverMorph         === 'yes',
            scrollTrigger:   wrapper.dataset.rsdScrollTrigger      === 'yes',
            layers:          [],
        };

        try { cfg.layers = JSON.parse(wrapper.dataset.rsdLayers || '[]'); } catch (e) {}

        /* Position class */
        var pos = wrapper.dataset.rsdPosition || 'bottom';
        wrapper.classList.add('rsd-divider-' + pos);

        /* Full Width Viewport Alignment */
        if (wrapper.dataset.rsdFullWidth === 'yes' || wrapper.classList.contains('rsd-full-width')) {
            function alignFullWidth() {
                var p = wrapper.parentElement;
                if (!p) return;
                var rect = p.getBoundingClientRect();
                var clientW = document.documentElement.clientWidth;
                wrapper.style.width = clientW + 'px';
                wrapper.style.marginLeft = (-rect.left) + 'px';
            }
            alignFullWidth();
            window.addEventListener('resize', alignFullWidth, { passive: true });
        }

        /* Snap to Section Edge (Pin Flush) */
        if (wrapper.dataset.rsdPin === 'yes' || wrapper.classList.contains('rsd-pin-edge') || wrapper.classList.contains('rsd-is-vertical')) {
            var sec = wrapper.closest('.elementor-section, .e-con, .elementor-container, [data-elementor-type]');
            if (sec) {
                sec.style.position = 'relative';
                sec.style.overflow = 'hidden';
            }
        }

        /* Vertical Divider Dynamic Height */
        if (wrapper.classList.contains('rsd-is-vertical')) {
            function syncVerticalHeight() {
                var sec = wrapper.closest('.elementor-section, .e-con, .elementor-container') || wrapper.parentElement;
                if (sec) {
                    var secH = sec.offsetHeight;
                    var flow = wrapper.querySelector('.rsd-flow-container, .rsd-static-container');
                    if (flow) {
                        flow.style.width = secH + 'px';
                    }
                }
            }
            syncVerticalHeight();
            window.addEventListener('resize', syncVerticalHeight, { passive: true });
        }

        /* Scroll Reveal */
        if (cfg.scrollReveal) setupScrollReveal(wrapper, cfg);

        /* Legacy CSS Wave Flow (backward compatibility) */
        if (!isDynamic && cfg.animType === 'css_wave') setupCSSWave(wrapper, cfg);

        /* Parallax */
        if (cfg.parallax) setupParallax(wrapper, cfg);

        /* Responsive Height */
        setupResponsiveHeight(wrapper, cfg);

        /* Dynamic wave */
        if (isDynamic) {
            initDynamicWave(wrapper, cfg);
        }
    }

    /* ══ ELEMENTOR INTEGRATION ═══════════════════════════════════════ */
    function initAll() {
        document.querySelectorAll('.royal-section-divider-wrap:not([data-rsd-initialized])').forEach(init);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }

    function attachElementorHook() {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/royalanimatedshapedivider.default',
                function ($scope) {
                    var $wraps = $scope.find('.royal-section-divider-wrap');
                    if ($wraps.length) {
                        $wraps.each(function () {
                            this.removeAttribute('data-rsd-initialized');
                            init(this);
                        });
                    }
                }
            );
            return true;
        }
        return false;
    }

    if (!attachElementorHook() && typeof jQuery !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', attachElementorHook);
    }

})();