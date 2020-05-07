<?php

    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TournamentsModel.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/GamesModel.class.php';
    include '../controllers/LayoutController.php';

    $usersModel = new UsersModel();
    $TournamentsModel = new TournamentsModel();
    $TeamsModel = new TeamsModel();
    $gameModel = new GamesModel();
    
    $user = $usersModel->findById($_GET['id']);
    $allTournaments = $TournamentsModel->findAll();
    $allTeams = $TeamsModel->findAll();
    $userIdLength = strlen($_GET['id']);

// take "look_for_team" string in page user and explode it into an array for phmtl use
    $seekOnGame = $user[0]['look_for_team'];
    $list = [];
    $games = [];
    $i = 0; /* REMOVE ? */

    if(!empty($seekOnGame)) {
        $list = explode(' ', $seekOnGame);
    }
    for($i = 0; $i < count($list);$i++) {
        $games[$i] = $gameModel->findById(intval($list[$i], 10));
    }

// take playerList from all tournaments and look for page user for phtml use (not smart / inner join expected)
    $tournaments = [];
    $i = 0;

    for($i = 0;$i < count($allTournaments);$i++) {
        $seekTournaments[$i] = $allTournaments[$i]['playerList'];
    }
    for ($i = 0;$i < count($seekTournaments);$i++) {
        if (strpos(substr($seekTournaments[$i], 0, ($userIdLength)), $_GET['id']) !== false) {
            $tournaments[$i] = $TournamentsModel->findById($i + 1);
        }
        else if (strpos($seekTournaments[$i], " ".$_GET['id']." ") !== false) {
            $tournaments[$i] = $TournamentsModel->findById($i + 1);
        }
        else if(strpos(substr($seekTournaments[$i], ($userIdLength - 1)), " ".$_GET['id']) !== false) {
            $tournaments[$i] = $TournamentsModel->findById($i + 1);
        }
        else {
        }
    }

// take teammates from all teams and look for page user for phtml use (not smart / inner join expected)
    $teams = [];
    $i = 0; /* REMOVE ? */

    for($i = 0;$i < count($allTeams);$i++) {
        $seekTeams[$i] = $allTeams[$i]['teammates'];
    }
    for ($i = 0;$i < count($seekTeams);$i++) {
            if (strpos(substr($seekTeams[$i], 0, ($userIdLength + 1)), $_GET['id']." ") !== false) {
                $teams[$i] = $TeamsModel->findById($i + 1);
            }
            else if (strpos($seekTeams[$i], " ".$_GET['id']." ") !== false) {
                $teams[$i] = $TeamsModel->findById($i + 1);
            }
            else if(strpos(substr($seekTeams[$i], ($userIdLength * -1 - 1)), " ".$_GET['id']) !== false) {
                $teams[$i] = $TeamsModel->findById($i + 1);
            }
            else {
            }
    }

    //take all invitations from teams to display them below looking for a team section on the left page
    if (!empty($user[0]['team_invite'])) {
        $invitations = explode(' ', $user[0]['team_invite']);
        $invite_list = [];
        for($i = 0;$i < count($invitations);$i++) {
            $invite_list[$i] = $TeamsModel->findById($invitations[$i]);
        }
    }

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>