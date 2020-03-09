<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ingmmo.com
 * @since             1.0.0
 * @package           Mn_Charts
 *
 * @wordpress-plugin
 * Plugin Name:       wp-mn-charts
 * Plugin URI:        https://github.com/epocaricerca/wp-mn-charts
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Marco Montanari
 * Author URI:        https://ingmmo.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mn-charts
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
define( 'MN_CHARTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mn-charts-activator.php
 */
function activate_mn_charts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mn-charts-activator.php';
	Mn_Charts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mn-charts-deactivator.php
 */
function deactivate_mn_charts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mn-charts-deactivator.php';
	Mn_Charts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mn_charts' );
register_deactivation_hook( __FILE__, 'deactivate_mn_charts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mn-charts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mn_charts() {

	$plugin = new Mn_Charts();
	$plugin->run();

}
run_mn_charts();
