<?php
require "checkpost.php";
require "../db/database.php";

$validated = false;

if (isset($_POST["siswaid"])) {
    $db = new Database();

    $siswaid = $_POST["siswaid"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal_tarik"];
    $deskripsi = $_POST["deskripsi"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);

    if ($validated && $nominal >= 1000 && $nominal <= $db->getUserById($siswaid, PDO::FETCH_OBJ)->saldo) {
        if ($db->siswaWithdrawal($siswaid, $nominal)) {
            $db->addTransaction($nominal, "tarik", "keluar", $siswaid, "teller", $deskripsi);
            $db->addAdminJournal($adminid, "tarik_tunai_siswa", $nominal, $siswaid);
            
            header("Location: ../admin/detail_siswa.php?ssc=Tarik Tunai Sukses&id=$siswaid");
            die();
        }
    } else {
        header("Location: ../admin/detail_siswa.php?ssc=Password salah atau nominal tarik terlalu kecil&id=$siswaid");        
    }
}
?>
