<?php

// Product Page
$page_hooks = Array('woocommerce_product_after_tabs',
                    'woocommerce_after_cart',
                    'woocommerce_after_checkout_form',
                    'woocommerce_order_details_after_customer_details',
                    'woocommerce_after_shop_loop');

foreach( $page_hooks as $page_hook ) {
  $option_key = 'proto_ai_' . $page_hook;

  if( get_option($option_key) ) {
    add_filter( $page_hook, function() use ($option_key) {
      $option_title = $option_key . '_title';
    	the_widget('proto_ai_recommendations_widget', array('title' => get_option($option_title)));
    }, 5);
  }
}
?>