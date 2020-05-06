<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/TeamsModel.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include '../controllers/LayoutController.php';

    $teamsModel = new TeamsModel();
    $userModel = new UsersModel();

    $allTeams = $teamsModel->findAll();
    $connectedUser = $userModel->checkName($_SESSION['name']);
    $userIdLength = strlen($connectedUser[0]['id']);
    $requestPlayer = $userModel->findById($_GET['id']);
    $requestPlayerIdLength = strlen($requestPlayer[0]['id']);
// take teammates from all teams and look for page user for phtml use (not smart / inner join expected)
$teams = [];

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
            var_dump($requestPlayer[0]['team_invite']);
            var_dump($allTeams[$i]['id']);
            var_dump(strpos($requestPlayer[0]['team_invite'], $allTeams[$i]['id']));
            $teams[$i] = $teamsModel->findById($i + 1);
        }
    }
    else {
    }
}

if (isset($_GET['path'])) {
    $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
    include ROOT_PATH.'/../views/layout.phtml';
}
?>