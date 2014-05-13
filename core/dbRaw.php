<?php
   include("dbManager.php");
   if (count($_GET) !== 0) {
      $db = new dbManager('blog');
      if ($_GET['section'] !== "") {
         $articles = $db->articleQuery(array('section'=>$_GET['section']));
         echo join("\n", $articles);
      }
   }
