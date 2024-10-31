<?php

class proto_ai_recommendations_widget extends WP_Widget {
  function __construct() {
    parent::__construct(
      // Base ID of your widget
      'proto_ai_recommendations_widget',

      // Widget name will appear in UI
      __('Proto AI Recommendations Widget', 'proto_ai_recommendations_widget_domain'),

      // Widget description
      array( 'description' => __( 'Product recommendations empowered by the Proto AI recommendation engine', 'proto_ai_recommendations_widget_domain' ), )
    );
  }

  // Creating widget front-end

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // This is where you run the code and display the output
    ?>
      <div class="proto-recommendations-element">
        <div class='proto-grid-uniform proto-ai-product-recommendations <?php echo esc_attr($widget_class); ?>'
            data-currency-symbol='<?php echo html_entity_decode(get_woocommerce_currency_symbol()); ?>'
            data-currency-iso-code='<?php echo html_entity_decode(get_woocommerce_currency()); ?>'
            data-number-of-recommendations='<?php echo esc_attr($instance['number_of_recommendations']); ?>'
            data-product-title-font='<?php echo esc_attr($instance['product_title_font']); ?>'
            data-product-title-alignment='<?php echo esc_attr($instance['product_title_alignment']); ?>'
            data-product-title-font-size='<?php echo esc_attr($instance['product_title_font_size']); ?>'
            data-product-price-font-size='<?php echo esc_attr($instance['product_price_font_size']); ?>'
            data-product-price-alignment='<?php echo esc_attr($instance['product_price_alignment']); ?>'>
        </div>
      </div>
    <?php
    echo $args['after_widget'];
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'Recommendations', 'proto_ai_recommendations_widget_domain' );
    }

    if ( isset( $instance[ 'number_of_recommendations' ] ) ) {
      $number_of_recommendations = __($instance[ 'number_of_recommendations' ], 'proto_ai_recommendations_widget_domain');
    }
    else {
      $number_of_recommendations = __( 'none', 'proto_ai_recommendations_widget_domain' );
    }

    if ( isset( $instance[ 'product_title_font' ] ) ) {
      $product_title_font = __($instance[ 'product_title_font' ], 'proto_ai_recommendations_widget_domain');
    }
    else {
      $product_title_font = __( 'none', 'proto_ai_recommendations_widget_domain' );
    }

    if ( isset( $instance[ 'product_title_alignment' ] ) ) {
      $product_title_alignment = __($instance[ 'product_title_alignment' ], 'proto_ai_recommendations_widget_domain');
    }
    else {
      $product_title_alignment = __( 'none', 'proto_ai_recommendations_widget_domain' );
    }

    if ( isset( $instance[ 'product_title_font_size' ] ) ) {
      $product_title_font_size = __($instance[ 'product_title_font_size' ], 'proto_ai_recommendations_widget_domain');
    }
    else {
      $product_title_font_size = __( 'none', 'proto_ai_recommendations_widget_domain' );
    }

    if ( isset( $instance[ 'product_price_font_size' ] ) ) {
      $product_price_font_size = __($instance[ 'product_price_font_size' ], 'proto_ai_recommendations_widget_domain');
    }
    else {
      $product_price_font_size = __( 'none', 'proto_ai_recommendations_widget_domain' );
    }

    if ( isset( $instance[ 'product_price_alignment' ] ) ) {
      $product_price_alignment = __($instance[ 'product_price_alignment' ], 'proto_ai_recommendations_widget_domain');
    }
    else {
      $product_price_alignment = __( 'none', 'proto_ai_recommendations_widget_domain' );
    }

    // Widget admin form
    ?>
    <p>
    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>

    <p>
    <label for="<?php echo esc_attr($this->get_field_id('number_of_recommendations')); ?>"><?php _e('Number of recommendations:'); ?></label>
    <select id="<?php echo esc_attr($this->get_field_id('number_of_recommendations')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_recommendations')); ?>" class="widefat" style="width:100%;">
      <option <?php selected( $instance['number_of_recommendations'], 'none'); ?> value="none">None</option>
      <option <?php selected( $instance['number_of_recommendations'], '2'); ?> value="2">2</option>
      <option <?php selected( $instance['number_of_recommendations'], '3'); ?> value="3">3</option>
      <option <?php selected( $instance['number_of_recommendations'], '4'); ?> value="4">4</option>
      <option <?php selected( $instance['number_of_recommendations'], '5'); ?> value="5">5</option>
    </select>
    </p>

    <hr />
    <h5>PRODUCT TITLE</h5>

    <p>
    <label for="<?php echo esc_attr($this->get_field_id('product_title_font')); ?>"><?php _e('Font:'); ?></label>
    <select id="<?php echo esc_attr($this->get_field_id('product_title_font')); ?>" name="<?php echo esc_attr($this->get_field_name('product_title_font')); ?>" class="widefat" style="width:100%;">
      <option <?php selected( $instance['product_title_font'], 'none'); ?> value="none">None</option>
      <option <?php selected( $instance['product_title_font'], 'inherit'); ?> value="inherit">Inherit</option>
      <option <?php selected( $instance['product_title_font'], 'Arial'); ?> value="Arial">Arial</option>
      <option <?php selected( $instance['product_title_font'], 'Verdana'); ?> value="Verdana">Verdana</option>
      <option <?php selected( $instance['product_title_font'], 'Tahoma'); ?> value="Tahoma">Tahoma</option>
      <option <?php selected( $instance['product_title_font'], 'Trebuchet MS'); ?> value="Trebuchet MS">Trebuchet MS</option>
      <option <?php selected( $instance['product_title_font'], 'Times New Roman'); ?> value="Times New Roman">Times New Roman</option>
      <option <?php selected( $instance['product_title_font'], 'Georgia'); ?> value="Georgia">Georgia</option>
      <option <?php selected( $instance['product_title_font'], 'Garamond'); ?> value="Garamond">Garamond</option>
      <option <?php selected( $instance['product_title_font'], 'Courier New'); ?> value="Courier New">Courier New</option>
      <option <?php selected( $instance['product_title_font'], 'Brush Script MT'); ?> value="Brush Script MT">Brush Script MT</option>
    </select>
    </p>

    <p>
    <label for="<?php echo esc_attr($this->get_field_id('product_title_alignment')); ?>"><?php _e('Alignment:'); ?></label>
    <select id="<?php echo esc_attr($this->get_field_id('product_title_alignment')); ?>" name="<?php echo esc_attr($this->get_field_name('product_title_alignment')); ?>" class="widefat" style="width:100%;">
      <option <?php selected( $instance['product_title_alignment'], 'none'); ?> value="none">None</option>
      <option <?php selected( $instance['product_title_alignment'], 'left'); ?> value="left">Left</option>
      <option <?php selected( $instance['product_title_alignment'], 'center'); ?> value="center">Center</option>
      <option <?php selected( $instance['product_title_alignment'], 'right'); ?> value="right">Right</option>
    </select>
    </p>

    <p>
    <label for="<?php echo esc_attr($this->get_field_id('product_title_font_size')); ?>"><?php _e('Size:'); ?></label>
    <select id="<?php echo esc_attr($this->get_field_id('product_title_font_size')); ?>" name="<?php echo esc_attr($this->get_field_name('product_title_font_size')); ?>" class="widefat" style="width:100%;">
      <option <?php selected( $instance['product_title_font_size'], 'none'); ?> value="none">None</option>
      <option <?php selected( $instance['product_title_font_size'], 'inherit'); ?> value="inherit">inherit</option>
      <option <?php selected( $instance['product_title_font_size'], 'initial'); ?> value="initial">initial</option>
      <option <?php selected( $instance['product_title_font_size'], 'large'); ?> value="large">large</option>
      <option <?php selected( $instance['product_title_font_size'], 'medium'); ?> value="medium">medium</option>
      <option <?php selected( $instance['product_title_font_size'], 'small'); ?> value="small">small</option>
      <option <?php selected( $instance['product_title_font_size'], 'x-large'); ?> value="x-large">x-large</option>
      <option <?php selected( $instance['product_title_font_size'], 'x-small'); ?> value="x-small">x-small</option>
      <option <?php selected( $instance['product_title_font_size'], 'xx-small'); ?> value="xx-small">xx-small</option>
    </select>
    </p>

    <hr />
    <h5>PRODUCT PRICE</h5>

    <p>
    <label for="<?php echo esc_attr($this->get_field_id('product_price_alignment')); ?>"><?php _e('Alignment:'); ?></label>
    <select id="<?php echo esc_attr($this->get_field_id('product_price_alignment')); ?>" name="<?php echo esc_attr($this->get_field_name('product_price_alignment')); ?>" class="widefat" style="width:100%;">
      <option <?php selected( $instance['product_price_alignment'], 'none'); ?> value="none">None</option>
      <option <?php selected( $instance['product_price_alignment'], 'left'); ?> value="left">Left</option>
      <option <?php selected( $instance['product_price_alignment'], 'center'); ?> value="center">Center</option>
      <option <?php selected( $instance['product_price_alignment'], 'right'); ?> value="right">Right</option>
    </select>
    </p>

    <p>
    <label for="<?php echo esc_attr($this->get_field_id('product_price_font_size')); ?>"><?php _e('Size:'); ?></label>
    <select id="<?php echo esc_attr($this->get_field_id('product_price_font_size')); ?>" name="<?php echo esc_attr($this->get_field_name('product_price_font_size')); ?>" class="widefat" style="width:100%;">
      <option <?php selected( $instance['product_price_font_size'], 'none'); ?> value="none">None</option>
      <option <?php selected( $instance['product_price_font_size'], 'inherit'); ?> value="inherit">inherit</option>
      <option <?php selected( $instance['product_price_font_size'], 'initial'); ?> value="initial">initial</option>
      <option <?php selected( $instance['product_price_font_size'], 'large'); ?> value="large">large</option>
      <option <?php selected( $instance['product_price_font_size'], 'medium'); ?> value="medium">medium</option>
      <option <?php selected( $instance['product_price_font_size'], 'small'); ?> value="small">small</option>
      <option <?php selected( $instance['product_price_font_size'], 'x-large'); ?> value="x-large">x-large</option>
      <option <?php selected( $instance['product_price_font_size'], 'x-small'); ?> value="x-small">x-small</option>
      <option <?php selected( $instance['product_price_font_size'], 'xx-small'); ?> value="xx-small">xx-small</option>
    </select>
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['number_of_recommendations'] = ( ! empty( $new_instance['number_of_recommendations'] ) ) ? $new_instance['number_of_recommendations'] : 'none';
    $instance['product_title_font'] = ( ! empty( $new_instance['product_title_font'] ) ) ? $new_instance['product_title_font'] : 'none';
    $instance['product_title_alignment'] = ( ! empty( $new_instance['product_title_alignment'] ) ) ? $new_instance['product_title_alignment'] : 'none';
    $instance['product_title_font_size'] = ( ! empty( $new_instance['product_title_font_size'] ) ) ? $new_instance['product_title_font_size'] : 'none';
    $instance['product_price_alignment'] = ( ! empty( $new_instance['product_price_alignment'] ) ) ? $new_instance['product_price_alignment'] : 'none';
    $instance['product_price_font_size'] = ( ! empty( $new_instance['product_price_font_size'] ) ) ? $new_instance['product_price_font_size'] : 'none';
    return $instance;
  }

  // public function proto_ai_recommendations_widget_output() {
  //   'Hello World'
  // }

// Class proto_ai_recommendations_widget ends here
}

?>
