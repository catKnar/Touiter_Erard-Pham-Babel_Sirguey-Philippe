<?php

// à laisser pour l'instant au cas où car Switch plus facile que Router 

namespace Touiteur\dispatch;

use Touiteur\action\DefaultAction;

class Dispatcher
{
    protected ?string $action;
    public function __construct()
    {
        $this->action = isset($_GET['action']) ? $_GET['action'] : null;
    }

    private function renderPage(string $html): void
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
  background-color: #ff5500;
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
        echo $res;
    }
    public function run(): void
    {


    switch ($this->action) {
        default:
            $action = new DefaultAction();
            break;

       
    }
     $this->renderPage($action->execute());
}

}
