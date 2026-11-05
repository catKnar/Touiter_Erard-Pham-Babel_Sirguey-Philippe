<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\classes\Image;
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
                </style>
            </head>
            
            <body>
                <div class="touite">
        HTML;

        $repo = TouiterRepository::getInstance();
        $touites = $repo->Affiche_liste_touites();
        $html = '';

        foreach ($touites as $t) {
            $texte = $t->get('texte');
            $date = $t->get('date');
            $pouceUp = $t->get('pouceUp');
            $pouceDown = $t->get('pouceDown');

        $htmlImage = '';
        $idImg = $t->get('id_img');
        if ($idImg > 0) {
            $image = $repo->Affiche_image_par_id($idImg);
            if ($image !== null) {
                $htmlImage = (new ImageRenderer($image))->render(Renderer::LONG);
            }
        }

            $html .= <<<HTML
                <p>
                    Texte: $texte<br>
                    Date: $date<br>
                    like : $pouceUp  dislike : $pouceDown <br>
                </p>
                $htmlImage
            HTML;
        }

        $page .= $html . '</div>
            </body>';
        return $page;
    }
}
