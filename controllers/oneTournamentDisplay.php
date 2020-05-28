<?php

$playerList = $tournament[0]['playerList'];
$list = [];
$players = [];
// next part stock players from 'playerList' in an array into $players to be display

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
//do not throw away diffMaxPlayers, importante variable in html ( as nbrRounds )
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
        if (in_array($currentUser[0]['id'], $list)) {
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
}
//set date in a readable way ( for html usage )
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

?>