<?php
require "../db/database.php";

$db = new Database();

$id = $db->createDonation(
    $_POST["judul"],
    $_POST["deskripsi"],
    $_POST["target"],
    $_POST["idposter"]
);

$db->addAdminJournal($_POST["idposter"], "create_donation", 0, $id);

header("Location: ../admin/donasi.php");
die();
