<?php
include("../core/Article.php");
include("../core/User.php");
include ("../core/Section.php");
include("../dbPass.php");
include("../config.php");

class dbManager {
   public $mysqlO;
   public $dbError;
   public $create;

   public function __construct($db) {
      global $dbPass;
      $this->id = $id;

      // Check for and create database if it does
      // not exist.
      global $create;
      $this->create = $create;
      $this->mysqlO = new mysqli('localhost','site',$dbPass);
      if ($this->mysqlO->connect_errno) {
         echo $mysqlO->connect_error;
      }
      $cmd = "CREATE DATABASE IF NOT EXISTS $db";
      if (!$this->mysqlO->query($cmd)) {
         $dbError = True;
      }

      $this->mysqlO->select_db($db);
      foreach ($create as $name => $q) {
         if ($this->mysqlO->query("SELECT * FROM $name") == false) {
            $this->mysqlO->query($q);
         }
      }
   }

   public function createDateRange($dateFrom, $dateTo) {
      return $dateFrom."|".$dateTo;
   }


   // Queries related to users
   public function userQuery($keyVal=array(),$num=0) {
      if ($this->mysqlO->query("SELECT * FROM users") == false){
         $this->mysqlO->query($create('users'));
         return;
      }
   }

   public function userById($id) {
      if ($this->mysqlO->query("SELECT * FROM users") == false){
         return new User();
      }
      $query = "SELECT * FROM users WHERE id = ?";
      $query = $this->mysqlO->prepare($query);
      $query->bind_param("i",$id);
      $query->execute();
      $res = $query->get_result();
      $res = $res->fetch_assoc();
      if ($res !== NULL)
         return new User($res);
      else return new User();
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
         return new User();
      }
   }

   // Profile Queries
   public function profileByUsername($username) {
      if ($this->mysqlO->query("SELECT * FROM profiles") == false) {
         $this->mysqlO->query($create('profiles'));
         return;
      }
      $query = "SELECT * FROM profiles WHERE username = ?";
      $query = $this->mysqlO->prepare($query);
      $query->bind_param("s",$username);
      $query->execute();
      $res = $query->get_result();
      $res = $res->fetch_assoc(); 
      $res['avatar'] = $res['avatar'].'.'.$this->imageDataById($res['avatar'])['type'];
      $user = $this->userByUsername($res['username']);
      $res['person'] = $user;
      return new Profile($res);
   }

   // Image query
  public function imageDataById($id) {
     if ($this->mysqlO->query("SELECT * FROM images") == false) {
        $this->mysqlO->query($create('images'));
        return;
      }
      $query = "SELECT * FROM images WHERE id = ?";
      $query = $this->mysqlO->prepare($query);
      $query->bind_param("i",$id);
      $query->execute();
      $res = $query->get_result();
      $res = $res->fetch_assoc();
      return $res;
   }
    

   // These are queries relating to articles
   public function articleQuery($keyVal=array(),$num=5) {
      if ($this->mysqlO->query("SELECT * FROM articles") == false){
         return array(new Article());
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
         return array(new Article());
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
      else return new Article();
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
