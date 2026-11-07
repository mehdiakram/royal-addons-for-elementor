<?php
/**
 * Royal Layout Builder — Loader
 * @package RoyalAddons\RoyalLayout
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

require_once ROYAL_LAYOUT_DIR . 'class-royal-layout-conditions-cache.php';
require_once ROYAL_LAYOUT_DIR . 'class-royal-layout-conditions.php';
require_once ROYAL_LAYOUT_DIR . 'class-royal-layout-renderer.php';
require_once ROYAL_LAYOUT_DIR . 'class-royal-layout.php';
require_once ROYAL_LAYOUT_DIR . 'admin/class-royal-layout-admin.php';

\RoyalAddons\RoyalLayout\Core::instance();
\RoyalAddons\RoyalLayout\Admin::instance();
