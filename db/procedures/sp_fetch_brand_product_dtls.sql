DROP PROCEDURE IF EXISTS sp_fetch_brand_product_dtls;
CREATE PROCEDURE sp_fetch_brand_product_dtls
(
    arg_brand_id int,
    arg_product_id int
)
BEGIN
    SET @query = CONCAT('
      SELECT 
	a.pd_name, a.pd_desc, b.product_dtl_id, b.meteric_type, b.meteric_name, b.meteric_val, b.unit_prize, b.discount,b.quant_per_unit_type, b.pd_attr,c.brand_name, c.brand_description
      FROM tbl_product_master a
      INNER JOIN tbl_product_details b
	ON a.product_id = b.product_id
      INNER JOIN tbl_brand_details c
	ON a.brand_id = c.brand_id
      WHERE a.product_id = ',arg_product_id,' AND a.brand_id = ',arg_brand_id,''
    );

    PREPARE stmt from @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END;

select a.pd_name, a.pd_desc, b.product_dtl_id, b.meteric_type, b.meteric_name, b.meteric_val, b.unit_prize, b.discount, b.quant_per_unit_type, b.pd_attr,
c.brand_name, c.brand_description
from tbl_product_master a
inner join tbl_product_details b on
a.product_id = b.product_id
inner join tbl_brand_details c on
a.brand_id = c.brand_id
where a.product_id = 1 and a.brand_id = 1;