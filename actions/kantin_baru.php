<?php
require "checkpost.php";
require "../db/database.php";

$db = new Database();

$id = $db->registerKantin(
    $_POST["nama"],
    $_POST["deskripsi"],
    $_POST["idsekolah"]
)[1];

$db->addAdminJournal($_POST["adminid"], "create_kantin", 0, $id);

header("Location: ../admin/kantin.php");
die();

