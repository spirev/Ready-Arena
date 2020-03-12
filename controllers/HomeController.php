<?php

include 'controllers/LayoutController.php';

    $allGameModel = new GamesModel();
    $allGames = $allGameModel->findAll();

?>