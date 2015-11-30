<?php
echo "test init<br /> ";
global $global_params;
global $page_params;

$page_params['js'] = array();

array_push($page_params['js'],JS_URL."common.js");

if($_COOKIE['test_cookie'])
{
	$_SESSION['test_session'][] = $_COOKIE['test_cookie'];
}
set_db_active_new('DB_URL');
p($global_params['page_arguments']);
?>