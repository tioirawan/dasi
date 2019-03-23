<?php
session_start();

require '../db/database.php';

if(!isset($_SESSION['adminid'])) {
    header("Location: ../admin/login.php");
   die() ;
}

$db = new Database();
$data = $db->getAdminById($_SESSION['adminid'], PDO::FETCH_ASSOC);

if($_SESSION['level'] != "admin") {
    header("Location: ../siswa/dashboard.php");
    die();
}
