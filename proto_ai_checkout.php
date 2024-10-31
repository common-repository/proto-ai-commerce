<?php

function proto_ai_checkout() {
  global $woocommerce;
  $items = $woocommerce->cart->get_cart();
  $details_array = array();

  foreach($items as $checkout_item => $values) {
      $product = wc_get_product($values['product_id']);
      $quantity = $values['quantity'];

      if($values['variation_id'] == 0) {
        $item = $product;
      } else {
        $item = new WC_Product_Variation($values['variation_id']);
      }

      $sku = $item->get_sku();
      $regular_price = $item->get_regular_price();
      error_log('$regular_price: '.print_r($regular_price, true));
      $sale_price = $item->get_sale_price();
      error_log('$sale_price: '.print_r(floatval($sale_price), true));

      if( floatval($sale_price) == 0 ) {
        $discount = 0;
      } else {
        $discount = floatval($regular_price) - floatval($sale_price);
      }

      $details = array(
         //'description' => $product->get_description(),
         'description' => "",
         'discount' => $discount,
         'event_type' => 'Checkout',
         'item_id' => $values['product_id'],
         'product_name' => $product->get_title(),
         'product_price' => (floatval($product->get_price()) + floatval($discount)),
         'sku' => $sku,
         'quantity' => $quantity,
         'transaction_amount' => ($quantity * $item->get_price())
       );

       if ($values['variation_id'] != 0) {
         $details['product_id'] = $values['variation_id'];
       }

      array_push($details_array, $details);
  }

  proto_ai_make_call($details_array);
}

?>