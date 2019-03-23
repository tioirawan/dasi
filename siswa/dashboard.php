<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>

    <?php include "../component/siswa/sidebaropen.php" ?>

    <?php
    $saldo = (int)$data["saldo"];
    ?>

    <!-- Content  -->
    <!-- <div class="jumbotron text-center bg-<?= $saldo >= 100000 ? 'success' : ($saldo >= 50000 ? 'warning' : 'danger') ?> text-white">
        <h3>Saldo Total</h3>
        <p class="display-4"><?= $saldo ?></p>
    </div> -->

    <div class="card">
        <div class="card-header">
            Hi, <?= explode(' ', $data["nama"])[0] ?>
        </div>
        <div class="card-body">
            <h5 class="card-title">Jumlah Saldomu</h5>
            <p class="card-text" id="saldo"><?= rupiah($saldo) ?></p>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Bayar</h5>
            <div class="row">
                <div class="col-sm-4 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-qrcode" aria-hidden="true"></i> QR Code</h5>
                            <p class="card-text">Bayar barang atau makanan di kantin dengan QR Code yang tersedia</p>
                            <a href="scan.php" class="btn btn-primary">Buka Pemindai</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-hand-holding-usd"></i> Donasi</h5>
                            <p class="card-text">Donasikan sedikit uang sakumu untuk yang membutuhkan</p>
                            <a href="donasi.php" class="btn btn-primary">Sumbang!</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-file-invoice"></i> SPP</h5>
                            <p class="card-text">Bayar SPP dengan cepat dan mudah tanpa antri dengan saldomu</p>
                            <a href="spp.php" class="btn btn-primary">Bayar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br/>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tagihan</h5>
            <p class="card-text">Yay! kamu tidak memiliki tagihan sama sekali</p>
        </div>
    </div>

    <br />

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Riwayat Transaksi</h5>

            <?php 
                    $trx = $db->getUserTransactionHistory($data["id"], PDO::FETCH_OBJ);

                    if ($trx) {
                        ?>

                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Tipe</th>
                            <th>Metode</th>
                            <th>Deskripsi</th>
                        </tr>

                        <?php
                        foreach ($trx as $val) {
                            ?>

                        <tr>
                            <td><?= $val->id ?></td>
                            <td><?= $val->tanggal ?></td>
                            <td><?= rupiah($val->jumlah) ?></td>
                            <td><?= $val->tipe ?></td>
                            <td><?= $val->metode ?></td>
                            <td><?= $val->deskripsi ?></td>
                        </tr>

                        <?php

                    }
                    ?>
                    </table>

                    <?php

                } else {
                    echo "<p class='card-text'>Kamu belum melakukan transaksi apapun</p>";
                }
                ?>
        </div>
    </div>

    <!-- Content End -->

    <?php include "../component/siswa/sidebarclose.php" ?>


    <?php include "../component/scripts.php" ?>
</body>

</html> 