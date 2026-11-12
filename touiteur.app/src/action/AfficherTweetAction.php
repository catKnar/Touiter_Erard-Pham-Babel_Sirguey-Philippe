<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\interfaces\Renderer;
use Touiteur\renders\TouiteRenderer;
use Touiteur\repository\TouiterRepository;

class AfficherTweetAction extends Action
{

    public function execute(): string
    {

        if (!isset($_GET['id_touite'])) {
            return 'Identifiant du touite manquant.';
        }

        $idtouite = (int) $_GET['id_touite'];

        $repo = TouiterRepository::getInstance();
        $result = $repo->Affiche_touite_detail($idtouite);

        $tweet = $result['touite'];

        $html = '';

        $html .= (new TouiteRenderer($tweet))->render(Renderer::LONG);

        return $html;
    }
}
