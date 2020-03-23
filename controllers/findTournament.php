<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include '../controllers/LayoutController.php';

    $tournamentsModel = new TournamentsModel();
    $tournaments = $tournamentsModel->findByName($_GET['game']);

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path'].".phtml";
        /*$dataview = ROOT_PATH."/../views/findTournamentView/findTournament.phtml";*/
        include ROOT_PATH.'/../views/layout.phtml';
    }

?>