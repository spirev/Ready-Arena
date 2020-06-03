<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include '../controllers/LayoutController.php';

    $tournamentsModel = new TournamentsModel();
    $usersModel = new UsersModel();
    $teamModel = new TeamsModel();
    $tournament = $tournamentsModel->findById($_GET['id']);

    // make connected user go to the next round (editing '$nextRound' in Database)
    function updateNextRound($tournamentsModel, $tournament, $nextRound, $currentUser) {
        $newPlayerList = $tournament[0][$nextRound];
        if (isset($_GET['format']) && $_GET['format'] == 'solo') {
            if (empty($tournament[0][$nextRound])) {
                $newPlayerList .= $currentUser[0]['id'];
            }
            else {
                $newPlayerList .= " ".$currentUser[0]['id'];
            }
        }
        else {
            if (empty($tournament[0][$nextRound])) {
                $newPlayerList .= $currentUser;
            }
            else {
                $newPlayerList .= " ".$currentUser;
            }
        }
        $tournamentsModel->updateRounds($tournament[0]['id'], $nextRound, $newPlayerList);
    }

    // count the number of rounds each players as gone throught and add one 'ladder_point' for each
    function addLadderPoint($playerList, $usersModel, $teamModel) {
        for ($i = 0;$i < count($playerList);$i++) {
            for ($y = 0;$y < count($playerList[$i]);$y++) {
                if (isset($_GET['format']) && $_GET['format'] == 'solo') {
                    $tmpUser = $usersModel->findById($playerList[$i][$y]);
                    $newLadderPoints = intval($tmpUser[0]['ladder_point'], 10) + 1;
                    $usersModel->updateLadderPoints($playerList[$i][$y], $newLadderPoints);
                }
                else {
                    //each user from signIn teams get points for the number of rounds they played
                    $tmpTeam = $teamModel->findByID($playerList[$i][$y]);
                    $tmpTeamTeammates = explode(' ', $tmpTeam[0]['teammates']);
                    for ($x = 0;$x < count($tmpTeamTeammates);$x++){
                        $tmpUser = $usersModel->findById($tmpTeamTeammates[$x]);
                        $newLadderPoints = intval($tmpUser[0]['ladder_point'], 10) + 1;
                        $usersModel->updateLadderPoints($tmpUser[0]['id'], $newLadderPoints);
                    }
                }
            }
        }
    }

    // take all players by 'ladder_point' in Database and rank them from one to 'max players'
    function rankCalcul($usersModel) {
        $allPlayers = $usersModel->findAllByPoints();
        for($i = 0;$i < count($allPlayers);$i++) {
            $usersModel->updateRank($allPlayers[$i]['id'], $i + 1);
        }
    }
    // next code is made of two parts, if '$_GET['win']' is set or not, this parametre is passed by clicking on victory button
    //if connected user win a round
    if (isset($_GET['win'])) {

        include 'oneTournamentWin.php';
    }
    else {

        include 'oneTournamentDisplay.php';
    }
?>