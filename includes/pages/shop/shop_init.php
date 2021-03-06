<?php
global $global_params;
global $page_params;

require_once FUNCTIONS_DIR."common.functions.inc.php";
require_once FUNCTIONS_DIR."shop.functions.php";
require_once FUNCTIONS_DIR."mobile.functions.php";

if( !isset($_SESSION['mobile_flag']) && !isset($_SESSION['mobile_device']) )
{
	$mobile_detect = mobile_device_detect();
	$_SESSION['mobile_flag'] = $mobile_detect['mobile_browser'];
	$_SESSION['mobile_device'] = $mobile_detect['status'];
}

$page_params['page_title'] = "Shop";

set_db_active_new("DB_URL");

check_cookie_set();

if( isset($global_params['page_arguments']['action_shop']) && $global_params['page_arguments']['action_shop'] == "shop" )
{
	$product_id = $global_params['page_arguments']['shop_pid'];
	$explode = explode("@",$product_id);
	$bid = $explode[0];
	$pid = $explode[1];
	
	if( func_check_bid_pid($global_params["db_indv_conns"]['DB_URL'],$bid,$pid) )
	{
		//USE THE BELOW LINES WHEN YOU DO NOT HAVE MY_CRYPTE INSTALLED IN PHP
		$encoded_bid = base64_encode($bid);
		$encoded_pid = base64_encode($pid);
		
		//USE THE BELOW LINES WHEN YOU HAVE MY_CRYPT INSTALLED IN PHP
		//$encoded_bid = decrypt($bid);
		//$encoded_pid = decrypt($pid);
		
		header("location: /shop/cart.html?bid=$encoded_bid&pid=$encoded_pid");
		exit;
	}
	else
	{
		$err_msg = "Oops! Could not fetch the product details.\nPlease scan the barcode again or enter the product id below\n";
	}
}

if( isset($global_params['page_arguments']['bid']) && isset($global_params['page_arguments']['pid']) )
{
	$bid = $global_params['page_arguments']['bid'];
	$pid = $global_params['page_arguments']['pid'];
	
	$decode_bid = base64_decode($bid);
	$decode_pid = base64_decode($pid);
	
	if( func_check_bid_pid($global_params["db_indv_conns"]['DB_URL'],$decode_bid,$decode_pid) )
	{
		header("location: /shop/cart.html?bid=$bid&pid=$pid");
		exit;
	}
	else
	{
		$err_msg = "Oops! Could not fetch the product details.\nPlease scan the barcode again or enter the product id below\n";
	}
}

if( $_SESSION['mobile_flag'] )
{
	$scan_link = func_get_barcode_scan_link($_SESSION['mobile_device']);
}

if( isset($_SESSION[CART_SESSION]) && !empty($_SESSION[CART_SESSION]) )
{
	$session_val = $_SESSION[CART_SESSION];
	if( is_array($_SESSION[$session_val]) && !empty($_SESSION[$session_val]) && is_array($_SESSION[$session_val."_order_dtl"]) && !empty($_SESSION[$session_val."_order_dtl"]) )
	{
		$i=0;
		$str = "";
		$total_cost = $_SESSION[$session_val."_order_dtl"]['total_cost'];
		
		$str .= '<ul>';
		foreach($_SESSION[$session_val."_order_dtl"] as $key => $value)
		{
			if(strstr($key,"@#@"))
			{
				$i++;
				$pd_name = $_SESSION[$session_val][$key]['pd_name'];
				$no_of_item = $value['no_of_item'];
				
				if($i%2 == 0)
				{
					$li_class = "class='even'";
				}
				else
				{
					$li_class = "class='odd'";
				}
				$str .= "<li $li_class><a href='javascript:void(0);' title='$no_of_item x $pd_name'><b>$no_of_item</b> $pd_name</a></li>";
			}
		}
		$str .= '</ul>';
	}
}
?>