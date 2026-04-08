<?php
/**
 * Plugin Name: WP Disable Site Health
 * Plugin URI: https://www.bekamhealing.com
 * Description: Disables WordPress Site Health features by removing the admin menu and blocking direct access.
 * Author: Edwin Bekedam
 * Author URI: https://www.bekamhealing.com/
 * Version: 1.0.0
 * License: GPL-2.0+
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Removes the Site Health submenu from the Tools menu.
 */
add_action('admin_menu', 'escode_remove_site_health_menu');
function escode_remove_site_health_menu() {
    remove_submenu_page('tools.php', 'site-health.php');
}

/**
 * Blocks direct access to the Site Health page by redirecting to the admin dashboard.
 */
add_action('current_screen', 'escode_block_site_health_access');
function escode_block_site_health_access() {
    if (is_admin()) {
        $screen = get_current_screen();

        // Redirect if current screen is Site Health
        if ('site-health' === $screen->id) {
            wp_safe_redirect(admin_url());
            exit;
        }
    }
}