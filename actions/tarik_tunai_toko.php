<?php
require "../db/database.php";

$validated = false;

if (isset($_POST["tokoid"])) {
    $db = new Database();

    $tokoid = $_POST["tokoid"];
    $adminid = $_POST["adminid"];
    $nominal = (int)$_POST["nominal_tarik"];
    $deskripsi = $_POST["deskripsi"];
    $pass = $_POST["password"];

    $validated = $db->validateAdminPassword($adminid, $pass);

    $saldotoko = $db->getToko($tokoid, PDO::FETCH_OBJ)->saldo;

    if ($validated && $nominal >= 1000 && $nominal <= $saldotoko) {
        if ($db->tokoWithdrawal($tokoid, $nominal)) {
            $db->addAdminJournal($adminid, "tarik_tunai_toko", $nominal, $tokoid);

            header("Location: ../admin/info_toko.php?ssc=Tarik Tunai Sukses&id=$tokoid");
            die();
        }
    } else {
        $errmess = "Kesalahan tidak diketahui";

        if(!$validated) $errmess = "Terjadi kesalahan autentikasi";
        else if($nominal < 1000) $errmess = "Nominal penarikan terlalu kecil";
        else if($nominal > $saldotoko) $errmess = "Nominal penarikan terlalu besar melebihi saldo toko";

        header("Location: ../admin/info_toko.php?ssc=$errmess&id=$tokoid");        
    }
}
?>
