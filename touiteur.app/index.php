<?php

require_once 'src/vendor/autoload.php';

use Touiteur\action\DefaultAction;
use Touiteur\action\AfficherProfilAction;
use Touiteur\action\AfficherTweetAction;
use Touiteur\action\AfficherUtilisateurProfilAction;
use Touiteur\action\AfficherListeTag;
use Touiteur\repository\TouiterRepository;
use Touiteur\conf\Router;

session_start();
TouiterRepository::setConfig('Config.db.ini');

$Dispatcher = new Router();
$Dispatcher->addRoute('default', DefaultAction::class);
$Dispatcher->addRoute('profil', AfficherProfilAction::class);
$Dispatcher->addRoute('detail', AfficherTweetAction::class);
$Dispatcher->addRoute('tag-touites', AfficherListeTag::class);
$Dispatcher->addRoute('user-touites', AfficherUtilisateurProfilAction::class);

try {
    echo $Dispatcher->run();
} catch (Exception $e) {
    echo "Oups, erreur: " . $e->getMessage();
}

?>