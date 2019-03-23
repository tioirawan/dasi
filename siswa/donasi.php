<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Donasi</h5>
            <div class="row">

                <?php
                $res = $db->getAllDonations(PDO::FETCH_OBJ);

                if ($res) {
                    foreach ($res as $r) {
                        echo "<div class='col-sm-4 mt-2'><div class='card'><div class='card-body'>";

                        echo "<h5 class='card-title'>$r->judul</h5>";
                        echo "<p class='card-text'>$r->deskripsi</p>";
                        echo "<a href='spp.php' class='btn btn-primary'>Donasi</a>";

                        echo "</div></div></div>";
                    }
                } else {
                    echo "Tidak Donasi Yang di Buka";
                }
                ?>

            </div>
        </div>
    </div>


    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</h tml> 