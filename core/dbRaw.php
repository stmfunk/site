<?php
   include("dbManager.php");
   if (count($_GET) !== 0) {
      $db = new dbManager('blog');
      if (in_array("section",array_keys($_GET))) {
         $articles = $db->articleQuery(array('section'=>$_GET['section']));
         echo join("\n", $articles);
      }
      else if (in_array("id",array_keys($_GET))) {
         $article = $db->getArticleById($_GET['id']);
         echo $article;
      }
   }
