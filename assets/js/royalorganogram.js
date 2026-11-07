/**
 * Royal Addons for Elementor - Royal Organogram Script
 */
(function ($) {
    "use strict";

    var RoyalOrganogramHandler = function ($scope, $) {
        var $wrapper = $scope.find('.royal-organogram-wrapper');
        if (!$wrapper.length) {
            return;
        }

        // ==========================================
        // 1. Number Count-Up Animation
        // ==========================================
        function countUp(el) {
            if (el._hasCounted) return;
            el._hasCounted = true;

            var target = parseInt(el.getAttribute('data-target'), 10) || 0;
            var pad = parseInt(el.getAttribute('data-pad') || '0', 10);
            var duration = 1600;
            var start = null;

            function fmt(n) {
                var s = String(n);
                while (s.length < pad) s = '0' + s;
                return s;
            }

            function tick(ts) {
                if (!start) start = ts;
                var p = Math.min((ts - start) / duration, 1);
                var eased = 1 - Math.pow(1 - p, 3); // cubic ease out
                el.textContent = fmt(Math.round(target * eased));
                if (p < 1) {
                    requestAnimationFrame(tick);
                } else {
                    el.textContent = fmt(target);
                }
            }
            requestAnimationFrame(tick);
        }

        // ==========================================
        // 2. Scroll Reveal & Intersection Observer
        // ==========================================
        var revealItems = $wrapper[0].querySelectorAll('.og-reveal, .og-man');
        if ('IntersectionObserver' in window && revealItems.length > 0) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) {
                        e.target.classList.add('is-visible');
                        var nums = e.target.querySelectorAll('.og-num');
                        nums.forEach(countUp);
                        io.unobserve(e.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });

            revealItems.forEach(function (el) { io.observe(el); });
        } else {
            revealItems.forEach(function (el) {
                el.classList.add('is-visible');
                var nums = el.querySelectorAll('.og-num');
                nums.forEach(function (n) {
                    n.textContent = n.getAttribute('data-target') || '0';
                });
            });
        }

        // ==========================================
        // 3. Desktop Matrix: Interactive Column Focus
        // ==========================================
        var chart = $wrapper[0].querySelector('.og-chart');
        if (chart) {
            var stickyDept = null;

            function setFocus(key) {
                if (!key) {
                    chart.classList.remove('has-focus');
                    chart.querySelectorAll('.is-focus').forEach(function (c) {
                        c.classList.remove('is-focus');
                    });
                    return;
                }
                chart.classList.add('has-focus');
                chart.querySelectorAll('.og-cell[data-dept]').forEach(function (c) {
                    c.classList.toggle('is-focus', c.getAttribute('data-dept') === key);
                });
            }

            // Click header buttons for persistent highlight
            var headBtns = chart.querySelectorAll('.og-head');
            headBtns.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    var dept = btn.getAttribute('data-dept');
                    stickyDept = (stickyDept === dept) ? null : dept;
                    setFocus(stickyDept);
                });
            });

            // Hover preview on nodes
            var nodeCells = chart.querySelectorAll('.og-cell.is-node[data-dept]');
            nodeCells.forEach(function (cell) {
                cell.addEventListener('mouseenter', function () {
                    setFocus(cell.getAttribute('data-dept'));
                });
                cell.addEventListener('mouseleave', function () {
                    setFocus(stickyDept);
                });
            });
        }

        // ==========================================
        // 4. Mobile / Compact View: Department Tabs
        // ==========================================
        var tabs = $wrapper[0].querySelectorAll('.oc-tab');
        var panels = $wrapper[0].querySelectorAll('.oc-panel');

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                var targetKey = tab.getAttribute('data-target');

                tabs.forEach(function (t) {
                    var isSelected = (t === tab);
                    t.classList.toggle('is-active', isSelected);
                    t.setAttribute('aria-selected', isSelected ? 'true' : 'false');
                });

                panels.forEach(function (p) {
                    p.classList.toggle('is-active', p.getAttribute('data-key') === targetKey);
                });

                if (typeof tab.scrollIntoView === 'function') {
                    tab.scrollIntoView({ inline: 'center', block: 'nearest', behavior: 'smooth' });
                }
            });
        });

        // ==========================================
        // 5. Pipeline Style: Expandable Accordion
        // ==========================================
        var pipelineSummaries = $wrapper[0].querySelectorAll('.og-pipeline-summary');
        pipelineSummaries.forEach(function (summary) {
            summary.addEventListener('click', function () {
                var parentDept = summary.closest('.og-pipeline-dept');
                if (parentDept) {
                    parentDept.classList.toggle('is-open');
                }
            });
        });

        // ==========================================
        // 6. Minimalist Style: Department Filter
        // ==========================================
        var filterBtns = $wrapper[0].querySelectorAll('.og-dir-filter-btn');
        var dirCards = $wrapper[0].querySelectorAll('.og-dir-card');

        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var filterKey = btn.getAttribute('data-filter');

                filterBtns.forEach(function (b) {
                    b.classList.toggle('is-active', b === btn);
                });

                dirCards.forEach(function (card) {
                    if (filterKey === 'all' || card.getAttribute('data-dept') === filterKey) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // ==========================================
        // 7. Search Input Filter
        // ==========================================
        var searchInput = $wrapper[0].querySelector('.og-search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                var q = (searchInput.value || '').trim().toLowerCase();

                // Desktop Matrix nodes highlight
                if (chart) {
                    var nodes = chart.querySelectorAll('.og-cell.is-node');
                    nodes.forEach(function (cell) {
                        var text = (cell.textContent || '').toLowerCase();
                        if (q.length > 0 && text.indexOf(q) !== -1) {
                            cell.style.filter = 'drop-shadow(0 0 10px rgba(255, 213, 74, 0.9))';
                            cell.style.transform = 'scale(1.08)';
                            cell.style.zIndex = '10';
                        } else {
                            cell.style.filter = '';
                            cell.style.transform = '';
                            cell.style.zIndex = '';
                        }
                    });
                }

                // Compact mobile chain items filter
                var chainItems = $wrapper[0].querySelectorAll('.oc-item');
                chainItems.forEach(function (item) {
                    var text = (item.textContent || '').toLowerCase();
                    if (!q || text.indexOf(q) !== -1) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Bento cards filter
                var bentoRoles = $wrapper[0].querySelectorAll('.og-bento-role-item');
                bentoRoles.forEach(function (role) {
                    var text = (role.textContent || '').toLowerCase();
                    if (!q || text.indexOf(q) !== -1) {
                        role.style.display = 'flex';
                    } else {
                        role.style.display = 'none';
                    }
                });

                // Card Grid, Tree, Radial, Horizontal, Table, Neumorphic roles filter
                var extraRoleSelectors = '.og-cardgrid-role-item, .og-tree-role-node, .og-horiz-node, .og-radial-role, .og-neu-role-tile';
                var extraRoles = $wrapper[0].querySelectorAll(extraRoleSelectors);
                extraRoles.forEach(function (role) {
                    var text = (role.textContent || '').toLowerCase();
                    if (!q || text.indexOf(q) !== -1) {
                        role.style.display = '';
                        if (q.length > 0) {
                            role.style.outline = '2px solid #ffd54a';
                        } else {
                            role.style.outline = '';
                        }
                    } else {
                        role.style.display = 'none';
                    }
                });

                // Table roles highlight
                var tableRoleNodes = $wrapper[0].querySelectorAll('.og-table-role-node');
                tableRoleNodes.forEach(function (node) {
                    var text = (node.textContent || '').toLowerCase();
                    if (q.length > 0 && text.indexOf(q) !== -1) {
                        node.style.boxShadow = '0 0 10px rgba(255, 213, 74, 0.9)';
                        node.style.borderColor = '#ffd54a';
                    } else {
                        node.style.boxShadow = '';
                        node.style.borderColor = '';
                    }
                });
            });
        }

        // ==========================================
        // 8. Download / Print Trigger (1-Page Isolated Print)
        // ==========================================
        var printTriggers = $wrapper[0].querySelectorAll('.og-trigger-print');
        printTriggers.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                // Clone widget container to isolate from website theme
                var clone = $wrapper[0].cloneNode(true);

                // Remove toolbar, hint, and interactive controls from print
                var unwanted = clone.querySelectorAll('.og-toolbar, .og-hint, .og-search-wrap, .og-dl, .og-man, .oc-wrap, .og-dir-filters');
                unwanted.forEach(function (el) {
                    if (el.parentNode) {
                        el.parentNode.removeChild(el);
                    }
                });

                var clonedHtml = clone.outerHTML;

                // Create isolated hidden iframe
                var printFrame = document.createElement('iframe');
                printFrame.style.position = 'fixed';
                printFrame.style.top = '-9999px';
                printFrame.style.left = '-9999px';
                printFrame.style.width = '100vw';
                printFrame.style.height = '100vh';
                printFrame.style.border = '0';
                printFrame.style.opacity = '0';
                printFrame.style.pointerEvents = 'none';
                document.body.appendChild(printFrame);

                // Collect page CSS links and styles
                var cssAssets = '';
                document.querySelectorAll('link[rel="stylesheet"]').forEach(function (l) {
                    cssAssets += '<link rel="stylesheet" href="' + l.href + '">';
                });
                document.querySelectorAll('style').forEach(function (s) {
                    cssAssets += s.outerHTML;
                });

                // Single-Page dedicated print CSS
                var printCSS = '<style>' +
                    '@page {' +
                    '    size: A4 landscape;' +
                    '    margin: 4mm 4mm 4mm 4mm;' +
                    '}' +
                    '* {' +
                    '    box-sizing: border-box !important;' +
                    '    -webkit-print-color-adjust: exact !important;' +
                    '    print-color-adjust: exact !important;' +
                    '}' +
                    'html, body {' +
                    '    margin: 0 !important;' +
                    '    padding: 0 !important;' +
                    '    width: 100% !important;' +
                    '    height: 100% !important;' +
                    '    background: #ffffff !important;' +
                    '    overflow: hidden !important;' +
                    '    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;' +
                    '}' +
                    '.og-single-page-print {' +
                    '    width: 100% !important;' +
                    '    height: 100vh !important;' +
                    '    max-height: 100vh !important;' +
                    '    overflow: hidden !important;' +
                    '    display: flex !important;' +
                    '    flex-direction: column !important;' +
                    '    justify-content: flex-start !important;' +
                    '    align-items: center !important;' +
                    '    page-break-inside: avoid !important;' +
                    '    page-break-before: avoid !important;' +
                    '    page-break-after: avoid !important;' +
                    '    break-inside: avoid !important;' +
                    '}' +
                    '.royal-organogram-wrapper {' +
                    '    width: 100% !important;' +
                    '    max-width: 100% !important;' +
                    '    margin: 0 !important;' +
                    '    padding: 0 !important;' +
                    '    background: transparent !important;' +
                    '}' +
                    '.og-main, .og-container {' +
                    '    width: 100% !important;' +
                    '    max-width: 100% !important;' +
                    '    margin: 0 !important;' +
                    '    padding: 0 !important;' +
                    '}' +
                    '.og-chart-card {' +
                    '    display: block !important;' +
                    '    box-shadow: none !important;' +
                    '    border: none !important;' +
                    '    margin: 0 !important;' +
                    '    padding: 0 !important;' +
                    '    width: 100% !important;' +
                    '    overflow: visible !important;' +
                    '    background: transparent !important;' +
                    '}' +
                    '.og-chart {' +
                    '    width: 100% !important;' +
                    '    min-width: 100% !important;' +
                    '    gap: 7px !important;' +
                    '    zoom: 0.58;' +
                    '    transform-origin: top center;' +
                    '}' +
                    '@supports not (zoom: 1) {' +
                    '    .og-chart {' +
                    '        transform: scale(0.58);' +
                    '    }' +
                    '}' +
                    '.og-row {' +
                    '    column-gap: 6px !important;' +
                    '    row-gap: 0 !important;' +
                    '}' +
                    '.og-node {' +
                    '    min-height: 34px !important;' +
                    '    padding: 4px 6px !important;' +
                    '    font-size: 10px !important;' +
                    '    box-shadow: none !important;' +
                    '}' +
                    '.og-node b { font-size: 10px !important; }' +
                    '.og-node small { font-size: 8px !important; }' +
                    '.og-head {' +
                    '    padding: 6px 8px !important;' +
                    '    font-size: 11px !important;' +
                    '    box-shadow: none !important;' +
                    '}' +
                    '.og-grade {' +
                    '    min-width: 50px !important;' +
                    '    padding: 3px 5px !important;' +
                    '    font-size: 9px !important;' +
                    '}' +
                    '.og-cell.has-next::after { height: 7px !important; }' +
                    '.og-branch { height: 12px !important; }' +
                    '.og-node-top { padding: 6px 10px !important; font-size: 11.5px !important; }' +
                    '.og-style-bento, .og-style-tree, .og-style-pipeline, .og-style-minimal, ' +
                    '.og-style-cardgrid, .og-style-horizontal, .og-style-circular, .og-style-table, .og-style-neumorphic {' +
                    '    zoom: 0.62;' +
                    '    width: 100% !important;' +
                    '    overflow: visible !important;' +
                    '    page-break-inside: avoid !important;' +
                    '    break-inside: avoid !important;' +
                    '}' +
                    '</style>';

                var frameDoc = printFrame.contentWindow.document;
                frameDoc.open();
                frameDoc.write('<!DOCTYPE html><html><head><meta charset="utf-8"><title>Organizational Structure (Organogram)</title>' +
                    cssAssets +
                    printCSS +
                    '</head><body><div class="og-single-page-print">' +
                    clonedHtml +
                    '</div></body></html>');
                frameDoc.close();

                // Trigger print
                setTimeout(function () {
                    try {
                        printFrame.contentWindow.focus();
                        printFrame.contentWindow.print();
                    } catch (err) {
                        window.print();
                    }
                    setTimeout(function () {
                        if (printFrame.parentNode) {
                            printFrame.parentNode.removeChild(printFrame);
                        }
                    }, 2500);
                }, 400);
            });
        });
    };

    // Hook into Elementor Frontend
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/royalorganogram.default', RoyalOrganogramHandler);
    });

    // Fallback for non-elementor or standard page load
    $(document).ready(function () {
        $('.elementor-widget-royalorganogram').each(function () {
            RoyalOrganogramHandler($(this), $);
        });
    });

})(jQuery);
