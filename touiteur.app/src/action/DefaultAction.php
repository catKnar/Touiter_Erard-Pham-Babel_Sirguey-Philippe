<?php

namespace Touiteur\action;

use Touiteur\action\Action;
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

        $touites = TouiterRepository::getInstance()->Affiche_liste_touites();
        $html = '';

        foreach ($touites as $t) {
            $texte = $t->get('texte');
            $date = $t->get('date');
            $pouceUp = $t->get('pouceUp');
            $pouceDown = $t->get('pouceDown');

            $html .= <<<HTML
                <p>
                    Texte: $texte<br>
                    Date: $date<br>
                    like : $pouceUp  dislike : $pouceDown <br>
                </p>
            HTML;
        }

        $page .= $html . '</div>
            </body>';
        return $page;
    }
}
