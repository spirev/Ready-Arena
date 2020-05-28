<?php

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
/* next part set '$lastRoundLoggedUser' between 0 and 2 to 4
   this will be the next second switch argument to know witch round (actual + 1) will need an update */
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
//call function updateNextRound depending on format : solo/team    32/16/8
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
                    //if actual win is last round, add ladder points to players of the tournament and update ranks of all users
                    addLadderPoint($playerList, $usersModel, $teamModel);
                    rankCalcul($usersModel);
                    header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&timerOff&format=solo");
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
        if (isset($_GET['format']) && $_GET['format'] == 'solo') {                
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
                    header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&timerOff&format=solo");
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
        if (isset($_GET['format']) && $_GET['format'] == 'solo') {                    
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
                    header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&timerOff&format=solo");
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
//reload of oneTournament.php with updated rounds
if (isset($_GET['format']) && $_GET['format'] == 'solo') {
    header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&format=solo");
}
else {
    header('Location: oneTournament.php?path=oneTournament&id='.$tournament[0]['id']."&format=team");
}
exit;

?>