<?php
   header('Content-type: image/jpg');
   $img = "../images/" . $_GET['img'];
   readfile($img);
?>
