<!DOCTYPE html>
<html>
  <head>

    <title>Menishi</title>
    <link rel="icon" href="favicon.png" type="image/x-icon" />
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script src="owl-carousel/owl.carousel.js"></script>
    <link rel="stylesheet" type="text/css" href="owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="owl-carousel/owl.theme.css" />
    <script src="js/main.js"></script>

  </head>
  <body>
    <?php include 'main-nav.php'; ?>

    <div id="sliderDiv" class="owl-carousel">
      <div class="owlDivs"><img class="watson" src="http://www.stars-arena.com/wp-content/uploads/2013/08/emma-watson-14.jpg"/></div>
      <div class="owlDivs"><img class="watson" src="http://www.stars-arena.com/wp-content/uploads/2013/08/emma-watson-14.jpg"/></div>
      <div class="owlDivs"><img class="watson" src="http://www.stars-arena.com/wp-content/uploads/2013/08/emma-watson-14.jpg"/></div>
    </div>
    <div id="slidenavbar" class="app-prefs">
      <div id="slide-next" class="slidenav">
        <span class="vcenter">Next</span>
      </div>
      <div id="slide-prev" class="slidenav">
        <span class="vcenter">Prev</span>
      </div>
    </div>
    <?php 
      echo mysqli_connect('localhost', 'donal', 'superbowl1984', 'fish') ? "yes" : "no";
    ?>
  </body>
</html>
