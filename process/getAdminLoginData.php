<?php
session_start();

require '../db/database.php';
require 'utils.php';

if(!isset($_SESSION['userid'])) {
    header("Location: ../admin/login.php");
   die() ;
}

$db = new Database();
$data = $db->getAdminById($_SESSION['userid'], PDO::FETCH_ASSOC);

if($_SESSION['level'] != "admin") {
    header("Location: ../siswa/dashboard.php");
    die();
}
