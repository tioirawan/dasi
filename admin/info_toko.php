<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>

    <title>Detail Toko</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>


    <?php 
    $toko = $db->getToko($_GET["id"], PDO::FETCH_OBJ);
    ?>

    <div class="row">
        <div class="col-md-5">
            <h1><i class="fas fa-store"></i> <?= $toko->nama ?>
                <a href="#edit_toko" data-toggle="collapse" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
            </h1>

            <div class="mt-4">
                <p><?= $toko->deskripsi ?></p>
                <h3><?= rupiah($toko->saldo) ?></h3>
            </div>

            <!-- <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4"><a href="#buat_qr" data-toggle="collapse" class="btn btn-primary m-1 w-100"><i class="fas fa-qrcode" aria-hidden="true"></i> Buat QR Code</a></div>
                        <div class="col-md-4"><a href="#tarik_tunai" data-toggle="collapse" class="btn btn-primary m-1 w-100"><i class="fas fa-qrcode" aria-hidden="true"></i> Tarik Tunai</a></div>
                        <div class="col-md-4"><a href="scan.php" class="btn btn-primary m-1 w-100"><i class="fas fa-qrcode" aria-hidden="true"></i> Edit Toko</a></div>
                    </div>
                </div>
            </div> -->

            <div class="collapse card p-4 mt-3" id="edit_toko">
                <h3>Edit Toko</h3>

                <form action="../actions/toko_baru.php" method="post">

                    <div class="form-group">
                        <label for="nama_toko">Nama Toko</label>
                        <input type="text" class="form-control" name="nama" id="nama_toko" value="<?= $toko->nama ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10" required><?= $toko->deskripsi ?></textarea>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Tarik">
                </form>
            </div>

            <div class="card my-3" id="card-wrapper">
                <div class="card-body">
                    <h3 class="card-title">QR Code</h3>

                    <?php 
                    $qr = $db->getQRCodeToko($toko->id, PDO::FETCH_OBJ);

                    if ($qr) {
                        ?>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Judul</th>
                                <th>Unique ID</th>
                                <th>Tetap</th>
                                <th>Nilai</th>
                            </tr>

                            <?php
                            foreach ($qr as $q) {
                                ?>

                            <tr>
                                <td><?= $q->judul ?></td>
                                <td><?= $q->unique_id ?></td>
                                <td><?= $q->tetap ? "ya" : "tidak" ?></td>
                                <td><?= $q->nilai ?></td>
                            </tr>

                            <?php

                        }
                        ?>
                        </table>
                    </div>

                    <?php

                } else {
                    echo "<p class='card-text'>Belum ada QR Code di toko ini</p>";
                }
                ?>

                </div>
            </div>

            <div class="card my-3" id="card-wrapper">
                <div class="card-body">
                    <h3 class="card-title">Transaksi</h3>

                    <?php 
                    $transaksi = $db->getTransaksiToko($toko->id, PDO::FETCH_OBJ);

                    if ($transaksi) {
                        ?>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>ID Transaksi</th>
                                <th>ID QR Code</th>
                                <th>ID Pembeli</th>
                                <th>Waktu Transaksi</th>
                                <th>Jumlah Transaksi</th>
                            </tr>

                            <?php
                            foreach ($transaksi as $d) {
                                ?>

                            <tr>
                                <td><?= $d->id ?></td>
                                <td><?= $d->qr_id ?></td>
                                <td><a href="info_siswa.php?id_siswa=<?= $d->user_id ?>"><?= $d->user_id ?></a></td>
                                <td><?= $d->tanggal ?></td>
                                <td><?= rupiah($d->jumlah) ?></td>
                            </tr>

                            <?php

                        }
                        ?>
                        </table>
                    </div>

                    <?php

                } else {
                    echo "<p class='card-text'>Belum ada transaksi di toko ini</p>";
                }
                ?>

                </div>
            </div>
        </div>

        <div class="col-md-7">

            <div class="card p-4 mt-3" id="buat_qr">
                <form action="../actions/qr_baru.php" method="post">
                    <h3>Buat QR Code</h3>

                    <div class="form-group">
                        <label for="judul_qr">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul_qr" required>
                    </div>

                    <div class="form-group">
                        <label for="nilai">Nilai</label>
                        <input type="number" class="form-control" name="nilai" id="nilai" value="0" required>
                        <small class="form-text text-muted">Harga yang harus dibayarkan oleh pembeli.</small>
                    </div>

                    <div class="form-check ml-4 mb-3">
                        <input type="checkbox" class="form-check-input" name="tetap" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Tidak dapat diubah</label>
                        <small class="form-text text-muted">Harga tidak dapat diubah oleh pembeli.</small>
                    </div>

                    <input type="hidden" name="adminid" value="<?= $data["id"] ?>">
                    <input type="hidden" name="tokoid" value="<?= $toko->id ?>">
                    <input type="hidden" name="namatoko" value="<?= $toko->nama ?>">

                    <input type="submit" class="btn btn-primary" value="Buat">
                </form>
            </div>

            <div class="card p-4 my-3" id="tarik_tunai">
                <h3>Tarik Tunai</h3>

                <form action="../actions/toko_baru.php" method="post">
                    <div class="form-group">
                        <label for="jumlah_penarikan">Jumlah Penarikan</label>
                        <input type="number" class="form-control" name="saldo" id="jumlah_penarikan" value="0" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password Admin</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Tarik">
                </form>
            </div>
        </div>
    </div>


    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 