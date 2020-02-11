<?php

define('ROOT_PATH', __DIR__);

// start the MVC programme
require_once 'program/mainController.php';
$data = new Controller;
$dataview = $data->chargement();

include 'views/layout.phtml';

?>