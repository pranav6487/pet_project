<?php
global $global_params;
global $page_params;

require_once FUNCTIONS_DIR."common.functions.inc.php";
require_once FUNCTIONS_DIR."cart.functions.php";
require_once FUNCTIONS_DIR."mobile.functions.php";
require_once LIB_DIR."JSON.php";

$page_params['page_title'] = "Cart";

set_db_active_new('DB_URL');

if( !isset($_COOKIE[CART_COOKIE]) )
{
	if( isset($_SESSION[CART_SESSION]) )
	{
		check_cookie_set();
	}
	else
	{
		echo "Cookie disbaled for the browser";
		exit;
	}
}

if( !isset($_SESSION['mobile_flag']) && !isset($_SESSION['mobile_device']) )
{
	$mobile_detect = mobile_device_detect();
	$_SESSION['mobile_flag'] = $mobile_detect['mobile_browser'];
	$_SESSION['mobile_device'] = $mobile_detect['status'];
}

if( $_SESSION['mobile_flag'] )
{
	$scan_link = func_get_barcode_scan_link($_SESSION['mobile_device']);
}
//p($global_params['page_arguments']); exit;
if( isset($_SESSION[CART_SESSION]) && !empty($_SESSION[CART_SESSION]) )
{
	$session_val = $_SESSION[CART_SESSION];
	
	if( is_array($_SESSION[$session_val]) )
	{
		if( isset($global_params['page_arguments']['ajax']) && $global_params['page_arguments']['ajax'] == 'yes' )
		{
			if( isset($global_params['page_arguments']['action']) && $global_params['page_arguments']['action'] == "set_order" )
			{
				$bid = $global_params['page_arguments']['bid'];
				$pid = $global_params['page_arguments']['pid'];
				$pd_dtl_id = $global_params['page_arguments']['pd_dtl_id'];
				$no_of_item = $global_params['page_arguments']['no_of_item'];
				$total_cost = $global_params['page_arguments']['total_cost'];
				
				$_SESSION[$session_val."_order_dtl"][$bid."@#@".$pid]['pd_dtl_id'] = $pd_dtl_id;
				$_SESSION[$session_val."_order_dtl"][$bid."@#@".$pid]['no_of_item'] = $no_of_item;
				
				$_SESSION[$session_val."_order_dtl"]['total_cost'] = $total_cost;
				
				$res['error_code'] = 0;
				$res['err_msg'] = "success";
				
				$json = new Services_JSON();		
				header("Content-Type: text/plain");
				echo $json->encode($res);		
			
				exit;
			}
			
			if( isset($global_params['page_arguments']['action']) && $global_params['page_arguments']['action'] == "del_order" )
			{
				$bid = $global_params['page_arguments']['bid'];
				$pid = $global_params['page_arguments']['pid'];
				
				unset($_SESSION[$session_val][$bid."@#@".$pid]);
				unset($_SESSION[$session_val."_order_dtl"][$bid."@#@".$pid]);
				
				if( count($_SESSION[$session_val."_order_dtl"]) == 1 )
				{
					unset($_SESSION[$session_val."_order_dtl"]);
				}

				$res['error_code'] = 0;
				$res['err_msg'] = "success";
				
				$json = new Services_JSON();		
				header("Content-Type: text/plain");
				echo $json->encode($res);		
			
				exit;
			}
		}
		//p($global_params['page_arguments']); exit;
		if( isset($global_params['page_arguments']['action']) && $global_params['page_arguments']['action'] == "cancel" )
		{
			unset($_SESSION[$session_val]);
			unset($_SESSION[$session_val."_order_dtl"]);
			unset($_SESSION[CART_SESSION]);
			
			$_SESSION['error_code'] = 0;
			$_SESSION['err_msg'] = "Thank you for your time.\nIf you feel like shopping again, you can start below";
			header("location: /shop/shop.html");
			exit;
		}
		
		if( isset($global_params['page_arguments']['action']) && $global_params['page_arguments']['action'] == "submit" )
		{
			//p($global_params['page_arguments']);
			if( isset($global_params['page_arguments']['bid_pid']) and !empty($global_params['page_arguments']['bid_pid']) )
			{
				$bid_pid_arr = $global_params['page_arguments']['bid_pid'];
				$pd_dtl_arr = $global_params['page_arguments']['pd_dtl_id'];
				$unit_prize_arr = $global_params['page_arguments']['unit_prize'];
				$no_items_arr = $global_params['page_arguments']['no_of_item'];
				$total_cost = $global_params['page_arguments']['total_cost'];
				
				$tmp_arr = array();
				for($i=0;$i<count($bid_pid_arr);$i++)
				{
					$arr = array();
					$arr['pd_dtl_id'] = $pd_dtl_arr[$i];
					$arr['unit_prize'] = $unit_prize_arr[$i];
					$arr['no_of_item'] = $no_items_arr[$i];
					
					$tmp_arr[$bid_pid_arr[$i]] = $arr;
				}
				$_SESSION[$session_val."_order_dtl"] = $tmp_arr;
				$_SESSION[$session_val."_order_dtl"]['total_cost'] = $total_cost; 
				
				header("location: /shop/order.html");
				exit;
			}
		}
	
		if( isset($global_params['page_arguments']['bid']) && $global_params['page_arguments']['bid'] && isset($global_params['page_arguments']['pid']) && $global_params['page_arguments']['pid'] )
		{
			//USE THE BELOW LINES WHEN YOU DO NOT HAVE MY_CRYPTE INSTALLED IN PHP
			$bid = base64_decode($global_params['page_arguments']['bid']);
			$pid = base64_decode($global_params['page_arguments']['pid']);
			
			//USE THE BELOW LINES WHEN YOU HAVE MY_CRYPT INSTALLED IN PHP
			//$bid = decrypt($global_params['page_arguments']['bid']);
			//$pid = decrypt($global_params['page_arguments']['pid']);
			
			if( !array_key_exists($bid."@#@".$pid,$_SESSION[$session_val]) )
			{
				$ret_arr = func_get_brand_product_dtl($global_params["db_indv_conns"]['DB_URL'],$bid,$pid);
				$_SESSION[$session_val][$bid."@#@".$pid] = $ret_arr['session_cart'];
				$_SESSION[$session_val."_order_dtl"][$bid."@#@".$pid] = $ret_arr['session_order'];			
			}
		}
		
		if( isset($global_params['page_arguments']['action_shop']) && $global_params['page_arguments']['action_shop'] == "shop" )
		{
			$product_id = $global_params['page_arguments']['shop_pid'];
			$explode = explode("@",$product_id);
			$bid = $explode[0];
			$pid = $explode[1];
			
			if( func_check_bid_pid($global_params["db_indv_conns"]['DB_URL'],$bid,$pid) )
			{
				if( !array_key_exists($bid."@#@".$pid,$_SESSION[$session_val]) )
				{
					$ret_arr = func_get_brand_product_dtl($global_params["db_indv_conns"]['DB_URL'],$bid,$pid);
					$_SESSION[$session_val][$bid."@#@".$pid] = $ret_arr['session_cart'];
					$_SESSION[$session_val."_order_dtl"][$bid."@#@".$pid] = $ret_arr['session_order'];
				}
			}
			else
			{
				$err_msg = "Oops! Could not fetch the product details.\nPlease scan the barcode again or enter the product id below\n";
			}
		}
		
		//p($_SESSION[$session_val."_order_dtl"]);
		if( empty($_SESSION[$session_val]) )
		{
			$no_data = true;
			$tbl_str = '<div class="product-cart">
							No Item Selected
						</div>';
		}
		else
		{
			$i = 0;
			$tbl_str = "";
			$total_cost = 0;
			foreach($_SESSION[$session_val] as $key => $value)
			{
				$pd_dtl_id = '';
				$no_of_item = 1;
				
				if( array_key_exists($key,$_SESSION[$session_val."_order_dtl"]) )
				{
					$pd_dtl_id = $_SESSION[$session_val."_order_dtl"][$key]['pd_dtl_id'];
					$no_of_item = $_SESSION[$session_val."_order_dtl"][$key]['no_of_item'];
					
					$cart_session_arr = array();
					$cart_session_arr = $_SESSION[$session_val][$key];
					$pd_dtl_arr = $_SESSION[$session_val][$key]['product_dtl'];
					
					$bid = $cart_session_arr['bid'];
					$pid = $cart_session_arr['pid'];
					$brand_desc = $cart_session_arr['brand_description'];
					$brand_name = $cart_session_arr['brand_name'];
					$pd_name = $cart_session_arr['pd_name'];
					$pd_desc = $cart_session_arr['pd_desc'];
				}
				else
				{
					$bid = $value['bid'];
					$pid = $value['pid'];
					$brand_desc = $value['brand_description'];
					$brand_name = $value['brand_name'];
					$pd_name = $value['pd_name'];
					$pd_desc = $value['pd_desc'];
				}
				$i++;
				$tbl_str .= "<div class='product-cart' id='row_".$bid."_".$pid."'>";
				$tbl_str .= "<p>By ".$brand_name."</p>";
				$tbl_str .= "<h2>".$pd_name."</h2>";
				$tbl_str .= "<p title='".$pd_desc."'>".substr($pd_desc,0,80)."...</p>";
				
				$onchange_func = "onchange= \"get_pd_unit_prize(this.id,'".$bid."','".$pid."');\"";
				$sel_str = "<select id='pd_dtl_id_".$bid."_".$pid."' name='pd_dtl_id[]' $onchange_func>";
				
				$j = 0;
				foreach($value['product_dtl'] as $key1 => $value1)
				{
					$selected = '';
					if($value1['product_dtl_id'] == $pd_dtl_id)
					{
						$meteric_type = $pd_dtl_arr[$pd_dtl_id]['meteric_type'];
						$meteric_name = $pd_dtl_arr[$pd_dtl_id]['meteric_name'];
						$meteric_val = $pd_dtl_arr[$pd_dtl_id]['meteric_val'];
						$unit_prize = $pd_dtl_arr[$pd_dtl_id]['unit_prize'];
						$discount = $pd_dtl_arr[$pd_dtl_id]['discount'];
						$quant_per_unit = $pd_dtl_arr[$pd_dtl_id]['quant_per_unit_type'];
						$pd_attr = $pd_dtl_arr[$pd_dtl_id]['pd_attr'];
						
						$selected = "selected";
					}
					else
					{
						//$pd_dtl_id = $value1['product_dtl_id'];
						$meteric_type = $value1['meteric_type'];
						$meteric_name = $value1['meteric_name'];
						$meteric_val = $value1['meteric_val'];
						if( $j == 0)
						{
							$unit_prize = $value1['unit_prize'];
						}
						$discount = $value1['discount'];
						$quant_per_unit = $value1['quant_per_unit_type'];
						$pd_attr = $value1['pd_attr'];
					}
					
					if( $value1['meteric_type'] == 'fixed')
					{
						$sel_str .= "<option value='".$value1['product_dtl_id']."' selected='selected'>1 pcs</option";
					}
					else
					{
						if( $value1['meteric_val'] == 0)
						{
							$sel_str .= "<option $selected value='".$value1['product_dtl_id']."' >".$meteric_name."</option>";
						}
						else
						{
							$sel_str .= "<option $selected value='".$value1['product_dtl_id']."' >".$meteric_val." ".$meteric_name."</option>";
						}
					}
					
					$j++;
				}
				$sel_str .= "</select>";
				
				$tbl_str .= "$sel_str&nbsp;";
				
				$tbl_str .= "<input id='unit_prize_".$bid."_".$pid."' name='unit_prize[]' type='hidden' value='".$unit_prize."' size='2' />";
				
				$tbl_str .= "<input type='text' id='no_of_item_".$bid."_".$pid."' name='no_of_item[]' value='".$no_of_item."' onblur=\"get_pd_total_cost('".$bid."','".$pid."')\" size='2' />";
				
				$cost_per_pd = $unit_prize*$no_of_item;
				$tbl_str .= "<input type='hidden' id='total_cost_".$bid."_".$pid."' name='total_cost[]' value='".$cost_per_pd."' size='2' /> <input type='hidden' id='ids_".$bid."_".$pid."' name='bid_pid[]' value='".$bid."@#@".$pid."' />";
				
				$tbl_str .= "<label>Amount <a href='javascript:void(0);' onclick=\"remove_row('".$bid."','".$pid."');\" title='Remove'>(Remove)</a></label>";
				$tbl_str .= "<h2 class='item' id='display_cost_".$bid."_".$pid."'>Rs $cost_per_pd</h2>";
				$tbl_str .= "</div>";
				
				$total_cost = $total_cost + $cost_per_pd;
			}
			
			$tbl_str .= "<label>Total: </label><h2 class='item display_total_cost'>Rs $total_cost</h2><input type='hidden' id='total_cost' name='total_cost' value='$total_cost' />";
			$json = new Services_JSON();
			$json_cart = $json->encode($_SESSION[$session_val]);
		}
	}
	else
	{
		$_SESSION[$session_val] = array();
		$tbl_str = "
		<tr>
			<td colspan='6' align='center'>
				No Item Selected
			</td>
		</tr>";
	}
}
else
{
	header("location: /shop/shop.html");
	exit;
}
?>