<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>

    <style>
        .card {
            width: 370px;
            border: 1px solid #2C3E50;
        }

        .card-body {
            padding: .8rem;
        }

        .card-footer>img {
            width: 30px;
        }

        .card-footer {
            background-color: #2C3E50;
            color: #fff;
            font-size: 20px;
            text-align: right;
            -webkit-print-color-adjust: exact;
        }

        .left {
            float: left;
            color: rgba(255, 255, 255, 0.9) padding-top: 10px;
            /* font-size: 13px; */
        }
    </style>

    <?php
    include "../phpqrcode/qrlib.php";

    $qr = $_GET["qrdata"];
    $judul = $_GET["judul"];
    $toko = $_GET["toko"];

    $file = "../qrcodes/$qr.png";

    QRCode::png($qr, $file, "L", 13, 1);
    ?>

    <title><?= $judul ?> - <?= $toko ?></title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>

    <div class="p-5">
        <div class="card text-center">
        <div class=" card-body">
            <small><?= $judul ?></small><br />
            <img src="../qrcodes/<?= $qr ?>.png">
            <small><?= $qr ?></small>
        </div>
        <div class="card-footer">
            <span class="left"><?= $toko ?></span>
            <img src="../assets/dasi_white.svg" alt="">Dasi
        </div>
    </div>
    </div>

    <script>
        window.print();

        window.onafterprint = function() {
            window.location.href = "../admin/info_toko.php?id=<?= $_GET["idtoko"] ?>";
        };
    </script>

</body>

</html> 