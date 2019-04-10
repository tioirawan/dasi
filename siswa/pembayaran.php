<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Pembayaran</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <div class="text-center">

    <?php
    $qrid = $_GET["qrid"];

    $detailPembayaran = $db->getQR($qrid, PDO::FETCH_OBJ);

    if($detailPembayaran) {
    ?>
        <h1 class="display-6 mb-0"><?= $detailPembayaran->judul ?></h1>
        <p class="lead text-muted pt-0"><?= $qrid ?></p>

        <form action="../actions/pay.php" method="post" class="mt-3">
            <div class="form-group">
                <label for="nominal_pembayaran">Nominal Pembayaran</label><br>

                <?php
                if ($detailPembayaran->tetap) {
                    ?>
                <h3><?=rupiah($detailPembayaran->nilai)?></h3>
                <input type="hidden" name="nominal" value="<?= $detailPembayaran->nilai ?>">
                <?php 
            } else { ?>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Rp</span>
                </div>
                <input type="number" class="form-control uang" name="nominal" min="500" value="<?=$detailPembayaran->nilai?>" id="nominal_pembayaran" required>
            </div>
                <?php 
            } ?>
            </div>

            <input type="hidden" name="uniqueid" value="<?= $qrid ?>">
            <input type="hidden" name="userid" value="<?= $data["id"] ?>">
            <input type="hidden" name="judul" value="<?= $detailPembayaran->judul ?>">

            <input type="submit" class="btn btn-primary btn-lg" value="Bayar">
        </form>
    <?php
    } else {
    ?>

    <h1>Kode QR tidak ditemukan</h1>
 
    <?php 
        $satusState = false;
        include "../component/statusIcon.php";
    ?>

    <a href="scan.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman pemindai</a>

    <?php } ?>

    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 