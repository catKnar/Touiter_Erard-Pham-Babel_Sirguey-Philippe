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
     * 
     */
    private function renderCompact(): string
    {

    }

    /**
     * 
     */
    private function renderLong(): string
    {

    }
    
}