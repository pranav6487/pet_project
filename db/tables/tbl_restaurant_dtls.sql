DROP TABLE IF EXISTS tbl_restaurant_dtls;
CREATE TABLE tbl_restaurant_dtls
(
  rest_id INT(10) unsigned not null auto_increment,
  rest_name varchar(255) not null,
  rest_loc varchar(255) not null,
  rest_add_1 varchar(255) not null,
  rest_add_2 varchar(255) default null,
  rest_contact_email varchar(255) not null,
  rest_manager_name varchar(255) not null,
  rest_manager_num varchar(255) not null,
  rest_contact1_name varchar(255) not null,
  rest_contact1_num varchar(255) not null,
  rest_contact2_name varchar(255) default null,
  rest_contact2_num varchar(255) default null,
  rest_type varchar(255) not null,
  rest_timings varchar(255) not null,
  status tinyint(3) unsigned default 1,
  created_on int(10) unsigned not null,
  updated_on int(10) unsigned default null,
  PRIMARY KEY (rest_id)
);

/*Alter queries to add columns for email address*/
alter table tbl_restaurant_dtls add rest_manager_email varchar(255) NOT NULL after rest_manager_num, add rest_contact1_email varchar(255) NOT NULL after rest_contact1_num, add rest_contact2_email varchar(255) after rest_contact2_num;

/*New table structure after alter queries*/
CREATE TABLE `tbl_restaurant_dtls` (
  `rest_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rest_name` varchar(255) NOT NULL,
  `rest_loc` varchar(255) NOT NULL,
  `rest_add_1` varchar(255) NOT NULL,
  `rest_add_2` varchar(255) DEFAULT NULL,
  `rest_contact_email` varchar(255) NOT NULL,
  `rest_manager_name` varchar(255) NOT NULL,
  `rest_manager_num` varchar(255) NOT NULL,
  `rest_manager_email` varchar(255) NOT NULL,
  `rest_contact1_name` varchar(255) NOT NULL,
  `rest_contact1_num` varchar(255) NOT NULL,
  `rest_contact1_email` varchar(255) NOT NULL,
  `rest_contact2_name` varchar(255) DEFAULT NULL,
  `rest_contact2_num` varchar(255) DEFAULT NULL,
  `rest_contact2_email` varchar(255) DEFAULT NULL,
  `rest_type` varchar(255) NOT NULL,
  `rest_timings` varchar(255) NOT NULL,
  `status` tinyint(3) unsigned DEFAULT '1',
  `created_on` int(10) unsigned NOT NULL,
  `updated_on` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`rest_id`)
)