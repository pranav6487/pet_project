<?php
global $global_params;
global $page_params;
$page_params['page_title'] = "Wait Time";
$pageArgs = $global_params['page_arguments'];

$users = new Users();
$restObj = new Restaurant();

if( $_SESSION[SESSION_USER_TYPE] == $users::SUPER_USER ) {
    $userId = $_SESSION[SESSION_USER_ID];
    $restList = $restObj->getRestListForSuperUser($userId);
}

if( $_SESSION[SESSION_USER_TYPE] == $users::SUPER_USER && !empty($pageArgs['restId']) ) {
    $restId = base64_decode($pageArgs['restId']);
}
elseif( $_SESSION[SESSION_USER_TYPE] == $users::RESTAURANT_USER ) {
    $restId = $_SESSION[SESSION_REST_ID];
}

if( !empty($restId) ) {
    $restDtls = $restObj->getOngoingBkkDtls( $restId );
    $currTableList = $restDtls['currTableList'];
    $waitList = $restDtls['waitList'];
    $avgTimeAtTable = $restDtls['avgTimeAtTable'];
    $tableCapacity = $restDtls['tableCapacity'];
    $nextAvailableAt = $restDtls['nextAvailableAt'];
    $bufferTime = $restDtls['bufferTime'];
    $totalTables = count($currTableList);
}

//$currTableList = array(
//    "t2_1" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t2_2" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t2_3" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t2_4" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t4_1" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t4_2" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t4_3" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t4_4" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t4_5" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t4_6" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t6_1" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t6_2" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t6_3" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t8_1" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t8_2" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => ""),
//    "t8_3" => array( "partyName" => "", "seatTime" => "" , "endTime" => "", "noOfPeople" => "")
//);
//
//$waitList = array( //noOfPeopleInParty => total
//    
//);
//
//$avgTimeAtTable = array( //time in minutes
//    1 => 45,
//    2 => 60,
//    3 => 90,
//    4 => 105,
//    5 => 120,
//    6 => 150
//);
//
//$tableTurnTime = array( //average time when the table will be available next
//    1 => 11.25,
//    2 => 6,
//    3 => 6.92,
//    4 => 8.75,
//    5 => 10,
//    6 => 25
//);
//
//$tableCapacity = array(
//    1 => array("t2_1","t2_2","t2_3","t2_4"),
//    2 => array("t2_1","t2_2","t2_3","t2_4","t4_1","t4_2","t4_3","t4_4","t4_5","t4_6"),
//    3 => array("t2_1","t2_2","t2_3","t2_4","t4_1","t4_2","t4_3","t4_4","t4_5","t4_6","t6_1","t6_2","t6_3"),
//    4 => array("t4_1","t4_2","t4_3","t4_4","t4_5","t4_6","t6_1","t6_2","t6_3","t8_1","t8_2","t8_3"),
//    5 => array("t4_1","t4_2","t4_3","t4_4","t4_5","t4_6","t6_1","t6_2","t6_3","t8_1","t8_2","t8_3"),
//    6 => array("t6_2","t6_3","t8_1","t8_2","t8_3"),
//    7 => array("t6_2","t6_3","t8_1","t8_2","t8_3"),
//    8 => array("t8_1","t8_2","t8_3"),
//    9 => array("t6_2","t6_3","t8_1","t8_2","t8_3")
//);
//$bufferTime = array( //buffer time for each party count
//    1 => 10,
//    2 => 15,
//    3 => 20,
//    4 => 25,
//    5 => 30,
//    6 => 35
//);
//
//$nextAvailableAt = array( //when the particular table will be next available
//    
//);
?>