<?php
   class User {
      public $id;
      public $name;
      public $username;
      public $url;

      public function __construct($vals=array('id' => 0, 'name' => "Anonymous", 'username' => "none", 'url' => "#")) {
         $this->id = $vals['id'];
         $this->name = $vals['name'];
         $this->username = $vals['username'];
         $this->url = $vals['url'];
      }

      public function __toString() {
         return $name;
      }
   }
?>
