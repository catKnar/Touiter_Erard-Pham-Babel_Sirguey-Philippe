<?php

namespace Touiteur\dispatch;



class Dispatcher
{
    protected ?string $action;
    public function __construct()
    {
        $this->action = isset($_GET['action']) ? $_GET['action'] : null;
    }

    private function renderPage(): void
    {
        $html = '';

        $res = "<html lang=\"fr\">
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
        
    
    <p>Bonjour !</p>
    " . $html . "
</body>";
        echo $res;
    }
    public function run(): void
    {
        $this->renderPage();
    }
}


?>