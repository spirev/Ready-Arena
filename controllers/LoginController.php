<?php
    define('ROOT_PATH', __DIR__);
    include ROOT_PATH.'/../library/bdd.class.php';
    include '../controllers/LayoutController.php';

    if(isset($_GET['action'])) {
        if ($_GET['action'] == 'disconnect') {
            session_unset();
            header('Location: ../index.php');
            exit;
        }
    }

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }
?>