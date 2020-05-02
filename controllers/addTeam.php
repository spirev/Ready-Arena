<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include '../controllers/LayoutController.php';
    
    $teamModel = new TeamsModel();
    
    if (empty($_POST['LFP'])) {
        $_POST['LFP'] = 0;
    }
    
    if (!empty($_POST['name']) && !empty($_POST['comment'])) {
        $teamModel->addTeam($_POST['name'], $_GET['game'], $_SESSION['name'], $_POST['LFP'], $_POST['comment'], $_SESSION['id']);
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