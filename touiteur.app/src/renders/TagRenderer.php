<?php

namespace Touiteur\renders;

use Touiteur\classes\Tag;
use Touiteur\interfaces\Renderer;

class TagRenderer implements Renderer
{
    private Tag $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function render(int $selector = self::COMPACT): string
    {
        $id = $this->tag->get('id_tag');
        $libelle = htmlspecialchars($this->tag->get('libelle'));
        $desc = htmlspecialchars($this->tag->get('description_tag'));

        if ($selector === self::LONG) {
            return <<<HTML
            <div class="tag-detail" style="border: 1px solid #00bfff; padding: 10px; margin: 10px;">
                <h3><a href="?action=tag-touites&id_tag={$id}" style="color: #00bfff;">#{$libelle}</a></h3>
                <p>{$desc}</p>
                <p><a href="?action=subscribe-tag&id_tag={$id}" style="color: #00ff88;">[+ S'abonner à ce tag]</a></p>
            </div>
            HTML;
        }

        return "<a href='?action=tag-touites&id_tag={$id}' style='color: #00bfff;'>#{$libelle}</a>";
    }
}