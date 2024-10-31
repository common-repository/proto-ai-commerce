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

require_once(constant('PAIC_PROTO_AI_LOCATION') . '/admin/no_woo_commerce/proto_ai_custom_menu_page.php');

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
