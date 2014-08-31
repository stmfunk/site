<?php
   class Feed {
      protected $articles;

      public function __construct($db,$keyVal=array(),$limitResults=5,$startPoint=0) {
         $this->articles = $db->articleQuery($keyVal,$limitResults,$startPoint);
      }

      public function __toString() {
         foreach ($this->articles as $article) {
            $thisStr .= "\n         ".join("\n         ",array_slice(explode("\n",$article),0,-1))."\n\n";
         }
         return $thisStr;
      }
   }
?> 


