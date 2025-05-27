<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);


header("Location: login.html");
exit();
