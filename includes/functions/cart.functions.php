<?php
function func_get_brand_product_dtl($str_db_conn_obj,$bid,$pid)
{
	$tmp_arr = array();
	$tmp_arr_pdt_dtl = array();
	$tmp_order_arr = array();
	$tmp_arr['bid'] = $bid;
	$tmp_arr['pid'] = $pid;
	
	$query = "call sp_fetch_brand_product_dtls($bid,$pid)";
	$str_db_conn_obj->db_query($query);
	$i = 0;
	while($row = $str_db_conn_obj->db_fetch_array() )
	{
		$tmp_arr['pd_name'] = $row['pd_name'];
		$tmp_arr['pd_desc'] = $row['pd_desc'];
		$tmp_arr['brand_name'] = $row['brand_name'];
		$tmp_arr['brand_description'] = $row['brand_description'];
		
		if( $i == 0)
		{
			$tmp_order_arr['pd_dtl_id'] = $row['product_dtl_id'];
			$tmp_order_arr['no_of_item'] = 1;
		}
		$tmp_arr_pdt_dtl['product_dtl_id'] = $row['product_dtl_id'];
		$tmp_arr_pdt_dtl['meteric_type'] = $row['meteric_type'];
		$tmp_arr_pdt_dtl['meteric_name'] = $row['meteric_name'];
		$tmp_arr_pdt_dtl['meteric_val'] = $row['meteric_val'];
		$tmp_arr_pdt_dtl['unit_prize'] = $row['unit_prize'];
		$tmp_arr_pdt_dtl['discount'] = $row['discount'];
		$tmp_arr_pdt_dtl['quant_per_unit_type'] = $row['quant_per_unit_type'];
		$tmp_arr_pdt_dtl['pd_attr'] = $row['pd_attr'];
		
		$tmp_arr['product_dtl'][$row['product_dtl_id']] = $tmp_arr_pdt_dtl;
		
		$i++;
	}
	$ret_arr['session_cart'] = $tmp_arr;
	$ret_arr['session_order'] = $tmp_order_arr;
	return $ret_arr;
}
?>