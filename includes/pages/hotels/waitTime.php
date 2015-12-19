<?php
global $global_params;
global $page_params;

$pageArgs = $global_params['page_arguments'];

if( $pageArgs['aj'] == 1 && $pageArgs['action'] == "saveBooking" ) {
    $restObj = new Restaurant();
    $bookingDtls = $restObj->saveBooking($pageArgs);
}
?>