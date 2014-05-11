<?
         class Article {
            public $title;
            public $author;
            public $author_url;
            public $date;
            public $id;
            public $content;

            public function __construct($vals) {
               $this->title = $vals['title'];
               $this->author = $vals['author'];
               $this->author_url = $vals['author_url'];
               $this->date = $vals['date'];
               $this->content = $vals['content'];
               $this->id = $vals['id'];
            }

            public function __toString() {
               $string = "";
               $string .= "<article class=\"blog card-style\" id=\"{$this->id}\">\n";
               $string .= "   <header>\n";
               $string .= "      <h1><a href=\"/blog?id=$this->id\">{$this->title}</a></h1>\n";
               $string .= "      <span class=\"author\">By <a rel=\"author\" href=\"{$this->author_url}\">{$this->author}</a></span>\n";
               $string .= "   </header>\n";
               $string .= "   <p>{$this->content}</p>\n";
               $string .= "</article>\n";
               return $string;
            }
         }
?>
