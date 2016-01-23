<?php
global $global_params;
global $page_params;
$page_params['page_title'] = "Login";
$pageArgs = $global_params['page_arguments'];

if( !empty($pageArgs['action']) && $pageArgs['action'] == "logout" ) {
    session_destroy();
    header("location: /login.html");
    exit;
}
?>