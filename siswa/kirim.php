<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Kirim</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <h1>
        Transfer <small class="text-muted"><?=$data["nisn"]?></small>
    </h1>

    <h5 class="card-title">Jumlah Saldomu</h5>
    <p class="card-text" id="saldo"><?= rupiah($data["saldo"]) ?></p>

    <div class="row">
        <div class="col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-qrcode" aria-hidden="true"></i> Kode QR</h5>
                    <p class="card-text">Transer lebih cepat dengan Kode QR</p>

                    <a href="qr.php" class="btn btn-primary">Kode QRmu</a>
                    <a href="scan.php" class="btn btn-primary">Buka Pemindai</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <form action="transfer.php" method="get">
                <div class="form-group">
                    <label for="nisn_transfer">NISN Tujuan</label>
                    <input type="number" class="form-control" name="nisn" min="0" max="99999999999" value="" required>
                </div>

                <input type="hidden" name="metode" value="manual"/>

                <input type="submit" class="btn btn-primary" value="ok">
            </form>
        </div>

    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html>