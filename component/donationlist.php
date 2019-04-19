<?php
$isadmin = isset($_SESSION['adminid']);
$res = $db->getAllDonations($data["id_sekolah"], PDO::FETCH_OBJ);

if ($res) {
    echo '<div class="row">';

    foreach ($res as $r) {

        $percentage = number_format(($r->terkumpul / $r->target_donasi) * 100, 2, '.', '');

        ?>

        <div class='col-lg-6 col-md-12 mt-3 mb-3'>
            <div class='card'>
                <?php if ($r->status == "close") { ?>
                    <div class='card-overlay'>
                        <div>
                            <h3 class="text-white">Donasi Sudah Ditutup</h3>

                            <?php if ($isadmin) { ?>
                                <a href='infodonasi.php?id_donasi=<?= $r->id ?>' class='btn btn-primary m-1'>Detail</a>

                                <form action="../actions/status_donasi.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $r->id ?>">
                                    <input type="hidden" name="adminid" value=<?= $data["id"] ?>>
                                    <input type="hidden" name="status" value="open">

                                    <input type="submit" class="btn btn-primary m-1" value="Buka Kembali Donasi">
                                </form>

                                <form action="../actions/hapus_donasi.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $r->id ?>">
                                    <input type="hidden" name="adminid" value=<?= $data["id"] ?>>

                                    <input type="submit" class="btn btn-danger m-1" value="Hapus Donasi">
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class='card-body'>
                    <h3 class='card-title'><?= $r->judul ?></h3>
                    <p class='card-text'><?= substr($r->deskripsi, 0, 150) ?>...</p>

                    <div class="table-responsive mb-1">
                        <table class='table'>
                            <tr>
                                <th>Terkumpul</th>
                                <th class="text-right">Target</th>
                            </tr>
                            <tr>
                                <td><?= rupiah($r->terkumpul) ?></td>
                                <td class="text-right"><?= rupiah($r->target_donasi) ?></td>
                            </tr>
                        </table>

                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;"><?= $percentage ?>%</div>
                        </div>
                    </div>

                    <?php if ($r->status == "open") { ?>

                        <a href='<?= $isadmin ? "infodonasi" : "bayardonasi" ?>.php?id_donasi=<?= $r->id ?>' class='btn btn-primary m-1'>Pelajari Lebih Lanjut!</a>

                        <?php if ($isadmin) { ?>
                            <form action="../actions/status_donasi.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $r->id ?>">
                                <input type="hidden" name="adminid" value=<?= $data["id"] ?>>
                                <input type="hidden" name="status" value="close">

                                <input type="submit" class="btn btn-warning m-1" value="Tutup Donasi">
                            </form>

                            <form action="../actions/hapus_donasi.php" method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $r->id ?>">
                                <input type="hidden" name="adminid" value=<?= $data["id"] ?>>

                                <input type="submit" class="btn btn-danger m-1" value="Hapus Donasi">
                            </form>
                        <?php }
                }

                echo "</div></div></div></div>";
            }
        } else {
            echo "Tidak ada donasi yang di buka";
        }
        ?>