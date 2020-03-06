<?php
    $allGameModel = new GamesModel();
    $allGames = $allGameModel->findAll();

    var_dump($allGames);
?>