<?php

/* Filter orders by payment method */

// Add the Payment Method column to the Orders page in WooCommerce admin
function td_add_payment_method_column($columns) {
    $columns['payment_method'] = __('Payment Method', 'woocommerce');
    return $columns;
}
add_filter('manage_edit-shop_order_columns', 'td_add_payment_method_column');

// Display the payment method value in the Payment Method column
function td_display_payment_method_column($column, $post_id) {
    if ($column == 'payment_method') {
        $order = wc_get_order($post_id);
        echo $order->get_payment_method_title();
    }
}
add_action('manage_shop_order_posts_custom_column', 'td_display_payment_method_column', 10, 2);

// Add a custom dropdown for filtering by payment method
function td_add_payment_method_filter() {
    
	global $typenow;
    
    if ('shop_order' === $typenow) {
        
        // get all payment methods, even inactive ones
    	$gateways = WC()->payment_gateways->get_available_payment_gateways();
    
        echo '<select name="payment_method_filter">';
        echo '<option value="">'.__('Filter by Payment Method','td').'</option>';
        
        foreach ( $gateways as $id => $gateway ) : ?>
       		 <option value="<?php echo esc_attr( $id ); ?>" <?php echo esc_attr( isset( $_GET['payment_method_filter'] ) ? selected( $id, $_GET['payment_method_filter'], false ) : '' ); ?>>
            	<?php echo esc_html( $gateway->get_method_title() ); ?>
       		 </option>
        <?php endforeach; 
        
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'td_add_payment_method_filter');

// Filter orders based on the selected payment method
function td_filter_orders_by_payment_method($query) {
    global $pagenow;
    
    if ('edit.php' === $pagenow && isset($_GET['payment_method_filter']) && !empty($_GET['payment_method_filter'])) {
        $query->query_vars['meta_key'] = '_payment_method';
        $query->query_vars['meta_value'] = sanitize_text_field($_GET['payment_method_filter']);
    }
}
add_filter('parse_query', 'td_filter_orders_by_payment_method');

