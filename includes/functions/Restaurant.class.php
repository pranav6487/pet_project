<?php
class Restaurant {
    public $restObj;
    //For DB
    const WAITING_STATUS = 1;
    const SEATED_STATUS = 2;
    const DONE_STATUS = 3;
    const REMOVED_FROM_WAIT_LIST = 4;
    const NO_RESULT_STATUS = 5;
    //For Code
    const ALLOT_TABLE = 1;
    const ADD_TO_WAIT_LIST = 2;
    const EMPTY_TABLE = 3;
    const REMOVE_FROM_WAIT_LIST = 4;
    const ALLOT_TABLE_FROM_WAIT_LIST = 5;
    public function __construct() {
        
    }
    
    public function getRestaurantDtls( $restId ) {
        $return = array();
        $dbObj = new DbConnc(DB_URL);
        $getRestDtls = "select rest_name,rest_loc,rest_add_1,rest_add_2,rest_contact_email,rest_manager_name,rest_manager_num,rest_contact1_name,rest_contact1_num,rest_contact2_name,rest_contact2_num,rest_type,rest_timings from tbl_restaurant_dtls where rest_id = ".$restId.";";
        if( $dbObj->db_query($getRestDtls) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $return['name'] = $rows['rest_name'];
                $return['location'] = $rows['rest_loc'];
                $return['address1'] = $rows['rest_add_1'];
                $return['address2'] = $rows['rest_add_2'];
                $return['restEmail'] = $rows['rest_contact_email'];
                $return['restManagerName'] = $rows['rest_manager_name'];
                $return['restManagerNum'] = $rows['rest_manager_num'];
                $return['restContact1Name'] = $rows['rest_contact1_name'];
                $return['restContact1Num'] = $rows['rest_contact1_num'];
                $return['restContact2Name'] = $rows['rest_contact2_name'];
                $return['restContact2Num'] = $rows['rest_contact2_num'];
                $return['restType'] = $rows['rest_type'];
                $return['restTimings'] = $rows['rest_timings'];
            }
        }
        else {
            die("Could not load restaurant details");
        }
        
