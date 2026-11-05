<?php

namespace Touiteur\renders;

use Touiteur\classes\Image;
use Touiteur\interfaces\Renderer;

class ImageRenderer implements Renderer
{
    private Image $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function render(int $selector = self::COMPACT): string
    {
        if ($selector === self::COMPACT) {
            return "";
        }

       
        $nomFichier = basename($this->image->get('chemin_fichier'));

        
        $url = htmlspecialchars('src/img/' . $nomFichier);

       
        $cheminDisque = __DIR__ . '/../img/' . $nomFichier;

        $desc = htmlspecialchars($this->image->get('description_image'));

        if (!file_exists($cheminDisque)) {
            return "<p><small><em>Image introuvable : {$desc} ({$nomFichier})</em></small></p>";
        }

        return <<<HTML
        <div class="touite-image" style="margin: 10px 0;">
            <img src="{$url}" alt="{$desc}" style="max-width: 400px; border-radius: 5px;">
        </div>
        HTML;
    }
}