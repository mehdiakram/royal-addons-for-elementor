<?php
/**
 * Royal HF Header
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $royal_hf_header_id;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}

if ( $royal_hf_header_id ) {
    echo '<header id="masthead" class="site-header royal-hf-header" role="banner">';
    echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $royal_hf_header_id );
    echo '</header>';
}
?>