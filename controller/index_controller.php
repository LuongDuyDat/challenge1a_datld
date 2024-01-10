<?php

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
//check if the user is logged
if (isset($_SESSION['logged']) && $_SESSION['logged'] == true)
{
    header("Location: /home");
    die();
} else {
    header("Location: /login");
    die();
}
