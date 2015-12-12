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
        $tableDtls = $this->getTableDtls($restId);
        $bookingDts = $this->getCurrentBookingDtls($restId);
        $currBookingDtls = $bookingDts['currBookingDtls'];
        
        $currTable = array();
        foreach( $tableDtls as $tableId => $tableNo ) {
            if( !empty($currBookingDtls[$tableId]) ) {
                $currTable[$tableNo] = $currBookingDtls[$tableId];
            }
            else {
                $currTable[$tableNo] = array("partyName" => "","partyNum" => "","seatTime" => "","endTime" => "","noOfPeople" => "","bookingId" => "");
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
        $currBookingSql = "select a.booking_id,a.table_id,a.party_rel_id,a.no_of_people,a.wait_list_time,a.seated_time,a.estd_empty_time,a.table_empty_time,a.status,b.customer_name,b.customer_number from tbl_booking_dtls as a inner join tbl_customer_dtls as b on b.customer_id = a.customer_id where (a.status = ".self::WAITING_STATUS." or a.status = ".self::SEATED_STATUS.") and a.start_time < ".time()." and a.start_time > ".$dayStartTime.";";
        $currBookingDtls = array();
        $waitListDtls = array();
        if( $dbObj->db_query($currBookingSql) ) {
            if( $dbObj->num_rows > 0 ) {
                while( $rows = $dbObj->db_fetch_array() ) {
                    if( $rows['status'] == self::SEATED_STATUS ) {
                        $currBookingDtls[$rows['table_id']] = array( "partyName" => $rows['customer_name'],"partyNum" => $rows['customer_number'],"seatTime" => $rows['seated_time'],"endTime" => $rows['estd_empty_time'],"noOfPeople" => $rows['no_of_people'],"bookingId" => $rows['booking_id'] );
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
        $selectSql = "select customer_id,customer_name from tbl_customer_dtls where customer_number = ".$custNumber.";";
        if( $dbObj->db_query($selectSql) ) {
            if( $dbObj->num_rows > 0 ) {
                $custDtls = array();
                while( $rows = $dbObj->db_fetch_array() ) {
                    $custDtls[$rows['customer_id']] = $rows['customer_name'];
                }
                
                $custId = array_search($custName,$custDtls);
                if( !$custId ) {
                    $insertDuplicateCust = "insert into tbl_customer_dtls (customer_name,customer_number,is_duplicate,created_on) values('{$custName}',{$custNumber},1,".time().");";
                    if( $dbObj->db_query($insertDuplicateCust) ) {
                        $custId = $dbObj->lastInsertId;
                    }
                }
            }
            else {
                $insertSql = "insert into tbl_customer_dtls (customer_name,customer_number,created_on) values('{$custName}',{$custNumber},".time().");";
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
                $allotTableSql = "insert into tbl_booking_dtls (rest_id,table_id,party_rel_id,customer_id,no_of_people,status,seated_time,estd_empty_time,start_time) values({$restId},{$tableId},{$partyRelId},{$custId},{$noOfPeople},".self::SEATED_STATUS.",{$seatedTime},{$estdEndTime},".time().");";
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
               $emptyTableSql = "update tbl_booking_dtls set status = ".self::DONE_STATUS.", table_empty_time = ".time().", end_time = ".time()." where rest_id = ".$restId." and table_id = ".$tableId." and party_rel_id = ".$partyRelId." and customer_id = ".$custId.";";
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
                $allotTableFromWaitListSql = "update tbl_booking_dtls set status = ".self::SEATED_STATUS.", seated_time = ".$pageArgs['seatedTime'].", estd_empty_time = ".$pageArgs['estdEndTime'].", table_id = ".$tableId." where rest_id = ".$restId." and party_rel_id = ".$partyRelId." and customer_id = ".$custId;
                $dbObj->db_query($allotTableFromWaitListSql);
                echo $allotTableFromWaitListSql;
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
}
?>