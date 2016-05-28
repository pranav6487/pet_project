<?php
global $global_params;
global $page_params;

$pageArgs = $global_params['page_arguments'];

if( $pageArgs['aj'] == 1 && $pageArgs['action'] == "getPerformanceData" ) {
    $restObj = new Restaurant();
    $restId = base64_decode($pageArgs['restId']);
    $performanceData = $restObj->getPerformanceData($restId);
    echo json_encode($performanceData);
    exit;
}
?>