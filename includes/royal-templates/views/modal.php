<?php
/**
 * Royal Templates Library Modal
 *
 * @package RoyalAddonsForElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div id="royal-templates-modal" class="royal-templates-modal" style="display: none;">
    <div class="royal-templates-modal-backdrop"></div>
    <div class="royal-templates-modal-content">
        
        <!-- Header -->
        <div class="royal-templates-modal-header">
            <div class="royal-templates-header-left">
                <img src="<?php echo esc_url( ROYAL_ADDONS_ASSETS . 'images/logo.png' ); ?>" alt="Royal Templates" class="royal-templates-logo">
                <h2><?php esc_html_e( 'Royal Templates', 'royal-addons-for-elementor' ); ?></h2>
            </div>
            <div class="royal-templates-header-center">
                <div class="royal-templates-tabs">
                    <button class="royal-templates-tab active" data-tab="pages">
                        <span class="dashicons dashicons-media-default"></span>
                        <?php esc_html_e( 'Pages', 'royal-addons-for-elementor' ); ?>
                    </button>
                    <button class="royal-templates-tab" data-tab="sections">
                        <span class="dashicons dashicons-screenoptions"></span>
                        <?php esc_html_e( 'Sections', 'royal-addons-for-elementor' ); ?>
                    </button>
                    <button class="royal-templates-tab" data-tab="headers">
                        <span class="dashicons dashicons-schedule"></span>
                        <?php esc_html_e( 'Headers', 'royal-addons-for-elementor' ); ?>
                    </button>
                    <button class="royal-templates-tab" data-tab="footers">
                        <span class="dashicons dashicons-arrow-down-alt"></span>
                        <?php esc_html_e( 'Footers', 'royal-addons-for-elementor' ); ?>
                    </button>
                </div>
            </div>
            <div class="royal-templates-header-right">
                <button class="royal-templates-close" title="<?php esc_attr_e( 'Close', 'royal-addons-for-elementor' ); ?>">
                    <span class="dashicons dashicons-no-alt"></span>
                </button>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="royal-templates-toolbar">
            <div class="royal-templates-toolbar-left">
                <div class="royal-templates-filter-type">
                    <button class="royal-templates-type-btn active" data-type="all">
                        <?php esc_html_e( 'All', 'royal-addons-for-elementor' ); ?>
                    </button>
                    <button class="royal-templates-type-btn" data-type="free">
                        <?php esc_html_e( 'Free', 'royal-addons-for-elementor' ); ?>
                    </button>
                    <button class="royal-templates-type-btn" data-type="pro">
                        <?php esc_html_e( 'Pro', 'royal-addons-for-elementor' ); ?>
                    </button>
                </div>
                <div class="royal-templates-filter-category">
                    <select id="royal-templates-category">
                        <option value="all"><?php esc_html_e( 'All Categories', 'royal-addons-for-elementor' ); ?></option>
                        <option value="business"><?php esc_html_e( 'Business', 'royal-addons-for-elementor' ); ?></option>
                        <option value="portfolio"><?php esc_html_e( 'Portfolio', 'royal-addons-for-elementor' ); ?></option>
                        <option value="blog"><?php esc_html_e( 'Blog', 'royal-addons-for-elementor' ); ?></option>
                        <option value="landing"><?php esc_html_e( 'Landing Page', 'royal-addons-for-elementor' ); ?></option>
                        <option value="ecommerce"><?php esc_html_e( 'eCommerce', 'royal-addons-for-elementor' ); ?></option>
                        <option value="agency"><?php esc_html_e( 'Agency', 'royal-addons-for-elementor' ); ?></option>
                        <option value="starter"><?php esc_html_e( 'Starter', 'royal-addons-for-elementor' ); ?></option>
                    </select>
                </div>
            </div>
            <div class="royal-templates-toolbar-right">
                <div class="royal-templates-search">
                    <span class="dashicons dashicons-search"></span>
                    <input type="text" id="royal-templates-search" placeholder="<?php esc_attr_e( 'Search templates...', 'royal-addons-for-elementor' ); ?>">
                </div>
            </div>
        </div>

        <!-- Body / Templates Grid -->
        <div class="royal-templates-body">
            <div class="royal-templates-grid" id="royal-templates-grid">
                <!-- Templates will be loaded here via JS -->
            </div>
            <div class="royal-templates-loading" id="royal-templates-loading">
                <div class="royal-templates-spinner"></div>
                <p><?php esc_html_e( 'Loading templates...', 'royal-addons-for-elementor' ); ?></p>
            </div>
            <div class="royal-templates-empty" id="royal-templates-empty" style="display: none;">
                <span class="dashicons dashicons-layout"></span>
                <p><?php esc_html_e( 'No templates found.', 'royal-addons-for-elementor' ); ?></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="royal-templates-modal-footer">
            <p>
                <?php 
                printf( 
                    esc_html__( 'Royal Addons for Elementor v%s | %s Templates Available', 'royal-addons-for-elementor' ), 
                    ROYAL_ADDONS_VERSION,
                    '<span id="royal-templates-count">0</span>'
                ); 
                ?>
            </p>
        </div>
    </div>
</div>

<!-- Template Preview Modal -->
<div id="royal-template-preview-modal" class="royal-template-preview-modal" style="display: none;">
    <div class="royal-template-preview-backdrop"></div>
    <div class="royal-template-preview-content">
        <div class="royal-template-preview-header">
            <h3 id="royal-preview-title"></h3>
            <button class="royal-template-preview-close">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </div>
        <div class="royal-template-preview-body">
            <iframe id="royal-preview-iframe" src="about:blank"></iframe>
        </div>
        <div class="royal-template-preview-footer">
            <button class="royal-template-import-btn" id="royal-preview-import-btn">
                <span class="dashicons dashicons-download"></span>
                <?php esc_html_e( 'Import Template', 'royal-addons-for-elementor' ); ?>
            </button>
        </div>
    </div>
</div>
