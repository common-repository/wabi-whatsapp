<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.wabi-app.com/
 * @since             1.0.0
 * @package           Wabi Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Wabi For Whatsapp
 * Plugin URI:        https://www.wabi-app.com
 * Description:       Wabi - "Click To Chat" via WhatsApp, for businesses who want to engage with their customers, and close more leads!
 * Version:           1.0.7
 * Author:            Wabi
 * Author URI:        http://www.wabi-app.com/
 * Text Domain:       wabiwidget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'WABI_WIDGET_FILE' ) ) {
    define( 'WABI_WIDGET_FILE', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-WabiWidget-activator.php
 */
function activate_wabiwidget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-WabiWidget-activator.php';
	WabiWidget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-WabiWidget-deactivator.php
 */
function deactivate_wabiwidget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-WabiWidget-deactivator.php';
	WabiWidget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wabiwidget' );
register_deactivation_hook( __FILE__, 'deactivate_wabiwidget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-WabiWidget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wabiwidget() {

	$plugin = new WabiWidget();
	$plugin->run();

}
run_wabiwidget();

