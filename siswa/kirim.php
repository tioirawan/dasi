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
        Transfer
    </h1>

    <h5 class="card-title">Jumlah Saldomu</h5>
    <p class="card-text" id="saldo"><?= rupiah($data["saldo"]) ?></p>

    <div class="row">
        <div class="col-sm-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-qrcode" aria-hidden="true"></i> QR Code</h5>
                    <p class="card-text">Transer lebih cepat dengan QR Code</p>

                    <a href="qr.php" class="btn btn-primary">QR Code mu</a>
                    <a href="scan.php" class="btn btn-primary">Buka Pemindai</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <form action="../actions/transfer_saldo.php" method="post">
                <div class="form-group">
                    <label for="nisn_transfer">NISN Tujuan</label>
                    <input type="text" class="form-control" name="nisn" value="" required>
                </div>

                <div class="form-group">
                    <label for="jumlah_transfer">Nominar Transfer</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="number" class="form-control uang" name="nominal" id="jumlah_transfer" min="500" value="10000" required>
                    </div>
                </div>

                <input type="hidden" name="metode" value="manual">
                <input type="hidden" name="userid" value="<?= $data["id"] ?>">

                <input type="submit" class="btn btn-primary" value="transfer">
            </form>
        </div>

    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html>