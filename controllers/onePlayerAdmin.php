<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/GamesModel.class.php';

    function deleteDBvalue($oldStartlist) {
        $oldList = explode(' ', $oldStartlist);
        for ($i = 0;$i < count($oldList);$i++) {
            if ($oldList[$i] == $_GET['user']) {
                $y = $oldList[0];
                $oldList[0] = $oldList[$i];
                $oldList[$i] = $y;
            }
        }
        array_shift($oldList);
        $newList = implode(' ', $oldList);
        if ($newList[0] == ' ') {
            $newList = substr($newList, 1, strlen($newList));
        }
        return $newList;
    }

    //delete connected user from one of its team (updating teammates value for that team)
    if ($_GET['choice'] == 'team') {
        $teamModel = new TeamsModel();
        $team = $teamModel->findById($_GET['team']);
        $teammates = $team[0]['teammates'];
        $newTeammates = deleteDBvalue($teammates);
        $teamModel->addTeammates($_GET['team'], $newTeammates);
    }
    if ($_GET['choice'] == 'LFT') {
        $gameModel = new GamesModel();
        $userModel = new UsersModel();
        $connectedUser = $userModel->findById($_GET['user']);
        $playerLFT = $connectedUser[0]['look_for_team'];
        $newPlayerLFT = deleteDBvalue($playerLFT);
        $userModel->updateLFT($_GET['user'], $newPlayerLFT);
    }
    header('Location: onePlayer.php?path=onePlayer&id='.$_GET['user']);
?>