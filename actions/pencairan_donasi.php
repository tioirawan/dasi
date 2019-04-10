<?php
require "../db/database.php";

$validated = false;

if (isset($_POST["iddonasi"])) {
    $db = new Database();

    $iddonasi = $_POST["iddonasi"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);

    $terkumpul = $db->getDonation($iddonasi, PDO::FETCH_OBJ)->terkumpul;

    if ($validated && $nominal > 0 && $nominal <= $terkumpul) {
        if ($db->disbursementDonation($iddonasi, $adminid, $nominal)) {
            $db->addAdminJournal($adminid, "pencairan_dana_donasi", $nominal, $iddonasi);

            header("Location: ../admin/infodonasi.php?ssc=Tarik Tunai Sukses&id_donasi=$iddonasi");
            die();
        }
    } else {
        $errmess = "Kesalahan tidak diketahui";

        if(!$validated) $errmess = "Terjadi kesalahan autentikasi";
        else if($nominal < 1000) $errmess = "Nominal penarikan terlalu kecil";
        else if($nominal > $saldotoko) $errmess = "Nominal penarikan terlalu besar melebihi jumlah terkumpul";

        header("Location: ../admin/infodonasi.php?ssc=$errmess&id_donasi=$iddonasi");        
    }
}
?>
