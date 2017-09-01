<?php

session_start();

if (isset($_POST['submit'])) {

    include 'database-connection.php';

    $login_unit = new UserLoginClass;

    $login_unit->loginUser();
} else {
    returnToPage("index.php", "login=error");
}