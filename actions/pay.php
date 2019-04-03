<?php
require "../db/database.php";

$success = false;

$judul = "";

if (isset($_POST["uniqueid"])) {
  $db = new Database();


  $judul = $_POST["judul"];
  $userid = $_POST["userid"];
  $uniqueid = $_POST["uniqueid"];
  $amount = (int)$_POST["nominal"];

  $user = $db->getUserById($userid, PDO::FETCH_OBJ);

  if ($amount < $user->saldo) {

    if ($db->payToko($userid, $uniqueid, $amount)) {
      $db->addTransaction($amount, "pembelian", "keluar", $userid, "qrcode", "Pembelian $judul");
      $success = true;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "../component/helmet.php" ?>

  <style>
    @-webkit-keyframes zoomIn {
      from {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
        transform: scale3d(0.3, 0.3, 0.3);
      }

      50% {
        opacity: 1;
      }
    }

    @keyframes zoomIn {
      from {
        opacity: 0;
        -webkit-transform: scale3d(0.3, 0.3, 0.3);
        transform: scale3d(0.3, 0.3, 0.3);
      }

      50% {
        opacity: 1;
      }
    }

    .zoomIn {
      -webkit-animation-name: zoomIn;
      animation: zoomIn 200ms ease-in-out;
    }
  </style>

  <title>Pembelian Sukses</title>
</head>

<body>
  <div class="container text-center mt-2">
    <div class="p-2 pt-4">
      <h1 class="card-title">Pembelian <?= $success ?'Sukses!' : 'Gagal' ?></h1>
      <p class="card-text">Pembelian <?= $judul ?> <?= $success ?'senilai ' . rupiah($amount) : '' ?> telah <?= $success ?'sukses!' : 'gagal' ?>!</p>

      <i class="zoomIn fas fa-<?= $success ?"check" : "times" ?> text-<?= $success ?"success" : "danger" ?> fa-9x m-5"></i>
      <br />

      <?php if (!isset($_POST["uniqueid"])) { ?>
        <p class="card-text">Sepertinya pembayaran sudah masuk, scan ulang untuk melakukan pembayaran lagi</p>
        <a href="../siswa/scan.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman pemindai</a>
      <?php } else if (!$success) { ?>
        <p class="card-text">Terjadi kesalahan, <?= $amount > $user->saldo ?"saldo anda tidak mencukupi" : "" ?></p>
        <a href="../siswa/scan.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman pemindai</a>
      <?php } else { ?>
        <p class="card-text">Sepertinya pembayaran sudah masuk, scan ulang untuk melakukan pembayaran lagi</p>
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