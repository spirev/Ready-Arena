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

    $playerList .= " ".$currentUser[0]['id'];
    $tournamentModel->updatePlayerList($playerList, $_GET['id']);
    header('Location: ../index.php');

?>