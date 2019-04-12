<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php
    $sekolah = $db->getSchoolData($data["id_sekolah"], PDO::FETCH_OBJ);

    $stats = $db->getSchoolStats($data["id_sekolah"]);

    // print_r($trx);
    ?>

    <h1>Dashobard</h1>

    
    <div class="card my-4">
        <div class="card-body">
            <h3 class="card-title"><?= $sekolah->nama_sekolah ?> <span class="text-muted lead"><?= $sekolah->npsn ?></span></h3>

            <div class="row">
                <div class="col-sm-4 my-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-male" aria-hidden="true"></i> Laki-laki</h4>
                            <p class="card-text"><?= $stats->users->laki ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 my-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-female"></i> Perempuan</h4>
                            <p class="card-text"><?= $stats->users->perempuan ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 my-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-male"></i><i class="fas fa-female"></i> Total</h4>
                            <p class="card-text"><?= $stats->users->total ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-school" aria-hidden="true"></i> Sekolah</h4>
                            <p class="card-text"><?=  boldGreen(rupiah($stats->balance->sekolah)) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <div class="card pointer" onclick="location.href = 'siswa.php'">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-user"></i> Siswa</h4>
                            <p class="card-text"><?= boldGreen(rupiah($stats->balance->siswa)) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <div class="card pointer" onclick="location.href = 'toko.php'">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-store"></i> Toko</h4>
                            <p class="card-text"><?= boldGreen(rupiah($stats->balance->toko)) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <div class="card pointer" onclick="location.href = 'donasi.php'">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-hand-holding-usd"></i> Dansos</h4>
                            <p class="card-text"><?= boldGreen(rupiah($stats->balance->donasi)) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mt-4">Total: <?= boldGreen(rupiah($stats->balance->total)) ?></h4>
        </div>
    </div>

    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html>