<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include ROOT_PATH.'/../models/UsersModel.class.php';
    include '../controllers/LayoutController.php';

    $userModel = new UsersModel();
    if ($_GET['order'] == 'name')
        $users = $userModel->findByName();
    else {
        $users = $userModel->findAllByPoints();
    }
    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
 