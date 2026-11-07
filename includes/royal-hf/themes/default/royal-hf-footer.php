<?php
/**
 * Royal HF Footer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $royal_hf_footer_id, $royal_hf_before_footer_id;

// Render Before Footer if it exists.
if ( $royal_hf_before_footer_id ) {
    echo '<div class="royal-before-footer-wrap">';
    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $royal_hf_before_footer_id );
    echo '</div>';
}

// Render Footer if it exists.
if ( $royal_hf_footer_id ) {
    echo '<footer id="colophon" class="site-footer royal-hf-footer" role="contentinfo">';
    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $royal_hf_footer_id );
    echo '</footer>';
}

// Call WordPress footer hooks.
wp_footer();
?>
</body>
</html>
