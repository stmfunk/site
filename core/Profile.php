<?php 
   include("Person.php");

   class Profile {
      public $person;
      public $about;
      public $links;
      public $onlineStatus;
      public $imgID;

      public function __construct($vals=array('person'=>'None','about'=>'Nothing','links'=>'None','onlineStatus'=>'Offline','imgID'=>'None')) {
         $this->person = $vals['person'];
         $this->about = $vals['about'];
         $this->links = $vals['links'];
         $this->onlineStatus = $vals['onlineStatus'];
         $this->imgID = $vals['imgID'];
      }

      public function condensedString() {
         $str = "      <article class=\"group profile-condense card-style\">\n";
         $str .= "        <header>\n";
         $str .= "          <img src=\"/img.php?img={$this->imgID}.jpg\">\n";
         $str .= "          <h2><a href=\"{$this->person->url}\">{$this->person->name}</a></h2>\n";
         $str .= "        </header>\n";
         $str .= "        <p>$this->about</p>\n";
         $str .= "      </article>\n";
         return $str;
      }
   }

