<!DOCTYPE html>
<html>
   <head>
      <?php 
         include("../dbPass.php");
         include("../config.php");
         include("../core/Article.php");
         include("../core/User.php");
         include("../core/dbManager.php");

         $db = new dbManager("blog");
         if (in_array('id',array_keys($_GET)) !== false) {
            $article = $db->getArticleById($_GET['id']);
            echo "<title>{$article->title}</title>\n";
            $articles = array($article);

         } else {
            $articles = $db->articleQuery();
            echo "<title>Blog</title>\n";
         }

         include("../includes.php"); 
      ?>
      <script>var tab_id="blog-tab";</script>
   </head>
   <body>
      <?php 
         include("../main-nav.php");
      ?>
      <nav class="blog-nav card-style">
         <div class="blog-nav">One</div>
         <div class="blog-selected blog-nav">Two</div>
         <div class="blog-nav">Three</div>
      </nav>
      <?php 
         echo "      <section class=\"blog-posts\">";
         foreach ($articles as $article) {
            echo "\n         ".join("\n         ",array_slice(split("\n",$article),0,-1))."\n\n";
         }
         echo "      </section>\n";
      ?>
   </body>
</html>
