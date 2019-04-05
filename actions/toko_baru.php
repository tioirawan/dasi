<?php
require "../db/database.php";

$db = new Database();

$pass = $db->registerToko(
    $_POST["nama"],
    $_POST["deskripsi"],
    $_POST["idsekolah"]
)[1];

header("Location: ../admin/toko.php");
die();

