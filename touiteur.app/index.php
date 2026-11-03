<?php

require_once 'src/vendor/autoload.php';

use Touiteur\src\classes\utilisateur;

$u1 = new utilisateur(333, "Eponge", "Bob", "poisson@uni.fr", 0);

echo $u1->toHtml();

?>