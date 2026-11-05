<?php

namespace Touiteur\renders;

use Touiteur\classes\Touite;
use Touiteur\interfaces\Renderer;

class TouiteListRenderer implements Renderer
{
    private array $touites;
    private string $titre;

    /**
     * Constructor
     * @param array $touites
     * @param string $titre
     */
    public function __construct(array $touites, string $titre = "Liste des touites")
    {
        $this->touites = $touites;
        $this->titre = $titre;
    }

    /**
     * Render
     * @param int $selector
     * @return string
     */
    public function render(int $selector = self::COMPACT): string
    {
        $titreXSS = htmlspecialchars($this->titre);
        $retour = "<div class='touite-list'><h2>{$titreXSS}</h2>";
        
        if (empty($this->touites)) {
            $retour .= "<p>Aucun touite à afficher pour le moment.</p></div>";
            return $retour;
        }

        $retour .= "<ul style='list-style-type: none; padding: 0;'>";
        foreach ($this->touites as $touite) {
            if ($touite instanceof Touite) {
                $renderer = new TouiteRenderer($touite);
                $retour .= "<li>" . $renderer->render($selector) . "</li>";
            }
        }
        $retour .= "</ul>";
        $retour .= "<p>Total affiché : " . count($this->touites) . " touite(s)</p></div>";

        return $retour;
    }
}