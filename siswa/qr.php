<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>QR Code</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <?php
    include "../phpqrcode/qrlib.php";

    $file = "../qrcodes/" . $data["nisn"] . ".png";

    if(!file_exists($file)) {
        QRCode::png($data["nisn"], $file, "L", 10.5, 1);
    }
    ?>

    <div class="card">
        <div class="card-header">
            Scan QR ini untuk transfer
        </div>
        <div class="card-body text-center">
            <img src="../qrcodes/<?= $data["nisn"] ?>.png"><br/>
            <small><?= $data["nisn"] ?></small>
        </div>
        <div class="card-footer">
            <a class="btn btn-primary w-100" href="kirim.php">Kembali</a>
        </div>
    </div>


    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html>