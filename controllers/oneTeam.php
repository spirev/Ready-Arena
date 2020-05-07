<?php

    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/GamesModel.class.php';
    include '../controllers/LayoutController.php';

    $teamsModel = new TeamsModel();
    $usersModel = new UsersModel();
    $team = $teamsModel->findById($_GET['id']);
    $playerList = $team[0]['teammates'];
    $waitingList = $team[0]['waiting_list'];
    $list = [];
    $players = [];
    $waitingPlayers = [];
    $alreadyIn = false;
    $alreadyRegister = false;

    if(!empty($playerList)) {
        $list = explode(' ', $playerList);
    }
    for($i = 0; $i < count($list);$i++) {
        $players[$i] = $usersModel->findById(intval($list[$i], 10));
        if (isset($_SESSION['name'])) {
            if ($players[$i][0]['name'] == $_SESSION['name']) {
                $alreadyIn = true;
                $alreadyRegister = true;
            }
        }
    }

    if(!empty($waitingList)) {
        $list = explode(' ', $waitingList);
        for ($i = 0;$i < count($list);$i++) {
            $waitingPlayers[$i] = $usersModel->findById(intval($list[$i], 10));
            if (isset($_SESSION['name'])) {
                if ($waitingPlayers[$i][0]['name'] == $_SESSION['name']) {
                    $alreadyIn = true;
                }
            }
        }
    }

    $gamesModel = new GamesModel();
    $game = $gamesModel->findByName($_GET['game']);

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>