<?php

/**
 * Hard Fork from https://wordpress.org/plugins/host-changer/.
 *
 * @see              https://domain-swapper.myridia.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Domain swapper - Use and change/swap multiple domains with one WordPress Site
 * Plugin URI: https://wordpress.org/plugins/domain-swapper
 * Description: domain_swapper to access same WordPress site from different domains.
 * Version: 1.0.0
 * Author: Myridia Company
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: domain_swapper
 * Domain Path: /languages
 * Author URI: http://domain-swapper.myridia.com
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
 * Get the metadata from the plugin header
 *
 * @since 1.0.0 (if available)
 */
$m_plugin_data = get_file_data(__FILE__, ['name' => 'Plugin Name', 'version' => 'Version', 'text_domain' => 'Text Domain', 'constant_prefix' => 'Constant Prefix', 'prefix' => 'Prefix', 'option_key' => 'Option_key']);

/*
 * Constants Calls
 *
 * @since 1.0.0 (if available)
 */
m_make_constants('NAME', $m_plugin_data['text_domain'], $m_plugin_data);
m_make_constants('DIR', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('BASE', plugin_basename(__FILE__), $m_plugin_data);
m_make_constants('URL', plugin_dir_url(__FILE__), $m_plugin_data);
m_make_constants('URI', plugin_dir_url(__FILE__), $m_plugin_data);
m_make_constants('PATH', plugin_dir_path(__FILE__), $m_plugin_data);
m_make_constants('SLUG', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('BASENAME', dirname(plugin_basename(__FILE__)), $m_plugin_data);
m_make_constants('VERSION', $m_plugin_data['version'], $m_plugin_data);
m_make_constants('TEXT', $m_plugin_data['text_domain'], $m_plugin_data);
m_make_constants('PREFIX', $m_plugin_data['prefix'], $m_plugin_data);
m_make_constants('OPTION', $m_plugin_data['option_key'], $m_plugin_data);

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
register_deactivation_hook(__FILE__, ['WP\Ds\Main\ClassFrontend', 'deactivate']);

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
        error_log('.....ajax');
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

/*
 * Create Constants
 *
 *  Create in a compact way all Constants used for the Plugin.
 *
 * @since 1.0.0
 * @param String $className
 */
function m_make_constants($name, $value, $pdata)
{
    $prefix = $pdata['constant_prefix'];
    $c_name = $prefix.$name;
    // echo $c_name.' : '.$value.' <br>';
    if (!defined($c_name)) {
        define($c_name, $value);
    }
}
