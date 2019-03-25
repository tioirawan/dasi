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
    $amout = 0;

    if (isset($_GET["amount"])) {
        $amount = $_GET["amount"];
    }
    ?>

    <div class="jumbotron text-center">
        <h1 class="display-6">Pembayaran QR Code</h1>
        <p class="lead"><?= $qrid ?></p>

        <form action="" method="post" class="mt-3" id="donation-form">
            <div class="form-group">
                <label for="nominal_pembayaran">Nominal Pembayaran</label><br>
                <input type="number" class="form-control" value="<?= $amount ?>" id="nominal_pembayaran">
            </div>

            <input type="submit" class="btn btn-primary btn-lg" value="Bayar">
        </form>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 