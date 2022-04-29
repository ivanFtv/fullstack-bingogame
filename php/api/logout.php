<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
//logout and destroy session
    unset($_SESSION['logged']);
    session_destroy() ;
    echo 'true';
}
?>