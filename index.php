<?php

define('ROOT_PATH', __DIR__);

// start the MVC programme
require_once 'library/bdd.class.php';
require_once 'program/mainController.php';
include 'models/GamesModel.class.php';
$data = new Controller;
$dataview = $data->chargement();

include 'views/layout.phtml';

?>