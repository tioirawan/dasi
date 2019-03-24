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
            <h1 class="card-title">Riwayat Transaksi</h1>

            <?php 
            $trx = $db->getUserTransactionHistory($data["id"], PDO::FETCH_OBJ);

            if ($trx) {
                ?>

            <div class="table-responsive">
                <table id="paymentHistoryTable" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Tipe</th>
                            <th>Metode</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
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

                    </tbody>
                </table>
            </div>

            <?php

        } else {
            echo "<p class='card-text'>Kamu belum melakukan transaksi apapun</p>";
        }
        ?>
        </div>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
        $(document).ready(function() {
            $('#paymentHistoryTable').DataTable({
                "order": [
                    [1, "desc"]
                ]
            });
        });
    </script>
</body>

</html> 