<?php

namespace Touiteur\renders;

use Touiteur\classes\Utilisateur;
use Touiteur\interfaces\Renderer;
use Touiteur\repository\TouiterRepository;

class UtilisateurRenderer implements Renderer
{
    private Utilisateur $user;

    public function __construct(Utilisateur $user)
    {
        $this->user = $user;
    }

    /**
     * Render
     * @param int $selector
     * @return string
     */
    public function render(int $selector = self::COMPACT): string
    {
        $id = $this->user->get('id_user');
        $nom = htmlspecialchars($this->user->get('nom'));
        $prenom = htmlspecialchars($this->user->get('prenom'));
        $email = htmlspecialchars($this->user->get('email'));

        $repo = TouiterRepository::getInstance();
        $nbTouites = count($repo->Afficher_Touite_Personne_donnee((int) $id));

        if ($selector === self::LONG) {
            $texteSuivi = $repo->estSuivi(333, (int) $id) ? 'Ne plus suivre' : 'Suivre cet utilisateur';
            return <<<HTML
            <div class="user-profile" style="border: 1px solid white; padding: 15px; margin: 10px;">
                <h2>Profil de {$prenom} {$nom} (@{$id})</h2>
                <p>Email : {$email}</p>
                <p>Nombre de touites publiés : {$nbTouites}</p>
                <p>
                    <a href="?action=follow-user&id_user={$id}&origine=profil" style="color: #00ff88;">{$texteSuivi}</a>
                </p>
            </div>
            HTML;
        }

        // Mode Compact
        return <<<HTML
        <div class="user-compact">
            <p>
                <strong><a href="?action=user-touites&id_user={$id}" style="color: #ff5500;">{$prenom} {$nom} (@{$id})</a></strong>
                - {$nbTouites} touite(s)
            </p>
        </div>
        HTML;
    }
}
