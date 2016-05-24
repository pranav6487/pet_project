DROP TABLE IF EXISTS tbl_feedback;
CREATE TABLE tbl_feedback
(
  feedback_id int(10) unsigned not null auto_increment,
  booking_id int(10) unsigned not null,
  rest_id int(10) unsigned not null,
  ambience int(10) unsigned not null,
  food_qaulity int(10) unsigned not null,
  staff_friendly int(10) unsigned not null,
  cleanliness int(10) unsigned not null,
  service_speed int(10) unsigned not null,
  recommend int(10) unsigned not null,
  comments text,
  created_on int(10) unsigned not null,
  primary key (feedback_id)
);