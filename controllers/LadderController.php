<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';

    $userModel = new UsersModel();
    $users = $userModel->findAllByPoints();
    
    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>