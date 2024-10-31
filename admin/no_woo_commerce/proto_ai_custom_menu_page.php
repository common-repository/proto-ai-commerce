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

	?>

    <!-- Vertical Steppers -->
    <div>
      <img src="<?php echo constant('PAIC_LOGO_URL'); ?>" />
      <p>
        Thanks for installing the Proto AI Commerce plugin for Wordpress. You need to have at least one active store with Proto AI Commerce in order to use this plugin.
      </p>

      <br />

      <h2> Looks like you are all set! </h2>
      <p>
        You can start inserting recommendations on all your pages. Here is how:
      </p>

      <ul class="stepper stepper-vertical">

        <li class="active">
          <div class='step'>
            <span class="circle">A</span>
            <span class="label">Using shortcodes</span>

            <ul>
              <li class="active">
                <div class='step'>
                  <span class="label ml"><em>Example: [proto_ai_recommendations title='You might like']</em></span>
                </div>
              </li>
            </ul>
          </div>
        </li>

        <li class="active">
          <div class='step'>
            <span class="circle">B</span>
            <span class="label">Adding the Proto AI Widget widget.</span>
            <br />

            <ul>
              <li class="active">
                <div class='step'>
                  <span class="label ml"><em>Appereance > Widgets</em></span>
                </div>
              </li>
            </ul>

          </div>
        </li>

      </ul>

    </div>

	<?php
}

?>
