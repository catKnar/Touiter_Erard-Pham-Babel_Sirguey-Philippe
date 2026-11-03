<?php

require_once 'src/vendor/autoload.php';

use Touiteur\classes\Utilisateur;

$u1 = new utilisateur(333, "Eponge", "Bob", "poisson@uni.fr", 0);

echo $u1->toHtml();

?>