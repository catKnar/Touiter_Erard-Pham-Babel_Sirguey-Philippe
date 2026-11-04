<?php

namespace Touiteur\renders;

use Touiteur\classes\Touite;
use Touiteur\interface\Renderer;

class TouiteListRenderer implements Renderer
{
    private array $touites;
    private string $titre;

    /**
     * 
     */
    public function __construct(array $touites, string $titre = "Liste des touites")
    {
        $this->touites = $touites;
        $this->titre = $titre;
    }

    public function render(int $selector = self::COMPACT): string
    {
        $titreXSS = htmlspecialchars($this->titre);
        $retour = "<div class='touite-list'><h2>{$titreXSS}</h2>";
        
        if (empty($this->touites)) {
            $retour .= "<p>Aucun touite à afficher pour le moment.</p></div>";
            return $retour;
        }

        return $retour;
    }
}