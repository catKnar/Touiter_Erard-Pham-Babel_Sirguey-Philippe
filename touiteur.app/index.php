<?php

require_once 'src/vendor/autoload.php';

use Touiteur\action\AfficherListeTagAction;
use Touiteur\action\DefaultAction;
use Touiteur\action\AfficherProfilAction;
use Touiteur\action\AfficherTweetAction;
use Touiteur\action\AfficherListeTag;
use Touiteur\action\AfficherUtilisateurProfilAction;
use Touiteur\action\EvalueTouiteAction;
use Touiteur\action\FollowTagAction;
use Touiteur\action\FollowerAction;
use Touiteur\repository\TouiterRepository;
use Touiteur\conf\Router;

session_start();
$_SESSION['id_user'] = 333;
TouiterRepository::setConfig('Config.db.ini');

$Dispatcher = new Router();
$Dispatcher->addRoute('default', DefaultAction::class);
$Dispatcher->addRoute('profil', AfficherProfilAction::class);
$Dispatcher->addRoute('detail', AfficherTweetAction::class);
$Dispatcher->addRoute('tag-touites', AfficherListeTagAction::class);
$Dispatcher->addRoute('user-touites', AfficherUtilisateurProfilAction::class);
$Dispatcher->addRoute('follow-user', FollowerAction::class);
$Dispatcher->addRoute('evaluate-touite', EvalueTouiteAction::class);
$Dispatcher->addRoute('follow-tag', FollowTagAction::class);

try {
    echo $Dispatcher->run();
} catch (Exception $e) {
    echo "Oups, erreur: " . $e->getMessage();
}

?>