<?php
require "../db/database.php";

$db = new Database();

$db->createDonation(
    $_POST["judul"],
    $_POST["deskripsi"],
    $_POST["target"],
    $_POST["idposter"]
);
