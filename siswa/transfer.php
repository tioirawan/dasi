<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Transfer</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <div class="text-center">

    <?php
    $nisn = $_GET["nisn"];
    $detailTransfer = true;
    $data_tujuan = $db->getUserByNISN($nisn, PDO::FETCH_OBJ);

    $diri_sendiri = $nisn == $data["nisn"];

    // $detailTransfer = $db->transfer($data["nisn"], $nisn);

    if($data_tujuan && !$diri_sendiri) {
    ?>
        <h1 class="display-6 mb-0">Transfer ke <?=explode(" ", $data_tujuan->nama)[0]?></h1>
        <p class="lead text-muted pt-0"><?= $nisn ?></p>

        <form action="../actions/transfer_saldo.php" method="post" class="mt-3">
            <div class="form-group">
                <label for="nominal_transfer">Nominal Transfer</label><br>
              
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number" class="form-control uang" name="nominal" min="500" value="10000" id="nominal_transfer" required>
                </div>
           
            </div>

            <input type="hidden" name="userid" value="<?= $data["id"] ?>">
            <input type="hidden" name="nisn" value="<?= $nisn ?>">

            <input type="submit" class="btn btn-primary btn-lg" value="Transfer">
        </form>
        
    <?php
    } else {
    ?>

    <h1>Gagal!</h1>
    <span><?=$diri_sendiri ? "Tidak dapat mentransfer ke akun sendiri": "NISN tidak ditemukan"?></span>
    <br/>

    <?php 
        $satusState = false;
        $iconNo = "user-times";
        include "../component/statusIcon.php";
    ?>

    <a href="scan.php" role="button" class="btn btn-primary btn-lg">Kembali ke halaman pemindai</a>

    <?php } ?>

    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 