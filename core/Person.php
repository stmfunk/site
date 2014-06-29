<?php
   class Person {
      public $username;
      public $name;
      public $url;

      public function __construct($vals=array("username"=>"Anon","name"=>"None",'url'=>"#")) {
         $this->username = $vals['username'];
         $this->name = $vals['name'];
         $this->url = $vals['url'];
      }

      public function __toString() {
         return "<a href=\"{$this->url}\">{$this->name}</a>";
      }
   }
?>


