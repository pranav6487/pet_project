<?php
global $global_params;
global $page_params;

require_once FUNCTIONS_DIR."common.functions.inc.php";
require_once FUNCTIONS_DIR."order.functions.php";
require_once LIB_DIR."JSON.php";

$page_params['page_title'] = "Checkout";


set_db_active_new('DB_URL');

if( !isset($_COOKIE[CART_COOKIE]) )
{
	echo "Cookie disbaled for the browser";
	exit;
}

if( isset($_SESSION[CART_SESSION]) && !empty($_SESSION[CART_SESSION]) )
{
	$session_val = $_SESSION[CART_SESSION];
	
	if( is_array($_SESSION[$session_val]) && !empty($_SESSION[$session_val]) )
	{
		$total_cost = $_SESSION[$session_val."_order_dtl"]['total_cost'];
		
		if( isset($global_params['page_arguments']['action']) && $global_params['page_arguments']['action'] == "submit" )
		{
			$err_flag = FALSE;
			//p($_SESSION[$session_val."_order_dtl"]); p($global_params['page_arguments']); exit;
			$order_dtl_arr = $_SESSION[$session_val."_order_dtl"];
			
			$cust_dtl_arr = array();
			$cust_dtl_arr['cust_name'] = $global_params['page_arguments']['cust_name'];
			$cust_dtl_arr['cust_no'] = $global_params['page_arguments']['cust_no'];
			$cust_dtl_arr['cust_add'] = $global_params['page_arguments']['cust_add'];
			$cust_dtl_arr['cust_pincode'] = $global_params['page_arguments']['cust_pincode'];
			$cust_dtl_arr['cust_email'] = $global_params['page_arguments']['cust_email'];
			
			$cust_ret_arr = func_get_cust_id($global_params["db_indv_conns"]['DB_URL'],$cust_dtl_arr);
			if( $cust_ret_arr['error_code'] == 1 )
			{
				$err_flag = TRUE;
				$err_msg = $cust_ret_arr['err_msg'];
			}
			else
			{
				$cust_id = $cust_ret_arr['cust_id'];
			}
			
			if( isset($cust_id) )
			{
				$order_cost = $order_dtl_arr['total_cost'];
				$ins_order = func_insert_order($global_params["db_indv_conns"]['DB_URL'],$order_cost,$cust_id);
				if( $ins_order['error_code'] == 1 )
				{
					$err_flag = TRUE;
					$err_msg = $ins_order['err_msg'];
				}
				else
				{
					$order_id = $ins_order['order_id'];
				}
			}
			
			if( isset($cust_id) && isset($order_id) )
			{
				$ins_order_dtls = func_insert_order_dtls($global_params["db_indv_conns"]['DB_URL'],$order_dtl_arr,$order_id);
			
				if($ins_order_dtls['error_code'] == 0 && $ins_order_dtls['err_msg'] == 'success')
				{
					unset($_SESSION[$session_val]);
					unset($_SESSION[$session_val."_order_dtl"]);
					unset($_SESSION[CART_SESSION]);
					
					$_SESSION['error_code'] = 0;
					$_SESSION['err_msg'] = "Thank you for shopping with us.\nPlease feel free to shop again.\nYour order id is $order_id";
					header("location: /shop/shop.html");
					exit;
				}
				elseif( $ins_order_dtls['error_code'] == 1)
				{
					$err_flag = TRUE;
					$err_msg = $ins_order_dtls['err_msg'];
				}
			}
		}
	}
	else
	{
		header("location: /shop/shop.html");
		exit;
	}
}
else
{
	header("location: /shop/shop.html");
	exit;
}
?>