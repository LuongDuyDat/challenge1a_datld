<?php

session_start();
if ($_SESSION['logged'] == true)
{
    echo 1;
    header("Location: /home");
} else {
    header("Location: /login");
}
