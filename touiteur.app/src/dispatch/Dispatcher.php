<?php

namespace Touiteur\dispatch;



class Dispatcher
{
    protected ?string $action;
    public function __construct()
    {
        $this->action = isset($_GET['action']) ? $_GET['action'] : null;
    }

    private function renderPage(string $html):void
    {
        if(isset($_SESSION['user_id']))
        {
            $id=$_SESSION['user_id'];
        }
        else{
            $id=0;
        }
        $res="<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <title>Touiteur</title>
</head>
<style>
body {
  margin: 0;
  padding: 0;
}
h2,h3, p {
  margin: 10px;
}


</style>
<body>
        
    
    <p>Bonjour, ".$id." !</p>
    ".$html."
</body>";
        echo $res;
    }
    public function run():void
    {
        $this->renderPage();
    }
}


?>