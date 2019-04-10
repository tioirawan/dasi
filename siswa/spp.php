<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>SPP</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <div class="jumbotron text-center">
        <h3 class="card-title"><i class="fas fa-file-invoice"> Pembayaran SPP</i></h3>
        <p>Pembayaran SPP sekarang tidak perlu ribet lagi, tinggal klik 'selesai' beres deh :)</p>
    </div>
    <?
        $spp = 1;
    ?>
    <div class="card text-center">
        <?
        if ($spp == 1) {
            echo '<div class="bg-success">
                    <div class="card-body">
                        <span class="text-white lead">Selamat, SPP anda sudah lunas !</span>
                    </div>
                </div>';
        }
        else {
            echo '<div class="bg-danger">
                    <div class="card-body">
                        <span class="text-white lead">SPP anda belum lunas, silakan melunasi !</span>
                    </div>
                </div>';
        }
        ?>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-4 mt-2">
            <div class="card">
                <h3 class="card-header">Me</h3>
                <div class="card-body">
                    <p>Some things. . .</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-2">
            <div class="card">
                <h3 class="card-header">You</h3>
                <div class="card-body">
                    <p>Some things. . .</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-2">
            <div class="card">
                <h3 class="card-header">You</h3>
                <div class="card-body">
                    <p>Some things. . .</p>
                </div>
            </div>
        </div>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 
