<!DOCTYPE html>
<html>
   <head>
      <?php 
         include_once("../core/dbManager.php");
         include_once("../core/feed.php");
         include_once("../sideNav.php");

         $title = "<title>Blog</title>\n";
         $db = new dbManager("blog");

         if (in_array('id',array_keys($_GET)) !== false) {
            $article = $db->getArticleById($_GET['id']);
            $title = "<title>{$article->title}</title>\n";
            $articles = array($article);
         } else {
            $_GET['type'] = 'blog';
            $page = new Feed($db,$_GET);
         }
         echo $title;
         include("../includes.php"); 

      ?>
      <script>var tab_id="blog-tab";</script>
   </head>
   <body>
      <?php 
         include("../main-nav.php");
         $sdNv = new sideNav(array('blog'),$db);
         echo $sdNv;

         echo "      <section class=\"blog-posts\">\n";
         echo $page;
         echo "      </section>\n";
      ?>
   </body>
</html>
