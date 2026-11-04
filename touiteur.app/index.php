<?php

require_once 'src/vendor/autoload.php';

use Touiteur\classes\Utilisateur;
use Touiteur\repository\TouiterRepository;

TouiterRepository::setConfig('Config.db.ini');
$u1 = new utilisateur(333, "Eponge", "Bob", "poisson@uni.fr", 0);

echo $u1->toHtml();

?>