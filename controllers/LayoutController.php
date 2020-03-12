<?php

    session_start();
    $_SESSION['connected'] = "";
    if (!isset($_SESSION['connected'])) {
        $disable = true;
    }
    else {
        $disable = false;
    }

?>