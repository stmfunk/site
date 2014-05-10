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

         class Article {
            public $title;
            public $author;
            public $author_url;
            public $date;
            public $id;
            public $content;

            public function __construct($vals) {
               $this->title = $vals['title'];
               $this->author = $vals['author'];
               $this->author_url = $vals['author_url'];
               $this->date = $vals['date'];
               $this->content = $vals['content'];
               $this->id = $vals['id'];
            }

            public function __toString() {
               $string = "";
               $string .= "<article class=\"blog\" id=\"{$this->id}\">\n";
               $string .= "   <header>\n";
               $string .= "      <h1><a href=\"/blog?id=$this->id\">{$this->title}</a></h1>\n";
               $string .= "      <span class=\"author\">By <a rel=\"author\" href=\"{$this->author_url}\">{$this->author}</a></span>\n";
               $string .= "   </header>\n";
               $string .= "   <p>{$this->content}</p>\n";
               $string .= "</article>\n";
               return $string;
            }
         }
      ?>

   </head>
   <body>
      <?php 
         include("../main-nav.php");
         $db = new dbManager("blog");
         echo "      <section class=\"blog-posts\">";
         if (in_array('id',array_keys($_GET)) !== false) {
            $article = $db->getArticleById($_GET['id']);
            echo "\n         ".join("\n         ",array_slice(split("\n",$article),0,-1))."\n\n";
         } else {
            $articles = $db->articleQuery();
            foreach ($articles as $article) {
               echo "\n         ".join("\n         ",array_slice(split("\n",$article),0,-1))."\n\n";
            }
         }
         echo "      </section>\n";
      ?>
   </body>
</html>
