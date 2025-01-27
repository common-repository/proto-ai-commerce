<?php

function proto_ai_remove_from_cart( $cart_item_key, $cart ) {
  error_log('Cart Item Key: '.print_r($cart_item_key, true));
  error_log('Cart: '.print_r($cart, true));
  $item = $cart->get_cart_item( $cart_item_key );
  $product_id = $item['product_id'];
  $variation_id = $item['variation_id'];
  $product = wc_get_product($product_id);

  if($variation_id == 0) {
    $item = $product;
  } else {
    $item = new WC_Product_Variation($variation_id);
  }

  error_log('item: '.print_r($item, true));

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

  $details_array = array();
  $details = array(
     //'description' => $product->get_description(),
     'description' => "",
     'discount' => $discount,
     'event_type' => 'RemoveFromCart',
     'item_id' => $product_id,
     'product_name' => $product->get_title(),
		 'product_price' => (floatval($product->get_price()) + floatval($discount)),
     'sku' => $sku
   );

   if ($variation_id != 0) {
    $details['product_id'] = $variation_id;
   }

  array_push($details_array, $details);

  proto_ai_make_call($details_array);
}

?>