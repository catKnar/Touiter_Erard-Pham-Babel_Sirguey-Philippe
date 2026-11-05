<?php

namespace Touiteur\renders;

use Touiteur\classes\Tag;
use Touiteur\interface\Renderer;

class TagRenderer implements Renderer
{
    private Tag $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function render(int $selector = self::COMPACT): string
    {
        return "";
    }
}