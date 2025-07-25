<?php
function wcs_fix_cancelled_date($subscription_id ){
    /*
    Sometimes when a user cancels his/her subscripition the same date as the last payment WCS fails. In that case the subscription can not get the status canceled through the Admin UI.
    You get the error 
        Exception: Subscription #ID : The cancelled date must occur after the last payment date. 
    You may also get an error regarding the end date.
    To fix both you must changed the dates programmaticaly in order for the canceled date to be after the last payment date and the end date to be after the cancel date.
    */
    $subscription = wcs_get_subscription($subscription_id);
    if ($subscription && $subscription->get_status() !== 'cancelled') {
        $last_payment = $subscription->get_date('last_payment');
        $cancel_date = date('Y-m-d H:i:s', strtotime($last_payment . ' +2 day'));
        $end_date = date('Y-m-d H:i:s', strtotime($cancel_date . ' +2 day'));
        $subscription->update_dates(['end' =>$end_date,'cancelled' => $cancel_date]);
        $subscription->update_status('cancelled');
    }
}
?>