<?php
    $allGameModel = new GamesModel();
    $allGames = $allGameModel->findAll();
    var_dump($allGames);
    foreach($allGames as $game) {
        var_dump("img/games_icone/" . $game['icone']);
    }
?>
