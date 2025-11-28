<?php
session_start();

        if (isset($_GET['username'])) {
            $_SESSION['username'] = $_GET['username'];
        }


        header("Location: home.php");
        exit;
        ?>