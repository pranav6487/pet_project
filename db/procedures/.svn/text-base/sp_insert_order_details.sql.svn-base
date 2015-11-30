DROP PROCEDURE IF EXISTS sp_insert_order_details;
CREATE PROCEDURE sp_insert_order_details
(
  arg_order_id INT(10),
  arg_brand_id INT(10),
  arg_product_id INT(10),
  arg_pd_dtl_id INT(10),
  arg_unit_prize DECIMAL(20,10),
  arg_quant INT(10),
  arg_total_prize DECIMAL(33,22)
)
BEGIN
    INSERT INTO tbl_order_details 
    (order_id,brand_id,product_id,product_dtl_id,pd_unit_price,pd_quant,total_price) 
    VALUES (arg_order_id,arg_brand_id,arg_product_id,arg_pd_dtl_id,arg_unit_prize,arg_quant,arg_total_prize);
END;