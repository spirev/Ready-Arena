<?php

    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/GamesModel.class.php';
    include '../controllers/LayoutController.php';

    $teamsModel = new TeamsModel();
    $team = $teamsModel->findById($_GET['id']);
    $usersModel = new UsersModel();
    $playerList = $team[0]['teammates'];
    $list = [];
    $players = [];

    if(!empty($playerList)) {
        $list = explode(' ', $playerList);
    }
    for($i = 0; $i < count($list);$i++) {
        $players[$i] = $usersModel->findById(intval($list[$i], 10));
    }

    $gamesModel = new GamesModel();
    $game = $gamesModel->findByName($_GET['game']);

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>