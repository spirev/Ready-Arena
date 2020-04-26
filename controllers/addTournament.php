<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    
    $tournamentModel = new TournamentsModel();
    $tmpPlayerList = '10';

    if (empty($_GET['soloTeam'])) {
        $_GET['soloTeam'] = 'Team';
    }
    if (empty($_GET['maxParticipants'])) {
        $_GET['maxParticipants'] = 32;
    }

    if (!empty($_GET['name']) && !empty($_GET['startDate'])) {
        $tournamentModel->addTournament($_GET['name'], $_COOKIE['game'], $_GET['maxParticipants'], $_GET['soloTeam'], $_GET['averageSkill'], $_GET['startDate'], $tmpPlayerList);
        var_dump('ok name / ok date');
        setcookie('game', null, -1, '/'); // doesn't work...
        header('Location: /finalProject/index.php');
        exit;
    }
    else {
        header('Location: /finalProject/index.php');
        exit;
    }
?>