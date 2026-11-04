<?php

namespace Touiteur\conf;

use Exception;

class Router {
    
    protected ?string $action = null;
    protected $actions = [];
    
    public function __construct(){

        $this->action =  $_GET['action'] ?? 'default';
    }
    
    public function addRoute(string $action, string $action_class) : Router {

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
            <li><h2>Compte</h2></li>
            <li><h2>Recherche</h2></li>
        </ul>

        <h2>Bienvenue sur le site de Touiteur</h2>

          ".$html."
    
</body>";
        return $res;
    }

    public function run() : string {

        if (isset($this->actions[$this->action])) {
            $action_class = $this->actions[$this->action];
            $action = new $action_class();
            return $this->renderPage($action->execute());
        }
        else {
            throw new Exception("Erreur d'action");
        }
    }

}

?>