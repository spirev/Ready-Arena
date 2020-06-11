<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    if (isset($_GET['findPlayer'])) {
        $userModel = new UsersModel();
        $player = $userModel->checkName(htmlspecialchars($_GET['findPlayer'], ENT_QUOTES));
        if (!empty($player)) {
            header('Location: onePlayer.php?path=onePlayer&id='.$player[0]['id']);
        }
        else {
            header('Location: ../index.php?flash=noPlayerFound');
        }
    }

?>