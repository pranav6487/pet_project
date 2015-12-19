DROP TABLE IF EXISTS tbl_users;
CREATE TABLE tbl_users
(
  user_id int(10) unsigned not null auto_increment,
  user_email varchar(100) not null,
  user_passwd varchar(255) not null,
  user_type int(10) unsigned not null,
  rest_id int(10) unsigned not null,
  status tinyint(3) unsigned default 1,
  created_on int(10) unsigned not null,
  updated_on int(10) unsigned default null,
  primary key (user_id)
);