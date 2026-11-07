<?php
namespace RoyalAddons;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Manages all the frontend scripts and styles for Royal Addons.
 */
class Royal_Enqueue_Manager {

    /**
     * Registers all the necessary scripts and styles for the plugin.
     * This function is hooked into 'elementor/frontend/after_enqueue_scripts'.
     */
    public function register_all_scripts() {

        // Note: All scripts are set to load in the footer (last parameter is true) for better page speed.
        // All scripts and styles are versioned with your plugin's version number to prevent caching issues on update.

        /*
         * =================================================================
         * Vendor Scripts & Styles (Third-party libraries)
         * =================================================================
         */
        
        // jQuery UI (Bundled with WordPress, so we don't need to register it from a file)
        // You can enqueue 'jquery-ui-core', 'jquery-ui-accordion', etc., directly in your widgets when needed.

        // Modernizr
        wp_register_script('royalmodernizr', ROYAL_ADDONS_DIR_URL.'assets/js/modernizr.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        
        // Match Height
        wp_register_script('matchheight', ROYAL_ADDONS_DIR_URL. 'assets/vendor/match-height/jquery.matchHeight.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        
        // ImagesLoaded (Often used with Isotope)
        wp_register_script('imagesloaded', ROYAL_ADDONS_DIR_URL. 'assets/vendor/imagesloaded/imagesloaded.pkgd.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true );

        // Particles JS
        wp_register_script('particles', ROYAL_ADDONS_DIR_URL. 'assets/vendor/particles/particles.js', [], ROYAL_ADDONS_VERSION, true );

        // Swiper (Elementor's version)
        wp_register_script("swiper", ELEMENTOR_ASSETS_URL . "/lib/swiper/swiper.min.js", ["jquery"], '5.3.6', true ); // Using Elementor's version

        // Owl Carousel
        wp_register_script('royalowlcarousel', ROYAL_ADDONS_DIR_URL.'assets/vendor/owl-carousel/owl.carousel.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalowlcarousel', ROYAL_ADDONS_DIR_URL . 'assets/vendor/owl-carousel/owl.carousel.min.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalowlcarouseltheme', ROYAL_ADDONS_DIR_URL . 'assets/vendor/owl-carousel/owl.theme.default.min.css', [], ROYAL_ADDONS_VERSION);

        // Isotope
        wp_register_script('isotope', ROYAL_ADDONS_DIR_URL.'assets/vendor/isotope/isotope.pkgd.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        
        // Magnific Popup
        wp_register_script('magnific-popup', ROYAL_ADDONS_DIR_URL.'assets/vendor/magnific-popup/jquery.magnific-popup.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true );

        // Lottie Player
        wp_register_script('lottie-player', ROYAL_ADDONS_DIR_URL. 'assets/vendor/lottie-player/lottie-player.js', [], ROYAL_ADDONS_VERSION, true );

        // DataTables
        wp_register_script('datatables', ROYAL_ADDONS_DIR_URL. 'assets/vendor/datatables/datatables.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('datatables', ROYAL_ADDONS_DIR_URL.'assets/vendor/datatables/datatables.css', [], ROYAL_ADDONS_VERSION);

        // Luxon (for World Clock)
        wp_register_script('luxon', ROYAL_ADDONS_DIR_URL. 'assets/vendor/luxon/luxon.js', [], ROYAL_ADDONS_VERSION, true );

        // Leaflet Map & MarkerCluster (100% Free OpenStreetMap)
        wp_register_style('leaflet', ROYAL_ADDONS_DIR_URL . 'assets/vendor/leaflet/leaflet.css', [], '1.9.4');
        wp_register_script('leaflet', ROYAL_ADDONS_DIR_URL . 'assets/vendor/leaflet/leaflet.js', [], '1.9.4', true);
        wp_register_style('leaflet-markercluster', ROYAL_ADDONS_DIR_URL . 'assets/vendor/leaflet/MarkerCluster.css', ['leaflet'], '1.5.3');
        wp_register_style('leaflet-markercluster-default', ROYAL_ADDONS_DIR_URL . 'assets/vendor/leaflet/MarkerCluster.Default.css', ['leaflet-markercluster'], '1.5.3');
        wp_register_script('leaflet-markercluster', ROYAL_ADDONS_DIR_URL . 'assets/vendor/leaflet/leaflet.markercluster.js', ['leaflet'], '1.5.3', true);
        wp_register_style('font-awesome-6', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', [], '6.5.1');

        // Sharer.js
        wp_register_script('sharer', ROYAL_ADDONS_DIR_URL. 'assets/vendor/sharer/sharer.min.js', [], ROYAL_ADDONS_VERSION, true );
        
        // Prism (for Source Code widget)
        wp_register_script('prism', ROYAL_ADDONS_DIR_URL.'assets/vendor/prism/prism.js', [], ROYAL_ADDONS_VERSION, true );
        wp_register_style('prism', ROYAL_ADDONS_DIR_URL.'assets/vendor/prism/prism.min.css', [], ROYAL_ADDONS_VERSION);

        // Countdown
        wp_register_script('countdown', ROYAL_ADDONS_DIR_URL.'assets/vendor/countdown/countdown.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        
        // Typed & vTicker (for Animated Heading)
        wp_register_script('typed', ROYAL_ADDONS_DIR_URL.'assets/vendor/typed/typed.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('vticker', ROYAL_ADDONS_DIR_URL.'assets/vendor/vticker/vticker.js', ['jquery'], ROYAL_ADDONS_VERSION, true );

        // jQuery Event Move (for Image Comparison)
        wp_register_script('jquery-event-move', ROYAL_ADDONS_DIR_URL.'assets/vendor/jquery.event.move/jquery.event.move.js', ['jquery'], ROYAL_ADDONS_VERSION, true );

        // GSAP Animation Libraries
        wp_register_script('gsap', ROYAL_ADDONS_DIR_URL.'assets/vendor/gsap/gsap.min.js', [], ROYAL_ADDONS_VERSION, true );
        wp_register_script('scrolltrigger', ROYAL_ADDONS_DIR_URL.'assets/vendor/gsap/scrolltrigger.min.js', ['gsap'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('splittext', ROYAL_ADDONS_DIR_URL.'assets/vendor/splittext/SplitText.min.js', ['gsap'], ROYAL_ADDONS_VERSION, true );
        
        // Anime.js
        wp_register_script('royalanime', ROYAL_ADDONS_DIR_URL.'assets/vendor/anime/lib/anime.min.js', [], ROYAL_ADDONS_VERSION, true );
        
        // Animate.css
        wp_register_style('royalanimate', ROYAL_ADDONS_DIR_URL.'assets/vendor/animate/animate.min.css', [], ROYAL_ADDONS_VERSION);

        /*
         * =================================================================
         * Plugin's Own Scripts & Styles
         * =================================================================
         */
        
        // General Components
        wp_register_style('royalcarousel', ROYAL_ADDONS_DIR_URL. 'assets/css/royalcarousel.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalcarousel', ROYAL_ADDONS_DIR_URL.'assets/js/royalcarousel.js', ['jquery', 'royalowlcarousel'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalimagegrid', ROYAL_ADDONS_DIR_URL. 'assets/css/royalimagegrid.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalmasonry', ROYAL_ADDONS_DIR_URL.'assets/js/royalmasonry.js', ['jquery', 'isotope'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalisotope', ROYAL_ADDONS_DIR_URL.'assets/js/royalisotope.js', ['jquery', 'isotope'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalmagnificpopup', ROYAL_ADDONS_DIR_URL.'assets/js/royalmagnificpopup.js', ['jquery', 'magnific-popup'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalyoutubevideo', ROYAL_ADDONS_DIR_URL.'assets/js/royalyoutubevideo.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalyoutubechannel', ROYAL_ADDONS_DIR_URL.'assets/js/royalyoutubechannel.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalimagegallery', ROYAL_ADDONS_DIR_URL. 'assets/css/royalimagegallery.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalimagegallerysleek', ROYAL_ADDONS_DIR_URL. 'assets/css/royalimagegallerysleek.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalsearch', ROYAL_ADDONS_DIR_URL. 'assets/js/royalsearch.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalsearchajax', ROYAL_ADDONS_DIR_URL.'assets/css/royalsearchajax.css', [], ROYAL_ADDONS_VERSION);
		wp_register_script( 'royalsearchajax', ROYAL_ADDONS_DIR_URL . 'assets/js/royalsearchajax.js', [ 'jquery' ], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalpostmetaquery', ROYAL_ADDONS_DIR_URL. 'assets/js/royalpostmetaquery.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalpostmetaquery', ROYAL_ADDONS_DIR_URL. 'assets/css/royalpostmetaquery.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalclockworld', ROYAL_ADDONS_DIR_URL. 'assets/js/royalclockworld.js', ['jquery', 'luxon'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalclockworld', ROYAL_ADDONS_DIR_URL . 'assets/css/royalclockworld.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalflipbox', ROYAL_ADDONS_DIR_URL . 'assets/css/royalflipbox.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalflipbox', ROYAL_ADDONS_DIR_URL. 'assets/js/royalflipbox.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royallightbox', ROYAL_ADDONS_DIR_URL . 'assets/css/royallightbox.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalimagehovereffect', ROYAL_ADDONS_DIR_URL . 'assets/css/royalimagehovereffect.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalimagestack', ROYAL_ADDONS_DIR_URL . 'assets/css/royalimagestack.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalimagescrolling', ROYAL_ADDONS_DIR_URL . 'assets/css/royalimagescrolling.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalimagescrolling', ROYAL_ADDONS_DIR_URL. 'assets/js/royalimagescrolling.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalimagescroll', ROYAL_ADDONS_DIR_URL. 'assets/js/royalimagescroll.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalimagescroll', ROYAL_ADDONS_DIR_URL . 'assets/css/royalimagescroll.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalsocialshare', ROYAL_ADDONS_DIR_URL . 'assets/css/royalsocialshare.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalteam', ROYAL_ADDONS_DIR_URL. 'assets/js/royalteam.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalteam', ROYAL_ADDONS_DIR_URL . 'assets/css/royalteam.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalweathermap', ROYAL_ADDONS_DIR_URL. 'assets/js/royalweathermap.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalweathermap', ROYAL_ADDONS_DIR_URL . 'assets/css/royalweathermap.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalimagehotspots', ROYAL_ADDONS_DIR_URL.'assets/js/royalimagehotspots.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalimagehotspots', ROYAL_ADDONS_DIR_URL.'assets/css/royalimagehotspots.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalagegate', ROYAL_ADDONS_DIR_URL.'assets/js/royalagegate.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalagegate', ROYAL_ADDONS_DIR_URL.'assets/css/royalagegate.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalsourcecode', ROYAL_ADDONS_DIR_URL . 'assets/css/royalsourcecode.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalsourcecode', ROYAL_ADDONS_DIR_URL.'assets/js/royalsourcecode.js', ['jquery', 'prism'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royaltimeline', ROYAL_ADDONS_DIR_URL.'assets/js/royaltimeline.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royaltimeline', ROYAL_ADDONS_DIR_URL . 'assets/css/royaltimeline.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalorganogram', ROYAL_ADDONS_DIR_URL . 'assets/js/royalorganogram.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalorganogram', ROYAL_ADDONS_DIR_URL . 'assets/css/royalorganogram.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalcountdown', ROYAL_ADDONS_DIR_URL.'assets/js/royalcountdown.js', ['jquery', 'countdown'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalcountdown', ROYAL_ADDONS_DIR_URL.'assets/css/royalcountdown.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalheadinganimated', ROYAL_ADDONS_DIR_URL.'assets/js/royalheadinganimated.js', ['jquery', 'typed', 'vticker'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalheadinganimated', ROYAL_ADDONS_DIR_URL.'assets/css/royalheadinganimated.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalimagecomparison', ROYAL_ADDONS_DIR_URL.'assets/js/royalimagecomparison.js', ['jquery', 'jquery-event-move'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalimagecomparison', ROYAL_ADDONS_DIR_URL.'assets/css/royalimagecomparison.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalslidernatural', ROYAL_ADDONS_DIR_URL.'assets/css/royalslidernatural.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalslidernatural', ROYAL_ADDONS_DIR_URL.'assets/js/royalslidernatural.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalslidercircle', ROYAL_ADDONS_DIR_URL.'assets/css/royalslidercircle.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalslidercircle', ROYAL_ADDONS_DIR_URL.'assets/js/royalslidercircle.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalportfolio', ROYAL_ADDONS_DIR_URL.'assets/js/royalportfolio.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalportfolio', ROYAL_ADDONS_DIR_URL.'assets/css/royalportfolio.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalticker', ROYAL_ADDONS_DIR_URL.'assets/js/royalticker.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalticker', ROYAL_ADDONS_DIR_URL.'assets/css/royalticker.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalbuttoneffects', ROYAL_ADDONS_DIR_URL.'assets/css/royalbuttoneffects.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalfloatsocialbuttons', ROYAL_ADDONS_DIR_URL.'assets/css/royalfloatsocialbuttons.css', [], ROYAL_ADDONS_VERSION);
        $stt_css_ver = file_exists(ROYAL_ADDONS_DIR_PATH.'assets/css/royalscrolltotop.css') ? filemtime(ROYAL_ADDONS_DIR_PATH.'assets/css/royalscrolltotop.css') : ROYAL_ADDONS_VERSION;
        $stt_js_ver  = file_exists(ROYAL_ADDONS_DIR_PATH.'assets/js/royalscrolltotop.js') ? filemtime(ROYAL_ADDONS_DIR_PATH.'assets/js/royalscrolltotop.js') : ROYAL_ADDONS_VERSION;
        wp_register_style('royalscrolltotop', ROYAL_ADDONS_DIR_URL.'assets/css/royalscrolltotop.css', [], $stt_css_ver);
        wp_register_script('royalscrolltotop', ROYAL_ADDONS_DIR_URL.'assets/js/royalscrolltotop.js', ['jquery'], $stt_js_ver, true);
        wp_register_style('royalpreloder', ROYAL_ADDONS_DIR_URL.'assets/css/royalpreloder.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalvisitorsstats', ROYAL_ADDONS_DIR_URL.'assets/css/royalvisitorsstats.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalphonecall', ROYAL_ADDONS_DIR_URL.'assets/css/royalphonecall.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalitemlists', ROYAL_ADDONS_DIR_URL.'assets/css/royalitemlists.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalreview', ROYAL_ADDONS_DIR_URL.'assets/css/royalreview.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalskillbar', ROYAL_ADDONS_DIR_URL.'assets/css/royalskillbar.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalopeninghours', ROYAL_ADDONS_DIR_URL.'assets/css/royalopeninghours.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalheadinggradient', ROYAL_ADDONS_DIR_URL.'assets/css/royalheadinggradient.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalheading', ROYAL_ADDONS_DIR_URL.'assets/css/royalheading.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalheadingdual', ROYAL_ADDONS_DIR_URL.'assets/css/royalheadingdual.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalheadingdual', ROYAL_ADDONS_DIR_URL.'assets/js/royalheadingdual.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalheadingscrolltrigger', ROYAL_ADDONS_DIR_URL.'assets/js/royalheadingscrolltrigger.js', ['jquery', 'gsap'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royaldomainsearch', ROYAL_ADDONS_DIR_URL.'assets/css/royaldomainsearch.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalinfinitescroll', ROYAL_ADDONS_DIR_URL.'assets/css/royalinfinitescroll.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalinfinitescroll', ROYAL_ADDONS_DIR_URL.'assets/js/royalinfinitescroll.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalchartprogressbar', ROYAL_ADDONS_DIR_URL.'assets/css/royalchartprogressbar.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalchartprogressbar', ROYAL_ADDONS_DIR_URL.'assets/js/royalchartprogressbar.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royaltechuikit', ROYAL_ADDONS_DIR_URL.'assets/js/royal-uikit.min.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royaltechuikit', ROYAL_ADDONS_DIR_URL . 'assets/css/royal-uikit.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalsliderdragon', ROYAL_ADDONS_DIR_URL.'assets/css/royalsliderdragon.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalslidergeneral', ROYAL_ADDONS_DIR_URL.'assets/css/royalslidergeneral.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalsliderdragon', ROYAL_ADDONS_DIR_URL.'assets/js/royalsliderdragon.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('royalslidergeneral', ROYAL_ADDONS_DIR_URL.'assets/js/royalslidergeneral.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalsvgdrawer', ROYAL_ADDONS_DIR_URL.'assets/css/royalsvgdrawer.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalsvgdrawer', ROYAL_ADDONS_DIR_URL.'assets/js/royalsvgdrawer.js', ['jquery', 'gsap'], ROYAL_ADDONS_VERSION, true );
        wp_register_style( 'royalpopup', ROYAL_ADDONS_ASSETS . 'css/royalpopup.css', [], ROYAL_ADDONS_VERSION );
        wp_register_script( 'royalpopup', ROYAL_ADDONS_ASSETS . 'js/royalpopup.js', [ 'jquery' ], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royaloffcanvas', ROYAL_ADDONS_DIR_URL.'assets/css/royaloffcanvas.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royaloffcanvas', ROYAL_ADDONS_DIR_URL.'assets/js/royaloffcanvas.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalads', ROYAL_ADDONS_DIR_URL.'assets/css/royalads.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalads', ROYAL_ADDONS_DIR_URL.'assets/js/royalads.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        $tab_css_ver = file_exists(ROYAL_ADDONS_DIR_PATH.'assets/css/royaladvancedtabs.css') ? filemtime(ROYAL_ADDONS_DIR_PATH.'assets/css/royaladvancedtabs.css') : ROYAL_ADDONS_VERSION;
        $tab_js_ver  = file_exists(ROYAL_ADDONS_DIR_PATH.'assets/js/royaladvancedtabs.js') ? filemtime(ROYAL_ADDONS_DIR_PATH.'assets/js/royaladvancedtabs.js') : ROYAL_ADDONS_VERSION;
        wp_register_style('royaladvancedtabs', ROYAL_ADDONS_DIR_URL.'assets/css/royaladvancedtabs.css', [], $tab_css_ver);
        wp_register_script('royaladvancedtabs', ROYAL_ADDONS_DIR_URL.'assets/js/royaladvancedtabs.js', ['jquery'], $tab_js_ver, true );
        wp_register_style('royal360degreeview', ROYAL_ADDONS_DIR_URL.'assets/css/royal360degreeview.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royal360degreeview', ROYAL_ADDONS_DIR_URL.'assets/js/royal360degreeview.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalschema', ROYAL_ADDONS_DIR_URL.'assets/css/royalschema.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalschema', ROYAL_ADDONS_DIR_URL.'assets/js/royalschema.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalsliderlanding', ROYAL_ADDONS_DIR_URL.'assets/css/royalsliderlanding.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalsliderlanding', ROYAL_ADDONS_DIR_URL.'assets/js/royalsliderlanding.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalimagecarousel3d', ROYAL_ADDONS_DIR_URL.'assets/css/royalimagecarousel3d.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalimagecarousel3d', ROYAL_ADDONS_DIR_URL.'assets/js/royalimagecarousel3d.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_script('accordion.multiple', ROYAL_ADDONS_DIR_URL.'assets/vendor/jquery-ui/jquery-ui.accordion.multiple.js', ['jquery-ui-accordion'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalaccordion', ROYAL_ADDONS_DIR_URL.'assets/css/royalaccordion.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalaccordion', ROYAL_ADDONS_DIR_URL.'assets/js/royalaccordion.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalblob', ROYAL_ADDONS_DIR_URL.'assets/css/royalblob.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalimagebox', ROYAL_ADDONS_DIR_URL.'assets/css/royalimagebox.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalnavmenumobile', ROYAL_ADDONS_DIR_URL.'assets/css/royalnavmenumobile.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalnavmenu', ROYAL_ADDONS_DIR_URL.'assets/css/royalnavmenu.css', [], ROYAL_ADDONS_VERSION);

        wp_register_script('royalnavmenuvertical', ROYAL_ADDONS_DIR_URL.'assets/js/royalnavmenuvertical.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalnavmenuvertical', ROYAL_ADDONS_DIR_URL.'assets/css/royalnavmenuvertical.css', [], ROYAL_ADDONS_VERSION);

        wp_register_script('royalnavmenufullblob', ROYAL_ADDONS_DIR_URL.'assets/js/royalnavmenufullblob.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalnavmenufullblob', ROYAL_ADDONS_DIR_URL.'assets/css/royalnavmenufullblob.css', [], ROYAL_ADDONS_VERSION);

        wp_register_script('royalnavmenumorph', ROYAL_ADDONS_DIR_URL.'assets/js/royalnavmenumorph.js', ['jquery'], ROYAL_ADDONS_VERSION, true );
        wp_register_style('royalnavmenumorph', ROYAL_ADDONS_DIR_URL.'assets/css/royalnavmenumorph.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalcontactform7', ROYAL_ADDONS_DIR_URL.'assets/css/royalcontactform7.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalpost', ROYAL_ADDONS_DIR_URL.'assets/css/royalpost.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalpostcategory', ROYAL_ADDONS_DIR_URL.'assets/css/royalpostcategory.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalpostfilterable', ROYAL_ADDONS_DIR_URL.'assets/css/royalpostfilterable.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalpostfilterable', ROYAL_ADDONS_DIR_URL.'assets/js/royalpostfilterable.js', ['jquery', 'isotope'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalwooproducts', ROYAL_ADDONS_DIR_URL.'assets/css/royalwooproducts.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalpreviewcard', ROYAL_ADDONS_DIR_URL.'assets/css/royalpreviewcard.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalpricelist', ROYAL_ADDONS_DIR_URL.'assets/css/royalpricelist.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalpricingtable', ROYAL_ADDONS_DIR_URL.'assets/css/royalpricingtable.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalprofilecard', ROYAL_ADDONS_DIR_URL.'assets/css/royalprofilecard.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royaldivider', ROYAL_ADDONS_DIR_URL.'assets/css/royaldivider.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalsearch', ROYAL_ADDONS_DIR_URL.'assets/css/royalsearch.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalservicelist', ROYAL_ADDONS_DIR_URL.'assets/css/royalservicelist.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalservices', ROYAL_ADDONS_DIR_URL.'assets/css/royalservices.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalwavetext', ROYAL_ADDONS_DIR_URL.'assets/css/royalwavetext.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalwoominicart', ROYAL_ADDONS_DIR_URL.'assets/css/royalwoominicart.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalcardmaker', ROYAL_ADDONS_DIR_URL.'assets/js/royalcardmaker.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalcardmaker', ROYAL_ADDONS_DIR_URL.'assets/css/royalcardmaker.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalsliderblur', ROYAL_ADDONS_DIR_URL.'assets/js/royalsliderblur.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalsliderblur', ROYAL_ADDONS_DIR_URL.'assets/css/royalsliderblur.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalsliderbuck', ROYAL_ADDONS_DIR_URL.'assets/js/royalsliderbuck.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalsliderbuck', ROYAL_ADDONS_DIR_URL.'assets/css/royalsliderbuck.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalslidernike', ROYAL_ADDONS_DIR_URL.'assets/js/royalslidernike.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalslidernike', ROYAL_ADDONS_DIR_URL.'assets/css/royalslidernike.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalcalltoactionbox', ROYAL_ADDONS_DIR_URL.'assets/js/royalcalltoactionbox.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalcalltoactionbox', ROYAL_ADDONS_DIR_URL.'assets/css/royalcalltoactionbox.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalslidernike', ROYAL_ADDONS_DIR_URL.'assets/css/royalslidernike.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalfeedviewer', ROYAL_ADDONS_DIR_URL.'assets/js/royalfeedviewer.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
        wp_register_style('royalfeedviewer', ROYAL_ADDONS_DIR_URL.'assets/css/royalfeedviewer.css', [], ROYAL_ADDONS_VERSION);
        wp_register_style('royalform', ROYAL_ADDONS_DIR_URL.'assets/css/royalform.css', [], ROYAL_ADDONS_VERSION);
        wp_register_script('royalform', ROYAL_ADDONS_DIR_URL.'assets/js/royalform.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
        wp_localize_script('royalform', 'royal_addons_settings', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('royalform'),
        ));

        // Royal Login Widget
        wp_register_style( 'royallogin', ROYAL_ADDONS_DIR_URL . 'assets/css/royallogin.css', [], ROYAL_ADDONS_VERSION );
        wp_register_script( 'royallogin', ROYAL_ADDONS_DIR_URL . 'assets/js/royallogin.js', [ 'jquery', 'sweetalert2' ], ROYAL_ADDONS_VERSION, true );

        // Royal Masonry Widget
        wp_register_style( 'royalmasonry-widget', ROYAL_ADDONS_DIR_URL . 'assets/css/royalmasonry.css', [], ROYAL_ADDONS_VERSION );
        wp_register_script( 'royalmasonry-widget', ROYAL_ADDONS_DIR_URL . 'assets/js/royalmasonry-widget.js', [ 'jquery', 'isotope', 'imagesloaded', 'magnific-popup' ], ROYAL_ADDONS_VERSION, true );

        // SweetAlert2 (frontend)
        wp_register_style( 'sweetalert2', ROYAL_ADDONS_DIR_URL . 'assets/vendor/sweetalert2/sweetalert2.min.css', [], ROYAL_ADDONS_VERSION );
        wp_register_script( 'sweetalert2', ROYAL_ADDONS_DIR_URL . 'assets/vendor/sweetalert2/sweetalert2.all.min.js', [], ROYAL_ADDONS_VERSION, true );

        // Royal Section Divider Widget (Pure Vanilla JS – no jQuery required)
        wp_register_style(  'royalanimatedshapedivider', ROYAL_ADDONS_DIR_URL . 'assets/css/royalanimatedshapedivider.css', [], ROYAL_ADDONS_VERSION );
        wp_register_script( 'royalanimatedshapedivider', ROYAL_ADDONS_DIR_URL . 'assets/js/royalanimatedshapedivider.js',  [ 'jquery' ], ROYAL_ADDONS_VERSION, true );

        // Royal Image Collage Widget (Interactive Parallax & Floating Grid)
        wp_register_style(  'royalimagecollage', ROYAL_ADDONS_DIR_URL . 'assets/css/royalimagecollage.css', [], ROYAL_ADDONS_VERSION );
        wp_register_script( 'royalimagecollage', ROYAL_ADDONS_DIR_URL . 'assets/js/royalimagecollage.js',  [], ROYAL_ADDONS_VERSION, true );

        // Royal Store Locator Widget
        $rsl_css_ver = file_exists( ROYAL_ADDONS_DIR_PATH . 'assets/css/royalstorelocator.css' ) ? filemtime( ROYAL_ADDONS_DIR_PATH . 'assets/css/royalstorelocator.css' ) : ROYAL_ADDONS_VERSION;
        $rsl_js_ver  = file_exists( ROYAL_ADDONS_DIR_PATH . 'assets/js/royalstorelocator.js' ) ? filemtime( ROYAL_ADDONS_DIR_PATH . 'assets/js/royalstorelocator.js' ) : ROYAL_ADDONS_VERSION;
        wp_register_style( 'royalstorelocator', ROYAL_ADDONS_DIR_URL . 'assets/css/royalstorelocator.css', ['font-awesome-6', 'leaflet', 'leaflet-markercluster', 'leaflet-markercluster-default'], $rsl_css_ver );
        wp_register_script( 'royalstorelocator', ROYAL_ADDONS_DIR_URL . 'assets/js/royalstorelocator.js', ['jquery', 'leaflet', 'leaflet-markercluster'], $rsl_js_ver, true );
        wp_localize_script( 'royalstorelocator', 'royalStoreLocatorData', [
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'pluginUrl' => ROYAL_ADDONS_DIR_URL,
            'presetUrl' => ROYAL_ADDONS_DIR_URL . 'assets/data/stores-preset.json',
        ] );

        // Bootstrap Icons
        wp_register_style( 'bootstrap-icons', ROYAL_ADDONS_DIR_URL . 'assets/vendor/bootstrap-icons/bootstrap-icons.min.css', [], '1.11.3' );

        // Royal Branches Locator Widget
        $rbl_css_ver = file_exists( ROYAL_ADDONS_DIR_PATH . 'assets/css/royalbrancheslocator.css' ) ? filemtime( ROYAL_ADDONS_DIR_PATH . 'assets/css/royalbrancheslocator.css' ) : ROYAL_ADDONS_VERSION;
        $rbl_js_ver  = file_exists( ROYAL_ADDONS_DIR_PATH . 'assets/js/royalbrancheslocator.js' ) ? filemtime( ROYAL_ADDONS_DIR_PATH . 'assets/js/royalbrancheslocator.js' ) : ROYAL_ADDONS_VERSION;
        wp_register_style( 'royalbrancheslocator', ROYAL_ADDONS_DIR_URL . 'assets/css/royalbrancheslocator.css', ['bootstrap-icons', 'leaflet'], $rbl_css_ver );
        wp_register_script( 'royalbrancheslocator', ROYAL_ADDONS_DIR_URL . 'assets/js/royalbrancheslocator.js', ['leaflet'], $rbl_js_ver, true );
        wp_localize_script( 'royalbrancheslocator', 'royalBranchesLocatorConfig', [
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'pluginUrl' => ROYAL_ADDONS_DIR_URL,
            'presetUrl' => ROYAL_ADDONS_DIR_URL . 'assets/data/branches.json',
        ] );

        // Common assets that are always loaded on the frontend

        // Common assets conditionally loaded for performance
        $post_id = get_the_ID();
        $is_elementor = false;
        if ( class_exists( '\Elementor\Plugin' ) ) {
            if ( $post_id && \Elementor\Plugin::$instance->documents->get( $post_id ) && \Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor() ) {
                $is_elementor = true;
            } elseif ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
                $is_elementor = true;
            }
        }
        
        // As a fallback for global headers/footers built with Elementor
        if ( $is_elementor || is_singular() || is_archive() || is_home() ) {
            wp_enqueue_script('royalallinone', ROYAL_ADDONS_DIR_URL.'assets/js/allinone.js', ['jquery'], ROYAL_ADDONS_VERSION, true);
            wp_enqueue_style('royalallinone', ROYAL_ADDONS_DIR_URL.'assets/css/allinone.css', [], ROYAL_ADDONS_VERSION);
            wp_enqueue_style('royalcommon', ROYAL_ADDONS_DIR_URL . 'assets/css/common.css', [], ROYAL_ADDONS_VERSION);
            wp_enqueue_style( 'royalicon', ROYAL_ADDONS_DIR_URL . 'assets/vendor/royalicon/css/royalicon.css', [], ROYAL_ADDONS_VERSION);
        }
    }
}