<?php
global $global_params;
global $page_params;

$pageArgs = $global_params['page_arguments'];

if( $pageArgs['aj'] == 1 && $pageArgs['action'] == "contMail" ) {
    $users = new Users();
    $return = $users->contactMail($pageArgs);
    echo json_encode($return);
    exit;
}
?>