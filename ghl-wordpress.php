<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.ibsofts.com
 * @since             1.0.0
 * @package           Ghl_Wordpress
 *
 * @wordpress-plugin
 * Plugin Name:       Go High Level (GHL) for WordPress
 * Plugin URI:        https://www.ibsofts.com
 * Description:       Integration with Go High Level
 * Version:           1.0.0
 * Author:            iB Softs
 * Author URI:        https://www.ibsofts.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ghl-wordpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GHL_WORDPRESS_VERSION', '1.0.0' );

/**
 * The class responsible for defining all actions that relates to database query
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ghl-wordpress-query.php';

/**
 * The class responsible for defining all constants
 */
require_once plugin_dir_path( __FILE__ ) . 'definition.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ghl-wordpress-activator.php
 */
function activate_ghl_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ghl-wordpress-activator.php';
	Ghl_Wordpress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ghl-wordpress-deactivator.php
 */
function deactivate_ghl_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ghl-wordpress-deactivator.php';
	Ghl_Wordpress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ghl_wordpress' );
register_deactivation_hook( __FILE__, 'deactivate_ghl_wordpress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ghl-wordpress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ghl_wordpress() {

	$plugin = new Ghl_Wordpress();
	$plugin->run();

}
run_ghl_wordpress();
