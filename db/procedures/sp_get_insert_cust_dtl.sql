DROP PROCEDURE IF EXISTS sp_get_insert_cust_dtl;
CREATE PROCEDURE sp_get_insert_cust_dtl
(
  arg_cust_name VARCHAR(255),
  arg_cust_number VARCHAR(255),
  arg_cust_add VARCHAR(255),
  arg_cust_pincode VARCHAR(255),
  arg_cust_email VARCHAR(255)
)
BEGIN
    SET @query = '';
    IF((SELECT count(1) FROM tbl_customer_details WHERE cust_no = arg_cust_number AND cust_email = arg_cust_email) = 1) THEN
	SET @query1 = CONCAT(
		      'SELECT cust_id 
		      FROM tbl_customer_details 
		      WHERE cust_no = "',arg_cust_number,'" AND cust_email = "',arg_cust_email,'"'
			    );
	
	PREPARE stmt from @query1;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;

	set @query2 = CONCAT(
		      'UPDATE tbl_customer_details 
		      SET last_visit = CURRENT_TIMESTAMP 
		      WHERE cust_no = "',arg_cust_number,'" AND cust_email = "',arg_cust_email,'"'
			    );
	
	PREPARE stmt from @query2;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
    ELSE
	SET @query1 = CONCAT(
		      'INSERT INTO tbl_customer_details 
		      (cust_name,cust_no,cust_add,cust_pincode,cust_email,last_visit) 
		      VALUES ("',arg_cust_name,'","',arg_cust_number,'","',arg_cust_add,'","',arg_cust_pincode,'","',arg_cust_email,'",CURRENT_TIMESTAMP)'
			    );

	PREPARE stmt from @query1;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;

	SET @query2 = CONCAT('SELECT LAST_INSERT_ID() as cust_id');

	PREPARE stmt from @query2;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
    END IF;
END;