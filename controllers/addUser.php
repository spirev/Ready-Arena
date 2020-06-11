<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    $usersModel = new UsersModel();
    $varTest;
    $lastUser = $usersModel->maxId();
    $lastId = intval($lastUser[0]['MAX(id)'], 10);
    $lastId = $lastId + 1;

    // if one field is not fill redirect to signup page
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirmPWD'])) {
        header('Location: SignUpController.php?path=SignUp&error=empty');
        exit;
    }

    // check if name field contain an unused name and have a minimum of two characters
    if (strlen($_POST['name']) >= 2) {
        $varTest = $usersModel->checkName(htmlspecialchars($_POST['name'], ENT_QUOTES));
        if (!empty($varTest)) {
            header('Location: SignUpController.php?path=SignUp&error=name');
            exit;
        }
    }
    else {
        header('Location: SignUpController.php?path=SignUp&error=name');
        exit;
    }

    //check if email field is a valid address format and is not already used
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $varTest = $usersModel->findByEmail(htmlspecialchars($_POST['email'], ENT_QUOTES));
        if (!empty($varTest)) {
            header('Location: SignUpController.php?path=SignUp&error=email');
            exit;
        }
    }
    else {
        header('Location: SignUpController.php?path=SignUp&error=email');
        exit;
    }

    //check if password is correct (contain at least 8 characters / 1 number / 1 Uppercase
    if (strlen($_POST['password']) >= 8) {
        if (!preg_match('/[A-Z]/', $_POST['password']) || !preg_match('/[0-9]/', $_POST['password']) || !preg_match('/[a-z]/', $_POST['password'])) {
            header('Location: SignUpController.php?path=SignUp&error=PWD');
            exit;
        }
    }
    else {
        header('Location: SignUpController.php?path=SignUp&error=PWD');
        exit;
    }

    //check if password confirmation match password
    if (strcmp($_POST['confirmPWD'], $_POST['password'])) {
        header('Location: SignUpController.php?path=SignUp&error=confirmPWD');
        exit;
    }

    //this take the user in DB who has the lower rank and make current signing user the same rank
    $lowerstRankUser = $usersModel->findLowerstRanks();
    $newRank = $lowerstRankUser[0]['MAX(rank)'] + 1;
    var_dump($lowerstRankUser);
    var_dump($newRank);

    //hashing password
    $hashedPWD = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $usersModel->addUser($lastId, htmlspecialchars($_POST['name'], ENT_QUOTES), htmlspecialchars($_POST['email'], ENT_QUOTES), $hashedPWD, $newRank);
    header('Location: ../index.php?flash=signUp');

?>