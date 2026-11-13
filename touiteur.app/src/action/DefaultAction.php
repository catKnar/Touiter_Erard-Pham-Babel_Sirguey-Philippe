<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\renders\ImageRenderer;
use Touiteur\interfaces\Renderer;
use Touiteur\repository\TouiterRepository;

class DefaultAction extends Action
{

    public function execute(): string
    {
        $page = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Touiter</title>
                <style>
                    .touite {
                        display: grid;
                        align-items: center;
                        justify-content: center;
                    }

                    p {
                        font-family: monospace, sans-serif;
                    }

                    h2 {
                        margin: 10px;
                        color: white;
                        font-family: monospace, sans-serif;
                    }

                    .touite a {
                        color: white;
                        text-decoration: none;
                        font-family: monospace, sans-serif;
                        margin-right: 10px;
                    }
                </style>
            </head>
            
            <body>
                <h2>Bienvenue sur le site de Touiteur</h2>
                <div class="touite">
        HTML;

        $iduser = (int) $_SESSION['id_user'];
        $repo = TouiterRepository::getInstance();
         
        if (!$repo->Affiche_mur($iduser)){
            $touites = $repo->Affiche_liste_touites();
        } else {
            $touites = $repo->Affiche_mur($iduser);
        }
        
        $html = '';

        foreach ($touites as $l) {
            $t = $l['touite'];
            $a = $l['auteur'];
            $id = $t->get('id_touite');
            $idUser = $t->get('id_user');
            $texte = $t->get('texte');
            $date = $t->get('date');
            $pouceUp = $t->get('pouceUp');
            $pouceDown = $t->get('pouceDown');
            $nom = $a->get('nom');
            $prenom = $a->get('prenom');
            

            $htmlImage = '';
            $idImg = $t->get('id_img');
            if ($idImg > 0) {
                $image = $repo->Affiche_image_par_id($idImg);
                if ($image !== null) {
                    $htmlImage = (new ImageRenderer($image))->render(Renderer::LONG);
                }
            }

            $html .= <<<HTML
                <a href='?action=detail&id_touite=$id'> <p>
                    Auteur : $nom $prenom <br>
                    Texte: $texte<br>
                    Date: $date<br>
                    like : $pouceUp  dislike : $pouceDown <br>
                </p> 
                $htmlImage
                 </a>
            HTML;
        }

        $page .= $html . '</div>
            </body>';
        return $page;
    }
}
