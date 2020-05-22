<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    session_start();
    $userModel = new UsersModel();
    $tournamentModel = new TournamentsModel();
    
    $currentUser = $userModel->checkName($_SESSION['name']);
    $currentTournament = $tournamentModel->findById($_GET['id']);
    $playerList = $currentTournament[0]['playerList'];

    if (isset($_GET['format']) && $_GET['format'] == 'solo') {
        $playerList .= " ".$currentUser[0]['id'];
    }
    else {
        //if tournament format is team --> re-use of inviteToTeam.phtml
        header('Location: inviteToTeam.php?path=inviteToteam&format=team&id='.$currentUser[0]['id']."&Tid=".$currentTournament[0]['id']);
        exit;
    }
    $tournamentModel->updatePlayerList($playerList, $_GET['id']);
    header('Location: oneTournament.php?path=oneTournament&id='.$currentTournament[0]['id']."&flash=apply");

?>