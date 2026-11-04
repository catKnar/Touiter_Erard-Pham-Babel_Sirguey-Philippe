<?php

require_once 'src/vendor/autoload.php';

use Touiteur\classes\Utilisateur;
use Touiteur\repository\TouiterRepository;
use Touiteur\dispatch\Dispatcher;

session_start();

$Dispatcher = new Dispatcher();
$Dispatcher->run();

TouiterRepository::setConfig('Config.db.ini');
$u1 = new utilisateur(333, "Eponge", "Bob", "poisson@uni.fr", 0);

echo $u1->toHtml();

?>