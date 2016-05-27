<?php
global $global_params;
global $page_params;

$pageArgs = $global_params['page_arguments'];

if( $pageArgs['aj'] == 1 && $pageArgs['action'] == "saveFeedBack" ) {
    $restObj = new Restaurant();
    $response = $restObj->saveFeedBack($pageArgs);
    echo json_encode($response);
    exit;
}
?>