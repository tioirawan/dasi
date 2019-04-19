<?php
require "checkpost.php";
require "../db/database.php";

$validated = false;

if (isset($_POST["siswaid"])) {
    $db = new Database();

    $siswaid = $_POST["siswaid"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal_setor"];
    $deskripsi = $_POST["deskripsi"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);

    if ($validated && $nominal >= 1000) {
        if ($db->siswaDeposit($siswaid, $nominal)) {
            $db->addTransaction($nominal, "topup", "masuk", $siswaid, "teller", $deskripsi);
            $db->addAdminJournal($adminid, "setor_tunai_siswa", $nominal, $siswaid);

            header("Location: ../admin/detail_siswa.php?ssc=Setor Tunai Sukses&id=$siswaid");
            die();
        }
    } else {
        header("Location: ../admin/detail_siswa.php?ssc=Password salah atau nominal tarik terlalu kecil&id=$siswaid");        
    }
}
?>
