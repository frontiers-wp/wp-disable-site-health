<?php
/**
 * Plugin Name: WP Disable Site Health
 * Plugin URI: https://github.com/frontiers-wp/wp-disable-site-health
 * Description: Disables WordPress Site Health features by removing the admin menu and blocking direct access.
 * Author: Edwin Bekedam
 * Author URI: https://github.com/frontiers-wp/wp-disable-site-health
 * Version: 1.0.3
 * Requires PHP: 8.1
 * License: GPL-2.0+
 */

namespace FrontiersWP\DisableSiteHealth;

// Exit if accessed directly.
if (!\defined('ABSPATH')) {
    exit;
}

/**
 * Class DisableSiteHealth
 * 
 * Handles the removal and blocking of the WordPress Site Health feature.
 */
final class DisableSiteHealth {

    /**
     * Initialize the plugin hooks.
     */
    public function __construct() {
        \add_action('admin_menu', [$this, 'remove_site_health_menu']);
        \add_action('current_screen', [$this, 'block_site_health_access']);
    }

    /**
     * Removes the Site Health submenu from the Tools menu.
     */
    public function remove_site_health_menu(): void {
        \remove_submenu_page('tools.php', 'site-health.php');
    }

    /**
     * Blocks direct access to the Site Health page by redirecting to the admin dashboard.
     */
    public function block_site_health_access(): void {
        if (\is_admin()) {
            $screen = \get_current_screen();

            // Redirect if current screen is Site Health
            if ($screen instanceof \WP_Screen && 'site-health' === $screen->id) {
                \wp_safe_redirect(\admin_url());
                exit;
            }
        }
    }
}

// Instantiate the class to activate the hooks
new DisableSiteHealth();
