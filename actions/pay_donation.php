<?php
require "../db/database.php";

$validated = false;
$donationame = "";
$donationid = null;
$success = false;

if (isset($_POST["donationid"])) {
    $db = new Database();

    $donationid = $_POST["donationid"];
    $userid = $_POST["userid"];
    $pass = $_POST["password"];
    $amount = (int)$_POST["jumlah_donasi"];
    $private = (boolean)$_POST["private"];
    $donationame = $_POST["donationname"];

    $validated = $db->validatePassword($userid, $pass);

    if ($validated && $amount >= 1000 && $amount <= $db->getUserById($userid, PDO::FETCH_OBJ)->saldo) {
        if ($db->fundDonation($donationid, $userid, $amount, $private)) {
            $db->addTransaction($amount, "donation", "keluar", $userid, "direct", "Donasi $donationame");
            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>

    <title>Donasi Sukses</title>
</head>

<body>
    <div class="container text-center mt-2">
        <div class="p-2 pt-1">
            <h1 class="card-title">Donasi <?= $success ?'Sukses!' : 'Gagal' ?></h1>
            <p class="card-text">Donasi kamu <?= $donationame ? "untuk $donationame" : "" ?> <?= $success ?'senilai ' . boldGreen(rupiah($amount)) : '' ?> telah <?= $success ?'sukses!' : 'gagal' ?>!</p>

            <?php 
                $satusState = $success;
                include "../component/statusIcon.php";
            ?>

            <?php if (!isset($_POST["donationid"])) { ?>
                <p class="card-text">Sepertinya donasi kamu sudah masuk, kamu bisa meninggalkan halaman ini</p>
                <a href="../siswa/donasi.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman list donasi</a>
            <?php } else if ($amount < 1000) { ?>
                <p class="card-text">Maaf, minimal donasi adalah <?=boldGreen(rupiah(1000))?></p>
                <a href="../siswa/bayardonasi.php?payment_success=0&id_donasi=<?= $donationid ?>" role="button" class="btn btn-primary btn-lg">Kembali ke halaman donasi</a>
            <?php } else if (!$validated) { ?>
                <p class="card-text">Terjadi kesalahan autentikasi</p>
                <a href="../siswa/bayardonasi.php?payment_success=0&id_donasi=<?= $donationid ?>" role="button" class="btn btn-primary btn-lg">Kembali ke halaman donasi</a>
            <?php } else { ?>
                <a href="../siswa/bayardonasi.php?payment_success=1&id_donasi=<?= $donationid ?>" role="button" class="btn btn-primary btn-lg">Kembali ke halaman donasi</a>
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