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
                            <h5 class="card-title"><i class="fas fa-qrcode" aria-hidden="true"></i> Kode QR</h5>
                            <p class="card-text">Bayar di kantin atau transfer saldo dengan Kode QR yang tersedia</p>
                            <a href="scan.php" class="btn btn-primary">Buka Pemindai</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-hand-holding-usd"></i> Donasi</h5>
                            <p class="card-text">Donasikan sedikit uang sakumu untuk yang membutuhkan</p>
                            <a href="donasi.php" class="btn btn-primary">Donasi!</a>
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

    <br />

    <div class="card">
        <div class="card-body pt-0">
            <div class="pointer pt-3" data-toggle="collapse" data-target="#list-tagihan">
                <h5 class="card-title">Tagihan</h5>
                <small class="text-muted" id="tagihan-help">*Klik untuk menampilkan tagihan</small>
            </div>

            <?php
                $semuaTagihan = $db->getUserSPPBill($data["id"], PDO::FETCH_OBJ);
            ?>

            <div class="row collapse" id="list-tagihan">
                <?php 
                if(!$semuaTagihan) {
                    echo '<p class="card-text mx-3">Yay! kamu tidak memiliki tagihan sama sekali</p>';
                } else {
                    $tagihan = array_filter($semuaTagihan, function($t) {
                        return !$t->status_pembayaran && $t->bulan <= bulanToNum(getBulan());
                    });
                    foreach($tagihan as $t) { 
                        if(bulanSekolahToNum($t->bulan) > bulanSekolahToNum(getBulan())) continue;
                ?>

                <div class="col-sm-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">SPP Bulan <?=ucwords($t->bulan)?></h5>
                            <p class="card-text">
                                Kamu belum malakukan pembayaran SPP bulan <?=ucwords($t->bulan)?>    
                            </p>

                            <div class="right-left">
                                <div>
                                    <h5 class="card-text pt-2 font-weight-bold float-sm-left mb-0">
                                        <?=boldGreen(rupiah($sekolah->biaya_spp))?>
                                    </h5>
                                </div>

                                <div>
                                    <a href="spp.php?focus=<?=$t->bulan?>" class="btn btn-primary">Bayar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } } ?>
            </div>

        </div>
    </div>

    <br />

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Riwayat Transaksi</h5>

            <?php include "../component/siswa/riwayat.php" ?>

        </div>
    </div>

    <!-- Content End -->

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
         $(document).ready(function() {
            $('#paymentHistoryTable').DataTable({
                "order": [
                    [1, "desc"]
                ]
            });

            
            $('#list-tagihan').on('show.bs.collapse', function(e) {
                $('#tagihan-help').hide();
            });

            $('#list-tagihan').on('hide.bs.collapse', function(e) {
                setTimeout(() => $('#tagihan-help').fadeIn('slow'), 100);
            });
        });
    </script>
</body>

</html> 