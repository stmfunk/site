<?php
   include("dbManager.php");
   if (count($_GET) !== 0) {
      $db = new dbManager('blog');
      if (in_array("section",array_keys($_GET))) {
         $section = strtolower($_GET['section']);
         if ($section == 'all') {
            $articles = $db->articleQuery();
         } else {
            $articles = $db->articleQuery(array('section'=>$section));
         }
         echo join("\n", $articles);
      }
      else if (in_array("id",array_keys($_GET))) {
         $article = $db->getArticleById($_GET['id']);
         echo $article;
      }
      else if (in_array("profile_username", array_keys($_GET))) {
         $profile = $db->profileByUsername($_GET['profile_username']);
         echo $profile->condensedString();
      }
   }
