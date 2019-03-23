<?php
session_start();

require "../db/database.php";

$db = new Database();

$res = $db->loginAdmin($_POST["useremail"], $_POST["userpass"], "*");

if($res) {
    $_SESSION['adminid'] = $res;
    $_SESSION['level'] = "admin";

    header("Location: ../admin/dashboard.php");
    die();
} else {
    header("Location: ../admin/login.php?error=1");
    die();
}
