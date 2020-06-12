<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include '../controllers/LayoutController.php';

    $tournamentsModel = new TournamentsModel();
    $tournaments = $tournamentsModel->findByGame($_GET['game']);
    foreach($tournaments as $tournament) {
        if ($tournament['played'] == 1 && $tournament['timer'] <= date('Y-m-d')) {
            $tournamentsModel->deleteTournament($tournament['id']);
        }
    }
    for ($i = 0;$i < count($tournaments);$i++) {
        $tournaments[$i]['id'] = $i - 1;
    }
    $tournaments = $tournamentsModel->findByGame($_GET['game']);


    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path'].".phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }

?>