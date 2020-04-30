<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    $usersModel = new UsersModel();
    $varTest;

    // if one field is not fill redirect to signup page
    if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirmPWD'])) {
        header('Location: SignUpController.php?path=SignUp&error=empty');
        //exit;
    }

    // check if name field contain an unused name and has two character minimum
    if (strlen($_POST['name']) >= 2) {
        $varTest = $usersModel->checkName($_POST['name']);
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
        $varTest = $usersModel->findByEmail($_POST['email']);
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

    //this take the user in DB who has the lower amount of ladder_point and make current signing user the same rank
    //there is a false user in DB whom stay at the lowerest rank for this to work
    $varTest = $usersModel->lowerestPoint();

    //hashing password
    $hashedPWD = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $usersModel->addUser($_POST['name'], $_POST['email'], $hashedPWD, $varTest[0]['rank']);
    header('Location: ../index.php?flash=signUp');

?>