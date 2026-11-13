<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\classes\Utilisateur;

class AfficherProfilAction extends Action
{

    public function execute(): string
    {
        $u1 = new utilisateur(1, "Bob", "Eponge", "poisson@uni.fr", 0);

        $id = $u1->get('id_user');
        $nom = $u1->get('nom');
        $prenom = $u1->get('prenom');
        $email = $u1->get('email');
        $touite = $u1->get('nb_touite');

        $html = <<<HTML
                <style>
                    .profil_ent{
                        display: grid;
                        align-items: center;
                        justify-content: center;
                        font-family: monospace, sans-serif;
                    }

                    .profil_ent a {
                        color: white;
                        text-decoration: none;
                        font-family: monospace, sans-serif;
                        margin-right: 10px;
                    }

                    .profil_info{
                        display: grid;
                        align-items: center;
                        justify-content: center;
                        font-family: monospace, sans-serif;
                        margin-top: 100px;
                    }

                    .photo_profil{
                        width: 120px;
                        height: 120px;
                        border-radius: 50%;
                        object-fit: cover;
                    }
                </style>

                <div class = "profil_ent">
                <p> Profil : $nom $prenom <br>
                $touite touites</p> 
                </div>

                <div class = "profil_info">
                    <img src="src/img/bob.jpg" class="photo_profil">
                <p>$nom $prenom $email<br>
                $id</p>
                </div>
        HTML;

        return $html;
    }
}
