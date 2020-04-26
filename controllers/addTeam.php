<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    
    $teamModel = new TeamsModel();
    $tmpCaptain = 'Menthe'; /* has to change once login ok */
    $tmpTeammates = '10';   /* has to change once login ok */
    
    if (empty($_POST['LFP'])) {
        $_POST['LFP'] = 0;
    }
    
    if (!empty($_POST['name']) && !empty($_POST['comment'])) {
        $teamModel->addTeam($_POST['name'], $_GET['game'], $tmpCaptain, $_POST['LFP'], $_POST['comment'], $tmpTeammates);
        header('Location: /finalProject/index.php');
        exit;
    }
    else {
        header('Location: /finalProject/controllers/createTeam.php?path=createTeam&game='.$_GET['game']);
        exit;
    }

//header('Location : '.ROOT_PATH.'index.php');
//header('Location : '.ROOT_PATH.'controllers/createTeam.php?path=createTeam');
?>