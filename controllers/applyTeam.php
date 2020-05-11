<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';

    session_start();
    $userModel = new UsersModel();
    $teamModel = new TeamsModel();

    $currentUser = $userModel->checkName($_SESSION['name']);
    $currentTeam = $teamModel->findById($_GET['id']);
    $waitingList = $currentTeam[0]['waiting_list'];

    if (empty($waitingList)) {
        $waitingList = $currentUser[0]['id'];
    }
    else {
        $waitingList .= " ".$currentUser[0]['id'];
    }
    $teamModel->updateWaitingPlayer($currentTeam[0]['id'], $waitingList);
    header('Location: oneTeam.php?path=oneTeam&id='.$currentTeam[0]['id'].'&game='.$currentTeam[0]['game']);

?>