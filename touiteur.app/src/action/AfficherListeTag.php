<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\interfaces\Renderer;
use Touiteur\renders\TouiteListRenderer;
use Touiteur\repository\TouiterRepository;

class AfficherListeTag extends Action {

    public function execute(): string {

        $id_tag = isset($_GET['id_tag']) ? (int) $_GET['id_tag'] : 0;

        $repo = TouiterRepository :: getInstance();
        $result = $repo->Affiche_touite_ParTag($id_tag);
        $touites = array_column($result, 'touite');

        return (new TouiteListRenderer($touites, 'Touites associés à ce tag : ' . $id_tag))
            ->render(Renderer::COMPACT);
    }
}

?>