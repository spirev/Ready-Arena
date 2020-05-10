<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    if(!empty($_POST['Email']) && !empty($_POST['Password'])) {
        $users = new UsersModel;
        $tryUser = $users->loginVerify($_POST['Email'], $_POST['Password']);
        if (!empty($tryUser)) {
            session_start();
            $_SESSION['name'] = $tryUser[0]['name'];
            $_SESSION['id'] = $tryUser[0]['id'];
            header('Location: http://localhost/finalProject/controllers/onePlayer?path=onePlayer&id='.$tryUser[0]['id']);
            exit;
        }
        else {
            header('Location: http://localhost/finalProject/controllers/LoginController.php?path=Login&flashError=login');
            exit;
        }
    }
    else {
        header('Location: http://localhost/finalProject/controllers/LoginController.php?path=Login&flashError=login');
        exit;
    }

?>