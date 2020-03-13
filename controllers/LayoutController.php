<?php

    /*session_start();
    $_SESSION['connected'] = "";*/
    if (!isset($_SESSION['connected'])) {
        $connect = true;
    }
    else {
        $connect = false;
    }

?>