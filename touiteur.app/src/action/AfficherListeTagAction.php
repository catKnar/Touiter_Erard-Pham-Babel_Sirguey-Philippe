<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\interfaces\Renderer;
use Touiteur\renders\TouiteListRenderer;
use Touiteur\repository\TouiterRepository;

class AfficherListeTagAction extends Action
{

    public function execute(): string
    {
        $idTag = filter_input(INPUT_GET, 'id_tag', FILTER_VALIDATE_INT);
        
        if ($idTag === false || $idTag === null || $idTag < 1) {
            return '<p>Tag ID manquant ou invalide.</p>';
        }

        $repo = TouiterRepository::getInstance();
        $result = $repo->Affiche_touite_ParTag($idTag);
        $touites = array_column($result, 'touite');

        $tag = $repo->Affiche_tag_par_id($idTag);

        foreach ($tag as $t) {
            $libelle = $t->get('libelle');
        }

        $idUser = 1;
        $followed = $repo->estAbonneAuTag($idUser, $idTag);
        $followTag = $followed ? sprintf('<a class="followtag" href="?action=follow-tag&amp;idTag=%d" style="margin-left: 15px; font-size: 1.2em; color: #00ff88;">[Tag suivi]</a>', $idTag)
            : sprintf('<a class="followtag" href="?action=follow-tag&amp;idTag=%d" style="margin-left: 15px; font-size: 1.2em; color: #00ff88;">[Suivre ce tag]</a>', $idTag);

        $html = (new TouiteListRenderer($touites, 'Touites associés à ce tag : ' . $libelle))
            ->render(Renderer::COMPACT);

        return $followTag . $html;
    }
}
