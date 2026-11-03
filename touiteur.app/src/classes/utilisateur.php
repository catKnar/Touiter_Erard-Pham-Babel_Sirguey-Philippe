<?php 

namespace Touiteur\classes;

use Exception;

class Utilisateur {

    protected int $id_user;
    protected string $nom;
    protected string $prenom;
    protected string $email;
    protected int $nb_touite;

    public function __construct(int $id_user, string $nom, string $prenom, string $email, int $nb_touite) {

    $this->id_user = $id_user;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->email = $email;
    $this->nb_touite = $nb_touite;
    }

    public function get( string $attrname) : mixed {
        
        if (property_exists($this, $attrname)) 
        return $this->$attrname;
        throw new Exception("$attrname : invalid property");
    }

    public function toHtml() : string {

        return "<h2>{$this->id_user}</h2>" .
               "<h2>{$this->nom}</h2>" .
               "<h2>{$this->prenom}</h2>" .
               "<h2>{$this->email}</h2>" .
               "<h2>{$this->nb_touite}</h2>" ;
    }
}

?>