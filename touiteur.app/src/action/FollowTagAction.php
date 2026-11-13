<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\repository\TouiterRepository;

class FollowTagAction extends Action
{

    public function execute(): string
    {
        $idTag = filter_input(INPUT_GET, 'idTag', FILTER_VALIDATE_INT);

        if ($idTag === false || $idTag === null || $idTag < 1) {
            return '<p>Identifiant de tag manquant ou invalide.</p>';
        }

        $repo = TouiterRepository::getInstance();
        $idUser = 1;

        if ($repo->estAbonneAuTag($idUser, $idTag)) {
            $repo->retirerAbonnementTag($idUser, $idTag);
        } else {
            $repo->tagAbonnement($idUser, $idTag);
            if (!$repo->estAbonneAuTag($idUser, $idTag)) {
                return '<p>Impossible d\'enregistrer le suivi de ce tag.</p>';
            }
        }

        header('Location: ?action=tag-touites&id_tag=' . $idTag);
        exit;
    }
}
