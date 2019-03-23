<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <h1>Donasi</h1>

    <div class="row">

        <?php
        $res = $db->getAllDonations(PDO::FETCH_OBJ);

        if ($res) {
            foreach ($res as $r) {
                ?>

        <div class='col-sm-4 mt-2'>
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

                    <?php
                    echo "<a href='bayardonasi.php?id_donasi=$r->id' class='btn btn-primary'>Pelajari Lebih Lanjut!</a>";

                    echo "</div></div></div>";
                }
            } else {
                echo "Tidak Donasi Yang di Buka";
            }
            ?>

                </div>

                <?php include "../component/siswa/sidebarclose.php" ?>
                <?php include "../component/scripts.php" ?>
</body>

</h tml> 