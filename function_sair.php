<?php
    session_start();
    unset ($_SESSION['id']);
    unset($_SESSION['email']);
    unset($_SESSION['tipo_id']);
    session_destroy();
    header('location:login.php')
?>