        $getTableDetails = "select table_id,table_min_occ,table_max_occ,table_no from tbl_table_dtls where rest_id = ".$restId.";";
        if( $dbObj->db_query($getTableDetails) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $return['tableDtls'][$rows['table_id']]['tableNo'] = $rows['table_no'];
                $return['tableDtls'][$rows['table_id']]['tableMinOcc'] = $rows['table_min_occ'];
                $return['tableDtls'][$rows['table_id']]['tableMaxOcc'] = $rows['table_max_occ'];
            }
        }
        else {
            die("Could not load table details");
        }
        
        $getPartyRel = "select party_rel_id,no_of_people,eligible_tables,avg_time,buffer_time,next_avail_at from tbl_party_rest_relation where rest_id = ".$restId.";";
        if( $dbObj->db_query($getPartyRel) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $return['partyRel'][$rows['party_rel_id']]['noOfPeople'] = $rows['no_of_people'];
                $return['partyRel'][$rows['party_rel_id']]['eligibleTables'] = $rows['eligible_tables'];
                $eligibleTablesArr = explode(",",$rows['eligible_tables']);
                $eligibleTableNos = "";
                foreach( $eligibleTablesArr as $eligibleTableId ) {
                    $eligibleTableNos .= $return['tableDtls'][$eligibleTableId]['tableNo'].",";
                }
                $return['partyRel'][$rows['party_rel_id']]['eligibleTableNos'] = trim($eligibleTableNos,",");
                $return['partyRel'][$rows['party_rel_id']]['avgTime'] = $rows['avg_time'];
                $return['partyRel'][$rows['party_rel_id']]['bufferTime'] = $rows['buffer_time'];
                $return['partyRel'][$rows['party_rel_id']]['nextAvailAt'] = $rows['next_avail_at'];
            }
        }
        else {
            die("Could not load party and restaurant relation");
        }
        
        return $return;
    }
    
    public function getTableNoFromIds( $tableId ) {
        if(is_array($tableId) ) {
            
        }
        else {
            
        }
    }
    
    public function getOngoingBkkDtls( $restId ) {
        $return = array();
        $tableDtls = $this->getTableDtls($restId);
        $bookingDts = $this->getCurrentBookingDtls($restId);
        $currBookingDtls = $bookingDts['currBookingDtls'];
        
        $currTable = array();
        foreach( $tableDtls as $tableId => $tableNo ) {
            if( !empty($currBookingDtls[$tableId]) ) {
                $currTable[$tableNo] = $currBookingDtls[$tableId];
            }
            else {
                $currTable[$tableNo] = array("partyName" => "","partyNum" => "","seatTime" => "","endTime" => "","noOfPeople" => "","bookingId" => "", "bookedTill" => "");
            }
        }
        $partyDtls = $this->getRestPartyDtls($restId);
        $return['currTableList'] = $currTable;
        $return['waitList'] = $bookingDts['waitListDtls'];
        $return['avgTimeAtTable'] = $partyDtls['avgTime'];
        $return['bufferTime'] = $partyDtls['bufferTime'];
        $tableCap = array();
        foreach( $partyDtls['tableCap'] as $key => $value ) {
            foreach( $value as $tableId ) {
               $tableCap[$key][] =  $tableDtls[$tableId];
            }
        }
        $return['tableCapacity'] = $tableCap;
        $return['nextAvailableAt'] = $partyDtls['nextAvailAt'];
        return $return;
    }
    
    public function getTableDtls( $restId ) {
        $dbObj = new DbConnc(DB_URL);
        $getTables = "select table_id,table_no from tbl_table_dtls where rest_id = {$restId} and status = 1;";
        $tableDtls = array();
        if( $dbObj->db_query($getTables) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $tableDtls[$rows['table_id']] = $rows['table_no'];
            }
        }
        else {
            die("Could not load restaurant details. Please load again or try again later");
        }
        return $tableDtls;
    }
    
    public function getCurrentBookingDtls($restId) {
        $dbObj = new DbConnc(DB_URL);
        $dayStartTime = strtotime(date('Y-m-d') . '10:00:00');
        $currBookingSql = "select booking_dtls.booking_id,booking_dtls.table_id,booking_dtls.party_rel_id,booking_dtls.no_of_people,booking_dtls.wait_list_time,booking_dtls.seated_time,booking_dtls.estd_empty_time,booking_dtls.table_empty_time,booking_dtls.status,booking_dtls.booked_till,customer_dtls.customer_name,customer_dtls.customer_number from tbl_booking_dtls as booking_dtls inner join tbl_customer_dtls as customer_dtls on customer_dtls.customer_id = booking_dtls.customer_id where (booking_dtls.status = ".self::WAITING_STATUS." or booking_dtls.status = ".self::SEATED_STATUS.") and booking_dtls.start_time < ".time()." and booking_dtls.start_time > ".$dayStartTime.";";
        $currBookingDtls = array();
        $waitListDtls = array();
        if( $dbObj->db_query($currBookingSql) ) {
            if( $dbObj->num_rows > 0 ) {
                while( $rows = $dbObj->db_fetch_array() ) {
                    if( $rows['status'] == self::SEATED_STATUS ) {
                        $currBookingDtls[$rows['table_id']] = array( "partyName" => $rows['customer_name'],"partyNum" => $rows['customer_number'],"seatTime" => $rows['seated_time'],"endTime" => $rows['estd_empty_time'],"noOfPeople" => $rows['no_of_people'],"bookingId" => $rows['booking_id'], "bookedTill" => $rows['booked_till'] );
                    }
                    elseif( $rows['status'] == self::WAITING_STATUS ) {
                        $waitListDtls[] = array("name" => $rows['customer_name'],"noOfPeople" => $rows['no_of_people'],"num" => $rows['customer_number'],"waitTime" => $rows['wait_list_time'],"tablesAvail" => "");
                    }
                }
            }
        }
        else {
            die("Could not load current booking details. Please load again or try again later");
        }
        $return = array();
        $return['currBookingDtls'] = $currBookingDtls;
        $return['waitListDtls'] = $waitListDtls;
        return $return;
    }
    
    public function getRestPartyDtls($restId) {
        $dbObj = new DbConnc(DB_URL);
        $return = array();
        $restPartyDtls = "select no_of_people,eligible_tables,avg_time,buffer_time,next_avail_at from tbl_party_rest_relation where rest_id = ".$restId.";";
        $avgTime = $bufferTime = $tableCap = $nextAvailAt = array();
        if( $dbObj->db_query($restPartyDtls) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $avgTime[$rows['no_of_people']] = $rows['avg_time'];
                $bufferTime[$rows['no_of_people']] = $rows['buffer_time'];
                $tableCap[$rows['no_of_people']] = explode(",",$rows['eligible_tables']);
                $nextAvailAt[$rows['no_of_people']] = $rows['next_avail_at'];
            }
        }
        else {
            die("Could not load party details");
        }
        $return['avgTime'] = $avgTime;
        $return['bufferTime'] = $bufferTime;
        $return['tableCap'] = $tableCap;
        $return['nextAvailAt'] = $nextAvailAt;
        return $return;
    }
    
    public function getCustomerId( $custName, $custNumber ) {
        $dbObj = new DbConnc(DB_URL);
        $selectSql = "select customer_id,customer_name from tbl_customer_dtls where customer_number = '".$custNumber."';";
        if( $dbObj->db_query($selectSql) ) {
            if( $dbObj->num_rows > 0 ) {
                $custDtls = array();
                while( $rows = $dbObj->db_fetch_array() ) {
                    $custDtls[$rows['customer_id']] = $rows['customer_name'];
                }
                
                $custId = array_search($custName,$custDtls);
                if( !$custId ) {
                    $insertDuplicateCust = "insert into tbl_customer_dtls (customer_name,customer_number,is_duplicate,created_on) values('{$custName}','{$custNumber}',1,".time().");";
                    if( $dbObj->db_query($insertDuplicateCust) ) {
                        $custId = $dbObj->lastInsertId;
                    }
                }
            }
            else {
                $insertSql = "insert into tbl_customer_dtls (customer_name,customer_number,created_on) values('{$custName}','{$custNumber}',".time().");";
                if( $dbObj->db_query($insertSql) ) {
                    $custId = $dbObj->lastInsertId;
                }
            }
            return $custId;
        }
    }
    
    public function getPartyRelId( $restId, $noOfPeople ) {
        $dbObj = new DbConnc(DB_URL);
        $selectSql = "select party_rel_id from tbl_party_rest_relation where rest_id = ".$restId." and no_of_people = ".$noOfPeople.";";
        if( $dbObj->db_query($selectSql) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $partyRelId = $rows['party_rel_id'];
            }
            return $partyRelId;
        }
    }
    
    public function saveBooking($pageArgs) {
        $return = array();
        $dbObj = new DbConnc(DB_URL);
        
        //Get Customer Id
        if( !empty($pageArgs['partyName']) && !empty($pageArgs['partyNum']) && !empty($pageArgs['restId']) && !empty($pageArgs['noOfPeople']) ) {
            $custName = $pageArgs['partyName'];
            $custNumber = $pageArgs['partyNum'];
            $custId = $this->getCustomerId($custName, $custNumber);

        //Get Party rest relation id
            $restId = $pageArgs['restId'];
            $noOfPeople = $pageArgs['noOfPeople'];
            $partyRelId = $this->getPartyRelId( $restId, $noOfPeople );
        }
        else {
            //Figure our error handling
        }

        //Get table id
        if( isset($pageArgs['tableNo']) && !empty($pageArgs['tableNo']) ) {
            $tableNo = $pageArgs['tableNo'];
            $tableDtls = $this->getTableDtls( $restId );
            $tableId = array_search($tableNo, $tableDtls);
        }
        else {
            //Figure out error handling
        }
                
        $status = $pageArgs['status'];
        switch( $status ) {
            case self::ALLOT_TABLE:
                $seatedTime = $pageArgs['seatedTime'];
                $estdEndTime = $pageArgs['estdEndTime'];
                $bookedTill = $pageArgs['bookedTill'];
                $allotTableSql = "insert into tbl_booking_dtls (rest_id,table_id,party_rel_id,customer_id,no_of_people,status,seated_time,estd_empty_time,start_time,booked_till) values({$restId},{$tableId},{$partyRelId},{$custId},{$noOfPeople},".self::SEATED_STATUS.",{$seatedTime},{$estdEndTime},".time().",{$bookedTill});";
                if( $dbObj->db_query($allotTableSql) ) {
                    $return['bookingId'] = $dbObj->lastInsertId;
                }
                
                if( isset($pageArgs['nextAvailableAt']) && !empty($pageArgs['nextAvailableAt']) ) {
                    $nextAvailableAt = $pageArgs['nextAvailableAt'];
                    $updateNextAvailSql = "update tbl_party_rest_relation set next_avail_at = {$nextAvailableAt} where rest_id = {$restId} and party_rel_id = {$partyRelId};";
                    $dbObj->db_query($updateNextAvailSql);
                }
                
                $return["tableNo"] = $tableNo;
                break;
            
            case self::ADD_TO_WAIT_LIST:
                $addWaitListSql = "insert into tbl_booking_dtls (rest_id,party_rel_id,customer_id,no_of_people,status,wait_list_time,start_time) values ({$restId},{$partyRelId},{$custId},{$noOfPeople},".self::WAITING_STATUS.",".$pageArgs['waitListTime'].",".time().")";
                if( $dbObj->db_query($addWaitListSql) ) {
                    $return['bookingId'] = $dbObj->lastInsertId;
                }
                
                if( isset($pageArgs['nextAvailableAt']) && !empty($pageArgs['nextAvailableAt']) ) {
                    $dbObj->db_free_result();
                    $nextAvailableAt = $pageArgs['nextAvailableAt'];
                    $updateNextAvailSql = "update tbl_party_rest_relation set next_avail_at = {$nextAvailableAt} where rest_id = {$restId} and party_rel_id = {$partyRelId};";
                    $dbObj->db_query($updateNextAvailSql);
                }
                
                $return['waitListIndex'] = $pageArgs['waitListIndex'];
                break;
            
            case self::EMPTY_TABLE:
               $emptyTableSql = "update tbl_booking_dtls set status = ".self::DONE_STATUS.", table_empty_time = ".time().", end_time = ".time().", booked_till = 0 where rest_id = ".$restId." and table_id = ".$tableId." and party_rel_id = ".$partyRelId." and customer_id = ".$custId.";";
                $dbObj->db_query($emptyTableSql);
                
                if( !empty($pageArgs['nextAvailableAt']) ) {
                    $updateNextAvailSql = "update tbl_party_rest_relation set next_avail_at = ".$pageArgs['nextAvailableAt']." where rest_id = {$restId} and party_rel_id = {$partyRelId};";
                    $dbObj->db_query($updateNextAvailSql);
                }
                break;
            
            case self::REMOVE_FROM_WAIT_LIST:
                $removeFromWaitListSql = "update tbl_booking_dtls set status = ".self::REMOVED_FROM_WAIT_LIST.", end_time = ".time()." where rest_id = ".$restId." and party_rel_id = ".$partyRelId." and customer_id = ".$custId.";";
                $dbObj->db_query($removeFromWaitListSql);
                
                if( !empty($pageArgs['nextAvailableAt']) ) {
                    $updateNextAvailSql = "update tbl_party_rest_relation set next_avail_at = ".$pageArgs['nextAvailableAt']." where rest_id = {$restId} and party_rel_id = {$partyRelId};";
                    $dbObj->db_query($updateNextAvailSql);
                }
                break;
            
            case self::ALLOT_TABLE_FROM_WAIT_LIST:
                $allotTableFromWaitListSql = "update tbl_booking_dtls set status = ".self::SEATED_STATUS.", seated_time = ".$pageArgs['seatedTime'].", estd_empty_time = ".$pageArgs['estdEndTime'].", table_id = ".$tableId.", booked_till = ".$pageArgs['bookedTill']." where rest_id = ".$restId." and party_rel_id = ".$partyRelId." and customer_id = ".$custId.";";
                $dbObj->db_query($allotTableFromWaitListSql);
                if( !empty($pageArgs['nextAvailableAt']) ) {
                    $updateNextAvailSql = "update tbl_party_rest_relation set next_avail_at = ".$pageArgs['nextAvailableAt']." where rest_id = {$restId} and party_rel_id = {$partyRelId};";
                    $dbObj->db_query($updateNextAvailSql);
                    echo $updateNextAvailSql;exit;
                }
                break;
        }
        
        echo json_encode($return);
        exit;
    }
    
    public function getRestListForSuperUser( $userId ) {
        $return = array();
        $dbObj = new DbConnc(DB_URL);
        $getRestSql = "select rest_id,rest_name from tbl_restaurant_dtls where status = 1;";
        if( $dbObj->db_query($getRestSql) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $return[] = array( "restId" => base64_encode($rows['rest_id']), "restName" => $rows['rest_name'] );
            }
        }
        else {
            //error handling
        }
        
        return $return;
    }
    
    public function getSeatedCusts($restId) {
        $return = array();
        $dbObj = new DbConnc(DB_URL);
        $dayStartTime = strtotime(date('Y-m-d') . '10:00:00');
        $getSeatedCustsSql = "select booking_dtls.booking_id,booking_dtls.table_id,booking_dtls.no_of_people,booking_dtls.feedback_id,customer_dtls.customer_name,customer_dtls.customer_number,table_dtls.table_no from tbl_booking_dtls as booking_dtls inner join tbl_customer_dtls as customer_dtls on customer_dtls.customer_id = booking_dtls.customer_id inner join tbl_table_dtls as table_dtls on table_dtls.table_id = booking_dtls.table_id where booking_dtls.status = ".self::SEATED_STATUS." and booking_dtls.start_time < ".time()." and booking_dtls.start_time > ".$dayStartTime.";";
        if( $dbObj->db_query($getSeatedCustsSql) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $seatedCusts[$rows['table_id']] = array("bookingId" => $rows['booking_id'],"noOfPeople" => $rows['no_of_people'],"customerName" => $rows['customer_name'],"customerNumber" => $rows['customer_number'],"tableNo" => $rows['table_no'],"feedBackId" => $rows['feedback_id']);
            }
        }
        else {
            die("Seems there is some issue. Please try again later");
        }
        
        $tableDtls = $this->getTableDtls($restId);
        foreach( $tableDtls as $tableId => $tableNo ) {
            if( !empty($seatedCusts[$tableId]) ) {
                $return[$tableId] = $seatedCusts[$tableId];
            }
            else {
                $return[$tableId] = array( "tableNo" => $tableNo );
            }
        }
        return $return;
    }
    
    public function getSeatedCustsHtml($restId) {
        $seatedCusts = $this->getSeatedCusts($restId);
        $html = "";
        $i = 0;
        $noOfTables = count($seatedCusts);
        foreach( $seatedCusts as $tableId => $bookingDtls ) {
            $i++;
            $feedBackLink = "";
            if( $i == 1 ) {
                $html .= "<li>";
            }
            
            if( !empty($bookingDtls['bookingId']) && $bookingDtls['feedBackId'] == 0 ) {
                $feedBackLink = HTTP_BASE_PATH."CustomerFeedback.html?bid=".base64_encode($bookingDtls['bookingId']);
                $html .= '<button type="button" class="feedBackBtn greenBtn" rel="'.$feedBackLink.'" title="Get Customer Feedback"><i>'.$bookingDtls['tableNo'].'</i><br />'.$bookingDtls['customerName'].' ('.$bookingDtls['noOfPeople'].')</button>&nbsp;';
            }
            elseif( !empty($bookingDtls['bookingId']) && $bookingDtls['feedBackId'] != 0 ) {
                $html .= '<button type="button" class="feedBackBtn greyBtn" rel="done"><i>'.$bookingDtls['tableNo'].'</i><br />'.$bookingDtls['customerName'].' ('.$bookingDtls['noOfPeople'].')</button>&nbsp;';
            }
            else {
                $html .= '<button type="button" class="feedBackBtn greyBtn">'.$bookingDtls['tableNo'].'</button>&nbsp;';
            }
            
            if( $i%4 == 0 || $noOfTables == $i ) {
                $html .= "</li><li>";
            }
            
            if( $noOfTables == $i ) {
                $html .= "</li>";
            }
        }
        return $html;
    }
    
    public function isFeedbackTaken($bookingId) {
        $return = array();
        $dbObj = new DbConnc(DB_URL);
        $findBookingSql = "select status,feedback_id from tbl_booking_dtls where booking_id = ".$bookingId;
        if( $dbObj->db_query($findBookingSql) ) {
            if( $dbObj->num_rows > 0 ) {
                while( $rows = $dbObj->db_fetch_array() ) {
                    $status = $rows['status'];
                    $feedBackId = $rows['feedback_id'];
                }
                
                if( $status == self::SEATED_STATUS && $feedBackId == 0 ) {
                    $return['isFeedBackTaken'] = false;
                }
                else {
                    $return['isFeedBackTaken'] = true;
                    $return['errMsg'] = "Feedback already taken for the selected customer";
                }
            }
            else {
                $return['isFeedBackTaken'] = true;
                $return['errMsg'] = "No reservation/booking found";
            }
        }
        return $return;
    }
    
    public function saveFeedBack($pageArgs) {
        $return = array();
        $dbObj = new DbConnc(DB_URL);
        $bookingId = base64_decode($pageArgs['bid']);
        $getRestIdSql = "select rest_id from tbl_booking_dtls where booking_id = ".$bookingId;
        if( $dbObj->db_query($getRestIdSql) ) {
            while( $rows = $dbObj->db_fetch_array() ) {
                $restId = $rows['rest_id'];
            }
        }
        else {
            $return['status'] = "fail";
            return $return;
        }
        
        $saveFeedBack = "insert into tbl_feedback (booking_id,rest_id,ambience,food_qaulity,staff_friendly,cleanliness,service_speed,recommend";
        if( isset($pageArgs['comments']) && !empty($pageArgs['comments']) ) {
            $saveFeedBack .= ",comments,created_on)";
        }
        else {
            $saveFeedBack .= ",created_on)";
        }
        
        $saveFeedBack .= " values ({$bookingId},{$restId},{$pageArgs['ambience']},{$pageArgs['foodQuality']},{$pageArgs['staffFriendly']},{$pageArgs['cleanliness']},{$pageArgs['serviceSpeed']},{$pageArgs['recommend']}";
        
        if( isset($pageArgs['comments']) && !empty($pageArgs['comments']) ) {
           $saveFeedBack .= ",{$pageArgs['comments']},".time().");"; 
        }
        else {
           $saveFeedBack .= ",".time().");";  
        }
        
        if( $dbObj->db_query($saveFeedBack) ) {
            $feedBackId = $dbObj->lastInsertId;
        }
        else {
            $return['status'] = "fail";
            return $return;
        }
        
        $updateBooking = "update tbl_booking_dtls set feedback_id = {$feedBackId} where booking_id = {$bookingId};";
        if( $dbObj->db_query($updateBooking) ) {
            $return['status'] = "success";
            return $return;
        }
        else {
            $return['status'] = "fail";
            return $return;
        }
    }
}
?>