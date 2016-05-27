<?php
global $global_params;
global $page_params;

$page_params['page_title'] = "Feedback Page";
$pageArgs = $global_params['page_arguments'];

$dispFeedBackFrm = "show";
$dispError = "hide";
$errorText = "";
if( !isset($pageArgs['bid']) || empty($pageArgs['bid']) ) {
    $dispFeedBackFrm = "hide";
    $dispError = "show";
    $errorText = "No reservation/booking found";
}
else {
    $restObj = new Restaurant();
    $bookingId = base64_decode($pageArgs['bid']);
    $isFeedbackTaken = $restObj->isFeedbackTaken($bookingId);
    if( $isFeedbackTaken['isFeedBackTaken'] == true ) {
        $dispFeedBackFrm = "hide";
        $dispError = "show";
        $errorText = $isFeedbackTaken['errMsg'];
    }
}
?>