<?php
function func_get_cust_id($str_db_conn_obj,$cust_dtl_arr)
{
	$query = "call sp_get_insert_cust_dtl('{$cust_dtl_arr['cust_name']}','{$cust_dtl_arr['cust_no']}','{$cust_dtl_arr['cust_add']}','{$cust_dtl_arr['cust_pincode']}','{$cust_dtl_arr['cust_email']}')";
	//echo $query."<br />";
	$str_db_conn_obj->db_query($query);
	
	if($str_db_conn_obj->errnum >0)
	{
		$ret['error_code'] = 1;
		$ret['err_msg'] = "DB Error";	
	}
	else
	{
		$ret = $str_db_conn_obj->db_fetch_array();
	}
	
	return $ret;
}

function func_insert_order($str_db_conn_obj,$order_cost,$cust_id)
{
	$order_date = date("Y-m-d");
	
	$query = "call sp_insert_order('{$cust_id}','{$order_date}','{$order_cost}')";
	//echo $query."<br />";
	$str_db_conn_obj->db_query($query);
	
	if($str_db_conn_obj->errnum >0)
	{
		$ret['error_code'] = 1;
		$ret['err_msg'] = "DB Error";	
	}
	else
	{
		$ret = $str_db_conn_obj->db_fetch_array();
	}
	
	return $ret;
}

function func_insert_order_dtls($str_db_conn_obj,$order_dtl_arr,$order_id)
{
	foreach($order_dtl_arr as $key => $value)
	{
		if(strpos($key,"@#@"))
		{
			$explode = explode("@#@",$key);
			$bid = $explode[0];
			$pid = $explode[1];
			
			$total_cost = $value['unit_prize']*$value['no_of_item'];
			
			$query = "call sp_insert_order_details('{$order_id}','{$bid}','{$pid}','{$value['pd_dtl_id']}','{$value['unit_prize']}','{$value['no_of_item']}','{$total_cost}')";
			
			$str_db_conn_obj->db_query($query);
			
			if($str_db_conn_obj->errnum >0)
			{
				$ret['error_code'] = 1;
				$ret['err_msg'] = "DB Error";
				return $ret;
			}
		}
	}
	
	$ret['error_code'] = 0;
	$ret['err_msg'] = "success";
	
	return $ret;
}
?>