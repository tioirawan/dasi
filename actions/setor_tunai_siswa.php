<?php
require "checkpost.php";
require "../db/database.php";

$validated = false;

if (isset($_POST["userid"])) {
    $db = new Database();

    $userid = $_POST["userid"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal_setor"];
    $deskripsi = $_POST["deskripsi"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);

    if ($validated && $nominal >= 1000) {
        if ($db->userDeposit($userid, $nominal)) {
            $db->addTransaction($nominal, "topup", "masuk", $userid, "teller", $deskripsi);
            $db->addAdminJournal($adminid, "setor_tunai_siswa", $nominal, $userid);

            header("Location: ../admin/detail_siswa.php?ssc=Setor Tunai Sukses&id=$userid");
            die();
        }
    } else {
        header("Location: ../admin/detail_siswa.php?ssc=Password salah atau nominal tarik terlalu kecil&id=$userid");        
    }
}
?>
