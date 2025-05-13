<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once('../functions.php');

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
