<?php
   $create = array(
     "users"=>"CREATE TABLE users (id MEDIUMINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id), name VARCHAR(50), username VARCHAR(100) UNIQUE NOT NULL, url VARCHAR(80) DEFAULT \"#\", joinDate DATETIME)",
     "articles"=>"CREATE TABLE articles (id MEDIUMINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id), title VARCHAR(100) NOT NULL, author VARCHAR(100), date DATETIME NOT NULL, section VARCHAR(100), content TEXT, FOREIGN KEY (section) REFERENCES sections(name), FOREIGN KEY (author) REFERENCES users(username))",
     "sections"=>"CREATE TABLE sections (name varchar(100) NOT NULL, UNIQUE KEY name (name))",
     "tags"=>"CREATE TABLE tags (id mediumint(9) NOT NULL AUTO_INCREMENT, name varchar(100) DEFAULT NULL, PRIMARY KEY (id), UNIQUE KEY name (name))",
     "article_tags"=>"CREATE TABLE article_tags (article_id mediumint(9) DEFAULT NULL, tag_id mediumint(9) DEFAULT NULL, KEY article_id (article_id), KEY tag_id (tag_id), CONSTRAINT article_tags_ibfk_1 FOREIGN KEY (article_id) REFERENCES articles (id) ON UPDATE CASCADE, CONSTRAINT article_tags_ibfk_2 FOREIGN KEY (tag_id) REFERENCES tags (id) ON UPDATE CASCADE)",
     "images"=>"CREATE TABLE images (id MEDIUMINT UNIQUE NOT NULL,owner VARCHAR(100) NOT NULL, uploadDate DATETIME, takenDate DATETIME, imageName VARCHAR(200), FOREIGN KEY(owner) REFERENCES users(username), privacy ENUM('public', 'private', 'teams') DEFAULT \"private\", type VARCHAR(10))",
     "profiles"=>"CREATE TABLE profiles (username VARCHAR(100), about TEXT, FOREIGN KEY(username) REFERENCES users(username), exp INTEGER DEFAULT 0, avatar MEDIUMINT, FOREIGN KEY(avatar) REFERENCES images(id),  PRIMARY KEY(username))"
   );
?>
