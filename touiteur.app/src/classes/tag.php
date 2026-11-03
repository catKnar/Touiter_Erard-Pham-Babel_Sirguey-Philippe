<?php 


class Tag {

   protected int $id_tag;

   protected String $libelle;

   protected String $description_tag;


   public function __construct(int $id_tag , String $lib, String $desc ){
        $this->id_tag = $id_tag;
        $this->libelle = $lib;
        $this->libelle = $desc;
   }

    public function get( string $attrname) : mixed {
        if (property_exists($this, $attrname)) 
        return $this->$attrname;
        throw new Exception("$attrname : invalid property");
    }



   public function toHtml(): String {
       return "<h2> {$this->id_tag}</h2>";
   }


}


?>