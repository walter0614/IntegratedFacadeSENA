
CREATE DATABASE integrated_facade_db;

USE integrated_facade_db;

CREATE TABLE category
(
  id_category int(100) NOT NULL
  AUTO_INCREMENT,
  id int
  (100) DEFAULT NULL,
  name text DEFAULT NULL,
  description text DEFAULT NULL,
  parent int
  (100) DEFAULT NULL,
  visible int
  (100) DEFAULT NULL,
  timemodified text DEFAULT NULL,
  PRIMARY KEY
  (id_category)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


  CREATE TABLE course
  (
    id_course int(100) NOT NULL
    AUTO_INCREMENT,
  id int
    (100) NOT NULL,
  fullname text NOT NULL,
  categoryid int
    (100) NOT NULL,
  startdate text NOT NULL,
  enddate text NOT NULL,
  timecreated text NOT NULL,
  timemodified text NOT NULL,
  PRIMARY KEY
    (`id_course`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


    CREATE TABLE module
    (
      id_module_table int(11) NOT NULL
      AUTO_INCREMENT,
  id int
      (11) NOT NULL,
  name varchar
      (100) NOT NULL,
  summary text NOT NULL,
  section int
      (11) NOT NULL,
  id_module int
      (11) NOT NULL,
  id_section int
      (11) NOT NULL,
  id_course int
      (11) NOT NULL,
  PRIMARY KEY
      (`id_module_table`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


      CREATE TABLE user
      (
        Id int(100) DEFAULT NULL,
        Name varchar(100) DEFAULT NULL,
        Pass varchar(100) DEFAULT NULL
      )
      ENGINE=InnoDB DEFAULT CHARSET=latin1;


      INSERT INTO user
        (Id, Name, Pass)
      VALUES
        (1, 'admin', 'MTIzNA==');


      CREATE TABLE activity
      (
        id_activity int(100) NOT NULL
        AUTO_INCREMENT,
  id int
        (100) NOT NULL,
  name text NOT NULL,
  courseid int
        (100) NOT NULL,
  moduleid int
        (100) NOT NULL,
  CONSTRAINT activity_pk PRIMARY KEY
        (id_activity)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


        CREATE TABLE delivery
(
    id_delivery int PRIMARY key AUTO_INCREMENT,
    id int,
    itemmodule text,
    cmid int,
    grademin int,
    grademax int,
    graderaw int,
    gradedategraded text,
    feedback text,
    userid int
) ENGINE=InnoDB DEFAULT CHARSET=latin1;