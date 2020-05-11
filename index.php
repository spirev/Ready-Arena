<?php

define('ROOT_PATH', __DIR__);
require_once 'library/bdd.class.php';
include 'models/GamesModel.class.php';
include 'controllers/HomeController.php';
$_GET['path'] = 'home';

if (isset($_GET['path'])) {
    $dataview = ROOT_PATH.'/views/HomeView/HomeView.phtml';
}
else {
    $dataview = ROOT_PATH.'/views/HomeView/HomeView.phtml';
}

include 'views/layout.phtml';

?>