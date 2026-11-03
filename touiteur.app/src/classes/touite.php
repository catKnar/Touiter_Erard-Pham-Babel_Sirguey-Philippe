<?php

namespace Touiteur\classes;

use Exception;

class touite {

    protected int $id_touite;
    protected string $texte;
    protected mixed $date;
    protected int $id_user;
    protected int $id_img;

    public function __construct(int $id_touite, string $texte, mixed $date, int $id_user, int $id_img) {
        
        $this->id_touite = $id_touite;
        $this->texte = $texte;
        $this->date = $date;
        $this->id_user = $id_user;
        $this->id_img = $id_img; 
    }

    public function get( string $attrname) : mixed {
        
        if (property_exists($this, $attrname)) 
        return $this->$attrname;
        throw new Exception("$attrname : invalid property");
    }

    public function toHtml () {
        return "<h2>{$this->id_touite}</h2>" .
               "<h2>{$this->texte}</h2>" .
               "<h2>{$this->date}</h2>" .
               "<h2>{$this->id_user}</h2>" .
               "<h2>{$this->id_user}</h2>" ;
    }
}

?>