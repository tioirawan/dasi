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
    $donationid = $_GET['id_donasi'];

    $res = $db->getDonation($donationid, PDO::FETCH_OBJ);

    if (!$res) {
        echo "<h1>Tidak dapat menemukan donasi 404</h1>";
    }

    $mindonation = $data["saldo"] >= 1000 ? 1000 : $data["saldo"];
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
                <div class="card-body mt-4 mb-4">
                    <!-- <h1 class="display-4">Terkumpul <?= rupiah($res->terkumpul) ?></h1> -->

                    <h3 class="card-title">Saat ini, sudah terkumpul <?= rupiah($res->terkumpul) ?> dari target <?= rupiah($res->target_donasi) ?></h3>
                    <p class="lead">Ayo, bantu berdonasi! sedekah tidaklah mengurangi harta <i class="fas fa-smile-wink"></i></p>
                </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Form Donasi</h3>

                    <form action="../actions/pay_donation.php" method="post" class="mt-3" id="donation-form">
                        <div class="form-group">
                            <label for="jumlah_donasi">Donasikan sedikut uangmu (<?= rupiah($mindonation) ?> - <?= rupiah($data["saldo"]) ?>)<br>
                                <span class="font-weight-bold" id="jmess"></span></label>
                            <input type="number" class="form-control" name="jumlah_donasi" id="jumlah_donasi" value="<?= $mindonation ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="private">Privasi</label>
                            <select class="form-control" name="private" id="private">
                                <option value="0">Tampilkan Data Diri Pada List Donatur</option>
                                <option vakue="1">Sembunyikan Data Diri Pada List Donatur</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>

                        <input type="hidden" name="donationid" value="<?= $donationid ?>">
                        <input type="hidden" name="donationname" value="<?= ucwords($res->judul) ?>">
                        <input type="hidden" name="userid" value="<?= $data["id"] ?>">

                        <input type="submit" class="btn btn-primary" value="Donasikan!">
                    </form>

                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h3 class="card-title">Donatur</h3>

                    <?php 
                    $donatur = $db->getDonatur($_GET['id_donasi'], PDO::FETCH_OBJ);

                    if ($donatur) {
                        ?>

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

                    <?php

                } else {
                    echo "<p class='card-text'>Tidak ada donatur untuk saat ini, jadilah yang pertama!</p>";
                }
                ?>

                </div>
            </div>
        </div>


    </div>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
        $('#donation-form').submit(function() {
            const jumlahdonasi = $("#jumlah_donasi");
            const jd = Number(jumlahdonasi.val())

            if (jd < <?= $mindonation ?> || jd > <?= $data["saldo"] ?>) {
                $("#jmess").text(`Jumlah donasi terlalu ${jd < <?= $mindonation ?> ? "kecil" : "besar"}`);
                jumlahdonasi.focus();
                return false;
            }

            return true;
        });
    </script>
</body>

</html> 