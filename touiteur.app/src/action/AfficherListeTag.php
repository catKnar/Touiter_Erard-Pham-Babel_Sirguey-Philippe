<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\interfaces\Renderer;
use Touiteur\renders\TouiteListRenderer;
use Touiteur\repository\TouiterRepository;

class AfficherListeTag extends Action {

    public function execute(): string {

        $idTag = filter_input(INPUT_GET, 'id_tag', FILTER_VALIDATE_INT);
        if ($idTag === false || $idTag === null || $idTag < 1) {
            return '<p>Tag ID manquant ou invalide.</p>';
        }

        $repo = TouiterRepository::getInstance();
        $result = $repo->Affiche_touite_ParTag($idTag);
        $touites = array_column($result, 'touite');

        return (new TouiteListRenderer($touites, 'Touites associés à ce tag : ' . $idTag))
            ->render(Renderer::COMPACT);

    }
}

?>