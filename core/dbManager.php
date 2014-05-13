<?php
if (count($_GET) !== 0) {
   include("../core/Article.php");
   include("../core/User.php");
   include ("../core/Section.php");
   include("../dbPass.php");
   include("../config.php");
}

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
      $queriesToBind = array();
      $bindPol = "";
      foreach (array_keys($keyVal) as $key) {
         if ($key == "date") {
            list($start,$stop) = split('\|',' '.$keyVal[$key].' ');
            if ($start != ' ') {
               array_push($queriesToRun, "date <= ?");
               $bindPol .= "s";
               array_push($queriesToBind, $start);
            } else if ($stop != ' ') {
               array_push($queriesToRun, "date >= ?");
               $bindPol .= "s";
               array_push($queriesToBind, $stop);
            }
         } else if ($key == "title") {
            array_push($queriesToRun,"title = ?");
            $bindPol .= "s";
            array_push($queriesToBind, "s",$keyVal[$key]);
         } else if ($key == "section") {
            if ($keyVal[$key] == "all") continue;
            array_push($queriesToRun,"section = ?");
            $bindPol .= "s";
            array_push($queriesToBind, "s",$keyVal[$key]);
         }
      }
      if (count($queriesToRun) != 0) {
         $queriesToRun = join(" AND ",$queriesToRun);
         $queriesToRun = "WHERE ".$queriesToRun;
      }
      $query = "SELECT * FROM articles $queriesToRun ORDER BY date DESC";
      $query = $this->mysqlO->prepare($query);
      foreach ($queriesToBind as $bind) {
         $query->bind_param($bindPol, $bind);
      }

      $query->execute();
      $result = $query->get_result();

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
      $resP = $this->userByUsername($res['author']);
      $res['author'] = $resP->name;
      $res['author_url'] = $resP->url;
      if ($res !== NULL)
         return new Article($res);
      else return $this->nullArticle;
   }

   public function getSections($num=5) {
      $query = "SELECT * FROM sections";
      $query = $this->mysqlO->prepare($query);
      $query->execute();
      $res = $query->get_result();
      $sections = array();
      for ($i = 0; $i <= $num && $row = $res->fetch_assoc(); $i += 1) {
         array_push($sections,new Section($row['name']));
      }
      return $sections;
   }
}
?>
