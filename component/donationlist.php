<div class="row">
    <?php
    $isadmin = isset($_SESSION['adminid']);
    $res = $db->getAllDonations(PDO::FETCH_OBJ);

    if ($res) {
        foreach ($res as $r) {
            ?>

    <div class='col-sm-4 mt-3 mb-3'>
        <div class='card'>
            <div class='card-body'>
                <h3 class='card-title'><?= $r->judul ?></h3>
                <p class='card-text'><?= substr($r->deskripsi, 0, 150) ?>...</p>

                <div class="table-responsive mb-1">
                    <table class='table'>
                        <tr>
                            <th>Terkumpul</th>
                            <th>Target</th>
                            <th>Persentase</th>
                        </tr>
                        <tr>
                            <td><?= rupiah($r->terkumpul) ?></td>
                            <td><?= rupiah($r->target_donasi) ?></td>
                            <td><?= number_format(($r->terkumpul / $r->target_donasi) * 100, 2, '.', '') ?>%</td>
                        </tr>
                    </table>
                </div>

                <a href='<?= $isadmin ? "infodonasi" : "bayardonasi" ?>.php?id_donasi=<?= $r->id ?>' class='btn btn-primary m-1'>Pelajari Lebih Lanjut!</a>

                <?php

                if ($isadmin) {
                    echo "<a href='../action/tutup_donasi.php?id_donasi=$r->id' class='btn btn-warning m-1'>Tutup Donasi</a>";
                    echo "<a href='../action/hapus_donasi.php?id_donasi=$r->id' class='btn btn-danger m-1'>Hapus Donasi</a>";
                }

                echo "</div></div></div>";
            }
        } else {
            echo "Tidak Donasi Yang di Buka";
        }
        ?>
            </div> 