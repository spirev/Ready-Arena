<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include '../controllers/LayoutController.php';

    $tournamentsModel = new TournamentsModel();
    $usersModel = new UsersModel();

    $tournament = $tournamentsModel->findById($_GET['id']);
    $playerList = $tournament[0]['playerList'];
    $list = [];
    $players = [];
    $i = 0; /* REMOVE ? */

    if(!empty($playerList)) {
        $list = explode(' ', $playerList);
    }
    for($i = 0; $i < count($list);$i++) {
        $players[$i] = $usersModel->findById(intval($list[$i], 10));
    }
    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>