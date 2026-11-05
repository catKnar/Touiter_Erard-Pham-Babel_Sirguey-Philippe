<?php

namespace Touiteur\renders;

use Touiteur\classes\Touite;
use Touiteur\interfaces\Renderer;

class TouiteRenderer implements Renderer
{
    private Touite $touite;

    public function __construct(Touite $touite)
    {
        $this->touite = $touite;
    }

    public function render(int $selector = self::COMPACT): string
    {
        switch ($selector) {
            case self::LONG:
                return $this->renderLong();
            case self::COMPACT:
            default:
                return $this-> renderCompact();
        }
    }

    /**
     * Affichage court pour les listes de touites
     */
    private function renderCompact(): string
    {
        $id = $this->touite->get('id_touite');
        $idUser = $this->touite->get('id_user');
        $date = htmlspecialchars((string)$this->touite->get('date'));
        $texte = htmlspecialchars($this->touite->get('texte'));

        // Tronquage si texte trop long
        $apercu = mb_strlen($texte) > 100 ? mb_substr($texte, 0, 100) . "..." : $texte;
        
        return <<<HTML
        <div class="touite-compact" style="border: 1px solid #ff5500; margin: 10px; padding: 10px; border-radius: 5px;">
            <p>
                <strong><a href="?action=user-touites&id_user={$idUser}" style="color: #ff5500;">@Utilisateur #{$idUser}</a></strong>
                <small style="color: #ccc;"> - {$date}</small>
            </p>
            <p>{$apercu}</p>
            <p><a href="?action=display-touite&id={$id}" style="color: #00bfff;">Voir le touite en détail →</a></p>
        </div>
        HTML;
    }

    /**
     * 
     */
    private function renderLong(): string
    {
        return "";
    }

}