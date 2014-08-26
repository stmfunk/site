<?php
   class sideNav {
      private $sections;
      private $db;
      public function __construct($contentTypes,$db) {
         $this->db = $db;
         $this->sections = $this->db->getSections($contentTypes);
      }

      public function __toString() {
         $str = "";
         $str .= "\n      <nav class=\"sticktop app-prefs blog-nav\">\n";
         $str .= "         <ul id=\"blog-nav\">\n";
         foreach ($this->sections as $section) {
            $section = ucfirst($section);
            $str .= "            <li class=\"blog-nav\">$section</div>\n";
         }
         $str .= "         </ul>\n";
         $str .= "      </nav>\n";
         $str .= "      <section class=\"blog-posts\">\n";
         return $str;
      }
   }
