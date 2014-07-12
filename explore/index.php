<!DOCTYPE html>
<html>
   <head>
      <title>Explore</title>
      <?php 
         include("../includes.php"); 
         include("../core/dbManager.php");
         $dbMan = new dbManager('blog');
      ?>
      <script>var tab_id="explore-tab";</script>
   </head>
   <body>

      <?php 
         include("../main-nav.php"); 
      ?>
      <section class="search group">
        <div contenteditable="true" class="large-search card-style">
           Search for People, Projects or Code
        </div>
        <div class="shadow-bottom"></div>
      </section>
      <section class="featured">
        <h2>Featured</h2>
        <?php
           $me = $dbMan->profileByUsername('stm');
           echo $me->condensedString();
        ?> 
      </section>
   </body>
</html>
