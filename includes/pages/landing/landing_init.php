<?php
global $global_params;
global $page_params;

$page_params['js'] = array();

array_push($page_params['js'],JS_URL."common.js");

if( $_COOKIE['chksess'] && $_COOKIE['chksess'] != '' )
{
	header("location: shop/cart.html");
	exit;
}

$ip_add = $_SERVER['REMOTE_ADDR'];
?>
