<?php 
/** Allow payment for unpaid renewal orders on active subscriptions
*
* WooCommerce Subscriptions normally requires the subscription to be on-hold or pending before
* it allows a customer to pay a renewal order.
* Temporarily change only the in-memory status during that validation; the active status is restored and never saved.
*/

add_action('wcs_before_renewal_setup_cart_subscription', 'td_allow_active_subscription_renewal_payment', 10, 2);
function td_allow_active_subscription_renewal_payment( $subscription, $order ) {
	if (
		! $subscription instanceof WC_Subscription ||
		! $order instanceof WC_Order ||
		! wcs_order_contains_renewal( $order ) ||
		! $order->needs_payment() ||
		! $subscription->has_status( 'active' )
	) {
		return;
	}

	$subscription->set_status( 'on-hold' );

	if ( ! isset( $GLOBALS['td_active_subscription_payment_overrides'] ) ) {
		$GLOBALS['td_active_subscription_payment_overrides'] = array();
	}

	$GLOBALS['td_active_subscription_payment_overrides'][ $subscription->get_id() ] = true;
}

add_action(	'wcs_after_renewal_setup_cart_subscription', 'td_restore_active_subscription_after_renewal_setup',	10, 2 );
function td_restore_active_subscription_after_renewal_setup( $subscription, $order ) {
	$subscription_id = $subscription instanceof WC_Subscription
		? $subscription->get_id()
		: 0;
	if (
		$subscription_id &&
		! empty( $GLOBALS['td_active_subscription_payment_overrides'][ $subscription_id ] )
	) {
		$subscription->set_status( 'active' );
		unset( $GLOBALS['td_active_subscription_payment_overrides'][ $subscription_id ] );
	}
}
