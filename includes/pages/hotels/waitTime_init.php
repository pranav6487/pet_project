<?php
global $global_params;
global $page_params;

$page_params['page_title'] = "Wait Time";

$restId = 2;
$restObj = new Restaurant();
$restDtls = $restObj->getRestaurantDtls( $restId );
$currTableList = $restDtls['currTableList'];
$waitList = $restDtls['waitListDtls'];
$avgTimeAtTable = $restDtls['avgTimeAtTable'];
$tableCapacity = $restDtls['tableCapacity'];
$nextAvailableAt = $restDtls['nextAvailableAt'];
$totalTables = 16;

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
WaitList coming correctly from db, but not getting displayed<br />
Verify current booking details correctly translating to JS variables<br />
Check waitTime calculation for case Remove from wait list - Add to wait list<br />
Javascript timer countdown for wait time<br />
Javascript timer countup for table occupied time<br />
Case when noOfPeople is more than what is present for the restaurant<br />