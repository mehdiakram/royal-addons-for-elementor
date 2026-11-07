/**
 * Royal Canvas Animations
 * Pure Canvas 2D - no external libraries
 * Animations: gradient, waves, snow, drops, rings, fancy-rotate
 */
(function () {
    'use strict';

    /* ================================================================
       HELPER: parse hex/rgb color → rgba string
    ================================================================ */
    function hexToRgba(hex, alpha) {
        alpha = alpha === undefined ? 1 : alpha;
        if (!hex) return 'rgba(99,102,241,' + alpha + ')';
        hex = hex.replace('#', '');
        if (hex.length === 3) hex = hex.split('').map(function (c) { return c + c; }).join('');
        var r = parseInt(hex.substring(0, 2), 16);
        var g = parseInt(hex.substring(2, 4), 16);
        var b = parseInt(hex.substring(4, 6), 16);
        return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
    }

    /* ================================================================
       ANIMATION MODULES
    ================================================================ */

    /* ------ GRADIENT ------------------------------------------------ */
    var Gradient = {
        init: function (canvas, cfg) {
            var ctx = canvas.getContext('2d');
            var colors = [cfg.gradColor1 || '#6366f1', cfg.gradColor2 || '#ec4899', cfg.gradColor3 || '#06b6d4'];
            var speed = (cfg.gradSpeed || 8) * 1000; // ms for one cycle
            var start = null;

            function lerp(a, b, t) { return a + (b - a) * t; }
            function lerpColor(c1, c2, t) {
                var p1 = parseHex(c1), p2 = parseHex(c2);
                return 'rgb(' +
                    Math.round(lerp(p1[0], p2[0], t)) + ',' +
                    Math.round(lerp(p1[1], p2[1], t)) + ',' +
                    Math.round(lerp(p1[2], p2[2], t)) + ')';
            }
            function parseHex(h) {
                h = h.replace('#', '');
                if (h.length === 3) h = h.split('').map(function (c) { return c + c; }).join('');
                return [parseInt(h.substring(0, 2), 16), parseInt(h.substring(2, 4), 16), parseInt(h.substring(4, 6), 16)];
            }

            function draw(ts) {
                if (!start) start = ts;
                var t = ((ts - start) % speed) / speed;
                var seg = t * colors.length;
                var idx = Math.floor(seg) % colors.length;
                var next = (idx + 1) % colors.length;
                var lt = seg - Math.floor(seg);

                var c1 = lerpColor(colors[idx], colors[next], lt);
                var c2 = lerpColor(colors[next], colors[(next + 1) % colors.length], lt);

                var grad = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
                grad.addColorStop(0, c1);
                grad.addColorStop(0.5, c2);
                grad.addColorStop(1, c1);

                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = grad;
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                canvas._rba_raf = requestAnimationFrame(draw);
            }

            canvas._rba_raf = requestAnimationFrame(draw);
        }
    };

    /* ------ WAVES --------------------------------------------------- */
    var Waves = {
        init: function (canvas, cfg) {
            var ctx = canvas.getContext('2d');
            var count   = Math.round(cfg.wavesCount || 3);
            var speed   = (cfg.wavesSpeed || 5) * 0.001;
            var height  = cfg.wavesHeight || 40;
            var color1  = cfg.wavesColor  || '#6366f1';
            var color2  = cfg.wavesColor2 || '#818cf8';
            var t = 0;

            function draw() {
                var W = canvas.width, H = canvas.height;
                ctx.clearRect(0, 0, W, H);

                for (var i = 0; i < count; i++) {
                    var progress = i / count;
                    var alpha    = 0.3 + progress * 0.4;
                    var col      = (i % 2 === 0) ? hexToRgba(color1, alpha) : hexToRgba(color2, alpha);
                    var phase    = (i + 1) * 0.7;
                    var yBase    = H * (0.45 + i * 0.08);

                    ctx.beginPath();
                    ctx.moveTo(0, H);

                    for (var x = 0; x <= W; x += 4) {
                        var y = yBase +
                            Math.sin(x * 0.008 * phase + t * speed * phase * 60) * height * (0.6 + progress * 0.4) +
                            Math.sin(x * 0.005 + t * speed * 40) * height * 0.3;
                        ctx.lineTo(x, y);
                    }

                    ctx.lineTo(W, H);
                    ctx.closePath();
                    ctx.fillStyle = col;
                    ctx.fill();
                }
                t++;
                canvas._rba_raf = requestAnimationFrame(draw);
            }

            canvas._rba_raf = requestAnimationFrame(draw);
        }
    };

    /* ------ SNOW / PARTICLES --------------------------------------- */
    var Snow = {
        init: function (canvas, cfg) {
            var ctx     = canvas.getContext('2d');
            var count   = Math.round(cfg.snowCount || 80);
            var speed   = cfg.snowSpeed || 2;
            var size    = cfg.snowSize  || 4;
            var wind    = cfg.snowWind  || 0.5;
            var color   = cfg.snowColor || '#ffffff';
            var flakes  = [];

            function reset(p, W, H) {
                p.x  = Math.random() * W;
                p.y  = Math.random() * -H;
                p.r  = Math.random() * size + 1;
                p.s  = Math.random() * speed + 0.5;
                p.sw = Math.random() * 2 - 1;
            }

            function build(W, H) {
                flakes = [];
                for (var i = 0; i < count; i++) {
                    var p = {};
                    reset(p, W, H);
                    p.y = Math.random() * H; // scattered start
                    flakes.push(p);
                }
            }

            build(canvas.width, canvas.height);

            function draw() {
                var W = canvas.width, H = canvas.height;
                ctx.clearRect(0, 0, W, H);
                ctx.fillStyle = color;

                flakes.forEach(function (p) {
                    p.y += p.s;
                    p.x += wind + p.sw * 0.3;
                    if (p.y > H + p.r) reset(p, W, H);
                    if (p.x > W + p.r) p.x = -p.r;
                    if (p.x < -p.r)    p.x = W + p.r;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fill();
                });

                canvas._rba_raf = requestAnimationFrame(draw);
            }

            canvas._rba_raf = requestAnimationFrame(draw);
        }
    };

    /* ------ RAIN DROPS --------------------------------------------- */
    var Drops = {
        init: function (canvas, cfg) {
            var ctx      = canvas.getContext('2d');
            var freqMs   = 1000 / (cfg.dropsSpeed || 5);
            var maxRings = Math.round(cfg.dropsMax || 15);
            var color    = cfg.dropsColor || '#6366f1';
            var ripples  = [];
            var last     = 0;

            function addRipple(W, H) {
                if (ripples.length >= maxRings) return;
                ripples.push({
                    x:     Math.random() * W,
                    y:     Math.random() * H,
                    r:     0,
                    maxR:  Math.random() * 80 + 40,
                    alpha: 0.8,
                    speed: Math.random() * 1.5 + 0.8
                });
            }

            function draw(ts) {
                var W = canvas.width, H = canvas.height;
                ctx.clearRect(0, 0, W, H);

                if (ts - last > freqMs) { addRipple(W, H); last = ts; }

                ripples = ripples.filter(function (rp) {
                    rp.r     += rp.speed;
                    rp.alpha -= 0.012;
                    if (rp.alpha <= 0) return false;

                    ctx.beginPath();
                    ctx.arc(rp.x, rp.y, rp.r, 0, Math.PI * 2);
                    ctx.strokeStyle = hexToRgba(color, rp.alpha);
                    ctx.lineWidth   = 1.5;
                    ctx.stroke();

                    // inner ring
                    if (rp.r > 10) {
                        ctx.beginPath();
                        ctx.arc(rp.x, rp.y, rp.r * 0.6, 0, Math.PI * 2);
                        ctx.strokeStyle = hexToRgba(color, rp.alpha * 0.4);
                        ctx.lineWidth   = 1;
                        ctx.stroke();
                    }
                    return true;
                });

                canvas._rba_raf = requestAnimationFrame(draw);
            }

            canvas._rba_raf = requestAnimationFrame(draw);
        }
    };

    /* ------ RINGS --------------------------------------------------- */
    var Rings = {
        init: function (canvas, cfg) {
            var ctx   = canvas.getContext('2d');
            var count = Math.round(cfg.ringsCount || 5);
            var spd   = cfg.ringsSpeed || 3;
            var color = cfg.ringsColor || '#6366f1';
            var rings = [];

            function build(W, H) {
                rings = [];
                var cx = W / 2, cy = H / 2;
                var maxR = Math.min(W, H) * 0.5;
                for (var i = 0; i < count; i++) {
                    rings.push({
                        x:    cx,
                        y:    cy,
                        r:    (i / count) * maxR,
                        maxR: maxR,
                        spd:  spd * (0.6 + i * 0.15)
                    });
                }
            }

            build(canvas.width, canvas.height);

            function draw() {
                var W = canvas.width, H = canvas.height;
                ctx.clearRect(0, 0, W, H);

                rings.forEach(function (rg) {
                    rg.r += rg.spd * 0.4;
                    if (rg.r >= rg.maxR) rg.r = 0;

                    var alpha = 1 - (rg.r / rg.maxR);
                    ctx.beginPath();
                    ctx.arc(rg.x, rg.y, rg.r, 0, Math.PI * 2);
                    ctx.strokeStyle = hexToRgba(color, alpha * 0.7);
                    ctx.lineWidth   = 2;
                    ctx.stroke();
                });

                canvas._rba_raf = requestAnimationFrame(draw);
            }

            canvas._rba_raf = requestAnimationFrame(draw);
        }
    };

    /* ------ FANCY ROTATE ------------------------------------------- */
    var FancyRotate = {
        init: function (canvas, cfg) {
            var ctx    = canvas.getContext('2d');
            var count  = Math.round(cfg.rotateCount || 8);
            var speed  = cfg.rotateSpeed || 3;
            var color1 = cfg.rotateColor  || '#6366f1';
            var color2 = cfg.rotateColor2 || '#ec4899';
            var shapes = [];

            function build(W, H) {
                shapes = [];
                var cx = W / 2, cy = H / 2;
                for (var i = 0; i < count; i++) {
                    var angle = (i / count) * Math.PI * 2;
                    var dist  = Math.min(W, H) * (0.15 + Math.random() * 0.25);
                    shapes.push({
                        angle:    angle,
                        dist:     dist,
                        cx:       cx,
                        cy:       cy,
                        size:     10 + Math.random() * 30,
                        sides:    Math.floor(Math.random() * 3) + 3, // 3,4,5
                        spd:      (speed * 0.02) * (Math.random() > 0.5 ? 1 : -1),
                        color:    (i % 2 === 0) ? color1 : color2,
                        alpha:    0.3 + Math.random() * 0.4,
                        selfRot:  0,
                        selfSpd:  (Math.random() - 0.5) * 0.04
                    });
                }
            }

            build(canvas.width, canvas.height);

            function drawPolygon(ctx, x, y, r, sides, rot) {
                ctx.beginPath();
                for (var i = 0; i <= sides; i++) {
                    var a  = rot + (i / sides) * Math.PI * 2;
                    var px = x + Math.cos(a) * r;
                    var py = y + Math.sin(a) * r;
                    if (i === 0) ctx.moveTo(px, py); else ctx.lineTo(px, py);
                }
                ctx.closePath();
            }

            function draw() {
                var W = canvas.width, H = canvas.height;
                ctx.clearRect(0, 0, W, H);

                shapes.forEach(function (sh) {
                    sh.angle   += sh.spd;
                    sh.selfRot += sh.selfSpd;

                    var x = sh.cx + Math.cos(sh.angle) * sh.dist;
                    var y = sh.cy + Math.sin(sh.angle) * sh.dist;

                    ctx.save();
                    drawPolygon(ctx, x, y, sh.size, sh.sides, sh.selfRot);
                    ctx.fillStyle   = hexToRgba(sh.color, sh.alpha * 0.4);
                    ctx.fill();
                    ctx.strokeStyle = hexToRgba(sh.color, sh.alpha);
                    ctx.lineWidth   = 1.5;
                    ctx.stroke();
                    ctx.restore();
                });

                canvas._rba_raf = requestAnimationFrame(draw);
            }

            canvas._rba_raf = requestAnimationFrame(draw);
        }
    };

    /* ================================================================
       DISPATCHER
    ================================================================ */
    var modules = {
        gradient:     Gradient,
        waves:        Waves,
        snow:         Snow,
        drops:        Drops,
        rings:        Rings,
        'fancy-rotate': FancyRotate
    };

    function isModile() {
        return window.innerWidth < 768;
    }

    function destroyCanvas(wrapper) {
        var existing = wrapper.querySelector('canvas.royal-canvas-anim');
        if (existing && existing._rba_raf) {
            cancelAnimationFrame(existing._rba_raf);
        }
        if (existing) existing.remove();
    }

    function initCanvas(wrapper) {
        var raw = wrapper.getAttribute('data-royal-canvas');
        if (!raw) return;

        var cfg;
        try { cfg = JSON.parse(raw); } catch (e) { return; }

        // Mobile disable
        if (cfg.disableMobile === 'yes' && isModile()) return;

        destroyCanvas(wrapper);

        var canvas   = document.createElement('canvas');
        canvas.className = 'royal-canvas-anim';

        // Sizing
        canvas.width  = wrapper.offsetWidth  || 800;
        canvas.height = wrapper.offsetHeight || 400;

        // Positioning
        canvas.style.cssText = [
            'position:absolute',
            'top:0',
            'left:0',
            'width:100%',
            'height:100%',
            'z-index:' + (cfg.zIndex || 0),
            'opacity:' + (cfg.opacity || 1),
            'pointer-events:none',
            'display:block'
        ].join(';');

        // Background color on canvas
        if (cfg.bgColor) {
            canvas.style.background = cfg.bgColor;
        }

        // Ensure wrapper has position
        var pos = window.getComputedStyle(wrapper).position;
        if (pos === 'static') wrapper.style.position = 'relative';

        // Insert before first child
        wrapper.insertBefore(canvas, wrapper.firstChild);

        // Handle resize
        var ro = new ResizeObserver(function () {
            canvas.width  = wrapper.offsetWidth  || 800;
            canvas.height = wrapper.offsetHeight || 400;
        });
        ro.observe(wrapper);
        canvas._rba_ro = ro;

        // Run animation
        var mod = modules[cfg.type] || modules.waves;
        mod.init(canvas, cfg);
    }

    function setupAll() {
        var wrappers = document.querySelectorAll('[data-royal-canvas]');
        if (!wrappers.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    initCanvas(entry.target);
                } else {
                    // Pause when off-screen
                    var c = entry.target.querySelector('canvas.royal-canvas-anim');
                    if (c && c._rba_raf) {
                        cancelAnimationFrame(c._rba_raf);
                        c._rba_raf = null;
                    }
                }
            });
        }, { threshold: 0 });

        wrappers.forEach(function (w) { observer.observe(w); });
    }

    /* ================================================================
       INIT
    ================================================================ */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupAll);
    } else {
        setupAll();
    }

    // Elementor editor live preview
    jQuery(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/global',
                function ($el) {
                    var w = $el.find('[data-royal-canvas]');
                    if (w.length) { initCanvas(w[0]); return; }
                    // Atomic Div Block: attribute is on the element itself
                    if ($el.attr('data-royal-canvas')) initCanvas($el[0]);
                }
            );
        }
    });

}());
