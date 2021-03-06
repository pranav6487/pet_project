<?php
class ManageRest {
    public $dbObj;
    public $restObj;
    
    public function __construct() {
        $this->dbObj = array(
            "cols" => array(
                "restId" => "rest_id",
                "restName" => "rest_name",
                "restType" => "rest_type",
                "restTime" => "rest_timings",
                "restLoc" => "rest_loc",
                "restAdd1" => "rest_add_1",
                "restAdd2" => "rest_add_2",
                "restCoEmail" => "rest_contact_email",
                "restManagerName" => "rest_manager_name",
                "restManagerNum" => "rest_manager_num",
                "restManagerEmail" => "rest_manager_email",
                "restContactName1" => "rest_contact1_name",
                "restContactNum1" => "rest_contact1_num",
                "restContactEmail1" => "rest_contact1_email",
                "restContactName2" => "rest_contact2_name",
                "restContactNum2" => "rest_contact2_num",
                "restContactEmail2" => "rest_contact2_email"
            ),
            "key" => "rest_id"
        );
    }
    
    public function addRestDtls( $args ) {
        $insertSql = "";
        $insertVals = array();
        foreach( $this->dbObj['cols'] as $key => $cols ) {
            if( !empty( $args[$key] ) ) {
                $insertVals[$cols] = $args[$key];
            }
        }
        $insertVals['created_on'] = time();
        $users = new Users();
        if( $users->checkUserExist($args['login_email']) ) {
            $insertSql .= "insert into tbl_restaurant_dtls (".  implode(",", array_keys($insertVals)).") values ( '".implode("','",$insertVals)."' )";
            $dbObj = new DbConnc(DB_URL);
            $return = array();
            if( $dbObj->db_query($insertSql) ) {
                $return['status'] = 1;
                $restId = $dbObj->lastInsertId;
                $return['restId'] = $restId;
                $insertUser = "";
                $userObj = new Users();
                $insertUser = 'insert into tbl_users(user_email,user_passwd,user_type,rest_id,created_on) values ("'.$args['login_email'].'","'.md5($args['login_pwd']).'",'.$userObj::RESTAURANT_USER.','.$restId.','.time().')';
                if( !$dbObj->db_query($insertUser) ) {
                    $return['status'] = 0;
                    $return['errMsg'] = "Could not execute query";
                }
            }
            else {
                $return['status'] = 0;
                $return['errMsg'] = "Could not execute query";
            }
        }
        else {
            $return['status'] = 0;
            $return['errMsg'] = "User with email address {$args['login_email']} already exists. Choose another email";
        }
        //$dbObj->db_close();
        return $return;
    }
    
    public function addTableDtls( $args ) {
        $tableNoArr = $args['tableNo'];
        $tableMinOccArr = $args['tableMinOcc'];
        $tableMaxOccArr = $args['tableMaxOcc'];
        $restId = $args['restId'];
        $count = count($tableNo);
        $tableDtls = array();
        $dbObj = new DbConnc(DB_URL);
        $error = false;
        $return = array();
        foreach( $tableNoArr as $key => $tableNo ) {
            if( !empty($tableNoArr[$key]) && !empty($tableMinOccArr[$key]) && !empty($tableMaxOccArr[$key]) ) {
                $insertSql = "";
                $insertSql = 'insert into tbl_table_dtls (rest_id,table_min_occ,table_max_occ,table_no,created_on) values( '.$restId.','.$tableMinOccArr[$key].','.$tableMaxOccArr[$key].',"'.$tableNo.'",'.time().' )';
                if( $dbObj->db_query($insertSql) ) {
                    $tableDtls[$dbObj->lastInsertId] = $tableNo;
                }
                else {
                   $error = true; 
                }
            }
        }
        $dbObj->db_close();
        if( !$error ) {
            $return['status'] = 1;
            $return['tableDtls'] = $tableDtls;
        }
        else {
            $return['status'] = 0;
            $return['errMsg'] = "Could not execute query";
        }
        return $return;
    }
    
    public function addPartyRel( $args ) {
        $noOfPeopleArr = $args['noOfPeople'];
        $avgTimeArr = $args['avgTime'];
        $bufferTimeArr = $args['bufferTime'];
        $restId = $args['rest_id'];
        $dbObj = new DbConnc(DB_URL);
        $error = false;
        $return = array();
        foreach( $noOfPeopleArr as $key => $noOfPeople ) {
            $eligibleTableKey = $key+1;
            if( !empty($noOfPeopleArr[$key]) && !empty($avgTimeArr[$key]) && !empty($bufferTimeArr[$key]) && !empty($args['eligibleTableOpts_'.$eligibleTableKey]) ) {
                $eligibleTables = implode(",",$args['eligibleTableOpts_'.$eligibleTableKey]);
                $insertSql = "";
                $insertSql = 'insert into tbl_party_rest_relation (rest_id,no_of_people,eligible_tables,avg_time,buffer_time,created_on) values('.$restId.','.$noOfPeople.',"'.$eligibleTables.'",'.$avgTimeArr[$key].','.$bufferTimeArr[$key].','.time().')';
                $return['sql'][] = $insertSql;
                if( !$dbObj->db_query($insertSql) ) {
                    $error = true;
                    break;
                }
            }
        }
        $dbObj->db_close();
        if( !$error ) {
            $return['status'] = 1;
        }
        else {
            $return['status'] = 0;
            $return['errMsg'] = "Could not execute query";
        }
        return $return;
    }
}
?>