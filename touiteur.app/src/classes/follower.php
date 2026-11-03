<?php 

class follower{

 private int $id_user;

 private int $id_user_following;

 public function __construct(int $id_use1, int $id_use2){
    $this->id_user = $id_use1;
    $this->id_user_following = $id_use2;
 }

  public function get( string $attrname) : mixed {
        if (property_exists($this, $attrname)) 
        return $this->$attrname;
        throw new Exception("$attrname : invalid property");
    }

 public function toHtml(){
    return "<h2>{$this->id_user}</h2>";
 }


}


?>