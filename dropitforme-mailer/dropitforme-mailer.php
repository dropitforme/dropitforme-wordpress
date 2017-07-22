<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://dropitforme.com
 * @since             1.0.0
 * @package           Dropitforme_Wordpress
 *
 * @wordpress-plugin
 * Plugin Name:       Drop It For Me Mail Delivery Service Plugin
 * Plugin URI:        https://dropitforme.com/dropitforme-wordpress
 * Description:       No longer do you have to worry about your message being delivered! No SMTP port blocking issues! (Sorry GoDaddy, Google Cloud). Simple, cheap, and elegant! DKIM/SPF/DMARC compliant!
 * Version:           1.0.0
 * Author:            Drop It For Me Mail Delivery Service
 * Author URI:        http://dropitforme.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dropitforme-wordpress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dropitforme-wordpress-activator.php
 */
function activate_dropitforme_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropitforme-wordpress-activator.php';
	Dropitforme_Wordpress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dropitforme-wordpress-deactivator.php
 */
function deactivate_dropitforme_wordpress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dropitforme-wordpress-deactivator.php';
	Dropitforme_Wordpress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dropitforme_wordpress' );
register_deactivation_hook( __FILE__, 'deactivate_dropitforme_wordpress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dropitforme-wordpress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dropitforme_wordpress() {

	$plugin = new Dropitforme_Wordpress();
	$plugin->run();

}
run_dropitforme_wordpress();
