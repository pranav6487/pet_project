<?php
//Function for print_r
function ppr($arr)
{
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

// Get URL string and query string in global params array. All the $_GET and $_POST variables will be in this array.
function get_page_arguments()
{
	global $global_params;
	$global_params['page_arguments'] = array();
	
	foreach( $_GET as $key => $val)
	{
		if( $key == 'gtp')
		{
			$global_params['page_arguments']['gtp'] = array();
			$arguments = explode("/",$val); 
			for($i=0;$i<count($arguments);$i++)
			{
				if( strlen($arguments[$i]) )
				{
					array_push( $global_params['page_arguments']['gtp'],$arguments[$i] );
				}
			}
		}
		elseif( is_array($val) )
		{
			if( !empty($val) )
			{
				$global_params['page_arguments'][$key] = $val;
			}
		}
		elseif( is_string($val) )
		{
			if( strlen($val) )
			{
				$global_params['page_arguments'][$key] = urldecode($val);
			}
		}
	}
	
	foreach($_POST as $key => $val)
	{
		if( is_array($val) )
		{
			if( !empty($val) )
			{
				$global_params['page_arguments'][$key] = $val;	
			}
		}
		elseif( is_string($val) )
		{
			if( strlen($val) )
			{
				$global_params['page_arguments'][$key] = $val;
			}
		}
	}
	
	$global_params['cookie_arguments'] = array();
	if( is_array($_COOKIE) )
	{
		foreach($_COOKIE as $key => $val)
		{
			if( is_array($val) )
			{
				if( !empty($val) )
				{
					$global_params['cookie_arguments'][$key] = $val;	
				}
			}
			elseif( is_string($val) )
			{
				if( strlen($val) )
				{
					$global_params['cookie_arguments'][$key] = $val;
				}
			}	
		}
	}
}

function _init()
{
	global $global_params;
	global $page_params;
	//ppr($page_params); ppr($global_params); exit;
	
	//start session
	make_session_active();
	//isset($global_params['session_arguments']['userId']) && !empty($global_params['session_arguments']['userId'])
        if( count($global_params['page_arguments']['gtp']) == 0 ) {
            $page_params['page_dir_file_name'] = "landing/landing";
            $page_params['template'] = LANDING_PAGE_TEMPLATE;
        }
        elseif( count($global_params['page_arguments']['gtp'])==1 && $global_params['page_arguments']['gtp'][0] == "CustomerFeedback" ) {
            $page_params['page_dir_file_name'] = implode("/", $global_params['page_arguments']['gtp']);
            $page_params['template'] = FEEDBACK_PAGE_TEMPLATE;
            //ppr($page_params); ppr($global_params); exit;
        }
        elseif( isset($global_params['session_arguments']['userId']) && !empty($global_params['session_arguments']['userId']) ) {
            if( $global_params['page_arguments']['gtp'][0] == "login" && $global_params['page_arguments']['action'] != "logout" ) {
                $page_params['page_dir_file_name'] = "hotels/waitTime";
                header("Location: ".HTTP_BASE_PATH.$page_params['page_dir_file_name'].".html");
                exit;
            }
            else {
                $page_params['page_dir_file_name'] = implode("/", $global_params['page_arguments']['gtp']);
                $page_params['template'] = $global_params['template'];
                //ppr($page_params); ppr($global_params); exit;
            }
        }
        elseif( count($global_params['page_arguments']['gtp'])==1 && $global_params['page_arguments']['gtp'][0] == "login" ) {
            $page_params['page_dir_file_name'] = implode("/", $global_params['page_arguments']['gtp']);
            $page_params['template'] = $global_params['template'];
            //ppr($page_params); ppr($global_params); exit;
        }
        else {
            header("location: ".HTTP_BASE_PATH."login.html");
            exit;
        }
}

function display_template()
{
	global $global_params;
	global $page_params;
	$pageArgs = $global_params['page_arguments'];
        
        if( isset($pageArgs['aj']) && $pageArgs['aj'] == 1 ) {
            $fileName = realpath(PAGES_DIR.$page_params['page_dir_file_name'].".php");
            if( substr($fileName, 0, strlen(BASE_PATH)) == BASE_PATH && file_exists($fileName) ) {
                require_once $fileName;
            }
            else {
                $return = array("status" => 0);
                echo json_encode($return);
                exit;
            }
        }
	elseif( validate_page_filepath() )
	{
            if( file_exists(TEMPLATE_DIR.$page_params['template'].".tpl.php"))
            {
                include (TEMPLATE_DIR.$page_params['template'].".tpl.php");
            }
            else
            {
                include(TEMPLATE_DIR."default.tpl.php");
            }
	}
	else
	{
            if(count($global_params['page_arguments']['gtp']) <= 0)
            {
                header("location: /login.html");
                exit;
            }
            else
            {
                header("location: /404.html");
                print "Page Not Found<br />"; exit;
            }
	}
	
}

function make_session_active()
{
	global $global_params;
	global $page_params;
	$lifeTime = time() + 60*60*24; //one day
	session_set_cookie_params($lifeTime);
	session_start();
	
	$global_params['session_arguments'] = array();
	
	if( is_array($_SESSION) )
	{
		foreach($_SESSION as $key => $val)
		{
			if( is_array($val) && !empty($val) )
			{
				$global_params['session_arguments'][$key] = $val;
			}
			elseif(strlen($val))
			{
				$global_params['session_arguments'][$key] = $val;
			} 
		}
	}
}

function validate_page_filepath()
{
	global $page_params;
	
	$init_path = realpath(PAGES_DIR.$page_params['page_dir_file_name']."_init.php");
	$tpl_path = realpath(PAGES_DIR.$page_params['page_dir_file_name'].".tpl.php");
	
	if( (substr($init_path, 0, strlen(BASE_PATH)) == BASE_PATH) && (substr($tpl_path, 0, strlen(BASE_PATH)) == BASE_PATH) )
	{
		return true;
	}
	else
	{
		return false;
	}
}

function set_db_active_new($DB_CONST_NAME, $options = array() )
{
	global $global_params;
	$array_const = get_defined_constants(true);echo $DB_CONST_NAME."|";
	$DB_URL_CONST = $array_const['user'][$DB_CONST_NAME];echo $DB_URL_CONST."|";
	ppr($array_const['user']);exit;
	$db_type = substr($DB_URL_CONST, 0, strpos($DB_URL_CONST,'://'));
	
	$handler = CLASS_DIR."database.class.".$db_type.".inc.php";
	
	if(is_file($handler))
		include_once $handler;
	else
	{
		die("File ".$handler." not found");
	}
	
	$url = parse_url($DB_URL_CONST);
	$url['user'] = urldecode($url['user']);
	$url['pass'] = urldecode($url['pass']);
	$url['host'] = urldecode($url['host']);
	$url['database'] = substr(urldecode($url['path']),1);
	
	if( isset($url['port']))
	{
		$url['host'] = $url['host'].":".$url['port'];
	}
	
	$global_params["db_indv_conns"][$DB_CONST_NAME] = new Database($url['host'], $url['database'], $url['user'], $url['pass'], $options);
	
	if( !$global_params["db_indv_conns"][$DB_CONST_NAME]->db_connect() )
	{
		die("<html><body><div>Unable to connect db at: <br /> Host: <b>".$url['host']."</b><br />Database: <b>".$url['database']."</b><br />User: <b>".$url['user']."</b></div></body></html>");
		return false;
	}
	else
	{
		return true;
	}
}

//function to close db conection
function set_db_close_new(){

        global $global_params;
        if (is_array($global_params["db_indv_conns"])) {
                $conns = array_keys($global_params["db_indv_conns"]);
                for($i=0; $i<count($conns); $i++){
                        if($global_params["db_indv_conns"][$conns[$i]]){
                                $global_params["db_indv_conns"][$conns[$i]]->db_close();
                        }
                }
        }
        return;

}//end of set_db_connection_close_new

function check_cookie_set()
{
	global $global_params;

	if( !isset($_COOKIE[CART_COOKIE]) )
	{
		if( isset($_SESSION[CART_SESSION]) )
		{
			$session_val = $cookie_val = $_SESSION[CART_SESSION];
			$unique_time_frame = 3600; //expire in 1 hour
			setcookie(CART_COOKIE,$cookie_val,time()+$unique_time_frame);
			if( !isset($_SESSION[$session_val]) )
			      $_SESSION[$session_val] = array();
		}
		else
		{
			$cookie_val = substr( md5(time().uniqid(mt_rand(), true)), 0, 10);
			$unique_time_frame = 3600; //expire in 1 hour
			setcookie(CART_COOKIE,$cookie_val,time()+$unique_time_frame);
			$_SESSION[CART_SESSION] = $cookie_val;
			$_SESSION[$cookie_val] = array();
		}
	}
	else
	{
		$cookie_val = $_COOKIE[CART_COOKIE];
		if( !isset($_SESSION[CART_SESSION]) )
		{
			$_SESSION[CART_SESSION] = $cookie_val;
			if( !isset($_SESSION[$cookie_val]) )
			{
			      $_SESSION[$cookie_val] = array();
			}
		 }
		 elseif( !isset($_SESSION[$cookie_val]) )
		 {
			 $_SESSION[$cookie_val] = array();
		 }
	}
	
}

// function is used to encrypt the data
function encrypt($text)
{
	/*global $encryption_iv,$encryption_key;
	$text = trim($text);
	$text = mcrypt_cfb (MCRYPT_TWOFISH, $encryption_key, $text, MCRYPT_ENCRYPT, $encryption_iv);
	return bintohex(trim(chop(base64_encode($text))));*/

	$iv_size = mcrypt_get_iv_size(MCRYPT_XTEA, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$encryption_key = "@#MCX%@CADas";

	return  $enc = bintohex(mcrypt_encrypt(MCRYPT_XTEA, $encryption_key, $text, MCRYPT_MODE_ECB, $iv));

}

// function is used to  dencrypt the data
function decrypt($encrypted_text)
{
	/*	global $encryption_iv,$encryption_key;
	$encrypted_text =trim(chop(base64_decode(hextobin($encrypted_text))));
	$decrypted_text = mcrypt_cfb (MCRYPT_TWOFISH, $encryption_key, $encrypted_text, MCRYPT_DECRYPT, $encryption_iv);
	return trim(chop($decrypted_text));
	*/

	$encryption_key = "@#MCX%@CADas";
	$iv_size = mcrypt_get_iv_size(MCRYPT_XTEA, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	return  $crypttext = trim(mcrypt_decrypt(MCRYPT_XTEA, $encryption_key, hextobin($encrypted_text), MCRYPT_MODE_ECB, $iv));

}

// function to convert binary to hexdecimal
function bintohex($data)  {
	return bin2hex($data);
}

// function to convert hexdecimal for binary
function hextobin($data)  {
	$len = strlen($data);
	return pack("H" . $len, $data);
}


function func_check_bid_pid($str_db_conn_obj,$decode_bid,$decode_pid)
{
	$query = "call sp_check_bid_pid($decode_bid,$decode_pid)";
	$str_db_conn_obj->db_query($query);
	
	if($str_db_conn_obj->errnum >0)
	{
		$ret['error_code'] = 1;
		$ret['err_msg'] = "DB Error";
		return false;
	}
	else
	{
		$ret = $str_db_conn_obj->db_fetch_array();
		if($ret['error_code'] == 0)
			return true;
		else
			return false;	
	}
}

function __autoload( $className ) {
    global $global_params;
    global $page_params;
    
    $fileLocs = array(CLASS_DIR,FUNCTIONS_DIR);
    $classFound = false;
    foreach( $fileLocs as $dirPath ) {
        $classFileName = $dirPath.$className.".class.php";
        if(file_exists($classFileName) ) {
            $classFound = true;
            require_once $classFileName;
        }
    }
    
    if( !$classFound ) {
        die("Class $className not found");
    }
}
?>