<?php

namespace Touiteur\classes;

use Exception;

class Image {

    protected int $id_img;
    protected string $description_image;
    protected string $chemin_fichier;

    public function __construct(int $id_img, string $description_image, string $chemin_fichier) {
        
        $this->id_img = $id_img;
        $this->description_image = $description_image;
        $this->chemin_fichier = $chemin_fichier; 
    }

    public function get( string $attrname) : mixed {
        
        if (property_exists($this, $attrname)) 
        return $this->$attrname;
        throw new Exception("$attrname : invalid property");
    }

    public function toHtml () {
        return "<h2>{$this->id_img}</h2>" .
               "<h2>{$this->description_image}</h2>" .
               "<h2>{$this->chemin_fichier}</h2>" ;
    }
}

?>