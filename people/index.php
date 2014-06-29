<!DOCTYPE html>
<html>
   <head>
      <title>People</title>
      <?php 
         include("../includes.php"); 
         include("../core/Profile.php");
      ?>
      <script>var tab_id="people-tab";</script>
   </head>
   <body>

      <?php 
         include("../main-nav.php"); 
      ?>
      <section class="search group">
        <div class="large-search card-style">

        </div>
      </section>
      <section class="featured">
        <?php
           $me = new Person(array('name'=>"Donal O'Shea", 'url'=>"http://menishi.com",'username'=>"stmfunk"));
           $myProfileC = new Profile(array('person'=>$me,'about'=>'Lorem ipsum dolor sit amet, eam at luptatum posidonium, in duo dicit animal, quaestio partiendo reprimique ex mei. Ne inani vivendo his, semper tritani laboramus nam at? Et mei solet copiosae, inani tempor eligendi ne est? Malis tacimates eam at, ut clita prompta hendrerit nec. An has adolescens vituperata intellegebat, te qui torquatos conclusionemque...', 'links'=>'asdf','imgID'=>'Batman','onlineStatus'=>'online'));
           echo $myProfileC->condensedString();
        ?> 
      </section>
   </body>
</html>
