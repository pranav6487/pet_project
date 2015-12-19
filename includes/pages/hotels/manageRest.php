<?php
global $global_params;
global $page_params;

$pageArgs = $global_params['page_arguments'];

if( $pageArgs['aj'] == 1 && $pageArgs['action'] == "addRest" ) {
    $manageRestObj = new ManageRest();
    $restDtls = $manageRestObj->addRestDtls($pageArgs);
    echo json_encode($restDtls);
    exit;
}
elseif( $pageArgs['aj'] == 1 && $pageArgs['action'] == "addTableDtls" ) {
    $manageRestObj = new ManageRest();
    $tableDtls = $manageRestObj->addTableDtls($pageArgs);
    echo json_encode($tableDtls);
    exit;
}
elseif( $pageArgs['aj'] == 1 && $pageArgs['action'] == "addPartyRel" ) {
    $manageRestObj = new ManageRest();
    $partyRelDtls = $manageRestObj->addPartyRel($pageArgs);
    echo json_encode($partyRelDtls);
    exit;
}
?>
