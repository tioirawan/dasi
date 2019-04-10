<?php
require "../db/database.php";

$db = new Database();

$res = $db->newQr(
    $_POST["judul"],
    $_POST["nilai"],
    isset($_POST["tetap"]) ? 1 : 0,
    $_POST["adminid"],
    $_POST["tokoid"]
);

$db->addAdminJournal($_POST["adminid"], "generate_qr_toko", 0, $res);

header("Location: ../admin/info_toko.php?id=".$_POST["tokoid"]);
die();
 