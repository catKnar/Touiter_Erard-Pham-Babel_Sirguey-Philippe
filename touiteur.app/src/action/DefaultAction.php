<?php

namespace Touiteur\action;

use Touiteur\action\Action;

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
                        border: 1px solid black;
                    }
                </style>
            </head>
            
            <body>
                <div class="touite">
                    <p>Le_dragon  <i><@1234</i> <br>
                        Touiter est la meilleure application !
                    </p>

                    <p>Gérard <i><@5678</i> <br>
                        Je recommande Touiter à tous mes amis !
                    </p>

                    <p>Marie <i><@9101</i> <br>
                        J'adore Touiter, c'est super pratique !
                    </p>

                    <p>Jean <i><@1121</i> <br>
                        Touiter est vraiment génial, je l'utilise tous les jours !  
                     </p>

                     <p>Lucie <i><@3141</i> <br>
                        Je suis fan de Touiter, c'est mon application préférée !
                    </p>
                </div>
            </body>
        </html>
        HTML;

        return $page;
    }
}
