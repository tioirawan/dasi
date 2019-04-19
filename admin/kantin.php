<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Kantin</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php 
    $kantin = $db->getKantinList($data["id_sekolah"], PDO::FETCH_OBJ);
    ?>

    <!-- <h1>Tambah Kantin Baru</h1> -->

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Kantin
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tambah_kantin">Tambah Kantin</button>
            </h1>

            <div class="collapse" id="tambah_kantin">
                <form action="../actions/kantin_baru.php" method="post">
                    <div class="form-group">
                        <label for="nama_kantin">Nama Kantin</label>
                        <input type="text" class="form-control" name="nama" id="nama_kantin" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10" required></textarea>
                    </div>

                    <input type="hidden" name="idsekolah" value="<?=$data["id_sekolah"]?>">
                    <input type="hidden" name="adminid" value="<?=$data["id"]?>">

                    <input type="submit" class="btn btn-primary" value="Masukan">
                </form>
            </div>

            <div class="row">
                <?php
                foreach ($kantin as $t) {
                    ?>

                <div class="col-sm-12 col-md-6 mt-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-store" aria-hidden="true"></i> <?= $t->nama ?></h5>
                            <p class="card-text"><?= $t->deskripsi ?></p>
                            <p class="card-text">Saldo <?= rupiah($t->saldo) ?></p>
                            <a href="info_kantin.php?id=<?= $t->id ?>" class="btn btn-primary">Detail</a>
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
    <?php require "../component/scrollTop.php" ?>

</body>

</html> 