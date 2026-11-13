<?php

namespace Touiteur\conf;

use Exception;

class Router
{

  protected ?string $action = null;
  protected $actions = [];

  public function __construct()
  {

    $this->action =  $_GET['action'] ?? 'default';
  }

  public function addRoute(string $action, string $action_class): Router
  {
    $this->actions[$action] =  $action_class;
    return $this;
  }

  private function renderPage(string $html): string
  {


    $res = "<html lang=\"fr\">

<head>
    <meta charset=\"UTF-8\">
    <title>Touiteur</title>
</head>
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #000d26; 
  
}

h1,h2,h3, p {
  margin: 10px;
  color : white;
  font-family: monospace, sans-serif;
}

.navbar {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #d9084e;
}
.navbar li {
  float: left;
  margin-right: 20px;
  
}

.navbar li h2 {
  color: white;
  font-family: monospace, sans-serif;
}
.navbar li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-family: monospace, sans-serif;
}

.navbar h1{
color: white;
text-align: center;
}
</style>
<body>
        <ul class='navbar'>
        <h1>Touiteur le faux</h1>
            <li><a href='?action=default'><h2>Accueil</h2></a></li>
            <li><a href='?action=profil'><h2>Compte</h2></a></li>
            <li><a href='?action=publier'><h2>Publier</h2></a></li>
        </ul>

          " . $html . "
    
</body>";

    return $res;
  }

  public function run(): string
  {
    if (isset($this->actions[$this->action])) {
      $action_class = $this->actions[$this->action];
      $action = new $action_class();
      return $this->renderPage($action->execute());
    } else {
      throw new Exception("Action '{$this->action}' not found");
    }
  }
}
