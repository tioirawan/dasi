<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Pembayaran</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <?php
    $qrid = $_GET["qrid"];

    $detailPembayaran = $db->getQR($qrid, PDO::FETCH_OBJ);
    ?>

    <div class="text-center">
        <h1 class="display-6"><?= $detailPembayaran->judul ?></h1>
        <p class="lead"><?= $qrid ?></p>

        <form action="" method="post" class="mt-3" id="donation-form">
            <div class="form-group">
                <label for="nominal_pembayaran">Nominal Pembayaran</label><br>

                <?php
                if ($detailPembayaran->tetap) {
                    ?>
                <h3><?=rupiah($detailPembayaran->nilai)?></h3>
                <?php 
            } else { ?>
                <input type="number" class="form-control" value="<?=$detailPembayaran->nilai?>" id="nominal_pembayaran">
                <?php 
            } ?>
            </div>

            <input type="submit" class="btn btn-primary btn-lg" value="Bayar">
        </form>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 