<?php

    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/GamesModel.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include '../controllers/LayoutController.php';

    $teamsModel = new TeamsModel();
    $usersModel = new UsersModel();
    $gamesModel = new GamesModel();
    $tournamentsModel = new TournamentsModel();
    $game = $gamesModel->findByName($_GET['game']);
    try {
        $team = $teamsModel->findById($_GET['id']);
        if (empty($team)) {
            throw new Exception('team is unreachable');
        }
    }
    catch(Exception $e){
        header('Location: ../index.php?flash=wrongTeam');
    }
    $teammates = $team[0]['teammates'];
    $waitingList = $team[0]['waiting_list'];
    $list = [];
    $players = [];
    $waitingPlayers = [];
    $alreadyIn = false;
    $alreadyRegister = false;

    if (isset($_GET['deletePlayer'])) {
        $oldTeammates = explode(' ', $teammates);
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
        $teamsModel->updateComment($team[0]['id'], htmlspecialchars($_POST['reloadComment'], ENT_QUOTES));
        header('Location: oneTeam.php?path=oneTeam&id='.$team[0]['id'].'&game='.$team[0]['game']);
    }

    if(!empty($teammates)) {
        $list = explode(' ', $teammates);
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

    $upcomingTournaments = [];
    $i = 0;
    $allTournamentsFormatTeam = $tournamentsModel->findByFormat('team');
    foreach ($allTournamentsFormatTeam as $tournament) {
        if (in_array($_GET['id'], explode(' ', $tournament['playerList']))) {
            $upcomingTournaments[$i] = $tournamentsModel->findById($tournament['id']);
            $i++;
        }
    }

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>