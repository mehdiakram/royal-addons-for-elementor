<?php
// Global Helper Functions for Royal Addons for Elementor

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/** Initializes the plugin updater. */
function royal_addons_initialize_updater() {
    // Ensure the updater class file is explicitly included here if it's not autoloaded
    if ( ! class_exists( 'Royal_Addons_Updater' ) ) {
        require_once ROYAL_ADDONS_DIR_PATH . 'includes/updater.php';
    }
    $update_url = 'https://raw.githubusercontent.com/mehdiakram/royal-addons-for-elementor/main/royal-addons-for-elementor.json';
    new Royal_Addons_Updater( ROYALADDONSFILE, $update_url ); // Use ROYALADDONSFILE constant
}
add_action( 'init', 'royal_addons_initialize_updater' );


function royal_addons_force_update_check() {
    if ( isset( $_GET['royal_addons_check_update'] ) && current_user_can( 'update_plugins' ) ) {
        delete_site_transient( 'update_plugins' );
        wp_safe_redirect( admin_url( 'plugins.php' ) );
        exit;
    }
}
add_action( 'admin_init', 'royal_addons_force_update_check' );


function royal_addons_for_elementor_mime_types($mimes) {
    $mimes['woff']  = 'application/font-woff';
    $mimes['woff2'] = 'application/font-woff2';
    $mimes['ttf']   = 'application/x-font-ttf';
    $mimes['otf']   = 'application/x-font-otf';
    $mimes['svg']   = 'image/svg+xml';
    $mimes['json']  = 'application/json';
    return $mimes;
}
add_filter('upload_mimes', 'royal_addons_for_elementor_mime_types');


// Image sizes should ideally be hooked to 'after_setup_theme' if they are theme-dependent,
// or 'init' if they are plugin-dependent. Placing them here might be fine but consider context.
add_image_size( 'image300', 300, 300, true );
add_image_size( 'image400x600', 400, 600, true );
add_image_size( 'image600', 600, 600, true );
add_image_size( 'image600x800', 600, 800, true );
add_image_size( 'image800x1200', 800, 1200, true );
add_image_size( 'image800x600', 800, 600, true );
add_image_size( 'image1140x570', 1140, 570, true );
add_image_size( 'image1400x560', 1400, 560, true );


function get_base_domain($host) {
    static $all_ccslds = null;

    if ($all_ccslds === null) {
        $all_ccslds = [];
        $ccsld_path = ROYAL_ADDONS_DIR_PATH . 'includes/ccsld.json';

        if (file_exists($ccsld_path)) {
            $ccsld_json = file_get_contents($ccsld_path);
            $ccsld_data = json_decode($ccsld_json, true);

            if (is_array($ccsld_data)) {
                foreach ($ccsld_data as $country_slds) {
                    if (is_array($country_slds)) {
                        $all_ccslds = array_merge($all_ccslds, $country_slds);
                    }
                }
                usort($all_ccslds, function($a, $b) {
                    return strlen($b) - strlen($a);
                });
            }
        }
    }

    $host = (string) $host;
    $host = strtolower(trim($host));
    
    if (!empty($all_ccslds)) {
        foreach ($all_ccslds as $sld) {
            if (preg_match('/\\.' . preg_quote($sld, '/') . '$/i', $host)) {
                $host_without_sld = substr($host, 0, strlen($host) - strlen($sld) - 1);
                
                $parts = explode('.', $host_without_sld);
                $domain_part = end($parts);
                
                return $domain_part . '.' . $sld;
            }
        }
    }

    $host = preg_replace('/^www\./', '', $host);
    $parts = explode('.', $host);
    $count = count($parts);

    if ($count >= 2) {
        return $parts[$count - 2] . '.' . $parts[$count - 1];
    }

    return $host;
}

