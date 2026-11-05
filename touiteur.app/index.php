<?php

require_once 'src/vendor/autoload.php';

use Touiteur\action\DefaultAction;
use Touiteur\classes\Utilisateur;
use Touiteur\repository\TouiterRepository;
use Touiteur\dispatch\Dispatcher;
use Touiteur\conf\Router;

session_start();
TouiterRepository::setConfig('Config.db.ini');

$Dispatcher = new Router()->addRoute('default', DefaultAction::class);

try {
    echo $Dispatcher->run();
} catch (Exception $e) {
    echo "Oupss, erreur" . $e->getMessage();
}

$u1 = new utilisateur(333, "Eponge", "Bob", "poisson@uni.fr", 0);

echo $u1->toHtml();
