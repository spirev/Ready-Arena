<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    $userModel = new UsersModel();
    $user = $userModel->findById($_GET['user']);
    $LFTuser = $user[0]['look_for_team'];
    $explodeLFTUser = explode(' ', $LFTuser);

    if (in_array($_GET['game'], $explodeLFTUser)) {
        header('Location: onePlayer.php?path=onePlayer&id='.$_GET['user']);
    }
    else {
        if($explodeLFTUser[0] == '') {
            $newLFT = $LFTuser.$_GET['game'];
        }
        else {
            $newLFT = $LFTuser." ".$_GET['game'];
        }
        $userModel->updateLFT($user[0]['id'], $newLFT);
        header('Location: onePlayer.php?path=onePlayer&id='.$_GET['user']);
    }
?>