<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\repository\TouiterRepository;
use Touiteur\interfaces\Renderer;
use Touiteur\renders\TouiteRenderer;

class AfficherProfilAction extends Action
{

    public function execute(): string
    {


        $id = (int) $_SESSION['id_user'];

        $repo = TouiterRepository::getInstance();
        $result = $repo->Afficher_Touite_Personne_donnee($id);
        $nom = '';
        $prenom = '';
        $email = '';

        foreach ($result as $item) {
            $user = $item['auteur'];
            $nom = htmlspecialchars($user->get('nom'));
            $prenom = htmlspecialchars($user->get('prenom'));
            $email = htmlspecialchars($user->get('email'));
        }

        $nbTouites = count($repo->Afficher_Touite_Personne_donnee((int) $id));

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
                $nbTouites touites</p> 
                </div>

                <div class = "profil_info">
                    <img src="src/img/bob.jpg" class="photo_profil">
                <p>$nom $prenom $email<br>
                $id</p>
                </div>
        HTML;

        foreach ($result as $item) {
            $touite = $item['touite'];
            $html .= (new TouiteRenderer($touite))->render(Renderer::COMPACT);
        }

        return $html;
    }
}
