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

CREATE TABLE news_posts ( --Upload image or use a url
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(511) NOT NULL,
  creation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  edit_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  markdown TEXT,
  PRIMARY KEY (id)
);

CREATE TABLE schools ( --Upload logos as images or use a url
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
); -- Functions needed: get number of schools, get schools

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
  PRIMARY KEY (id)
);

CREATE TABLE tournament_pages (
  id INT NOT NULL AUTO_INCREMENT,
  tournament_date DATE NOT NULL,
  school_id INT NOT NULL,
  tabroom VARCHAR(127),
  contacts VARCHAR(511), --List of ids (1-7 for oversight and then coach ids + 7) separated by commas
  PRIMARY KEY (id),
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

CREATE TABLE rules (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  number INT NOT NULL,
  summary VARCHAR(1023) NOT NULL,
  PRIMARY KEY (id)
);
