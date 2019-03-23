<?php
require "../db/database.php";

$db = new Database();

$donationid = $_POST["donationid"];
$userid = $_POST["userid"];
$pass = $_POST["password"];
$amount = (int)$_POST["jumlah_donasi"];
$private = (boolean)$_POST["private"];
$donationame = $_POST["donationname"];

$validated = $db->validatePassword($userid, $pass);

if ($validated) {
    if ($db->fundDonation($donationid, $userid, $amount, $private)) {
        $db->addTransaction($amount, "donation", $userid, "direct", "Pembayaran Donasi");
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
    <?php include "../component/siswa/sidebaropen.php" ?>

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Donasi <?= $validated ? 'Sukses!' : 'Gagal' ?></h1>
            <p class="card-text">Donasi kamu untuk "<?= $donationame ?>" <?= $validated ? 'senilai '.rupiah($amount) : '' ?> telah <?= $validated ? 'sukses!' : 'gagal' ?>!</p>
            <?php if(!$validated) { ?>
            <p class="card-text">Terjadi kesalahan autentikasi</p>
        <?php } ?>

        <a href="../siswa/bayardonasi.php?payment_success=1&id_donasi=<?= $donationid ?>" role="button" class="btn btn-primary btn-lg">Kembali ke halaman donasi</a>
        </div>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 