function royaladdons_verify_license_cache($localCache) {
    if (!$localCache || !isset($localCache['signature'], $localCache['license_data'])) {
        return false;
    }

    // 1. Ed25519 Signature Verification — prevents tampering and domain forgery
    try {
        $publicKey = base64_decode('vE7PkX4ho5A4ZVWH5KwToDcv1cPIY6FJsNU4tDjbNIw=');
        $signature = base64_decode($localCache['signature']);
        $message   = json_encode($localCache['license_data']);

        if (!sodium_crypto_sign_verify_detached($signature, $message, $publicKey)) {
            return false; // Signature invalid — data tampered or wrong key!
        }
    } catch (\Exception $e) {
        return false;
    }

    $data = $localCache['license_data'];

    // 2. Domain Lock — domain is cryptographically bound to signature
    $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
    if (strpos($host, ':') !== false) {
        $host = explode(':', $host)[0];
    }
    $currentDomain = get_base_domain($host);

    $allowedLocalDomains = ['localhost', '127.0.0.1'];
    if (
        !in_array($currentDomain, $allowedLocalDomains) &&
        strpos($currentDomain, '.test') === false &&
        $currentDomain !== ($data['domain'] ?? '')
    ) {
        return false; // Domain mismatch — DB copied to another domain!
    }

    // 3. Expiry Check with Grace Period
    $now       = time();
    $expiresAt = !empty($data['expires_at']) ? strtotime($data['expires_at']) : null;
    $type      = $data['type'] ?? 'lifetime';

    // Lifetime: only check status (works forever, even without server)
    if ($type === 'lifetime') {
        return ($data['status'] ?? '') === 'active';
    }

    if ($expiresAt && $now > $expiresAt) {
        $graceDays   = ($type === 'yearly') ? 30 : 3;
        $graceExpiry = $expiresAt + ($graceDays * 24 * 60 * 60);
        return $now <= $graceExpiry;
    }

    return ($data['status'] ?? '') === 'active';
}

