<?php
require "checkpost.php";
require "../db/database.php";

$validated = false;

if (isset($_POST["id_sekolah"])) {
    $db = new Database();

    $id_sekolah = $_POST["id_sekolah"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);
    $sekolah = $db->getSchoolData($id_sekolah, PDO::FETCH_OBJ);

    if ($validated && $nominal >= 1000 && $nominal <= $sekolah->saldo) {
        if ($db->sppWithdrawal($id_sekolah, $nominal)) {
            $db->addAdminJournal($adminid, "tarik_spp", $nominal, $adminid);

            header("Location: ../admin/spp.php?ssc=Tarik Tunai Sukses&id=$id_sekolah");
            die();
        }
    } else {
        $errmess = "Kesalahan tidak diketahui";

        if(!$validated) $errmess = "Terjadi kesalahan autentikasi";
        else if($nominal < 1000) $errmess = "Nominal penarikan terlalu kecil";
        else if($nominal > $sekolah->saldo) $errmess = "Nominal penarikan terlalu besar melebihi saldo toko";

        header("Location: ../admin/spp.php?ssc=$errmess&id=$id_sekolah");        
    }
}
?>
