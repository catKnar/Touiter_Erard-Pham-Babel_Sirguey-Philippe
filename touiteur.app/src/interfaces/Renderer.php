<?php
namespace Touiteur\src\interfaces;
interface Renderer
{
    const COMPACT=1;
    const LONG=2;
    function render(int $selector):string;
}