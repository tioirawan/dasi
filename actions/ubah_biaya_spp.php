<?php
require "checkpost.php";
require "../db/database.php";

$db = new Database();

$success = false;

$validated = $db->validateAdminPassword($_POST["adminid"], $_POST["password"]);

if ($validated) {
    if ($db->changeSchoolBiayaSPP(
        $_POST["id_sekolah"],
        $_POST["biaya_spp"]
    )) {
        $success = true;
        header("Location: ../admin/spp.php?scc=Berhasil mengubah biaya spp");
        die();
    }

    header("Location: ../admin/spp.php?scc=Terjadi kesalahan");
    die();
} else {
    header("Location: ../admin/spp.php?scc=Password Salah");
    die();
}
