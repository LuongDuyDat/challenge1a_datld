<?php

session_start();

//check if the user is logged
if ($_SESSION['logged'] == true)
{
    echo 1;
    header("Location: /home");
} else {
    header("Location: /login");
}
