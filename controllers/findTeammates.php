<?php
    define('ROOT_PATH', __DIR__);
    include '../controllers/LayoutController.php';

    if (isset($_GET['path'])) {
        $dataview = $_GET['path']."View/".$_GET['path']."View.phtml";
        include ROOT_PATH.'/../views/layout.phtml';
    }

?>