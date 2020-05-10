<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include '../controllers/LayoutController.php';
    
    //check if a user is connected before seting the tournament
    if (!isset($_SESSION['name'])) {
        header('Location: ../index.php?flash=notConnected');
        exit;
    }
    
    $tournamentModel = new TournamentsModel();
    $lastTournament = $tournamentModel->maxId();
    $lastId = intval($lastTournament[0]['MAX(id)'], 10);
    $lastId = $lastId + 1;

    if (empty($_GET['soloTeam'])) {
        $_GET['soloTeam'] = 'Team';
    }
    if (empty($_GET['maxParticipants'])) {
        $_GET['maxParticipants'] = 32;
    }


    if (!empty($_GET['name']) && !empty($_GET['startDate'])) {
        $tournamentModel->addTournament($lastId, $_GET['name'], $_COOKIE['game'], $_GET['maxParticipants'], $_GET['soloTeam'], $_GET['averageSkill'], $_GET['startDate'], $_SESSION['id']);
        setcookie('game', null, -1, '/'); // doesn't work...
        header('Location: /finalProject/index.php');
        exit;
    }
    else {
        header('Location: /finalProject/index.php?flash=incorrectForm');
        exit;
    }
?>