function royaladdons_is_license_valid() {
    $saved_license = get_option('royaladdons_license_key', '');

    // লাইসেন্স key না থাকলে কোনো HTTP request করা হবে না
    if (empty($saved_license)) {
        return false;
    }

    // লোকাল ক্যাশ আগে চেক করো — সার্ভার ping ছাড়াই
    $localCache = get_option('royaladdons_license_cache', []);
    $cache_valid = royaladdons_verify_license_cache($localCache);

    // Online Check: শুধুমাত্র তখনই পিং করো যদি:
    // (১) transient lock নেই, এবং (২) valid license key আছে
    if (false === get_transient('ra_license_check_lock')) {
        // 1. Lightweight Version Check (GET, ~50 bytes)
        if ($cache_valid) {
            $cachedVersion = (int) get_option('royaladdons_license_version', 0);
            $vUrl = add_query_arg([
                'k' => $saved_license,
                's' => 'royaladdonsforelementor',
                'v' => $cachedVersion,
            ], 'https://auth.royaltechbd.com/api/license/version');

            $vResponse = wp_remote_get($vUrl, [
                'timeout'   => 5,
                'sslverify' => false,
            ]);

            if (!is_wp_error($vResponse) && wp_remote_retrieve_response_code($vResponse) === 200) {
                $vData = json_decode(wp_remote_retrieve_body($vResponse), true);
                if (isset($vData['version'])) {
                    update_option('royaladdons_license_version', (int) $vData['version']);
                }
                if (!($vData['changed'] ?? false)) {
                    set_transient('ra_license_check_lock', 'locked', 24 * 60 * 60);
                    return true;
                }
            }
        }
        global $wp_version;
        $active_theme = wp_get_theme();
        $theme_name   = $active_theme ? $active_theme->get('Name') : 'Unknown';

        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';
        if (strpos($host, ':') !== false) {
            $host = explode(':', $host)[0];
        }
        $domain = get_base_domain($host);

        $user_agent = sprintf(
            'WordPress/%s; PHP/%s; Theme/%s; Url/%s',
            $wp_version, PHP_VERSION, $theme_name, home_url()
        );

        $response = wp_remote_post('https://auth.royaltechbd.com/api/verify', [
            'timeout'    => 10,
            'user-agent' => $user_agent,
            'sslverify'  => false,
            'body'       => [
                'software'    => 'royaladdonsforelementor',
                'license_key' => $saved_license,
                'domain'      => $domain,
            ],
        ]);

        if (is_wp_error($response)) {
            set_transient('ra_license_check_lock', 'locked', 60 * 60);
            return $cache_valid;
        }

        $statusCode = wp_remote_retrieve_response_code($response);
        $body       = json_decode(wp_remote_retrieve_body($response), true);

        // Server 5xx Error — NEVER wipe local cache on server failure!
        if ($statusCode >= 500) {
            set_transient('ra_license_check_lock', 'locked', 60 * 60);
            return $cache_valid;
        }

        // Valid signed response
        if (isset($body['success']) && $body['success'] === true && isset($body['signature'])) {
            if (royaladdons_verify_license_cache($body)) {
                update_option('royaladdons_license_cache', $body);
                if (isset($body['license_data']['version'])) {
                    update_option('royaladdons_license_version', (int) $body['license_data']['version']);
                }
                set_transient('ra_license_check_lock', 'locked', 24 * 60 * 60);
                return true;
            } else {
                delete_option('royaladdons_license_cache');
                set_transient('ra_license_check_lock', 'locked', 2 * 60 * 60);
                return false;
            }
        }

        // Server explicitly rejected the license
        if (isset($body['success']) && $body['success'] === false) {
            $msg = $body['message'] ?? '';
            $definitelyInvalid = stripos($msg, 'suspended') !== false ||
                                 stripos($msg, 'expired') !== false   ||
                                 stripos($msg, 'invalid') !== false   ||
                                 stripos($msg, 'blocked') !== false   ||
                                 $statusCode === 403                  ||
                                 $statusCode === 404;

            if ($definitelyInvalid) {
                delete_option('royaladdons_license_cache');
                set_transient('ra_license_check_lock', 'locked', 2 * 60 * 60);
                return false;
            }

            if ($cache_valid) {
                set_transient('ra_license_check_lock', 'locked', 60 * 60);
                return true;
            }

            delete_option('royaladdons_license_cache');
            set_transient('ra_license_check_lock', 'locked', 2 * 60 * 60);
            return false;
        }

        set_transient('ra_license_check_lock', 'locked', 60 * 60);
    }

    // লোকাল Ed25519 ক্যাশ থেকে যাচাই করো
    return $cache_valid;
}

if (!defined('ROYAL_ADDONS_PRO_ACTIVE')) {
    define('ROYAL_ADDONS_PRO_ACTIVE', royaladdons_is_license_valid());
}
/**
 * AJAX Handler: Download sample stores JSON for Store Locator
 */
add_action( 'wp_ajax_royal_download_sample_stores', 'royal_download_sample_stores_json' );
add_action( 'wp_ajax_nopriv_royal_download_sample_stores', 'royal_download_sample_stores_json' );
if ( ! function_exists( 'royal_download_sample_stores_json' ) ) {
    function royal_download_sample_stores_json() {
        $file = ROYAL_ADDONS_DIR_PATH . 'assets/data/stores-preset.json';
        if ( file_exists( $file ) ) {
            header( 'Content-Description: File Transfer' );
            header( 'Content-Type: application/json; charset=utf-8' );
            header( 'Content-Disposition: attachment; filename="royal-stores-sample.json"' );
            header( 'Expires: 0' );
            header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
            header( 'Pragma: public' );
            header( 'Content-Length: ' . filesize( $file ) );
            readfile( $file );
            exit;
        }
        wp_die( 'Sample JSON file not found.', 'Error', [ 'response' => 404 ] );
    }
}
