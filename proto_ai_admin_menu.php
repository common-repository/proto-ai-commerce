<?php

add_shortcode( 'proto_ai_recommendations', 'shortcode_for_proto_ai_recommendations_widget' );

function shortcode_for_proto_ai_recommendations_widget( $atts ) {
	ob_start();
  $title = 'Recommendations';
  $number_of_recommendations = 'none';
  $product_title_font = 'none';
  $product_title_alignment = 'none';
  $product_title_font_size = 'none';
  $product_price_alignment = 'none';
  $product_price_font_size = 'none';

  try {
    if(is_array($atts)) {
      $title = $atts['title'];
      $number_of_recommendations = $atts['number_of_recommendations'];
      $product_title_font = $atts['product_title_font'];
      $product_title_alignment = $atts['product_title_alignment'];
      $product_title_font_size = $atts['product_title_font_size'];
      $product_price_alignment = $atts['product_price_alignment'];
      $product_price_font_size = $atts['product_price_font_size'];
    }
  }
  catch (TypeError $e) {
    // exception is raised and it'll be handled here
    // $e->getMessage() contains the error message
  }

  the_widget('proto_ai_recommendations_widget', array('title' => $title,
             'number_of_recommendations' => $number_of_recommendations, 
             'product_title_font' => $product_title_font,
             'product_title_alignment' => $product_title_alignment,
             'product_title_font_size' => $product_title_font_size,
             'product_price_alignment' => $product_price_alignment,
             'product_price_font_size' => $product_price_font_size));
	$output = ob_get_clean();
	return $output;
}

/**
 * Register a custom menu page.
 */
function proto_ai_register_custom_menu_page() {
     add_menu_page(
       __( 'Proto AI Commerce', 'textdomain' ),
       'Proto AI Commerce',
       'manage_options',
       'proto-ai-commerce-admin-page',
       'proto_ai_custom_menu_page',
       constant('PAIC_ICON_URL'),
       53
   );
}

add_action( 'admin_enqueue_scripts', 'add_scripts_to_proto_ai_commerce_plugin_page' );
add_action( 'admin_menu', 'proto_ai_register_custom_menu_page' );
add_action( 'admin_init', 'register_proto_ai_settings' );

function init_proto_ai_option($option_name) {
	$option_name_title = $option_name . '_title';

	if ( get_option( $option_name ) === false ) {
		update_option( $option_name, 'on' );
		error_log("Created option " . $option_name . print_r(get_option( $option_name ), true));
	} else {
		error_log("Found option " . $option_name . print_r(get_option( $option_name ), true));
	}

	if ( get_option( $option_name_title ) === false ) {
		update_option( $option_name_title, 'Recommendations' );
		error_log("Created option " . $option_name_title . print_r(get_option( $option_name_title ), true));
	} else {
		error_log("Found option " . $option_name_title . print_r(get_option( $option_name_title ), true));
	}


	register_setting( 'proto-ai-settings-group', $option_name, Array("default" => 'on') );

	register_setting( 'proto-ai-settings-group', $option_name_title , Array("default" => 'Recommendations'));

	// error_log("Found options: " . print_r(get_alloptions(), true));
}

