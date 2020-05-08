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

    if (isset($_GET['deletePlayer'])) {
        $oldTeammates = explode(' ', $playerList);
        for ($i = 0;$i < count($oldTeammates);$i++) {
            if ($oldTeammates[$i] == $_GET['user']) {
                $y = $oldTeammates[0];
                $oldTeammates[0] = $oldTeammates[$i];
                $oldTeammates[$i] = $y;
            }
        }
        array_shift($oldTeammates);
        $newList = implode(' ', $oldTeammates);
        if ($newList[0] == ' ') {
            $newList = substr($newList, 1, strlen($newList));
        }
        $teamsModel->addTeammates($team[0]['id'], $newList);
        header('Location: oneTeam.php?path=oneTeam&id='.$team[0]['id'].'&game='.$team[0]['game']);
    }

    if (isset($_GET['reloadComment'])) {
        $teamsModel->updateComment($team[0]['id'], $_POST['reloadComment']);
        header('Location: oneTeam.php?path=oneTeam&id='.$team[0]['id'].'&game='.$team[0]['game']);
    }

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