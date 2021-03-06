<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include '../controllers/LayoutController.php';
    
    $tournamentModel = new TournamentsModel();
    $lastTournament = $tournamentModel->maxId();
    $lastId = intval($lastTournament[0]['MAX(id)'], 10);
    $lastId = $lastId + 1;

    //check if a user is connected before seting the tournament
    if (!isset($_SESSION['name'])) {
        header('Location: ../index.php?flash=notConnected');
        exit;
    }
    if (empty($_GET['soloTeam'])) {
        $_GET['soloTeam'] = 'team';
    }
    if (empty($_GET['maxParticipants'])) {
        $_GET['maxParticipants'] = 32;
    }

    function resetAllId($tournamentModel) {
        $allTournaments = $tournamentModel->findAll();
        var_dump($allTournaments);
        for ($i = 0;$i < count($allTournaments);$i++) {
            $tournamentModel->updateId($allTournaments[$i]['id'], $i + 1);
        }
    }
    
// if team choice isn't done yet or if tournament is solo
    if (!isset($_GET['action'])) {
        if ($_GET['soloTeam'] === 'solo') {
            //if tournament format is 'solo' add this tournament to the database
            if (!empty($_GET['name']) && !empty($_GET['startDate'])) {
                $tournamentModel->addTournament($lastId, htmlspecialchars($_GET['name'], ENT_QUOTES), $_COOKIE['game'], $_GET['maxParticipants'], $_GET['soloTeam'], htmlspecialchars($_GET['averageSkill'], ENT_QUOTES), $_GET['startDate'], $_SESSION['id']);
                //resetAllId($tournamentModel);
                header('Location: ../index.php?flash=tournament');
                exit;
            }
            else {
                header('Location: ../index.php?flash=incorrectForm');
                exit;
            }
        }
        else {
            //if tournament format is 'team' redirect to 'inviteToTeam.php' for team selection then go to this script again with all previous 'GET' info + chosen team
            //this is reuse of 'inviteToTeam.phtml', variable 'action' is there to specify to 'inviteToTeam.phtml' that it is meant for adding a team as the first participant
            if (!empty($_GET['name']) && !empty($_GET['startDate'])) {
                header('Location: inviteToTeam.php?path=inviteToTeam&action=addTournament&formName='.htmlspecialchars($_GET['name'])."&startDate=".$_GET['startDate']."&soloTeam=".$_GET['soloTeam']."&maxParticipants=".$_GET['maxParticipants']."&averageSkill=".htmlspecialchars($_GET['averageSkill'], ENT_QUOTES));
            }
            else {
                header('Location: ../index.php?flash=incorrectForm');
            }
        }
    }
    else {
        // if tournament is for teams and choice has been made
        $tournamentModel->addTournament($lastId, htmlspecialchars($_GET['formName'], ENT_QUOTES), $_COOKIE['game'], $_GET['maxParticipants'], $_GET['soloTeam'], $_GET['averageSkill'], $_GET['startDate'], $_GET['teamId']);
        header('Location: ../index.php?flash=tournament');
        //resetAllId($tournamentModel);
}
?>