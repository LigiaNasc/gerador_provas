<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    require_once('conex.php');
    if ((!isset($_SESSION['id']) == true) and (!isset($_SESSION['email']) == true)) {
        unset($_SESSION['id']);
        unset($_SESSION['email']);
        session_destroy();
        header('Location: login.php');
        exit();
    }
    ?>