<?php

function proto_ai_make_call($details_array) {
	global $wp;
	$user_agent = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
	$current_url = wp_get_referer();

	$data = array(
		'event_uri' => $current_url,
		'visit_id' => proto_ai_visit_id(),
		'details' => $details_array,
		'user_agent' => $user_agent
	);

	# Convert $data into query parameters
	$query_params = http_build_query($data);

	# Preparing HTTP call with query parameters attached to the URL
	$url = constant('PAIC_API_DOMAIN') . constant('PAIC_API_BASE_PATH') . '/event?' . $query_params;
	$headers = array(
			'Authorization' => 'Bearer ' . proto_ai_token(),
			'Store-Server-Name' => sanitize_url($_SERVER['SERVER_NAME'])
	);

  $response = wp_remote_request( $url, [
    'method' => 'GET',
    'headers' => $headers
  ] );
}

function proto_ai_token() {
	$headerCookies = explode('; ', getallheaders()['Cookie']);
	$cookies = array();
	$proto_ai_token = null;

	if (!isset($_COOKIE['proto_ai_token'])) {
		foreach($headerCookies as $itm) {
			list($key, $val) = explode('=', $itm, 2);
			if($key == 'proto_ai_token') {
				$proto_ai_token = $val;
			}
			$cookies[$key] = $val;
	}
	} else {
			$proto_ai_token = $_COOKIE['proto_ai_token'];
	}

	return $proto_ai_token;
}

function proto_ai_visit_id() {
	$headerCookies = explode('; ', getallheaders()['Cookie']);
	$cookies = array();
	$proto_ai_token = null;

	if (!isset($_COOKIE['proto_ai_visit_id'])) {
		foreach($headerCookies as $itm) {
			list($key, $val) = explode('=', $itm, 2);
			if($key == 'proto_ai_visit_id') {
				$proto_ai_visit_id = $val;
			}
			$cookies[$key] = $val;
	}
	} else {
			$proto_ai_visit_id = $_COOKIE['proto_ai_visit_id'];
	}

	return $proto_ai_visit_id;
}


?>
