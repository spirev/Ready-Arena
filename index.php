<?php

define('ROOT_PATH', __DIR__);

// start the MVC programme
require_once 'library/bdd.class.php';
//require_once 'program/mainController.php';
include 'models/GamesModel.class.php';
include 'controllers/HomeController.php';
//$data = new MainController;
//$dataview = $data->chargement();
$_GET['path'] = 'home';

if (isset($_GET['path'])) {
    $dataview = ROOT_PATH.'/views/HomeView/HomeView.phtml';
}
else {
    $dataview = ROOT_PATH.'/views/HomeView/HomeView.phtml';
}

include 'views/layout.phtml';

?>