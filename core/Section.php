<?php
   class Section {
      public $name;

      public function __construct($name) {
         $this->name = $name;
      }

      public function __toString() {
         return $this->name;
      }
   }
?>
