<?php
   $articlesCreate = "CREATE TABLE articles (id MEDIUMINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id), title VARCHAR(100) NOT NULL, author , date DATETIME NOT NULL, section VARCHAR(100), content TEXT, FOREIGN KEY (section) REFERENCES sections(name), FOREIGN KEY (author) REFERENCES users(username))";
   $usersCreate = "CREATE TABLE users (id MEDIUMINT AUTO_INCREMENT NOT NULL, name VARCHAR(50), username VARCHAR(100) UNIQUE NOT NULL, url VARCHAR(80) DEFAULT \"#\")";
   $sectionsCreate = "CREATE TABLE sections (name varchar(100) NOT NULL, UNIQUE KEY name (name))";
   $tagsCreate = "CREATE TABLE tags (id mediumint(9) NOT NULL AUTO_INCREMENT, name varchar(100) DEFAULT NULL, PRIMARY KEY (id), UNIQUE KEY name (name))";
   $articleTagsCreate = "CREATE TABLE article_tags ( article_id mediumint(9) DEFAULT NULL, tag_id mediumint(9) DEFAULT NULL, KEY article_id (article_id), KEY tag_id (tag_id), CONSTRAINT article_tags_ibfk_1 FOREIGN KEY (article_id) REFERENCES articles (id) ON UPDATE CASCADE, CONSTRAINT article_tags_ibfk_2 FOREIGN KEY (tag_id) REFERENCES tags (id) ON UPDATE CASCADE)";
