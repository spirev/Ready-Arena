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

    function rankCalcul($usersModel) {
        $allPlayers = $usersModel->findAllByPoints();
        for($i = 0;$i < count($allPlayers);$i++) {
            if ($i == 0) {
                $usersModel->updateRank($allPlayers[$i]['id'], '1');
            }
            else {
                if ($allPlayers[$i]['ladder_point'] == $allPlayers[$i - 1]['ladder_point']) {
                    $usersModel->updateRank($allPlayers[$i]['id'], $allPlayers[$i - 1]['rank']);
                }
                else {
                    $usersModel->updateRank($allPlayers[$i]['id'], strval(intval($allPlayers[$i - 1]['rank'] + 1, 10)));
                }
            }
        }
    }

    //if connected user win a round
    if (isset($_GET['win'])) {
        if (isset($_SESSION['name'])) {
            $currentUser = $usersModel->checkName($_SESSION['name']);
        }
        $maxPlayers = intval($tournament[0]['nbr_participants'], 10);
        //find last round where current user is
        switch ($maxPlayers) {
            case 32:
                $playerList[0] = explode(' ', $tournament[0]['playerList']);
                $playerList[1] = explode(' ', $tournament[0]['round16']);
                $playerList[2] = explode(' ', $tournament[0]['round8']);
                $playerList[3] = explode(' ', $tournament[0]['round4']);
                $playerList[4] = explode(' ', $tournament[0]['round2']);
                break;
            case 16:
                $playerList[0] = explode(' ', $tournament[0]['playerList']);
                $playerList[1] = explode(' ', $tournament[0]['round8']);
                $playerList[2] = explode(' ', $tournament[0]['round4']);
                $playerList[3] = explode(' ', $tournament[0]['round2']);
                break;
            case 8:
                $playerList[0] = explode(' ', $tournament[0]['playerList']);
                $playerList[1] = explode(' ', $tournament[0]['round4']);
                $playerList[2] = explode(' ', $tournament[0]['round2']);
                break;
        }
        for ($i = 0;$i < count($playerList);$i++) {
            for ($y = 0;$y < count($playerList[$i]);$y++) {
                if (isset($_GET['format']) && $_GET['format'] == 'solo') {
                    if ($playerList[$i][$y] == $currentUser[0]['id']) {
                        $lastRoundLoggedUser = $i;
                    }
                }
                else {
                    if ($playerList[$i][$y] == $_GET['currentUserTeam']) {
                        $lastRoundLoggedUser = $i;
                    }
                }
            }
        }
        switch ($maxPlayers) {
            case 32:
                if (isset($_GET['format']) && $_GET['format'] == 'solo') {
                    switch($lastRoundLoggedUser) {
                        case 0:
                            updateNextRound($tournamentsModel, $tournament, 'round16', $currentUser);
                            break;
                        case 1:
                            updateNextRound($tournamentsModel, $tournament, 'round8', $currentUser);
                            break;
                        case 2:
                            updateNextRound($tournamentsModel, $tournament, 'round4', $currentUser);
                            break;
                        case 3:
                            updateNextRound($tournamentsModel, $tournament, 'round2', $currentUser);
                        break;
                        case 4:
                            addLadderPoint($playerList, $usersModel, $teamModel);
                            rankCalcul($usersModel);
                            header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&timerOff");
                            exit;
                            break;
                    }
                }
                else {
                    switch($lastRoundLoggedUser) {
                        case 0:
                            updateNextRound($tournamentsModel, $tournament, 'round16', $_GET['currentUserTeam']);
                            break;
                        case 1:
                            updateNextRound($tournamentsModel, $tournament, 'round8', $_GET['currentUserTeam']);
                            break;
                        case 2:
                            updateNextRound($tournamentsModel, $tournament, 'round4', $_GET['currentUserTeam']);
                            break;
                        case 3:
                            updateNextRound($tournamentsModel, $tournament, 'round2', $_GET['currentUserTeam']);
                            break;
                        case 4:
                            addLadderPoint($playerList, $usersModel, $teamModel);
                            rankCalcul($usersModel);
                            header('Location: oneTournament.php?path=oneTournament&format=team&id='.$tournament[0]['id']."&timerOff");
                            exit;
                            break;
                    }
                }
                break;
            case 16:
                if (!isset($_GET['format']) && $_GET['format'] == 'solo') {                
                    switch ($lastRoundLoggedUser) {
                        case 0:
                            updateNextRound($tournamentsModel, $tournament, 'round8', $currentUser);
                            break;
                        case 1:
                            updateNextRound($tournamentsModel, $tournament, 'round4', $currentUser);
                            break;
                        case 2:
                            updateNextRound($tournamentsModel, $tournament, 'round2', $currentUser);
                            break;
                        case 3:
                            addLadderPoint($playerList, $usersModel, $teamModel);
                            rankCalcul($usersModel);
                            header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&timerOff");
                            exit;
                            break;
                    }
                    break;
                }
                else {
                    switch ($lastRoundLoggedUser) {
                        case 0:
                            updateNextRound($tournamentsModel, $tournament, 'round8', $_GET['currentUserTeam']);
                            break;
                        case 1:
                            updateNextRound($tournamentsModel, $tournament, 'round4', $_GET['currentUserTeam']);
                            break;
                        case 2:
                            updateNextRound($tournamentsModel, $tournament, 'round2', $_GET['currentUserTeam']);
                            break;
                        case 3:
                            addLadderPoint($playerList, $usersModel, $teamModel);
                            rankCalcul($usersModel);
                            header('Location: oneTournament.php?path=oneTournament&format=team&id='.$tournament[0]['id']."&timerOff");
                            exit;
                            break;
                    }
                }
                break;
            case 8:
                if (!isset($_GET['format']) && $_GET['format'] == 'solo') {                    
                    switch ($lastRoundLoggedUser) {
                        case 0:
                            updateNextRound($tournamentsModel, $tournament, 'round4', $currentUser);
                            break;
                        case 1:
                            updateNextRound($tournamentsModel, $tournament, 'round2', $currentUser);
                            break;
                        case 2:
                            addLadderPoint($playerList, $usersModel, $teamModel);
                            rankCalcul($usersModel);
                            header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&timerOff");
                            exit;
                            break;
                    }
                }
                else {
                    switch ($lastRoundLoggedUser) {
                        case 0:
                            updateNextRound($tournamentsModel, $tournament, 'round4', $_GET['currentUserTeam']);
                            break;
                        case 1:
                            updateNextRound($tournamentsModel, $tournament, 'round2', $_GET['currentUserTeam']);
                            break;
                        case 2:
                            addLadderPoint($playerList, $usersModel, $teamModel);
                            rankCalcul($usersModel);
                            header('Location: oneTournament.php?path=oneTournament&format=team&id='.$tournament[0]['id']."&timerOff");
                            exit;
                            break;
                    }
                }
                break;
        }
        if (isset($_GET['format']) && $_GET['format'] == 'solo') {
            header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&format=solo");
        }
        else {
            header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&format=team");
        }
        exit;
    }
    else {
        //display part (not win part)
        $playerList = $tournament[0]['playerList'];
        $list = [];
        $players = [];
        $i = 0;
        // put all subscribed players on the list
        if(!empty($playerList)) {
            $list = explode(' ', $playerList);
        }
        
        if (isset($_GET['format']) && $_GET['format'] == 'solo') {        
            for($i = 0; $i < count($list);$i++) {
                $players[$i] = $usersModel->findById(intval($list[$i], 10));
            }
        }
        else{
            for($i = 0; $i < count($list);$i++) {
                $players[$i] = $teamModel->findById(intval($list[$i], 10));
            }
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
    
        //look for connected user on this tournament
        if (isset($_SESSION['name'])) {
            $currentUser = $usersModel->checkName($_SESSION['name']);
            if (strpos(substr($tournament[0]['playerList'], 0, strlen($currentUser[0]['id'])), $currentUser[0]['id']) !== false) {
                $alreadySub = 1;
            }
            else if (strpos($tournament[0]['playerList'], " ".$currentUser[0]['id']." ") !== false) {
                $alreadySub = 1;
            }
            else if (strpos($tournament[0]['playerList'], " ".$currentUser[0]['id']) !== false) {
                $alreadySub = 1;
            }
            else {
                $alreadySub = 0;
            }
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
                if (isset($_GET['format']) && $_GET['format'] == 'solo') {
                    $playerRoundList[$i][$y] = $usersModel->findById(intval($playersRound[$i][$y], 10));
                }
                else {
                    $playerRoundList[$i][$y] = $teamModel->findById(intval($playersRound[$i][$y], 10));
                }
            }
            // if tournament format is for team --> take the last team of connected user as reference for win
            if (isset($currentUser) && $_GET['format'] == 'team') {
                $tmpList = $list;
                for ($x = 0;$x < count($tmpList);$x++) {
                    $tmpTeam = $teamModel->findById($tmpList[$x]);
                    if (in_array($currentUser[0]['id'], explode(' ', $tmpTeam[0]['teammates']))) {
                        $currentUserTeam = $tmpTeam[0]['id'];
                    }
                }
            }
            //set the last round number to $lastRoundLoggedUser where connected user qualified itself
            if (isset($currentUser) && in_array($currentUser[0]['id'], $playersRound[$i]) && isset($_SESSION['name']) && $currentUser[0]['name'] == $_SESSION['name'] && $_GET['format'] == 'solo') {
                $lastRoundLoggedUser = $i;
            }
            else if ($_GET['format'] == 'team' && isset($currentUser) && isset($currentUserTeam) && in_array($currentUserTeam, $playersRound[$i]) && isset($_SESSION['name']) && $currentUser[0]['name'] == $_SESSION['name']){
                $lastRoundLoggedUser = $i;
            }
            else {
            }
            //debug
            if (!isset($lastRoundLoggedUser)) {
            }
        }
        //set date in a readable way
        $newTimer = substr($tournament[0]['timer'], -2, 2)."-".substr($tournament[0]['timer'], -5, 2)."-".substr($tournament[0]['timer'], 0, 4);

        //test if tournament is ready to be launch ( timer - actual date )
        if (intval(substr($tournament[0]['timer'], 0, 4), 10) - date("Y") <= 0 && intval(substr($tournament[0]['timer'], 5, 2), 10) - date("m") <= 0 && intval(substr($tournament[0]['timer'], 8, 2), 10) - date("d") <= 0) {
            $isTournamentReady = true;
        }
        else {
            $isTournamentReady = false;
        }
        // if round2 (final) has been played, then set timer to unreachable limit (year 3000)
        if (isset($_GET['timerOff'])) {
            $tournamentsModel->TimerOff($tournament[0]['id']);

        }

        if (isset($_GET['path'])) {
            $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
            include ROOT_PATH.'/../views/layout.phtml';
        }
    }
?>