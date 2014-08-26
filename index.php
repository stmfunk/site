<!DOCTYPE html>
<html>
   <head>
      <title>Menishi</title>
      <?php 
         include("includes.php"); 
         include("core/dbManager.php");
         $db = new dbManager('blog');
      ?>
      <script>var tab_id="home";</script>
   </head>
   <body>
      <?php 
         include("main-nav.php"); 
         include("sideNav.php");
         $sdNv = new sideNav(array(),$db);
         echo $sdNv;
      ?>
   </body>
</html>
