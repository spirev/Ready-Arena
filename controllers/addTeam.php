<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include '../controllers/LayoutController.php';
    
    //check if a user is connected before seting the team
    if (!isset($_SESSION['name'])) {
        header('Location: ../index.php?flash=notConnected');
        exit;
    }

    $teamModel = new TeamsModel();
    $lastTeam = $teamModel->maxID();
    $lastId = intval($lastTeam[0]['MAX(id)'], 10);
    $lastId = $lastId + 1;

    if (empty($_POST['LFP'])) {
        $_POST['LFP'] = 0;
    }
    
    if (!empty($_POST['name']) && !empty($_POST['comment'])) {
        $teamModel->addTeam($lastId, htmlspecialchars($_POST['name'], ENT_QUOTES), $_GET['game'], $_SESSION['name'], $_POST['LFP'], htmlspecialchars($_POST['comment'], ENT_QUOTES), $_SESSION['id']);
        header('Location: ../index.php?flash=team');
        exit;
    }
    else {
        header('Location: createTeam.php?path=createTeam&game='.$_GET['game']);
        exit;
    }

//header('Location : '.ROOT_PATH.'index.php');
//header('Location : '.ROOT_PATH.'controllers/createTeam.php?path=createTeam');
?>