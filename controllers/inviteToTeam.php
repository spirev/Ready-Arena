<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include '../controllers/LayoutController.php';

    $teamsModel = new TeamsModel();
    $userModel = new UsersModel();
    $tournamentModel = new TournamentsModel();

    $allTeams = $teamsModel->findAll();
    $connectedUser = $userModel->checkName($_SESSION['name']);
    $userIdLength = strlen($connectedUser[0]['id']);
    $requestPlayer = $userModel->findById($_GET['id']);
    $requestPlayerIdLength = strlen($requestPlayer[0]['id']);
    $teams = [];

if (isset($_GET['format'])) {
    $currentTournament = $tournamentModel->findById($_GET['Tid']);
    $y = 0;
    for ($i = 0;$i < count($allTeams);$i++) {
        $tmpTeammates = explode(' ', $allTeams[$i]['teammates']);
        if (in_array($connectedUser[0]['id'], $tmpTeammates) && !in_array($i + 1, explode(' ', $currentTournament[0]['playerList']))) {
            $teams[$y] = $teamsModel->findById($i + 1);
            $y++;
        }
    }
}
else {
    for($i = 0;$i < count($allTeams);$i++) {
        $seekTeams[$i] = $allTeams[$i]['teammates'];
    }
    for ($i = 0;$i < count($seekTeams);$i++) {
        if (strpos(substr($seekTeams[$i], 0, $userIdLength), $connectedUser[0]['id']) !== false && strpos($seekTeams[$i], " ".$requestPlayer[0]['id']) == false) {
            if (strpos($requestPlayer[0]['team_invite'], $allTeams[$i]['id']) === false){
                $teams[$i] = $teamsModel->findById($i + 1);
            }
        }
        else if (strpos($seekTeams[$i], " ".$connectedUser[0]['id']) !== false && strpos($seekTeams[$i], " ".$requestPlayer[0]['id']) == false) {
            if (strpos($requestPlayer[0]['team_invite'], $allTeams[$i]['id']) === false){
                $teams[$i] = $teamsModel->findById($i + 1);
            }
        }
        else {
        }
    }
}
// take teammates from all teams and look for page user for phtml use (not smart / inner join expected)

if (isset($_GET['path'])) {
    $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
    include ROOT_PATH.'/../views/layout.phtml';
}
?>