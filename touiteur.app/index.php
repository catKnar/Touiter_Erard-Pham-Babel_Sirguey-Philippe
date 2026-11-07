<?php

require_once 'src/vendor/autoload.php';

use Touiteur\action\DefaultAction;
use Touiteur\action\AfficherProfilAction;
use Touiteur\repository\TouiterRepository;
use Touiteur\dispatch\Dispatcher;
use Touiteur\conf\Router;

session_start();
TouiterRepository::setConfig('Config.db.ini');

$Dispatcher = new Router();
$Dispatcher->addRoute('default', DefaultAction::class);
$Dispatcher->addRoute('profil', AfficherProfilAction::class);

try {
    echo $Dispatcher->run();
} catch (Exception $e) {
    echo "Oupss, erreur" . $e->getMessage();
}

?>