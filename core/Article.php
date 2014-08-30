<?php
class Article {
   public $title;
   public $author;
   public $author_url;
   public $date;
   public $id;
   public $content;
   public $section;

   public function __construct($vals=array("title"=>"None","author"=>"NONE", "author_url"=>"#","id"=>"0","date"=>"NONE","content"=>"NONE","section"=>"All")) {
      $this->title = $vals['title'];
      $this->author = $vals['author'];
      $this->author_url = $vals['author_url'];
      $this->date = $vals['date'];
      $this->content = $vals['content'];
      $this->id = $vals['id'];
      $this->section = $vals['section'];
   }

   public function __toString() {
      $string = "";
      $string .= "<article class=\"group blog card-style\" id=\"{$this->id}\">\n";
      $string .= "   <header>\n";
      $string .= "      <h2><a href=\"javascript:void(0)\" class=\"postTitle\" data-section=\"$this->section\" data-id=\"$this->id\">{$this->title}</a></h2>\n";
      $string .= "      <span class=\"author\">By <a rel=\"author\" href=\"{$this->author_url}\">{$this->author}</a></span>\n";
      $string .= "   </header>\n";
      $string .= "   <p>{$this->content}</p>\n";
      $date = explode(' ',$this->date)[0];
      $string .= "   <footer>\n";
      $string .= "      <span class=\"pubdate\">Published on $date</span>\n";
      $string .= "   </footer>\n";
      $string .= "</article>\n";
      return $string;
   }
}
?>
