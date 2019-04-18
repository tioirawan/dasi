<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>History</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Riwayat Transaksi</h1>

            <?php 
            $trx = $db->getUserTransactionHistory($data["id"], PDO::FETCH_OBJ);

            // print_r($trx);

            if ($trx) {
                ?>

            <div class="table-responsive">
                <table id="paymentHistoryTable" class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Debit</th>
                            <th>Kredit</th>
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
                            <td><?= $val->tanggal ?></td>
                            <td class="text-<?=$val->jenis == "masuk" ? "success" : "danger" ?>"><?= ucwords($val->jenis) ?></td>
                            <td class="text-muted" data-sort="<?=$val->debit?>"><?= rupiah($val->debit) ?></td>
                            <td class="text-<?=$val->jenis == "masuk" ? "success" : "danger" ?>" data-sort="<?=$val->kredit?>"><?= rupiah($val->kredit) ?></td>
                            <td><?= $val->tipe ?></td>
                            <td><?= $val->metode ?></td>
                            <td><?= ucwords($val->deskripsi) ?></td>
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
    <?php require "../component/scrollTop.php" ?>

    <script>
        $(document).ready(function() {
            $('#paymentHistoryTable').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ riwayat per halaman",
                    "zeroRecords": "Maaf, tidak dapat menemukan apapun",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada riwayat yang dapat ditampilkan",
                    "infoFiltered": "(tersaring dari _MAX_ total riwayat)",
                    "search": "Cari:",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Berikutnya",
                        "previous":   "Sebelumnya"
                    },
                }
            });
        });
    </script>
</body>

</html> 