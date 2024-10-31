<?php

function add_scripts_to_proto_ai_commerce_plugin_page($hook) {
  if( 'toplevel_page_proto-ai-commerce-admin-page' != $hook )
    return;

  wp_register_style('proto_ai_top_level_page', plugins_url( '/css/proto_ai_top_level_plugin_page.css', __FILE__ ));
  wp_enqueue_style('proto_ai_top_level_page');
  # wp_enqueue_script('proto_ai_progress_bar_script', plugins_url( '/js/progress_bar.js', __FILE__ ));
}

function proto_ai_custom_menu_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

  $create_account_path = '/merchants/get-started/woo-commerce';
  $iframe = '&iframe=true';
  $wordpress_account_path = $create_account_path . "?site-domain=" . $_SERVER['SERVER_NAME'] . $iframe;

	?>

  <div class="embed-container">
    <iframe src="<?php echo esc_url(constant('PAIC_COMMERCE_DOMAIN') . $wordpress_account_path);?>" frameborder="0" allowfullscreen></iframe>
  </div>

	<?php
}

?>
