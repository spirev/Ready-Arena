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
    $teams = [];
    
    if (isset($_GET['action']) || isset($_GET['format'])) {
        if (isset($_GET['format'])) {
            //find all teams where currentUser is in and stock them in "$teams" //// WARNING (for team choice in tournament ONLY)
            $currentTournament = $tournamentModel->findById($_GET['Tid']);
            $y = 0;
            for ($i = 0;$i < count($allTeams);$i++) {
                $tmpTeammates = explode(' ', $allTeams[$i]['teammates']);
                if (in_array($connectedUser[0]['id'], $tmpTeammates) && !in_array($allTeams[$i]['id'], explode(' ', $currentTournament[0]['playerList']))) {
                    $teams[$y] = $teamsModel->findById($allTeams[$i]['id']);
                    $y++;
                }
            }
        }
        else {
            $y = 0;
            for ($i = 0;$i < count($allTeams);$i++) {
                $tmpTeammates = explode(' ', $allTeams[$i]['teammates']);
                if (in_array($connectedUser[0]['id'], $tmpTeammates)) {
                    $teams[$y] = $teamsModel->findById($allTeams[$i]['id']);
                    $y++;
                }
            }
        }
    }
    else {
        //find all teams where currentUser is in ( and requestPlayer is not and where 'team_invite' of requestPlayer don't have currentTeam) for sending invite to other users
        $requestPlayer = $userModel->findById($_GET['id']);
        $requestPlayerIdLength = strlen($requestPlayer[0]['id']);

        for($i = 0;$i < count($allTeams);$i++) {
            $tmpTeammates = explode(' ', $allTeams[$i]['teammates']);
            if (!in_array($requestPlayer[0]['id'], $tmpTeammates) && in_array($connectedUser[0]['id'], $tmpTeammates) && !in_array($allTeams[$i]['id'], explode(' ', $requestPlayer[0]['team_invite']))) {
                $teams[$i] = $teamsModel->findById($allTeams[$i]['id']);
            }
        }
    }
    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>