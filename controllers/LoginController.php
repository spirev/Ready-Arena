<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include '../controllers/LayoutController.php';
    include '../models/UsersModel.class.php';
    
    if ($_POST) {
        if(!empty($_POST['Email']) && !empty($_POST['Password'])) {
            $users = new UsersModel;
            $tryUser = $users->loginVerify($_POST['Email'], $_POST['Password']);
            if (!isset($tryUser)) {
                header('Location: http://localhost/finalProject/controllers/LoginController.php?path=Login&flashError=login');
            }
            header('Location: http://localhost/finalProject/index.php?loged=T');
            exit;
        }
        else {
            header('Location: http://localhost/finalProject/controllers/LoginController.php?path=Login&flashError=login');
        }
    }

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>