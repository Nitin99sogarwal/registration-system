<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "please login to access user dashboard ";
            header("Location: login.php");
            exit(0);
}


?>