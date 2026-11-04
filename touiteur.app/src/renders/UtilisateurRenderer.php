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
        return "";
    }
}