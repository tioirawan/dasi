<?php
require "checkpost.php";
require "../db/database.php";

$success = false;
$trx = null;

if (isset($_POST["nisn"])) {
  $db = new Database();

  $nisn = $_POST["nisn"];
  $siswaid = $_POST["siswaid"];
  $amount = (int)$_POST["nominal"];

  $siswa = $db->getUserById($siswaid, PDO::FETCH_OBJ);
  $siswa_tujuan = $db->getUserByNISN($nisn, PDO::FETCH_OBJ);

  $diri_sendiri = $nisn == $siswa->nisn;

  if ($siswa_tujuan && $siswa_tujuan->id_sekolah == $siswa->id_sekolah && !$diri_sendiri && $amount <= $siswa->saldo && $amount >= 500) {
    if ($db->transferByNISN($siswaid, $nisn, $amount)) {
      $db->addTransaction(
          $amount, "transfer", "keluar", 
          $siswaid, isset($_POST["metode"]) ? $_POST["metode"] : "qrcode", 
          "Transfer ke $siswa_tujuan->nama"
        );

      $id = $db->addTransaction(
          $amount, "transfer", "masuk", 
          $siswa_tujuan->id, isset($_POST["metode"]) ? $_POST["metode"] : "qrcode", 
          "Transfer dari $siswa->nama"
        );

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

  <title>Transfer Sukses</title>
</head>

<body>
  <div class="container text-center mt-2">
    <div class="p-2 pt-1">
      <h1 class="card-title text-<?= $success ? "success" : "danger" ?>">Transfer <?= $success ?'Sukses!' : 'Gagal' ?></h1>
      <p class="card-text lead"><?= $success ? "$siswa->nama <i class='fas fa-arrow-right'></i> $siswa_tujuan->nama" : ""?></p>
      <p class="card-text"><?= $success ? $trx->tanggal : ""?></p>
      
      <?php 
        $satusState = $success;
        include "../component/statusIcon.php";
      ?>

      <?php if (!isset($_POST["nisn"])) { ?>
        <p class="card-text">Sepertinya proses transfer telah berhasil sebelumnya</p>
      <?php } else if ($diri_sendiri) { ?>
          <p class="card-text">Tidak dapat mentransfer ke akun sendiri</p>
      <?php } else if (!$siswa_tujuan) { ?>
          <p class="card-text">Siswa dengan NISN <?=boldGreen($nisn)?> tidak ditemukan, harap periksa kembali</p>
      <?php } else if (!$success) { ?>
        <p class="card-text">Terjadi kesalahan<br/><?= $amount > $siswa->saldo ? "Saldo anda tidak mencukupi" : ($amount < 500 ? "Minimal transfer adalah ".boldGreen(rupiah(500)): "") ?></p>
      <?php } else if ($siswa_tujuan->id_sekolah != $siswa->id_sekolah) { ?>
        <p class="card-text">Tidak dapat mentransfer ke sekolah lain</p>
      <?php } else { ?>
      <p class="card-text">Transfer <?= $success ?'senilai ' . boldGreen(rupiah($amount)) . ' ke <span class="text-muted">' . $siswa_tujuan->nisn . "</span>": '' ?> telah <?= $success ?'sukses!' : 'gagal' ?>!</p>
      <?php } ?>
      
      <a href="../siswa/kirim.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman transfer</a>
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