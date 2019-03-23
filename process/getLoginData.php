<?php
session_start();

require '../db/database.php';

if(!isset($_SESSION['userid'])) {
    header("Location: ../siswa/login.php");
   die() ;
}

$db = new Database();
$data = $db->getUserById($_SESSION['userid'], PDO::FETCH_ASSOC);

if($_SESSION['level'] != "siswa") {
    header("Location: ../admin/dashboard.php");
    die();
}

