<?php
session_start();

require "../db/database.php";

$db = new Database();

$res = $db->login($_POST["useremail"], $_POST["userpass"], "*");

if($res) {
    $_SESSION['userid'] = $res;
    $_SESSION['level'] = "siswa";

    header("Location: ../siswa/dashboard.php");
    die();
} else {
    header("Location: ../siswa/login.php?error=1");
    die();
}
