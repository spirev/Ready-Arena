<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/GamesModel.class.php';
    include '../controllers/LayoutController.php';

    $gameModel = new GamesModel();
    $game = $gameModel->findByName($_GET['game']);

    $playerModel = new UsersModel();
    $players = $playerModel->findAll();
    $playerTab = [];


    // look for each player if he is looking for a team for this game
    foreach ($players as $player) {
        if ($game[0]['id'] < 10) {
            if (strpos(substr($player['look_for_team'], 0, 2), $game[0]['id']." ") !== false) {
                array_push($playerTab, $player);
            }
            else if (strpos($player['look_for_team'], " ".$game[0]['id']." ") !== false) {
                array_push($playerTab, $player);
            }
            else if(strpos(substr($player['look_for_team'], -2), " ".$game[0]['id']) !== false) {
                array_push($playerTab, $player);
            }
            else {
            }
        }
        else {
            if (strpos(substr($player['look_for_team'], 0, 3), $game[0]['id']." ") !== false) {
                array_push($playerTab, $player);
            }
            else if (strpos($player['look_for_team'], " ".$game[0]['id']." ") !== false) {
                array_push($playerTab, $player);
            }
            else if(strpos(substr($player['look_for_team'], -3), " ".$game[0]['id']) !== false) {
                array_push($playerTab, $player);
            }
            else {
            }
        }
    }
    //var_dump($playerTab);

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>