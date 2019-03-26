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

header("Location: printqr.php?qrdata=$res&toko=".$_POST["namatoko"]."&judul=".$_POST["judul"]."&idtoko=".$_POST["tokoid"]);
die();
 