<html>
   <head>
      <title>Page.page</title>
   </head>
   <body>
      <?php if (!empty($_POST['name'])) {
            echo "Greetings,{$_POST['name']}, and welcome.";
         } 
      ?>
      <form action="<?php echo $_SEVRER['PHP_SELF']; ?>" method="post">
         Enter your name <input type="text" name="name" />
         <input type="submit" />
      </form>
   </body>
</html>
