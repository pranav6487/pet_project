DROP PROCEDURE IF EXISTS reset_all_db;
CREATE PROCEDURE reset_all_db()
BEGIN
    truncate tbl_booking_dtls;
    update tbl_party_rest_relation set next_avail_at = 0;
    truncate tbl_customer_dtls;
    truncate tbl_feedback;
END;