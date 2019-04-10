<?php
require "../db/database.php";

$success = false;

$judul = "";
$trx = null;

if (isset($_POST["uniqueid"])) {
  $db = new Database();

  $judul = $_POST["judul"];
  $userid = $_POST["userid"];
  $uniqueid = $_POST["uniqueid"];
  $amount = (int)$_POST["nominal"];

  $user = $db->getUserById($userid, PDO::FETCH_OBJ);

  if ($amount < $user->saldo && $amount >= 500) {
    if ($db->payToko($userid, $uniqueid, $amount)) {
      $id = $db->addTransaction($amount, "pembelian", "keluar", $userid, "qrcode", "Pembelian $judul");
      $trx = $db->getTransaction($id, PDO::FETCH_OBJ);
      
      $success = true;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "../component/helmet.php" ?>

  <title>Pembelian Sukses</title>
</head>

<body>
  <div class="container text-center mt-2">
    <div class="p-2 pt-1">
      <h1 class="card-title text-<?= $success ? "success" : "danger" ?>">Pembelian <?= $success ?'Sukses!' : 'Gagal' ?></h1>
      <p class="card-text lead"><?= $success ? $judul : ""?></p>
      <p class="card-text"><?= $success ? $trx->tanggal : ""?></p>
      
      <?php 
        $satusState = $success;
        include "../component/statusIcon.php";
      ?>

      <?php if (!isset($_POST["uniqueid"])) { ?>
        <p class="card-text">Sepertinya pembayaran sudah masuk, scan ulang untuk melakukan pembayaran lagi</p>
        <a href="../siswa/scan.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman pemindai</a>
      <?php } else if (!$success) { ?>
        <p class="card-text">Terjadi kesalahan<br/><?= $amount > $user->saldo ?"Saldo anda tidak mencukupi" : ($amount < 500 ? "Minimal pembayaran adalah ".boldGreen(rupiah(500)): "") ?></p>
        <a href="../siswa/scan.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman pemindai</a>
      <?php } else { ?>
      <p class="card-text">Pembelian <?= $judul ?> <?= $success ?'senilai ' . boldGreen(rupiah($amount)) : '' ?> telah <?= $success ?'sukses!' : 'gagal' ?>!</p>
        <a href="../siswa/scan.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman pemindai</a>
      <?php } ?>

    </div>
  </div>
  <?php include "../component/scripts.php" ?>
  <?php include "../component/siswa/footer.php" ?>

  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
</body>

</html>