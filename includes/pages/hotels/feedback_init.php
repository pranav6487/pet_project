<?php
global $global_params;
global $page_params;

$page_params['page_title'] = "Feedback";
$pageArgs = $global_params['page_arguments'];

$users = new Users();
$restObj = new Restaurant();
$restId = $_SESSION[SESSION_REST_ID];

$seatedCusts = $restObj->getSeatedCustsHtml($restId);
?>