<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\interfaces\Renderer;
use Touiteur\renders\TouiteRenderer;
use Touiteur\repository\TouiterRepository;

class AfficherTweetAction extends Action {

    public function execute(): string
    {
        $idtouite = (int) $_GET['id_touite'];

        $repo = TouiterRepository::getInstance();
        $result = $repo->Affiche_touite_detail($idtouite);

        $tweet = $result['touite'];
        $auteur = $result['auteur'];

        $html = '';

        $html .= (new TouiteRenderer($tweet, $auteur))->render(Renderer::LONG);

        return $html;
    }
}