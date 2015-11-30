DROP PROCEDURE IF EXISTS sp_insert_order;
CREATE PROCEDURE sp_insert_order
(
  arg_cust_id VARCHAR(255),
  arg_order_date DATE,
  arg_order_cost DECIMAL(33,22)
)
BEGIN
    SET @query = '';
    SET @query = CONCAT(
		  'INSERT INTO tbl_order_master
		   (cust_id,order_date,order_cost) 
		   VALUES 
		   ("',arg_cust_id,'","',arg_order_date,'","',arg_order_cost,'")'
		  );

    PREPARE stmt from @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

    SELECT LAST_INSERT_ID() AS order_id;
END;