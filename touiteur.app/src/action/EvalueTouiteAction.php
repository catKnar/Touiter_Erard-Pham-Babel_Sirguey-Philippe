<?php

namespace Touiteur\action;

use Touiteur\repository\TouiterRepository;

class EvalueTouiteAction extends Action
{
    public function execute(): string
    {
        // Récupération des paramètres
        $idTouite = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $note = filter_input(INPUT_GET, 'note', FILTER_VALIDATE_INT);
       
        $repo = TouiterRepository::getInstance();

     
        if ($note === 1) {
            $repo->incrementPouceUp($idTouite);
        } else {
            $repo->incrementPouceDown($idTouite);
        }

        // Retour à la page du touite
        header('Location: ?action=detail&id_touite=' . $idTouite);
        exit;
    }
}
