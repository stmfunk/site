<?php
   if (!class_exists('dbManager')) $standAlone = True;
   include_once("dbManager.php");

   class Feed {
      protected $articles;
      protected $startPage;

      public function __construct($db,$keyVal=array(),$limitResults=5,$startPage=0) {
         $this->startPage = $startPage;
         $startPoint = $startPage*$limitResults;
         $this->articles = $db->articleQuery($keyVal,$limitResults,$startPoint);
      }

      public function __toString() {
         $thisStr =  "\n         <div class=\"page\" data-number=$this->startPage>\n";
         foreach ($this->articles as $article) {
           if ($article->id != 0) {
              $thisStr .= "\n           ".join("\n           ",array_slice(explode("\n",$article),0,-1))."\n\n";
           } else {
              if (count($this->articles) > 1) {
                 $thisStr .= "\n          <span id=\"terminus\"></span>\n";
                 break;
              } else return "";
           }
         }
         $thisStr .=  "\n        </div>\n";
         return $thisStr;
      }
   }

   if ($standAlone) {
      $db = new dbManager('blog');
      echo new Feed($db,$_GET, 5,$_GET['startpage']);
   }
?> 


