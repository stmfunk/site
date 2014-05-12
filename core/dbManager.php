<?php
class dbManager {
   public $mysqlO;
   public $nullArticle;
   public $anonymousUser;
   public $dbError;

   public function __construct($db) {
      global $dbPass;
      $this->id = $id;

      // Check for and create database if it does
      // not exist.
      $this->nullArticle = new Article();
      $this->anonymousUser = new User();
      $this->mysqlO = new mysqli('localhost','site',$dbPass);
      if ($this->mysqlO->connect_errno) {
         echo $mysqlO->connect_error;
      }
      $cmd = "CREATE DATABASE IF NOT EXISTS $db";
      if (!$this->mysqlO->query($cmd)) {
         $dbError = True;
      }

      $this->mysqlO->select_db($db);
      if ($this->mysqlO->query("SELECT * FROM users") == false){
         global $articlesCreate;
         global $usersCreate;
         global $sectionsCreate;
         global $tagsCreate;
         global $articleTagsCreate;
         $this->mysqlO->query($usersCreate);
         $this->mysqlO->query($sectionsCreate);
         $this->mysqlO->query($articlesCreate);
         $this->mysqlO->query($tagsCreate);
         $this->mysqlO->query($articleTagsCreate);
      }

   }

   public function createDateRange($dateFrom, $dateTo) {
      return $dateFrom."|".$dateTo;
   }

   public function userQuery($keyVal=array(),$num=0) {
      if ($this->mysqlO->query("SELECT * FROM users") == false){
         $this->mysqlO->query($userCreate);
      }
   }

   public function userById($id) {
      if ($this->mysqlO->query("SELECT * FROM users") == false){
         return $this->nullUser;
      }
      $query = "SELECT * FROM users WHERE id = ?";
      $query = $this->mysqlO->prepare($query);
      $query->bind_param("i",$id);
      $query->execute();
      $res = $query->get_result();
      $res = $res->fetch_assoc();
      if ($res !== NULL)
         return new User($res);
      else return $this->anonymousUser;
   }


   public function userByUsername($username) {
      $query = "SELECT * FROM users WHERE username = ?";
      $query = $this->mysqlO->prepare($query);
      $query->bind_param("s",$username);
      $query->execute();
      $res = $query->get_result();
      $res = $res->fetch_assoc();
      if ($res !== NULL) {
         return new User($res);
      } else {
         return $this->anonymousUser;
      }
   }

   public function articleQuery($keyVal=array(),$num=5) {
      if ($this->mysqlO->query("SELECT * FROM articles") == false){
         return array($this->nullArticle);
      }

      $this->userQuery();
      // Key value as a date is split using 
      $queriesToRun = array();
      foreach (array_keys($keyVal) as $key) {
         if ($key == "date") {
            list($start,$stop) = split('\|',' '.$keyVal[$key].' ');
            if ($start != ' ') array_push($queriesToRun, "date <= '$start'");
            if ($stop != ' ') array_push($queriesToRun, "date >= '$stop'");
         } else if ($key == "title") {
            array_push($queriesToRun,"title = '{$keyVal[$key]}'");
         }
      }
      if (count($queriesToRun) != 0) {
         $queriesToRun = join(" AND ",$queriesToRun);
         $queriesToRun = "WHERE ".$queriesToRun;
      }
      $query = "SELECT * FROM articles $queriesToRun ORDER BY date DESC";
      $result = $this->mysqlO->query($query);

      $articles = array();
      for ($i = 0; $i <= $num && $row = $result->fetch_array(); $i += 1) {
         $user = $this->userByUsername($row['author']);
         $row['author'] = $user->name;
         $row['author_url'] = $user->url;
         array_push($articles,new Article($row));
      }
      if (count($articles) == 0) {
         return array($this->nullArticle);
      } else {
        return $articles;
     }
   }

   public function getArticleById($id) {
      $query = "SELECT * FROM articles WHERE id = ?";
      $query = $this->mysqlO->prepare($query);
      $query->bind_param("i",$id);
      $query->execute();
      $res = $query->get_result();
      $res = $res->fetch_assoc();
      if ($res !== NULL)
         return new Article($res);
      else return $this->nullArticle;
   }
}
?>
