<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    
    $userModel = new UsersModel();
    $teamModel = new TeamsModel();
    $user = $userModel->findById($_GET['user']);
    $team = $teamModel->findById($_GET['team']);
    $oldWaitingList = $team[0]['waiting_list'];
    // dump user id from user waiting_list regardless what $_GET[choice] is
    if (strpos($oldWaitingList, " ".$_GET['team']) === false) {
        $newInvite = substr($oldWaitingList, strlen($_GET['user']) + 1, strlen($oldWaitingList) - strlen($_GET['user']) + 1);
    }
    else {
        $tab = explode(" ", $oldWaitingList);
        for ($i = 0;$i < count($tab);$i++) {
            if ($tab[$i] == $_GET['team']) {
                $y = $tab[0];
                $tab[0] = $tab[$i];
                $tab[$i] = $y;
            }
        }
        array_shift($tab);
        $newInvite = implode(' ', $tab);
    }
    if ($newInvite[0] == ' ') {
        $newInvite = substr($newInvite, 1, strlen($newInvite));
    }
    $teamModel->updateWaitingPlayer($_GET['team'], $newInvite);

    //if choice = yes add user id to teammates in the right team
    if ($_GET['choice'] === 'yes') {
        $newTeammates = $team[0]['teammates'];
        $newTeammates .= " ".$user[0]['id'];
        $teamModel->addTeammates($team[0]['id'], $newTeammates);
    }
    header('Location: oneTeam.php?path=oneTeam&id='.$team[0]['id'].'&game='.$team[0]['game']);

?>