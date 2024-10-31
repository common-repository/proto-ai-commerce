<?php

function proto_ai_view_details() {
  global $product;

	$regular_price = $product->get_regular_price();
	$sale_price = $product->get_sale_price();

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
		 'event_type' => 'ViewDetails',
		 'item_id' => $product->get_id(),
		 'product_name' => $product->get_title(),
		 'product_price' => (floatval($product->get_price()) + floatval($discount)),
		 'sku' => $product->get_sku()
	 );

	 array_push($details_array, $details);

  proto_ai_make_call($details_array);
}

?>