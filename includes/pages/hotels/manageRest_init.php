<?php
global $global_params;
global $page_params;

$page_params['page_title'] = "Manage Restaurants";

$users = new Users();
$restId = $_SESSION[SESSION_REST_ID];
$restObj = new Restaurant();
if( $_SESSION[SESSION_USER_TYPE] == $users::RESTAURANT_USER ) { 
    $restDtls = $restObj->getRestaurantDtls( $restId );
}
?>