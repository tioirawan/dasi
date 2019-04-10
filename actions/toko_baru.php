<?php
require "../db/database.php";

$db = new Database();

$id = $db->registerToko(
    $_POST["nama"],
    $_POST["deskripsi"],
    $_POST["idsekolah"]
)[1];

$db->addAdminJournal($_POST["adminid"], "create_toko", 0, $id);

header("Location: ../admin/toko.php");
die();

