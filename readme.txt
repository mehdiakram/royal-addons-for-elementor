=== Royal Addons for Elementor ===
Contributors: royaltechbd
Donate link: https://www.royaltechbd.com/
Tags: elementor, addons, widgets, elementor page builder, royal addons
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 26.11.14
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Royal Addons for Elementor is a powerful plugin that provides 137+ free & premium widgets and 26 extensions for Elementor Page Builder.

== Description ==

**Royal Addons for Elementor** is the ultimate toolkit for Elementor Page Builder. It comes packed with **137+ highly customizable widgets** and **26 advanced extensions** to help you build stunning websites without writing a single line of code.

With a focus on performance, modern design aesthetics, and ease of use, Royal Addons empowers both beginners and professional developers to create pixel-perfect Elementor sites.

### 🔥 Key Features
*   **137+ Powerful Widgets:** Everything from advanced typography to interactive data elements.
*   **26 Advanced Extensions:** Sticky Header, Wrapper Link, Magic Scroll, Hover Animator, Custom CSS, and more.
*   **Performance Optimized:** Modular architecture ensures that only the CSS and JS for the widgets you use are loaded on the page.
*   **Elementor 4 Atomic Support:** Fully compatible with Elementor's latest atomic widget architecture.
*   **Built-in Custom Fonts:** Upload and manage your custom WOFF/WOFF2/TTF fonts directly from the dashboard.
*   **Developer Friendly:** Extensively documented code, hooks, and clean architecture.

### 🌟 Popular Widgets
*   **Animated Text & Headings:** Grab your visitors' attention with engaging text animations.
*   **Advanced Sliders & Carousels:** Create beautiful sliders without needing a separate plugin.
*   **Interactive Tabs & Accordions:** Organize your content beautifully.
*   **Timeline:** Showcase your company history or project roadmap.
*   **Data Visualization:** Pie charts, progress bars, and dynamic counters.
*   **Zakat Calculator:** A specialized Islamic finance widget with dynamic currency support.

