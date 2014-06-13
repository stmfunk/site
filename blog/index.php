<!DOCTYPE html>
<html>
   <head>
      <?php 
         include("../core/dbManager.php");

         $db = new dbManager("blog");
         if (in_array('id',array_keys($_GET)) !== false) {
            $article = $db->getArticleById($_GET['id']);
            echo "<title>{$article->title}</title>\n";
            $articles = array($article);

         } else if (in_array('section',array_keys($_GET)) !== false) {
            $articles = $db->articleQuery(array('section'=>$_GET['section']));
            echo "<title>Blog</title>\n";
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
      <?php 
         echo "\n      <nav class=\"sticktop app-prefs blog-nav card-style\">\n";
         echo "         <ul id=\"blog-nav\">\n";
         $sections = $db->getSections();
         foreach ($sections as $section) {
            $section = ucfirst($section);
            echo "            <li class=\"blog-nav\">$section</div>\n";
         }
         echo "         </ul>\n";
         echo "      </nav>\n";
         echo "      <section class=\"blog-posts\">\n";
         foreach ($articles as $article) {
            echo "\n         ".join("\n         ",array_slice(split("\n",$article),0,-1))."\n\n";
         }
         echo "      </section>\n";
      ?>
   </body>
</html>
