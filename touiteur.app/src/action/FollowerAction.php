<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\repository\TouiterRepository;

class FollowerAction extends Action
{
    public function execute(): string
    {
        $idMe = 333;
        $idFollow = (int) $_GET['id_user'];
        $origine = $_GET['origine'] ?? '';

        $repo = TouiterRepository::getInstance();

        if ($repo->estSuivi($idMe, $idFollow)) {
            $repo->desabonnerUtiliseurs($idMe, $idFollow);
        } else {
            $repo->suivreUtiliseurs($idMe, $idFollow);
        }

        if ($origine === 'profil') {
            header('Location: ?action=user-touites&id_user=' . $idFollow);
            exit;
        }

        if ($origine === 'touite') {
            if (isset($_GET['id_touite'])) {
                $idTouite = (int) $_GET['id_touite'];
                header('Location: ?action=detail&id_touite=' . $idTouite);
                exit;
            }
        }

        exit;
    }
}
