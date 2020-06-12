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

    $lookingForTeam = $user[0]['look_for_team'];
    $list = [];
    $games = [];

// make list of LFT games
    if(!empty($lookingForTeam)) {
        $list = explode(' ', $lookingForTeam);
    }
    for($i = 0; $i < count($list);$i++) {
        $games[$i] = $gameModel->findById(intval($list[$i], 10));
    }

// make a list of games for '#seekTeam section' selection
$notLFTGames = $gameModel->findAll();



// delete finished tournaments that have exceed thair 48 waiting hours after being done (where connected user is in)
// take playerList from all tournaments and look for page user for phtml use (not smart / inner join expected)
$tournaments = [];
$y = 0;

    for ($i = 0;$i < count($allTournaments);$i++) {
        if (in_array($_GET['id'], explode(' ', $allTournaments[$i]['playerList']))) {
            if ($allTournaments[$i]['played'] == 1 && $allTournaments[$i]['timer'] <= date('Y-m-d')) {
                $TournamentsModel->deleteTournament($allTournaments[$i]['id']);
                for ($x = $i;$x < count($allTournaments);$x++) {
                    $allTournaments[$x]['id'] -= 1;
                }
                $i--;
            }
            else {
                $tournaments[$y] = $TournamentsModel->findById($i + 1);
            }
            $y++;
        }
    }

// take teammates from all teams and look for page user for phtml use (not smart / inner join expected)
    $teams = [];
    $y = 0; /* REMOVE ? */

    for ($i = 0;$i < count($allTeams);$i++) {
        if (in_array($_GET['id'], explode(' ', $allTeams[$i]['teammates']))) {
            $teams[$y] = $TeamsModel->findById($allTeams[$i]['id']);
            $y++;
        }
    }

//take all invitations from teams to display them under 'looking for a team' section on the left page
    if (!empty($user[0]['team_invite'])) {
        $invite_list = [];
        $invitations = explode(' ', $user[0]['team_invite']);
        for($i = 0;$i < count($invitations);$i++) {
            $invite_list[$i] = $TeamsModel->findById($invitations[$i]);
        }
    }

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>