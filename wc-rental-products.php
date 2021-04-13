<?php
/**
 * Plugin Name: Rental Equipment Custom Product Type
 * Description: Add support for rental equipment products
 */

if ( ! defined( 'ABSPATH' ) ) {
  return;
}

class WC_Rental_Products_Plugin {

  /**
   * Build the instance
   */

  public function __construct() {

    add_action( 'init', array( $this, 'load_plugin' ) );
    add_filter( 'product_type_selector', array( $this, 'add_simple_rental_product' ) );
    add_action( 'admin_footer', array( $this, 'simple_rental_custom_js' ) );
    add_filter( 'woocommerce_product_data_tabs', array( $this, 'custom_product_tabs' ) );
    add_action( 'woocommerce_product_data_panels', array( $this, 'rental_options_product_tab_content' ) );
    add_action( 'woocommerce_process_product_meta_simple_rental', array( $this, 'save_rental_options_fields' ) );



  }


  /**
  * Add Simple Rental to Product Type Dropdown
  */
  function add_simple_rental_product( $types ) {

    // Key should be exactly the same as in the class product_type parameter
    $types[ 'simple_rental' ] = __( 'Simple Rental' );

    return $types;

  }



  /**
  * Add custom tab for Rental Products only
  */
  function custom_product_tabs( $tabs ) {

    $tabs['rental'] = array(
      'label'   => __( 'Rental', 'woocommerce' ),
      'target'  => 'rental_options',
      'class'   => 'show_if_simple_rental'
    );

    return $tabs;

  }



  /**
  * Contents of the new Rental Products tab
  */
  function rental_options_product_tab_content() {

    global $post;

    ?>
    <div id='rental_options' class='panel woocommerce_options_panel'>

      <div class='options_group'>
      <?php

        woocommerce_wp_text_input( array(
          'id'            => '_4_hour_rate',
          'label'         => __( '4 Hour Rate', 'woocommerce' ),
          'type'          => 'text',
        ) );

        woocommerce_wp_text_input( array(
          'id'            => '_daily_rate',
          'label'         => __( 'Daily Rate', 'woocommerce' ),
          'type'          => 'text',
        ) );

        woocommerce_wp_text_input( array(
          'id'            => '_weekly_rate',
          'label'         => __( 'Weekly Rate', 'woocommerce' ),
          'type'          => 'text',
        ) );

        woocommerce_wp_text_input( array(
          'id'            => '_4_week_rate',
          'label'         => __( '4 Week Rate', 'woocommerce' ),
          'type'          => 'text',
        ) );

      ?>
      </div>

    </div>
    <?php

  }



  /**
  * Save the custom fields
  */
  function save_rental_options_fields( $post_id ) {

    if ( isset( $_POST['_4_hour_rate'] ) ) :
      update_post_meta( $post_id, '_4_hour_rate', sanitize_text_field( $_POST['_4_hour_rate'] ) );
    endif;

    if ( isset( $_POST['_daily_rate'] ) ) :
      update_post_meta( $post_id, '_daily_rate', sanitize_text_field( $_POST['_daily_rate'] ) );
    endif;

    if ( isset( $_POST['_weekly_rate'] ) ) :
      update_post_meta( $post_id, '_weekly_rate', sanitize_text_field( $_POST['_weekly_rate'] ) );
    endif;

    if ( isset( $_POST['_4_week_rate'] ) ) :
      update_post_meta( $post_id, '_4_week_rate', sanitize_text_field( $_POST['_4_week_rate'] ) );
    endif;

  }



  /**
  * Show pricing tab for simple_rental product
  */
  function simple_rental_custom_js() {

    if ( 'product' != get_post_type() ) :
      return;
    endif;

    ?>
    <script type='text/javascript'>
      jQuery( document ).ready( function() {
        //for General Tab
        jQuery( '.options_group.pricing' ).addClass( 'show_if_simple_rental' ).show();
        //for Inventory tab
        jQuery('.inventory_options').addClass('show_if_simple_rental').show();
      })
    </script>
    <?php

  }



  /**
   * Load WC Dependencies
   *
   * @return void
   */
  public function load_plugin() {
    require_once 'includes/class-wc-product-simple-rental.php';
    require_once 'includes/wc-product-simple-rental-functions.php';
  }
}

new WC_Rental_Products_Plugin();
