<!DOCTYPE html>
<html>
   <head>
      <title>People</title>
      <?php 
         include("../includes.php"); 
         include("../core/dbManager.php");
         include("../core/Profile.php");
         $dbMan = new dbManager('blog');
      ?>
      <script>var tab_id="people-tab";</script>
   </head>
   <body>

      <?php 
         include("../main-nav.php"); 
      ?>
      <section class="search group">
        <div contenteditable="true" class="large-search card-style">
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
