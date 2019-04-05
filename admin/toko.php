<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Toko</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php 
    $toko = $db->getTokoList($data["id_sekolah"], PDO::FETCH_OBJ);
    ?>

    <!-- <h1>Tambah Toko Baru</h1> -->

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Toko
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tambah_toko">Tambah Toko</button>
            </h1>

            <div class="collapse" id="tambah_toko">
                <form action="../actions/toko_baru.php" method="post">
                    <div class="form-group">
                        <label for="nama_toko">Nama Toko</label>
                        <input type="text" class="form-control" name="nama" id="nama_toko" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10" required></textarea>
                    </div>

                    <input type="hidden" name="idsekolah" value="<?=$data["id_sekolah"]?>">

                    <input type="submit" class="btn btn-primary" value="Masukan">
                </form>
            </div>

            <div class="row">
                <?php
                foreach ($toko as $t) {
                    ?>

                <div class="col-sm-12 col-md-6 mt-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-store" aria-hidden="true"></i> <?= $t->nama ?></h5>
                            <p class="card-text"><?= $t->deskripsi ?></p>
                            <p class="card-text">Saldo <?= rupiah($t->saldo) ?></p>
                            <a href="info_toko.php?id=<?= $t->id ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>

                <?php

            }
            ?>
            </div>
        </div>

    </div>



    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 