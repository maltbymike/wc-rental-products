<?php

/*
* Remove subcategories from main loop and display them in a seperate loop
*/

function irent_show_product_subcategories( $args = array() ) {
    $parentid = get_queried_object_id();

    $args = array(
     'parent_id' => $parentid
    );

    wc_get_template( 'loop/loop-start.php' );
    woocommerce_output_product_categories($args);
    wc_get_template( 'loop/loop-end.php' );
}
remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
add_action( 'woocommerce_before_shop_loop', 'irent_show_product_subcategories' );



// Change the price display for simple rental products
function irent_change_product_html( $price_html, $product ) {

	if ($product->is_type('simple_rental'))
	{
	  $price_html =
	  '<table class="table table-dark">
	     <thead>
	       <tr>
	         <th scope="col" class="text-center table-dark d-none d-sm-table-cell" style="width:12%">4 Hours</th>
             <th scope="col" class="text-center table-dark" style="width:12%">Daily</th>
             <th scope="col" class="text-center table-dark d-none d-sm-table-cell" style="width:12%">Weekly</th>
           </tr>
	     </thead>
	     <tbody>
	       <tr>
	         <td class="text-center table-dark d-none d-sm-table-cell">$' . $product->get_4_hour_rate() . '</td>
	         <td class="text-center table-dark">$' . $product->get_daily_rate() . '</td>
	         <td class="text-center table-dark d-none d-sm-table-cell">$' . $product->get_weekly_rate() . '</td>
	       </tr>
	     </tbody>
	   </table>';

	}

	return $price_html;
}
add_filter( 'woocommerce_get_price_html', 'irent_change_product_html', 10, 2 );
