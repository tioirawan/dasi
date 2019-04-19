<?php
require "checkpost.php";
require "../db/database.php";

$db = new Database();

$res = $db->newQr(
    $_POST["judul"],
    $_POST["nilai"],
    isset($_POST["tetap"]) ? 1 : 0,
    $_POST["adminid"],
    $_POST["kantinid"]
);

$db->addAdminJournal($_POST["adminid"], "generate_qr_kantin", 0, $res);

header("Location: ../admin/info_kantin.php?id=".$_POST["kantinid"]);
die();
 