function register_proto_ai_settings() { // whitelist options

	$settings = Array('proto_ai_woocommerce_after_shop_loop',
	                    'proto_ai_woocommerce_product_after_tabs',
	                    'proto_ai_woocommerce_after_cart',
	                    'proto_ai_woocommerce_after_checkout_form',
	                    'proto_ai_woocommerce_order_details_after_customer_details');


	foreach( $settings as $setting ) {
		init_proto_ai_option($setting);
	}

  add_settings_section(
    'proto_ai_woocommerce_recommendations', // ID
    'Recommendations display', // Title
    'proto_ai_print_section_info_callback', // Callback
    'proto-ai-settings-page' // Page
  );

	add_settings_field(
          'proto_ai_woocommerce_after_shop_loop', // ID
          'Category page', // Title
          'proto_ai_recommendations_category_page_callback', // Callback
          'proto-ai-settings-page', // Page
          'proto_ai_woocommerce_recommendations' // Section
      );

  add_settings_field(
           'proto_ai_recommendations_on_product_page', // ID
           'Product page', // Title
           'proto_ai_recommendations_on_product_page_callback', // Callback
           'proto-ai-settings-page', // Page
           'proto_ai_woocommerce_recommendations' // Section
       );

 add_settings_field(
          'proto_ai_recommendations_on_cart_page', // ID
          'Cart page', // Title
          'proto_ai_recommendations_on_cart_page_callback', // Callback
          'proto-ai-settings-page', // Page
          'proto_ai_woocommerce_recommendations' // Section
      );

  add_settings_field(
           'proto_ai_woocommerce_after_checkout_form', // ID
           'Checkout page', // Title
           'proto_ai_recommendations_on_checkout_page_callback', // Callback
           'proto-ai-settings-page', // Page
           'proto_ai_woocommerce_recommendations' // Section
       );

  add_settings_field(
          'proto_ai_woocommerce_after_order_confirmed_form', // ID
          'Order confirmed page', // Title
          'proto_ai_recommendations_order_confirmed_page_callback', // Callback
          'proto-ai-settings-page', // Page
          'proto_ai_woocommerce_recommendations' // Section
      );

  // register_setting( 'proto-ai-settings-group', 'some_other_option' );
  // register_setting( 'proto-ai-settings-group', 'option_etc' );
}

/**
 * Print the Section text
 */
function proto_ai_print_section_info_callback()
{
    print 'Check the pages where the Proto AI recommendations should be automatically injected:';
}

function proto_ai_recommendations_on_product_page_callback()
{
  proto_ai_options_callback('proto_ai_woocommerce_product_after_tabs');
}

function proto_ai_recommendations_on_cart_page_callback()
{
  proto_ai_options_callback('proto_ai_woocommerce_after_cart');
}

function proto_ai_recommendations_on_checkout_page_callback()
{
  proto_ai_options_callback('proto_ai_woocommerce_after_checkout_form');
}

function proto_ai_recommendations_order_confirmed_page_callback()
{
  proto_ai_options_callback('proto_ai_woocommerce_order_details_after_customer_details');
}

function proto_ai_recommendations_category_page_callback()
{
  proto_ai_options_callback('proto_ai_woocommerce_after_shop_loop');
}

function proto_ai_options_callback($option_key) {
  $option = get_option( $option_key );
  $title = get_option( $option_key . '_title' );

  $html  = '<input type="checkbox" id="' . $option_key . '" name="' . $option_key . '" ' . checked('on', $option, false) . ' />';
  $html .= '<label for="' . $option_key . '">Enabled</label>';
  $html .= '<br />';
  $html .= '<br />';
	$html .= '<label for="' . $option_key . '"> <b>Title</b> </label>';
  $html .= '<input type="text" id="' . $option_key . '_title" style="width: 50%" name="' . $option_key . '_title" value="' . $title . '" />';

	echo $html;
}


function proto_ai_my_settings_page()
{
	add_submenu_page(
		'proto-ai-commerce-admin-page', // top level menu page
		'Proto AI Settings Page', // title of the settings page
		'Settings', // title of the submenu
		'manage_options', // capability of the user to see this page
		'proto-ai-settings-page', // slug of the settings page
		'proto_ai_settings_page_html' // callback function when rendering the page
	);
}
add_action('admin_menu', 'proto_ai_my_settings_page');

function proto_ai_settings_page_html() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	?>
		<div class="wrap">
			<h1>Settings</h1>

		</div>

    <form method="post" action="options.php">
      <?php settings_fields( 'proto-ai-settings-group' ); ?>
      <?php do_settings_sections( 'proto-ai-settings-page' ); ?>

      <?php submit_button(); ?>

    </form>
	<?php
}

?>
