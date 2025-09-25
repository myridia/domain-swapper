<?php

/**
 * @see              https://domain-swapper.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Domain-swapper
 * Plugin URI: https://wordpress.org/plugins/domain-swapper
 * Description: Swap or change your Domains for one WordPress Site. So you can access one single WordPress site with different domains.
 * Version: 1.0.10
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
use WPDS\Ds\Main\ClassAdmin;
use WPDS\Ds\Main\ClassAjax;
use WPDS\Ds\Main\ClassFrontend;

/*
 * Constants Calls
 * @since 1.0.0 (if available)
 */
define('WPDS_OPTION', 'plugin_domain_swapper');

/*
 * Default Plugin activate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_activation_hook(__FILE__, ['WPDS\Ds\Main\ClassAdmin', 'activate']);

/*
 * Default Plugin deactivate hooks. Started as a static class functions
 *
 * @since 1.0.0 (if available)
 */
register_deactivation_hook(__FILE__, ['WPDS\Ds\Main\ClassAdmin', 'deactivate']);

// Register to start the Plugin

add_action('init', 'myridia_wpds_plugin_init', 80);
add_action('admin_init', 'myridia_wpds_plugin_admin_init', 99);

/**
 * Init the Admin Plugin .
 *
 * Init ClassAdmin and register the settings
 *
 * @since 1.0.0
 */
function myridia_wpds_plugin_admin_init()
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
function myridia_wpds_plugin_init()
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
    if (false === strpos($className, 'WPDS\\Ds')) {
        return;
    }
    $className = str_replace('WPDS\\Ds\\', __DIR__.'/src/', $className);
    $classFile = str_replace('\\', '/', $className).'.php';
    require_once $classFile;
});
