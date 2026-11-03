<?php
namespace Touiteur\interfaces;
interface Renderer
{
    const COMPACT=1;
    const LONG=2;
    function render(int $selector):string;
}