### 🔌 Powerful Extensions
*   **Royal Background Canvas:** Add animated backgrounds like gradients, waves, and snow.
*   **Sticky Header:** Advanced sticky effects for Elementor sections.
*   **Custom CSS:** Add custom CSS directly to any Elementor widget or container.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/royal-addons-for-elementor` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Make sure you have the Elementor Page Builder plugin installed and activated.
4. Use the Royal Addons widgets directly from the Elementor editor panel.

== Frequently Asked Questions ==

= Does this plugin work with the free version of Elementor? =

Yes! Royal Addons for Elementor is fully compatible with both the free and Pro versions of Elementor.

= Will this slow down my website? =

No. Royal Addons is built with performance in mind. It uses a modular architecture, meaning it only loads the assets (CSS/JS) for the specific widgets you are using on a page.

= Where can I find the documentation? =

Please check the `docs` folder inside the plugin directory for the complete user manual and documentation.

== Screenshots ==

1. Royal Addons Dashboard - Manage all widgets and extensions easily.
2. Elementor Editor - 137+ widgets available in the editor panel.
3. Custom Fonts Manager - Upload and manage local fonts.

== Changelog ==

= 26.11.14 =
* Fix: Prevented Royal Popup widget FOUC (Flash of Unstyled Content) where popup content briefly loaded or flashed at the bottom of the page before external stylesheets finished loading.

= 26.11.13 =
* Feature: Royal Popup Widget (RoyalPopup) Major Modernization & Page-Level Display Targeting:
  - Page-Level Display Conditions: Added "This Page Only", "Specific Pages" (Select2 multi-selector), and "All Single Posts" display conditions alongside Entire Site, Home Page, and All Pages.
  - Advanced Display Triggers: Added configurable "Open Delay (sec)" for Page Load trigger, "After Page Scroll" (Scroll depth percentage slider 5% - 95%), and "After Inactivity" (user idle detection 3s - 120s).
  - Smart Cookie & Session Rules: Added toggle to disable cookies for live testing and instant reload, "Until Browser Closed (Session)" time unit, and "Cookie Per Page Only" option to prevent cross-page suppression.
  - Interactive Close Actions: Added custom close triggers (.royal-popup-close-btn & [data-royal-popup-close]) for inner template buttons, plus switches for "Close on Overlay Click" and "Close on ESC Key".
  - Responsive & Editor Experience: Added "Hide on Mobile (< 768px)" responsive toggle and "Preview in Editor" mode for seamless canvas styling without popup interference.

= 26.11.12 =
* Feature: WordPress Automatic Updates option support in plugins dashboard (enable/disable auto-updates toggle).
* Enhancement: Moved updater initialization to `init` hook to ensure compatibility with WordPress background WP-Cron auto-updates.
* Performance: Optimized updater initialization and lightweight fallback state injection.

= 26.11.11 =
* Enhancement: GitHub Release & Cloud Distribution automation, asset delivery optimizations, and stability improvements.

= 26.11.10 =
* Feature: Royal Scroll To Top Widget Complete Modernization (RoyalScrollToTop):
  - 4 Modern Button Types: Added support for Icon Only, Text Only, Icon & Text (with flexible icon layouts: Left, Right, Above, Below), and Scroll Progress Ring (Smart Circular Progress Indicator).
  - Real-Time Circular Scroll Progress Ring: SVG circular progress ring that dynamically fills (0% to 100%) as visitor scrolls down the page, with customizable stroke width, fill color, background track color, and progress glow.
  - Live Scroll Percentage Display: Real-time percentage indicator (0% - 100%) displayed inside the button with typography controls.
  - Smart Direction Visibility: Automatically hides the button during downward reading scroll to keep screen clear, and smoothly reveals when scrolling up.
  - Smart Animations Engine:
    * Entrance & Exit: Smart Slide Up (Elastic Bounce), Smooth Fade In, Spring Zoom In, 3D Flip In, Rotate Zoom In, and Bouncy Pop In.
    * Idle / Attention: Gentle Floating, Heartbeat Pulse, Neon Glow Pulse, and Radar / Water Ripple Wave.
    * Hover Micro-Interactions: Icon Fly Up & Return, Scale & Elevate, 360° Icon Spin, Micro Bounce, and Aura Glow.
    * Interactive Click Animations: Rocket Launch Blast (button shoots up to the sky with smooth scroll), Material Water Ripple, and Tactile Click Depress.
  - Design & Styling: Glassmorphism (Frosted glass blur backdrop), multi-layer elevation and hover glow box shadows, Classic and Gradient background types, customizable Tooltip with typography and shadow, and responsive Offset X and Offset Y controls (px, %, vw, vh).
  - Performance & Compatibility: Replaced hardcoded IDs with modular class-based architecture, added responsive smooth scroll speed (200ms - 2000ms), 60fps requestAnimationFrame scroll monitoring, and full backward compatibility.

= 26.11.09 =
* Feature: Royal Store Locator Widget — Modern Store & Showroom Locator powered by Leaflet and OpenStreetMap (100% zero API key required, free & unlimited).
* Feature: Dual Data Source — Support for Preset JSON (with 30 sample stores) or Custom Repeater items with coordinates, addresses, contacts, badges, amenities, and schedules.
* Feature: Sample JSON Export — Added 1-click "Download Sample JSON" button directly in the Elementor editor for instant demo data export.
* Feature: GPS "Near Me" Geolocation — Real-time user position lookup with radius slider filtering (5 to 100 km) and automatic map zoom/bounds fitting.
* Feature: Interactive Filters — Live search, Division/Category dropdown & pill tabs, amenities filter popup (Air Conditioned, Parking, Card Payment, Official Warranty, etc.), and sort order.
* Feature: Live "Open Now Only" Filter — Real-time open/closed status calculation with auto-refresh and map auto-fit bounds on filter change.
* Feature: Structured Opening Hours — 30-minute interval time selectors for opening & closing times, working days, and off-day selector for error-free scheduling.
* Feature: Custom Map Pin Markers — Support for custom pin icons (Elementor Icon library), SVG pins, custom pin colors, or image icons per store.
* Feature: Turn-by-Turn Navigation & Actions — 1-click directions via Google Maps, Apple Maps, or Waze; 1-click "Copy Address" and "Share Location" buttons.
* Feature: Custom Button Labels — Added customizable text controls for "View Map" and "Directions" action buttons in Elementor.
* Feature: Store Thumbnail Image Toggle — Option to show/hide store card images with responsive height slider in Style tab.
* Feature: Royal Branches Locator Widget — Modern Branch Network & GIS Explorer with 4 layout styles (Cards Grid, Interactive Map, District Directory, Data Table), live search, area pills, GPS Near Me, and CSV export.
* Improvement: Sidebar Collapse Toggle — Redesigned into sleek, modern Google Maps-style 26px round floating white button with delicate shadow and Feather chevron icon.
* Improvement: Card Action Buttons — Optimized font size, padding, and gaps; added white-space protection and SVG flex-shrink prevention so buttons never wrap or distort.
* Fix: Section Ordering & Wrapper Link [Royal] — Renamed layout section to ensure Wrapper Link extension renders at the very bottom of the Content tab.
* Fix: Fixed PHP 8.3 / Elementor warnings in Royal Divider widget script dependency and radius settings.

= 26.11.08 =
* Feature: Filterable Post Widget — Post Count in Filter: Added option to display post count in filter tabs (Parentheses `(12)` or Pill Badge `12`) with full styling controls for normal and active states.
* Feature: Filterable Post Widget — Portfolio Action Buttons Control: Added settings to display Live Preview button only, View Details button only, Both, or None, with individual target options (`_blank` / `_self`).
* Fix: Filterable Post Widget — Card Hover Clipping: Fixed top border and header clipping when cards translate upwards on hover by ensuring grid containers and column wrappers maintain visible overflow with top headroom buffer.
* Fix: Filterable Post Widget — Extra Border Removal: Fixed unwanted outer blue border showing around grid column items (`.royalisotopeitem`) by isolating border, radius, and box shadow selectors to inner card containers.
* Fix: Filterable Post Widget — Portfolio Bottom Typography: Removed default solid blue background color box from titles; enhanced typography with crisp white text, subtle text shadow, and seamless dark glass gradient backdrop.
* Improvement: Filterable Post Widget — Mobile Height & Layout: Increased mobile height default from 280px to 380px with responsive slider controls and mobile CSS enhancements, ensuring preview showcases look spacious, tall, and elegant on mobile devices.

= 26.11.07 =
* Feature: Animated Shape Divider — Full Width Breakout: Added "Full Width (Breakout)" switch (Default: Yes) allowing dividers to stretch 100vw edge-to-edge across the screen even inside boxed Elementor containers and columns with zero horizontal scrollbars.
* Feature: Animated Shape Divider — Snap to Section Edge: Added "Snap to Section Edge" switch to pin dividers flush against section top/bottom borders with zero margin or gap.
* Feature: Animated Shape Divider — Vertical Shape Dividers: Added Left and Right vertical divider positions with dedicated vertical width slider, vertical rotation, and dynamic container height sync.
* Feature: Animated Shape Divider — Complete Aesthetic Overhaul:
  - Zigzag 3D: Replaced spiky 48-needle shark teeth with wide, elegant 6-panel origami 3D accordion ribbon with soft depth shading.
  - Waves Pattern: Redesigned into 16 smooth, flowing organic water ripple curves.
  - Smooth Zigzag: Cleaned into an architectural, silky sine wave with continuous rhythm.
  - Zigzag: Upgraded into modern wide chevron geometric panels.
  - Diamonds & Stairs: Redesigned into Bauhaus modernist stepped blocks and clean rhombus crests.
* Improvement: Animated Shape Divider — Guaranteed 100% seamless infinite loop tiling with zero seams, steps, or vertical cliffs across all shapes.
* Tweak: Removed all emoji icons from Elementor editor control sections for a clean, professional native UI.

= 26.11.06 =
* Feature: Royal Preview Card Widget — Added 10 brand-new modern styles inspired by CreedBD & Unnayan Prochesta design systems:
  - Style 2: Program Card with feature checklist, category badge, and chevron link.
  - Style 3: Minimal Feature Icon Card with soft pastel icon squircle, bold title, and description.
  - Style 4: Process Step Card (Dark Mode) with circular step number, secondary icon, divider, and gold footer note.
  - Style 5: Process Step Card (Light Mode) with clean border, step number, and accent highlight.
  - Style 6: Branch & Headquarters Card (Dark Mode) with gold badge, office icon, address, contact items, and footer note.
  - Style 7: Branch & Hub Card (Light Mode) with emerald badge, location pin icon, address, info list, and recovery rate footer.
  - Style 8: Registration & Legal Info Card (`ab-reg`) with mint background, thick accent left border, shimmer sweep, and definition list.
  - Style 9: Modern Contact Card (`ct-card`) with floating icon, spinning dashed ring, top accent bar, and interactive pill links.
  - Style 10: Social Media & Follow Card (`ct-card`) with floating icon, spinning dashed ring, and 3D bounce gradient social buttons.
  - Style 11: Impact & Stat Metric Card with hover-scaling icon box, big counter metric, uppercase label, and subtitle.
* Fix: Animated Shape Divider — Fixed blank gap in the middle ("মাঝে ফাকা") for Wave — Ripple Rhythm (`waves_pattern`) with a newly generated, mathematically seamless 1200px harmonic wave path ensuring 100% gapless continuous infinite loop tiling.
* Fix: Animated Shape Divider — Rebuilt Smooth Zigzag (`smooth_zigzag`) with a clean 6-cycle sine wave path, fixing out-of-bounds coordinates.
* Fix: Animated Shape Divider — Removed dark editor preset badge label and cleaned up section title icons in Elementor editor.

= 26.11.05 =
* Feature: Royal Divider Widget — Added 10 modern animated divider styles including dual-bar accent, glowing line, traveling glow dot, pulse bar, liquid flow shimmer, diagonal stripes, shooting meteor streak, expand bar, bounce dots, and dual pulse.
* Feature: Animated Shape Divider Overhaul — Fixed broken SVG shapes and re-anchored all paths to Y=0 flat base:
  - Fan Waves: Fixed 120px hole on right side with 8 smooth scallops perfectly spanning 1200px.
  - Tilt Opacity: Replaced duplicate paths with 3 genuine depth layers and dual-color support.
  - Arrow Split: Fixed into a true dual-chevron split arrow with secondary accent peeking from behind.
  - Zigzag: Fixed Y=120 bottom fill bug that caused screen overflow when flipped to bottom position.
  - Zigzag 3D: Redesigned into realistic 3D origami accordion ribbon with light and shaded facets.
  - Half Circle & Book: Fixed distorted bezier curves into symmetrical arch dome and authentic book page spine.
* Feature: Animated Shape Divider 15+ New Shapes — Added Droplet / Liquid Drops, Paint Splash, Wave Brush (Painterly), Torn Paper (Ragged Edge), Flame Tongues (3 Layers), Cityscape Skyline (4 Layers), Desert Dunes (Layered), Pyramids, Split Notch, Waves Pattern, Smooth Zigzag, Diamonds, Stepped Stairs, Scallops Layered Scales, Abstract Web, and Ocean Swell Wave.
* Feature: Universal Animation Engine for All Shapes — Any shape can now animate with infinite continuous flow:
  - Bidirectional controls: Right to Left (RTL) and Left to Right (LTR) infinite loop, plus Alternate Ping-Pong.
  - Mirrored 4-Tile Seamless Loop: 100% zero-jump continuous looping across asymmetrical shapes (Cityscape, Desert, Brush, Flame, etc.).
  - 3D Multi-Layer Parallax Drift: Independent staggered speeds across multi-layer shapes creating cinematic 3D depth.
  - Interactive Hover Effects: Pause on hover and 2.5x speed boost options.
  - Performance: 100% GPU-accelerated CSS translate3d running at 60-120 FPS.
* Fix: Animated Shape Divider — Fixed live animation playback in Elementor editor and frontend preview; removed emojis from all section headers for clean, native styling.

= 26.11.01 =
* Feature: Filterable Post Widget — Major modern UI/UX redesign with enhanced aesthetics, smooth animations, and refined typography.
* Feature: Portfolio Style Overhaul — Complete revamp with macOS-style browser mockup window bar, smooth screenshot scrolling effect, alternative zoom effect, floating category badges, and interactive live preview/details action buttons.
* Feature: Added 5 brand-new styles to Filterable Post widget:
  - Layout 7 (Overlay Card with dark gradient and hover lift)
  - Layout 8 (Minimalist Editorial with underline micro-interaction)
  - Layout 9 (Side by Side / Split layout with responsive flex)
  - Layout 10 (Modern Bento Box with date badge and rotating diagonal arrow)
  - Portfolio (Modern Creative Card with frosted glass overlay)
* Feature: Filter Count Navigation — Added option to show post count in filter tabs with parentheses e.g. `(12)` or modern pill badge e.g. `12`, with complete style controls for normal and active states.
* Feature: Action Buttons Control — Added setting to choose Live Preview only, View Details only, Both buttons, or None, with individual new-tab window options.
* Feature: Added dedicated Portfolio Style controls in Elementor (overlay gradient, category badge colors, and action button styling).
* Improvement: Mobile Display & Height — Increased default portfolio height on mobile devices from 280px to 380px, with responsive sliders and mobile CSS refinements for a spacious, comfortable showcase.
* Improvement: Filter navigation bar redesigned into sleek, modern pills with smooth active states and box shadows.
* Improvement: Re-layout grid automatically with imagesLoaded for seamless Isotope filtering without card overlap.
* Fix: Extra Border Removal — Fixed unwanted outer border issue on grid column items (`.royalisotopeitem`) by properly scoping border and shadow controls to inner cards only.
* Fix: Portfolio Bottom Typography & Overlay — Eliminated awkward solid blue background boxes from titles; styled titles with clean, elegant white typography, soft text shadow, and seamless dark gradient overlay.
* Fix: Custom taxonomy terms now correctly display in meta and badges when using custom post types like Portfolio.
* Fix: Resolved single-assignment bug in portfolio live url check and fixed post-date class naming.
* Tweak: Added animated SVG arrow to Read More button with new-tab target support.

= 26.10.26 =
* Feature: Added new Services Widget with image/icon, title, description, and read more button support.
* Feature: Royal Snippet Custom Code manager now supports PHP code execution with display conditions.
* Tweak: Improved Royal Snippet output system — supports Head, Body Start, Body End, Admin Head, and Admin Footer locations.
* Tweak: Enhanced CPT Manager UI for Custom Codes with modern admin interface and condition-based display.
* Fix: Snippet output now correctly handles priority ordering across all locations.

= 26.09.19 =
* Feature: Added Regular Price, Badges, and Item Links to Price List widget.
* Feature: Added multiple new currency options (Euro, Pound, Rupee, CAD, AUD) to Price List widget.
* Feature: Added Item Gap and Item Border (Style, Color, Width) controls to Price List widget.
* Feature: Added Currency Position control (Left/Right with Space options) to Price List widget.
* Tweak: Improved default styles, hover effects, and border radius for Price List widget.
* Tweak: Updated UI of Deactivate License button in admin dashboard to be uniform with Activate button.
* Fix: Resolved race condition and double AJAX requests in license activation that caused UI conflicts and "✓ undefined" errors.

= 26.08.25 =
Royal Snippet editor updated with PHP code support.
