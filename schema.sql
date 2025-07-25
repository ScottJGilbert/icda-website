--REMOVE FROM ROOT BEFORE DISTRIBUTING FOR PRODUCTION

CREATE TABLE users (
  uuid VARCHAR(36) NOT NULL,
  name VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  access_level ENUM('Poster', 'Editor', 'Administrator') NOT NULL,
  PRIMARY KEY (uuid)
);

CREATE TABLE sessions (
  session_id VARCHAR(127) NOT NULL,
  user_uuid VARCHAR(36) NOT NULL,
  ip_address VARCHAR(40),
  user_agent TEXT (4095),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_seen DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (session_id),
  FOREIGN KEY (user_uuid) REFERENCES users(uuid)
);

CREATE TABLE posts (
  id INT NOT NULL AUTO_INCREMENT,
  slug VARCHAR(255) NOT NULL UNIQUE, 
  title VARCHAR(511) NOT NULL,
  image_url VARCHAR(511), 
  creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  edit_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  markdown TEXT,
  PRIMARY KEY (id)
);

CREATE TABLE schools ( --Upload logos as images or use a url
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  image_url VARCHAR(511),
  PRIMARY KEY (id)
);

CREATE TABLE coaches (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(127) NOT NULL,
  email VARCHAR(127),
  school_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

-- Order: President, Secretary, Treasurer, Executive, Technology, Membership/Training, At-Large
CREATE TABLE oversight (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(127) NOT NULL,
  email VARCHAR(127) NOT NULL,
  image_url VARCHAR(511),
  PRIMARY KEY (id)
);

CREATE TABLE tournaments (
  id INT NOT NULL AUTO_INCREMENT,
  date DATE NOT NULL,
  school_id INT NOT NULL, -- Default to 1 for ICDA State but always display harper college
  tabroom VARCHAR(127),
  PRIMARY KEY (id),
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

CREATE TABLE contacts (
  id INT NOT NULL AUTO_INCREMENT,
  tournament INT NOT NULL,
  name VARCHAR(127) NOT NULL,
  email VARCHAR(127) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (tournament) REFERENCES tournaments(id)
);

CREATE TABLE rules (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  number INT NOT NULL,
  summary VARCHAR(1023) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE archiveData(
  id INT NOT NULL AUTO_INCREMENT,
  icda_1_school VARCHAR(255),
  icda_1_date DATE,
  icda_2_school VARCHAR(255),
  icda_2_date DATE,
  icda_3_school VARCHAR(255),
  icda_3_date DATE,
  icda_4_school VARCHAR(255),
  icda_4_date DATE,
  icda_5_school VARCHAR(255),
  icda_5_date DATE,
  icda_state_date DATE,
  archive_time TIMESTAMP DEAFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);
