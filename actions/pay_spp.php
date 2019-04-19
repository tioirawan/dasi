<?php
require "checkpost.php";
require "../db/database.php";

$validated = false;
$success = false;

if (isset($_POST["idspp"])) {
    $db = new Database();

    $idspp = $_POST["idspp"];
    $idsekolah = $_POST["idsekolah"];
    $bulan = $_POST["bulanspp"];
    $idsiswa = $_POST["idsiswa"];
    $pass = $_POST["password"];

    $validated = $db->validatePassword($idsiswa, $pass);

    $siswa = $db->getUserById($idsiswa, PDO::FETCH_OBJ);
    $school = $db->getSchoolData($siswa->id_sekolah, PDO::FETCH_OBJ);

    if ($validated && $siswa->saldo >= $school->biaya_spp) {
        if ($db->paySPP($idsiswa, $idsekolah, $idspp)) {
            $db->addTransaction($school->biaya_spp, "spp", "keluar", $idsiswa, "direct", "Pembayaran SPP Bulan ".ucwords($bulan));
            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>

    <title>SPP <?= $success ?'Sukses!' : 'Gagal' ?></title>
</head>

<body>
    <div class="container text-center mt-2">
        <div class="p-2 pt-1">
            <h1 class="card-title">Pembayaran SPP <?= $success ?'Sukses!' : 'Gagal' ?></h1>

            <?php 
                $satusState = $success;
                include "../component/statusIcon.php";
            ?>

            <?php if (!isset($_POST["idspp"])) { ?>
                <p class="card-text">Sepertinya SPP kamu sudah masuk, kamu bisa meninggalkan halaman ini</p>
                <a href="../siswa/SPP.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman SPP</a>
            <?php } else if ($siswa->saldo < $school->biaya_spp) { ?>
                <p class="card-text">Maaf, saldo anda tidak mencukupi untuk membayar SPP</p>
                <a href="../siswa/spp.php?payment_success=0&id_SPP=<?= $idspp ?>" role="button" class="btn btn-primary btn-lg">Kembali ke halaman SPP</a>
            <?php } else if (!$validated) { ?>
                <p class="card-text">Terjadi kesalahan autentikasi</p>
                <a href="../siswa/spp.php?payment_success=0&id_SPP=<?= $idspp ?>" role="button" class="btn btn-primary btn-lg">Kembali ke halaman SPP</a>
            <?php } else { ?>
            <p class="card-text">Pembayaran SPP <?= $success ?'senilai ' . boldGreen(rupiah($school->biaya_spp)) : '' ?> telah <?= $success ?'sukses!' : 'gagal' ?>!</p>
                <a href="../siswa/spp.php?payment_success=1&id_SPP=<?= $idspp ?>" role="button" class="btn btn-primary btn-lg">Kembali ke halaman SPP</a>
            <?php } ?>

        </div>
    </div>
    <?php include "../component/scripts.php" ?>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>