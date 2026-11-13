<?php

namespace Touiteur\action;

use Touiteur\action\Action;
use Touiteur\repository\TouiterRepository;
use Touiteur\interfaces\Renderer;
use Touiteur\renders\TouiteRenderer;
use Touiteur\renders\UtilisateurRenderer;

class AfficherUtilisateurProfilAction extends Action
{

    public function execute(): string
    {
        $idUser = (int) $_GET['id_user'];

        $repo = TouiterRepository::getInstance();
        $result = $repo->Afficher_Touite_Personne_donnee($idUser);

        $user = $result[0]['auteur'] ?? null;

        if ($user === $user) {
            header('Location: ?action=profil');
            exit;
        }

        $html = (new UtilisateurRenderer($user))->render(Renderer::LONG);

        foreach ($result as $item) {
            $html .= (new TouiteRenderer($item['touite']))->render(Renderer::COMPACT);
        }

        return $html;
    }
}
