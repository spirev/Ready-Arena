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

    // put all subscribed players on the list
    if(!empty($playerList)) {
        $list = explode(' ', $playerList);
    }

    for($i = 0; $i < count($list);$i++) {
        $players[$i] = $usersModel->findById(intval($list[$i], 10));
    }
    // bracket part ( $nbrRounds count numbers of rounds left to final for html list minus 1 ( first round is set by nbr_participants ))
    $maxPlayers = intval($tournament[0]['nbr_participants'], 10);
    $nbrRounds = 0;
    $diffMaxPlayers = $maxPlayers - count($players);
    switch($maxPlayers) {
        case 32:
            $nbrRounds = 4;
            break;
        case 16:
            $nbrRounds = 3;
            break;
        case 8:
            $nbrRounds = 2;
            break;
        default:
            echo "an internal problem occurred... :("; 
    }

    // takes players qualified for every rounds and display them on the right round-list
    $playersRound = [];
    $playerRoundList = [];
    switch ($maxPlayers) {
        case 32:
            $playersRound[0] = explode(' ', $tournament[0]['round16']);
            $playersRound[1] = explode(' ', $tournament[0]['round8']);
            $playersRound[2] = explode(' ', $tournament[0]['round4']);
            $playersRound[3] = explode(' ', $tournament[0]['round2']);
            break;
        case 16:
            $playersRound[0] = explode(' ', $tournament[0]['round8']);
            $playersRound[1] = explode(' ', $tournament[0]['round4']);
            $playersRound[2] = explode(' ', $tournament[0]['round2']);
            break;
        case 8:
            $playersRound[0] = explode(' ', $tournament[0]['round4']);
            $playersRound[1] = explode(' ', $tournament[0]['round2']);
    }
    for($i = 0;$i < count($playersRound);$i++) {
        for($y = 0;$y < count($playersRound[$i]);$y++) {
            $playerRoundList[$i][$y] = $usersModel->findById(intval($playersRound[$i][$y], 10));
        }
    }

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>