<?php
class Users {
    const SUPER_USER = 1;
    const RESTAURANT_USER = 2;
    
    public function __construct() {
        $this->dbObj = array(
            "cols" => array(
                "userId" => "user_id",
                "userEmail" => "user_email",
                "userPasswd" => "user_passwd",
                "userType" => "user_type",
                "restId" => "rest_id",
                "status" => "status",
                "createdOn" => "created_on",
                "updatedOn" => "updated_on"
            ),
            "key" => "user_id"
        );
    }
    
    public function signIn( $email, $passwd ) {
        $encryptPasswd = md5($passwd);
        $dbObj = new DbConnc(DB_URL);
        $findUser = "select user_id,user_type,rest_id from tbl_users where user_email = '{$email}' and user_passwd = '{$encryptPasswd}' and status = 1;";
        $return = array();
        if( $dbObj->db_query($findUser) ) {
            if( $dbObj->num_rows > 0 ) {
                $rows = $dbObj->db_fetch_array();
                $return['userId'] = $rows['user_id'];
                $return['userType'] = $rows['user_type'];
                $return['restId'] = $rows['rest_id'];
                $return['status'] = 1;
                //Set session
                $_SESSION[SESSION_USER_ID] = $return['userId'];
                $_SESSION[SESSION_USER_TYPE] = $return['userType'];
                $_SESSION[SESSION_REST_ID] = $return['restId'];
                $return['redHref'] = "/hotels/waitTime.html";
            }
            else {
                $return['status'] = 0;
                $return['errMsg'] = "User not found. Please use correct email and password";
            }
        }
        else {
            $return['status'] = 0;
            $return['errMsg'] = "There seems to be some problem connecting. Please try again later";
        }
        
        return $return;
    }
    
    public function forgotPasswd( $email ) {
        $dbObj = new DbConnc(DB_URL);
        $return = array();
        $findUser = "select user_id from tbl_users where user_email = '{$email}' and status = 1;";
        if( $dbObj->db_query($findUser) ) {
            if( $dbObj->num_rows > 0 ) {
                $rows = $dbObj->db_fetch_array();
                $userId = $rows['user_id'];
                //Send Mail to user with password reset link
                $subject = "Password reset link";
                $message = "A password reset request has been initiated for the email address '{$email}'. If you have not initiated this request, please report this mail.<br /><a href='".HTTP_URL."login.html?action=forgotPasswd&id=".base64_encode($userId)."'>Click here</a> to reset your password.";
                $header = "From:noreply@waittime.com \r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-type: text/html\r\n";
                $sendMail = mail($email,$subject,$message,$header);
                if( $sendMail == true ) {
                    $return['status'] = 1;
                    $return['errMsg'] = "Password reset mail sent to {$email}";
                }
                else {
                    $return['status'] = 0;
                    $return['errMsg'] = "There seems to be some problem. Please contact on pranav6487@gmail.com for password request with your email address";
                }
            }
            else {
                $return['status'] = 0;
                $return['errMsg'] = "User not found. Please use correct email and password";
            }
        }
        else {
            $return['status'] = 0;
            $return['errMsg'] = "There seems to be some problem connecting. Please try again later";
        }
        return $return;
    }
    
    public function resetPasswd( $args ) {
        $userId = base64_decode($args['userId']);
        $newPasswd = md5($args['newPasswd']);
        $dbObj = new DbConnc(DB_URL);
        $return = array();
        $updatePasswd = "update tbl_users set user_passwd = '{$newPasswd}',updated_on = ".time()." where user_id = {$userId};";
        if( $dbObj->db_query($updatePasswd) ) {
            $return['status'] = 1;
            $return['errMsg'] = "Password reset successfully. You will now be redirected to Login page in a few seconds";
            $return['redHref'] = "/login.html";
        }
        else {
            $return['status'] = 0;
            $return['errMsg'] = "There seems to be problem. Please contact with your email address on pranav6487@gmail.com";
        }
        return $return;
    }
    
    public function checkUserExist( $email ) {
        $dbObj = new DbConnc(DB_URL);
        $checkUser = "select user_id from tbl_users where user_email = '{$email}';";
        if( $dbObj->db_query($checkUser) ) {
            if( $dbObj->num_rows > 0 ) {
                return false;
            }
            else {
                return true;
            }
        }
        else {
            return false;
        }
    }
    
    public function getUser( $userId ) {
        $dbObj = new DbConnc(DB_URL);
        $userDtls = array();
        $getUser = "select user_email, user_passwd, user_type, rest_id from tbl_users where user_id = {$userId} and status = 1";
        if( $dbObj->db_query($getUser) ) {
            $rows = $dbObj->db_fetch_array();
            $userDtls['userId'] = $userId;
            $userDtls['userEmail'] = $rows['user_email'];
            $userDtls['userType'] = $rows['user_type'];
            $userDtls['restId'] = $rows['rest_id'];
            
            return $userDtls;
        }
        else {
            return false;
        }
    }
    
    public function contactMail( $args ) {
        $return = array();
        $subject = "Restaurant Contact Mail - ".$args['subject'];
        $message = $args['message'];
        $userId = $_SESSION[SESSION_USER_ID];
        $userDtls = $this->getUser($userId);
        $emailMsg = "Query from <br />User id: {$userDtls['userId']}<br />User email: {$userDtls['userEmail']}<br /><br />Message:<br />".$message;
        $header = "From:{$userDtls['userEmail']} \r\n";
        $header .= "Reply-to: ".$userDtls['userEmail']." \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $sendMail = mail(CONTACT_US_EMAIL,$subject,$emailMsg,$header);
        if( $sendMail == true ) {
            $return['status'] = 1;
            $return['errMsg'] = "We have recieved your mail and shall get back to you shortly";
        }
        else {
            $return['status'] = 0;
            $return['errMsg'] = "There seems to be some problem. Please contact on pranav6487@gmail.com with your query from your email address";
        }
        
        return $return;
    }
}
?>