DROP TABLE IF EXISTS tbl_party_rest_relation;
CREATE TABLE tbl_party_rest_relation
(
  party_rel_id int(10) unsigned not null auto_increment,
  rest_id int(10) unsigned not null,
  no_of_people int(10) unsigned not null,
  eligible_tables varchar(255) not null,
  avg_time int(10) unsigned not null,
  buffer_time int(10) unsigned not null,
  next_avail_at int(10) unsigned not null default 0,
  status tinyint(3) unsigned default 1,
  created_on int(10) unsigned not null,
  updated_on int(10) unsigned default null,
  primary key (party_rel_id)
);