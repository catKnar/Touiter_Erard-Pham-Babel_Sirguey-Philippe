<?php

namespace Touiteur\renders;

use Touiteur\classes\Image;
use Touiteur\interface\Renderer;

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

        $chemin = htmlspecialchars($this->image->get('chemin_fichier'));
        $desc = htmlspecialchars($this->image->get('description_image'));

        return <<<HTML
        <div class="touite-image" style="margin: 10px 0;">
            <img src="{$chemin}" alt="{$desc}" style="max-width: 400px; border-radius: 5px;">
            <p><small><em>{$desc}</em></small></p>
        </div>
        HTML;
    }
}