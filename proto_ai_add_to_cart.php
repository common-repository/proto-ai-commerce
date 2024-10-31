<?php

function proto_ai_add_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data) {
  $product = wc_get_product($product_id);

  if($variation_id == 0) {
    $item = $product;
  } else {
    $item = new WC_Product_Variation($variation_id);
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

  $details_array = array();
  $details = array(
     //'description' => $product->get_description(),
     'description' => "",
     'discount' => $discount,
     'event_type' => 'AddToCart',
     'item_id' => $product_id,
     'product_name' => $product->get_title(),
     'product_price' => (floatval($product->get_price()) + floatval($discount)),
     'sku' => $sku,
     'quantity' => $quantity
   );

   if ($variation_id != 0) {
     $details['product_id'] = $variation_id;
   }

   array_push($details_array, $details);

   proto_ai_make_call($details_array);

}

?>