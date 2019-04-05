<?php
require "../db/database.php";

$validated = false;

if (isset($_POST["userid"])) {
    $db = new Database();

    $userid = $_POST["userid"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal_tarik"];
    $deskripsi = $_POST["deskripsi"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);

    if ($validated && $nominal >= 1000) {
        if ($db->userWithdrawal($userid, $nominal)) {
            $db->addTransaction($nominal, "tarik", "keluar", $userid, "teller", $deskripsi);
            
            header("Location: ../admin/detail_siswa.php?ssc=Tarik Tunai Sukses&id=$userid");
            die();
        }
    } else {
        header("Location: ../admin/detail_siswa.php?ssc=Password salah atau nominal tarik terlalu kecil&id=$userid");        
    }
}
?>
