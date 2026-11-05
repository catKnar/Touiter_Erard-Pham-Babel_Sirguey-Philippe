<?php

namespace Touiteur\renders;

use Touiteur\classes\Utilisateur;
use Touiteur\interfaces\Renderer;

class UtilisateurRenderer implements Renderer
{
    private Utilisateur $user;

    public function __construct(Utilisateur $user) {
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
        $nbTouites = (int)$this->user->get('nb_touite');

        if ($selector === self::LONG) {
            return <<<HTML
            <div class="user-profile" style="border: 1px solid white; padding: 15px; margin: 10px;">
                <h2>Profil de {$prenom} {$nom} (@{$id})</h2>
                <p>Email : {$email}</p>
                <p>Nombre de touites publiés : {$nbTouites}</p>
                <p>
                    <a href="?action=user-touites&id_user={$id}" style="color: #00bfff;">Voir ses touites</a> |
                    <a href="?action=follow-user&id_user={$id}" style="color: #00ff88;">Suivre cet utilisateur</a>
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