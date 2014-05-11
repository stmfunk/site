<?php
         class dbManager {
            public $mysqlO;
            public $nullArticle;
            public $dbError;

            public function __construct($db) {
               global $dbPass;
               $this->id = $id;

               // Check for and create database if it does
               // not exist.
               $this->nullArticle = new Article(array("title"=>"None","author"=>"NONE", "author_url"=>"#","id"=>"0","date"=>"NONE","content"=>"NONE"));
               $this->mysqlO = new mysqli('localhost','site',$dbPass);
               if ($this->mysqlO->connect_errno) {
                  echo $mysqlO->connect_error;
               }
               $cmd = "CREATE DATABASE IF NOT EXISTS $db";
               if (!$this->mysqlO->query($cmd)) {
                  $dbError = True;
               }

               $this->mysqlO->select_db($db);
            }

            public function createDateRange($dateFrom, $dateTo) {
               return $dateFrom."|".$dateTo;
            }

            public function articleQuery($keyVal=array(),$num=0) {
               
               if ($this->mysqlO->query("SELECT * FROM articles") == false){
                  $this->mysqlO->query("CREATE TABLE articles (id MEDIUMINT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL,author VARCHAR(50), author_url VARCHAR(80) DEFAULT \"#\",date DATETIME NOT NULL, content TEXT, PRIMARY KEY(id))");
                  return array($this->nullArticle);
               }
               if ($this->mysqlO->query("SELECT * FROM users") == false){
                  $this->mysqlO->query("CREATE TABLE users (id MEDIUMINT AUTO_INCREMENT NOT NULL, name VARCHAR(50), username VARCHAR(100) UNIQUE NOT NULL, url VARCHAR(80) DEFAULT \"#\")");
               }

               // Key value as a date is split using 
               $queriesToRun = array();
               foreach (array_keys($keyVal) as $key) {
                  if ($key == "date") {
                     $range = split('|', $keyVal[$key]);
                     array_push($queriesToRun, "date < '{$range[0]}' AND date >= '{$range[1]}'");
                  } else if ($key == "author") {
                     array_push($queriesToRun,"author = '{$keyVal[$key]}'");
                  } else if ($key == "title") {
                     array_push($queriesToRun,"title = '{$keyVal[$key]}'");
                  } else if ($key == "author_url") {
                     array_push($queriesToRun,"author_url = '{$keyVal[$key]}'");
                  }
               }
               if (count($queriesToRun) != 0) {
                  $queriesToRun = join(" AND ",$queriesToRun);
                  $queriesToRun = "WHERE ".$queriesToRun;
               }
               $query = "SELECT * FROM articles $queriesToRun";
               $result = $this->mysqlO->query($query);

               $articles = array();
               $i = -1;
               while ($row = $result->fetch_array()) {
                  if ($i == -1) $i = 0;
                  array_push($articles,new Article($row));
                  if ($num != 0){
                    $i += 1;
                    if ($i == $num) break;
                 }
               }
               if ($i == -1) {
                  return array($this->nullArticle);
               }
               return $articles;
            }

            public function getArticleById($id) {
               $query = "SELECT * FROM articles WHERE id = ?";
               $query = $this->mysqlO->prepare($query);
               $query->bind_param("i",$id);
               $query->execute();
               $res = $query->get_result();
               $res = $res->fetch_assoc();
               if ($res !== NULL)
                  return new Article ($res);
               else return $this->nullArticle;

            }
         }
?>
