<?php
require "checkpost.php";
require "../db/database.php";

$validated = false;

if (isset($_POST["kantinid"])) {
    $db = new Database();

    $kantinid = $_POST["kantinid"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal_tarik"];
    $deskripsi = $_POST["deskripsi"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);

    $saldokantin = $db->getKantin($kantinid, PDO::FETCH_OBJ)->saldo;

    if ($validated && $nominal >= 1000 && $nominal <= $saldokantin) {
        if ($db->kantinWithdrawal($kantinid, $nominal)) {
            $db->addAdminJournal($adminid, "tarik_tunai_kantin", $nominal, $kantinid);

            header("Location: ../admin/info_kantin.php?ssc=Tarik Tunai Sukses&id=$kantinid");
            die();
        }
    } else {
        $errmess = "Kesalahan tidak diketahui";

        if(!$validated) $errmess = "Terjadi kesalahan autentikasi";
        else if($nominal < 1000) $errmess = "Nominal penarikan terlalu kecil";
        else if($nominal > $saldokantin) $errmess = "Nominal penarikan terlalu besar melebihi saldo kantin";

        header("Location: ../admin/info_kantin.php?ssc=$errmess&id=$kantinid");        
    }
}
?>
