<?php
    session_start();
    unset($_SESSION['alquiler']);
    header('Location: alquiler.php');
    exit();
?>