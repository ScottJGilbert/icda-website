CREATE TABLE users (
  uuid VARCHAR(36) NOT NULL,
  name VARCHAR(100) NOT NULL,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL, --MUST BE HASHED WITH BCRYPT!!!!
  access_level ENUM('Poster', 'Editor', 'Administrator') NOT NULL,
  PRIMARY KEY (uuid),
);

CREATE TABLE sessions (
  session_id VARCHAR(128) NOT NULL,
  user_uuid VARCHAR(36) NOT NULL,
  ip_address VARCHAR(45),
  user_agent TEXT (4096),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_seen DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  is_valid BOOLEAN DEFAULT 1,
  PRIMARY KEY (session_id),
  FOREIGN KEY (user_uuid) REFERENCES users(uuid),
);


CREATE TABLE news_posts (
  id INT NOT_NULL AUTO_INCREMENT,
  title VARCHAR(300) NOT NULL,
  image_url VARCHAR(1024),
  markdown 
  PRIMARY KEY (id),

);