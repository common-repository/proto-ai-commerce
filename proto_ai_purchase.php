<?php

function proto_ai_purchase($order_id) {
  try{
    $order = new WC_Order( $order_id );
    $purchased_items = $order->get_items();
    $details_array = array();

    foreach ( $purchased_items as $purchased_item ) {
        $quantity = $purchased_item['quantity'];
        $detail = proto_ai_purchase_with_quantity($purchased_item, $quantity);
        array_push($details_array, $detail);
    }

    proto_ai_make_call($details_array);
  } catch (Exception $e) {
    error_log("Proto AI - Error: ".print_r($e, true));
  }
}


function proto_ai_refund($order_id) {
  $order = new WC_Order( $order_id );
  $purchased_items = $order->get_items();
  $details_array = array();

  foreach ( $purchased_items as $purchased_item ) {
      $detail = proto_ai_purchase_with_quantity($purchased_item, $quantity);
      array_push($details_array, 0); // Because it's a refund
  }

  proto_ai_make_call($details_array);
}

function proto_ai_purchase_with_quantity($purchased_item, $quantity) {
  $product_id = $purchased_item['product_id'];
  $product_variation_id = $purchased_item['variation_id'];
  $product = wc_get_product($product_id);


  if($product_variation_id == 0) {
    $item = $product;
  } else {
    $item = new WC_Product_Variation($product_variation_id);
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
     'event_type' => 'Purchase',
     'item_id' => $product_id,
     'product_name' => $product->get_title(),
     'product_price' => (floatval($product->get_price()) + floatval($discount)),
     'sku' => $sku,
     'quantity' => $quantity,
     'transaction_amount' => ($quantity * $item->get_price())
   );

   if ($product_variation_id != 0) {
     $details['product_id'] = $product_variation_id;
   } else {
     $details['product_id'] = $product_id;
   }

  return $details;
}

?>