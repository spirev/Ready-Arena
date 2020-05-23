<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';

    $userModel = new UsersModel();
    $tournamentModel = new TournamentsModel();

    if (isset($_GET['format'])) {
        $tournament = $tournamentModel->findById($_GET['tournament']);
        $oldPlayerList = $tournament[0]['playerList'];
        $newPlayerList = $oldPlayerList." ".$_GET['teamId'];
        $tournamentModel->updatePlayerList($newPlayerList, $_GET['tournament']);
        header('Location: oneTournament.php?path=oneTournament&id='.$_GET['tournament']."&format=team");
    }
    else {
        $requestPlayer = $userModel->findById($_GET['id']);
        $requestPlayerInviteBox = $requestPlayer[0]['team_invite'];
        if (empty($requestPlayerInviteBox)) {
            $requestPlayerInviteBox .= $_GET['team'];
        }
        else {
            $requestPlayerInviteBox .= " ".$_GET['team'];
        }
        $userModel->updateTeamInvite($requestPlayerInviteBox, $_GET['id']);
        header('Location: ../index.php?flash=sendInvite');
    }
?>