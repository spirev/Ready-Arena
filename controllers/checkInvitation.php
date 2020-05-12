<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    $userModel = new UsersModel();
    $requestPlayer = $userModel->findById($_GET['id']);
    $requestPlayerInviteBox = $requestPlayer[0]['team_invite'];
    if (empty($requestPlayerInviteBox)) {
        $requestPlayerInviteBox = $_GET['team'];
    }
    else {
        $requestPlayerInviteBox .= " ".$_GET['team'];
    }
    $userModel->updateTeamInvite($requestPlayerInviteBox, $_GET['id']);
    header('Location: ../index.php?flash=sendInvite');

?>