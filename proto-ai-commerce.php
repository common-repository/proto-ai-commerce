<?php
/**
 * Proto AI Commerce
 *
 * Plugin Name: Proto AI Commerce
 * Plugin URI:  https://www.proto.ai/proto-ai-commerce-for-wordpress/
 * Description: Industry-leading AI-driven recommendation engine
 * Version:     0.3.4
 * Author:      Proto AI
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: proto-ai-commerce
 *
 * Copyright 2023, Proto AI LLC.
 *
 * Proto AI Commerce is free software: you can redistribute it and/or modify it under the terms of the GNU General
 * Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.
 *
 * Proto AI Commerce is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with Proto AI Commerce. If not, see
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
 *
 */

/* exist if directly accessed */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php') ) {
  // Do what you want in case woocommerce is installed
	define( 'PAIC_WOO_COMMERCE_PLUGIN_INSTALLED', true );
} else {
	define( 'PAIC_WOO_COMMERCE_PLUGIN_INSTALLED', false );
}
// define variable for path to this plugin file.
define( 'PAIC_PROTO_AI_LOCATION', dirname( __FILE__ ) );
define( 'PAIC_API_BASE_PATH', "/api/v1" );
define( 'PAIC_LOGO_URL', plugin_dir_url( __FILE__ ) . 'admin/images/proto-ai-logo.png' );
define( 'PAIC_ICON_URL', plugin_dir_url( __FILE__ ) . 'images/proto-ai-icon.png' );
######################## Environment dependent variables ########################
define( 'PAIC_API_DOMAIN', "https://api.proto.ai" );
define( 'PAIC_COMMERCE_DOMAIN', "https://commerce.proto.ai" );
define( 'PAIC_ENVIRONMENT', 'production' );
######################## Environment dependent variables ########################

// Add options
if(constant('PAIC_WOO_COMMERCE_PLUGIN_INSTALLED')) {
	function proto_ai_inline_script() {
		try {
			echo '<script type="text/javascript">';
			echo ("window.protoAICurrentCurrencySymbol = '" . html_entity_decode(get_woocommerce_currency_symbol()) . "';");
			echo ("window.protoAICurrentCurrencyIsoCode = '" . html_entity_decode(get_woocommerce_currency()) . "';");
			echo '</script>';
		} catch(Exception $e) {
			error_log($e->getMessage());
			echo "<!-- Error adding the drawer -->";
		}
	}

	add_action('wp_print_scripts', 'proto_ai_inline_script', 10);
}

add_action('wp_enqueue_scripts', function() {
	/* The following code is defined in js/proto-ai-header-functions.js
	  It provides functions for:

	  - API Authorization
	  - Generation of session id
	  - Generation of visit id
	*/

	wp_enqueue_script('proto-ai-common-scripts', 'https://scripts-commerce.proto.ai/' . constant('PAIC_ENVIRONMENT') . '/commerce-common-files/proto-ai-common-scripts-min.js');
	wp_enqueue_script('proto-ai-header-functions', plugins_url( '/js/proto-ai-header-functions.js', __FILE__ ));

	wp_enqueue_style( 'prefix-style' );
});

require_once('proto_ai_recommendations.php');

// When woo commerce is installed on the Wordpress site, the plugin will import them to the Proto database
// in order to empower the recommendation engine and learn from the visitors activity.
// If woo commerce is not installed, we just give the option to display recommendations from a different
// ecommerce Engine. i.e: Shopify

if(constant('PAIC_WOO_COMMERCE_PLUGIN_INSTALLED')) {
	require_once('proto_ai_global_functions.php');

	// ******************** Event Tracking functions *************************
	require_once('proto_ai_add_to_cart.php');
	require_once('proto_ai_remove_from_cart.php');
	require_once('proto_ai_cart_update.php');
	require_once('proto_ai_checkout.php');
	require_once('proto_ai_purchase.php');
	require_once('proto_ai_view_details.php');
	// ******************** End Event Tracking functions *************************

	// Automatically injects recommendations on every woo commerce page
	require_once('proto_ai_recommendations_injector.php');
	require_once('proto_ai_admin_menu.php');

	// Creates shortcuts and pages for the admin panel
	require_once('admin/proto_ai_custom_menu_page.php');

	// ******************** Event Tracking Hooks *************************
	// Add to cart tracking
	add_action( 'woocommerce_add_to_cart', 'proto_ai_add_to_cart', 5, 6 );
	// Remove from cart tracking
	add_action( 'woocommerce_remove_cart_item', 'proto_ai_remove_from_cart', 5, 2 );
	// Cart Update
	add_action( 'woocommerce_update_cart_action_cart_updated', 'proto_ai_cart_update', 20, 1 );
	// Checkout tracking
	add_action( 'woocommerce_before_checkout_form', 'proto_ai_checkout', 5, 0 );
	// Purchase tracking
	add_action( 'woocommerce_order_status_processing', 'proto_ai_purchase', 5, 1 );
	// Refund tracking
	add_action( 'woocommerce_order_status_refunded', 'proto_ai_refund', 5, 1 );
	// ViewDetails
	add_action( 'woocommerce_before_single_product', 'proto_ai_view_details', 5, 0 );
	// ******************** End Event Tracking Hooks *************************

	//Remove related products output
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	// The following code is to enable the oauth authentication between our site and WooCommerce.
	// We need it because some Wordpress plugins strip out the Authorization header.
	register_activation_hook( __FILE__, 'proto_ai_commerce_function_to_run' );


	function proto_ai_commerce_function_to_run() {
		// Get path to main .htaccess for WordPress
		$htaccess = get_home_path().".htaccess";

		$lines = array();
		$lines[] = "SetEnvIf Authorization (.+) HTTP_AUTHORIZATION=$1";

		insert_with_markers($htaccess, "ProtoAICommerce", $lines);
	};
} else {

	require_once('no_woo_commerce/proto_ai_admin_menu.php');
	// Creates shortcuts and pages for the admin panel
	require_once('admin/no_woo_commerce/proto_ai_custom_menu_page.php');
}

// Registers the widget so the user can add it to the layout
add_action( 'widgets_init', function(){
	// Register and load the widget
	register_widget( 'proto_ai_recommendations_widget');
} );

?>
