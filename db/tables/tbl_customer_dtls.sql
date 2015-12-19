DROP TABLE IF EXISTS tbl_customer_dtls;
CREATE TABLE tbl_customer_dtls
(
  customer_id int(10) unsigned not null auto_increment,
  customer_name varchar(255) not null,
  customer_number int(10) unsigned not null,
  is_duplicate tinyint(3) unsigned not null default 0,
  created_on int(10) unsigned not null,
  updated_on int(10) unsigned not null,
  primary key (customer_id)
);