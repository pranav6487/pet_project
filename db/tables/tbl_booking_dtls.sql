DROP TABLE IF EXISTS tbl_booking_dtls;
CREATE TABLE tbl_booking_dtls
(
  booking_id int(10) unsigned not null auto_increment,
  rest_id int(10) unsigned not null,
  table_id int(10) unsigned not null,
  party_rel_id int(10) unsigned not null,
  customer_id int(10) unsigned not null,
  no_of_people int(10) unsigned not null,
  status tinyint(3) unsigned not null,
  wait_list_time int(10) unsigned not null,
  seated_time int(10) unsigned not null,
  estd_empty_time int(10) unsigned not null,
  table_empty_time int(10) unsigned not null,
  start_time int(10) unsigned not null,
  end_time int(10) unsigned not null,
  primary key (booking_id)
);