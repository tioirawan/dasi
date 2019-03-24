<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <?php include "../process/getAdminLoginData.php" ?>

    <?php
    $donationid = $_GET['id_donasi'];

    $res = $db->getDonation($donationid, PDO::FETCH_OBJ);
    ?>

    <style>
        .table-scroll-v {
            position: relative;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .right-left div:nth-child(1) {
            float: left;
            margin-left: 0;
        }
    </style>

    <title><?= ucwords($res->judul) ?></title>
</head>

<body>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php
    if (!$res) {
        echo "<h1>Tidak dapat menemukan donasi 404</h1>
        <a href='donasi.php' role='button' class='btn btn-primary btn-lg mt-3'>Kembali ke halaman list donasi</a>";
    } else { // else open

        $percentage = number_format(($res->terkumpul / $res->target_donasi) * 100, 2, '.', '')
        ?>

    <div class="row">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?= ucwords($res->judul) ?></h1>
                    <p class="card-text"><?= $res->deskripsi ?></p>
                </div>
            </div>

            <div class="card mt-3 mb-3">
                <div class="card-body mt-2">
                    <h3 class="card-title">Terkumpul <?= rupiah($res->terkumpul) ?> dari target <?= rupiah($res->target_donasi) ?></h3>

                    <div class="progress mb-3" style="height: 25px;">
                        <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%;"><?= $percentage ?>%</div>
                    </div>

                    <a href="donasi.php" role="button" class="btn btn-primary">Kembali ke List Donasi</a>
                </div>
            </div>

        </div>

        <div class="col-sm-5 mb-3">
            <div class="card h-100" id="card-wrapper">
                <div class="card-body">
                    <h3 class="card-title">Donatur</h3>

                    <?php 
                    $donatur = $db->getDonatur($_GET['id_donasi'], PDO::FETCH_OBJ);

                    if ($donatur) {
                        ?>

                    <div class="table-wrapper-scroll-y table-scroll-v">
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jumlah Donasi</th>
                            </tr>

                            <?php
                            foreach ($donatur as $d) {
                                ?>

                            <tr>
                                <td><?= $d->private ? "-" : $d->nama ?></td>
                                <td><?= $d->private ? "-" : "$d->tingkatan $d->jurusan $d->kelas" ?></td>
                                <td><?= rupiah($d->jumlah) ?></td>
                            </tr>

                            <?php

                        }
                        ?>
                        </table>
                    </div>

                    <?php

                } else {
                    echo "<p class='card-text'>Belum ada donatur untuk saat ini, jadilah yang pertama!</p>";
                }
                ?>

                </div>
            </div>
        </div>

        <!-- Else CLose -->
        <?php 
    } ?>
    </div>
    </div>

    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <?php if ($res) { ?>
    <script>
        $(".table-scroll-v").height($("#card-wrapper").height() - <?= $isadmin ? 0 : 200 ?> + "px");
    </script>
    <?php 
} ?>
</body>

</html> 