DROP TABLE IF EXISTS tbl_table_dtls;
CREATE TABLE tbl_table_dtls
(
  table_id int(10) unsigned not null auto_increment,
  rest_id int(10) unsigned not null,
  table_min_occ int(10) unsigned not null,
  table_max_occ int(10) unsigned not null,
  table_no varchar(100) not null,
  status tinyint(3) unsigned default 1,
  created_on int(10) unsigned not null,
  updated_on int(10) unsigned default null,
  primary key (table_id)
);