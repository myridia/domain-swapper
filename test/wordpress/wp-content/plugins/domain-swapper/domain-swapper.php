<?php

/**
 * @see              https://domain-swapper.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Domain-swapper
 * Plugin URI: https://wordpress.org/plugins/domain-swapper
 * Description: Swap or change your Domains for one WordPress Site. So you can access one single WordPress site with different domains.
 * Version: 1.0.6
 * Author: veto, Myridia Company
 * Author URI: http://domain-swapper.myridia.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: domain-swapper
 * Domain Path: /languages
 * Update URL: https://github.com/myridia/domain-swapper
 * Constant Prefix: WPDS_
 * Prefix: wpds_
 * Option_key: plugin_domain_swapper
 **/

/*
 * Default Wordpress Constant
 *
 * @since 1.0.0 (if available)
 */
defined('ABSPATH') or exit('Something went wrong');

/*
 * Set the Plugin Namespace
 *
 * @since 1.0.0 (if available)
 */
use WP\Ds\Main\ClassAdmin;
use WP\Ds\Main\ClassAjax;
use WP\Ds\Main\ClassFrontend;

/*
 * Constants Calls
 *
 * @since 1.0.0 (if available)
 */
define('WPDS_NAME', 'domain-swapper');
define('WPDS_DIR', 'domain-swapper');
define('WPDS_BASE', 'domain-swapper/domain-swapper.php');
define('WPDS_URL', 'https://www.app.local/wp-content/plugins/domain-swapper/');
define('WPDS_URI', 'https://www.app.local/wp-content/plugins/domain-swapper/');
define('WPDS_PATH', '/usr/share/nginx/html/wp-content/plugins/domain-swapper/');
define('WPDS_SLUG', 'domain-swapper');
define('WPDS_BASENAME', 'domain-swapper');
define('WPDS_VERSION', '1.0.6');
define('WPDS_TEXT', 'domain-swapper');
define('WPDS_PREFIX', 'wpds_');
define('WPDS_OPTION', 'plugin_domain_swapper');

/*
 * Default Plugin activate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_activation_hook(__FILE__, ['WP\Ds\Main\ClassAdmin', 'activate']);

/*
 * Default Plugin deactivate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_deactivation_hook(__FILE__, ['WP\Ds\Main\ClassAdmin', 'deactivate']);

// Register to start the Plugin

add_action('init', 'wp_ds_plugin_init', 80);
add_action('admin_init', 'wp_ds_plugin_admin_init', 99);

/**
 * Init the Admin Plugin .
 *
 * Init ClassAdmin and register the settings
 *
 * @since 1.0.0
 */
function wp_ds_plugin_admin_init()
{
    $plugin = new ClassAdmin();
    $plugin->register_settings();
    // $plugin->key();
}

/**
 * Init the User Front Plugin.
 *
 * Init ClassAdmin,ClassFrontend and ClassAjax
 *
 * @since 1.0.0
 */
function wp_ds_plugin_init()
{
    if (defined('DOING_AJAX') && DOING_AJAX) {
        // error_log('.....ajax');
        $plugin3 = new ClassAjax();
    } else {
        $plugin = new ClassAdmin();
        $plugin->add_menu_setting();
        $plugin2 = new ClassFrontend();

        // $plugin2->add_menu_setting();
    }
}

/*
 * Register Classes
 *
 *  Register a PHP Class with Namespace
 *
 * @since 1.0.0
 * @param String $className
 */
spl_autoload_register(function (string $className) {
    if (false === strpos($className, 'WP\\Ds')) {
        return;
    }
    $className = str_replace('WP\\Ds\\', __DIR__.'/src/', $className);
    $classFile = str_replace('\\', '/', $className).'.php';
    require_once $classFile;
});
