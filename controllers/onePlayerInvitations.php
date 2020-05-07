<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';

    $userModel = new UsersModel();
    $teamModel = new TeamsModel();
    $user = $userModel->findById($_GET['user']);
    $team = $teamModel->findById($_GET['team']);
    $oldUserInvit = $user[0]['team_invite'];
    $teamIdLength = strlen($_GET['team']);
    
    //dump team id from user team_invite regardless what $_GET[choice] is
    var_dump("OLD ".$oldUserInvit);
    if (strpos($oldUserInvit, " ".$_GET['team']) === false) {
        $newInvite = substr($oldUserInvit, strlen($_GET['team']) + 1, strlen($oldUserInvit) - strlen($_GET['team']) + 1);
        $userModel->addTeamInvite($newInvite, $_GET['user']);
    }
    else {
        $tab = explode(" ", $oldUserInvit);
        for ($i = 0;$i < count($tab);$i++) {
            if ($tab[$i] == $_GET['team']) {
                $y = $tab[0];
                $tab[0] = $tab[$i];
                $tab[$i] = $y;
            }
        }
        array_shift($tab);
        $newInvite = implode(' ', $tab);
        $userModel->addTeamInvite($newInvite, $_GET['user']);
    }
    //var_dump("NEW ".$newInvite);

    //if choice = yes add user id to teammates in the right team
    if ($_GET['choice'] === 'yes') {
        $newTeammates = $team[0]['teammates'];
        $newTeammates .= " ".$user[0]['id'];
        $teamModel->addTeammates($team[0]['id'], $newTeammates);
        header('Location: oneTeam.php?path=oneTeam&id='.$team[0]['id'].'&game='.$team[0]['game']);
    }
    else {
        header('Location: onePlayer.php?path=onePlayer&id='.$user[0]['id']);
    }
?>