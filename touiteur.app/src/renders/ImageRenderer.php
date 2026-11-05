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
        return "";
    }
}