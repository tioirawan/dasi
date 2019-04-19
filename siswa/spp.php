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
                $tenggang = bulanSekolahToNum($spp->bulan) < bulanSekolahToNum(getBulan());
            ?>
                <div class="col-sm-4 my-3">
                    <div class="card" id="<?=$spp->bulan?>">
                        <div class="card-body <?=$spp->bulan == getBulan()? "pb-0" :"pb-4"?>">
                            <h3 class="card-title">
                                <?=ucwords($spp->bulan)?>
                            </h3>

                            <?php if($spp->status_pembayaran) { ?>
                                <p>Yeay! SPP bulan ini sudah kamu bayar pada tanggal</p>
                                <p><?=indonesian_date($spp->tanggal_pembayaran), date('H:i:s', strtotime($spp->tanggal_pembayaran))?></p>
                            <?php } else { ?>
                                <p>Kamu belum membayar SPP bulan ini, yuk segera bayar</p>

                                <div class="right-left">
                                <div>
                                    <h5 class="card-text pt-2 font-weight-bold float-sm-left mb-0">
                                        <?=boldGreen(rupiah($sekolah->biaya_spp))?>
                                    </h5>
                                </div>

                                <div>
                                    <button 
                                        class="btn btn-primary mb-2 <?=bulanSekolahToNum($spp->bulan) < bulanSekolahToNum(getBulan()) ? ($spp->status_pembayaran ? "btn-success" : "btn-danger")." text-white": "btn-primary" ?>" 
                                        type="button" 
                                        id="btn-<?=$spp->bulan?>"
                                        data-toggle="modal" 
                                        data-target="#confirmmodal"
                                        data-idspp="<?=$spp->id?>"
                                        data-bulanspp="<?=$spp->bulan?>"
                                    >
                                        Bayar
                                    </button>
                                </div>
                            </div>

                            <?php } ?>

                            
                        </div>
                        <?php if($spp->bulan == getBulan()) { ?>
                            <div class="card-footer bg-primary"></div>        
                        <?php } ?>
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
    <?php require "../component/scrollTop.php" ?>

    <script>
         $(document).ready(function () {
            $('#confirmmodal').on('shown.bs.modal', function(e) {
                $('#idspp').val($(e.relatedTarget).data("idspp"));
                $('#bulanspp').val($(e.relatedTarget).data("bulanspp"));
            });

            <?php if(isset($_GET["focus"])) { ?>
                setTimeout(() => {
                    $('html, body').animate(
                        {
                            scrollTop: $('#<?=$_GET["focus"]?>').offset().top - 200
                        },
                        1000
                    );

                    $("#btn-<?=$_GET["focus"]?>").focus();
                }, 400)
            <?php } ?>
        });
    </script>
</body>

</html> 
