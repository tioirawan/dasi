<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>SPP</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <div class="modal fade" id="confirmmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <form class="m-2" method="post" action="../actions/pay_spp.php">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <input type="hidden" name="idsiswa" value="<?=$data["id"]?>">
                    <input type="hidden" name="idsekolah" value="<?=$data["id_sekolah"]?>">
                    <input type="hidden" name="idspp" id="idspp" value="">
                    <input type="hidden" name="bulanspp" id="bulanspp" value="">

                    <input type="submit" class="btn btn-primary" value="Konfirmasi">
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
            </div>
            </div>
        </div>
    </div>

    <?php
        $res = $db->getUserSPP($data["id"], PDO::FETCH_OBJ);
        $chunk = array_chunk($res, ceil(count($res) / 2));

        $tagihanSPP = array_merge($chunk[1], $chunk[0]);

        $jumlahLunas = 0;
        $bulanIniLunas = false;

        foreach($tagihanSPP as $spp) {
            if($spp->status_pembayaran) $jumlahLunas++;
            if($spp->bulan == getBulan() && $spp->status_pembayaran) $bulanIniLunas = true;
        }

        $lunas = $jumlahLunas >= 12;
    ?>

    <div class="card <?=$lunas || $bulanIniLunas? "bg-success" : "bg-danger"?>">
        <div class="card-body  text-center ">
            <span class="text-white lead">
                <?php
                if ($lunas) {
                    echo 'Selamat, SPP anda sudah lunas!';
                } else if($bulanIniLunas) {
                    echo 'SPP kamu bulan ini sudah lunas!';
                } else if(!$bulanIniLunas) {
                    echo 'Silahkan melunasi SPP bulan ini';
                } else {
                    echo 'Silahkan melunasi SPP yang belum dilunasi';
                }
                ?>
            </span>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <div class="row">

            <?php
                foreach($tagihanSPP as $spp) {
                $tenggang = bulanToNum($spp->bulan) < bulanToNum(getBulan());
            ?>
                <div class="col-sm-4 my-3">
                    <div class="card">
                        <h3 class="card-header  
                        <?=!$spp->status_pembayaran && $tenggang ? "bg-danger text-white" : ""?>
                        <?=$spp->status_pembayaran ? "bg-success text-white" : "" ?>
                        <?=$spp->bulan == getBulan() ? "bg-primary text-white": "" ?>"
                    >
                        <?=ucwords($spp->bulan)?>
                    </h3>
                        <div class="card-body">
                            <?php if($spp->status_pembayaran) { ?>
                                <p>SPP bulan ini sudah dibayar pada tanggal</p>
                                <p><?=indonesian_date($spp->tanggal_pembayaran), date('H:i:s', strtotime($spp->tanggal_pembayaran))?></p>
                            <?php } else { ?>
                                <p>Belum dibayar</p>
                                
                                <button 
                                    class="btn btn-primary <?=bulanToNum($spp->bulan) < bulanToNum(getBulan()) ? ($spp->status_pembayaran ? "btn-success" : "btn-danger")." text-white": "btn-primary" ?>" 
                                    type="button" 
                                    data-toggle="modal" 
                                    data-target="#confirmmodal"
                                    data-idspp="<?=$spp->id?>"
                                    data-bulanspp="<?=$spp->bulan?>"
                                >
                                    Bayar
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>

            </div>
        </div>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
         $(document).ready(function () {
            $('#confirmmodal').on('shown.bs.modal', function(e) {
                $('#idspp').val($(e.relatedTarget).data("idspp"));
                $('#bulanspp').val($(e.relatedTarget).data("bulanspp"));
            }) ;
        });
    </script>
</body>

</html> 
