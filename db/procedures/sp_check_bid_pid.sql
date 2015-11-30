DROP PROCEDURE IF EXISTS sp_check_bid_pid;
CREATE PROCEDURE sp_check_bid_pid
(
  arg_bid INT(10),
  arg_pid INT(10)
)
BEGIN
    SET @var_error_code = 0;

    IF( (SELECT count(1) FROM tbl_product_master WHERE brand_id = arg_bid AND product_id = arg_pid ) <> 1 ) THEN
	SET @var_error_code = 1;
    END IF;

    SELECT @var_error_code as error_code;
END;