<!DOCTYPE html>
<html>
   <head>
      <title>Blog</title>
      <script>var tab_id="blog-tab";</script>
      <?php 
         include("../includes.php"); 
         include("../../config.php");

         class dbManager {
            public $mysqlO;
            public $dbError;

            public function __construct($db) {
               global $dbFile;
               $dbPass = file_get_contents($dbFile);
               $dbPass = trim($dbPass);

               $this->id = $id;

               // Check for and create database if it does
               // not exist.
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

            public function articleQuery($keyVal,$num=0) {
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
                  }
               }
               $queriesToRun = join(" AND ",$queriesToRun);
               $query = "SELECT * FROM articles WHERE $queriesToRun";
               $result = $this->mysqlO->query($query);

               $articles = array();
               while ($row = $result->fetch_array()) {
                  array_push($articles,new Article($row));
               }
               return $articles;
            }
         }

         class Article {
            public $title;
            public $author;
            public $date;
            public $id;
            public $content;

            public function __construct($vals) {
               $this->title = $vals['title'];
               $this->author = $vals['author'];
               $this->date = $vals['date'];
               $this->content = $vals['content'];
               $this->id = $vals['id'];

            }
         }
      ?>

   </head>
   <body>
      <?php 
         include("../main-nav.php");
         $db = new dbManager("blog");
         $articles = $db->articleQuery(array("title"=>"fish"));
      ?>
   </body>
</html>
